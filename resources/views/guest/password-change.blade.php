@extends('index.main')

@section('title', 'NCIP - Password reset')

@push('style')
    <link rel="stylesheet" href="{{asset('css/template/float-text.css')}}">
@endpush

@section('guest-content')
    <div class="container col-lg-6 col-10 mt-5 mb-5">
        <div class="row shadow col-lg-10 p-0 mx-auto my-auto">
            <div class="col-lg-12 p-0 login-form-left animated zoomIn" style="background : #eeeeff;">
                <div class="rounded-left p-5 image-holder-left">
                    <form id="password-reset-form">
                        <input type="hidden" name="email" value="{{$email}}">
                        <input type="hidden" name="token" value="{{$token}}">
                        <div class="row">
                            <div class="col-12 mt-2 text-center">
                                <h3 class="font font-weight-bold">Password reset</h3>
                                <hr>
                            </div>
                            <div class="col-4 offset-4">
                                <img src="{{asset('image/ncip-logo.png')}}" class="img-fluid ${3|rounded-top,rounded-right,rounded-bottom,rounded-left,rounded-circle,|}" alt="">
                            </div>
                            <div class="col-8 offset-2 mt-5">
                                <div class="form-group row mb-1">
                                    <label class="has-float-label col-12 p-0">
                                        <input class="form-control rounded-0" type="password" id="password" name="password"/>
                                        <span toggle="#password" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                                        <span class="span-credential-key" style="background: #eef !important;">Password</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-8 offset-2 text-center mt-3">
                                <button type="submit" form="password-reset-form" class="btn btn-primary btn-block login-form pr-sm-5 pl-sm-5"><b> Reset Password </b></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script src="{{asset('js/auth/login/form.js')}}"></script>
@endpush
