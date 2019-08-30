<?php

include("../class/classMyDBC.php");
include("../class/classSubAmbito.php");

if (extract($_POST)):
    $sam = new SubAmbito();
    $list_s = $sam->getByAmbito($am);
    
    echo json_encode($list_s);
endif;