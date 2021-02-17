var filesToUpload = [];
$(function(){

    $(".chat-box").animate({
        scrollTop: $('.chat-box').get(0).scrollHeight
    }, 1);

    $('body').on('change keyup', '#searchUserGroup', function(){
        searchUserGroup($(this).val())
        return false
    }).on('submit', '#chatMessage', function(){
        var data = new FormData(this)
        for (var i = 0, len = filesToUpload.length; i < len; i++) {
            data.append("file[]", filesToUpload[i].file);
        }
        sendMessage(data)
        return false
    }).on('change', '#file-upload', function(evt){
        let output = [];
        let fileIdCounter = 0;

        for (var i = 0; i < evt.target.files.length; i++) {
            fileIdCounter++;
            var file = evt.target.files[i];
            var fileId = 'file-upload' + fileIdCounter;

            filesToUpload.push({
                id: fileId,
                file: file
            });

            var removeLink = "&nbsp<a class=\"removeFile\" href=\"#\" data-fileid=\"" + fileId + "\">x</a>";

            output.push(`
                <button type="button" class="btn btn-primary mb-2">
                `+escape(file.name)+removeLink+`
                </button>
            `)
        };

        $('.fileList').append(output)
    }).on('click', '.removeFile', function(){
        var fileId = $(this).parent().children("a").data("fileid");

        for (var i = 0; i < filesToUpload.length; ++i) {
            if (filesToUpload[i].id === fileId)
                filesToUpload.splice(i, 1);
        }

        $(this).parent().remove();
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

const sendMessage = data => {
    $.ajax({
        url: '/chat/send',
        type: 'POST',
        data: data,
        contentType: false,
        cache: false,
        processData: false,
        isDatabale: true,
    }).done(result => {
        if(result.message == 'success'){
            $('.chat-box').empty('')
            $('.chat-box').append(result.chatBox)

            $('#message').val('')

            $(".chat-box").animate({
                scrollTop: $('.chat-box').get(0).scrollHeight
            }, 500);

            for (var i = 0; i < filesToUpload.length; ++i) {
                if (filesToUpload[i].id.indexOf('file-upload') >= 0)
                    filesToUpload.splice(i, 1);
            }

            $(".fileList").empty();
        }
    })
}
