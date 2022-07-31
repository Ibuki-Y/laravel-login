<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\LoginFormRequest;

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
     * @param App\Http\Requests\LoginFormRequest
     */
    public function login(LoginFormRequest $request) {
        dd($request->all());
    }
}
