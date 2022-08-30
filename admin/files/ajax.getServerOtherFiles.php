<?php

include("../../class/classMyDBC.php");
include("../../class/classOFile.php");
include("../../src/fn.php");
session_start();

// DB table to use
$table = 'uc_oarchivo';

// Table's primary key
$primaryKey = 'oarc_id';

$columns = array(
	array('db' => 'oarc_path', 'dt' => 0, 'field' => 'oarc_path',
		'formatter' => function ($d) {
			$ext = pathinfo($d, PATHINFO_EXTENSION);
			return '<i class="fa fa-file-' . getExtension($ext) . '-o text-' . getColorExt($ext) . ' icon-table"></i>';
		}
	),
	array('db' => 'oarc_nombre', 'dt' => 1, 'field' => 'oarc_nombre'),
	array('db' => 'oarc_fecha', 'dt' => 2, 'field' => 'oarc_fecha',
		'formatter' => function ($d) {
			return getDateToForm($d);
		}
	),
	array('db' => 'oarc_fecha_vig', 'dt' => 3, 'field' => 'oarc_fecha_vig',
		'formatter' => function ($d) {
			return getDateToForm($d);
		}
	),
	array('db' => 'oarc_id', 'dt' => 4, 'field' => 'oarc_id',
		'formatter' => function ($d) {
			$string = '<button id="id_' . $d . '" data-toggle="modal" data-target="#fileDetail" class="fileModal btn btn-xs btn-info" data-tooltip="tooltip" data-placement="top" title="Ver detalles"><i class="fa fa-search"></i></button>';
			$string .= ' <a class="fileEdit btn btn-xs btn-primary" href="index.php?section=admin&sbs=editotherfile&id=' . $d . '" data-tooltip="tooltip" data-placement="top" title="Editar"><i class="fa fa-pencil"></i></a>';
			$string .= ' <button id="del_' . $d . '" class="fileDelete btn btn-xs btn-danger" data-tooltip="tooltip" data-placement="top" title="Eliminar"><i class="fa fa-remove"></i></button>';

			return $string;
		}
	)
);

$joinQuery = "";
$extraWhere = "";
$groupBy = "";
$having = "";

// SQL server connection information
$sql_details = array(
	'user' => DB_USER,
	'pass' => DB_PASSWORD,
	'db' => DB_DATABASE,
	'host' => DB_HOST
);

/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * If you just want to use the basic configuration for DataTables with PHP
 * server-side, there is no need to edit below this line.
 */

require('../../src/ssp2.class.php');

echo json_encode(
	SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere, $groupBy, $having)
);
