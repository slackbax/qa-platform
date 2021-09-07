<?php

class SubtipoEvento {

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
		$stmt = $db->Prepare("SELECT * FROM uc_subtipo_evento se
                                    JOIN uc_categoria c ON se.cat_id = c.cat_id
                                    WHERE stev_id = ?");
		$stmt->bind_param("i", $id);
		$stmt->execute();
		$result = $stmt->get_result();
		$obj = new stdClass();

		$row = $result->fetch_assoc();
		$obj->stev_id = $row['stev_id'];
		$obj->tev_id = $row['tev_id'];
		$obj->cat_id = $row['cat_id'];
		$obj->cat_desc = $row['cat_descripcion'];
		$obj->stev_descripcion = utf8_encode($row['stev_descripcion']);

		unset($db);
		return $obj;
	}

	/**
	 * @return array
	 */
	public function getAll(): array
	{
		$db = new myDBC();
		$stmt = $db->Prepare("SELECT stev_id FROM uc_subtipo_evento");
		$stmt->execute();
		$result = $stmt->get_result();
		$lista = [];

		while ($row = $result->fetch_assoc()):
			$lista[] = $this->get($row['stev_id']);
		endwhile;

		unset($db);
		return $lista;
	}

	/**
	 * @param $id
	 * @return array
	 */
	public function getByTipo($id): array
	{
		$db = new myDBC();
		$stmt = $db->Prepare("SELECT stev_id FROM uc_subtipo_evento WHERE tev_id = ? ORDER BY stev_descripcion");
		$stmt->bind_param("i", $id);
		$stmt->execute();
		$result = $stmt->get_result();
		$lista = [];

		while ($row = $result->fetch_assoc()):
			$lista[] = $this->get($row['stev_id']);
		endwhile;

		unset($db);
		return $lista;
	}
}