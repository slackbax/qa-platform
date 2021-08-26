<?php

session_start();
include("../class/classMyDBC.php");
include("../class/classAccidente.php");
include("../src/fn.php");
include("../src/sessionControl.ajax.php");

if (extract($_POST)):
	$db = new myDBC();
	$ac = new Accidente();
	$idate = setDateBD($idate);
	$idateacc = setDateBD($idateacc) . ' ' . $ihour . ':' . $imin;

	try {
		$db->autoCommit(FALSE);
		$ins = $ac->mod($iid, $iserv, $_SESSION['uc_userid'], $iestamento, $iprofesion, $idate, $idateacc, $iname, $iap, $iam, $ilugar, $idescrip, $ivacuna,
							$itiempo, $ificha, $imedico, $ifuente, $iaviso, $idiat, $imedper, $iurg, $iserol, $itrat, $iproto, $db);

		if (!$ins['estado']):
			throw new Exception('Error al guardar los datos del accidente. ' . $ins['msg'], 0);
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