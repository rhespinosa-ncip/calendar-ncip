@if(isset($data['messageType']) && $data['messageType'] == 'group')
    @forelse ($data['conversation']->conversation as $conversation)
        @if ($conversation->sent_by_user_id == Auth::id())
            <div class="media w-50 ml-auto mb-3">
                <div class="media-body">
                    <div class="bg-primary rounded py-2 px-3 mb-2">
                        <p class="text-small mb-0 text-white">{{$conversation->body == 'file-upload' ? '' : $conversation->body}}</p>
                        @if (isset($conversation->file[0]))
                            <ul class="mb-0">
                                @foreach ($conversation->file as $file)
                                    <li><a class="file-attach" target="_blank" href="/show-document/{{$file->file_path}}">{{$file->file_path}}</a></li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                    <p class="small text-muted">{{date('h:i A | F d, Y' , strtotime($conversation->created_at))}} - You -
                        <a href="#" class="view-seen" chatId="{{$conversation->id}}">
                            view seen
                        </a>
                    </p>
                </div>
            </div>
        @else
            <div class="media w-50 mb-3">
                <p class="mt-2 bg" data-color="#bf3f3f" data-letters="{{$conversation->user->initial}}"></p><!-- or whatever structure you used -->
                <div class="media-body ml-3">
                    <div class="bg-light rounded py-2 px-3 mb-2">
                        <p class="text-small mb-0 text-muted">{{$conversation->body == 'file-upload' ? '' : $conversation->body}}</p>
                        @if (isset($conversation->file[0]))
                            <ul class="mb-0">
                                @foreach ($conversation->file as $file)
                                    <li><a class="file-attach-sender" target="_blank" href="/show-document/{{$file->file_path}}">{{$file->file_path}}</a></li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                    <p class="small text-muted">{{date('h:i A | F d, Y' , strtotime($conversation->created_at))}} - {{$conversation->user->fullName}} -
                        <a href="#" class="view-seen" chatId="{{$conversation->id}}">
                            view seen
                        </a>
                    </p>
                </div>
            </div>
        @endif
    @empty
        <div class="row mt-5">
            <div class="col-12 text-center">
                <h3>{{$data['group']->name ?? ''}}</h3>
            </div>
            <div class="col-12 text-center mt-5">
                Say hi and start messaging
            </div>
        </div>
    @endforelse
@elseif (isset($data['conversation']))
    @forelse ($data['conversation']->conversation as $conversation)
        @if ($conversation->sent_by_user_id == Auth::id())
            <div class="media w-50 ml-auto mb-3">
                <div class="media-body">
                    <div class="bg-primary rounded py-2 px-3 mb-2">
                        <p class="text-small mb-0 text-white">{{$conversation->body == 'file-upload' ? '' : $conversation->body}}</p>
                        @if (isset($conversation->file[0]))
                            <ul class="mb-0">
                                @foreach ($conversation->file as $file)
                                    <li><a class="file-attach" target="_blank" href="/show-document/{{$file->file_path}}">{{$file->file_path}}</a></li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                    <p class="small text-muted">{{date('h:i A | F d, Y' , strtotime($conversation->created_at))}}</p>
                </div>
            </div>
        @else
            <div class="media w-50 mb-3">
                <p class="mt-2 bg" data-color="#bf3f3f" data-letters="{{$conversation->user->initial}}"></p><!-- or whatever structure you used -->
                <div class="media-body ml-3">
                    <div class="bg-light rounded py-2 px-3 mb-2">
                        <p class="text-small mb-0 text-muted">{{$conversation->body == 'file-upload' ? '' : $conversation->body}}</p>
                        @if (isset($conversation->file[0]))
                            <ul class="mb-0">
                                @foreach ($conversation->file as $file)
                                    <li><a class="file-attach-sender" target="_blank" href="/show-document/{{$file->file_path}}">{{$file->file_path}}</a></li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                    <p class="small text-muted">{{date('h:i A | F d, Y' , strtotime($conversation->created_at))}}</p>
                </div>
            </div>
        @endif
    @empty
        <div class="row mt-5">
            <div class="col-12 text-center">
                <h3>{{$data['userToMessage']->fullName ?? ''}}</h3>
            </div>
            <div class="col-12 text-center">
                <h6>({{$data['userToMessage']->position ?? ''}})</h6>
            </div>
            <div class="col-12 text-center mt-5">
                Say hi and start messaging
            </div>
        </div>
    @endforelse
@else
    <div class="row mt-5">
        <div class="col-12 text-center">
            <h3>{{$data['userToMessage']->fullName ?? ''}}</h3>
        </div>
        <div class="col-12 text-center">
            <h6><i>{{$data['userToMessage']->bureau->name ?? ''}} - {{$data['userToMessage']->department->name ?? ''}}</i></h6>
        </div>
        <div class="col-12 text-center">
            <h6>{{$data['userToMessage']->position ?? ''}}</h6>
        </div>
        <div class="col-12 text-center mt-5">
            Say hi and start messaging
        </div>
    </div>
@endif
