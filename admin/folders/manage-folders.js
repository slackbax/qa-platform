$(document).ready(function () {
	var tableFolders = $("#tfolders").DataTable({
		columns: [
			{ width: "20px", className: "text-center" },
			null,
			null,
			{ width: "120px", className: "text-center" },
			{ "orderable": false, width: "50px", className: "text-center" }],
		buttons: [{
			extend: 'excel',
			exportOptions: {
				columns: [0, 1, 2, 3]
			}
		}],
		serverSide: true,
		ajax: {
			url: 'admin/folders/ajax.getServerFolders.php',
			type: 'GET',
			length: 20
		}
	});
});