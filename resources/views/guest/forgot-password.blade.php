@extends('index.main')

@push('style')
    <link rel="stylesheet" href="{{asset('css/template/float-text.css')}}">
    <link rel="stylesheet" href="{{asset('css/login/login.css')}}">
@endpush

@section('guest-content')
<div class="container col-lg-6 col-10 mb-5 login-body">
    <div class="row shadow col-lg-10 p-0 mx-auto my-auto">
        <div class="col-lg-12 p-0 login-form-left animated zoomIn" style="background : #eeeeff;">
            <div class="rounded-left p-5 image-holder-left">
                <form id="forgotPassword-form">
                    @csrf
                    <div class="row">
                        <div class="col-12 mt-2 text-center">
                            <h3 class="font font-weight-bold">Forgot Password</h3>
                            <hr>
                        </div>
                        <div class="col-4 offset-4">
                            <img src="{{asset('image/ncip-logo.png')}}" class="img-fluid ${3|rounded-top,rounded-right,rounded-bottom,rounded-left,rounded-circle,|}" alt="">
                        </div>
                        <div class="col-8 offset-2 mt-4">
                            <div class="form-group row">
                                <label class="has-float-label col-12 p-0">
                                    <input class="form-control rounded-0" type="email" id="email" name="email"/>
                                    <span class="span-credential-password" style="background: #eef !important;">Email</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-8 offset-2 text-center mt-3">
                            <button type="submit" form="forgotPassword-form" class="btn btn-primary btn-block login-form pr-sm-5 pl-sm-5 rounded-0"><b> Send Reset Link </b></button>
                        </div>
                    </div>
                </form>
                <div class="row mt-3">
                    <div class="col-12 text-center">
                        <a href="/">Have an account?</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
    <script src="{{asset('js/auth/login/form.js')}}"></script>
@endpush
