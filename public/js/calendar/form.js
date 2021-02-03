$(function(){
    $('.btn-add-meeting').click(function(){
        showAddMeeting()
        return false
    })

    $('body').on('submit', '#addMeeting', function(){
        var data = new FormData(this)
        submitMeeting(data)
        return false
    }).on('submit', '#updateMeeting', function(){
        var data = new FormData(this)
        data.append("meetingStatus", 'update');
        submitMeeting(data)
        return false
    }).on('click', '.btn-show-meeting', function(){
        showMeeting($(this).attr('meetingId'))
        return false
    }).on('change', '#requestZoomMeetingLink', function(){
        if($(this).is(":checked") == true){
            $('#zoomMeetingLink').addClass('d-none')
            $('#zoomMeetingId').addClass('d-none')
            $('#zoomMeetingPasscode').addClass('d-none')
            $('#zoomMeetingLink').val('requestToAdmin')
            $('#zoomMeetingId').val('')
            $('#zoomMeetingPasscode').val('')
        }else{
            $('#zoomMeetingLink').removeClass('d-none')
            $('#zoomMeetingId').removeClass('d-none')
            $('#zoomMeetingPasscode').removeClass('d-none')
            $('#zoomMeetingLink').val('')
            $('#zoomMeetingId').val('')
            $('#zoomMeetingPasscode').val('')
        }
        return false
    }).on('change', '[name="participantsChoice"], #isIndividual', function(){
        let valueRadio = $('input[name="participantsChoice"]:checked').val()
        let valueCheck = $('#isIndividual:checked').val()
        showOptions(valueRadio, $(this).attr('meetingId'), valueCheck)
        return false
    }).on('click', '.btn-add-minutes', function(){
        maintenanceMinutes($(this).attr('meetingId'))
        return false
    }).on('click', '.btn-add-remarks', function(){
        maintenanceRemarks($(this).attr('meetingId'))
        return false
    }).on('submit', '#saveMinutes', function(){
        var data = new FormData(this)
        saveMinutes(data)
        return false
    }).on('click', '.btn-view-minutes', function(){
        maintenanceMinutes($(this).attr('meetingId'), 'showOnly')
        return false
    }).on('submit', '#submitRemakrs', function(){
        submitRemarks($(this).serialize())
        return false
    }).on('click', '.view-remarks', function(){
        maintenanceRemarks($(this).attr('meetingId'), 'showOnly')
        return false
    })

    showEndedMeeting()
})

const showOptions = (value, meetingId = 0, valueCheck) => {
    $.ajax({
        url: '/meeting/add/option',
        type: 'GET',
        data: {value: value, meetingId: meetingId, valueCheck: valueCheck}
    }).done(result => {
        $('.optionSelectArea').empty()
        $('.optionSelectArea').append(result)
    })
}

const maintenanceRemarks = (meetingId, status = '') => {
    $.ajax({
        url: '/meeting/add/remarks',
        type: 'GET',
        data: {meetingId: meetingId, status: status}
    }).done(result => {
        showModal({
            type: status == '' ? '' : 'lg',
            title: status == '' ? 'Add remarks' : 'Remarks',
            bodyContent: result
        })
    })
}

const submitRemarks = data => {
    $.ajax({
        url: '/meeting/add/remarks/submit',
        type: 'POST',
        data: data
    }).done(result => {
        if(result.message == 'success'){
            closeModal('')
            setTimeOut('/')

            toastr.success('Remarks submitted successfully', '', {
                progressBar: true,
                timeOut: 1000,
            })
        }
    })
}

const showAddMeeting = () => {
    $.ajax({
        url: '/meeting/add',
        type: 'GET',
    }).done(result => {
        showModal({
            type: 'lg',
            title: 'Add meeting',
            bodyContent: result
        })

        var dateToday = new Date();
        dateToday.setMinutes(dateToday.getMinutes() - dateToday.getTimezoneOffset());
        $('[name="date"]').attr('min', dateToday.toISOString().slice(0,16))
    })
}

const submitMeeting = data => {
    $.ajax({
        url: '/meeting/add/submit',
        type: 'POST',
        data: data,
        contentType: false,
        cache: false,
        processData: false,
    }).done(result => {
        if(result.message == 'success'){
            closeModal('lg')
            setTimeOut('/')

            toastr.success('Meeting added successfully', '', {
                progressBar: true,
                timeOut: 1000,
            })
        }else if(result.message == 'updateSuccess'){
            closeModal('lg')
            setTimeOut('/')

            toastr.success('Meeting updates successfully', '', {
                progressBar: true,
                timeOut: 1000,
            })
        }
    })
}

const showMeeting = meetingId => {
    $.ajax({
        url: '/meeting/show',
        type: 'GET',
        data: {meetingId: meetingId}
    }).done(result => {
        showModal({
            type: 'lg',
            title: 'Meeting',
            bodyContent: result
        })

        $('[name="participantsChoice"]').trigger("change");

        var dateToday = new Date();
        dateToday.setMinutes(dateToday.getMinutes() - dateToday.getTimezoneOffset());
        $('[name="date"]').attr('min', dateToday.toISOString().slice(0,16))
    })
}

const showEndedMeeting = () => {
    $('#endedMeetingList').DataTable({
        searchDelay: 500,
        pagingType: 'full_numbers',
        iDisplayLength: 10,
        processing: true,
        serverSide: true,
        initComplete: function( settings, json ) {
            closeLoader()
        },
        drawCallback: function( settings ) {
            closeLoader()
        },
        columns: [
            {
                data: 'title',
                name: 'title'
            },
            {
                data: 'meeting_schedule',
                name: 'meeting_schedule',
                orderable: false
            },
            {
                data: 'action',
                name: 'action',
                orderable: false
            },

        ],
        ajax: {
            url: '/meeting/ended-meeting/list',
            type: 'post',
            'isDatabale': true
        }
    })
}

const maintenanceMinutes = (meetingId, status = '') => {
    $.ajax({
        url: '/meeting/ended-meeting/maintenance',
        type: 'GET',
        data: {meetingId: meetingId, status: status}
    }).done(result => {
        showModal({
            type: 'lg',
            title: 'Meeting files',
            bodyContent: result
        })
    })
}

const saveMinutes = data => {
    $.ajax({
        url: '/meeting/ended-meeting/maintenance/submit',
        type: 'POST',
        data: data,
        contentType: false,
        cache: false,
        processData: false,
    }).done(result => {
        if(result.message == 'success'){
            closeModal('lg')
            setTimeOut('')

            toastr.success('Minutes update successfully', '', {
                progressBar: true,
                timeOut: 1000,
            })
        }
    })
}
