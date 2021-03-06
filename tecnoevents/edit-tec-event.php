<?php include("class/classUser.php") ?>
<?php include("class/classServicio.php") ?>
<?php include("class/classTecnoEvento.php") ?>
<?php $u = new User() ?>
<?php $t = new TecnoEvento() ?>
<?php $us = $u->get($_SESSION['uc_userid']) ?>
<?php $te = $t->get($id) ?>

<section class="content-header">
	<h1>Eventos
		<small><i class="fa fa-angle-right"></i> Ingreso de Nuevo Evento de Tecnovigilancia</small>
	</h1>

	<ol class="breadcrumb">
		<li><a href="index.php?section=home"><i class="fa fa-home"></i> Inicio</a></li>
		<li><a href="index.php?section=tec-event&sbs=viewtecnoevents">Eventos ingresados</a></li>
		<li class="active">Edición de evento</li>
	</ol>
</section>

<section class="content container-fluid">
	<form role="form" id="formNewEvent">
		<p class="bg-class bg-danger">Los campos marcados con (*) son obligatorios</p>

		<div class="box box-default">
			<div class="box-header with-border">
				<h3 class="box-title">Información del evento</h3>
			</div>

			<input type="hidden" id="iid" name="id" value="<?php echo $id ?>">

			<div class="box-body">
				<div class="row">
					<div class="form-group col-sm-3 has-feedback" id="gdate">
						<label class="control-label" for="iNdate">Fecha de notificación</label>
						<div class="input-group">
							<div class="input-group-addon">
								<i class="fa fa-calendar"></i>
							</div>
							<input type="text" class="form-control" id="iNdate" name="idate" data-date-format="dd/mm/yyyy" placeholder="DD/MM/AAAA" value="<?php echo date('d/m/Y') ?>" readonly>
						</div>
						<span class="fa form-control-feedback" id="icondate"></span>
					</div>
				</div>

				<div class="row">
					<div class="form-group col-sm-12 has-feedback" id="gdescription">
						<label class="control-label" for="iNdescription">Descripción del evento *</label>
						<textarea rows="4" class="form-control" id="iNdescription" name="idescription" maxlength="450" required><?php echo $te->tec_descripcion ?></textarea>
						<span class="fa form-control-feedback" id="icondescription"></span>
					</div>
				</div>

				<div class="row">
					<div class="form-group col-sm-6 has-feedback" id="gserv">
						<label class="control-label" for="iNserv">Unidad/Servicio Clínico de ocurrencia *</label>
						<select class="form-control" id="iNserv" name="iserv" required>
							<option value="">Seleccione servicio</option>
							<?php $sv = new Servicio() ?>
							<?php $serv = $sv->getAll() ?>
							<?php foreach ($serv as $s): ?>
								<option value="<?php echo $s->ser_id ?>"<?php if ($s->ser_id == $te->ser_id): ?> selected<?php endif ?>><?php echo $s->ser_nombre ?></option>
							<?php endforeach ?>
						</select>
					</div>

					<div class="form-group col-sm-3 has-feedback" id="gdateev">
						<label class="control-label" for="iNdateev">Fecha de evento *</label>
						<div class="input-group">
							<div class="input-group-addon">
								<i class="fa fa-calendar"></i>
							</div>
							<input type="text" class="form-control" id="iNdateev" name="idateev" data-date-format="dd/mm/yyyy" placeholder="DD/MM/AAAA" required value="<?php echo getDateToForm($te->tec_fecha_ev) ?>">
						</div>
						<span class="fa form-control-feedback" id="icondateev"></span>
					</div>
				</div>

				<div class="row">
					<div class="form-group col-sm-6 has-feedback" id="gdeteccion">
						<label class="control-label" for="iNdeteccion">Detección *</label>
						<select class="form-control" id="iNdeteccion" name="ideteccion" required>
							<option value="">Seleccione momento de detección</option>
							<option value="AN"<?php if ($te->tec_momento == 'AN'): ?> selected<?php endif ?>>ANTES</option>
							<option value="DU"<?php if ($te->tec_momento == 'DU'): ?> selected<?php endif ?>>DURANTE</option>
							<option value="DE"<?php if ($te->tec_momento == 'DE'): ?> selected<?php endif ?>>DESPUÉS</option>
						</select>
					</div>

					<div class="form-group col-sm-6 has-feedback" id="gcat">
						<label class="control-label" for="iNcat">Clasificación *</label>
						<select class="form-control" id="iNcat" name="icat" required>
							<option value="">Seleccione clasificación del evento</option>
							<option value="1"<?php if ($te->cat_id == 1): ?> selected<?php endif ?>>EVENTO CENTINELA</option>
							<option value="2"<?php if ($te->cat_id == 2): ?> selected<?php endif ?>>EVENTO ADVERSO</option>
							<option value="3"<?php if ($te->cat_id == 3): ?> selected<?php endif ?>>OTRO INCIDENTE</option>
						</select>
					</div>
				</div>

				<div class="row">
					<div class="form-group col-sm-6 has-feedback" id="gcausa">
						<label class="control-label" for="iNcausa">Causa del evento</label>
						<input type="text" class="form-control" id="iNcausa" name="icausa" placeholder="Ingrese causa del evento" maxlength="256" value="<?php echo $te->tec_causa ?>">
						<span class="fa form-control-feedback" id="iconcausa"></span>
					</div>

					<div class="form-group col-sm-6 has-feedback" id="gconsec">
						<label class="control-label" for="iNconsec">Consecuencia *</label>
						<input type="text" class="form-control" id="iNconsec" name="iconsec" placeholder="Ingrese consecuencia(s) del evento" maxlength="256" required value="<?php echo $te->tec_consecuencia ?>">
						<span class="fa form-control-feedback" id="iconconsec"></span>
					</div>
				</div>

				<div class="row">
					<div class="col-sm-12">
						<p><strong>¿Autoriza que su identidad sea revelada al Fabricante, representante autorizado, importador o distribuidor? *</strong></p>
					</div>
					<div class="form-group col-sm-6 has-feedback" id="gautorizo">
						<select class="form-control" id="iNautorizo" name="iautorizo" required>
							<option value="1"<?php if ($te->tec_autoriza == 1): ?> selected<?php endif ?>>SI</option>
							<option value="0"<?php if ($te->tec_autoriza == 0): ?> selected<?php endif ?>>NO</option>
						</select>
					</div>
				</div>
			</div>

			<div class="box-header with-border">
				<h3 class="box-title">Información del paciente</h3>
			</div>

			<div class="box-body">
				<div class="row">
					<div class="form-group col-sm-3 has-feedback" id="gpacrut">
						<label class="control-label" for="iNpacrut">RUT paciente *</label>
						<input type="text" class="form-control" id="iNpacrut" name="ipacrut" placeholder="12.345.678-9" maxlength="12" required value="<?php echo $te->tec_pac_rut ?>">
						<span class="fa form-control-feedback" id="iconpacrut"></span>
					</div>

					<div class="form-group col-sm-9 has-feedback" id="gpacnombre">
						<label class="control-label" for="iNpacnombre">Nombre paciente *</label>
						<input type="text" class="form-control" id="iNpacnombre" name="ipacnombre" placeholder="Nombre completo paciente afectado" maxlength="128" required value="<?php echo $te->tec_pac_nombre ?>">
						<span class="fa form-control-feedback" id="iconpacnombre"></span>
					</div>
				</div>

				<div class="row">
					<div class="form-group col-sm-12 has-feedback" id="gdiag">
						<label class="control-label" for="iNdiag">Diagnóstico del paciente</label>
						<textarea rows="4" class="form-control" id="iNdiag" name="idiag" maxlength="450"><?php echo $te->tec_diagnostico ?></textarea>
						<span class="fa form-control-feedback" id="icondiag"></span>
					</div>
				</div>
			</div>

			<div class="box-header with-border">
				<h3 class="box-title">Información del dispositivo médico</h3>
			</div>

			<div class="box-body">
				<div class="row">
					<div class="form-group col-sm-6 has-feedback" id="gngenerico">
						<label class="control-label" for="iNngenerico">Nombre genérico *</label>
						<input type="text" class="form-control" id="iNngenerico" name="ingenerico" placeholder="Ingrese nombre genérico del dispositivo" maxlength="256" required value="<?php echo $te->tec_nombre_gen ?>">
						<span class="fa form-control-feedback" id="iconngenerico"></span>
					</div>

					<div class="form-group col-sm-6 has-feedback" id="gncomercial">
						<label class="control-label" for="iNncomercial">Nombre comercial *</label>
						<input type="text" class="form-control" id="iNncomercial" name="incomercial" placeholder="Ingrese nombre comercial del dispositivo" maxlength="256" required value="<?php echo $te->tec_nombre_com ?>">
						<span class="fa form-control-feedback" id="iconncomercial"></span>
					</div>
				</div>

				<div class="row">
					<div class="form-group col-sm-12 has-feedback" id="guso">
						<label class="control-label" for="iNuso">Uso previsto</label>
						<textarea rows="4" class="form-control" id="iNuso" name="iuso" maxlength="450"><?php echo $te->tec_uso ?></textarea>
						<span class="fa form-control-feedback" id="iconuso"></span>
					</div>
				</div>

				<div class="row">
					<div class="form-group col-sm-4 has-feedback" id="gcriesgo">
						<label class="control-label" for="iNcriesgo">Clase de riesgo</label>
						<input type="text" class="form-control" id="iNcriesgo" name="icriesgo" placeholder="Ingrese clase de riesgo asociado al dispositivo" maxlength="64" value="<?php echo $te->tec_riesgo ?>">
						<span class="fa form-control-feedback" id="iconcriesgo"></span>
					</div>

					<div class="form-group col-sm-4 has-feedback" id="gnlote">
						<label class="control-label" for="iNnlote">Número de lote *</label>
						<input type="text" class="form-control" id="iNnlote" name="inlote" placeholder="Ingrese número de lote del dispositivo" maxlength="16" required value="<?php echo $te->tec_lote ?>">
						<span class="fa form-control-feedback" id="iconnlote"></span>
					</div>

					<div class="form-group col-sm-4 has-feedback" id="gnserie">
						<label class="control-label" for="iNnserie">Número de serie</label>
						<input type="text" class="form-control" id="iNnserie" name="inserie" placeholder="Ingrese número de serie (si aplica)" maxlength="16" value="<?php echo $te->tec_serie ?>">
						<span class="fa form-control-feedback" id="iconnserie"></span>
					</div>
				</div>

				<div class="row">
					<div class="form-group col-sm-3 has-feedback" id="gdatefab">
						<label class="control-label" for="iNdatefab">Fecha de fabricación</label>
						<div class="input-group">
							<div class="input-group-addon">
								<i class="fa fa-calendar"></i>
							</div>
							<input type="text" class="form-control" id="iNdatefab" name="idatefab" data-date-format="dd/mm/yyyy" placeholder="DD/MM/AAAA" value="<?php echo getDateToForm($te->tec_fecha_fab) ?>">
						</div>
						<span class="fa form-control-feedback" id="icondatefab"></span>
					</div>

					<div class="form-group col-sm-3 has-feedback" id="gdatevenc">
						<label class="control-label" for="iNdatevenc">Fecha de vencimiento *</label>
						<div class="input-group">
							<div class="input-group-addon">
								<i class="fa fa-calendar"></i>
							</div>
							<input type="text" class="form-control" id="iNdatevenc" name="idatevenc" data-date-format="dd/mm/yyyy" placeholder="DD/MM/AAAA" required value="<?php echo getDateToForm($te->tec_fecha_ven) ?>">
						</div>
						<span class="fa form-control-feedback" id="icondatevenc"></span>
					</div>
				</div>

				<div class="row">
					<div class="form-group col-sm-4 has-feedback" id="gcondicion">
						<label class="control-label" for="iNcondicion">Condición del dispositivo *</label>
						<select class="form-control" id="iNcondicion" name="icondicion" required>
							<option value="">Seleccione condición</option>
							<option value="P"<?php if ($te->tec_condicion == 'P'): ?> selected<?php endif ?>>PRIMER USO</option>
							<option value="R"<?php if ($te->tec_condicion == 'R'): ?> selected<?php endif ?>>REUTILIZADO</option>
						</select>
					</div>

					<div class="form-group col-sm-4 has-feedback" id="gnregistrosan">
						<label class="control-label" for="iNnregistrosan">Número de registro sanitario</label>
						<input type="text" class="form-control" id="iNnregistrosan" name="inregistrosan" placeholder="Ingrese número de registro sanitario (si aplica)" maxlength="16" value="<?php echo $te->tec_num_registro ?>">
						<span class="fa form-control-feedback" id="iconnregistrosan"></span>
					</div>
				</div>

				<div class="row">
					<div class="form-group col-sm-4 has-feedback" id="gdisponible">
						<label class="control-label" for="iNdisponible">¿Dispositivo médico disponible para evaluación? *</label>
						<select class="form-control" id="iNdisponible" name="idisponible" required>
							<option value="1"<?php if ($te->tec_disponibilidad == 1): ?> selected<?php endif ?>>SI</option>
							<option value="0"<?php if ($te->tec_disponibilidad == 0): ?> selected<?php endif ?>>NO</option>
						</select>
						<p class="help-block">No descarte el dispositivo médico afectado ya que es importante para la investigación</p>
					</div>

					<div class="form-group col-sm-4 has-feedback" id="gmanera">
						<label class="control-label" for="iNmanera">¿De qué manera adquirió el dispositivo?</label>
						<select class="form-control" id="iNmanera" name="imanera" required>
							<option value="">Seleccione origen</option>
							<option value="C"<?php if ($te->tec_adquisicion == 'C'): ?> selected<?php endif ?>>CENABAST</option>
							<option value="A"<?php if ($te->tec_adquisicion == 'A'): ?> selected<?php endif ?>>ABASTECIMIENTO</option>
							<option value="L"<?php if ($te->tec_adquisicion == 'L'): ?> selected<?php endif ?>>LEY RICARTE SOTO</option>
							<option value="O"<?php if ($te->tec_adquisicion == 'O'): ?> selected<?php endif ?>>OTRO</option>
						</select>
					</div>
				</div>
			</div>

			<div class="box-header with-border">
				<h3 class="box-title">Información del fabricante legal</h3>
			</div>

			<div class="box-body">
				<div class="row">
					<div class="form-group col-sm-8 has-feedback" id="gfnombre">
						<label class="control-label" for="iNfnombre">Nombre</label>
						<input type="text" class="form-control" id="iNfnombre" name="ifnombre" placeholder="Ingrese nombre del fabricante legal" maxlength="128" value="<?php echo $te->tec_fnombre ?>">
						<span class="fa form-control-feedback" id="iconfnombre"></span>
					</div>

					<div class="form-group col-sm-4 has-feedback" id="gfpais">
						<label class="control-label" for="iNfpais">País</label>
						<input type="text" class="form-control" id="iNfpais" name="ifpais" placeholder="Ingrese país de fabricación" maxlength="16" value="<?php echo $te->tec_fpais ?>">
						<span class="fa form-control-feedback" id="iconfpais"></span>
					</div>
				</div>

				<div class="row">
					<div class="form-group col-sm-6 has-feedback" id="gfemail">
						<label class="control-label" for="iNfemail">E-mail</label>
						<input type="text" class="form-control" id="iNfemail" name="ifemail" placeholder="Ingrese dirección de e-mail del fabricante" maxlength="128" value="<?php echo $te->tec_femail ?>">
						<span class="fa form-control-feedback" id="iconfemail"></span>
					</div>

					<div class="form-group col-sm-6 has-feedback" id="gftelefono">
						<label class="control-label" for="iNftelefono">Teléfono</label>
						<input type="text" class="form-control" id="iNftelefono" name="iftelefono" placeholder="Ingrese teléfono del fabricante" maxlength="64" value="<?php echo $te->tec_ftelefono ?>">
						<span class="fa form-control-feedback" id="iconftelefono"></span>
					</div>
				</div>
			</div>

			<div class="box-header with-border">
				<h3 class="box-title">Información del representante autorizado</h3>
			</div>

			<div class="box-body">
				<div class="row">
					<div class="form-group col-sm-6 has-feedback" id="grlnombre">
						<label class="control-label" for="iNrlnombre">Nombre</label>
						<input type="text" class="form-control" id="iNrlnombre" name="irlnombre" placeholder="Ingrese nombre del representante autorizado" maxlength="128" value="<?php echo $te->tec_rnombre ?>">
						<span class="fa form-control-feedback" id="iconrlnombre"></span>
					</div>

					<div class="form-group col-sm-6 has-feedback" id="grldireccion">
						<label class="control-label" for="iNrldireccion">Dirección</label>
						<input type="text" class="form-control" id="iNrldireccion" name="irldireccion" placeholder="Ingrese dirección del representante" maxlength="256" value="<?php echo $te->tec_rdireccion ?>">
						<span class="fa form-control-feedback" id="iconrldireccion"></span>
					</div>
				</div>

				<div class="row">
					<div class="form-group col-sm-6 has-feedback" id="grlemail">
						<label class="control-label" for="iNrlemail">E-mail</label>
						<input type="text" class="form-control" id="iNrlemail" name="irlemail" placeholder="Ingrese dirección de e-mail del representante" maxlength="128" value="<?php echo $te->tec_remail ?>">
						<span class="fa form-control-feedback" id="iconrlemail"></span>
					</div>

					<div class="form-group col-sm-6 has-feedback" id="grltelefono">
						<label class="control-label" for="iNrltelefono">Teléfono</label>
						<input type="text" class="form-control" id="iNrltelefono" name="irltelefono" placeholder="Ingrese teléfono del representante" maxlength="64" value="<?php echo $te->tec_rtelefono ?>">
						<span class="fa form-control-feedback" id="iconrltelefono"></span>
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
						<input type="text" class="form-control" id="iNimnombre" name="iimnombre" placeholder="Ingrese nombre del importador" maxlength="128" value="<?php echo $te->tec_imnombre ?>">
						<span class="fa form-control-feedback" id="iconimnombre"></span>
					</div>

					<div class="form-group col-sm-6 has-feedback" id="gimdireccion">
						<label class="control-label" for="iNimdireccion">Dirección</label>
						<input type="text" class="form-control" id="iNimdireccion" name="iimdireccion" placeholder="Ingrese dirección del importador" maxlength="256" value="<?php echo $te->tec_imdireccion ?>">
						<span class="fa form-control-feedback" id="iconimdireccion"></span>
					</div>
				</div>

				<div class="row">
					<div class="form-group col-sm-6 has-feedback" id="gimemail">
						<label class="control-label" for="iNimemail">E-mail</label>
						<input type="text" class="form-control" id="iNimemail" name="iimemail" placeholder="Ingrese dirección de e-mail del importador" maxlength="128" value="<?php echo $te->tec_imemail ?>">
						<span class="fa form-control-feedback" id="iconimemail"></span>
					</div>

					<div class="form-group col-sm-6 has-feedback" id="gimtelefono">
						<label class="control-label" for="iNimtelefono">Teléfono</label>
						<input type="text" class="form-control" id="iNimtelefono" name="iimtelefono" placeholder="Ingrese teléfono del importador" maxlength="64" value="<?php echo $te->tec_imtelefono ?>">
						<span class="fa form-control-feedback" id="iconimtelefono"></span>
					</div>
				</div>
			</div>

			<div class="box-header with-border">
				<h3 class="box-title">Acciones correctivas</h3>
			</div>

			<div class="box-body">
				<div class="row">
					<div class="form-group col-sm-12 has-feedback" id="gcorreccion">
						<label class="control-label" for="iNcorreccion">Acciones correctivas realizadas (si aplican)</label>
						<textarea rows="4" class="form-control" id="iNcorreccion" name="icorreccion" maxlength="450"><?php echo $te->tec_correccion ?></textarea>
						<span class="fa form-control-feedback" id="iconcorreccion"></span>
					</div>
				</div>
			</div>

			<div class="box-footer">
				<button type="submit" class="btn btn-primary" id="btnsubmit"><i class="fa fa-check"></i> Editar</button>
				<button type="reset" class="btn btn-default" id="btnClear">Limpiar</button>
				<i class="ajaxLoader fa fa-cog fa-spin" id="submitLoader"></i>
			</div>
		</div>
	</form>
</section>

<script src="tecnoevents/edit-tec-event.js"></script>