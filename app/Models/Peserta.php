<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Peserta extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = "peserta";
    protected $primaryKey = "id_peserta";
    protected $guarded = ["id_peserta"];
}
