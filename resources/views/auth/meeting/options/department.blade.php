<select {{date("Y-m-d H:i", strtotime($meeting->date)) >= date("Y-m-d H:i") ? '' : 'disabled'}} name="departmentParticipant[]" id="departmentParticipant[]" class="form-control rounded-0 individualParticipant" multiple="multiple" style="display: none;">
    @foreach ($data['departments'] as $department)
        <option
        @foreach ($data['selectedDepartment'] as $selectedDepartment)
            {{$selectedDepartment->department_id == $department->id ? 'selected' : ''}}
        @endforeach
        value="department-{{$department->id}}">{{$department->name}}</option>
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
