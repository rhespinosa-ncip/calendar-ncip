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
    })
})

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
        $("select").bsMultiSelect({
            cssPatch: {
                choices: {
                    columnCount: '4'
                },
            }
        });
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
        $("select").bsMultiSelect({
            cssPatch: {
                choices: {
                    columnCount: '4'
                },
            }
        });
    })
}