@extends('index.main')

@push('style')
@endpush

@section('auth-content')
    <div class="container-fluid mb-5">
        <div class="row mt-3 mb-2">
            <div class="col-12 text-right">
                <button class="btn btn-success rounded-0 py-1 px-3 btn-add-department">
                     ADD DIVISION
                </button>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <table class="table table-border sample-table" id="departmentList">
                            <thead>
                                <tr>
                                    <th>Division name</th>
                                    <th>Division color</th>
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
    <script src="{{ asset('js/department/form.js')}}"></script>
@endpush
