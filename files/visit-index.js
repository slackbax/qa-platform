$(document).ready(function () {
	$("#tcaract").DataTable({
		columns: [null, {"width": "20%", className: "text-center"}],
		order: [[0, "desc"]]
	});

	$("#tfiles").DataTable({
		columns: [null, {"width": "20%", className: "text-center"}]
	});

	$("#tfilestr").DataTable({
		columns: [null, {"width": "20%", className: "text-center"}]
	});

	$(".fileModal").click(function () {
		var fid = $(this).attr('id').split("_").pop();
		$("#f_name").html('');
		$("#f_char").html('');
		$("#f_code").html('');
		$("#f_edition").html('');
		$("#f_date_c").html('');
		$("#f_date").html('');
		$("#f_date_v").html('');
		$("#f_type").html('');
		$("#f_downloads").html('');
		$("#f_path").attr('href', null);

		$.ajax({
			url: 'files/ajax.getFile.php',
			type: 'POST',
			dataType: 'json',
			data: {id: fid}
		}).done(function (d) {
			//console.log(d);
			if (d.arc_id !== null) {
				$("#f_path").data('ident', d.arc_id);
				$("#f_name").html('<i class="fa fa-chevron-right"></i> ' + d.arc_nombre);
				$("#f_char").html(d.arc_char);
				$("#f_code").html(d.arc_codigo);
				$("#f_edition").html(d.arc_edicion);
				$("#f_date_c").html(getMonthDate(d.arc_fecha_crea));
				$("#f_date").html(getDateToFormBD(d.arc_fecha));
				$("#f_date_v").html(getMonthDate(d.arc_fecha_vig));
				$("#f_type").html(getExt(d.arc_path));
				$("#f_downloads").html(d.arc_descargas);
				$("#f_path").attr('href', d.arc_path);
			}
		});
	});

	$(".btnModal").on('click', function () {
		var fid = $(this).data('ident');

		$.ajax({
			url: 'files/ajax.setCounter.php',
			type: 'POST',
			dataType: 'json',
			data: {id: fid}
		}).done(function () {
			//console.log(d);
			$('#fileDetail').modal('hide');
		});
	});
});