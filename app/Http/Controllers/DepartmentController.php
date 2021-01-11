<?php

namespace App\Http\Controllers;

use App\GlobalClass\Datatables;
use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function index(){
        return view('auth.department.index');
    }

    public function indexList(Request $request){
        $query = 'SELECT * FROM department where id != 1';

        return Datatables::of($query)
            ->addAction('action', function($result){
                return '<button class="btn btn-info  py-1 px-2 rounded-0 btn-update-department" departmentId="'.$result->id.'" data-toggle="tooltip" title="Update department"><i class="fas fa-edit"></i></button>';
            })->addAction('department_color', function($result){
                return '<span class="badge badge-pill" style="background-color: '.$result->hexa_color.'!important;">&nbsp</span>';
            })
            ->searchable(['name'])
            ->request($request)
            ->make();
    }

    public function addDepartmentForm(){
        return view('auth.department.add');
    }

    public function updateUserForm(Request $request){
        $department = Department::find($request->departmentId);

        if(isset($department)){
            $data = array(
                'department' => $department,
            );

            return view('auth.department.update', compact('data'));
        }
    }

    public function addDepartmentSubmit(Request $request){
        if(isset($request->departmentStatus) && $request->departmentStatus == 'update'){
            return Department::updateData($request);
        }
        return Department::insert($request);
    }
}
