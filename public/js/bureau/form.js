$(function(){
    $('#bureauList').DataTable({
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
                data: 'bureau_color',
                name: 'bureau_color',
                orderable: false
            },
            {
                data: 'action',
                name: 'action',
                orderable: false
            },

        ],
        ajax: {
            url: '/bureau/list',
            type: 'post',
            'isDatabale': true
        }
    })

    $('body').on('click', '.btn-add-bureau', function(){
        addBureau()
        return false
    }).on('submit', '#addBureau', function(){
        var data = $(this).serialize()
        submitBureau(data)
        return false
    }).on('click', '.btn-update-bureau', function(){
        updateBureau($(this).attr('bureauId'))
        return false
    }).on('submit', '#updateBureau', function(){
        var data = $(this).serialize()
        submitBureau(data+'&bureauStatus=update')
        return false
    })
})

const addBureau = () => {
    $.ajax({
        url: '/bureau/add',
        type: 'GET',
    }).done(result => {
        showModal({
            type: '',
            title: 'Add bureau',
            bodyContent: result
        })
    })
}

const updateBureau = bureauId => {
    $.ajax({
        url: '/bureau/update',
        type: 'GET',
        data: {bureauId: bureauId}
    }).done(result => {
        showModal({
            type: '',
            title: 'Update bureau',
            bodyContent: result
        })
    })
}

const submitBureau = data => {
    $.ajax({
        url: '/bureau/add/submit',
        type: 'POST',
        data: data,
    }).done(result => {
        if(result.message == 'success'){
            closeModal('')
            setTimeOut('/bureau')

            toastr.success('Bureau added successfully', '', {
                progressBar: true,
                timeOut: 1000,
            })
        }else if(result.message == 'updateSuccess'){
            closeModal('')
            setTimeOut('/bureau')

            toastr.success('Bureau updates successfully', '', {
                progressBar: true,
                timeOut: 1000,
            })
        }
    })
}
