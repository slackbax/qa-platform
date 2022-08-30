$(document).ready(function () {
	var tableEvents = $("#tevents").DataTable({
		columns: [
			{visible: false},
			null,
			{width: '100px'},
			null,
			null,
			null,
			null,
			null,
			null,
			{visible: false},
			{visible: false},
			null,
			{visible: false},
			{visible: false},
			{visible: false},
			{width: '30px', className: 'text-center', orderable: false}],
		order: [[2, 'desc']],
		buttons: [
			{
				extend: 'excel',
				exportOptions: {
					columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14]
				}
			}
		],
		serverSide: true,
		ajax: {
			url: 'tecnoevents/ajax.getServerAlerts.php',
			type: 'POST',
			length: 20,
			beforeSend: function () {
				$('#tevents > tbody').html(
					'<tr class="odd">' +
					'<td colspan="16" class="dataTables_empty text-orange"><i class="fa fa-cog fa-spin fa-fw"></i> <em>Cargando data...</em></td>' +
					'</tr>'
				);
			},
		}
	});
});
