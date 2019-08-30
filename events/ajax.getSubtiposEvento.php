<?php

include("../class/classMyDBC.php");
include("../class/classSubtipoEvento.php");

if (extract($_POST)):
    $stev = new SubtipoEvento();
    $list_s = $stev->getByTipo($te);
    
    echo json_encode($list_s);
endif;