@extends('index.main')

@push('style')
    <link rel="stylesheet" href="{{asset('css/calendar/calendar.css')}}">
@endpush

@section('auth-content')
    <div class="container-fluid mb-5">
        <div class="row mt-3 mb-2">
            @if (Auth::user()->user_type != 'executive')
                <div class="col-12 text-right">
                    <button class="btn btn-success rounded-0 py-1 px-3 btn-add-meeting">
                        ADD MEETING
                    </button>
                </div>
            @endif
        </div>
        @php
            $tommorowMeeting = 0;

            if(isset($data['asParticipant'])){
                foreach ($data['asParticipant'] as $asParticipantKey => $asParticipantValue) {
                    if(date('Y-m-d', strtotime($asParticipantValue->meeting->date)) == date('Y-m-d', strtotime('+1 day'))){
                        $tommorowMeeting++;
                    }
                }
            }

            if(isset($data['filedMeeting'])){
                foreach ($data['filedMeeting'] as $filedMeetingKey => $filedMeetingValue) {
                    if(date('Y-m-d', strtotime($filedMeetingValue->date)) == date('Y-m-d', strtotime('+1 day'))){
                        $tommorowMeeting++;
                    }
                }
            }

            if(isset($data['departmentMeeting'])){
                foreach ($data['departmentMeeting'] as $departmentMeetingKey) {
                    if(date('Y-m-d', strtotime($departmentMeetingKey->date)) == date('Y-m-d', strtotime('+1 day'))){
                        $tommorowMeeting++;
                    }
                }
            }

            if(isset($data['todayMeetingAsBureau'])){
                foreach ($data['todayMeetingAsBureau'] as $todayMeetingAsBureauKey) {
                    if(date('Y-m-d', strtotime($todayMeetingAsBureauKey->date)) == date('Y-m-d', strtotime('+1 day'))){
                        $tommorowMeeting++;
                    }
                }
            }
        @endphp
        <div class="row">
            @if (Auth::user()->user_type != 'executive')
                <div class="col-lg-4 col-12">
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 text-center">
                                    <h5 class="mb-0">
                                        <label class="p-0">{{\App\GlobalClass\SystemLibrary::day()}} {{Auth::user()->fullName}},</label>
                                    </h5>
                                    <span>( {{Auth::user()->position}} )</span>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-12 text-center">
                                    <label class="ncip-date p-0">{{date('F d, Y')}}</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 text-center">
                                    <span class="ncip-date time" id="time"></span>
                                    <span class="ampm" id="ampm"></span>
                                </div>
                            </div>
                            @if (Auth::user()->user_type != 'admin')
                                @if (isset($data['tito']->time_in))
                                    <hr>
                                    <div class="row">
                                        <div class="col-6 text-center">
                                            <h6><b>Time in</b></h6>
                                            <div class="row">
                                                <div class="col-12">
                                                    <h6>{{date('h:i A', strtotime($data['tito']->time_in))}}</h6>
                                                </div>
                                            </div>
                                        </div>
                                        @if (isset($data['tito']->time_out))
                                            <div class="col-6 text-center">
                                                <h6><b>Time out</b></h6>
                                                <div class="row">
                                                    <div class="col-12">
                                                        <h6>{{date('h:i A', strtotime($data['tito']->time_out))}}</h6>
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <div class="col-6 text-center">
                                                <h6><b>Time out</b></h6>
                                                <div class="row">
                                                    <div class="col-12">
                                                        <h6>NO TIME OUT</h6>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <button class="btn btn-info rounded-0 btn-block btn-time-out">Time out</button>
                                            </div>
                                        @endif
                                    </div>
                                @else
                                    <div class="row m-2">
                                        <div class="col-12">
                                            <button class="btn btn-info rounded-0 btn-block btn-time-in">Time in</button>
                                        </div>
                                    </div>
                                @endif
                            @endif
                            <hr>
                            @if (isset($tommorowMeeting) && $tommorowMeeting != 0)
                                <div class="row mt-2">
                                    <div class="col-12 text-center">
                                        <span class="badge badge-danger p-2">
                                            {{$tommorowMeeting ?? 0}} meeting's tommorow
                                        </span>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body ncip-meeting">
                            <div class="row ncip-body">
                                @if (Auth::user()->user_type != 'admin')
                                    @foreach ($data['todayMeetingAsParticipant'] as $todayMeetingAsParticipant)
                                        @if (isset($todayMeetingAsParticipant->meeting->title))
                                            @if (date("Y-m-d H:i", strtotime($todayMeetingAsParticipant->meeting->date)) >= date("Y-m-d H:i"))
                                                @php
                                                    $haveMeeting = true;
                                                    array_push($todayMeetings, array(
                                                        'id' => $todayMeetingAsParticipant->meeting->id,
                                                        'hexa_color' => $todayMeetingAsParticipant->meeting->user->department->hexa_color ?? '#3788d8',
                                                        'title' => $todayMeetingAsParticipant->meeting->title,
                                                        'time' => date('H:i', strtotime($todayMeetingAsParticipant->meeting->date)),
                                                        'description' => $todayMeetingAsParticipant->meeting->description
                                                    ));
                                                @endphp
                                            @endif
                                        @endif
                                    @endforeach
                                    @foreach ($data['todayMeetingAsDepartment'] as $departmentMeeting)
                                        @if (date("Y-m-d H:i", strtotime($departmentMeeting->date)) >= date("Y-m-d H:i"))
                                            @php
                                                $haveMeeting = true;
                                                array_push($todayMeetings, array(
                                                    'id' => $departmentMeeting->meeting_schedule_id,
                                                    'hexa_color' => $departmentMeeting->meetingSchedule->user->department->hexa_color ?? '#3788d8',
                                                    'title' => $departmentMeeting->title,
                                                    'time' => date('H:i', strtotime($departmentMeeting->date)),
                                                    'description' => $departmentMeeting->description
                                                ));
                                            @endphp
                                        @endif
                                    @endforeach
                                    @foreach ($data['todayMeetingAsBureau'] as $todayMeetingAsBureau)
                                        @if (date("Y-m-d H:i", strtotime($todayMeetingAsBureau->date)) >= date("Y-m-d H:i"))
                                            @php
                                                $haveMeeting = true;
                                                array_push($todayMeetings, array(
                                                    'id' => $todayMeetingAsBureau->meeting_schedule_id,
                                                    'hexa_color' => $todayMeetingAsBureau->meetingSchedule->user->bureau->hexa_color ?? '#3788d8',
                                                    'title' => $todayMeetingAsBureau->title,
                                                    'time' => date('H:i', strtotime($todayMeetingAsBureau->date)),
                                                    'description' => $todayMeetingAsBureau->description
                                                ));
                                            @endphp
                                        @endif
                                    @endforeach
                                @endif
                                @foreach ($data['todayMeeting'] as $todayMeeting)
                                    @if (date("Y-m-d H:i", strtotime($todayMeeting->date)) >= date("Y-m-d H:i"))
                                        @php
                                            $haveMeeting = true;
                                            array_push($todayMeetings, array(
                                                'id' => $todayMeeting->id,
                                                'hexa_color' => $todayMeeting->user->department->hexa_color ??  ($todayMeeting->user->bureau->hexa_color ?? '#3788d8'),
                                                'title' => $todayMeeting->title,
                                                'time' => date('H:i', strtotime($todayMeeting->date)),
                                                'description' => $todayMeeting->description
                                            ));
                                        @endphp
                                    @endif
                                @endforeach
                                @php
                                    foreach ($todayMeetings as $key => $row) {
                                        $timeColumn[$key]  = $row['time'];
                                    }

                                    $timeColumn  = array_column($todayMeetings, 'time');

                                    array_multisort($timeColumn, SORT_ASC, $todayMeetings);
                                @endphp
                                @foreach ($todayMeetings as $todayMeetingKey => $todayMeetingValue)
                                    <div class="col-12">
                                        <div class="card mb-2" style="border-left: 3px solid {{$todayMeetingValue['hexa_color']}}; !important">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <label class="ncip-title">{{$todayMeetingValue['title']}}</label>
                                                    </div>
                                                    <div class="col-12">
                                                        <label class="ncip-description">{{date('h:i A', strtotime($todayMeetingValue['time']))}}</label>
                                                    </div>
                                                    <div class="col-12">
                                                        <label class="ncip-description">{{$todayMeetingValue['description']}}</label>
                                                    </div>
                                                    <div class="col-12 text-center">
                                                        <a class="btn-show-meeting" href="" meetingId="{{$todayMeetingValue['id']}}">View in details</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                                @if (!isset($haveMeeting))
                                    <div class="col-12">
                                        <div class="row">
                                            <div class="col-12 text-center p-5">
                                                <label class="">No meeting today</label>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            <div class="{{Auth::user()->user_type == 'executive' ? 'col-lg-6' : 'col-lg-8'}}">
                <div class="card h-100">
                    <div class="card-body">
                        <div id='ncip-calendar'></div>
                    </div>
                </div>
            </div>
            @if (Auth::user()->user_type == 'executive')
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="mb-0">Actionable Item</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <table class="table table-border sample-table" id="actionableItemTable">
                                        <thead>
                                            <tr>
                                                <th>Actionable Item</th>
                                                <th>Status</th>
                                                <th>Deadline</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($data['actionableItems'] as $actionableItems)
                                                <tr>
                                                    <td>{{$actionableItems->actionable_item}}</td>
                                                    <td>
                                                        @foreach ($actionableItems->statuses as $status)
                                                            - {{$status->status}} ({{date('F d,Y h:i A', strtotime($status->created_at))}}) </br>
                                                        @endforeach
                                                    </td>
                                                    <td>{{date('F d,Y h:i A', strtotime($actionableItems->deadline))}}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card mt-2">
                        <div class="card-header">
                            <h4 class="mb-0">Audit Trail</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <table class="table table-border sample-table" id="auditTrailTable">
                                        <thead>
                                            <tr>
                                                <th>Event</th>
                                                <th>User</th>
                                                <th>Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($data['auditTrail'] as $auditTrail)
                                                <tr>
                                                    <td>{{$auditTrail->event}}</td>
                                                    <td>{{$auditTrail->user->fullName}}</td>
                                                    <td>{{date('F d,Y h:i A', strtotime($auditTrail->created_at))}}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
        <div class="row mt-3">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="mb-0">Meetings</h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-border sample-table" id="endedMeetingList">
                            <thead>
                                <tr>
                                    <th>Meeting title</th>
                                    <th>Meeting date</th>
                                    <th>File or Action</th>
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
    <script src="{{asset('js/calendar/form.js')}}"></script>
    <script src="{{asset('js/calendar/tito/form.js')}}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('ncip-calendar');

            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                fixedWeekCount: false,
                headerToolbar: {
                    end: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth',
                    center: 'title',
                    start: 'prev,next',
                },
                businessHours: {
                    daysOfWeek: [1, 2, 3, 4, 5], // Monday - Thursday
                    startTime: '01:00',
                    endTime: '24:00',
                },
                events: [
                    @foreach($data['filedMeeting'] as $filedMeeting)
                    {
                        id: '{{$filedMeeting->id}}',
                        title: '{{$filedMeeting->title}}',
                        start: '{{$filedMeeting->date}}',
                        color: '{{$filedMeeting->user->department->hexa_color ?? ($filedMeeting->user->bureau->hexa_color ?? '')}}'
                    },
                    @endforeach

                    @if(Auth::user()->user_type != 'admin' && Auth::user()->user_type != 'executive')
                        @foreach($data['asParticipant'] as $asParticipant)
                        {
                            id: '{{$asParticipant->meeting->id}}',
                            title: '{{$asParticipant->meeting->title}}',
                            start: '{{$asParticipant->meeting->date}}',
                            color: '{{$asParticipant->meeting->user->department->hexa_color ?? ''}}'
                        },
                        @endforeach
                        @foreach($data['departmentMeeting'] as $departmentMeeting)
                        {
                            id: '{{$departmentMeeting->meeting_schedule_id}}',
                            title: '{{$departmentMeeting->title}}',
                            start: '{{$departmentMeeting->date}}',
                            color: '{{$departmentMeeting->meetingSchedule->user->department->hexa_color ?? ''}}'
                        },
                        @endforeach
                        @foreach($data['asBureau'] as $asBureau)
                        {
                            id: '{{$asBureau->meeting_schedule_id}}',
                            title: '{{$asBureau->title}}',
                            start: '{{$asBureau->date}}',
                            color: '{{$asBureau->meetingSchedule->user->bureau->hexa_color ?? ''}}'
                        },
                        @endforeach
                    @endif

                ],
                eventTimeFormat: {
                    hour: "numeric",
                    minute: "2-digit",
                    meridiem: "short",
                },
                eventClick: function(info) {
                    info.jsEvent.preventDefault(); // don't let the browser navigate

                    if(info.event.id){
                        showMeeting(info.event.id)
                    }
                }
            });

            calendar.render();
        });
    </script>
@endpush
