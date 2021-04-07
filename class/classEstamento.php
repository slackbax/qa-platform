<?php

class Estamento {
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
		$stmt = $db->Prepare("SELECT * FROM uc_estamento WHERE esta_id = ?");
		$stmt->bind_param("i", $id);
		$stmt->execute();
		$result = $stmt->get_result();
		$obj = new stdClass();

		$row = $result->fetch_assoc();
		$obj->esta_id = $row['esta_id'];
		$obj->esta_descripcion = utf8_encode($row['esta_descripcion']);

		unset($db);
		return $obj;
	}

	/**
	 * @return array
	 */
	public function getAll()
	{
		$db = new myDBC();
		$stmt = $db->Prepare("SELECT esta_id FROM uc_estamento ORDER BY esta_descripcion");
		$stmt->execute();
		$result = $stmt->get_result();
		$lista = [];

		while ($row = $result->fetch_assoc()):
			$lista[] = $this->get($row['esta_id']);
		endwhile;

		unset($db);
		return $lista;
	}
}