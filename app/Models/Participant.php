<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Participant extends Model
{
    use HasFactory;

    protected $table = 'meeting_participant';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'meeting_schedule_id',
        'user_id',
    ];

    public function user(){
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function meeting(){
        return $this->hasOne(MeetingSchedule::class, 'id', 'meeting_schedule_id');
    }

    static function insert($userId, $meetingId){
        Participant::create([
            'meeting_schedule_id' => $meetingId,
            'user_id' => $userId,
        ]);
    }

    static function insertIndividual($request, $meeting){
        if(isset($request->participant)){
            self::insertNow($request->participant, $meeting);
        }else if(isset($request->bureauParticipant)){
            self::insertNow($request->bureauParticipant, $meeting);
        }else if(isset($request->departmentParticipant)){
            self::insertNow($request->departmentParticipant, $meeting);
        }
    }

    static function insertNow($participant, $meeting){
        foreach($participant as $key => $value){
            $check = explode("-", $value);

            if($check[0] == 'participant'){
                $user = User::whereId($check[1])->first();

                $bureauParticipant = BureauParticipant::where([
                    ['meeting_schedule_id', $meeting->id],
                    ['bureau_id', $user->bureau_id]
                ])->first();

                $departmentParticipant = DepartmentParticipant::where([
                    ['meeting_schedule_id', $meeting->id],
                    ['department_id', $user->department_id]
                ])->first();

                if(!isset($bureauParticipant) && !isset($departmentParticipant)){
                    $meeting = MeetingSchedule::where('id', $meeting->id)->first();
                    $meeting->is_participant = 'yes';
                    $meeting->save();

                    self::insert($check[1], $meeting->id);

                    $link = '<a href="#" class="card rounded-0 notification-card btn-show-meeting" meetingid="'.$meeting->id.'">';

                    Notification::insert('individual', $check[1], $link, $meeting->id, 'meeting_schedule');
                }
            }
        }
    }

    static function updateIndividual($request, $meeting){
        $partipant = Participant::where('meeting_schedule_id', $meeting->id)->delete();
        $bureauParticipant = BureauParticipant::where('meeting_schedule_id', $meeting->id)->delete();
        $departmentPartipant = DepartmentParticipant::where('meeting_schedule_id', $meeting->id)->delete();

        self::insertIndividual($request, $meeting);
    }
}
