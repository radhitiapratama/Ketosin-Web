<?php

namespace App\Http\Controllers;

use App\Imports\KelasImport;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class KelasController extends Controller
{
    protected $statuses = [
        '1' => "Aktif",
        '0' => "Nonaktif",
    ];

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $columnsSearch = ['nama_kelas'];

            $table  = DB::table("kelas");

            if ($request->input("search.value")) {
                $table->where(function ($q) use ($columnsSearch, $request) {
                    foreach ($columnsSearch as $column) {
                        $q->orWhere($column, 'like', '%' . $request->input("search.value") . "%");
                    }
                });
            }

            if ($request->status != null) {
                $table->where("status", $request->status);
            }

            $count = $table->count();

            $result = $table->offset($request->start)
                ->limit($request->length)
                ->orderBy("nama_kelas", "ASC")
                ->get();

            $data = [];

            if (!empty($result)) {
                $i = $request->start;
                foreach ($result as $row) {
                    $i++;
                    $subData = [];
                    $status = $this->checkStatus($row->status);

                    $subData['no'] = $i;
                    $subData['nama_kelas'] = $row->nama_kelas;
                    $subData['status'] = '
                    <div class="text-center">
                    ' . $status . '
                    </div>';
                    $subData['action'] = '
                    <div class="text-center">
                        <a href="kelas/edit/' . $row->id_kelas . '" class="badge badge-warning p-2"><i class="ri-pencil-line"></i></a>
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

        $dataToVieww = [
            'statuses' => $this->statuses,
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

        return redirect("/kelas")->with('successAdd', 'successAdd');
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
                return redirect()->back()->with("duplicate", "duplicate")->withInput();
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

    public function checkStatus($status)
    {
        if ($status == 1) {
            return '<span class="badge badge-success p-2">Aktif</span>';
        }

        if ($status == 0) {
            return '<span class="badge badge-danger p-2">Nonaktif</span>';
        }

        return null;
    }
}
