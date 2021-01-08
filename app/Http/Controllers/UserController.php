<?php

namespace App\Http\Controllers;

use App\GlobalClass\Datatables;
use App\Models\Department;
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
                    department.`name` as department_name
                FROM
                    users
                    JOIN department ON users.department_id = department.id
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
                'user' => $user
            );

            return view('auth.user.update', compact('data'));
        }
    }
}
