<?php

include("../class/classMyDBC.php");
include("../class/classTecnoEvento.php");
include("../src/fn.php");
session_start();
$e = new TecnoEvento();
$_admin = false;

if (isset($_SESSION['uc_useradmin']) && $_SESSION['uc_useradmin']):
    $_admin = true;
endif;

// DB table to use
$table = 'uc_tecnoevento';

// Table's primary key
$primaryKey = 'tec_id';
$index = 0;

$columns = array(
    array('db' => 'tec_id', 'dt' => $index, 'field' => 'tec_id'),
    array('db' => 'tec_rut', 'dt' => ++$index, 'field' => 'tec_rut'),
    array('db' => 'us_username', 'dt' => ++$index, 'field' => 'us_username',
        'formatter' => function ($d) {
            return utf8_encode($d);
        }
    ),
    array('db' => 'tec_fecha', 'dt' => ++$index, 'field' => 'tec_fecha',
        'formatter' => function ($d) {
            return getDateToForm($d);
        }
    ),
    array('db' => 'tec_fecha_ev', 'dt' => ++$index, 'field' => 'tec_fecha_ev',
        'formatter' => function ($d) {
            return getDateToForm($d);
        }
    ),
    array('db' => 'ser_nombre', 'dt' => ++$index, 'field' => 'ser_nombre'),
    array('db' => 'cat_descripcion', 'dt' => ++$index, 'field' => 'cat_descripcion'),
    array('db' => 'tec_descripcion', 'dt' => ++$index, 'field' => 'tec_descripcion',
        'formatter' => function ($d) {
            return utf8_encode($d);
        }
    ),
    array('db' => 'tec_momento', 'dt' => ++$index, 'field' => 'tec_momento',
        'formatter' => function ($d) {
            switch ($d):
                case 'AN':
                    return 'ANTES';
                case 'DU':
                    return 'DURANTE';
                default:
                    return 'DESPUÉS';
            endswitch;
        }
    ),
    array('db' => 'tec_causa', 'dt' => ++$index, 'field' => 'tec_causa',
        'formatter' => function ($d) {
            return utf8_encode($d);
        }
    ),
    array('db' => 'tec_consecuencia', 'dt' => ++$index, 'field' => 'tec_consecuencia',
        'formatter' => function ($d) {
            return utf8_encode($d);
        }
    ),
    array('db' => 'tec_autoriza', 'dt' => ++$index, 'field' => 'tec_autoriza',
        'formatter' => function ($d) {
            return ($d) ? 'SÍ' : 'NO';
        }
    ),
    array('db' => 'tec_id', 'dt' => ++$index, 'field' => 'tec_id',
        'formatter' => function ($d) use ($e) {
            $ev = $e->get($d);
            return ($ev->tec_pac_masculinos + $ev->tec_pac_femeninos . ' (' . $ev->tec_pac_masculinos . '/' . $ev->tec_pac_femeninos . ')');
        }
    ),
    array('db' => 'tec_diagnostico', 'dt' => ++$index, 'field' => 'tec_diagnostico',
        'formatter' => function ($d) {
            return utf8_encode($d);
        }
    ),
    array('db' => 'tec_nombre_gen', 'dt' => ++$index, 'field' => 'tec_nombre_gen',
        'formatter' => function ($d) {
            return utf8_encode($d);
        }
    ),
    array('db' => 'tec_nombre_com', 'dt' => ++$index, 'field' => 'tec_nombre_com',
        'formatter' => function ($d) {
            return utf8_encode($d);
        }
    ),
    array('db' => 'tec_uso', 'dt' => ++$index, 'field' => 'tec_uso',
        'formatter' => function ($d) {
            return utf8_encode($d);
        }
    ),
    array('db' => 'tec_riesgo', 'dt' => ++$index, 'field' => 'tec_riesgo',
        'formatter' => function ($d) {
            return utf8_encode($d);
        }
    ),
    array('db' => 'tec_lote', 'dt' => ++$index, 'field' => 'tec_lote',
        'formatter' => function ($d) {
            return utf8_encode($d);
        }
    ),
    array('db' => 'tec_serie', 'dt' => ++$index, 'field' => 'tec_serie',
        'formatter' => function ($d) {
            return utf8_encode($d);
        }
    ),
    array('db' => 'tec_fecha_fab', 'dt' => ++$index, 'field' => 'tec_fecha_fab',
        'formatter' => function ($d) {
            return getDateToForm($d);
        }
    ),
    array('db' => 'tec_fecha_ven', 'dt' => ++$index, 'field' => 'tec_fecha_ven',
        'formatter' => function ($d) {
            return getDateToForm($d);
        }
    ),
    array('db' => 'tec_condicion', 'dt' => ++$index, 'field' => 'tec_condicion',
        'formatter' => function ($d) {
            return ($d == 'P') ? 'PRIMER USO' : 'REUTILIZADO';
        }
    ),
    array('db' => 'tec_num_registro', 'dt' => ++$index, 'field' => 'tec_num_registro',
        'formatter' => function ($d) {
            return utf8_encode($d);
        }
    ),
    array('db' => 'tec_disponibilidad', 'dt' => ++$index, 'field' => 'tec_disponibilidad',
        'formatter' => function ($d) {
            return ($d) ? 'SÍ' : 'NO';
        }
    ),
    array('db' => 'tec_adquisicion', 'dt' => ++$index, 'field' => 'tec_adquisicion',
        'formatter' => function ($d) {
            switch ($d):
                case 'C':
                    return 'CENABAST';
                case 'A':
                    return 'ABASTECIMIENTO';
                case 'L':
                    return 'LEY RICARTE SOTO';
                default:
                    return 'OTRO';
            endswitch;
        }
    ),
    array('db' => 'tec_fnombre', 'dt' => ++$index, 'field' => 'tec_fnombre',
        'formatter' => function ($d) {
            return utf8_encode($d);
        }
    ),
    array('db' => 'tec_fpais', 'dt' => ++$index, 'field' => 'tec_fpais',
        'formatter' => function ($d) {
            return utf8_encode($d);
        }
    ),
    array('db' => 'tec_femail', 'dt' => ++$index, 'field' => 'tec_femail',
        'formatter' => function ($d) {
            return utf8_encode($d);
        }
    ),
    array('db' => 'tec_ftelefono', 'dt' => ++$index, 'field' => 'tec_ftelefono',
        'formatter' => function ($d) {
            return utf8_encode($d);
        }
    ),
    array('db' => 'tec_rnombre', 'dt' => ++$index, 'field' => 'tec_rnombre',
        'formatter' => function ($d) {
            return utf8_encode($d);
        }
    ),
    array('db' => 'tec_rdireccion', 'dt' => ++$index, 'field' => 'tec_rdireccion',
        'formatter' => function ($d) {
            return utf8_encode($d);
        }
    ),
    array('db' => 'tec_remail', 'dt' => ++$index, 'field' => 'tec_remail',
        'formatter' => function ($d) {
            return utf8_encode($d);
        }
    ),
    array('db' => 'tec_rtelefono', 'dt' => ++$index, 'field' => 'tec_rtelefono',
        'formatter' => function ($d) {
            return utf8_encode($d);
        }
    ),
    array('db' => 'tec_imnombre', 'dt' => ++$index, 'field' => 'tec_imnombre',
        'formatter' => function ($d) {
            return utf8_encode($d);
        }
    ),
    array('db' => 'tec_imdireccion', 'dt' => ++$index, 'field' => 'tec_imdireccion',
        'formatter' => function ($d) {
            return utf8_encode($d);
        }
    ),
    array('db' => 'tec_imemail', 'dt' => ++$index, 'field' => 'tec_imemail',
        'formatter' => function ($d) {
            return utf8_encode($d);
        }
    ),
    array('db' => 'tec_imtelefono', 'dt' => ++$index, 'field' => 'tec_imtelefono',
        'formatter' => function ($d) {
            return utf8_encode($d);
        }
    ),
    array('db' => 'tec_notificacion', 'dt' => ++$index, 'field' => 'tec_notificacion',
        'formatter' => function ($d) {
            return ($d) ? 'SÍ' : 'NO';
        }
    ),
    array('db' => 'tec_retiro', 'dt' => ++$index, 'field' => 'tec_retiro',
        'formatter' => function ($d) {
            return ($d) ? 'SÍ' : 'NO';
        }
    ),
    array('db' => 'tec_respuesta', 'dt' => ++$index, 'field' => 'tec_respuesta',
        'formatter' => function ($d) {
            return utf8_encode($d);
        }
    ),
    array('db' => 'tec_correccion', 'dt' => ++$index, 'field' => 'tec_correccion',
        'formatter' => function ($d) {
            return utf8_encode($d);
        }
    ),
    array('db' => 'tec_id', 'dt' => ++$index, 'field' => 'tec_id',
        'formatter' => function ($d) {
            $string = '';
            $string .= ' <a href="index.php?section=tec-event&sbs=edittecnoevent&id=' . $d . '" class="btn btn-xs btn-primary" data-tooltip="tooltip" data-placement="top" title="Editar"><i class="fa fa-pencil"></i></a>';

            return $string;
        }
    )
);

$joinQuery = "FROM uc_tecnoevento e";
$joinQuery .= ' JOIN uc_usuario u ON e.us_id = u.us_id ';
$joinQuery .= ' LEFT JOIN uc_servicio s ON e.ser_id = s.ser_id ';
$joinQuery .= ' JOIN uc_categoria c ON e.cat_id = c.cat_id ';

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
