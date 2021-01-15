<?php

namespace App\Http\Controllers;

use App\GlobalClass\Datatables;
use App\Models\Bureau;
use App\Models\BureauDivision;
use App\Models\Department;
use App\Models\Tito;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index(){
        return view('auth.user.index');
    }

    public function indexList(Request $request){
        $query = 'SELECT
                    users.id,
                    users.username,
                    users.first_name,
                    users.middle_name,
                    users.last_name,
                    department.`name` as department_name,
                    bureau.`name` as bureau_name
                FROM
                    users
                    LEFT JOIN department ON users.department_id = department.id
                    JOIN bureau ON users.bureau_id = bureau.id
                    where users.id != '.Auth::id().'';

        return Datatables::of($query)
            ->addAction('action', function($result){
                return '<button class="btn btn-info  py-1 px-2 rounded-0 btn-update-user" userId="'.$result->id.'" data-toggle="tooltip" title="Update user"><i class="fas fa-edit"></i></button>';
            })
            ->addAction('full_name', function($result){
                return $result->first_name.' '.$result->middle_name.' '.$result->last_name;
            })
            ->searchable(['username','first_name','middle_name','last_name','department.`name`'])
            ->request($request)
            ->make();
    }

    public function addUserForm(){
        $data = array(
            'bureaus' => Bureau::all(),
            'departments' => Department::where('id', '!=', '1')->get(),
        );

        return view('auth.user.add', compact('data'));
    }

    public function addUserSubmit(Request $request){
        if(isset($request->userStatus) && $request->userStatus == 'update'){
            return User::updateData($request);
        }
        return User::insert($request);
    }

    public function updateUserForm(Request $request){
        $user = User::find($request->userId);

        if(isset($user)){
            $data = array(
                'departments' => Department::where('id', '!=', '1')->get(),
                'bureaus' => Bureau::all(),
                'user' => $user
            );

            return response()->json([
                'view' => view('auth.user.update', compact('data'))->render(),
                'bureauId' => $user->department_id
            ]);
        }
    }

    public function timeUser(Request $request){

        $timeIn = Tito::where('user_id', Auth::id())
                    ->whereDate('created_at', date('Y-m-d'))->first();

        if(!isset($timeIn)){
            Tito::insertTimeIn();
        }else{
            if($request->tito == 'timeOut'){
                Tito::updateTimeOut();
            }
        }

        return response()->json([
            'message' => 'success',
        ]);
    }

    public function getDivisions(Request $request){
        $bureau = Bureau::find($request->bureauId);

        if(isset($bureau)){
            $bureauDivisions = BureauDivision::with('department')->where('bureau_id', $bureau->id)->get();

            return response()->json([
                'divisions' => $bureauDivisions
            ]);
        }
    }
}
