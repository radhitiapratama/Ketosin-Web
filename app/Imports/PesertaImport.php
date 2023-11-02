<?php

namespace App\Imports;

use Carbon\Carbon;
use App\Models\Peserta;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Symfony\Component\CssSelector\XPath\Extension\FunctionExtension;

class PesertaImport implements ToCollection, WithStartRow
{
    use Importable;

    /**
     * @param Collection $collection
     */
    public function collection(Collection $rows)
    {
        DB::beginTransaction();

        $dataInsert = [];

        foreach ($rows as $row) {
            $tingkatan = $this->checkTingkatan($row[2]);
            $tipe = $this->checkTipe($row[1]);
            $kelas = null;

            if ($tipe == "Siswa") {
                if ($tingkatan == null) {
                    continue;
                }

                $sql_kelas = DB::table('kelas')
                    ->where("nama_kelas", $row[3])
                    ->first();

                if (!$sql_kelas) {
                    continue;
                }

                $kelas =  $sql_kelas->id_kelas;
            }

            $nama_peserta = str_replace("'", "", $row[0]);

            $dataInsert[] = [
                'nama_peserta' =>  $nama_peserta,
                'tipe' => $tipe,
                'qr_code' => Str::random(40),
                'tingkatan' => $tingkatan,
                'id_kelas' => $kelas,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
        }

        Peserta::insert($dataInsert);

        DB::commit();
    }

    public function startRow(): int
    {
        return 2;
    }

    public function checkTipe($tipe)
    {

        if (strtoupper($tipe)  == "SISWA") {
            return 1;
        }

        if (strtoupper($tipe)  == "GURU") {
            return 2;
        }

        if (strtoupper($tipe)  == "KARYAWAN") {
            return 3;
        }

        return null;
    }

    public function checkTingkatan($tingkatan)
    {

        if (strtoupper($tingkatan) == "X") {
            return 1;
        }
        if (strtoupper($tingkatan) == "XI") {
            return 2;
        }
        if (strtoupper($tingkatan) == "XII") {
            return 3;
        }

        return null;
    }
}
