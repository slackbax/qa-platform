$(document).ready(function () {
	let n_destinos;

	function validateForm() {
		let validate = true;
		const fieldVal = $(".multi").val();
		if (!fieldVal) validate = false;

		if (n_destinos === 0)
			validate = false;

		if (validate) {
			$('#submitLoader').css('display', 'inline-block');
			return true;
		} else {
			new Noty({
				text: 'Error al registrar documento.<br>Por favor, agregue al menos un punto de verificación o archivo al formulario.',
				type: 'error'
			}).show();
			return false;
		}
	}

	function showResponse(response) {
		$('#submitLoader').css('display', 'none');

		if (response.type) {
			new Noty({
				text: '<b>¡Éxito!</b><br>El documento ha sido guardado correctamente.',
				type: 'success'
			}).show();

			$('#formNewFile').clearForm();
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

	let options = {
		url: 'files/ajax.insertFile.php',
		type: 'post',
		dataType: 'json',
		beforeSubmit: validateForm,
		success: showResponse
	}, ArrayDestinos = [];
	n_destinos = 0;
	let d_spv = 0;

	$('#submitLoader').css('display', 'none');

	$(document).on("focusin", "#iNdate, #iNdatec", function () {
		$(this).prop('readonly', true);
	}).on("focusout", "#iNdate, #iNdatec", function () {
		$(this).prop('readonly', false);
	});

	$('#iNdate').datepicker({
		endDate: '+1m'
	}).on('changeDate', function () {
		if ($.trim($(this).val()) !== '') {
			$('#gdate').removeClass('has-error').addClass('has-success');
			$('#icondate').removeClass('fa-remove fa-check').addClass('fa-check');
		}
	});

	$('#iNdatec').datepicker({
		startView: 1,
		minViewMode: 1,
		startDate: '-5y'
	}).on('changeDate', function () {
		if ($.trim($(this).val()) !== '') {
			$('#gdatec').removeClass('has-error').addClass('has-success');
			$('#icondatec').removeClass('fa-remove fa-check').addClass('fa-check');
		}
	});

	$('#iNname, #iNversion, #iNcode, #iNresp, #iNdate, #iNdatec, #iNtdocumento, #iNcaracter, #iNambito, #iNsambito, #iNtcar, #iNtcode, #iNpv, #iNspv').change(function () {
		const idn = $(this).attr('id').split('N');

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
		$('#iNtcar').html('').append('<option value="">Seleccione tipo</option>');
		$('#gtcar').removeClass('has-error').removeClass('has-success');
		$('#iNtcode').html('').append('<option value="">Seleccione código</option>');
		$('#gtcode').removeClass('has-error').removeClass('has-success');
		$('#iNdescription').val('');

		$.ajax({
			type: "POST",
			url: "files/ajax.getSubambitos.php",
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
		$('#iNtcar').html('').append('<option value="">Cargando tipo...</option>');
		$('#gtcar').removeClass('has-error').removeClass('has-success');
		$('#iNtcode').html('').append('<option value="">Seleccione código</option>');
		$('#gtcode').removeClass('has-error').removeClass('has-success');
		$('#iNdescription').val('');

		$.ajax({
			type: "POST",
			url: "files/ajax.getTipoCaracts.php",
			dataType: 'json',
			data: {sa: $(this).val()}
		}).done(function (data) {
			$('#iNtcar').html('').append('<option value="">Seleccione tipo</option>');

			$.each(data, function (k, v) {
				$('#iNtcar').append(
					$('<option></option>').val(v.tcar_id).html(v.tcar_nombre)
				);
			});
		});
	});

	$('#iNtcar').change(function () {
		$('#iNtcode').html('').append('<option value="">Cargando códigos...</option>');
		$('#gtcode').removeClass('has-error').removeClass('has-success');
		$('#iNdescription').val('');

		$.ajax({
			type: "POST",
			url: "files/ajax.getCodigos.php",
			dataType: 'json',
			data: {sa: $('#iNsambito').val(), tc: $(this).val()}
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
		$('#iNdescription').val('');

		if ($(this).val() !== '') {
			$.ajax({
				type: "POST",
				url: "files/ajax.getCaracteristica.php",
				dataType: 'json',
				data: {sa: $('#iNsambito').val(), cod: $(this).val()}
			}).done(function (data) {
				$('#iind').val(data.ind_id);
				$('#iNdescription').val(data.samb_sigla + ' ' + data.cod_descripcion + '\n- ' + data.ind_descripcion);

				$.each(data.pvs, function (k, v) {
					$('#ipvs_' + v.pv_id).prop('checked', true);
				});
			});
		}
	});

	$('#iNpv').change(function () {
		$('#iNspv').html('').append('<option value="">Cargando sub-puntos...</option>');
		$('#gspv').removeClass('has-error').removeClass('has-success');

		$.ajax({
			type: "POST",
			url: "files/ajax.getSubpuntos.php",
			dataType: 'json',
			data: {pv: $('#iNpv').val()}
		}).done(function (data) {
			$('#iNspv').html('').append('<option value="">Seleccione sub-punto</option>');

			$.each(data, function (k, v) {
				$('#iNspv').append(
					$('<option></option>').val(v.spv_id).html(v.spv_nombre)
				);
			});
		});
	});

	$('#iNspv').change(function () {
		if ($.trim($(this).val()) !== '') {
			$('#btnAddPoint').prop('disabled', false);
		}
	});

	$('#btnAddPoint').click(function () {
		const pvText = $('#iNpv :selected').text(), spvVal = $('#iNspv').val(), spvText = $('#iNspv :selected').text();

		if ($.trim(spvVal) !== '') {
			let chk = false;

			$(ArrayDestinos).each(function (index) {
				if (ArrayDestinos[index] === spvVal) chk = true;
			});

			if (!chk) {
				ArrayDestinos.push(spvVal);

				const $row = $('<div>');
				$row.attr('id', 'row' + n_destinos).addClass('row');

				const $pv = $('<div>'), $spv = $('<div>'), $dl = $('<div>');
				$pv.addClass('form-group col-sm-5');
				$spv.addClass('form-group col-sm-6');
				$dl.addClass('form-group col-sm-1 text-center');
				$row.append('<input type="hidden" name="iispv[]" id="iNispv_' + n_destinos + '" value="' + spvVal + '">');

				const $namePv = $('<p>'), $nameSpv = $('<p>');
				$namePv.addClass('form-control-static').text(pvText);
				$pv.append($namePv);
				$nameSpv.addClass('form-control-static').text(spvText);
				$spv.append($nameSpv);

				$dl.append('<button type="button" class="btn btn-xs btn-danger btnDel" name="btn_' + n_destinos + '" id="btndel_' + n_destinos + '"><i class="fa fa-close"></i></button>');
				$row.append($pv).append($spv).append($dl);

				$('#gpv, #gspv').removeClass('has-success');
				$('#iNpv').val('').change();
				if (n_destinos === 0) $('#divDestiny-inner').html('');
				$('#divDestiny-inner').append($row);
				$('#divDestiny').css('display', 'block');
				n_destinos++;
				d_spv++;
				$('#iNnspv').val(d_spv);
			} else {
				swal("Error", "El punto elegido ya se encuentra en la lista de puntos agregados.", "error");
				$('#gspv').removeClass('has-success');
				$('#iNspv').val('');
			}
		}
	});

	$('#divDestiny').on('click', '.btnDel', function () {
		console.log(ArrayDestinos);
		const idn = $(this).attr('id').split('_').pop();
		const valDel = $('#iNispv_' + idn).val();

		$(ArrayDestinos).each(function (index) {
			if (ArrayDestinos[index] === valDel)
				ArrayDestinos.splice(index, 1);
		});

		console.log(ArrayDestinos);
		$('#row' + idn).remove();
		d_spv--;

		if (d_spv === 0) {
			n_destinos = 0;
			$('#divDestiny-inner').html('<div class="row"><div class="form-group col-sm-12"><p><em>No se han agregado puntos de verificación.</em></p></div></div>');
		}

		$('#iNndest').val(d_spv);
	});

	$('#btnClear').click(function () {
		$('#gname, #gversion, #gcode, #gdate, #gdatec, #gambito, #gsambito, #gtcar, #gtcode, #gpv').removeClass('has-error').removeClass('has-success');
		$('#iconname, #iconversion, #iconcode, #icondate, #icondatec, #iconambito, #iconsambito, #icontcar, #icontcode').removeClass('fa-remove').removeClass('fa-check');
	});

	$('#formNewFile').submit(function () {
		$(this).ajaxSubmit(options);
		return false;
	});
});
