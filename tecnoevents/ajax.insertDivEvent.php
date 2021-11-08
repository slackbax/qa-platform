<?php
use PHPMailer\PHPMailer\PHPMailer;

session_start();
include("../class/classMyDBC.php");
include("../class/classTecnoDivEvento.php");
include("../src/fn.php");
include("../src/sessionControl.ajax.php");
require("../vendor/autoload.php");

if (extract($_POST)):
    $db = new myDBC();
    $ev = new TecnoDivEvento();
    $idate = setDateBD($idate);
    $idateev = setDateBD($idateev);
    $idatefab = setDateBD($idatefab);
    $idatevenc = setDateBD($idatevenc);

    try {
        $db->autoCommit(FALSE);
        $ins = $ev->set($_SESSION['uc_userid'], $iserv, $idate, $idateev, $ingenerico, $incomercial, $icatalogo, $iuso, $iotrouso, $icadena, $itemp, $inlote, $iseguridad, $ifnombre, $ifpais, $iimnombre, $iimpais, $iformauso, $idatefab, $idatevenc, $iverificacion, $icontrol, $iadscrito, $iautorizacion, $iotraaut, $iensayo, $itecnica, $ianalizador, $idescription, $iinvestig, $ireporte, $db);

        if (!$ins['estado']):
            throw new Exception('Error al guardar los datos del evento. ' . $ins['msg'], 0);
        endif;

        $db->Commit();
        $db->autoCommit(TRUE);

        $serv = $se->get($iserv);
        $eve = $ev->get($ins['msg']);
        $msg = '<b>ATENCIÓN</b><br>';
        $msg .= 'Se ha generado un nuevo reporte de evento de tecnovigilancia con los siguientes datos:<br>';
        $msg .= '<br><b>Código:</b> ' . $ins['msg'];
        $msg .= '<br><b>RUT:</b> ' . $irut;
        $msg .= '<br><b>Nombre:</b> ' . $iname;
        $msg .= '<br><b>Servicio:</b> ' . $serv->ser_nombre;
        $msg .= '<br><b>Fecha:</b> ' . $idate;
        $msg .= '<br><b>Evento:</b> ' . $eve->stev_desc;
        $msg .= '<br><br><br>Saludos cordiales,<br><br>Plataforma de Calidad y Seguridad del Paciente';

        $mail = new PHPMailer;

        $mail->IsSMTP();
        $mail->SMTPDebug = 0;
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = "tls";
        $mail->Host = "smtp.gmail.com";
        $mail->Port = 587;
        $mail->Username = MAIL;
        $mail->Password = MAIL_PASSWORD;

        $mail->SetFrom('soportedesarrollo@ssconcepcion.cl', 'Plataforma Calidad');

        $mail->Subject = "Mensaje desde plataforma calidad";
        $mail->AltBody = "Para visualizar el mensaje, por favor utilice un visor de correos compatible con HTML!"; // optional, comment out and test

        if ((int)$istev < 13 or (int)$istev == 15):
            $mail->MsgHTML(utf8_decode($msg));
        else:
            $mail->MsgHTML(utf8_decode("Se ha generado un nuevo ingreso de reporte de evento adverso/centinela con el código <b>" . $ins['msg'] . "</b> y paciente <b>" . $iname . "</b>. <br><br>Saludos cordiales,<br><br>Plataforma de Calidad y Seguridad del Paciente"));
        endif;

        // Testing only
        // $address = "i.munoz.j@gmail.com";
        // $mail->AddAddress("i.munoz.j@gmail.com", "Yo");
        // $mail->AddAddress("soportedesarrollo@ssconcepcion.cl", "Soporte");

        $mail->AddAddress("cmunoz@ssconcepcion.cl", "Claudia Munoz");
        $mail->AddAddress("lgatica@ssconcepcion.cl", "Luis Gatica");

        if ((int)$istev < 13 or (int)$istev == 15):
            $mail->AddAddress("boportus@ssconcepcion.cl", "Boris Oportus");
            $mail->AddAddress("kcampos@ssconcepcion.cl", "Katherine Campos");
        endif;

        if (!$mail->send()):
            throw new Exception('Error al enviar correo de confirmación. ' . $mail->ErrorInfo, 0);
        endif;

        $response = array('type' => true, 'msg' => 'OK');
        echo json_encode($response);
    } catch (Exception $e) {
        $db->Rollback();
        $db->autoCommit(TRUE);
        $response = array('type' => false, 'msg' => $e->getMessage(), 'code' => $e->getCode());
        echo json_encode($response);
    }
endif;