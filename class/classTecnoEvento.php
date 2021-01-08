<?php

class TecnoEvento {
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
                                    FROM uc_tecnoevento e
                                    JOIN uc_usuario u ON e.us_id = u.us_id
                                    LEFT JOIN uc_servicio s ON e.ser_id = s.ser_id
                                    JOIN uc_categoria ca ON e.cat_id = ca.cat_id
                                    WHERE e.tec_id = ?");

		$stmt->bind_param("i", $id);
		$stmt->execute();
		$result = $stmt->get_result();
		$obj = new stdClass();

		$row = $result->fetch_assoc();
		$obj->tec_id = $row['tec_id'];
		$obj->ser_id = $row['ser_id'];
		$obj->ser_desc = utf8_encode($row['ser_nombre']);
		$obj->tec_usid = $row['us_id'];
		$obj->tec_username = $row['us_username'];
		$obj->cat_id = $row['cat_id'];
		$obj->cat_desc = utf8_encode($row['cat_descripcion']);
		$obj->tec_fecha = utf8_encode($row['tec_fecha']);
		$obj->tec_fecha_ev = utf8_encode($row['tec_fecha_ev']);
		$obj->tec_descripcion = utf8_encode($row['tec_descripcion']);
		$obj->tec_momento = utf8_encode($row['tec_momento']);
		$obj->tec_causa = utf8_encode($row['tec_causa']);
		$obj->tec_consecuencia = utf8_encode($row['tec_consecuencia']);
		$obj->tec_autoriza = $row['tec_autoriza'];
		$obj->tec_pac_rut = utf8_encode($row['tec_pac_rut']);
		$obj->tec_pac_nombre = utf8_encode($row['tec_pac_nombre']);
		$obj->tec_diagnostico = utf8_encode($row['tec_diagnostico']);
		$obj->tec_nombre_gen = utf8_encode($row['tec_nombre_gen']);
		$obj->tec_nombre_com = utf8_encode($row['tec_nombre_com']);
		$obj->tec_uso = utf8_encode($row['tec_uso']);
		$obj->tec_riesgo = utf8_encode($row['tec_riesgo']);
		$obj->tec_lote = utf8_encode($row['tec_lote']);
		$obj->tec_serie = utf8_encode($row['tec_serie']);
		$obj->tec_fecha_fab = utf8_encode($row['tec_fecha_fab']);
		$obj->tec_fecha_ven = utf8_encode($row['tec_fecha_ven']);
		$obj->tec_condicion = $row['tec_condicion'];
		$obj->tec_num_registro = utf8_encode($row['tec_num_registro']);
		$obj->tec_disponibilidad = $row['tec_disponibilidad'];
		$obj->tec_adquisicion = $row['tec_adquisicion'];
		$obj->tec_fnombre = utf8_encode($row['tec_fnombre']);
		$obj->tec_fpais = utf8_encode($row['tec_fpais']);
		$obj->tec_femail = utf8_encode($row['tec_femail']);
		$obj->tec_ftelefono = utf8_encode($row['tec_ftelefono']);
		$obj->tec_rnombre = utf8_encode($row['tec_rnombre']);
		$obj->tec_rdireccion = utf8_encode($row['tec_rdireccion']);
		$obj->tec_remail = utf8_encode($row['tec_remail']);
		$obj->tec_rtelefono = utf8_encode($row['tec_rtelefono']);
		$obj->tec_imnombre = utf8_encode($row['tec_imnombre']);
		$obj->tec_imdireccion = utf8_encode($row['tec_imdireccion']);
		$obj->tec_imemail = utf8_encode($row['tec_imemail']);
		$obj->tec_imtelefono = utf8_encode($row['tec_imtelefono']);
		$obj->tec_correccion = utf8_encode($row['tec_correccion']);
		$obj->tec_registro = $row['tec_registro'];

		unset($db);
		return $obj;
	}

	/**
	 * @return array
	 */
	public function getAll()
	{
		$db = new myDBC();
		$stmt = $db->Prepare("SELECT tec_id FROM uc_tecnoevento");
		$stmt->execute();
		$result = $stmt->get_result();
		$lista = [];

		while ($row = $result->fetch_assoc()):
			$lista[] = $this->get($row['tec_id']);
		endwhile;

		unset($db);
		return $lista;
	}

	/**
	 * @param $us
	 * @return stdClass
	 */
	public function getLastByUser($us)
	{
		$db = new myDBC();
		$stmt = $db->Prepare("SELECT MAX(tec_id) as tec_id FROM uc_tecnoevento WHERE us_id = ?");
		$stmt->bind_param("i", $us);
		$stmt->execute();
		$result = $stmt->get_result();
		$row = $result->fetch_assoc();
		unset($db);
		return $this->get($row['tec_id']);
	}

	/**
	 * @param $us_id
	 * @param $ser_id
	 * @param $cat_id
	 * @param $tec_fecha
	 * @param $tec_fecha_ev
	 * @param $tec_descripcion
	 * @param $tec_momento
	 * @param $tec_causa
	 * @param $tec_consecuencia
	 * @param $tec_autoriza
	 * @param $pac_rut
	 * @param $pac_nombre
	 * @param $tec_diagnostico
	 * @param $tec_nombre_gen
	 * @param $tec_nombre_com
	 * @param $tec_uso
	 * @param $tec_riesgo
	 * @param $tec_lote
	 * @param $tec_serie
	 * @param $tec_fecha_fab
	 * @param $tec_fecha_ven
	 * @param $tec_condicion
	 * @param $tec_num_registro
	 * @param $tec_disponibilidad
	 * @param $tec_adquisicion
	 * @param $tec_fnombre
	 * @param $tec_fpais
	 * @param $tec_femail
	 * @param $tec_ftelefono
	 * @param $tec_rnombre
	 * @param $tec_rdireccion
	 * @param $tec_remail
	 * @param $tec_rtelefono
	 * @param $tec_imnombre
	 * @param $tec_imdireccion
	 * @param $tec_imemail
	 * @param $tec_imtelefono
	 * @param $tec_correccion
	 * @param $db
	 * @return array
	 */
	public function set($us_id, $ser_id, $cat_id, $tec_fecha, $tec_fecha_ev, $tec_descripcion, $tec_momento, $tec_causa, $tec_consecuencia, $tec_autoriza, $pac_rut, $pac_nombre, $tec_diagnostico, $tec_nombre_gen, $tec_nombre_com,
						$tec_uso, $tec_riesgo, $tec_lote, $tec_serie, $tec_fecha_fab, $tec_fecha_ven, $tec_condicion, $tec_num_registro, $tec_disponibilidad, $tec_adquisicion, $tec_fnombre, $tec_fpais, $tec_femail, $tec_ftelefono, $tec_rnombre, $tec_rdireccion,
						$tec_remail, $tec_rtelefono, $tec_imnombre, $tec_imdireccion, $tec_imemail, $tec_imtelefono, $tec_correccion, $db)
	{
		if (is_null($db)):
			$db = new myDBC();
		endif;

		try {
			$stmt = $db->Prepare("INSERT INTO uc_tecnoevento (us_id, ser_id, cat_id, tec_fecha, tec_fecha_ev, tec_descripcion, tec_momento, tec_causa, tec_consecuencia, tec_autoriza, tec_pac_rut, tec_pac_nombre,
                            			tec_diagnostico, tec_nombre_gen, tec_nombre_com, tec_uso, tec_riesgo, tec_lote, tec_serie, tec_fecha_fab, tec_fecha_ven, tec_condicion, tec_num_registro, tec_disponibilidad, tec_adquisicion,
                            			tec_fnombre, tec_fpais, tec_femail, tec_ftelefono, tec_rnombre, tec_rdireccion, tec_remail, tec_rtelefono, tec_imnombre, tec_imdireccion, tec_imemail, tec_imtelefono, tec_correccion) 
                                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

			if (!$stmt):
				throw new Exception("La inserción del evento falló en su preparación.");
			endif;

			$tec_descripcion = $db->clearText(utf8_decode($tec_descripcion));
			$tec_momento = $db->clearText(utf8_decode($tec_momento));
			$tec_causa = $db->clearText(utf8_decode($tec_causa));
			$tec_consecuencia = $db->clearText(utf8_decode($tec_consecuencia));
			$pac_rut = $db->clearText(utf8_decode($pac_rut));
			$pac_nombre = $db->clearText(utf8_decode($pac_nombre));
			$tec_diagnostico = $db->clearText(utf8_decode($tec_diagnostico));
			$tec_nombre_gen = $db->clearText(utf8_decode($tec_nombre_gen));
			$tec_nombre_com = $db->clearText(utf8_decode($tec_nombre_com));
			$tec_uso = $db->clearText(utf8_decode($tec_uso));
			$tec_riesgo = $db->clearText(utf8_decode($tec_riesgo));
			$tec_lote = $db->clearText(utf8_decode($tec_lote));
			$tec_serie = $db->clearText(utf8_decode($tec_serie));
			$tec_condicion = $db->clearText(utf8_decode($tec_condicion));
			$tec_num_registro = $db->clearText(utf8_decode($tec_num_registro));
			$tec_fnombre = $db->clearText(utf8_decode($tec_fnombre));
			$tec_fpais = $db->clearText(utf8_decode($tec_fpais));
			$tec_femail = $db->clearText(utf8_decode($tec_femail));
			$tec_ftelefono = $db->clearText(utf8_decode($tec_ftelefono));
			$tec_rnombre = $db->clearText(utf8_decode($tec_rnombre));
			$tec_rdireccion = $db->clearText(utf8_decode($tec_rdireccion));
			$tec_remail = $db->clearText(utf8_decode($tec_remail));
			$tec_rtelefono = $db->clearText(utf8_decode($tec_rtelefono));
			$tec_imnombre = $db->clearText(utf8_decode($tec_imnombre));
			$tec_imdireccion = $db->clearText(utf8_decode($tec_imdireccion));
			$tec_imemail = $db->clearText(utf8_decode($tec_imemail));
			$tec_imtelefono = $db->clearText(utf8_decode($tec_imtelefono));
			$tec_correccion = $db->clearText(utf8_decode($tec_correccion));
			$bind = $stmt->bind_param("iiissssssisssssssssssssissssssssssssss", $us_id, $ser_id, $cat_id, $tec_fecha, $tec_fecha_ev, $tec_descripcion, $tec_momento, $tec_causa, $tec_consecuencia, $tec_autoriza,
				$pac_rut, $pac_nombre, $tec_diagnostico, $tec_nombre_gen, $tec_nombre_com, $tec_uso, $tec_riesgo, $tec_lote, $tec_serie, $tec_fecha_fab, $tec_fecha_ven, $tec_condicion, $tec_num_registro,
				$tec_disponibilidad, $tec_adquisicion, $tec_fnombre, $tec_fpais, $tec_femail, $tec_ftelefono, $tec_rnombre, $tec_rdireccion, $tec_remail, $tec_rtelefono, $tec_imnombre, $tec_imdireccion, $tec_imemail,
				$tec_imtelefono, $tec_correccion);
			if (!$bind):
				throw new Exception("La inserción del evento falló en su binding.");
			endif;

			if (!$stmt->execute()):
				throw new Exception("La inserción del evento falló en su ejecución.");
			endif;

			return array('estado' => true, 'msg' => $stmt->insert_id);
		} catch (Exception $e) {
			return array('estado' => false, 'msg' => $e->getMessage());
		}
	}

	/**
	 * @param $id
	 * @param $us_id
	 * @param $ser_id
	 * @param $cat_id
	 * @param $tec_fecha
	 * @param $tec_fecha_ev
	 * @param $tec_descripcion
	 * @param $tec_momento
	 * @param $tec_causa
	 * @param $tec_consecuencia
	 * @param $tec_autoriza
	 * @param $pac_rut
	 * @param $pac_nombre
	 * @param $tec_diagnostico
	 * @param $tec_nombre_gen
	 * @param $tec_nombre_com
	 * @param $tec_uso
	 * @param $tec_riesgo
	 * @param $tec_lote
	 * @param $tec_serie
	 * @param $tec_fecha_fab
	 * @param $tec_fecha_ven
	 * @param $tec_condicion
	 * @param $tec_num_registro
	 * @param $tec_disponibilidad
	 * @param $tec_adquisicion
	 * @param $tec_fnombre
	 * @param $tec_fpais
	 * @param $tec_femail
	 * @param $tec_ftelefono
	 * @param $tec_rnombre
	 * @param $tec_rdireccion
	 * @param $tec_remail
	 * @param $tec_rtelefono
	 * @param $tec_imnombre
	 * @param $tec_imdireccion
	 * @param $tec_imemail
	 * @param $tec_imtelefono
	 * @param $tec_correccion
	 * @param $db
	 * @return array
	 */
	public function mod($id, $us_id, $ser_id, $cat_id, $tec_fecha, $tec_fecha_ev, $tec_descripcion, $tec_momento, $tec_causa, $tec_consecuencia, $tec_autoriza, $pac_rut, $pac_nombre, $tec_diagnostico, $tec_nombre_gen, $tec_nombre_com,
						$tec_uso, $tec_riesgo, $tec_lote, $tec_serie, $tec_fecha_fab, $tec_fecha_ven, $tec_condicion, $tec_num_registro, $tec_disponibilidad, $tec_adquisicion, $tec_fnombre, $tec_fpais, $tec_femail, $tec_ftelefono, $tec_rnombre, $tec_rdireccion,
						$tec_remail, $tec_rtelefono, $tec_imnombre, $tec_imdireccion, $tec_imemail, $tec_imtelefono, $tec_correccion, $db)
	{
		if (is_null($db)):
			$db = new myDBC();
		endif;

		try {
			$stmt = $db->Prepare("UPDATE uc_tecnoevento SET us_id = ?, ser_id = ?, cat_id = ?, tec_fecha_ev = ?, tec_descripcion = ?, tec_momento = ?, tec_causa = ?, tec_consecuencia = ?, tec_autoriza = ?, tec_pac_rut = ?, tec_pac_nombre = ?,
                            			tec_diagnostico = ?, tec_nombre_gen = ?, tec_nombre_com = ?, tec_uso = ?, tec_riesgo = ?, tec_lote = ?, tec_serie = ?, tec_fecha_fab = ?, tec_fecha_ven = ?, tec_condicion = ?, tec_num_registro = ?, 
                          				tec_disponibilidad = ?, tec_adquisicion = ?, tec_fnombre = ?, tec_fpais = ?, tec_femail = ?, tec_ftelefono = ?, tec_rnombre = ?, tec_rdireccion = ?, tec_remail = ?, tec_rtelefono = ?,
                          				tec_imnombre = ?, tec_imdireccion = ?, tec_imemail = ?, tec_imtelefono = ?, tec_correccion = ? WHERE tec_id = ?");

			if (!$stmt):
				throw new Exception("La inserción del evento falló en su preparación.");
			endif;

			$tec_descripcion = $db->clearText(utf8_decode($tec_descripcion));
			$tec_momento = $db->clearText(utf8_decode($tec_momento));
			$tec_causa = $db->clearText(utf8_decode($tec_causa));
			$tec_consecuencia = $db->clearText(utf8_decode($tec_consecuencia));
			$pac_rut = $db->clearText(utf8_decode($pac_rut));
			$pac_nombre = $db->clearText(utf8_decode($pac_nombre));
			$tec_diagnostico = $db->clearText(utf8_decode($tec_diagnostico));
			$tec_nombre_gen = $db->clearText(utf8_decode($tec_nombre_gen));
			$tec_nombre_com = $db->clearText(utf8_decode($tec_nombre_com));
			$tec_uso = $db->clearText(utf8_decode($tec_uso));
			$tec_riesgo = $db->clearText(utf8_decode($tec_riesgo));
			$tec_lote = $db->clearText(utf8_decode($tec_lote));
			$tec_serie = $db->clearText(utf8_decode($tec_serie));
			$tec_condicion = $db->clearText(utf8_decode($tec_condicion));
			$tec_num_registro = $db->clearText(utf8_decode($tec_num_registro));
			$tec_fnombre = $db->clearText(utf8_decode($tec_fnombre));
			$tec_fpais = $db->clearText(utf8_decode($tec_fpais));
			$tec_femail = $db->clearText(utf8_decode($tec_femail));
			$tec_ftelefono = $db->clearText(utf8_decode($tec_ftelefono));
			$tec_rnombre = $db->clearText(utf8_decode($tec_rnombre));
			$tec_rdireccion = $db->clearText(utf8_decode($tec_rdireccion));
			$tec_remail = $db->clearText(utf8_decode($tec_remail));
			$tec_rtelefono = $db->clearText(utf8_decode($tec_rtelefono));
			$tec_imnombre = $db->clearText(utf8_decode($tec_imnombre));
			$tec_imdireccion = $db->clearText(utf8_decode($tec_imdireccion));
			$tec_imemail = $db->clearText(utf8_decode($tec_imemail));
			$tec_imtelefono = $db->clearText(utf8_decode($tec_imtelefono));
			$tec_correccion = $db->clearText(utf8_decode($tec_correccion));
			$bind = $stmt->bind_param("iiisssssisssssssssssssissssssssssssssi", $us_id, $ser_id, $cat_id, $tec_fecha_ev, $tec_descripcion, $tec_momento, $tec_causa, $tec_consecuencia, $tec_autoriza,
				$pac_rut, $pac_nombre, $tec_diagnostico, $tec_nombre_gen, $tec_nombre_com, $tec_uso, $tec_riesgo, $tec_lote, $tec_serie, $tec_fecha_fab, $tec_fecha_ven, $tec_condicion, $tec_num_registro,
				$tec_disponibilidad, $tec_adquisicion, $tec_fnombre, $tec_fpais, $tec_femail, $tec_ftelefono, $tec_rnombre, $tec_rdireccion, $tec_remail, $tec_rtelefono, $tec_imnombre, $tec_imdireccion, $tec_imemail,
				$tec_imtelefono, $tec_correccion, $id);
			if (!$bind):
				throw new Exception("La edición del evento falló en su binding.");
			endif;

			if (!$stmt->execute()):
				throw new Exception("La edición del evento falló en su ejecución.");
			endif;

			return array('estado' => true, 'msg' => $stmt->insert_id);
		} catch (Exception $e) {
			return array('estado' => false, 'msg' => $e->getMessage());
		}
	}
}