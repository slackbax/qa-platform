<?php
session_start();
include("../class/classMyDBC.php");
include("../class/classIndicador.php");
include("../class/classIndicadorEsp.php");
include("../class/classSubPuntoVerificacion.php");
include("../src/fn.php");
include("../src/sessionControl.ajax.php");

if (extract($_POST)):
	$db = new myDBC();
	$in = new Indicador();
	$ie = new IndicadorEsp();
	$spv = new SubPuntoVerificacion();

	try {
		$db->autoCommit(FALSE);

		$idescripcion = str_replace(array("\r\n", "\r", "\n"), "<br>", $idescripcion);
		$imetodo = str_replace(array("\r\n", "\r", "\n"), "<br>", $imetodo);
		$inum = str_replace(array("\r\n", "\r", "\n"), "<br>", $inum);
		$iden = str_replace(array("\r\n", "\r", "\n"), "<br>", $iden);

		$ind = $in->getBySACod($isambito, $itcode);
		$inde = $ie->set($ind->ind_id, $iperiodo, $iem, $iname, $idescripcion, $imetodo, $inum, $iden, $iumbral, $db);

		if (!$inde['estado']):
			throw new Exception('Error al crear el indicador. ' . $inde['msg'], 0);
		endif;

		$subp = $spv->getByIndicador($ind->ind_id);

		foreach ($subp as $k => $v):
			$ins_sp = $spv->set($inde['msg'], $v->spv_id, $db);

			if (!$ins_sp['estado']):
				throw new Exception('Error al crear el indicador-pv. ' . $ins_sp['msg'], 0);
			endif;
		endforeach;

		$db->Commit();
		$db->autoCommit(TRUE);
		$response = array('type' => true, 'msg' => 'OK');
		echo json_encode($response);
	} catch (Exception $e) {
		$db->Rollback();
		$db->autoCommit(TRUE);
		$response = array('type' => false, 'msg' => $e->getMessage(), 'code' => $e->getCode());
		echo json_encode($response);
	}
endif;