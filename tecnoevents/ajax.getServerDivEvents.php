<?php

include("../class/classMyDBC.php");
include("../class/classTecnoDivEvento.php");
include("../src/fn.php");
session_start();
$e = new TecnoDivEvento();
$_admin = false;

if (isset($_SESSION['uc_useradmin']) && $_SESSION['uc_useradmin']):
    $_admin = true;
endif;

// DB table to use
$table = 'uc_tecnoeventodiv';

// Table's primary key
$primaryKey = 'ted_id';
$index = 0;

$columns = array(
    array('db' => 'ted_id', 'dt' => $index, 'field' => 'ted_id'),
    array('db' => 'ted_rut', 'dt' => ++$index, 'field' => 'ted_rut'),
    array('db' => 'us_username', 'dt' => ++$index, 'field' => 'us_username',
        'formatter' => function ($d) {
            return utf8_encode($d);
        }
    ),
    array('db' => 'ted_direccion', 'dt' => ++$index, 'field' => 'ted_direccion',
        'formatter' => function ($d) {
            return utf8_encode($d);
        }
    ),
    array('db' => 'ted_profesion', 'dt' => ++$index, 'field' => 'ted_profesion',
        'formatter' => function ($d) {
            return utf8_encode($d);
        }
    ),
    array('db' => 'ted_fecha', 'dt' => ++$index, 'field' => 'ted_fecha',
        'formatter' => function ($d) {
            return getDateToForm($d);
        }
    ),
    array('db' => 'ted_fecha_ev', 'dt' => ++$index, 'field' => 'ted_fecha_ev',
        'formatter' => function ($d) {
            return getDateToForm($d);
        }
    ),
    array('db' => 'ser_nombre', 'dt' => ++$index, 'field' => 'ser_nombre'),
    array('db' => 'ted_descripcion', 'dt' => ++$index, 'field' => 'ted_descripcion',
        'formatter' => function ($d) {
            return utf8_encode($d);
        }
    ),
    array('db' => 'ted_nombre_gen', 'dt' => ++$index, 'field' => 'ted_nombre_gen',
        'formatter' => function ($d) {
            return utf8_encode($d);
        }
    ),
    array('db' => 'ted_nombre_com', 'dt' => ++$index, 'field' => 'ted_nombre_com',
        'formatter' => function ($d) {
            return utf8_encode($d);
        }
    ),
    array('db' => 'ted_catalogo', 'dt' => ++$index, 'field' => 'ted_catalogo',
        'formatter' => function ($d) {
            return utf8_encode($d);
        }
    ),
    array('db' => 'ted_uso', 'dt' => ++$index, 'field' => 'ted_uso',
        'formatter' => function ($d) {
            switch ($d):
                case 'CAL':
                    return 'CALIBRADOR';
                case 'CON':
                    return 'CONTROL';
                case 'DIA':
                    return 'DIAGNÓSTICO';
                default:
                    return 'OTRO';
            endswitch;
        }
    ),
    array('db' => 'ted_uso_otro', 'dt' => ++$index, 'field' => 'ted_uso_otro',
        'formatter' => function ($d) {
            return utf8_encode($d);
        }
    ),
    array('db' => 'ted_cadena', 'dt' => ++$index, 'field' => 'ted_cadena',
        'formatter' => function ($d) {
            return ($d) ? 'SÍ' : 'NO';
        }
    ),
    array('db' => 'ted_temperatura', 'dt' => ++$index, 'field' => 'ted_temperatura',
        'formatter' => function ($d) {
            return utf8_encode($d);
        }
    ),
    array('db' => 'ted_lote', 'dt' => ++$index, 'field' => 'ted_lote',
        'formatter' => function ($d) {
            return utf8_encode($d);
        }
    ),
    array('db' => 'ted_seguridad', 'dt' => ++$index, 'field' => 'ted_seguridad',
        'formatter' => function ($d) {
            return utf8_encode($d);
        }
    ),
    array('db' => 'ted_fnombre', 'dt' => ++$index, 'field' => 'ted_fnombre',
        'formatter' => function ($d) {
            return utf8_encode($d);
        }
    ),
    array('db' => 'ted_fpais', 'dt' => ++$index, 'field' => 'ted_fpais',
        'formatter' => function ($d) {
            return utf8_encode($d);
        }
    ),
    array('db' => 'ted_imnombre', 'dt' => ++$index, 'field' => 'ted_imnombre',
        'formatter' => function ($d) {
            return utf8_encode($d);
        }
    ),
    array('db' => 'ted_impais', 'dt' => ++$index, 'field' => 'ted_impais',
        'formatter' => function ($d) {
            return utf8_encode($d);
        }
    ),
    array('db' => 'ted_formauso', 'dt' => ++$index, 'field' => 'ted_formauso',
        'formatter' => function ($d) {
            return ($d == 'S') ? 'SEMI-AUTOMATIZADO' : 'MANUAL';
        }
    ),
    array('db' => 'ted_fecha_fab', 'dt' => ++$index, 'field' => 'ted_fecha_fab',
        'formatter' => function ($d) {
            return getDateToForm($d);
        }
    ),
    array('db' => 'ted_fecha_ven', 'dt' => ++$index, 'field' => 'ted_fecha_ven',
        'formatter' => function ($d) {
            return getDateToForm($d);
        }
    ),
    array('db' => 'ted_verificacion', 'dt' => ++$index, 'field' => 'ted_verificacion',
        'formatter' => function ($d) {
            return ($d) ? 'SÍ' : 'NO';
        }
    ),
    array('db' => 'ted_control', 'dt' => ++$index, 'field' => 'ted_control',
        'formatter' => function ($d) {
            return ($d) ? 'SÍ' : 'NO';
        }
    ),
    array('db' => 'ted_adscrito', 'dt' => ++$index, 'field' => 'ted_adscrito',
        'formatter' => function ($d) {
            return ($d) ? 'SÍ' : 'NO';
        }
    ),
    array('db' => 'ted_autorizacion', 'dt' => ++$index, 'field' => 'ted_autorizacion',
        'formatter' => function ($d) {
            switch ($d):
                case 'CU':
                    return 'COMUNIDAD EUROPEA';
                case 'US':
                    return 'FDA - ESTADOS UNIDOS';
                case 'ISP':
                    return 'ISP';
                default:
                    return 'OTRO';
            endswitch;
        }
    ),
    array('db' => 'ted_aut_otro', 'dt' => ++$index, 'field' => 'ted_aut_otro',
        'formatter' => function ($d) {
            return utf8_encode($d);
        }
    ),
    array('db' => 'ted_ensayo', 'dt' => ++$index, 'field' => 'ted_ensayo',
        'formatter' => function ($d) {
            return utf8_encode($d);
        }
    ),
    array('db' => 'ted_tecnica', 'dt' => ++$index, 'field' => 'ted_tecnica',
        'formatter' => function ($d) {
            switch ($d):
                case 'CL':
                    return 'CUALITATIVO';
                case 'SCN':
                    return 'SEMI-CUANTITATIVO';
                default:
                    return 'CUANTITATIVO';
            endswitch;
        }
    ),
    array('db' => 'ted_analizador', 'dt' => ++$index, 'field' => 'ted_analizador',
        'formatter' => function ($d) {
            return utf8_encode($d);
        }
    ),
    array('db' => 'ted_investigacion', 'dt' => ++$index, 'field' => 'ted_investigacion',
        'formatter' => function ($d) {
            return ($d) ? 'SÍ' : 'NO';
        }
    ),
    array('db' => 'ted_reporte', 'dt' => ++$index, 'field' => 'ted_reporte',
        'formatter' => function ($d) {
            return ($d) ? 'SÍ' : 'NO';
        }
    ),
    array('db' => 'ted_id', 'dt' => ++$index, 'field' => 'ted_id',
        'formatter' => function ($d) {
            $string = '';
            //$string .= ' <a href="index.php?section=tec-event&sbs=edittecnoevent&id=' . $d . '" class="btn btn-xs btn-primary" data-tooltip="tooltip" data-placement="top" title="Editar"><i class="fa fa-pencil"></i></a>';

            return $string;
        }
    )
);

$joinQuery = "FROM uc_tecnoeventodiv e";
$joinQuery .= ' JOIN uc_usuario u ON e.us_id = u.us_id ';
$joinQuery .= ' LEFT JOIN uc_servicio s ON e.ser_id = s.ser_id ';

$extraWhere = '';

if (!$_admin):
    $extraWhere .= 'e.us_id = ' . $_SESSION['uc_userid'];
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

require('../src/ssp2.class.php');

echo json_encode(
    SSP::simple($_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere, $groupBy, $having)
);
