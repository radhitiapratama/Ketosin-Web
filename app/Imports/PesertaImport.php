<?php

namespace App\Imports;

use App\Models\Peserta;
use Carbon\Carbon;
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

            if ($tipe == null || $tingkatan == null) {
                DB::rollBack();
                return;
            }

            $sql_kelas = DB::table('kelas')
                ->where("nama_kelas", $row[3])
                ->first();

            if (!$sql_kelas) {
                DB::rollBack();
                return;
            }

            $dataInsert[] = [
                'nama_peserta' => $row[0],
                'tipe' => $tipe,
                'id_kelas' => $sql_kelas->id_kelas,
                'qr_code' => null,
                'tingkatan' => $tingkatan,
                'id_kelas' => $sql_kelas->id_kelas,
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
