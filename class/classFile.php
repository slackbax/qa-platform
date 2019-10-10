<?php

class File {

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
		$stmt = $db->Prepare("SELECT a.*, am.amb_id, i.ind_id, i.ind_descripcion, i.tcar_id, s.samb_id, s.samb_sigla, u.us_username, c.cod_id, c.cod_descripcion FROM uc_archivo a 
                                JOIN uc_indicador i ON a.ind_id = i.ind_id
                                JOIN uc_subambito s ON i.samb_id = s.samb_id
                                JOIN uc_ambito am ON s.amb_id = am.amb_id
                                JOIN uc_usuario u ON a.us_id = u.us_id
                                JOIN uc_codigo c ON i.cod_id = c.cod_id
                                WHERE arc_id = ?");

		$stmt->bind_param("i", $id);
		$stmt->execute();
		$result = $stmt->get_result();
		$obj = new stdClass();

		$row = $result->fetch_assoc();
		$obj->arc_id = $row['arc_id'];
		$obj->arc_user = utf8_encode($row['us_username']);
		$obj->arc_amb = $row['amb_id'];
		$obj->arc_samb = $row['samb_id'];
		$obj->arc_sigla = utf8_encode($row['samb_sigla']);
		$obj->arc_tcar = $row['tcar_id'];
		$obj->arc_codid = $row['cod_id'];
		$obj->arc_cod = utf8_encode($row['cod_descripcion']);
		$obj->arc_indid = $row['ind_id'];
		$obj->arc_ind = utf8_encode($row['ind_descripcion']);
		$obj->arc_char = utf8_encode($row['samb_sigla'] . ' ' . $row['cod_descripcion'] . ' - ' . $row['ind_descripcion']);
		$obj->arc_nombre = utf8_encode($row['arc_nombre']);
		$obj->arc_codigo = utf8_encode($row['arc_codigo']);
		$obj->arc_edicion = utf8_encode($row['arc_edicion']);
		$obj->arc_fecha = $row['arc_fecha'];
		$obj->arc_fecha_crea = $row['arc_fecha_crea'];
		$obj->arc_fecha_vig = $row['arc_fecha_vig'];
		$obj->arc_descargas = $row['arc_descargas'];
		$obj->arc_path = utf8_encode($row['arc_path']);
		$obj->arc_ext = pathinfo($row['arc_path'], PATHINFO_EXTENSION);
		$obj->arc_publicado = $row['arc_publicado'];

		$stmt_pv = $db->Prepare("SELECT spv_nombre FROM uc_subpunto_verif spv 
                                JOIN uc_archivo_subpuntoverif ap ON spv.spv_id = ap.spv_id
                                WHERE arc_id = ?");

		$stmt_pv->bind_param("i", $id);
		$stmt_pv->execute();
		$result_pv = $stmt_pv->get_result();
		$array = [];

		while ($row = $result_pv->fetch_assoc()):
			$array[] = utf8_encode($row['spv_nombre']);
		endwhile;

		$obj->arc_pvs = $array;

		unset($db);
		return $obj;
	}

	/**
	 * @return array
	 */
	public function getAll()
	{
		$db = new myDBC();
		$stmt = $db->Prepare("SELECT arc_id FROM uc_archivo WHERE arc_publicado = TRUE");

		$stmt->execute();
		$result = $stmt->get_result();
		$lista = [];

		while ($row = $result->fetch_assoc()):
			$lista[] = $this->get($row['arc_id']);
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
		$stmt = $db->Prepare("SELECT COUNT(DISTINCT a.arc_id) AS num 
								FROM uc_archivo a
								JOIN uc_archivo_subpuntoverif ap ON a.arc_id = ap.arc_id
								JOIN uc_subpunto_verif usv on ap.spv_id = usv.spv_id
								WHERE arc_publicado = TRUE AND pv_id <> '99'");

		$stmt->execute();
		$result = $stmt->get_result();
		$row = $result->fetch_assoc();

		unset($db);
		return $row['num'];
	}

	/**
	 * @param $pvid
	 * @return mixed
	 */
	public function getNumberByPV($pvid)
	{
		$db = new myDBC();
		$stmt = $db->Prepare("SELECT COUNT(DISTINCT a.arc_id) AS num
                                FROM uc_archivo a
								JOIN uc_archivo_subpuntoverif ap ON a.arc_id = ap.arc_id
								JOIN uc_subpunto_verif usv on ap.spv_id = usv.spv_id
                                WHERE usv.pv_id = ? AND a.arc_publicado = TRUE");

		$stmt->bind_param("i", $pvid);
		$stmt->execute();
		$result = $stmt->get_result();

		$row = $result->fetch_assoc();
		$num = $row['num'];

		unset($db);
		return $num;
	}

	/**
	 * @param $sid
	 * @param $tcar
	 * @return array
	 */
	public function getByCaractSamb($sid, $tcar)
	{
		$db = new myDBC();
		$stmt = $db->Prepare("SELECT a.arc_id FROM uc_archivo a
                                JOIN uc_indicador i ON a.ind_id = i.ind_id
                                JOIN uc_tipo_caracteristica tc ON i.tcar_id = tc.tcar_id
                                WHERE tc.tcar_id = ? AND i.samb_id = ? AND a.arc_publicado = TRUE");

		$stmt->bind_param("ii", $tcar, $sid);
		$stmt->execute();
		$result = $stmt->get_result();
		$lista = [];

		while ($row = $result->fetch_assoc()):
			$lista[] = $this->get($row['arc_id']);
		endwhile;

		unset($db);
		return $lista;
	}

	/**
	 * @param $pvid
	 * @return array
	 */
	public function getByPV($pvid)
	{
		$db = new myDBC();
		$stmt = $db->Prepare("SELECT a.arc_id FROM uc_archivo a
                                JOIN uc_archivo_puntoverif ap ON a.arc_id = ap.arc_id
                                WHERE ap.pv_id = ? AND a.arc_publicado = TRUE");

		$stmt->bind_param("i", $pvid);
		$stmt->execute();
		$result = $stmt->get_result();
		$lista = [];

		while ($row = $result->fetch_assoc()):
			$lista[] = $this->get($row['arc_id']);
		endwhile;

		unset($db);
		return $lista;
	}

	/**
	 * @param $spvid
	 * @param $tcar
	 * @return array
	 */
	public function getByCaractSPV($spvid, $tcar)
	{
		$db = new myDBC();
		$stmt = $db->Prepare("SELECT a.arc_id FROM uc_archivo a
                                JOIN uc_indicador i ON a.ind_id = i.ind_id
                                JOIN uc_tipo_caracteristica tc ON i.tcar_id = tc.tcar_id
                                JOIN uc_archivo_subpuntoverif ap ON a.arc_id = ap.arc_id
                                WHERE ap.spv_id = ? AND tc.tcar_id = ? AND a.arc_publicado = TRUE");

		$stmt->bind_param("ii", $spvid, $tcar);
		$stmt->execute();
		$result = $stmt->get_result();
		$lista = [];

		while ($row = $result->fetch_assoc()):
			$lista[] = $this->get($row['arc_id']);
		endwhile;

		unset($db);
		return $lista;
	}

	/**
	 * @return array
	 */
	public function getTrans()
	{
		$db = new myDBC();
		$stmt = $db->Prepare("SELECT a.arc_id FROM uc_archivo a
                                JOIN uc_archivo_subpuntoverif ap ON a.arc_id = ap.arc_id
								JOIN uc_subpunto_verif usv on ap.spv_id = usv.spv_id
                                WHERE usv.pv_id = 1 AND a.arc_publicado = TRUE");

		$stmt->execute();
		$result = $stmt->get_result();
		$lista = [];

		while ($row = $result->fetch_assoc()):
			$lista[] = $this->get($row['arc_id']);
		endwhile;

		unset($db);
		return $lista;
	}

	/**
	 * @param $time
	 * @return array
	 */
	public function getExpiring($time)
	{
		$db = new myDBC();

		$stmt = $db->Prepare("SELECT a.arc_id FROM uc_archivo a
                                WHERE a.arc_fecha_vig >= DATE(now())
                                AND a.arc_fecha_vig <= DATE_ADD(DATE(now()), INTERVAL ? MONTH)
                                AND a.arc_publicado = TRUE
                                ORDER BY a.arc_fecha_vig ASC");

		$stmt->bind_param("i", $time);
		$stmt->execute();
		$result = $stmt->get_result();
		$lista = [];

		while ($row = $result->fetch_assoc()):
			$lista[] = $this->get($row['arc_id']);
		endwhile;

		unset($db);
		return $lista;
	}

	/**
	 * @param $num
	 * @return array
	 */
	public function getLast($num)
	{
		$db = new myDBC();

		$stmt = $db->Prepare("SELECT a.arc_id FROM uc_archivo a
                                WHERE a.arc_publicado = TRUE
                                ORDER BY a.arc_fecha DESC, a.arc_id DESC
                                LIMIT ?");

		$stmt->bind_param("i", $num);
		$stmt->execute();
		$result = $stmt->get_result();
		$lista = [];

		while ($row = $result->fetch_assoc()):
			$lista[] = $this->get($row['arc_id']);
		endwhile;

		unset($db);
		return $lista;
	}

	/**
	 * @param $ind_id
	 * @param $user_id
	 * @param $arc_nombre
	 * @param $arc_codigo
	 * @param $arc_edicion
	 * @param $arc_fecha_crea
	 * @param $arc_fecha_vig
	 * @param $db
	 * @return array
	 */
	public function set($ind_id, $user_id, $arc_nombre, $arc_codigo, $arc_edicion, $arc_fecha_crea, $arc_fecha_vig, $db = null)
	{
		if (is_null($db)):
			$db = new myDBC();
		endif;

		try {
			$stmt = $db->Prepare("INSERT INTO uc_archivo (ind_id, us_id, arc_nombre, arc_codigo, arc_edicion, arc_fecha, arc_fecha_crea, arc_fecha_vig, arc_descargas, arc_publicado)
                                    VALUES (?, ?, ?, ?, ?, CURRENT_DATE, ?, ?, '0', TRUE)");

			if (!$stmt):
				throw new Exception("La inserción del documento falló en su preparación.");
			endif;

			$bind = $stmt->bind_param("iisssss", $ind_id, $user_id, $db->clearText(utf8_decode($arc_nombre)), $db->clearText(utf8_decode($arc_codigo)), $db->clearText(utf8_decode($arc_edicion)),
				$db->clearText($arc_fecha_crea), $db->clearText($arc_fecha_vig));
			if (!$bind):
				throw new Exception("La inserción del documento falló en su binding.");
			endif;

			if (!$stmt->execute()):
				throw new Exception("La inserción del documento falló en su ejecución.");
			endif;

			$result = array('estado' => true, 'msg' => $stmt->insert_id);
			return $result;
		} catch (Exception $e) {
			$result = array('estado' => false, 'msg' => $e->getMessage());
			return $result;
		}
	}

	/**
	 * @param $arc_id
	 * @param $pv_id
	 * @param $db
	 * @return array
	 */
	public function setFilePV($arc_id, $pv_id, $db = null)
	{
		if (is_null($db)):
			$db = new myDBC();
		endif;

		try {
			$stmt = $db->Prepare("INSERT INTO uc_archivo_puntoverif (pv_id, arc_id) VALUES (?, ?)");

			if (!$stmt):
				throw new Exception("La inserción del documento-pv falló en su preparación.");
			endif;

			$bind = $stmt->bind_param("ii", $pv_id, $arc_id);
			if (!$bind):
				throw new Exception("La inserción del documento-pv falló en su binding.");
			endif;

			if (!$stmt->execute()):
				throw new Exception("La inserción del documento-pv falló en su ejecución." . $stmt->error);
			endif;

			$result = array('estado' => true, 'msg' => $stmt->insert_id);
			return $result;
		} catch (Exception $e) {
			$result = array('estado' => false, 'msg' => $e->getMessage());
			return $result;
		}
	}

	/**
	 * @param $arc_id
	 * @param $spv_id
	 * @param null $db
	 * @return array
	 */
	public function setFileSpv($arc_id, $spv_id, $db = null)
	{
		if (is_null($db)):
			$db = new myDBC();
		endif;

		try {
			$stmt = $db->Prepare("INSERT INTO uc_archivo_subpuntoverif (spv_id, arc_id) VALUES (?, ?)");

			if (!$stmt):
				throw new Exception("La inserción del documento-spv falló en su preparación.");
			endif;

			$bind = $stmt->bind_param("ii", $spv_id, $arc_id);
			if (!$bind):
				throw new Exception("La inserción del documento-spv falló en su binding.");
			endif;

			if (!$stmt->execute()):
				throw new Exception("La inserción del documento-spv falló en su ejecución." . $stmt->error);
			endif;

			$result = array('estado' => true, 'msg' => $stmt->insert_id);
			return $result;
		} catch (Exception $e) {
			$result = array('estado' => false, 'msg' => $e->getMessage());
			return $result;
		}
	}

	/**
	 * @param $arc_id
	 * @param $arc_path
	 * @param $db
	 * @return array
	 */
	public function setPath($arc_id, $arc_path, $db = null)
	{
		if (is_null($db)):
			$db = new myDBC();
		endif;

		try {
			$stmt = $db->Prepare("UPDATE uc_archivo SET arc_path = ? WHERE arc_id = ?");

			if (!$stmt):
				throw new Exception("La inserción del documento-path falló en su preparación.");
			endif;

			$bind = $stmt->bind_param("si", $arc_path, $arc_id);
			if (!$bind):
				throw new Exception("La inserción del documento-path falló en su binding.");
			endif;

			if (!$stmt->execute()):
				throw new Exception("La inserción del documento-path falló en su ejecución.");
			endif;

			$result = array('estado' => true, 'msg' => $arc_id);
			return $result;
		} catch (Exception $e) {
			$result = array('estado' => false, 'msg' => $e->getMessage());
			return $result;
		}
	}

	/**
	 * @param $id
	 * @return stdClass
	 */
	public function setCounter($id)
	{
		$db = new myDBC();
		$stmt = $db->Prepare("SELECT arc_descargas AS num, arc_path AS path FROM uc_archivo WHERE arc_id = ?");

		$stmt->bind_param("i", $id);
		$stmt->execute();
		$result = $stmt->get_result();
		$obj = new stdClass();

		$row = $result->fetch_assoc();
		$obj->arc_down = $row['num'] + 1;
		$obj->arc_path = utf8_encode($row['path']);

		$stmt = $db->Prepare("UPDATE uc_archivo SET arc_descargas = ? WHERE arc_id = ?");

		$stmt->bind_param("ii", $obj->arc_down, $id);

		$stmt->execute();
		unset($db);
		return $obj;
	}

	/**
	 * @param $id
	 * @param $ind_id
	 * @param $user_id
	 * @param $arc_nombre
	 * @param $arc_codigo
	 * @param $arc_edicion
	 * @param $arc_fecha_crea
	 * @param $arc_fecha_vig
	 * @param $db
	 * @return array
	 */
	public function mod($id, $ind_id, $user_id, $arc_nombre, $arc_codigo, $arc_edicion, $arc_fecha_crea, $arc_fecha_vig, $db = null)
	{
		if (is_null($db)):
			$db = new myDBC();
		endif;

		$date = date("Y-m-d");

		try {
			$stmt = $db->Prepare("UPDATE uc_archivo SET ind_id = ?, us_id = ?, arc_nombre = ?, arc_codigo = ?, arc_edicion = ?, arc_fecha = ?, arc_fecha_crea = ?, arc_fecha_vig = ?
                                    WHERE arc_id = ?");

			if (!$stmt):
				throw new Exception("La modificación del documento falló en su preparación.");
			endif;

			$bind = $stmt->bind_param("iissssssi", $ind_id, $user_id, $db->clearText(utf8_decode($arc_nombre)), $db->clearText(utf8_decode($arc_codigo)), $db->clearText(utf8_decode($arc_edicion)),
				$date, $db->clearText($arc_fecha_crea), $db->clearText($arc_fecha_vig), $id);
			if (!$bind):
				throw new Exception("La modificación del documento falló en su binding.");
			endif;

			if (!$stmt->execute()):
				throw new Exception("La modificación del documento falló en su ejecución.");
			endif;

			$result = array('estado' => true, 'msg' => $id);
			return $result;
		} catch (Exception $e) {
			$result = array('estado' => false, 'msg' => $e->getMessage());
			return $result;
		}
	}

	/**
	 * @param $arc_id
	 * @param $db
	 * @return array
	 */
	public function delFileSpv($arc_id, $db = null)
	{
		if (is_null($db)):
			$db = new myDBC();
		endif;

		try {
			$stmt = $db->Prepare("DELETE FROM uc_archivo_subpuntoverif WHERE arc_id = ?");

			if (!$stmt):
				throw new Exception("La eliminación del documento-spv falló en su preparación.");
			endif;

			$bind = $stmt->bind_param("i", $arc_id);
			if (!$bind):
				throw new Exception("La eliminación del documento-spv falló en su binding.");
			endif;

			if (!$stmt->execute()):
				throw new Exception("La eliminación del documento-spv falló en su ejecución." . $stmt->error);
			endif;

			$result = array('estado' => true, 'msg' => 'OK');
			return $result;
		} catch (Exception $e) {
			$result = array('estado' => false, 'msg' => $e->getMessage());
			return $result;
		}
	}

	/**
	 * @param $id
	 * @param $folder
	 * @param $db
	 * @return array
	 */
	public function del($id, $folder, $db = null)
	{
		if (is_null($db)):
			$db = new myDBC();
		endif;

		try {
			$r = $db->runQuery("SELECT arc_path FROM uc_archivo WHERE arc_id = '$id'");
			$p = $r->fetch_assoc();

			$stmt = $db->Prepare("DELETE FROM uc_archivo_puntoverif WHERE arc_id = ?");

			if (!$stmt):
				throw new Exception("La eliminación del documento-pv falló en su preparación.");
			endif;

			$bind = $stmt->bind_param("i", $id);
			if (!$bind):
				throw new Exception("La eliminación del documento-pv falló en su binding.");
			endif;

			if (!$stmt->execute()):
				throw new Exception("La eliminación del documento-pv falló en su ejecución.");
			endif;

			$stmt = $db->Prepare("DELETE FROM uc_archivo WHERE arc_id = ?");

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

			if (file_exists($_SERVER['DOCUMENT_ROOT'] . $folder . $p['arc_path'])):
				if (!unlink($_SERVER['DOCUMENT_ROOT'] . $folder . $p['arc_path'])):
					throw new Exception("La eliminación del documento falló al eliminar el archivo. " . $_SERVER['DOCUMENT_ROOT'] . $folder . $p['arc_path']);
				endif;
			endif;

			$result = array('estado' => true, 'msg' => '');
			return $result;
		} catch (Exception $e) {
			$result = array('estado' => false, 'msg' => $e->getMessage());
			return $result;
		}
	}
}