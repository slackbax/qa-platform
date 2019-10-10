<?php include("class/classSubPuntoVerificacion.php"); ?>

<section class="content-header">
	<h1>Autoevaluación
		<small><i class="fa fa-angle-right"></i> Ingreso de reporte de Autoevaluación</small>
	</h1>

	<ol class="breadcrumb">
        <li><a href="index.php?section=home"><i class="fa fa-home"></i> Inicio</a></li>
		<li class="active">Ingreso de reporte de autoevaluación</li>
	</ol>
</section>

<section class="content container-fluid">
	<p class="bg-class bg-danger">Los campos marcados con (*) son obligatorios</p>

    <div class="box box-default">
        <form role="form" id="formNewFile">
            <div class="box-header with-border">
				<h3 class="box-title">Información del reporte</h3>
			</div>

			<div class="box-body">
                <div class="row">
                    <div class="form-group col-sm-6 has-feedback" id="gname">
                        <label class="control-label" for="iname">Nombre Evaluado *</label>
                        <input type="text" class="form-control" id="iNname" name="iname" placeholder="Ingrese nombre del o los encargados de la característica" maxlength="250" required>
                        <i class="fa form-control-feedback" id="iconname"></i>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-sm-6 has-feedback" id="gspv">
                        <label class="control-label" for="ispv">Lugar de Evaluación *</label>
                        <select class="form-control" id="iNspv" name="ispv" required>
                            <option value="">Seleccione lugar de evaluación</option>
                            <?php $spv = new SubPuntoVerificacion() ?>
                            <?php $s = $spv->getAll() ?>
                            <?php foreach ($s as $sp): ?>
                                <option value="<?php echo $sp->spv_id ?>"><?php echo $sp->spv_pvnombre . ' - ' . $sp->spv_nombre ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-sm-3 has-feedback" id="gdate">
                        <label class="control-label" for="idate">Fecha de evaluación *</label>
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input type="text" class="form-control" id="iNdate" name="idate" data-date-format="dd/mm/yyyy" placeholder="DD/MM/AAAA" required>
                        </div>
                        <i class="fa form-control-feedback" id="icondate"></i>
                    </div>
                </div>

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
                        <label class="control-label" for="itcode">Código de Característica *</label>
                        <select class="form-control" id="iNtcode" name="itcode" required>
                            <option value="">Seleccione código</option>
                        </select>
                    </div>
                </div>
            </div>

            <div id="t-autoeval"></div>

            <div class="box-footer">
                <button type="submit" class="btn btn-primary" id="btnsubmit"><i class="fa fa-check"></i> Guardar</button>
                <button type="reset" class="btn btn-default" id="btnClear">Limpiar</button>
                <i class="ajaxLoader fa fa-cog fa-spin" id="submitLoader"></i>
            </div>
        </div>
    </form>
</section>

<script src="autoevaluation/neweval.js?v=20190828"></script>