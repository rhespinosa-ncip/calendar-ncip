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
         <div class="col-12">
             <div class="form-group">
                 <label for="zoomMeetingLink">Zoom meeting link: </label>
                 <input type="text"class="form-control rounded-0" name="zoomMeetingLink" id="zoomMeetingLink" value="{{$data['meeting']->zoom_meeting_description}}">
             </div>
         </div>
         <div class="col-12">
             <div class="form-group">
                 <label for="participant">Participant: </label>
                 <select name="participant[]" id="participant[]" class="form-control rounded-0" multiple="multiple" style="display: none;">
                     @foreach ($data['users'] as $user)
                        <option 
                            @foreach ($data['meeting']->participants as $participant)
                                {{$participant->user_id == $user->id ? 'selected' : ''}}
                            @endforeach
                        value="{{$user->id}}">{{$user->fullName}}</option>
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