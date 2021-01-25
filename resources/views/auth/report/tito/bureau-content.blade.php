<div class="row mt-4">
    <div class="col-12 text-center">
        <h4>TIME IN AND TIME OUT REPORT</h4>
    </div>
</div>
@foreach ($tito['perDepartment'] as $perDepartment)
    <div class="row mt-3 mb-4">
        <div class="col-12">
            <b>
                Office :
            </b>
            {{$perDepartment->name ?? ''}} - {{Auth::user()->bureau->name ?? ''}}
        </div>
        <div class="col-12">
            <b>
                Period :
            </b>
            {{date('F d, Y', strtotime($dateFrom)). ' - ' .date('F d, Y', strtotime($dateTo))}}
        </div>
        <div class="col-12 mt-2">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th scope="col">NAME OF PERSONNEL</th>
                        <th scope="col">POSITION</th>
                        <th scope="col">DATE </th>
                        <th scope="col">TIME IN</th>
                        <th scope="col">TIME OUT</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($perDepartment->users as $user)
                        @php
                            $count = 0;
                        @endphp

                        @forelse ($user->tito as $tito)
                            @if ($count == 0)
                                <tr>
                                    <td class="align-middle" rowspan="{{$user->tito->count()}}">{{$user->fullName}}</td>
                                    <td class="align-middle" rowspan="{{$user->tito->count()}}">{{$user->position}}</td>
                                    <td><label>{{date('F d, Y', strtotime($tito->created_at))}}</label></td>
                                    <td><label>{{date('h:i A', strtotime($tito->time_in))}}</label></td>
                                    <td><label>{{isset($tito->time_out) ? date('h:i A', strtotime($tito->time_in)) : 'NO TIME OUT'}}</label></td>
                                </tr>
                                @php
                                    $count++;
                                @endphp
                            @else
                                <tr>
                                    <td>
                                        <label>{{date('F d, Y', strtotime($tito->created_at))}}</label>
                                    </td>
                                    <td>
                                        <label>{{date('h:i A', strtotime($tito->time_in))}}</label>
                                    </td>
                                    <td>
                                        <label>{{isset($tito->time_out) ? date('h:i A', strtotime($tito->time_in)) : 'NO TIME OUT'}}</label>
                                    </td>
                                </tr>
                            @endif
                        @empty
                            <tr>
                                <td colspan="5" class="text-center"> NO DTR  </td>
                            </tr>
                        @endforelse
                    @empty
                        <tr>
                            <td colspan="5" class="text-center"> NO DTR  </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endforeach

@if ($tito['haveUser'] != 'none')
    <div class="row mt-3 mb-4">
        <div class="col-12">
            <b>
                Office :
            </b>
            {{Auth::user()->bureau->name ?? ''}}
        </div>
        <div class="col-12">
            <b>
                Period :
            </b>
            {{date('F d, Y', strtotime($dateFrom)). ' - ' .date('F d, Y', strtotime($dateTo))}}
        </div>
        <div class="col-12 mt-2">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th scope="col">NAME OF PERSONNEL</th>
                        <th scope="col">POSITION</th>
                        <th scope="col">DATE </th>
                        <th scope="col">TIME IN</th>
                        <th scope="col">TIME OUT</th>
                    </tr>
                </thead>
                <tbody>
                    @if (isset($tito['perUserBureau']))
                        @forelse ($tito['perUserBureau'] as $perUserBureau)
                        @php
                            $count = 0;
                        @endphp

                                @forelse ($perUserBureau->tito as $tito)
                                    @if ($count == 0)
                                        <tr>
                                            <td class="align-middle" rowspan="{{$perUserBureau->tito->count()}}">{{$perUserBureau->fullName}}</td>
                                            <td class="align-middle" rowspan="{{$perUserBureau->tito->count()}}">{{$perUserBureau->position}}</td>
                                            <td><label for="">{{date('F d, Y', strtotime($tito->created_at))}}</label></td>
                                            <td>
                                                <label>{{date('h:i A', strtotime($tito->time_in))}}</label>
                                            </td>
                                            <td>
                                                <label>{{isset($tito->time_out) ? date('h:i A', strtotime($tito->time_in)) : 'NO TIME OUT'}}</label>
                                            </td>
                                            @php
                                                $count++;
                                            @endphp
                                        </tr>
                                    @else
                                        <tr>
                                            <td><label for="">{{date('F d, Y', strtotime($tito->created_at))}}</label></td>
                                            <td>
                                                <label>{{date('h:i A', strtotime($tito->time_in))}}</label>
                                            </td>
                                            <td>
                                                <label>{{isset($tito->time_out) ? date('h:i A', strtotime($tito->time_in)) : 'NO TIME OUT'}}</label>
                                            </td>
                                        </tr>
                                    @endif
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center"> NO ACCOMPLISHMENT </td>
                                    </tr>
                                @endforelse
                        @empty
                        <tr>
                            <td colspan="5" class="text-center"> NO ACCOMPLISHMENT </td>
                        </tr>
                        @endforelse
                    @endif
                </tbody>
            </table>
        </div>
    </div>
@endif
