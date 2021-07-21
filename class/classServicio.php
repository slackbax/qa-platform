<?php

class Servicio {

	public function __construct()
	{
	}

	/**
	 * @param $id
	 * @param null $db
	 * @return \stdClass
	 */
	public function get($id, $db = null): stdClass
	{
		if (is_null($db)):
			$db = new myDBC();
		endif;

		$stmt = $db->Prepare("SELECT * FROM uc_servicio WHERE ser_id = ?");
		$stmt->bind_param("i", $id);
		$stmt->execute();
		$result = $stmt->get_result();
		$obj = new stdClass();

		$row = $result->fetch_assoc();
		$obj->ser_id = $row['ser_id'];
		$obj->ser_nombre = utf8_encode($row['ser_nombre']);

		unset($db);
		return $obj;
	}

	/**
	 * @param null $db
	 * @return array
	 */
	public function getAll($db = null): array
	{
		if (is_null($db)):
			$db = new myDBC();
		endif;

		$stmt = $db->Prepare("SELECT ser_id FROM uc_servicio WHERE ser_activo IS TRUE ORDER BY ser_nombre");
		$stmt->execute();
		$result = $stmt->get_result();
		$lista = [];

		while ($row = $result->fetch_assoc()):
			$lista[] = $this->get($row['ser_id']);
		endwhile;

		unset($db);
		return $lista;
	}

	/**
	 * @param $us
	 * @param null $db
	 * @return array
	 */
	public function getByUser($us, $db = null): array
	{
		if (is_null($db)):
			$db = new myDBC();
		endif;

		$stmt = $db->Prepare("SELECT ser_id FROM uc_usuario_servicio WHERE us_id = ?");
		$stmt->bind_param("i", $us);
		$stmt->execute();
		$result = $stmt->get_result();
		$lista = [];

		while ($row = $result->fetch_assoc()):
			$lista[] = $this->get($row['ser_id']);
		endwhile;

		unset($db);
		return $lista;
	}

}