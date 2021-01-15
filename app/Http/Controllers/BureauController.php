<?php

namespace App\Http\Controllers;

use App\GlobalClass\Datatables;
use App\Models\Bureau;
use App\Models\BureauDivision;
use App\Models\Department;
use Illuminate\Http\Request;

class BureauController extends Controller
{
    public function index(){
        return view('auth.bureau.index');
    }

    public function indexList(Request $request){
        $query = 'SELECT * FROM bureau';

        return Datatables::of($query)
            ->addAction('action', function($result){
                return '<button class="btn btn-info  py-1 px-2 rounded-0 btn-update-bureau" bureauId="'.$result->id.'" data-toggle="tooltip" title="Update Bureau"><i class="fas fa-edit"></i></button>';
            })->addAction('bureau_color', function($result){
                return '<span class="badge badge-pill" style="background-color: '.$result->hexa_color.'!important;">&nbsp</span>';
            })
            ->searchable(['name'])
            ->request($request)
            ->make();
    }

    public function addForm(){
        $bureauDepartment = BureauDivision::get('department_id');

        $data = array(
            'department' => Department::where('id','!=','1')->whereNotIn('id', $bureauDepartment)->get()
        );

        return view('auth.bureau.add', compact('data'));
    }

    public function addSubmit(Request $request){
        if(isset($request->bureauStatus) && $request->bureauStatus == 'update'){
            return Bureau::updateData($request);
        }
        return Bureau::insert($request);
    }

    public function updateForm(Request $request){
        $bureau = Bureau::find($request->bureauId);

        if(isset($bureau)){
            $bureauDepartment = BureauDivision::get('department_id');

            $data = array(
                'bureau' => $bureau,
                'department' => Department::where('id','!=','1')->whereNotIn('id', $bureauDepartment)->get(),
                'bureauDepartment' => Department::whereIn('id', BureauDivision::where('bureau_id', $request->bureauId)->get('department_id'))->get(),
            );

            return view('auth.bureau.update', compact('data'));
        }
    }
}
