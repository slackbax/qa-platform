<?php include("class/classOFile.php") ?>
<?php $fol = new Folder() ?>
<?php $fl = new OFile() ?>

<?php
$folder = $fol->get($sfid);
$id = $folder->fol_id;
$title = $folder->fol_nombre;
?>

<section class="content-header">
	<h1>Repositorio de Archivos
		<small><i class="fa fa-angle-right"></i> <?php echo $title ?></small>
	</h1>

	<ol class="breadcrumb">
		<li><a href="index.php?section=home"><i class="fa fa-home"></i> Inicio</a></li>
		<li class="active"><?php echo $title ?></li>
	</ol>
</section>

<?php $n_f = $fol->getNumFiles($sfid) ?>
<?php if ($n_f > 0): $file = $fl->getByFolder($sfid); endif ?>

<section class="content container-fluid">
	<div class="box box-default">
		<div class="box-header with-border">
			<h3 class="box-title">Archivos</h3>
		</div>

		<div class="box-body">
			<div class="row">
				<div class="form-group col-sm-4">
					<label>Directorio</label>
					<p class="form-control-static">
						<?php echo $folder->fol_nombre ?>
					</p>
				</div>
				<div class="form-group col-sm-8">
					<label>Descripción</label>
					<p class="form-control-static">
						<?php echo $folder->fol_descripcion ?>
					</p>
				</div>
			</div>
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
								<i class="fa fa-file-<?php echo getExtension($f->oarc_ext) ?>-o text-<?php echo getColorExt($f->oarc_ext) ?> icon-table"></i>
								<a class="fileModal" id="id_<?php echo $f->oarc_id ?>" data-toggle="modal" data-target="#fileDetail"><?php echo $f->oarc_nombre ?></a>
								<div class="td-div">
									<p class="td-div-t first-tdiv">Edición</p>
									<p class="td-div-i first-tdiv"><?php echo $f->oarc_edicion ?></p>
								</div>
								<div class="td-div no-bottom">
									<p class="td-div-t">Vigente hasta</p>
									<p class="td-div-i"><?php echo getMonthDate($f->oarc_fecha_vig) ?></p>
								</div>
							</td>
							<td><?php echo getDateToForm($f->oarc_fecha) ?></td>
						</tr>
					<?php endforeach ?>
					</tbody>
				</table>
			<?php else: ?>
				<div class="alert alert-warning"><h4>Atención!</h4> La categoría elegida no tiene archivos registrados.</div>
			<?php endif ?>
		</div>
	</div>
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
				<button id="f_path" href="" data-ident="" type="button" class="btn btn-primary btnModal" target="_blank">Descargar</button>
			</div>
		</div>
	</div>
</div>

<div class="scrollToTop">Volver arriba</div>

<script src="files/other-index.js?v=20190828"></script>