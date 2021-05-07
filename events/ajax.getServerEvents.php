<?php

include("../class/classMyDBC.php");
include("../class/classEvento.php");
include("../src/fn.php");
session_start();
$_admin = false;

if (isset($_SESSION['uc_useradmin']) && $_SESSION['uc_useradmin']): 
    $_admin = true;
endif;

// DB table to use
$table = 'uc_evento';

// Table's primary key
$primaryKey = 'ev_id';
$index = 0;

$columns = array(
    array('db' => 'ev_id', 'dt' => $index, 'field' => 'ev_id'),
    array('db' => 'us_username', 'dt' => ++$index, 'field' => 'us_username'),
    array('db' => 'ev_fecha', 'dt' => ++$index, 'field' => 'ev_fecha',
        'formatter' => function( $d ) {
            $tmp = explode(' ', $d);
            return getDateToForm($tmp[0]);
        }
    ),
    array('db' => 'ev_fecha', 'dt' => ++$index, 'field' => 'ev_fecha',
        'formatter' => function( $d ) {
            $tmp = explode(' ', $d);
            return $tmp[1];
        }
    ),
    array('db' => 'ev_rut', 'dt' => ++$index, 'field' => 'ev_rut'),
    array('db' => 'ev_nombre', 'dt' => ++$index, 'field' => 'ev_nombre'),
    array('db' => 'ev_edad', 'dt' => ++$index, 'field' => 'ev_edad'),
    array('db' => 'ser_nombre', 'dt' => ++$index, 'field' => 'ser_nombre'),
    array('db' => 'tev_descripcion', 'dt' => ++$index, 'field' => 'tev_descripcion'),
    array('db' => 'stev_descripcion', 'dt' => ++$index, 'field' => 'stev_descripcion'),
    array('db' => 'cat_descripcion', 'dt' => ++$index, 'field' => 'cat_descripcion'),
    array('db' => 'ev_contexto', 'dt' => ++$index, 'field' => 'ev_contexto'),
    array('db' => 'tpac_descripcion', 'dt' => ++$index, 'field' => 'tpac_descripcion'),
    array('db' => 'rie_descripcion', 'dt' => ++$index, 'field' => 'rie_descripcion'),
	array('db' => 'ev_origen', 'dt' => ++$index, 'field' => 'ev_origen',
		'formatter' => function( $d ) {
			return ($d == 'E') ? 'EXTRAHOSPITALARIO' : 'INTRAHOSPITALARIO';
		}
	),
    array('db' => 'cons_descripcion', 'dt' => ++$index, 'field' => 'cons_descripcion'),
    array('db' => 'ev_caida_path', 'dt' => ++$index, 'field' => 'ev_caida_path',
        'formatter' => function( $d ) {
            if ($d == ''):
                return 'NO';
            else:
                return 'SI';
            endif;
        }
    ),
    array('db' => 'tv2.tver_descripcion', 'dt' => ++$index,  'field' => 'tver_descripcion'),
    array('db' => 'tv3.tver_descripcion', 'dt' => ++$index, 'field' => 'tver_descripcion'),
    array('db' => 'tv4.tver_descripcion', 'dt' => ++$index,  'field' => 'tver_descripcion'),
    array('db' => 'tv5.tver_descripcion', 'dt' => ++$index, 'field' => 'tver_descripcion'),
	array('db' => 'ev_registro', 'dt' => ++$index, 'field' => 'ev_registro'),
    array('db' => 'ev_id', 'dt' => ++$index, 'field' => 'ev_id',
        'formatter' => function( $d ) {
            $ev = new Evento();
            $eve = $ev->get($d);
            $string = '';
            
            if ($eve->ev_path != ''):
                $string .= '<a href="' . $eve->ev_path . '" target="_blank" class="btn btn-xs btn-info" data-tooltip="tooltip" data-placement="top" title="Plan de mejoras"><i class="fa fa-file"></i></a>';
            endif;
            
            if ($eve->ev_caida_path != ''):
                $string .= ' <a href="' . $eve->ev_caida_path . '" target="_blank" class="btn btn-xs btn-warning" data-tooltip="tooltip" data-placement="top" title="Notificación de caída"><i class="fa fa-file"></i></a>';
            endif;
            $string .= ' <a href="index.php?section=adv-event&sbs=editevent&id=' . $d . '" class="btn btn-xs btn-primary" data-tooltip="tooltip" data-placement="top" title="Editar"><i class="fa fa-pencil"></i></a>';

            return $string;
        }
    )
);

$joinQuery = "FROM uc_evento e";
$joinQuery .= ' JOIN uc_usuario u ON e.us_id = u.us_id ';
$joinQuery .= ' LEFT JOIN uc_servicio s ON e.ser_id = s.ser_id ';
$joinQuery .= ' JOIN uc_riesgo r ON e.rie_id = r.rie_id ';
$joinQuery .= ' JOIN uc_subtipo_evento se ON e.stev_id = se.stev_id ';
$joinQuery .= ' JOIN uc_tipo_evento te ON se.tev_id = te.tev_id ';
$joinQuery .= ' JOIN uc_categoria c ON se.cat_id = c.cat_id ';
$joinQuery .= ' JOIN uc_tipo_paciente tp ON e.tpac_id = tp.tpac_id ';
$joinQuery .= ' JOIN uc_consecuencia co ON e.cons_id = co.cons_id ';
$joinQuery .= ' JOIN uc_tipo_verificacion tv2 ON e.ev_justificacion = tv2.tver_id ';
$joinQuery .= ' JOIN uc_tipo_verificacion tv3 ON e.ev_analisis_jus = tv3.tver_id ';
$joinQuery .= ' JOIN uc_tipo_verificacion tv4 ON e.ev_reporte = tv4.tver_id ';
$joinQuery .= ' JOIN uc_tipo_verificacion tv5 ON e.ev_verificacion = tv5.tver_id ';

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
