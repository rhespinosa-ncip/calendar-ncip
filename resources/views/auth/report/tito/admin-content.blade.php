<div class="row mt-4">
    <div class="col-12 text-center">
        <h4>TIME IN AND TIME OUT REPORT</h4>
    </div>
</div>

@foreach ($tito as $bureau)
    @foreach ($bureau->bureauDivision as $bureauDivision)
        <div class="row mt-4">
            <div class="col-12">
                <b>
                    Office :
                </b>
                {{$bureauDivision->department->name}} - {{$bureau->name}}
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <b>
                    Period :
                </b>
                {{date('F d, Y', strtotime($dateFrom)). ' - ' .date('F d, Y', strtotime($dateTo))}}
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-12">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">NAME OF PERSONNEL</th>
                            <th scope="col">POSITION</th>
                            <th scope="col">DATE</th>
                            <th scope="col">TIME IN</th>
                            <th scope="col">TIME OUT</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($bureauDivision->department->users as $user)
                            @php
                                $count = 0;
                            @endphp
                            @forelse ($user->tito as $tito)
                                @if ($count == 0)
                                    <tr>
                                        <td class="align-middle" rowspan="{{$user->tito->count()}}">{{$user->fullName}}</td>
                                        <td class="align-middle" rowspan="{{$user->tito->count()}}">{{$user->position}}</td>
                                        <td>
                                            <label for="">{{date('F d, Y', strtotime($tito->created_at))}}</label>
                                        </td>
                                        <td>
                                            <label for="">{{date('h:i A', strtotime($tito->time_in))}}</label>
                                        </td>
                                        <td>
                                            <label for="">{{isset($tito->time_out) ? date('h:i A', strtotime($tito->time_out)) : 'NO TIME OUT'}}</label>
                                        </td>
                                    </tr>
                                    @php
                                        $count++;
                                    @endphp
                                @else
                                    <tr>
                                        <td>
                                            <label for="">{{date('F d, Y', strtotime($tito->created_at))}}</label>
                                        </td>
                                        <td>
                                            <label for="">{{date('h:i A', strtotime($tito->time_in))}}</label>
                                        </td>
                                        <td>
                                            <label for="">{{isset($tito->time_out) ? date('h:i A', strtotime($tito->time_out)) : 'NO TIME OUT'}}</label>
                                        </td>
                                    </tr>
                                @endif
                            @empty
                                <tr>
                                    <td class="align-middle">{{$user->fullName}}</td>
                                    <td class="align-middle">{{$user->position}}</td>
                                    <td colspan="3" class="text-center"> NO DTR </td>
                                </tr>
                            @endforelse
                        @empty
                            <tr>
                                <td colspan="5" class="text-center"> NO DTR </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @endforeach
@endforeach
