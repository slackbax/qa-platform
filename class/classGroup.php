<?php

class Group {

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
		$result = $db->runQuery("SELECT * FROM uc_grupo WHERE gru_id = '$id'");
		$obj = new stdClass();

		$row = $result->fetch_assoc();
		$obj->gru_id = $row['gru_id'];
		$obj->gru_nombre = utf8_encode($row['gru_nombre']);

		unset($db);
		return $obj;
	}

	/**
	 * @return array
	 */
	public function getAll(): array
	{
		$db = new myDBC();
		$result = $db->runQuery("SELECT gru_id FROM uc_grupo");
		$lista = [];

		while ($row = $result->fetch_assoc()):
			$lista[] = $this->get($row['gru_id']);
		endwhile;

		unset($db);
		return $lista;
	}
}