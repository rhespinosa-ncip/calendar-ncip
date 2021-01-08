<select name="participant[]" id="participant[]" class="form-control rounded-0 individualParticipant" multiple="multiple" style="display: none;">
    @foreach ($data['users'] as $user)
        <option
        @foreach ($data['selectedParticipant'] as $selectedParticipant)
            {{$selectedParticipant->user_id == $user->id ? 'selected' : ''}}
        @endforeach
        value="{{$user->id}}">{{$user->fullName}}</option>
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
