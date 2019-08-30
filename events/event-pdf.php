<?php

session_start();

// Include the main TCPDF library (search for installation path).
require_once('../src/tcpdf_include.php');
include('../class/classMyDBC.php');
include('../class/classEvento.php');
include('../class/classServicio.php');
include('../class/classUser.php');
include('../class/classTipoEvento.php');
include('../class/classSubtipoEvento.php');
include('../src/fn.php');

if (extract($_GET)):
	$ev = new Evento();
	$ser = new Servicio();
	$us = new User();
	$tev = new TipoEvento();
	$stev = new SubtipoEvento();

	$e = $ev->get($id);

	// create new PDF document
	$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

	$pdf->SetCreator(PDF_CREATOR);
	$pdf->SetAuthor('UNidad de Calidad y Seguridad del Paciente');
	$pdf->SetTitle("REPORTE DE EVENTO N° " . $id);
	$pdf->SetKeywords('Documento HGGB');
	// ---------------------------------------------------------
	// set default font subsetting mode
	$pdf->setLanguageArray($l);
	$pdf->setFontSubsetting(true);
	$pdf->setPrintHeader(false);
	$pdf->setPrintFooter(false);
	$pdf->setRightMargin(0);

	// Set font
	// dejavusans is a UTF-8 Unicode font, if you only need to
	// print standard ASCII chars, you can use core fonts like
	// helvetica or times to reduce file size.
	$pdf->SetFont('helvetica', '', 8, '', true);

	// Add a page
	// This method has several options, check the source code documentation for more information.
	$pdf->AddPage();

	$pdf->setJPEGQuality(100);
	$pdf->SetXY(15, 1);
	$pdf->Image('../dist/img/logo.jpg', 16, 10, 22, 22, 'JPG', '', '', true, 150, '', false, false, 1, false, false, false);

	//CABECERA
	$html = "MINISTERIO DE SALUD";
	$pdf->SetY(10);
	$pdf->SetX(40);
	$pdf->writeHTMLCell('', 0, '', '', $html, 0, 1, 0, true, '', true);
	$html = "SERVICIO DE SALUD CONCEPCIÓN";
	$pdf->SetX(40);
	$pdf->writeHTMLCell('', 0, '', '', $html, 0, 1, 0, true, '', true);
	$html = "HOSPITAL GMO. GRANT BENAVENTE";
	$pdf->SetX(40);
	$pdf->writeHTMLCell('', 0, '', '', $html, 0, 1, 0, true, '', true);
	$html = "UNIDAD DE CALIDAD Y SEGURIDAD DEL PACIENTE";
	$pdf->SetX(40);
	$pdf->writeHTMLCell('', 0, '', '', $html, 0, 1, 0, true, '', true);

	$pdf->SetFont('helvetica', 'B', 14, '', true);
	$html = "EVENTO N° " . $id;
	$pdf->ln(15);
	$pdf->writeHTMLCell('', 0, '', '', $html, 0, 1, 0, true, 'C', true);

	$pdf->SetFont('helvetica', 'B', 10, '', true);
	$html = "RUT Paciente";
	$pdf->ln(5);
	$pdf->SetX(15);
	$pdf->writeHTMLCell('', 0, '', '', $html, 0, 1, 0, true, '', true);

	$pdf->SetFont('helvetica', '', 11, '', true);
	$pdf->SetX(25);
	$pdf->writeHTMLCell('', 0, '', '', $e->ev_rut, 0, 1, 0, true, '', true);

	$pdf->SetFont('helvetica', 'B', 10, '', true);
	$html = "Nombre Paciente";
	$pdf->SetY(50);
	$pdf->SetX(100);
	$pdf->writeHTMLCell('', 0, '', '', $html, 0, 1, 0, true, '', true);

	$pdf->SetFont('helvetica', '', 11, '', true);
	$pdf->SetX(110);
	$pdf->writeHTMLCell('', 0, '', '', $e->ev_nombre, 0, 1, 0, true, '', true);

	$pdf->SetFont('helvetica', 'B', 10, '', true);
	$html = "Lugar del Evento";
	$pdf->ln(1);
	$pdf->SetX(15);
	$pdf->writeHTMLCell('', 0, '', '', $html, 0, 1, 0, true, '', true);

	$pdf->SetFont('helvetica', '', 11, '', true);
	$pdf->SetX(25);
	$pdf->writeHTMLCell('', 0, '', '', $e->ser_desc, 0, 1, 0, true, '', true);

	$pdf->SetFont('helvetica', 'B', 10, '', true);
	$html = "Edad";
	$pdf->SetY(60);
	$pdf->SetX(100);
	$pdf->writeHTMLCell('', 0, '', '', $html, 0, 1, 0, true, '', true);

	$pdf->SetFont('helvetica', '', 11, '', true);
	$pdf->SetX(110);
	$pdf->writeHTMLCell('', 0, '', '', $e->ev_edad . ' años', 0, 1, 0, true, '', true);

	$pdf->SetFont('helvetica', 'B', 10, '', true);
	$html = "Fecha del Evento";
	$pdf->ln(1);
	$pdf->SetX(15);
	$pdf->writeHTMLCell('', 0, '', '', $html, 0, 1, 0, true, '', true);

	$pdf->SetFont('helvetica', '', 11, '', true);
	$pdf->SetX(25);
	$tmp = explode(' ', $e->ev_fecha);
	$hora = $tmp[1];
	$fecha = getDateToForm($tmp[0]);
	$pdf->writeHTMLCell('', 0, '', '', $fecha, 0, 1, 0, true, '', true);

	$pdf->SetFont('helvetica', 'B', 10, '', true);
	$html = "Hora del Evento";
	$pdf->SetY(70);
	$pdf->SetX(100);
	$pdf->writeHTMLCell('', 0, '', '', $html, 0, 1, 0, true, '', true);

	$pdf->SetFont('helvetica', '', 11, '', true);
	$pdf->SetX(110);
	$tmp = explode(' ', $e->ev_fecha);
	$hora = $tmp[1];
	$fecha = getDateToForm($tmp[0]);
	$pdf->writeHTMLCell('', 0, '', '', $hora, 0, 1, 0, true, '', true);

	$pdf->SetFont('helvetica', 'B', 10, '', true);
	$html = "Reportado por";
	$pdf->ln(1);
	$pdf->SetX(15);
	$pdf->writeHTMLCell('', 0, '', '', $html, 0, 1, 0, true, '', true);

	$user = $us->get($e->ev_usid);
	$pdf->SetFont('helvetica', '', 11, '', true);
	$pdf->SetX(25);
	$pdf->writeHTMLCell('', 0, '', '', $user->us_nombres . ' ' . $user->us_ap . ' ' . $user->us_am, 0, 1, 0, true, '', true);

	$pdf->SetFont('helvetica', 'B', 10, '', true);
	$html = "Categorización del Evento";
	$pdf->ln(5);
	$pdf->SetX(15);
	$pdf->writeHTMLCell('', 0, '', '', $html, 0, 1, 0, true, '', true);

	$pdf->SetFont('helvetica', '', 11, '', true);
	$pdf->SetX(25);
	$pdf->writeHTMLCell('', 0, '', '', $e->cat_desc, 0, 1, 0, true, '', true);

	$pdf->SetFont('helvetica', 'B', 10, '', true);
	$html = "Tipo de Evento";
	$pdf->SetX(15);
	$pdf->writeHTMLCell('', 0, '', '', $html, 0, 1, 0, true, '', true);

	$pdf->SetFont('helvetica', '', 11, '', true);
	$pdf->SetX(25);
	$pdf->writeHTMLCell('', 0, '', '', $e->tev_desc, 0, 1, 0, true, '', true);

	$pdf->SetFont('helvetica', 'B', 10, '', true);
	$html = "Subtipo de Evento";
	$pdf->SetX(15);
	$pdf->writeHTMLCell('', 0, '', '', $html, 0, 1, 0, true, '', true);

	$pdf->SetFont('helvetica', '', 11, '', true);
	$pdf->SetX(25);
	$pdf->writeHTMLCell('', 0, '', '', $e->stev_desc, 0, 1, 0, true, '', true);

	$pdf->SetFont('helvetica', 'B', 10, '', true);
	$html = "Contexto";
	$pdf->SetX(15);
	$pdf->writeHTMLCell('', 0, '', '', $html, 0, 1, 0, true, '', true);

	$pdf->SetFont('helvetica', '', 11, '', true);
	$pdf->SetX(25);
	$pdf->writeHTMLCell(180, 0, '', '', $e->ev_contexto, 0, 1, 0, true, '', true);

	$pdf->SetFont('helvetica', 'B', 10, '', true);
	$html = "Consecuencias sufridas";
	$pdf->SetX(15);
	$pdf->writeHTMLCell('', 0, '', '', $html, 0, 1, 0, true, '', true);

	$pdf->SetFont('helvetica', '', 11, '', true);
	$pdf->SetX(25);
	$pdf->writeHTMLCell('', 0, '', '', $e->cons_desc, 0, 1, 0, true, '', true);

	$pdf->SetFont('helvetica', 'B', 10, '', true);
	$html = "Verificación de Cumplimiento de Medidas Preventivas";
	$pdf->ln(5);
	$pdf->SetX(15);
	$pdf->writeHTMLCell('', 0, '', '', $html, 0, 1, 0, true, '', true);

	$pdf->SetFont('helvetica', '', 11, '', true);
	$pdf->SetX(25);
	$pdf->writeHTMLCell('', 0, '', '', $e->ev_ver, 0, 1, 0, true, '', true);

	$pdf->SetFont('helvetica', 'B', 10, '', true);
	$html = "Justificación escrita de no cumplimiento de Medidas Preventivas";
	$pdf->SetX(15);
	$pdf->writeHTMLCell('', 0, '', '', $html, 0, 1, 0, true, '', true);

	$pdf->SetFont('helvetica', '', 11, '', true);
	$pdf->SetX(25);
	$pdf->writeHTMLCell('', 0, '', '', $e->ev_je, 0, 1, 0, true, '', true);

	$pdf->SetFont('helvetica', 'B', 10, '', true);
	$html = "Análisis clínico de justificación por especialistas";
	$pdf->SetX(15);
	$pdf->writeHTMLCell('', 0, '', '', $html, 0, 1, 0, true, '', true);

	$pdf->SetFont('helvetica', '', 11, '', true);
	$pdf->SetX(25);
	$pdf->writeHTMLCell('', 0, '', '', $e->ev_acj, 0, 1, 0, true, '', true);

	$pdf->SetFont('helvetica', 'B', 10, '', true);
	$html = "Verificación de Medidas Preventivas en otros pacientes";
	$pdf->SetX(15);
	$pdf->writeHTMLCell('', 0, '', '', $html, 0, 1, 0, true, '', true);

	$pdf->SetFont('helvetica', '', 11, '', true);
	$pdf->SetX(25);
	$pdf->writeHTMLCell('', 0, '', '', $e->ev_rep, 0, 1, 0, true, '', true);

	// set default header data
	$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE . ' 001', PDF_HEADER_STRING, array(0, 64, 255), array(0, 64, 128));
	$pdf->setFooterData(array(0, 64, 0), array(0, 64, 128));

	// set header and footer fonts
	$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
	$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

	$pdf->setAutoPageBreak(false, 0);

	// Close and output PDF document
	// This method has several options, check the source code documentation for more information.
	$pdf->Output('Reporte-evento-' . $id . '.pdf', 'I');
endif;

function getTypeVer($t) {
	return ($t == 1) ? 'SI' : 'NO';
}