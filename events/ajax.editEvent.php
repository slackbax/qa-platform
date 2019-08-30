<?php
session_start();
include("../class/classMyDBC.php");
include("../class/classEvento.php");
include("../src/fn.php");
include("../src/sessionControl.ajax.php");

if (extract($_POST)):
    $db = new myDBC();
    $ev = new Evento();
    
    try {
        $db->autoCommit(FALSE);

        $event = $ev->get($iid);
        if (!empty($event->ev_path)) unlink('../' . $event->ev_path);
		if (!empty($event->ev_caida_path)) unlink('../' . $event->ev_caida_path);
        
        $targetPath = $_SERVER['DOCUMENT_ROOT'] . BASEFOLDER . 'upload';
        
        foreach ($_FILES as $aux => $file):
            $tempFile = $file['tmp_name'][0];
            $fileName = removeAccents(str_replace(' ', '_', $file['name'][0]));
            $targetFile = rtrim($targetPath,'/') . '/' . $fileName;
            
            if(!move_uploaded_file($tempFile, $targetFile)):
                throw new Exception("Error al subir el documento. " . print_r(error_get_last()), 0);
            endif;
            
            $doc_route = 'upload/' . $fileName;
            if ($aux == 'idocument')
            	$ins_f = $ev->setPath($iid, $doc_route, $db);
            if ($aux == 'idocumentcaida')
				$ins_f = $ev->setPathCaida($iid, $doc_route, $db);

            if (!$ins_f['estado']):
                throw new Exception('Error al guardar el documento. ' . $ins_f['msg'], 0);
            endif;
        endforeach;
        
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