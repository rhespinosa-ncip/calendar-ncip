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
            <div class="row mt-5">
                <div class="col-12 text-center">
                    <h4>Nothing Found</h4>
                    <p class="p-4">No matches were found for "{{$data['search']}}". Try checking for typos or using complete words.</p>
                </div>
            </div>
        @endforelse
    @else
        @forelse ($data['messages'] as $message)
            @php
                if($message->type == 'individual'){
                    $initial =  $message->individual->initial;
                    $name = $message->individual->fullName;
                    $username = $message->individual->username;
                }
            @endphp
            <a href="/chat/{{$username}}" class="list-group-item list-group-item-action list-group-item-light rounded-0">
                <div class="media">
                    <p class="mt-2 bg" data-color="#bf3f3f" data-letters="{{$initial ?? 'NA'}}"></p>
                    <div class="media-body ml-4">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h6 class="mb-0">{{$name ?? 'NA'}}</h6><small class="small font-weight-bold">{{date('d F', strtotime($message->lastConversation->created_at))}}</small>
                        </div>
                        <p class="font-italic text-muted mb-0 text-small">{{ \Illuminate\Support\Str::limit($message->lastConversation->body, 150, $end='...') }}</p>
                    </div>
                </div>
            </a>
        @empty
            <div class="row mt-5">
                <div class="col-12 text-center">
                    <h4>Your contact list is empty</h4>
                </div>
            </div>
        @endforelse
    @endif
</div>
