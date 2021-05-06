$(function(){
    $('input, select').attr('disabled', true);

    $('body').on('keypress', 'form', function(event){
        if (event.which == 13) { return false; }
    }).on('change', '#dualCitizenship', function(){
        if($('input[name="dualCitizenship"]:checked').val()){
            $('.dual-show').removeClass('d-none')
            return false
        }
        $('.dual-show').addClass('d-none')
    }).on('click', '.btn-update', function(){
        $('input, select').attr('disabled', false);
        $(this).addClass('d-none')
        $('.save-button').removeClass('d-none')
        return false
    }).on('click', '.btn-add-children-row, .btn-add-civil-service-row, .btn-add-work-experience-row, .btn-add-voluntary-work-row, .btn-add-learning-and-development-row, .btn-add-special-skills-row, .btn-add-non-academic-distinction-row, .btn-add-special-skills-membership-association-row, .btn-add-references-row', function(){
        $('#'+$(this).attr('table')+' > tbody').append(formats($(this).attr('table')))
        return false
    }).on('click', '.btn-remove-children-row, .btn-remove-civil-service-row, .btn-remove-work-experience-row, .btn-remove-voluntary-work-row, .btn-remove-learning-and-development-row,.btn-remove-special-skills-row, .btn-remove-non-academic-distinction-row, .btn-remove-special-skills-membership-association-row, .btn-remove-references-row', function(){
        removeTbodyTrPDS($(this), 'children')
        return false
    }).on('submit', '#updatePDS', function(){
        savePDS($(this).serialize())
        return false
    }).on('click', '.export-button', function(){
        exportPDS()
        return false
    })
})

const formats = (tableName) => {
    switch(tableName){
        case 'childrenList':
            return  `<tr>
                        <td><input type="text"class="form-control rounded-0" name="nameOfChildren[]" id="nameOfChildren[]"></td>
                        <td><input type="date"class="form-control rounded-0" name="childrenDateOfBirth[]" id="childrenDateOfBirth[]"></td>
                        <td><button class="btn btn-danger rounded-0 btn-remove-children-row">REMOVE</button></td>
                    </tr>`
        case 'eligibilityList':
            return  `<tr>
                        <td><input type="text"class="form-control rounded-0" name="careerService[]" id="careerService[]"></td>
                        <td><input type="text"class="form-control rounded-0" name="careerServiceRating[]" id="careerServiceRating[]"></td>
                        <td><input type="date"class="form-control rounded-0" name="careerServiceDate[]" id="careerServiceDate[]"></td>
                        <td><input type="text"class="form-control rounded-0" name="careerServicePlace[]" id="careerServicePlace[]"></td>
                        <td><button class="btn btn-danger rounded-0 btn-remove-civil-service-row">REMOVE</button></td>
                    </tr>`
        case 'workExperienceTable':
            return `<tr>
                        <td><input type="text"class="form-control rounded-0" name="workExperienceTo[]" id="workExperienceTo[]"></td>
                        <td><input type="text"class="form-control rounded-0" name="workExperienceFrom[]" id="workExperienceFrom[]"></td>
                        <td><input type="text"class="form-control rounded-0" name="workExperienceCompany[]" id="workExperienceCompany[]"></td>
                        <td><input type="text"class="form-control rounded-0" name="workExperienceSalary[]" id="workExperienceSalary[]"></td>
                        <td><input type="text"class="form-control rounded-0" name="workExperienceSalaryGrade[]" id="workExperienceSalaryGrade[]"></td>
                        <td><button class="btn btn-danger rounded-0 btn-remove-work-experience-row">REMOVE</button></td>
                    </tr>`
        case 'voluntaryWorkTable':
            return `<tr>
                        <td><input type="text"class="form-control rounded-0" name="voluntaryWorknameAndAddress[]" id="voluntaryWorknameAndAddress[]"></td>
                        <td><input type="text"class="form-control rounded-0" name="voluntaryWorkInclusiveDatesFrom[]" id="voluntaryWorkInclusiveDatesFrom[]"></td>
                        <td><input type="text"class="form-control rounded-0" name="voluntaryWorkInclusiveDatesTo[]" id="voluntaryWorkInclusiveDatesTo[]"></td>
                        <td><input type="text"class="form-control rounded-0" name="voluntaryWorkNumberOfHours[]" id="voluntaryWorkNumberOfHours[]"></td>
                        <td><input type="text"class="form-control rounded-0" name="voluntaryWorkPositionNatureOfWork[]" id="voluntaryWorkPositionNatureOfWork[]"></td>
                        <td><button class="btn btn-danger rounded-0 btn-remove-voluntary-work-row">REMOVE</button></td>
                    </tr>`
        case 'learningAndDevelopmentTable':
            return `<tr>
                        <td><input type="text"class="form-control rounded-0" name="learningAndDevelopmentTitleOfLearning[]" id="learningAndDevelopmentTitleOfLearning[]"></td>
                        <td><input type="text"class="form-control rounded-0" name="learningAndDevelopmentInclusiveDatesFrom[]" id="learningAndDevelopmentInclusiveDatesFrom[]"></td>
                        <td><input type="text"class="form-control rounded-0" name="learningAndDevelopmentInclusiveDatesTo[]" id="learningAndDevelopmentInclusiveDatesTo[]"></td>
                        <td><input type="text"class="form-control rounded-0" name="learningAndDevelopmentNumberOfHours[]" id="learningAndDevelopmentNumberOfHours[]"></td>
                        <td><input type="text"class="form-control rounded-0" name="learningAndDevelopmentTypeOfLD[]" id="learningAndDevelopmentTypeOfLD[]"></td>
                        <td><input type="text"class="form-control rounded-0" name="learningAndDevelopmentconductedOrSponsoredBy[]" id="learningAndDevelopmentconductedOrSponsoredBy[]"></td>
                        <td><button class="btn btn-danger rounded-0 btn-remove-learning-and-development-row">REMOVE</button></td>
                    </tr>`
        case 'specialSkillsTable':
            return `<tr>
                        <td><input type="text"class="form-control rounded-0" name="specialSkillsAndHobbies[]" id="specialSkillsAndHobbies[]"></td>
                        <td class="text-center"><button class="btn btn-danger rounded-0 btn-remove-special-skills-row">REMOVE</button></td>
                    </tr>`
        case 'nonAcademic':
            return `<tr>
                        <td><input type="text"class="form-control rounded-0" name="nonAcademicDistinction[]" id="nonAcademicDistinction[]"></td>
                        <td class="text-center"><button class="btn btn-danger rounded-0 btn-remove-non-academic-distinction-row">REMOVE</button></td>
                    </tr>`
        case 'memberAssociation':
            return `<tr>
                        <td><input type="text"class="form-control rounded-0" name="membershipAssociation[]" id="membershipAssociation[]"></td>
                        <td class="text-center"><button class="btn btn-danger rounded-0 btn-remove-special-skills-membership-association-row">REMOVE</button></td>
                    </tr>`
        case 'referencesTable':
            return `<tr>
                        <td><input type="text"class="form-control rounded-0" name="referencesName[]" id="referencesName[]"></td>
                        <td><input type="text"class="form-control rounded-0" name="referenceAddress[]" id="referenceAddress[]"></td>
                        <td><input type="text"class="form-control rounded-0" name="referencesTelNo[]" id="referencesTelNo[]"></td>
                        <td><button class="btn btn-danger rounded-0 btn-remove-references-row">REMOVE</button></td>
                    </tr>`
        default:
            return  ''
    }
}

const removeTbodyTrPDS = thisRow => {
    Swal.fire({
        type: 'warning',
        text: 'Are you sure you want to remove row?',
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: 'Yes'
    }).then(result => {
        if (result.value) {
            $(thisRow).closest('tr').remove()
        }
    })
}

const savePDS = data => {
    $.ajax({
        url: '/pds/update',
        data: data,
        type: 'POST'
    }).done(result => {
        if(result.message == 'success'){
            setTimeOut('pds')

            toastr.success('PDS Updated successfully', '', {
                progressBar: true,
                timeOut: 1000,
            })
        }
    });
}

const exportPDS = () => {
    $.ajax({
        url: '/pds/export',
        type: 'POST'
    }).done(result => {
        if(result.message == 'success'){
            
        }
    });
}

