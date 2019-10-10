<?php include("class/classIndicadorEsp.php") ?>
<?php include("class/classSubAmbito.php") ?>
<?php include("class/classCodigo.php") ?>
<?php include("class/classElementoMed.php") ?>
<?php include("class/classPeriodicidad.php") ?>
<?php $ie = new IndicadorEsp() ?>
<?php $ine = $ie->get($id) ?>

<section class="content-header">
	<h1>Autoevaluación
		<small><i class="fa fa-angle-right"></i> Edición de Indicador</small>
	</h1>

	<ol class="breadcrumb">
		<li><a href="index.php?section=home"><i class="fa fa-home"></i> Inicio</a></li>
		<li><a href="index.php?section=autoeval&sbs=manageindicators">Indicadores de autoevaluación ingresados</a></li>
		<li class="active">Edición de indicador</li>
	</ol>
</section>

<section class="content container-fluid">
	<p class="bg-class bg-danger">Los campos marcados con (*) son obligatorios</p>
    
	<div class="box box-default">
		<form role="form" id="formEditIndicator">
			<div class="box-header with-border">
				<h3 class="box-title">Información del indicador</h3>
			</div>

			<div class="box-body">
				<div class="row">
					<div class="form-group col-sm-6 has-feedback" id="gambito">
						<label class="control-label" for="iambito">Ámbito *</label>
						<select class="form-control" id="iNambito" name="iambito" required>
							<option value="">Seleccione ámbito</option>
							<?php $am = new Ambito() ?>
							<?php $ambito = $am->getAll() ?>
							<?php foreach ($ambito as $a): ?>
								<option value="<?php echo $a->amb_id ?>"<?php if ($ine->amb_id == $a->amb_id): ?> selected<?php endif ?>><?php echo $a->amb_nombre ?></option>
							<?php endforeach ?>
						</select>
					</div>
					<input type="hidden" name="iind" value="<?php echo $id ?>">
					<div class="form-group col-sm-6 has-feedback" id="gsambito">
						<label class="control-label" for="isambito">Sub-ámbito *</label>
						<select class="form-control" id="iNsambito" name="isambito" required>
							<option value="">Seleccione sub-ámbito</option>
							<?php $sam = new SubAmbito() ?>
							<?php $sambito = $sam->getByAmbito($ine->amb_id) ?>
							<?php foreach ($sambito as $sa): ?>
								<option value="<?php echo $sa->samb_id ?>"<?php if ($ine->samb_id == $sa->samb_id): ?> selected<?php endif ?>><?php echo $sa->samb_sigla . ' - ' . $sa->samb_nombre ?></option>
							<?php endforeach ?>
						</select>
					</div>
				</div>

				<div class="row">
					<div class="form-group col-sm-6 has-feedback" id="gtcode">
						<label class="control-label" for="itcode">Código de característica *</label>
						<select class="form-control" id="iNtcode" name="itcode" required>
							<option value="">Seleccione código</option>
							<?php $cod = new Codigo() ?>
							<?php $codigo = $cod->getBySa($ine->samb_id) ?>
							<?php foreach ($codigo as $c): ?>
								<option value="<?php echo $c->cod_id ?>"<?php if ($ine->cod_id == $c->cod_id): ?> selected<?php endif ?>><?php echo $c->cod_descripcion ?></option>
							<?php endforeach ?>
						</select>
					</div>

					<div class="form-group col-sm-6 has-feedback" id="gem">
						<label class="control-label" for="iem">Elemento medible *</label>
						<select class="form-control" id="iNem" name="iem" required>
							<option value="">Seleccione elemento</option>
							<?php $elm = new ElementoMed() ?>
							<?php $el = $elm->getByInd($ine->samb_id, $ine->cod_id) ?>
							<?php foreach ($el as $e): ?>
								<option value="<?php echo $e->elm_id ?>"<?php if ($ine->elem_id == $e->elm_id): ?> selected<?php endif ?>><?php echo $e->elm_numero . ': ' . $e->elm_descripcion ?></option>
							<?php endforeach ?>
						</select>
					</div>
				</div>

				<div class="row">
					<div class="form-group col-sm-6 has-feedback" id="gname">
						<label class="control-label" for="iname">Nombre *</label>
						<input type="text" class="form-control" id="iNname" name="iname" placeholder="Ingrese nombre del indicador" maxlength="250" value="<?php echo $ine->ine_nombre ?>" required>
						<i class="fa form-control-feedback" id="iconname"></i>
					</div>
				</div>

				<?php
				$ine->ine_descripcion = str_replace("<br>", "\n", $ine->ine_descripcion);
				$ine->ine_metodologia = str_replace("<br>", "\n", $ine->ine_metodologia);
				$ine->ine_num_desc = str_replace("<br>", "\n", $ine->ine_num_desc);
				$ine->ine_den_desc = str_replace("<br>", "\n", $ine->ine_den_desc);
				?>

				<div class="row">
					<div class="form-group col-sm-6 has-feedback" id="gdescripcion">
						<label class="control-label" for="idescripcion">Descripción *</label>
						<textarea rows="4" class="form-control" id="iNdescripcion" name="idescripcion" placeholder="Ingrese descripción del indicador" required><?php echo $ine->ine_descripcion ?></textarea>
						<i class="fa form-control-feedback" id="icondescripcion"></i>
					</div>

					<div class="form-group col-sm-6 has-feedback" id="gmetodo">
						<label class="control-label" for="imetodo">Metodología *</label>
						<textarea rows="4" class="form-control" id="iNmetodo" name="imetodo" placeholder="Ingrese la metodología de medición del indicador" required><?php echo $ine->ine_metodologia ?></textarea>
						<i class="fa form-control-feedback" id="iconmetodo"></i>
					</div>
				</div>

				<div class="row">
					<div class="form-group col-sm-6 has-feedback" id="gnum">
						<label class="control-label" for="inum">Descripción numerador *</label>
						<textarea rows="4" class="form-control" id="iNnum" name="inum" placeholder="Ingrese descripción del numerador del indicador" required><?php echo $ine->ine_num_desc ?></textarea>
						<i class="fa form-control-feedback" id="iconnum"></i>
					</div>

					<div class="form-group col-sm-6 has-feedback" id="gden">
						<label class="control-label" for="iden">Descripción denominador *</label>
						<textarea rows="4" class="form-control" id="iNden" name="iden" placeholder="Ingrese descripción del denominador del indicador" required><?php echo $ine->ine_den_desc ?></textarea>
						<i class="fa form-control-feedback" id="iconden"></i>
					</div>
				</div>

				<div class="row">
					<div class="form-group col-sm-3 has-feedback" id="gperiodo">
						<label class="control-label" for="iperiodo">Periodicidad *</label>
						<select class="form-control" id="iNperiodo" name="iperiodo" required>
							<option value="">Seleccione periodicidad</option>
							<?php $pe = new Periodicidad() ?>
							<?php $p = $pe->getAll() ?>
							<?php foreach ($p as $p): ?>
								<option value="<?php echo $p->pe_id ?>"<?php if ($ine->ine_peid == $p->pe_id): ?> selected<?php endif ?>><?php echo $p->pe_descripcion ?></option>
							<?php endforeach ?>
						</select>
					</div>

					<div class="form-group col-sm-3 has-feedback" id="gumbral">
						<label class="control-label" for="iumbral">Umbral (%) *</label>
						<input type="text" class="form-control t-right" id="iNumbral" name="iumbral" placeholder="Ingrese umbral de cumplimiento del indicador" maxlength="4" value="<?php echo $ine->ine_umbral ?>" required>
						<i class="fa form-control-feedback" id="iconumbral"></i>
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

<script src="indicators/edit-indicator.js?v=20190828"></script>