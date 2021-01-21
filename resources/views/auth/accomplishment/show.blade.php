<div class="row">
    <div class="col-12 text-center mt-2">
        <h4>
            {{date('F d, Y', strtotime($data['tito']->created_at))}} - Accomplishment
        </h4>
    </div>
    <div class="col-12 mt-3">
        <table class="table table-bordered" id="fileTbl">
            <thead>
                <tr>
                    <th scope="col" class="text-center">Accomplishment</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <ul>
                            @foreach ($data['tito']->accomplishments as $accomplishment)
                                <li>
                                    {{$accomplishment->accomplishment}}
                                    <ul>
                                        <li>{{$accomplishment->remarks}}</li>
                                    </ul>
                                </li>
                            @endforeach
                        </ul>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
