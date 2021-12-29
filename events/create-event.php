<?php include("class/classServicio.php") ?>
<?php include("class/classTipoPaciente.php") ?>
<?php include("class/classTipoEvento.php") ?>
<?php include("class/classRiesgo.php") ?>
<?php include("class/classConsecuencia.php") ?>
<?php include("class/classTipoVerificacion.php") ?>

<section class="content-header">
	<h1>Eventos
		<small><i class="fa fa-angle-right"></i> Ingreso de Nuevo Evento</small>
	</h1>

	<ol class="breadcrumb">
		<li><a href="index.php?section=home"><i class="fa fa-home"></i> Inicio</a></li>
		<li class="active">Ingreso de evento</li>
	</ol>
</section>

<section class="content container-fluid">
	<form role="form" id="formNewEvent">
		<p class="bg-class bg-danger">Los campos marcados con (*) son obligatorios</p>

		<div class="box box-default">
			<div class="box-header with-border">
				<h3 class="box-title">Información del paciente</h3>
			</div>

			<div class="box-body">
				<div class="row">
					<div class="form-group col-sm-6">
						<label class="label-checkbox">
							<input type="checkbox" class="minimal" name="ibrote" id="iNbrote"> Evento correspondiente a brote epidemiológico o afecta a más de un paciente
						</label>
					</div>
				</div>

				<div class="row">
					<div class="form-group col-sm-3 has-feedback" id="grut">
						<label class="control-label" for="iNrut">RUT *</label>
						<input type="text" class="form-control" id="iNrut" name="irut" placeholder="12345678-9" maxlength="12" required>
						<span class="fa form-control-feedback" id="iconrut"></span>
					</div>
				</div>

				<div class="row">
					<div class="form-group col-sm-6 has-feedback" id="gname">
						<label class="control-label" for="iNname">Nombre *</label>
						<input type="text" class="form-control" id="iNname" name="iname" placeholder="Ingrese nombre del paciente" maxlength="250" required>
						<span class="fa form-control-feedback" id="iconname"></span>
					</div>

					<div class="form-group col-sm-6 has-feedback" id="gtpac">
						<label class="control-label" for="iNtpac">Tipo de Paciente *</label>
						<select class="form-control" id="iNtpac" name="itpac" required>
							<option value="">Seleccione tipo</option>
							<?php $tp = new TipoPaciente() ?>
							<?php $tpac = $tp->getAll() ?>
							<?php foreach ($tpac as $p): ?>
								<option value="<?php echo $p->tpac_id ?>"><?php echo $p->tpac_descripcion ?></option>
							<?php endforeach ?>
						</select>
					</div>
				</div>

				<div class="row">
					<div class="form-group col-sm-3 has-feedback" id="gedad">
						<label class="control-label" for="iNedad">Edad *</label>
						<input type="text" class="form-control" id="iNedad" name="iedad" placeholder="Ingrese la edad del paciente" maxlength="3" required>
						<span class="fa form-control-feedback" id="iconedad"></span>
					</div>

					<div class="form-group col-sm-6 col-sm-offset-3 has-feedback" id="gserv">
						<label class="control-label" for="iNserv">Servicio Clínico de ocurrencia *</label>
						<select class="form-control" id="iNserv" name="iserv" required>
							<option value="">Seleccione servicio</option>
							<?php $sv = new Servicio() ?>
							<?php $serv = $sv->getAll() ?>
							<?php foreach ($serv as $s): ?>
								<option value="<?php echo $s->ser_id ?>"><?php echo $s->ser_nombre ?></option>
							<?php endforeach ?>
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
						<label class="control-label" for="iNdate">Fecha de evento *</label>
						<div class="input-group">
							<div class="input-group-addon">
								<i class="fa fa-calendar"></i>
							</div>
							<input type="text" class="form-control" id="iNdate" name="idate" data-date-format="dd/mm/yyyy" placeholder="DD/MM/AAAA" required>
						</div>
						<span class="fa form-control-feedback" id="icondate"></span>
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
					<div class="form-group col-sm-6 has-feedback" id="gtev">
						<label class="control-label" for="iNtev">Tipo de Evento *</label>
						<select class="form-control" id="iNtev" name="itev" required>
							<option value="">Seleccione tipo</option>
							<?php $te = new TipoEvento() ?>
							<?php $tev = $te->getAll() ?>
							<?php foreach ($tev as $t): ?>
								<option value="<?php echo $t->tev_id ?>"><?php echo $t->tev_descripcion ?></option>
							<?php endforeach ?>
						</select>
					</div>

					<div class="form-group col-sm-6 has-feedback" id="gstev">
						<label class="control-label" for="iNstev">Evento Específico *</label>
						<select class="form-control" id="iNstev" name="istev" required>
							<option value="">Seleccione evento</option>
						</select>
					</div>
				</div>

				<div class="row">
					<div class="form-group col-sm-6">
						<label class="control-label">Categoría de evento</label>
						<div>
							<p class="form-control-static" id="iNtevent"><em>No seleccionado</em></p>
						</div>
					</div>

					<div class="form-group col-sm-6 has-feedback" id="grie">
						<label class="control-label" for="iNrie">Nivel de Riesgo *</label>
						<select class="form-control" id="iNrie" name="irie" required>
							<option value="">Seleccione nivel</option>
							<?php $ri = new Riesgo() ?>
							<?php $rie = $ri->getAll() ?>
							<?php foreach ($rie as $r): ?>
								<option value="<?php echo $r->rie_id ?>"><?php echo $r->rie_descripcion ?></option>
							<?php endforeach ?>
						</select>
					</div>
				</div>

				<div class="row">
					<div class="form-group col-sm-6 has-feedback" id="gorigen">
						<label class="control-label" for="iNorigen">Origen *</label>
						<select class="form-control" id="iNorigen" name="iorigen" required>
							<option value="">Seleccione origen</option>
							<option value="I">INTRAHOSPITALARIO</option>
							<option value="E">EXTRAHOSPITALARIO</option>
						</select>
					</div>
				</div>

				<div class="row">
					<div class="form-group col-sm-12 has-feedback" id="gdescription">
						<label class="control-label" for="iNdescription">Circunstancias o contexto en que ocurre el evento *</label>
						<textarea rows="4" class="form-control" id="iNdescription" name="idescription" maxlength="450" required></textarea>
						<span class="fa form-control-feedback" id="icondescription"></span>
					</div>
				</div>

				<div class="row">
					<div class="form-group col-sm-6 has-feedback" id="gconsec">
						<label class="control-label" for="iNconsec">Consecuencias o daños producidos *</label>
						<select class="form-control" id="iNconsec" name="iconsec" required>
							<option value="">Seleccione consecuencia</option>
							<?php $con = new Consecuencia() ?>
							<?php $co = $con->getAll() ?>
							<?php foreach ($co as $c): ?>
								<option value="<?php echo $c->cons_id ?>"><?php echo $c->cons_descripcion ?></option>
							<?php endforeach ?>
						</select>
					</div>

					<div class="form-group col-sm-3 has-feedback" id="gcaida">
						<label class="control-label" for="iNcaida">Notificación de caída *</label>
						<select class="form-control" id="iNcaida" name="icaida" required>
							<?php $tv = new TipoVerificacion() ?>
							<?php $tverif = $tv->getAll() ?>
							<?php foreach ($tverif as $t): ?>
								<option value="<?php echo $t->tver_id ?>"<?php if ($t->tver_id == 2): ?> selected<?php endif ?>><?php echo $t->tver_descripcion ?></option>
							<?php endforeach ?>
						</select>
					</div>
				</div>

				<div class="row">
					<div class="form-group col-sm-3 has-feedback" id="gvermed">
						<label class="control-label" for="iNvermed">Verificación de medidas preventivas *</label>
						<select class="form-control" id="iNvermed" name="ivermed" required>
							<?php $tv = new TipoVerificacion() ?>
							<?php $tverif = $tv->getAll() ?>
							<?php foreach ($tverif as $t): ?>
								<option value="<?php echo $t->tver_id ?>"><?php echo $t->tver_descripcion ?></option>
							<?php endforeach ?>
						</select>
					</div>
				</div>

				<div id="div-cent" style="display: none">
					<div class="row">
						<div class="form-group col-sm-3 has-feedback" id="gnocu">
							<label class="control-label" for="iNnocu">Justificación escrita de no cumplimiento *</label>
							<select class="form-control" id="iNnocu" name="inocu">
								<?php $tv = new TipoVerificacion() ?>
								<?php $tverif = $tv->getAll() ?>
								<?php foreach ($tverif as $t): ?>
									<option value="<?php echo $t->tver_id ?>"<?php if ($t->tver_id == 1): ?> selected<?php endif ?>><?php echo $t->tver_descripcion ?></option>
								<?php endforeach ?>
							</select>
						</div>

						<div class="form-group col-sm-3 has-feedback" id="gcljus">
							<label class="control-label" for="iNcljus">Análisis Clínico de justificación *</label>
							<select class="form-control" id="iNcljus" name="icljus">
								<?php $tv = new TipoVerificacion() ?>
								<?php $tverif = $tv->getAll() ?>
								<?php foreach ($tverif as $t): ?>
									<option value="<?php echo $t->tver_id ?>"<?php if ($t->tver_id == 1): ?> selected<?php endif ?>><?php echo $t->tver_descripcion ?></option>
								<?php endforeach ?>
							</select>
						</div>
					</div>

					<div class="row">
						<div class="form-group col-sm-3 has-feedback" id="gmedp">
							<label class="control-label" for="iNmedp">Verificación de medidas preventivas en otros pacientes *</label>
							<select class="form-control" id="iNmedp" name="imedp">
								<?php $tv = new TipoVerificacion() ?>
								<?php $tverif = $tv->getAll() ?>
								<?php foreach ($tverif as $t): ?>
									<option value="<?php echo $t->tver_id ?>"<?php if ($t->tver_id == 1): ?> selected<?php endif ?>><?php echo $t->tver_descripcion ?></option>
								<?php endforeach ?>
							</select>
						</div>
					</div>
				</div>
			</div>

			<div class="box-header with-border">
				<h3 class="box-title">Archivos adjuntos</h3>
			</div>

			<div class="box-body">
				<div class="row">
					<div class="form-group col-sm-6">
						<label class="control-label" for="iNdocument">Archivo de Plan de Mejoras</label>
						<div class="controls">
							<input name="idocument[]" class="multi" id="iNdocument" type="file" size="16" accept="pdf|doc|docx|xls|xlsx|rar|zip" maxlength="1">
							<p class="help-block">Formatos admitidos: pdf, doc, docx, xls, xlsx, rar, zip</p>
						</div>
					</div>
					<div class="form-group col-sm-6">
						<a href="upload/Formato_plan_mejoras.docx" class="btn btn-info" target="_blank"><span class="fa fa-download"></span> Descargar formato de Plan de Mejoras</a>
					</div>
				</div>

				<div class="row" id="div-caida" style="display: none">
					<div class="form-group col-sm-6">
						<label class="control-label" for="iNdoccaida">Archivo de Informe de Caída</label>
						<div class="controls">
							<input name="idoccaida[]" class="multi" id="iNdoccaida" type="file" size="16" accept="pdf|doc|docx|xls|xlsx|rar|zip" maxlength="1">
							<p class="help-block">Formatos admitidos: pdf, doc, docx, xls, xlsx, rar, zip</p>
						</div>
					</div>
					<div class="form-group col-sm-6">
						<a href="upload/Formato_notificacion_caidas.docx" class="btn btn-info" target="_blank"><span class="fa fa-download"></span> Descargar formato de Informe de Caídas</a>
					</div>
				</div>

				<div class="row" id="div-brote" style="display: none">
					<div class="form-group col-sm-6">
						<label class="control-label" for="iNdocbrote">Archivo de Informe de Brote Epidemiológico para IAAS</label>
						<div class="controls">
							<input name="idocbrote[]" class="multi" id="iNdocbrote" type="file" size="16" accept="pdf|doc|docx|xls|xlsx|rar|zip" maxlength="1">
							<p class="help-block">Formatos admitidos: pdf, doc, docx, xls, xlsx, rar, zip</p>
						</div>
					</div>
				</div>
			</div>

			<input name="iind" id="iind" type="hidden">

			<div class="box-footer">
				<button type="submit" class="btn btn-primary" id="btnsubmit"><i class="fa fa-check"></i> Guardar</button>
				<button type="reset" class="btn btn-default" id="btnClear">Limpiar</button>
				<i class="ajaxLoader fa fa-cog fa-spin" id="submitLoader"></i>
			</div>
		</div>
	</form>
</section>

<script src="events/create-event.js?20211229"></script>
