$(function(){

    $('#departmentList').DataTable({
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
                data: 'name',
                name: 'name'
            },
            {
                data: 'department_color',
                name: 'department_color',
                orderable: false
            },
            {
                data: 'action',
                name: 'action',
                orderable: false
            },

        ],
        ajax: {
            url: '/department/list',
            type: 'post',
            'isDatabale': true
        }
    })

    $('body').on('click', '.btn-add-department', function(){
        addDepartment()
        return false
    }).on('submit', '#addDepartment', function(){
        var data = $(this).serialize()
        submitDepartment(data)
        return false
    }).on('click', '.btn-update-department', function(){
        updateDepartment($(this).attr('departmentId'))
        return false
    }).on('submit', '#updateDepartment', function(){
        var data = $(this).serialize()
        submitDepartment(data+'&departmentStatus=update')
        return false
    })
})

const addDepartment = () => {
    $.ajax({
        url: '/department/add',
        type: 'GET',
    }).done(result => {
        showModal({
            type: '',
            title: 'Add division',
            bodyContent: result
        })
    })
}

const updateDepartment = departmentId => {
    $.ajax({
        url: '/department/update',
        type: 'GET',
        data: {departmentId: departmentId}
    }).done(result => {
        showModal({
            type: '',
            title: 'Update division',
            bodyContent: result
        })
    })
}

const submitDepartment = data => {
    $.ajax({
        url: '/department/add/submit',
        type: 'POST',
        data: data,
    }).done(result => {
        if(result.message == 'success'){
            closeModal('')
            setTimeOut('/department')

            toastr.success('Division added successfully', '', {
                progressBar: true,
                timeOut: 1000,
            })
        }else if(result.message == 'updateSuccess'){
            closeModal('')
            setTimeOut('/department')

            toastr.success('Division updates successfully', '', {
                progressBar: true,
                timeOut: 1000,
            })
        }
    })
}
