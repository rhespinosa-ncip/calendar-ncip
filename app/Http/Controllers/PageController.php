<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;

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

    public function showDocuments(Request $request){
        $path = storage_path('app/public/' . $request->username.'/'.$request->fileName);

        if (!File::exists($path)) {
            return $path;
        }

        $file = File::get($path);
        $type = File::mimeType($path);

        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);

        return $response;
    }

    public function passwordForm(Request $request){
        return view('auth.user.password.form');
    }

    public function passwordSubmit(Request $request){
        if(Hash::check($request->oldPassword, Auth::user()->password)){
            if(!isset($request->newPassword)){
                return response()->json([
                    'message' => 'provideNewPassword'
                ]);
            }

            $user = Auth::user();
            $user->password = Hash::make($request->newPassword);
            $user->save();

            return response()->json([
                'message' => 'success'
            ]);
        }

        return response()->json([
            'message' => 'wrongOldPassword'
        ]);
    }
}
