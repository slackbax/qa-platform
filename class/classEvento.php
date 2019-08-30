<?php

class Evento {
    
    public function __construct() {}

	/**
	 * @param $id
	 * @return stdClass
	 */
    public function get($id) {
        $db = new myDBC();
        $stmt = $db->Prepare("SELECT *, tv2.tver_descripcion AS je, tv3.tver_descripcion AS acj, tv4.tver_descripcion AS rep, tv5.tver_descripcion AS ver 
                                    FROM uc_evento e
                                    JOIN uc_usuario u ON e.us_id = u.us_id
                                    LEFT JOIN uc_servicio s ON e.ser_id = s.ser_id
                                    JOIN uc_riesgo r ON e.rie_id = r.rie_id
                                    JOIN uc_subtipo_evento se ON e.stev_id = se.stev_id
                                    JOIN uc_tipo_evento te ON se.tev_id = te.tev_id
                                    JOIN uc_categoria ca ON se.cat_id = ca.cat_id
                                    JOIN uc_tipo_paciente tp ON e.tpac_id = tp.tpac_id
                                    JOIN uc_consecuencia c ON e.cons_id = c.cons_id
                                    JOIN uc_tipo_verificacion tv2 ON e.ev_justificacion = tv2.tver_id
                                    JOIN uc_tipo_verificacion tv3 ON e.ev_analisis_jus = tv3.tver_id
                                    JOIN uc_tipo_verificacion tv4 ON e.ev_reporte = tv4.tver_id
                                    JOIN uc_tipo_verificacion tv5 ON e.ev_verificacion = tv5.tver_id
                                    WHERE e.ev_id = ?");
        
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $obj = new stdClass();
        
        $row = $result->fetch_assoc();
        $obj->ev_id = $row['ev_id'];
        $obj->ser_id = $row['ser_id'];
        $obj->ser_desc = utf8_encode($row['ser_nombre']);
        $obj->ev_usid = $row['us_id'];
        $obj->ev_username = $row['us_username'];
        $obj->rie_id = $row['rie_id'];
        $obj->rie_desc = utf8_encode($row['rie_descripcion']);
        $obj->stev_id = $row['stev_id'];
        $obj->stev_desc = utf8_encode($row['stev_descripcion']);
        $obj->tev_id = $row['tev_id'];
        $obj->tev_desc = utf8_encode($row['tev_descripcion']);
        $obj->cat_id = $row['cat_id'];
        $obj->cat_desc = utf8_encode($row['cat_descripcion']);
        $obj->tpac_id = $row['tpac_id'];
        $obj->tpac_desc = utf8_encode($row['tpac_descripcion']);
        $obj->cons_id = $row['cons_id'];
        $obj->cons_desc = utf8_encode($row['cons_descripcion']);
        $obj->ev_rut = utf8_encode($row['ev_rut']);
        $obj->ev_nombre = utf8_encode($row['ev_nombre']);
		$obj->ev_edad = $row['ev_edad'];
        $obj->ev_sala = utf8_encode($row['ev_sala']);
        $obj->ev_fecha = utf8_encode($row['ev_fecha']);
        $obj->ev_contexto = utf8_encode($row['ev_contexto']);
        $obj->ev_justificacion = $row['ev_justificacion'];
        $obj->ev_je = $row['je'];
        $obj->ev_analisis_jus = $row['ev_analisis_jus'];
        $obj->ev_acj = $row['acj'];
        $obj->ev_reporte = $row['ev_reporte'];
        $obj->ev_rep = $row['rep'];
        $obj->ev_verificacion = $row['ev_verificacion'];
        $obj->ev_ver = $row['ver'];
        $obj->ev_path = $row['ev_path'];
        $obj->ev_caida_path = $row['ev_caida_path'];

        unset($db);
        return $obj;
    }

	/**
	 * @return array
	 */
    public function getAll() {
        $db = new myDBC();
        $stmt = $db->Prepare("SELECT ev_id FROM uc_evento");
        $stmt->execute();
        $result = $stmt->get_result();
        $lista = [];
      
        while ($row = $result->fetch_assoc()):
            $lista[] = $this->get($row['ev_id']);
        endwhile;
      
        unset($db);
        return $lista;
    }

	/**
	 * @param $us
	 * @return array
	 */
    public function getByUser($us) {
        $db = new myDBC();
        $stmt = $db->Prepare("SELECT ev_id FROM uc_evento WHERE us_id = ?");
        $stmt->bind_param("i", $us);
        $stmt->execute();
        $result = $stmt->get_result();
        $lista = [];
      
        while ($row = $result->fetch_assoc()):
            $lista[] = $this->get($row['ev_id']);
        endwhile;
      
        unset($db);
        return $lista;
    }

	/**
	 * @param $pac
	 * @return stdClass
	 */
    public function getByRut($pac) {
        $db = new myDBC();
        $stmt = $db->Prepare("SELECT ev_id FROM uc_evento WHERE ev_rut = ? LIMIT 1");
        $stmt->bind_param("s", $pac);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $row = $result->fetch_assoc();
        $obj = $this->get($row['ev_id']);
      
        unset($db);
        return $obj;
    }

	/**
	 * @param $us_id
	 * @param $ser_id
	 * @param $rie_id
	 * @param $stev_id
	 * @param $tpac_id
	 * @param $cons_id
	 * @param $ev_rut
	 * @param $ev_nombre
	 * @param $ev_edad
	 * @param $ev_fecha
	 * @param $ev_contexto
	 * @param $ev_justificacion
	 * @param $ev_analisis_jus
	 * @param $ev_reporte
	 * @param $ev_verificacion
	 * @param $db
	 * @return array
	 */
    public function set($us_id, $ser_id, $rie_id, $stev_id, $tpac_id, $cons_id, $ev_rut, $ev_nombre, $ev_edad, $ev_fecha, $ev_contexto, $ev_justificacion, $ev_analisis_jus, $ev_reporte, $ev_verificacion, $db) {
        if (is_null($db)):
            $db = new myDBC();
        endif;
        
        try {
            $stmt = $db->Prepare("INSERT INTO uc_evento (us_id, ser_id, rie_id, stev_id, tpac_id, cons_id, ev_rut, ev_nombre, ev_edad, ev_fecha, ev_contexto, ev_justificacion, ev_analisis_jus, ev_reporte, ev_verificacion) 
                                        VALUES (?, ?, ?, ?, ?, ?, ?, UPPER(?), ?, ?, ?, ?, ?, ?, ?)");
            
            if (!$stmt):
                throw new Exception("La inserción del evento falló en su preparación.");
            endif;

            $bind = $stmt->bind_param("iiiiiississiiii", $us_id, $ser_id, $rie_id, $stev_id, $tpac_id, $cons_id, $db->clearText(utf8_decode($ev_rut)), $db->clearText(utf8_decode($ev_nombre)), $db->clearText(utf8_decode($ev_edad)),
                                $db->clearText($ev_fecha), nl2br($db->clearText(utf8_decode($ev_contexto))), $ev_justificacion, $ev_analisis_jus, $ev_reporte, $ev_verificacion);
            if (!$bind):
                throw new Exception("La inserción del evento falló en su binding.");
            endif;

            if (!$stmt->execute()):
                throw new Exception("La inserción del evento falló en su ejecución.");
            endif;

            $result = array('estado' => true, 'msg' => $stmt->insert_id);
            return $result;
            
        } catch (Exception $e) {
            $result = array('estado' => false, 'msg' => $e->getMessage());
            return $result;
        }
    }

	/**
	 * @param $ev_id
	 * @param $ev_path
	 * @param null $db
	 * @return array
	 */
    public function setPath($ev_id, $ev_path, $db = null) {
        if (is_null($db)):
            $db = new myDBC();
        endif;
        
        try {
            $stmt = $db->Prepare("UPDATE uc_evento SET ev_path = ? WHERE ev_id = ?");

            if (!$stmt):
                throw new Exception("La inserción del evento-path falló en su preparación.");
            endif;

            $bind = $stmt->bind_param("si", $ev_path, $ev_id);
            if (!$bind):
                throw new Exception("La inserción del evento-path falló en su binding.");
            endif;

            if (!$stmt->execute()):
                throw new Exception("La inserción del evento-path falló en su ejecución.");
            endif;

            $result = array('estado' => true, 'msg' => $ev_id);
            return $result;
        
        } catch (Exception $e) {
            $result = array('estado' => false, 'msg' => $e->getMessage());
            return $result;
        }
    }

	/**
	 * @param $ev_id
	 * @param $ev_path
	 * @param null $db
	 * @return array
	 */
    public function setPathCaida($ev_id, $ev_path, $db = null) {
        if (is_null($db)):
            $db = new myDBC();
        endif;
        
        try {
            $stmt = $db->Prepare("UPDATE uc_evento SET ev_caida_path = ? WHERE ev_id = ?");

            if (!$stmt):
                throw new Exception("La inserción del evento-caida-path falló en su preparación.");
            endif;

            $bind = $stmt->bind_param("si", $ev_path, $ev_id);
            if (!$bind):
                throw new Exception("La inserción del evento-caida-path falló en su binding.");
            endif;

            if (!$stmt->execute()):
                throw new Exception("La inserción del evento-caida-path falló en su ejecución.");
            endif;

            $result = array('estado' => true, 'msg' => $ev_id);
            return $result;
        
        } catch (Exception $e) {
            $result = array('estado' => false, 'msg' => $e->getMessage());
            return $result;
        }
    }
}