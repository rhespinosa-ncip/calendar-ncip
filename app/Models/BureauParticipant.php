<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BureauParticipant extends Model
{
    use HasFactory;

    protected $table = 'bureau_participant';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'meeting_schedule_id',
        'bureau_id',
    ];

    public function bureau(){
        return $this->hasOne(Bureau::class, 'id', 'bureau_id');
    }

    public function meetingSchedule(){
        return $this->hasOne(MeetingSchedule::class, 'id', 'meeting_schedule_id');
    }

    static function insert($bureauId, $meetingId){
        BureauParticipant::create([
            'meeting_schedule_id' => $meetingId,
            'bureau_id' => $bureauId,
        ]);

        $link = '<a href="#" class="card rounded-0 notification-card btn-show-meeting" meetingid="'.$meetingId.'">';

        Notification::insert('bureau', $bureauId, $link, $meetingId, 'meeting_schedule');
    }

    static function insertBureau($request, $meeting){
        foreach($request->bureauParticipant as $key => $value){
            $check = explode("-", $value);

            if($check[0] == 'bureau'){
                self::insert($check[1], $meeting->id);
            }
        }
    }

    static function updateBureau($request, $meeting){
        $partipant = Participant::where('meeting_schedule_id', $meeting->id)->delete();
        $bureauParticipant = BureauParticipant::where('meeting_schedule_id', $meeting->id)->delete();
        $departmentPartipant = DepartmentParticipant::where('meeting_schedule_id', $meeting->id)->delete();


        self::insertBureau($request, $meeting);
    }
}
