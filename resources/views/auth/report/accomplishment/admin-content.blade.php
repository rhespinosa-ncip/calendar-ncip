<div class="row mt-4">
    <div class="col-12 text-center">
        <h4>ACCOMPLISHMENT REPORT</h4>
    </div>
</div>

@foreach ($accomplishments as $bureau)
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
                            <th scope="col">ACCOMPLISHMENT</th>
                            <th scope="col">DATE</th>
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
                                            @forelse ($tito->accomplishments as $accomplishment)
                                                <li>
                                                    {{$accomplishment->accomplishment}}
                                                    <ul>
                                                        <li>{{$accomplishment->remarks}}</li>
                                                    </ul>
                                                </li>
                                            @empty
                                                <li> NO ACCOMPLISHMENT </li>
                                            @endforelse
                                        </td>
                                        <td class="align-middle">{{date('F d, Y', strtotime($tito->created_at))}}</td>
                                    </tr>
                                    @php
                                        $count++;
                                    @endphp
                                @else
                                    <tr>
                                        <td>
                                            @forelse ($tito->accomplishments as $accomplishment)
                                                <li>
                                                    {{$accomplishment->accomplishment}}
                                                    <ul>
                                                        <li>{{$accomplishment->remarks}}</li>
                                                    </ul>
                                                </li>
                                            @empty
                                                <li> NO ACCOMPLISHMENT </li>
                                            @endforelse
                                        </td>
                                        <td class="align-middle">{{date('F d, Y', strtotime($tito->created_at))}}</td>
                                    </tr>
                                @endif
                            @empty
                                <tr>
                                    <td>{{$user->fullName}}</td>
                                    <td>{{$user->position}}</td>
                                    <td colspan="2" class="text-center"> NO ACCOMPLISHMENT </td>
                                </tr>
                            @endforelse
                        @empty
                            <tr>
                                <td colspan="4" class="text-center"> NO ACCOMPLISHMENT </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @endforeach
@endforeach
