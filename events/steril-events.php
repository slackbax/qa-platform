<?php include("class/classEvento.php") ?>
<?php $ev = new Evento() ?>

<section class="content-header">
	<h1>Eventos
		<small><i class="fa fa-angle-right"></i> Eventos Ingresados para Esterilización</small>
	</h1>

	<ol class="breadcrumb">
		<li><a href="index.php?section=home"><i class="fa fa-home"></i>Inicio</a></li>
		<li class="active">Eventos ingresados para esterilización</li>
	</ol>
</section>

<section class="content container-fluid">
    <div class="box box-default">
        <div class="box-body">
			<table id="tfiles" class="table table-striped table-hover">
				<thead>
				<tr>
					<th>ID</th>
					<th>Usuario</th>
					<th>Fecha</th>
					<th>Hora</th>
					<th>RUT</th>
					<th>Nombre</th>
					<th>Edad</th>
					<th>Servicio</th>
					<th>Evento</th>
					<th>Categoría</th>
					<th>Contexto</th>
					<th>Tipo Paciente</th>
					<th>Riesgo</th>
					<th>Consecuencias</th>
					<th>R. Caída</th>
					<th>JE</th>
					<th>ACJ</th>
					<th>REP</th>
					<th>VER</th>
					<th></th>
				</tr>
				</thead>

				<tbody>
				</tbody>
			</table>
		</div>
	</div>
</section>

<script src="events/steril-events.js?v=20190828"></script>