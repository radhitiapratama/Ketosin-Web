<?php

namespace App\Http\Controllers;

use App\Models\Kandidat;
use App\Models\Kelas;
use App\Models\Pemilihan;
use App\Models\Peserta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $sql_suara = DB::table('pemilihan')
                ->select("id_kandidat", DB::raw("COUNT(*) as total_suara"))
                ->groupBy("id_kandidat")
                ->get();

            return response()->json($sql_suara);
        };

        $sql_kandidat = Kandidat::count();
        $sql_peserta = Peserta::where("status", 1)->count();
        $sql_kelas = Kelas::where("status", 1)->count();
        $sql_pemilihan = Pemilihan::where("status", 1)->count();

        $sql_golput = DB::table('peserta as ps')
            ->leftJoin("pemilihan as pm", 'pm.id_peserta', '=', 'ps.id_peserta')
            ->where("ps.status", 1)
            ->where("pm.id_pemilihan", null)
            ->get()->count();

        $dataToView = [
            'kandidat' => $sql_kandidat,
            'peserta' => $sql_peserta,
            'kelas' => $sql_kelas,
            'pemilihan' => $sql_pemilihan,
            'peserta_golput' => $sql_golput,
        ];

        return view("dashboard.index", $dataToView);
    }
}
