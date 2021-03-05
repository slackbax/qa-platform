<?php $interval = 3;
$last_f = 8; ?>
<?php include("class/classFile.php") ?>
<?php include("class/classSubPuntoVerificacion.php") ?>
<?php $vs = new Visit() ?>
<?php $fl = new File() ?>
<?php $spv = new SubPuntoVerificacion() ?>

<div class="row">
	<div class="col-lg-8">
		<section class="content-header">
			<div class="callout">
				<h2 class="text-orange"><i class="fa fa-check"></i> <small>Bienvenido
						<?php if (isset($_SESSION['uc_userid'])): ?>
							<?php echo '(a),</small>' ?>
							<?php echo $_SESSION['uc_userfname'] ?>
						<?php else: echo '</small>' ?>
						<?php endif ?>
				</h2>
				<h4>A la Plataforma de información de la Unidad de Calidad del Hospital Regional Guillermo Grant Benavente.</h4>
			</div>
		</section>

		<section class="content container-fluid">
			<?php if (isset($timeout) and $timeout == 1): ?>
				<div class="alert alert-danger">
					<h4><i class="fa fa-warning"></i> Atención!</h4>
					Su sesión ha finalizado por inactividad. Por favor, ingrese sus datos nuevamente para reanudarla.
				</div>

			<?php endif ?>
			<div class="row">
				<?php $nf = $fl->getNumber() ?>
				<div class="col-lg-4 col-lg-offset-2 col-sm-6">
					<div class="small-box bg-aqua">
						<div class="inner">
							<h3><?php echo $nf ?></h3>

							<p>Documentos</p>
						</div>
						<div class="icon">
							<i class="ion ion-stats-bars"></i>
						</div>
						<a class="small-box-footer" href="index.php?section=search-files">
							Más info
							<i class="fa fa-arrow-circle-right"></i>
						</a>
					</div>
				</div>

				<?php $nv = $spv->getNumber() ?>
				<div class="col-lg-4 col-sm-6">
					<div class="small-box bg-green">
						<div class="inner">
							<h3><?php echo $nv ?></h3>

							<p>Puntos de Verificación</p>
						</div>
						<div class="icon">
							<i class="ion ion-flag"></i>
						</div>
						<a class="small-box-footer" href="index.php?section=verif-points">
							Más info
							<i class="fa fa-arrow-circle-right"></i>
						</a>
					</div>
				</div>
			</div>

			<!--
			<div class="row text-center">
				<div class="col-lg-8 col-lg-offset-2 col-sm-10 col-sm-offset-1">
					<a href="index.php?section=media"><img class="img-responsive" alt="Banner Acreditacion 2020" src="dist/img/banner_acreditacion.jpg"></a>
				</div>
			</div>
			<div class="row text-center text-red" style="margin-bottom: 20px">
				<div class="col-lg-8 col-lg-offset-2 col-sm-10 col-sm-offset-1">
					<div class="row" style="background: #94c9da; margin: 0; padding-bottom: 10px">
						<div class="col-xs-2 col-xs-offset-2"><h2 id="counter-d" class="text-bold" style="margin-top: 0"><i class="fa fa-refresh fa-spin"></i></h2></div>
						<div class="col-xs-2"><h2 id="counter-h" class="text-bold" style="margin-top: 0"><i class="fa fa-refresh fa-spin"></i></h2></div>
						<div class="col-xs-2"><h2 id="counter-m" class="text-bold" style="margin-top: 0"><i class="fa fa-refresh fa-spin"></i></h2></div>
						<div class="col-xs-2"><h2 id="counter-s" class="text-bold" style="margin-top: 0"><i class="fa fa-refresh fa-spin"></i></h2></div>
						<div class="col-xs-2 col-xs-offset-2"><span class="text-xs">DIAS</span></div>
						<div class="col-xs-2"><span class="text-xs">HORAS</span></div>
						<div class="col-xs-2"><span class="text-xs">MINUTOS</span></div>
						<div class="col-xs-2"><span class="text-xs">SEGUNDOS</span></div>
					</div>
					<div class="row" style="background: #94c9da; margin: 0; padding-bottom: 5px">
						<h5>09 de Marzo de 2020</h5>
					</div>
				</div>
			</div>
			-->

			<div class="box box-warning">
				<div class="box-header with-border">
					<h3 class="box-title">Últimas actualizaciones de normativas</h3>
				</div>

				<div class="box-body">
					<?php $lf = $fl->getLast($last_f) ?>
					<table id="tlfiles" class="table table-striped table-condensed">
						<thead>
						<tr>
							<th></th>
							<th>Nombre</th>
							<th>Fecha</th>
						</tr>
						</thead>

						<tbody>
						<?php foreach ($lf as $aux => $f): ?>
							<tr>
								<td><i class="fa fa-file-<?php echo getExtension($f->arc_ext) ?>-o text-<?php echo getColorExt($f->arc_ext) ?> icon-table"></i></td>
								<td><a href="<?php echo $f->arc_path ?>" target="_blank"><?php echo $f->arc_sigla . ' ' . $f->arc_cod . ' - ' . $f->arc_nombre ?></a></td>
								<td><?php echo getDateToForm($f->arc_fecha) ?></td>
							</tr>
						<?php endforeach ?>
						</tbody>
					</table>
				</div>
			</div>

			<div class="box box-danger box-solid">
				<div class="box-header">
					<h3 class="box-title">Documentos por vencer</h3>
				</div>

				<div class="box-body">
					<?php if (count($fl->getExpiring($interval)) > 0): ?>
						<?php $file = $fl->getExpiring($interval) ?>

						<table id="tfiles" class="table table-striped table-condensed">
							<thead>
							<tr>
								<th>Nombre</th>
								<th class="text-center">Vigencia</th>
							</tr>
							</thead>

							<tbody>
							<?php foreach ($file as $aux => $f): ?>
								<tr>
									<td><?php echo $f->arc_sigla . ' ' . $f->arc_cod . ' - ' . $f->arc_nombre ?></td>
									<td class="text-center"><?php echo getMonthDate($f->arc_fecha_vig) ?></td>
								</tr>
							<?php endforeach ?>
							</tbody>
						</table>
					<?php else: ?>
						No hay documentos por vencer.
					<?php endif ?>
				</div>
			</div>
		</section>
	</div>

	<div class="col-lg-4">
		<section class="content container-fluid">
			<div class="box box-warning widget-user-team">
				<div class="box-header with-border">
					<h3 class="box-title">Nuestro equipo</h3>
				</div>
			</div>

			<div class="box box-widget widget-user-2 widget-user-team">
				<div class="widget-user-header bg-white">
					<div class="widget-user-image">
						<img class="img-circle" src="dist/img/users/claudia-munoz.jpg">
					</div>
					<div class="widget-user-username">Claudia Muñoz Hernández</div>
					<div class="widget-user-desc">Jefa (S) de Unidad de Calidad y Acreditación</div>
					<p class="widget-user-desc ic-data email"><a href="mailto:cmunoz@ssconcepcion.cl">cmunoz@ssconcepcion.cl</a></p>
					<p class="widget-user-desc ic-data phone">417996</p>
				</div>
			</div>

			<div class="box box-widget widget-user-2 widget-user-team">
				<div class="widget-user-header bg-white">
					<div class="widget-user-image">
						<img class="img-circle" src="dist/img/users/nestor-duarte.jpg">
					</div>
					<div class="widget-user-username">Néstor Duarte Farías</div>
					<div class="widget-user-desc">Ingeniero Civil Biomédico</div>
					<p class="widget-user-desc ic-data email"><a href="mailto:nduarte@ssconcepcion.cl">nduarte@ssconcepcion.cl</a></p>
					<p class="widget-user-desc ic-data phone">417668</p>
				</div>
			</div>

			<div class="box box-widget widget-user-2 widget-user-team">
				<div class="widget-user-header bg-white">
					<div class="widget-user-image">
						<img class="img-circle" src="dist/img/users/constanza-moncada.jpg">
					</div>
					<div class="widget-user-username">Constanza Moncada Soto</div>
					<div class="widget-user-desc">Enfermera</div>
					<p class="widget-user-desc ic-data email"><a href="mailto:c.moncada@ssconcepcion.cl">c.moncada@ssconcepcion.cl</a></p>
					<p class="widget-user-desc ic-data phone">417668</p>
				</div>
			</div>

			<div class="box box-widget widget-user-2 widget-user-team">
				<div class="widget-user-header bg-white">
					<div class="widget-user-image">
						<img class="img-circle" src="dist/img/users/paula-torres.jpg">
					</div>
					<div class="widget-user-username">Paula Torres Retamal</div>
					<div class="widget-user-desc">Enfermera</div>
					<p class="widget-user-desc ic-data email"><a href="mailto:paula.torres@ssconcepcion.cl">paula.torres@ssconcepcion.cl</a></p>
					<p class="widget-user-desc ic-data phone">417668</p>
				</div>
			</div>

			<div class="box box-widget widget-user-2 widget-user-team">
				<div class="widget-user-header bg-white">
					<div class="widget-user-image">
						<img class="img-circle" src="dist/img/users/andrea-ibacache.jpg">
					</div>
					<div class="widget-user-username">Andrea Ibacache Ravanal</div>
					<div class="widget-user-desc">Enfermera</div>
					<p class="widget-user-desc ic-data email"><a href="mailto:aibacache@ssconcepcion.cl">aibacache@ssconcepcion.cl</a></p>
					<p class="widget-user-desc ic-data phone">413117</p>
				</div>
			</div>

			<div class="box box-widget widget-user-2 widget-user-team">
				<div class="widget-user-header bg-white">
					<div class="widget-user-image">
						<img class="img-circle" src="dist/img/users/leila-vielma.jpg">
					</div>
					<div class="widget-user-username">Leila Vielma Aedo</div>
					<div class="widget-user-desc">Enfermera</div>
					<p class="widget-user-desc ic-data email"><a href="mailto:leilavielma@ssconcepcion.cl">leilavielma@ssconcepcion.cl</a></p>
					<p class="widget-user-desc ic-data phone">412997</p>
				</div>
			</div>

			<div class="box box-widget widget-user-2 widget-user-team">
				<div class="widget-user-header bg-white">
					<div class="widget-user-image">
						<img class="img-circle" src="dist/img/users/no-photo.png">
					</div>
					<div class="widget-user-username">Carol Aillón Vidal</div>
					<div class="widget-user-desc">Enfermera</div>
					<p class="widget-user-desc ic-data email"><a href="mailto:francisca.vigueras@ssconcepcion.cl">francisca.vigueras@ssconcepcion.cl</a></p>
					<p class="widget-user-desc ic-data phone">417668</p>
				</div>
			</div>

			<div class="box box-widget widget-user-2">
				<div class="widget-user-header bg-white">
					<div class="widget-user-image">
						<img class="img-circle" src="dist/img/users/elizabeth-briones.jpg">
					</div>
					<div class="widget-user-username">Elizabeth Briones Cuevas</div>
					<div class="widget-user-desc">Secretaria</div>
					<p class="widget-user-desc ic-data email"><a href="mailto:secrecalidad@ssconcepcion.cl">secrecalidad@ssconcepcion.cl</a></p>
					<p class="widget-user-desc ic-data phone">417668</p>
				</div>
			</div>

			<div class="row">
				<div class="col-xs-12">
					<div class="info-box">
						<span class="info-box-icon bg-green-active">
							<i class="ion ion-ios-people-outline"></i>
						</span>
						<div class="description-block no-margin">
							<h5 class="description-header description-header-info-box"><?php echo number_format($vs->getNumberToday()) ?></h5>
							<span class="description-text">Visitas hoy</span>
							<h5 class="description-header description-header-info-box"><?php echo number_format($vs->getNumberTotal()) ?></h5>
							<span class="description-text">Visitas totales</span>
						</div>
					</div>
				</div>
			</div>
		</section>
	</div>
</div>

<script src="main/main-index.js?v=20190828"></script>