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
});   