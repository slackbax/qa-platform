<?php
session_start();
include("../../class/classMyDBC.php");
include("../../class/classOFile.php");
include("../../src/fn.php");
include("../../src/sessionControl.ajax.php");

if (extract($_POST)):
	$db = new myDBC();
	$fl = new OFile();
	$idate = setDateBD($idate);
	$idatec = setDateBD('01/' . $idatec);

	try {
		$db->autoCommit(FALSE);
		$ins = $fl->mod($iid, $_SESSION['uc_userid'], $iname, $iversion, $idate, $idatec, $db);

		if (!$ins['estado']):
			throw new Exception('Error al modificar los datos del documento. ' . $ins['msg'], 0);
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
