@extends('index.main')

@push('style')
    <link rel="stylesheet" href="{{asset('css/calendar/calendar.css')}}">
@endpush

@section('auth-content')
    <div class="container-fluid mt-5">
        <div class="container-fluid">
            <div class="card rounded-0">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 text-center">
                            <img src="{{asset('image/maintenance-mode.jpg')}}" class="img-fluid ${3|rounded-top,rounded-right,rounded-bottom,rounded-left,rounded-circle,|}">
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-12 text-center">
                            <div class="error-template">
                                <h2>Oops!</h2>
                                <h1>Sorry this page isn't available</h1>
                                <div>
                                    <p>— The NCIP Developers team</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script src="{{asset('js/user/form.js')}}"></script>
@endpush
