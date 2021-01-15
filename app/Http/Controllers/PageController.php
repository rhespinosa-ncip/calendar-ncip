<?php

namespace App\Http\Controllers;

use App\Models\Tito;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Milon\Barcode\Facades\DNS2DFacade as DNS2D;
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

    public function barcode(){
        Storage::disk('public')->put('test.png',base64_decode(DNS2D::getBarcodePNG("4", "QRCODE")));
    }

    public function myQrCode(Request $request){
        return view('auth.user.qr-code.view');
    }

    public function downloadMyQrCode(Request $request){
        $url = $request->root();
        $param ='/auto-time/tito?username='.Auth::user()->username.'&password='.Auth::user()->password;

        Storage::disk('public')->put('qr-codes/'.Auth::user()->username.'.png',base64_decode(DNS2D::getBarcodePNG($url.$param, "QRCODE")));

        $path = storage_path('app/public/qr-codes/' .Auth::user()->username.'.png');

        return Response::download($path);
    }

    public function autoTito(Request $request){
        $username = $request->username;
        $password = $request->password;

        $user = User::where('username', $username)->first();

        if(isset($user)){
            $userTito = Tito::where('user_id', $user->id)->whereDate('created_at', date('Y-m-d'))->first();

            if(isset($userTito)){
                $userTito->time_out =  date('H:i:s');
                $userTito->save();

                return response()->json([
                    'message' => 'success'
                ]);
            }

            Tito::create([
                'time_in' => date('H:i:s'),
                'user_id' => $user->id
            ]);

            return response()->json([
                'message' => 'success'
            ]);
        }

        return response()->json([
            'message' => 'error'
        ]);
    }
}
