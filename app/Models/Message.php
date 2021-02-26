<?php

namespace App\Models;

use App\Events\NotificationProcessed;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class Message extends Model
{
    use HasFactory;
    protected $table = 'message';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'from_user_id',
        'type',
        'to_id',
    ];

    public function conversation(){
        return $this->hasMany(Conversation::class, 'message_id', 'id');
    }

    public function notSeenConversation(){
        return $this->hasMany(Conversation::class, 'message_id', 'id')->where([['is_seen', 'no'],['sent_by_user_id', '!=', Auth::id()]]);
    }

    public function lastConversation(){
        return $this->hasOne(Conversation::class, 'message_id', 'id')->orderBy('id', 'desc');
    }

    public function groupTo(){
        return $this->hasOne(Group::class, 'id', 'to_id');
    }

    public function individualTo(){
        return $this->hasOne(User::class, 'id', 'to_id');
    }

    public function individualFrom(){
        return $this->hasOne(User::class, 'id', 'from_user_id');
    }

    static function countMessage(){
        $messages = Message::orWhere('from_user_id', Auth::id())->orWhere('to_id', Auth::id())->with('notSeenConversation')->get();
        $count = 0;

        foreach($messages as $message){
            if(isset($message->notSeenConversation[0]) && $message->type == 'individual'){
                $count++;
            }
        }

        $groupParticipant = GroupParticipant::where([['user_id', Auth::id()],['status', 'active']])->get();

        foreach($groupParticipant as $gP){
            $messageGroup = Message::where([['to_id', $gP->group_id],['type', 'group']])->first();
            $conversations = Conversation::where([['message_id', $messageGroup->id],['sent_by_user_id', '!=', Auth::id()]])->get();
            $groupSeen = GroupSeen::whereIn('conversation_id', $conversations->pluck('id'))->where('user_id', Auth::id())->get();

            count($conversations) == count($groupSeen) ? '' : $count++;
        }

        $messageGroupCreated = Message::where([['from_user_id', Auth::id()],['type', 'group']])->get();
        $createdGroupConversation = Conversation::whereIn('message_id', $messageGroupCreated->pluck('id'))->where('sent_by_user_id', '!=', Auth::id())->get();
        $createGroupSeen = GroupSeen::whereIn('conversation_id', $createdGroupConversation->pluck('id'))->where('user_id', Auth::id())->get();

        count($createdGroupConversation) == count($createGroupSeen) ? '' : $count++;

        return $count;
    }

    static function groupMessageCount($messageId){
        $conversation = Conversation::where('message_id', $messageId)->get();
        $groupSeen = GroupSeen::whereIn('conversation_id', $conversation->pluck('id'))->where('user_id', Auth::id())->get();

        return count($conversation) - count($groupSeen);
    }

    static function insertData($request, $type){
        return Message::create([
            'from_user_id' => Auth::id(),
            'type' => $type,
            'to_id' => $request->toMessage,
        ]);
    }

    static function insert($request){
        $validate = Validator::make($request->all(), [
            'message' => [
                Rule::requiredIf($request->hasFile('file') != 1)
            ],
        ]);

        if($validate->fails()){
            return response()->json([
                'message' => 'error',
            ]);
        }

        $message = Message::orWhere([['from_user_id', Auth::id()],['to_id', $request->toMessage]])
                            ->orWhere([['to_id', Auth::id()],['from_user_id', $request->toMessage]])->first();

        if($request->toMessageGroup == 'yes'){
            $message = Message::where('to_id', $request->toMessage)->first();
        }

        if(!isset($message)){
            $message = self::insertData($request, 'individual');
        }

        $message->updated_at = now();
        $message->save();

        Conversation::insert($message->id, $request->message ?? 'file-upload', $request);

        if($request->toMessageGroup == 'yes'){
            $data = array(
                'messageType' => 'group',
                'conversation' => Message::where([['to_id', $request->toMessage],['type', 'group']])->first(),
            );

            $group = Group::whereId($request->toMessage)->first();

            foreach($group->groupParticipant as $groupParticipant){
                if($groupParticipant->user_id != Auth::id()){
                    event(new NotificationProcessed(array(
                        'type' => 'groupMessage',
                        'groupId' => $request->toMessage,
                        'message' => $request->message,
                        'notify_user' => $groupParticipant->user_id,
                        'notify_by_id' => Auth::id(),
                        'notify_by' => Auth::user()->fullName
                    )));
                }
            }

            $conversationIds = $data['conversation']->conversation->pluck('id');
            GroupSeen::checker($conversationIds);

            if(Auth::id() != $group->created_by){
                event(new NotificationProcessed(array(
                    'type' => 'groupMessage',
                    'groupId' => $request->toMessage,
                    'message' => $request->message,
                    'notify_user' => $group->created_by,
                    'notify_by_id' => Auth::id(),
                    'notify_by' => Auth::user()->fullName
                )));
            }
        }else{
            $data = array(
                'messageType' => '',
                'conversation' => Message::where([['from_user_id', Auth::id()], ['to_id', $request->toMessage]])->orWhere([['from_user_id', $request->toMessage], ['to_id',  Auth::id()]])->first(),
            );

            $conversation = Conversation::where([['message_id', $data['conversation']->id ?? ''],['sent_by_user_id', '!=', Auth::id()],['is_seen', 'no']])->update(array('is_seen' => 'yes'));

            event(new NotificationProcessed(array(
                'type' => 'message',
                'message' => $request->message,
                'notify_user' => $request->toMessage,
                'notify_by_id' => Auth::id(),
                'notify_by' => Auth::user()->fullName
            )));
        }

        return response()->json([
            'message' => 'success',
            'chatBox' => view('auth.chat.chat-box', compact('data'))->render()
        ]);
    }
}
