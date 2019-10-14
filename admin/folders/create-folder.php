<section class="content-header">
	<h1>Panel de Control
		<small><i class="fa fa-angle-right"></i> Creación de Directorio</small>
	</h1>

	<ol class="breadcrumb">
		<li><a href="index.php?section=home"><i class="fa fa-home"></i>Inicio</a></li>
		<li class="active">Creación de directorio</li>
	</ol>
</section>

<section class="content container-fluid">
	<form role="form" id="formNewFolder">
		<p class="bg-class bg-danger">Los campos marcados con (*) son obligatorios</p>

		<div class="box box-default">
			<div class="box-header with-border">
				<h3 class="box-title">Información del directorio</h3>
			</div>

			<div class="box-body">
				<div class="row">
					<div class="form-group col-sm-4" id="gname">
						<label for="iname">Nombre *</label>
						<input type="text" class="form-control" id="iNname" name="iname" placeholder="Ingrese nombres del directorio" required>
						<i class="fa form-control-feedback" id="iconname"></i>
					</div>
				</div>

				<div class="row">
					<div class="form-group col-sm-8" id="gdescription">
						<label for="idescription">Descripción *</label>
						<input type="text" class="form-control" id="iNdescription" name="idescription" placeholder="Ingrese una descripción para el directorio" required>
						<i class="fa form-control-feedback" id="icondescription"></i>
					</div>
				</div>
			</div>

			<div class="box-footer">
				<button type="submit" class="btn btn-primary" id="btnsubmit"><i class="fa fa-check"></i> Guardar</button>
				<button type="reset" class="btn btn-default" id="btnClear">Limpiar</button>
				<i class="ajaxLoader fa fa-cog fa-spin" id="submitLoader"></i>
			</div>
		</div>
	</form>
</section>

<script src="admin/folders/create-folder.js?v=20191014"></script>