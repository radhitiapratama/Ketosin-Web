<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PemilihanController extends Controller
{
    public function index()
    {
        $sql_pemilih = DB::table("peserta as p")
            ->leftJoin("pemilihan as pm", 'pm.id_peserta', '=', 'p.id_peserta')
            ->orderBy("pm.created_at", 'DESC')
            ->select("pm.*", 'p.nama_peserta', 'p.tipe')
            ->get();

        $dataToView = [
            'pemilihs' => $sql_pemilih
        ];

        return view("pemilihan.index", $dataToView);
    }
}
