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
    <div class="col-6">
        <div class="form-group">
            <label for="zoomMeetingLink">Zoom meeting id: </label>
            @if ($data['meeting']->zoom_meeting_id == '')
                <span class="badge badge-warning">
                    No zoom meeting id
                </span>
            @else
                <label for="">{{$data['meeting']->zoom_meeting_id}}</label>
            @endif
        </div>
    </div>
    <div class="col-6">
        <div class="form-group">
            <label for="zoomMeetingLink">Zoom meeting passcode: </label>
            @if ($data['meeting']->zoom_meeting_passcode == '')
                <span class="badge badge-warning">
                    No zoom meeting passcode
                </span>
            @else
                <label for="">{{$data['meeting']->zoom_meeting_passcode}}</label>
            @endif
        </div>
    </div>
    <div class="col-12">
        <div class="form-group">
            <label for="participant">Participant: </label>
            <div class="form-check form-check-inline">
                <input type="checkbox" disabled class="form-check-input" {{$data['meeting']->is_participant == 'yes' ? 'checked' : ''}} id="isIndividual" name="isIndividual">
                <label class="form-check-label" for="isIndividual">Individual</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" disabled {{$data['meeting']->participant == 'bureau' ? 'checked' : ''}} meetingId="{{$data['meeting']->id}}" type="radio" name="participantsChoice" id="bureau" value="bureau">
                <label class="form-check-label" for="bureau">Bureau</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" disabled {{$data['meeting']->participant == 'department' ? 'checked' : ''}} meetingId="{{$data['meeting']->id}}" type="radio" name="participantsChoice" id="department" value="department">
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
