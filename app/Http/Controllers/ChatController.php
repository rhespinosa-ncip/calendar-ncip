<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\Group;
use App\Models\GroupParticipant;
use App\Models\GroupSeen;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ChatController extends Controller
{
    public function index(Request $request){
        $user = User::where('username', $request->username)->first();
        $group = Group::where('name', explode('-', $request->username)[1] ?? '')->first();

        if(isset($group)){
            $data = array(
                'group' => $group,
                'messageType' => 'group',
                'messages' => Message::withCount('notSeenConversation')->orWhere('to_id', $group->id)->orWhere('from_user_id', Auth::id())->orWhere('to_id', Auth::id())->get(),
                'conversation' => Message::where([['to_id', $group->id],['type', 'group']])->first(),
                'groupMessage' => GroupParticipant::with('message')->where([['user_id', Auth::id()],['status', 'active']])->get(),
            );

            $checker = Group::with(['groupParticipant' => function($query){
                $query->where([['user_id', Auth::id()],['status', 'active']]);
            }])->where('id', $group->id)->first();

            if(isset($checker->groupParticipant[0]) || $checker->created_by == Auth::id()){
                $conversationIds = $data['conversation']->conversation->pluck('id');
                GroupSeen::checker($conversationIds);
                return view('auth.chat.index', compact('data'));
            }


        }else if(isset($user) || $request->username == ''){
            $data = array(
                'userToMessage' => $user,
                'messageType' => 'individual',
                'messages' => Message::withCount('notSeenConversation')->orWhere('from_user_id', Auth::id())->orWhere('to_id', Auth::id())->get(),
                'conversation' => Message::where([['from_user_id', Auth::id()], ['to_id', $user->id ?? '']])->orWhere([['from_user_id',$user->id ?? ''], ['to_id',  Auth::id()]])->first(),
                'groupMessage' => GroupParticipant::with('message')->where([['user_id', Auth::id()],['status', 'active']])->get(),
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
            'groups' => Group::with(['groupParticipant' => function($query){
                $query->where([['user_id', Auth::id()],['status', 'active']]);
            }])->where('name', 'LIKE', $request->data.'%')->get(),
            'search' => $request->data,
            'groupMessage' => GroupParticipant::with('message')->where([['user_id', Auth::id()],['status', 'active']])->get(),
        );

        return view('auth.chat.search',compact('data'));
    }

    public function sendMessage(Request $request){
        return Message::insert($request);
    }

    static function notify($request){
        $data = array(
            'messageType' => '',
            'conversation' => Message::where([['from_user_id', $request->notify_by_id], ['to_id', $request->notify_user]])->orWhere([['from_user_id', $request->notify_user], ['to_id',  $request->notify_by_id]])->first(),
        );

        $append = false;

        $user = User::whereId($request->notify_by_id)->first();

        if(str_replace(url('/'), '', url()->previous()) == '/chat/'.$user->username){
            $append = true;
            $conversation = Conversation::where([['message_id', $data['conversation']->id ?? ''],['sent_by_user_id', '!=', Auth::id()],['is_seen', 'no']])->update(array('is_seen' => 'yes'));
        }

        return response()->json([
            'message' => 'success-message',
            'isAppend' => $append,
            'body' => $request->message,
            'notifCount' => Message::countMessage(),
            'chatBox' => view('auth.chat.chat-box', compact('data'))->render()
        ]);
    }

    static function notifyGroup($request){
        $data = array(
            'messageType' => 'group',
            'conversation' => Message::where([['to_id', $request->groupId],['type', 'group']])->first(),
        );

        $group = Group::whereId($request->groupId)->first();

        $append = false;

        if(urldecode(str_replace(url('/'), '', url()->previous())) == '/chat/group-'.$group->name){
            $append = true;

            $conversationIds = $data['conversation']->conversation->pluck('id');
            GroupSeen::checker($conversationIds);
        }

        return response()->json([
            'message' => 'success-message',
            'isAppend' => $append,
            'messageType' => 'group',
            'body' => $request->message,
            'notifCount' => 0,
            'groupName' => $data['conversation']->groupTo->name,
            'chatBox' => view('auth.chat.chat-box', compact('data'))->render()
        ]);
    }

    public function createGroup(){
        $data = array(
            'users' => User::where('id', '!=', Auth::id())->get()
        );

        return view('auth.chat.group.create', compact('data'));
    }

    public function submitGroup(Request $request){
        return Group::insert($request);
    }

    public function updateGroup(Request $request){
        return Group::updateData($request);
    }

    public function viewSeen(Request $request){
        $groupSeen = GroupSeen::where('conversation_id', $request->chatId)->get();
        return view('auth.chat.seen', compact('groupSeen'));
    }

    public function settingGroup(Request $request){
        $group = Group::whereId($request->groupId)->first();

        if(isset($group)){
            $data = array(
                'group' => $group,
                'users' => User::where(function($query) use ($group){
                    if($group->created_by == Auth::id()){
                        $query->where('id', '!=', Auth::id());
                    }
                })->get()
            );

            if($group->created_by == Auth::id()){
                return view('auth.chat.group.update', compact('data'));
            }
            return view('auth.chat.group.show', compact('data'));
        }
    }
}
