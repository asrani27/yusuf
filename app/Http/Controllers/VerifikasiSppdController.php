<?php

namespace App\Http\Controllers;

use App\Models\Sppd;
use App\Models\VerifikasiSppd;
use Illuminate\Http\Request;

class VerifikasiSppdController extends Controller
{
    public function index(Request $request)
    {
        $query = Sppd::with(['spt', 'pegawai', 'anggaran', 'latestVerifikasi'])
            ->whereIn('status_sppd', ['menunggu_verifikasi', 'diverifikasi', 'ditolak', 'selesai']);

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

        return view('verifikasi.index', compact('sppdList'));
    }

    public function show(Sppd $sppd)
    {
        $sppd->load(['spt.pejabat', 'spt.tujuan', 'pegawai', 'anggaran', 'verifikasi.verifikator']);

        return view('verifikasi.show', compact('sppd'));
    }

    public function verifikasi(Request $request, Sppd $sppd)
    {
        $request->validate([
            'status_verifikasi' => 'required|in:disetujui,perbaikan,ditolak',
            'catatan' => 'nullable|string',
        ]);

        VerifikasiSppd::create([
            'sppd_id' => $sppd->id,
            'verifikator_id' => auth()->id(),
            'tanggal_verifikasi' => now(),
            'status_verifikasi' => $request->status_verifikasi,
            'catatan' => $request->catatan,
        ]);

        $statusMap = [
            'disetujui' => 'diverifikasi',
            'perbaikan' => 'draft',
            'ditolak' => 'ditolak',
        ];

        $sppd->update(['status_sppd' => $statusMap[$request->status_verifikasi]]);

        return redirect()->route('verifikasi.index')->with('success', 'Verifikasi berhasil disimpan.');
    }

    public function selesai(Sppd $sppd)
    {
        if ($sppd->status_sppd !== 'diverifikasi') {
            return back()->with('error', 'SPPD harus dalam status diverifikasi untuk diselesaikan.');
        }

        $sppd->update(['status_sppd' => 'selesai']);

        return back()->with('success', 'SPPD berhasil ditandai selesai.');
    }
}
