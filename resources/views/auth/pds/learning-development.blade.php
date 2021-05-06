<div class="row mb-2">
    <div class="col-12 text-right">
        <button class="btn btn-success rounded-0 btn-add-learning-and-development-row" table="learningAndDevelopmentTable">ADD ROW</button>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <table class="table table-bordered sample-table" id="learningAndDevelopmentTable">
            <thead class="text-center">
                <tr>
                    <th rowspan="2">TITLE OF LEARNING AND DEVELOPMENT INTERVENTIONS/TRAINING PROGRAMS (Write in Full)</th>
                    <th colspan="2">INCLUSIVE DATES OF ATTENDANCE</th>
                    <th rowspan="2">NUMBER OF HOURS</th>
                    <th rowspan="2">TYPE OF LD (MANAGERIAL/SUPERVISORY/THECNICAL/ETC)</th>
                    <th rowspan="2">CONDUCTED/ SPONSORED BY (Write in Full)</th>
                    <th rowspan="2">ACTION</th>
                </tr>
                <tr>
                    <th>From</th>
                    <th>To</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><input type="text"class="form-control rounded-0" name="learningAndDevelopmentTitleOfLearning[]" id="learningAndDevelopmentTitleOfLearning[]"></td>
                    <td><input type="text"class="form-control rounded-0" name="learningAndDevelopmentInclusiveDatesFrom[]" id="learningAndDevelopmentInclusiveDatesFrom[]"></td>
                    <td><input type="text"class="form-control rounded-0" name="learningAndDevelopmentInclusiveDatesTo[]" id="learningAndDevelopmentInclusiveDatesTo[]"></td>
                    <td><input type="text"class="form-control rounded-0" name="learningAndDevelopmentNumberOfHours[]" id="learningAndDevelopmentNumberOfHours[]"></td>
                    <td><input type="text"class="form-control rounded-0" name="learningAndDevelopmentTypeOfLD[]" id="learningAndDevelopmentTypeOfLD[]"></td>
                    <td><input type="text"class="form-control rounded-0" name="learningAndDevelopmentconductedOrSponsoredBy[]" id="learningAndDevelopmentconductedOrSponsoredBy[]"></td>
                    <td><button class="btn btn-danger rounded-0 btn-remove-learning-and-development-row">REMOVE</button></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>