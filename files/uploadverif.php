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
                    <div class="form-group col-xs-6 has-feedback" id="gname">
                        <label class="control-label" for="iname">Nombre *</label>
                        <input type="text" class="form-control" id="iNname" name="iname" placeholder="Ingrese nombre del documento" maxlength="250" required>
                        <i class="fa form-control-feedback" id="iconname"></i>
                    </div>
                </div>
                
                <div class="row">
                    <div class="form-group col-xs-3 has-feedback" id="gversion">
                        <label class="control-label" for="iversion">Versión *</label>
                        <input type="text" class="form-control" id="iNversion" name="iversion" placeholder="Ingrese versión del documento" maxlength="4" required>
                        <i class="fa form-control-feedback" id="iconversion"></i>
                    </div>
                    
                    <div class="form-group col-xs-3 has-feedback" id="gcode">
                        <label class="control-label" for="icode">Código *</label>
                        <input type="text" class="form-control" id="iNcode" name="icode" placeholder="Ingrese código del documento" maxlength="8" required>
                        <i class="fa form-control-feedback" id="iconcode"></i>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-xs-3 has-feedback" id="gdate">
                        <label class="control-label" for="idate">Fecha de creación *</label>
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input type="text" class="form-control" id="iNdate" name="idate" data-date-format="dd/mm/yyyy" placeholder="DD/MM/AAAA" required>
                        </div>
                        <i class="fa form-control-feedback" id="icondate"></i>
                    </div>
                    
                    <div class="form-group col-xs-3 has-feedback" id="gdatec">
                        <label class="control-label" for="idatec">Fecha de caducidad *</label>
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input type="text" class="form-control" id="iNdatec" name="idatec" data-date-format="mm/yyyy" placeholder="MM/AAAA" required>
                        </div>
                        <i class="fa form-control-feedback" id="icondatec"></i>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-xs-6 has-feedback" id="gambito">
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
                    <div class="form-group col-xs-6 has-feedback" id="gsambito">
                        <label class="control-label" for="isambito">Sub-ámbito *</label>
                        <select class="form-control" id="iNsambito" name="isambito" required>
                            <option value="">Seleccione sub-ámbito</option>
                        </select>
                    </div>
                </div>
                
                <div class="row">
                    <div class="form-group col-xs-6 has-feedback" id="gtcar">
                        <label class="control-label" for="iambito">Tipo de Característica *</label>
                        <select class="form-control" id="iNtcar" name="itcar" required>
                            <option value="">Seleccione tipo</option>
                        </select>
                    </div>
                    <div class="form-group col-xs-6 has-feedback" id="gtcode">
                        <label class="control-label" for="itcode">Código de Característica *</label>
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
                    <div class="form-group col-xs-12">
                        <label class="control-label" for="iproblem">Descripción</label>
                        <textarea rows="4" class="form-control" id="iNdescription" name="idescription" readonly></textarea>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-xs-12">
                        <label class="control-label" for="ipvs">Puntos de verificación</label>
                        <div class="clearfix"></div>
                        <?php include("class/classPuntoVerificacion.php") ?>
                        <?php $pv = new PuntoVerificacion() ?>
                        <?php $pver = $pv->getAll() ?>
                        <?php foreach ($pver as $p): ?>
                        <div class="col-xs-3">
                            <label class="label-checkbox">
                                <input class="ipv_check minimal" type="checkbox" name="ipvs[<?php echo $p->pv_id ?>]" id="ipvs_<?php echo $p->pv_id ?>">
                                <?php echo $p->pv_nombre ?>
                            </label>
                        </div>
                        <?php endforeach ?>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-xs-12">
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

<script src="files/uploadverif.js?v=20190828"></script>