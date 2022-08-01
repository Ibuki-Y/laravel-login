<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\LoginFormRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller {
    public function __construct(User $user) {
        $this->user = $user;
    }

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

        // $userModel = new User();
        $user = $this->user->getUserByEmail($credentials['email']);

        if (!is_null($user)) {
            if ($this->user->isAccountLocked($user)) {
                return back()->withErrors([
                    'danger' => 'Your account has been locked.'
                ]);
            }

            if (Auth::attempt($credentials)) {
                // セッション再生成
                $request->session()->regenerate();

                $this->user->resetErrorCount($user);

                return redirect()->route('home')->with('success', 'Login succeeded.');
            }

            $user->error_count = $this->user->addErrorCount($user->error_count);

            if ($this->user->lockAccount($user)) {
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
