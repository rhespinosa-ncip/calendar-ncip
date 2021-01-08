$(function(){
    $('#meetingAdminList').DataTable({
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
                name: 'meeting_schedule'
            },
            {
                data: 'created_by',
                name: 'created_by',
                orderable: false
            },
            {
                data: 'action',
                name: 'action',
                orderable: false
            },

        ],
        ajax: {
            url: '/meeting/admin/list',
            type: 'post',
            'isDatabale': true
        }
    })

    $('body').on('click', '.btn-update-meeting', function(){
        let meetingId = $(this).attr('meetingId')
        showMeetingLink(meetingId)
        return false
    }).on('submit', '#updateMeetingLink', function(){
        var data = $(this).serialize()
        submitMeetingLink(data)
        return false
    })
})

const showMeetingLink = meetingId => {
    $.ajax({
        url: '/meeting/admin/meeting-link',
        type: 'GET',
        data: {meetingId: meetingId}
    }).done(result => {
        showModal({
            type: '',
            title: 'Meeting Link',
            bodyContent: result
        })
    })
}

const submitMeetingLink = data => {
    $.ajax({
        url: '/meeting/admin/meeting-link/submit',
        type: 'POST',
        data: data,
    }).done(result => {
        if(result.message == 'success'){
            closeModal('')
            setTimeOut('/meeting/admin')

            toastr.success('Meeting link updated successfully', '', {
                progressBar: true,
                timeOut: 1000,
            })
        }
    })
}
