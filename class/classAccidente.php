<?php

class Accidente {
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
                                    FROM uc_acc_laboral a
                                    JOIN uc_usuario u ON a.us_id = u.us_id
									JOIN uc_usuario um ON a.us_mod_id = u.us_id
                                    JOIN uc_estamento ue on a.esta_id = ue.esta_id
                                    JOIN uc_servicio s ON a.ser_id = s.ser_id
									JOIN uc_unidad un on u.un_id = un.un_id
                                    WHERE acl_id = ?");

		$stmt->bind_param("i", $id);
		$stmt->execute();
		$result = $stmt->get_result();
		$obj = new stdClass();

		$row = $result->fetch_assoc();
		$obj->acl_id = $row['acl_id'];
		$obj->ser_id = $row['ser_id'];
		$obj->ser_desc = utf8_encode($row['ser_nombre']);
		$obj->esta_id = $row['esta_id'];
		$obj->esta_desc = utf8_encode($row['esta_descripcion']);
		$obj->us_id = $row['us_id'];
		$obj->us_username = $row['us_username'];
		$obj->us_mod_id = $row['us_id'];
		$obj->us_mod_username = $row['us_username'];
		$obj->acl_fecha = $row['acl_fecha'];
		$obj->acl_fecha_acc = $row['acl_fecha_acc'];
		$obj->acl_nombres = utf8_encode($row['acl_nombres']);
		$obj->acl_ap = utf8_encode($row['acl_ap']);
		$obj->acl_am = utf8_encode($row['acl_am']);
		$obj->acl_lugar = utf8_encode($row['acl_lugar']);
		$obj->acl_descripcion = utf8_encode($row['acl_descripcion']);
		$obj->acl_vacuna = $row['acl_vacuna'];
		$obj->acl_tiempo_espera = utf8_encode($row['acl_tiempo_espera']);
		$obj->acl_ficha = $row['acl_ficha'];
		$obj->acl_medico_turno = utf8_encode($row['acl_medico_turno']);
		$obj->acl_fuente = $row['acl_fuente'];
		$obj->acl_aviso = $row['acl_aviso'];
		$obj->acl_diat = $row['acl_diat'];
		$obj->acl_seguimiento = $row['acl_seguimiento'];
		$obj->acl_atencion = $row['acl_atencion'];
		$obj->acl_serologia = $row['acl_serologia'];
		$obj->acl_tratamiento = $row['acl_tratamiento'];
		$obj->acl_protocolo = $row['acl_protocolo'];
		$obj->un_nombre = utf8_encode($row['un_nombre']);
		$obj->acl_registro = $row['acl_registro'];
		$obj->acl_mod = $row['acl_mod'];

		unset($db);
		return $obj;
	}

	/**
	 * @return array
	 */
	public function getAll(): array
	{
		$db = new myDBC();
		$stmt = $db->Prepare("SELECT acl_id FROM uc_acc_laboral");
		$stmt->execute();
		$result = $stmt->get_result();
		$lista = [];

		while ($row = $result->fetch_assoc()):
			$lista[] = $this->get($row['acl_id']);
		endwhile;

		unset($db);
		return $lista;
	}

	/**
	 * @param $ser
	 * @param $us
	 * @param $us_mod
	 * @param $esta
	 * @param $fecha
	 * @param $fecha_acc
	 * @param $nombres
	 * @param $ap
	 * @param $am
	 * @param $lugar
	 * @param $desc
	 * @param $vacuna
	 * @param $tiempo
	 * @param $ficha
	 * @param $medico
	 * @param $fuente
	 * @param $aviso
	 * @param $diat
	 * @param $seguim
	 * @param $aten
	 * @param $serol
	 * @param $trat
	 * @param $prot
	 * @param $db
	 * @return array
	 */
	public function set($ser, $us, $us_mod, $esta, $fecha, $fecha_acc, $nombres, $ap, $am, $lugar, $desc, $vacuna, $tiempo, $ficha, $medico, $fuente, $aviso, $diat, $seguim, $aten, $serol, $trat, $prot, $db): array
	{
		if (is_null($db)):
			$db = new myDBC();
		endif;

		try {
			$stmt = $db->Prepare("INSERT INTO uc_acc_laboral (ser_id, us_id, us_mod_id, esta_id, acl_fecha, acl_fecha_acc, acl_nombres, acl_ap, acl_am, acl_lugar, acl_descripcion, acl_vacuna, 
                            			acl_tiempo_espera, acl_ficha, acl_medico_turno, acl_fuente, acl_aviso, acl_diat, acl_seguimiento, acl_atencion, acl_serologia, acl_tratamiento, acl_protocolo, acl_mod) 
                                        VALUES (?, ?, ?, ?, ?, ?, UPPER(?), UPPER(?), UPPER(?), ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, CURRENT_TIMESTAMP)");

			if (!$stmt):
				throw new Exception("La inserción del accidente falló en su preparación.");
			endif;

			$fecha = $db->clearText($fecha);
			$fecha_acc = $db->clearText($fecha_acc);
			$nombres = $db->clearText(utf8_decode($nombres));
			$ap = $db->clearText(utf8_decode($ap));
			$am = $db->clearText(utf8_decode($am));
			$lugar = $db->clearText(utf8_decode($lugar));
			$desc = $db->clearText(utf8_decode($desc));
			$tiempo = $db->clearText(utf8_decode($tiempo));
			$ficha = $db->clearText(utf8_decode($ficha));
			$medico = $db->clearText(utf8_decode($medico));
			$bind = $stmt->bind_param("iiiisssssssisssiiisissi", $ser, $us, $us_mod, $esta, $fecha, $fecha_acc, $nombres, $ap, $am, $lugar, $desc, $vacuna,
				$tiempo, $ficha, $medico, $fuente, $aviso, $diat, $seguim, $aten, $serol, $trat, $prot);
			if (!$bind):
				throw new Exception("La inserción del accidente falló en su binding.");
			endif;

			if (!$stmt->execute()):
				throw new Exception("La inserción del accidente falló en su ejecución.");
			endif;

			return array('estado' => true, 'msg' => $stmt->insert_id);
		} catch (Exception $e) {
			return array('estado' => false, 'msg' => $e->getMessage());
		}
	}

	/**
	 * @param $ser
	 * @param $us_mod
	 * @param $esta
	 * @param $fecha
	 * @param $fecha_acc
	 * @param $nombres
	 * @param $ap
	 * @param $am
	 * @param $lugar
	 * @param $desc
	 * @param $vacuna
	 * @param $tiempo
	 * @param $ficha
	 * @param $medico
	 * @param $fuente
	 * @param $aviso
	 * @param $diat
	 * @param $seguim
	 * @param $aten
	 * @param $serol
	 * @param $trat
	 * @param $prot
	 * @param $db
	 * @return array
	 */
	public function mod($ser, $us_mod, $esta, $fecha, $fecha_acc, $nombres, $ap, $am, $lugar, $desc, $vacuna, $tiempo, $ficha, $medico, $fuente, $aviso, $diat, $seguim, $aten, $serol, $trat, $prot, $db): array
	{
		if (is_null($db)):
			$db = new myDBC();
		endif;

		try {
			$stmt = $db->Prepare("INSERT INTO uc_acc_laboral (ser_id, us_mod_id, esta_id, acl_fecha, acl_fecha_acc, acl_nombres, acl_ap, acl_am, acl_lugar, acl_descripcion, acl_vacuna, 
                            			acl_tiempo_espera, acl_ficha, acl_medico_turno, acl_fuente, acl_aviso, acl_diat, acl_seguimiento, acl_atencion, acl_serologia, acl_tratamiento, acl_protocolo, acl_mod) 
                                        VALUES (?, ?, ?, ?, ?, UPPER(?), UPPER(?), UPPER(?), ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, CURRENT_TIMESTAMP)");

			if (!$stmt):
				throw new Exception("La inserción del accidente falló en su preparación.");
			endif;

			$fecha = $db->clearText($fecha);
			$fecha_acc = $db->clearText($fecha_acc);
			$nombres = $db->clearText(utf8_decode($nombres));
			$ap = $db->clearText(utf8_decode($ap));
			$am = $db->clearText(utf8_decode($am));
			$lugar = $db->clearText(utf8_decode($lugar));
			$desc = $db->clearText(utf8_decode($desc));
			$tiempo = $db->clearText(utf8_decode($tiempo));
			$ficha = $db->clearText(utf8_decode($ficha));
			$medico = $db->clearText(utf8_decode($medico));
			$bind = $stmt->bind_param("iiisssssssisssiiisissi", $ser, $us_mod, $esta, $fecha, $fecha_acc, $nombres, $ap, $am, $lugar, $desc, $vacuna,
				$tiempo, $ficha, $medico, $fuente, $aviso, $diat, $seguim, $aten, $serol, $trat, $prot);
			if (!$bind):
				throw new Exception("La inserción del accidente falló en su binding.");
			endif;

			if (!$stmt->execute()):
				throw new Exception("La inserción del accidente falló en su ejecución.");
			endif;

			return array('estado' => true, 'msg' => $stmt->insert_id);
		} catch (Exception $e) {
			return array('estado' => false, 'msg' => $e->getMessage());
		}
	}
}