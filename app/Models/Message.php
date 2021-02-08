<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;
    protected $table = 'message';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'from_user_id',
        'body',
        'type',
        'to_id',
        'is_seen',
    ];

    public function conversation(){
        return $this->hasMany(Conversation::class, 'message_id', 'id');
    }

    public function lastConversation(){
        return $this->hasOne(Conversation::class, 'message_id', 'id')->orderBy('id', 'desc');
    }

    public function individualTo(){
        return $this->hasOne(User::class, 'id', 'to_id');
    }

    public function individualFrom(){
        return $this->hasOne(User::class, 'id', 'from_user_id');
    }


    public function lastMessage(){

    }
}
