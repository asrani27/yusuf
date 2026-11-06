<?php

namespace App\Http\Controllers;

use App\Http\Requests\SptRequest;
use App\Models\Pegawai;
use App\Models\Spt;
use App\Models\TujuanTugas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SptController extends Controller
{
    public function index(Request $request)
    {
        $query = Spt::with(['pejabat', 'tujuan', 'pengikut']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nomor_spt', 'like', "%{$search}%")
                    ->orWhere('maksud_perjalanan', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status_spt', $request->status);
        }

        if ($request->filled('bulan')) {
            $query->whereMonth('tanggal_berangkat', $request->bulan);
        }

        if ($request->filled('tahun')) {
            $query->whereYear('tanggal_berangkat', $request->tahun);
        }

        $sptList = $query->latest()->paginate(15)->withQueryString();

        return view('spt.index', compact('sptList'));
    }

    public function create()
    {
        $pejabat = Pegawai::where('is_pejabat', true)->get();
        $tujuan = TujuanTugas::all();
        $pegawai = Pegawai::all();

        return view('spt.create', compact('pejabat', 'tujuan', 'pegawai'));
    }

    public function store(SptRequest $request)
    {
        DB::transaction(function () use ($request) {
            $spt = Spt::create($request->safe()->except('pengikut'));

            foreach ($request->pengikut as $p) {
                $spt->pengikut()->attach($p['pegawai_id'], [
                    'peran_tugas' => $p['peran_tugas'],
                ]);
            }
        });

        return redirect()->route('spt.index')->with('success', 'SPT berhasil dibuat.');
    }

    public function show(Spt $spt)
    {
        $spt->load(['pejabat', 'tujuan', 'pengikut', 'sppd.pegawai']);

        return view('spt.show', compact('spt'));
    }

    public function edit(Spt $spt)
    {
        $spt->load('pengikut');
        $pejabat = Pegawai::where('is_pejabat', true)->get();
        $tujuan = TujuanTugas::all();
        $pegawai = Pegawai::all();

        return view('spt.edit', compact('spt', 'pejabat', 'tujuan', 'pegawai'));
    }

    public function update(SptRequest $request, Spt $spt)
    {
        DB::transaction(function () use ($request, $spt) {
            $spt->update($request->safe()->except('pengikut'));

            $spt->pengikut()->detach();
            foreach ($request->pengikut as $p) {
                $spt->pengikut()->attach($p['pegawai_id'], [
                    'peran_tugas' => $p['peran_tugas'],
                ]);
            }
        });

        return redirect()->route('spt.index')->with('success', 'SPT berhasil diperbarui.');
    }

    public function destroy(Spt $spt)
    {
        if ($spt->sppd()->exists()) {
            return back()->with('error', 'SPT tidak dapat dihapus karena sudah memiliki SPPD terkait.');
        }

        $spt->delete();

        return redirect()->route('spt.index')->with('success', 'SPT berhasil dihapus.');
    }

    public function updateStatus(Request $request, Spt $spt)
    {
        $request->validate([
            'status_spt' => 'required|in:draft,diajukan,disetujui,ditolak',
        ]);

        $spt->update(['status_spt' => $request->status_spt]);

        return back()->with('success', 'Status SPT berhasil diperbarui.');
    }
}
