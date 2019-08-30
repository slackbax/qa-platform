<?php

include("../../class/classMyDBC.php");
include("../../class/classIndicador.php");

if (extract($_POST)):
    $ind = new Indicador();
    $list_i = $ind->getBySACod($sa, $cod);
    
    echo json_encode($list_i);
endif;