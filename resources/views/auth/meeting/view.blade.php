@extends('index.main')

@push('style')

@endpush

@section('auth-content')
    <div class="container-fluid mb-5">
        <div class="row mt-3">
            <div class="col-12">
                <div class="card rounded-0">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-3">
                                <h4>Meeting title:</h4>
                                <div class="indent-30">
                                    <p>{{$data['meetingSchedule']->title}}</p>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <h4>Meeting date:</h4>
                                <div class="indent-30">
                                    <p>{{date('F d,Y h:i A', strtotime($data['meetingSchedule']->date))}}</p>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <h4>Meeting description: </h4>
                                <div class="indent-30">
                                    <p>{{$data['meetingSchedule']->description}}</p>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <h4>Meeting participant: </h4>
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
                            <div class="col-lg-12">
                                <h4>Attached file: </h4>
                                <ul>
                                    @foreach ($data['meetingSchedule']->documents as $documents)
                                        <li><a target="_blank" href="/show-document/{{$documents->file_path}}">{{$documents->file_path}}</a></li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 mt-2">
                <div class="card rounded-0">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-12">
                                <h5>Actionable Item</h5>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 text-right">
                                @if ($data['meetingSchedule']->created_by == Auth::id())
                                    <button class="btn btn-success py-0 px-3 rounded-0 btn-add-actionable" meetingid="{{$data['meetingSchedule']->id}}"> ADD  </button>
                                @endif
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-12">
                                <table class="table table-bordered" id="actionableItemTable">
                                    <thead>
                                        <tr>
                                            <th scope="col">Actionable Item</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Deadline</th>
                                            <th scope="col">File</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($data['meetingSchedule']->created_by == Auth::id() || Auth::user()->user_type == 'admin')
                                            @foreach ($data['meetingSchedule']->actionableItem as $actionableItem)
                                                <tr>
                                                    <td>{{$actionableItem->actionable_item}}</td>
                                                    <td>{{$actionableItem->status->status}} - ( {{date('F d, Y - h:i A', strtotime($actionableItem->status->created_at))}} )</td>
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
                                                    <td>
                                                        @if ($data['meetingSchedule']->created_by == Auth::id())
                                                            <button class="btn btn-success py-0 px-3 rounded-0 btn-add-actionable" status="update" meetingid="{{$actionableItem->id}}"> UPDATE  </button>
                                                        @else
                                                            NO ACTION NEEDED
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            @foreach ($data['meetingSchedule']->actionableItem as $actionableItem)
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

                                                @if (isset($showTable) && $showTable == true)
                                                    <tr>
                                                        <td>{{$actionableItem->actionable_item}}</td>
                                                        <td>{{$actionableItem->status->status}} - ( {{date('F d, Y - h:i A', strtotime($actionableItem->status->created_at))}} )</td>
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
                                                        <td>
                                                            @if (isset($showButton) && $showButton == true)
                                                                <button class="btn btn-success py-0 px-3 rounded-0 btn-add-actionable-file" actionableItem="{{$actionableItem->id}}"> ADD FILE  </button>
                                                            @else
                                                                NO ACTION NEEDED
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 mt-2">
                <div class="card rounded-0">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-12">
                                <h5>Files</h5>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 text-right">
                                @if ($data['meetingSchedule']->created_by == Auth::id())
                                    <button class="btn btn-success py-0 px-3 rounded-0 btn-add-minutes" meetingid="{{$data['meetingSchedule']->id}}"> ADD  </button>
                                @endif
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-12">
                                <table class="table table-bordered" id="fileTable">
                                    <thead>
                                        <tr>
                                            <th scope="col">File</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data['meetingSchedule']->minuteDocuments as $minuteDocuments)
                                            <tr>
                                                <td><a target="_blank" href="/show-document/{{$minuteDocuments->file_path}}">{{$minuteDocuments->file_path}}</a></td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script src="{{ asset('js/meeting/form.js')}}"></script>
    <script src="{{ asset('js/calendar/form.js')}}"></script>
@endpush
