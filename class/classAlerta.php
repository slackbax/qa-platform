<?php

class Alerta {
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
                                    FROM uc_eventoalerta e
                                    JOIN uc_usuario u ON e.us_id = u.us_id
                                    WHERE e.eal_id = ?");

		$stmt->bind_param("i", $id);
		$stmt->execute();
		$result = $stmt->get_result();
		$obj = new stdClass();

		$row = $result->fetch_assoc();
		$obj->eal_id = $row['eal_id'];
		$obj->eal_usid = $row['us_id'];
		$obj->eal_username = $row['us_username'];
		$obj->eal_fecha = utf8_encode($row['eal_fecha']);
		$obj->eal_marca = utf8_encode($row['eal_marca']);
		$obj->eal_riesgo = utf8_encode($row['eal_riesgo']);
		$obj->eal_tipoalerta = utf8_encode($row['eal_tipoalerta']);
		$obj->eal_lote = utf8_encode($row['eal_lote']);
		$obj->eal_serie = utf8_encode($row['eal_serie']);
		$obj->eal_fnombre = utf8_encode($row['eal_fnombre']);
		$obj->eal_femail = utf8_encode($row['eal_femail']);
		$obj->eal_ftelefono = utf8_encode($row['eal_ftelefono']);
		$obj->eal_inombre = utf8_encode($row['eal_inombre']);
		$obj->eal_iemail = utf8_encode($row['eal_iemail']);
		$obj->eal_itelefono = utf8_encode($row['eal_itelefono']);
		$obj->eal_plan = utf8_encode($row['eal_plan']);
		$obj->eal_registro = $row['eal_registro'];

		unset($db);
		return $obj;
	}

	/**
	 * @return array
	 */
	public function getAll(): array
	{
		$db = new myDBC();
		$stmt = $db->Prepare("SELECT eal_id FROM uc_eventoalerta");
		$stmt->execute();
		$result = $stmt->get_result();
		$lista = [];

		while ($row = $result->fetch_assoc()):
			$lista[] = $this->get($row['eal_id']);
		endwhile;

		unset($db);
		return $lista;
	}

	/**
	 * @param $us_id
	 * @param $eal_marca
	 * @param $eal_riesgo
	 * @param $eal_tipoalerta
	 * @param $eal_lote
	 * @param $eal_serie
	 * @param $eal_fnombre
	 * @param $eal_femail
	 * @param $eal_ftelefono
	 * @param $eal_inombre
	 * @param $eal_iemail
	 * @param $eal_itelefono
	 * @param $eal_plan
	 * @param $db
	 * @return array
	 */
	public function set($us_id, $dateal, $eal_marca, $eal_riesgo, $eal_tipoalerta, $eal_lote, $eal_serie, $eal_fnombre, $eal_femail, $eal_ftelefono, $eal_inombre, $eal_iemail, $eal_itelefono, $eal_plan, $db): array
	{
		if (is_null($db)):
			$db = new myDBC();
		endif;

		try {
			$stmt = $db->Prepare("INSERT INTO uc_eventoalerta (us_id, eal_fecha, eal_marca, eal_riesgo, eal_tipoalerta, eal_lote, eal_serie, eal_fnombre, eal_femail, eal_ftelefono, 
                             			eal_inombre, eal_iemail, eal_itelefono, eal_plan) 
                                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

			if (!$stmt):
				throw new Exception("La inserción del evento de alerta falló en su preparación.");
			endif;

			$eal_marca = $db->clearText(utf8_decode($eal_marca));
			$eal_riesgo = $db->clearText(utf8_decode($eal_riesgo));
			$eal_tipoalerta = $db->clearText(utf8_decode($eal_tipoalerta));
			$eal_lote = $db->clearText(utf8_decode($eal_lote));
			$eal_serie = $db->clearText(utf8_decode($eal_serie));
			$eal_fnombre = $db->clearText(utf8_decode($eal_fnombre));
			$eal_femail = $db->clearText(utf8_decode($eal_femail));
			$eal_ftelefono = $db->clearText(utf8_decode($eal_ftelefono));
			$eal_inombre = $db->clearText(utf8_decode($eal_inombre));
			$eal_iemail = $db->clearText(utf8_decode($eal_iemail));
			$eal_itelefono = $db->clearText(utf8_decode($eal_itelefono));
			$eal_plan = $db->clearText(utf8_decode($eal_plan));
			$bind = $stmt->bind_param("isssssssssssss", $us_id, $dateal, $eal_marca, $eal_riesgo, $eal_tipoalerta, $eal_lote, $eal_serie, $eal_fnombre, $eal_femail, $eal_ftelefono, $eal_inombre,
										$eal_iemail, $eal_itelefono, $eal_plan);
			if (!$bind):
				throw new Exception("La inserción del evento de alerta falló en su binding.");
			endif;

			if (!$stmt->execute()):
				throw new Exception("La inserción del evento de alerta falló en su ejecución.");
			endif;

			return array('estado' => true, 'msg' => $stmt->insert_id);
		} catch (Exception $e) {
			return array('estado' => false, 'msg' => $e->getMessage());
		}
	}

	/**
	 * @param $id
	 * @param $us_id
	 * @param $eal_marca
	 * @param $eal_riesgo
	 * @param $eal_tipoalerta
	 * @param $eal_lote
	 * @param $eal_serie
	 * @param $eal_fnombre
	 * @param $eal_femail
	 * @param $eal_ftelefono
	 * @param $eal_inombre
	 * @param $eal_iemail
	 * @param $eal_itelefono
	 * @param $eal_plan
	 * @param $db
	 * @return array
	 */
	public function mod($id, $us_id, $eal_date, $eal_marca, $eal_riesgo, $eal_tipoalerta, $eal_lote, $eal_serie, $eal_fnombre, $eal_femail, $eal_ftelefono, $eal_inombre, $eal_iemail, $eal_itelefono, $eal_plan, $db): array
	{
		if (is_null($db)):
			$db = new myDBC();
		endif;

		try {
			$stmt = $db->Prepare("UPDATE uc_eventoalerta SET us_id = ?, eal_fecha = ?, eal_marca = ?, eal_riesgo = ?, eal_tipoalerta = ?, eal_lote = ?, eal_serie = ?, eal_fnombre = ?, eal_femail = ?, eal_ftelefono = ?, eal_inombre = ?, 
                           eal_iemail = ?, eal_itelefono = ?, eal_plan = ? WHERE eal_id = ?");

			if (!$stmt):
				throw new Exception("La edición del evento de alerta falló en su preparación.");
			endif;

			$eal_marca = $db->clearText(utf8_decode($eal_marca));
			$eal_riesgo = $db->clearText(utf8_decode($eal_riesgo));
			$eal_tipoalerta = $db->clearText(utf8_decode($eal_tipoalerta));
			$eal_lote = $db->clearText(utf8_decode($eal_lote));
			$eal_serie = $db->clearText(utf8_decode($eal_serie));
			$eal_fnombre = $db->clearText(utf8_decode($eal_fnombre));
			$eal_femail = $db->clearText(utf8_decode($eal_femail));
			$eal_ftelefono = $db->clearText(utf8_decode($eal_ftelefono));
			$eal_inombre = $db->clearText(utf8_decode($eal_inombre));
			$eal_iemail = $db->clearText(utf8_decode($eal_iemail));
			$eal_itelefono = $db->clearText(utf8_decode($eal_itelefono));
			$eal_plan = $db->clearText(utf8_decode($eal_plan));
			$bind = $stmt->bind_param("isssssssssssssi", $us_id, $eal_date, $eal_marca, $eal_riesgo, $eal_tipoalerta, $eal_lote, $eal_serie, $eal_fnombre, $eal_femail, $eal_ftelefono, $eal_inombre,
				$eal_iemail, $eal_itelefono, $eal_plan, $id);
			if (!$bind):
				throw new Exception("La edición del evento de alerta falló en su binding.");
			endif;

			if (!$stmt->execute()):
				throw new Exception("La edición del evento de alerta falló en su ejecución.");
			endif;

			return array('estado' => true, 'msg' => $stmt->insert_id);
		} catch (Exception $e) {
			return array('estado' => false, 'msg' => $e->getMessage());
		}
	}
}
