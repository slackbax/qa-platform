$(document).ready( function() {
    var tableFiles = $("#tlfiles").DataTable({
        columns: [
            { orderable: false },
            null,
            { width: "100px", className: "text-center" }
        ],
        dom: "<'row'<'col-md-12't>>",
        order: [[2, 'desc']]
    });

    $("#counter-d").html(0);
    $("#counter-h").html(0);
    $("#counter-m").html(0);
    $("#counter-s").html(0);
    $("#counter").html(0 + "d " + 0 + "h "
        + 0 + "m " + 0 + "s ");

    /*
    var countDownDate = new Date("Mar 09, 2020 23:59:59").getTime();

    var x = setInterval(function() {
        var now = new Date().getTime();

        var distance = countDownDate - now;

        var days = Math.floor(distance / (1000 * 60 * 60 * 24));
        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((distance % (1000 * 60)) / 1000);
        days = days < 10 ? '0' + days : days;
        hours = hours < 10 ? '0' + hours : hours;
        minutes = minutes < 10 ? '0' + minutes : minutes;
        seconds = seconds < 10 ? '0' + seconds : seconds;

        $("#counter-d").html(days);
        $("#counter-h").html(hours);
        $("#counter-m").html(minutes);
        $("#counter-s").html(seconds);
        $("#counter").html(days + "d " + hours + "h "
            + minutes + "m " + seconds + "s ");

        if (distance < 0) {
            clearInterval(x);
        }
    }, 1000);*/
});   