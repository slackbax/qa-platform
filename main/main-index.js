$(document).ready( function() {
    var tableFiles = $("#tlfiles").DataTable({
        "columns": [
            null,
            { width: "100px", className: "text-center" }
        ],
        'dom': "<'row'<'col-md-12'B>>" + "<'row'<'col-md-12't>>",
        'order': [[1, 'desc']]
    });
});   