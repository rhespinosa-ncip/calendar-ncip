@extends('index.main')

@push('style')
@endpush

@section('auth-content')
    <div class="container-fluid mb-5">
         <div class="row mt-4">
            <div class="col-12">
                <div class="card rounded-0">
                    <div class="card-body" id="printAreaReports">
                        <div class="content-report">
                            @include('auth.report.meeting.content')
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
    </div>
@endsection

@push('script')
    <script src="{{asset('js/multiple/js/BsMultiSelect.js')}}"></script>
    <script src="{{ asset('js/report/form.js')}}"></script>
@endpush
