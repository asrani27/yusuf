<?php

namespace App\Http\Controllers;

use App\Helpers\Terbilang;
use App\Models\Pegawai;
use App\Models\Sppd;
use App\Models\Spt;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class PdfController extends Controller
{
    public function cetakRekapSpt(Request $request)
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

        $sptList = $query->latest()->get();
        $pejabat = Pegawai::where('is_pejabat', true)->first();

        if ($request->get('format') === 'html') {
            return view('pdf.spt-rekap', compact('sptList', 'pejabat'));
        }

        $pdf = Pdf::loadView('pdf.spt-rekap', compact('sptList', 'pejabat'))
            ->setPaper([0, 0, 609.449, 935.433], 'landscape');

        return $pdf->stream('Rekap-SPT-'.now()->format('YmdHis').'.pdf');
    }

    public function cetakRekapSppd(Request $request)
    {
        $query = Sppd::with(['spt.pejabat', 'spt.tujuan', 'pegawai', 'anggaran']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nomor_sppd', 'like', "%{$search}%")
                    ->orWhereHas('pegawai', fn ($q2) => $q2->where('nama_pegawai', 'like', "%{$search}%"))
                    ->orWhere('tempat_tujuan', 'like', "%{$search}%");
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

        $sppdList = $query->latest()->get();
        $pejabat = Pegawai::where('is_pejabat', true)->first();

        if ($request->get('format') === 'html') {
            return view('pdf.sppd-rekap', compact('sppdList', 'pejabat'));
        }

        $pdf = Pdf::loadView('pdf.sppd-rekap', compact('sppdList', 'pejabat'))
            ->setPaper([0, 0, 609.449, 935.433], 'landscape');

        return $pdf->stream('Rekap-SPPD-'.now()->format('YmdHis').'.pdf');
    }

    public function cetakRekapVerifikasi(Request $request)
    {
        $query = Sppd::with(['spt.pejabat', 'pegawai', 'anggaran', 'latestVerifikasi.verifikator'])
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

        $sppdList = $query->latest()->get();
        $pejabat = Pegawai::where('is_pejabat', true)->first();

        if ($request->get('format') === 'html') {
            return view('pdf.verifikasi-rekap', compact('sppdList', 'pejabat'));
        }

        $pdf = Pdf::loadView('pdf.verifikasi-rekap', compact('sppdList', 'pejabat'))
            ->setPaper([0, 0, 609.449, 935.433], 'landscape');

        return $pdf->stream('Rekap-Verifikasi-SPPD-'.now()->format('YmdHis').'.pdf');
    }

    public function cetakSpt(Spt $spt)
    {
        $spt->load(['pejabat', 'tujuan', 'pengikut']);

        $pdf = Pdf::loadView('pdf.spt', compact('spt'))
            ->setPaper([0, 0, 609.449, 935.433], 'portrait');

        return $pdf->stream('SPT-'.$spt->nomor_spt.'.pdf');
    }

    public function cetakSppd(Sppd $sppd)
    {
        $sppd->load(['spt.pejabat', 'spt.tujuan', 'pegawai', 'anggaran']);

        $pdf = Pdf::loadView('pdf.sppd', compact('sppd'))
            ->setPaper([0, 0, 609.449, 935.433], 'portrait');

        return $pdf->stream('SPPD-'.$sppd->nomor_sppd.'.pdf');
    }

    public function cetakKuitansi(Sppd $sppd)
    {
        $sppd->load(['spt.pejabat', 'spt.tujuan', 'pegawai', 'anggaran']);

        $terbilang = '';
        if ($sppd->anggaran) {
            $terbilang = Terbilang::rupiah($sppd->anggaran->total_biaya);
        }

        $pdf = Pdf::loadView('pdf.kuitansi', compact('sppd', 'terbilang'))
            ->setPaper([0, 0, 609.449, 935.433], 'portrait');

        return $pdf->stream('Kuitansi-SPPD-'.$sppd->nomor_sppd.'.pdf');
    }
}
