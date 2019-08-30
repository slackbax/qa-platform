<?php

include("../class/classMyDBC.php");
include("../class/classIndicadorEsp.php");
include("../src/fn.php");
session_start();
$ine = new IndicadorEsp();

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
$table = 'uc_ind_especifico';

// Table's primary key
$primaryKey = 'ine_id';

// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(
    array('db' => 'ine_id', 'dt' => 0, 'field' => 'ine_id'),
    array('db' => 'ine_id', 'dt' => 1, 'field' => 'ine_id',
        'formatter' => function ($d, $row) use ($ine) {
            $inde = $ine->get($d);
            return $inde->samb_sigla . '-' . $inde->cod_descripcion;
        }
    ),
    array('db' => 'ine_nombre', 'dt' => 2, 'field' => 'ine_nombre'),
    array('db' => 'pe_descripcion', 'dt' => 3, 'field' => 'pe_descripcion'),
    array('db' => 'ine_umbral', 'dt' => 4, 'field' => 'ine_umbral'),
    array('db' => 'samb_sigla', 'dt' => 5, 'field' => 'samb_sigla'),
    array('db' => 'cod_descripcion', 'dt' => 6, 'field' => 'cod_descripcion'),
    array('db' => 'ine_id', 'dt' => 7, 'field' => 'ine_id',
        'formatter' => function ($d, $row) {
            $string = '';
            $string = '<button id="id_' . $d . '" data-toggle="modal" data-target="#indDetail" class="indModal btn btn-xs btn-info" data-tooltip="tooltip" data-placement="top" title="Ver detalles"><i class="fa fa-search"></i></button>';
            $string .= ' <a class="indEdit btn btn-xs btn-primary" href="index.php?section=autoeval&sbs=editindicator&id=' . $d . '" data-tooltip="tooltip" data-placement="top" title="Editar"><i class="fa fa-pencil"></i></a>';
            //$string .= ' <button id="del_' . $d . '" class="indDelete btn btn-xs btn-danger" data-tooltip="tooltip" data-placement="top" title="Eliminar"><i class="fa fa-remove"></i></button>';
        
            return $string;
        }
    )
);

$joinQuery = "FROM uc_ind_especifico e";
$joinQuery .= " JOIN uc_periodicidad p ON e.pe_id = p.pe_id
			JOIN uc_indicador i ON e.ind_id = i.ind_id
			JOIN uc_tipo_caracteristica tc ON i.tcar_id = tc.tcar_id
			JOIN uc_subambito s ON i.samb_id = s.samb_id
			JOIN uc_ambito a ON s.amb_id = a.amb_id
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