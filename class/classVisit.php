<?php

class Visit {
    
    public function __construct() {}
    
    /**
     * 
     * @param $id
     * @return \stdClass
     */
    public function get($id) {
        $db = new myDBC();
        $result = $db->runQuery("SELECT * FROM uc_visita WHERE vis_id = '$id'");
        $obj = new stdClass();
        
        $row = $result->fetch_assoc();
        $obj->vis_id = $row['vis_id'];
        $obj->vis_ip = $row['vis_ip'];
        $obj->vis_ip_forw = $row['vis_ip_forw'];
        $obj->vis_date = $row['vis_date'];

        unset($db);
        return $obj;
    }
    
    /**
     * 
     * @param $ip
     * @return boolean
     */
    public function set($ip) {
        $db = new myDBC();
        
        $res = $db->runQuery("SELECT COUNT(vis_id) AS num FROM uc_visita WHERE vis_ip = '" . $ip . "' AND DAY(vis_date) = '" . date('d') . "'
                                AND MONTH(vis_date) = '" . date('m') . " AND YEAR(vis_date) = " . date('Y') . "'");
        
        $row = $res->fetch_assoc();
        
        if ($row['num'] <= 5):
            $result = $db->runQuery("INSERT INTO uc_visita (vis_ip, vis_date) VALUES ('" . $ip . "', NOW())");

            if ($result):
                unset($db);
                return true;
            else:
                return false;
            endif;
        endif;
        
        return true;
    }
}