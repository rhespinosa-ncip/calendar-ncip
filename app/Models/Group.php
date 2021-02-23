<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class Group extends Model
{
    use HasFactory;
    protected $table = 'group';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'created_by',
    ];

    public function getInitialAttribute(){
        return ucfirst($this->name[0]);
    }

    public function groupParticipant(){
        return $this->hasMany(GroupParticipant::class, 'group_id', 'id');
    }

    static function insert($request){
        $validate = Validator::make($request->all(),[
            'groupName' => 'required',
            'participant' => [
                'array',
                'min:1',
                'required'
            ],
            'participant.*' => [
                'string',
                'distinct',
                'min:1',
                'required'
            ]
        ]);

        if($validate->fails()){
            return response()->json([
                'message' => 'error-input',
                'messages' => $validate->messages(),
            ]);
        }

        $group = Group::create([
            'name' => $request->groupName,
            'created_by' => Auth::id(),
        ]);

        Message::create([
            'from_user_id' => Auth::id(),
            'type' => 'group',
            'to_id' => $group->id,
        ]);

        $groupParticipant = GroupParticipant::insert($request, $group);

        return response()->json([
            'message' => 'success',
        ]);
    }
}
