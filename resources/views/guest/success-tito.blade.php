@extends('index.main')

@push('style')
    <style>
        body{
            background-color: #d2d2d2 !important;
        }
    </style>
@endpush

@section('guest-content')
    <div class="container">
        @php
            $hour = date('H');
            $dayTerm = ($hour > 17) ? "Evening" : (($hour > 12) ? "Afternoon" : "Morning");
            $greet = "Good " . $dayTerm;
        @endphp
        <div class="row mt-5">
            <div class="col-12 mt-3 text-center">
                <img src="{{asset('image/ncip-logo.png')}}" class="img-fluid ${3|rounded-top,rounded-right,rounded-bottom,rounded-left,rounded-circle,|}" alt="">
            </div>
            <div class="col-12 text-center mt-5">
                <div class="row mt-2">
                    <div class="col-12 text-center">
                        <h2>{{$greet}}</h2>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-lg-6">
                        <h2>Hello {{$user->fullName}}</h2>
                        <h5>{{$user->bureau->name}}</h5>
                        <h5>{{$user->department->name ?? ''}}</h5>
                        <h5>({{$user->position}})</h5>
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

@push('script')
    <script src="{{asset('js/auto-tito/form.js')}}"></script>
@endpush
