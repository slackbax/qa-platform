<?php

include("../class/classMyDBC.php");
include("../class/classSubPuntoVerificacion.php");

if (extract($_POST)):
	$spv = new SubPuntoVerificacion();
	$list_s = $spv->getByPV($pv);

	echo json_encode($list_s);
endif;