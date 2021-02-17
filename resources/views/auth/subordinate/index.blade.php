@extends('index.main')

@section('auth-content')
    <div class="container-fluid mb-5 mt-3">
        <div class="row mt-3">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <table class="table table-border" id="subordinateTable">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Position</th>
                                    <th>Task</th>
                                    <th>Deadline</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($actionableItems as $actionableItem)
                                    @php
                                        $id = explode("_",$actionableItem->personnel_id)[1];

                                        $user = App\Models\User::where('id', $id)->first();
                                    @endphp
                                    @if ((isset(Auth::user()->department_id) && Auth::user()->user_type == 'head' && $user->department_id == Auth::user()->department_id) || (Auth::user()->user_type == 'head' && $user->bureau_id == Auth::user()->bureau_id))
                                        <tr>
                                            <td>{{$user->fullName}}</td>
                                            <td>{{$user->position}}</td>
                                            <td>{{$actionableItem->actionable_item}} ({{$actionableItem->status->status}} - {{date('F d, Y - h:i A', strtotime($actionableItem->status->created_at))}})</td>
                                            <td>{{date('F d, Y - h:i A', strtotime($actionableItem->deadline))}}</td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script src="{{asset('js/subordinate/form.js')}}"></script>
@endpush
