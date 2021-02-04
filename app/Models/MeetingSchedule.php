<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class MeetingSchedule extends Model
{
    use HasFactory;

    protected $table = 'meeting_schedule';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
        'zoom_meeting_description',
        'zoom_meeting_id',
        'zoom_meeting_passcode',
        'is_participant',
        'participant',
        'date',
        'created_by',
    ];

    public function participants(){
        return $this->hasMany(Participant::class, 'meeting_schedule_id', 'id');
    }

    public function departmentParticipants(){
        return $this->hasMany(DepartmentParticipant::class, 'meeting_schedule_id', 'id');
    }

    public function bureauParticipants(){
        return $this->hasMany(BureauParticipant::class, 'meeting_schedule_id', 'id');
    }

    public function documents(){
        return $this->hasMany(Document::class, 'table_id', 'id')->where('table_name','meeting_schedule');
    }

    public function minuteDocuments(){
        return $this->hasMany(Document::class, 'table_id', 'id')->where('table_name','minutes');
    }

    public function user(){
        return $this->hasOne(User::class, 'id', 'created_by');
    }

    public function remarks(){
        return $this->hasMany(MeetingRemarks::class, 'meeting_schedule_id', 'id')->orderBy('id', 'desc');
    }

    public function actionableItem(){
        return $this->hasMany(ActionableItem::class, 'meeting_schedule_id', 'id')->orderBy('deadline', 'desc');
    }

    static function validation($request){
        $validate = Validator::make($request->all(),[
            'title' => 'required',
            'date' => 'required',
            'description' => 'required',
            'zoomMeetingLink' => [
                Rule::requiredIf($request->requestZoomMeetingLink != 'on')
            ],
            'zoomMeetingId' => [
                Rule::requiredIf($request->requestZoomMeetingLink != 'on')
            ],
            'zoomMeetingPasscode' => [
                Rule::requiredIf($request->requestZoomMeetingLink != 'on')
            ],
            'participant' => [
                'array',
                'min:1',
                Rule::requiredIf($request->isIndividual == 'on' && !isset($request->participantsChoice))
            ],
            'participant.*' => [
                'string',
                'distinct',
                'min:1',
                Rule::requiredIf($request->isIndividual == 'on' && !isset($request->participantsChoice))
            ],
            'departmentParticipant' => [
                'array',
                'min:1',
                Rule::requiredIf($request->participantsChoice == 'department')
            ],
            'departmentParticipant.*' => [
                'string',
                'distinct',
                'min:1',
                Rule::requiredIf($request->participantsChoice == 'department')
            ],
            'bureauParticipant' => [
                'array',
                'min:1',
                Rule::requiredIf($request->participantsChoice == 'bureau')
            ],
            'bureauParticipant.*' => [
                'string',
                'distinct',
                'min:1',
                Rule::requiredIf($request->participantsChoice == 'bureau')
            ],
        ]);

        return $validate;
    }

    static function insert($request){
        $validate = self::validation($request);

        if($validate->fails()){
            return response()->json([
                'message' => 'error-input',
                'messages' => $validate->messages(),
            ]);
        }

        $meeting = MeetingSchedule::create([
            'title' => $request->title,
            'description' => $request->description,
            'zoom_meeting_description' => $request->zoomMeetingLink,
            'zoom_meeting_id' => $request->zoomMeetingId,
            'zoom_meeting_passcode' =>  $request->zoomMeetingPasscode,
            'participant' => $request->participantsChoice ?? 'individual',
            'is_participant' => 'no',
            'date' => $request->date,
            'created_by' => Auth::id(),
        ]);

        Document::insert($request, 'meeting_schedule', $meeting, 'meeting_schedule_'.$meeting->id);

        if($request->participantsChoice == 'bureau'){
            BureauParticipant::insertBureau($request, $meeting);
            Participant::insertIndividual($request, $meeting);
        }else if($request->participantsChoice == 'department'){
            DepartmentParticipant::insertDepartment($request, $meeting);
            Participant::insertIndividual($request, $meeting);
        }else if($request->isIndividual == 'on'){
            Participant::insertIndividual($request, $meeting);
        }

        return response()->json([
            'message' => 'success',
        ]);
    }

    static function updateData($request){
        $validate = self::validation($request);

        if($validate->fails()){
            return response()->json([
                'message' => 'error-input',
                'messages' => $validate->messages(),
            ]);
        }

        $meeting = MeetingSchedule::find($request->meetingId);

        if(isset($meeting)){
            if($meeting->created_by == Auth::id()){
                $meeting->title = $request->title;
                $meeting->description = $request->description;
                $meeting->zoom_meeting_description = $request->zoomMeetingLink;
                $meeting->zoom_meeting_id = $request->zoomMeetingId;
                $meeting->zoom_meeting_passcode = $request->zoomMeetingPasscode;
                $meeting->date = $request->date;
                $meeting->is_participant = 'no';
                $meeting->participant = $request->participantsChoice ?? 'individual';
                $meeting->save();

                $notification = Notification::where([['table_name', 'meeting_schedule'],['table_id', $request->meetingId]])
                ->update(['table_name' => 'meeting_schedule_update','personnel_id' => '0']);

                if($request->participantsChoice == 'bureau'){
                    BureauParticipant::updateBureau($request, $meeting);
                    Participant::insertIndividual($request, $meeting);
                }else if($request->participantsChoice == 'department'){
                    DepartmentParticipant::updateDepartment($request, $meeting);
                    Participant::insertIndividual($request, $meeting);
                }else if($request->isIndividual == 'on'){
                    Participant::updateIndividual($request, $meeting);
                }

                Document::updateData($request, 'meeting_schedule', $meeting, 'meeting_schedule_'.$meeting->id);
            }
        }

        return response()->json([
            'message' => 'updateSuccess',
        ]);
    }
}
