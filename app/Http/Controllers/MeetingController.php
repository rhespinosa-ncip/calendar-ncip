<?php

namespace App\Http\Controllers;

use App\Models\MeetingSchedule;
use App\Models\Participant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MeetingController extends Controller
{
    static function index(){
        $count = 0;
        
        $data = array(
            'filedMeeting' => MeetingSchedule::where('created_by', Auth::id())->get(),
            'asParticipant' => Participant::where('user_id', Auth::id())->get(),
            'todayMeeting' => MeetingSchedule::where('created_by', Auth::id())
                            ->whereDate('date', date('Y-m-d'))->get(),
            'todayMeetingAsParticipant' => Participant::with(['meeting' => function($query){
                $query->whereDate('date', date('Y-m-d'));
            }])->where('user_id', Auth::id())->get()
        );

        return view('auth.dashboard.index', compact('data', 'count'));
    }

    public function addMeetingForm(){
        $data = array(
            'users' => User::where('id','!=', Auth::id())->get(),
        );

        return view('auth.meeting.add', compact('data'));
    }

    public function addMeetingSubmit(Request $request){
        if(isset($request->meetingStatus) && $request->meetingStatus == 'update'){
            return MeetingSchedule::updateData($request);
        }
        return MeetingSchedule::insert($request);
    }

    public function showMeeting(Request $request){
        $meeting = MeetingSchedule::find($request->meetingId);

        if(isset($meeting)){            
            $dateToday = date("Y-m-d");
            $meetingDate = date("Y-m-d", strtotime($meeting->date));
            
            $data = array(
                'users' => User::where('id','!=', Auth::id())->get(),
                'meeting' => $meeting,
            );

            if ($meetingDate >= $dateToday) {
                if($meeting->created_by == Auth::id()){
                    return view('auth.meeting.update', compact('data'));
                }
            }

            return view('auth.meeting.show', compact('data'));
        }
    }
}
