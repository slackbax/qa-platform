<?php

include("../class/classMyDBC.php");
include("../class/classCodigo.php");

if (extract($_POST)):
    $cod = new Codigo();
    $list_c = $cod->getBySaTc($sa, $tc);
    
    echo json_encode($list_c);
endif;