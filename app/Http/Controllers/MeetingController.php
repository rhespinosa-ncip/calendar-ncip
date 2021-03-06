<?php

namespace App\Http\Controllers;

use App\GlobalClass\Datatables;
use App\Models\ActionableItem;
use App\Models\Bureau;
use App\Models\BureauParticipant;
use App\Models\Department;
use App\Models\DepartmentParticipant;
use App\Models\Document;
use App\Models\MeetingRemarks;
use App\Models\MeetingSchedule;
use App\Models\Minutes;
use App\Models\Notification;
use App\Models\Participant;
use App\Models\ReadNotification;
use App\Models\Tito;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class MeetingController extends Controller
{
    static function index(){
        $count = 0;
        $todayMeetings = array();

        if(Auth::user()->user_type == 'admin'){
            $data = array(
                'filedMeeting' => MeetingSchedule::all(),
                'todayMeeting' => MeetingSchedule::whereDate('date', date('Y-m-d'))->get(),
            );
        }else{
            $departmentParticipant = DepartmentParticipant::with('meeting.user.department')->join('meeting_schedule', 'meeting_schedule.id','=','meeting_department_participant.meeting_schedule_id')
                                        ->join('department', 'department.id','=','meeting_department_participant.department_id')
                                        ->where([['department.id', Auth::user()->department_id],['meeting_schedule.created_by' ,'!=', Auth::id()]]);

            $meetingSchedule = MeetingSchedule::where('created_by', Auth::id());
            $participant = Participant::where('user_id', Auth::id());

            $bureauParticipant = BureauParticipant::with('meetingSchedule.user.bureau')
                                            ->join('meeting_schedule', 'meeting_schedule.id','=','bureau_participant.meeting_schedule_id')
                                            ->join('bureau', 'bureau.id','=','bureau_participant.bureau_id')
                                            ->where([['bureau.id', Auth::user()->bureau_id],['meeting_schedule.created_by' ,'!=', Auth::id()]]);
            $data = array(
                'filedMeeting' => $meetingSchedule->get(),
                'todayMeeting' => $meetingSchedule->whereDate('date', date('Y-m-d'))->get(),

                'asParticipant' => $participant->get(),
                'todayMeetingAsParticipant' => $participant->with(['meeting' => function($query){
                    $query->whereDate('date', date('Y-m-d'));
                }])->get(),

                'departmentMeeting' => $departmentParticipant->get(),
                'todayMeetingAsDepartment' => $departmentParticipant->whereDate('meeting_schedule.date', date('Y-m-d'))->get(),

                'asBureau' => $bureauParticipant->get(),
                'todayMeetingAsBureau' => $bureauParticipant->whereDate('meeting_schedule.date', date('Y-m-d'))->get(),

                'tito' => Tito::today(),
            );

        }

        return view('auth.dashboard.index', compact('data', 'count', 'todayMeetings'));
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

            $notification = Notification::where([['table_name', 'meeting_schedule'],['table_id', $meeting->id]])->first();

            if(isset($notification)){
                ReadNotification::insert($notification->id);
            }

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
        $query = MeetingSchedule::join('users','users.id', '=', 'meeting_schedule.created_by')
                            ->select('users.first_name',
                            'users.middle_name',
                            'users.last_name',
                            'meeting_schedule.title',
                            'meeting_schedule.date',
                            'meeting_schedule.id',
                            'meeting_schedule.zoom_meeting_description')->toSql();

        return Datatables::of($query)
            ->addAction('action', function($result){
                if(date('Y-m-d', strtotime($result->date)) < date('Y-m-d')){
                    return 'no action available';
                }
                return '<button class="btn btn-info  py-1 px-2 rounded-0 btn-update-meeting" meetingId="'.$result->id.'" data-toggle="tooltip" title="Update meeting link"><i class="fas fa-edit"></i></button>';
            })
            ->addAction('meeting_schedule', function($result){
                return date('F d, Y h:i A', strtotime($result->date));
            })
            ->addAction('created_by', function($result){
                return $result->first_name.' '.$result->middle_name.' '.$result->last_name;
            })
            ->addAction('meeting_link_status', function($result){
                if(date('Y-m-d', strtotime($result->date)) < date('Y-m-d')){
                    return '<span class="badge badge-danger">Meeting ended</span>';
                }

                if($result->zoom_meeting_description == 'requestToAdmin'){
                    return '<span class="badge badge-warning">No zoom meeting link</span>';
                }else{
                    return '<span class="badge badge-primary">Zoom meeting link provided</span>';
                }
            })
            ->searchable(['meeting_schedule.title','first_name','middle_name','last_name'])
            ->request($request)
            ->orderBy('ORDER BY date DESC')
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
            'personalMeetingId' => 'required',
            'meetingPasscode' => 'required',
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
            $meeting->zoom_meeting_id = $request->personalMeetingId;
            $meeting->zoom_meeting_passcode = $request->meetingPasscode;
            $meeting->save();
        }

        return response()->json([
            'message' => 'success',
        ]);
    }

    public function optionForm(Request $request){
        $meeting = MeetingSchedule::find($request->meetingId);

        $userQuery = User::where([['user_type','!=','admin'],['id', '!=', Auth::id()]])->get();

        if(isset($meeting->date)){
            if(date('y-m-d H:i', strtotime($meeting->date)) <= date('y-m-d H:i')){
                $userQuery = User::where([['user_type','!=','admin']])->get();
            }
        }

        if($request->value == 'bureau'){
            $data = array(
                'bureau' => Bureau::all(),
                'participant' => $request->valueCheck == 'on' ? $userQuery : array(),
                'selectedParticipant' => $request->valueCheck == 'on' ? Participant::where('meeting_schedule_id', $request->meetingId)->get() : array(),
                'selectedBureau' => BureauParticipant::where('meeting_schedule_id', $request->meetingId)->get(),
            );

            return view('auth.meeting.options.bureau', compact('data','meeting'))->render();
        }else if($request->value == 'department'){
            $data = array(
                'departments' => Department::where('id','!=', '1')->get(),
                'participant' => $request->valueCheck == 'on' ? $userQuery : array(),
                'selectedParticipant' => $request->valueCheck == 'on' ? Participant::where('meeting_schedule_id', $request->meetingId)->get() : array(),
                'selectedDepartment' => DepartmentParticipant::where('meeting_schedule_id', $request->meetingId)->get()
            );

            return view('auth.meeting.options.department', compact('data','meeting'))->render();
        }else if($request->valueCheck == 'on'){
            $data = array(
                'participant' => $userQuery,
                'selectedParticipant' => Participant::where('meeting_schedule_id', $request->meetingId)->get(),
            );

            return view('auth.meeting.options.individual', compact('data','meeting'))->render();
        }
    }

    public function endedMeetingList(Request $request){
        $department = Auth::user()->department_id ?? '0';

        $departmentJoin = '';
        $departmentWhere = '';
        $orAnd = ' AND';

        if(isset(Auth::user()->department_id)){
            $departmentJoin = 'LEFT JOIN meeting_department_participant ON meeting_department_participant.meeting_schedule_id = meeting_schedule.id';
            $departmentWhere = " OR meeting_department_participant.department_id = ".$department;
            $orAnd = ' OR';
        }

        $query = "SELECT
                    DISTINCT meeting_schedule.*
                    FROM meeting_schedule
                    LEFT JOIN meeting_participant ON meeting_participant.meeting_schedule_id = meeting_schedule.id
                    LEFT JOIN bureau_participant ON bureau_participant.meeting_schedule_id  = meeting_schedule.id
                    ".$departmentJoin ."
                WHERE (meeting_schedule.created_by = ".Auth::id()."
                    OR meeting_participant.user_id = ".Auth::id(). $departmentWhere."
                    OR bureau_participant.bureau_id = ".Auth::user()->bureau_id.") AND DATE <= '".now()."' ";

        if(Auth::user()->user_type == 'admin'){
            $query = "SELECT *
            FROM meeting_schedule WHERE DATE <= '".now()."'";
        }

        return Datatables::of($query)
            ->addAction('action', function($result){
                return '<a href="/meeting/view/'.$result->id.'" class="btn btn-success py-0 px-3 rounded-0"> VIEW </a>';
            })
            ->addAction('meeting_schedule', function($result){
                return date('F d, Y h:i A', strtotime($result->date));
            })
            ->searchable(['title'])
            ->request($request)
            ->orderBy('ORDER BY DATE DESC')
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

    public function addRemarksForm(Request $request){
        $data = array(
            'minute' => MeetingSchedule::where('id', $request->meetingId)->first(),
        );

        if(isset($request->status) && $request->status == 'showOnly'){
            return view('auth.meeting.remarks.show', compact('data'));
        }

        return view('auth.meeting.remarks.form', compact('data'));
    }

    public function addRemarksSubmit(Request $request){
        return MeetingRemarks::insert($request);
    }

    public function viewMeeting(Request $request){
        $data = array(
            'meetingSchedule' => MeetingSchedule::where('id', $request->meetingId)->first(),
        );

        if(isset($data['meetingSchedule'])){
            $participantDepartment = DepartmentParticipant::where('meeting_schedule_id', $request->meetingId)->get('department_id');
            $participantBureau = BureauParticipant::where('meeting_schedule_id', $request->meetingId)->get('bureau_id');
            $participant = Participant::where('meeting_schedule_id', $request->meetingId)->get('user_id');

            $userAuth = User::where(function ($query) use ($participantDepartment, $participantBureau, $participant, $data){
                                        if($data['meetingSchedule']->created_by != Auth::id()){
                                            if(Auth::user()->user_type != 'admin'){
                                                switch($data['meetingSchedule']->participant){
                                                    case 'department':
                                                        if(isset($participantDepartment[0])){
                                                            $query->whereIn('department_id', $participantDepartment);
                                                        }else{
                                                            $query->whereIn('id', $participant);
                                                        }
                                                    break;

                                                    case 'bureau':
                                                        if(isset($participantBureau[0])){
                                                            $query->whereIn('bureau_id', $participantBureau);
                                                        }else{
                                                            $query->whereIn('id', $participant);
                                                        }
                                                    break;

                                                    case 'individual':
                                                        $query->whereIn('id', $participant);
                                                    break;
                                                }
                                            }
                                        }
                                    })->whereId(Auth::id())->first();


            if(isset($userAuth) && date('y-m-d H:i', strtotime($data['meetingSchedule']->date)) <= date('y-m-d H:i')){
                $notifications = Notification::where(function($query) use ($data){
                    if($data['meetingSchedule']->created_by == Auth::id()){
                        $query->where('table_name', 'actionable_item_response');
                    }else{
                        $query->where('table_name', 'actionable_item');
                    }
                })
                ->whereIn('table_id', $data['meetingSchedule']->actionableItem->pluck('id'))->get();

                foreach($notifications as $notification){
                    ReadNotification::insert($notification->id);
                }

                return view('auth.meeting.view', compact('data'));
            }
        }

        return view('not-found');
    }

    public function actionableForm(Request $request){
        $data = array(
            'minute' => MeetingSchedule::where('id', $request->meetingId)->first(),
        );

        if($request->status == 'update'){
            $actionableItem = ActionableItem::whereId($request->meetingId)->first();

            if(isset($actionableItem)){
                return response()->json([
                    'view' => view('auth.meeting.actionable-item.update-form', compact('actionableItem'))->render(),
                    'personnel_id' => $actionableItem->personnel_id
                ]);
            }
        }
        return view('auth.meeting.actionable-item.form', compact('data'));
    }

    public function actionableFormOption(Request $request){
        $meetingId = $request->meetingId;
        $selectedOption = $request->value;

        $meetingSchedule = MeetingSchedule::with('departmentParticipants.department','bureauParticipants.bureau','participants.user')->where('id', $meetingId)->first();

        if(isset($meetingSchedule)){
            $participantDepartment = DepartmentParticipant::where('meeting_schedule_id', $meetingId)->get('department_id');
            $participantBureau = BureauParticipant::where('meeting_schedule_id', $meetingId)->get('bureau_id');
            $participant = Participant::where('meeting_schedule_id', $meetingId)->get('user_id');

            if($selectedOption == 'individual'){
                $userOption = array();

                $users = User::orWhereIn('department_id', $participantDepartment)
                            ->orWhereIn('bureau_id', $participantBureau)
                            ->orWhereIn('id', $participant)->get();

                foreach($users as $user){
                    array_push($userOption, array(
                        'user_id' => $user->id,
                        'user_name' => $user->fullName,
                    ));
                }

                return $userOption;
            }

            return response()->json([
                'optionBD' => $meetingSchedule
            ]);
        }
    }

    public function actionableFormSubmit(Request $request){
        return ActionableItem::insert($request);
    }

    public function actionableFormResponse(Request $request){
        $data = array(
            'actionableItem' => ActionableItem::find($request->actionableItem),
        );

        if(isset($data['actionableItem'])){
            return view('auth.meeting.actionable-item.response.form', compact('data'));
        }
    }

    public function actionableFormResponseSubmit(Request $request){
        return ActionableItem::insertResponse($request);
    }
}
