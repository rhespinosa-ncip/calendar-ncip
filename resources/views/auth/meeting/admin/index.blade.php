@extends('index.main')

@push('style')
    <link rel="stylesheet" href="{{asset('css/calendar/calendar.css')}}">
@endpush

@section('auth-content')
    <div class="container-fluid mb-5">
        <div class="row mt-3">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <table class="table table-border sample-table" id="meetingAdminList">
                            <thead>
                                <tr>
                                    <th>Meeting title</th>
                                    <th>Meeting schedule</th>
                                    <th>Created by</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script src="{{asset('js/meeting/admin/form.js')}}"></script>
@endpush
