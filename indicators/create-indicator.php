<?php include("class/classSubPuntoVerificacion.php") ?>

<section class="content-header">
	<h1>Autoevaluación
		<small><i class="fa fa-angle-right"></i> Ingreso de valores para Indicador</small>
	</h1>

	<ol class="breadcrumb">
        <li><a href="index.php?section=home"><i class="fa fa-home"></i> Inicio</a></li>
		<li class="active">Ingreso de valores para indicador</li>
	</ol>
</section>

<section class="content container-fluid">
	<p class="bg-class bg-danger">Los campos marcados con (*) son obligatorios</p>
    
	<div class="box box-default">
        <form role="form" id="formSearchIndicator">
            <div class="box-header with-border">
				<h3 class="box-title">Filtros de búsqueda</h3>
			</div>

			<div class="box-body">
                <div class="row">
                    <div class="form-group col-sm-3 has-feedback" id="gdate">
                        <label class="control-label" for="idate">Año *</label>
                        <div class="input-group">
							<div class="input-group-addon">
								<i class="fa fa-calendar"></i>
							</div>
                            <input type="text" class="form-control" id="iNdate" name="idate" data-date-format="yyyy" placeholder="AAAA" required>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="form-group col-sm-6 has-feedback" id="gpv">
                        <label class="control-label" for="ipv">Punto de Verificación *</label>
                        <select class="form-control" id="iNpv" name="ipv" required>
                            <option value="">Seleccione punto de verificación</option>
                            <?php $spv = new SubPuntoVerificacion() ?>
                            <?php $spver = $spv->getAll() ?>
                            <?php foreach ($spver as $s): ?>
                            <option value="<?php echo $s->spv_id ?>"><?php echo $s->spv_pvnombre . ': ' . $s->spv_nombre ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="box-footer">
				<button type="submit" class="btn btn-info" id="btnsearch"><i class="fa fa-search"></i> Buscar</button>
				<i class="ajaxLoader fa fa-cog fa-spin" id="submitLoader"></i>
			</div>
		</form>
	</div>

    <div class="box box-default">
        <form role="form" id="formSaveInd">
            <div class="box-header with-border">
				<h3 class="box-title">Características/indicadores asociados</h3>
            </div>
            
            <div class="box-body">
                <div id="divResult"><i>No hay resultados para la búsqueda</i></div>
            </div>

            <div class="box-footer">
                <input type="hidden" id="iNspv" name="ispv">
                <input type="hidden" id="iNyear" name="iyear">
				<button type="submit" class="btn btn-primary" id="btnsubmit"><i class="fa fa-check"></i> Guardar</button>
				<button type="reset" class="btn btn-default" id="btnClear">Limpiar</button>
				<i class="ajaxLoader fa fa-cog fa-spin" id="submitLoader2"></i>
			</div>
        </form>
    </div>
</section>

<script src="indicators/create-indicator.js?v=20190828"></script>