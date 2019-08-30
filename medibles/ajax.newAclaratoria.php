<?php
session_start();
include("../class/classMyDBC.php");
include("../class/classAclaratoria.php");
include("../class/classIndicador.php");
include("../src/fn.php");
include("../src/sessionControl.ajax.php");

if (extract($_POST)):
	$db = new myDBC();
	$ac = new Aclaratoria();
	$in = new Indicador();
	$idate = setDateBD($idate);

	try {
		$db->autoCommit(FALSE);

		$idescripcion = str_replace(array("\r\n", "\r", "\n"), "<br>", $idescripcionr);

		$ind = $in->getBySACod($isambitor, $itcoder);
		$ins_ac = $ac->set($ind->ind_id, $idate, $inumres, $inumero, $iresumen, $idescripcion, $db);

		if (!$ins_ac['estado']):
			throw new Exception('Error al crear la aclaratoria. ' . $ins_ac['msg'], 0);
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