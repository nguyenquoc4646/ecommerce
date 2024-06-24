<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
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
        'status'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    static public function checkEmail($email)
    {
        return self::select('users.*')
            ->where('email', '=', $email)
            ->first();
        // Add the where condition
    }
    static public function totalUser()
    {
        return self::select('id')
            ->where('is_admin', '=', 0)
            ->where('status', '=', 0)
            ->where('is_deleted', '=', 0)
            ->count();
    }
    static public function totalTodayUser()
    {
        return self::select('id')
            ->where('is_admin', '=', 0)
            ->where('status', '=', 0)
            ->where('is_deleted', '=', 0)
            ->where('created_at', '=', date('Y-m-d'))
            ->count();
    }
}
