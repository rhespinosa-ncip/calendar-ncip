@extends('index.main')

@section('auth-content')
    <div class="container-fluid mb-5">
        <div class="row mt-4">
            <div class="col-12 text-right mb-4">
                <button class="btn btn-success rounded-0 py-1 px-3 btn-print-report"><i class="fa fa-print" aria-hidden="true"></i>  Print</button>
            </div>
        </div>
        <div class="col-12">
            <div class="card rounded-0">
                <div class="card-body" id="printAreaReports">
                    <div class="row">
                        <div class="col-12 text-center">
                            <img src="{{asset('image/ncip-document.png')}}" class="img-fluid" alt="Responsive image">
                        </div>
                    </div>
                    <div class="content-report">
                        @include('auth.report.meeting.meeting-content')
                    </div>
                    <div class="row mt-4">
                        @include('prepared-by')
                    </div>
                    <div class="row">
                        <div class="col-12">
                            @include('fullwidth')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
