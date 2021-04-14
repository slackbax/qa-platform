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
                        <th>ID</th>
                        <th>Usuario</th>
                        <th>Fecha</th>
                        <th>Hora</th>
                        <th>RUT</th>
                        <th>Nombre</th>
                        <th>Edad</th>
                        <th>Servicio</th>
                        <th>Tipo</th>
                        <th>Evento</th>
                        <th>Categoría</th>
                        <th>Contexto</th>
                        <th>Tipo Paciente</th>
                        <th>Riesgo</th>
						<th>Origen</th>
                        <th>Consecuencias</th>
                        <th>R. Caída</th>
                        <th>JE</th>
                        <th>ACJ</th>
                        <th>REP</th>
                        <th>VER</th>
                        <th>Registro</th>
                        <th></th>
                    </tr>
                </thead>

                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</section>

<script src="events/view-events.js?v=20210414"></script>