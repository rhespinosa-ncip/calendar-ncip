<div class="row">
    <div class="col-lg-12">
        <div class="row">
            <div class="col-12">
                <h5>New</h5>
            </div>
            <hr>
            <div class="scrollable scrollable-body-35">
                @forelse ($notReadNotifications as $notReadNotification)
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
                    @elseif ($notReadNotification->table_name == 'actionable_item_response')
                        <div class="col-12 mb-2">
                            {!! $notReadNotification->link !!}
                                <div class="card-body">
                                    <label class="text-justify">
                                        @php
                                            $id = explode("_",$notReadNotification->actionableItem->personnel_id)[1];
                                        @endphp
                                        @switch($notReadNotification->actionableItem->personnel)
                                            @case('individual')
                                                @php
                                                    $user = App\Models\User::whereId($id)->first();
                                                    $name = $user->fullName;
                                                @endphp
                                            @break
                                            @case('department')
                                                @php
                                                    $department = App\Models\Department::whereId($id)->first();
                                                    $name = $department->name;
                                                @endphp
                                            @break
                                            @case('bureau')
                                                @php
                                                    $bureau = App\Models\Bureau::whereId($id)->first();
                                                    $name = $bureau->name;
                                                @endphp
                                            @break
                                        @endswitch
                                        <b>{{$name}}</b> response to your actionable item "<i>{{$notReadNotification->actionableItem->actionable_item}}</i>" in {{date('F d, Y h:i A', strtotime($notReadNotification->created_at))}}
                                    </label>
                                    <p class="text-sm text-muted mb-0"><i class="far fa-clock mr-1"></i>{{App\GlobalClass\SystemLibrary::timeAgo($notReadNotification->created_at)[1]}}</p>
                                </div>
                            </a>
                        </div>
                    @endif
                @empty
                    <div class="col-12 text-center mt-3">
                        <label>NO NOTIFICATION</label>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
<div class="row mt-2">
    <div class="col-lg-12 text-center">
        <a href="/notification">see all notification</a>
    </div>
</div>
