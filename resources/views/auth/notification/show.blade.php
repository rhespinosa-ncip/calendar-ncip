<div class="row">
    <div class="col-lg-12">
        <div class="row">
            <div class="col-12">
                <h5>New</h5>
            </div>
            <hr>
            @forelse ($notReadNotifications as $notReadNotification)
                <div class="scrollable scrollable-body-35">
                    @if ($notReadNotification->table_name == 'meeting_schedule')
                        <div class="col-12 mb-2">
                            {!! $notReadNotification->link !!}
                                <div class="card-body">
                                    <label class="text-justify">
                                        <b>{{$notReadNotification->meeting->user->fullName}}</b> added a new meeting, you're invited to a meeting "<i>{{$notReadNotification->meeting->title}}</i>" in {{date('F d, Y h:i A', strtotime($notReadNotification->meeting->date))}}
                                    </label>
                                    <p class="text-sm text-muted mb-0"><i class="far fa-clock mr-1"></i>{{App\GlobalClass\SystemLibrary::timeAgo($notReadNotification->created_at)[1]}}</p>
                                </div>
                            </a>
                        </div>
                    @elseif ($notReadNotification->table_name == 'actionable_item')
                        <div class="col-12 mb-2">
                            {!! $notReadNotification->link !!}
                                <div class="card-body">
                                    <label class="text-justify">
                                        <b>{{$notReadNotification->actionableItem->meetingSchedule->user->fullName}}</b> assigned you actionable item "<i>{{$notReadNotification->actionableItem->actionable_item}}</i>" deadline in {{date('F d, Y h:i A', strtotime($notReadNotification->actionableItem->deadline))}}
                                    </label>
                                    <p class="text-sm text-muted mb-0"><i class="far fa-clock mr-1"></i>{{App\GlobalClass\SystemLibrary::timeAgo($notReadNotification->created_at)[1]}}</p>
                                </div>
                            </a>
                        </div>
                    @endif
                </div>
            @empty
                <div class="col-12 text-center">
                    <label>NO NOTIFICATION</label>
                </div>
            @endforelse
        </div>
    </div>
</div>
<div class="row mt-2">
    <div class="col-lg-12 text-center">
        <a href="/notification">see all notification</a>
    </div>
</div>
