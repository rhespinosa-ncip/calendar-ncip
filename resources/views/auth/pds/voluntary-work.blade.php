<div class="row mb-2">
    <div class="col-12 text-right">
        <button class="btn btn-success rounded-0 btn-add-voluntary-work-row" table="voluntaryWorkTable">ADD ROW</button>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <table class="table table-bordered sample-table" id="voluntaryWorkTable">
            <thead class="text-center">
                <tr>
                    <th rowspan="2">NAME & ADDRESS OF ORGANIZATION (Write in Full)</th>
                    <th colspan="2">INCLUSIVE DATES</th>
                    <th rowspan="2">NUMBER OF HOURS</th>
                    <th rowspan="2">POSITION / NATURE OF WORK</th>
                    <th rowspan="2">ACTION</th>
                </tr>
                <tr>
                    <th>From</th>
                    <th>To</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><input type="text"class="form-control rounded-0" name="voluntaryWorknameAndAddress[]" id="voluntaryWorknameAndAddress[]"></td>
                    <td><input type="text"class="form-control rounded-0" name="voluntaryWorkInclusiveDatesFrom[]" id="voluntaryWorkInclusiveDatesFrom[]"></td>
                    <td><input type="text"class="form-control rounded-0" name="voluntaryWorkInclusiveDatesTo[]" id="voluntaryWorkInclusiveDatesTo[]"></td>
                    <td><input type="text"class="form-control rounded-0" name="voluntaryWorkNumberOfHours[]" id="voluntaryWorkNumberOfHours[]"></td>
                    <td><input type="text"class="form-control rounded-0" name="voluntaryWorkPositionNatureOfWork[]" id="voluntaryWorkPositionNatureOfWork[]"></td>
                    <td><button class="btn btn-danger rounded-0 btn-remove-voluntary-work-row">REMOVE</button></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
