$(document).ready( function() {
	var tableFiles = $("#tfiles").DataTable({
		"columns": [ { "visible": false },
			{ "width": "50px" },
			{ "width": "50px" },
			{ "visible": false },
			{ "visible": false },
			null,
			{ "width": "40px" },
			null,
			{ "visible": false },
			null,
			{ "visible": false },
			{ "visible": false },
			{ "visible": false },
			{ "width": "50px" },
			{ "visible": false },
			{ "visible": false },
			{ "visible": false },
			{ "visible": false },
			{ "visible": false },
			{ "width": "70px", className: "text-center", "orderable": false } ],
		'order': [[ 2, 'desc' ], [ 3, 'asc' ]],
		'buttons': [
			{
				extend: 'excel',
				exportOptions: {
					columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17]
				}
			}
		],
		serverSide: true,
		ajax: {
			url: 'events/ajax.getServerSteril.php',
			type: 'GET',
			length: 20
		}
	});

	$('#view-historic').click( function() {
		tableFiles.ajax.url('events/ajax.getServerEvents.php').load();
	});
});