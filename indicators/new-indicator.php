<?php include("class/classPeriodicidad.php") ?>

<section class="content-header">
	<h1>Autoevaluación
		<small><i class="fa fa-angle-right"></i> Ingreso de nuevo Indicador</small>
	</h1>

	<ol class="breadcrumb">
        <li><a href="index.php?section=home"><i class="fa fa-home"></i> Inicio</a></li>
		<li class="active">Ingreso de nuevo indicador</li>
	</ol>
</section>

<section class="content container-fluid">
	<p class="bg-class bg-danger">Los campos marcados con (*) son obligatorios</p>
    
	<div class="box box-default">
		<form role="form" id="formNewIndicator">
			<div class="box-header with-border">
				<h3 class="box-title">Información del elemento medible</h3>
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
								<option value="<?php echo $a->amb_id ?>"><?php echo $a->amb_nombre ?></option>
							<?php endforeach ?>
						</select>
					</div>
					<div class="form-group col-sm-6 has-feedback" id="gsambito">
						<label class="control-label" for="isambito">Sub-ámbito *</label>
						<select class="form-control" id="iNsambito" name="isambito" required>
							<option value="">Seleccione sub-ámbito</option>
						</select>
					</div>
				</div>

				<div class="row">
					<div class="form-group col-sm-6 has-feedback" id="gtcode">
						<label class="control-label" for="itcode">Código de característica *</label>
						<select class="form-control" id="iNtcode" name="itcode" required>
							<option value="">Seleccione código</option>
						</select>
					</div>

					<div class="form-group col-sm-6 has-feedback" id="gem">
						<label class="control-label" for="iem">Elemento medible *</label>
						<select class="form-control" id="iNem" name="iem" required>
							<option value="">Seleccione elemento</option>
						</select>
					</div>
				</div>

				<div class="row">
					<div class="form-group col-sm-6 has-feedback" id="gname">
						<label class="control-label" for="iname">Nombre *</label>
						<input type="text" class="form-control" id="iNname" name="iname" placeholder="Ingrese nombre del indicador" maxlength="250" required>
						<i class="fa form-control-feedback" id="iconname"></i>
					</div>
				</div>

				<div class="row">
					<div class="form-group col-sm-6 has-feedback" id="gdescripcion">
						<label class="control-label" for="idescripcion">Descripción *</label>
						<textarea rows="4" class="form-control" id="iNdescripcion" name="idescripcion" placeholder="Ingrese descripción del indicador" required></textarea>
						<i class="fa form-control-feedback" id="icondescripcion"></i>
					</div>

					<div class="form-group col-sm-6 has-feedback" id="gmetodo">
						<label class="control-label" for="imetodo">Metodología *</label>
						<textarea rows="4" class="form-control" id="iNmetodo" name="imetodo" placeholder="Ingrese la metodología de medición del indicador" required></textarea>
						<i class="fa form-control-feedback" id="iconmetodo"></i>
					</div>
				</div>

				<div class="row">
					<div class="form-group col-sm-6 has-feedback" id="gnum">
						<label class="control-label" for="inum">Descripción numerador *</label>
						<textarea rows="4" class="form-control" id="iNnum" name="inum" placeholder="Ingrese descripción del numerador del indicador" required></textarea>
						<i class="fa form-control-feedback" id="iconnum"></i>
					</div>

					<div class="form-group col-sm-6 has-feedback" id="gden">
						<label class="control-label" for="iden">Descripción denominador *</label>
						<textarea rows="4" class="form-control" id="iNden" name="iden" placeholder="Ingrese descripción del denominador del indicador" required></textarea>
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
								<option value="<?php echo $p->pe_id ?>"><?php echo $p->pe_descripcion ?></option>
							<?php endforeach ?>
						</select>
					</div>

					<div class="form-group col-sm-3 has-feedback" id="gumbral">
						<label class="control-label" for="iumbral">Umbral (%) *</label>
						<input type="text" class="form-control t-right" id="iNumbral" name="iumbral" placeholder="Ingrese umbral de cumplimiento del indicador" maxlength="4" required>
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

<script src="indicators/new-indicator.js?v=20190828"></script>