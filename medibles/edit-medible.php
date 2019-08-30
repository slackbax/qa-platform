<?php include("class/classElementoMed.php") ?>
<?php include("class/classIndicador.php") ?>
<?php include("class/classSubAmbito.php") ?>
<?php include("class/classCodigo.php") ?>
<?php include("class/classPeriodicidad.php") ?>
<?php $em = new ElementoMed() ?>
<?php $in = new Indicador() ?>
<?php $elm = $em->get($id) ?>
<?php $ind = $in->get($elm->elm_indid); ?>

<section class="content-header">
	<h1>Autoevaluación
		<small><i class="fa fa-angle-right"></i> Edición de Elemento Medible</small>
	</h1>

	<ol class="breadcrumb">
        <li><a href="index.php?section=home"><i class="fa fa-home"></i> Inicio</a></li>
		<li><a href="index.php?section=autoeval&sbs=managemedibles">Administración de adicionales de características</a></li>
		<li class="active">Edición de elemento medible</li>
	</ol>
</section>

<section class="content container-fluid">
	<p class="bg-class bg-danger">Los campos marcados con (*) son obligatorios</p>
    
	<div class="box box-default">
		<form role="form" id="formEditMedible">
			<div class="box-header with-border">
				<h3 class="box-title">Información del elemento medible</h3>
			</div>

			<div class="box-body">
				<div class="row">
					<div class="form-group col-xs-6 has-feedback" id="gambito">
						<label class="control-label" for="iambito">Ámbito *</label>
						<select class="form-control" id="iNambito" name="iambito" required>
							<option value="">Seleccione ámbito</option>
							<?php $am = new Ambito() ?>
							<?php $ambito = $am->getAll() ?>
							<?php foreach ($ambito as $a): ?>
								<option value="<?php echo $a->amb_id ?>"<?php if ($ind->amb_id == $a->amb_id): ?> selected<?php endif ?>><?php echo $a->amb_nombre ?></option>
							<?php endforeach ?>
						</select>
					</div>
					<input type="hidden" name="iind" value="<?php echo $id ?>">
					<div class="form-group col-xs-6 has-feedback" id="gsambito">
						<label class="control-label" for="isambito">Sub-ámbito *</label>
						<select class="form-control" id="iNsambito" name="isambito" required>
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
					<div class="form-group col-xs-6 has-feedback" id="gtcode">
						<label class="control-label" for="itcode">Código de característica *</label>
						<select class="form-control" id="iNtcode" name="itcode" required>
							<option value="">Seleccione código</option>
							<?php $cod = new Codigo() ?>
							<?php $codigo = $cod->getBySa($ind->samb_id) ?>
							<?php foreach ($codigo as $c): ?>
								<option value="<?php echo $c->cod_id ?>"<?php if ($ind->cod_id == $c->cod_id): ?> selected<?php endif ?>><?php echo $c->cod_descripcion ?></option>
							<?php endforeach ?>
						</select>
					</div>
					<div class="form-group col-xs-3 has-feedback" id="gnumelem">
						<label class="control-label" for="inumelem">Número de elemento *</label>
						<input type="text" class="form-control" id="iNnumelem" name="inumelem" placeholder="Ingrese número de elemento (1EM, 2EM, etc)" required value="<?php echo $elm->elm_numero ?>">
						<i class="fa form-control-feedback" id="iconnumelem"></i>
					</div>
				</div>

				<?php
				$elm->elm_descripcion = str_replace("<br>", "\n", $elm->elm_descripcion);
				?>

				<div class="row">
					<div class="form-group col-xs-6 has-feedback" id="gdescripcion">
						<label class="control-label" for="idescripcion">Descripción *</label>
						<textarea rows="4" class="form-control" id="iNdescripcion" name="idescripcion" placeholder="Ingrese descripción del indicador" required><?php echo $elm->elm_descripcion ?></textarea>
						<i class="fa form-control-feedback" id="icondescripcion"></i>
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

<script src="medibles/edit-medible.js?v=20190828"></script>