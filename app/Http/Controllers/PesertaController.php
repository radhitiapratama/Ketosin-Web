<?php

namespace App\Http\Controllers;

use App\Imports\PesertaImport;
use App\Models\Kelas;
use App\Models\Peserta;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use PDO;
use Symfony\Component\CssSelector\XPath\Extension\FunctionExtension;

class PesertaController extends Controller
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

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $columnsSearch = ['p.nama_peserta'];

            $table = DB::table('peserta as p');

            if ($request->input("search.value")) {
                $table->where(function ($q) use ($columnsSearch, $request) {
                    foreach ($columnsSearch as $column) {
                        $q->orWhere($column, 'like', '%' . $request->input("search.value") . "%");
                    }
                });
            }

            $sql_peserta = $table
                ->select('p.*', 'k.nama_kelas')
                ->join('kelas as k', 'k.id_kelas', '=', 'p.id_kelas');

            if ($request->tipe != null) {
                $sql_peserta->where("p.tipe", $request->tipe);
            }

            if ($request->tingkatan != null) {
                $sql_peserta->where("p.tingkatan", $request->tingkatan);
            }

            if ($request->kelas != null) {
                $sql_peserta->where("p.id_kelas", $request->kelas);
            }

            if ($request->status != null) {
                $sql_peserta->where("p.status", $request->status);
            }

            $count = $sql_peserta->count();

            $result = $sql_peserta->offset($request->start)
                ->limit($request->length)
                ->orderBy("p.id_peserta", 'ASC')
                ->get();

            $data = [];
            if (!empty($result)) {
                $i = $request->start;
                foreach ($result as $row) {
                    $i++;

                    $tingkatan = $this->checkTingkatan($row->tingkatan);
                    $status =  $this->checkStatus($row->status);
                    $subData = [];
                    $subData['no'] = $i;
                    $subData['nama_peserta'] = $row->nama_peserta;
                    $subData['tipe'] = $this->checkTipe($row->tipe);
                    $subData['kelas'] = $tingkatan . " " . $row->nama_kelas;
                    $subData['status'] = '
                    <div class="text-center"> ' . $status . ' </div>
                    ';
                    $subData['action'] = '
                    <div class="d-flex justify-content-center gap-20 text-center">
                        <button type="button" class="badge badge-primary p-2 btn-detail-qr"
                            data-qr-value="' . $row->qr_code . '" data-toggle="modal" data-target="#modalQr">
                            <i class="ri-qr-code-line"></i>
                        </button>
                        <a href="/peserta/edit/' . $row->id_peserta . '" class="badge badge-warning p-2">
                            <i class="ri-pencil-line"></i>
                        </a>
                    </div>
                    ';

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

        $sql_kelas = Kelas::where("status", 1)
            ->get();

        $dataToView = [
            'tipeses' => $this->tipeses,
            'tingkatans' => $this->tingkatans,
            'kelases' => $sql_kelas,
            'statuses' => $this->statuses,
        ];

        return view("peserta.index", $dataToView);
    }

    public function add()
    {
        $sql_kelas = Kelas::where("status", 1)->get();

        $dataToView = [
            'kelases' => $sql_kelas,
            'tipeses' => $this->tipeses,
            "tingkatans" => $this->tingkatans,
        ];

        return view("peserta.add", $dataToView);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_peserta' => "required|unique:peserta,nama_peserta",
            'tipe' => "required",
            'tingkatan' => "required",
            'kelas' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }

        Peserta::create([
            'nama_peserta' => $request->nama_peserta,
            'tipe' => $request->tipe,
            'qr_code' => Str::random(40),
            'tingkatan' => $request->tingkatan,
            'id_kelas' => $request->kelas,
        ]);

        return redirect("/peserta")->with("successAdd", "successAdd");
    }

    public function edit($id_peserta)
    {
        if (empty($id_peserta)) {
            return redirect("peserta");
        }

        $sql_peserta = Peserta::where("id_peserta", $id_peserta)->first();

        if (empty($sql_peserta)) {
            return redirect("peserta");
        }

        $sql_kelas = Kelas::where("status", 1)->get();

        $dataToView = [
            'peserta' => $sql_peserta,
            'tipeses' => $this->tipeses,
            'tingkatans' => $this->tingkatans,
            'statuses' => $this->statuses,
            'kelases' => $sql_kelas,
        ];

        return view("peserta.edit", $dataToView);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_peserta' => "required",
            'tipe' => "required",
            'tingkatan' => "required",
            'kelas' => "required",
            'status' => "required",
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }

        $id_peserta = $request->id_peserta;

        if (empty($id_peserta)) {
            return redirect()->back();
        }

        $sql_peserta = Peserta::where("id_peserta", $id_peserta)->first();

        if (empty($sql_peserta)) {
            return redirect()->back();
        }

        $dataUpdate = [];

        if ($sql_peserta->nama_peserta != $request->nama_peserta) {
            $sql_check = Peserta::where("nama_peserta", $request->nama_peserta)->first();
            if ($sql_check) {
                return redirect()->back()->with("duplicate", "duplicate");
            }
            $dataUpdate['nama_peserta'] = $request->nama_peserta;
        }

        if ($sql_peserta->tipe != $request->tipe) {
            $dataUpdate['tipe'] = $request->tipe;
        }

        if ($sql_peserta->tingkatan != $request->tingkatan) {
            $dataUpdate['tingkatan'] = $request->tingkatan;
        }

        if ($sql_peserta->kelas != $request->kelas) {
            $dataUpdate['id_kelas'] = $request->kelas;
        }

        if ($sql_peserta->status != $request->status) {
            $dataUpdate['status'] = $request->status;
        }

        if (!empty($dataUpdate)) {
            Peserta::where("id_peserta", $id_peserta)
                ->update($dataUpdate);
        }

        return redirect("/peserta")->with("successUpdate", "successUpdate");
    }

    public function import(Request $request)
    {

        $file = $request->file("file_excel");

        $importPeserta = new PesertaImport;
        $importPeserta->import($file);

        return redirect()->back()->with("success_import", "success_import");
    }

    public function checkTingkatan($tingkatan)
    {
        if ($tingkatan == 1) {
            return  "X";
        }

        if ($tingkatan == 2) {
            return  "XI";
        }

        if ($tingkatan == 3) {
            return  "XII";
        }

        return null;
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
}
