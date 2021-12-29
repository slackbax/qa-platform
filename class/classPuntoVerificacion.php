<?php

class PuntoVerificacion {

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
		$stmt = $db->Prepare("SELECT * FROM uc_punto_verificacion WHERE pv_id = ?");
		$stmt->bind_param("i", $id);
		$stmt->execute();
		$result = $stmt->get_result();
		$obj = new stdClass();

		$row = $result->fetch_assoc();
		$obj->pv_id = $row['pv_id'];
		$obj->pv_nombre = utf8_encode($row['pv_nombre']);
		$obj->pv_descripcion = utf8_encode($row['pv_descripcion']);
		$obj->pv_icon = utf8_encode($row['pv_icon']);

		unset($db);
		return $obj;
	}

	/**
	 * @return array
	 */
	public function getAll(): array
	{
		$db = new myDBC();
		$stmt = $db->Prepare("SELECT pv_id FROM uc_punto_verificacion WHERE pv_activo IS TRUE ORDER BY pv_nombre");
		$stmt->execute();
		$result = $stmt->get_result();
		$lista = [];

		while ($row = $result->fetch_assoc()):
			$lista[] = $this->get($row['pv_id']);
		endwhile;

		unset($db);
		return $lista;
	}

	/**
	 * @param $ind
	 * @return array
	 */
	public function getByInd($ind): array
	{
		$db = new myDBC();
		$stmt = $db->Prepare("SELECT pv_id FROM uc_pv_indicador WHERE ind_id = ? AND pv_id <> 1");

		$stmt->bind_param("i", $ind);
		$stmt->execute();
		$result = $stmt->get_result();
		$lista = [];

		while ($row = $result->fetch_assoc()):
			$lista[] = $this->get($row['pv_id']);
		endwhile;

		unset($db);
		return $lista;
	}
}
