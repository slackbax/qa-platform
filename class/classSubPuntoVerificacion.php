<?php

class SubPuntoVerificacion {

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
									FROM uc_subpunto_verif sp
									JOIN uc_punto_verificacion v on sp.pv_id = v.pv_id
									WHERE spv_id = ?");
		$stmt->bind_param("i", $id);
		$stmt->execute();
		$result = $stmt->get_result();
		$obj = new stdClass();

		$row = $result->fetch_assoc();
		$obj->spv_id = $row['spv_id'];
		$obj->spv_pvid = $row['pv_id'];
		$obj->spv_nombre = utf8_encode($row['spv_nombre']);
		$obj->spv_pvnombre = utf8_encode($row['pv_nombre']);

		unset($db);
		return $obj;
	}

	/**
	 * @return array
	 */
	public function getAll()
	{
		$db = new myDBC();
		$stmt = $db->Prepare("SELECT spv_id 
								  FROM uc_subpunto_verif sp
								  JOIN uc_punto_verificacion v on sp.pv_id = v.pv_id
								  ORDER BY pv_nombre ASC, spv_nombre ASC");
		$stmt->execute();
		$result = $stmt->get_result();
		$lista = [];

		while ($row = $result->fetch_assoc()):
			$lista[] = $this->get($row['spv_id']);
		endwhile;

		unset($db);
		return $lista;
	}

	/**
	 * @return int
	 */
	public function getNumber()
	{
		$db = new myDBC();
		$stmt = $db->Prepare("SELECT COUNT(spv_id) AS num FROM uc_subpunto_verif");

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
	public function getByPV($id)
	{
		$db = new myDBC();
		$stmt = $db->Prepare("SELECT DISTINCT(spv_id) FROM uc_indicador i
									JOIN uc_pv_indicador pvi ON i.ind_id = pvi.ind_id
									JOIN uc_punto_verificacion pv ON pvi.pv_id = pv.pv_id
									JOIN uc_subpunto_verif spv ON pv.pv_id = spv.pv_id
									WHERE i.ind_id = ?");

		$stmt->bind_param("i", $id);
		$stmt->execute();
		$result = $stmt->get_result();
		$lista = [];

		while ($row = $result->fetch_assoc()):
			$lista[] = $this->get($row['spv_id']);
		endwhile;

		unset($db);
		return $lista;
	}

	/**
	 * @param $ie
	 * @param $spv
	 * @param null $db
	 * @return array
	 */
	public function set($ie, $spv, $db = null)
	{
		if (is_null($db)):
			$db = new myDBC();
		endif;

		try {
			$stmt = $db->Prepare("INSERT INTO uc_indesp_subpunto (spv_id, ine_id) VALUES (?, ?)");

			if (!$stmt):
				throw new Exception("La inserción del indicador-pv falló en su preparación.");
			endif;

			$bind = $stmt->bind_param("ii", $spv, $ie);

			if (!$bind):
				throw new Exception("La inserción del indicador-pv falló en su binding.");
			endif;

			if (!$stmt->execute()):
				throw new Exception("La inserción del indicador-pv falló en su ejecución.");
			endif;

			$result = array('estado' => true, 'msg' => 'OK');
			return $result;
		} catch (Exception $e) {
			$result = array('estado' => false, 'msg' => $e->getMessage());
			return $result;
		}
	}
}