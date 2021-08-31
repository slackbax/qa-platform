<?php

class Profesion {
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
		$stmt = $db->Prepare("SELECT * FROM uc_profesion WHERE pro_id = ?");

		$stmt->bind_param("i", $id);
		$stmt->execute();
		$result = $stmt->get_result();
		$obj = new stdClass();

		$row = $result->fetch_assoc();
		$obj->pro_id = $id;
		$obj->pro_nombre = utf8_encode($row['pro_nombre']);

		unset($db);
		return $obj;
	}

	/**
	 * @return array
	 */
	public function getAll(): array
	{
		$db = new myDBC();
		$stmt = $db->Prepare("SELECT pro_id FROM uc_profesion ORDER BY pro_nombre");

		$stmt->execute();
		$result = $stmt->get_result();
		$array = [];

		while ($row = $result->fetch_assoc()):
			$array[] = $this->get($row['pro_id']);
		endwhile;

		unset($db);
		return $array;
	}
}