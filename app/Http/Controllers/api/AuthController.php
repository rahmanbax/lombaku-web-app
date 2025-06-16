<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|unique:users|max:30',
            'password' => 'required|min:6',
            'nama' => 'required|max:100',
            'email' => 'required|email|unique:users',
            'notelp' => 'nullable|max:15',
            'nim_atau_nip' => 'nullable|integer',
            'instansi' => 'nullable|max:100',
            'role' => 'nullable|in:mahasiswa,dosen,admin_lomba,admin_prodi,kemahasiswaan',
            'id_program_studi' => 'nullable|exists:program_studi,id_program_studi'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = User::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'nama' => $request->nama,
            'email' => $request->email,
            'notelp' => $request->notelp,
            'nim_atau_nip' => $request->nim_atau_nip,
            'instansi' => $request->instansi,
            'role' => $request->role ?? 'mahasiswa',
            'id_program_studi' => $request->id_program_studi
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;
 return redirect()->intended('login')->with('success', 'Registrasi berhasil, silakan login.');
        return response()->json([
            'success' => true,
            'message' => 'Registrasi berhasil',
            'data' => $user,
            'token' => $token
        ], 201);
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt(['email' => $credentials['email'], 'password' => $credentials['password']])) {
            $request->session()->regenerate();
            $user = Auth::user();
            
            // Menyimpan data pengguna dalam session
            session([
                'user_id' => $user->id,
                'username' => $user->username,
                'nama' => $user->nama,
                'email' => $user->email,
                'role' => $user->role,
                'nim_atau_nip' => $user->nim_atau_nip,
                'instansi' => $user->instansi,
            ]);

            return redirect()->intended('/');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/');
    }
}