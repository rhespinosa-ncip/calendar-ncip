$(function(){
    $('#accomplishmentTable').DataTable({
        searchDelay: 500,
        searching: false,
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
                data: 'created_at',
                name: 'created_at'
            },
            {
                data: 'time_in',
                name: 'time_in'
            },
            {
                data: 'time_out',
                name: 'time_out'
            },
            {
                data: 'action',
                name: 'action',
                orderable: false
            },

        ],
        ajax: {
            url: '/accomplishment/list',
            type: 'post',
            'isDatabale': true
        }
    })

    $('body').on('click', '.btn-add-accomplishment', function(){
        let tito = $(this).attr('titoId')
        accomplishmentRecord(tito)
        return false
    }).on('click', '.btn-view-accomplishment', function(){
        let tito = $(this).attr('titoId')
        accomplishmentRecord(tito, 'view')
        return false
    }).on('submit', '#saveAccomplishment', function(){
        let data = $(this).serialize()
        saveAccomplishment(data)
        return false
    })
})

const accomplishmentRecord = (tito, titoStatus = 'add') => {
    $.ajax({
        url: '/accomplishment/record',
        type: 'GET',
        data: {titoId: tito, titoStatus: titoStatus}
    }).done(result => {
        showModal({
            type: 'lg',
            title: 'Accomplishment',
            bodyContent: result
        })
    })
}


const saveAccomplishment = data => {
    $.ajax({
        url: '/accomplishment/record/submit',
        type: 'POST',
        data: data,
    }).done(result => {
        if(result.message == 'success'){
            closeModal('lg')
            setTimeOut('/accomplishment')

            toastr.success('Accomplishment update successfully', '', {
                progressBar: true,
                timeOut: 1000,
            })
        }
    })
}
