<?php session_start() ?>
<?php $_login = false ?>
<?php $_admin = false ?>
<?php $_calidad = false ?>
<?php $_operador = false ?>
<?php $_autoeval = false ?>
<?php $_acclaboral = false ?>

<?php require("class/classMyDBC.php") ?>
<?php require("class/classVisit.php") ?>
<?php require("src/Random/random.php") ?>
<?php require("src/sessionControl.php") ?>
<?php require("src/fn.php") ?>
<?php $vis = new Visit() ?>
<?php $set_visit = $vis->set($_SERVER['REMOTE_ADDR']) ?>

<?php include("class/classAmbito.php"); ?>
<?php include("class/classFolder.php"); ?>
<?php $a = new Ambito(); ?>
<?php $fo = new Folder(); ?>

<?php extract($_GET) ?>
<?php if (isset($_SESSION['uc_userid'])): ?>
	<?php $_login = true ?>
	<?php if (isset($_SESSION['uc_useradmin']) && $_SESSION['uc_useradmin']): $_admin = true; endif ?>
	<?php if (isset($_SESSION['uc_rol'])): ?>
		<?php foreach ($_SESSION['uc_rol'] as $rol): ?>
			<?php switch ($rol):
				case 2:
					$_calidad = true;
					break;
				case 3:
					$_operador = true;
					break;
				case 4:
					$_autoeval = true;
					break;
				case 5:
					$_acclaboral = true;
					break;
				default:
					break;
			endswitch ?>
		<?php endforeach ?>
	<?php endif ?>
<?php endif ?>

<!DOCTYPE html>

<html lang="es">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Unidad de Calidad y Seguridad del Paciente</title>

	<link rel="apple-touch-icon" sizes="57x57" href="dist/img/favicon/apple-icon-57x57.png">
	<link rel="apple-touch-icon" sizes="60x60" href="dist/img/favicon/apple-icon-60x60.png">
	<link rel="apple-touch-icon" sizes="72x72" href="dist/img/favicon/apple-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="76x76" href="dist/img/favicon/apple-icon-76x76.png">
	<link rel="apple-touch-icon" sizes="114x114" href="dist/img/favicon/apple-icon-114x114.png">
	<link rel="apple-touch-icon" sizes="120x120" href="dist/img/favicon/apple-icon-120x120.png">
	<link rel="apple-touch-icon" sizes="144x144" href="dist/img/favicon/apple-icon-144x144.png">
	<link rel="apple-touch-icon" sizes="152x152" href="dist/img/favicon/apple-icon-152x152.png">
	<link rel="apple-touch-icon" sizes="180x180" href="dist/img/favicon/apple-icon-180x180.png">
	<link rel="icon" type="image/png" sizes="192x192" href="dist/img/favicon/android-icon-192x192.png">
	<link rel="icon" type="image/png" sizes="32x32" href="dist/img/favicon/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="96x96" href="dist/img/favicon/favicon-96x96.png">
	<link rel="icon" type="image/png" sizes="16x16" href="dist/img/favicon/favicon-16x16.png">
	<link rel="manifest" href="dist/img/favicon/manifest.json">
	<meta name="msapplication-TileColor" content="#ffffff">
	<meta name="msapplication-TileImage" content="dist/img/favicon/ms-icon-144x144.png">
	<meta name="theme-color" content="#ffffff">

	<!-- Responsivness -->
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
	<!-- DataTables -->
	<link rel="stylesheet" href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
	<link rel="stylesheet" href="bower_components/datatables.net-buttons-bs/css/buttons.bootstrap.min.css">
	<!-- Font Awesome -->
	<link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
	<!-- Ionicons -->
	<link rel="stylesheet" href="bower_components/Ionicons/css/ionicons.min.css">
	<!-- daterange picker -->
	<link rel="stylesheet" href="bower_components/bootstrap-daterangepicker/daterangepicker.css">
	<!-- bootstrap datepicker -->
	<link rel="stylesheet" href="bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
	<!-- MultiFile -->
	<link rel="stylesheet" href="bower_components/multifile/jquery.MultiFile.css">
	<!-- SweetAlert -->
	<link rel="stylesheet" href="bower_components/sweetalert2/dist/sweetalert2.css">
	<!-- Noty -->
	<link rel="stylesheet" href="bower_components/noty/lib/noty.css">
	<!-- iCheck -->
	<link rel="stylesheet" href="plugins/iCheck/all.css">
	<!-- lightGallery -->
	<link rel="stylesheet" href="bower_components/lightgallery/dist/css/lightgallery.css">
	<!-- Theme style -->
	<link rel="stylesheet" href="dist/css/SISCal.css?v=20191024">
	<link rel="stylesheet" href="dist/css/skins/skin-yellow-light.min.css">

	<!-- jQuery 3 -->
	<script src="bower_components/jquery/dist/jquery.min.js"></script>
	<!-- Google Font -->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>


<body class="hold-transition skin-yellow-light sidebar-mini fixed">
<div class="wrapper">

	<header class="main-header">
		<a href="index.php" class="logo">
			<span class="logo-mini"><b>C</b>SP</span>
			<span class="logo-lg">
				<strong>CyS</strong> del <strong>P</strong>aciente
			</span>
		</a>

		<nav class="navbar navbar-static-top" role="navigation">
			<a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
				<span class="sr-only">Toggle navigation</span>
			</a>

			<div class="navbar-custom-menu">
				<ul class="nav navbar-nav">
					<li>
						<a href="#" id="btn-help">Ayuda</a>
					</li>

					<li>
						<a href="index.php?section=about">Acerca de</a>
					</li>

					<?php if (isset($_SESSION['uc_userid'])): ?>
						<li class="dropdown user user-menu">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">
								<img src="dist/img/<?php echo $_SESSION['uc_userpic'] ?>" class="user-image" alt="User Image">
								<span class="hidden-xs"><?php echo $_SESSION['uc_userfname'] . ' ' . $_SESSION['uc_userlnamep'] ?></span>
							</a>
							<ul class="dropdown-menu">
								<li class="user-header">
									<img src="dist/img/<?php echo $_SESSION['uc_userpic'] ?>" class="img-circle" alt="User Image">

									<p>
										<?php echo $_SESSION['uc_userfname'] . ' ' . $_SESSION['uc_userlnamep'] ?>
										<small><?php echo $_SESSION['uc_usergroup'] ?></small>
									</p>
								</li>

								<li class="user-footer">
									<div class="row">
										<div class="col-sm-12">
											<div class="pull-left">
												<a href="index.php?section=adminusers&sbs=editprofile" class="btn btn-default btn-flat"><i class="fa fa-user"></i> Ver perfil</a>
											</div>
											<div class="pull-right">
												<a href="index.php?section=adminusers&sbs=changepass" class="btn btn-default btn-flat"><i class="fa fa-key"></i> Cambiar contraseña</a>
											</div>
										</div>
									</div>
								</li>

								<li class="user-footer">
									<button type="button" id="btn-logout" class="btn btn-danger btn-flat btn-block">
										<i class="fa fa-power-off"></i> Salir
									</button>
								</li>
							</ul>
						</li>
					<?php else: ?>
						<li class="dropdown user user-menu">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">
								<i class="fa fa-sign-in"></i> Acceso
							</a>
							<ul class="dropdown-menu">
								<li class="user-header">
									<img src="dist/img/users/no-photo.png" class="img-circle" alt="User Image">
									<p>Acceso de usuarios</p>
								</li>

								<form role="form" id="formLogin">
									<li class="user-header">
										<div class="row">
											<div class="form-group col-sm-offset-1 col-sm-10">
												<input type="text" class="form-control" id="inputUser" placeholder="Usuario" required>
											</div>
										</div>

										<div class="row">
											<div class="form-group col-sm-offset-1 col-sm-10">
												<input type="password" class="form-control" id="inputPassword" placeholder="Contraseña" required>
											</div>
										</div>

										<div class="col-sm-offset-1 col-sm-10" id="login-error"></div>
									</li>

									<li class="user-footer">
										<div class="text-center">
											<a class="btn btn-default btn-flat btn-sm" href="index.php?section=forgotpass">Olvidé mi contraseña</a>
										</div>
									</li>

									<li class="user-footer">
										<button type="submit" class="btn btn-danger btn-flat btn-block">
											<i class="fa fa-sign-in"></i> Ingresar
										</button>
									</li>
								</form>
							</ul>
						</li>
					<?php endif ?>
				</ul>
			</div>
		</nav>
	</header>

	<aside class="main-sidebar">

		<section class="sidebar">

			<ul class="sidebar-menu" data-widget="tree">
				<li class="header">PRINCIPAL</li>
				<li <?php if (!isset($section) or $section == 'home' or $section == 'adminusers' or $section == 'forgotpass'): ?> class="active"<?php endif ?>>
					<a href="index.php?section=home">
						<i class="fa fa-home"></i> <span>Inicio</span>
					</a>
				</li>

				<?php if ($_login and !$_operador and !$_autoeval): ?>
					<li class="treeview<?php if (isset($section) and $section == 'files' and $sid < 9): ?> active<?php endif; ?>">
						<?php $amb = $a->getClinicos() ?>
						<a href="#">
							<i class="fa fa-chevron-down"></i>
							<span class="menu-item">Servicios Clínicos</span>
							<span class="pull-right-container">
							<i class="fa fa-angle-left pull-right"></i>
						</span>
						</a>
						<ul class="treeview-menu">
							<?php foreach ($amb as $am): ?>
								<?php $subam = $a->getChildren($am->amb_id) ?>
								<?php foreach ($subam as $aux => $sam): ?>
									<li <?php if (isset($sid) and $sid == $sam->samb_id): ?> class="active"<?php endif ?>>
										<a href="index.php?section=files&sid=<?php echo $sam->samb_id ?>">
											<i class="fa fa-circle-o text-orange"></i>
											<span class="menu-item"><small><?php echo $sam->samb_sigla ?></small> <?php echo $sam->samb_nombre ?></span>
										</a>
									</li>
								<?php endforeach ?>
							<?php endforeach ?>
						</ul>
					</li>

					<?php $amb = $a->getApoyo() ?>
					<li class="treeview<?php if (isset($section) and $section == 'files' and $sid > 8): ?> active<?php endif; ?>">
						<a href="#">
							<i class="fa fa-chevron-down"></i>
							<span class="menu-item">Servicios de Apoyo Diagnóstico/Terapéutico</span>
							<span class="pull-right-container">
							<i class="fa fa-angle-left pull-right"></i>
						</span>
						</a>
						<ul class="treeview-menu">
							<?php foreach ($amb as $am): ?>
								<?php $subam = $a->getChildren($am->amb_id) ?>
								<?php foreach ($subam as $aux => $sam): ?>
									<li <?php if (isset($sid) and $sid == $sam->samb_id): ?> class="active"<?php endif ?>>
										<a href="index.php?section=files&sid=<?php echo $sam->samb_id ?>">
											<i class="fa fa-circle-o text-orange"></i>
											<span class="menu-item"><small><?php echo $sam->samb_sigla ?></small> <?php echo $sam->samb_nombre ?></span>
										</a>
									</li>
								<?php endforeach ?>
							<?php endforeach ?>
						</ul>
					</li>
				<?php endif ?>

				<li <?php if (isset($section) and $section == 'verif-points'): ?> class="active"<?php endif; ?>>
					<a href="index.php?section=verif-points">
						<i class="fa fa-flag"></i>
						<span class="menu-item">Puntos de Verificación</span>
					</a>
				</li>

				<?php $fol = $fo->getMain() ?>
				<?php foreach ($fol as $folder): ?>
					<li class="treeview<?php if (isset($section) and $section == 'other-files'): ?> active<?php endif; ?>">
						<a href="#">
							<i class="fa fa-folder-open"></i>
							<span><?php echo $folder->fol_nombre ?></span>
							<span class="pull-right-container">
							<i class="fa fa-angle-left pull-right"></i>
						</span>
						</a>
						<ul class="treeview-menu">
							<?php $subfol = $fo->getChildren($folder->fol_id) ?>
							<?php foreach ($subfol as $aux => $sfl): ?>
								<li <?php if (isset($sfid) and $sfid == $sfl->fol_id): ?> class="active"<?php endif ?>>
									<?php if ($sfl->fol_privado and (!$_admin and !$_calidad and !$_autoeval)) continue ?>
									<a href="index.php?section=other-files&sfid=<?php echo $sfl->fol_id ?>">
										<span class="fa fa-circle-o text-orange"></span>
										<span class="menu-item"><?php echo $sfl->fol_nombre ?></span>
									</a>
								</li>
							<?php endforeach ?>
						</ul>
					</li>
				<?php endforeach ?>

				<?php if ($_admin or $_calidad or $_autoeval): ?>
					<li class="treeview<?php if (isset($section) and $section == 'autoeval'): ?> active<?php endif; ?>">
						<a href="#">
							<i class="fa fa-check-square-o"></i>
							<span>Autoevaluación</span>
							<span class="pull-right-container">
							<i class="fa fa-angle-left pull-right"></i>
						</span>
						</a>
						<ul class="treeview-menu">
							<?php if ($_admin or $_calidad): ?>
								<li <?php if (isset($sbs) and $sbs == 'newmedible'): ?> class="active"<?php endif ?>>
									<a href="index.php?section=autoeval&sbs=newmedible">
										<i class="fa fa-circle-o text-orange"></i>
										<span class="menu-item">Ingreso de adicionales</span>
									</a>
								</li>
								<li <?php if (isset($sbs) and $sbs == 'managemedibles'): ?> class="active"<?php endif ?>>
									<a href="index.php?section=autoeval&sbs=managemedibles">
										<span class="fa fa-circle-o text-orange"></span>
										<span class="menu-item">Adicionales registrados</span>
									</a>
								</li>
								<li <?php if (isset($sbs) and $sbs == 'newindicator'): ?> class="active"<?php endif ?>>
									<a href="index.php?section=autoeval&sbs=newindicator">
										<span class="fa fa-circle-o text-orange"></span>
										<span class="menu-item">Ingreso de indicador de autoevaluación</span>
									</a>
								</li>
								<li <?php if (isset($sbs) and $sbs == 'manageindicators'): ?> class="active"<?php endif ?>>
									<a href="index.php?section=autoeval&sbs=manageindicators">
										<span class="fa fa-circle-o text-orange"></span>
										<span class="menu-item">Indicadores de autoevaluación registrados</span>
									</a>
								</li>
							<?php endif ?>
							<li <?php if (isset($sbs) and $sbs == 'newvaluesindicator'): ?> class="active"<?php endif ?>>
								<a href="index.php?section=autoeval&sbs=newvaluesindicator">
									<span class="fa fa-circle-o text-orange"></span>
									<span class="menu-item">Ingreso de valores para indicador</span>
								</a>
							</li>
							<li <?php if (isset($sbs) and $sbs == 'newauto'): ?> class="active"<?php endif ?>>
								<a href="index.php?section=autoeval&sbs=newauto">
									<span class="fa fa-circle-o text-orange"></span>
									<span class="menu-item">Ingreso de reporte de autovaluación</span>
								</a>
							</li>
							<li <?php if (isset($sbs) and $sbs == 'manageauto'): ?> class="active"<?php endif ?>>
								<a href="index.php?section=autoeval&sbs=manageauto">
									<span class="fa fa-circle-o text-orange"></span>
									<span class="menu-item">Reportes de autovaluación registrados</span>
								</a>
							</li>
							<li <?php if (isset($sbs) and $sbs == 'generatereport'): ?> class="active"<?php endif ?>>
								<a href="index.php?section=autoeval&sbs=generatereport">
									<span class="fa fa-circle-o text-orange"></span>
									<span class="menu-item">Exportación de autoevaluación por servicio</span>
								</a>
							</li>
							<li <?php if (isset($sbs) and $sbs == 'generatereportbychar'): ?> class="active"<?php endif ?>>
								<a href="index.php?section=autoeval&sbs=generatereportbychar">
									<span class="fa fa-circle-o text-orange"></span>
									<span class="menu-item">Exportación de autoevaluación por características</span>
								</a>
							</li>
						</ul>
					</li>
				<?php endif ?>

				<?php if ($_login): ?>
					<li class="treeview<?php if (isset($section) and $section == 'adv-event'): ?> active<?php endif; ?>">
						<a href="#">
							<i class="fa fa-calendar-times-o"></i>
							<span class="menu-item">Eventos Adversos</span>
							<span class="pull-right-container">
								<i class="fa fa-angle-left pull-right"></i>
							</span>
						</a>
						<ul class="treeview-menu">
							<li <?php if (isset($sbs) and $sbs == 'createevent'): ?> class="active"<?php endif ?>>
								<a href="index.php?section=adv-event&sbs=createevent">
									<i class="fa fa-circle-o text-orange"></i>
									<span class="menu-item">Ingreso de evento</span>
								</a>
							</li>
							<li <?php if (isset($sbs) and $sbs == 'viewevents'): ?> class="active"<?php endif ?>>
								<a href="index.php?section=adv-event&sbs=viewevents">
									<i class="fa fa-circle-o text-orange"></i>
									<span class="menu-item">Eventos registrados</span>
								</a>
							</li>
							<?php if ($_admin or $_calidad or $_SESSION['uc_userid'] == 74): ?>
								<li <?php if (isset($sbs) and $sbs == 'eventsteril'): ?> class="active"<?php endif ?>>
									<a href="index.php?section=adv-event&sbs=eventsteril">
										<i class="fa fa-circle-o text-orange"></i>
										<span class="menu-item">Eventos de Esterilización</span>
									</a>
								</li>
							<?php endif ?>
							<li <?php if (isset($sbs) and $sbs == 'exportevent'): ?> class="active"<?php endif ?>>
								<a href="index.php?section=adv-event&sbs=exportevent">
									<i class="fa fa-circle-o text-orange"></i>
									<span class="menu-item">Exportación de eventos individuales</span>
								</a>
							</li>
						</ul>
					</li>
				<?php endif ?>

				<?php if ($_login): ?>
					<li class="treeview<?php if (isset($section) and $section == 'tec-event'): ?> active<?php endif; ?>">
						<a href="#">
							<i class="fa fa-calendar-check-o"></i>
							<span class="menu-item">Tecnovigilancia</span>
							<span class="pull-right-container">
								<i class="fa fa-angle-left pull-right"></i>
							</span>
						</a>
						<ul class="treeview-menu">
							<li <?php if (isset($sbs) and $sbs == 'createtecnoevent'): ?> class="active"<?php endif ?>>
								<a href="index.php?section=tec-event&sbs=createtecnoevent">
									<i class="fa fa-circle-o text-orange"></i>
									<span class="menu-item">Ingreso de evento</span>
								</a>
							</li>
							<li <?php if (isset($sbs) and $sbs == 'viewtecnoevents'): ?> class="active"<?php endif ?>>
								<a href="index.php?section=tec-event&sbs=viewtecnoevents">
									<i class="fa fa-circle-o text-orange"></i>
									<span class="menu-item">Eventos registrados</span>
								</a>
							</li>
							<li <?php if (isset($sbs) and $sbs == 'createdivevent'): ?> class="active"<?php endif ?>>
								<a href="index.php?section=tec-event&sbs=createdivevent">
									<i class="fa fa-circle-o text-orange"></i>
									<span class="menu-item">Ingreso de evento DIV</span>
								</a>
							</li>
							<li <?php if (isset($sbs) and $sbs == 'viewdivevents'): ?> class="active"<?php endif ?>>
								<a href="index.php?section=tec-event&sbs=viewdivevents">
									<i class="fa fa-circle-o text-orange"></i>
									<span class="menu-item">Eventos DIV registrados</span>
								</a>
							</li>
						</ul>
					</li>
				<?php endif ?>

				<?php if ($_admin or $_calidad or $_acclaboral): ?>
					<li class="treeview<?php if (isset($section) and $section == 'tec-event'): ?> active<?php endif; ?>">
						<a href="#">
							<i class="fa fa-exclamation-triangle"></i>
							<span class="menu-item">Accidentes Laborales</span>
							<span class="pull-right-container">
								<i class="fa fa-angle-left pull-right"></i>
							</span>
						</a>
						<ul class="treeview-menu">
							<li <?php if (isset($sbs) and $sbs == 'createacc'): ?> class="active"<?php endif ?>>
								<a href="index.php?section=acc-laboral&sbs=createacc">
									<i class="fa fa-circle-o text-orange"></i>
									<span class="menu-item">Ingreso de accidente</span>
								</a>
							</li>
							<li <?php if (isset($sbs) and $sbs == 'viewacc'): ?> class="active"<?php endif ?>>
								<a href="index.php?section=acc-laboral&sbs=manageacc">
									<i class="fa fa-circle-o text-orange"></i>
									<span class="menu-item">Accidentes registrados</span>
								</a>
							</li>
						</ul>
					</li>
				<?php endif ?>

				<li <?php if (isset($section) and $section == 'search-files'): ?> class="active"<?php endif; ?>>
					<a href="index.php?section=search-files">
						<i class="fa fa-search"></i> <span class="menu-item">Búsqueda de Documentos</span>
					</a>
				</li>

				<li <?php if (isset($section) and $section == 'media'): ?> class="active"<?php endif; ?>>
					<a href="index.php?section=media">
						<i class="fa fa-microphone"></i>
						<span class="menu-item">Multimedia</span>
					</a>
				</li>

				<li <?php if (isset($section) and $section == 'covid'): ?> class="active"<?php endif; ?>>
					<a href="index.php?section=covid">
						<i class="fa fa-book"></i>
						<span class="menu-item">Capacitación COVID-19</span>
					</a>
				</li>

				<?php if ($_admin): ?>
					<li class="header">PANEL DE CONTROL</li>
					<li class="treeview<?php if (isset($section) and $section == 'users'): ?> active<?php endif ?>">
						<a href="#">
							<i class="fa fa-user-o"></i>
							<span>Usuarios</span>
							<span class="pull-right-container">
								<i class="fa fa-angle-left pull-right"></i>
							</span>
						</a>
						<ul class="treeview-menu">
							<li <?php if (isset($sbs) and $sbs == 'createuser'): ?> class="active"<?php endif ?>>
								<a href="index.php?section=users&sbs=createuser">
									<i class="fa fa-circle-o text-aqua"></i>Creación de Usuarios
								</a>
							</li>
							<li <?php if (isset($sbs) and $sbs == 'manageusers'): ?> class="active"<?php endif ?>>
								<a href="index.php?section=users&sbs=manageusers">
									<i class="fa fa-circle-o text-aqua"></i>Ver Usuarios Creados
								</a>
							</li>
						</ul>
					</li>

					<li class="treeview<?php if (isset($section) and $section == 'admin'): ?> active<?php endif ?>">
						<a href="#">
							<i class="fa fa-copy"></i>
							<span>Documentos</span>
							<span class="pull-right-container">
								<i class="fa fa-angle-left pull-right"></i>
							</span>
						</a>
						<ul class="treeview-menu">
							<li <?php if (isset($sbs) and $sbs == 'verifdoc'): ?> class="active"<?php endif ?>>
								<a href="index.php?section=admin&sbs=verifdoc">
									<i class="fa fa-circle-o text-aqua"></i>Crear Documento Acreditación
								</a>
							</li>
							<li <?php if (isset($sbs) and $sbs == 'otherdoc'): ?> class="active"<?php endif ?>>
								<a href="index.php?section=admin&sbs=otherdoc">
									<i class="fa fa-circle-o text-aqua"></i>Crear Otro Documento
								</a>
							</li>
							<li <?php if (isset($sbs) and $sbs == 'managefiles'): ?> class="active"<?php endif ?>>
								<a href="index.php?section=admin&sbs=managefiles">
									<i class="fa fa-circle-o text-aqua"></i>Ver Documentos Registrados
								</a>
							</li>
						</ul>
					</li>

					<li class="treeview<?php if (isset($section) and $section == 'folders'): ?> active<?php endif ?>">
						<a href="#">
							<i class="fa fa-folder-open-o"></i>
							<span>Directorios</span>
							<span class="pull-right-container">
								<i class="fa fa-angle-left pull-right"></i>
							</span>
						</a>
						<ul class="treeview-menu">
							<li <?php if (isset($sbs) and $sbs == 'createfolder'): ?> class="active"<?php endif ?>>
								<a href="index.php?section=folders&sbs=createfolder">
									<i class="fa fa-circle-o text-aqua"></i>Creación de Directorios
								</a>
							</li>
							<li <?php if (isset($sbs) and $sbs == 'managefolders'): ?> class="active"<?php endif ?>>
								<a href="index.php?section=folders&sbs=managefolders">
									<i class="fa fa-circle-o text-aqua"></i>Ver Directorios Creados
								</a>
							</li>
						</ul>
					</li>
				<?php endif ?>
			</ul>
		</section>
	</aside>

	<div class="content-wrapper main">
		<?php include('src/routes.php'); ?>
	</div>
</div>

<!-- REQUIRED JS SCRIPTS -->
<!-- Bootstrap 3.3.7 -->
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- DataTables -->
<script src="bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="bower_components/jszip/dist/jszip.min.js"></script>
<script src="bower_components/pdfmake/build/pdfmake.min.js"></script>
<script src="bower_components/pdfmake/build/vfs_fonts.js"></script>
<script src="bower_components/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
<script src="bower_components/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="bower_components/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
<!-- jQueryForm -->
<script src="bower_components/jquery-form/dist/jquery.form.min.js"></script>
<!-- AutoComplete -->
<script src="bower_components/devbridge-autocomplete/dist/jquery.autocomplete.min.js"></script>
<!-- date-range-picker -->
<script src="bower_components/moment/min/moment.min.js"></script>
<script src="bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<!-- bootstrap datepicker -->
<script src="bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script src="bower_components/bootstrap-datepicker/dist/locales/bootstrap-datepicker.es.min.js"></script>
<!-- SweetAlert -->
<script src="bower_components/sweetalert2/dist/sweetalert2.min.js"></script>
<!-- Noty -->
<script src="bower_components/noty/lib/noty.js"></script>
<!-- CKEditor -->
<script src="bower_components/ckeditor/ckeditor.js"></script>
<!-- Slimscroll -->
<script src="bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="bower_components/fastclick/lib/fastclick.js"></script>
<!-- MultiFile -->
<script src="bower_components/multifile/jquery.MultiFile.min.js"></script>
<!-- iCheck -->
<script src="plugins/iCheck/icheck.min.js"></script>
<!-- lightGallery -->
<script src="bower_components/lightgallery/dist/js/lightgallery.js"></script>
<script src="bower_components/lightgallery/modules/lg-thumbnail.min.js"></script>
<script src="bower_components/lightgallery/modules/lg-fullscreen.min.js"></script>
<!-- SISCal App -->
<script src="dist/js/siscal.min.js"></script>
<script src="dist/js/jquery.Rut.min.js"></script>
<script src="dist/js/fn.js?v=20190828"></script>
<script src="dist/js/index.js?v=20190828"></script>
</body>
</html>