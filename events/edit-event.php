<?php include("class/classEvento.php") ?>
<?php include("class/classTipoPaciente.php") ?>
<?php include("class/classTipoEvento.php") ?>
<?php include("class/classRiesgo.php") ?>
<?php include("class/classConsecuencia.php") ?>
<?php include("class/classTipoVerificacion.php") ?>
<?php $ev = new Evento() ?>
<?php $e = $ev->get($id) ?>

<section class="content-header">
	<h1>Eventos
		<small><i class="fa fa-angle-right"></i> Edición de Evento</small>
	</h1>

	<ol class="breadcrumb">
        <li><a href="index.php?section=home"><i class="fa fa-home"></i> Inicio</a></li>
        <li><a href="index.php?section=adv-event&sbs=viewevents">Eventos ingresados</a></li>
		<li class="active">Edición de evento</li>
	</ol>
</section>

<section class="content container-fluid">
    <form role="form" id="formNewEvent">
        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title">Información del paciente</h3>
            </div>

            <div class="box-body">
                <div class="row">
                    <div class="form-group col-sm-3" id="grut">
                        <label class="control-label" for="irut">RUT</label>
                        <p class="form-control-static"><?php echo $e->ev_rut ?></p>
                        <input type="hidden" id="iNid" name="iid" value="<?php echo $e->ev_id ?>">
                    </div>
                    
                    <div class="form-group col-sm-6" id="gname">
                        <label class="control-label" for="iname">Nombre</label>
                        <p class="form-control-static"><?php echo $e->ev_nombre ?></p>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-sm-3" id="gtpac">
                        <label class="control-label" for="itpac">Tipo de Paciente</label>
                        <p class="form-control-static"><?php echo $e->tpac_desc ?></p>
                    </div>
                    
                    <div class="form-group col-sm-6" id="gservicio">
                        <label class="control-label" for="isala">Servicio</label>
                        <p class="form-control-static"><?php echo $e->ser_desc ?></p>
                    </div>
                </div>
            </div>

            <div class="box-header with-border">
                <h3 class="box-title">Información del evento</h3>
            </div>

            <div class="box-body">
                <div class="row">
                    <div class="form-group col-sm-3" id="gdate">
                        <label class="control-label" for="idate">Fecha de evento/hora</label>
                        <p class="form-control-static"><?php echo getDateHourToForm($e->ev_fecha) ?></p>
                    </div>
                </div>
                
                <div class="row">
                    <div class="form-group col-sm-6" id="gstev">
                        <label class="control-label" for="istsev">Evento</label>
                        <p class="form-control-static"><?php echo $e->tev_desc . ' - ' . $e->stev_desc . ' <em>(' . $e->cat_desc . ')</em>' ?></p>
                    </div>
                </div>
                
                <div class="row">
                    <div class="form-group col-sm-6" id="grie">
                        <label class="control-label" for="irie">Nivel de Riesgo</label>
                        <p class="form-control-static"><?php echo $e->rie_desc ?></p>
                    </div>
                </div>

				<div class="row">
					<div class="form-group col-sm-6 has-feedback" id="gorigen">
						<label class="control-label" for="iNorigen">Origen</label>
						<p class="form-control-static"><?php echo ($e->ev_origen == 'E') ? 'EXTRAHOSPITALARIO' : 'INTRAHOSPITALARIO' ?></p>
					</div>
				</div>

                <div class="row">
                    <div class="form-group col-sm-12" id="gdescription">
                        <label class="control-label" for="idescription">Circunstancias o contexto en que ocurre el evento</label>
                        <p class="form-control-static"><?php echo $e->ev_contexto ?></p>
                    </div>
                </div>
                
                <div class="row">
                    <div class="form-group col-sm-6" id="gconsec">
                        <label class="control-label" for="iconsec">Consecuencias o daños producidos</label>
                        <p class="form-control-static"><?php echo $e->cons_desc ?></p>
                    </div>
                </div>
                
                <div class="row">
                    <div class="form-group col-sm-3" id="gnocu">
                        <label class="control-label" for="inocu">Justificación escrita de no cumplimiento</label>
                        <p class="form-control-static"><?php echo $e->ev_je ?></p>
                    </div>
                    
                    <div class="form-group col-sm-3" id="gcljus">
                        <label class="control-label" for="icljus">Análisis Clínico de justificación</label>
                        <p class="form-control-static"><?php echo $e->ev_acj ?></p>
                    </div>
                </div>
                
                <div class="row">
                    <div class="form-group col-sm-3" id="gmedp">
                        <label class="control-label" for="imedp">Verificación de medidas preventivas en otros pacientes</label>
                        <p class="form-control-static"><?php echo $e->ev_rep ?></p>
                    </div>
                    
                    <div class="form-group col-sm-3 has-feedback" id="gvermed">
                        <label class="control-label" for="ivermed">Verificación de medidas preventivas</label>
                        <p class="form-control-static"><?php echo $e->ev_ver ?></p>
                    </div>
                </div>
            </div>

            <div class="box-header with-border">
                <h3 class="box-title">Archivos adjuntos</h3>
            </div>

            <div class="box-body">
                <?php if (!empty($e->ev_path)): ?>
                <div class="row">
                    <div class="form-group col-sm-12">
                        <label class="control-label" for="idocument">Archivo de Plan de Mejoras</label>
                        <?php $tmp = explode('/', $e->ev_path) ?>
                        <p class="form-control-static">
							<a href="<?php echo $e->ev_path ?>" target="_blank">
								<i class="fa fa-file-<?php echo getExtension(pathinfo($e->ev_path, PATHINFO_EXTENSION)) ?>-o text-<?php echo getColorExt(pathinfo($e->ev_path, PATHINFO_EXTENSION)) ?>"></i> <?php echo $tmp[2] ?>
							</a>
						</p>
                    </div>
                </div>
                <?php endif ?>
                
                <div class="row">
                    <div class="form-group col-sm-12">
                        <label class="control-label" for="idocument">Archivo de Plan de Mejoras</label>
                        <div class="controls">
                            <input name="idocument[]" class="multi" id="idocument" type="file" size="16" accept="pdf|doc|docx|xls|xlsx|rar|zip" maxlength="1">
                            <p class="help-block">Formatos admitidos: pdf, doc, docx, xls, xlsx, rar, zip</p>
                        </div>
                    </div>
                </div>

                <?php if (!empty($e->ev_caida_path)): ?>
                <div class="row">
                    <div class="form-group col-sm-12">
                        <label class="control-label" for="idocument">Notificación de Caída</label>
                        <?php $tmp = explode('/', $e->ev_caida_path) ?>
                        <p class="form-control-static">
							<a href="<?php echo $e->ev_path ?>" target="_blank">
								<i class="fa fa-file-<?php echo getExtension(pathinfo($e->ev_caida_path, PATHINFO_EXTENSION)) ?>-o text-<?php echo getColorExt(pathinfo($e->ev_caida_path, PATHINFO_EXTENSION)) ?>"></i> <?php echo $tmp[1] ?>
							</a>
						</p>
                    </div>
                </div>
                <?php endif ?>

				<div class="row">
					<div class="form-group col-sm-12">
						<label class="control-label" for="idocumentcaida">Archivo de Notificación de Caída</label>
						<div class="controls">
							<input name="idocumentcaida[]" class="multi" id="idocumentcaida" type="file" size="16" accept="pdf|doc|docx|xls|xlsx|rar|zip" maxlength="1">
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

<script src="events/edit-event.js?v=20191023"></script>