$(document).ready(function () {
	function validateForm() {
		var files = true;

		if (files) {
			$('#submitLoader').css('display', 'inline-block');
			return true;
		}
	}

	function showResponse(response) {
		$('#submitLoader').css('display', 'none');

		if (response.type) {
			new Noty({
				text: '<b>¡Éxito!</b><br>El indicador ha sido editado correctamente.',
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

	var options = {
		url: 'indicators/ajax.editIndicator.php',
		type: 'post',
		dataType: 'json',
		beforeSubmit: validateForm,
		success: showResponse
	};

	$('#submitLoader').css('display', 'none');

	$('#iNambito, #iNsambito, #iNtcode, #iNem, #iNname, #iNdescripcion, #iNmetodo, #iNnum, #iNden, #iNperiodo, #iNumbral').change(function () {
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
		$('#iNem').html('').append('<option value="">Seleccione elemento</option>');
		$('#gem').removeClass('has-error').removeClass('has-success');

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
		$('#iNem').html('').append('<option value="">Seleccione elemento</option>');
		$('#gem').removeClass('has-error').removeClass('has-success');

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

	$('#iNtcode').change(function () {
		$('#iNem').html('').append('<option value="">Cargando elementos...</option>');
		$('#gem').removeClass('has-error').removeClass('has-success');

		if ($(this).val() !== '') {
			$.ajax({
				type: "POST",
				url: "autoevaluation/ajax.getCaracteristica.php",
				dataType: 'json',
				data: {sa: $('#iNsambito').val(), cod: $(this).val()}
			}).done(function (data) {
				$('#iNem').html('').append('<option value="">Seleccione elemento</option>');

				$.each(data.ems, function (k, v) {
					//var desc = v.em_descripcion.split('.');
					var desc = v.em_descripcion.substring(0, 120);
					if (v.em_descripcion.length > 120) desc += '...';

					$('#iNem').append(
						$('<option></option>').val(v.em_id).html(v.em_numero + ': ' + desc)
					);
				});
			});
		}
	});

	$('#btnClear').click(function () {
		$('#gambito, #gsambito, #gtcode, #gem, #gname, #gdescripcion, #gmetodo, #gnum, #gden, #gperiodo, #gumbral').removeClass('has-error has-success');
		$('#iconname, #icondescripcion, #iconmetodo, #iconnum, #iconden, #iconumbral').removeClass('fa-remove fa-check');
	});

	$('#formEditIndicator').submit(function () {
		$(this).ajaxSubmit(options);
		return false;
	});
});