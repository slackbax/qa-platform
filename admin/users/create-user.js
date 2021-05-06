$(document).ready(function () {
	let _vUser = true;
	let _vEmail = true;

	$('#iconUsername').css('display', 'none');
	$('#submitLoader').css('display', 'none');

	$('#iusername').change(function () {
		$('#divUsername').removeClass('has-error').removeClass('has-success');
		$('#iconUsername').removeClass('fa-remove').removeClass('fa-check');

		if ($.trim($(this).val()) !== '') {
			$.ajax({
				type: "POST",
				url: "admin/users/ajax.existUsername.php",
				dataType: 'json',
				data: {username: $('#iusername').val()}
			}).done(function (resp) {
				$('#iconUsername').css('display', 'block');

				if (resp['msg'] === true) {
					_vUser = false;
					$('#divUsername').addClass('has-error');
					$('#iconUsername').addClass('fa-remove');
					$('#iusername').val('');

					new Noty({
						text: 'El nombre de usuario elegido ya se encuentra registrado.<br>Por favor, escoja un nombre de usuario diferente.',
						type: 'error'
					}).show();
				} else {
					_vUser = true;
					$('#divUsername').addClass('has-success');
					$('#iconUsername').addClass('fa-check');
				}
			});
		}
	});

	$('#iemail').change(function () {
		$('#divEmail').removeClass('has-error').removeClass('has-success');
		$('#iconEmail').removeClass('fa-remove').removeClass('fa-check');

		const email_reg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;

		if ($.trim($(this).val()) !== '') {
			if (!email_reg.test($.trim($(this).val()))) {
				_vEmail = false;
				$('#divEmail').addClass('has-error');
				$('#iconEmail').addClass('fa-remove');
			} else {
				_vEmail = true;
				$('#divEmail').addClass('has-success');
				$('#iconEmail').addClass('fa-check');
			}
		}
	});

	$('#formNewUser').ajaxForm({
		url: 'admin/users/ajax.insertUser.php',
		type: 'post',
		dataType: 'json',
		beforeSubmit: function () {
			const _checked = ($('input[name="iusergroups[]"]:checked').length > 0);

			if (_vUser && _vEmail) {
				$('#submitLoader').css('display', 'inline-block');
				return true;
			} else {
				let msg = '';
				if (!_checked) msg += '<br>Agregue al menos un grupo al usuario.';

				new Noty({
					text: 'Error al crear el usuario.<br>' + msg,
					type: 'error'
				}).show();
				return false;
			}
		},
		success: function (response) {
			$('#submitLoader').css('display', 'none');

			if (response.type) {
				new Noty({
					text: '<b>¡Éxito!</b><br>El usuario ha sido guardado correctamente.',
					type: 'success'
				}).show();

				$('#formNewUser').clearForm();
				$('#btnClear').click();
				$('input:file').MultiFile('reset');
			} else {
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
		}
	});

	$('#btnClear').click(function () {
		$('#divEmail').removeClass('has-error').removeClass('has-success');
		$('#iconEmail').removeClass('fa-remove').removeClass('fa-check');
		$('#divUsername').removeClass('has-error').removeClass('has-success');
		$('#iconUsername').removeClass('fa-remove').removeClass('fa-check');

		$('.minimal').each(function () {
			const id = $(this).attr('id');
			$('#' + id).iCheck('uncheck');
		});
	});
});