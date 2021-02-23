<form method="POST" accept-charset="UTF-8" id="addGroup" class="form-modal" enctype="multipart/form-data">
    <div class="row mt-1">
        <div class="col-12">
            <div class="form-group">
                <label for="groupName">Group name: </label>
                <input type="text"class="form-control rounded-0" name="groupName" id="groupName">
            </div>
        </div>
        <div class="col-12">
            <div class="form-group">
                <label for="participant">Participant: </label>
                <select name="participant[]" id="participant[]" class="form-control rounded-0 individualParticipant" multiple="multiple" style="display: none;">
                    @foreach ($data['users'] as $user)
                        <option value="{{$user->id}}">{{$user->fullName}}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 text-right">
             <button form="addGroup" class="btn btn-success py-1 px-5 rounded-0">CREATE GROUP</button>
        </div>
    </div>
 </form>

 <script>
    $("select").bsMultiSelect({
            cssPatch: {
                choices: {
                    columnCount: '2'
                },
            }
    });
</script>
