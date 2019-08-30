<?php

include("../class/classMyDBC.php");
include("../class/classTipoCaracteristica.php");

if (extract($_POST)):
    $tc = new TipoCaracteristica();
    $list_s = $tc->getBySubAmb($sa);
    
    echo json_encode($list_s);
endif;