<?php

session_start();
include("../../class/classMyDBC.php");
include("../../class/classUser.php");
include("../../class/classGroup.php");
include("../../src/sessionControl.ajax.php");

if (extract($_POST)):
    $db = new myDBC();
    $user = new User();
    $group = new Group();
    $_islog = false;
    
    if (isset($iactive)):
        $iactive = 1;
    else:
        $iactive = 0;
    endif;
    
    if ($_SESSION['uc_userid'] == $id):
        $_islog = true;
    endif;
    
    try {
        $db->autoCommit(FALSE);
        $ins = $user->mod($id, $iname, $ilastnamep, $ilastnamem, $iemail, $ipassword, $iactive, $db);
    
        if (!$ins['estado']):
            throw new Exception('Error al guardar los datos de usuario.', 0);
        endif;

        if ($_islog):
            $_SESSION['uc_userfname'] = $iname;
            $_SESSION['uc_userlnamep'] = $ilastnamep;
            $_SESSION['uc_userlnamem'] = $ilastnamem;
            $_SESSION['uc_useremail'] = $iemail;
        endif;

        $d_g = $user->delGroup($id, $db);

        if (!$d_g['estado']):
            throw new Exception('Error al eliminar grupo antiguos.', 0);
        endif;

        $grp = $user->setGroup($id, $iusergroups, $db);

        if (!$grp['estado']):
            throw new Exception('Error al crear grupo del usuario. ' . $grp['msg'], 0);
        endif;

        if (!empty($_FILES)):
            $targetFolder = BASEFOLDER . 'dist/img/users/';
            $targetPath = $_SERVER['DOCUMENT_ROOT'] . $targetFolder;

            $u = $user->get($id);
            $img_old = $_SERVER['DOCUMENT_ROOT'] . BASEFOLDER . 'dist/img/' . $u->us_pic;

            if (is_readable($img_old)):
                if (unlink($img_old)):
                    foreach ($_FILES as $aux => $file):
                        $tempFile = $file['tmp_name'][0];
                        $targetFile = rtrim($targetPath,'/') . '/' . $id . '_' . $file['name'][0];
                        move_uploaded_file($tempFile, $targetFile);
                    endforeach;

                    $pic_route = 'dist/img/users/' . $id . '_' . $file['name'][0];

                    $ins = $user->setPicture($id, $pic_route, $db);

                    if (!$ins):
                        throw new Exception('Error al guardar la imagen.', 0);
                    endif;

                    if ($ins and $_islog):
                        $_SESSION['uc_userpic'] = 'dist/img/users/' . $id . '_' . $file['name'][0];
                    endif;
                else:
                    throw new Exception('Error al eliminar la imagen antigua.', 0);
                endif;
            else:
                throw new Exception('El archivo solicitado no existe.', 0);
            endif;
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