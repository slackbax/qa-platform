<?php

class IndicadorTiempo {
    
    public function __construct() {}
    
    /**
     * 
     * @param $id
     * @return \stdClass
     */
    public function get($id) {
        $db = new myDBC();
        $stmt = $db->Prepare("SELECT * FROM uc_ind_tiempo
                                WHERE indt_id = ?");
        
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $obj = new stdClass();
        
        $row = $result->fetch_assoc();
        $obj->indt_id = $id;
        $obj->indt_spv = $row['spv_id'];
        $obj->indt_us = $row['us_id'];
        $obj->indt_ine = $row['ine_id'];
        $obj->indt_fecha = utf8_encode($row['indt_fecha']);
        $obj->indt_num = $row['indt_numerador'];
        $obj->indt_den = $row['indt_denominador'];

        unset($db);
        return $obj;
    }
    
    /**
     * 
     * @return array
     */
    public function getByIndYear($spv, $year) {
        $db = new myDBC();
        $stmt = $db->Prepare("SELECT indt_id
                                FROM uc_ind_tiempo
                                WHERE spv_id = ? AND YEAR(indt_fecha) = ?");
        
        $stmt->bind_param("is", $spv, $year);
        $stmt->execute();
        $result = $stmt->get_result();
        $array = [];
        
        while ($row = $result->fetch_assoc()):
            $array[] = $this->get($row['indt_id']);
        endwhile;

        unset($db);
        return $array;
    }
    
    /**
     * 
     * @param $ind
     * @param $date
     * @return stdClass
     */
    public function getByIndDate($spv, $ind, $date) {
        $db = new myDBC();
        $stmt = $db->Prepare("SELECT indt_id
                                FROM uc_ind_tiempo
                                WHERE spv_id = ? AND ine_id = ? AND indt_fecha = ?");
        
        $stmt->bind_param("iis", $spv, $ind, $date);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        
        $obj = $this->get($row['indt_id']);

        unset($db);
        return $obj;
    }
    
    /**
     * 
     * @param $spv
     * @param $us
     * @param $ine
     * @param $fecha
     * @param $num
     * @param $den
     * @param myDBC $db
     * @return array
     * @throws Exception
     */
    public function set($spv, $us, $ine, $fecha, $num, $den, $db = null) {
        if (is_null($db)):
            $db = new myDBC();
        endif;
        
        try {
            $stmt = $db->Prepare("INSERT INTO uc_ind_tiempo (spv_id, us_id, ine_id, indt_fecha, indt_numerador, indt_denominador)
                                    VALUES (?, ?, ?, ?, ?, ?)");

            if (!$stmt):
                throw new Exception("La inserción del indicador falló en su preparación.");
            endif;

            $bind = $stmt->bind_param("iiisii", $spv, $us, $ine, $db->clearText(utf8_decode($fecha)), $db->clearText($num), $db->clearText($den));
            if (!$bind):
                throw new Exception("La inserción del indicador falló en su binding.");
            endif;

            if (!$stmt->execute()):
                throw new Exception("La inserción del indicador falló en su ejecución.");
            endif;

            $result = array('estado' => true, 'msg' => $stmt->insert_id);
            return $result;
        
        } catch (Exception $e) {
            $result = array('estado' => false, 'msg' => $e->getMessage());
            return $result;
        }
    }
    
    /**
     * 
     * @param $id
     * @param myDBC $db
     * @return array
     * @throws Exception
     */
    public function del($id, $db = null) {
        if (is_null($db)):
            $db = new myDBC();
        endif;
        
        try {
            $stmt = $db->Prepare("DELETE FROM uc_ind_tiempo WHERE indt_id = ?");

            if (!$stmt):
                throw new Exception("La actualización del indicador falló en su preparación.");
            endif;

            $bind = $stmt->bind_param("i", $id);
            if (!$bind):
                throw new Exception("La actualización del indicador falló en su binding.");
            endif;

            if (!$stmt->execute()):
                throw new Exception("La actualización del indicador falló en su ejecución.");
            endif;

            $result = array('estado' => true, 'msg' => $id);
            return $result;
        
        } catch (Exception $e) {
            $result = array('estado' => false, 'msg' => $e->getMessage());
            return $result;
        }
    }
}