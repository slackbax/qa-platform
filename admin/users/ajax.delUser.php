<?php

include("../../class/classMyDBC.php");
include("../../class/classUser.php");

if (extract($_POST)):
    $user = new User();

    try {
        $us = $user->del($id);
        
        if (!$us):
            throw new Exception('Error al eliminar el usuario.');
        endif;
        
        $response = array('type' => true, 'msg' => 'OK');
        echo json_encode($response);
        
    } catch (Exception $e) {
        $response = array('type' => false, 'msg' => $e->getMessage());
        echo json_encode($response);
    }
endif;