<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class PageController extends Controller
{
    public function index(Request $request){
        if(Auth::check()){
            return MeetingController::index();
        }

        return view('guest.login');
    }

    public function login(Request $request){
        $validate = Validator::make($request->all(),[
            'username' => 'required',
            'password' => 'required'
        ]);

        if($validate->fails()){
            return response()->json([
                'message' => 'error-input',
                'messages' => $validate->messages(),
            ]);
        }

        $user = User::where('username', $request->username)->first();

        if(isset($user)){
            if(Hash::check($request->password, $user->password)){
                Auth::login($user);

                return response()->json([
                    'message' => 'success',
                ]);
            }
        }

        return response()->json([
            'message' => 'no-credential',
        ]);
    }
}
