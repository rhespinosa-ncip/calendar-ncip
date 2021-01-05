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
    })
})

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
        window.location.href = url;
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
    let loadingImage = getBaseUrl('image/loader.svg');
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
