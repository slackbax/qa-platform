<?php
session_start();
include("../../class/classMyDBC.php");
include("../../class/classFile.php");
include("../../src/fn.php");
include("../../src/sessionControl.ajax.php");

if (extract($_POST)):
    $db = new myDBC();
    $fl = new File();
    $idate = setDateBD($idate);
    $idatec = setDateBD('01/' . $idatec);
    
    try {
        $db->autoCommit(FALSE);
        $ins = $fl->mod($iid, $iind, $_SESSION['uc_userid'], $iname, $icode, $iversion, $idate, $idatec, $db);
        
        if (!$ins['estado']):
            throw new Exception('Error al modificar los datos del documento. ' . $ins['msg'], 0);
        endif;
        
        $modpv = $fl->delFilePV($ins['msg'], $db);
        
        if (!$modpv['estado']):
            throw new Exception('Error al modificar-eliminar puntos de verificación del documento. ' . $modpv['msg'], 0);
        endif;
        
        while ($check = current($ipvs)):
            if ($check == 'on'):
                $grp = $fl->setFilePV($ins['msg'], key($ipvs), $db);

                if (!$grp['estado']):
                    throw new Exception('Error al modificar-crear puntos de verificación del documento. ' . $grp['msg'], 0);
                endif;
            endif;

            next($ipvs);
        endwhile;

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