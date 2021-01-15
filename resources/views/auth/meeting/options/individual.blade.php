<select name="participant[]" id="participant[]" class="form-control rounded-0 individualParticipant" multiple="multiple" style="display: none;">
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
