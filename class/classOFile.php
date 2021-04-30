<?php

class OFile {

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
		$stmt = $db->Prepare("SELECT a.*, u.us_username, f.fol_nombre FROM uc_oarchivo a 
                                JOIN uc_folder f ON a.fol_id = f.fol_id
                                JOIN uc_usuario u ON a.us_id = u.us_id
                                WHERE oarc_id = ?");

		$stmt->bind_param("i", $id);
		$stmt->execute();
		$result = $stmt->get_result();
		$obj = new stdClass();

		$row = $result->fetch_assoc();
		$obj->oarc_id = $row['oarc_id'];
		$obj->oarc_user = utf8_encode($row['us_username']);
		$obj->oarc_folder = utf8_encode($row['fol_nombre']);
		$obj->oarc_nombre = utf8_encode($row['oarc_nombre']);
		$obj->oarc_edicion = utf8_encode($row['oarc_edicion']);
		$obj->oarc_fecha = $row['oarc_fecha'];
		$obj->oarc_fecha_crea = $row['oarc_fecha_crea'];
		$obj->oarc_fecha_vig = $row['oarc_fecha_vig'];
		$obj->oarc_descargas = $row['oarc_descargas'];
		$obj->oarc_path = utf8_encode($row['oarc_path']);
		$obj->oarc_ext = pathinfo($row['oarc_path'], PATHINFO_EXTENSION);
		$obj->oarc_publicado = $row['oarc_publicado'];

		unset($db);
		return $obj;
	}

	/**
	 * @return array
	 */
	public function getAll(): array
	{
		$db = new myDBC();
		$result = $db->runQuery("SELECT oarc_id FROM uc_oarchivo ORDER BY oarc_nombre");
		$lista = [];

		while ($row = $result->fetch_assoc()):
			$lista[] = $this->get($row['oarc_id']);
		endwhile;

		unset($db);
		return $lista;
	}

	/**
	 * @param $fid
	 * @return array
	 */
	public function getByFolder($fid): array
	{
		$db = new myDBC();
		$stmt = $db->Prepare("SELECT oarc_id FROM uc_oarchivo a
                                JOIN uc_folder f ON a.fol_id = f.fol_id
                                WHERE f.fol_id = ? AND oarc_publicado IS TRUE");

		$stmt->bind_param("i", $fid);
		$stmt->execute();
		$result = $stmt->get_result();
		$lista = [];

		while ($row = $result->fetch_assoc()):
			$lista[] = $this->get($row['oarc_id']);
		endwhile;

		unset($db);
		return $lista;
	}

	/**
	 * @param $fol_id
	 * @param $user_id
	 * @param $oarc_nombre
	 * @param $oarc_edicion
	 * @param $oarc_fecha_crea
	 * @param $oarc_fecha_vig
	 * @param null $db
	 * @return array
	 */
	public function set($fol_id, $user_id, $oarc_nombre, $oarc_edicion, $oarc_fecha_crea, $oarc_fecha_vig, $db = null): array
	{
		if (is_null($db)):
			$db = new myDBC();
		endif;

		$publ = 1;
		$desc = 0;
		$date = date("Y-m-d");

		try {
			$stmt = $db->Prepare("INSERT INTO uc_oarchivo (fol_id, us_id, oarc_nombre, oarc_edicion, oarc_fecha, oarc_fecha_crea, oarc_fecha_vig, oarc_descargas, oarc_publicado)
                                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");

			if (!$stmt):
				throw new Exception("La inserción del documento falló en su preparación.");
			endif;

			$oarc_nombre = $db->clearText(utf8_decode($oarc_nombre));
			$oarc_edicion = $db->clearText(utf8_decode($oarc_edicion));
			$oarc_fecha_crea = $db->clearText($oarc_fecha_crea);
			$oarc_fecha_vig = $db->clearText($oarc_fecha_vig);
			$bind = $stmt->bind_param("iisssssii", $fol_id, $user_id, $oarc_nombre, $oarc_edicion, $date, $oarc_fecha_crea, $oarc_fecha_vig, $desc, $publ);
			if (!$bind):
				throw new Exception("La inserción del documento falló en su binding.");
			endif;

			if (!$stmt->execute()):
				throw new Exception("La inserción del documento falló en su ejecución.");
			endif;

			return array('estado' => true, 'msg' => $stmt->insert_id);
		} catch (Exception $e) {
			return array('estado' => false, 'msg' => $e->getMessage());
		}
	}

	/**
	 * @param $oarc_id
	 * @param $oarc_path
	 * @param null $db
	 * @return array
	 */
	public function setPath($oarc_id, $oarc_path, $db = null): array
	{
		if (is_null($db)):
			$db = new myDBC();
		endif;

		try {
			$stmt = $db->Prepare("UPDATE uc_oarchivo SET oarc_path = ? WHERE oarc_id = ?");

			if (!$stmt):
				throw new Exception("La inserción del documento-path falló en su preparación.");
			endif;

			$bind = $stmt->bind_param("si", $oarc_path, $oarc_id);
			if (!$bind):
				throw new Exception("La inserción del documento-path falló en su binding.");
			endif;

			if (!$stmt->execute()):
				throw new Exception("La inserción del documento-path falló en su ejecución.");
			endif;

			return array('estado' => true, 'msg' => $oarc_id);
		} catch (Exception $e) {
			return array('estado' => false, 'msg' => $e->getMessage());
		}
	}

	/**
	 * @param $id
	 * @return stdClass
	 */
	public function setCounter($id): stdClass
	{
		$db = new myDBC();
		$stmt = $db->Prepare("SELECT oarc_descargas AS num, oarc_path AS path FROM uc_oarchivo WHERE oarc_id = ?");

		$stmt->bind_param("i", $id);
		$stmt->execute();
		$result = $stmt->get_result();
		$obj = new stdClass();

		$row = $result->fetch_assoc();
		$obj->oarc_down = $row['num'] + 1;
		$obj->oarc_path = utf8_encode($row['path']);

		$stmt = $db->Prepare("UPDATE uc_oarchivo SET oarc_descargas = ? WHERE oarc_id = ?");

		$stmt->bind_param("ii", $obj->oarc_down, $id);

		$stmt->execute();
		unset($db);
		return $obj;
	}

	/**
	 * @param $id
	 * @param $folder
	 * @param null $db
	 * @return array
	 */
	public function del($id, $folder, $db = null): array
	{
		if (is_null($db)):
			$db = new myDBC();
		endif;

		try {
			$r = $db->runQuery("SELECT oarc_path FROM uc_oarchivo ORDER BY oarc_nombre");
			$p = $r->fetch_assoc();

			$stmt = $db->Prepare("DELETE FROM uc_oarchivo WHERE oarc_id = ?");

			if (!$stmt):
				throw new Exception("La eliminación del documento falló en su preparación.");
			endif;

			$bind = $stmt->bind_param("i", $id);
			if (!$bind):
				throw new Exception("La eliminación del documento falló en su binding.");
			endif;

			if (!$stmt->execute()):
				throw new Exception("La eliminación del documento falló en su ejecución.");
			endif;

			if (!unlink($_SERVER['DOCUMENT_ROOT'] . $folder . $p['oarc_path'])):
				throw new Exception("La eliminación del documento falló al eliminar el archivo.");
			endif;

			return array('estado' => true, 'msg' => '');
		} catch (Exception $e) {
			return array('estado' => false, 'msg' => $e->getMessage());
		}
	}
}