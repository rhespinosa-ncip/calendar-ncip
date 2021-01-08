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
        foreach($request->participant as $key => $value){
            self::insert($value, $meeting->id);
        }
    }

    static function updateIndividual($request, $meeting){
        $partipant = Participant::where('meeting_schedule_id', $meeting->id)->delete();
        $departmentPartipant = DepartmentParticipant::where('meeting_schedule_id', $meeting->id)->delete();

        self::insertIndividual($request, $meeting);
    }
}
