<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\ProfilAdminLomba;
use App\Models\ProfilMahasiswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    // Method register() Anda sudah benar, tidak perlu diubah.
    public function register(Request $request)
    {
        Log::info('--- Proses registrasi dimulai ---', ['request_data' => $request->all()]);

        $rules = [
            'password' => 'required|string|min:6',
            'nama' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'notelp' => 'nullable|string|max:15',
            'role' => 'required|in:mahasiswa,dosen,admin_lomba,admin_prodi,kemahasiswaan',
        ];

        if ($request->input('role') === 'mahasiswa') {
            $rules['nim'] = 'required|string|max:20|unique:profil_mahasiswa,nim';
            $rules['id_program_studi'] = 'required|exists:program_studi,id_program_studi';
            $rules['tanggal_lahir'] = 'nullable|date';
            $rules['jenis_kelamin'] = 'nullable|in:Laki-laki,Perempuan';
        }
        if ($request->input('role') === 'admin_lomba') {
            // [PERBAIKAN] Pastikan nama field di validasi sama dengan yang diakses nanti
            $rules['alamat'] = 'required|string|max:255';
            $rules['jenis_organisasi'] = 'required|string|in:perusahaan,mahasiswa,lainnya'; // Sesuaikan dengan Enum di migrasi
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            Log::warning('Validasi registrasi gagal.', ['errors' => $validator->errors()->all()]);
            return redirect()->route('register')
                ->withErrors($validator)
                ->withInput();
        }

        Log::info('Validasi berhasil.');

        try {
            DB::transaction(function () use ($request) {
                Log::info('Memulai DB Transaction.');

                $user = User::create([
                    'password' => Hash::make($request->password),
                    'nama' => $request->nama,
                    'email' => $request->email,
                    'notelp' => $request->notelp,
                    'role' => $request->role,
                ]);

                Log::info('User berhasil dibuat.', ['user_id' => $user->id_user]);

                if ($user->role === 'mahasiswa') {
                    Log::info('Membuat profil mahasiswa...');
                    ProfilMahasiswa::create([
                        'id_user' => $user->id_user,
                        'nim' => $request->nim,
                        'id_program_studi' => $request->id_program_studi,
                        'tanggal_lahir' => $request->tanggal_lahir,
                        'jenis_kelamin' => $request->jenis_kelamin,
                    ]);
                    Log::info('Profil mahasiswa berhasil dibuat.');
                }

                if ($user->role === 'admin_lomba') {
                    Log::info('Membuat profil admin lomba...');
                    ProfilAdminLomba::create([
                        'id_user' => $user->id_user, // Diasumsikan kolom ini ada di migrasi Anda
                        'alamat' => $request->alamat, // <-- [PERBAIKAN] Menggunakan $request->alamat
                        'jenis_organisasi' => $request->jenis_organisasi,
                    ]);
                    Log::info('Profil admin lomba berhasil dibuat.');
                }
            });

            Log::info('DB Transaction berhasil. Proses registrasi selesai.');
        } catch (\Exception $e) {
            // <-- [PERUBAHAN] Ini bagian terpenting untuk debug -->
            Log::error('!!! EXCEPTION SAAT REGISTRASI !!!', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString() // Memberikan trace lengkap error
            ]);

            return redirect()->route('register')
                ->with('error', 'Registrasi Gagal. Terjadi kesalahan pada server. Silakan cek log untuk detail.')
                ->withInput();
        }

        return redirect()->route('login')
            ->with('success', 'Registrasi berhasil! Silakan masuk dengan akun Anda.');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();

            // Logika redirect berdasarkan role
            switch ($user->role) {
                case 'kemahasiswaan':
                    return redirect()->intended('/dashboard/kemahasiswaan');
                case 'admin_lomba':
                    return redirect()->intended('/dashboard/adminlomba');
                    // Tambahkan case lain jika perlu
                case 'admin_prodi':
                    // Arahkan ke URL /adminprodi, sesuai dengan yang ada di web.php
                    return redirect()->intended('/adminprodi');

                case 'dosen':
                    // Arahkan ke URL /dosen, sesuai dengan yang ada di web.php
                    return redirect()->intended('/dosen');

                case 'mahasiswa':
                default:
                    // PERUBAHAN: Arahkan ke halaman utama (root URL) yang menampilkan welcome.blade.php
                    return redirect()->intended('/');
            }
        }

        // Jika login gagal, kembali ke halaman login dengan pesan error
        return back()->withErrors([
            'email' => 'Email atau password yang Anda masukkan salah.',
        ])->onlyInput('email');
    }

    // Method logout() Anda sudah benar, tidak perlu diubah.
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
