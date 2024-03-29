<?php

class Autoevaluation {

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
								FROM uc_autoevaluacion a 
                                JOIN uc_pv_indicador u ON a.pv_id = u.pv_id AND a.ind_id = u.ind_id
								JOIN uc_indicador i ON u.ind_id = i.ind_id
								JOIN uc_codigo c ON i.cod_id = c.cod_id
								JOIN uc_subambito s ON i.samb_id = s.samb_id
                                JOIN uc_elem_medible uem ON a.elm_id = uem.elm_id
								JOIN uc_subpunto_verif usv ON a.spv_id = usv.spv_id
                                WHERE aut_id = ?");

		$stmt->bind_param("i", $id);
		$stmt->execute();
		$result = $stmt->get_result();
		$obj = new stdClass();

		$row = $result->fetch_assoc();
		$obj->aut_id = $id;
		$obj->aut_pvid = $row['pv_id'];
		$obj->aut_indid = $row['ind_id'];
		$obj->aut_codid = $row['cod_id'];
		$obj->aut_coddesc = $row['cod_descripcion'];
		$obj->aut_sambid = $row['samb_id'];
		$obj->aut_sambsigla = $row['samb_sigla'];
		$obj->aut_sambdesc = utf8_encode($row['samb_nombre']);
		$obj->aut_ambid = $row['amb_id'];
		$obj->aut_elmid = $row['elm_id'];
		$obj->aut_spvid = $row['spv_id'];
		$obj->aut_usid = $row['us_id'];
		$obj->aut_fecha = $row['aut_fecha'];
		$obj->aut_fecha_reg = $row['aut_fecha_registro'];
		$obj->aut_comentario = utf8_encode($row['aut_comentario']);
		$obj->aut_cumplimiento = $row['aut_cumplimiento'];
		$obj->aut_evaluado = utf8_encode($row['aut_evaluador']);

		unset($db);
		return $obj;
	}

	/**
	 * @param $em
	 * @param $spv
	 * @param $u
	 * @param $date
	 * @return stdClass
	 */
	public function getByEmSpvUserDate($em, $spv, $u, $date): stdClass
	{
		$db = new myDBC();
		$stmt = $db->Prepare("SELECT MAX(aut_id) AS aut_id
								FROM uc_autoevaluacion a 
								WHERE a.elm_id = ? AND a.spv_id = ? AND a.us_id = ? AND a.aut_fecha = ?");

		$stmt->bind_param("iiis", $em, $spv, $u, $date);
		$stmt->execute();
		$result = $stmt->get_result();
		$row = $result->fetch_assoc();
		$obj = $this->get($row['aut_id']);

		unset($db);
		return $obj;
	}

	/**
	 * @param $pv
	 * @param $em
	 * @param $fini
	 * @param $fter
	 * @return array
	 */
	public function getFailedByPVEMDate($pv, $em, $fini, $fter): array
	{
		$db = new myDBC();
		$stmt = $db->Prepare("SELECT *
								FROM uc_autoevaluacion a
								WHERE aut_id IN (
									SELECT MAX(aut_id)
									FROM uc_autoevaluacion 
									WHERE pv_id = ? AND elm_id = ? AND aut_fecha BETWEEN ? AND ?
									GROUP BY spv_id, ind_id, elm_id) 
								AND aut_cumplimiento = 0");

		$stmt->bind_param("iiss", $pv, $em, $fini, $fter);
		$stmt->execute();
		$result = $stmt->get_result();
		$array = [];

		while ($row = $result->fetch_assoc()):
			$array[] = $this->get($row['aut_id']);
		endwhile;

		unset($db);
		return $array;
	}

	/**
	 * @param $fini
	 * @param $fter
	 * @param $spv
	 * @param $type
	 * @param $db
	 * @return array
	 */
	public function getByFilters($fini, $fter, $spv, $type, $db = null): array
	{
		if (is_null($db)):
			$db = new myDBC();
		endif;

		$stmt = $db->Prepare("SELECT aut_id, i.tcar_id, a.spv_id, spv_nombre, samb_sigla, cod_descripcion, ind_descripcion, ind_umbral, e.elm_id, elm_numero, aut_cumplimiento, aut_comentario, aut_evaluador, aut_fecha_registro, us_nombres, us_ap
									FROM uc_autoevaluacion a
									JOIN uc_usuario u ON a.us_id = u.us_id
									JOIN uc_subpunto_verif sv ON a.spv_id = sv.spv_id
									JOIN uc_elem_medible e ON a.elm_id = e.elm_id
									JOIN uc_pv_indicador pvi ON a.pv_id = pvi.pv_id AND a.ind_id = pvi.ind_id
									JOIN uc_punto_verificacion p ON pvi.pv_id = p.pv_id
									JOIN uc_indicador i ON pvi.ind_id = i.ind_id
									JOIN uc_subambito s ON i.samb_id = s.samb_id
									JOIN uc_tipo_caracteristica tc ON i.tcar_id = tc.tcar_id
									JOIN uc_codigo c ON i.cod_id = c.cod_id
									AND aut_id IN (
										SELECT MAX(aut_id)
										FROM uc_autoevaluacion a
										JOIN uc_usuario u ON a.us_id = u.us_id
										JOIN uc_subpunto_verif sv ON a.spv_id = sv.spv_id
										JOIN uc_elem_medible e ON a.elm_id = e.elm_id
										JOIN uc_pv_indicador pvi ON a.pv_id = pvi.pv_id AND a.ind_id = pvi.ind_id
										JOIN uc_punto_verificacion p ON pvi.pv_id = p.pv_id
										JOIN uc_indicador i ON pvi.ind_id = i.ind_id
										JOIN uc_subambito s ON i.samb_id = s.samb_id
										JOIN uc_tipo_caracteristica tc ON i.tcar_id = tc.tcar_id
										JOIN uc_codigo c ON i.cod_id = c.cod_id
										WHERE aut_fecha BETWEEN ? AND ?
										AND a.spv_id = ? AND i.tcar_id = ?
										GROUP BY samb_sigla, cod_descripcion, a.elm_id
									)
									ORDER BY samb_sigla, cod_descripcion, elm_numero");

		$stmt->bind_param("ssii", $fini, $fter, $spv, $type);
		$stmt->execute();
		$result = $stmt->get_result();
		$array = [];

		while ($row = $result->fetch_assoc()):
			$obj = new stdClass();
			$obj->aut_id = $row['aut_id'];
			$obj->tcar_id = $row['tcar_id'];
			$obj->spv_id = $row['spv_id'];
			$obj->spv_nombre = utf8_encode($row['spv_nombre']);
			$obj->samb_sigla = $row['samb_sigla'];
			$obj->cod_descripcion = utf8_encode($row['cod_descripcion']);
			$obj->ind_descripcion = utf8_encode($row['ind_descripcion']);
			$obj->ind_umbral = $row['ind_umbral'];
			$obj->elm_id = $row['elm_id'];
			$obj->elm_numero = $row['elm_numero'];
			$obj->aut_cumplimiento = $row['aut_cumplimiento'];
			$obj->aut_comentario = utf8_encode($row['aut_comentario']);
			$obj->aut_evaluado = utf8_encode($row['aut_evaluador']);
			$obj->aut_fecha_registro = $row['aut_fecha_registro'];
			$obj->aut_evaluador = utf8_encode($row['us_nombres'] . ' ' . $row['us_ap']);
			$array[] = $obj;
		endwhile;

		unset($db);
		return $array;
	}

	/**
	 * @param $pv
	 * @param $spv
	 * @param $ind
	 * @param $elm
	 * @param $cumplim
	 * @param $comentario
	 * @param $us
	 * @param $eval
	 * @param $fecha
	 * @param $db
	 * @return array
	 */
	public function set($pv, $spv, $ind, $elm, $cumplim, $comentario, $us, $eval, $fecha, $db = null): array
	{
		if (is_null($db)):
			$db = new myDBC();
		endif;

		try {
			$stmt = $db->Prepare("INSERT INTO uc_autoevaluacion (pv_id, spv_id, ind_id, elm_id, aut_cumplimiento, aut_comentario, us_id, aut_evaluador, aut_fecha, aut_fecha_registro)
                                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, CURRENT_TIMESTAMP)");

			if (!$stmt):
				throw new Exception("La inserción de la autoevaluación falló en su preparación.");
			endif;

			$comentario = $db->clearText(utf8_decode($comentario));
			$eval = $db->clearText(utf8_decode($eval));
			$fecha = $db->clearText($fecha);
			$bind = $stmt->bind_param("iiiiisiss", $pv, $spv, $ind, $elm, $cumplim, $comentario, $us, $eval, $fecha);

			if (!$bind):
				throw new Exception("La inserción de la autoevaluación falló en su binding.");
			endif;

			if (!$stmt->execute()):
				throw new Exception("La inserción de la autoevaluación falló en su ejecución. " . $stmt->error);
			endif;

			return array('estado' => true, 'msg' => $stmt->insert_id);
		} catch (Exception $e) {
			return array('estado' => false, 'msg' => $e->getMessage());
		}
	}

	/**
	 * @param $pv
	 * @param $spv
	 * @param $ind
	 * @param $elm
	 * @param $date
	 * @param $db
	 * @return array
	 */
	public function delByFilters($pv, $spv, $ind, $elm, $date, $db = null): array
	{
		if (is_null($db)):
			$db = new myDBC();
		endif;

		try {
			$stmt = $db->Prepare("DELETE FROM uc_autoevaluacion WHERE pv_id = ? AND spv_id = ? AND ind_id = ? AND elm_id = ? AND aut_fecha = ?");

			if (!$stmt):
				throw new Exception("La eliminación de la autoevaluación falló en su preparación.");
			endif;

			$date = $db->clearText($date);
			$bind = $stmt->bind_param("iiiis", $pv, $spv, $ind, $elm, $date);

			if (!$bind):
				throw new Exception("La eliminación de la autoevaluación falló en su binding.");
			endif;

			if (!$stmt->execute()):
				throw new Exception("La eliminación de la autoevaluación falló en su ejecución.");
			endif;

			return array('estado' => true, 'msg' => 'OK');
		} catch (Exception $e) {
			return array('estado' => false, 'msg' => $e->getMessage());
		}
	}
}
