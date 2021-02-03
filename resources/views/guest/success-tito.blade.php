@extends('index.main')


@section('guest-content')
    <div class="container">
        <div class="row mt-5">
            <div class="col-12 mt-5 text-center">
                <img src="{{asset('image/ncip-logo.png')}}" class="img-fluid ${3|rounded-top,rounded-right,rounded-bottom,rounded-left,rounded-circle,|}" alt="">
            </div>
            <div class="col-12 text-center mt-4">
                <div class="row mt-4">
                    <div class="col-lg-6">
                        <h2>Hello {{$user->fullName}}</h2>
                        <h4>({{($user->position)}})</h4>
                    </div>
                    <div class="col-lg-6">
                        <h2>TIME {{$tito}} SUCCESS</h2>
                        <h4>{{date('h:i:s A')}}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

