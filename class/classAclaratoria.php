<?php

class Aclaratoria {

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
								FROM uc_aclaratoria a 
                                JOIN uc_indicador i ON a.ind_id = i.ind_id
                                WHERE acl_id = ?");

		$stmt->bind_param("i", $id);
		$stmt->execute();
		$result = $stmt->get_result();
		$obj = new stdClass();

		$row = $result->fetch_assoc();
		$obj->acl_id = $id;
		$obj->acl_indid = $row['ind_id'];
		$obj->acl_fecha = $row['acl_fecha'];
		$obj->acl_resolucion = utf8_encode($row['acl_resolucion']);
		$obj->acl_numero = $row['acl_numero'];
		$obj->acl_resumen = utf8_encode($row['acl_resumen']);
		$obj->acl_descripcion = utf8_encode($row['acl_descripcion']);

		unset($db);
		return $obj;
	}

	/**
	 * @param $ind
	 * @return array
	 */
	public function getByIndicador($ind)
	{
		$db = new myDBC();
		$stmt = $db->Prepare("SELECT * 
								FROM uc_aclaratoria a 
                                JOIN uc_indicador i ON a.ind_id = i.ind_id
                                WHERE a.ind_id = ?");

		$stmt->bind_param("i", $ind);
		$stmt->execute();
		$result = $stmt->get_result();
		$array = [];

		while ($row = $result->fetch_assoc()):
			$array[] = $this->get($row['acl_id']);
		endwhile;

		unset($db);
		return $array;
	}

	/**
	 * @param $ind
	 * @param $fecha
	 * @param $res
	 * @param $num
	 * @param $resumen
	 * @param $desc
	 * @param $db
	 * @return array
	 */
	public function set($ind, $fecha, $res, $num, $resumen, $desc, $db = null)
	{
		if (is_null($db)):
			$db = new myDBC();
		endif;

		try {
			$stmt = $db->Prepare("INSERT INTO uc_aclaratoria (ind_id, acl_fecha, acl_resolucion, acl_numero, acl_resumen, acl_descripcion) VALUES (?, ?, ?, ?, ?, ?)");

			if (!$stmt):
				throw new Exception("La inserción de la aclaratoria falló en su preparación.");
			endif;

			$fecha = $db->clearText($fecha);
			$res = $db->clearText(utf8_decode($res));
			$num = $db->clearText($num);
			$resumen = $db->clearText(utf8_decode($resumen));
			$desc = $db->clearText(utf8_decode($desc));
			$bind = $stmt->bind_param("ississ", $ind, $fecha, $res, $num, $resumen, $desc);

			if (!$bind):
				throw new Exception("La inserción de la aclaratoria falló en su binding.");
			endif;

			if (!$stmt->execute()):
				throw new Exception("La inserción de la aclaratoria falló en su ejecución.");
			endif;

			$result = array('estado' => true, 'msg' => $stmt->insert_id);
			return $result;
		} catch (Exception $e) {
			$result = array('estado' => false, 'msg' => $e->getMessage());
			return $result;
		}
	}

	/**
	 * @param $acl
	 * @param $ind
	 * @param $fecha
	 * @param $res
	 * @param $num
	 * @param $resumen
	 * @param $desc
	 * @param $db
	 * @return array
	 */
	public function mod($acl, $ind, $fecha, $res, $num, $resumen, $desc, $db = null)
	{
		if (is_null($db)):
			$db = new myDBC();
		endif;

		try {
			$stmt = $db->Prepare("UPDATE uc_aclaratoria SET ind_id = ?, acl_fecha = ?, acl_resolucion = ?, acl_numero = ?, acl_resumen = ?, acl_descripcion = ? WHERE acl_id = ?");

			if (!$stmt):
				throw new Exception("La edición de la aclaratoria falló en su preparación.");
			endif;

			$resumen = str_replace('"', '&quot;', $resumen);
			$desc = str_replace('"', '&quot;', $desc);
			$fecha = $db->clearText($fecha);
			$res = $db->clearText(utf8_decode($res));
			$num = $db->clearText($num);
			$resumen = $db->clearText(utf8_decode($resumen));
			$desc = $db->clearText(utf8_decode($desc));
			$bind = $stmt->bind_param("ississi", $ind, $fecha, $res, $num, $resumen, $desc, $acl);

			if (!$bind):
				throw new Exception("La edición de la aclaratoria falló en su binding.");
			endif;

			if (!$stmt->execute()):
				throw new Exception("La edición de la aclaratoria falló en su ejecución.");
			endif;

			$result = array('estado' => true, 'msg' => $stmt->insert_id);
			return $result;
		} catch (Exception $e) {
			$result = array('estado' => false, 'msg' => $e->getMessage());
			return $result;
		}
	}
}
