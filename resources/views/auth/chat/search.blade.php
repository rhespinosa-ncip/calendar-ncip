<div class="list-group rounded-0">
    @if (isset($data['search']))
        @forelse ($data['users'] as $user)
            @php
                $message = App\Models\Message::where([['from_user_id', Auth::id()],['to_id', $user->id]])->first();
            @endphp
            @if (isset($message))
                <a href="/chat/{{$user->username}}" class="list-group-item list-group-item-action list-group-item-light rounded-0">
                    <div class="media">
                        <p class="mt-2 bg" data-letters="{{$user->initial}}"></p>
                        <div class="media-body ml-4">
                            <div class="d-flex align-items-center justify-content-between mb-1">
                                <h6 class="mb-0">{{$user->fullName}}</h6>
                                <small class="small font-weight-bold">
                                    @if (isset($message->lastConversation->created_at))
                                        {{date('d F', strtotime($message->lastConversation->created_at))}}
                                    @endif
                                </small>
                            </div>
                            <p class="font-italic mb-0 text-small">
                                @if (isset($message->lastConversation->body))
                                    {{ \Illuminate\Support\Str::limit($message->lastConversation->body, 150, $end='...') }}
                                @else
                                    Say hi and start messaging
                                @endif</p>
                        </div>
                    </div>
                </a>
            @else
                <a href="/chat/{{$user->username}}" class="list-group-item list-group-item-action list-group-item-light rounded-0">
                    <div class="media">
                        <p class="mt-2 bg" data-letters="{{$user->initial}}"></p>
                        <div class="media-body ml-4">
                            <div class="d-flex align-items-center justify-content-between mb-1">
                                <h6 class="mb-0">{{$user->fullName}}</h6>
                                <small class="small font-weight-bold">
                                    @if (isset($user->lastConversation->created_at))
                                        {{date('d F', strtotime($user->lastConversation->created_at))}}
                                    @endif
                                </small>
                            </div>
                            <p class="font-italic mb-0 text-small">
                                @if (isset($user->lastConversation->body))
                                    {{ \Illuminate\Support\Str::limit($user->lastConversation->body, 150, $end='...') }}
                                @else
                                    Say hi and start messaging
                                @endif</p>
                        </div>
                    </div>
                </a>
            @endif
        @empty
            @php
                $userSearch = true;
            @endphp
        @endforelse

        @forelse ($data['groups'] as $group)
            @if ($group->created_by == Auth::id() || isset($group->groupParticipant[0]))
                @php
                    $groupSearch = false;
                @endphp
                <a href="/chat/group-{{$group->name}}" class="list-group-item list-group-item-action list-group-item-light rounded-0">
                    <div class="media">
                        <p class="mt-2 bg" data-letters="{{$group->initial}}"></p>
                        <div class="media-body ml-4">
                            <div class="d-flex align-items-center justify-content-between mb-1">
                                <h6 class="mb-0">{{$group->name}} -
                                    <span class="setting" groupId="{{$group->id}}">details</span>
                                </h6>
                                <small class="small font-weight-bold">
                                    @if (isset($group->message->updated_at))
                                        {{date('d F', strtotime($group->message->updated_at))}}
                                    @endif
                                </small>
                            </div>
                            <p class="font-italic mb-0 text-small">
                                @if (isset($group->message->lastConversation->body))
                                    {{ \Illuminate\Support\Str::limit($group->message->lastConversation->body, 150, $end='...') }}
                                @else
                                    Say hi and start messaging
                                @endif
                            </p>
                        </div>
                    </div>
                </a>
            @else
                @php
                    $groupSearch = true;
                @endphp
            @endif
        @empty
            @php
                $groupSearch = true;
            @endphp
        @endforelse

        @if (isset($userSearch) && isset($groupSearch))
            @if ($groupSearch == true)
                <div class="row mt-5">
                    <div class="col-12 text-center">
                        <h4>Nothing Found</h4>
                        <p class="p-4">No matches were found for "{{$data['search']}}". Try checking for typos or using complete words.</p>
                    </div>
                </div>
            @endif
        @endif
    @else
        @forelse ($data['messages'] as $message)
            @php
                if($message->type == 'individual'){
                    $individual = 'individualFrom';
                    if($message->individualTo->id != Auth::id()){
                        $individual = 'individualTo';
                    }
                    $initial =  $message->$individual->initial;
                    $name = $message->$individual->fullName;
                    $username = $message->$individual->username;
                }else if($message->type == 'group'){
                    $initial =  $message->groupTo->initial;
                    $name = $message->groupTo->name;
                    $username = 'group-'.$message->groupTo->name;
                }
            @endphp
            <a href="/chat/{{$username}}" class="list-group-item list-group-item-action list-group-item-light rounded-0">
                <div class="media">
                    <p class="mt-2 bg" data-color="#bf3f3f" data-letters="{{$initial ?? 'NA'}}"></p>
                    <div class="media-body ml-4">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h6 class="mb-0">{{$name ?? 'NA'}}
                                @if ($message->type == 'group')
                                -
                                <span class="setting" groupId="{{$message->groupTo->id}}">
                                    details
                                </span>
                                @endif
                            </h6><small class="small font-weight-bold">{{isset($message->lastConversation->created_at) ? date('d F', strtotime($message->lastConversation->created_at)) : ''}}</small>
                        </div>
                        <p class="font-italic text-muted mb-0 text-small">{{ \Illuminate\Support\Str::limit($message->lastConversation->body ?? 'No conversation yet', 150, $end='...') }}</p>
                    </div>
                </div>
            </a>
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
                        @if ($groupMessage->message->not_seen_conversation_count != 0 && Request::segment(2) != $username)
                            <span class="badge badge-pill badge-info notif-count" style="float:right;margin-bottom:-10px;">{{$groupMessage->message->not_seen_conversation_count}}</span>
                        @endif
                        <p class="font-italic {{Request::segment(2) == $username ? '' : 'text-muted'}} mb-0 text-small">{{ \Illuminate\Support\Str::limit($groupMessage->message->lastConversation->body ?? 'No conversation yet', 50, $end='...') }}</p>
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
    @endif
</div>
