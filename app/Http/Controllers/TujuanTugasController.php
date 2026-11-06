<?php

namespace App\Http\Controllers;

use App\Http\Requests\TujuanTugasRequest;
use App\Models\TujuanTugas;
use Illuminate\Http\Request;

class TujuanTugasController extends Controller
{
    public function index(Request $request)
    {
        $query = TujuanTugas::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('kota_tujuan', 'like', "%{$search}%")
                    ->orWhere('provinsi_tujuan', 'like', "%{$search}%")
                    ->orWhere('instansi_tujuan', 'like', "%{$search}%");
            });
        }

        $tujuan = $query->orderBy('kota_tujuan')->paginate(15)->withQueryString();

        return view('tujuan-tugas.index', compact('tujuan'));
    }

    public function create()
    {
        return view('tujuan-tugas.create');
    }

    public function store(TujuanTugasRequest $request)
    {
        TujuanTugas::create($request->validated());

        return redirect()->route('tujuan-tugas.index')->with('success', 'Data tujuan tugas berhasil ditambahkan.');
    }

    public function edit(TujuanTugas $tujuanTuga)
    {
        return view('tujuan-tugas.edit', ['tujuan' => $tujuanTuga]);
    }

    public function update(TujuanTugasRequest $request, TujuanTugas $tujuanTuga)
    {
        $tujuanTuga->update($request->validated());

        return redirect()->route('tujuan-tugas.index')->with('success', 'Data tujuan tugas berhasil diperbarui.');
    }

    public function destroy(TujuanTugas $tujuanTuga)
    {
        $tujuanTuga->delete();

        return redirect()->route('tujuan-tugas.index')->with('success', 'Data tujuan tugas berhasil dihapus.');
    }

    public function apiSearch(Request $request)
    {
        $search = $request->get('q', '');
        $tujuan = TujuanTugas::where('kota_tujuan', 'like', "%{$search}%")
            ->orWhere('instansi_tujuan', 'like', "%{$search}%")
            ->limit(20)
            ->get();

        return response()->json($tujuan);
    }
}
