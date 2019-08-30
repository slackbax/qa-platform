$(document).ready(function () {
	function validateForm(data, jF, o) {
		var files = true;

		if (files) {
			$('#submitLoader').css('display', 'inline-block');
			return true;
		}
	}

	function showResponse(response) {
		$('#submitLoader').css('display', 'none');

		if (response.type === true) {
			var $a = $("<a>");
			$a.attr("href", "upload/Reporte_" + response.msg + ".xlsx");
			$a.attr("target", "_blank");
			$a.text("down");
			$("#formNewReport").append($a);
			$a[0].click();
			$a.remove();
		}
	}

	var options = {
		url: 'autoevaluation/ajax.generateReport.php',
		type: 'post',
		dataType: 'json',
		beforeSubmit: validateForm,
		success: showResponse
	};

	$('#submitLoader').css('display', 'none');

	$(document).on("focusin", "#iNdate", function (event) {
		$(this).prop('readonly', true);
	});
	$(document).on("focusout", "#iNdate", function (event) {
		$(this).prop('readonly', false);
	});

	$('#iNdate').datepicker({
		minViewMode: 1
	}).on('changeDate', function () {
		if ($.trim($(this).val()) !== '') {
			$('#gdate').removeClass('has-error').addClass('has-success');
			$('#icondate').removeClass('glyphicon-remove glyphicon-ok').addClass('glyphicon-ok');
		}
	});

	$('#iNser, #iNdate').change(function () {
		var idn = $(this).attr('id').split('N');

		if ($.trim($(this).val()) !== '') {
			$('#g' + idn[1]).removeClass('has-error').addClass('has-success');
			$('#icon' + idn[1]).removeClass('glyphicon-remove').addClass('glyphicon-ok');
		} else {
			$('#g' + idn[1]).removeClass('has-success');
			$('#icon' + idn[1]).removeClass('glyphicon-ok');
		}
	});

	$('#btnClear').click(function () {
		$('#gser, #gdate').removeClass('has-error').removeClass('has-success');
		$('#icondate').removeClass('glyphicon-remove').removeClass('glyphicon-ok');
	});

	$('#formNewReport').submit(function () {
		$(this).ajaxSubmit(options);
		return false;
	});
});