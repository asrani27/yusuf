<?php

namespace App\Http\Controllers;

use App\Http\Requests\PegawaiRequest;
use App\Models\Pegawai;
use Illuminate\Http\Request;

class PegawaiController extends Controller
{
    public function index(Request $request)
    {
        $query = Pegawai::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nip', 'like', "%{$search}%")
                    ->orWhere('nama_pegawai', 'like', "%{$search}%")
                    ->orWhere('jabatan', 'like', "%{$search}%");
            });
        }

        $pegawai = $query->orderBy('nama_pegawai')->paginate(15)->withQueryString();

        return view('pegawai.index', compact('pegawai'));
    }

    public function create()
    {
        return view('pegawai.create');
    }

    public function store(PegawaiRequest $request)
    {
        $data = $request->validated();
        $data['is_pejabat'] = $request->boolean('is_pejabat');

        Pegawai::create($data);

        return redirect()->route('pegawai.index')->with('success', 'Data pegawai berhasil ditambahkan.');
    }

    public function show(Pegawai $pegawai)
    {
        $pegawai->load('user');

        return view('pegawai.show', compact('pegawai'));
    }

    public function edit(Pegawai $pegawai)
    {
        return view('pegawai.edit', compact('pegawai'));
    }

    public function update(PegawaiRequest $request, Pegawai $pegawai)
    {
        $data = $request->validated();
        $data['is_pejabat'] = $request->boolean('is_pejabat');

        $pegawai->update($data);

        return redirect()->route('pegawai.index')->with('success', 'Data pegawai berhasil diperbarui.');
    }

    public function destroy(Pegawai $pegawai)
    {
        $pegawai->delete();

        return redirect()->route('pegawai.index')->with('success', 'Data pegawai berhasil dihapus.');
    }

    public function apiSearch(Request $request)
    {
        $search = $request->get('q', '');
        $pegawai = Pegawai::where('nama_pegawai', 'like', "%{$search}%")
            ->orWhere('nip', 'like', "%{$search}%")
            ->limit(20)
            ->get(['id', 'nip', 'nama_pegawai', 'jabatan']);

        return response()->json($pegawai);
    }

    public function apiPejabat(Request $request)
    {
        $search = $request->get('q', '');
        $pejabat = Pegawai::where('is_pejabat', true)
            ->where(function ($q) use ($search) {
                $q->where('nama_pegawai', 'like', "%{$search}%")
                    ->orWhere('nip', 'like', "%{$search}%");
            })
            ->limit(20)
            ->get(['id', 'nip', 'nama_pegawai', 'jabatan']);

        return response()->json($pejabat);
    }
}
