<?php include("class/classPeriodicidad.php") ?>

<section class="content-header">
	<h1>Autoevaluación
		<small><i class="fa fa-angle-right"></i> Ingreso de adicional para característica</small>
	</h1>

	<ol class="breadcrumb">
        <li><a href="index.php?section=home"><i class="fa fa-home"></i> Inicio</a></li>
		<li class="active">Ingreso de adicional para característica</li>
	</ol>
</section>

<section class="content container-fluid">
    <div class="box box-default">
		<ul class="nav nav-tabs">
			<li role="presentation" class="active"><a href="#em" aria-controls="em" role="tab" data-toggle="tab">Elemento Medible</a></li>
			<li role="presentation"><a href="#acl" aria-controls="acl" role="tab" data-toggle="tab">Aclaratoria</a></li>
		</ul>

		<div class="tab-content">
			<div role="tabpanel" class="tab-pane fade in active" id="em">
				<form role="form" id="formNewMedible">
					<div class="box-header with-border">
						<h3 class="box-title">Nuevo elemento medible</h3>
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

							<div class="form-group col-sm-3 has-feedback" id="gnumelem">
								<label class="control-label" for="inumelem">Número de elemento *</label>
								<input type="text" class="form-control" id="iNnumelem" name="inumelem" placeholder="Ingrese número de elemento (1EM, 2EM, etc)" required>
								<i class="fa form-control-feedback" id="iconnumelem"></i>
							</div>
						</div>

						<div class="row">
							<div class="form-group col-sm-6 has-feedback" id="gdescripcion">
								<label class="control-label" for="idescripcion">Descripción *</label>
								<textarea rows="4" class="form-control" id="iNdescripcion" name="idescripcion" placeholder="Ingrese descripción del indicador" required></textarea>
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
		
			<div role="tabpanel" class="tab-pane fade" id="acl">
				<form role="form" id="formNewAclaratoria">
					<div class="box-header with-border">
						<h3 class="box-title">Nueva aclaratoria</h3>
					</div>

					<div class="box-body">
						<div class="row">
							<div class="form-group col-sm-3 has-feedback" id="gdate">
								<label class="control-label" for="idate">Fecha de resolución *</label>
								<div class="input-group">
									<div class="input-group-addon">
										<i class="fa fa-calendar"></i>
									</div>
									<input type="text" class="form-control" id="iNdate" name="idate" data-date-format="dd/mm/yyyy" placeholder="DD/MM/AAAA" value="24/11/2017" required>
								</div>
								<i class="fa form-control-feedback" id="icondate"></i>
							</div>

							<div class="form-group col-sm-3 has-feedback" id="gnumres">
								<label class="control-label" for="inumres">Número de Resolución *</label>
								<input type="text" class="form-control" id="iNnumres" name="inumres" placeholder="Ingrese número de resolución" value="REX. IP/N°1860" required>
								<i class="fa form-control-feedback" id="iconnumres"></i>
							</div>
						</div>

						<div class="row">
							<div class="form-group col-sm-6 has-feedback" id="gambitor">
								<label class="control-label" for="iambitor">Ámbito *</label>
								<select class="form-control" id="iNambitor" name="iambitor" required>
									<option value="">Seleccione ámbito</option>
									<?php $am = new Ambito() ?>
									<?php $ambito = $am->getAll() ?>
									<?php foreach ($ambito as $a): ?>
										<option value="<?php echo $a->amb_id ?>"><?php echo $a->amb_nombre ?></option>
									<?php endforeach ?>
								</select>
							</div>

							<div class="form-group col-sm-6 has-feedback" id="gsambitor">
								<label class="control-label" for="isambitor">Sub-ámbito *</label>
								<select class="form-control" id="iNsambitor" name="isambitor" required>
									<option value="">Seleccione sub-ámbito</option>
								</select>
							</div>
						</div>

						<div class="row">
							<div class="form-group col-sm-6 has-feedback" id="gtcoder">
								<label class="control-label" for="itcoder">Código de característica *</label>
								<select class="form-control" id="iNtcoder" name="itcoder" required>
									<option value="">Seleccione código</option>
								</select>
							</div>

							<div class="form-group col-sm-3 has-feedback" id="gnumero">
								<label class="control-label" for="inumero">Número de Aclaratoria *</label>
								<input type="text" class="form-control" id="iNnumero" name="inumero" placeholder="Ingrese número de aclaratoria" maxlength="4" required>
								<i class="fa form-control-feedback" id="iconnumero"></i>
							</div>
						</div>

						<div class="row">
							<div class="form-group col-sm-6 has-feedback" id="gresumen">
								<label class="control-label" for="iname">Resumen *</label>
								<input type="text" class="form-control" id="iNresumen" name="iresumen" placeholder="Ingrese resumen de la aclaratoria" maxlength="1024" required>
								<i class="fa form-control-feedback" id="iconresumen"></i>
							</div>

							<div class="form-group col-sm-6 has-feedback" id="gdescripcionr">
								<label class="control-label" for="idescripcionr">Descripción *</label>
								<textarea rows="4" class="form-control" id="iNdescripcionr" name="idescripcionr" placeholder="Ingrese descripción de la aclaratoria" required></textarea>
								<i class="fa form-control-feedback" id="icondescripcionr"></i>
							</div>
						</div>
					</div>

					<div class="box-footer">
						<button type="submit" class="btn btn-primary" id="btnsubmit"><i class="fa fa-check"></i> Guardar</button>
						<button type="reset" class="btn btn-default" id="btnClearR">Limpiar</button>
						<i class="ajaxLoader fa fa-cog fa-spin" id="submitLoader2"></i>
					</div>
				</form>
			</div>
		</div>
	</div>
</section>

<script src="medibles/new-medible.js?v=20190828"></script>