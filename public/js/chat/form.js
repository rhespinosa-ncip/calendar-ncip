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
    }).on('click', '.btn-create-group', function(){
        createGroup()
        return false
    }).on('submit', '#addGroup', function(){
        let data = $(this).serialize()
        submitGroup(data)
        return false
    }).on('click', '.view-seen', function(){
        showSeen($(this).attr('chatId'))
        return false
    }).on('click', '.setting', function(){
        showSetting($(this).attr('groupId'))
        return false
    }).on('submit', '#updateGroup', function(){
        updateGroup($(this).serialize())
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

const createGroup = () => {
    $.ajax({
        url: '/chat/group/create',
        type: 'GET',
    }).done(result => {
        showModal({
            type: '',
            title: 'Group',
            bodyContent: result
        })
    })
}

const submitGroup = data => {
    $.ajax({
        url: '/chat/group/create/submit',
        type: 'POST',
        data: data
    }).done(result => {
        if(result.message == 'success'){
            closeModal('')
            setTimeOut('/chat/group-'+result.groupName)

            toastr.success('Group added successfully', '', {
                progressBar: true,
                timeOut: 1000,
            })
        }
    })
}

const showSeen = (chatId) => {
    $.ajax({
        url: '/chat/seen/view',
        type: 'GET',
        data: {chatId: chatId}
    }).done(result => {
        showModal({
            type: '',
            title: 'Seen by',
            bodyContent: result
        })
    })
}

const showSetting = (groupId) => {
    $.ajax({
        url: '/chat/group/setting',
        type: 'GET',
        data: {groupId: groupId}
    }).done(result => {
        showModal({
            type: '',
            title: 'Show setting',
            bodyContent: result
        })
    })
}

const updateGroup = data => {
    $.ajax({
        url: '/chat/group/create/update',
        type: 'POST',
        data: data
    }).done(result => {
        if(result.message == 'success'){
            closeModal('')
            setTimeOut('/chat/group-'+result.groupName)

            toastr.success('Group update successfully', '', {
                progressBar: true,
                timeOut: 1000,
            })
        }
    })
}
