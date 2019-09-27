<?php

class Periodicidad {

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
		$stmt = $db->Prepare("SELECT *
                                FROM uc_periodicidad ie
                                WHERE ie.pe_id = ?");

		$stmt->bind_param("i", $id);
		$stmt->execute();
		$result = $stmt->get_result();
		$obj = new stdClass();

		$row = $result->fetch_assoc();
		$obj->pe_id = $id;
		$obj->pe_descripcion = utf8_encode($row['pe_descripcion']);
		$obj->pe_numero = $row['pe_numero'];

		unset($db);
		return $obj;
	}

	/**
	 * @return array
	 */
	public function getAll()
	{
		$db = new myDBC();
		$stmt = $db->Prepare("SELECT ie.pe_id FROM uc_periodicidad ie");

		$stmt->execute();
		$result = $stmt->get_result();
		$array = [];

		while ($row = $result->fetch_assoc()):
			$array[] = $this->get($row['pe_id']);
		endwhile;

		unset($db);
		return $array;
	}
}