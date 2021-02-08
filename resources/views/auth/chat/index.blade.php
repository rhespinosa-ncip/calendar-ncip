@extends('index.main')

@push('style')
    <link rel="stylesheet" href="{{asset('css/chat/form.css')}}">
@endpush

@section('auth-content')
<div class="container-fluid">
    <div class="row h-100 overflow-hidden">
        <!-- Users box-->
        <div class="col-lg-4 px-0">
            <div class="bg-white">
                <div class="bg-gray px-4 py-2 bg-light">
                    <p class="h5 mb-0 py-1">Messanger</p>
                </div>
                <div class="bg-gray px-4 py-2 bg-light">
                    <input type="text" class="form-control" placeholder="Search" name="searchUserGroup" id="searchUserGroup">
                </div>
                <div class="messages-box">
                    <div class="list-group rounded-0">
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
                            @if (Request::segment(2) == $username)
                                <a class="list-group-item list-group-item-action active text-white rounded-0">
                                    <div class="media">
                                        <p class="mt-2 bg" data-color="#bf3f3f" data-letters="{{$initial ?? 'NA'}}"></p><!-- or whatever structure you used -->
                                        <div class="media-body ml-4">
                                            <div class="d-flex align-items-center justify-content-between mb-1">
                                                <h6 class="mb-0">{{$name ?? 'NA'}}</h6><small class="small font-weight-bold">{{date('d F', strtotime($message->lastConversation->created_at))}}</small>
                                            </div>
                                            <p class="font-italic mb-0 text-small">{{ \Illuminate\Support\Str::limit($message->lastConversation->body, 150, $end='...') }}</p>
                                        </div>
                                    </div>
                                </a>
                            @else
                                <a href="/chat/{{$username}}" class="list-group-item list-group-item-action list-group-item-light rounded-0">
                                    <div class="media">
                                        <p class="mt-2 bg" data-color="#bf3f3f" data-letters="{{$initial ?? 'NA'}}"></p><!-- or whatever structure you used -->
                                        <div class="media-body ml-4">
                                            <div class="d-flex align-items-center justify-content-between mb-3">
                                                <h6 class="mb-0">{{$name ?? 'NA'}}</h6><small class="small font-weight-bold">{{date('d F', strtotime($message->lastConversation->created_at))}}</small>
                                            </div>
                                            <p class="font-italic text-muted mb-0 text-small">{{ \Illuminate\Support\Str::limit($message->lastConversation->body, 150, $end='...') }}</p>
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
                    </div>
                </div>
            </div>
        </div>
        <!-- Chat Box-->
        <div class="col-lg-8 px-0">
            <div class="px-4 py-5 chat-box bg-white">
                <!-- Sender Message-->
                @if (isset($data['conversation']))
                    @forelse ($data['conversation']->conversation as $conversation)
                        @if ($conversation->sent_by_user_id == Auth::id())
                            <div class="media w-50 ml-auto mb-3">
                                <div class="media-body">
                                    <div class="bg-primary rounded py-2 px-3 mb-2">
                                        <p class="text-small mb-0 text-white">{{$conversation->body}}</p>
                                    </div>
                                    <p class="small text-muted">{{date('h:i A | F d, Y' , strtotime($conversation->created_at))}}</p>
                                </div>
                            </div>
                        @else
                            <div class="media w-50 mb-3">
                                <p class="mt-2 bg" data-color="#bf3f3f" data-letters="{{$conversation->user->initial}}"></p><!-- or whatever structure you used -->
                                <div class="media-body ml-3">
                                    <div class="bg-light rounded py-2 px-3 mb-2">
                                        <p class="text-small mb-0 text-muted">{{$conversation->body}}</p>
                                    </div>
                                    <p class="small text-muted">{{date('h:i A | F d, Y' , strtotime($conversation->created_at))}}</p>
                                </div>
                            </div>
                        @endif
                    @empty
                        <div class="row">
                            <div class="col-12 text-center">
                                Say hi and start messaging
                            </div>
                        </div>
                    @endforelse
                @else
                    <div class="row">
                        <div class="col-12 text-center">
                            Say hi and start messaging
                        </div>
                    </div>
                @endif
        </div>
        <form action="#" class="bg-light">
            <div class="input-group">
                <input type="text" placeholder="Type a message" aria-describedby="button-addon2"
                    class="form-control rounded-0 border-0 py-4 bg-light">
                <div class="input-group-append">
                    <button id="button-addon2" type="submit" class="btn btn-link"> <i
                            class="fa fa-paper-plane"></i></button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('script')
    <script src="{{asset('js/chat/form.js')}}"></script>
@endpush
