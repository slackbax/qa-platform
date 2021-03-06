$(document).ready(function () {
	var tableEvents = $("#tevents").DataTable({
		columns: [
			{visible: false},
			{width: '70px'},
			{width: '60px'},
			{width: '60px'},
			null,
			null,
			null,
			null,
			null,
			{visible: false},
			{visible: false}, //10
			null,
			null,
			{visible: false},
			null,
			{visible: false},
			{visible: false},
			{visible: false},
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
			{visible: false},
			{visible: false},
			{visible: false},
			{width: '30px', className: 'text-center', orderable: false}],
		order: [[2, 'desc']],
		buttons: [
			{
				extend: 'excel',
				exportOptions: {
					columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30,
					31, 32, 33, 34, 35, 36, 37, 38]
				}
			}
		],
		serverSide: true,
		ajax: {
			url: 'tecnoevents/ajax.getServerEvents.php',
			type: 'POST',
			length: 20,
			beforeSend: function () {
				$('#tevents > tbody').html(
					'<tr class="odd">' +
					'<td colspan="39" class="dataTables_empty text-orange"><i class="fa fa-cog fa-spin fa-fw"></i> <em>Cargando data...</em></td>' +
					'</tr>'
				);
			},
		}
	});
});