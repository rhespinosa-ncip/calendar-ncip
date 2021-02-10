<div class="row mt-3">
    <div class="col-12 text-center">
        <h4>MEETING REPORT</h4>
    </div>
</div>
<div class="row mt-4">
    <div class="col-12">
        <div class="row">
            <div class="col-8">
                <div class="row">
                    <div class="col-12">
                        Title:
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 indent-30">
                        {{$data['meetingSchedule']->title}}
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="row">
                    <div class="col-12">
                        Date:
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 indent-30">
                        {{date('F d, Y - h:i A', strtotime($data['meetingSchedule']->date))}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row mt-2">
    <div class="col-12">
        Description:
    </div>
</div>
<div class="row">
    <div class="col-12 text-justify indent-30">
        {{$data['meetingSchedule']->title}}
    </div>
</div>
<div class="row mt-2">
    <div class="col-12">
        Participant(s):
    </div>
</div>
<div class="row">
    <div class="col-12">
        <ul>
            @if ($data['meetingSchedule']->participant == 'bureau')
                @foreach ($data['meetingSchedule']->bureauParticipants as $bureauParticipants)
                    <li>{{$bureauParticipants->bureau->name}}</li>
                @endforeach
            @elseif($data['meetingSchedule']->participant == 'department')
                @foreach ($data['meetingSchedule']->departmentParticipants as $departmentParticipants)
                    <li>{{$departmentParticipants->department->name}}</li>
                @endforeach
            @endif

            @if ($data['meetingSchedule']->is_participant == 'yes')
                @foreach ($data['meetingSchedule']->participants as $participants)
                    <li>{{$participants->user->fullName}}</li>
                @endforeach
            @endif
        </ul>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <table class="table table-bordered" id="actionableItemTable">
            <thead>
                <tr>
                    <th scope="col">Actionable Item</th>
                    <th scope="col">Status</th>
                    <th scope="col">Deadline</th>
                    <th scope="col">File</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($data['meetingSchedule']->actionableItem as $actionableItem)
                    @php
                        $showButton = false;
                    @endphp
                    @if ($actionableItem->personnel == 'individual')
                        @if ($actionableItem->personnel_id == 'user_'.Auth::id())
                            @php
                                $showTable = true;
                                $showButton = true;
                            @endphp
                        @endif
                    @elseif($actionableItem->personnel == 'department')
                        @if ($actionableItem->personnel_id == 'department_'.Auth::user()->department_id)
                            @if (Auth::user()->user_type == 'head')
                                @php
                                    $showButton = true;
                                @endphp
                            @endif
                            @php
                                $showTable = true;
                            @endphp
                        @endif
                    @elseif($actionableItem->personnel == 'bureau')
                        @if ($actionableItem->personnel_id == 'bureau_'.Auth::user()->bureau_id)
                            @if (Auth::user()->user_type == 'head')
                                @php
                                    $showButton = true;
                                @endphp
                            @endif
                            @php
                                $showTable = true;
                            @endphp
                        @endif
                    @endif

                    @if ($data['meetingSchedule']->created_by == Auth::id() || Auth::user()->user_type == 'admin')
                        @php
                            $showTable = true;
                        @endphp
                    @endif

                    @if (isset($showTable) && $showTable == true)
                        <tr>
                            <td>{{$actionableItem->actionable_item}}</td>
                            <td>
                                <ul>
                                    @foreach ($actionableItem->statuses as $status)
                                        <li>{{$status->status}} - ( {{date('F d, Y - h:i A', strtotime($status->created_at))}} )</li>
                                    @endforeach
                                </ul>
                            </td>
                            <td>{{date('F d, Y - h:i A', strtotime($actionableItem->deadline))}}</td>
                            <td>
                                <ul>
                                    @forelse ($actionableItem->documentsResponse as $document)
                                        <li><a target="_blank" href="/show-document/{{$document->file_path}}">{{$document->file_path}}</a></li>
                                    @empty
                                        <li> NO FILE YET</li>
                                    @endforelse
                                </ul>
                            </td>
                        </tr>
                    @else
                        <tr>
                            <td class="text-center" colspan="4">NO ACTIONABLE ITEM YET</td>
                        </tr>
                    @endif
                @empty
                    <tr>
                        <td colspan="4">NO ACTIONABLE ITEM YET</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
