<?php

class Profile {

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
		$result = $db->runQuery("SELECT * FROM uc_perfil WHERE perf_id = '$id'");
		$obj = new stdClass();

		$row = $result->fetch_assoc();
		$obj->perf_id = $row['perf_id'];
		$obj->perf_descripcion = utf8_encode($row['perf_descripcion']);

		unset($db);
		return $obj;
	}

	/**
	 * @return array
	 */
	public function getAll()
	{
		$db = new myDBC();
		$result = $db->runQuery("SELECT perf_id FROM uc_perfil ORDER BY perf_id");
		$lista = [];

		while ($row = $result->fetch_assoc()):
			$lista[] = $this->get($row['perf_id']);
		endwhile;

		unset($db);
		return $lista;
	}
}