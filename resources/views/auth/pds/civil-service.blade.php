<div class="row mb-2">
    <div class="col-12 text-right">
        <button class="btn btn-success rounded-0 btn-add-civil-service-row" table='eligibilityList'>ADD ROW</button>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <table class="table table-bordered sample-table" id="eligibilityList">
            <thead>
                <tr>
                    <th>CAREER SERVICE/ RA 1080 (BOARD/ BAR) UNDER SPECIAL LAWS/ CES/ CSEE BARANGAY ELIGIBILITY / DRIVER'S LICENSE</th>
                    <th>RATING (If Applicable)</th>
                    <th>DATE OF EXAMINIATION/CONFERMENT</th>
                    <th>PLACE OF EXAMINCATION/CONFERMENT</th>
                    <th>ACTION</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><input type="text"class="form-control rounded-0" name="careerService[]" id="careerService[]"></td>
                    <td><input type="text"class="form-control rounded-0" name="careerServiceRating[]" id="careerServiceRating[]"></td>
                    <td><input type="date"class="form-control rounded-0" name="careerServiceDate[]" id="careerServiceDate[]"></td>
                    <td><input type="text"class="form-control rounded-0" name="careerServicePlace[]" id="careerServicePlace[]"></td>
                    <td><button class="btn btn-danger rounded-0 btn-remove-civil-service-row">REMOVE</button></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
