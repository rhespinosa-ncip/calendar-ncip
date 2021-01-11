$(function(){
    startTime()

    $('body').on('click', '.btn-time-in', function(){
        Swal.fire({
            title: 'Are you sure you want to time in?',
            text: "",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Time in'
        }).then((result) => {
            if (result.value) {
                timeUser()
            }
        })
        return false
    }).on('click', '.btn-time-out', function(){
        Swal.fire({
            title: 'Are you sure you want to time out?',
            text: "",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Time out'
        }).then((result) => {
            if (result.value) {
                timeUser('timeOut')
            }
        })
        return false
    })
})

const startTime = () => {
    var today = new Date();
    var h = today.getHours();
    var m = today.getMinutes();
    var s = today.getSeconds();
    m = checkTime(m);
    s = checkTime(s);

    var ampm = h >= 12 ? 'PM' : 'AM';
    h = h % 12;
    h = h ? h : 12;
    h = h <= 12 ? h : "0"+h

    document.getElementById('time').innerHTML = h+':'+m+':'+s
    // document.getElementById('second').innerHTML = s
    document.getElementById('ampm').innerHTML = ampm
    // document.getElementById('dayToday').innerHTML = weekDay(today)
    // document.getElementById('month').innerHTML = month(today) +' '+ today.getDate() + ', ' + today.getFullYear()
    var t = setTimeout(startTime, 500);
}

const checkTime = i => {
    if (i < 10) {i = "0" + i};
    return i;
}

const weekDay = date => {
    //Create an array containing each day, starting with Sunday.
    var weekdays = new Array(
        "SUNDAY", "MONDAY", "TUESDAY", "WEDNESDAY", "THURSDAY", "FRIDAY", "SATURDAY"
    );
    //Use the getDay() method to get the day.
    var day = date.getDay();
    //Return the element that corresponds to that index.
    return weekdays[day];
}

const month = date => {
    var months = new Array(
        "Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sept","Oct","Nov","Dec"
    );

    return  months[date.getMonth()];
}

const timeUser = (tito = 'timeIn') => {
    $.ajax({
        url: '/tito/time-in',
        type: 'POST',
        data: {tito: tito}
    }).done(result => {
        if(result.message == 'success'){
            setTimeOut('/')

            toastr.success('Time in successfully', '', {
                progressBar: true,
                timeOut: 1000,
            })
        }
    })
}
