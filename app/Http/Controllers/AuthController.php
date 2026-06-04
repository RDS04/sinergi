<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use App\Models\Presence;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    /**
     * Tampilkan halaman login
     */
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        return view('auth.login');
    }

    /**
     * Tampilkan halaman register
     */
    public function showRegister()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        return view('auth.register');
    }

    /**
     * Tampilkan halaman dashboard admin.
     */
    public function dashboard()
    {
        $totalInvitations = Invitation::count();
        $presencesCount = Presence::count();
        $mahasiswaCount = Invitation::where('status', 'mahasiswa')->count();
        $alumniCount = Invitation::where('status', 'alumni')->count();
        $ortuCount = Invitation::where('status', 'ortu')->count();
        $todayInvitations = Invitation::whereDate('created_at', today())->count();
        $todayPresences = Presence::whereDate('created_at', today())->count();
        $latestInvitations = Invitation::latest()->limit(15)->get();

        return view('auth.dashboard.dashboard', compact(
            'totalInvitations',
            'presencesCount',
            'mahasiswaCount',
            'alumniCount',
            'ortuCount',
            'todayInvitations',
            'todayPresences',
            'latestInvitations'
        ));
    }

    /**
     * Tampilkan halaman daftar hadir admin.
     */
    public function daftarHadir()
    {
        $invitations = Invitation::select('id', 'nama_mhs as nama', 'wa_mhs as email', 'wa_mhs as kontak', 'status', 'attendance_status', 'created_at')->get()
            ->map(function ($item) {
                $item->statusKehadiran = $item->attendance_status === 'hadir' ? 'Hadir' : 'Belum Hadir';

                return $item;
            });

        $presences = Presence::select('id', 'nama_mhs as nama', 'wa_mhs as email', 'status', 'created_at')->get()
            ->map(function ($presence) {
                $presence->checkIn = $presence->created_at->format('H:i') . ' WIB';

                return $presence;
            });

        $totalInvitations = Invitation::count();
        $totalPresences = Presence::count();

        return view('auth.dashboard.daftarHadir', compact('invitations', 'presences', 'totalInvitations', 'totalPresences'));
    }

    /**
     * Process login
     */
    public function login(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string|min:3',
            'password' => 'required|string|min:4',
        ], [
            'username.required' => 'Username harus diisi',
            'username.min' => 'Username minimal 3 karakter',
            'password.required' => 'Password harus diisi',
            'password.min' => 'Password minimal 4 karakter',
        ]);

        // Coba login dengan username
        $user = User::where('name', $validated['username'])->first();

        if (!$user || !Hash::check($validated['password'], $user->password)) {
            return back()->withErrors(['login' => 'Username atau password salah'])->withInput();
        }

        Auth::login($user, $request->boolean('remember'));

        return redirect()->route('dashboard')->with('success', 'Selamat datang, ' . $user->name . '!');
    }

    /**
     * Process register
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'fullname' => 'required|string|min:2|max:255',
            'password' => 'required|string|min:4',
            'password_confirmation' => 'required|string|same:password',
            'terms' => 'accepted',
        ], [
            'fullname.required' => 'Nama lengkap harus diisi',
            'fullname.min' => 'Nama lengkap minimal 2 karakter',
            'password.required' => 'Password harus diisi',
            'password.min' => 'Password minimal 4 karakter',
            'password_confirmation.same' => 'Konfirmasi password tidak cocok',
            'terms.accepted' => 'Anda harus menerima syarat dan ketentuan',
        ]);

        // Cek apakah username sudah terdaftar
        if (User::where('name', $validated['fullname'])->exists()) {
            return back()->withErrors(['fullname' => 'Nama ini sudah terdaftar'])->withInput();
        }

        // Buat user baru
        $user = User::create([
            'name' => $validated['fullname'],
            'email' => strtolower(str_replace(' ', '.', $validated['fullname'])) . '@metamedia.local',
            'password' => Hash::make($validated['password']),
        ]);

        // Auto login setelah register
        Auth::login($user);

        return redirect()->route('dashboard')->with('success', 'Pendaftaran berhasil! Selamat bergabung, ' . $user->name . '!');
    }

    /**
     * Logout
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('invitation.index')->with('success', 'Anda telah logout');
    }

    /**
     * Tandai hadir secara manual dari halaman admin.
     */
    public function markAttendanceManual($id)
    {
        try {
            $invitation = Invitation::find($id);

            if (!$invitation) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data undangan tidak ditemukan',
                ], 404);
            }

            DB::beginTransaction();

            try {
                $existingPresence = Presence::where('invitation_id', $invitation->id)
                    ->whereDate('created_at', now()->toDateString())
                    ->first();

                if (!$existingPresence) {
                    Presence::create([
                        'invitation_id' => $invitation->id,
                        'nama_mhs' => $invitation->nama_mhs,
                        'status' => $invitation->status,
                        'wa_mhs' => $invitation->wa_mhs,
                    ]);
                }

                $invitation->update([
                    'attendance_status' => 'hadir',
                ]);

                DB::commit();

                return response()->json([
                    'success' => true,
                    'message' => 'Status kehadiran berhasil diperbarui',
                    'data' => [
                        'id' => $invitation->id,
                        'nama_mhs' => $invitation->nama_mhs,
                        'attendance_status' => $invitation->attendance_status,
                        'statusKehadiran' => 'Hadir',
                    ],
                ], 200);
            } catch (\Exception $e) {
                DB::rollBack();

                throw $e;
            }
        } catch (\Exception $e) {
            Log::error('Error marking attendance:', ['error' => $e->getMessage()]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memperbarui status: ' . $e->getMessage(),
            ], 500);
        }
    }
}
