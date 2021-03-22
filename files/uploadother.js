$(document).ready( function() {
    function validateForm() {
        var files = true;
        var fieldVal = $(".multi").val();
        if (!fieldVal) files = false;

        if (files) {
            $('#submitLoader').css('display', 'inline-block');
            return true;
        } else {
            new Noty({
                text: 'Error al registrar documento.<br>Por favor, agregue al menos un archivo al formulario.',
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

    var options = {
        url: 'files/ajax.insertOFile.php',
        type: 'post',
        dataType: 'json',
        beforeSubmit: validateForm,
        success: showResponse
    };
    
    $('#submitLoader').css('display', 'none');

    $(document).on("focusin", "#iNdate, #iNdatec", function () {
        $(this).prop('readonly', true);
    }).on("focusout", "#iNdate, #iNdatec", function () {
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

    $('#iNname, #iNversion, #iNdate, #iNdatec, #iNfolder').change( function() {
        var idn = $(this).attr('id').split('N');
        
        if ($.trim($(this).val()) !== '') {
            $('#g' + idn[1]).removeClass('has-error').addClass('has-success');
            $('#icon' + idn[1]).removeClass('fa-remove').addClass('fa-check');
        } else {
            $('#g' + idn[1]).removeClass('has-success');
            $('#icon' + idn[1]).removeClass('fa-check');
        }
    });

    $('#btnClear').click( function() {
        $('#gname, #gversion, #gdate, #gdatec, #gfolder').removeClass('has-error').removeClass('has-success');
        $('#iconname, #iconversion, #icondate, #icondatec').removeClass('fa-remove').removeClass('fa-check');
    });

    $('#formNewFile').submit( function() {
        $(this).ajaxSubmit(options);
        return false;
    });
});