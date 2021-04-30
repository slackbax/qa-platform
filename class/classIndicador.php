<?php

class Indicador {

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
								FROM uc_indicador i 
                                JOIN uc_tipo_caracteristica tc ON i.tcar_id = tc.tcar_id
                                JOIN uc_subambito s ON i.samb_id = s.samb_id
                                JOIN uc_ambito a on s.amb_id = a.amb_id
                                JOIN uc_codigo c on i.cod_id = c.cod_id
                                WHERE i.ind_id = ?");

		$stmt->bind_param("i", $id);
		$stmt->execute();
		$result = $stmt->get_result();
		$obj = new stdClass();

		$row = $result->fetch_assoc();
		$obj->ind_id = $id;
		$obj->ind_descripcion = utf8_encode($row['ind_descripcion']);
		$obj->samb_id = $row['samb_id'];
		$obj->samb_sigla = utf8_encode($row['samb_sigla']);
		$obj->samb_nombre = utf8_encode($row['samb_nombre']);
		$obj->amb_id = $row['amb_id'];
		$obj->amb_nombre = utf8_encode($row['amb_nombre']);
		$obj->cod_id = $row['cod_id'];
		$obj->cod_descripcion = utf8_encode($row['cod_descripcion']);

		$stmt_pv = $db->Prepare("SELECT p.pv_id, p.pv_nombre 
								FROM uc_punto_verificacion p
								JOIN uc_pv_indicador u on p.pv_id = u.pv_id
                                JOIN uc_indicador i ON u.ind_id = i.ind_id
                                WHERE i.ind_id = ?");

		$stmt_pv->bind_param("i", $id);
		$stmt_pv->execute();
		$result_pv = $stmt_pv->get_result();
		$array = [];

		while ($row = $result_pv->fetch_assoc()):
			$array[] = array('pv_id' => $row['pv_id'], 'pv_nombre' => utf8_encode($row['pv_nombre']));
		endwhile;

		$obj->pvs = $array;

		unset($db);
		return $obj;
	}

	/**
	 * @param $tcar
	 * @return array
	 */
	public function getByTypeCar($tcar): array
	{
		$db = new myDBC();
		$stmt = $db->Prepare("SELECT ind_id, tcar_id, amb_id, s.samb_id, c.cod_id, ind_descripcion, ind_umbral, s.samb_sigla, cod_descripcion
								FROM uc_indicador i
								JOIN uc_subambito s ON i.samb_id = s.samb_id
								JOIN uc_codigo c ON i.cod_id = c.cod_id
								WHERE tcar_id = ? ORDER BY samb_sigla, cod_descripcion");

		$stmt->bind_param("i", $tcar);
		$stmt->execute();
		$result = $stmt->get_result();
		$list = [];

		while ($row = $result->fetch_assoc()):
			$obj = new stdClass();
			$obj->ind_id = $row['ind_id'];
			$obj->tcar_id = $row['tcar_id'];
			$obj->amb_id = $row['amb_id'];
			$obj->samb_id = $row['samb_id'];
			$obj->cod_id = $row['cod_id'];
			$obj->ind_descripcion = utf8_encode($row['ind_descripcion']);
			$obj->ind_umbral = $row['ind_umbral'];
			$obj->samb_sigla = utf8_encode($row['samb_sigla']);
			$obj->cod_descripcion = utf8_encode($row['cod_descripcion']);
			$list[] = $obj;
		endwhile;

		unset($db);
		return $list;
	}

	/**
	 * @param $sid
	 * @param $cid
	 * @return stdClass
	 */
	public function getBySACod($sid, $cid): stdClass
	{
		$db = new myDBC();
		$stmt = $db->Prepare("SELECT i.*, tc.tcar_nombre, s.samb_sigla, s.samb_nombre, a.amb_nombre, c.cod_descripcion 
								FROM uc_indicador i 
                                JOIN uc_tipo_caracteristica tc ON i.tcar_id = tc.tcar_id
                                JOIN uc_subambito s ON i.samb_id = s.samb_id
                                JOIN uc_ambito a ON s.amb_id = a.amb_id
                                JOIN uc_codigo c ON i.cod_id = c.cod_id
                                WHERE i.samb_id = ? AND i.cod_id = ?");

		$stmt->bind_param("ii", $sid, $cid);
		$stmt->execute();
		$result = $stmt->get_result();
		$obj = new stdClass();

		$row = $result->fetch_assoc();
		$obj->ind_id = $row['ind_id'];
		$obj->ind_descripcion = utf8_encode($row['ind_descripcion']);
		$obj->ind_umbral = $row['ind_umbral'];
		$obj->samb_sigla = utf8_encode($row['samb_sigla']);
		$obj->samb_nombre = utf8_encode($row['samb_nombre']);
		$obj->amb_nombre = utf8_encode($row['amb_nombre']);
		$obj->cod_descripcion = utf8_encode($row['cod_descripcion']);

		$stmt_em = $db->Prepare("SELECT elm_id, elm_descripcion, elm_numero
								FROM uc_elem_medible
                                WHERE ind_id = ?");

		$stmt_em->bind_param("i", $row['ind_id']);
		$stmt_em->execute();
		$result_em = $stmt_em->get_result();
		$array = [];

		while ($row_em = $result_em->fetch_assoc()):
			$array[] = array('em_id' => $row_em['elm_id'], 'em_descripcion' => utf8_encode($row_em['elm_descripcion']), 'em_numero' => $row_em['elm_numero']);
		endwhile;

		$obj->ems = $array;

		$stmt_pv = $db->Prepare("SELECT p.pv_id, p.pv_nombre, p.pv_code 
								FROM uc_punto_verificacion p 
                                JOIN uc_pv_indicador pi ON p.pv_id = pi.pv_id
                                WHERE pi.ind_id = ?");

		$stmt_pv->bind_param("i", $row['ind_id']);
		$stmt_pv->execute();
		$result_pv = $stmt_pv->get_result();
		$array = [];

		while ($row_pv = $result_pv->fetch_assoc()):
			$array[] = array('pv_id' => $row_pv['pv_id'], 'pv_nombre' => utf8_encode($row_pv['pv_nombre']), 'pv_code' => $row_pv['pv_code']);
		endwhile;

		$obj->pvs = $array;

		unset($db);
		return $obj;
	}
}