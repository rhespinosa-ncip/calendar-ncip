$(function(){
    $('#login-form').submit(function(){
        let data = $(this).serialize()
        loginSubmit(data)
        return false
    })
})

const loginSubmit = data => {
    $.ajax({
        url: '/login',
        type: 'post',
        data: data
    }).done(result => {
        if(result.message == 'success'){

        }
    })
}
