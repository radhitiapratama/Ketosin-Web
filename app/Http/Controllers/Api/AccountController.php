<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\CssSelector\XPath\Extension\FunctionExtension;

class AccountController extends Controller
{
    public function index()
    {
        $sql_peserta = DB::table("peserta as p")
            ->select('p.nama_peserta', 'p.tipe', 'p.tingkatan', 'k.nama_kelas', 'p.status')
            ->join('kelas as k', 'k.id_kelas', '=', 'p.id_kelas')
            ->where("p.id_peserta", Auth::user()->id_peserta)
            ->first();

        if (!$sql_peserta) {
            return response()->json([
                'status' => false,
                'message' => "Peserta tidak di temukan !",
            ]);
        }

        if ($sql_peserta->tipe == 1) {
            $tingkatan = $this->checkTingkatan($sql_peserta->tingkatan);

            $nama = $sql_peserta->nama_peserta;
            if (count(explode(' ', $sql_peserta->nama_peserta)) > 2) {
                $nama = explode(' ', $sql_peserta->nama_peserta)[0] .  ' ' . explode(' ', $sql_peserta->nama_peserta)[1];
            };
            return response()->json([
                'status' => true,
                'message' => "success",
                'peserta' => [
                    'nama_peserta'  => $nama,
                    'tipe' => "Siswa",
                    'kelas' => $tingkatan . " " . $sql_peserta->nama_kelas,
                ],
            ]);
        }

        if ($sql_peserta->tipe == 2) {
            return response()->json([
                'status' => true,
                'message' => "success",
                'peserta' => [
                    'nama_peserta'  => $sql_peserta->nama_peserta,
                    'tipe' => "Guru",
                ],
            ]);
        }

        if ($sql_peserta->tipe == 3) {
            return response()->json([
                'status' => true,
                'message' => "success",
                'peserta' => [
                    'nama_peserta'  => $sql_peserta->nama_peserta,
                    'tipe' => "Karyawan",
                ],
            ]);
        }
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
}
