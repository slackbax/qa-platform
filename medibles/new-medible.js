$(document).ready(function () {
	function validateFormMed() {
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
				text: '<b>¡Éxito!</b><br>El elemento medible ha sido guardado correctamente.',
				type: 'success'
			}).show();

			$('#formNewMedible').clearForm();
			$('#btnClear').click();
		}
		else {
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
		url: 'medibles/ajax.newMedible.php',
		type: 'post',
		dataType: 'json',
		beforeSubmit: validateFormMed,
		success: showResponseMed
	};

	function validateFormAc(data, jF, o) {
		var files = true;

		if (files) {
			$('#submitLoader2').css('display', 'inline-block');
			return true;
		}
	}

	function showResponseAc(response) {
		$('#submitLoader2').css('display', 'none');

		if (response.type) {
			new Noty({
				text: '<b>¡Éxito!</b><br>La aclaratoria ha sido guardada correctamente.',
				type: 'success'
			}).show();

			$('#formNewAclaratoria').clearForm();
			$('#btnClearR').click();
		}
		else {
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

	var optionsAc = {
		url: 'medibles/ajax.newAclaratoria.php',
		type: 'post',
		dataType: 'json',
		beforeSubmit: validateFormAc,
		success: showResponseAc
	};

	$('#submitLoader, #submitLoader2').css('display', 'none');

	$('a[data-toggle="tab"]').on('shown.bs.tab', function () {
		$('#formNewMedible').clearForm();
		$('#btnClear').click();
		$('#formNewAclaratoria').clearForm();
		$('#btnClearR').click();
	});

	$('#iNambito, #iNsambito, #iNtcode, #iNnumelem, #iNdescripcion').change(function () {
		var idn = $(this).attr('id').split('N');

		if ($.trim($(this).val()) !== '') {
			$('#g' + idn[1]).removeClass('has-error').addClass('has-success');
			$('#icon' + idn[1]).removeClass('fa-remove').addClass('fa-check');
		}
		else {
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


	$('#formNewMedible').submit(function () {
		$(this).ajaxSubmit(optionsMed);
		return false;
	});

	$(document).on("focusin", "#iNdate", function (event) {
		$(this).prop('readonly', true);
	});
	$(document).on("focusout", "#iNdate", function (event) {
		$(this).prop('readonly', false);
	});

	$('#iNdate').datepicker({
		endDate: '0d'
	}).on('changeDate', function () {
		if ($.trim($(this).val()) !== '') {
			$('#gdate').removeClass('has-error').addClass('has-success');
			$('#icondate').removeClass('fa-remove fa-check').addClass('fa-check');
		}
	});

	$('#iNdate, #iNnumres, #iNambitor, #iNsambitor, #iNtcoder, #iNnumero, #iNresumen, #iNdescripcionr').change(function () {
		var idn = $(this).attr('id').split('N');

		if ($.trim($(this).val()) !== '') {
			$('#g' + idn[1]).removeClass('has-error').addClass('has-success');
			$('#icon' + idn[1]).removeClass('fa-remove').addClass('fa-check');
		}
		else {
			$('#g' + idn[1]).removeClass('has-success');
			$('#icon' + idn[1]).removeClass('fa-check');
		}
	});

	$('#iNambitor').change(function () {
		$('#iNsambitor').html('').append('<option value="">Cargando sub-ámbitos...</option>');
		$('#gsambitor').removeClass('has-error').removeClass('has-success');
		$('#iNtcoder').html('').append('<option value="">Seleccione código</option>');
		$('#gtcoder').removeClass('has-error').removeClass('has-success');

		$.ajax({
			type: "POST",
			url: "autoevaluation/ajax.getSubambitos.php",
			dataType: 'json',
			data: {am: $(this).val()}
		}).done(function (data) {
			$('#iNsambitor').html('').append('<option value="">Seleccione sub-ámbito</option>');

			$.each(data, function (k, v) {
				$('#iNsambitor').append(
					$('<option></option>').val(v.samb_id).html(v.samb_sigla + ' - ' + v.samb_nombre)
				);
			});
		});
	});

	$('#iNsambitor').change(function () {
		$('#iNtcoder').html('').append('<option value="">Cargando códigos...</option>');
		$('#gtcoder').removeClass('has-error').removeClass('has-success');

		$.ajax({
			type: "POST",
			url: "autoevaluation/ajax.getCodigos.php",
			dataType: 'json',
			data: {sa: $('#iNsambitor').val()}
		}).done(function (data) {
			$('#iNtcoder').html('').append('<option value="">Seleccione código</option>');

			$.each(data, function (k, v) {
				$('#iNtcoder').append(
					$('<option></option>').val(v.cod_id).html(v.cod_descripcion)
				);
			});
		});
	});

	$('#btnClearR').click(function () {
		$('#gdate, #gnumres, #gambitor, #gsambitor, #gtcoder, #gnumero, #gresumen, #gdescripcionr').removeClass('has-error has-success');
		$('#icondate, #iconnumres, #iconnumero, #iconresumen, #icondescripcionr').removeClass('fa-remove fa-check');
	});

	$('#formNewAclaratoria').submit(function () {
		$(this).ajaxSubmit(optionsAc);
		return false;
	});
});