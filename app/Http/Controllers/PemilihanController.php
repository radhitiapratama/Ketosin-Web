<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDO;

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
            $columnSearch = [];

            $table = DB::table("peserta as p");

            $query = $table->leftJoin("pemilihan as pm", 'pm.id_peserta', '=', 'p.id_peserta')
                ->orderBy("pm.created_at", 'DESC')
                ->select('pm.*', 'p.nama_peserta', 'p.tipe');

            if ($request->tipe != null) {
                $query->where("p.tipe", $request->tipe);
            }

            if ($request->tingkatan != null) {
                $query->where("p.tingkatan", $request->tingkatan);
            }

            if ($request->kelas != null) {
                $query->where("p.id_kelas", $request->kelas);
            }

            if ($request->statusPilih != null) {
                if ($request->statusPilih == 1) {
                    $query->where("pm.id_peserta", '!=', null);
                } else {
                    $query->where("pm.id_peserta", null);
                }
            }

            if ($request->hasilPilih != null) {
                $query->where("pm.status", $request->hasilPilih);
            }

            $count = $query->count();

            $result = $query->offset($request->start)
                ->limit($request->length)
                ->orderBy("p.id_peserta", 'ASC')
                ->select("pm.*", 'p.nama_peserta', 'p.tipe')
                ->get();

            $data = [];
            if (!empty($result)) {
                $i = $request->start;
                foreach ($result as $row) {
                    $i++;
                    $subData = [];

                    if ($row->waktu) {
                        $waktu = date("d-m-Y H:i:s", strtotime($row->waktu));
                    } else {
                        $waktu = "-";
                    }

                    $subData['no'] = $i;
                    $subData["nama_peserta"] = $row->nama_peserta;
                    $subData['tipe'] = $this->checkTipe($row->tipe);
                    $subData['waktu'] = $waktu;
                    $subData['statusPilih'] = $this->checkStatusPilih($row->id_pemilihan);
                    $subData['hasilPilih'] = $this->checkHasilPilih($row->status);

                    $data[] = $subData;
                }
            }

            return response()->json([
                'draw' => $request->draw,
                'recordsFiltered' => $count,
                'recordsTotal' => $count,
                'data' => $data,
            ]);
        }


        $sql_pemilih = DB::table("peserta as p")
            ->leftJoin("pemilihan as pm", 'pm.id_peserta', '=', 'p.id_peserta')
            ->orderBy("pm.created_at", 'DESC')
            ->select("pm.*", 'p.nama_peserta', 'p.tipe')
            ->get();

        // dd($sql_pemilih);

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

    public function checkTipe($tipe)
    {
        if ($tipe == 1) {
            return "Siswa";
        }

        if ($tipe == 2) {
            return "Guru";
        }

        if ($tipe == 1) {
            return "Karyawan";
        }

        return null;
    }

    public function checkStatus($status)
    {
        if ($status == 1) {
            return '<span class="badge badge-success p-2">Aktif</span>';
        }

        if ($status = 0) {
            return '<span class="badge badge-danger p-2">Nonaktif</span>';
        }

        return null;
    }

    public function checkStatusPilih($statusPilih)
    {
        if ($statusPilih == null) {
            return '<span class="badge badge-danger p-2">Belum Memilih</span>';
        }

        if ($statusPilih != null) {
            return '<span class="badge badge-success p-2">Sudah Memilih</span>';
        }
    }

    public function checkHasilPilih($hasilPilih)
    {
        if ($hasilPilih == 1) {
            return "";
        }

        if ($hasilPilih == 0) {
            return "";
        }
    }
}
