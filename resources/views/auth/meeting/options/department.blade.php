<select name="departmentParticipant[]" id="departmentParticipant[]" class="form-control rounded-0 individualParticipant" multiple="multiple" style="display: none;">
    @foreach ($data['departments'] as $department)
        <option
        @foreach ($data['selectedDepartment'] as $selectedDepartment)
            {{$selectedDepartment->department_id == $department->id ? 'selected' : ''}}
        @endforeach
        value="{{$department->id}}">{{$department->name}}</option>
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
