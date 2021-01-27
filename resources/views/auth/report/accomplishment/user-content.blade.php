<div class="row mt-4">
    <div class="col-12 text-center">
        <h4>ACCOMPLISHMENT REPORT</h4>
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
                    <th scope="col">ACCOMPLISHMENT</th>
                    <th scope="col">DATE</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $count = 0;
                @endphp
                @forelse($accomplishments as $accomplishment)
                    @if ($count == 0)
                        <tr>
                            <td class="align-middle" rowspan="{{$accomplishment->accomplishments->count()}}">{{$accomplishment->user->fullName}}</td>
                            <td class="align-middle" rowspan="{{$accomplishment->accomplishments->count()}}">{{$accomplishment->user->position}}</td>
                            <td>
                                <ul>
                                    @forelse ($accomplishment->accomplishments as $accomplishment)
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
                                <label for="">{{date('F d, Y', strtotime($accomplishment->created_at))}}</label>
                            </td>
                        </tr>
                        @php
                            $count++;
                        @endphp
                    @else
                        <tr>
                            <td>
                                <ul>
                                    @forelse ($accomplishment->accomplishments as $accomplishment)
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
                                <label for="">{{date('F d, Y', strtotime($accomplishment->created_at))}}</label>
                            </td>
                        </tr>
                    @endif
                @empty

                        <td class="align-middle">{{$accomplishment->user->fullName}}</td>
                        <td class="align-middle">{{$accomplishment->user->position}}</td>
                        <td colspan="2" class="text-center"> NO ACCOMPLISHMENT </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
