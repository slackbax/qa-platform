$(document).ready(function () {
	var tableUsr = $("#tusers").DataTable({
		columns: [
			null,
			null,
			null,
			null,
			{className: "text-center"},
			{"orderable": false, width: "100px", className: "text-center"}],
		order: [[1, 'asc'], [2, 'asc']],
		serverSide: true,
		ajax: {
			url: 'admin/users/ajax.getServerUsers.php',
			type: 'GET',
			length: 20
		}
	});

	$('#tusers').on('click', '.userModal', function () {
		var uid = $(this).attr('id').split("_").pop();

		$.ajax({
			url: 'admin/users/ajax.getUser.php',
			type: 'POST',
			dataType: 'json',
			data: {id: uid}
		}).done(function (d) {
			console.log(d);
			$("#u_nombres").html('');
			$("#u_ap").html('');
			$("#u_am").html('');
			$("#u_email").html('');
			$("#u_username").html('');
			$("#u_estado").html('');
			$("#u_fecha").html('');
			$("#u_pic").html('');

			if (d.us_id !== null) {
				$("#u_name").html('<i class="fa fa-chevron-right"></i> ' + d.us_username);
				$("#u_nombres").html(d.us_nombres);
				$("#u_ap").html(d.us_ap);
				$("#u_am").html(d.us_am);
				$("#u_email").html(d.us_email);
				if (d.us_activo === 1)
					$("#u_estado").html('Activo');
				else
					$("#u_estado").html('Inactivo');
				$("#u_fecha").html(getDateBD(d.us_fecha));
				$("#u_pic").html('<img src="dist/img/' + d.us_pic + '" width="100" height="100">');
			}
		});

		$.ajax({
			url: 'admin/users/ajax.getGroups.php',
			type: 'POST',
			dataType: 'json',
			data: {id: uid}
		}).done(function (d) {
			console.log(d);
			$("#u_perfiles").html('');
			var _innerTxt = '<ul class="inner-list">';

			$.each(d, function (i, val) {
				_innerTxt += '<li>' + val.gru_nombre + '</li>';
			});

			_innerTxt += '</ul>';

			$("#u_perfiles").html(_innerTxt);
		});
	});

	$('#tusers').on('click', '.userDelete', function () {
		var uid = $(this).attr('id').split("_").pop();
		$(this).parent().parent().addClass('selected');

		swal({
			title: "¿Está seguro de querer eliminar el usuario?",
			text: "Esta acción borrará todos los registros relacionados al usuario.",
			type: "warning",
			showCancelButton: true,
			confirmButtonColor: "#DD6B55",
			confirmButtonText: "Sí"
		}).then(function (result) {
			if (!result.dismiss) {
				$.ajax({
					url: 'admin/users/ajax.delUser.php',
					type: 'POST',
					dataType: 'json',
					data: {id: uid}
				}).done(function (response) {
					console.log(response);

					if (response.type) {
						new Noty({
							text: '<b>¡Éxito!</b><br>El usuario ha sido eliminado correctamente.',
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