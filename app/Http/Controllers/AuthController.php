<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function index()
    {
        return view("auth.login");
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => "required",
            'password' => "required",
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }

        if (Auth::attempt([
            'name' => $request->name,
            'password' => $request->password,
        ])) {
            $request->session()->regenerate();
            return redirect()->intended("dashboard");
        }

        return redirect()->back()->with("loginFailed", "loginFailed");
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect("/");
    }
}
