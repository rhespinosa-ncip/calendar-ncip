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

    static function insertData($groupId, $valueParticipant){
        GroupParticipant::create([
            'group_id' => $groupId,
            'user_id' => $valueParticipant,
            'status' => 'active',
        ]);
    }

    static function insert($request, $group){
        foreach($request->participant as $keyParticipant => $valueParticipant){
            self::insertData($group->id, $valueParticipant);
        }
    }

    static function updateData($request, $group){
        $groupParticipants = GroupParticipant::where('group_id', $group->id)->get();

        foreach($groupParticipants as $groupParticipant){
            $groupParticipant->status = 'not-active';
            $groupParticipant->save();
        }

        foreach($request->participant as $keyParticipant => $valueParticipant){
            $groupParticipant = GroupParticipant::where([['group_id', $group->id],['user_id', $valueParticipant]])->first();
            if(isset($groupParticipant)){
                $groupParticipant->status = 'active';
                $groupParticipant->save();
            }else{
                self::insertData($group->id, $valueParticipant);
            }
        }
    }
}
