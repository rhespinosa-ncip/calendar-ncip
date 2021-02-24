@forelse ($data['messages'] as $message)
    @php
        if($message->type == 'individual'){
            if ($message->to_id == Auth::id()) {
                $initial =  $message->individualFrom->initial;
                $name = $message->individualFrom->fullName;
                $username = $message->individualFrom->username;
            }else{
                $initial =  $message->individualTo->initial;
                $name = $message->individualTo->fullName;
                $username = $message->individualTo->username;
            }
        }else if($message->type == 'group'){
            $initial =  $message->groupTo->initial;
            $name = $message->groupTo->name;
            $username = 'group-'.$message->groupTo->name;
        }
    @endphp
    @if ($message->not_seen_conversation_count != 0 && $message->type != 'group')
        {!! Request::segment(2) == $username ? '<a class="list-group-item list-group-item-action active text-white rounded-0">' :
        '<a href="/chat/'.$username.'" class="list-group-item list-group-item-action list-group-item-light rounded-0">' !!}
            <div class="media">
                <p class="mt-2 bg" data-color="#bf3f3f" data-letters="{{$initial ?? 'NA'}}"></p><!-- or whatever structure you used -->
                <div class="media-body ml-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h6 class="mb-0">{{$name ?? 'NA'}}</h6>
                        <small class="small font-weight-bold">{{isset($message->lastConversation->created_at) ? date('d F', strtotime($message->lastConversation->created_at)) : ''}}</small>
                    </div>
                    @if ($message->not_seen_conversation_count != 0 && Request::segment(2) != $username)
                        <span class="badge badge-pill badge-info notif-count" style="float:right;margin-bottom:-10px;">{{$message->not_seen_conversation_count}}</span>
                    @endif
                    <p class="font-italic {{Request::segment(2) == $username ? '' : 'text-muted'}} mb-0 text-small">{{ \Illuminate\Support\Str::limit($message->lastConversation->body, 50, $end='...') }}</p>
                </div>
            </div>
        </a>
    @endif
    @if ($message->type == 'group' && $message->groupTo->created_by == Auth::id())
    {!! Request::segment(2) == $username ? '<a class="list-group-item list-group-item-action active text-white rounded-0">' :
        '<a href="/chat/'.$username.'" class="list-group-item list-group-item-action list-group-item-light rounded-0">' !!}
            <div class="media">
                <p class="mt-2 bg" data-color="#3490dc" data-letters="{{$initial ?? 'NA'}}"></p><!-- or whatever structure you used -->
                <div class="media-body ml-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h6 class="mb-0">{{$name ?? 'NA'}} -
                            <span class="setting" groupId="{{$message->groupTo->id}}">
                                details
                            </span>
                        </h6>
                        <small class="small font-weight-bold">{{isset($message->lastConversation->created_at) ? date('d F', strtotime($message->lastConversation->created_at)) : ''}}</small>
                    </div>
                    @php
                        $groupMessageCount = App\Models\Message::groupMessageCount($message->id);
                    @endphp
                    @if ($groupMessageCount != 0)
                        <span class="badge badge-pill badge-info notif-count" style="float:right;margin-bottom:-10px;">{{$groupMessageCount}}</span>
                    @endif
                    <p class="font-italic {{Request::segment(2) == $username ? '' : 'text-muted'}} mb-0 text-small">{{ucfirst($message->lastConversation->user->first_name)}}: {{isset($message->lastConversation->body) ? \Illuminate\Support\Str::limit($message->lastConversation->body, 50, $end='...') : 'No conversation yet' }}</p>
                </div>
            </div>
        </a>
    @endif
@empty

@endforelse

@forelse ($data['messages'] as $message)
    @php
        if($message->type == 'individual'){
            if ($message->to_id == Auth::id()) {
                $initial =  $message->individualFrom->initial;
                $name = $message->individualFrom->fullName;
                $username = $message->individualFrom->username;
            }else{
                $initial =  $message->individualTo->initial;
                $name = $message->individualTo->fullName;
                $username = $message->individualTo->username;
            }
        }else if($message->type == 'group'){
            $initial =  $message->groupTo->initial;
            $name = $message->groupTo->name;
            $username = 'group-'.$message->groupTo->name;
        }
    @endphp
    @if ($message->not_seen_conversation_count == 0  && $message->type != 'group')
        {!! Request::segment(2) == $username ? '<a class="list-group-item list-group-item-action active text-white rounded-0">' :
        '<a href="/chat/'.$username.'" class="list-group-item list-group-item-action list-group-item-light rounded-0">' !!}
            <div class="media">
                <p class="mt-2 bg" data-color="#bf3f3f" data-letters="{{$initial ?? 'NA'}}"></p><!-- or whatever structure you used -->
                <div class="media-body ml-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h6 class="mb-0">{{$name ?? 'NA'}} </h6>
                        <small class="small font-weight-bold">{{isset($message->lastConversation->created_at) ? date('d F', strtotime($message->lastConversation->created_at)) : ''}}</small>
                    </div>
                    <p class="font-italic {{Request::segment(2) == $username ? '' : 'text-muted'}} mb-0 text-small">{{isset($message->lastConversation->body) ? \Illuminate\Support\Str::limit($message->lastConversation->body, 50, $end='...') : 'No conversation yet' }}</p>
                </div>
            </div>
        </a>
    @endif
@empty
    @php
        $chatPeople = true;
    @endphp
@endforelse

@forelse ($data['groupMessage'] as $groupMessage)
    @php
        if($groupMessage->message->type == 'group'){
            $initial =  $groupMessage->message->groupTo->initial;
            $name = $groupMessage->message->groupTo->name;
            $username = 'group-'.$groupMessage->message->groupTo->name;
        }
    @endphp
    {!! Request::segment(2) == $username ? '<a class="list-group-item list-group-item-action active text-white rounded-0">' :
    '<a href="/chat/'.$username.'" class="list-group-item list-group-item-action list-group-item-light rounded-0">' !!}
        <div class="media">
            <p class="mt-2 bg" data-color="#3490dc" data-letters="{{$initial ?? 'NA'}}"></p><!-- or whatever structure you used -->
            <div class="media-body ml-4">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h6 class="mb-0">{{$name ?? 'NA'}}  -
                        <span class="setting" groupId="{{$groupMessage->message->groupTo->id}}">
                            details
                        </span>
                    </h6>
                    <small class="small font-weight-bold">{{isset($groupMessage->message->lastConversation->created_at) ? date('d F', strtotime($groupMessage->message->lastConversation->created_at)) : ''}}</small>
                </div>
                @php
                    $groupMessageCount = App\Models\Message::groupMessageCount($groupMessage->message->id);
                @endphp
                @if ($groupMessageCount != 0)
                    <span class="badge badge-pill badge-info notif-count" style="float:right;margin-bottom:-10px;">{{$groupMessageCount}}</span>
                @endif
                <p class="font-italic {{Request::segment(2) == $username ? '' : 'text-muted'}} mb-0 text-small">{{ucfirst($message->lastConversation->user->first_name)}}: {{ \Illuminate\Support\Str::limit($groupMessage->message->lastConversation->body ?? 'No conversation yet', 50, $end='...') }}</p>
            </div>
        </div>
    </a>
@empty
    @php
        $chatGroup = true;
    @endphp
@endforelse

@if (isset($chatGroup) && isset($chatPeople))
    <div class="row mt-5">
        <div class="col-12 text-center">
            <h4>Your contact list is empty</h4>
        </div>
    </div>
@endif
