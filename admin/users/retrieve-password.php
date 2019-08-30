<section class="content-header">
	<h1>Menú de Usuario
		<small><i class="fa fa-angle-right"></i> Recuperación de Contraseña</small>
	</h1>

	<ol class="breadcrumb">
        <li><a href="index.php?section=home"><i class="fa fa-home"></i> Inicio</a></li>
		<li class="active">Recuperación de contraseña</li>
	</ol>
</section>

<section class="content container-fluid">
    <form role="form" id="formChangePass">           
        <div class="box box-default">
            <div class="box-body">
                <div class="alert alert-success">
                    <h4>
                        <i class="icon fa fa-check"></i>Ingrese su nombre de usuario y una nueva contraseña será enviada a su correo.
                    </h4>
                    Luego podrá cambiarla en el menú de usuario en la barra superior, si así lo desea.
                </div>

                <div class="row">
                    <div class="form-group col-xs-6 has-feedback" id="gusername">
                        <label for="iusername">Ingrese su nombre de usuario</label>
                        <input type="text" class="form-control input-sm" id="iNusername" name="iusername" placeholder="Ingrese su nombre de usuario" maxlength="16" required>
                        <span class="glyphicon form-control-feedback" id="iconusername"></span>
                    </div>
                </div>
            </div>

            <div class="box-footer">
                <button type="submit" class="btn btn-primary" id="btnsubmit"><i class="fa fa-check"></i> Enviar</button>
                <button type="reset" class="btn btn-default" id="btnClear">Limpiar</button>
                <i class="ajaxLoader fa fa-cog fa-spin" id="submitLoader"></i>
            </div>
        </div>
    </form>
</section>

<script src="admin/users/retrieve-password.js?v=20190828"></script>