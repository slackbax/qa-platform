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
				text: '<b>¡Éxito!</b><br>El reporte ha sido guardado correctamente.',
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
		url: 'autoevaluation/ajax.editAutoeval.php',
		type: 'post',
		dataType: 'json',
		beforeSubmit: validateForm,
		success: showResponse
	};

	$('#submitLoader').css('display', 'none');

	$(document).on("focusin", "#iNdate", function () {
		$(this).prop('readonly', true);
	});
	$(document).on("focusout", "#iNdate", function () {
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

	$('#iNname, #iNspv, #iNversion, #iNcode, #iNdate, #iNdatec, #iNambito, #iNsambito, #iNtcode').change(function () {
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
		$('#iNdescription').val('');
		$('#t-autoeval').html('');

		$('.ipv_check').each(function () {
			$(this).prop('checked', false);
		});

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
		$('#iNdescription').val('');
		$('#t-autoeval').html('');

		$('.ipv_check').each(function () {
			$(this).prop('checked', false);
		});

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
		$('#iNdescription').val('');

		$('.ipv_check').each(function () {
			$(this).prop('checked', false);
		});

		if ($(this).val() !== '') {
			$.ajax({
				type: "POST",
				url: "autoevaluation/ajax.getCaracteristica.php",
				dataType: 'json',
				data: {sa: $('#iNsambito').val(), cod: $(this).val()}
			}).done(function (data) {
				$('#iind').val(data.ind_id);

				var txt = '';
				txt += '<h4>Detalles</h4>';
				txt += '<table class="table table-condensed">';
				txt += '<thead>' +
					'<tr>' +
					'<th>Descripción</th>' +
					'</tr>' +
					'</thead>';
				txt += '<tbody>';
				txt += '<tr>';
				txt += '<td><strong>' + data.ind_descripcion + '<strong></td>';
				txt += '</tr>';
				txt += '</tbody>';
				txt += '</table>';

				txt += '<table class="table table-condensed table-striped">';
				txt += '<thead>' +
					'<tr>' +
					'<th colspan="2">Aclaratoria</th>' +
					'</tr>' +
					'</thead>';
				txt += '<tbody>';

				$.each(data.acl, function (k, v) {
					txt += '<tr>' +
						'<td class="text-center" rowspan="2" width="100px">N° ' + v.acl_numero + '</td>' +
						'<td>' +
						'<strong>' + v.acl_resumen + '</strong>' +
						'</td></tr>' +
						'<tr><td>' +
						v.acl_descripcion +
						'</td>' +
						'</tr>';
				});

				txt += '</tbody>';
				txt += '</table>';

				data.pvs = $.map(data.pvs, function (v, k) {
					if (v.pv_code == null) return null;
					return v;
				});

				txt += '<div class="table-responsive">';
				txt += '<table class="table table-condensed table-striped">';
				txt += '<thead>' +
					'<tr>' +
					'<th class="text-center" style="width:100px">Código Característica</th>' +
					'<th class="text-center" style="width:150px">Verificadores</th>' +
					'<th class="text-center" colspan="' + data.pvs.length + '">Puntos de Verificación</th>' +
					'<th class="text-center">Observaciones</th>' +
					'</tr>' +
					'</thead>';
				txt += '<tbody>';
				txt += '<tr>';
				txt += '<td class="text-center" rowspan="' + (data.ems.length + 1) + '">' + data.samb_sigla + '-' + data.cod_descripcion + '</td>';
				txt += '<td><strong>Elementos medibles ' + data.samb_sigla + '-' + data.cod_descripcion + '</strong></td>';

				$.each(data.pvs, function (k, v) {
					if (v.pv_code != null) {
						txt += '<td class="text-center td-pvs"><strong>' + v.pv_code + '</strong></td>';
					}
				});

				txt += '<td></td>';
				txt += '</tr>';

				$.each(data.ems, function (k, v) {
					txt += '<tr>';
					txt += '<td>' + v.em_descripcion + '</td>';

					$.each(data.pvs, function (kv, vv) {
						txt += '<td class="text-center">';
						txt += '<div class="radio"><label class="label-checkbox"><input type="radio" class="minimal" id="vf_si_' + v.em_id + '_' + vv.pv_id + '" name="vf[' + v.em_id + '_' + vv.pv_id + ']" value="1"> Sí</label></div>';
						txt += '<div class="radio"><label class="label-checkbox"><input type="radio" class="minimal" id="vf_no_' + v.em_id + '_' + vv.pv_id + '" name="vf[' + v.em_id + '_' + vv.pv_id + ']" value="0"> No</label></div>';
						txt += '<div class="radio"><label class="label-checkbox"><input type="radio" class="minimal" id="vf_na_' + v.em_id + '_' + vv.pv_id + '" name="vf[' + v.em_id + '_' + vv.pv_id + ']" value="2"> N/A</label></div>';
						txt += '</td>';
					});

					txt += '<td><textarea class="form-control" rows="4" name="obs[' + v.em_id + ']"></textarea></td>';
					txt += '</tr>';
				});

				txt += '</tbody>';
				txt += '</table>';
				txt += '</div>';

				$('#t-autoeval').html(txt);
				$('.minimal').iCheck({
					radioClass: 'iradio_square-green'
				});
			});
		}
	});

	$('#btnClear').click(function () {
		$('#gname, #gspv, #gversion, #gcode, #gdate, #gdatec, #gambito, #gsambito, #gtcode').removeClass('has-error').removeClass('has-success');
		$('#iconname, #iconversion, #iconcode, #icondate, #icondatec, #iconambito, #iconsambito, #icontcode').removeClass('fa-remove').removeClass('fa-check');
	});

	$('#formNewEvent').submit(function () {
		$(this).ajaxSubmit(options);
		return false;
	});
});