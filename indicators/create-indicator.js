$(document).ready(function () {
	function validateForm() {
		$('#submitLoader').css('display', 'inline-block');
		$('#divResult').html('<em>Buscando datos asociados...</em>');
		$('#iNspv').val('');
		$('#iNyear').val('');
		return true;
	}

	function showResponse(response) {
		$('#divResult').html('');
		$('#submitLoader').css('display', 'none');
		$('#iNspv').val(response.spv);
		$('#iNyear').val(response.y);
		var tab_num = 1, tab_den = 2;
		if (response.i.length > 0) $('#btnsubmit').prop('disabled', false);
		var first = true, strFirst;

		if (response.i.length > 0)
			$.each(response.i, function (k, v) {
				strFirst = (!first) ? ' style="margin-top:35px"' : '';
				var txt = '<h6' + strFirst + '><strong>Característica: </strong> ' + v.samb_sigla + ' ' + v.cod_descripcion + ' - ' + v.ine_inddesc + '</h6><h5><strong>Indicador: </strong>' + v.ine_nombre + '</h5>';
				txt += '<div class="row">';
				txt += '<div class="col-sm-2"><strong>Mes</strong></div>';
				txt += '<div class="col-sm-10">';
				for (var i = 1; i < 13; i++) {
					txt += '<div class="col-sm-1 text-center">' + i + '</div>';
				}
				txt += '</div>';
				txt += '</div>';

				//Numerador
				txt += '<div class="row">';
				txt += '<div class="col-sm-2">' + v.ine_num_desc + '</div>';
				txt += '<div class="col-sm-10">';
				for (var i = 1; i < 13; i++) {
					var r = i % parseInt(v.ine_penum);
					var r_o = '';
					var numerador = '';

					if (response.db[v.ine_id] !== undefined && response.db[v.ine_id][i] !== undefined) {
						var numer = response.db[v.ine_id][i];
						numerador = numer.num;
					}

					txt += '<div class="col-sm-1">';
					if (r === 0) {
						txt += '<input type="text" class="form-control input-sm input-number text-center input-nmr" tabindex="' + tab_num + '" id="iNnum-' + v.ine_id + '-' + i + '" name="num[' + v.ine_id + '][' + i + ']" value="' + numerador + '"' + r_o + '>';
						tab_num += 2;
					}
					txt += '</div>';
				}
				txt += '</div>';
				txt += '</div>';

				//Denominador
				txt += '<div class="row" style="margin-top:5px">';
				txt += '<div class="col-sm-2">' + v.ine_den_desc + '</div>';
				txt += '<div class="col-sm-10">';
				for (var i = 1; i < 13; i++) {
					var r = i % parseInt(v.ine_penum);
					//var r_o = ' disabled';
					var r_o = '';
					var denominador = '';

					if (response.db[v.ine_id] !== undefined && response.db[v.ine_id][i] !== undefined) {
						var numer = response.db[v.ine_id][i];
						denominador = numer.den;
					}

					txt += '<div class="col-sm-1">';
					if (r === 0) {
						txt += '<input type="text" class="form-control input-sm input-number text-center input-dnm" tabindex="' + tab_den + '" id="iNden-' + v.ine_id + '-' + i + '" name="den[' + v.ine_id + '][' + i + ']" value="' + denominador + '"' + r_o + '>';
						tab_den += 2;
					}
					txt += '</div>';
				}
				txt += '</div>';
				txt += '</div>';

				txt += '<div class="row"><div class="col-sm-12"><div class="col-sm-12 col-divider bd-bottom"></div></div></div>';

				txt += '<div class="row">';
				txt += '<div class="col-sm-2">Porcentaje cumplimiento</div>';
				txt += '<div class="col-sm-10">';

				for (var i = 1; i < 13; i++) {
					var r = i % parseInt(v.ine_penum);
					var total = 0;

					if (response.db[v.ine_id] !== undefined && response.db[v.ine_id][i] !== undefined) {
						var numer = response.db[v.ine_id][i];
						numerador = numer.num;
						denominador = numer.den;

						if (parseInt(numerador) === 0 && parseInt(denominador === 0)) {
							total = 0;
						} else {
							total = Math.round(parseInt(numerador) / parseInt(denominador) * 100);
						}
					}

					txt += '<div class="col-sm-1">';
					if (r === 0) {
						txt += '<input type="text" class="form-control input-sm input-number text-center" id="iNtot-' + v.ine_id + '-' + i + '" name="tot[' + v.ine_id + '][' + i + ']" value="' + total + '" disabled>';
					}
					txt += '</div>';
				}

				txt += '</div>';
				txt += '</div>';

				$('#divResult').append(txt);
				first = false;
			});
		else
			$('#divResult').html('<em>No hay resultados para la búsqueda</em>');
	}

	var options = {
		url: 'indicators/ajax.findIndicator.php',
		type: 'post',
		dataType: 'json',
		beforeSubmit: validateForm,
		success: showResponse
	};

	function validateForm2() {
		$('#submitLoader2').css('display', 'inline-block');
		return true;
	}

	function showResponse2(response) {
		$('#submitLoader2').css('display', 'none');

		if (response.type) {
			new Noty({
				text: '<b>¡Éxito!</b><br>Los valores han sido guardado correctamente.',
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

	var options2 = {
		url: 'indicators/ajax.insertIndicator.php',
		type: 'post',
		dataType: 'json',
		beforeSubmit: validateForm2,
		success: showResponse2
	};

	$('#submitLoader, #submitLoader2').css('display', 'none');
	$('#btnsubmit').prop('disabled', true);

	$(document).on("focusin", "#iNdate", function (event) {
		$(this).prop('readonly', true);
	});
	$(document).on("focusout", "#iNdate", function (event) {
		$(this).prop('readonly', false);
	});

	$('#iNdate').datepicker({
		minViewMode: 2,
		endDate: '+0y'
	}).on('changeDate', function () {
		if ($.trim($(this).val()) !== '') {
			$('#gdate').removeClass('has-error').addClass('has-success');
			$('#icondate').removeClass('fa-remove fa-check').addClass('fa-check');
		}
	});

	$('#formSaveInd').on('change', '.input-number', function () {
		var value = $.trim($(this).val());

		if (value !== '') {
			if (parseInt(value) < 0) {
				$(this).val('');
			}
		}
	});

	$('#iNdate, #iNpv').change(function () {
		var idn = $(this).attr('id').split('N');

		if ($.trim($(this).val()) !== '') {
			$('#g' + idn[1]).removeClass('has-error').addClass('has-success');
			$('#icon' + idn[1]).removeClass('fa-remove').addClass('fa-check');
		} else {
			$('#g' + idn[1]).removeClass('has-success');
			$('#icon' + idn[1]).removeClass('fa-check');
		}
	});

	$('#formSaveInd').on('change', '.input-nmr, .input-dnm', function () {
		var tmp = $(this).attr('id').split('-');
		var id = tmp[1];
		var mon = tmp[2];
		var num = $.trim($('#iNnum-' + id + '-' + mon).val());
		var den = $.trim($('#iNden-' + id + '-' + mon).val());

		if (num !== '' && den !== '') {
			if (parseInt(num) === 0 && parseInt(den) === 0) {
				$('#iNtot-' + id + '-' + mon).val(0);
			} else {
				var total = (parseInt(num) / parseInt(den) * 100);
				$('#iNtot-' + id + '-' + mon).val(Math.round(total));
			}
		}
	});

	$('#btnClear').click(function () {
		$('#gname, #gversion, #gdate, #gdatec, #gfolder').removeClass('has-error').removeClass('has-success');
		$('#iconname, #iconversion, #icondate, #icondatec').removeClass('fa-remove').removeClass('fa-check');
	});


	$('#formSearchIndicator').submit(function () {
		$(this).ajaxSubmit(options);
		return false;
	});

	$('#formSaveInd').submit(function () {
		$(this).ajaxSubmit(options2);
		return false;
	});
});