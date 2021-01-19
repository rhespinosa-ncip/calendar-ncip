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
                            <th scope="col">DATE / TIME IN / TIME OUT</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($bureauDivision->department->users as $user)
                            <tr>
                                <td>{{$user->fullName}}</td>
                                <td>{{$user->position}}</td>
                                <td>
                                    @forelse ($user->tito as $tito)
                                        <label for="">{{date('F d, Y', strtotime($tito->created_at))}}</label>
                                        <ul>
                                            <li>Time in: {{date('h:i A', strtotime($tito->time_in))}}</li>
                                            <li>Time out: {{isset($tito->time_out) ? date('h:i A', strtotime($tito->time_in)) : 'NO TIME OUT'}}</li>
                                        </ul>
                                    @empty
                                        <li> NO TIME IN AND TIME OUT </li>
                                    @endforelse
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center"> NO TIME IN AND TIME OUT </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @endforeach
@endforeach
