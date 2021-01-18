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
                        <th scope="col">DATE / TIME IN / TIME OUT</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($perDepartment->users as $user)
                        <tr>
                            <td>{{$user->fullName}}</td>
                            <td>{{$user->position}}</td>
                            <td>
                                @forelse ($user->tito as $tito)
                                    <label>{{date('F d, Y', strtotime($tito->created_at))}}</label>
                                    <ul>
                                        <li>Time in: {{date('h:i A', strtotime($tito->time_in))}}</li>
                                        <li>Time out: {{isset($tito->time_out) ? date('h:i A', strtotime($tito->time_in)) : 'NO TIME OUT'}}</li>
                                    </ul>
                                @empty
                                    NO TIME IN AND TIME OUT
                                @endforelse
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center"> NO TIME IN AND TIME OUT  </td>
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
                        <th scope="col">DATE / TIME IN / TIME OUT</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($tito['perUserBureau'] as $perUserBureau)
                    <tr>
                        <td>{{$perUserBureau->fullName}}</td>
                        <td>{{$perUserBureau->position}}</td>
                        <td>
                            @forelse ($perUserBureau->tito as $tito)
                                <label for="">{{date('F d, Y', strtotime($tito->created_at))}}</label>
                                <ul>
                                    @forelse ($tito->accomplishments as $accomplishment)
                                        <li> {{$accomplishment->accomplishment}} </li>
                                    @empty
                                        <li> NO ACCOMPLISHMENT </li>
                                    @endforelse
                                </ul>
                            @empty
                                NO TIME IN
                            @endforelse
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="text-center"> NO ACCOMPLISHMENT </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endif
