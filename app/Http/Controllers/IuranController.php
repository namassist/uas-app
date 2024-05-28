<?php

namespace App\Http\Controllers;
use App\Models\Warga;
use App\Models\Iuran;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Carbon\Carbon;

class IuranController extends Controller
{
    /**
     * GET /iurans
     * @return array
     */
    public function index()
    {
        try {
            return response()->json([
                'data' => Iuran::all()
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => [
                    'message' => 'Iuran not found'
                ]
            ], 404);
        }
    }

    /**
     * GET /iuran/{id}
     * @param integer $id
     * @return mixed
     */
    public function show($id)
    {
        try {
            return response()->json([
                'data' => Iuran::findOrFail($id)
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => [
                    'message' => 'Iuran not found'
                ]
            ], 404);
        }
    }

    /**
     * POST /iuran
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function store(Request $request)
    {
        try {
            $this->validateIuran($request);
            $iuran = Iuran::create($request->all());

            return response()->json([
                "message" => "Data iuran berhasil ditambahkan",
                "data" => $iuran
            ], 201);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => [
                    'message' => 'Iuran not found'
                ]
            ], 404);
        }
    }

    public function update(Request $request, $id)
    {
        try{
            $this->validate($request, [
                'status' => [
                    'required',
                    'regex:/^(pending|selesai)$/i',
                ],
            ],[
                'status.regex' => "Status format is invalid: must equal 'pending' or 'selesai'",
            ]);

            $iuran = Iuran::findOrFail($id);
            $iuran->fill($request->only('status'));
            $iuran->save();

            return response()->json([
                "message" => "Data Iuran berhasil diperbarui",
                "data" => $iuran
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => [
                    'message' => 'Iuran not found'
                ]
            ], 404);
        }
    }

    /**
     * DELETE /iuran/{id}
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        try{
            $iuran = Iuran::findOrFail($id);
            $iuran->delete();

            return response()->json([
                "message" => "Data iuran Berhasil Dihapus!",
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => [
                    'message' => 'Iuran not found'
                ]
            ], 404);
        }
    }

    public function getTunggakan($tahun)
    {
        $wargas = Warga::with(['iurans' => function ($query) use ($tahun) {
            $query->whereYear('bulan', $tahun)->where('status', 'pending');
        }])->get()->map(function ($warga) {
            $total_tunggakan = $warga->iurans->sum('jumlah_iuran');

            $detail_tunggakan = $warga->iurans->map(function ($iuran) {
                return [
                    'bulan' => Carbon::parse($iuran->bulan)->format('Y-m'),
                    'jumlah_iuran' => $iuran->jumlah_iuran,
                ];
            });

            return [
                'id' => $warga->id,
                'nama' => $warga->nama,
                'alamat' => $warga->alamat,
                'total_tunggakan' => $total_tunggakan,
                'detail_tunggakan' => $detail_tunggakan,
            ];
        });

        return response()->json(['data' => $wargas]);
    }

    /**
     * Validate iuran from the request.
     *
     * @param Request $request
     */
    private function validateIuran(Request $request)
    {
        $this->validate($request, [
            'id_warga' => 'required|exists:wargas,id',
            'bulan' => [
                'required',
                'date_format:Y-m-d',
            ],
            'jumlah_iuran' => 'required',
            'status' => [
                'required',
                'regex:/^(pending|selesai)$/i',
            ],
        ], [
            'status.regex' => "Status format is invalid: must equal 'pending' or 'selesai'",
            'bulan.date_format' => "The month must be in the format YYYY-MM-DD"
        ]);
    }
}
