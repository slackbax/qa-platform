<?php

session_start();
include("../class/classMyDBC.php");
include("../class/classOFile.php");
include("../src/fn.php");
include("../src/sessionControl.ajax.php");

if (extract($_POST)):
    $db = new myDBC();
    $fl = new OFile();
    $idate = setDateBD($idate);
    $idatec = setDateBD('01/' . $idatec);
    
    try {
        $db->autoCommit(FALSE);
        $ins = $fl->set($ifolder, $_SESSION['uc_userid'], $iname, $iversion, $idate, $idatec, $db);
        
        if (!$ins['estado']):
            throw new Exception('Error al guardar los datos del documento. ' . $ins['msg'], 0);
        endif;

		$targetPath = '/home/hggb/repo_calidad';

        foreach ($_FILES as $aux => $file):
            $tempFile = $file['tmp_name'][0];
            $fileName = date('Ymd') . '_' . removeAccents(str_replace(' ', '_', $file['name'][0]));
            $targetFile = rtrim($targetPath,'/') . '/' . $fileName;
            
            if(!move_uploaded_file($tempFile, $targetFile)):
                throw new Exception("Error al subir el documento. " . error_get_last(), 0);
            endif;
            
            $doc_route = '/repo_calidad/' . $fileName;
            $ins_p = $fl->setPath($ins['msg'], $doc_route, $db);

            if (!$ins_p['estado']):
                throw new Exception('Error al guardar el documento. ' . $ins['msg'], 0);
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