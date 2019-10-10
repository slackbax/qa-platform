$(document).ready(function () {
	var tableUsr = $("#tfiles").DataTable({
		columns: [
			{ width: "20px", className: "text-center" },
			{ "orderable": false, width: "20px", className: "text-center" },
			{ width: "50px", className: "text-center" },
			null,
			{ "visible": false },
			{ "visible": false },
			{ "orderable": false, width: "50px", className: "text-center" }],
		serverSide: true,
		ajax: {
			url: 'medibles/ajax.getServerMedibles.php',
			type: 'GET',
			length: 20
		}
	});

	var tableAcl = $("#tacl").DataTable({
		columns: [
			{ width: "20px", className: "text-center" },
			{ "orderable": false, width: "20px", className: "text-center" },
			{ width: "80px", className: "text-center" },
			{ width: "100px", className: "text-center" },
			{ className: "text-right" },
			null,
			{ "visible": false },
			{ "visible": false },
			{ "orderable": false, width: "52px", className: "text-center" }],
		serverSide: true,
		ajax: {
			url: 'medibles/ajax.getServerAclaratorias.php',
			type: 'GET',
			length: 20
		}
	});

	$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
		var tmp = e.target.hash.split('#');

		if (tmp[1] === 'em') {
			tableUsr.ajax.url('medibles/ajax.getServerMedibles.php').load();
		}
		else {
			tableAcl.ajax.url('medibles/ajax.getServerAclaratorias.php').load();
		}

		$.fn.dataTable.tables({ visible: true, api: true }).columns.adjust();
	});

	$('#tfiles').on('click', '.fileDelete', function () {
		var uid = $(this).attr('id').split("_").pop();
		$(this).parent().parent().addClass('selected');

		swal({
			title: "¿Está seguro de querer eliminar el documento?",
			text: "Esta acción borrará todos los registros relacionados al documento.",
			type: "warning",
			showCancelButton: true,
			confirmButtonColor: "#DD6B55",
			confirmButtonText: "Sí"
		}).then(function (result) {
			if (!result.dismiss) {
				$.ajax({
					url: 'admin/files/ajax.delFile.php',
					type: 'POST',
					dataType: 'json',
					data: { id: uid }
				}).done(function (response) {
					console.log(response);

					if (response.type) {
						new Noty({
							text: '<b>¡Éxito!</b><br>El documento ha sido eliminado correctamente.',
							type: 'success'
						}).show();
					}
					else {
						if (response.code === 0) {
							new Noty({
								text: '<b>¡Error!</b><br>' + response.msg,
								type: 'error'
							}).show();
						} else if (response.code === 1) {
							new Noty({
								text: response.msg,
								type: 'error',
								callbacks: {
									afterClose: function () {
										document.location.replace('index.php');
									}
								}
							}).show();
						}
					}

					tableUsr.draw(false);
				});
			}
			else {
				tableUsr.draw(false);
			}
		});
	});
});