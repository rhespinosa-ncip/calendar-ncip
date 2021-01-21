<form method="POST" accept-charset="UTF-8" id="saveAccomplishment" class="form-modal" enctype="multipart/form-data">
    <input type="hidden" name="titoId" id="titoId" value="{{$data['titoId']}}">
    <input type="hidden" name="documentIds" id="documentIds" value="">
    <div class="row">
        <div class="col-12 text-right">
            <button class="btn btn-info py-1 px-5 rounded-0 add-accomplishment">Add accomplishment</button>
        </div>
        <div class="col-12 mt-3">
            <table class="table table-bordered" id="fileTbl">
                <thead>
                    <tr>
                        <th scope="col">Accomplishment</th>
                        <th scope="col">Remarks</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data['tito']->accomplishments as $accomplishment)
                        <tr>
                            <td>
                                <input class="form-control" name="accomplishment[]" id="accomplishment[]" type="text" value="{{$accomplishment->accomplishment}}">
                            </td>
                            <td>
                                <input class="form-control" name="remarks[]" id="remarks[]" type="text" value="{{$accomplishment->remarks}}">
                            </td>
                            <td>
                                <button class="btn btn-danger rounded-0 py-1 btn-remove-file" document-id="{{$accomplishment->id}}">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                    <tr>
                        <td>
                            <input class="form-control" name="accomplishment[]" id="accomplishment[]" type="text">
                        </td>
                        <td>
                            <input class="form-control" name="remarks[]" id="remarks[]" type="text">
                        </td>
                        <td>
                            <button class="btn btn-danger rounded-0 py-1 btn-remove-file">
                                <i class="fa fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-12 text-right">
             <button form="saveAccomplishment" class="btn btn-success py-1 px-5 rounded-0">SAVE ACCOMPLISHMENT</button>
        </div>
    </div>
</form>
