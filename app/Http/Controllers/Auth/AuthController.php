<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\LoginFormRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

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

        $user = User::where('email', '=', $credentials['email'])->first();

        if (!is_null($user)) {
            if ($user->locked_flg === 1) {
                return back()->withErrors([
                    'danger' => 'Your account has been locked.'
                ]);
            }

            if (Auth::attempt($credentials)) {
                // セッション再生成
                $request->session()->regenerate();

                if ($user->error_count > 0) {
                    $user->error_count = 0;
                    $user->save();
                }

                return redirect()->route('home')->with('success', 'Login succeeded.');
            }

            $user->error_count += 1;
            if ($user->error_count > 5) {
                $user->locked_flg = 1;
                $user->save();
                return back()->withErrors([
                    'danger' => 'Sorry, your account is locked.'
                ]);
            }
            $user->save();
        }

        return back()->withErrors([
            'danger' => 'Email address or password is incorrect.'
        ]);
    }

    /**
     * Execute Logout.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request) {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('login.show')->with('success', 'Logged out.');
    }
}
