$(document).ready(function () {
	var tableUsr = $("#tfiles").DataTable({
		"columns": [
			{ width: "20px", className: "text-center" },
			{ "orderable": false, width: "20px", className: "text-center" },
			null,
			{ className: "text-center" },
			{ width: "80px", className: "text-center" },
			{ "visible": false },
			{ "visible": false },
			{ "orderable": false, width: "60px", className: "text-center" }],
		"order": [[0, "asc"]],
		serverSide: true,
		ajax: {
			url: 'indicators/ajax.getServerIndicators.php',
			type: 'GET',
			length: 20
		}
	});

	$('#tfiles').on('click', '.indModal', function () {
		var fid = $(this).attr('id').split("_").pop();
		$("#f_name").html('');
		$("#f_desc").html('');
		$("#f_char").html('');
		$("#f_elem").html('');
		$("#f_period").html('');
		$("#f_num").html('');
		$("#f_den").html('');
		$("#f_umbral").html('');
		$("#f_date").html('');

		$.ajax({
			url: 'indicators/ajax.getIndicator.php',
			type: 'POST',
			dataType: 'json',
			data: { id: fid }
		}).done(function (d) {
			console.log(d);
			if (d.ine_id !== null) {
				$("#f_name, #f_name2").html(d.ine_nombre);
				$("#f_desc").html(d.ine_descripcion);
				$("#f_char").html(d.samb_sigla + '-' + d.cod_descripcion);
				$("#f_elem").html(d.elem_descripcion);
				$("#f_period").html(d.ine_pedesc);
				$("#f_num").html(d.ine_num_desc);
				$("#f_den").html(d.ine_den_desc);
				$("#f_umbral").html(d.ine_umbral);
				$("#f_date").html(getDateBD(d.ine_fecha));
			}
		});
	});
});