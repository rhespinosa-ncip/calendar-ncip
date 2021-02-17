@extends('index.main')

@push('style')
    <link rel="stylesheet" href="{{asset('css/chat/form.css')}}">
    <style>
        input[type="file"] {
            display: none;
        }
        .custom-file-upload {
            display: inline-block;
            padding: 6px 12px;
            cursor: pointer;
        }
        .removeFile {
            color: #000000 !important;
        }
        .removeFile:hover {
            text-decoration: underline;
        }
    </style>
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
                    <div class="list-group rounded-0 side-messages">
                        @include('auth.chat.message-box')
                    </div>
                </div>
            </div>
        </div>
        <!-- Chat Box-->
        <div class="col-lg-8 px-0">
            <div id="chat-box" class="px-4 py-5 chat-box bg-white">
                <!-- Sender Message-->
                @include('auth.chat.chat-box')
        </div>
        @if ($data['userToMessage'])
            <form id="chatMessage" class="bg-light">
                <input type="hidden" name="toMessage" value="{{$data['userToMessage']->id ?? ''}}">
                <div class="row mt-2">
                    <div class="col-12 ml-3">
                        <div class="fileList"></div>
                    </div>
                </div>
                <div class="input-group">
                    <input type="text" name="message" id="message" placeholder="Type a message" class="form-control rounded-0 border-0 py-4 bg-light">
                    <div class="input-group-append files">
                        <label for="file-upload" class="btn btn-link custom-file-upload mt-2">
                            <i class="fas fa-paperclip"></i>
                        </label>
                        <input id="file-upload" name="fileUpload[]" type="file" multiple/>
                    </div>
                    <div class="input-group-append">
                        <button form="chatMessage" type="submit" class="btn btn-link"> <i class="fa fa-paper-plane"></i></button>
                    </div>
                </div>

            </form>
        @endif
    </div>
</div>
@endsection

@push('script')
    <script src="{{asset('js/chat/form.js')}}"></script>
@endpush
