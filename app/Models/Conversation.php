<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

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

    public function file(){
        return $this->hasMany(Document::class, 'table_id', 'id')->where('table_name','conversation_file');
    }

    static function insert($messageId, $body, $request){
        $conversation = Conversation::create([
            'message_id' => $messageId,
            'body' => $body ?? '',
            'sent_by_user_id' => Auth::id(),
            'is_seen' => 'no',
        ]);

        $document = Document::insert($request, 'conversation_file', $conversation, 'conversation');
    }
}
