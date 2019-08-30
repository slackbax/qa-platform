<?php

session_start();
include ('../class/classMyDBC.php');
include ('../class/classSession.php');

$qr = new myDBC();
$ses = new Session();

extract($_POST);
$isActive = false;

try {
    $stmt = $qr->Prepare("SELECT COUNT(*) AS num FROM uc_usuario WHERE us_username = ?");
    
    if (!$stmt):
        throw new Exception("El usuario ingresado no es correcto. Fallo en la preparación de la consulta de usuario.");
    endif;

    $bind = $stmt->bind_param("s", $qr->clearText($user));
    
    if(!$bind):
        throw new Exception("El usuario ingresado no es correcto. Fallo en el binding de los parámetros de usuario.");
    endif;
    
    if(!$stmt->execute()):
        throw new Exception("El usuario ingresado no es correcto. Fallo en la ejecución de la consulta de usuario.");
    endif;
    
    $query = $stmt->get_result();
    $q_user = $query->fetch_assoc();
        
    if ($q_user['num'] == 0):
        throw new Exception("El usuario ingresado no existe.");
    endif;
        
    $stmt = $qr->Prepare("SELECT us_password FROM uc_usuario WHERE us_username = ?");
    
    if (!$stmt):
        throw new Exception("El usuario ingresado no es correcto. Fallo en la preparación de la consulta de contraseña.");
    endif;
        
    $bind = $stmt->bind_param("s", $qr->clearText($user));
    
    if(!$bind):
        throw new Exception("El usuario ingresado no es correcto. Fallo en el binding de los parámetros de contraseña.");
    endif;
    
    if(!$stmt->execute()):
        throw new Exception("El usuario ingresado no es correcto. Fallo en la ejecución de la consulta de contraseña.");
    endif;
    
    $query = $stmt->get_result();
    $q_pass = $query->fetch_assoc();

    if (md5($passwd) !== $q_pass['us_password']):
        throw new Exception("La contraseña ingresada no es correcta.");
    endif;

    $stmt = $qr->Prepare("SELECT us_activo FROM uc_usuario WHERE us_username = ?");
    
    if (!$stmt):
        throw new Exception("El usuario ingresado no es correcto. Fallo en la preparación de la consulta de activación.");
    endif;
            
    $bind = $stmt->bind_param("s", $qr->clearText($user));
    
    if(!$bind):
        throw new Exception("El usuario ingresado no es correcto. Fallo en el binding de los parámetros de activación.");
    endif;
    
    if(!$stmt->execute()):
        throw new Exception("El usuario ingresado no es correcto. Fallo en la ejecución de la consulta de activación.");
    endif;
    
    $query = $stmt->get_result();
    $q_active = $query->fetch_assoc();

    if ($q_active['us_activo'] !== 1):
        throw new Exception("El usuario ingresado se encuentra inactivo.");
    endif;

    $stmt = $qr->Prepare("SELECT * FROM uc_usuario WHERE us_username = ?");
    
    if (!$stmt):
        throw new Exception("El usuario ingresado no es correcto. Fallo en la preparación de la consulta de datos de usuario.");
    endif;
                
    $bind = $stmt->bind_param("s", $qr->clearText($user));
    
    if(!$bind):
        throw new Exception("El usuario ingresado no es correcto. Fallo en el binding de los parámetros de datos de usuario.");
    endif;

    if(!$stmt->execute()):
        throw new Exception("El usuario ingresado no es correcto. Fallo en la ejecución de la consulta de datos de usuario.");
    endif;
    
    $query = $stmt->get_result();
    $q_data = $query->fetch_assoc();

	$_SESSION['uc_logintime'] = time();
    $_SESSION['uc_userid'] = $q_data['us_id'];
    $_SESSION['uc_username'] = $user;
    $_SESSION['uc_userfname'] = utf8_encode($q_data['us_nombres']);
    $_SESSION['uc_userlnamep'] = utf8_encode($q_data['us_ap']);
    $_SESSION['uc_userlnamem'] = utf8_encode($q_data['us_am']);
    $_SESSION['uc_useremail'] = $q_data['us_email'];
    $_SESSION['uc_userpic'] = utf8_encode($q_data['us_pic']);

    $stmt = $qr->Prepare("SELECT g.gru_id, g.perf_id, g.gru_nombre
                    FROM uc_grupo_usuario gu
                    JOIN uc_grupo g ON gu.gru_id = g.gru_id
                    WHERE gu.us_id = ?");
    
    if (!$stmt):
        throw new Exception("El usuario ingresado no es correcto. Fallo en la preparación de la consulta de grupos.");
    endif;
                    
    $bind = $stmt->bind_param("i", $q_data['us_id']);
    
    if(!$bind):
        throw new Exception("El usuario ingresado no es correcto. Fallo en el binding de los parámetros de grupos.");
    endif;

    if(!$stmt->execute()):
        throw new Exception("El usuario ingresado no es correcto. Fallo en la ejecución de la consulta de grupos.");
    endif;
    
    $queryS = $stmt->get_result();
                        
    while ($q_session = $queryS->fetch_assoc()):
        $_SESSION['uc_usergroup'] = utf8_encode($q_session['gru_nombre']);
        $_SESSION['uc_rol'] = array('perf' => $q_session['perf_id'], 'group' => $q_session['gru_id']);

        if ($q_session['perf_id'] === 1):
            $_SESSION['uc_useradmin'] = true;
        endif;
    endwhile;

    $set_session = $ses->set($q_data['us_id'], $_SERVER['REMOTE_ADDR']);

    if ($set_session):
        echo "true";
        return;
    else:
        throw new Exception("Hubo un problema al guardar la sesión.");
    endif;

} catch (Exception $e) {
    echo $e->getMessage();
    return;
}