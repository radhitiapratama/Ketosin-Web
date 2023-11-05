<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Peserta;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QrCodeController extends Controller
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

    public function index()
    {
        $sql_kelas = Kelas::where("status", 1)->get();

        $dataToView = [
            'kelases' => $sql_kelas,
            'tipeses' => $this->tipeses,
            'tingkatans' => $this->tingkatans
        ];

        return view("qr.index", $dataToView);
    }

    public function store(Request $request)
    {
        $tipe = $request->tipe;

        if ($tipe == 1) {
            $tingkatan = $request->tingkatan;
            $kelas = $request->kelas;

            $sql_peserta = Peserta::where("qr_code", null)
                ->where("tingkatan", $tingkatan)
                ->where("id_kelas", $kelas)
                ->where("tipe", 1)
                ->get();

            if (!empty($sql_peserta)) {
                foreach ($sql_peserta as $row) {
                    Peserta::where("id_peserta", $row->id_peserta)
                        ->update([
                            'qr_code' => Str::random(40)
                        ]);
                }
            }

            return response()->json([
                'status' => true,
            ]);
        }

        if ($tipe == 2) {
            $sql_peserta = Peserta::where("qr_code", null)
                ->where("tipe", 2)
                ->get();

            if (!empty($sql_peserta)) {
                foreach ($sql_peserta as $row) {
                    Peserta::where("id_peserta", $row->id_peserta)
                        ->update([
                            'qr_code' => Str::random(40)
                        ]);
                }
            }

            return response()->json([
                'status' => true,
            ]);
        }

        if ($tipe == 3) {
            $sql_peserta = Peserta::where("qr_code", null)
                ->where("tipe", 3)
                ->get();

            if (!empty($sql_peserta)) {
                foreach ($sql_peserta as $row) {
                    Peserta::where("id_peserta", $row->id_peserta)
                        ->update([
                            'qr_code' => Str::random(40)
                        ]);
                }
            }

            return response()->json([
                'status' => true,
            ]);
        }
    }

    public function cetak(Request $request)
    {
        $tipe = $request->tipe_cetak;
        $page = $request->page;
        $offset = 0;

        if ($tipe == "") {
            return redirect("qr-code");
        }

        if ($tipe == 1) {
            $tingkatan = $request->cetak_tingkatan;
            $kelas = $request->cetak_kelas;
            $sql_peserta = DB::table("peserta")
                ->select('qr_code', 'nama_peserta')
                ->where("tingkatan", $tingkatan)
                ->where("id_kelas", $kelas)
                ->where("status", 1)
                ->where("qr_code", '!=', null)
                ->orderBy('id_peserta', 'ASC')
                ->get();

            $sql_kelas = Kelas::where("status", 1)
                ->where("id_kelas", $kelas)
                ->first();

            if ($tingkatan == 1) {
                $tingkatan = "X";
            }

            if ($tingkatan == 2) {
                $tingkatan = "XI";
            }

            if ($tingkatan == 3) {
                $tingkatan = "XII";
            }

            $fileName = $tingkatan . " " . $sql_kelas->nama_kelas;

            $dataToView = [
                'tipe' => $tipe,
                'pesertas' => $sql_peserta,
                'kelas' => $sql_kelas->nama_kelas,
                'tingkatan' => $tingkatan,
            ];
        }

        if ($tipe == 2) {
            if (!$page) {
                return redirect("qr-code");
            }

            if ($page != 1) {
                $offset = ($page * 25) - 25;
            }

            $sql_peserta = DB::table("peserta")->select("nama_peserta", "qr_code")
                ->where("tipe", 2)
                ->where("status", 1)
                ->where("qr_code", "!=", null)
                ->orderBy("id_peserta", "ASC")
                ->limit(25)
                ->offset($offset)
                ->get();

            $fileName = "Barcode-Guru";

            $dataToView = [
                'tipe' => $tipe,
                'pesertas' => $sql_peserta,
            ];
        }

        if ($tipe == 3) {
            if (!$page) {
                return redirect("qr-code");
            }

            if ($page != 1) {
                $offset = ($page * 25) - 25;
            }

            $sql_peserta = DB::table("peserta")->select("nama_peserta", "qr_code")
                ->where("tipe", 3)
                ->where("status", 1)
                ->where("qr_code", "!=", null)
                ->orderBy("id_peserta", "ASC")
                ->limit(25)
                ->offset($offset)
                ->get();

            $fileName = "Barcode-Karyawan";

            $dataToView = [
                'tipe' => $tipe,
                'pesertas' => $sql_peserta,
            ];
        }

        $pdf = Pdf::loadView("qr.cetak-barcode", $dataToView);
        $pdf->setPaper("A4", "landscape");
        return $pdf->stream($fileName . ".pdf");
    }
}
