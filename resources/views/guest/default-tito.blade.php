@extends('index.main')

@push('style')
    <style>
        .ncip-date{
            font-size: 24px;
        }
    </style>
@endpush

@section('guest-content')
    <div class="container">
        <div class="row mt-5">
            <div class="col-12">
                <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                    <ol class="carousel-indicators">
                        <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                        <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                        <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                        <li data-target="#carouselExampleIndicators" data-slide-to="3"></li>
                        <li data-target="#carouselExampleIndicators" data-slide-to="4"></li>
                    </ol>
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img class="d-block w-100" src="https://neilpatel.com/wp-content/uploads/2017/09/image-editing-tools.jpg" alt="First slide">
                        </div>
                        <div class="carousel-item">
                            <img class="d-block w-100" src="https://neilpatel.com/wp-content/uploads/2017/09/image-editing-tools.jpg" alt="Second slide">
                        </div>
                        <div class="carousel-item">
                            <img class="d-block w-100" src="https://neilpatel.com/wp-content/uploads/2017/09/image-editing-tools.jpg" alt="Third slide">
                        </div>
                        <div class="carousel-item">
                            <img class="d-block w-100" src="https://neilpatel.com/wp-content/uploads/2017/09/image-editing-tools.jpg" alt="Fourth slide">
                        </div>
                        <div class="carousel-item">
                            <img class="d-block w-100" src="https://neilpatel.com/wp-content/uploads/2017/09/image-editing-tools.jpg" alt="Fifth slide">
                        </div>
                        <div class="carousel-item">
                            <img class="d-block w-100" src="https://neilpatel.com/wp-content/uploads/2017/09/image-editing-tools.jpg" alt="Six slide">
                        </div>
                    </div>
                    <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>
        </div>
        @php
            $hour = date('H');
            $dayTerm = ($hour > 17) ? "Evening" : (($hour > 12) ? "Afternoon" : "Morning");
            $greet = "Good " . $dayTerm;
        @endphp
        <div class="row mt-4">
            <div class="col-12 text-center">
                <h1>{{$greet}}</h1>
            </div>
            </div>
            <div class="col-12 text-center">
                <span class="ncip-date" >{{date('F d, Y')}} - </span>
                <span class="ncip-date time" id="time"></span>
                <span class="ncip-date ampm" id="ampm"></span>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script src="{{asset('js/auto-tito/form.js')}}"></script>
@endpush
