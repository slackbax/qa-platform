<?php include("class/classPuntoVerificacion.php") ?>
<?php include("class/classTipoDocumento.php") ?>
<?php $pv = new PuntoVerificacion() ?>
<?php $td = new TipoDocumento() ?>
<?php $am = new Ambito() ?>

<section class="content-header">
	<h1>Archivos
		<small><i class="fa fa-angle-right"></i> Ingreso de Documento de Acreditación</small>
	</h1>

	<ol class="breadcrumb">
        <li><a href="index.php?section=home"><i class="fa fa-home"></i> Inicio</a></li>
		<li class="active">Ingreso de documento de acreditación</li>
	</ol>
</section>

<section class="content container-fluid">
    <form role="form" id="formNewFile">
        <p class="bg-class bg-danger">Los campos marcados con (*) son obligatorios</p>

        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title">Información del archivo</h3>
            </div>

            <div class="box-body">
                <div class="row">
                    <div class="form-group col-sm-6 has-feedback" id="gname">
                        <label class="control-label" for="iNname">Nombre *</label>
                        <input type="text" class="form-control" id="iNname" name="iname" placeholder="Ingrese nombre del documento" maxlength="250" required>
                        <i class="fa form-control-feedback" id="iconname"></i>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-sm-3 has-feedback" id="gversion">
                        <label class="control-label" for="iNversion">Versión *</label>
                        <input type="text" class="form-control" id="iNversion" name="iversion" placeholder="Ingrese versión del documento" maxlength="4" required>
                        <i class="fa form-control-feedback" id="iconversion"></i>
                    </div>

                    <div class="form-group col-sm-3 has-feedback" id="gcode">
                        <label class="control-label" for="iNcode">Código *</label>
                        <input type="text" class="form-control" id="iNcode" name="icode" placeholder="Ingrese código del documento" maxlength="8" required>
                        <i class="fa form-control-feedback" id="iconcode"></i>
                    </div>

					<div class="form-group col-sm-6 has-feedback" id="gresp">
						<label class="control-label" for="iNresp">Responsable</label>
						<input type="text" class="form-control" id="iNresp" name="iresp" placeholder="Ingrese nombre del responsable del documento" maxlength="256">
						<i class="fa form-control-feedback" id="iconresp"></i>
					</div>
                </div>

                <div class="row">
                    <div class="form-group col-sm-3 has-feedback" id="gdate">
                        <label class="control-label" for="iNdate">Fecha de creación *</label>
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input type="text" class="form-control" id="iNdate" name="idate" data-date-format="dd/mm/yyyy" placeholder="DD/MM/AAAA" required>
                        </div>
                        <i class="fa form-control-feedback" id="icondate"></i>
                    </div>

                    <div class="form-group col-sm-3 has-feedback" id="gdatec">
                        <label class="control-label" for="iNdatec">Fecha de caducidad *</label>
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input type="text" class="form-control" id="iNdatec" name="idatec" data-date-format="mm/yyyy" placeholder="MM/AAAA" required>
                        </div>
                        <i class="fa form-control-feedback" id="icondatec"></i>
                    </div>

					<div class="form-group col-sm-3 has-feedback" id="gtdocumento">
						<label class="control-label" for="iNtdocumento">Tipo de documento</label>
						<select class="form-control" id="iNtdocumento" name="itdocumento">
							<option value="">Seleccione tipo de documento</option>
							<?php $tdoc = $td->getAll() ?>
							<?php foreach ($tdoc as $k => $tdo): ?>
								<option value="<?php echo $tdo->tdo_id ?>"><?php echo $tdo->tdo_descripcion ?></option>
							<?php endforeach ?>
						</select>
					</div>

					<div class="form-group col-sm-3 has-feedback" id="gcaracter">
						<label class="control-label" for="iNcaracter">Carácter</label>
						<select class="form-control" id="iNcaracter" name="icaracter">
							<option value="">Seleccione carácter</option>
							<option value="1">INSTITUCIONAL</option>
							<option value="0">NO INSTITUCIONAL</option>
						</select>
					</div>
                </div>

                <div class="row">
                    <div class="form-group col-sm-6 has-feedback" id="gambito">
                        <label class="control-label" for="iNambito">Ámbito *</label>
                        <select class="form-control" id="iNambito" name="iambito" required>
                            <option value="">Seleccione ámbito</option>
                            <?php $ambito = $am->getAll() ?>
                            <?php foreach ($ambito as $a): ?>
                            <option value="<?php echo $a->amb_id ?>"><?php echo $a->amb_nombre ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class="form-group col-sm-6 has-feedback" id="gsambito">
                        <label class="control-label" for="iNsambito">Sub-ámbito *</label>
                        <select class="form-control" id="iNsambito" name="isambito" required>
                            <option value="">Seleccione sub-ámbito</option>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-sm-6 has-feedback" id="gtcar">
                        <label class="control-label" for="iNtcar">Tipo de Característica *</label>
                        <select class="form-control" id="iNtcar" name="itcar" required>
                            <option value="">Seleccione tipo</option>
                        </select>
                    </div>
                    <div class="form-group col-sm-6 has-feedback" id="gtcode">
                        <label class="control-label" for="iNtcode">Código de Característica *</label>
                        <select class="form-control" id="iNtcode" name="itcode" required>
                            <option value="">Seleccione código</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="box-header with-border">
                <h3 class="box-title">Detalles</h3>
            </div>

            <div class="box-body">
                <div class="row">
                    <div class="form-group col-sm-12">
                        <label class="control-label" for="iNdescription">Descripción</label>
                        <textarea rows="4" class="form-control" id="iNdescription" name="idescription" readonly></textarea>
                    </div>
                </div>

				<div class="row">
					<div class="form-group col-sm-6 has-feedback" id="gpv">
						<label class="control-label" for="iNpv">Punto de Verificación</label>
						<select class="form-control" id="iNpv" name="ipv">
							<option value="">Seleccione punto</option>
							<?php $punto = $pv->getAll() ?>
							<?php foreach ($punto as $p): ?>
								<option value="<?php echo $p->pv_id ?>"><?php echo $p->pv_nombre ?></option>
							<?php endforeach ?>
						</select>
					</div>
					<div class="form-group col-sm-6 has-feedback" id="gspv">
						<label class="control-label" for="iNspv">Sub-punto</label>
						<select class="form-control" id="iNspv" name="ispv">
							<option value="">Seleccione sub-punto</option>
						</select>
					</div>
				</div>

				<div class="row">
					<div class="col-sm-6">
						<button type="button" class="btn btn-info btn-sm" id="btnAddPoint" style="margin-bottom: 20px" disabled><i class="fa fa-plus"></i> Agregar sub-punto</button>
					</div>
				</div>

				<input type="hidden" name="inspv" id="iNnspv">

				<div id="divDestiny" style="padding: 2px 10px; margin-bottom: 10px; background-color: #f2f2f2; border: 2px solid #f2f2f2">
					<h4>Sub-puntos agregados</h4>
					<div class="row">
						<div class="form-group col-sm-5">
							<p class="form-control-static"><strong>Punto de verificación</strong></p>
						</div>
						<div class="form-group col-sm-6">
							<p class="form-control-static"><strong>Sub-punto</strong></p>
						</div>
						<div class="form-group col-sm-1 text-center">
							<p class="form-control-static"></p>
						</div>
					</div>

					<div id="divDestiny-inner">
						<div class="row">
							<div class="form-group col-sm-12">
								<p><em>No se han agregado puntos de verificación.</em></p>
							</div>
						</div>
					</div>
				</div>

                <div class="row">
                    <div class="form-group col-sm-12">
                        <label class="control-label" for="idocument">Archivo *</label>
                        <div class="controls">
                            <input name="idocument[]" class="multi" id="idocument" type="file" size="16" accept="pdf|doc|docx|xls|xlsx" maxlength="1">
                            <p class="help-block">Formatos admitidos: pdf, doc, docx, xls, xlsx</p>
                        </div>
                    </div>
                </div>
            </div>

            <input name="iind" id="iind" type="hidden">

            <div class="box-footer">
                <button type="submit" class="btn btn-primary" id="btnsubmit"><i class="fa fa-check"></i> Guardar</button>
                <button type="reset" class="btn btn-default btn-sm" id="btnClear">Limpiar</button>
                <i class="ajaxLoader fa fa-cog fa-spin" id="submitLoader"></i>
            </div>
        </div>
    </form>
</section>

<script src="files/uploadverif.js?v=20210322"></script>
