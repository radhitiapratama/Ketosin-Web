<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kandidat extends Model
{
    use HasFactory;

    protected $table = "kandidat";
    protected $primaryKey = "id_kandidat";
    protected $guarded = ["id_kandidat"];

    public function ketua_peserta()
    {
        return $this->belongsTo(Peserta::class, 'id_peserta', "id_ketua");
    }

    public function wakil_peserta()
    {
        return $this->belongsTo(Peserta::class, 'id_peserta', "id_wakil");
    }
}
