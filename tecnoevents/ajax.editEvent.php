<?php

session_start();
include("../class/classMyDBC.php");
include("../class/classTecnoEvento.php");
include("../src/fn.php");
include("../src/sessionControl.ajax.php");
require("../vendor/autoload.php");

if (extract($_POST)):
	$db = new myDBC();
	$ev = new TecnoEvento();
	$idate = setDateBD($idate);
	$idateev = (!empty($idateev)) ? setDateBD($idateev) : NULL;
	$idatefab = (!empty($idatefab)) ? setDateBD($idatefab) : NULL;
	$idatevenc = (!empty($idatevenc)) ? setDateBD($idatevenc) : NULL;

	try {
		$db->autoCommit(FALSE);
		$ins = $ev->mod($id, $_SESSION['uc_userid'], $iserv, $icat, $idate, $idateev, $idescription, $ideteccion, $icausa, $iconsec, $iautorizo, $ipacrut, $ipacnombre, $idiag, $ingenerico, $incomercial, $iuso, $icriesgo,
			$inlote, $inserie, $idatefab, $idatevenc, $icondicion, $inregistrosan, $idisponible, $imanera, $ifnombre, $ifpais, $ifemail, $iftelefono, $irlnombre, $irldireccion, $irlemail, $irltelefono, $iimnombre, $iimdireccion,
			$iimemail, $iimtelefono, $icorreccion, $db);

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
