<?php $interval = 3;
$last_f = 8; ?>
<?php include("class/classFile.php") ?>
<?php include("class/classSubPuntoVerificacion.php") ?>
<?php $vs = new Visit() ?>
<?php $fl = new File() ?>
<?php $spv = new SubPuntoVerificacion() ?>

<div class="row">
	<div class="col-xs-8">
		<section class="content-header">
			<div class="callout">
				<h2 class="text-orange"><i class="fa fa-check"></i> <small>Bienvenido
						<?php if (isset($_SESSION['uc_userid'])): ?>
							<?php echo '(a),</small>' ?>
							<?php echo $_SESSION['uc_userfname'] ?>
						<?php else: echo '</small>' ?>
						<?php endif ?>
				</h2>
				<h4>A la Plataforma de información de la Subdirección de Calidad del Hospital Regional Guillermo Grant Benavente.</h4>
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
				<div class="col-lg-4 col-lg-offset-2 col-xs-6">
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
				<div class="col-lg-4 col-xs-6">
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
								<td><a href="<?php echo $f->arc_path ?>"><?php echo $f->arc_sigla . ' ' . $f->arc_cod . ' - ' . $f->arc_nombre ?></a></td>
								<td class="t-center"><?php echo getDateToForm($f->arc_fecha) ?></td>
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

	<div class="col-xs-4">
		<section class="content container-fluid">
			<div class="box box-warning">
				<div class="box-header with-border">
					<h3 class="box-title">Nuestro equipo</h3>
				</div>

				<div class="box-body">
					<div class="people-img">
						<img class="image-ver" src="dist/img/users/luis-gatica.jpg">
					</div>
					<strong>Dr. Luis Gatica Norambuena</strong>
					<br>
					- Subdirector de Calidad y Seguridad del Paciente
					<br>
					- Jefe Unidad de Calidad y Acreditación
					<p class="ic-data email"><a href="mailto:lgatica@ssconcepcion.cl">lgatica@ssconcepcion.cl</a></p>
					<p class="ic-data phone">417996</p>
				</div>

				<div class="box-body">
					<div class="people-img">
						<img class="image-ver" src="dist/img/users/claudia-munoz.jpg">
					</div>
					<strong>Claudia Muñoz Hernández</strong>
					<br>
					Jefa de Enfermeras Unidad de Calidad y Acreditación
					<p class="ic-data email"><a href="mailto:cmunoz@ssconcepcion.cl">cmunoz@ssconcepcion.cl</a></p>
					<p class="ic-data phone">412997</p>
				</div>

				<div class="box-body">
					<div class="people-img">
						<img class="image-ver" src="dist/img/users/nestor-duarte.jpg">
					</div>
					<strong>Néstor Duarte Farías</strong>
					<br>
					Ingeniero Civil Biomédico
					<p class="ic-data email"><a href="mailto:nduarte@ssconcepcion.cl">nduarte@ssconcepcion.cl</a></p>
					<p class="ic-data phone">417668</p>
				</div>

				<div class="box-body">
					<div class="people-img">
						<img class="image-ver" src="dist/img/users/constanza-moncada.jpg">
					</div>
					<strong>Constanza Moncada Soto</strong>
					<br>
					Enfermera
					<p class="ic-data email"><a href="mailto:c.moncada@ssconcepcion.com">c.moncada@ssconcepcion.cl</a></p>
					<p class="ic-data phone">413117</p>
				</div>

				<div class="box-body">
					<div class="people-img">
						<img class="image-ver" src="dist/img/users/paula-torres.jpg">
					</div>
					<strong>Paula Torres Retamal</strong>
					<br>
					Enfermera
					<p class="ic-data email"><a href="mailto:paula.torres@ssconcepcion.com">paula.torres@ssconcepcion.cl</a></p>
					<p class="ic-data phone">413117</p>
				</div>

				<div class="box-body">
					<div class="people-img">
						<img class="image-ver" src="dist/img/users/giovanna-nanjari.jpg">
					</div>
					<strong>Giovanna Nanjari Massoglia</strong>
					<br>
					Enfermera
					<p class="ic-data email"><a href="mailto:gnanjari@ssconcepcion.com">gnanjari@ssconcepcion.cl</a></p>
					<p class="ic-data phone">413117</p>
				</div>

				<div class="box-body">
					<div class="people-img">
						<img class="image-ver" src="dist/img/users/elizabeth-briones.jpg">
					</div>
					<strong>Elizabeth Briones Cuevas</strong>
					<br>
					Secretaria
					<p class="ic-data email"><a href="mailto:secrecalidad@ssconcepcion.cl">secrecalidad@ssconcepcion.cl</a></p>
					<p class="ic-data phone">417668</p>
				</div>
			</div>
		</section>
	</div>
</div>

<script src="main/main-index.js?v=20190828"></script>