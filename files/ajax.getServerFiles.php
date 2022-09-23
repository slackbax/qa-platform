<?php

include("../class/classMyDBC.php");
include("../class/classFile.php");
include("../src/fn.php");
session_start();

$_admin = false;
if (isset($_SESSION['uc_useradmin']) && $_SESSION['uc_useradmin']):
	$_admin = true;
endif;

$table = 'uc_archivo';
$primaryKey = 'arc_id';
$index = 0;

$columns = array(
	array('db' => 'DISTINCT(a.arc_id)', 'dt' => $index, 'field' => 'arc_id'),
	array('db' => 'arc_path', 'dt' => ++$index, 'field' => 'arc_path',
		'formatter' => function ($d) {
			$ext = pathinfo($d, PATHINFO_EXTENSION);
			return '<i class="fa fa-file-' . getExtension($ext) . '-o text-' . getColorExt($ext) . ' icon-table"></i>';
		}
	),
	array('db' => 'arc_codigo', 'dt' => ++$index, 'field' => 'arc_codigo',
		'formatter' => function ($d) {
			return explode(' ', utf8_encode($d))[0];
		}
	),
	array('db' => 'arc_codigo', 'dt' => ++$index, 'field' => 'arc_codigo',
		'formatter' => function ($d) {
			return explode(' ', utf8_encode($d))[1];
		}
	),
	array('db' => 'arc_nombre', 'dt' => ++$index, 'field' => 'arc_nombre'),
	array('db' => 'tdo_descripcion', 'dt' => ++$index, 'field' => 'tdo_descripcion'),
	array('db' => 'arc_responsable', 'dt' => ++$index, 'field' => 'arc_responsable'),
	array('db' => 'arc_fecha_crea', 'dt' => ++$index, 'field' => 'arc_fecha_crea',
		'formatter' => function ($d) {
			return getDateToForm($d);
		}
	),
	array('db' => 'arc_fecha_vig', 'dt' => ++$index, 'field' => 'arc_fecha_vig',
		'formatter' => function ($d) {
			return getDateToForm($d);
		}
	),
	array('db' => 'arc_institucional', 'dt' => ++$index, 'field' => 'arc_institucional',
		'formatter' => function ($d) {
			if (!empty($d)):
				if ($d == '0') return 'NO INSTITUCIONAL';
				else return 'INSTITUCIONAL';
			else:
				return '';
			endif;
		}
	),
	array('db' => 'a.arc_id', 'dt' => ++$index, 'field' => 'arc_id',
		'formatter' => function ($d) use ($_admin) {
			$string = '<button id="id_' . $d . '" data-toggle="modal" data-target="#fileDetail" class="fileModal btn btn-xs btn-info" data-tooltip="tooltip" data-placement="top" title="Ver detalles"><i class="fa fa-search"></i></button>';

			if ($_admin):
				$string .= ' <a class="fileEdit btn btn-xs btn-primary" href="index.php?section=admin&sbs=editfile&id=' . $d . '" data-tooltip="tooltip" data-placement="top" title="Editar"><i class="fa fa-pencil"></i></a>';
				$string .= ' <button id="del_' . $d . '" class="fileDelete btn btn-xs btn-danger" data-tooltip="tooltip" data-placement="top" title="Eliminar"><i class="fa fa-remove"></i></button>';
			endif;

			return $string;
		}
	)
);

$joinQuery = "FROM uc_archivo a";
$joinQuery .= " JOIN uc_archivo_subpuntoverif asp ON a.arc_id = asp.arc_id";
$joinQuery .= " JOIN uc_subpunto_verif spv ON asp.spv_id = spv.spv_id";
$joinQuery .= " LEFT JOIN uc_tipo_documento td ON a.tdo_id = td.tdo_id";
$extraWhere = " arc_publicado = '1' AND pv_id <> '99' ";

$groupBy = "";
$having = "";

// SQL server connection information
$sql_details = array(
	'user' => DB_USER,
	'pass' => DB_PASSWORD,
	'db' => DB_DATABASE,
	'host' => DB_HOST
);

require('../src/ssp2.class.php');

echo json_encode(
	SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere, $groupBy, $having)
);
