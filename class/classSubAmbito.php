<?php

class SubAmbito {

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
		$stmt = $db->Prepare("SELECT * FROM uc_subambito WHERE samb_id = ?");
		$stmt->bind_param("i", $id);
		$stmt->execute();
		$result = $stmt->get_result();
		$obj = new stdClass();

		$row = $result->fetch_assoc();
		$obj->samb_id = $row['samb_id'];
		$obj->samb_nombre = utf8_encode($row['samb_nombre']);
		$obj->samb_sigla = utf8_encode($row['samb_sigla']);

		unset($db);
		return $obj;
	}

	/**
	 * @param $id
	 * @return array
	 */
	public function getByAmbito($id): array
	{
		$db = new myDBC();
		$stmt = $db->Prepare("SELECT samb_id FROM uc_subambito WHERE amb_id = ?");
		$stmt->bind_param("i", $id);
		$stmt->execute();
		$result = $stmt->get_result();
		$lista = [];

		while ($row = $result->fetch_assoc()):
			$lista[] = $this->get($row['samb_id']);
		endwhile;

		unset($db);
		return $lista;
	}
}