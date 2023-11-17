<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class TPSController extends Controller
{
    public $tokens = [
        'TPS 1' => "TokenTPS1",
        'TPS 2' => 'TokenTPS2',
        'TPS 3' => 'TokenTPS3',
    ];

    public function index()
    {
        $dataToView = [
            'tokens' => $this->tokens,
        ];

        return view("token-tps.index", $dataToView);
    }

    public function cetak()
    {
        $dataToView = [
            'tokens' => $this->tokens,
        ];

        $fileName = "token-tps";

        $pdf = Pdf::loadView("qr.cetak-token", $dataToView);
        $pdf->setPaper("A4", "landscape");
        return $pdf->stream($fileName . '.pdf');
    }
}
