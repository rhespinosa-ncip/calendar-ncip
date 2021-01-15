@extends('index.main')

@push('style')
@endpush

@section('auth-content')
    <div class="container-fluid mb-5">
        <div class="row mt-3 mb-2">
            <div class="col-12 text-right">
                <button class="btn btn-success rounded-0 py-1 px-3 btn-add-bureau">
                     ADD BUREAU
                </button>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <table class="table table-border sample-table" id="bureauList">
                            <thead>
                                <tr>
                                    <th>Bureau name</th>
                                    <th>Bureau color</th>
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
    <script src="{{asset('js/multiple/js/BsMultiSelect.js')}}"></script>
    <script src="{{ asset('js/bureau/form.js')}}"></script>
@endpush
