$(function(){
    $('#actionableItemTable').DataTable()
    $('#fileTable').DataTable()

    $('body').on('click', '.btn-add-actionable', function(){
        actionableItem($(this).attr('meetingId'), $(this).attr('status'))
        return false
    }).on('change', '[name="assignedPersonel"]', function(event, personnelId){
        let valueRadio = $('input[name="assignedPersonel"]:checked').val()
        showForm(valueRadio, $('input[name="meetingId"]').val(), personnelId)
    }).on('submit', '#saveActionableItem', function(){
        var data = new FormData(this)
        submitActionableForm(data)
        return false
    }).on('click', '.btn-add-actionable-file', function(){
        showFormAction($(this).attr('actionableItem'))
        return false
    }).on('submit', '#saveActionableItemResponse', function(){
        var data = new FormData(this)
        let status = $(this).find("button[type=submit]:focus").attr('status')
        data.append("status", status);
        submitFormActionResponse(data)
        return false
    })
})

const submitFormActionResponse = data => {
    $.ajax({
        url: '/meeting/actionable-item/form-response/submit',
        type: 'POST',
        data: data,
        contentType: false,
        cache: false,
        processData: false,
    }).done(result => {
        if(result.message == 'success'){
            closeModal('lg')
            setTimeOut('')

            toastr.success('Actionable item responses successfully', '', {
                progressBar: true,
                timeOut: 1000,
            })
        }
    })
}

const submitActionableForm = data => {
    $.ajax({
        url: '/meeting/actionable-item/form/submit',
        type: 'POST',
        data: data,
        contentType: false,
        cache: false,
        processData: false,
    }).done(result => {
        if(result.message == 'success'){
            closeModal('lg')
            setTimeOut('')

            toastr.success('Actionable item added successfully', '', {
                progressBar: true,
                timeOut: 1000,
            })
        }
    })
}

const showForm = (value, meetingId, personnelId = '') => {
    $.ajax({
        url: '/meeting/actionable-item/option',
        type: 'GET',
        data: {value: value, meetingId: meetingId}
    }).done(result => {
        $('#assignedPerson').empty()
        $('#assignedPerson').append('<option disabled selected>-- select personnel --</option>')

        let options = '';

        if(value == 'department'){
            $.each(result.optionBD.department_participants, function (key, value) {
                let isSelected = personnelId == 'department_'+value.department.id ? 'selected' : ''

                options += '<option '+isSelected+' value="department_'+value.department.id+'">'+value.department.name+'</option>'
            });
        }else if(value == 'bureau'){
            $.each(result.optionBD.bureau_participants, function (key, value) {
                let isSelected = personnelId == 'bureau_'+value.bureau.id ? 'selected' : ''

                options += '<option '+isSelected+' value="bureau_'+value.bureau.id+'">'+value.bureau.name+'</option>'
            });
        }else if(value == 'individual'){
            $.each(result, function (key, value) {
                let isSelected = personnelId == 'user_'+value.user_id ? 'selected' : ''

                options += '<option '+isSelected+' value="user_'+value.user_id+'">'+value.user_name+'</option>'
            });
        }

        $('#assignedPerson').append(options)
    })
}

const actionableItem = (meetingId, status = '') => {
    $.ajax({
        url: '/meeting/actionable-item/form',
        type: 'GET',
        data: {meetingId: meetingId, status: status}
    }).done(result => {
        showModal({
            type: 'lg',
            title: 'Actionable Item',
            bodyContent: result.view ?? result
        })

        if(result.personnel_id == null){
            var dateToday = new Date();
            dateToday.setMinutes(dateToday.getMinutes() - dateToday.getTimezoneOffset());
            $('[name="deadline"]').attr('min', dateToday.toISOString().slice(0,16))
        }

        $('[name="assignedPersonel"]').trigger("change", [result.personnel_id]);
    })
}


const showFormAction = (actionableItem) => {
    $.ajax({
        url: '/meeting/actionable-item/form-response',
        type: 'GET',
        data: {actionableItem: actionableItem}
    }).done(result => {
        showModal({
            type: 'lg',
            title: 'Actionable Item Response',
            bodyContent: result
        })
    })
}
