<form method="POST" accept-charset="UTF-8" id="updateMeetingLink" class="form-modal" enctype="multipart/form-data">
    <input type="hidden" name="meetingId" value="{{$meeting->id}}">
    <div class="row mt-1">
        <div class="col-12">
            <div class="form-group">
                <label>Meeting Title: </label>
                <input type="text"class="form-control rounded-0" disabled value="{{$meeting->title}}">
            </div>
        </div>
        <div class="col-12">
            <div class="form-group">
                <label for="meetingLink">Meeting link: </label>
                <input type="text"class="form-control rounded-0" name="meetingLink" id="meetingLink" value="{{$meeting->zoom_meeting_description == 'requestToAdmin' ? '' : $meeting->zoom_meeting_description}}">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 text-right">
             <button form="updateMeetingLink" class="btn btn-success py-1 px-5 rounded-0">UPDATE MEETING LINK</button>
        </div>
    </div>
 </form>
