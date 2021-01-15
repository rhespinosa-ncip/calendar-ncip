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
                data: 'bureau_name',
                name: 'bureau_name',
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

        $('#password').val('ncip-'+ firstName.toLowerCase().replace(/\s/g, '')+lastName.toLowerCase().replace(/\s/g, ''))
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
    }).on('change', '#bureauName', function(event, updateId){
        showDivisions($(this).val(), updateId)
        return false
    })
})

const showDivisions = (bureauId, updateId) => {
    $.ajax({
        url: '/user/bureau/get-division',
        type: 'GET',
        data: {bureauId: bureauId}
    }).done(result => {
        $('#departmentName').empty()
        $('#departmentName').append('<option selected disabled>-- select department --</option>')

        let options = '';

        $.each(result.divisions, function (i, item) {
            let isSelected = updateId == item.department.id ? 'selected' : ''
            options += '<option '+isSelected+' value="'+item.department.id+'">'+item.department.name+'</option>'
        });

        $('#departmentName').append(options);
    })
}

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
            bodyContent: result.view
        })
        $('[name="bureauName"]').trigger("change", [result.bureauId] );
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
