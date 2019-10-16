$(document).ready( function() {
    var tableFiles = $("#tlfiles").DataTable({
        columns: [
            { orderable: false },
            null,
            { width: "100px", className: "text-center" }
        ],
        'dom': "<'row'<'col-md-12't>>",
        order: [[2, 'desc']]
    });

    var countDownDate = new Date("Mar 17, 2020 12:00:00").getTime();

    var x = setInterval(function() {
        var now = new Date().getTime();

        var distance = countDownDate - now;

        var days = Math.floor(distance / (1000 * 60 * 60 * 24));
        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((distance % (1000 * 60)) / 1000);

        $("#counter").html(days + "d " + hours + "h "
            + minutes + "m " + seconds + "s ");

        if (distance < 0) {
            clearInterval(x);
        }
    }, 1000);
});   