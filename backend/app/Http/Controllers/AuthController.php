<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function user(Request $request) {
        $data = $request->user();

        return response()->json(['message' => 'Informasi user', 'data' => $data], 200);
    }

    public function users() {
        $data = User::where('role', '!=', 'admin')->get();

        if(empty($data)) return response()->json(['message'=> 'Belum ada anggota'], 404);

        return response()->json(['message'=> 'Daftar semua anggota','data'=> $data], 200);
    }

    public function register(Request $request) {
        $request->validate([
            'name' => 'required|string|min:3',
            'jabatan' => 'nullable|in:Senior Software Engineer,Marketing and Comunications Executive,Financial Operations Officer,Junior Software Developer',
            'department' => 'nullable|in:Technology,Marketing,Finance',
            'email' => 'email|required|unique:users',
            'password' => 'required|string|min:6'
        ]);

        $data = User::create([
            'name' => $request->name,
            'jabatan' => $request->jabatan,
            'department' => $request->department,
            'email' => $request->email,
            'password'=> Hash::make($request->password),
        ]);

        $token = $data->createToken('auth_token')->plainTextToken;
        $data->token = $token;

        return response()->json(['message' => 'Registered succesfuly', 'data' => $data], 201);
    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'required|string|min:3',
            'jabatan' => 'nullable|in:Senior Software Engineer,Marketing and Comunications Executive,Financial Operations Officer,Junior Software Developer',
            'department' => 'nullable|in:Technology,Marketing,Finance',
            'email' => 'email|required|unique:users',
            'password' => 'required|string|min:6'
        ]);

        $data = User::create([
            'name' => $request->name,
            'jabatan' => $request->jabatan,
            'department' => $request->department,
            'email' => $request->email,
            'password'=> Hash::make($request->password),
        ]);

        // $token = $data->createToken('auth_token')->plainTextToken;
        // $data->token = $token;

        return response()->json(['message' => 'User added', 'data' => $data], 201);
    }

    public function login(Request $request) {
        $request->validate([
            'email' => 'email|required',
            'password' => 'required|string|min:6'
        ]);

        $data = User::where('email', $request->email)->first();

        if(!$data || !Hash::check($request->password, $data->password)) return response()->json(['message'=> 'Email or password incorrect'], 401);

        $token = $data->createToken('auth_token')->plainTextToken;
        $data->token = $token;

        return response()->json(['message' => 'Login succesfuly', 'data' => $data], 200);
    }

    public function logout(Request $request) {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message'=> 'Logout succesfuly'], 200);
    }

    public function update($id, Request $request) {
        $request->validate([
            'name' => ['nullable','string','min:3'],
            'email' => ['nullable', 'email', 'unique:users'],
            'jabatan' => ['nullable', 'in:Senior Software Engineer,Marketing and Comunications Executive,Financial Operations Officer,Junior Software Engineer'],
            'department' => ['nullable', 'in:Technology,Marketing,Finance'],
            'role' => ['nullable', 'in:admin,staff'],
            'password' => ['nullable', 'min:6', 'string']
        ]);

        $data = User::find($id);

        if(!$data) return response()->json(['message'=> 'User tidak ditemukan'], 404);
        else if($data->id != $request->user()->id && $request->user()->role != 'admin') return response()->json(['message'=> 'Akses ditolak'], 403);

        $data->update([
            'name' => $request->name ?? $data->name,
            'email' => $request->email ?? $data->email,
            'jabatan' => $request->jabatan ?? $data->jabatan,
            'department' => $request->department ?? $data->department,
            'role' => $request->role ?? $data->role,
            'password' => $request->password ?? $data->password,
        ]);

        return response()->json(['message'=> 'Data berhasil dirubah', 'data' => $data], 200);
    }

    public function destroy($id, Request $request) {
        $data = User::find($id);

        if(!$data) return response()->json(['message'=> 'User tidak ditemukan'], 404);
        else if($data->id != $request->user()->id && $request->user()->role != 'admin') return response()->json(['message'=> 'Akses ditolak'], 403);

        $data->delete();

        return response()->json(['message'=> 'Data berhasil dihapus'], 200);
    }
}
 