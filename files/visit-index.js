$(document).ready(function () {
	$('#tspv').DataTable({
		columns: [null, {'width': '20%', className: 'text-center'}],
		order: [[0, 'asc']]
	});

	$('#tcaract').DataTable({
		columns: [null, {'width': '20%', className: 'text-center'}],
		order: [[0, 'desc']]
	});

	$('#tfiles').DataTable({
		columns: [null, {'width': '20%', className: 'text-center'}],
		order: [[0, 'asc'], [1, 'desc']]
	});

	$('#tfilestr').DataTable({
		columns: [null, {'width': '20%', className: 'text-center'}],
		order: [[0, 'asc'], [1, 'desc']]
	});

	$('.fileModal').click(function () {
		var fid = $(this).attr('id').split("_").pop();
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
			url: 'files/ajax.getFile.php',
			type: 'POST',
			dataType: 'json',
			data: {id: fid}
		}).done(function (d) {
			//console.log(d);
			if (d.arc_id !== null) {
				$("#f_path").data('ident', d.arc_id).attr('href', d.arc_path);
				$("#f_name").html('<i class="fa fa-chevron-right"></i> ' + d.arc_nombre);
				$("#f_char").html(d.arc_char);
				$("#f_code").html(d.arc_codigo);
				$("#f_edition").html(d.arc_edicion);
				$("#f_date_c").html(getMonthDate(d.arc_fecha_crea));
				$("#f_date").html(getDateToFormBD(d.arc_fecha));
				$("#f_date_v").html(getMonthDate(d.arc_fecha_vig));
				$("#f_type").html(getExt(d.arc_path));
				$("#f_downloads").html(d.arc_descargas);
			}
		});
	});

	$('.btnModal').on('click', function () {
		var fid = $(this).data('ident');

		$.ajax({
			url: 'files/ajax.setCounter.php',
			type: 'POST',
			dataType: 'json',
			data: {id: fid}
		}).done(function () {
			$('#fileDetail').modal('hide');
		});
	});
});
