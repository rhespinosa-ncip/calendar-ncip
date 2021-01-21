<div class="row mt-4">
    <div class="col-12 text-center">
        <h4>TIME IN AND TIME OUT REPORT</h4>
    </div>
</div>
<div class="row mt-2">
    <div class="col-12">
        <b>
            Office :
        </b>
        @if (isset(Auth::user()->department->name))
            {{Auth::user()->department->name}} -
        @endif {{Auth::user()->bureau->name ?? ''}}
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
                <tr>
                    <td>{{$tito->fullName}}</td>
                    <td>{{$tito->position}}</td>
                    <td>
                        @forelse ($tito->tito as $tito)
                            <label>{{date('F d, Y', strtotime($tito->created_at))}}</label>
                            <ul>
                                <li>Time in: {{date('h:i A', strtotime($tito->time_in))}}</li>
                                <li>Time out: {{isset($tito->time_out) ? date('h:i A', strtotime($tito->time_in)) : 'NO TIME OUT'}}</li>
                            </ul>
                        @empty
                            NO DTR
                        @endforelse
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
