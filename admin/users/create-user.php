<?php include("class/classGroup.php") ?>
<?php $gr = new Group() ?>
<?php $group = $gr->getAll() ?>

<section class="content-header">
	<h1>Panel de Control
		<small><i class="fa fa-angle-right"></i> Creación de Usuario</small>
	</h1>

	<ol class="breadcrumb">
        <li><a href="index.php?section=home"><i class="fa fa-home"></i>Inicio</a></li>
		<li class="active">Creación de usuario</li>
	</ol>
</section>

<section class="content container-fluid">
    <form role="form" id="formNewUser">
        <p class="bg-class bg-danger">Los campos marcados con (*) son obligatorios</p>

        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title">Información del archivo</h3>
            </div>

            <div class="box-body">
                <div class="row">
                    <div class="form-group col-xs-6">
                        <label for="iname">Nombres</label>
                        <input type="text" class="form-control" id="iname" name="iname" placeholder="Ingrese nombres del usuario" required>
                    </div>

                    <div class="form-group col-xs-6">
                        <label for="ilastnamep">Apellido Paterno</label>
                        <input type="text" class="form-control" id="ilastnamep" name="ilastnamep" placeholder="Ingrese apellido paterno" required>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-xs-6">
                        <label for="ilastnamem">Apellido Materno</label>
                        <input type="text" class="form-control" id="ilastnamem" name="ilastnamem" placeholder="Ingrese apellido materno" required>
                    </div>

                    <div class="form-group col-xs-6 has-feedback" id="divEmail">
                        <label for="iemail">Correo Electrónico</label>
                        <input type="text" class="form-control" id="iemail" name="iemail" placeholder="Ingrese e-mail del usuario" required>
                        <i class="fa form-control-feedback" id="iconEmail"></i>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-xs-6 has-feedback" id="divUsername">
                        <label for="iusername">Nombre de Usuario</label>
                        <input type="text" class="form-control" id="iusername" name="iusername" placeholder="Ingrese el nombre de usuario con el que entrará al sistema" maxlength="16" required>
                        <i class="fa form-control-feedback" id="iconUsername"></i>
                    </div>

                    <div class="form-group col-xs-6">
                        <label for="ipassword">Contraseña</label>
                        <input type="text" class="form-control" name="ipassword" id="ipassword" placeholder="Ingrese la contraseña con la que entrará al sistema" maxlength="64" required>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-xs-12">
                        <label for="iuserimage">Imagen de Cuenta</label>
                        <input name="iuserimage[]" class="multi" id="iuserimage" type="file" size="16" accept="gif|jpg|png|jpeg" maxlength="1">
                        <p class="help-block">Formatos admitidos: GIF, JPG, JPEG, PNG</p>
                    </div>
                </div>
            </div>

            <div class="box-header with-border">
                <h3 class="box-title">Grupos de usuario</h3>
            </div>

            <div class="box-body">
                <div class="row">
                    <?php foreach ($group as $g): ?>
                    <div class="form-group col-xs-12">
                        <label class="label-checkbox">
                            <input type="radio" class="minimal" name="iusergroups" id="iusergroups<?php echo $g->gru_id ?>" value="<?php echo $g->gru_id ?>">
                            <?php echo $g->gru_nombre ?>
                        </label>
                    </div>
                    <?php endforeach ?>
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

<script src="admin/users/create-user.js?v=20190828"></script>