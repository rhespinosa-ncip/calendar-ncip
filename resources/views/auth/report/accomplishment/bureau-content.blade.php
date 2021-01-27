<div class="row mt-4">
    <div class="col-12 text-center">
        <h4>ACCOMPLISHMENT REPORT</h4>
    </div>
</div>
@foreach ($accomplishments['perDepartment'] as $perDepartment)
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
                        <th scope="col">ACCOMPLISHMENT</th>
                        <th scope="col">DATE</th>
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
                                    <td>
                                        <ul>
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
                                        </ul>
                                    </td>
                                    <td class="align-middle" >
                                        <label for="">{{date('F d, Y', strtotime($tito->created_at))}}</label>
                                    </td>
                                </tr>
                                @php
                                    $count++;
                                @endphp
                            @else
                                <tr>
                                    <td>
                                        <ul>
                                            @forelse ($tito->accomplishments as $accomplishment)
                                                <li> {{$accomplishment->accomplishment}} </li>
                                            @empty
                                                <li> NO ACCOMPLISHMENT </li>
                                            @endforelse
                                        </ul>
                                    </td>
                                    <td class="align-middle" >
                                        <label for="">{{date('F d, Y', strtotime($tito->created_at))}}</label>
                                    </td>
                                </tr>
                            @endif
                        @empty
                            <tr>
                                <td class="align-middle">{{$user->fullName}}</td>
                                <td class="align-middle">{{$user->position}}</td>
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

@if ($accomplishments['haveUser'] != 'none')
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
                        <th scope="col">ACCOMPLISHMENT</th>
                        <th scope="col">DATE</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($accomplishments['perUserBureau'] as $perUserBureau)
                    @php
                        $count = 0;
                    @endphp
                        @forelse ($perUserBureau->tito as $tito)
                            @if ($count == 0)
                                <tr>
                                    <td class="align-middle" rowspan="{{$perUserBureau->tito->count()}}">{{$perUserBureau->fullName}}</td>
                                    <td class="align-middle" rowspan="{{$perUserBureau->tito->count()}}">{{$perUserBureau->position}}</td>
                                    <td>
                                        <ul>
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
                                        </ul>
                                    </td>
                                    <td class="align-middle">
                                        <label for="">{{date('F d, Y', strtotime($tito->created_at))}}</label>
                                    </td>
                                </tr>
                                @php
                                    $count++;
                                @endphp
                            @else
                                <tr>
                                    <td>
                                        <ul>
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
                                        </ul>
                                    </td>
                                    <td class="align-middle">
                                        <label for="">{{date('F d, Y', strtotime($tito->created_at))}}</label>
                                    </td>
                                </tr>
                            @endif
                        @empty
                            <tr>
                                <td class="align-middle">{{$perUserBureau->fullName}}</td>
                                <td class="align-middle">{{$perUserBureau->position}}</td>
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
@endif
