<div class="row mt-1">
    <div class="col-12">
        <div class="form-group">
            <label for="groupName">Group name: </label>
            <input type="text" disabled class="form-control rounded-0" name="groupName" id="groupName" value="{{$data['group']->name}}">
        </div>
    </div>
    <div class="col-12">
        <div class="form-group">
            <label for="participant">Participant: </label>
            <select name="participant[]" disabled id="participant[]" class="form-control rounded-0 individualParticipant" multiple="multiple" style="display: none;">
                @foreach ($data['users'] as $user)
                    <option
                    @foreach ($data['group']->groupParticipant as $groupParticipant)
                        {{$user->id == $groupParticipant->user_id ? 'selected' : ''}}
                    @endforeach
                    {{$data['group']->created_by == $user->id ? 'selected' : ''}}
                        value="{{$user->id}}">{{$user->fullName}}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>
 <script>
    $("select").bsMultiSelect({
        cssPatch: {
            choices: {
                columnCount: '2'
            },
        }
    });
</script>
