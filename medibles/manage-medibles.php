<section class="content-header">
	<h1>Autoevaluación
		<small><i class="fa fa-angle-right"></i> Administración de Adicionales de Características</small>
	</h1>

	<ol class="breadcrumb">
		<li><a href="index.php?section=home"><i class="fa fa-home"></i>Inicio</a></li>
		<li class="active">Adicionales de características ingresados</li>
	</ol>
</section>

<section class="content container-fluid">
    <div class="box box-default">
		<ul class="nav nav-tabs">
			<li role="presentation" class="active"><a href="#em" aria-controls="em" role="tab" data-toggle="tab">Elementos Medibles</a></li>
			<li role="presentation"><a href="#acl" aria-controls="acl" role="tab" data-toggle="tab">Aclaratorias</a></li>
		</ul>

		<div class="tab-content">
			<div role="tabpanel" class="tab-pane fade in active" id="em">
				<div class="box-body">
					<table id="tfiles" class="table table-striped table-hover">
						<thead>
						<tr>
							<th>ID</th>
							<th>Código</th>
							<th>Número</th>
							<th>Descripción</th>
							<th></th>
							<th></th>
							<th></th>
						</tr>
						</thead>

						<tbody>
						</tbody>
					</table>
				</div>
			</div>

			<div role="tabpanel" class="tab-pane fade" id="acl">
				<div class="box-body">
					<table id="tacl" class="table table-striped table-hover">
						<thead>
						<tr>
							<th>ID</th>
							<th>Código</th>
							<th>Fecha</th>
							<th>Resolución</th>
							<th>Número</th>
							<th>Resumen</th>
							<th></th>
							<th></th>
							<th></th>
						</tr>
						</thead>

						<tbody>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</section>

<!-- Modal -->
<div class="modal fade" id="indDetail" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title" id="myModalLabel">Información de Indicador</h4>
				<h5 id="f_name"></h5>
			</div>
			<div class="modal-body">

				<div class="td-div">
					<p class="td-div-t">Nombre</p>
					<p class="td-div-i" id="f_name2"></p>
				</div>
				<div class="td-div">
					<p class="td-div-t">Descripción</p>
					<p class="td-div-i" id="f_desc"></p>
				</div>
				<div class="td-div">
					<p class="td-div-t">Característica asociada</p>
					<p class="td-div-i" id="f_char"></p>
				</div>
				<div class="td-div">
					<p class="td-div-t">Elemento medible</p>
					<p class="td-div-i" id="f_elem"></p>
				</div>
				<div class="td-div">
					<p class="td-div-t">Periodicidad</p>
					<p class="td-div-i" id="f_period"></p>
				</div>
				<div class="td-div">
					<p class="td-div-t">Numerador</p>
					<p class="td-div-i" id="f_num"></p>
				</div>
				<div class="td-div">
					<p class="td-div-t">Denominador</p>
					<p class="td-div-i" id="f_den"></p>
				</div>
				<div class="td-div">
					<p class="td-div-t">Umbral (%)</p>
					<p class="td-div-i" id="f_umbral"></p>
				</div>
				<div class="td-div no-bottom">
					<p class="td-div-t">Creado/modificado el</p>
					<p class="td-div-i" id="f_date"></p>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
			</div>
		</div>
	</div>
</div>

<script src="medibles/manage-medibles.js?v=20190828"></script>