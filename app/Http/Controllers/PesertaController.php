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

    public function index()
    {
        $sql_peserta = DB::table("peserta as p")
            ->join('kelas as k', 'k.id_kelas', '=', 'p.id_kelas')
            ->where("k.status", 1)
            ->select('p.*', 'k.nama_kelas')
            ->get();

        $dataToView = [
            'pesertas' => $sql_peserta,
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
            'qr_code' => Str::random(10),
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
}
