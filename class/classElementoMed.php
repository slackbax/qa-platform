<?php

class ElementoMed {

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
		$stmt = $db->Prepare("SELECT * FROM uc_elem_medible WHERE elm_id = ?");
		$stmt->bind_param("i", $id);
		$stmt->execute();
		$result = $stmt->get_result();
		$obj = new stdClass();

		$row = $result->fetch_assoc();
		$obj->elm_id = $row['elm_id'];
		$obj->elm_indid = $row['ind_id'];
		$obj->elm_descripcion = utf8_encode($row['elm_descripcion']);
		$obj->elm_numero = utf8_encode($row['elm_numero']);

		unset($db);
		return $obj;
	}

	/**
	 * @return array
	 */
	public function getAll()
	{
		$db = new myDBC();
		$stmt = $db->Prepare("SELECT elm_id FROM uc_elem_medible");
		$stmt->execute();
		$result = $stmt->get_result();
		$lista = [];

		while ($row = $result->fetch_assoc()):
			$lista[] = $this->get($row['elm_id']);
		endwhile;

		unset($db);
		return $lista;
	}

	/**
	 * @param $ind
	 * @return array
	 */
	public function getByIndCod($ind)
	{
		$db = new myDBC();
		$stmt = $db->Prepare("SELECT e.elm_id 
								FROM uc_elem_medible e
								JOIN uc_indicador u on e.ind_id = u.ind_id
 								WHERE u.ind_id = ?");

		$stmt->bind_param("i", $ind);
		$stmt->execute();
		$result = $stmt->get_result();
		$lista = [];

		while ($row = $result->fetch_assoc()):
			$lista[] = $this->get($row['elm_id']);
		endwhile;

		unset($db);
		return $lista;
	}

	/**
	 * @param $samb
	 * @param $cod
	 * @return array
	 */
	public function getByInd($samb, $cod)
	{
		$db = new myDBC();
		$stmt = $db->Prepare("SELECT e.elm_id 
								FROM uc_elem_medible e
								JOIN uc_indicador u on e.ind_id = u.ind_id
 								WHERE u.samb_id = ? AND u.cod_id = ?");

		$stmt->bind_param("ii", $samb, $cod);
		$stmt->execute();
		$result = $stmt->get_result();
		$lista = [];

		while ($row = $result->fetch_assoc()):
			$lista[] = $this->get($row['elm_id']);
		endwhile;

		unset($db);
		return $lista;
	}

	/**
	 * @param $ind
	 * @param $desc
	 * @param $numero
	 * @param $db
	 * @return array
	 */
	public function set($ind, $desc, $numero, $db = null)
	{
		if (is_null($db)):
			$db = new myDBC();
		endif;

		try {
			$stmt = $db->Prepare("INSERT INTO uc_elem_medible (ind_id, elm_descripcion, elm_numero) VALUES (?, ?, ?)");

			if (!$stmt):
				throw new Exception("La inserción del elemento falló en su preparación.");
			endif;

			$desc = $db->clearText(utf8_decode($desc));
			$numero = $db->clearText(utf8_decode($numero));
			$bind = $stmt->bind_param("iss", $ind, $desc, $numero);

			if (!$bind):
				throw new Exception("La inserción del elemento falló en su binding.");
			endif;

			if (!$stmt->execute()):
				throw new Exception("La inserción del elemento falló en su ejecución.");
			endif;

			$result = array('estado' => true, 'msg' => $stmt->insert_id);
			return $result;
		} catch (Exception $e) {
			$result = array('estado' => false, 'msg' => $e->getMessage());
			return $result;
		}
	}

	/**
	 * @param $elem
	 * @param $ind
	 * @param $desc
	 * @param $numero
	 * @param $db
	 * @return array
	 */
	public function mod($elem, $ind, $desc, $numero, $db = null)
	{
		if (is_null($db)):
			$db = new myDBC();
		endif;

		try {
			$stmt = $db->Prepare("UPDATE uc_elem_medible SET ind_id = ?, elm_descripcion = ?, elm_numero = ? WHERE elm_id = ?");

			if (!$stmt):
				throw new Exception("La edición del elemento falló en su preparación.");
			endif;

			$desc = $db->clearText(utf8_decode($desc));
			$numero = $db->clearText(utf8_decode($numero));
			$bind = $stmt->bind_param("issi", $ind, $desc, $numero, $elem);

			if (!$bind):
				throw new Exception("La edición del elemento falló en su binding.");
			endif;

			if (!$stmt->execute()):
				throw new Exception("La edición del elemento falló en su ejecución.");
			endif;

			$result = array('estado' => true, 'msg' => $stmt->insert_id);
			return $result;
		} catch (Exception $e) {
			$result = array('estado' => false, 'msg' => $e->getMessage());
			return $result;
		}
	}
}