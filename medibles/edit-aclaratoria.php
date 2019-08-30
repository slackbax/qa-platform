<?php include("class/classAclaratoria.php") ?>
<?php include("class/classIndicador.php") ?>
<?php include("class/classSubAmbito.php") ?>
<?php include("class/classCodigo.php") ?>
<?php include("class/classPeriodicidad.php") ?>
<?php $ac = new Aclaratoria() ?>
<?php $in = new Indicador() ?>
<?php $acl = $ac->get($id) ?>
<?php $ind = $in->get($acl->acl_indid); ?>

<section class="content-header">
	<h1>Autoevaluación
		<small><i class="fa fa-angle-right"></i> Edición de Aclaratoria</small>
	</h1>

	<ol class="breadcrumb">
        <li><a href="index.php?section=home"><i class="fa fa-home"></i> Inicio</a></li>
		<li><a href="index.php?section=autoeval&sbs=managemedibles">Administración de adicionales de características</a></li>
		<li class="active">Edición de aclaratoria</li>
	</ol>
</section>

<section class="content container-fluid">
	<p class="bg-class bg-danger">Los campos marcados con (*) son obligatorios</p>

    <div class="box box-default">
		<form role="form" id="formEditAclaratoria">
			<div class="box-header with-border">
				<h3 class="box-title">Información de la aclaratoria</h3>
			</div>

			<div class="box-body">
				<div class="row">
					<div class="form-group col-xs-3 has-feedback" id="gdate">
						<label class="control-label" for="idate">Fecha de resolución *</label>
						<div class="input-group">
							<div class="input-group-addon">
								<i class="fa fa-calendar"></i>
							</div>
							<input type="text" class="form-control" id="iNdate" name="idate" data-date-format="dd/mm/yyyy" placeholder="DD/MM/AAAA" value="<?php echo getDateToForm($acl->acl_fecha) ?>" required>
						</div>
						<i class="fa form-control-feedback" id="icondate"></i>
					</div>

					<input type="hidden" name="iind" value="<?php echo $id ?>">

					<div class="form-group col-xs-3 has-feedback" id="gnumres">
						<label class="control-label" for="inumres">Número de Resolución *</label>
						<input type="text" class="form-control" id="iNnumres" name="inumres" placeholder="Ingrese número de resolución" value="<?php echo $acl->acl_resolucion ?>" required>
						<i class="fa form-control-feedback" id="iconnumres"></i>
					</div>
				</div>

				<div class="row">
					<div class="form-group col-xs-6 has-feedback" id="gambitor">
						<label class="control-label" for="iambitor">Ámbito *</label>
						<select class="form-control" id="iNambitor" name="iambitor" required>
							<option value="">Seleccione ámbito</option>
							<?php $am = new Ambito() ?>
							<?php $ambito = $am->getAll() ?>
							<?php foreach ($ambito as $a): ?>
								<option value="<?php echo $a->amb_id ?>"<?php if ($ind->amb_id == $a->amb_id): ?> selected<?php endif ?>><?php echo $a->amb_nombre ?></option>
							<?php endforeach ?>
						</select>
					</div>

					<div class="form-group col-xs-6 has-feedback" id="gsambitor">
						<label class="control-label" for="isambitor">Sub-ámbito *</label>
						<select class="form-control" id="iNsambitor" name="isambitor" required>
							<option value="">Seleccione sub-ámbito</option>
							<?php $sam = new SubAmbito() ?>
							<?php $sambito = $sam->getByAmbito($ind->amb_id) ?>
							<?php foreach ($sambito as $sa): ?>
								<option value="<?php echo $sa->samb_id ?>"<?php if ($ind->samb_id == $sa->samb_id): ?> selected<?php endif ?>><?php echo $sa->samb_sigla . ' - ' . $sa->samb_nombre ?></option>
							<?php endforeach ?>
						</select>
					</div>
				</div>

				<div class="row">
					<div class="form-group col-xs-6 has-feedback" id="gtcoder">
						<label class="control-label" for="itcoder">Código de característica *</label>
						<select class="form-control" id="iNtcoder" name="itcoder" required>
							<option value="">Seleccione código</option>
							<?php $cod = new Codigo() ?>
							<?php $codigo = $cod->getBySa($ind->samb_id) ?>
							<?php foreach ($codigo as $c): ?>
								<option value="<?php echo $c->cod_id ?>"<?php if ($ind->cod_id == $c->cod_id): ?> selected<?php endif ?>><?php echo $c->cod_descripcion ?></option>
							<?php endforeach ?>
						</select>
					</div>

					<div class="form-group col-xs-3 has-feedback" id="gnumero">
						<label class="control-label" for="inumero">Número de Aclaratoria *</label>
						<input type="text" class="form-control" id="iNnumero" name="inumero" placeholder="Ingrese número de aclaratoria" maxlength="4" value="<?php echo $acl->acl_numero ?>" required>
						<span class="fa form-control-feedback" id="iconnumero"></span>
					</div>
				</div>

				<?php
				$acl->acl_descripcion = str_replace("<br>", "\n", $acl->acl_descripcion);
				?>

				<div class="row">
					<div class="form-group col-xs-6 has-feedback" id="gresumen">
						<label class="control-label" for="iname">Resumen *</label>
						<input type="text" class="form-control" id="iNresumen" name="iresumen" placeholder="Ingrese resumen de la aclaratoria" maxlength="1024" value="<?php echo $acl->acl_resumen ?>" required>
						<i class="fa form-control-feedback" id="iconresumen"></i>
					</div>

					<div class="form-group col-xs-6 has-feedback" id="gdescripcionr">
						<label class="control-label" for="idescripcionr">Descripción *</label>
						<textarea rows="4" class="form-control" id="iNdescripcionr" name="idescripcionr" placeholder="Ingrese descripción de la aclaratoria" required><?php echo $acl->acl_descripcion ?></textarea>
						<i class="fa form-control-feedback" id="icondescripcionr"></i>
					</div>
				</div>
			</div>

			<div class="box-footer">
				<button type="submit" class="btn btn-primary" id="btnsubmit"><i class="fa fa-check"></i> Guardar</button>
				<button type="reset" class="btn btn-default" id="btnClear">Limpiar</button>
				<i class="ajaxLoader fa fa-cog fa-spin" id="submitLoader"></i>
			</div>
		</form>
	</div>
</section>

<script src="medibles/edit-aclaratoria.js?v=20190828"></script>