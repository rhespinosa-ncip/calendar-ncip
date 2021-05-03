<?php

namespace App\Http\Controllers;

use App\Events\NotificationProcessed;
use App\Mail\ForgotPassword;
use App\Models\Group;
use App\Models\Message;
use App\Models\Notification;
use App\Models\PasswordReset;
use App\Models\ReadNotification;
use App\Models\Signatory;
use App\Models\Tito;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
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
                if(strtotime($userTito->time_in) > strtotime("-30 minutes")){

                }else{
                    // $userTito->time_out =  date('H:i:s');
                    // $userTito->save();
                }

                return view('guest.success-tito', [
                    'tito' => 'OUT',
                    'user' => $user
                ]);
            }

            // Tito::create([
            //     'time_in' => date('H:i:s'),
            //     'user_id' => $user->id
            // ]);
                // return view('guest.default-tito');
            return view('guest.success-tito', [
                'tito' => 'IN',
                'user' => $user
            ]);
        }

        return response()->json([
            'message' => 'error'
        ]);
    }

    public function forgotPassword(){
        return view('guest.forgot-password');
    }

    public function forgotPasswordSubmit(Request $request){
        $email = $request->email;

        $user = User::where('email', $email)->first();

        if(isset($user)){
            $passwordReset = PasswordReset::insert($request);

            Mail::to($user->email)->send(new ForgotPassword($user->email, $passwordReset, $user));

            return response()->json([
                'message' => 'success'
            ]);
        }

        return response()->json([
            'message' => 'error'
        ]);
    }

    public function resetPassword(Request $request){
        Auth::logout();

        if(!Auth::check()){
            $token = $request->token;
            $email = $request->email;

            if(PasswordReset::checker($email, $token) == true){
                return view('guest.password-change', compact('email','token'));
            }
        }
    }

    public function resetPasswordSubmit(Request $request){
        Auth::logout();

        if(PasswordReset::checker($request->email, $request->token) == true){
            $validate = Validator::make($request->all(),[
                'password' => [
                    'required',
                    'min:6',
                ]
            ]);

            if($validate->fails()){
                return response()->json([
                    'message' => 'error-input',
                    'messages' => $validate->messages()
                ]);
            }

            $user = User::where('email', $request->email)->first();
            $user->password = Hash::make($request->password);
            $user->save();

            PasswordReset::where([['email',$request->email]])->delete();

            return response()->json([
                'message' => 'success',
            ]);
        }else{
            return response()->json([
                'message' => 'error'
            ]);
        }
    }

    public function showNotification(){
        $notifications = Notification::where(function($query){
            $query->orWhere([['personnel','bureau'],['personnel_id', Auth::user()->bureau_id]])
            ->orWhere([['personnel','department'],['personnel_id', Auth::user()->department_id]])
            ->orWhere([['personnel','individual'],['personnel_id', Auth::id()]]);
        })->get('id');

        $readNotifications = ReadNotification::where('user_id', Auth::id())->whereIn('notification_id', $notifications)->get('notification_id');

        $notReadNotifications = Notification::where(function($query){
            $query->orWhere([['personnel','bureau'],['personnel_id', Auth::user()->bureau_id]])
            ->orWhere([['personnel','department'],['personnel_id', Auth::user()->department_id]])
            ->orWhere([['personnel','individual'],['personnel_id', Auth::id()]]);
        })->whereNotIn('id', $readNotifications)->orderBy('created_at', 'asc')->get();


        return view('auth.notification.show', compact('readNotifications', 'notReadNotifications'));
    }

    public function notificationIndex(){
        $notifications = Notification::where(function($query){
            $query->orWhere([['personnel','bureau'],['personnel_id', Auth::user()->bureau_id]])
            ->orWhere([['personnel','department'],['personnel_id', Auth::user()->department_id]])
            ->orWhere([['personnel','individual'],['personnel_id', Auth::id()]]);
        })->orderBy('created_at', 'asc')->get();

        return view('auth.notification.index', compact('notifications'));
    }

    public function validateNotify(Request $request){
        if($request->type == 'message'){
            if(Auth::id() == $request->notify_user){
                return ChatController::notify($request);
            }
        }else if($request->type == 'groupMessage'){
            if(Auth::id() == $request->notify_user){
                return ChatController::notifyGroup($request);
            }
        }

        if(($request->personnel == 'bureau' && Auth::user()->bureau_id == $request->personnel_id)
        || ($request->personnel == 'department' && Auth::user()->department_id == $request->personnel_id)
        || ($request->personnel == 'individual' && Auth::id() == $request->personnel_id)){

            return response()->json([
                'message' => 'success',
                'notifCount' => Notification::countNotification()
            ]);
        }
    }

    public function mySignatory(Request $request){
        $signatory = Signatory::where('user_id', Auth::id())->first();
        return view('auth.user.signatory.form', compact('signatory'));
    }

    public function mySignatorySubmit(Request $request){
        return Signatory::updateData($request);
    }
}
