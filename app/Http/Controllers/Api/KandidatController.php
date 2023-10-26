<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Spatie\LaravelIgnition\Support\Composer\FakeComposer;

class KandidatController extends Controller
{
    public function index(Request $request)
    {
        $sql_check = DB::table("pemilihan")
            ->where("id_peserta", Auth::user()->id_peserta)
            ->first();

        $sql_kandidat = DB::table("kandidat as k")
            ->select('k.slogan', 'k.visi', 'k.misi', 'foto', 'p1.nama_peserta as nama_ketua', 'p1.tipe as tipe_ketua', 'p1.tingkatan as tingkatan_ketua', 'ks1.nama_kelas as kelas_ketua', 'p2.nama_peserta as nama_wakil', 'p2.tipe as tipe_wakil', 'p2.tingkatan as tingkatan_wakil', 'ks2.nama_kelas as kelas_wakil')
            ->join('peserta as p1', 'p1.id_peserta', '=', 'k.id_ketua')
            ->join('peserta as p2', 'p2.id_peserta', '=', 'k.id_wakil')
            ->join('kelas as ks1', 'ks1.id_kelas', '=', 'p1.id_kelas')
            ->join('kelas as ks2', 'ks2.id_kelas', '=', 'p2.id_kelas')
            ->get();

        if (!$sql_check) {
            return response()->json([
                'status' => true,
                'message' => "success",
                'kandidats' => $sql_kandidat,
                'status_vote' => 0,
            ]);
        } else {
            return response()->json([
                'status' => true,
                'message' => "success",
                'kandidats' => $sql_kandidat,
                'status_vote' => 1,
            ]);
        }
    }

    public function vote(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_kandidat' => "required",
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => "Validation failed",
            ]);
        }

        $id_kandidat = $request->id_kandidat;
        $longtitude = $request->longtitude;
        $latitude = $request->latitude;

        $sql_checkPeserta = DB::table("peserta")
            ->where("id_peserta", Auth::user()->id_peserta)
            ->first();

        // check id peserta
        if (!$sql_checkPeserta) {
            return response()->json([
                'status' => false,
                'message' => "ID Peserta tidak di temukan !",
            ]);
        }

        $sql_waktu = DB::table('waktu')
            ->where("status", 1)
            ->first();

        // cek apakah ada batas waktu
        if (!$sql_waktu) {
            return response()->json([
                'status' => false,
                'message' => "Batas Waktu belum ada"
            ]);
        }

        $sql_check = DB::table("pemilihan")
            ->where("id_peserta", Auth::user()->id_peserta)
            ->first();

        // cek sudah pilih atau belum
        if ($sql_check) {
            return response()->json([
                'status' => false,
                'message' => "Gagal ! anda sudah memilih",
            ]);
        }

        $waktuSaatIni = Carbon::now();

        // cek apabila waktu kurang
        if ($waktuSaatIni <= $sql_waktu->start) {
            return response()->json([
                'status' => false,
                'message' => "Gagal ! Kurang dari batas waktu"
            ]);
        }

        // cek apabila waktu lebih
        if ($waktuSaatIni >= $sql_waktu->finish) {
            return response()->json([
                'status' => false,
                'message' => "Gagal ! Lebih dari batas waktu"
            ]);
        }

        //lolos
        if ($waktuSaatIni >= $sql_waktu->start && $waktuSaatIni <= $sql_waktu->finish) {
            DB::table('pemilihan')
                ->insert([
                    'id_peserta' => Auth::user()->id_peserta,
                    'id_kandidat' => $id_kandidat,
                    'waktu' => Carbon::now(),
                    'longtitude' => $longtitude,
                    'latitude' => $latitude,
                    'status' => 1,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);

            return response()->json([
                'status' => true,
                'message' => "Anda berhasil memilih",
            ]);
        }
    }
}
