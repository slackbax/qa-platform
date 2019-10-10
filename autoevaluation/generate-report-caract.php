<section class="content-header">
	<h1>Autoevaluación
		<small><i class="fa fa-angle-right"></i> Gneración de reporte de Autoevaluación por características</small>
	</h1>

	<ol class="breadcrumb">
		<li><a href="index.php?section=home"><i class="fa fa-home"></i>Inicio</a></li>
		<li class="active">Generación de reporte por características</li>
	</ol>
</section>

<section class="content container-fluid">
	<form role="form" id="formNewReport">
        <p class="bg-class bg-danger">Los campos marcados con (*) son obligatorios</p>

        <div class="box box-default">
            <div class="box-body">
				<div class="row">
					<div class="form-group col-sm-3 has-feedback" id="gdate">
						<label class="control-label" for="idate">Fecha de evaluación *</label>
						<div class="input-group">
							<div class="input-group-addon">
								<i class="fa fa-calendar"></i>
							</div>
							<input type="text" class="form-control" id="iNdate" name="idate" data-date-format="mm/yyyy" placeholder="MM/AAAA" required>
						</div>
						<i class="fa form-control-feedback" id="icondate"></i>
					</div>
				</div>
			</div>

			<div class="box-footer">
				<button type="submit" class="btn btn-primary" id="btnsubmit"><i class="fa fa-check"></i> Generar reporte</button>
				<button type="reset" class="btn btn-default" id="btnClear">Limpiar</button>
				<i class="ajaxLoader fa fa-cog fa-spin" id="submitLoader"></i>
			</div>
		</div>
    </form>
</section>

<script src="autoevaluation/generate-report-caract.js?v=20190828"></script>