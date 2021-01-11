<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Tito extends Model
{
    use HasFactory;

    protected $table = 'tito';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'time_in',
        'time_out',
        'user_id'
    ];

    public function accomplishments(){
        return $this->hasMany(Accomplishment::class, 'tito_id', 'id');
    }

    static function insertTimeIn(){
        Tito::create([
            'time_in' => date('H:i:s'),
            'user_id' => Auth::id()
        ]);
    }

    static function updateTimeOut(){
        Tito::where('user_id', Auth::id())
            ->whereDate('created_at', date('Y-m-d'))
            ->update(['time_out' => date('H:i:s')]);
    }
}
