<?php

include("../../class/classMyDBC.php");
include("../../class/classFile.php");
include("../../src/fn.php");
session_start();

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
$table = 'uc_archivo';

// Table's primary key
$primaryKey = 'arc_id';

// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(
    array('db' => 'arc_path', 'dt' => 0, 'field' => 'arc_path',
        'formatter' => function ($d, $row) {
            $ext = pathinfo($d, PATHINFO_EXTENSION);
            return '<i class="fa fa-file-' . getExtension($ext) . '-o text-' . getColorExt($ext) . ' icon-table"></i>';
        }
    ),
    array('db' => 'arc_nombre', 'dt' => 1, 'field' => 'arc_nombre'),
    array('db' => 'arc_fecha', 'dt' => 2, 'field' => 'arc_fecha',
        'formatter' => function ($d, $row) {
            return getDateToForm($d);
        }
    ),
    array('db' => 'arc_fecha_vig', 'dt' => 3, 'field' => 'arc_fecha_vig',
        'formatter' => function ($d, $row) {
            return getDateToForm($d);
        }
    ),
    array('db' => 'arc_id', 'dt' => 4, 'field' => 'arc_id',
        'formatter' => function ($d, $row) {
            $string = '<button id="id_' . $d . '" data-toggle="modal" data-target="#fileDetail" class="fileModal btn btn-xs btn-info" data-tooltip="tooltip" data-placement="top" title="Ver detalles"><i class="fa fa-search"></i></button>';
            $string .= ' <a class="fileEdit btn btn-xs btn-primary" href="index.php?section=admin&sbs=editfile&id=' . $d . '" data-tooltip="tooltip" data-placement="top" title="Editar"><i class="fa fa-pencil"></i></a>';
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

require( '../../src/ssp2.class.php' );

echo json_encode(
    SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere, $groupBy, $having)
);