<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::with('pegawai');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('username', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $users = $query->orderBy('username')->paginate(15)->withQueryString();

        return view('users.index', compact('users'));
    }

    public function create()
    {
        $pegawaiList = Pegawai::orderBy('nama_pegawai')->get();

        return view('users.create', compact('pegawaiList'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'pegawai_id' => 'nullable|exists:pegawai,id',
            'username' => 'required|string|max:50|unique:users,username',
            'email' => 'required|email|max:100|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:admin,pejabat,verifikator,pegawai',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        User::create($data);

        return redirect()->route('users.index')->with('success', 'User berhasil ditambahkan.');
    }

    public function edit(User $user)
    {
        $pegawaiList = Pegawai::orderBy('nama_pegawai')->get();

        return view('users.edit', compact('user', 'pegawaiList'));
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'pegawai_id' => 'nullable|exists:pegawai,id',
            'username' => ['required', 'string', 'max:50', Rule::unique('users')->ignore($user->id)],
            'email' => ['required', 'email', 'max:100', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|in:admin,pejabat,verifikator,pegawai',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        if (empty($data['password'])) {
            unset($data['password']);
        }

        $user->update($data);

        return redirect()->route('users.index')->with('success', 'User berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun sendiri.');
        }

        $user->delete();

        return redirect()->route('users.index')->with('success', 'User berhasil dihapus.');
    }
}
