<?php

class Codigo {
    
    public function __construct() {}
    
    /**
     * 
     * @param $id
     * @return \stdClass
     */
    public function get($id) {
        $db = new myDBC();
        $stmt = $db->Prepare("SELECT * FROM uc_codigo WHERE cod_id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $obj = new stdClass();
        
        $row = $result->fetch_assoc();
        $obj->cod_id = $row['cod_id'];
        $obj->cod_descripcion = utf8_encode($row['cod_descripcion']);

        unset($db);
        return $obj;
    }
    
    /**
     * 
     * @return $lista
     */
    public function getAll() {
        $db = new myDBC();
        $stmt = $db->Prepare("SELECT cod_id FROM uc_codigo");
        $stmt->execute();
        $result = $stmt->get_result();
        $lista = [];
      
        while ($row = $result->fetch_assoc()):
            $lista[] = $this->get($row['cod_id']);
        endwhile;
      
        unset($db);
        return $lista;
    }

	/**
	 *
	 * @param $sid
	 * @return array
	 */
    public function getBySa($sid) {
		$db = new myDBC();
		$stmt = $db->Prepare("SELECT i.cod_id FROM uc_indicador i
                                JOIN uc_codigo c ON i.cod_id = c.cod_id
                                WHERE samb_id = ?");

		$stmt->bind_param("i", $sid);
		$stmt->execute();
		$result = $stmt->get_result();
		$lista = [];

		while ($row = $result->fetch_assoc()):
			$lista[] = $this->get($row['cod_id']);
		endwhile;

		unset($db);
		return $lista;
	}
    
    /**
     * 
     * @param $sid
     * @param $tcid
     * @return array
     */
    public function getBySaTc($sid, $tcid) {
        $db = new myDBC();
        $stmt = $db->Prepare("SELECT i.cod_id FROM uc_indicador i
                                JOIN uc_codigo c ON i.cod_id = c.cod_id
                                JOIN uc_tipo_caracteristica tc ON i.tcar_id = tc.tcar_id
                                WHERE samb_id = ? AND i.tcar_id = ?");
        
        $stmt->bind_param("ii", $sid, $tcid);
        $stmt->execute();
        $result = $stmt->get_result();
        $lista = [];
      
        while ($row = $result->fetch_assoc()):
            $lista[] = $this->get($row['cod_id']);
        endwhile;
      
        unset($db);
        return $lista;
    }
}