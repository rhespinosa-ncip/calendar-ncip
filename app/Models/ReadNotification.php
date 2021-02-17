<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ReadNotification extends Model
{
    use HasFactory;

    protected $table = 'read_notification';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'notification_id',
        'user_id'
    ];

    static function insert($notification_id){
        $readNotif = ReadNotification::where([['notification_id', $notification_id],['user_id', Auth::id()]])->first();

        if(!isset($readNotif)){
            ReadNotification::create([
                'notification_id' => $notification_id,
                'user_id' => Auth::id()
            ]);
        }
    }
}
