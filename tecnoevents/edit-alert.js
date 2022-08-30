$(document).ready(function () {
	function validateForm() {
		let datos = true;

		if (datos) {
			$('#submitLoader').css('display', 'inline-block');
			return true;
		} else {
			new Noty({
				text: '<b>¡Error!</b><br>No deje campos obligatorios en blanco.',
				type: 'error'
			}).show();
			return false;
		}
	}

	function showResponse(response) {
		$('#submitLoader').css('display', 'none');

		if (response.type) {
			new Noty({
				text: '<b>¡Éxito!</b><br>La alerta ha sido editada correctamente.',
				type: 'success'
			}).show();
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

	const options = {
		url: 'tecnoevents/ajax.editAlert.php',
		type: 'post',
		dataType: 'json',
		beforeSubmit: validateForm,
		success: showResponse
	};

	$('#submitLoader').css('display', 'none');

	$(document).on('keyup', '.input-number', function () {
		const v = this.value;
		if ($.isNumeric(v) === false) {
			this.value = this.value.slice(0, -1);
		}
	});

	$(document).on("focusin", "#iNdateal", function () {
		$(this).prop('readonly', true);
	}).on("focusout", "#iNdateal", function () {
		$(this).prop('readonly', false);
	});

	$('#iNdateal').datepicker({
		endDate: '0d'
	}).on('changeDate', function () {
		if ($.trim($(this).val()) !== '') {
			$('#gdateal').removeClass('has-error').addClass('has-success');
			$('#icondateal').removeClass('fa-remove fa-check').addClass('fa-check');
		}
	});

	$('.form-control').change(function () {
		const idn = $(this).attr('id').split('N').pop();

		if ($.trim($(this).val()) !== '') {
			$('#g' + idn).removeClass('has-error').addClass('has-success');
			$('#icon' + idn).removeClass('fa-times').addClass('fa-check');
		} else {
			$('#g' + idn).removeClass('has-success');
			$('#icon' + idn).removeClass('fa-check');
		}
	});

	$('#btnClear').click(function () {
		$('.form-group').removeClass('has-error has-success');
		$('.form-control-feedback').removeClass('fa-remove fa-check')
	});

	$('#formEditAlert').submit(function () {
		$(this).ajaxSubmit(options);
		return false;
	});
});
