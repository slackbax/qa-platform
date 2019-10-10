$(document).ready( function() {
    var tableFiles = $("#tfiles").DataTable({
        columns: [
            { "width": "50px" },
            { "width": "50px" },
            { "width": "50px" },
            { "width": "80px" },
            null,
            null,
            null,
            null,
            null,
            null,
            { "width": "30px", className: "text-center", "orderable": false } ],
        order: [[ 1, 'desc' ], [ 2, 'desc' ]],
        serverSide: true,
        ajax: {
            url: 'events/ajax.getServerExport.php?period=' + (new Date()).getFullYear(),
            type: 'GET',
            length: 20
        }
    });

    $('#view-historic').click( function() {
        tableFiles.ajax.url('events/ajax.getServerExport.php').load();
    });
});