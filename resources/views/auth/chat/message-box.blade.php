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
        }
    @endphp
    @if ($message->not_seen_conversation_count != 0)
        {!! Request::segment(2) == $username ? '<a class="list-group-item list-group-item-action active text-white rounded-0">' :
        '<a href="/chat/'.$username.'" class="list-group-item list-group-item-action list-group-item-light rounded-0">' !!}
            <div class="media">
                <p class="mt-2 bg" data-color="#bf3f3f" data-letters="{{$initial ?? 'NA'}}"></p><!-- or whatever structure you used -->
                <div class="media-body ml-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h6 class="mb-0">{{$name ?? 'NA'}} </h6>
                        <small class="small font-weight-bold">{{date('d F', strtotime($message->lastConversation->created_at))}}</small>
                    </div>
                    @if ($message->not_seen_conversation_count != 0 && Request::segment(2) != $username)
                        <span class="badge badge-pill badge-info notif-count" style="float:right;margin-bottom:-10px;">{{$message->not_seen_conversation_count}}</span>
                    @endif
                    <p class="font-italic {{Request::segment(2) == $username ? '' : 'text-muted'}} mb-0 text-small">{{ \Illuminate\Support\Str::limit($message->lastConversation->body, 50, $end='...') }}</p>
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
        }
    @endphp
    @if ($message->not_seen_conversation_count == 0)
        {!! Request::segment(2) == $username ? '<a class="list-group-item list-group-item-action active text-white rounded-0">' :
        '<a href="/chat/'.$username.'" class="list-group-item list-group-item-action list-group-item-light rounded-0">' !!}
            <div class="media">
                <p class="mt-2 bg" data-color="#bf3f3f" data-letters="{{$initial ?? 'NA'}}"></p><!-- or whatever structure you used -->
                <div class="media-body ml-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h6 class="mb-0">{{$name ?? 'NA'}} </h6>
                        <small class="small font-weight-bold">{{date('d F', strtotime($message->lastConversation->created_at))}}</small>
                    </div>
                    <p class="font-italic {{Request::segment(2) == $username ? '' : 'text-muted'}} mb-0 text-small">{{ \Illuminate\Support\Str::limit($message->lastConversation->body, 50, $end='...') }}</p>
                </div>
            </div>
        </a>
    @endif
@empty
    <div class="row mt-5">
        <div class="col-12 text-center">
            <h4>Your contact list is empty</h4>
        </div>
    </div>
@endforelse
