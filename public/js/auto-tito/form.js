$(function(){
    startTime()
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
