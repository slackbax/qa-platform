<?php

session_start();
include("../../class/classMyDBC.php");
include("../../class/classUser.php");
include("../../src/sessionControl.ajax.php");

if (extract($_POST)):
	$db = new myDBC();
	$user = new User();

	try {
		$db->autoCommit(FALSE);
		$ins = $user->set($iname, $ilastnamep, $ilastnamem, $iemail, $iusername, $ipassword, $db);

		if (!$ins['estado']):
			throw new Exception('Error al guardar los datos de usuario.' . $ins['msg'], 0);
		endif;

		foreach ($iusergroups as $i => $g):
			$grp = $user->setGroup($ins['msg'], $g, $db);

			if (!$grp['estado']):
				throw new Exception('Error al crear grupos del usuario.' . $grp['msg'], 0);
			endif;
		endforeach;

		if (!empty($_FILES)):
			$targetFolder = BASEFOLDER . 'dist/img/users/';
			$targetPath = $_SERVER['DOCUMENT_ROOT'] . $targetFolder;

			foreach ($_FILES as $aux => $file):
				$tempFile = $file['tmp_name'][0];
				$targetFile = rtrim($targetPath, '/') . '/' . $ins['msg'] . '_' . $file['name'][0];
				move_uploaded_file($tempFile, $targetFile);
			endforeach;

			$pic_route = 'users/' . $ins['msg'] . '_' . $file['name'][0];
		else:
			$pic_route = 'users/no-photo.png';
		endif;

		$ins_p = $user->setPicture($ins['msg'], $pic_route, $db);

		if (!$ins_p):
			throw new Exception('Error al guardar la imagen.', 0);
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