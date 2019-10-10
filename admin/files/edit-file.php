<?php include("class/classFile.php") ?>
<?php include("class/classPuntoVerificacion.php") ?>
<?php include("class/classSubPuntoVerificacion.php") ?>
<?php include("class/classCodigo.php") ?>
<?php include("class/classSubAmbito.php") ?>
<?php include("class/classTipoCaracteristica.php") ?>
<?php $tc = new TipoCaracteristica() ?>
<?php $sam = new SubAmbito() ?>
<?php $cod = new Codigo() ?>
<?php $pv = new PuntoVerificacion() ?>
<?php $spv = new SubPuntoVerificacion() ?>
<?php $am = new Ambito() ?>
<?php $fl = new File() ?>
<?php $file = $fl->get($id) ?>
<?php $tmp = explode('/', $file->arc_path) ?>
<?php $namefile = $tmp[1] ?>
<?php $sp_file = $spv->getByFile($id) ?>


<section class="content-header">
	<h1>Archivos
		<small><i class="fa fa-angle-right"></i> Edición de Documento</small>
	</h1>

	<ol class="breadcrumb">
		<li><a href="index.php?section=home"><i class="fa fa-home"></i> Inicio</a></li>
		<li><a href="index.php?section=admin&sbs=managefiles">Documentos registrados</a></li>
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
					<div class="form-group col-xs-6 has-feedback" id="gname">
						<label class="control-label" for="iname">Nombre *</label>
						<input type="text" class="form-control" id="iNname" name="iname" placeholder="Ingrese nombre del documento" maxlength="250" required value="<?php echo $file->arc_nombre ?>">
						<i class="fa form-control-feedback" id="iconname"></i>
					</div>
				</div>

				<div class="row">
					<div class="form-group col-xs-3 has-feedback" id="gversion">
						<label class="control-label" for="iversion">Versión *</label>
						<input type="text" class="form-control" id="iNversion" name="iversion" placeholder="Ingrese versión del documento" maxlength="4" required value="<?php echo $file->arc_edicion ?>">
						<i class="fa form-control-feedback" id="iconversion"></i>
					</div>

					<div class="form-group col-xs-3 has-feedback" id="gcode">
						<label class="control-label" for="icode">Código *</label>
						<input type="text" class="form-control" id="iNcode" name="icode" placeholder="Ingrese código del documento" maxlength="8" required value="<?php echo $file->arc_codigo ?>">
						<i class="fa form-control-feedback" id="iconcode"></i>
					</div>
				</div>

				<div class="row">
					<div class="form-group col-xs-3 has-feedback" id="gdate">
						<label class="control-label" for="idate">Fecha de creación *</label>
						<div class="input-group">
							<div class="input-group-addon">
								<i class="fa fa-calendar"></i>
							</div>
							<input type="text" class="form-control" id="iNdate" name="idate" data-date-format="dd/mm/yyyy" placeholder="DD/MM/AAAA" required value="<?php echo getDateToForm($file->arc_fecha_crea) ?>">
						</div>
						<i class="fa form-control-feedback" id="icondate"></i>
					</div>

					<div class="form-group col-xs-3 has-feedback" id="gdatec">
						<label class="control-label" for="idatec">Fecha de caducidad *</label>
						<div class="input-group">
							<div class="input-group-addon">
								<i class="fa fa-calendar"></i>
							</div>
							<input type="text" class="form-control" id="iNdatec" name="idatec" data-date-format="mm/yyyy" placeholder="MM/AAAA" required value="<?php echo getDateMonthToForm($file->arc_fecha_vig) ?>">
						</div>
						<i class="fa form-control-feedback" id="icondatec"></i>
					</div>
				</div>

				<div class="row">
					<div class="form-group col-xs-6 has-feedback" id="gambito">
						<label class="control-label" for="iambito">Ámbito *</label>
						<select class="form-control" id="iNambito" name="iambito" required>
							<option value="">Seleccione ámbito</option>
							<?php $am = new Ambito() ?>
							<?php $ambito = $am->getAll() ?>
							<?php foreach ($ambito as $a): ?>
								<option value="<?php echo $a->amb_id ?>" <?php if ($file->arc_amb == $a->amb_id): ?>selected<?php endif ?>><?php echo $a->amb_nombre ?></option>
							<?php endforeach ?>
						</select>
					</div>

					<div class="form-group col-xs-6 has-feedback" id="gsambito">
						<label class="control-label" for="isambito">Sub-ámbito *</label>
						<select class="form-control" id="iNsambito" name="isambito" required>
							<option value="">Seleccione sub-ámbito</option>
							<?php $sambito = $sam->getByAmbito($file->arc_amb) ?>
							<?php foreach ($sambito as $sa): ?>
								<option value="<?php echo $sa->samb_id ?>" <?php if ($file->arc_samb == $sa->samb_id): ?>selected<?php endif ?>><?php echo $sa->samb_sigla . ' - ' . $sa->samb_nombre ?></option>
							<?php endforeach ?>
						</select>
					</div>
				</div>

				<div class="row">
					<div class="form-group col-xs-6 has-feedback" id="gtcar">
						<label class="control-label" for="iambito">Tipo de Característica *</label>
						<select class="form-control" id="iNtcar" name="itcar" required>
							<option value="">Seleccione tipo</option>
							<?php $tchar = $tc->getBySubAmb($file->arc_samb) ?>
							<?php foreach ($tchar as $tc): ?>
								<option value="<?php echo $tc->tcar_id ?>" <?php if ($file->arc_tcar == $tc->tcar_id): ?>selected<?php endif ?>><?php echo $tc->tcar_nombre ?></option>
							<?php endforeach ?>
						</select>
					</div>

					<div class="form-group col-xs-6 has-feedback" id="gtcode">
						<label class="control-label" for="itcode">Código de Característica *</label>
						<select class="form-control" id="iNtcode" name="itcode" required>
							<option value="">Seleccione código</option>
							<?php $codigo = $cod->getBySaTc($file->arc_samb, $file->arc_tcar) ?>
							<?php foreach ($codigo as $c): ?>
								<option value="<?php echo $c->cod_id ?>" <?php if ($file->arc_codid == $c->cod_id): ?>selected<?php endif ?>><?php echo $c->cod_descripcion ?></option>
							<?php endforeach ?>
						</select>
					</div>
				</div>
			</div>

			<div class="box-header with-border">
				<h3 class="box-title">Detalles</h3>
			</div>

			<div class="box-body">
				<div class="row">
					<div class="form-group col-xs-12">
						<label class="control-label" for="iNdescription">Descripción</label>
						<textarea rows="4" class="form-control" id="iNdescription" name="idescription" readonly><?php echo $file->arc_sigla ?> <?php echo $file->arc_cod . '&#13;&#10;' ?>- <?php echo $file->arc_ind ?></textarea>
					</div>
				</div>

				<div class="row">
					<div class="form-group col-xs-6 has-feedback" id="gpv">
						<label class="control-label" for="iNpv">Punto de Verificación</label>
						<select class="form-control" id="iNpv" name="ipv">
							<option value="">Seleccione punto</option>
							<?php $punto = $pv->getAll() ?>
							<?php foreach ($punto as $p): ?>
								<option value="<?php echo $p->pv_id ?>"><?php echo $p->pv_nombre ?></option>
							<?php endforeach ?>
						</select>
					</div>

					<div class="form-group col-xs-6 has-feedback" id="gspv">
						<label class="control-label" for="iNspv">Sub-punto</label>
						<select class="form-control" id="iNspv" name="ispv">
							<option value="">Seleccione sub-punto</option>
						</select>
					</div>
				</div>

				<div class="row">
					<div class="col-xs-6">
						<button type="button" class="btn btn-info btn-sm" id="btnAddPoint" style="margin-bottom: 20px" disabled><i class="fa fa-plus"></i> Agregar sub-punto</button>
					</div>
				</div>

				<input type="hidden" name="inspv" id="iNnspv" value="<?php echo count($sp_file) ?>">

				<div id="divDestiny" style="padding: 2px 10px; margin-bottom: 10px; background-color: #f2f2f2; border: 2px solid #f2f2f2">
					<h4>Sub-puntos agregados</h4>
					<div class="row">
						<div class="form-group col-xs-5">
							<p class="form-control-static"><strong>Punto de verificación</strong></p>
						</div>
						<div class="form-group col-xs-6">
							<p class="form-control-static"><strong>Sub-punto</strong></p>
						</div>
						<div class="form-group col-xs-1 text-center">
							<p class="form-control-static"></p>
						</div>
					</div>

					<div id="divDestiny-inner">
						<?php $n_destinos = 0 ?>
						<?php foreach ($sp_file as $k => $v): ?>
							<div class="row" id="row<?php echo $n_destinos ?>">
								<div class="form-group col-xs-5">
									<p class="form-control-static"><?php echo $v->spv_pvnombre ?></p>
								</div>
								<div class="form-group col-xs-6">
									<p class="form-control-static"><?php echo $v->spv_nombre ?></p>
								</div>
								<div class="form-group col-xs-1 text-center">
									<button type="button" class="btn btn-xs btn-danger btnDel" name="btn_<?php echo $n_destinos ?>" id="btndel_<?php echo $n_destinos ?>"><i class="fa fa-close"></i></button>
								</div>
								<input type="hidden" class="inpv" name="iispv[]" id="iNispv_<?php echo $n_destinos ?>" value="<?php echo $v->spv_id ?>">
							</div>
							<?php $n_destinos++ ?>
						<?php endforeach ?>
					</div>
				</div>

				<div class="row">
					<div class="form-group col-xs-6">
						<label class="control-label" for="idocument">Archivo</label>
						<div class="controls">
							<input name="idocument" class="form-control" id="idocument" type="text" value="<?php echo $namefile ?>" readonly>
						</div>
					</div>
				</div>
			</div>

			<input name="iid" id="iid" type="hidden" value="<?php echo $id ?>">
			<input name="iind" id="iind" type="hidden" value="<?php echo $file->arc_indid ?>">

			<div class="box-footer">
				<button type="submit" class="btn btn-primary" id="btnsubmit"><i class="fa fa-check"></i> Guardar</button>
				<button type="reset" class="btn btn-default btn-sm" id="btnClear">Limpiar</button>
				<i class="ajaxLoader fa fa-cog fa-spin" id="submitLoader"></i>
			</div>
		</div>
	</form>
</section>

<script src="admin/files/edit-file.js?v=20191009"></script>