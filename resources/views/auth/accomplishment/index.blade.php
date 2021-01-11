@extends('index.main')

@section('auth-content')
    <div class="container-fluid mb-5 mt-3">
        <div class="row mt-3">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <table class="table table-border sample-table" id="accomplishmentTable">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Time in</th>
                                    <th>Time out</th>
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
    <script src="{{asset('js/accomplishment/form.js')}}"></script>
@endpush
