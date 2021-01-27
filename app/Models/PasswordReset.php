<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class PasswordReset extends Model
{
    use HasFactory;

    protected $table = 'password_reset';

    protected $fillable = [
        'email',
        'token',
    ];

    static function insert($request){
        $token = Str::random(60);

        PasswordReset::create([
            'email' => $request->email,
            'token' => $token,
        ]);

        return $token;
    }

    static function checker($email, $token) : bool{
        $checkPasswordReset = PasswordReset::where([['email', $email],['token', $token]])->first();

        if(isset($checkPasswordReset->created_at)){
            if(Carbon::now()->isSameDay($checkPasswordReset->created_at)){
                return true;
            }
        }
        return false;
    }
}
