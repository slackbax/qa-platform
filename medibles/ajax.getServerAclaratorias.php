<?php

include("../class/classMyDBC.php");
include("../class/classIndicador.php");
include("../src/fn.php");
session_start();

$ine = new Indicador();

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
$table = 'uc_aclaratoria';

// Table's primary key
$primaryKey = 'acl_id';

// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(
	array('db' => 'acl_id', 'dt' => 0, 'field' => 'acl_id'),
	array('db' => 'a.ind_id', 'dt' => 1, 'field' => 'ind_id',
		'formatter' => function ($d, $row) use ($ine) {
			$inde = $ine->get($d);
			return $inde->samb_sigla . '-' . $inde->cod_descripcion;
		}
	),
	array('db' => 'acl_fecha', 'dt' => 2, 'field' => 'acl_fecha',
		'formatter' => function ($d, $row) {
	  		return getDateToForm($d);
  		}
	),
	array('db' => 'acl_resolucion', 'dt' => 3, 'field' => 'acl_resolucion'),
	array('db' => 'acl_numero', 'dt' => 4, 'field' => 'acl_numero'),
	array('db' => 'acl_resumen', 'dt' => 5, 'field' => 'acl_resumen'),
	array('db' => 'samb_sigla', 'dt' => 6, 'field' => 'samb_sigla'),
	array('db' => 'cod_descripcion', 'dt' => 7, 'field' => 'cod_descripcion'),
	array('db' => 'acl_id', 'dt' => 8, 'field' => 'acl_id',
		'formatter' => function ($d, $row) {
			$string = '';
			$string .= ' <a class="indEdit btn btn-xs btn-info" href="index.php?section=autoeval&sbs=editaclaratoria&id=' . $d . '" data-tooltip="tooltip" data-placement="top" title="Editar"><i class="fa fa-pencil"></i></a>';
			//$string .= ' <button id="del_' . $d . '" class="indDelete btn btn-xs btn-danger" data-toggle="tooltip" data-placement="top" title="Eliminar"><span class="glyphicon glyphicon-remove no-mr"></span></button>';
		
			return $string;
		}
	)
);

$joinQuery = "FROM uc_aclaratoria a";
$joinQuery .= " JOIN uc_indicador i ON a.ind_id = i.ind_id
			JOIN uc_subambito s ON i.samb_id = s.samb_id
			JOIN uc_codigo c ON i.cod_id = c.cod_id";

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

require('../src/ssp2.class.php');

echo json_encode(
	SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere, $groupBy, $having)
);