<?php

use PHPMailer\PHPMailer\PHPMailer;

session_start();
include("../class/classMyDBC.php");
include("../class/classAlerta.php");
include("../src/fn.php");
include("../src/sessionControl.ajax.php");
require("../vendor/autoload.php");

if (extract($_POST)):
	$db = new myDBC();
	$al = new Alerta();
	$idateal = setDateBD($idateal);

	try {
		$db->autoCommit(FALSE);
		$ins = $al->set($_SESSION['uc_userid'], $idateal, $inmarca, $icriesgo, $intalerta, $inlote, $inserie, $ifnombre, $ifemail, $iftelefono, $iimnombre, $iimemail, $iimtelefono, $icorreccion, $db);

		if (!$ins['estado']):
			throw new Exception('Error al guardar los datos del evento. ' . $ins['msg'], 0);
		endif;

		$db->Commit();
		$db->autoCommit(TRUE);

		$msg = '<b>ATENCIÓN</b><br>';
		$msg .= 'Se ha generado un nuevo reporte de alerta de equipo médico con los siguientes datos:<br>';
		$msg .= '<br><b>Código:</b> ' . $ins['msg'];
		$msg .= '<br><b>Marca / modelo:</b> ' . $inmarca;
		$msg .= '<br><b>Riesgo:</b> ' . $icriesgo;
		$msg .= '<br><b>Fecha:</b> ' . $idateal;
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
		$mail->Subject = "Mensaje desde Plataforma de Calidad";
		$mail->AltBody = "Para visualizar el mensaje, por favor utilice un visor de correos compatible con HTML!";
		$mail->MsgHTML(utf8_decode($msg));

		// Testing only
		// $address = "i.munoz.j@gmail.com";
		// $mail->AddAddress("i.munoz.j@gmail.com", "Yo");
		$mail->AddAddress("imunoz@ssconcepcion.cl", "Soporte");

		/*$mail->AddAddress("cmunoz@ssconcepcion.cl", "Enf. Claudia Munoz");
		$mail->AddAddress("nduarte@ssconcepcion.cl", "Ing. Nestor Duarte");*/

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
