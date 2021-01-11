<?php

namespace App\Http\Controllers;

use App\GlobalClass\Datatables;
use App\Models\Accomplishment;
use App\Models\Tito;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccomplishmentController extends Controller
{
    public function index(){
        return view('auth.accomplishment.index');
    }

    public function indexList(Request $request){
        $query = 'SELECT * FROM tito where user_id = '.Auth::id().'';

        return Datatables::of($query)
                ->addAction('action', function($result){
                    if(date("Y-m-d", strtotime($result->created_at)) < date("Y-m-d")){
                        return '<button class="btn btn-success rounded-0 py-1 px-3 btn-view-accomplishment" titoId="'.$result->id.'">VIEW ACCOMPLISHMENT</button>';
                    }

                    return '<button class="btn btn-success rounded-0 py-1 px-3 btn-add-accomplishment" titoId="'.$result->id.'">ADD ACCOMPLISHMENT</button>';
                })->addAction('time_in', function($result){
                    return date('h:i A', strtotime($result->time_in));
                })->addAction('time_out', function($result){
                    if(isset($result->time_out)){
                        return date('h:i A', strtotime($result->time_out));
                    }
                    return 'NO TIME OUT';
                })->addAction('created_at', function($result){
                    return date('F d, Y', strtotime($result->created_at));
                })
                ->request($request)
                ->orderBy('ORDER BY created_at DESC')
                ->make();
    }

    public function formAccomplishment(Request $request){
        $data = array(
            'titoId' => $request->titoId,
            'tito' => Tito::find($request->titoId),
        );

        if($request->titoStatus == 'add'){
            return view('auth.accomplishment.form', compact('data'));
        }else if($request->titoStatus == 'view'){
            return view('auth.accomplishment.show', compact('data'));
        }
    }

    public function submitAccomplishment(Request $request){
        $accomplishment =  Accomplishment::where('tito_id', $request->titoId)->first();

        if(isset($accomplishment)){
            return Accomplishment::updateData($request);
        }else{
            return Accomplishment::insert($request);
        }
    }
}
