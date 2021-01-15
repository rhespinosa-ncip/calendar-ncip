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
                @if (Auth::user()->user_type == 'admin')
                    <label for="zoomMeetingLink">Zoom meeting link: </label>
                    <input type="text" class="form-control rounded-0" name="zoomMeetingLink" id="zoomMeetingLink">
                @else
                    <label for="zoomMeetingLink">Zoom meeting link: </label>
                    <input type="text" class="form-control rounded-0 d-none" name="zoomMeetingLink" id="zoomMeetingLink" value="requestToAdmin">
                    <div class="form-check mb-1">
                        <input type="checkbox" checked class="form-check-input" id="requestZoomMeetingLink">
                        <label class="form-check-label" for="requestZoomMeetingLink">Request zoom meeting link to admin</label>
                    </div>
                @endif
            </div>
        </div>
        <div class="col-12">
            <div class="form-group">
                <label for="participant">Participant: </label>
                <div class="form-check form-check-inline">
                    <input type="checkbox" class="form-check-input" id="isIndividual" name="isIndividual">
                    <label class="form-check-label" for="isIndividual">Individual</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="participantsChoice" id="bureau" value="bureau">
                    <label class="form-check-label" for="bureau">Bureau</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="participantsChoice" id="department" value="department">
                    <label class="form-check-label" for="department">Division</label>
                </div>
                <div class="optionSelectArea">

                </div>
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
