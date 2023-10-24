<?php

namespace App\Imports;

use App\Models\Kelas;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;

class KelasImport implements ToCollection, WithStartRow
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
            $sql_check = Kelas::where("nama_kelas", $row[0])->first();

            if ($sql_check) {
                DB::rollBack();
                return;
            }

            $dataInsert[] = [
                'nama_kelas' => $row[0],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
        }

        Kelas::insert($dataInsert);

        DB::commit();
    }

    public function startRow(): int
    {
        return 2;
    }
}
