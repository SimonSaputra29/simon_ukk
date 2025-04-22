<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserApiController extends Controller
{
    // Ambil semua User
    public function index()
    {
        return response()->json(User::all());
    }

    // Simpan User baru
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'role' => 'required|in:administrator,petugas,visitor',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create($data);

        return response()->json([
            'message' => 'User berhasil ditambahkan',
            'data' => $user
        ], 201);
    }

    // Tampilkan detail User
    public function show($id)
    {
        $user = User::findOrFail($id);

        return response()->json($user);
    }

    // Update User
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required|in:administrator,petugas,visitor',
        ]);

        $user->update($data);

        return response()->json([
            'message' => 'User berhasil diperbarui',
            'data' => $user
        ]);
    }

    // Hapus User
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json(['message' => 'User berhasil dihapus']);
    }
}
