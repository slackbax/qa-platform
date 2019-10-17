<?php

session_start();
include("../../class/classMyDBC.php");
include("../../class/classFolder.php");
include("../../src/fn.php");
include("../../src/sessionControl.ajax.php");

if (extract($_POST)):
	$db = new myDBC();
	$fl = new Folder();

	if (isset($iactive)):
		$iactive = 1;
	else:
		$iactive = 0;
	endif;

	try {
		$db->autoCommit(FALSE);
		$ins = $fl->mod($iid, $iname, $idescription, $iactive, $db);

		if (!$ins['estado']):
			throw new Exception('Error al editar los datos del directorio. ' . $ins['msg'], 0);
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