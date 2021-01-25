<form method="POST" accept-charset="UTF-8" id="submitRemakrs" class="form-modal" enctype="multipart/form-data">
    <input type="hidden" name="meetingMinutesId" value="{{$data['minute']->id}}">
    <div class="row">
        <div class="col-12">
            <div class="form-group">
                <label for="remarks">Remarks: </label>
                <textarea class="form-control rounded-0" name="remarks" id="remarks"
                    cols="10" rows="5"></textarea>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 text-right">
             <button form="submitRemakrs" class="btn btn-success py-1 px-5 rounded-0">SUBMIT REMARKS</button>
        </div>
    </div>
</form>
