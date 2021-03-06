$(function(){
    $('#meetingReportTable').DataTable({
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
            url: '/report/meeting/ended-meeting/list',
            type: 'post',
            'isDatabale': true
        }
    })

    $('body').on('click', '.btn-report-filter', function(){
        showFilter()
        return false
    }).on('submit', '#submitFilter', function(){
        submitFilter($(this).serialize())
        return false
    }).on('click', '.btn-tito-filter', function(){
        showFilter('tito')
        return false
    })
})

const showFilter = (type = 'accomplishment') => {
    $.ajax({
        url: '/report/filter',
        type: 'GET',
        data: {type: type}
    }).done(result => {
        showModal({
            type: '',
            title: 'Report Filter',
            bodyContent: result
        })
    })
}

const submitFilter = data => {
    $.ajax({
        url: '/report/filter/submit',
        type: 'POST',
        data: data
    }).done(result => {
        if(result.message == 'success'){
            closeModal()
            $('.content-report').empty()
            $('.content-report').append(result.content)
        }
    })
}
