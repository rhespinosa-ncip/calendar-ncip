$(function(){
    $('#userList').DataTable({
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
                data: 'username',
                name: 'username'
            },
            {
                data: 'full_name',
                name: 'full_name',
                orderable: false
            },
            {
                data: 'department_name',
                name: 'department_name',
                orderable: false
            },
            {
                data: 'action',
                name: 'action',
                orderable: false
            },

        ],
        ajax: {
            url: '/user/list',
            type: 'post',
            'isDatabale': true
        }
    })

    $('body').on('click', '.btn-add-user', function(){
        addUser()
        return false
    }).on('keyup', '#firstName, #lastName', function(){
        let firstName = $('#firstName').val()
        let lastName = $('#lastName').val()
        $('#password').val('ncip-'+firstName.toLowerCase()+lastName.toLowerCase())
        return false
    }).on('submit', '#addUser', function(){
        var data = $(this).serialize()
        submitUser(data)
        return false
    }).on('click', '.btn-update-user', function(){
        updateUser($(this).attr('userId'))
        return false
    }).on('submit', '#updateUser', function(){
        var data = $(this).serialize()
        submitUser(data+'&userStatus=update')
        return false
    })
})

const addUser = () => {
    $.ajax({
        url: '/user/add',
        type: 'GET',
    }).done(result => {
        showModal({
            type: 'lg',
            title: 'Add user',
            bodyContent: result
        })
    })
}

const updateUser = (userId) => {
    $.ajax({
        url: '/user/update',
        type: 'GET',
        data: {userId: userId}
    }).done(result => {
        showModal({
            type: 'lg',
            title: 'Update user',
            bodyContent: result
        })
    })
}

const submitUser = data => {
    $.ajax({
        url: '/user/add/submit',
        type: 'POST',
        data: data,
    }).done(result => {
        if(result.message == 'success'){
            closeModal('lg')
            setTimeOut('/user')
            
            toastr.success('User added successfully', '', {
                progressBar: true,
                timeOut: 1000,
            })
        }else if(result.message == 'updateSuccess'){
            closeModal('lg')
            setTimeOut('/user')
            
            toastr.success('User updates successfully', '', {
                progressBar: true,
                timeOut: 1000,
            })
        }
    })
}
