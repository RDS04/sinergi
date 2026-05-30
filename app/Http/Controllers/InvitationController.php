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
        $validated = $request->validate([
            'nama_mhs' => 'required|string|max:255|unique:invitation,nama_mhs',
            'prodi' => 'required|string|max:255',
            'wa_mhs' => 'required|string|max:20',
            'nama_ortu' => 'required|string|max:255',
            'alamat_ortu' => 'required|string',
            'wa_ortu' => 'required|string|max:20',
        ]);

        $invitation = Invitation::create($validated);

        return redirect()->route('invitation.show', $invitation->id)
            ->with('success', 'Data berhasil ditambahkan');
    }

    /**
     * Tampilkan QR code dan data undangan
     */
    public function show(Invitation $invitation)
    {
        // Generate QR code untuk WhatsApp orang tua - HANYA BERISI NOMOR WA ORTU
        // Ini menjadi identifier unik untuk absen
        $qrCodeUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=' . urlencode($invitation->wa_ortu);

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
     * Cari invitation berdasarkan nomor WhatsApp orang tua
     */
    public function findByWaOrtu(Request $request)
    {
        $waOrtu = $request->input('wa_ortu');

        if (!$waOrtu) {
            return response()->json([
                'success' => false,
                'message' => 'Nomor WhatsApp tidak ditemukan'
            ], 400);
        }

        $invitation = Invitation::where('wa_ortu', $waOrtu)->first();

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
     * Catat kehadiran berdasarkan nomor WhatsApp orang tua
     */
    public function recordPresence(Request $request)
    {
        $request->validate([
            'wa_ortu' => 'required|string'
        ]);

        \Log::info('Record presence request:', ['wa_ortu' => $request->wa_ortu]);

        $invitation = Invitation::where('wa_ortu', $request->wa_ortu)->first();

        if (!$invitation) {
            \Log::warning('Invitation not found for wa_ortu:', ['wa_ortu' => $request->wa_ortu]);
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
                ->whereDate('present_at', now()->toDateString())
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
                'prodi' => $invitation->prodi,
                'wa_mhs' => $invitation->wa_mhs,
                'nama_ortu' => $invitation->nama_ortu,
                'alamat_ortu' => $invitation->alamat_ortu,
                'wa_ortu' => $invitation->wa_ortu,
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
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}
