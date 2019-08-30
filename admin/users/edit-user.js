$(document).ready(function () {
	var _vEmail = true;

	$('#submitLoader').css('display', 'none');

	$('#iemail').change(function () {
		$('#divEmail').removeClass('has-error').removeClass('has-success');
		$('#iconEmail').removeClass('fa-remove').removeClass('fa-check');

		var email_reg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;

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
		url: 'admin/users/ajax.editUser.php',
		type: 'post',
		dataType: 'json',
		beforeSubmit: function () {
			if (_vEmail) {
				$('#submitLoader').css('display', 'inline-block');
				return true;
			} else {
				new Noty({
					text: 'Error al modificar usuario.<br>Por favor corrija los campos marcados con errores',
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

				$('#divEmail').removeClass('has-error').removeClass('has-success');
				$('#iconEmail').removeClass('fa-remove').removeClass('fa-check');
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
});