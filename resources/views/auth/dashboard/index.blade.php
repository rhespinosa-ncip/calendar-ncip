@extends('index.main')

@push('style')
    <link rel="stylesheet" href="css/calendar/calendar.css">
@endpush

@section('auth-content')
    <div class="container-fluid mb-5">
        <div class="row mt-3 mb-2">
            <div class="col-12 text-right">
                <button class="btn btn-success rounded-0 py-1 px-3 btn-add-meeting">
                     ADD MEETING
                </button>
            </div>
        </div>
        <div class="row">
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
                                <span class="ncip-date time" id="time">12:56</span>
                                <span class="ampm" id="ampm">AM</span>
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
                                            @endphp
                                            <div class="col-12">
                                                <div class="card mb-2" style="border-left: 3px solid {{$todayMeetingAsParticipant->meeting->user->department->hexa_color}}; !important">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <label class="ncip-title">{{$todayMeetingAsParticipant->meeting->title}}</label>
                                                            </div>
                                                            <div class="col-12">
                                                                <label class="ncip-description">{{date('h:i A', strtotime($todayMeetingAsParticipant->meeting->date))}}</label>
                                                            </div>
                                                            <div class="col-12">
                                                                <label class="ncip-description">{{$todayMeetingAsParticipant->meeting->description}}</label>
                                                            </div>
                                                            <div class="col-12 text-center">
                                                                <a class="btn-show-meeting" href="" meetingId="{{$todayMeetingAsParticipant->meeting->id}}">View in details</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endif
                                @endforeach
                            @endif
                            @foreach ($data['todayMeeting'] as $todayMeeting)
                                @if (date("Y-m-d H:i", strtotime($todayMeeting->date)) >= date("Y-m-d H:i"))
                                    @php
                                        $haveMeeting = true;
                                    @endphp
                                    <div class="col-12">
                                        <div class="card mb-2" style="border-left: 3px solid {{$todayMeeting->user->department->hexa_color}}; !important">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <label class="ncip-title">{{$todayMeeting->title}}</label>
                                                    </div>
                                                    <div class="col-12">
                                                        <label class="ncip-description">{{date('h:i A', strtotime($todayMeeting->date))}}</label>
                                                    </div>
                                                    <div class="col-12">
                                                        <label class="ncip-description">{{$todayMeeting->description}}</label>
                                                    </div>
                                                    <div class="col-12 text-center">
                                                        <a class="btn-show-meeting" href="" meetingId="{{$todayMeeting->id}}">View in details</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                            @if (Auth::user()->user_type != 'admin')
                                @foreach ($data['todayMeetingAsDepartment'] as $departmentMeeting)
                                    @if (date("Y-m-d H:i", strtotime($departmentMeeting->date)) >= date("Y-m-d H:i"))
                                        @php
                                            $haveMeeting = true;
                                        @endphp
                                        <div class="col-12">
                                            <div class="card mb-2" style="border-left: 3px solid {{$departmentMeeting->hexa_color}}; !important">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <label class="ncip-title">{{$departmentMeeting->title}}</label>
                                                        </div>
                                                        <div class="col-12">
                                                            <label class="ncip-description">{{date('h:i A', strtotime($departmentMeeting->date))}}</label>
                                                        </div>
                                                        <div class="col-12">
                                                            <label class="ncip-description">{{$departmentMeeting->description}}</label>
                                                        </div>
                                                        <div class="col-12 text-center">
                                                            <a class="btn-show-meeting" href="" meetingId="{{$departmentMeeting->id}}">View in details</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            @endif
                            @if (!isset($haveMeeting))
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-12 text-center p-5">
                                            <label class="">No meeting</label>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="card h-100">
                    <div class="card-body">
                        <div id='ncip-calendar'></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <table class="table table-border sample-table" id="endedMeetingList">
                            <thead>
                                <tr>
                                    <th>Meeting title</th>
                                    <th>Meeting date</th>
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
                        color: '{{$filedMeeting->user->department->hexa_color}}'
                    },
                    @endforeach

                    @if(Auth::user()->user_type != 'admin')
                        @foreach($data['asParticipant'] as $asParticipant)
                        {
                            id: '{{$asParticipant->meeting->id}}',
                            title: '{{$asParticipant->meeting->title}}',
                            start: '{{$asParticipant->meeting->date}}',
                            color: '{{$asParticipant->meeting->user->department->hexa_color}}'
                        },
                        @endforeach
                        @foreach($data['departmentMeeting'] as $departmentMeeting)
                        {
                            id: '{{$departmentMeeting->id}}',
                            title: '{{$departmentMeeting->title}}',
                            start: '{{$departmentMeeting->date}}',
                            color: '{{$departmentMeeting->hexa_color}}'
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
