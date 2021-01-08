<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>NCIP - Meeting</title>

    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <link href="{{ asset('css/global.css') }}" rel="stylesheet">
    <link href="{{ asset('css/datatables.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/toastr.css') }}" rel="stylesheet">
    <link href="{{ asset('css/calendar/full-calendar.css') }}" rel="stylesheet">
    <link href="{{ asset('css/fontawesome-free/css/all.min.css') }}" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300&display=swap" rel="stylesheet">
    @stack('style')
</head>

    <body>
        @auth
            <nav class="navbar navbar-light bg-light navbar-expand-lg">
                <a class="navbar-brand" href="/">
                  <img src="{{asset('image/ncip-logo.png')}}" width="30" height="30" class="d-inline-block align-top" alt="">
                  NCIP
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto">
                        @if (Auth::user()->user_type == 'admin')
                            <li class="nav-item border-left">
                                <a class="nav-link" href="/department">Department</a>
                            </li>
                            <li class="nav-item border-left">
                                <a class="nav-link" href="/user">User</a>
                            </li>
                            <li class="nav-item border-left">
                                <a class="nav-link" href="/meeting/admin">Zoom meeting link</a>
                            </li>
                        @endif
                    </ul>
                    <span class="navbar-text">
                        <a href="/logout">
                            Logout
                        </a>
                    </span>
                </div>
            </nav>
            @yield('auth-content')
        @endauth

        @guest
            @yield('guest-content')
        @endguest

        <div class="modal fade" id="modalXl" tabindex="-1" data-backdrop="static" role="dialog">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">

                    </div>

                    <div class="modal-footer">

                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modal" tabindex="-1" data-backdrop="static" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">

                    </div>

                    <div class="modal-footer">

                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modalLg" tabindex="-1" data-backdrop="static" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">

                    </div>

                    <div class="modal-footer">

                    </div>
                </div>
            </div>
        </div>
    </body>

    <script src="{{asset('js/app.js')}}"></script>
    <script src="{{asset('js/sweetalert2.min.js')}}"></script>
    <script src="{{asset('js/datatables.min.js')}}"></script>
    <script src="{{asset('js/global.js')}}"></script>
    <script src="{{asset('js/calendar/full-calendar.js')}}"></script>
    @stack('script')
</html>
