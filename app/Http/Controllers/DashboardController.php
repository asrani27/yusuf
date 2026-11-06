<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\Sppd;
use App\Models\Spt;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $data = [
            'totalPegawai' => Pegawai::count(),
            'totalSpt' => Spt::count(),
            'totalSppd' => Sppd::count(),
            'totalUsers' => User::count(),
            'sptDraft' => Spt::where('status_spt', 'draft')->count(),
            'sptDisetujui' => Spt::where('status_spt', 'disetujui')->count(),
            'sppdMenunggu' => Sppd::where('status_sppd', 'menunggu_verifikasi')->count(),
            'sppdSelesai' => Sppd::where('status_sppd', 'selesai')->count(),
            'recentSpt' => Spt::with(['pejabat', 'tujuan'])->latest()->take(5)->get(),
            'recentSppd' => Sppd::with(['pegawai', 'spt'])->latest()->take(5)->get(),
        ];

        return view('dashboard', $data);
    }
}
