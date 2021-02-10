<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ChatController extends Controller
{
    public function index(Request $request){
        $user = User::where('username', $request->username)->first();

        if(isset($user) || $request->username == ''){
            $data = array(
                'userToMessage' => $user,
                'messages' => Message::withCount('notSeenConversation')->orWhere('from_user_id', Auth::id())->orWhere('to_id', Auth::id())->get(),
                'conversation' => Message::where([['from_user_id', Auth::id()], ['to_id', $user->id ?? '']])->orWhere([['from_user_id',$user->id ?? ''], ['to_id',  Auth::id()]])->first(),
            );

            if(isset($user)){
                $conversation = Conversation::where([['message_id', $data['conversation']->id ?? ''],['sent_by_user_id', '!=', Auth::id()],['is_seen', 'no']])->update(array('is_seen' => 'yes'));
            }

            return view('auth.chat.index', compact('data'));
        }

        return view('not-found');
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

    public function sendMessage(Request $request){
        return Message::insert($request);
    }

    static function notify($request){
        $data = array(
            'conversation' => Message::where([['from_user_id', $request->notify_by_id], ['to_id', $request->notify_user]])->orWhere([['from_user_id', $request->notify_user], ['to_id',  $request->notify_by_id]])->first(),
        );

        return response()->json([
            'message' => 'success-message',
            'body' => $request->message,
            'notifCount' => Message::countMessage(),
            'chatBox' => view('auth.chat.chat-box', compact('data'))->render()
        ]);
    }
}
