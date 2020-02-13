<section class="content-header">
	<h1>Multimedia
		<small><i class="fa fa-angle-right"></i> Medios relacionados a la Subdirección</small>
	</h1>

	<ol class="breadcrumb">
		<li><a href="index.php?section=home"><i class="fa fa-home"></i> Inicio</a></li>
		<li class="active">Medios relacionados a la Subdirección</li>
	</ol>
</section>

<section class="content container-fluid">
	<div class="box box-default">
		<div class="box-header with-border">
			<h3 class="box-title">Videos</h3>
		</div>

		<div class="box-body">
			<div class="row">
				<div class="col-sm-3 text-center" style="margin-bottom: 15px">
					<div class="embed-responsive embed-responsive-16by9">
						<iframe class="embed-responsive-item" src="https://www.youtube.com/embed/DWR665II2dc" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
					</div>
					<em>Video motivacional Proceso de Reacreditación</em>
				</div>
				<div class="col-sm-3 text-center" style="margin-bottom: 15px">
					<div class="embed-responsive embed-responsive-16by9">
						<iframe class="embed-responsive-item" src="https://www.youtube.com/embed/RwN_8xleztA" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
					</div>
					<em>Para una correcta presentación de la información</em>
				</div>
				<div class="col-sm-3 text-center" style="margin-bottom: 15px">
					<div class="embed-responsive embed-responsive-16by9">
						<iframe class="embed-responsive-item" src="https://www.youtube.com/embed/ng4Z5Hw0FV0" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
					</div>
					<em>Para una correcta presentación en la entrevista de evaluación</em>
				</div>
				<div class="col-sm-3 text-center" style="margin-bottom: 15px">
					<div class="embed-responsive embed-responsive-16by9">
						<iframe class="embed-responsive-item" src="https://www.youtube.com/embed/Jgx4s3FkXSQ" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
					</div>
					<em>Cómo utilizar la Clave Azul</em>
				</div>
			</div>
		</div>

		<div class="box-header with-border">
			<h3 class="box-title">Galerías</h3>
		</div>

		<div class="box-body">
			<div class="row">
				<div class="col-lg-4 col-lg-offset-4 col-sm-8 col-sm-offset-2" style="margin-bottom: 20px">
					<a class="btn btn-default btn-block" href="dist/img/medios/Manual_REACREDITACION_2020.pdf" target="_blank"><i class="fa fa-file-pdf-o text-red"></i> Descargar Manual Reacreditación 2020</a>
				</div>
			</div>

			<div id="media-gallery" class="lightgallery row">
				<ul class="col-sm-8 col-sm-offset-2">
					<?php for ($i = 1; $i < 30; $i++): ?>
						<?php $index = ($i < 10) ? '0' . $i : $i ?>
						<li class="col-xs-6 col-sm-2 item" data-src="dist/img/medios/Reacreditacion2020-<?php echo $index ?>.jpg" data-sub-html=".caption">
							<a>
								<img class="img-responsive" alt="Imagen 1" src="dist/img/medios/Reacreditacion2020-<?php echo $index ?>.jpg">
								<div class="gallery-poster">
									<img alt="zoom" src="dist/img/zoom.png">
								</div>
							</a>
						</li>
					<?php endfor ?>
				</ul>
			</div>
		</div>
	</div>
</section>

<script src="media/media-index.js?v=20190828"></script>
