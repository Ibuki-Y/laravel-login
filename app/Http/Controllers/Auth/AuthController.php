<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\LoginFormRequest;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller {
    /**
     * View Login Page.
     *
     * @return View
     */
    public function showLogin() {
        return view('login.login_form');
    }

    /**
     *　Execute Login.
     *
     * @param App\Http\Requests\LoginFormRequest $request
     * @return
     */
    public function login(LoginFormRequest $request) {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // セッション再生成
            $request->session()->regenerate();

            return redirect('home')->with('login_success', 'Login succeeded.');
        }

        return back()->withErrors([
            'login_error' => 'Email address or password is incorrect.'
        ]);
    }
}
