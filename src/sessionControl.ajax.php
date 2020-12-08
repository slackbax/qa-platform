<?php

$include_dirs = array(
	'../src/settings.php',
	'../../src/settings.php',
);
foreach ($include_dirs as $include_path):
	if (file_exists($include_path)):
		include_once($include_path);
		break;
	endif;
endforeach;

$logout = false;

try {
	if (isset($_SESSION['uc_logintime']) and !empty($_SESSION['uc_logintime'])):
		$timeout = (time() - $_SESSION['uc_logintime']) >= SESSION_TIME;

		if ($timeout):
			$logout = true;
		else:
			$time = time();
			setcookie(session_name(), session_id(), $time + SESSION_TIME);
			$_SESSION['uc_logintime'] = $time;
		endif;
	else:
		$logout = true;
	endif;

	if ($logout):
		session_unset();
		session_destroy();
		throw new Exception('Su sesión ha cerrado por inactividad, debe iniciar sesión nuevamente.<br>Redirigiendo a página de inicio...', 1);
	endif;
} catch (Exception $e) {
	$response = array('type' => false, 'msg' => $e->getMessage(), 'code' => $e->getCode());
	echo json_encode($response);
	die();
}