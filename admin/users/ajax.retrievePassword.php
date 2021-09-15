<?php

use PHPMailer\PHPMailer\PHPMailer;

include("../../class/classMyDBC.php");
include("../../class/classUser.php");
include("../../src/Random/random.php");

require("../../vendor/autoload.php");

if (extract($_POST)):
	$db = new myDBC();
	$us = new User();

	try {
		$db->autoCommit(FALSE);
		$usr = $us->getByUsername($iusername);

		if (is_null($usr->us_id)):
			throw new Exception('El usuario ingresado no existe.', 0);
		endif;

		$keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$length = 7;
		$str = '';
		$max = mb_strlen($keyspace, '8bit') - 1;

		for ($i = 0; $i < $length; ++$i):
			$str .= $keyspace[random_int(0, $max)];
		endfor;

		$pmod = $us->modPass($usr->us_id, $str, $db);

		if (!$pmod['estado']):
			throw new Exception('Error al modificar la contraseña. ' . $pmod['msg'], 0);
		endif;

		$db->Commit();
		$db->autoCommit(TRUE);

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

		$mail->Subject = "Sus nuevos datos de acceso";
		$mail->AltBody = "Para visualizar el mensaje, por favor utilice un visor de correos compatible con HTML!";

		$html = "Estimado usuario:<br><br>Usted ha solicitado un cambio de contraseña con fecha " . date('d-m-Y') . ". Su nueva contraseña es <strong>" . $str . "</strong>";
		$html .= "<br>Le recordamos que puede modificar esta contraseña en el menú de usuario de la plataforma, ubicado en la barra superior bajo su nombre.";
		$html .= "<br><br>Saludos cordiales,";
		$html .= "<br>Soporte Plataforma Calidad";
		$mail->MsgHTML(utf8_decode($html));

		// Testing only
		// $address = "i.munoz.j@gmail.com";
		// $mail->AddAddress("i.munoz.j@gmail.com", "Yo");
		// $mail->AddAddress("imunoz@ssconcepcion.cl", "Ignacio Muñoz");

		$mail->AddAddress($usr->us_email, utf8_decode($usr->us_nombres . ' ' . $usr->us_ap));

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