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
	array('db' => 'ev_id', 'dt' => 0, 'field' => 'ev_id'),
    array('db' => 'us_username', 'dt' => 1, 'field' => 'us_username',
        'formatter' => function( $d, $row ) {
            return utf8_encode($d);
        }
    ),
    array('db' => 'ev_fecha', 'dt' => 2, 'field' => 'ev_fecha',
        'formatter' => function( $d, $row ) {
            $tmp = explode(' ', $d);
            return getDateToForm($tmp[0]);
        }
    ),
    array('db' => 'ev_fecha', 'dt' => 3, 'field' => 'ev_fecha',
        'formatter' => function( $d, $row ) {
            $tmp = explode(' ', $d);
            return $tmp[1];
        }
    ),
    array('db' => 'ev_rut', 'dt' => 4, 'field' => 'ev_rut',
        'formatter' => function( $d, $row ) {
            return utf8_encode($d);
        }
    ),
    array('db' => 'ev_nombre', 'dt' => 5, 'field' => 'ev_nombre'),
    array('db' => 'ev_edad', 'dt' => 6, 'field' => 'ev_edad',
        'formatter' => function( $d, $row ) {
            return utf8_encode($d);
        }
    ),
	array('db' => 'ser_nombre', 'dt' => 7, 'field' => 'ser_nombre'),
	array('db' => 'stev_descripcion', 'dt' => 8, 'field' => 'stev_descripcion',
        'formatter' => function( $d, $row ) {
            return utf8_encode($d);
        }
    ),
    array('db' => 'cat_descripcion', 'dt' => 9, 'field' => 'cat_descripcion',
        'formatter' => function( $d, $row ) {
            return utf8_encode($d);
        }
    ),
    array('db' => 'ev_contexto', 'dt' => 10, 'field' => 'ev_contexto',
        'formatter' => function( $d, $row ) {
            return utf8_encode($d);
        }
    ),
    array('db' => 'tpac_descripcion', 'dt' => 11, 'field' => 'tpac_descripcion',
        'formatter' => function( $d, $row ) {
            return utf8_encode($d);
        }
    ),
    array('db' => 'rie_descripcion', 'dt' => 12, 'field' => 'rie_descripcion',
        'formatter' => function( $d, $row ) {
            return utf8_encode($d);
        }
    ),
    array('db' => 'cons_descripcion', 'dt' => 13, 'field' => 'cons_descripcion'),
    array('db' => 'ev_caida_path', 'dt' => 14, 'field' => 'ev_caida_path',
        'formatter' => function( $d, $row ) {
            if ($d == ''):
                return 'NO';
            else:
                return 'SI';
            endif;
        }
    ),
    array('db' => 'tv2.tver_descripcion', 'dt' => 15,  'field' => 'tver_descripcion',
        'formatter' => function( $d, $row ) {
            return utf8_encode($d);
        }
    ),
    array('db' => 'tv3.tver_descripcion', 'dt' => 16, 'field' => 'tver_descripcion',
        'formatter' => function( $d, $row ) {
            return utf8_encode($d);
        }
    ),
    array('db' => 'tv4.tver_descripcion', 'dt' => 17,  'field' => 'tver_descripcion',
        'formatter' => function( $d, $row ) {
            return utf8_encode($d);
        }
    ),
    array('db' => 'tv5.tver_descripcion', 'dt' => 18, 'field' => 'tver_descripcion',
        'formatter' => function( $d, $row ) {
            return utf8_encode($d);
        }
    ),
    array('db' => 'ev_id', 'dt' => 19, 'field' => 'ev_id',
        'formatter' => function( $d, $row ) {
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

$extraWhere = ' se.tev_id = 5';

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
