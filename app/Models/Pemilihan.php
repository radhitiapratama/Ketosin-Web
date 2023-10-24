<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pemilihan extends Model
{
    use HasFactory;

    protected $table = "pemilihan";
    protected $primaryKey = "pemilihan_id";
    protected $guarded = ['pemilihan_id'];
}
