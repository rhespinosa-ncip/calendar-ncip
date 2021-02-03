<form method="POST" accept-charset="UTF-8" id="saveActionableItem" class="form-modal" enctype="multipart/form-data">
    <input type="hidden" name="meetingId" value="{{$data['minute']->id}}">
    <div class="row">
        <div class="col-12">
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="assignedPersonel" id="individual" value="individual">
                <label class="form-check-label" for="individual">Individual</label>
            </div>
            @if ($data['minute']->participant == 'bureau')
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="assignedPersonel" id="bureau" value="bureau">
                    <label class="form-check-label" for="bureau">Bureau</label>
                </div>
            @elseif($data['minute']->participant == 'department')
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="assignedPersonel" id="department" value="department">
                    <label class="form-check-label" for="department">Division</label>
                </div>
            @endif
        </div>
        <div class="col-12 mt-2">
            <div class="form-group">
                <label for="assignedPerson">Assigned personel: </label>
                <select class="form-control" name="assignedPerson" id="assignedPerson">
                    <option disabled selected>-- select personnel --</option>
                </select>
            </div>
        </div>
        <div class="col-12">
            <div class="form-group">
                <label for="actionableItem">Actionable Item: </label>
                <textarea class="form-control rounded-0" name="actionableItem" id="actionableItem"
                    cols="10" rows="5"></textarea>
            </div>
        </div>
        <div class="col-12">
            <div class="form-group">
                <label for="deadline">Deadline: </label>
                <input type="datetime-local"class="form-control rounded-0" name="deadline" id="deadline" value="">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 text-right">
             <button form="saveActionableItem" class="btn btn-success py-1 px-5 rounded-0">SAVE ACTIONABLE ITEM</button>
        </div>
    </div>
</form>
