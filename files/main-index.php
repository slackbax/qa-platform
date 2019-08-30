<?php include("class/classSubAmbito.php") ?>
<?php include("class/classTipoCaracteristica.php") ?>
<?php include("class/classFile.php") ?>
<?php $am = new Ambito() ?>
<?php $sa = new SubAmbito() ?>
<?php $tc = new TipoCaracteristica() ?>
<?php $fl = new File() ?>

<?php 
if ($am->getNumChildren($sid) == 1):
    $amb = $am->get($sid);
    $id = $amb->amb_id;
    $title = $amb->amb_nombre;
else:
    $samb = $sa->get($sid);
    $id = $samb->samb_id;
    $title = $samb->samb_nombre;
endif 
?>

<section class="content-header">
	<h1>Repositorio de Archivos
		<small><i class="fa fa-angle-right"></i> <?php echo $title ?></small>
	</h1>

	<ol class="breadcrumb">
		<li><a href="index.php?section=home"><i class="fa fa-home"></i> Inicio</a></li>
        <li <?php if (!isset($tcid)): ?> class="active"<?php endif ?>><?php if (isset($tcid)): ?><a href="index.php?section=files&sid=<?php echo $id ?>"><?php endif ?><?php echo $title ?><?php if (isset($tcid)): ?></a><?php endif ?></li>
        <?php if (isset($tcid)): ?>
        <?php $tcar = $tc->get($tcid) ?>
        <li class="active">Características <?php echo $tcar->tcar_nombre ?></li>
        <?php endif ?>
	</ol>
</section>

<section class="content container-fluid">
    <?php if (!isset($tcid)): ?>
    <div class="box box-default">
        <div class="box-header with-border">
            <h3 class="box-title">Tipos de Características</h3>
        </div>

        <?php $tipoc = $tc->getAll() ?>
        <div class="box-body">
            <table id="tcaract" class="table table-hover table-striped">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Archivos</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($tipoc as $t): ?>
                    <tr>
                        <td>
                            <i class="fa fa-folder-open text-red icon-table"></i>
                            <a href="index.php?section=files&sid=<?php echo $sid ?>&tcid=<?php echo $t->tcar_id ?>"><?php echo $t->tcar_nombre ?></a>
                        </td>
                        <td><?php echo $tc->getNumFiles($sid, $t->tcar_id) ?></td>
                    </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php endif ?>

    <?php if (isset($tcid)): ?>
    <?php $n_f = $tc->getNumFiles($sid, $tcid) ?>
    <?php if ($n_f > 0): $file = $fl->getByCaractSamb($sid, $tcid); endif ?>

    <div class="box box-default">
        <div class="box-header with-border">
            <h3 class="box-title">Archivos</h3>
        </div>

        <div class="box-body">
            <?php if ($n_f > 0): ?>
            <table id="tfiles" class="table table-hover table-striped">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Fecha de Publicación</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($file as $aux => $f): ?>
                    <tr>
                        <td>
                            <i class="fa fa-file-<?php echo getExtension($f->arc_ext) ?>-o text-<?php echo getColorExt($f->arc_ext) ?> icon-table"></i>
                            <a class="fileModal" id="id_<?php echo $f->arc_id ?>" data-toggle="modal" data-target="#fileDetail"><?php echo $f->arc_codigo . ' - ' . $f->arc_nombre ?></a>
                            <div class="td-div">
                                <p class="td-div-t first-tdiv">Edición</p>
                                <p class="td-div-i first-tdiv"><?php echo $f->arc_edicion ?></p>
                            </div>
                            <div class="td-div no-bottom">
                                <p class="td-div-t">Vigente hasta</p>
                                <p class="td-div-i"><?php echo getMonthDate($f->arc_fecha_vig) ?></p>
                            </div>
                        </td>
                        <td><?php echo getDateToForm($f->arc_fecha) ?></td>
                    </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
            <?php else: ?>
            <div class="alert alert-warning"><h4>Atención!</h4> La categoría elegida no tiene archivos registrados.</div>
            <?php endif ?>
        </div>
    </div>
    <?php endif ?>
</section>

<!-- Modal -->
<div class="modal fade" id="fileDetail" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">Información de Archivo <small id="f_name"></small></h4>
            </div>
            <div class="modal-body">
                <div class="td-div">
                    <p class="td-div-t">Característica asociada</p>
                    <p class="td-div-i" id="f_char"></p>
                </div>
                <div class="td-div">
                    <p class="td-div-t">Código</p>
                    <p class="td-div-i" id="f_code"></p>
                </div>
                <div class="td-div">
                    <p class="td-div-t">Edición</p>
                    <p class="td-div-i" id="f_edition"></p>
                </div>
                <div class="td-div">
                    <p class="td-div-t">Creado en</p>
                    <p class="td-div-i" id="f_date_c"></p>
                </div>
                <div class="td-div">
                    <p class="td-div-t">Publicado el</p>
                    <p class="td-div-i" id="f_date"></p>
                </div>
                <div class="td-div">
                    <p class="td-div-t">Vigente hasta</p>
                    <p class="td-div-i" id="f_date_v"></p>
                </div>
                <div class="td-div">
                    <p class="td-div-t">Puntos de Verificación</p>
                    <p class="td-div-i" id="f_pvs"></p>
                </div>
                <div class="td-div">
                    <p class="td-div-t">Tipo</p>
                    <p class="td-div-i" id="f_type"></p>
                </div>
                <div class="td-div no-bottom">
                    <p class="td-div-t">Descargas</p>
                    <p class="td-div-i" id="f_downloads"></p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <a id="f_path" href="" data-ident="" class="btn btn-primary btnModal" target="_blank">Descargar</a>
            </div>
        </div>
    </div>
</div>

<div class="scrollToTop">Volver arriba</div>

<script src="files/main-index.js?v=20190828"></script>