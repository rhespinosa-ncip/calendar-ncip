$(function(){
    $("input").attr("autocomplete", "off");

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },beforeSend: (e, settings) => {
            if(settings.isDatabale != true){
                showLoader()
            }
        },success: (result,status,xhr) => {
            closeLoader()
            if(result.message == 'error-input'){
                clearError()

                $.each(result.messages, (key, val) => {
                    if(key == 'participant'){
                        toastr.error('Participant field is required', '', {
                            progressBar: true,
                            timeOut: 1000,
                        })
                    }

                    if(key == 'departmentParticipant'){
                        toastr.error('Department participant field is required', '', {
                            progressBar: true,
                            timeOut: 1000,
                        })
                    }

                    if(key == 'bureauParticipant'){
                        toastr.error('Bureau participant field is required', '', {
                            progressBar: true,
                            timeOut: 1000,
                        })
                    }

                    if(key == 'file'){
                        toastr.error('File field is required', '', {
                            progressBar: true,
                            timeOut: 1000,
                        })
                    }

                    inputError(key, val)
                })
            }
        },
        error : function(jqXHR, textStatus, errorThrown) {
            closeLoader()
            failError()
        },
    });

    $('body').on('keypress, change',':input', function(){
        let id = $(this).attr('id');
        $(this).removeClass("error-input");
        $(this).next('.ncip-blinking').remove();
    }).on('click', '.btn-remove-file', function(){
        removeTbodyTr(this)
        return false
    }).on('click', '.add-file', function(){
        appendFile()
        return false
    }).on('click', '.add-accomplishment', function(){
        appenAccomplishment()
        return false
    }).on('click', '.toggle-password', function(){
        $(this).toggleClass("fa-eye fa-eye-slash");
        var input = $($(this).attr("toggle"));

        if (input.attr("type") == "password") {
          input.attr("type", "text");
        } else {
          input.attr("type", "password");
        }

    }).on('click', '.change-password', function(){
        showPasswordForm()
        return false
    }).on('submit', '#changePassword', function(){
        let data = $(this).serialize()
        submitNewPassword(data)
        return false
    }).on('click', '.my-qr-code', function(){
        showMyQrCode()
    }).on('click', '.btn-print-report', function(){
        printElement(document.getElementById("printAreaReports"))
    }).on('click', '.show-notification', function(){
        showNotification()
        return false
    }).on('click', '.my-signatory', function(){
        showMySignatory()
    }).on('submit', '#signatoryForm', function(){
        let data = $(this).serialize()
        let status = $(this).find("button[type=submit]:focus").attr('status')
        submitSignatory(data, status)
        return false
    })

})

const notify = (e) => {
    const { message, personnel, personnel_id, notify_by } = e.message; // destructure the event data

    $.ajax({
        'isDatabale': true,
        url: '/notification/validate',
        type: 'GET',
        data: e.message
    }).done(result => {
        if(result.message == 'success'){
            $('.notif-count').text(result.notifCount)
            toastr.info(message, '', {
                progressBar: true,
                positionClass: "toast-bottom-left",
                extendedTimeOut: 5000,
                timeOut: 5000,
            })
        }else if(result.message == 'success-message'){
            toastr.info(notify_by+' sent you a message.', '', {
                progressBar: true,
                positionClass: "toast-bottom-left",
                extendedTimeOut: 5000,
                timeOut: 5000,
            })
            $('.notif-message-count').text(result.notifCount)

            $('.chat-box').empty('')
            $('.chat-box').append(result.chatBox)
            $(".chat-box").animate({
                scrollTop: $('.chat-box').get(0).scrollHeight
            }, 500);
        }
    })
}

const showNotification = () => {
    $.ajax({
        url: '/notification/show',
        type: 'GET',
    }).done(result => {
        showModal({
            type: '',
            title: 'Notifications',
            bodyContent: result
        })
    })
}
const showMyQrCode = download => {
    $.ajax({
        url: '/my-qr-code',
        type: 'GET',
    }).done(result => {
        showModal({
            type: '',
            title: 'QR CODE',
            bodyContent: result
        })
    })
}

const showMySignatory = () => {
    $.ajax({
        url: '/my-signatory',
        type: 'GET',
    }).done(result => {
        showModal({
            type: '',
            title: 'Signatory',
            bodyContent: result
        })
    })
}

const submitSignatory = (data, status) => {
    $.ajax({
        url: '/my-signatory/submit',
        type: 'POST',
        data: data + "&status="+status
    }).done(result => {
        if(result.message == 'success'){
            closeModal('')
            setTimeOut('')

            toastr.success('Signatory assigned succesfully', '', {
                progressBar: true,
                timeOut: 1000,
            })
        }
    })
}

const showPasswordForm = meetingId => {
    $.ajax({
        url: '/change-password/form',
        type: 'GET',
    }).done(result => {
        showModal({
            type: '',
            title: 'Password',
            bodyContent: result
        })
    })
}


const submitNewPassword = data => {
    $.ajax({
        url: '/change-password/form/submit',
        type: 'POST',
        data: data
    }).done(result => {
        if(result.message == 'success'){
            closeModal('')
            setTimeOut('/')

            toastr.success('Password update successfully', '', {
                progressBar: true,
                timeOut: 1000,
            })
        }else if(result.message == 'wrongOldPassword'){
            toastr.error('Wrong old password', '', {
                progressBar: true,
                timeOut: 1000,
            })
        }else if(result.message == 'provideNewPassword'){
            toastr.error('New password field is required', '', {
                progressBar: true,
                timeOut: 1000,
            })
        }
    })
}

const removeTbodyTr = thisRow => {
    Swal.fire({
        type: 'warning',
        text: 'Are you sure you want to remove row?',
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: 'Yes'
    }).then(result => {
        if (result.value) {
            $(thisRow).closest('tr').remove()
            storeAttrDocumentId(thisRow)
        }
    })
}

const storeAttrDocumentId = (thisData) =>{
    let documentId = $(thisData).attr('document-id')
    if(typeof documentId != 'undefined'){
        let value = $('#documentIds').val()
        $('#documentIds').val(documentId+','+value)
    }
}

const appendFile = () => {
    let toAppend = `
        <tr>
            <td><input type="file" class="form-control-file" id="file[]" name="file[]"></td>
            <td>
                <button class="btn btn-danger rounded-0 py-1 btn-remove-file">
                    <i class="fa fa-trash"></i>
                </button>
            </td>
        </tr>
    `

    $('#fileTbl > tbody').append(toAppend)
}

const appenAccomplishment = () => {
    let toAppend = `
        <tr>
            <td>
                <input class="form-control" name="accomplishment[]" id="accomplishment[]" type="text">
            </td>
            <td>
                <input class="form-control" name="remarks[]" id="remarks[]" type="text">
            </td>
            <td>
                <button class="btn btn-danger rounded-0 py-1 btn-remove-file">
                    <i class="fa fa-trash"></i>
                </button>
            </td>
        </tr>
    `

    $('#fileTbl > tbody').append(toAppend)
}

function clearError() {
    $('.ncip-blinking').remove();
}

function inputError(key, val){
    $('#'+key).removeClass("error-input");
    $('#'+key).addClass("error-input");
    $(`<div class="row ncip-blinking">
            <div class="col-12">
                <i class="fa fa-exclamation-circle"></i>
                <span class="span-error">${val}</span>
            </div>
        </div>` ).insertAfter('#'+key);
}

function setTimeOut(url){
    setTimeout(function() {
        window.location.href = url
    }, 1000);
}

function showModal(settings){
    let $modal = $('#modal');

    let defaults = {
        type: '',
        title: '',
        headerContent: '',
        bodyContent: '',
        footerContent: '',
        header: true,
        body: true,
        footer: false
    };

    let options = $.extend({}, defaults, settings);

    if (options.type === 'xl') {
        $modal = $('#modalXl');
    } else if (options.type === 'lg') {
        $modal = $('#modalLg');
    }

    $modal.find('.modal-title').html('');
    $modal.find('.modal-body').html('');
    $modal.find('.modal-footer').html('');

    $modal.find('.modal-header').show();
    $modal.find('.modal-body').show();
    $modal.find('.modal-footer').show();

    $modal.find('.modal-title').html(options.title);
    $modal.find('.modal-body').html(options.bodyContent);
    $modal.find('.modal-footer').html(options.footerContent);

    if (options.header === false) {
        $modal.find('.modal-header').hide();
    }

    if (options.body === false) {
        $modal.find('.modal-body').hide();
    }

    if (options.footer === false) {
        $modal.find('.modal-footer').hide();
    }

    $modal.modal({
        keyboard: false,
        show: true
    });

    $modal.find('.modal-header .modal-title').addClass('title_set');
}

function closeModal(type){
    let $modal = $('#modal');

    if (type) {
        if (type === 'lg') {
            $modal = $('#modalLg');
        } else if (type === 'xl') {
            $modal = $('#modalXl');
        }
    }

    $modal.find('.modal-title').html('');
    $modal.find('.modal-body').html('');
    $modal.find('.modal-footer').html('');

    $modal.modal('hide');
}


function showLoader(options){
    let loadingImage = getBaseUrl('public/image/loader.svg');
    let title = '<span class="loadingText">Just a moment...';
    let text = '';

    if (typeof options !== 'undefined') {
        if (typeof options.title !== 'undefined') {
            title = options.title;
        }

        if (typeof options.text !== 'undefined') {
            text = options.text;
        }
    }

    Swal.fire({
        title: title,
        text: text,
        backdrop: true,
        allowOutsideClick: false,
        allowEscapeKey: false,
        allowEnterKey: false,
        showConfirmButton: false,
        imageUrl: loadingImage,
        background: 'transparent',
        color: 'red',
        backdrop: `rgba(0,0,0,0.8)`
    });
}

function closeLoader(options){
    Swal.close();
}

function getBaseUrl(uri){
    let getUrl = window.location;
    let baseUrl = getUrl.protocol + "//" + getUrl.host + "/";

    return baseUrl + uri;
}

function reloadTable(tableId = ""){
    location.reload()
}

function failError(){
    toastr.error('Connection error - contact admin', '', {
        progressBar: true,
        timeOut: 2000,
    })
}

const printElement = elem => {
    var domClone = elem.cloneNode(true);

    var printSection = document.getElementById("printSection");

    if (!printSection) {
        var printSection = document.createElement("div");
        printSection.id = "printSection";

        document.body.appendChild(printSection);
    }

    printSection.innerHTML = "";
    printSection.appendChild(domClone);
    window.print();
    printSection.innerHTML = "";
}
