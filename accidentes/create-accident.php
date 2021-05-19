<?php include("class/classEstamento.php") ?>
<?php include("class/classServicio.php") ?>
<?php $es = new Estamento() ?>
<?php $sv = new Servicio() ?>

<section class="content-header">
	<h1>Accidentes laborales
		<small><i class="fa fa-angle-right"></i> Ingreso de Nuevo Accidente</small>
	</h1>

	<ol class="breadcrumb">
		<li><a href="index.php?section=home"><i class="fa fa-home"></i> Inicio</a></li>
		<li class="active">Ingreso de accidente</li>
	</ol>
</section>

<section class="content container-fluid">
	<form role="form" id="formNewEvent">
		<p class="bg-class bg-danger">Los campos marcados con (*) son obligatorios</p>

		<div class="box box-default">
			<div class="box-header with-border">
				<h3 class="box-title">Información del afectado</h3>
			</div>

			<div class="box-body">
				<div class="row">
					<div class="form-group col-sm-6 has-feedback" id="gname">
						<label class="control-label" for="iNname">Nombre *</label>
						<input type="text" class="form-control" id="iNname" name="iname" placeholder="Ingrese nombre del afectado" maxlength="250" required>
						<span class="fa form-control-feedback" id="iconname"></span>
					</div>
				</div>

				<div class="row">
					<div class="form-group col-sm-6 has-feedback" id="gap">
						<label class="control-label" for="iNap">Apellido paterno *</label>
						<input type="text" class="form-control" id="iNap" name="iap" placeholder="Ingrese apellido paterno del afectado" maxlength="128" required>
						<span class="fa form-control-feedback" id="iconap"></span>
					</div>

					<div class="form-group col-sm-6 has-feedback" id="gam">
						<label class="control-label" for="iNam">Apellido materno *</label>
						<input type="text" class="form-control" id="iNam" name="iam" placeholder="Ingrese aopellido materno del afectado" maxlength="128" required>
						<span class="fa form-control-feedback" id="iconam"></span>
					</div>
				</div>

				<div class="row">
					<div class="form-group col-sm-6 has-feedback" id="gestamento">
						<label class="control-label" for="iNestamento">Estamento *</label>
						<select class="form-control" id="iNestamento" name="iestamento" required>
							<option value="">Seleccione estamento</option>
							<?php $est = $es->getAll() ?>
							<?php foreach ($est as $e): ?>
								<option value="<?php echo $e->esta_id ?>"><?php echo $e->esta_descripcion ?></option>
							<?php endforeach ?>
						</select>
					</div>

					<div class="form-group col-sm-3 has-feedback" id="gvacuna">
						<label class="control-label" for="iNvacuna">Vacuna Hepatitis B</label>
						<select class="form-control" id="iNvacuna" name="ivacuna">
							<option value="1">SI</option>
							<option value="0">NO</option>
							<option value="">N/D</option>
						</select>
					</div>
				</div>
			</div>

			<div class="box-header with-border">
				<h3 class="box-title">Información del evento</h3>
			</div>

			<div class="box-body">
				<div class="row">
					<div class="form-group col-sm-3 has-feedback" id="gdate">
						<label class="control-label" for="iNdate">Fecha de reporte *</label>
						<div class="input-group">
							<div class="input-group-addon">
								<i class="fa fa-calendar"></i>
							</div>
							<input type="text" class="form-control" id="iNdate" name="idate" data-date-format="dd/mm/yyyy" placeholder="DD/MM/AAAA" required>
						</div>
						<span class="fa form-control-feedback" id="icondate"></span>
					</div>
				</div>

				<div class="row">
					<div class="form-group col-sm-3 has-feedback" id="gdateacc">
						<label class="control-label" for="iNdateacc">Fecha de accidente *</label>
						<div class="input-group">
							<div class="input-group-addon">
								<i class="fa fa-calendar"></i>
							</div>
							<input type="text" class="form-control" id="iNdateacc" name="idateacc" data-date-format="dd/mm/yyyy" placeholder="DD/MM/AAAA" required>
						</div>
						<span class="fa form-control-feedback" id="icondateacc"></span>
					</div>

					<div class="form-group col-sm-3" id="ghour">
						<label class="control-label" for="iNhour">Hora *</label>
						<select class="form-control" id="iNhour" name="ihour" required>
							<?php for ($i = 0; $i < 24; $i++): ?>
								<option value="<?php echo ($i < 10) ? '0' . $i : $i ?>"><?php echo ($i < 10) ? '0' . $i : $i ?></option>
							<?php endfor ?>
						</select>
					</div>

					<div class="form-group col-sm-3" id="gmin">
						<label class="control-label" for="iNmin">Minuto *</label>
						<select class="form-control" id="iNmin" name="imin" required>
							<?php for ($i = 0; $i < 60; $i++): ?>
								<option value="<?php echo ($i < 10) ? '0' . $i : $i ?>"><?php echo ($i < 10) ? '0' . $i : $i ?></option>
							<?php endfor ?>
						</select>
					</div>
				</div>

				<div class="row">
					<div class="form-group col-sm-6 has-feedback" id="gserv">
						<label class="control-label" for="iNserv">Servicio Clínico *</label>
						<select class="form-control" id="iNserv" name="iserv" required>
							<option value="">Seleccione servicio</option>
							<?php $serv = $sv->getAll() ?>
							<?php foreach ($serv as $s): ?>
								<option value="<?php echo $s->ser_id ?>"><?php echo $s->ser_nombre ?></option>
							<?php endforeach ?>
						</select>
					</div>

					<div class="form-group col-sm-6 has-feedback" id="glugar">
						<label class="control-label" for="iNlugar">Lugar de ocurrencia *</label>
						<input type="text" class="form-control" id="iNlugar" name="ilugar" placeholder="Ingrese lugar de ocurrencia del accidente" maxlength="256" required>
						<span class="fa form-control-feedback" id="iconlugar"></span>
					</div>
				</div>

				<div class="row">
					<div class="form-group col-sm-12 has-feedback" id="gdescrip">
						<label class="control-label" for="iNdescrip">Descripción del accidente *</label>
						<textarea class="form-control" rows="3" id="iNdescrip" name="idescrip" placeholder="Ingrese descripción del accidente" required></textarea>
						<span class="fa form-control-feedback" id="icondescrip"></span>
					</div>
				</div>

				<div class="row">
					<div class="form-group col-sm-3 has-feedback" id="gfuente">
						<label class="control-label" for="iNfuente">Identificación fuente</label>
						<select class="form-control" id="iNfuente" name="ifuente">
							<option value="1">SI</option>
							<option value="0">NO</option>
							<option value="">N/D</option>
						</select>
					</div>

					<div class="form-group col-sm-3 has-feedback" id="gaviso">
						<label class="control-label" for="iNaviso">Aviso jefatura</label>
						<select class="form-control" id="iNaviso" name="iaviso">
							<option value="1">SI</option>
							<option value="0">NO</option>
							<option value="">N/D</option>
						</select>
					</div>

					<div class="form-group col-sm-3 has-feedback" id="gdiat">
						<label class="control-label" for="iNdiat">DIAT en ASySO</label>
						<select class="form-control" id="iNdiat" name="idiat">
							<option value="1">SI</option>
							<option value="0">NO</option>
							<option value="">N/D</option>
						</select>
					</div>
				</div>

				<div class="row">
					<div class="form-group col-sm-3 has-feedback" id="gmedper">
						<label class="control-label" for="iNmedper">Seguimiento en Medicina Personal</label>
						<select class="form-control" id="iNmedper" name="imedper">
							<option value="1">SI</option>
							<option value="0">NO</option>
							<option value="">N/A</option>
						</select>
					</div>

					<div class="form-group col-sm-3 has-feedback" id="gproto">
						<label class="control-label" for="iNproto">Cumplimiento Protocolo</label>
						<select class="form-control" id="iNproto" name="iproto">
							<option value="1">SI</option>
							<option value="0">NO</option>
							<option value="">N/D</option>
						</select>
					</div>
				</div>
			</div>

			<div class="box-header with-border">
				<h3 class="box-title">Información de Urgencias</h3>
			</div>

			<div class="box-body">
				<div class="row">
					<div class="form-group col-sm-3 has-feedback" id="gurg">
						<label class="control-label" for="iNurg">Atención en Urgencias</label>
						<select class="form-control" id="iNurg" name="iurg">
							<option value="1">SI</option>
							<option value="0">NO</option>
							<option value="">N/D</option>
						</select>
					</div>

					<div class="form-group col-sm-3 has-feedback" id="gserol">
						<label class="control-label" for="iNserol">Serología de la fuente</label>
						<select class="form-control" id="iNserol" name="iserol">
							<option value="1">SI</option>
							<option value="0">NO</option>
							<option value="">N/A</option>
						</select>
					</div>

					<div class="form-group col-sm-3 has-feedback" id="gtrat">
						<label class="control-label" for="iNtrat">Médico indica tratamiento según serología</label>
						<select class="form-control" id="iNtrat" name="itrat">
							<option value="1">SI</option>
							<option value="0">NO</option>
							<option value="">N/A</option>
						</select>
					</div>
				</div>

				<div class="row">
					<div class="form-group col-sm-6 has-feedback" id="gmedico">
						<label class="control-label" for="iNmedico">Médico de turno en Urgencias</label>
						<input type="text" class="form-control" id="iNmedico" name="imedico" placeholder="Ingrese nombre del médico de turno" maxlength="256">
						<span class="fa form-control-feedback" id="iconmedico"></span>
					</div>

					<div class="form-group col-sm-3 has-feedback" id="gtiempo">
						<label class="control-label" for="iNtiempo">Tiempo de espera en Urgencias</label>
						<input type="text" class="form-control" id="iNtiempo" name="itiempo" placeholder="Ingrese tiempo de espera" maxlength="32">
						<span class="fa form-control-feedback" id="icontiempo"></span>
					</div>

					<div class="form-group col-sm-3 has-feedback" id="gficha">
						<label class="control-label" for="iNficha">Número de ficha clínica</label>
						<input type="text" class="form-control" id="iNficha" name="ificha" placeholder="Ingrese número de ficha clínica" maxlength="32">
						<span class="fa form-control-feedback" id="iconficha"></span>
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

<script src="accidentes/create-accident.js"></script>