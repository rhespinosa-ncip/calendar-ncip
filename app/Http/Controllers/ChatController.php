<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function index(Request $request){
        $user = User::where('username', $request->username)->first();

        $data = array(
            'messages' => Message::orWhere('from_user_id', Auth::id())->orWhere('to_id',Auth::id())->get(),
            'conversation' => Message::where([['from_user_id', Auth::id()], ['to_id', $user->id ?? '']])->orWhere([['from_user_id',$user->id ?? ''], ['to_id',  Auth::id()]])->first(),
        );

        return view('auth.chat.index', compact('data'));
    }

    public function showMyMessage(){

    }

    public function searchUserGroup(Request $request){
        $data = array(
            'messages' => Message::orWhere('from_user_id', Auth::id())->orWhere('to_id', Auth::id())->get(),
            'users' => User::orWhere('first_name', 'LIKE', $request->data.'%')
                        ->orWhere('middle_name', 'LIKE', $request->data.'%')
                        ->orWhere('last_name', 'LIKE', $request->data.'%')
                        ->orWhere('username', 'LIKE', $request->data.'%')
                        ->select('users.id', 'first_name', 'middle_name', 'last_name', 'username')->get(),
            'search' => $request->data
        );

        return view('auth.chat.search',compact('data'));

    }
}
