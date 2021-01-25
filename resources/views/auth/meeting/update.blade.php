<form method="POST" accept-charset="UTF-8" id="updateMeeting" class="form-modal" enctype="multipart/form-data">
    <input type="hidden" name="documentIds" id="documentIds">
    <input type="hidden" name="meetingId" value="{{$data['meeting']->id}}">
    <div class="row mt-1">
         <div class="col-12">
             <div class="form-group">
                 <label for="date">Date: </label>
                 <input type="datetime-local"class="form-control rounded-0" name="date" id="date" value="{{ date('Y-m-d\TH:i', strtotime($data['meeting']->date)) }}">
             </div>
         </div>
         <div class="col-12">
             <div class="form-group">
                 <label for="title">Title</label>
                 <input type="text"class="form-control rounded-0" name="title" id="title" value="{{$data['meeting']->title}}">
             </div>
         </div>
         <div class="col-12">
             <div class="form-group">
                 <label for="description">Description: </label>
                 <textarea class="form-control rounded-0" name="description" id="description"
                     cols="10" rows="5">{{$data['meeting']->description}}</textarea>
             </div>
         </div>
         @if ($data['meeting']->zoom_meeting_description == 'requestToAdmin')
            @php
                $isChecked = 'checked';
                $isInputNotShow = 'd-none';
                $inputZoomMeeting = 'requestToAdmin';
            @endphp
        @endif

        @if (Auth::user()->user_type == 'admin')
            <div class="col-12">
                <div class="form-group">
                    <label for="zoomMeetingLink">Zoom meeting link: </label>
                    <input type="text" class="form-control rounded-0" name="zoomMeetingLink" id="zoomMeetingLink" value="{{$data['meeting']->zoom_meeting_description}}">
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="zoomMeetingId">Zoom meeting id: </label>
                    <input type="text" class="form-control rounded-0 d-none" name="zoomMeetingId" id="zoomMeetingId" value="{{$data['meeting']->zoom_meeting_id}}">
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="zoomMeetingPasscode">Zoom meeting passcode: </label>
                    <input type="text" class="form-control rounded-0 d-none" name="zoomMeetingPasscode" id="zoomMeetingPasscode" value="{{$data['meeting']->zoom_meeting_passcode}}">
                </div>
            </div>
        @else
            <div class="col-12">
                <div class="form-group">
                    <label for="zoomMeetingLink">Zoom meeting link: </label>
                    <input type="text" class="form-control rounded-0 {{$isInputNotShow ?? ''}}" name="zoomMeetingLink" id="zoomMeetingLink" value="{{$inputZoomMeeting ?? $data['meeting']->zoom_meeting_description}}">
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="zoomMeetingId">Zoom meeting id: </label>
                    <input type="text" class="form-control rounded-0 {{$isInputNotShow ?? ''}}" name="zoomMeetingId" id="zoomMeetingId" value="{{$data['meeting']->zoom_meeting_id}}">
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="zoomMeetingPasscode">Zoom meeting passcode: </label>
                    <input type="text" class="form-control rounded-0 {{$isInputNotShow ?? ''}}" name="zoomMeetingPasscode" id="zoomMeetingPasscode" value="{{$data['meeting']->zoom_meeting_passcode}}">
                </div>
            </div>
            <div class="col-12">
                <div class="form-check mb-1">
                    <input type="checkbox" {{$isChecked ?? ''}}  class="form-check-input" id="requestZoomMeetingLink" name="requestZoomMeetingLink">
                    <label class="form-check-label" for="requestZoomMeetingLink">Request zoom meeting link to admin</label>
                </div>
            </div>
        @endif
         <div class="col-12">
             <div class="form-group">
                <label for="participant">Participant: </label>
                <div class="form-check form-check-inline">
                    <input type="checkbox" class="form-check-input" {{$data['meeting']->is_participant == 'yes' ? 'checked' : ''}} id="isIndividual" name="isIndividual">
                    <label class="form-check-label" for="isIndividual">Individual</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" {{$data['meeting']->participant == 'bureau' ? 'checked' : ''}} meetingId="{{$data['meeting']->id}}" type="radio" name="participantsChoice" id="bureau" value="bureau">
                    <label class="form-check-label" for="bureau">Bureau</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" {{$data['meeting']->participant == 'department' ? 'checked' : ''}} meetingId="{{$data['meeting']->id}}" type="radio" name="participantsChoice" id="department" value="department">
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
                     @foreach ($data['meeting']->documents as $document)
                         <tr>
                             <td><a href="/show-document/{{$document->file_path}}" target="_blank" rel="noopener noreferrer">{{$document->file_path}}</a></td>
                             <td>
                                <button class="btn btn-danger rounded-0 py-1 btn-remove-file" document-id="{{$document->id}}">
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
             <button form="updateMeeting" class="btn btn-success py-1 px-5 rounded-0">UPDATE THIS MEETING</button>
        </div>
    </div>
 </form>
