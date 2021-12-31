$(document).ready(function () {
    $('#tfiles').DataTable({
        columns: [null, { 'width': '20%', className: 'text-center' }],
        order: [[0, 'asc'], [1, 'desc']]
    });

    $('.fileModal').click(function () {
        var fid = $(this).attr('id').split('_').pop();
        $('#f_name').html('');
        $('#f_edition').html('');
        $('#f_date_c').html('');
        $('#f_date').html('');
        $('#f_date_v').html('');
        $('#f_type').html('');
        $('#f_downloads').html('');
        $('#f_path').attr('href', null);

        $.ajax({
            url: 'files/ajax.getOFile.php',
            type: 'POST',
            dataType: 'json',
            data: { id: fid }
        }).done(function (d) {
            console.log(d);
            if (d.oarc_id !== null) {
                $('#f_path').data('ident', d.oarc_id).attr('href', d.oarc_path);
                $('#f_name').html('<i class="fa fa-chevron-right"></i> ' + d.oarc_nombre);
                $('#f_edition').html(d.oarc_edicion);
                $('#f_date_c').html(getMonthDate(d.oarc_fecha_crea));
                $('#f_date').html(getDateToFormBD(d.oarc_fecha));
                $('#f_date_v').html(getMonthDate(d.oarc_fecha_vig));
                $('#f_type').html(getExt(d.oarc_path));
                $('#f_downloads').html(d.oarc_descargas);
            }
        });
    });

    $('.btnModal').on('click', function (e) {
        e.preventDefault();
        var fid = $(this).data('ident');

        $.ajax({
            url: 'files/ajax.setOCounter.php',
            type: 'POST',
            dataType: 'json',
            data: { id: fid }
        }).done(function (d) {
            //console.log(d);
            window.open(d.oarc_path, 'Descarga de Archivo <i class="fa fa-chevron-right"></i> Plataforma Calidad', 'width=1280,height=720,scrollbars=yes');
            $('#fileDetail').modal('hide');
        });
    });
});
