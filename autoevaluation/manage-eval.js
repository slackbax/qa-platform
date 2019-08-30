$(document).ready(function () {
	var tableUsr = $("#tfiles").DataTable({
		"columns": [
            {width: "20px", className: "text-center"},
            {width: "80px", className: "text-center"},
            {"orderable": false, width: "100px", className: "text-center"},
			null,
			null,
			{width: "80px", className: "text-center"},
			{"orderable": false, width: "50px", className: "text-center"}],
		"order": [[0, "desc"]],
        'buttons': [
            {
                extend: 'excel',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20]
                }
            }
        ],
		serverSide: true,
		ajax: {
			url: 'autoevaluation/ajax.getServerAutoevaluations.php',
			type: 'GET',
			length: 20
		}
	});
});