$(document).ready(function () {
	const tableFiles = $("#tfiles").DataTable({
		columns: [
			{width: "20px"},
			{width: "60px"},
			{width: "60px"},
			null,
			null,
			null,
			null,
			null,
			null,
			{visible: false},
			{visible: false},
			{visible: false},
			null,
			{visible: false},
			{visible: false},
			{visible: false},
			{visible: false},
			{visible: false},
			{visible: false},
			{visible: false},
			{visible: false},
			{visible: false},
			{visible: false},
			{visible: false},
			{visible: false},
			null,
			null,
			{width: "30px", className: "text-center", orderable: false}
		],
		buttons: [
			{
				extend: 'excel',
				exportOptions: {
					columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26]
				}
			}
		],
		serverSide: true,
		ajax: {
			url: 'accidentes/ajax.getServerAccidents.php',
			type: 'GET',
			length: 20,
			beforeSend: function () {
				$('#tfiles > tbody').html(
					'<tr class="odd">' +
					'<td colspan="26" class="dataTables_empty text-orange"><i class="fa fa-cog fa-spin fa-fw"></i> <em>Cargando data...</em></td>' +
					'</tr>'
				);
			},
		}
	});
});