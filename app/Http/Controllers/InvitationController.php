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
     * Simpan data undangan dengan logika bertahap
     */
    public function store(Request $request)
    {
        try {
            $stage = $request->input('stage', 1); // default stage 1

            // STAGE 1: Validasi nama, status, wa_mhs
            if ($stage == 1) {
                $validated = $request->validate([
                    'nama_mhs' => 'required|string|max:255',
                    'wa_mhs' => 'required|string|unique:invitation,wa_mhs|regex:/^\+62\d{10,12}$/',
                    'status' => 'required|in:mahasiswa,alumni,ortu',
                ], [
                    'wa_mhs.unique' => 'Nomor WhatsApp ini sudah terdaftar sebelumnya.',
                    'wa_mhs.regex' => 'Format WhatsApp harus +62 diikuti 10-12 digit (contoh: +62812345678901).',
                    'status.in' => 'Status tidak valid. Pilih: mahasiswa, alumni, atau ortu.'
                ]);

                // PENTING: Simpan ke database untuk semua status (termasuk mahasiswa)
                // Untuk mahasiswa: akan di-update di Stage 2 dengan nama_ortu_1 dan nama_ortu_2
                $validated['attendance_status'] = 'belum_hadir';
                $invitation = Invitation::create($validated);

                // Jika status mahasiswa, return pesan untuk lanjut ke tahap 2 (input orang tua)
                if ($validated['status'] == 'mahasiswa') {
                    return response()->json([
                        'success' => true,
                        'stage' => 1,
                        'nextStage' => true,
                        'message' => 'Silakan isi data orang tua',
                        'invitation_id' => $invitation->id,
                        'nama_mhs' => $invitation->nama_mhs,
                        'wa_mhs' => $invitation->wa_mhs,
                        'status' => $invitation->status,
                    ], 200);
                }
                
                // Jika status alumni atau ortu, langsung generate barcode
                // (record sudah dibuat di atas)

                // Generate QR code URL
                $qrCodeUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=' . urlencode($invitation->wa_mhs);

                return response()->json([
                    'success' => true,
                    'stage' => 1,
                    'nextStage' => false,
                    'message' => 'Data berhasil disimpan!',
                    'qr_code_url' => $qrCodeUrl,
                    'invitation_id' => $invitation->id,
                    'nama_mhs' => $invitation->nama_mhs,
                    'wa_mhs' => $invitation->wa_mhs,
                    'status' => $invitation->status,
                    'data' => $invitation
                ], 200);
            }

            // STAGE 2: Validasi & simpan nama orang tua
            if ($stage == 2) {
                $validated = $request->validate([
                    'nama_mhs' => 'required|string|max:255',
                    'wa_mhs' => 'required|string|exists:invitation,wa_mhs',
                    'status' => 'required|in:mahasiswa,alumni,ortu',
                    'nama_ortu_1' => 'nullable|string|max:255',
                    'nama_ortu_2' => 'nullable|string|max:255',
                    'alasan_ortu_tidak_ikut' => 'nullable|required_without_all:nama_ortu_1,nama_ortu_2|string|max:500',
                ], [
                    'wa_mhs.exists' => 'Data mahasiswa tidak ditemukan. Silakan daftar di tahap 1 terlebih dahulu.',
                    'status.in' => 'Status tidak valid.',
                    'alasan_ortu_tidak_ikut.required_without_all' => 'Alasan orang tua/wali tidak ikut harus diisi jika kedua data orang tua/wali kosong.'
                ]);

                \Log::info('Stage 2 Validation Passed:', $validated);

                $namaOrtu1 = trim($validated['nama_ortu_1'] ?? '');
                $namaOrtu2 = trim($validated['nama_ortu_2'] ?? '');
                $alasanOrtuTidakIkut = trim($validated['alasan_ortu_tidak_ikut'] ?? '');
                $tidakAdaOrtuIkut = $namaOrtu1 === '' && $namaOrtu2 === '';

                // Cari dan update invitation berdasarkan wa_mhs
                $invitation = Invitation::where('wa_mhs', $validated['wa_mhs'])->first();

                if (!$invitation) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Data mahasiswa tidak ditemukan'
                    ], 404);
                }

                // Update dengan data orang tua
                $invitation->update([
                    'nama_ortu_1' => $namaOrtu1 ?: null,
                    'nama_ortu_2' => $namaOrtu2 ?: null,
                    'alasan_ortu_tidak_ikut' => $tidakAdaOrtuIkut ? $alasanOrtuTidakIkut : null,
                ]);

                \Log::info('Invitation updated with parent data:', [
                    'invitation_id' => $invitation->id,
                    'nama_ortu_1' => $namaOrtu1 ?: null,
                    'nama_ortu_2' => $namaOrtu2 ?: null,
                    'alasan_ortu_tidak_ikut' => $tidakAdaOrtuIkut ? $alasanOrtuTidakIkut : null,
                ]);

                // Generate QR code URL
                $qrCodeUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=' . urlencode($invitation->wa_mhs);

                return response()->json([
                    'success' => true,
                    'stage' => 2,
                    'message' => 'Data orang tua berhasil disimpan!',
                    'qr_code_url' => $qrCodeUrl,
                    'invitation_id' => $invitation->id,
                    'nama_mhs' => $invitation->nama_mhs,
                    'wa_mhs' => $invitation->wa_mhs,
                    'status' => $invitation->status,
                    'nama_ortu_1' => $invitation->nama_ortu_1,
                    'nama_ortu_2' => $invitation->nama_ortu_2,
                    'alasan_ortu_tidak_ikut' => $invitation->alasan_ortu_tidak_ikut,
                ], 200);
            }

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal Mendaftar ',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            \Log::error('Error storing invitation:', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
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
    public function kartu(Request $request)
    {
        $qrUrl = $request->query('qr');
        $namaUser = $request->query('nama', '');
        
        return view('invitations.kartu', [
            'qrUrl' => $qrUrl,
            'namaUser' => $namaUser
        ]);
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
    public function findByWaMhs(Request $request)
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

    public function findByWaOrtu(Request $request)
    {
        return $this->findByWaMhs($request);
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
                'wa_mhs' => $invitation->wa_mhs,
                'nama_ortu_1' => $invitation->nama_ortu_1,
                'nama_ortu_2' => $invitation->nama_ortu_2,
            ]);

            // Update status kehadiran menjadi "hadir" di tabel invitation
            $invitation->update([
                'attendance_status' => 'hadir'
            ]);

            \Log::info('Presence created successfully:', ['presence_id' => $presence->id]);
            \DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Kehadiran berhasil dicatat!',
                'data' => $presence,
                'status' => 'Hadir',
                'attendance_status' => 'hadir'
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
        return view('invitation');
    }

    /**
     * Tampilkan halaman daftar hadir (mengambil data dari DB)
     */
    public function daftarHadir()
    {
        $invitations = Invitation::select('id', 'nama_mhs as nama', 'wa_mhs as email', 'wa_mhs as kontak', 'status', 'attendance_status', 'nama_ortu_1', 'nama_ortu_2', 'created_at')->get()
            ->map(function($item) {
                $item->statusKehadiran = $item->attendance_status === 'hadir' ? 'Hadir' : 'Belum Hadir';
                return $item;
            });
        
        // Map presence data
        $presences = Presence::with('invitation')
            ->select('id', 'invitation_id', 'nama_mhs as nama', 'wa_mhs as email', 'status', 'nama_ortu_1', 'nama_ortu_2', 'created_at')
            ->get()
            ->map(function($p){
            $p->nama_ortu_1 = $p->nama_ortu_1 ?: $p->invitation?->nama_ortu_1;
            $p->nama_ortu_2 = $p->nama_ortu_2 ?: $p->invitation?->nama_ortu_2;
            $p->checkIn = $p->created_at->format('H:i').' WIB';
            unset($p->invitation);
            return $p;
        });

        // counts
        $totalInvitations = Invitation::count();
        $totalPresences = Presence::count();

        return view('auth.dashboard.daftarHadir', compact('invitations', 'presences', 'totalInvitations', 'totalPresences'));
    }

    /**
     * Export data undangan ke Excel format CSV
     */
    public function exportExcel()
    {
        $invitations = Invitation::all();

        // Prepare headers
        $headers = [
            'Content-Type' => 'text/csv; charset=utf-8',
            'Content-Disposition' => 'attachment; filename=undangan_' . date('Y-m-d_His') . '.csv',
        ];

        // Create callback for CSV generation
        $callback = function () use ($invitations) {
            $file = fopen('php://output', 'w');
            
            // Set UTF-8 BOM untuk Excel
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            
            // Write header row
            fputcsv($file, [
                'No',
                'Nama Lengkap',
                'No. Telepon',
                'Status',
                'Tanggal Daftar'
            ], ';');

            // Write data rows
            foreach ($invitations as $index => $invitation) {
                fputcsv($file, [
                    $index + 1,
                    $invitation->nama_mhs,
                    $invitation->wa_mhs,
                    ucfirst($invitation->status),
                    $invitation->created_at->format('d-m-Y H:i:s')
                ], ';');
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Export data kehadiran ke Excel format CSV
     */
    public function exportPresenceExcel()
    {
        $presences = Presence::with('invitation')->get();

        // Prepare headers
        $headers = [
            'Content-Type' => 'text/csv; charset=utf-8',
            'Content-Disposition' => 'attachment; filename=kehadiran_' . date('Y-m-d_His') . '.csv',
        ];

        // Create callback for CSV generation
        $callback = function () use ($presences) {
            $file = fopen('php://output', 'w');
            
            // Set UTF-8 BOM untuk Excel
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            
            // Write header row
            fputcsv($file, [
                'No',
                'Nama Lengkap',
                'No. Telepon',
                'Nama Orang Tua/Wali 1',
                'Nama Orang Tua/Wali 2',
                'Status',
                'Waktu Check-in'
            ], ';');

            // Write data rows
            foreach ($presences as $index => $presence) {
                fputcsv($file, [
                    $index + 1,
                    $presence->nama_mhs,
                    $presence->wa_mhs,
                    $presence->nama_ortu_1 ?: $presence->invitation?->nama_ortu_1,
                    $presence->nama_ortu_2 ?: $presence->invitation?->nama_ortu_2,
                    ucfirst($presence->status),
                    $presence->created_at->format('d-m-Y H:i:s')
                ], ';');
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Mark attendance manually dari admin dashboard
     * Ketika admin klik "Tandai Hadir", update status di database
     */
    public function markAttendanceManual($id)
    {
        try {
            $invitation = Invitation::find($id);
            
            if (!$invitation) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data undangan tidak ditemukan'
                ], 404);
            }

            // Gunakan transaction untuk consistency
            \DB::beginTransaction();
            
            try {
                // Cek apakah sudah tercatat kehadiran hari ini
                $existingPresence = Presence::where('invitation_id', $invitation->id)
                    ->whereDate('created_at', now()->toDateString())
                    ->first();

                if (!$existingPresence) {
                    // Buat presence record
                    Presence::create([
                        'invitation_id' => $invitation->id,
                        'nama_mhs' => $invitation->nama_mhs,
                        'status' => $invitation->status,
                        'wa_mhs' => $invitation->wa_mhs,
                        'nama_ortu_1' => $invitation->nama_ortu_1,
                        'nama_ortu_2' => $invitation->nama_ortu_2,
                    ]);
                }

                // Update attendance status menjadi "hadir"
                $invitation->update([
                    'attendance_status' => 'hadir'
                ]);

                \DB::commit();

                return response()->json([
                    'success' => true,
                    'message' => 'Status kehadiran berhasil diperbarui',
                    'data' => [
                        'id' => $invitation->id,
                        'nama_mhs' => $invitation->nama_mhs,
                        'attendance_status' => $invitation->attendance_status,
                        'statusKehadiran' => 'Hadir'
                    ]
                ], 200);

            } catch (\Exception $e) {
                \DB::rollBack();
                throw $e;
            }

        } catch (\Exception $e) {
            \Log::error('Error marking attendance:', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memperbarui status: ' . $e->getMessage()
            ], 500);
        }
    }
}
