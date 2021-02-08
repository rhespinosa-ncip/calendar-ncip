$(function(){
    $('body').on('change keyup', '#searchUserGroup', function(){
        searchUserGroup($(this).val())
        return false
    })
})

const searchUserGroup = data => {
    $.ajax({
        'isDatabale': true,
        url: '/chat/search/search',
        type: 'GET',
        data: {data: data}
    }).done(result => {
        $('.messages-box').empty()
        $('.messages-box').append(result)
    })
}
