<?php

class Session {

	public function __construct()
	{
	}

	/**
	 * @param $id
	 * @return stdClass
	 */
	public function get($id): stdClass
	{
		$db = new myDBC();
		$result = $db->runQuery("SELECT * FROM uc_sesion WHERE ses_id = '$id'");
		$obj = new stdClass();

		$row = $result->fetch_assoc();
		$obj->ses_id = $row['ses_id'];
		$obj->us_id = $row['us_id'];
		$obj->us_time = $row['ses_time'];
		$obj->us_ip = $row['ses_ip'];

		unset($db);
		return $obj;
	}

	/**
	 * @param $user
	 * @param $ip
	 * @return bool
	 */
	public function set($user, $ip): bool
	{
		$db = new myDBC();
		$result = $db->runQuery("INSERT INTO uc_sesion (us_id, ses_ip) VALUES ('" . $user . "', '" . $ip . "')");

		if ($result):
			unset($db);
			return true;
		else:
			return false;
		endif;
	}
}