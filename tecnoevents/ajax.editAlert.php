<?php

session_start();
include("../class/classMyDBC.php");
include("../class/classAlerta.php");
include("../src/fn.php");
include("../src/sessionControl.ajax.php");
require("../vendor/autoload.php");

if (extract($_POST)):
	$db = new myDBC();
	$al = new Alerta();
	$idateal = setDateBD($idateal);

	try {
		$db->autoCommit(FALSE);
		$ins = $al->mod($id, $_SESSION['uc_userid'], $idateal, $inmarca, $icriesgo, $intalerta, $inlote, $inserie, $ifnombre, $ifemail, $iftelefono, $iimnombre, $iimemail, $iimtelefono, $icorreccion, $db);

		if (!$ins['estado']):
			throw new Exception('Error al guardar los datos del evento. ' . $ins['msg'], 0);
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
