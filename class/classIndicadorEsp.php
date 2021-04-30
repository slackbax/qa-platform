<?php

class IndicadorEsp {

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
		$stmt = $db->Prepare("SELECT *
                                FROM uc_ind_especifico ie
                                JOIN uc_periodicidad p ON ie.pe_id = p.pe_id
                                JOIN uc_indicador i ON ie.ind_id = i.ind_id
                                JOIN uc_tipo_caracteristica tc ON i.tcar_id = tc.tcar_id
                                JOIN uc_subambito s ON i.samb_id = s.samb_id
                                JOIN uc_ambito a ON s.amb_id = a.amb_id
                                JOIN uc_codigo c ON i.cod_id = c.cod_id
                                LEFT JOIN uc_elem_medible u on ie.elm_id = u.elm_id
                                WHERE ie.ine_id = ?");

		$stmt->bind_param("i", $id);
		$stmt->execute();
		$result = $stmt->get_result();
		$obj = new stdClass();

		$row = $result->fetch_assoc();
		$obj->ine_id = $id;
		$obj->ine_nombre = utf8_encode($row['ine_nombre']);
		$obj->ine_descripcion = utf8_encode($row['ine_descripcion']);
		$obj->ine_metodologia = utf8_encode($row['ine_metodologia']);
		$obj->ine_indid = $row['ind_id'];
		$obj->ine_inddesc = utf8_encode($row['ind_descripcion']);
		$obj->ine_peid = $row['pe_id'];
		$obj->ine_pedesc = utf8_encode($row['pe_descripcion']);
		$obj->ine_penum = $row['pe_numero'];
		$obj->ine_num_desc = utf8_encode($row['ine_num_desc']);
		$obj->ine_den_desc = utf8_encode($row['ine_den_desc']);
		$obj->ine_umbral = $row['ine_umbral'];
		$obj->ine_fecha = $row['ine_fecha'];
		$obj->samb_id = $row['samb_id'];
		$obj->samb_sigla = utf8_encode($row['samb_sigla']);
		$obj->samb_nombre = utf8_encode($row['samb_nombre']);
		$obj->amb_id = $row['amb_id'];
		$obj->amb_nombre = utf8_encode($row['amb_nombre']);
		$obj->cod_id = $row['cod_id'];
		$obj->cod_descripcion = utf8_encode($row['cod_descripcion']);
		$obj->elem_id = $row['elm_id'];
		$obj->elem_descripcion = utf8_encode($row['elm_descripcion']);

		unset($db);
		return $obj;
	}

	/**
	 * @param $pv
	 * @return array
	 */
	public function getByPV($pv): array
	{
		$db = new myDBC();
		$stmt = $db->Prepare("SELECT ie.ine_id
                                FROM uc_ind_especifico ie
                                JOIN uc_indesp_subpunto ins ON ie.ine_id = ins.ine_id
								JOIN uc_indicador i ON ie.ind_id = i.ind_id
                                JOIN uc_subambito s ON i.samb_id = s.samb_id
                                JOIN uc_codigo c ON i.cod_id = c.cod_id
                                WHERE ins.spv_id = ?
                                ORDER BY samb_sigla, cod_descripcion");

		$stmt->bind_param("i", $pv);
		$stmt->execute();
		$result = $stmt->get_result();
		$array = [];

		while ($row = $result->fetch_assoc()):
			$array[] = $this->get($row['ine_id']);
		endwhile;

		unset($db);
		return $array;
	}

	/**
	 * @param $ind
	 * @param $pe
	 * @param $elm
	 * @param $nombre
	 * @param $desc
	 * @param $metodo
	 * @param $num
	 * @param $den
	 * @param $umbral
	 * @param $db
	 * @return array
	 */
	public function set($ind, $pe, $elm, $nombre, $desc, $metodo, $num, $den, $umbral, $db = null): array
	{
		if (is_null($db)):
			$db = new myDBC();
		endif;

		try {
			$stmt = $db->Prepare("INSERT INTO uc_ind_especifico (ind_id, pe_id, elm_id, ine_nombre, ine_descripcion, ine_metodologia, ine_num_desc, ine_den_desc, ine_umbral, ine_fecha, ine_activo)
                                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, CURRENT_DATE, TRUE)");

			if (!$stmt):
				throw new Exception("La inserción del indicador falló en su preparación.");
			endif;

			$nombre = $db->clearText(utf8_decode($nombre));
			$desc = utf8_decode($db->clearText($desc));
			$metodo = utf8_decode($db->clearText($metodo));
			$num =utf8_decode($db->clearText($num));
			$den = utf8_decode($db->clearText($den));
			$umbral = $db->clearText($umbral);
			$bind = $stmt->bind_param("iiisssssd", $ind, $pe, $elm, $nombre, $desc, $metodo, $num, $den, $umbral);

			if (!$bind):
				throw new Exception("La inserción del indicador falló en su binding.");
			endif;

			if (!$stmt->execute()):
				throw new Exception("La inserción del indicador falló en su ejecución.");
			endif;

			return array('estado' => true, 'msg' => $stmt->insert_id);
		} catch (Exception $e) {
			return array('estado' => false, 'msg' => $e->getMessage());
		}
	}

	/**
	 * @param $ine
	 * @param $ind
	 * @param $pe
	 * @param $elm
	 * @param $nombre
	 * @param $desc
	 * @param $metodo
	 * @param $num
	 * @param $den
	 * @param $umbral
	 * @param $db
	 * @return array
	 */
	public function mod($ine, $ind, $pe, $elm, $nombre, $desc, $metodo, $num, $den, $umbral, $db = null): array
	{
		if (is_null($db)):
			$db = new myDBC();
		endif;

		try {
			$stmt = $db->Prepare("UPDATE uc_ind_especifico SET ind_id = ?, pe_id = ?, elm_id = ?, ine_nombre = ?, ine_descripcion = ?, ine_metodologia = ?, 
									ine_num_desc = ?, ine_den_desc = ?, ine_umbral = ?, ine_fecha = CURRENT_DATE
									WHERE ine_id = ?");

			if (!$stmt):
				throw new Exception("La inserción del indicador falló en su preparación.");
			endif;

			$nombre = $db->clearText(utf8_decode($nombre));
			$desc = utf8_decode($db->clearText($desc));
			$metodo = utf8_decode($db->clearText($metodo));
			$num =utf8_decode($db->clearText($num));
			$den = utf8_decode($db->clearText($den));
			$umbral = $db->clearText($umbral);
			$bind = $stmt->bind_param("iiisssssdi", $ind, $pe, $elm, $nombre, $desc, $metodo, $num, $den, $umbral, $ine);

			if (!$bind):
				throw new Exception("La inserción del indicador falló en su binding.");
			endif;

			if (!$stmt->execute()):
				throw new Exception("La inserción del indicador falló en su ejecución.");
			endif;

			return array('estado' => true, 'msg' => $stmt->insert_id);
		} catch (Exception $e) {
			return array('estado' => false, 'msg' => $e->getMessage());
		}
	}
}