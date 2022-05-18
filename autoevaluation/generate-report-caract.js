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

		if (response.type === true) {
			var $a = $("<a>");
			$a.attr("href", "upload/Resumen_" + response.msg + ".xlsx");
			$a.attr("target", "_blank");
			$a.text("down");
			$("#formNewReport").append($a);
			$a[0].click();
			$a.remove();
		}
	}

	var options = {
		url: 'autoevaluation/ajax.generateReportCaract.php',
		type: 'post',
		dataType: 'json',
		beforeSubmit: validateForm,
		success: showResponse
	};

	$('#submitLoader').css('display', 'none');

	$(document).on("focusin", "#iNdate", function (event) {
		$(this).prop('readonly', true);
	}).on("focusout", "#iNdate", function (event) {
		$(this).prop('readonly', false);
	});

	$('#gdate .input-daterange').each(function () {
		$(this).datepicker({
			startView: 0,
			minViewMode: 0
		});
	}).change(function () {
		if ($.trim($('#iNdatei').val()) !== '' && $.trim($('#iNdatet').val()) !== '') {
			$('#gdate').addClass('has-success');
		} else {
			$('#gdate').removeClass('has-success');
		}
	});

	$('#btnClear').click(function () {
		$('#gdate').removeClass('has-error').removeClass('has-success');
		$('#icondate').removeClass('fa-remove').removeClass('fa-check');
	});

	$('#formNewReport').submit(function () {
		$(this).ajaxSubmit(options);
		return false;
	});
});
