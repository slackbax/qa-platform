<?php

include("../class/classMyDBC.php");
include("../class/classAlerta.php");
include("../src/fn.php");
session_start();

$a = new Alerta();
$_admin = false;

if (isset($_SESSION['uc_useradmin']) && $_SESSION['uc_useradmin']):
	$_admin = true;
endif;

// DB table to use
$table = 'uc_eventoalerta';

// Table's primary key
$primaryKey = 'eal_id';
$index = 0;

$columns = array(
	array('db' => 'eal_id', 'dt' => $index, 'field' => 'eal_id'),
	array('db' => 'us_username', 'dt' => ++$index, 'field' => 'us_username'),
	array('db' => 'eal_fecha', 'dt' => ++$index, 'field' => 'eal_fecha',
		'formatter' => function ($d) {
			return getDateToForm($d);
		}
	),
	array('db' => 'eal_marca', 'dt' => ++$index, 'field' => 'eal_marca'),
	array('db' => 'eal_riesgo', 'dt' => ++$index, 'field' => 'eal_riesgo'),
	array('db' => 'eal_tipoalerta', 'dt' => ++$index, 'field' => 'eal_tipoalerta'),
	array('db' => 'eal_lote', 'dt' => ++$index, 'field' => 'eal_lote'),
	array('db' => 'eal_serie', 'dt' => ++$index, 'field' => 'eal_serie'),
	array('db' => 'eal_fnombre', 'dt' => ++$index, 'field' => 'eal_fnombre'),
	array('db' => 'eal_femail', 'dt' => ++$index, 'field' => 'eal_femail'),
	array('db' => 'eal_ftelefono', 'dt' => ++$index, 'field' => 'eal_ftelefono'),
	array('db' => 'eal_inombre', 'dt' => ++$index, 'field' => 'eal_inombre'),
	array('db' => 'eal_iemail', 'dt' => ++$index, 'field' => 'eal_iemail'),
	array('db' => 'eal_itelefono', 'dt' => ++$index, 'field' => 'eal_itelefono'),
	array('db' => 'eal_plan', 'dt' => ++$index, 'field' => 'eal_plan'),
	array('db' => 'eal_id', 'dt' => ++$index, 'field' => 'eal_id',
		'formatter' => function ($d) {
			return ' <a href="index.php?section=tec-event&sbs=editalert&id=' . $d . '" class="btn btn-xs btn-primary" data-tooltip="tooltip" data-placement="top" title="Editar"><i class="fa fa-pencil"></i></a>';
		}
	)
);

$joinQuery = "FROM uc_eventoalerta e";
$joinQuery .= ' JOIN uc_usuario u ON e.us_id = u.us_id ';
$extraWhere = '';
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
	SSP::simple($_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere, $groupBy, $having)
);
