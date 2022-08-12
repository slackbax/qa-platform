<?php include("class/classOFile.php") ?>
<?php $fl = new OFile() ?>
<?php $file = $fl->get($id) ?>
<?php $tmp = explode('/', $file->oarc_path) ?>
<?php $namefile = $tmp[2] ?>

<section class="content-header">
	<h1>Archivos
		<small><i class="fa fa-angle-right"></i> Edición de Documento</small>
	</h1>

	<ol class="breadcrumb">
		<li><a href="index.php?section=home"><i class="fa fa-home"></i> Inicio</a></li>
		<li class="active">Edición de documento</li>
	</ol>
</section>

<section class="content container-fluid">
	<form role="form" id="formEditFile">
		<p class="bg-class bg-danger">Los campos marcados con (*) son obligatorios</p>

		<div class="box box-default">
			<div class="box-header with-border">
				<h3 class="box-title">Información del archivo</h3>
			</div>

			<div class="box-body">
				<div class="row">
					<div class="form-group col-sm-6 has-feedback" id="gname">
						<label class="control-label" for="iNname">Nombre *</label>
						<input type="text" class="form-control" id="iNname" name="iname" placeholder="Ingrese nombre del documento" maxlength="250" value="<?php echo $file->oarc_nombre ?>" required>
						<i class="fa form-control-feedback" id="iconname"></i>
					</div>
				</div>

				<div class="row">
					<div class="form-group col-sm-3 has-feedback" id="gversion">
						<label class="control-label" for="iNversion">Versión *</label>
						<input type="text" class="form-control" id="iNversion" name="iversion" placeholder="Ingrese versión del documento" maxlength="4" value="<?php echo $file->oarc_edicion ?>" required>
						<i class="fa form-control-feedback" id="iconversion"></i>
					</div>
				</div>

				<div class="row">
					<div class="form-group col-sm-3 has-feedback" id="gdate">
						<label class="control-label" for="iNdate">Fecha de creación *</label>
						<div class="input-group">
							<div class="input-group-addon">
								<i class="fa fa-calendar"></i>
							</div>
							<input type="text" class="form-control" id="iNdate" name="idate" data-date-format="dd/mm/yyyy" placeholder="DD/MM/AAAA" value="<?php echo getDateToForm($file->oarc_fecha_crea) ?>" required>
						</div>
						<i class="fa form-control-feedback" id="icondate"></i>
					</div>

					<?php $tmp = explode('-', $file->oarc_fecha_vig) ?>
					<div class="form-group col-sm-3 has-feedback" id="gdatec">
						<label class="control-label" for="iNdatec">Fecha de caducidad *</label>
						<div class="input-group">
							<div class="input-group-addon">
								<i class="fa fa-calendar"></i>
							</div>
							<input type="text" class="form-control" id="iNdatec" name="idatec" data-date-format="mm/yyyy" placeholder="MM/AAAA" value="<?php echo $tmp[1] . '/' . $tmp[0] ?>" required>
						</div>
						<i class="fa form-control-feedback" id="icondatec"></i>
					</div>
				</div>

				<div class="row">
					<div class="form-group col-sm-6 has-feedback" id="gfolder">
						<label class="control-label" for="iNfolder">Carpeta *</label>
						<select class="form-control" id="iNfolder" name="ifolder" required>
							<option value="">Seleccione carpeta</option>
							<?php $fl = new Folder() ?>
							<?php $folder = $fl->getLesser() ?>
							<?php foreach ($folder as $f): ?>
								<option value="<?php echo $f->fol_id ?>"<?php if ($f->fol_id == $file->fol_id): ?> selected<?php endif ?>><?php echo $f->fol_nombre ?></option>
							<?php endforeach ?>
						</select>
					</div>
				</div>

				<div class="row">
					<div class="form-group col-sm-6">
						<label class="control-label" for="idocument">Archivo</label>
						<div class="controls">
							<input name="idocument" class="form-control" id="idocument" type="text" value="<?php echo $namefile ?>" readonly>
						</div>
					</div>
				</div>
			</div>

			<input name="iid" id="iid" type="hidden" value="<?php echo $id ?>">

			<div class="box-footer">
				<button type="submit" class="btn btn-primary" id="btnsubmit"><i class="fa fa-check"></i> Guardar</button>
				<button type="reset" class="btn btn-default btn-sm" id="btnClear">Limpiar</button>
				<i class="ajaxLoader fa fa-cog fa-spin" id="submitLoader"></i>
			</div>
	</form>
</section>

<script src="admin/files/edit-other-file.js"></script>
