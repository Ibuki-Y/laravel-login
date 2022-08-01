<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable {
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'locked_flg',
        'error_count',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    // protected $casts = [
    //     'email_verified_at' => 'datetime',
    // ];

    /**
     * Returns users matched by email.
     *
     * @param string $email
     * @return object
     */
    public function getUserByEmail($email) {
        return User::where('email', '=', $email)->first();
    }

    /**
     * Is the account locked?
     *
     * @param object $user
     * @return bool
     */
    public function isAccountLocked($user) {
        if ($user->locked_flg === 1) {
            return true;
        }
        return false;
    }

    /**
     * Reset error count.
     *
     * @param object $user
     */
    public function resetErrorCount($user) {
        if ($user->error_count > 0) {
            $user->error_count = 0;
            $user->save();
        }
    }

    /**
     * Increase error count by 1.
     *
     * @param int $error_count
     * @return int
     */
    public function addErrorCount($error_count) {
        return $error_count + 1;
    }

    /**
     * Lock an account.
     *
     * @param object $user
     * @return bool
     */
    public function lockAccount($user) {
        if ($user->error_count > 5) {
            $user->locked_flg = 1;
            return $user->save();
        }
        return false;
    }
}
