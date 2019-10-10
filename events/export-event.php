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
            <div class="row">
                <div class="col-sm-12 text-center">
                    <button type="button" class="btn btn-info" id="view-historic"><i class="fa fa-calendar"></i> Ver histórico de eventos</button>
                </div>
            </div>
        </div>

        <div class="box-body">
			<table id="tfiles" class="table table-striped table-hover">
				<thead>
				<tr>
					<th>Usuario</th>
					<th>Fecha</th>
					<th>Hora</th>
					<th>RUT</th>
					<th>Nombre</th>
					<th>Edad</th>
					<th>Servicio</th>
					<th>Tipo</th>
					<th>Categoría</th>
					<th>Consecuencias</th>
					<th></th>
				</tr>
				</thead>

				<tbody>
				</tbody>
			</table>
		</div>
	</div>
</section>

<script src="events/export-event.js?v=20190828"></script>