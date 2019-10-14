<?php include("class/classUser.php") ?>
<?php include("class/classGroup.php") ?>
<?php $us = new User() ?>
<?php $gr = new Group() ?>
<?php $u = $us->get($id) ?>
<?php $group = $gr->getAll() ?>
<?php $u_g = $us->getGroups($id) ?>

<section class="content-header">
	<h1>Panel de Control
		<small><i class="fa fa-angle-right"></i> Creación de Usuario</small>
	</h1>

	<ol class="breadcrumb">
        <li><a href="index.php?section=home"><i class="fa fa-home"></i>Inicio</a></li>
        <li><a href="index.php?section=users&sbs=manageusers">Usuarios registrados</a></li>
		<li class="active">Edición de usuario</li>
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
                    <div class="form-group col-sm-6">
                        <label for="iname">Nombres</label>
                        <input type="hidden" name="id" value="<?php echo $id ?>">
                        <input type="text" class="form-control" id="iname" name="iname" placeholder="Ingrese nombres del usuario" value="<?php echo $u->us_nombres ?>" required>
                    </div>
                    
                    <div class="form-group col-sm-6">
                        <label for="ilastnamep">Apellido Paterno</label>
                        <input type="text" class="form-control" id="ilastnamep" name="ilastnamep" placeholder="Ingrese apellido paterno" value="<?php echo $u->us_ap ?>" required>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-sm-6">
                        <label for="ilastnamem">Apellido Materno</label>
                        <input type="text" class="form-control" id="ilastnamem" name="ilastnamem" placeholder="Ingrese apellido materno" value="<?php echo $u->us_am ?>" required>
                    </div>
                    <div class="form-group col-sm-6 has-feedback" id="divEmail">
                        <label for="iemail">Correo Electrónico</label>
                        <input type="text" class="form-control" id="iemail" name="iemail" placeholder="Ingrese e-mail del usuario" value="<?php echo $u->us_email ?>" required>
                        <i class="fa form-control-feedback" id="iconEmail"></i>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-sm-6 has-feedback">
                        <label for="iusername">Nombre de Usuario</label>
                        <input type="text" class="form-control" id="iusername" name="iusername" value="<?php echo $u->us_username ?>" disabled>
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="ipassword">Contraseña</label>
                        <input type="text" class="form-control" name="ipassword" id="ipassword" placeholder="Ingrese la contraseña sólo si desea modificar la existente" maxlength="64">
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-sm-6">
                        <label class="label-checkbox">
                            <input type="checkbox" class="minimal" name="iactive"<?php if ($u->us_activo): ?> checked<?php endif ?>> Activo
                        </label>
                    </div>
                    
                    <div class="form-group col-sm-12">
                        <label for="iuserimage">Imagen de Cuenta</label>
                        <div class="controls">
                            <img src="dist/img/<?php echo $u->us_pic ?>" width="100" height="100"><br><br>
                            <input name="iuserimage[]" class="multi" id="iuserimage" type="file" size="16" accept="gif|jpg|png|jpeg" maxlength="1">
                            <p class="help-block">Formatos admitidos: GIF, JPG, JPEG, PNG</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="box-header with-border">
                <h3 class="box-title">Grupos de usuario</h3>
            </div>

            <div class="box-body">
                <div class="row">
                    <?php foreach ($group as $g): ?>
                    <div class="form-group col-sm-12">
                        <label class="label-checkbox">
                            <input type="radio" class="minimal" name="iusergroups" id="iusergroups<?php echo $g->gru_id ?>" value="<?php echo $g->gru_id ?>"<?php foreach ($u_g as $ug): if ($g->gru_id == $ug): ?> checked<?php endif; endforeach ?>>
                            <?php echo $g->gru_nombre ?>
                        </label>
                    </div>
                    <?php endforeach ?>
                </div>
            </div>

            <div class="box-footer">
                <button type="submit" class="btn btn-primary" id="btnsubmit"><i class="fa fa-check"></i> Guardar</button>
                <a href="javascript:history.back()" class="btn btn-default">Volver</a>
                <i class="ajaxLoader fa fa-cog fa-spin" id="submitLoader"></i>
            </div>
        </div>
    </form>
</section>

<script src="admin/users/edit-user.js?v=20190828"></script>