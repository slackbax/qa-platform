<?php

class Folder {

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
		$stmt = $db->Prepare("SELECT * FROM uc_folder WHERE fol_id = ?");
		$stmt->bind_param("i", $id);
		$stmt->execute();
		$result = $stmt->get_result();
		$obj = new stdClass();

		$row = $result->fetch_assoc();
		$obj->fol_id = $row['fol_id'];
		$obj->fol_parent_id = $row['fol_parent_id'];
		$obj->fol_nombre = utf8_encode($row['fol_nombre']);
		$obj->fol_descripcion = utf8_encode($row['fol_descripcion']);
		$obj->fol_fecha = $row['fol_fecha'];
		$obj->fol_publicado = $row['fol_publicado'];

		unset($db);
		return $obj;
	}

	/**
	 * @return array
	 */
	public function getAll()
	{
		$db = new myDBC();
		$stmt = $db->Prepare("SELECT fol_id FROM uc_folder WHERE fol_publicado = TRUE ORDER BY fol_nombre ASC");
		$stmt->execute();
		$result = $stmt->get_result();
		$lista = array();

		while ($row = $result->fetch_assoc()):
			$lista[] = $this->get($row['fol_id']);
		endwhile;

		unset($db);
		return $lista;
	}

	/**
	 * @return array
	 */
	public function getMain()
	{
		$db = new myDBC();
		$stmt = $db->Prepare("SELECT * FROM uc_folder WHERE fol_publicado = TRUE AND fol_parent_id IS NULL ORDER BY fol_nombre ASC");
		$stmt->execute();
		$result = $stmt->get_result();
		$lista = array();

		while ($row = $result->fetch_assoc()):
			$lista[] = $this->get($row['fol_id']);
		endwhile;

		unset($db);
		return $lista;
	}

	/**
	 * @return array
	 */
	public function getLesser()
	{
		$db = new myDBC();
		$stmt = $db->Prepare("SELECT * FROM uc_folder WHERE fol_publicado = TRUE AND fol_parent_id IS NOT NULL ORDER BY fol_nombre ASC");
		$stmt->execute();
		$result = $stmt->get_result();
		$lista = array();

		while ($row = $result->fetch_assoc()):
			$lista[] = $this->get($row['fol_id']);
		endwhile;

		unset($db);
		return $lista;
	}

	/**
	 * @param $id
	 * @return array
	 */
	public function getChildren($id)
	{
		$db = new myDBC();
		$stmt = $db->Prepare("SELECT * FROM uc_folder WHERE fol_publicado = TRUE AND fol_parent_id = ? ORDER BY fol_nombre ASC");
		$stmt->bind_param("i", $id);
		$stmt->execute();
		$result = $stmt->get_result();
		$lista = array();

		while ($row = $result->fetch_assoc()):
			$lista[] = $this->get($row['fol_id']);
		endwhile;

		unset($db);
		return $lista;
	}

	/**
	 * @param $id
	 * @return mixed
	 */
	public function getNumFiles($id)
	{
		$db = new myDBC();
		$stmt = $db->Prepare("SELECT COUNT(oarc_id) AS filecount FROM uc_oarchivo WHERE oarc_publicado = TRUE AND fol_id = ?");
		$stmt->bind_param("i", $id);
		$stmt->execute();
		$result = $stmt->get_result();
		$row = $result->fetch_assoc();
		unset($db);

		return $row['filecount'];
	}

	/**
	 * @param $fol_nombre
	 * @param $fol_desc
	 * @param null $menu_id
	 * @param null $fol_p
	 * @param null $db
	 * @return array
	 */
	public function set($fol_nombre, $fol_desc, $menu_id = null, $fol_p = null, $db = null)
	{
		if (is_null($db)):
			$db = new myDBC();
		endif;

		try {
			if (is_null($menu_id)):
				$_qcol = 'fol_parent_id';
			endif;

			if (is_null($fol_p)):
				$_qcol = 'men_id';
			endif;

			$stmt = $db->Prepare("INSERT INTO uc_folder (fol_nombre, fol_descripcion, fol_fecha, fol_publicado, " . $_qcol . ") VALUES (?, ?, CURRENT_DATE, TRUE, ?)");

			if (!$stmt):
				throw new Exception("La inserción del directorio falló en su preparación.");
			endif;

			$bind = true;

			if (is_null($menu_id)):
				$bind = $stmt->bind_param("ssi", utf8_decode($db->clearText($fol_nombre)), utf8_decode($db->clearText($fol_desc)), $fol_p);
			endif;
			if (is_null($fol_p)):
				$bind = $stmt->bind_param("ssi", utf8_decode($db->clearText($fol_nombre)), utf8_decode($db->clearText($fol_desc)), $menu_id);
			endif;

			if (!$bind):
				throw new Exception("La inserción del directorio falló en su binding.");
			endif;

			if (!$stmt->execute()):
				throw new Exception("La inserción del directorio falló en su ejecución.");
			endif;

			$result = array('estado' => true, 'msg' => $stmt->insert_id);
			return $result;
		} catch (Exception $e) {
			$result = array('estado' => false, 'msg' => $e->getMessage());
			return $result;
		}
	}

	/**
	 * @param $id
	 * @param $fol_nombre
	 * @param $fol_desc
	 * @param $fol_publicado
	 * @param null $db
	 * @return array
	 */
	public function mod($id, $fol_nombre, $fol_desc, $fol_publicado, $db = null)
	{
		if (is_null($db)):
			$db = new myDBC();
		endif;

		try {
			$stmt = $db->Prepare("UPDATE uc_folder SET fol_nombre = ?, fol_descripcion = ?, fol_publicado = ? WHERE fol_id = ?");

			if (!$stmt):
				throw new Exception("La edición del directorio falló en su preparación.");
			endif;

			$bind = $stmt->bind_param("sssi", utf8_decode($db->clearText($fol_nombre)), utf8_decode($db->clearText($fol_desc)), $db->clearText($fol_publicado), $id);

			if (!$bind):
				throw new Exception("La edición del directorio falló en su binding.");
			endif;

			if (!$stmt->execute()):
				throw new Exception("La edición del directorio falló en su ejecución.");
			endif;

			$result = array('estado' => true, 'msg' => $stmt->insert_id);
			return $result;
		} catch (Exception $e) {
			$result = array('estado' => false, 'msg' => $e->getMessage());
			return $result;
		}
	}
}