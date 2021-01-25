<div class="row">
    <div class="col-12">
        <table class="table table-bordered" id="fileTbl">
            <thead>
                <tr>
                    <th scope="col">Remarks</th>
                    <th scope="col">Remarks by</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data['minute']->remarks as $remark)
                    <tr>
                        <td><textarea class="border-0 form-control">{{$remark->remarks}}</textarea></td>
                        <td>{{$remark->user->fullName}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
