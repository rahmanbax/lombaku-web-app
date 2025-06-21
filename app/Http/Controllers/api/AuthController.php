<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
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
        // ... (kode register Anda)
        $rules = [
            'username' => 'required|string|unique:users,username|max:30',
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

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->route('register')
                ->withErrors($validator)
                ->withInput();
        }

        try {
            DB::transaction(function () use ($request) {
                $user = User::create([
                    'username' => $request->username,
                    'password' => Hash::make($request->password),
                    'nama' => $request->nama,
                    'email' => $request->email,
                    'notelp' => $request->notelp,
                    'role' => $request->role,
                ]);

                if ($user->role === 'mahasiswa') {
                    ProfilMahasiswa::create([
                        'id_user' => $user->id_user,
                        'nim' => $request->nim,
                        'id_program_studi' => $request->id_program_studi,
                        'tanggal_lahir' => $request->tanggal_lahir,
                        'jenis_kelamin' => $request->jenis_kelamin,
                    ]);
                }
            });
        } catch (\Exception $e) {
            return redirect()->route('register')
                ->with('error', 'Registrasi Gagal. Terjadi kesalahan pada server.')
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
