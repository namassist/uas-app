<?php

namespace App\Http\Controllers;
use App\Models\Warga;
use App\Models\Iuran;

class IuranController extends Controller
{
    public function getTunggakan($tahun)
    {
        $wargas = Warga::with(['iurans' => function ($query) use ($tahun) {
            $query->whereYear('bulan', $tahun)->where('status', 'pending');
        }])->get();

        $data = $wargas->map(function ($warga) use ($tahun) {
            $detail_tunggakan = $warga->iurans->map(function ($iuran) {
                return [
                    'bulan' => $iuran->bulan,
                    'jumlah_iuran' => $iuran->jumlah_iuran,
                ];
            });

            $total_tunggakan = $warga->iurans->sum('jumlah_iuran');

            return [
                'id' => $warga->id,
                'nama' => $warga->nama,
                'alamat' => $warga->alamat,
                'total_tunggakan' => $total_tunggakan,
                'detail_tunggakan' => $detail_tunggakan,
            ];
        });

        return response()->json(['data' => $data]);
    }
}
