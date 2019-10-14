$(document).ready(function () {
	function validateForm() {
		var validate = true

		if (validate) {
			$('#submitLoader').css('display', 'inline-block');
			return true;
		} else {
			new Noty({
				text: 'Error al registrar directorio.',
				type: 'error'
			}).show();
			return false;
		}
	}

	function showResponse(response) {
		$('#submitLoader').css('display', 'none');

		if (response.type) {
			new Noty({
				text: '<b>¡Éxito!</b><br>El directorio ha sido guardado correctamente.',
				type: 'success'
			}).show();

			$('#formNewFolder').clearForm();
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
		url: 'admin/folders/ajax.insertFolder.php',
		type: 'post',
		dataType: 'json',
		beforeSubmit: validateForm,
		success: showResponse
	};

	$('#submitLoader').css('display', 'none');

	$('#iNname, #iNdescription').change(function () {
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
		$('#gname, #gdescription').removeClass('has-error').removeClass('has-success');
		$('#iconname, #icondescription').removeClass('fa-remove').removeClass('fa-check');
	});

	$('#formNewFolder').submit(function () {
		$(this).ajaxSubmit(options);
		return false;
	});
});