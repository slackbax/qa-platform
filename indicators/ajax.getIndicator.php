<?php

include("../class/classMyDBC.php");
include("../class/classIndicadorEsp.php");

if (extract($_POST)):
	$ind = new IndicadorEsp();
	echo json_encode($ind->get($id));
endif;