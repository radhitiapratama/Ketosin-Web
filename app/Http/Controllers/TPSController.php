<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;

class TPSController extends Controller
{
    public function index()
    {
        $tokens = [
            'TPS 1' => "TokenTPS1",
            'TPS 2' => 'TokenTPS2',
            'TPS 3' => 'TokenTPS3',
        ];

        return view("token-tps.index", compact("tokens"));
    }
}
