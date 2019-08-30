<?php

session_start();
include("../class/classMyDBC.php");
include("../class/classUser.php");
include("../class/classIndicadorEsp.php");
include("../class/classIndicadorTiempo.php");

$_admin = false;
if (isset($_SESSION['uc_useradmin']) && $_SESSION['uc_useradmin']):
    $_admin = true;
endif;

if (extract($_POST)):
    $u = new User();
    $ie = new IndicadorEsp();
    $it = new IndicadorTiempo();
    
    $obj = $tmp = [];
    $obj['admin'] = $_admin;
    $obj['pvs_u'] = $u->getPV($_SESSION['uc_userid']);
    $obj['y'] = $idate;
    $obj['spv'] = $ipv;
    $obj['i'] = $ie->getByPV($ipv);
    
    $i_t = $it->getByIndYear($ipv, $idate);
    //print_r($i_t);
    
    foreach ($i_t as $i => $v):
        $t = explode('-', $v->indt_fecha);
		$mes = ($t[1] < 10) ? str_replace('0', '', $t[1]) : $t[1];
        $data = new stdClass();
        $data->num = $v->indt_num;
        $data->den = $v->indt_den;
        
        $tmp[$v->indt_ine][$mes] = $data;
    endforeach;
    
    $obj['db'] = $tmp;

    echo json_encode($obj);
endif;