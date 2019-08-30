<?php


include("../class/classMyDBC.php");
include("../class/classEvento.php");

if (extract($_POST)):
    $ev = new Evento();
    echo json_encode($ev->getByRut($rut));
endif;