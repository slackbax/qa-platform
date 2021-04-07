<?php include("class/classEvento.php") ?>
<?php $ev = new Evento() ?>

<section class="content-header">
	<h1>Eventos
		<small><i class="fa fa-angle-right"></i> Eventos Ingresados</small>
	</h1>

	<ol class="breadcrumb">
		<li><a href="index.php?section=home"><i class="fa fa-home"></i>Inicio</a></li>
		<li class="active">Eventos ingresados</li>
	</ol>
</section>

<section class="content container-fluid">
	<div class="box box-default">
		<div class="box-body">
			<table id="tevents" class="table table-striped table-hover">
				<thead>
				<tr>
					<th>ID</th>
					<th>RUT</th>
					<th>Usuario</th>
					<th>Fecha</th>
					<th>Fecha Evento</th>
					<th>Servicio</th>
					<th>Descripción</th>
					<th>Nombre gen.</th>
					<th>Nombre com.</th>
					<th>Catálogo</th>
					<th>Uso</th>
					<th>Otro uso</th>
					<th>Cadena de frío</th>
					<th>Temperatura</th>
					<th>Lote</th>
					<th>Medidas adicionales</th>
					<th>Fabricante</th>
					<th>País</th>
					<th>Importador</th>
					<th>País</th>
					<th>Forma de uso</th>
					<th>Fecha fab.</th>
					<th>Fecha ven.</th>
					<th>Verificación cond.</th>
					<th>Control calidad</th>
					<th>Adscrito a programa</th>
					<th>Autorización de uso</th>
					<th>Otra autorización</th>
					<th>Método ensayo</th>
					<th>Tipo técnica</th>
					<th>Analizador</th>
					<th>Investigación realizada</th>
					<th>Reporte de evento</th>
					<th></th>
				</tr>
				</thead>

				<tbody>
				</tbody>
			</table>
		</div>
	</div>
</section>

<script src="tecnoevents/view-div-events.js"></script>