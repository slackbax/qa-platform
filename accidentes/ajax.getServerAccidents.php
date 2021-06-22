<?php

include("../class/classMyDBC.php");
include("../src/fn.php");
session_start();
$_admin = false;

if (isset($_SESSION['uc_useradmin']) && $_SESSION['uc_useradmin']):
	$_admin = true;
endif;

// DB table to use
$table = 'uc_acc_laboral';

// Table's primary key
$primaryKey = 'acl_id';
$index = 0;

$columns = array(
	array('db' => 'acl_id', 'dt' => $index, 'field' => 'acl_id'),
	array('db' => 'u.us_username', 'dt' => ++$index, 'field' => 'us_username'),
	array('db' => 'us.us_username', 'dt' => ++$index, 'field' => 'user_mod', 'as' => 'user_mod'),
	array('db' => 'ser_nombre', 'dt' => ++$index, 'field' => 'ser_nombre'),
	array('db' => 'acl_fecha_acc', 'dt' => ++$index, 'field' => 'acl_fecha_acc',
		'formatter' => function ($d) {
			return getDateHourToForm($d);
		}
	),
	array('db' => 'acl_fecha', 'dt' => ++$index, 'field' => 'acl_fecha',
		'formatter' => function ($d) {
			return getDateToForm($d);
		}
	),
	array('db' => 'acl_nombres', 'dt' => ++$index, 'field' => 'acl_nombres'),
	array('db' => 'acl_ap', 'dt' => ++$index, 'field' => 'acl_ap'),
	array('db' => 'acl_am', 'dt' => ++$index, 'field' => 'acl_am'),
	array('db' => 'acl_vacuna', 'dt' => ++$index, 'field' => 'acl_vacuna',
		'formatter' => function ($d) {
			switch ($d):
				case '0':
					return 'NO';
				case '1':
					return 'SI';
				default:
					return 'N/D';
			endswitch;
		}
	),
	array('db' => 'acl_lugar', 'dt' => ++$index, 'field' => 'acl_lugar'),
	array('db' => 'acl_descripcion', 'dt' => ++$index, 'field' => 'acl_descripcion'),
	array('db' => 'acl_fuente', 'dt' => ++$index, 'field' => 'acl_fuente',
		'formatter' => function ($d) {
			switch ($d):
				case '0':
					return 'NO';
				case '1':
					return 'SI';
				default:
					return 'N/D';
			endswitch;
		}
	),
	array('db' => 'acl_aviso', 'dt' => ++$index, 'field' => 'acl_aviso',
		'formatter' => function ($d) {
			switch ($d):
				case '0':
					return 'NO';
				case '1':
					return 'SI';
				default:
					return 'N/D';
			endswitch;
		}
	),
	array('db' => 'acl_diat', 'dt' => ++$index, 'field' => 'acl_diat',
		'formatter' => function ($d) {
			switch ($d):
				case '0':
					return 'NO';
				case '1':
					return 'SI';
				default:
					return 'N/D';
			endswitch;
		}
	),
	array('db' => 'acl_protocolo', 'dt' => ++$index, 'field' => 'acl_protocolo',
		'formatter' => function ($d) {
			switch ($d):
				case '0':
					return 'NO';
				case '1':
					return 'SI';
				default:
					return 'N/D';
			endswitch;
		}
	),
	array('db' => 'acl_seguimiento', 'dt' => ++$index, 'field' => 'acl_seguimiento',
		'formatter' => function ($d) {
			switch ($d):
				case '0':
					return 'NO';
				case '1':
					return 'SI';
				default:
					return 'N/D';
			endswitch;
		}
	),
	array('db' => 'acl_atencion', 'dt' => ++$index, 'field' => 'acl_atencion',
		'formatter' => function ($d) {
			switch ($d):
				case '0':
					return 'NO';
				case '1':
					return 'SI';
				default:
					return 'N/A';
			endswitch;
		}
	),
	array('db' => 'acl_ficha', 'dt' => ++$index, 'field' => 'acl_ficha'),
	array('db' => 'acl_medico_turno', 'dt' => ++$index, 'field' => 'acl_medico_turno'),
	array('db' => 'acl_tiempo_espera', 'dt' => ++$index, 'field' => 'acl_tiempo_espera'),
	array('db' => 'acl_serologia', 'dt' => ++$index, 'field' => 'acl_serologia',
		'formatter' => function ($d) {
			switch ($d):
				case '0':
					return 'NO';
				case '1':
					return 'SI';
				default:
					return 'N/D';
			endswitch;
		}
	),
	array('db' => 'acl_tratamiento', 'dt' => ++$index, 'field' => 'acl_tratamiento',
		'formatter' => function ($d) {
			switch ($d):
				case '0':
					return 'NO';
				case '1':
					return 'SI';
				default:
					return 'N/D';
			endswitch;
		}
	),
	array('db' => 'un_nombre', 'dt' => ++$index, 'field' => 'un_nombre'),
	array('db' => 'acl_registro', 'dt' => ++$index, 'field' => 'acl_registro',
		'formatter' => function ($d) {
			return getDateHourToForm($d);
		}
	),
	array('db' => 'acl_id', 'dt' => ++$index, 'field' => 'acl_id',
		'formatter' => function ($d) {
			return '<a href="index.php?section=acc-laboral&sbs=editacc&id=' . $d . '" class="btn btn-xs btn-primary" data-tooltip="tooltip" data-placement="top" title="Editar"><i class="fa fa-pencil"></i></a>';
		}
	)
);

$joinQuery = "FROM uc_acc_laboral a";
$joinQuery .= ' JOIN uc_usuario u ON a.us_id = u.us_id';
$joinQuery .= ' JOIN uc_usuario us ON a.us_mod_id = us.us_id';
$joinQuery .= ' JOIN uc_servicio s ON a.ser_id = s.ser_id';
$joinQuery .= ' JOIN uc_estamento ue on a.esta_id = ue.esta_id';
$joinQuery .= ' JOIN uc_unidad un on u.un_id = un.un_id';

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
