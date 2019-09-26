<?php $interval = 3;
$last_f = 10; ?>
<?php include("class/classFile.php") ?>
<?php $fl = new File() ?>

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
			<div class="box box-default">
				<div class="box-header with-border">
					<h3 class="box-title">Últimos documentos editados</h3>
				</div>

				<div class="box-body">
					<?php $lf = $fl->getLast($last_f) ?>
					<table id="tlfiles" class="table table-striped table-condensed">
						<thead>
						<tr>
							<th>Nombre</th>
							<th class="t-center">Fecha</th>
						</tr>
						</thead>

						<tbody>
						<?php foreach ($lf as $aux => $f): ?>
							<tr>
								<td>
									<i class="fa fa-file-<?php echo getExtension($f->arc_ext) ?>-o text-<?php echo getColorExt($f->arc_ext) ?> icon-table"></i> <?php echo $f->arc_sigla . ' ' . $f->arc_cod . ' - ' . $f->arc_nombre ?>
								</td>
								<td class="t-center"><?php echo getDateToForm($f->arc_fecha) ?></td>
							</tr>
						<?php endforeach ?>
						</tbody>
					</table>
				</div>
			</div>

			<div class="box box-widget">
				<div class="box-header with-border">
					<div class="user-block">
						<span class="news-title">Boletín de acreditación N° 4</span>
						<span class="news-description">23/12/2016</span>
					</div>
				</div>

				<div class="box-body">
					Se encuentra disponible para nuestros usuarios el boletín N° 4 de acreditación. Pueden visualizarlo o descargarlo en el siguiente link: <a href="upload/Boletin04.pdf" target="_blank">BOLETÍN N° 4</a>
				</div>
			</div>
		</section>
	</div>

	<div class="col-xs-4">
		<section class="content container-fluid">
			<div class="box box-info box-solid">
				<div class="box-header">
					<i class="fa fa-info-circle"></i>
					<h3 class="box-title">Documentos por vencer</h3>
				</div>

				<div class="box-body">
					<?php if (count($fl->getExpiring($interval)) > 0): ?>
						<?php $file = $fl->getExpiring($interval) ?>

						<table id="tfiles" class="table table-striped table-condensed">
							<thead>
							<tr>
								<th>Nombre</th>
								<th class="t-center">Vigencia</th>
							</tr>
							</thead>

							<tbody>
							<?php foreach ($file as $aux => $f): ?>
								<tr>
									<td><?php echo $f->arc_sigla . ' ' . $f->arc_cod . ' - ' . $f->arc_nombre ?></td>
									<td class="t-center"><?php echo getMonthDate($f->arc_fecha_vig) ?></td>
								</tr>
							<?php endforeach ?>
							</tbody>
						</table>
					<?php else: ?>
						No hay documentos por vencer.
					<?php endif ?>
				</div>
			</div>

			<div class="box box-default">
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