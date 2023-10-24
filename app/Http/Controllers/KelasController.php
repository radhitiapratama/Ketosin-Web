<?php

namespace App\Http\Controllers;

use App\Imports\KelasImport;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\RequestStack;

class KelasController extends Controller
{
    protected $statuses = [
        '1' => "Aktif",
        '0' => "Nonaktif",
    ];

    public function index()
    {
        $sql_kelas = Kelas::get();

        $dataToVieww = [
            'kelases' => $sql_kelas,
        ];

        return view("kelas.index", $dataToVieww);
    }

    public function add()
    {
        return view("kelas.add");
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_kelas' => "required|unique:kelas,nama_kelas"
        ], [
            'nama_kelas.unique' => "Nama Kelas sudah ada",
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }

        Kelas::create([
            'nama_kelas' => $request->nama_kelas,
        ]);

        return redirect("/kelas");
    }

    public function edit($id_kelas)
    {
        if (empty($id_kelas)) {
            return redirect("kelas");
        };

        $sql_kelas = Kelas::where("id_kelas", $id_kelas)->first();

        if (empty($sql_kelas)) {
            return redirect("kelas");
        }

        $dataToView = [
            'kelas' => $sql_kelas,
            'statuses' => $this->statuses
        ];

        return view("kelas.edit", $dataToView);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_kelas' => "required",
            'status' => "required"
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }

        $dataUpdate = [];

        $id_kelas = $request->id_kelas;

        $sql_kelas = Kelas::where("id_kelas", $id_kelas)->first();

        if ($sql_kelas->nama_kelas != $request->nama_kelas) {
            $sql_check = Kelas::where("nama_kelas", $request->nama_kelas)->first();
            if ($sql_check) {
                return redirect()->with("duplicate", "duplicate");
            }

            $dataUpdate['nama_kelas'] = $request->nama_kelas;
        }

        if ($sql_kelas->status != $request->status) {
            $dataUpdate['status'] = $request->status;
        }

        if (!empty($dataUpdate)) {
            Kelas::where("id_kelas", $id_kelas)
                ->update($dataUpdate);
        }

        return redirect("kelas");
    }

    public function import(Request $request)
    {
        $file = $request->file("file_excel");
        $kelasImport = new KelasImport;
        $kelasImport->import($file);

        return redirect()->back()->with("success_import", "success_import");
    }
}
