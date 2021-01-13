<div class="row mt-1">
    <div class="col-12">
        <div class="form-group">
            <label for="date">Date: </label>
            <input type="text"class="form-control rounded-0" disabled value="{{ date('F d, Y h:i A', strtotime($data['meeting']->date)) }}">
        </div>
    </div>
    <div class="col-12">
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text"class="form-control rounded-0" disabled value="{{$data['meeting']->title}}">
        </div>
    </div>
    <div class="col-12">
        <div class="form-group">
            <label for="description">Description: </label>
            <textarea class="form-control rounded-0" cols="10" disabled rows="5">{{$data['meeting']->description}}</textarea>
        </div>
    </div>
    <div class="col-12">
        <div class="form-group">
            <label for="zoomMeetingLink">Zoom meeting link: </label>
            @if ($data['meeting']->zoom_meeting_description == 'requestToAdmin')
                <span class="badge badge-warning">
                    No zoom meeting link
                </span>
            @else
                <a target="_blank" href="{{$data['meeting']->zoom_meeting_description}}">{{$data['meeting']->zoom_meeting_description}}</a>
            @endif
        </div>
    </div>
    <div class="col-12">
        <div class="form-group">
            @if ($data['meeting']->participant == 'department')
                <label for="participant">Department Participant: </label>
                <select class="form-control rounded-0" disabled multiple="multiple" style="display: none;">
                    @foreach ($data['department'] as $department)
                    <option
                        @foreach ($data['meeting']->departmentParticipants as $departmentParticipants)
                            {{$departmentParticipants->department_id == $department->id ? 'selected' : ''}}
                        @endforeach
                    value="{{$department->id}}">{{$department->name}}</option>
                    @endforeach
                </select>
            @elseif($data['meeting']->participant == 'individual')
                <label for="participant">Participant: </label>
                <select class="form-control rounded-0" disabled multiple="multiple" style="display: none;">
                    @foreach ($data['users'] as $user)
                    <option
                        @foreach ($data['meeting']->participants as $participant)
                            {{$participant->user_id == $user->id ? 'selected' : ''}}
                        @endforeach
                    value="{{$user->id}}">{{$user->fullName}}</option>
                    @endforeach
                </select>
            @endif
        </div>
    </div>
</div>
<hr>
<h6>Attachment:</h6>
<div class="row">
    <div class="col-12 mt-3">
        <table class="table table-bordered" id="fileTbl">
            <thead>
                <tr>
                    <th scope="col">File</th>
                </tr>
            </thead>
            <tbody>
                @if (isset($data['meeting']->documents[0]))
                    @foreach ($data['meeting']->documents as $document)
                        <tr>
                            <td><a href="/show-document/{{$document->file_path}}" target="_blank" rel="noopener noreferrer">{{$document->file_path}}</a></td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td class="text-center">NO ATTACHMENT</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>

<script>
    $("select").bsMultiSelect({
        cssPatch: {
            choices: {
                columnCount: '1'
            },
        }
    });
</script>
