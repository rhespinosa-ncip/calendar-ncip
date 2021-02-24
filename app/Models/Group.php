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
        $initial = '';

        foreach (explode(' ', $this->name) as $word)
            $initial .= strtoupper($word[0]);

        return $initial;
    }

    public function message(){
        return $this->hasOne(Message::class, 'to_id', 'id');
    }

    public function groupParticipant(){
        return $this->hasMany(GroupParticipant::class, 'group_id', 'id')->where('status', 'active');
    }

    static function rule($request){
        return $validate = Validator::make($request->all(),[
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
    }

    static function insert($request){
        if(self::rule($request)->fails()){
            return response()->json([
                'message' => 'error-input',
                'messages' => self::rule($request)->messages(),
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
            'groupName' => $request->groupName
        ]);
    }

    static function updateData($request){
        if(self::rule($request)->fails()){
            return response()->json([
                'message' => 'error-input',
                'messages' => self::rule($request)->messages(),
            ]);
        }

        $group = Group::where([['id', $request->groupId],['created_by', Auth::id()]])->first();

        if(isset($group)){
            $group->name = $request->groupName;
            $group->save();

            GroupParticipant::updateData($request, $group);
        }

        return response()->json([
            'message' => 'success',
            'groupName' => $group->name,
        ]);
    }
}
