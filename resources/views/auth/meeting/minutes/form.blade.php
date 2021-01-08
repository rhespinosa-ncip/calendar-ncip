<form method="POST" accept-charset="UTF-8" id="saveMinutes" class="form-modal" enctype="multipart/form-data">
    <input type="hidden" name="meetingMinutesId" value="{{$data['minute']->id}}">
    <input type="hidden" name="documentIds" id="documentIds" value="">
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
                    @if (isset($data['minute']->minuteDocuments))
                        @foreach ($data['minute']->minuteDocuments as $document)
                            <tr>
                                <td>
                                    <a href="/show-document/{{$document->file_path}}" target="_blank" rel="noopener noreferrer">{{$document->file_path}}</a>
                                </td>
                                <td>
                                    <button class="btn btn-danger rounded-0 py-1 btn-remove-file" document-id="{{$document->id}}">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    @endif
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
             <button form="saveMinutes" class="btn btn-success py-1 px-5 rounded-0">SAVE FILE</button>
        </div>
    </div>
</form>
