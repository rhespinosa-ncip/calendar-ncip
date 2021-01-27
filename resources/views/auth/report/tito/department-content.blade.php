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
        {{Auth::user()->department->name}} - {{Auth::user()->bureau->name ?? ''}}
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
                @forelse ($tito as $tito)
                    @php
                        $count = 0;
                    @endphp
                    @forelse ($tito->tito as $titoValue)
                        @if ($count == 0)
                            <tr>
                                <td class="align-middle" rowspan="{{$tito->tito->count()}}">{{$tito->fullName}}</td>
                                <td class="align-middle" rowspan="{{$tito->tito->count()}}">{{$tito->position}}</td>
                                <td>
                                    <label>{{date('F d, Y', strtotime($titoValue->created_at))}}</label>
                                </td>
                                <td>
                                    <label>{{date('h:i A', strtotime($titoValue->time_in))}}</label>
                                </td>
                                <td>
                                    <label>{{isset($titoValue->time_out) ? date('h:i A', strtotime($titoValue->time_in)) : 'NO TIME OUT'}}</label>
                                </td>
                            </tr>
                            @php
                                $count++;
                            @endphp
                        @else
                            <tr>
                                <td>
                                    <label>{{date('F d, Y', strtotime($titoValue->created_at))}}</label>
                                </td>
                                <td>
                                    <label>{{date('h:i A', strtotime($titoValue->time_in))}}</label>
                                </td>
                                <td>
                                    <label>{{isset($titoValue->time_out) ? date('h:i A', strtotime($titoValue->time_in)) : 'NO TIME OUT'}}</label>
                                </td>
                            </tr>
                        @endif
                    @empty
                        <tr>
                            <td class="align-middle">{{$tito->fullName}}</td>
                            <td class="align-middle">{{$tito->position}}</td>
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
