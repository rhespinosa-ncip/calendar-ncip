<div class="row mb-2">
    <div class="col-12 text-right">
        <button class="btn btn-success rounded-0 btn-add-work-experience-row" table="workExperienceTable">ADD ROW</button>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <table class="table table-bordered sample-table" id="workExperienceTable">
            <thead class="text-center">
                <tr>
                    <th colspan="2">INLCUSIVE DATES</th>
                    <th rowspan="2">DEPARTMENT / AGENCY / OFFICE / COMPANY (Write in full/Do not abbreviate)</th>
                    <th rowspan="2">MONTHLY SALARY</th>
                    <th rowspan="2">SALARY/ JOB/ PAY GRADE (if applicable)& STEP  (Format "00-0")/ INCREMENT</th>
                    <th rowspan="2">ACTION</th>
                </tr>
                <tr>
                    <th>From</th>
                    <th>To</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($data['user']->workExperience as $workExperience)
                    <tr>
                        <td><input type="date"class="form-control rounded-0" name="workExperienceTo[]" id="workExperienceTo[]" value="{{$workExperience->from}}"></td>
                        <td><input type="date"class="form-control rounded-0" name="workExperienceFrom[]" id="workExperienceFrom[]" value="{{$workExperience->to}}"></td>
                        <td><input type="text"class="form-control rounded-0" name="workExperienceCompany[]" id="workExperienceCompany[]" value="{{$workExperience->name}}"></td>
                        <td><input type="text"class="form-control rounded-0" name="workExperienceSalary[]" id="workExperienceSalary[]" value="{{$workExperience->monthly_salary}}"></td>
                        <td><input type="text"class="form-control rounded-0" name="workExperienceSalaryGrade[]" id="workExperienceSalaryGrade[]" value="{{$workExperience->salary_grade}}"></td>
                        <td><button class="btn btn-danger rounded-0 btn-remove-work-experience-row">REMOVE</button></td>
                    </tr>
                @empty
                    <tr>
                        <td><input type="date"class="form-control rounded-0" name="workExperienceTo[]" id="workExperienceTo[]"></td>
                        <td><input type="date"class="form-control rounded-0" name="workExperienceFrom[]" id="workExperienceFrom[]"></td>
                        <td><input type="text"class="form-control rounded-0" name="workExperienceCompany[]" id="workExperienceCompany[]"></td>
                        <td><input type="text"class="form-control rounded-0" name="workExperienceSalary[]" id="workExperienceSalary[]"></td>
                        <td><input type="text"class="form-control rounded-0" name="workExperienceSalaryGrade[]" id="workExperienceSalaryGrade[]"></td>
                        <td><button class="btn btn-danger rounded-0 btn-remove-work-experience-row">REMOVE</button></td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
