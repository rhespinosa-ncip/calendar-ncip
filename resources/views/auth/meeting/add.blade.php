<form method="POST" accept-charset="UTF-8" id="addMeeting" class="form-modal" enctype="multipart/form-data">
   <div class="row mt-1">
        <div class="col-12">
            <div class="form-group">
                <label for="date">Date: </label>
                <input type="datetime-local"class="form-control rounded-0" name="date" id="date">
            </div>
        </div>
        <div class="col-12">
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text"class="form-control rounded-0" name="title" id="title">
            </div>
        </div>
        <div class="col-12">
            <div class="form-group">
                <label for="description">Description: </label>
                <textarea class="form-control rounded-0" name="description" id="description"
                    cols="10" rows="5"></textarea>
            </div>
        </div>
        <div class="col-12">
            <div class="form-group">
                <label for="zoomMeetingLink">Zoom meeting link: </label>
                <input type="text"class="form-control rounded-0" name="zoomMeetingLink" id="zoomMeetingLink">
            </div>
        </div>
        <div class="col-12">
            <div class="form-group">
                <label for="participant">Participant: </label>
                <select name="participant[]" id="participant[]" class="form-control rounded-0" multiple="multiple" style="display: none;">
                    @foreach ($data['users'] as $user)
                        <option value="{{$user->id}}">{{$user->fullName}}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
   <hr>
   <h6>Attachment:</h6>
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
            <button form="addMeeting" class="btn btn-success py-1 px-5 rounded-0">ADD THIS MEETING</button>
       </div>
   </div>
</form>