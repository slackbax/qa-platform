<?php
session_start();
include("../class/classMyDBC.php");
include("../class/classElementoMed.php");
include("../class/classIndicador.php");
include("../src/fn.php");
include("../src/sessionControl.ajax.php");

if (extract($_POST)):
	$db = new myDBC();
	$in = new Indicador();
	$ie = new ElementoMed();

	try {
		$db->autoCommit(FALSE);

		$idescripcion = str_replace(array("\r\n", "\r", "\n"), "<br>", $idescripcion);

		$ind = $in->getBySACod($isambito, $itcode);
		$inde = $ie->mod($iind, $ind->ind_id, $idescripcion, $inumelem, $db);

		if (!$inde['estado']):
			throw new Exception('Error al editar el elemento medible. ' . $inde['msg'], 0);
		endif;

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