<?php

class Folder {
    
    public function __construct() {}
    
    /**
     * 
     * @param $id
     * @return stdClass
     */
    public function get($id) {
        $db = new myDBC();
        $stmt = $db->Prepare("SELECT * FROM uc_folder WHERE fol_id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $obj = new stdClass();
        
        $row = $result->fetch_assoc();
        $obj->fol_id = $row['fol_id'];
        $obj->fol_parent_id = $row['fol_parent_id'];
        $obj->fol_nombre = utf8_encode($row['fol_nombre']);
        $obj->fol_descripcion = utf8_encode($row['fol_descripcion']);
        $obj->fol_fecha = $row['fol_fecha'];

        unset($db);
        return $obj;
    }
    
    /**
     * 
     * @return array
     */
    public function getAll() {
        $db = new myDBC();
        $stmt = $db->Prepare("SELECT fol_id FROM uc_folder WHERE fol_publicado = TRUE ORDER BY fol_nombre ASC");
        $stmt->execute();
        $result = $stmt->get_result();
        $lista = array();
      
        while ($row = $result->fetch_assoc()):
            $lista[] = $this->get($row['fol_id']);
        endwhile;
      
        unset($db);
        return $lista;
    }
    
    /**
     * 
     * @return array
     */
    public function getMain() {
        $db = new myDBC();
        $stmt = $db->Prepare("SELECT * FROM uc_folder WHERE fol_publicado = TRUE AND fol_parent_id IS NULL ORDER BY fol_nombre ASC");
        $stmt->execute();
        $result = $stmt->get_result();
        $lista = array();
      
        while ($row = $result->fetch_assoc()):
            $lista[] = $this->get($row['fol_id']);
        endwhile;
      
        unset($db);
        return $lista;
    }
    
    /**
     * 
     * @return array
     */
    public function getLesser() {
        $db = new myDBC();
        $stmt = $db->Prepare("SELECT * FROM uc_folder WHERE fol_publicado = TRUE AND fol_parent_id IS NOT NULL ORDER BY fol_nombre ASC");
        $stmt->execute();
        $result = $stmt->get_result();
        $lista = array();
      
        while ($row = $result->fetch_assoc()):
            $lista[] = $this->get($row['fol_id']);
        endwhile;
      
        unset($db);
        return $lista;
    }
    
    /**
     * 
     * @param $id
     * @return array
     */
    public function getChildren($id) {
        $db = new myDBC();
        $stmt = $db->Prepare("SELECT * FROM uc_folder WHERE fol_publicado = TRUE AND fol_parent_id = ? ORDER BY fol_nombre ASC");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $lista = array();
      
        while ($row = $result->fetch_assoc()):
            $lista[] = $this->get($row['fol_id']);
        endwhile;
      
        unset($db);
        return $lista;
    }
    
    /**
     * 
     * @param $id
     * @return int
     */
    public function getNumFiles($id) {
        $db = new myDBC();
        $stmt = $db->Prepare("SELECT COUNT(oarc_id) AS filecount FROM uc_oarchivo WHERE oarc_publicado = TRUE AND fol_id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        unset($db);
        
        return $row['filecount'];
    }
    
    /**
     * 
     * @param $fol_nombre
     * @param $fol_desc
     * @param $menu_id
     * @param $fol_p
     * @param myDBC $db
     * @return boolean
     */
    public function set($fol_nombre, $fol_desc, $menu_id = null, $fol_p = null, $db = null) {
        if (is_null($db)):
            $db = new myDBC();
        endif;
        
        if (is_null($menu_id)):
            $_qcol = 'fol_parent_id';
        endif;
        
        if (is_null($fol_p)):
            $_qcol = 'men_id';
        endif;
        
        $stmt = $db->Prepare("INSERT INTO uc_folder (fol_nombre, fol_descripcion, fol_fecha, fol_publicado, fol_foldercount, fol_filecount, " . $_qcol . ") VALUES (
                ?, ?, CURRENT_DATE, TRUE, 0 , 0, ?)");
        
        if (is_null($menu_id)):
            $stmt->bind_param("ssi", utf8_decode($db->clearText($fol_nombre)), utf8_decode($db->clearText($fol_desc)), $fol_p);
        endif;
        if (is_null($fol_p)):
            $stmt->bind_param("ssi", utf8_decode($db->clearText($fol_nombre)), utf8_decode($db->clearText($fol_desc)), $menu_id);
        endif;

        if ($stmt->execute()):
            return true;
        else:
            return false;
        endif;
    }
    
}