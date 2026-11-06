<?php

namespace App\Http\Controllers;

use App\Http\Requests\AnggaranSppdRequest;
use App\Models\AnggaranSppd;
use App\Models\Sppd;

class AnggaranSppdController extends Controller
{
    public function create(Sppd $sppd)
    {
        if ($sppd->anggaran) {
            return redirect()->route('anggaran-sppd.edit', $sppd);
        }

        return view('anggaran-sppd.create', compact('sppd'));
    }

    public function store(AnggaranSppdRequest $request, Sppd $sppd)
    {
        $data = $request->validated();
        $data['sppd_id'] = $sppd->id;
        $data['total_biaya'] = $data['uang_harian']
            + $data['biaya_transportasi']
            + $data['biaya_penginapan']
            + $data['biaya_taksi']
            + $data['biaya_representasi']
            + $data['biaya_lainnya'];

        AnggaranSppd::create($data);

        return redirect()->route('sppd.show', $sppd)->with('success', 'Anggaran SPPD berhasil disimpan.');
    }

    public function edit(Sppd $sppd)
    {
        $anggaran = $sppd->anggaran;

        if (! $anggaran) {
            return redirect()->route('anggaran-sppd.create', $sppd);
        }

        return view('anggaran-sppd.edit', compact('sppd', 'anggaran'));
    }

    public function update(AnggaranSppdRequest $request, Sppd $sppd)
    {
        $data = $request->validated();
        $data['total_biaya'] = $data['uang_harian']
            + $data['biaya_transportasi']
            + $data['biaya_penginapan']
            + $data['biaya_taksi']
            + $data['biaya_representasi']
            + $data['biaya_lainnya'];

        $sppd->anggaran->update($data);

        return redirect()->route('sppd.show', $sppd)->with('success', 'Anggaran SPPD berhasil diperbarui.');
    }
}
