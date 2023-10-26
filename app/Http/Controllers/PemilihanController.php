<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PemilihanController extends Controller
{
    protected $tipeses = [
        '1' => "Siswa",
        '2' => "Guru",
        '3' => "Karyawan",
    ];

    protected $tingkatans = [
        '1' => "X",
        '2' => "XI",
        '3' => "XII",
    ];

    protected $statuses = [
        '1' => "Aktif",
        '0' => "Nonaktif",
    ];

    protected $pemilihans = [
        '1' => "Sudah Memilih",
        '0' => "Belum Memilih"
    ];

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $tipe = $request->filter_tipe;
            $tingkatan = $request->filter_tingkatan;
            $kelas =  $request->filter_kelas;
            $statusPilih = $request->filter_statusPilih;
            $hasilPilih = $request->filter_hasilPilih;

            $sql_pemilih = DB::table("");
        }

        $sql_pemilih = DB::table("peserta as p")
            ->leftJoin("pemilihan as pm", 'pm.id_peserta', '=', 'p.id_peserta')
            ->orderBy("pm.created_at", 'DESC')
            ->select("pm.*", 'p.nama_peserta', 'p.tipe')
            ->get();

        $sql_kelas = Kelas::where("status", 1)->get();

        $dataToView = [
            'pemilihs' => $sql_pemilih,
            'tipeses' => $this->tipeses,
            'tingkatans' => $this->tingkatans,
            'kelases' => $sql_kelas,
            'hasilPilih' => $this->statuses,
            'statusPilih' => $this->pemilihans,
        ];

        return view("pemilihan.index", $dataToView);
    }
}
