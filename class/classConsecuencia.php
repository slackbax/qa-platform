<?php

class Consecuencia {
    
    public function __construct() {}
    
    /**
     * 
     * @param $id
     * @return stdClass
     */
    public function get($id) {
        $db = new myDBC();
        $stmt = $db->Prepare("SELECT * FROM uc_consecuencia WHERE cons_id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $obj = new stdClass();
        
        $row = $result->fetch_assoc();
        $obj->cons_id = $row['cons_id'];
        $obj->cons_descripcion = utf8_encode($row['cons_descripcion']);

        unset($db);
        return $obj;
    }
    
    /**
     * 
     * @return array
     */
    public function getAll() {
        $db = new myDBC();
        $stmt = $db->Prepare("SELECT cons_id FROM uc_consecuencia");
        $stmt->execute();
        $result = $stmt->get_result();
        $lista = [];
      
        while ($row = $result->fetch_assoc()):
            $lista[] = $this->get($row['cons_id']);
        endwhile;
      
        unset($db);
        return $lista;
    }
}