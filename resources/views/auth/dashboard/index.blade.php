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
                                <label class="ncip-date p-0">{{date('F d, Y')}}</label>
                            </div>
                        </div>
                        <hr>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body ncip-meeting">
                        <div class="row ncip-body">
                            @foreach ($data['todayMeetingAsParticipant'] as $todayMeetingAsParticipant)
                                @if (isset($todayMeetingAsParticipant->meeting->title))
                                    <div class="col-12">
                                        <div class="card ncip-card-meeting mb-2">
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
                            @endforeach
                            @foreach ($data['todayMeeting'] as $todayMeeting)
                                <div class="col-12">
                                    <div class="card ncip-card-meeting mb-2">
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
                            @endforeach
                            @if (count($data['todayMeetingAsParticipant']) == 0 && count($data['todayMeeting']) == 0)
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
                <div class="card">
                    <div class="card-body">
                        <div id='ncip-calendar'></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script src="{{asset('js/multiple/js/BsMultiSelect.js')}}"></script>
    <script src="{{asset('js/calendar/form.js')}}"></script>
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
                    },
                    @endforeach
                    @foreach($data['asParticipant'] as $asParticipant)
                    {
                        id: '{{$asParticipant->meeting->id}}',
                        title: '{{$asParticipant->meeting->title}}',
                        start: '{{$asParticipant->meeting->date}}',
                    },
                    @endforeach
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
