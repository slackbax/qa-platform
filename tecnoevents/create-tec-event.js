$(document).ready(function () {
    function validateForm() {
        var datos = true;

        if (parseInt($('#iNnpac').val()) === 0) {
            datos = false;
        }

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
                text: '<b>¡Éxito!</b><br>El evento ha sido guardado correctamente.',
                type: 'success'
            }).show();

            $('#formNewEvent').clearForm();
            $('#btnClear').click();
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
        url: 'tecnoevents/ajax.insertEvent.php',
        type: 'post',
        dataType: 'json',
        beforeSubmit: validateForm,
        success: showResponse
    };

    $('#submitLoader').css('display', 'none');

    $(document).on('keyup', '.input-number', function () {
        var v = this.value;
        if ($.isNumeric(v) === false) {
            this.value = this.value.slice(0, -1);
        }
    });

    $('#iNpacrut').Rut({
        on_error: function () {
            swal("Error!", "El RUT ingresado no es válido.", "error");
            $('#iNpacrut, #iNpacname').val('');
            $('#iNpacrut').val('');
            $('#gpacrut').addClass('has-error');
            $('#iconpacrut').addClass('fa-remove');
        },
        on_success: function () {
            $('#gpacrut').addClass('has-success');
            $('#iconpacrut').addClass('fa-check');
        },
        format_on: 'keyup'
    });

    $(document).on("focusin", "#iNdateev, #iNdatefab, #iNdatevenc", function () {
        $(this).prop('readonly', true);
    }).on("focusout", "#iNdateev, #iNdatefab, #iNdatevenc", function () {
        $(this).prop('readonly', false);
    });

    $('#iNdateev').datepicker({
        endDate: '0d'
    }).on('changeDate', function () {
        if ($.trim($(this).val()) !== '') {
            $('#gdateev').removeClass('has-error').addClass('has-success');
            $('#icondateev').removeClass('fa-remove fa-check').addClass('fa-check');
        }
    });

    $('#iNdatefab').datepicker({
        endDate: '0d'
    }).on('changeDate', function () {
        if ($.trim($(this).val()) !== '') {
            $('#gdatefab').removeClass('has-error').addClass('has-success');
            $('#icondatefab').removeClass('fa-remove fa-check').addClass('fa-check');
        }
    });

    $('#iNdatevenc').datepicker().on('changeDate', function () {
        if ($.trim($(this).val()) !== '') {
            $('#gdatevenc').removeClass('has-error').addClass('has-success');
            $('#icondatevenc').removeClass('fa-remove fa-check').addClass('fa-check');
        }
    });

    $('.form-control').change(function () {
        var idn = $(this).attr('id').split('N').pop();

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

    $('#formNewEvent').submit(function () {
        $(this).ajaxSubmit(options);
        return false;
    });
});