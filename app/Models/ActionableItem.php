<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ActionableItem extends Model
{
    use HasFactory;

    protected $table = 'actionable_item';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'personnel',
        'personnel_id',
        'actionable_item',
        'deadline',
        'meeting_schedule_id'
    ];

    public function documentsResponse(){
        return $this->hasMany(Document::class, 'table_id', 'id')->where('table_name','actionable_item_response');
    }

    public function status(){
        return $this->hasOne(ActionableItemStatus::class, 'actionable_item_id', 'id')->orderBy('id', 'desc');
    }

    public function meetingSchedule(){
        return $this->hasOne(MeetingSchedule::class, 'id', 'meeting_schedule_id');
    }

    static function insert($request){
        $validate = Validator::make($request->all(), [
            'assignedPerson' => [
                'required',
            ],
            'actionableItem' => [
                'required',
            ],
            'deadline' => [
                'required',
            ],
        ]);

        if($validate->fails()){
            return response()->json([
                'message' => 'error-input',
                'messages' => $validate->messages(),
            ]);
        }

        if(isset($request->actionableItemId)){
            $actionable = ActionableItem::whereId($request->actionableItemId)->first();
            $actionable->personnel = $request->assignedPersonel;
            $actionable->personnel_id = $request->assignedPerson;
            $actionable->actionable_item = $request->actionableItem;
            $actionable->deadline = $request->deadline;
            $actionable->save();

            $notification = Notification::where([['table_name', 'actionable_item'],['table_id', $request->actionableItemId]])
            ->update(['table_name' => 'actionable_item_update','personnel_id' => '0']);

            ActionableItemStatus::insert('update submit', $actionable->id);
        }else{
            $actionableId = ActionableItem::create([
                'personnel' => $request->assignedPersonel,
                'personnel_id' => $request->assignedPerson,
                'actionable_item' => $request->actionableItem,
                'deadline' => $request->deadline,
                'meeting_schedule_id' => $request->meetingId
            ]);

            ActionableItemStatus::insert('submit', $actionableId->id);
        }

        $actionId = $actionableId->id ?? $request->actionableItemId;

        $link = '<a href="/meeting/view/'.$request->meetingId.'" class="card rounded-0 notification-card">';
        Notification::insert($request->assignedPersonel, explode("_", $request->assignedPerson)[1], $link, $actionableId->id ?? $request->actionableItemId, 'actionable_item');

        return response()->json([
            'message' => 'success',
        ]);
    }

    static function insertResponse($request){
        $validate = Validator::make($request->all(), [
            'file' => [
                'array',
                'min:1',
                Rule::requiredIf($request->status == 'done')
            ],
            'file.*' => [
                'min:1',
                Rule::requiredIf($request->status == 'done')
            ],
        ]);

        if($validate->fails()){
            return response()->json([
                'message' => 'error-input',
                'messages' => $validate->messages(),
            ]);
        }

        $actionable = ActionableItem::whereId($request->actionableItem)->first();

        if(isset($actionable)){
            Document::updateData($request, 'actionable_item_response', $actionable, 'actionable-response-'.$actionable->id);
            ActionableItemStatus::insert($request->status, $actionable->id);

            $link = '<a href="/meeting/view/'.$actionable->meetingSchedule->id.'" class="card rounded-0 notification-card">';
            Notification::insert('individual', $actionable->meetingSchedule->created_by, $link, $actionable->id, 'actionable_item_response');
        }

        return response()->json([
            'message' => 'success',
        ]);
    }
}
