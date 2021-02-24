<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class GroupSeen extends Model
{
    use HasFactory;
    protected $table = 'group_seen';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'conversation_id',
    ];

    public function user(){
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    static function insert($conversationId){
        GroupSeen::create([
            'user_id' => Auth::id(),
            'conversation_id' => $conversationId,
        ]);
    }

    static function checker($conversationIds){
        foreach($conversationIds as $conversationId){
            $groupSeen = GroupSeen::where([['user_id', Auth::id()],['conversation_id', $conversationId]])->first();
            if(!isset($groupSeen)){
                self::insert($conversationId);
            }
        }
    }
}
