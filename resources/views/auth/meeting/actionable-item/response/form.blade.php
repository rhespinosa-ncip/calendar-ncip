<form method="POST" accept-charset="UTF-8" id="saveActionableItemResponse" class="form-modal" enctype="multipart/form-data">
    <input type="hidden" name="actionableItem" value="{{$data['actionableItem']->id}}">
    <input type="hidden" name="documentIds" id="documentIds">
    <div class="row">
        <div class="col-12 text-right">
            <button class="btn btn-info py-1 px-5 rounded-0 add-file">Add file</button>
        </div>
        <div class="col-12 mt-3">
            <table class="table table-bordered" id="fileTbl">
                <thead>
                    <tr>
                        <th scope="col">File</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data['actionableItem']->documentsResponse as $documentsResponse)
                        <tr>
                            <td><a target="_blank" href="/show-document/{{$documentsResponse->file_path}}">{{$documentsResponse->file_path}}</a></td>
                            <td>
                                <button class="btn btn-danger rounded-0 py-1 btn-remove-file" document-id="{{$documentsResponse->id}}">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                    <tr>
                        <td><input type="file" class="form-control-file" id="file[]" name="file[]"></td>
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
             <button type="submit" form="saveActionableItemResponse" status="on-going" class="btn btn-info py-1 px-5 rounded-0">ON-GOING</button>
             <button type="submit" form="saveActionableItemResponse" status="done" class="btn btn-success py-1 px-5 rounded-0">DONE</button>
        </div>
    </div>
</form>
