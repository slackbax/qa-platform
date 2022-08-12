$(document).ready(function () {
	const tableUsr = $("#tfiles").DataTable({
		columns: [
			{"orderable": false, width: "20px", className: "text-center"},
			null,
			{className: "text-center"},
			{className: "text-center"},
			{"orderable": false, width: "100px", className: "text-center"}],
		order: [[1, "asc"]],
		buttons: [{
			extend: 'excel',
			exportOptions: {
				columns: [1, 2, 3]
			}
		}],
		serverSide: true,
		ajax: {
			url: 'admin/files/ajax.getServerOtherFiles.php',
			type: 'GET',
			length: 20
		}
	});

	$('#tfiles').on('click', '.fileModal', function () {
		const fid = $(this).attr('id').split("_").pop();
		$("#f_name").html('<i class="fa fa-spin fa-spinner"></i>');
		$("#f_char").html('<i class="fa fa-spin fa-spinner"></i>');
		$("#f_code").html('<i class="fa fa-spin fa-spinner"></i>');
		$("#f_edition").html('<i class="fa fa-spin fa-spinner"></i>');
		$("#f_date_c").html('<i class="fa fa-spin fa-spinner"></i>');
		$("#f_date").html('<i class="fa fa-spin fa-spinner"></i>');
		$("#f_date_v").html('<i class="fa fa-spin fa-spinner"></i>');
		$("#f_type").html('<i class="fa fa-spin fa-spinner"></i>');
		$("#f_user").html('<i class="fa fa-spin fa-spinner"></i>');
		$("#f_downloads").html('<i class="fa fa-spin fa-spinner"></i>');
		$("#f_path").attr('href', null);

		$.ajax({
			url: 'files/ajax.getOFile.php',
			type: 'POST',
			dataType: 'json',
			data: { id: fid }
		}).done(function (d) {
			console.log(d);
			if (d.arc_id !== null) {
				$("#f_path").data('ident', d.oarc_id);
				$("#f_name").html('<i class="fa fa-chevron-right"></i> ' + d.oarc_nombre);
				$("#f_edition").html(d.oarc_edicion);
				$("#f_date_c").html(getMonthDate(d.oarc_fecha_crea));
				$("#f_date").html(getDateBD(d.oarc_fecha));
				$("#f_date_v").html(getMonthDate(d.oarc_fecha_vig));
				$("#f_type").html(getExt(d.oarc_path));
				$("#f_user").html(d.oarc_user);
				$("#f_downloads").html(d.oarc_descargas);
				$("#f_path").attr('href', d.oarc_path);
			}
		});
	});

	$(".btnModal").click(function () {
		const fid = $(this).data('ident');

		$.ajax({
			url: 'files/ajax.setCounter.php',
			type: 'POST',
			dataType: 'json',
			data: { id: fid }
		}).done(function () {
			$('#fileDetail').modal('hide');
		});
	});

	$('#tfiles').on('click', '.fileDelete', function () {
		const uid = $(this).attr('id').split("_").pop();
		$(this).parent().parent().addClass('selected');

		swal({
			title: "¿Está seguro de querer eliminar el documento?",
			text: "Esta acción borrará todos los registros relacionados al documento.",
			type: "warning",
			showCancelButton: true,
			confirmButtonText: "Eliminar"
		}).then(function (result) {
			if (!result.dismiss) {
				$.ajax({
					url: 'admin/files/ajax.delOtherFile.php',
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
					} else {
						new Noty({
							text: '<b>¡Error!</b><br>' + response.msg,
							type: 'error'
						}).show();
					}

					tableUsr.draw(false);
				});
			} else {
				tableUsr.draw(false);
			}
		});
	});
});
