<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        $users = User::latest()->get();
        return view('user.index', compact('users'));
    }

    public function create()
    {
        return view('user.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama'     => 'required|string|max:100',
            'username' => 'required|string|max:100|unique:users,username',
            'password' => 'required|string|min:6|confirmed',
            'hak'      => 'required|in:admin,pegawai',
            'status'   => 'required|in:aktif,tidak aktif',
        ], [
            'nama.required'             => 'Nama wajib diisi!',
            'username.required'         => 'Username wajib diisi!',
            'username.unique'           => 'Username sudah digunakan!',
            'password.required'         => 'Password wajib diisi!',
            'password.min'              => 'Password minimal 6 karakter!',
            'password.confirmed'        => 'Konfirmasi password tidak cocok!',
            'hak.required'              => 'Hak akses wajib dipilih!',
        ]);

        $validated['password'] = Hash::make($validated['password']);

        User::create($validated);

        return redirect()->route('admin.user.index')->with('success', 'Pengguna berhasil ditambahkan!');
    }

    public function edit(User $user)
    {
        return view('user.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'nama'     => 'required|string|max:100',
            'username' => ['required', 'string', 'max:100', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|string|min:6|confirmed',
            'hak'      => 'required|in:admin,pegawai',
            'status'   => 'required|in:aktif,tidak aktif',
        ], [
            'username.unique'    => 'Username sudah digunakan!',
            'password.min'       => 'Password minimal 6 karakter!',
            'password.confirmed' => 'Konfirmasi password tidak cocok!',
        ]);

        if (empty($validated['password'])) {
            unset($validated['password']);
        } else {
            $validated['password'] = Hash::make($validated['password']);
        }

        $user->update($validated);

        return redirect()->route('admin.user.index')->with('success', 'Data pengguna berhasil diperbarui!');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.user.index')->with('error', 'Anda tidak bisa menghapus akun sendiri!');
        }
        $user->delete();
        return redirect()->route('admin.user.index')->with('success', 'Pengguna berhasil dihapus!');
    }
}
