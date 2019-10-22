<?php

class Visit {

	public function __construct()
	{
	}

	/**
	 * @param $id
	 * @return stdClass
	 */
	public function get($id)
	{
		$db = new myDBC();
		$stmt = $db->Prepare("SELECT * FROM uc_visita WHERE vis_id = ?");

		$stmt->bind_param("i", $id);
		$stmt->execute();
		$result = $stmt->get_result();
		$obj = new stdClass();

		$row = $result->fetch_assoc();
		$obj->vis_id = $row['vis_id'];
		$obj->vis_ip = $row['vis_ip'];
		$obj->vis_ip_forw = $row['vis_ip_forw'];
		$obj->vis_date = $row['vis_date'];

		unset($db);
		return $obj;
	}

	/**
	 * @return int
	 */
	public function getNumber() {
		$db = new myDBC();
		$stmt = $db->Prepare("SELECT COUNT(vis_id) AS num FROM uc_visita");

		$stmt->execute();
		$result = $stmt->get_result();
		$row = $result->fetch_assoc();

		unset($db);
		return $row['num'];
	}

	/**
	 * @param $ip
	 * @return bool
	 */
	public function set($ip)
	{
		$db = new myDBC();

		$stmt = $db->Prepare("SELECT COUNT(vis_id) AS num FROM uc_visita WHERE vis_ip = ? AND DAY(vis_date) = '" . date('d') . "'
                                AND MONTH(vis_date) = '" . date('m') . "' AND YEAR(vis_date) = '" . date('Y') . "'");

		$stmt->bind_param("s", $ip);
		$stmt->execute();
		$result = $stmt->get_result();
		$row = $result->fetch_assoc();

		if ($row['num'] == 0):
			$stmt = $db->Prepare("INSERT INTO uc_visita (vis_ip, vis_date) VALUES (?, NOW())");
			$stmt->bind_param("s", $ip);
			$stmt->execute();

			if ($result):
				unset($db);
				return true;
			else:
				return false;
			endif;
		endif;

		return true;
	}
}