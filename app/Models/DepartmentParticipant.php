<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DepartmentParticipant extends Model
{
    use HasFactory;

    protected $table = 'meeting_department_participant';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'meeting_schedule_id',
        'department_id',
    ];

    public function department(){
        return $this->hasOne(Department::class, 'id', 'department_id');
    }

    public function meeting(){
        return $this->hasOne(MeetingSchedule::class, 'id', 'meeting_schedule_id');
    }

    static function insert($departmentId, $meetingId){
        DepartmentParticipant::create([
            'meeting_schedule_id' => $meetingId,
            'department_id' => $departmentId,
        ]);

        $link = '<a href="#" class="card rounded-0 notification-card btn-show-meeting" meetingid="'.$meetingId.'">';

        Notification::insert('department', $departmentId, $link, $meetingId, 'meeting_schedule');
    }

    static function insertDepartment($request, $meeting){
        foreach($request->departmentParticipant as $key => $value){
            $check = explode("-", $value);

            if($check[0] == 'department'){
                self::insert($check[1], $meeting->id);
            }
        }
    }

    static function updateDepartment($request, $meeting){
        $partipant = Participant::where('meeting_schedule_id', $meeting->id)->delete();
        $bureauParticipant = BureauParticipant::where('meeting_schedule_id', $meeting->id)->delete();
        $departmentPartipant = DepartmentParticipant::where('meeting_schedule_id', $meeting->id)->delete();

        self::insertDepartment($request, $meeting);
    }
}
