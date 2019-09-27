<?php

class Ambito {

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
		$stmt = $db->Prepare("SELECT * FROM uc_ambito WHERE amb_id = ?");
		$stmt->bind_param("i", $id);
		$stmt->execute();
		$result = $stmt->get_result();
		$obj = new stdClass();

		$row = $result->fetch_assoc();
		$obj->amb_id = $row['amb_id'];
		$obj->amb_nombre = utf8_encode($row['amb_nombre']);

		unset($db);
		return $obj;
	}

	/**
	 * @return array
	 */
	public function getAll()
	{
		$db = new myDBC();
		$stmt = $db->Prepare("SELECT amb_id FROM uc_ambito");
		$stmt->execute();
		$result = $stmt->get_result();
		$lista = [];

		while ($row = $result->fetch_assoc()):
			$lista[] = $this->get($row['amb_id']);
		endwhile;

		unset($db);
		return $lista;
	}

	/**
	 * @return array
	 */
	public function getClinicos()
	{
		$db = new myDBC();
		$stmt = $db->Prepare("SELECT amb_id FROM uc_ambito WHERE amb_id < 9");
		$stmt->execute();
		$result = $stmt->get_result();
		$lista = [];

		while ($row = $result->fetch_assoc()):
			$lista[] = $this->get($row['amb_id']);
		endwhile;

		unset($db);
		return $lista;
	}

	/**
	 * @return array
	 */
	public function getApoyo()
	{
		$db = new myDBC();
		$stmt = $db->Prepare("SELECT amb_id FROM uc_ambito WHERE amb_id = 9");
		$stmt->execute();
		$result = $stmt->get_result();
		$lista = [];

		while ($row = $result->fetch_assoc()):
			$lista[] = $this->get($row['amb_id']);
		endwhile;

		unset($db);
		return $lista;
	}

	/**
	 * @param $id
	 * @return mixed
	 */
	public function getNumChildren($id)
	{
		$db = new myDBC();
		$stmt = $db->Prepare("SELECT COUNT(*) AS num FROM uc_subambito WHERE amb_id = ?");
		$stmt->bind_param("i", $id);
		$stmt->execute();
		$result = $stmt->get_result();

		$row = $result->fetch_assoc();
		$num = $row['num'];

		unset($db);
		return $num;
	}

	/**
	 * @param $id
	 * @return array
	 */
	public function getChildren($id)
	{
		$db = new myDBC();
		$stmt = $db->Prepare("SELECT * FROM uc_subambito WHERE amb_id = ?");
		$stmt->bind_param("i", $id);
		$stmt->execute();
		$result = $stmt->get_result();
		$lista = [];

		while ($row = $result->fetch_assoc()):
			$obj = new stdClass();
			$obj->samb_id = $row['samb_id'];
			$obj->samb_nombre = utf8_encode($row['samb_nombre']);
			$obj->samb_sigla = $row['samb_sigla'];
			$lista[] = $obj;
		endwhile;

		unset($db);
		return $lista;
	}

}