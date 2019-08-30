$(document).ready(function () {
	var _vEmail = true;

	function validateForm() {
		if (_vEmail) {
			$('#submitLoader').css('display', 'inline-block');
			return true;
		} else {
			new Noty({
				text: 'Error al editar usuario.<br>Por favor corrija los campos marcados con errores',
				type: 'error'
			}).show();
			return false;
		}
	}

	function showResponse(response) {
		$('#submitLoader').css('display', 'none');

		if (response.type) {
			new Noty({
				text: '<b>¡Éxito!</b><br>El perfil ha sido guardado correctamente.',
				type: 'success'
			}).show();

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

	var options = {
		url: 'admin/users/ajax.editProfile.php',
		type: 'post',
		dataType: 'json',
		beforeSubmit: validateForm,
		success: showResponse
	};

	$('#submitLoader').css('display', 'none');

	$('#iNemail').change(function () {
		$('#gemail').removeClass('has-error').removeClass('has-success');
		$('#iconEmail').removeClass('fa-remove').removeClass('fa-check');

		var email_reg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;

		if ($(this).val() !== '') {
			if (!email_reg.test($.trim($(this).val()))) {
				_vEmail = false;
				$('#gemail').addClass('has-error');
				$('#iconEmail').addClass('fa-remove');
			} else {
				_vEmail = true;
				$('#gemail').addClass('has-success');
				$('#iconEmail').addClass('fa-check');
			}
		}
	});

	$('#iNname, #iNlastnamep, #iNlastnamem').change(function () {
		var idn = $(this).attr('id').split('N');

		if ($.trim($(this).val()) !== '') {
			$('#g' + idn[1]).removeClass('has-error').addClass('has-success');
			$('#icon' + idn[1]).removeClass('fa-remove').addClass('fa-check');
		} else {
			$('#g' + idn[1]).removeClass('has-success');
			$('#icon' + idn[1]).removeClass('fa-check');
		}
	});

	$('#btnClear').click(function () {
		$('#gname, #glastnamep, #glastnamem, #gemail').removeClass('has-error').removeClass('has-success');
		$('#iconname, #iconlastnamep, #iconlastnamem, #iconEmail').removeClass('fa-remove').removeClass('fa-check');
	});


	$('#formNewUser').submit(function () {
		$(this).ajaxSubmit(options);
		return false;
	});
});