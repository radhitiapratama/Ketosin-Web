<?php

namespace App\Http\Controllers;

use App\Models\Waktu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class WaktuController extends Controller
{
    protected $statuses = [
        '1' => "Aktif",
        '0' => "Nonaktif",
    ];

    public function index()
    {
        $sql_waktu = Waktu::orderBy("id_waktu", "desc")->get();

        $dataToView = [
            'waktus' => $sql_waktu
        ];

        return view("waktu.index", $dataToView);
    }

    public function add()
    {
        return view("waktu.add");
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'start' => "required",
            'finish' => "required"
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }

        if ($request->finish < $request->start) {
            return redirect()->back()->withInput()->with("minFinish", "minFinish");
        }

        DB::table("waktu")
            ->update([
                'status' => 0,
            ]);

        Waktu::create([
            'start' => $request->start,
            'finish' => $request->finish,
        ]);

        return redirect("batas-waktu")->with("successAdd", "successAdd");
    }

    public function edit($id_waktu)
    {
        if (empty($id_waktu)) {
            return redirect("/batas-waktu");
        }

        $sql_waktu = Waktu::where("id_waktu", $id_waktu)->first();

        if (empty($sql_waktu)) {
            return redirect("/batas-waktu");
        }

        $dataToView =  [
            'waktu' => $sql_waktu,
            'statuses' => $this->statuses
        ];


        return view("waktu.edit", $dataToView);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_waktu' => "required",
            'start' => "required",
            'finish' => "required",
            'status' => "required"
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }

        if ($request->finish < $request->start) {
            return redirect()->back()->with("minFinish", "minFinish")->withInput();
        }

        $sql_waktu = Waktu::where("id_waktu", $request->id_waktu)->first();

        if (empty($sql_waktu)) {
            return redirect()->back();
        }

        $dataUpdate = [];

        if ($sql_waktu->start != $request->start) {
            $dataUpdate['start'] = $request->start;
        }

        if ($sql_waktu->finish != $request->finish) {
            $dataUpdate['finish'] = $request->finish;
        }

        if ($sql_waktu->status != $request->status) {
            $dataUpdate['status'] = $request->status;
        }

        if (!empty($dataUpdate)) {
            Waktu::where("id_waktu", $request->id_waktu)
                ->update($dataUpdate);
        }

        return redirect("/batas-waktu")->with("successUpdate", "successUpdate");
    }
}
