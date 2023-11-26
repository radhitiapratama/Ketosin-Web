<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Peserta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'qr_code' => "required",
        ]);

        if ($validator->fails()) {
            return response()->json(
                [
                    'status' => false,
                    'message' => "Validation failed"
                ]
            );
        }

        $peserta = Peserta::where("qr_code", $request->qr_code)->first();

        if ($peserta) {
            $token = $peserta->createToken("api-token")->plainTextToken;
            return response()->json([
                'status' => true,
                'message' => "success",
                'peserta' => $peserta,
                'token' => $token,
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => "Name / Password Salah !",
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            "status" => true,
            'message' => "success logout",
        ]);
    }
}
