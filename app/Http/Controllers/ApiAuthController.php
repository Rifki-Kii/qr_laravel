<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ApiAuthController extends Controller
{
    // Login function
    public function login(Request $request)
    {
        // Validasi input
        $validator = Validator::make(
            $request->all(),
            [
                'username' => 'required',
                'password' => 'required',
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'status' => "error",
                'message' => "Validasi gagal",
                'errors' => $validator->errors(),
                'data' => []
            ], 422); // 422 Unprocessable Entity untuk kesalahan validasi
        }

        // Cek apakah user ada di database
        $user = User::where('username', $request->username)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' => 'error',
                'message' => 'User atau password salah'
            ], 401); // 401 Unauthorized untuk kesalahan login
        }

        // Generate token
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'status' => 'success',
            'message' => 'Login berhasil',
            'data' => [
                'id' => $user->id,
                'username' => $user->username, // Disarankan gunakan 'username' untuk identifikasi
                'token' => $token
            ]
        ], 200); // 200 OK untuk login berhasil
    }

    // Logout function
    public function logout(Request $request)
    {
        // Mengambil user dari request
        $user = $request->user();

        // Periksa jika user ditemukan
        if ($user) {
            // Hapus semua token pengguna
            $user->tokens()->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Logout berhasil'
            ], 200);
        } else {
            // Jika user tidak ditemukan (user sudah logout atau token tidak valid)
            return response()->json([
                'status' => 'error',
                'message' => 'User tidak ditemukan atau sudah logout'
            ], 404); // 404 Not Found jika user tidak ada
        }
    }
}
