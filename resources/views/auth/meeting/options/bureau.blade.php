<select {{isset($meeting->date) ? date("Y-m-d H:i", strtotime($meeting->date)) >= date("Y-m-d H:i") ? '' : 'disabled' : ''}} name="bureauParticipant[]" id="bureauParticipant[]" class="form-control rounded-0 bureauParticipant" multiple="multiple" style="display: none;">
    @foreach ($data['bureau'] as $bureau)
        <option
        @foreach ($data['selectedBureau'] as $selectedBureau)
            {{$selectedBureau->bureau_id == $bureau->id ? 'selected' : ''}}
        @endforeach
        value="bureau-{{$bureau->id}}">{{$bureau->name}}</option>
    @endforeach
    @foreach ($data['participant'] as $participant)
    <option
        @foreach ($data['selectedParticipant'] as $selectedParticipant)
            {{$selectedParticipant->user_id == $participant->id ? 'selected' : ''}}
        @endforeach
        value="participant-{{$participant->id}}">{{$participant->fullName}}</option>
    @endforeach
</select>

<script>
    $("select").bsMultiSelect({
            cssPatch: {
                choices: {
                    columnCount: '1'
                },
            }
    });
</script>
