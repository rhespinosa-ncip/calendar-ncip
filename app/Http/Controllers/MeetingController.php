<?php

namespace App\Http\Controllers;

use App\GlobalClass\Datatables;
use App\Models\Department;
use App\Models\DepartmentParticipant;
use App\Models\Document;
use App\Models\MeetingSchedule;
use App\Models\Minutes;
use App\Models\Participant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class MeetingController extends Controller
{
    static function index(){
        $count = 0;

        if(Auth::user()->user_type == 'admin'){
            $data = array(
                'filedMeeting' => MeetingSchedule::all(),
                'todayMeeting' => MeetingSchedule::whereDate('date', date('Y-m-d'))->get(),
                'todayMeetingAsParticipant' => Participant::with(['meeting' => function($query){
                    $query->whereDate('date', date('Y-m-d'));
                }])->get(),
                'departmentMeeting' => DepartmentParticipant::join('meeting_schedule', 'meeting_schedule.id','=','meeting_department_participant.meeting_schedule_id')
                                        ->select('meeting_schedule.*')
                                        ->get()
            );
        }else{
            $data = array(
                'filedMeeting' => MeetingSchedule::where('created_by', Auth::id())->get(),
                'asParticipant' => Participant::where('user_id', Auth::id())->get(),
                'todayMeeting' => MeetingSchedule::where('created_by', Auth::id())
                                ->whereDate('date', date('Y-m-d'))->get(),
                'todayMeetingAsParticipant' => Participant::with(['meeting' => function($query){
                    $query->whereDate('date', date('Y-m-d'));
                }])->where('user_id', Auth::id())->get(),
                'departmentMeeting' => DepartmentParticipant::join('meeting_schedule', 'meeting_schedule.id','=','meeting_department_participant.meeting_schedule_id')
                                        ->where('department_id', Auth::user()->department_id)
                                        ->where('meeting_schedule.created_by', '!=', Auth::id())
                                        ->select('meeting_schedule.*')
                                        ->get(),
                'todayMeetingAsDepartment' => DepartmentParticipant::join('meeting_schedule', 'meeting_schedule.id','=','meeting_department_participant.meeting_schedule_id')
                                    ->where('department_id', Auth::user()->department_id)
                                    ->where('meeting_schedule.created_by', '!=', Auth::id())
                                    ->whereDate('meeting_schedule.date', date('Y-m-d'))
                                    ->select('meeting_schedule.*')
                                    ->get()
            );
        }

        return view('auth.dashboard.index', compact('data', 'count'));
    }

    public function addMeetingForm(){
        $data = array(
            'users' => User::where([['id','!=', Auth::id()],['user_type', 'user']])->get(),
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
            $dateToday = date("Y-m-d H:i");
            $meetingDate = date("Y-m-d H:i", strtotime($meeting->date));

            $data = array(
                'users' => $meeting->created_by == Auth::id() ? User::where('id','!=', Auth::id())->get() : User::all(),
                'department' => Department::where('id','!=', '1')->get(),
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

    public function adminMeetings(Request $request){
        return view('auth.meeting.admin.index');
    }

    public function adminMeetingsList(Request $request){
        $query = 'SELECT
                    users.first_name,
                    users.middle_name,
                    users.last_name,
                    meeting_schedule.title,
                    meeting_schedule.date,
                    meeting_schedule.id
                FROM meeting_schedule
                JOIN users ON users.id = meeting_schedule.created_by';

        return Datatables::of($query)
            ->addAction('action', function($result){
                return '<button class="btn btn-info  py-1 px-2 rounded-0 btn-update-meeting" meetingId="'.$result->id.'" data-toggle="tooltip" title="Update meeting link"><i class="fas fa-edit"></i></button>';
            })
            ->addAction('meeting_schedule', function($result){
                return date('F d, Y h:i A', strtotime($result->date));
            })
            ->addAction('created_by', function($result){
                return $result->first_name.' '.$result->middle_name.' '.$result->last_name;
            })
            ->searchable(['meeting_schedule.title','first_name','middle_name','last_name'])
            ->request($request)
            ->make();
    }

    public function meetingLinkForm(Request $request){
        $meeting = MeetingSchedule::find($request->meetingId);

        if(isset($meeting)){
            return view('auth.meeting.admin.form', compact('meeting'));
        }
    }

    public function meetingLinkSubmit(Request $request){
        $validate = Validator::make($request->all(),[
            'meetingLink' => 'required',
        ]);

        if($validate->fails()){
            return response()->json([
                'message' => 'error-input',
                'messages' => $validate->messages(),
            ]);
        }

        $meeting = MeetingSchedule::find($request->meetingId);

        if(isset($meeting)){
            $meeting->zoom_meeting_description = $request->meetingLink;
            $meeting->save();
        }

        return response()->json([
            'message' => 'success',
        ]);
    }

    public function optionForm(Request $request){
        if($request->value == 'individual'){
            $data = array(
                'users' => User::where('id','!=', Auth::id())->get(),
                'selectedParticipant' => Participant::where('meeting_schedule_id', $request->meetingId)->get()
            );

            return view('auth.meeting.options.individual', compact('data'))->render();
        }else if($request->value == 'department'){
            $data = array(
                'departments' => Department::where('id','!=', '1')->get(),
                'selectedDepartment' => DepartmentParticipant::where('meeting_schedule_id', $request->meetingId)->get()
            );

            return view('auth.meeting.options.department', compact('data'))->render();
        }
    }

    public function endedMeetingList(Request $request){
        $query = "SELECT *
                    FROM meeting_schedule
                    LEFT JOIN meeting_participant ON meeting_participant.meeting_schedule_id = meeting_schedule.id
                    LEFT JOIN meeting_department_participant ON meeting_department_participant.meeting_schedule_id = meeting_schedule.id
                WHERE DATE <= '".now()."'
                    AND (meeting_schedule.created_by = ".Auth::id()."
                    OR meeting_participant.user_id = ".Auth::id()."
                    OR meeting_department_participant.department_id = ".Auth::user()->department_id.")";
        if(Auth::user()->user_type = 'admin'){
            $query = "SELECT *
            FROM meeting_schedule WHERE DATE <= '".now()."'";
        }
        return Datatables::of($query)
            ->addAction('action', function($result){
                if(Auth::id() == $result->created_by){
                    return '<button class="btn btn-success py-0 px-3 rounded-0 btn-add-minutes" meetingId="'.$result->id.'"> ADD </button>';
                }

                return '<button class="btn btn-success py-0 px-3 rounded-0 btn-view-minutes" meetingId="'.$result->id.'"> VIEW </button>';
            })
            ->addAction('meeting_schedule', function($result){
                return date('F d, Y h:i A', strtotime($result->date));
            })
            ->searchable(['title'])
            ->request($request)
            ->make();
    }

    public function minutesForm(Request $request){
        $data = array(
            'minute' => MeetingSchedule::with('minuteDocuments')->where('id', $request->meetingId)->first(),
        );

        if(isset($request->status) && $request->status == 'showOnly'){
            return view('auth.meeting.minutes.show', compact('data'));
        }

        return view('auth.meeting.minutes.form', compact('data'));
    }

    public function minutesFormSubmit(Request $request){
        $meetingSchedule = MeetingSchedule::where('id', $request->meetingMinutesId)->first();

        Document::updateData($request, 'minutes', $meetingSchedule, 'minutes-'.$meetingSchedule->id);

        return response()->json([
            'message' => 'success',
        ]);
    }
}
