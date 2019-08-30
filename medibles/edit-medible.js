$(document).ready(function () {
	function validateFormMed(data, jF, o) {
		var files = true;

		if (files) {
			$('#submitLoader').css('display', 'inline-block');
			return true;
		}
	}

	function showResponseMed(response) {
		$('#submitLoader').css('display', 'none');

		if (response.type) {
			new Noty({
				text: '<b>¡Éxito!</b><br>El elemento medible ha sido editado correctamente.',
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

	var optionsMed = {
		url: 'medibles/ajax.editMedible.php',
		type: 'post',
		dataType: 'json',
		beforeSubmit: validateFormMed,
		success: showResponseMed
	};

	$('#submitLoader').css('display', 'none');

	$('#iNambito, #iNsambito, #iNtcode, #iNnumelem, #iNdescripcion').change(function () {
		var idn = $(this).attr('id').split('N');

		if ($.trim($(this).val()) !== '') {
			$('#g' + idn[1]).removeClass('has-error').addClass('has-success');
			$('#icon' + idn[1]).removeClass('fa-remove').addClass('fa-check');
		} else {
			$('#g' + idn[1]).removeClass('has-success');
			$('#icon' + idn[1]).removeClass('fa-check');
		}
	});

	$('#iNambito').change(function () {
		$('#iNsambito').html('').append('<option value="">Cargando sub-ámbitos...</option>');
		$('#gsambito').removeClass('has-error').removeClass('has-success');
		$('#iNtcode').html('').append('<option value="">Seleccione código</option>');
		$('#gtcode').removeClass('has-error').removeClass('has-success');

		$.ajax({
			type: "POST",
			url: "autoevaluation/ajax.getSubambitos.php",
			dataType: 'json',
			data: {am: $(this).val()}
		}).done(function (data) {
			$('#iNsambito').html('').append('<option value="">Seleccione sub-ámbito</option>');

			$.each(data, function (k, v) {
				$('#iNsambito').append(
					$('<option></option>').val(v.samb_id).html(v.samb_sigla + ' - ' + v.samb_nombre)
				);
			});
		});
	});

	$('#iNsambito').change(function () {
		$('#iNtcode').html('').append('<option value="">Cargando códigos...</option>');
		$('#gtcode').removeClass('has-error').removeClass('has-success');

		$.ajax({
			type: "POST",
			url: "autoevaluation/ajax.getCodigos.php",
			dataType: 'json',
			data: {sa: $('#iNsambito').val()}
		}).done(function (data) {
			$('#iNtcode').html('').append('<option value="">Seleccione código</option>');

			$.each(data, function (k, v) {
				$('#iNtcode').append(
					$('<option></option>').val(v.cod_id).html(v.cod_descripcion)
				);
			});
		});
	});

	$('#btnClear').click(function () {
		$('#gambito, #gsambito, #gtcode, #gnumelem, #gdescripcion').removeClass('has-error has-success');
		$('#iconnumelem, #icondescripcion').removeClass('fa-remove fa-check');
	});

	$('#formEditMedible').submit(function () {
		$(this).ajaxSubmit(optionsMed);
		return false;
	});
});