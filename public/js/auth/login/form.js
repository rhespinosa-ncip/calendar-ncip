$(function(){
    $('#login-form').submit(function(){
        let data = $(this).serialize()
        loginSubmit(data)
        return false
    })

    $('#forgotPassword-form').submit(function(){
        let data = $(this).serialize()
        forgotPassword(data)
        return false
    })

    $('#password-reset-form').submit(function(){
        let data = $(this).serialize()
        changePassword(data)
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
            setTimeOut('/')
            toastr.success('Login success', '', {
                progressBar: true,
                timeOut: 1000,
            })
        }else if(result.message == 'no-credential'){
            toastr.error('No credential found', '', {
                progressBar: true,
                timeOut: 1000,
            })
        }
    })
}

const forgotPassword = data => {
    $.ajax({
        url: '/forgot-password/submit',
        type: 'post',
        data: data
    }).done(result => {
        if(result.message == 'success'){
            toastr.success('Link sent successfully', '', {
                progressBar: true,
                timeOut: 1000,
            })
        }

        if(result.message == 'error'){
            toastr.error('Credentials not found', '', {
                progressBar: true,
                timeOut: 1000,
            })
        }
    })
}


const changePassword = data => {
    $.ajax({
        url: '/forgot-password/reset-password/submit',
        type: 'post',
        data: data
    }).done(result => {
        if(result.message == 'success'){
            toastr.success('Password reset successfully', '', {
                progressBar: true,
                timeOut: 1000,
            });
            setTimeOut('/')
        }else if(result.message == 'error'){
            toastr.error('Token and email not match', '', {
                progressBar: true,
                timeOut: 1000,
            });
        }
    })
}
