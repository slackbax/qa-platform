<?php

include("../class/classMyDBC.php");
include("../class/classEvento.php");
include("../src/fn.php");
session_start();
$_admin = false;

if (isset($_SESSION['uc_useradmin']) && $_SESSION['uc_useradmin']):
	$_admin = true;
endif;

/*
 * DataTables example server-side processing script.
 *
 * Please note that this script is intentionally extremely simply to show how
 * server-side processing can be implemented, and probably shouldn't be used as
 * the basis for a large complex system. It is suitable for simple use cases as
 * for learning.
 *
 * See http://datatables.net/usage/server-side for full details on the server-
 * side processing requirements of DataTables.
 *
 * @license MIT - http://datatables.net/license_mit
 */

/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * Easy set variables
 */

// DB table to use
$table = 'uc_evento';

// Table's primary key
$primaryKey = 'ev_id';

// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(
	array('db' => 'us_username', 'dt' => 0, 'field' => 'us_username',
		'formatter' => function( $d, $row ) {
			return utf8_encode($d);
		}
	),
	array('db' => 'ev_fecha', 'dt' => 1, 'field' => 'ev_fecha',
		'formatter' => function( $d, $row ) {
			$tmp = explode(' ', $d);
			return getDateToForm($tmp[0]);
		}
	),
	array('db' => 'ev_fecha', 'dt' => 2, 'field' => 'ev_fecha',
		'formatter' => function( $d, $row ) {
			$tmp = explode(' ', $d);
			return $tmp[1];
		}
	),
	array('db' => 'ev_rut', 'dt' => 3, 'field' => 'ev_rut',
		'formatter' => function( $d, $row ) {
			return utf8_encode($d);
		}
	),
	array('db' => 'ev_nombre', 'dt' => 4, 'field' => 'ev_nombre'),
	array('db' => 'ev_edad', 'dt' => 5, 'field' => 'ev_edad',
		'formatter' => function( $d, $row ) {
			return utf8_encode($d);
		}
	),
	array('db' => 'ser_nombre', 'dt' => 6, 'field' => 'ser_nombre'),
	array('db' => 'stev_descripcion', 'dt' => 7, 'field' => 'stev_descripcion'),
	array('db' => 'cat_descripcion', 'dt' => 8, 'field' => 'cat_descripcion',
		'formatter' => function( $d, $row ) {
			return utf8_encode($d);
		}
	),
	array('db' => 'cons_descripcion','dt' => 9, 'field' => 'cons_descripcion'),
	array('db' => 'ev_id', 'dt' => 10, 'field' => 'ev_id',
		'formatter' => function( $d, $row ) {
			$string = ' <a href="events/event-pdf.php?id=' . $d . '" target="_blank" class="btn btn-xs btn-primary" data-tooltip="tooltip" data-placement="top" title="Exportar"><i class="fa fa-print"></i></a>';

			return $string;
		}
	)
);

$joinQuery = "FROM uc_evento e";
$joinQuery .= ' JOIN uc_usuario u ON e.us_id = u.us_id ';
$joinQuery .= ' LEFT JOIN uc_servicio s ON e.ser_id = s.ser_id ';
$joinQuery .= ' JOIN uc_subtipo_evento se ON e.stev_id = se.stev_id ';
$joinQuery .= ' JOIN uc_tipo_evento te ON se.tev_id = te.tev_id ';
$joinQuery .= ' JOIN uc_categoria c ON se.cat_id = c.cat_id ';
$joinQuery .= ' JOIN uc_tipo_paciente tp ON e.tpac_id = tp.tpac_id ';
$joinQuery .= ' JOIN uc_consecuencia co ON e.cons_id = co.cons_id ';

$extraWhere = '';
$and = false;

if (!$_admin):
	$extraWhere .= ' e.us_id = ' . $_SESSION['uc_userid'];
	$and = true;
endif;

if (isset($_GET['period'])):
	if ($and): $extraWhere .= ' AND '; endif;
	$extraWhere .= ' ev_fecha BETWEEN "' .$_GET['period'] . '-01-01 00:00:00" AND "' .$_GET['period'] . '-12-31 11:59:59" ';
endif;

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

require( '../src/ssp2.class.php' );

echo json_encode(
	SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere, $groupBy, $having)
);
