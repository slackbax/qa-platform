<?php
session_start();
include("../../class/classMyDBC.php");
include("../../class/classFile.php");
include("../../src/fn.php");
include("../../src/sessionControl.ajax.php");

if (extract($_POST)):
    $db = new myDBC();
    $file = new File();
    
    try {
        $db->autoCommit(FALSE);
        $fl = $file->del($id, BASEFOLDER, $db);

        if (!$fl['estado']):
            throw new Exception('Error al eliminar el documento. ' . $fl['msg'], 0);
        endif;

        $db->Commit();
        $db->autoCommit(TRUE);
        $response = array('type' => true, 'msg' => 'OK');
        echo json_encode($response);
        
    } catch (Exception $e) {
        $db->Rollback();
        $db->autoCommit(TRUE);
        $response = array('type' => false, 'msg' => $e->getMessage(), 'code' => $e->getCode());
        echo json_encode($response);
    }
endif;