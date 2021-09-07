$(document).ready(function () {
    function validateForm() {
        let files = false;

        $('.multi').each( function () {
           if ($(this).val() !== '') {
               files = true;
           }
        });

        if (files) {
            $('#submitLoader').css('display', 'inline-block');
            return true;
        } else {
            new Noty({
                text: '<b>¡Error!</b><br>Por favor, agregue al menos un archivo al formulario.',
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
                type: 'success',
                callbacks: {
                    afterClose: function () {
                        document.location.reload();
                    }
                }
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

    const options = {
        url: 'events/ajax.editEvent.php',
        type: 'post',
        dataType: 'json',
        beforeSubmit: validateForm,
        success: showResponse
    };

    $('#submitLoader').css('display', 'none');

    $('#btnClear').click(function () {
        $('#grut, #gname, #gtpac, #gsala, #gcama, #ghour, #gmin, #gtev, #gstev, #grie, #gdescription, #gconsec, #gancl, #gnocu, #gcljus, #gmedp, #gvermed').removeClass('has-error has-success');
        $('#iconrut, #iconname, #iconsala, #iconcama, #icondate, #icondescription').removeClass('fa-remove fa-check');
    });

    $('#formNewEvent').submit(function () {
        $(this).ajaxSubmit(options);
        return false;
    });
});