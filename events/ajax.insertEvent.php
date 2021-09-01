<?php
use PHPMailer\PHPMailer\PHPMailer;

session_start();
include("../class/classMyDBC.php");
include("../class/classEvento.php");
include("../class/classServicio.php");
include("../src/fn.php");
include("../src/sessionControl.ajax.php");

require("../vendor/autoload.php");

if (extract($_POST)):
	$db = new myDBC();
	$ev = new Evento();
	$se = new Servicio();
	$idate = setDateBD($idate) . ' ' . $ihour . ':' . $imin;

	$inocu = (!isset($inocu)) ? 2 : $inocu;
	$icljus = (!isset($icljus)) ? 2 : $icljus;
	$imedp = (!isset($imedp)) ? 2 : $imedp;
	$itpac = (!isset($itpac)) ? 4 : $itpac;
	$irut = (empty($irut)) ? 'N/A' : $irut;
	$iname = (empty($iname)) ? 'BROTE EPIDEMIOLOGICO' : $iname;
	$iedad = (empty($iedad)) ? 0 : $iedad;

	try {
		$db->autoCommit(FALSE);
		$ins = $ev->set($_SESSION['uc_userid'], $iserv, $irie, $istev, $itpac, $iconsec, $irut, $iname, $iedad, $idate, $iorigen, $idescription, $inocu, $icljus, $imedp, $ivermed, $db);

		if (!$ins['estado']):
			throw new Exception('Error al guardar los datos del evento. ' . $ins['msg'], 0);
		endif;

		$targetPath = '/home/hggb/repo_calidad';

		/*foreach ($_FILES as $aux => $file):

			if ($aux === 'idocument'):
				$tempFile = $file['tmp_name'][0];
				$fileName = 'ea' . $ins['msg'] . '_' . date('Ymd') . '_' . removeAccents(str_replace(' ', '_', $file['name'][0]));
				$targetFile = rtrim($targetPath, '/') . '/' . $fileName;

				if (!move_uploaded_file($tempFile, $targetFile)):
					throw new Exception("Error al subir el documento. " . print_r(error_get_last()), 0);
				endif;

				$doc_route = '/repo_calidad/' . $fileName;
				$ins_f = $ev->setPath($ins['msg'], $doc_route, $db);

				if (!$ins_f['estado']):
					throw new Exception('Error al guardar el documento. ' . $ins_f['msg'], 0);
				endif;
			endif;

			if ($aux === 'idoccaida'):
				$tempFile = $file['tmp_name'][0];
				$fileName = 'eac' . $ins['msg'] . '_' . date('Ymd') . '_' . removeAccents(str_replace(' ', '_', $file['name'][0]));
				$targetFile = rtrim($targetPath, '/') . '/' . $fileName;

				if (!move_uploaded_file($tempFile, $targetFile)):
					throw new Exception("Error al subir el documento. " . print_r(error_get_last()), 0);
				endif;

				$doc_route = '/repo_calidad/' . $fileName;
				$ins_f = $ev->setPathCaida($ins['msg'], $doc_route, $db);

				if (!$ins_f['estado']):
					throw new Exception('Error al guardar el documento. ' . $ins_f['msg'], 0);
				endif;
			endif;
		endforeach;*/

		$db->Commit();
		$db->autoCommit(TRUE);

		/*$serv = $se->get($iserv);
		$eve = $ev->get($ins['msg']);
		$msg = '<b>ATENCIÓN</b><br>';
		$msg .= 'Se ha generado un nuevo reporte de evento centinela con los siguientes datos:<br>';
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
		$mail->Username = "ti.hggb@gmail.com";
		$mail->Password = "svr1504_woot";

		$mail->SetFrom('soportedesarrollo@ssconcepcion.cl', 'Plataforma Calidad');

		$mail->Subject = "Mensaje desde Plataforma de Calidad";
		$mail->AltBody = "Para visualizar el mensaje, por favor utilice un visor de correos compatible con HTML!";

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

		if ((int)$istev < 13 or (int)$istev == 15):
			$mail->AddAddress("miguelaguayo@ssconcepcion.cl", "Miguel Aguayo");
			$mail->AddAddress("kcampos@ssconcepcion.cl", "Katherine Campos");
		endif;

		if (!$mail->send()):
			throw new Exception('Error al enviar correo de confirmación. ' . $mail->ErrorInfo, 0);
		endif;*/

		$response = array('type' => true, 'msg' => 'OK');
		echo json_encode($response);
	} catch (Exception $e) {
		$db->Rollback();
		$db->autoCommit(TRUE);
		$response = array('type' => false, 'msg' => $e->getMessage(), 'code' => $e->getCode());
		echo json_encode($response);
	}
endif;