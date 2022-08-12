<section class="content-header">
	<h1>Panel de Control
		<small><i class="fa fa-angle-right"></i> Administración de Otros Documentos</small>
	</h1>

	<ol class="breadcrumb">
		<li><a href="index.php?section=home"><i class="fa fa-home"></i>Inicio</a></li>
		<li class="active">Otros documentos ingresados</li>
	</ol>
</section>

<section class="content container-fluid">
	<div class="box box-default">
		<div class="box-header with-border">
			<h3 class="box-title">Otros documentos registrados</h3>
		</div>

		<div class="box-body">
			<table id="tfiles" class="table table-striped table-hover">
				<thead>
				<tr>
					<th></th>
					<th>Nombre</th>
					<th>Subido el</th>
					<th>Válido hasta</th>
					<th></th>
				</tr>
				</thead>

				<tbody>
				</tbody>
			</table>
		</div>
	</div>
</section>

<!-- Modal -->
<div class="modal fade" id="fileDetail" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title" id="myModalLabel">Información de Archivo <small id="f_name"></small></h4>
			</div>
			<div class="modal-body">
				<div class="td-div">
					<p class="td-div-t">Edición</p>
					<p class="td-div-i" id="f_edition"></p>
				</div>
				<div class="td-div">
					<p class="td-div-t">Creado en</p>
					<p class="td-div-i" id="f_date_c"></p>
				</div>
				<div class="td-div">
					<p class="td-div-t">Publicado el</p>
					<p class="td-div-i" id="f_date"></p>
				</div>
				<div class="td-div">
					<p class="td-div-t">Vigente hasta</p>
					<p class="td-div-i" id="f_date_v"></p>
				</div>
				<div class="td-div">
					<p class="td-div-t">Tipo</p>
					<p class="td-div-i" id="f_type"></p>
				</div>
				<div class="td-div">
					<p class="td-div-t">Subido por</p>
					<p class="td-div-i" id="f_user"></p>
				</div>
				<div class="td-div no-bottom">
					<p class="td-div-t">Descargas</p>
					<p class="td-div-i" id="f_downloads"></p>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
				<a id="f_path" href="" data-ident="" class="btn btn-primary btnModal" target="_blank">Descargar</a>
			</div>
		</div>
	</div>
</div>

<script src="admin/files/manage-other-files.js"></script>
