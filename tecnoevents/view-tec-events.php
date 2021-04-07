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
					<th>Usuario</th>
					<th>Fecha</th>
					<th>Fecha Evento</th>
					<th>Servicio</th>
					<th>Clasificación</th>
					<th>Descripción</th>
					<th>Detección</th>
					<th>Causa</th>
					<th>Consecuencia</th>
					<th>Autorización</th>
					<th>RUT</th>
					<th>Paciente</th>
					<th>Diagnóstico</th>
					<th>Nombre disp.</th>
					<th>Nombre com. disp.</th>
					<th>Uso previsto</th>
					<th>Riesgo</th>
					<th>Lote</th>
					<th>Serie</th>
					<th>Fecha fab.</th>
					<th>Fecha ven.</th>
					<th>Condición</th>
					<th>Registro san.</th>
					<th>Disponibilidad</th>
					<th>Adquisición</th>
					<th>Fabricante</th>
					<th>País</th>
					<th>E-mail</th>
					<th>Teléfono</th>
					<th>Representante</th>
					<th>Dirección</th>
					<th>E-mail</th>
					<th>Teléfono</th>
					<th>Inmportador</th>
					<th>Dirección</th>
					<th>E-mail</th>
					<th>Teléfono</th>
					<th>Correcciones</th>
					<th></th>
				</tr>
				</thead>

				<tbody>
				</tbody>
			</table>
		</div>
	</div>
</section>

<script src="tecnoevents/view-tec-events.js"></script>