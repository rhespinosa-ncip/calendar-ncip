@extends('index.main')

@section('auth-content')
    <div class="container-fluid mb-5">
        <div class="row mt-3">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <table class="table table-border sample-table" id="notification">
                            <thead>
                                <tr>
                                    <th>Notification</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($notifications as $notification)
                                    @if ($notification->table_name == 'meeting_schedule')
                                        <tr>
                                            <td><b>{{$notification->meeting->user->fullName}}</b> added a new meeting, you're invited to a meeting "<i>{{$notification->meeting->title}}</i>" in {{date('F d, Y h:i A', strtotime($notification->meeting->date))}}</td>
                                            <td><a href="#" class="btn btn-success py-1 px-3 rounded-0 btn-show-meeting" meetingid="{{$notification->meeting->id}}">View</a></td>
                                        </tr>
                                    @elseif ($notification->table_name == 'actionable_item')
                                        <tr>
                                            <td><b>{{$notification->actionableItem->meetingSchedule->user->fullName}}</b> assigned you actionable item "<i>{{$notification->actionableItem->actionable_item}}</i>" deadline in {{date('F d, Y h:i A', strtotime($notification->actionableItem->deadline))}}</td>
                                            <td><a href="/meeting/view/{{$notification->actionableItem->meetingSchedule->id}}" class="btn btn-success py-1 px-3 rounded-0 ">View</a></td>
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
    <script src="{{asset('js/notification/form.js')}}"></script>
    <script src="{{asset('js/calendar/form.js')}}"></script>
@endpush

