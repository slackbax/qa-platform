<?php

session_start();
include("../class/classMyDBC.php");
include("../class/classIndicadorTiempo.php");
include("../src/sessionControl.ajax.php");

if (extract($_POST)):
	$db = new myDBC();
	$it = new IndicadorTiempo();

	try {
		$db->autoCommit(FALSE);

		foreach ($num as $n => $ine):
			foreach ($ine as $i => $val):
				if ($val !== ''):
					$mes_f = ($i < 10) ? '0' . $i : $i;
					$fecha = $iyear . '-' . $mes_f . '-01';

					$for_d = $it->getByIndDate($ispv, $n, $fecha);

					if (!is_null($for_d->indt_id)):
						$del = $it->del($for_d->indt_id, $db);

						if (!$del['estado']):
							throw new Exception('Error al eliminar indicador antiguo. ' . $del['msg'], 0);
						endif;
					endif;

					$ins = $it->set($ispv, $_SESSION['uc_userid'], $n, $fecha, $val, $den[$n][$i], $db);

					if (!$ins['estado']):
						throw new Exception('Error al guardar indicador nuevo. ' . $ins['msg'], 0);
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