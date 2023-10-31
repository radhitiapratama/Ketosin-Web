<?php

namespace App\Http\Controllers;

use App\Models\Peserta;
use App\Models\Kandidat;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use PHPUnit\Framework\ExpectationFailedException;
use Symfony\Component\CssSelector\Node\FunctionNode;

class KandidatController extends Controller
{
    public function index()
    {
        $sql_kandidat = DB::table("kandidat as k")
            ->select(
                'k.*',
                'p1.nama_peserta as nama_ketua',
                'p2.nama_peserta as nama_wakil',
                'p1.tingkatan as tingkatan_ketua',
                'p2.tingkatan as tingkatan_wakil',
                'k1.nama_kelas as kelas_ketua',
                'k2.nama_kelas as kelas_wakil'
            )
            ->join("peserta as p1", 'p1.id_peserta', '=', 'k.id_ketua')
            ->join('peserta as p2', 'p2.id_peserta', '=', 'k.id_wakil')
            ->join('kelas as k1', 'k1.id_kelas', '=', 'p1.id_kelas')
            ->join('kelas as k2', 'k2.id_kelas', '=', 'p2.id_kelas')
            ->where("p1.status", 1)
            ->where("p2.status", 1)
            ->where("k1.status", 1)
            ->where("k2.status", 1)
            ->orderBy("k.id_kandidat", 'ASC')
            ->get();

        $dataToView = [
            'kandidats' => $sql_kandidat,
        ];

        return view("kandidat.index", $dataToView);
    }

    public function add()
    {
        $sql_kandidatKetua = Kandidat::select("id_ketua");
        $sql_kandidatWakil = Kandidat::select("id_wakil");

        $sql_peserta = Peserta::where("status", 1)
            ->where('tipe', 1)
            ->whereNotIn("id_peserta", $sql_kandidatKetua)
            ->whereNotIn("id_peserta", $sql_kandidatWakil)
            ->orderBy("id_peserta", "ASC")
            ->get();

        $dataToView = [
            'pesertas' => $sql_peserta,
        ];

        return view("kandidat.add", $dataToView);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ketua' => "required",
            'wakil' => "required",
            'slogan' => "required",
            'visi' => "required",
            'misi' => "required",
            'foto' => "required|image|mimes:jpeg,jpg,png|max:2048",
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }

        if ($request->ketua == $request->wakil) {
            return redirect()->back()->with("kandidatSama", "kandidatSama");
        }

        $file = $request->file("foto");
        $fileDB = Str::random(40) . "." . $file->getClientOriginalExtension();

        $dataUpdate = [
            'id_ketua' => $request->ketua,
            'id_wakil' => $request->wakil,
            'slogan' => $request->slogan,
            'visi' => $request->visi,
            'misi' => $request->misi,
            'foto' => $fileDB,
        ];

        Kandidat::create($dataUpdate);
        $request->file("foto")->storeAs("public/img-uploads", $fileDB);

        return redirect("kandidat")->with("successAdd", "successAdd");
    }

    public function edit($id_kandidat)
    {
        if (empty($id_kandidat)) {
            return redirect("kandidat");
        }

        $sql_kandidat = DB::table("kandidat as k")
            ->join('peserta as p1', 'p1.id_peserta', '=', 'k.id_ketua')
            ->join('peserta as p2', 'p2.id_peserta', '=', 'k.id_wakil')
            ->where('k.id_kandidat', $id_kandidat);

        $sql_peserta = DB::table("peserta")
            ->where("status", 1)
            ->whereNotIn("id_peserta", $sql_kandidat->select("id_ketua"))
            ->whereNotIn("id_peserta", $sql_kandidat->select("id_wakil"))
            ->get();

        if (empty($sql_kandidat->first())) {
            return redirect("kandidat");
        }

        $dataToView = [
            'kandidat' => $sql_kandidat
                ->select("k.*", 'p1.nama_peserta as nama_ketua', "p2.nama_peserta as nama_wakil")->first(),
            'pesertas' => $sql_peserta
        ];

        return view("kandidat.edit", $dataToView);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_kandidat' => "required",
            'ketua' => "required",
            'wakil' => "required",
            'slogan' => "required",
            'visi' => "required",
            'misi' => "required",
            'foto' => "image|mimes:jpeg,jpg,png|max:2048",
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }

        if ($request->ketua == $request->wakil) {
            return redirect()->back()->withInput()->with("ketuaWakilSama", "ketuaWakilSama");
        }

        $fileDB = null;
        $sql_kandidat = Kandidat::where("id_kandidat", $request->id_kandidat)->first();

        if (empty($sql_kandidat)) {
            return redirect()->back()->withInput()->with("kandidat_null", "kandidat_null");
        }

        if ($request->file("foto")) {
            $file = $request->file("foto");
            $fileDB = Str::random(40) . "." . $file->getClientOriginalExtension();
            $dataUpdate['foto'] = $fileDB;
        }

        if ($sql_kandidat->id_ketua != $request->ketua) {
            $dataUpdate['id_ketua'] = $request->ketua;
        }

        if ($sql_kandidat->id_wakil != $request->wakil) {
            $dataUpdate['id_wakil'] = $request->wakil;
        }

        if ($sql_kandidat->slogan != $request->slogan) {
            $dataUpdate['slogan'] = $request->slogan;
        }

        if ($sql_kandidat->visi != $request->visi) {
            $dataUpdate['visi'] = $request->visi;
        }

        if ($sql_kandidat->misi != $request->misi) {
            $dataUpdate['misi'] = $request->misi;
        }

        if (!empty($dataUpdate)) {
            if ($fileDB != null) {
                $request->file("foto")->storeAs("public/img-uploads", $fileDB);
                Storage::delete("public/img-uploads/" . $request->old_foto);
            }

            Kandidat::where("id_kandidat", $request->id_kandidat)
                ->update($dataUpdate);
        }

        return redirect("kandidat")->with("updateSuccess", "updateSuccess");
    }

    public function detail($id_kandidat)
    {
        if (!isset($id_kandidat)) {
            return redirect("/kandidat");
        }

        $sql_kandidat = DB::table("kandidat as kd")
            ->join('peserta as p1', 'p1.id_peserta', '=', 'kd.id_ketua')
            ->join('kelas as k1', 'k1.id_kelas', '=', 'p1.id_kelas')
            ->join('peserta as p2', 'p2.id_peserta', '=', 'kd.id_wakil')
            ->join('kelas as k2', 'k2.id_kelas', '=', 'p2.id_kelas')
            ->where("kd.id_kandidat", $id_kandidat)
            ->select('kd.*', 'p1.nama_peserta as nama_ketua', 'p1.tingkatan as tingkatan_ketua', 'k1.nama_kelas as kelas_ketua', 'p2.nama_peserta as nama_wakil', 'p2.tingkatan as tingkatan_wakil', 'k2.nama_kelas as kelas_wakil')
            ->first();

        if (empty($sql_kandidat)) {
            return redirect('kandidat');
        }

        $sql_suara = DB::table("pemilihan")
            ->where("id_kandidat", $id_kandidat)
            ->count();

        $dataToView = [
            'kandidat' => (object)[
                'nama_ketua' => $sql_kandidat->nama_ketua,
                'kelas_ketua' => $sql_kandidat->kelas_ketua,
                'tingkatan_ketua' => $this->checkTingkatan($sql_kandidat->tingkatan_ketua),
                'nama_wakil' => $sql_kandidat->nama_wakil,
                'kelas_wakil' => $sql_kandidat->kelas_wakil,
                'tingkatan_wakil' => $this->checkTingkatan($sql_kandidat->tingkatan_wakil),
                'visi' => $sql_kandidat->visi,
                'misi' => $sql_kandidat->misi,
                'slogan' => $sql_kandidat->slogan,
                'foto' => $sql_kandidat->foto,
                'suara' => $sql_suara,
            ],
        ];

        return view("kandidat.detail", $dataToView);
    }

    public function checkTingkatan($tingkatan)
    {
        if ($tingkatan == 1) {
            return "X";
        }

        if ($tingkatan == 2) {
            return "XI";
        }

        if ($tingkatan == 3) {
            return "XII";
        }
    }

    public function ajax_detail(Request $request)
    {
        $id_kandidat = $request->id_kandidat;

        $sql_kandidat = DB::table("kandidat as kd")
            ->join('peserta as p1', 'p1.id_peserta', '=', 'kd.id_ketua')
            ->join('kelas as k1', 'k1.id_kelas', '=', 'p1.id_kelas')
            ->join('peserta as p2', 'p2.id_peserta', '=', 'kd.id_wakil')
            ->join('kelas as k2', 'k2.id_kelas', '=', 'p2.id_kelas')
            ->where("kd.id_kandidat", $id_kandidat)
            ->select('kd.*', 'p1.nama_peserta as nama_ketua', 'p1.tingkatan as tingkatan_ketua', 'k1.nama_kelas as kelas_ketua', 'p2.nama_peserta as nama_wakil', 'p2.tingkatan as tingkatan_wakil', 'k2.nama_kelas as kelas_wakil')
            ->first();

        if (empty($sql_kandidat)) {
            return response()->json([
                'status' => false,
                'message' => "ID Kandidat tidak di temukan",
            ]);
        }

        $misiArr = [];
        $misi = explode("|", $sql_kandidat->misi);

        if (count($misi) > 0) {
            foreach ($misi as $row) {
                array_push($misiArr, $row);
            }
        } else {
            array_push($misiArr, $misi[0]);
        }

        return response()->json([
            'status' => true,
            'message' => "success",
            'slogan' => $sql_kandidat->slogan,
            'visi' => $sql_kandidat->visi,
            'misi' => $misi
        ]);
    }
}
