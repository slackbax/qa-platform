<?php

include("../class/classMyDBC.php");
include("../class/classAutoevaluation.php");
include("../src/fn.php");
session_start();
$_admin = false;
if (isset($_SESSION['uc_useradmin']) && $_SESSION['uc_useradmin']): $_admin = true; endif;
$au = new Autoevaluation();

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
$table = 'uc_autoevaluacion';

// Table's primary key
$primaryKey = 'aut_id';

// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(
	array('db' => 'aut_id', 'dt' => 0, 'field' => 'aut_id'),
	array('db' => 'us_username', 'dt' => 1, 'field' => 'us_username'),
	array('db' => 'aut_id', 'dt' => 2, 'field' => 'aut_id',
		'formatter' => function ($d, $row) use ($au) {
			$aut = $au->get($d);
			return $aut->aut_sambsigla . ' ' . $aut->aut_coddesc;
		}
	),
	array('db' => 'spv_nombre', 'dt' => 3, 'field' => 'spv_nombre'),
	array('db' => 'ind_descripcion', 'dt' => 4, 'field' => 'ind_descripcion'),
	array('db' => 'aut_fecha', 'dt' => 5, 'field' => 'aut_fecha',
		'formatter' => function ($d, $row) {
			return getDateToForm($d);
		}
	),
	array('db' => 'aut_id', 'dt' => 6, 'field' => 'aut_id',
		'formatter' => function ($d, $row) use ($au, $_admin) {
			$auto = $au->get($d);
			$today = new DateTime();
			$today->modify('-7 days');
			$d_ini = new DateTime($auto->aut_fecha_reg);
			$string = '';

			if ($today <= $d_ini or $_admin)
				$string .= '<a class="indEdit btn btn-xs btn-info" href="index.php?section=autoeval&sbs=editauto&id=' . $d . '" data-tooltip="tooltip" data-placement="top" title="Editar"><i class="fa fa-pencil"></i></a>';

			return $string;
		}
	)
);

$joinQuery = "FROM uc_autoevaluacion a";
$joinQuery .= " JOIN uc_usuario u ON a.us_id = u.us_id
            JOIN uc_indicador i ON a.ind_id = i.ind_id
            JOIN uc_subambito s ON i.samb_id = s.samb_id
            JOIN uc_codigo c ON i.cod_id = c.cod_id
            JOIN uc_subpunto_verif sv ON a.spv_id = sv.spv_id ";

$extraWhere = "aut_id IN 
			(SELECT MAX(aut_id) FROM uc_autoevaluacion a 
				JOIN uc_usuario u ON a.us_id = u.us_id 
				JOIN uc_indicador i ON a.ind_id = i.ind_id 
				GROUP BY a.spv_id, a.ind_id, a.us_id)";

if (!$_admin)
	$extraWhere .= " AND a.us_id = " . $_SESSION['uc_userid'];

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

require('../src/ssp2.class.php');

echo json_encode(
	SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere, $groupBy, $having)
);