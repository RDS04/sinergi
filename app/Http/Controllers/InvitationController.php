<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use App\Models\Presence;
use Illuminate\Http\Request;

class InvitationController extends Controller
{
    /**
     * Tampilkan form undangan
     */
    public function index()
    {
        return view('invitation');
    }

    /**
     * Simpan data undangan
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'nama_mhs' => 'required|string|max:255',
                'nama_ortu' => 'required|string|max:255',
                'wa_mhs' => 'required|string',
                'status' => 'required|in:mahasiswa,alumni',
            ]);

            $invitation = Invitation::create($validated);

            // Generate QR code URL
            $qrCodeUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=' . urlencode($invitation->wa_mhs);

            // Return JSON untuk AJAX requests (dengan Accept: application/json header)
            if ($request->wantsJson() || $request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Data berhasil ditambahkan',
                    'invitation_id' => $invitation->id,
                    'qr_code_url' => $qrCodeUrl,
                    'nama_mhs' => $invitation->nama_mhs,
                    'nama_ortu' => $invitation->nama_ortu,
                    'wa_mhs' => $invitation->wa_mhs,
                    'status' => $invitation->status,
                    'data' => $invitation
                ], 200);
            }

            return redirect()->route('invitation.show', $invitation->id)
                ->with('success', 'Data berhasil ditambahkan');
        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->wantsJson() || $request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validasi gagal',
                    'errors' => $e->errors()
                ], 422);
            }
            throw $e;
        } catch (\Exception $e) {
            if ($request->wantsJson() || $request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan: ' . $e->getMessage()
                ], 500);
            }
            throw $e;
        }
    }

    /**
     * Tampilkan QR code dan data undangan
     */
    public function show(Invitation $invitation)
    {
        // Generate QR code dari WhatsApp mahasiswa - HANYA BERISI NOMOR WA MHS
        // Ini menjadi identifier unik untuk checkin di event
        $qrCodeUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=' . urlencode($invitation->wa_mhs);

        return view('invitations.show', compact('invitation', 'qrCodeUrl'));
    }

    /**
     * Tampilkan halaman scan QR
     */
    public function scanQR()
    {
        return view('scan-qr');
    }

    /**
     * Tampilkan halaman kartu undangan dengan background dan QR
     */
    public function kartu()
    {
        return view('invitations.kartu');
    }

    /**
     * Get invitation data as JSON
     */
    public function getInvitationData(Invitation $invitation)
    {
        return response()->json([
            'success' => true,
            'data' => $invitation
        ]);
    }

    /**
     * Cari invitation berdasarkan nomor WhatsApp mahasiswa
     */
    public function findByWaOrtu(Request $request)
    {
        $waMhs = $request->input('wa_mhs');

        if (!$waMhs) {
            return response()->json([
                'success' => false,
                'message' => 'Nomor WhatsApp tidak ditemukan'
            ], 400);
        }

        $invitation = Invitation::where('wa_mhs', $waMhs)->first();

        if (!$invitation) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan. Silahkan daftarkan diri terlebih dahulu.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $invitation
        ]);
    }
    
    /**
     * Catat kehadiran berdasarkan nomor WhatsApp mahasiswa
     */
    public function recordPresence(Request $request)
    {
        $request->validate([
            'wa_mhs' => 'required|string',
            'invitation_id' => 'nullable|integer'
        ]);

        \Log::info('Record presence request:', [
            'wa_mhs' => $request->wa_mhs,
            'invitation_id' => $request->invitation_id,
        ]);

        $invitation = null;
        if ($request->filled('invitation_id')) {
            $invitation = Invitation::find($request->invitation_id);
        }

        if (! $invitation) {
            $invitation = Invitation::where('wa_mhs', $request->wa_mhs)->first();
        }

        if (!$invitation) {
            \Log::warning('Invitation not found for record presence:', [
                'wa_mhs' => $request->wa_mhs,
                'invitation_id' => $request->invitation_id,
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        \Log::info('Invitation found:', ['invitation_id' => $invitation->id]);

        // Gunakan transaction dengan pessimistic locking untuk mencegah race condition
        \DB::beginTransaction();
        
        try {
            // Lock untuk read - cek apakah sudah di-presensikan hari ini
            $existingPresence = Presence::where('invitation_id', $invitation->id)
                ->whereDate('created_at', now()->toDateString())
                ->lockForUpdate()
                ->first();

            if ($existingPresence) {
                \Log::info('Presence already exists for today:', ['invitation_id' => $invitation->id]);
                \DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => 'Anda sudah tercatat kehadiran hari ini!',
                    'data' => $existingPresence
                ]);
            }

            // Simpan kehadiran
            $presence = Presence::create([
                'invitation_id' => $invitation->id,
                'nama_mhs' => $invitation->nama_mhs,
                'status' => $invitation->status,
                'nama_ortu' => $invitation->nama_ortu,
                'wa_mhs' => $invitation->wa_mhs,
            ]);

            \Log::info('Presence created successfully:', ['presence_id' => $presence->id]);
            \DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Kehadiran berhasil dicatat!',
                'data' => $presence,
                'status' => 'Hadir'
            ]);
        } catch (\Exception $e) {
            \Log::error('Error recording presence:', ['error' => $e->getMessage()]);
            \DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menyimpan kehadiran'
            ], 500);
        }
    }
    public function undangan()
    {
        return view('undangan');
    }
}
