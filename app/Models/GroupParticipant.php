<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupParticipant extends Model
{
    use HasFactory;
    protected $table = 'group_participant';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'group_id',
        'user_id',
        'status',
    ];

    public function message(){
        return $this->hasOne(Message::class, 'to_id', 'group_id')->where('type', 'group');
    }

    public function group(){
        return $this->hasOne(Group::class, 'id', 'group_id');
    }


    static function insert($request, $group){
        foreach($request->participant as $keyParticipant => $valueParticipant){
            GroupParticipant::create([
                'group_id' => $group->id,
                'user_id' => $valueParticipant,
                'status' => 'active',
            ]);
        }
    }
}
