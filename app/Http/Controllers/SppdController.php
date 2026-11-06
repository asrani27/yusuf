<?php

namespace App\Http\Controllers;

use App\Http\Requests\SppdRequest;
use App\Models\Sppd;
use App\Models\Spt;
use Illuminate\Http\Request;

class SppdController extends Controller
{
    public function index(Request $request)
    {
        $query = Sppd::with(['spt', 'pegawai', 'anggaran']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nomor_sppd', 'like', "%{$search}%")
                    ->orWhereHas('pegawai', fn ($q2) => $q2->where('nama_pegawai', 'like', "%{$search}%"));
            });
        }

        if ($request->filled('status')) {
            $query->where('status_sppd', $request->status);
        }

        if ($request->filled('bulan')) {
            $query->whereMonth('tanggal_berangkat', $request->bulan);
        }

        if ($request->filled('tahun')) {
            $query->whereYear('tanggal_berangkat', $request->tahun);
        }

        $sppdList = $query->latest()->paginate(15)->withQueryString();

        return view('sppd.index', compact('sppdList'));
    }

    public function create(Request $request)
    {
        $sptList = Spt::where('status_spt', 'disetujui')->with('pengikut')->get();
        $selectedSpt = null;
        $pengikutOptions = collect();

        if ($request->filled('spt_id')) {
            $selectedSpt = Spt::with(['pengikut', 'tujuan'])->find($request->spt_id);
            if ($selectedSpt) {
                $pengikutOptions = $selectedSpt->pengikut;
            }
        }

        return view('sppd.create', compact('sptList', 'selectedSpt', 'pengikutOptions'));
    }

    public function store(SppdRequest $request)
    {
        Sppd::create($request->validated());

        return redirect()->route('sppd.index')->with('success', 'SPPD berhasil dibuat.');
    }

    public function show(Sppd $sppd)
    {
        $sppd->load(['spt.pejabat', 'spt.tujuan', 'pegawai', 'anggaran', 'verifikasi.verifikator']);

        return view('sppd.show', compact('sppd'));
    }

    public function edit(Sppd $sppd)
    {
        $sptList = Spt::where('status_spt', 'disetujui')->get();
        $sppd->load(['spt.pengikut']);

        return view('sppd.edit', compact('sppd', 'sptList'));
    }

    public function update(SppdRequest $request, Sppd $sppd)
    {
        $sppd->update($request->validated());

        return redirect()->route('sppd.index')->with('success', 'SPPD berhasil diperbarui.');
    }

    public function destroy(Sppd $sppd)
    {
        $sppd->delete();

        return redirect()->route('sppd.index')->with('success', 'SPPD berhasil dihapus.');
    }

    public function ajukanVerifikasi(Sppd $sppd)
    {
        if (! $sppd->anggaran) {
            return back()->with('error', 'Anggaran SPPD belum diisi. Silakan isi anggaran terlebih dahulu.');
        }

        $sppd->update(['status_sppd' => 'menunggu_verifikasi']);

        return back()->with('success', 'SPPD berhasil diajukan untuk verifikasi.');
    }

    public function getSptPengikut(Spt $spt)
    {
        $spt->load(['pengikut', 'tujuan']);

        return response()->json([
            'pengikut' => $spt->pengikut,
            'tujuan' => $spt->tujuan,
            'transportasi' => $spt->transportasi,
            'tanggal_berangkat' => $spt->tanggal_berangkat->format('Y-m-d'),
            'tanggal_kembali' => $spt->tanggal_kembali->format('Y-m-d'),
            'lama_hari' => $spt->lama_hari,
        ]);
    }
}
