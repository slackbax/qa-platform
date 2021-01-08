<?php

class TecnoDivEvento {
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
                                    FROM uc_tecnoeventodiv e
                                    JOIN uc_usuario u ON e.us_id = u.us_id
                                    LEFT JOIN uc_servicio s ON e.ser_id = s.ser_id
                                    WHERE e.ted_id = ?");

        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $obj = new stdClass();

        $row = $result->fetch_assoc();
        $obj->ted_id = $row['ted_id'];
        $obj->ser_id = $row['ser_id'];
        $obj->ser_desc = utf8_encode($row['ser_nombre']);
        $obj->ted_usid = $row['us_id'];
        $obj->ted_username = $row['us_username'];
        $obj->ted_fecha = utf8_encode($row['ted_fecha']);
        $obj->ted_fecha_ev = utf8_encode($row['ted_fecha_ev']);
        $obj->ted_nombre_gen = utf8_encode($row['ted_nombre_gen']);
        $obj->ted_nombre_com = utf8_encode($row['ted_nombre_com']);
        $obj->ted_catalogo = utf8_encode($row['ted_catalogo']);
        $obj->ted_uso = utf8_encode($row['ted_uso']);
        $obj->ted_uso_otro = utf8_encode($row['ted_uso_otro']);
        $obj->ted_cadena = utf8_encode($row['ted_cadena']);
        $obj->ted_temperatura = utf8_encode($row['ted_temperatura']);
        $obj->ted_lote = utf8_encode($row['ted_lote']);
        $obj->ted_seguridad = utf8_encode($row['ted_seguridad']);
        $obj->ted_fnombre = utf8_encode($row['ted_fnombre']);
        $obj->ted_fpais = utf8_encode($row['ted_fpais']);
        $obj->ted_imnombre = utf8_encode($row['ted_imnombre']);
        $obj->ted_impais = utf8_encode($row['ted_impais']);
        $obj->ted_formauso = $row['ted_formauso'];
        $obj->ted_fecha_fab = utf8_encode($row['ted_fecha_fab']);
        $obj->ted_fecha_ven = utf8_encode($row['ted_fecha_ven']);
        $obj->ted_verificacion = $row['ted_verificacion'];
        $obj->ted_control = $row['ted_control'];
        $obj->ted_adscrito = $row['ted_adscrito'];
        $obj->ted_autorizacion = $row['ted_autorizacion'];
        $obj->ted_aut_otro = utf8_encode($row['ted_aut_otro']);
        $obj->ted_ensayo = utf8_encode($row['ted_ensayo']);
        $obj->ted_tecnica = utf8_encode($row['ted_tecnica']);
        $obj->ted_analizador = utf8_encode($row['ted_analizador']);
        $obj->ted_descripcion = utf8_encode($row['ted_descripcion']);
        $obj->ted_investigacion = $row['ted_investigacion'];
        $obj->ted_reporte = $row['ted_reporte'];
        $obj->ted_registro = $row['ted_registro'];

        unset($db);
        return $obj;
    }

    /**
     * @return array
     */
    public function getAll()
    {
        $db = new myDBC();
        $stmt = $db->Prepare("SELECT ted_id FROM uc_tecnoeventodiv");
        $stmt->execute();
        $result = $stmt->get_result();
        $lista = [];

        while ($row = $result->fetch_assoc()):
            $lista[] = $this->get($row['ted_id']);
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
        $stmt = $db->Prepare("SELECT MAX(ted_id) as ted_id FROM uc_tecnoeventodiv WHERE us_id = ?");
        $stmt->bind_param("i", $us);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        unset($db);
        return $this->get($row['ted_id']);
    }

    /**
     * @param $us_id
     * @param $ser_id
     * @param $ted_fecha
     * @param $ted_fecha_ev
     * @param $ted_nombre_gen
     * @param $ted_nombre_com
     * @param $ted_catalogo
     * @param $ted_uso
     * @param $ted_uso_otro
     * @param $ted_cadena
     * @param $ted_temperatura
     * @param $ted_lote
     * @param $ted_seguridad
     * @param $ted_fnombre
     * @param $ted_fpais
     * @param $ted_imnombre
     * @param $ted_impais
     * @param $ted_formauso
     * @param $ted_fecha_fab
     * @param $ted_fecha_ven
     * @param $ted_verificacion
     * @param $ted_control
     * @param $ted_adscrito
     * @param $ted_autorizacion
     * @param $ted_auto_otro
     * @param $ted_ensayo
     * @param $ted_tecnica
     * @param $ted_analizador
     * @param $ted_descripcion
     * @param $ted_investigacion
     * @param $ted_reporte
     * @param $db
     * @return array
     */
    public function set($us_id, $ser_id, $ted_fecha, $ted_fecha_ev, $ted_nombre_gen, $ted_nombre_com, $ted_catalogo, $ted_uso, $ted_uso_otro, $ted_cadena, $ted_temperatura,
                        $ted_lote, $ted_seguridad, $ted_fnombre, $ted_fpais, $ted_imnombre, $ted_impais, $ted_formauso, $ted_fecha_fab, $ted_fecha_ven, $ted_verificacion, $ted_control, $ted_adscrito, $ted_autorizacion, $ted_auto_otro,
                        $ted_ensayo, $ted_tecnica, $ted_analizador, $ted_descripcion, $ted_investigacion, $ted_reporte, $db)
    {
        if (is_null($db)):
            $db = new myDBC();
        endif;

        try {
            $stmt = $db->Prepare("INSERT INTO uc_tecnoeventodiv (us_id, ser_id, ted_fecha, ted_fecha_ev, ted_nombre_gen, ted_nombre_com, ted_catalogo, ted_uso, ted_uso_otro, ted_cadena, ted_temperatura,
                            			ted_lote, ted_seguridad, ted_fnombre, ted_fpais, ted_imnombre, ted_impais, ted_formauso, ted_fecha_fab, ted_fecha_ven, ted_verificacion, ted_control, ted_adscrito, ted_autorizacion, ted_aut_otro,
                            			ted_ensayo, ted_tecnica, ted_analizador, ted_descripcion, ted_investigacion, ted_reporte) 
                                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

            if (!$stmt):
                throw new Exception("La inserción del evento falló en su preparación.");
            endif;

            $ted_nombre_gen = $db->clearText(utf8_decode($ted_nombre_gen));
            $ted_nombre_com = $db->clearText(utf8_decode($ted_nombre_com));
            $ted_catalogo = $db->clearText(utf8_decode($ted_catalogo));
            $ted_uso = $db->clearText(utf8_decode($ted_uso));
            $ted_uso_otro = $db->clearText(utf8_decode($ted_uso_otro));
            $ted_cadena = $db->clearText(utf8_decode($ted_cadena));
            $ted_temperatura = $db->clearText(utf8_decode($ted_temperatura));
            $ted_lote = $db->clearText(utf8_decode($ted_lote));
            $ted_seguridad = $db->clearText(utf8_decode($ted_seguridad));
            $ted_fnombre = $db->clearText(utf8_decode($ted_fnombre));
            $ted_fpais = $db->clearText(utf8_decode($ted_fpais));
            $ted_imnombre = $db->clearText(utf8_decode($ted_imnombre));
            $ted_impais = $db->clearText(utf8_decode($ted_impais));
            $ted_formauso = $db->clearText(utf8_decode($ted_formauso));
            $ted_verificacion = $db->clearText(utf8_decode($ted_verificacion));
            $ted_control = $db->clearText(utf8_decode($ted_control));
            $ted_adscrito = $db->clearText(utf8_decode($ted_adscrito));
            $ted_autorizacion = $db->clearText(utf8_decode($ted_autorizacion));
            $ted_auto_otro = $db->clearText(utf8_decode($ted_auto_otro));
            $ted_ensayo = $db->clearText(utf8_decode($ted_ensayo));
            $ted_tecnica = $db->clearText(utf8_decode($ted_tecnica));
            $ted_analizador = $db->clearText(utf8_decode($ted_analizador));
            $ted_descripcion = utf8_decode($ted_descripcion);
            $bind = $stmt->bind_param("iisssssssissssssssssiiissssssii", $us_id, $ser_id, $ted_fecha, $ted_fecha_ev, $ted_nombre_gen, $ted_nombre_com, $ted_catalogo,
                $ted_uso, $ted_uso_otro, $ted_cadena, $ted_temperatura, $ted_lote, $ted_seguridad, $ted_fnombre, $ted_fpais, $ted_imnombre, $ted_impais, $ted_formauso, $ted_fecha_fab, $ted_fecha_ven, $ted_verificacion, $ted_control,
                $ted_adscrito, $ted_autorizacion, $ted_auto_otro, $ted_ensayo, $ted_tecnica, $ted_analizador, $ted_descripcion, $ted_investigacion, $ted_reporte);
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
}