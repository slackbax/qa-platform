<?php

class TipoCaracteristica {

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
		$stmt = $db->Prepare("SELECT * FROM uc_tipo_caracteristica WHERE tcar_id = ?");
		$stmt->bind_param("i", $id);
		$stmt->execute();
		$result = $stmt->get_result();
		$obj = new stdClass();

		$row = $result->fetch_assoc();
		$obj->tcar_id = $row['tcar_id'];
		$obj->tcar_nombre = utf8_encode($row['tcar_nombre']);

		unset($db);
		return $obj;
	}

	/**
	 * @return array
	 */
	public function getAll()
	{
		$db = new myDBC();
		$stmt = $db->Prepare("SELECT tcar_id FROM uc_tipo_caracteristica");
		$stmt->execute();
		$result = $stmt->get_result();
		$lista = [];

		while ($row = $result->fetch_assoc()):
			$lista[] = $this->get($row['tcar_id']);
		endwhile;

		unset($db);
		return $lista;
	}

	/**
	 * @param $id
	 * @return array
	 */
	public function getBySubAmb($id)
	{
		$db = new myDBC();
		$stmt = $db->Prepare("SELECT DISTINCT(i.tcar_id) FROM uc_indicador i
                                JOIN uc_tipo_caracteristica tc ON i.tcar_id = tc.tcar_id
                                WHERE i.samb_id = ?
                                ORDER BY i.tcar_id ASC");

		$stmt->bind_param("i", $id);
		$stmt->execute();
		$result = $stmt->get_result();
		$lista = [];

		while ($row = $result->fetch_assoc()):
			$lista[] = $this->get($row['tcar_id']);
		endwhile;

		unset($db);
		return $lista;
	}

	/**
	 * @param $id
	 * @param $tcar
	 * @return mixed
	 */
	public function getNumFiles($id, $tcar)
	{
		$db = new myDBC();
		$stmt = $db->Prepare("SELECT COUNT(*) AS num FROM uc_archivo a
                                JOIN uc_indicador i ON a.ind_id = i.ind_id
                                JOIN uc_tipo_caracteristica tc ON i.tcar_id = tc.tcar_id
                                WHERE i.samb_id = ? AND i.tcar_id = ? AND a.arc_publicado = TRUE");

		$stmt->bind_param("ii", $id, $tcar);
		$stmt->execute();
		$result = $stmt->get_result();

		$row = $result->fetch_assoc();
		$num = $row['num'];

		unset($db);
		return $num;
	}

	/**
	 * @param $spvid
	 * @param $tcar
	 * @return mixed
	 */
	public function getNumFilesBySPV($spvid, $tcar)
	{
		$db = new myDBC();
		$stmt = $db->Prepare("SELECT COUNT(*) AS num FROM uc_archivo a
                                JOIN uc_archivo_subpuntoverif ap ON a.arc_id = ap.arc_id
                                JOIN uc_indicador i ON a.ind_id = i.ind_id
                                JOIN uc_tipo_caracteristica tc ON i.tcar_id = tc.tcar_id
                                WHERE ap.spv_id = ? AND i.tcar_id = ? AND a.arc_publicado = TRUE");

		$stmt->bind_param("ii", $spvid, $tcar);
		$stmt->execute();
		$result = $stmt->get_result();

		$row = $result->fetch_assoc();
		$num = $row['num'];

		unset($db);
		return $num;
	}
}