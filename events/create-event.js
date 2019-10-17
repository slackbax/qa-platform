$(document).ready(function () {
	function validateForm(data, jF, o) {
		var files = datos = true;
		var fieldVal = $("iNdoccaida").val();
		if (fieldVal === '' && $('#iNcaida').val() === 1) files = false;

		if ($.trim($('#iNname').val()) === '') {
			datos = false;
		}

		if (files && datos) {
			$('#submitLoader').css('display', 'inline-block');
			return true;
		} else {
			new Noty({
				text: 'Error al registrar evento.<br>No deje campos obligatorios en blanco.',
				type: 'error'
			}).show();
			return false;
		}
	}

	function showResponse(response) {
		$('#submitLoader').css('display', 'none');

		if (response.type) {
			new Noty({
				text: '<b>¡Éxito!</b><br>El evento ha sido guardado correctamente.',
				type: 'success'
			}).show();

			$('#formNewEvent').clearForm();
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
		url: 'events/ajax.insertEvent.php',
		type: 'post',
		dataType: 'json',
		beforeSubmit: validateForm,
		success: showResponse
	};

	$('#submitLoader').css('display', 'none');

	$('#iNrut').blur(function () {
		$('#grut, #gname').removeClass('has-success has-error');
		$('#iconrut, #iconname').removeClass('fa-remove fa-check');
		$('#iNname').val('');

		if ($.trim($(this).val()) !== '') {
			$.ajax({
				url: 'events/ajax.getPaciente.php',
				type: 'post',
				dataType: 'json',
				data: {rut: $(this).val()}
			}).done(function (d) {
				if (d.ev_id !== null) {
					$('#iNname').val(d.ev_nombre);
					$('#grut, #gname').removeClass('has-error').addClass('has-success');
					$('#iconrut, #iconname').removeClass('fa-remove fa-check').addClass('fa-check');
				}
			});
		}
	}).Rut({
		on_error: function () {
			swal("Error!", "El RUT ingresado no es válido.", "error");
			$('#iNrut, #iNname').val('');
			$('#iNrut').val('');
			$('#grut').addClass('has-error');
			$('#iconrut').addClass('fa-remove');
			$('#grut, #gname').removeClass('has-success has-error');
			$('#iconrut, #iconname').removeClass('fa-remove fa-check');
		},
		on_success: function () {
			$('#grut').addClass('has-success');
			$('#iconrut').addClass('fa-check');
		},
		format_on: 'keyup'
	});

	$(document).on("focusin", "#iNdate", function (event) {
		$(this).prop('readonly', true);
	});
	$(document).on("focusout", "#iNdate", function (event) {
		$(this).prop('readonly', false);
	});

	$('#iNdate').datepicker({
		endDate: '+1d'
	}).on('changeDate', function () {
		if ($.trim($(this).val()) !== '') {
			$('#gdate').removeClass('has-error').addClass('has-success');
			$('#icondate').removeClass('fa-remove fa-check').addClass('fa-check');
		}
	});

	$('#iNname, #iNtpac, #iNedad, #iNserv, #iNhour, #iNmin, #iNtev, #iNstev, #iNrie, #iNdescription, #iNconsec, #iNnocu, #iNcljus, #iNmedp, #iNvermed, #iNcaida').change(function () {
		var idn = $(this).attr('id').split('N');

		if ($.trim($(this).val()) !== '') {
			$('#g' + idn[1]).removeClass('has-error').addClass('has-success');
			$('#icon' + idn[1]).removeClass('fa-remove').addClass('fa-check');
		} else {
			$('#g' + idn[1]).removeClass('has-success');
			$('#icon' + idn[1]).removeClass('fa-check');
		}
	});

	$('#iNtev').change(function () {
		$('#iNstev').html('').append('<option value="">Cargando eventos...</option>');
		$('#gstev').removeClass('has-error has-success');

		$.ajax({
			type: "POST",
			url: "events/ajax.getSubtiposEvento.php",
			dataType: 'json',
			data: {te: $(this).val()}
		}).done(function (data) {
			$('#iNstev').html('').append('<option value="">Seleccione evento</option>');
			$('#iNtevent').html('<em>No seleccionado</em>');

			$.each(data, function (k, v) {
				$('#iNstev').append(
					$('<option></option>').val(v.stev_id).html(v.stev_descripcion)
				);
			});
		});
	});

	$('#iNstev').change(function () {
		$('#iNvermed, #iNnocu, #iNcljus, #iNmedp').val(3);

		$.ajax({
			type: "POST",
			url: "events/ajax.getSubtipoDetail.php",
			dataType: 'json',
			data: {te: $(this).val()}
		}).done(function (d) {
			$('#iNtevent').html('<em>No seleccionado</em>');

			if (d.stev_id !== null) {
				$('#iNtevent').html('<font color="red">' + d.cat_desc + '</font>');
			}

			if (d.cat_id === 1) {
				$('#div-cent').css('display', 'block');
				$('#iNnocu, #iNcljus, #iNmedp').prop('required', true);
			} else {
				$('#div-cent').css('display', 'none');
				$('#iNnocu, #iNcljus, #iNmedp').prop('required', false);
			}
		});
	});

	$('#iNcaida').change(function () {
		($(this).val() === '1') ? $('#div-caida').css('display', 'block') : $('#div-caida').css('display', 'none');

		if ($(this).val() === '2')
			$('#iNdoccaida').MultiFile('reset');
	});

	$('#btnClear').click(function () {
		$('#grut, #gname, #gtpac, #gedad, #gserv, #gdate, #ghour, #gmin, #gtev, #gstev, #grie, #gdescription, #gconsec, #gnocu, #gcljus, #gmedp, #gvermed, #gcaida').removeClass('has-error has-success');
		$('#iconrut, #iconname, #iconedad, #icondate, #icondescription').removeClass('fa-remove fa-check');
		$('#iNtevent').html('<em>No seleccionado</em>');
		$('#div-caida').css('display', 'none');
	});

	$('#formNewEvent').submit(function () {
		$(this).ajaxSubmit(options);
		return false;
	});
});