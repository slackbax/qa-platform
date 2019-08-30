<?php
session_start();
include("../class/classMyDBC.php");
include("../class/classAutoevaluation.php");
include("../class/classIndicador.php");
include("../src/fn.php");
include("../src/sessionControl.ajax.php");

if (extract($_POST)):
	$db = new myDBC();
	$au = new Autoevaluation();
	$in = new Indicador();
	$idate = setDateBD($idate);

	try {
		$db->autoCommit(FALSE);

		$ind = $in->getBySACod($isambito, $itcode);

		foreach ($ind->pvs as $k => $v):
			foreach ($ind->ems as $ke => $ve):
				if (isset($vf[$ve['em_id'] . '_' . $v['pv_id']])):

					if (isset($_SESSION['uc_userid']) and $_SESSION['uc_userid'] != '')
						$autoev = $au->set($v['pv_id'], $ispv, $ind->ind_id, $ve['em_id'], $vf[$ve['em_id'] . '_' . $v['pv_id']], $obs[$ve['em_id']], $_SESSION['uc_userid'], $iname, $idate, $db);
					else
						throw new Exception('Error al crear el registro de autoevaluación. La sesión ha caducado, ingrese nuevamente.', 0);

					if (!$autoev['estado']):
						throw new Exception('Error al crear el registro de autoevaluación. ' . $autoev['msg'], 0);
					endif;

				endif;
			endforeach;
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
