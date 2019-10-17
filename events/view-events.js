$(document).ready(function () {
	var tableFiles = $("#tfiles").DataTable({
		columns: [
			{"visible": false},
			{"width": "50px"},
			{"width": "50px"},
			{"visible": false},
			{"visible": false},
			null,
			{"width": "40px"},
			null,
			null,
			{"visible": false},
            {"width": "120px"},
			{"visible": false},
			{"visible": false},
			{"visible": false},
			null,
			{"visible": false},
			{"visible": false},
			{"visible": false},
			{"visible": false},
			{"visible": false},
			{"visible": false},
			{"width": "90px", className: "text-center", "orderable": false}],
		order: [[2, 'desc'], [3, 'asc']],
		buttons: [
			{
				extend: 'excel',
				exportOptions: {
					columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20]
				}
			}
		],
		serverSide: true,
		ajax: {
			url: 'events/ajax.getServerEvents.php?period=' + (new Date()).getFullYear(),
			type: 'GET',
			length: 20,
			beforeSend: function () {
				$('#tfiles > tbody').html(
					'<tr class="odd">' +
					'<td colspan="9" class="dataTables_empty text-orange"><i class="fa fa-cog fa-spin fa-fw"></i> <em>Cargando data...</em></td>' +
					'</tr>'
				);
			},
		}
	});

	$('#view-historic').click(function () {
		tableFiles.ajax.url('events/ajax.getServerEvents.php').load();
	});
});