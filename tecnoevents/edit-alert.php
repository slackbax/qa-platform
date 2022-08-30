<?php include("class/classAlerta.php") ?>
<?php $a = new Alerta() ?>
<?php $al = $a->get($id) ?>

<section class="content-header">
	<h1>Eventos
		<small><i class="fa fa-angle-right"></i> Edición de Alerta</small>
	</h1>

	<ol class="breadcrumb">
		<li><a href="index.php?section=home"><i class="fa fa-home"></i> Inicio</a></li>
		<li class="active">Edición de alerta</li>
	</ol>
</section>

<section class="content container-fluid">
	<form role="form" id="formEditAlert">
		<p class="bg-class bg-danger">Los campos marcados con (*) son obligatorios</p>

		<div class="box box-default">
			<div class="box-header with-border">
				<h3 class="box-title">Información de la alerta</h3>
			</div>

			<input type="hidden" id="iid" name="id" value="<?php echo $id ?>">

			<div class="box-body">
				<div class="row">
					<div class="form-group col-sm-3 has-feedback" id="gdate">
						<label class="control-label" for="iNdate">Fecha de alerta</label>
						<div class="input-group">
							<div class="input-group-addon">
								<i class="fa fa-calendar"></i>
							</div>
							<?php $date = explode(' ', $al->eal_registro)[0] ?>
							<input type="text" class="form-control" id="iNdate" name="idate" data-date-format="dd/mm/yyyy" placeholder="DD/MM/AAAA" value="<?php echo getDateToForm($date) ?>" readonly>
						</div>
						<span class="fa form-control-feedback" id="icondate"></span>
					</div>

					<div class="form-group col-sm-3 has-feedback" id="gdateal">
						<label class="control-label" for="iNdateal">Fecha de recepción alerta *</label>
						<div class="input-group">
							<div class="input-group-addon">
								<i class="fa fa-calendar"></i>
							</div>
							<input type="text" class="form-control" id="iNdateal" name="idateal" data-date-format="dd/mm/yyyy" placeholder="DD/MM/AAAA" value="<?php echo getDateToForm($al->eal_fecha) ?>" required>
						</div>
						<span class="fa form-control-feedback" id="icondateal"></span>
					</div>
				</div>
			</div>

			<div class="box-header with-border">
				<h3 class="box-title">Información del dispositivo médico</h3>
			</div>

			<div class="box-body">
				<div class="row">
					<div class="form-group col-sm-6 has-feedback" id="gnmarca">
						<label class="control-label" for="iNnmarca">Marca / modelo dispositivo *</label>
						<input type="text" class="form-control" id="iNnmarca" name="inmarca" placeholder="Ingrese marca / modelo del dispositivo" value="<?php echo $al->eal_marca ?>" maxlength="256" required>
						<span class="fa form-control-feedback" id="iconnmarca"></span>
					</div>
				</div>

				<div class="row">
					<div class="form-group col-sm-4 has-feedback" id="gcriesgo">
						<label class="control-label" for="iNcriesgo">Clase de riesgo *</label>
						<input type="text" class="form-control" id="iNcriesgo" name="icriesgo" placeholder="Ingrese clase de riesgo asociado al dispositivo" value="<?php echo $al->eal_riesgo ?>" maxlength="64" required>
						<span class="fa form-control-feedback" id="iconcriesgo"></span>
					</div>

					<div class="form-group col-sm-4 has-feedback" id="gntalerta">
						<label class="control-label" for="iNntalerta">Tipo de alerta *</label>
						<input type="text" class="form-control" id="iNntalerta" name="intalerta" placeholder="Ingrese tipo de alerta asociada al dispositivo" value="<?php echo $al->eal_tipoalerta ?>" maxlength="64" required>
						<span class="fa form-control-feedback" id="iconntalerta"></span>
					</div>
				</div>

				<div class="row">
					<div class="form-group col-sm-4 has-feedback" id="gnlote">
						<label class="control-label" for="iNnlote">Número de lote *</label>
						<input type="text" class="form-control" id="iNnlote" name="inlote" placeholder="Ingrese número de lote del dispositivo" value="<?php echo $al->eal_lote ?>" maxlength="32" required>
						<span class="fa form-control-feedback" id="iconnlote"></span>
					</div>

					<div class="form-group col-sm-4 has-feedback" id="gnserie">
						<label class="control-label" for="iNnserie">Número de serie *</label>
						<input type="text" class="form-control" id="iNnserie" name="inserie" placeholder="Ingrese número de serie del dispositivo" maxlength="32" value="<?php echo $al->eal_serie ?>" required>
						<span class="fa form-control-feedback" id="iconnserie"></span>
					</div>
				</div>
			</div>

			<div class="box-header with-border">
				<h3 class="box-title">Información del fabricante legal</h3>
			</div>

			<div class="box-body">
				<div class="row">
					<div class="form-group col-sm-6 has-feedback" id="gfnombre">
						<label class="control-label" for="iNfnombre">Nombre</label>
						<input type="text" class="form-control" id="iNfnombre" name="ifnombre" placeholder="Ingrese nombre del fabricante legal" value="<?php echo $al->eal_fnombre ?>" maxlength="128">
						<span class="fa form-control-feedback" id="iconfnombre"></span>
					</div>
				</div>

				<div class="row">
					<div class="form-group col-sm-6 has-feedback" id="gfemail">
						<label class="control-label" for="iNfemail">E-mail</label>
						<input type="text" class="form-control" id="iNfemail" name="ifemail" placeholder="Ingrese dirección de e-mail del fabricante" value="<?php echo $al->eal_femail ?>" maxlength="128">
						<span class="fa form-control-feedback" id="iconfemail"></span>
					</div>

					<div class="form-group col-sm-6 has-feedback" id="gftelefono">
						<label class="control-label" for="iNftelefono">Teléfono</label>
						<input type="text" class="form-control" id="iNftelefono" name="iftelefono" placeholder="Ingrese teléfono del fabricante" value="<?php echo $al->eal_ftelefono ?>" maxlength="64">
						<span class="fa form-control-feedback" id="iconftelefono"></span>
					</div>
				</div>
			</div>

			<div class="box-header with-border">
				<h3 class="box-title">Información del importador</h3>
			</div>

			<div class="box-body">
				<div class="row">
					<div class="form-group col-sm-6 has-feedback" id="gimnombre">
						<label class="control-label" for="iNimnombre">Nombre</label>
						<input type="text" class="form-control" id="iNimnombre" name="iimnombre" placeholder="Ingrese nombre del importador" value="<?php echo $al->eal_inombre ?>" maxlength="128">
						<span class="fa form-control-feedback" id="iconimnombre"></span>
					</div>
				</div>

				<div class="row">
					<div class="form-group col-sm-6 has-feedback" id="gimemail">
						<label class="control-label" for="iNimemail">E-mail</label>
						<input type="text" class="form-control" id="iNimemail" name="iimemail" placeholder="Ingrese dirección de e-mail del importador" value="<?php echo $al->eal_iemail ?>" maxlength="128">
						<span class="fa form-control-feedback" id="iconimemail"></span>
					</div>

					<div class="form-group col-sm-6 has-feedback" id="gimtelefono">
						<label class="control-label" for="iNimtelefono">Teléfono</label>
						<input type="text" class="form-control" id="iNimtelefono" name="iimtelefono" placeholder="Ingrese teléfono del importador" value="<?php echo $al->eal_itelefono ?>" maxlength="64">
						<span class="fa form-control-feedback" id="iconimtelefono"></span>
					</div>
				</div>
			</div>

			<div class="box-header with-border">
				<h3 class="box-title">Plan de trabajo</h3>
			</div>

			<div class="box-body">
				<div class="row">
					<div class="form-group col-sm-12 has-feedback" id="gcorreccion">
						<label class="control-label" for="iNcorreccion">Recomendaciones / Plan de trabajo *</label>
						<textarea rows="4" class="form-control" id="iNcorreccion" name="icorreccion" maxlength="450" required><?php echo $al->eal_plan ?></textarea>
						<span class="fa form-control-feedback" id="iconcorreccion"></span>
					</div>
				</div>
			</div>

			<div class="box-footer">
				<button type="submit" class="btn btn-primary" id="btnsubmit"><i class="fa fa-check"></i> Guardar</button>
				<button type="reset" class="btn btn-default" id="btnClear">Limpiar</button>
				<i class="ajaxLoader fa fa-cog fa-spin" id="submitLoader"></i>
			</div>
		</div>
	</form>
</section>

<script src="tecnoevents/edit-alert.js"></script>
