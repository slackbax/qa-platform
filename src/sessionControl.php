<?php

$logout = false;

if (isset($_SESSION['uc_logintime']) and !empty($_SESSION['uc_logintime'])):
	$timeout = ((time() - $_SESSION['uc_logintime']) >= SESSION_TIME) ? true : false;

	if ($timeout):
		$logout = true;
	else:
		$time = time();
		setcookie(session_name(), session_id(), $time + SESSION_TIME);
		$_SESSION['uc_logintime'] = $time;
	endif;
endif;

if ($logout):
	header("Location: src/logout.php");
endif;