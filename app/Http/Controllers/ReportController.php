<?php

namespace App\Http\Controllers;

use App\Models\Bureau;
use App\Models\Tito;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\BureauDivision;
use App\Models\Department;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class ReportController extends Controller
{
    public function indexAccomplishment(){
        return view('auth.report.accomplishment.index');
    }

    public function indexTiTo(){
        return view('auth.report.tito.index');
    }

    public function indexMeeting(){
        return view('auth.report.meeting.index');
    }

    public function filterForm(Request $request){
        $data = array(
            'bureauDepartment' => BureauDivision::where('bureau_id', Auth::user()->bureau_id)->get(),
            'bureauUser' => User::where([['bureau_id', Auth::user()->bureau_id],['department_id', null]])->get(),
            'userPerDepartment' => User::where([['department_id', Auth::user()->department_id]])->get(),
            'bureauAdmin' => Bureau::all(),
            'type' => $request->type,
        );

        return view('auth.report.filter.form', compact('data'));
    }

    public function filterSubmit(Request $request){
        $dateFrom = date('Y-m-d', strtotime($request->dateFrom ?? date('Y-m-d'))).' 00:00:00';
        $dateTo = date('Y-m-d', strtotime($request->dateTo ?? date('Y-m-d'))).' 23:59:59';

        $validate = Validator::make($request->all(), [
            'dateFrom' => 'required',
            'dateTo' => 'required',
            'departmentUser' => [
                Rule::requiredIf(Auth::user()->user_type == 'head' && isset(Auth::user()->department_id))
            ],
            'bureauAdmin' => [
                Rule::requiredIf(Auth::user()->user_type == 'admin')
            ],
        ]);

        if($validate->fails()){
            return response()->json([
                'message' => 'error-input',
                'messages' => $validate->messages(),
            ]);
        }

        if($request->filterType == 'tito'){
            return $this->titoFilterSubmit($request);
        }

        if (Auth::user()->user_type == 'head'){
            if (!isset(Auth::user()->department_id)){
                $view = 'auth.report.accomplishment.bureau-content';

                $accomplishments = array(
                    'perDepartment' => Department::whereIn('id', $request->bureauDepartment ?? array())->with(['users.tito' => function($query) use ($dateFrom, $dateTo){
                        $query->wherebetween('created_at', [$dateFrom, $dateTo]);
                    }])->get(),
                    'haveUser' => $request->bureauUsers ?? 'none',
                    'perUserBureau' => User::whereIn('id', $request->bureauUsers ?? array())->with(['tito' => function($query) use ($dateFrom, $dateTo){
                        $query->wherebetween('created_at', [$dateFrom, $dateTo]);
                    }])->get()
                );

            }else{
                $view = 'auth.report.accomplishment.department-content';

                $accomplishments = User::whereIn('id', $request->departmentUser)->with(['tito' => function($query) use ($dateFrom, $dateTo){
                    $query->wherebetween('created_at', [$dateFrom, $dateTo]);
                }])->get();
            }
        }else if(Auth::user()->user_type == 'admin'){
            $view = 'auth.report.accomplishment.admin-content';
            $accomplishments = Bureau::whereIn('id', $request->bureauAdmin)->get();
        }else{
            $view = 'auth.report.accomplishment.user-content';
            $accomplishments = Tito::where('user_id', Auth::id())->wherebetween('created_at', [$dateFrom, $dateTo])->get();
        }

        return response()->json([
            'message' => 'success',
            'content' => view($view, compact(
                'dateFrom', 'dateTo', 'accomplishments'
            ))->render()
        ]);
    }

    public function titoFilterSubmit($request){
        $dateFrom = date('Y-m-d', strtotime($request->dateFrom ?? date('Y-m-d'))).' 00:00:00';
        $dateTo = date('Y-m-d', strtotime($request->dateTo ?? date('Y-m-d'))).' 23:59:59';

        if (Auth::user()->user_type == 'head'){
            if (!isset(Auth::user()->department_id)){
                $view = 'auth.report.tito.bureau-content';

                $tito = array(
                    'perDepartment' => Department::whereIn('id', $request->bureauDepartment ?? array())->with(['users.tito' => function($query) use ($dateFrom, $dateTo){
                        $query->wherebetween('created_at', [$dateFrom, $dateTo]);
                    }])->get(),
                    'haveUser' => $request->bureauUsers ?? 'none',
                    'perUserBureau' => User::whereIn('id', $request->bureauUsers ?? array())->with(['tito' => function($query) use ($dateFrom, $dateTo){
                        $query->wherebetween('created_at', [$dateFrom, $dateTo]);
                    }])->get()
                );
            }else{
                $view = 'auth.report.tito.department-content';

                $tito = User::whereIn('id', $request->departmentUser)->with(['tito' => function($query) use ($dateFrom, $dateTo){
                    $query->wherebetween('created_at', [$dateFrom, $dateTo]);
                }])->get();
            }
        }else if(Auth::user()->user_type == 'admin'){
            $view = 'auth.report.tito.admin-content';
            $tito = Bureau::whereIn('id', $request->bureauAdmin)->get();
        }else{
            $view = 'auth.report.tito.user-content';
            $tito = User::whereId(Auth::id())->with(['tito' => function($query) use ($dateFrom, $dateTo){
                $query->wherebetween('created_at', [$dateFrom, $dateTo]);
            }])->first();
        }

        return response()->json([
            'message' => 'success',
            'content' => view($view, compact(
                'dateFrom', 'dateTo', 'tito'
            ))->render()
        ]);
    }
}
