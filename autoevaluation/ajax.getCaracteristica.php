<?php

include("../class/classMyDBC.php");
include("../class/classIndicador.php");
include("../class/classAclaratoria.php");

if (extract($_POST)):
    $ind = new Indicador();
	$acl = new Aclaratoria();
    $list_i = $ind->getBySACod($sa, $cod);
    $list_a = $acl->getByIndicador($list_i->ind_id);

    $list_i->acl = $list_a;
    echo json_encode($list_i);
endif;