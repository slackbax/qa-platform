<section class="content-header">
	<h1>Panel de Control
		<small><i class="fa fa-angle-right"></i> Administración de Usuarios</small>
	</h1>

	<ol class="breadcrumb">
        <li><a href="index.php?section=home"><i class="fa fa-home"></i>Inicio</a></li>
		<li class="active">Usuarios ingresados</li>
	</ol>
</section>

<section class="content container-fluid">
    <div class="box box-default">
    <div class="box-header with-border">
            <h3 class="box-title">Usuarios registrados</h3>
        </div>

        <div class="box-body">
            <table id="tusers" class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Nombres</th>
                        <th>Apellido paterno</th>
                        <th>Apellido materno</th>
                        <th>Usuario</th>
                        <th>Fecha creación</th>
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
<div class="modal fade" id="userDetail" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">Información de Usuario <small id="u_name"></small></h4>
            </div>
            <div class="modal-body">
                <div class="td-div">
                    <p class="td-div-t">Nombres</p>
                    <p class="td-div-i" id="u_nombres"></p>
                </div>
                <div class="td-div">
                    <p class="td-div-t">Apellido paterno</p>
                    <p class="td-div-i" id="u_ap"></p>
                </div>
                <div class="td-div">
                    <p class="td-div-t">Apellido materno</p>
                    <p class="td-div-i" id="u_am"></p>
                </div>
                <div class="td-div">
                    <p class="td-div-t">E-mail</p>
                    <p class="td-div-i" id="u_email"></p>
                </div>
                <div class="td-div">
                    <p class="td-div-t">Estado</p>
                    <p class="td-div-i" id="u_estado"></p>
                </div>
                <div class="td-div">
                    <p class="td-div-t">Fecha de creación</p>
                    <p class="td-div-i" id="u_fecha"></p>
                </div>
                <div class="td-div">
                    <p class="td-div-t">Grupos de usuario</p>
                    <p class="td-div-i" id="u_perfiles"></p>
                </div>
                <div class="td-div no-bottom">
                    <p class="td-div-t">Foto de perfil</p>
                    <p class="td-div-i" id="u_pic"></p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<script src="admin/users/manage-users.js?v=20190828"></script>