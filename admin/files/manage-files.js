$(document).ready(function () {
    var tableUsr = $("#tfiles").DataTable({
        columns: [
            { "orderable": false, width: "20px", className: "text-center" },
            null,
            { className: "text-center" },
            { className: "text-center" },
            { "orderable": false, width: "100px", className: "text-center" }],
        order: [[1, "asc"]],
        buttons: [{
            extend: 'excel',
            exportOptions: {
                columns: [1, 2, 3]
            }
        }],
        serverSide: true,
        ajax: {
            url: 'admin/files/ajax.getServerFiles.php',
            type: 'GET',
            length: 20
        }
    });

    $('#tfiles').on('click', '.fileModal', function () {
        var fid = $(this).attr('id').split("_").pop();
		$("#f_name").html('<i class="fa fa-spin fa-spinner"></i>');
		$("#f_char").html('<i class="fa fa-spin fa-spinner"></i>');
		$("#f_code").html('<i class="fa fa-spin fa-spinner"></i>');
		$("#f_edition").html('<i class="fa fa-spin fa-spinner"></i>');
		$("#f_date_c").html('<i class="fa fa-spin fa-spinner"></i>');
		$("#f_date").html('<i class="fa fa-spin fa-spinner"></i>');
		$("#f_date_v").html('<i class="fa fa-spin fa-spinner"></i>');
		$("#f_pvs").html('<i class="fa fa-spin fa-spinner"></i>');
		$("#f_type").html('<i class="fa fa-spin fa-spinner"></i>');
		$("#f_user").html('<i class="fa fa-spin fa-spinner"></i>');
		$("#f_downloads").html('<i class="fa fa-spin fa-spinner"></i>');
        $("#f_path").attr('href', null);

        $.ajax({
            url: 'files/ajax.getFile.php',
            type: 'POST',
            dataType: 'json',
            data: { id: fid }
        }).done(function (d) {
            console.log(d);
            if (d.arc_id !== null) {
                $("#f_path").data('ident', d.arc_id);
                $("#f_name").html('<i class="fa fa-chevron-right"></i> ' + d.arc_nombre);
                $("#f_char").html(d.arc_char);
                $("#f_code").html(d.arc_codigo);
                $("#f_edition").html(d.arc_edicion);
                $("#f_date_c").html(getMonthDate(d.arc_fecha_crea));
                $("#f_date").html(getDateBD(d.arc_fecha));
                $("#f_date_v").html(getMonthDate(d.arc_fecha_vig));
                $("#f_type").html(getExt(d.arc_path));
				$("#f_pvs").html('');
                $("#f_user").html(d.arc_user);
                $("#f_downloads").html(d.arc_descargas);
                $("#f_path").attr('href', d.arc_path);

                $.each(d.arc_pvs, function (k, v) {
                    $("#f_pvs").append('<i class="fa fa-check"></i> ' + v + '<br>');
                });
            }
        });
    });

    $(".btnModal").click(function () {
        var fid = $(this).data('ident');

        $.ajax({
            url: 'files/ajax.setCounter.php',
            type: 'POST',
            dataType: 'json',
            data: { id: fid }
        }).done(function () {
            $('#fileDetail').modal('hide');
        });
    });

    $('#tfiles').on('click', '.fileDelete', function () {
        var uid = $(this).attr('id').split("_").pop();
        $(this).parent().parent().addClass('selected');

        swal({
            title: "¿Está seguro de querer eliminar el documento?",
            text: "Esta acción borrará todos los registros relacionados al documento.",
            type: "warning",
            showCancelButton: true,
            confirmButtonText: "Eliminar"
        }).then(function (result) {
            if (!result.dismiss) {
                $.ajax({
                    url: 'admin/files/ajax.delFile.php',
                    type: 'POST',
                    dataType: 'json',
                    data: { id: uid }
                }).done(function (response) {
                    console.log(response);

                    if (response) {
                        new Noty({
                            text: '<b>¡Éxito!</b><br>El documento ha sido eliminado correctamente.',
                            type: 'success'
                        }).show();
                    } else {
                        new Noty({
                            text: '<b>¡Error!</b><br>' + response.msg,
                            type: 'error'
                        }).show();
                    }

                    tableUsr.draw(false);
                });
            } else {
                tableUsr.draw(false);
            }
        });
    });
});