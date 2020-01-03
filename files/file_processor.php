<?php
include("../class/classMyDBC.php");
include("../class/classFile.php");
include("../class/classPuntoVerificacion.php");
include("../class/classSubPuntoVerificacion.php");

$db = new myDBC();
$fl = new File();
$pv = new PuntoVerificacion();
$spv = new SubPuntoVerificacion();

$list_spv = $spv->getAll();

foreach ($list_spv as $k => $v):
	$list_arc = $fl->getByPV($v->spv_pvid);

	foreach ($list_arc as $ka => $va):
		$ins_arc = $fl->setFileSpv($va->arc_id, $v->spv_id);

		if (!$ins_arc['estado']):
			echo "ERROR: " . $ins_arc['msg'] . ' - ' . $va->arc_id . ',' . $v->spv_id;
			exit();
		endif;
	endforeach;
endforeach;