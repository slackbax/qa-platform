$(document).ready(function () {
    var tableEvents = $("#tevents").DataTable({
        columns: [
            {visible: false},
            {width: '100px'},
            {width: '100px'},
            {visible: false},
            {visible: false},
            {width: '100px'},
            {width: '100px'},
            null,
            null,
            null, //10
            null,
            {visible: false},
            {visible: false},
            {visible: false},
            {visible: false},
            {visible: false},
            null,
            {visible: false},
            {visible: false},
            {visible: false}, //20
            {visible: false},
            {visible: false},
            {visible: false},
            {visible: false},
            {visible: false},
            {visible: false},
            {visible: false},
            {visible: false},
            {visible: false},
            {visible: false}, //30
            {visible: false},
            {visible: false},
            {visible: false},
            {visible: false},
            {visible: false},
            {width: '30px', className: 'text-center', orderable: false}],
        order: [[5, 'desc']],
        buttons: [
            {
                extend: 'excel',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30,
                        31, 32, 33, 34]
                }
            }
        ],
        serverSide: true,
        ajax: {
            url: 'tecnoevents/ajax.getServerDivEvents.php',
            type: 'POST',
            length: 20,
            beforeSend: function () {
                $('#tfiles > tbody').html(
                    '<tr class="odd">' +
                    '<td colspan="37" class="dataTables_empty text-orange"><i class="fa fa-cog fa-spin fa-fw"></i> <em>Cargando data...</em></td>' +
                    '</tr>'
                );
            },
        }
    });
});