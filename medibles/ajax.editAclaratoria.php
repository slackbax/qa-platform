<?php
session_start();
include("../class/classMyDBC.php");
include("../class/classAclaratoria.php");
include("../class/classIndicador.php");
include("../src/fn.php");
include("../src/sessionControl.ajax.php");

if (extract($_POST)):
	$db = new myDBC();
	$in = new Indicador();
	$ac = new Aclaratoria();
	$idate = setDateBD($idate);

	try {
		$db->autoCommit(FALSE);

		$idescripcionr = str_replace(array("\r\n", "\r", "\n"), "<br>", $idescripcionr);

		$ind = $in->getBySACod($isambitor, $itcoder);
		$ins_ac = $ac->mod($iind, $ind->ind_id, $idate, $inumres, $inumero, $iresumen, $idescripcionr, $db);

		if (!$ins_ac['estado']):
			throw new Exception('Error al editar la aclaratoria. ' . $ins_ac['msg'], 0);
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