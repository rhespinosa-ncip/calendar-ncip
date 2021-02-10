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
            if(isset($message->notSeenConversation[0])){
                $count++;
            }
        }

        return $count;
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

        if(!isset($message)){
            $message = self::insertData($request, 'individual');
        }

        Conversation::insert($message->id, $request->message ?? 'file-upload', $request);

        $data = array(
            'conversation' => Message::where([['from_user_id', Auth::id()], ['to_id', $request->toMessage]])->orWhere([['from_user_id', $request->toMessage], ['to_id',  Auth::id()]])->first(),
        );

        event(new NotificationProcessed(array(
            'type' => 'message',
            'message' => $request->message,
            'notify_user' => $request->toMessage,
            'notify_by_id' => Auth::id(),
            'notify_by' => Auth::user()->fullName
        )));

        return response()->json([
            'message' => 'success',
            'chatBox' => view('auth.chat.chat-box', compact('data'))->render()
        ]);
    }
}
