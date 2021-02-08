<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    use HasFactory;

    protected $table = 'conversation';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'message_id',
        'body',
        'sent_by_user_id',
        'is_seen',
    ];

    public function user(){
        return $this->hasOne(User::class, 'id', 'sent_by_user_id');
    }
}
