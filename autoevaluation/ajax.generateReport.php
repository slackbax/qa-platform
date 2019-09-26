<?php

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

/** Include \PhpOffice\PhpSpreadsheet\Spreadsheet */
require '../vendor/autoload.php';

/** Include Classes */
include("../class/classMyDBC.php");
include("../class/classSubPuntoVerificacion.php");
include("../class/classAutoevaluation.php");
include("../src/fn.php");

if (extract($_POST)):
	$au = new Autoevaluation();
	$spv = new SubPuntoVerificacion();
	$subpv = $spv->get($iser);

	$tmp = explode('/', $idate);
	$month = $tmp[0];
	$month_num = ($month[0] == '0') ? substr($month, 1) : $month;
	$month_words = getMonth($month_num);
	$year = $tmp[1];
	$totalo_apl = 0;
	$totalo_si = 0;
	$totalno_apl = 0;
	$totalno_si = 0;

	// Create new \PhpOffice\PhpSpreadsheet\Spreadsheet object
	$objSS = new Spreadsheet();

	// Set document properties
	$objSS->getProperties()->setCreator("Ignacio Muñoz J.")
		->setLastModifiedBy("Subdireccion de Calidad")
		->setTitle("Reporte de Autoevaluacion");

	$objSS->getDefaultStyle()->getFont()->setName('Calibri');
	$objSS->getDefaultStyle()->getFont()->setSize(11);
	$objSS->getActiveSheet()->getDefaultColumnDimension()->setWidth(14.00);
	$objSS->getActiveSheet()->getSheetView()->setZoomScale(90);

	$saHeaderTop = array(
		'font' => array(
			'bold' => true,
			'size' => 7
		),
		'alignment' => array(
			'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
			'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
		)
	);

	$saHeader = array(
		'font' => array(
			'bold' => true,
			'size' => 12
		),
		'alignment' => array(
			'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
			'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
		)
	);

	$saHeaderType = array(
		'font' => array(
			'bold' => true,
			'size' => 12
		),
		'alignment' => array(
			'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
			'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
		)
	);

	// Celda cabecera de tabla
	$saCellHeader = array(
		'font' => array(
			'bold' => true,
			'size' => 8
		),
		'alignment' => array(
			'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
			'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
		),
		'borders' => array(
			'top' => array(
				'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
				'color' => ['rgb' => '000000']
			),
			'bottom' => array(
				'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
				'color' => ['rgb' => '000000']
			),
			'right' => array(
				'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
				'color' => ['rgb' => '000000']
			)
		)
	);

	// Celda normal
	$saCell = array(
		'font' => array(
			'size' => 8
		),
		'alignment' => array(
			'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
			'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
		),
		'borders' => array(
			'bottom' => array(
				'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
				'color' => ['rgb' => '000000']
			),
			'right' => array(
				'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
				'color' => ['rgb' => '000000']
			)
		)
	);

	// Celda centrada
	$saCellCenter = array(
		'font' => array(
			'size' => 8
		),
		'alignment' => array(
			'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
			'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
		),
		'borders' => array(
			'bottom' => array(
				'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
				'color' => ['rgb' => '000000']
			),
			'right' => array(
				'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
				'color' => ['rgb' => '000000']
			)
		)
	);

	$objSS->getActiveSheet()->getColumnDimension('A')->setWidth(10);
	$objSS->getActiveSheet()->getColumnDimension('B')->setWidth(38);
	$objSS->getActiveSheet()->getColumnDimension('C')->setWidth(10);
	$objSS->getActiveSheet()->getColumnDimension('D')->setWidth(8);
	$objSS->getActiveSheet()->getColumnDimension('E')->setWidth(8);
	$objSS->getActiveSheet()->getColumnDimension('F')->setWidth(8);
	$objSS->getActiveSheet()->getColumnDimension('G')->setWidth(8);
	$objSS->getActiveSheet()->getColumnDimension('H')->setWidth(8);
	$objSS->getActiveSheet()->getColumnDimension('I')->setWidth(10);
	$objSS->getActiveSheet()->getColumnDimension('J')->setWidth(10);
	$objSS->getActiveSheet()->getColumnDimension('K')->setWidth(48);

	/**
	 * CABECERAS
	 */
	$objSS->getActiveSheet()->setCellValue('A2', 'SERVICIO DE SALUD CONCEPCIÓN');
	$objSS->getActiveSheet()->mergeCells('A2:K2');
	$objSS->getActiveSheet()->setCellValue('A3', 'HOSPITAL GUILLERMO GRANT BENAVENTE');
	$objSS->getActiveSheet()->mergeCells('A3:K3');
	$objSS->getActiveSheet()->setCellValue('A4', 'SUBDIRECCIÓN DE CALIDAD Y SEGURIDAD DEL PACIENTE');
	$objSS->getActiveSheet()->mergeCells('A4:K4');
	$objSS->getActiveSheet()->getStyle('A2:A4')->applyFromArray($saHeaderTop);

	/**
	 * TITULO
	 */
	$objSS->getActiveSheet()->setCellValue('A6', 'AUTOEVALUACIÓN ' . strtoupper($month_words) . ' ' . $year . ' SERVICIO ' . strtoupper($subpv->spv_nombre));
	$objSS->getActiveSheet()->mergeCells('A6:K6');
	$objSS->getActiveSheet()->getStyle('A6:K6')->applyFromArray($saHeader);

	/**
	 * CARACTERISTICAS OBLIGATORIAS
	 */
	$objSS->getActiveSheet()->setCellValue('A8', 'I. CUMPLIMIENTO DE CARACTERÍSTICAS OBLIGATORIAS');
	$objSS->getActiveSheet()->mergeCells('A8:K8');
	$objSS->getActiveSheet()->getStyle('A8:K8')->applyFromArray($saHeaderType);

	/**
	 * TABLA DE DATOS
	 */
	$objSS->getActiveSheet()->setCellValue('A10', 'COD');
	$objSS->getActiveSheet()->getStyle('A10')->applyFromArray($saCellHeader);
	$objSS->getActiveSheet()->setCellValue('B10', 'DESCRIPCIÓN');
	$objSS->getActiveSheet()->getStyle('B10')->applyFromArray($saCellHeader);
	$objSS->getActiveSheet()->setCellValue('C10', 'UMBRAL (%)');
	$objSS->getActiveSheet()->getStyle('C10')->applyFromArray($saCellHeader);
	$objSS->getActiveSheet()->setCellValue('D10', '1em EM');
	$objSS->getActiveSheet()->getStyle('D10')->applyFromArray($saCellHeader);
	$objSS->getActiveSheet()->setCellValue('E10', '2do EM');
	$objSS->getActiveSheet()->getStyle('E10')->applyFromArray($saCellHeader);
	$objSS->getActiveSheet()->setCellValue('F10', '3er EM');
	$objSS->getActiveSheet()->getStyle('F10')->applyFromArray($saCellHeader);
	$objSS->getActiveSheet()->setCellValue('G10', '4to EM');
	$objSS->getActiveSheet()->getStyle('G10')->applyFromArray($saCellHeader);
	$objSS->getActiveSheet()->setCellValue('H10', '5to EM');
	$objSS->getActiveSheet()->getStyle('H10')->applyFromArray($saCellHeader);
	$objSS->getActiveSheet()->setCellValue('I10', '% CUMP');
	$objSS->getActiveSheet()->getStyle('I10')->applyFromArray($saCellHeader);
	$objSS->getActiveSheet()->setCellValue('J10', 'CUMPLE');
	$objSS->getActiveSheet()->getStyle('J10')->applyFromArray($saCellHeader);
	$objSS->getActiveSheet()->setCellValue('K10', 'OBSERVACIONES');
	$objSS->getActiveSheet()->getStyle('K10')->applyFromArray($saCellHeader);
	$objSS->getActiveSheet()->getStyle('K10')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);

	$i = 11;

	$aut_data = $au->getByFilters($year, $month, $iser, 1);
	$arr = [];

	//print_r($aut_data);

	foreach ($aut_data as $k => $v):
		$index = $v->samb_sigla . '-' . $v->cod_descripcion;
		$arr[$index]['descripcion'] = $v->ind_descripcion;
		$umbral = ($v->ind_umbral == '') ? 0 : $v->ind_umbral;
		$arr[$index]['umbral'] = $umbral;

		if (!isset($arr[$index]['comment']))
			$arr[$index]['comment'] = '';
		if (!isset($arr[$index]['si']))
			$arr[$index]['si'] = 0;
		if (!isset($arr[$index]['total']))
			$arr[$index]['total'] = 0;

		$coment = '';

		if ($v->aut_cumplimiento == 0):
			$cumpl = '0';
			$arr[$index]['total']++;
			$totalo_apl++;
		elseif ($v->aut_cumplimiento == 1):
			$cumpl = '1';
			$arr[$index]['si']++;
			$arr[$index]['total']++;
			$totalo_si++;
			$totalo_apl++;
		else:
			$cumpl = 'N/A';
		endif;

		if ($v->elm_numero == '1EM'):
			$arr[$index]['1EM'] = $cumpl;
			if ($arr[$index]['comment'] != '')
				$arr[$index]['comment'] .= "\n";
			$arr[$index]['comment'] .= ($v->aut_comentario !== '') ? '1EM: ' . str_replace('\n', "\n", $v->aut_comentario) : '';
		elseif ($v->elm_numero == '2EM'):
			$arr[$index]['2EM'] = $cumpl;
			if ($arr[$index]['comment'] != '')
				$arr[$index]['comment'] .= "\n";
			$arr[$index]['comment'] .= ($v->aut_comentario !== '') ? '2EM: ' . str_replace('\n', "\n", $v->aut_comentario) : '';
		elseif ($v->elm_numero == '3EM'):
			$arr[$index]['3EM'] = $cumpl;
			if ($arr[$index]['comment'] != '')
				$arr[$index]['comment'] .= "\n";
			$arr[$index]['comment'] .= ($v->aut_comentario !== '') ? '3EM: ' . str_replace('\n', "\n", $v->aut_comentario) : '';
		elseif ($v->elm_numero == '4EM'):
			$arr[$index]['4EM'] = $cumpl;
			if ($arr[$index]['comment'] != '')
				$arr[$index]['comment'] .= "\n";
			$arr[$index]['comment'] .= ($v->aut_comentario !== '') ? '4EM: ' . str_replace('\n', "\n", $v->aut_comentario) : '';
		elseif ($v->elm_numero == '5EM'):
			$arr[$index]['5EM'] = $cumpl;
			if ($arr[$index]['comment'] != '')
				$arr[$index]['comment'] .= "\n";
			$arr[$index]['comment'] .= ($v->aut_comentario !== '') ? '5EM: ' . str_replace('\n', "\n", $v->aut_comentario) : '';
		endif;
	endforeach;

	foreach ($arr as $k => $v):
		if (!isset($v['1EM']))
			$arr[$k]['1EM'] = 'N/A';
		if (!isset($v['2EM']))
			$arr[$k]['2EM'] = 'N/A';
		if (!isset($v['3EM']))
			$arr[$k]['3EM'] = 'N/A';
		if (!isset($v['4EM']))
			$arr[$k]['4EM'] = 'N/A';
		if (!isset($v['5EM']))
			$arr[$k]['5EM'] = 'N/A';
	endforeach;

	//print_r($arr);

	/**
	 * DATA
	 */
	foreach ($arr as $k => $v):
		$code = str_replace('-', ' ', $k);
		$objSS->getActiveSheet()->setCellValue('A' . $i, $code);
		$objSS->getActiveSheet()->getStyle('A' . $i)->applyFromArray($saCellCenter);

		$objSS->getActiveSheet()->setCellValue('B' . $i, $v['descripcion']);
		$objSS->getActiveSheet()->getStyle('B' . $i)->applyFromArray($saCell);
		$objSS->getActiveSheet()->getStyle('B' . $i)->getAlignment()->setWrapText(true);

		$objSS->getActiveSheet()->setCellValue('C' . $i, $v['umbral']);
		$objSS->getActiveSheet()->getStyle('C' . $i)->applyFromArray($saCellCenter);

		$objSS->getActiveSheet()->setCellValue('D' . $i, $v['1EM']);
		$objSS->getActiveSheet()->getStyle('D' . $i)->applyFromArray($saCellCenter);

		$objSS->getActiveSheet()->setCellValue('E' . $i, $v['2EM']);
		$objSS->getActiveSheet()->getStyle('E' . $i)->applyFromArray($saCellCenter);

		$objSS->getActiveSheet()->setCellValue('F' . $i, $v['3EM']);
		$objSS->getActiveSheet()->getStyle('F' . $i)->applyFromArray($saCellCenter);

		$objSS->getActiveSheet()->setCellValue('G' . $i, $v['4EM']);
		$objSS->getActiveSheet()->getStyle('G' . $i)->applyFromArray($saCellCenter);

		$objSS->getActiveSheet()->setCellValue('H' . $i, $v['5EM']);
		$objSS->getActiveSheet()->getStyle('H' . $i)->applyFromArray($saCellCenter);

		$per_total = ($v['total'] > 0) ? ($v['si'] / $v['total']) * 100 : 0;
		$objSS->getActiveSheet()->setCellValue('I' . $i, round($per_total, 0));
		$objSS->getActiveSheet()->getStyle('I' . $i)->applyFromArray($saCellCenter);

		$umbral = str_replace('%', '', $v['umbral']);
		$cumple = ($umbral <= $per_total) ? 'SI' : 'NO';
		if ($umbral > $per_total):
			$objSS->getActiveSheet()->getStyle('I' . $i . ':J' . $i)->getFont()->getColor()->setRGB('FF0000');
			$objSS->getActiveSheet()->getStyle('I' . $i . ':J' . $i)->getFont()->setBold(true);
		endif;
		$objSS->getActiveSheet()->setCellValue('J' . $i, $cumple);
		$objSS->getActiveSheet()->getStyle('J' . $i)->applyFromArray($saCellCenter);

		$objSS->getActiveSheet()->setCellValue('K' . $i, $v['comment']);
		$objSS->getActiveSheet()->getStyle('K' . $i)->applyFromArray($saCell);
		$objSS->getActiveSheet()->getStyle('K' . $i)->getAlignment()->setWrapText(true);
		$objSS->getActiveSheet()->getStyle('K' . $i)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);

		$i++;
	endforeach;

	if (count($arr) == 0):
		$objSS->getActiveSheet()->getStyle('A' . $i . ':K' . $i)->getFont()->setBold(true);
		$objSS->getActiveSheet()->mergeCells('A' . $i . ':K' . $i);
		$objSS->getActiveSheet()->setCellValue('A' . $i, 'No existen valores ingresados para estas características');
		$objSS->getActiveSheet()->getStyle('K' . $i)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
		$i++;
	endif;

	$objSS->getActiveSheet()->getStyle('A' . $i . ':K' . $i)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);

	$i += 2;

	/**
	 * CARACTERISTICAS NO OBLIGATORIAS
	 */
	$objSS->getActiveSheet()->setCellValue('A' . $i, 'II. CUMPLIMIENTO DE CARACTERÍSTICAS NO OBLIGATORIAS');
	$objSS->getActiveSheet()->mergeCells('A' . $i . ':K' . $i);
	$objSS->getActiveSheet()->getStyle('A' . $i . ':K' . $i)->applyFromArray($saHeaderType);

	$i += 2;

	/**
	 * TABLA DE DATOS
	 */
	$objSS->getActiveSheet()->setCellValue('A' . $i, 'COD');
	$objSS->getActiveSheet()->getStyle('A' . $i)->applyFromArray($saCellHeader);
	$objSS->getActiveSheet()->setCellValue('B' . $i, 'DESCRIPCIÓN');
	$objSS->getActiveSheet()->getStyle('B' . $i)->applyFromArray($saCellHeader);
	$objSS->getActiveSheet()->setCellValue('C' . $i, 'UMBRAL (%)');
	$objSS->getActiveSheet()->getStyle('C' . $i)->applyFromArray($saCellHeader);
	$objSS->getActiveSheet()->setCellValue('D' . $i, '1em EM');
	$objSS->getActiveSheet()->getStyle('D' . $i)->applyFromArray($saCellHeader);
	$objSS->getActiveSheet()->setCellValue('E' . $i, '2do EM');
	$objSS->getActiveSheet()->getStyle('E' . $i)->applyFromArray($saCellHeader);
	$objSS->getActiveSheet()->setCellValue('F' . $i, '3er EM');
	$objSS->getActiveSheet()->getStyle('F' . $i)->applyFromArray($saCellHeader);
	$objSS->getActiveSheet()->setCellValue('G' . $i, '4to EM');
	$objSS->getActiveSheet()->getStyle('G' . $i)->applyFromArray($saCellHeader);
	$objSS->getActiveSheet()->setCellValue('H' . $i, '5to EM');
	$objSS->getActiveSheet()->getStyle('H' . $i)->applyFromArray($saCellHeader);
	$objSS->getActiveSheet()->setCellValue('I' . $i, '% CUMP');
	$objSS->getActiveSheet()->getStyle('I' . $i)->applyFromArray($saCellHeader);
	$objSS->getActiveSheet()->setCellValue('J' . $i, 'CUMPLE');
	$objSS->getActiveSheet()->getStyle('J' . $i)->applyFromArray($saCellHeader);
	$objSS->getActiveSheet()->setCellValue('K' . $i, 'OBSERVACIONES');
	$objSS->getActiveSheet()->getStyle('K' . $i)->applyFromArray($saCellHeader);
	$objSS->getActiveSheet()->getStyle('K' . $i)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);

	$i++;
	$aut_data = $au->getByFilters($year, $month, $iser, 2);
	$arr = [];

	//print_r($aut_data);

	foreach ($aut_data as $k => $v):
		$index = $v->samb_sigla . '-' . $v->cod_descripcion;
		$arr[$index]['descripcion'] = $v->ind_descripcion;
		$umbral = ($v->ind_umbral == '') ? 0 : $v->ind_umbral;
		$arr[$index]['umbral'] = $umbral;

		if (!isset($arr[$index]['comment']))
			$arr[$index]['comment'] = '';
		if (!isset($arr[$index]['si']))
			$arr[$index]['si'] = 0;
		if (!isset($arr[$index]['total']))
			$arr[$index]['total'] = 0;

		$coment = '';

		if ($v->aut_cumplimiento == 0):
			$cumpl = '0';
			$arr[$index]['total']++;
			$totalno_apl++;
		elseif ($v->aut_cumplimiento == 1):
			$cumpl = '1';
			$arr[$index]['si']++;
			$arr[$index]['total']++;
			$totalno_si++;
			$totalno_apl++;
		else:
			$cumpl = 'N/A';
		endif;

		if ($v->elm_numero == '1EM'):
			$arr[$index]['1EM'] = $cumpl;
			if ($arr[$index]['comment'] != '')
				$arr[$index]['comment'] .= "\n";
			$arr[$index]['comment'] .= ($v->aut_comentario !== '') ? '1EM: ' . str_replace('\n', "\n", $v->aut_comentario) : '';
		elseif ($v->elm_numero == '2EM'):
			$arr[$index]['2EM'] = $cumpl;
			if ($arr[$index]['comment'] != '')
				$arr[$index]['comment'] .= "\n";
			$arr[$index]['comment'] .= ($v->aut_comentario !== '') ? '2EM: ' . str_replace('\n', "\n", $v->aut_comentario) : '';
		elseif ($v->elm_numero == '3EM'):
			$arr[$index]['3EM'] = $cumpl;
			if ($arr[$index]['comment'] != '')
				$arr[$index]['comment'] .= "\n";
			$arr[$index]['comment'] .= ($v->aut_comentario !== '') ? '3EM: ' . str_replace('\n', "\n", $v->aut_comentario) : '';
		elseif ($v->elm_numero == '4EM'):
			$arr[$index]['4EM'] = $cumpl;
			if ($arr[$index]['comment'] != '')
				$arr[$index]['comment'] .= "\n";
			$arr[$index]['comment'] .= ($v->aut_comentario !== '') ? '4EM: ' . str_replace('\n', "\n", $v->aut_comentario) : '';
		elseif ($v->elm_numero == '5EM'):
			$arr[$index]['5EM'] = $cumpl;
			if ($arr[$index]['comment'] != '')
				$arr[$index]['comment'] .= "\n";
			$arr[$index]['comment'] .= ($v->aut_comentario !== '') ? '5EM: ' . str_replace('\n', "\n", $v->aut_comentario) : '';
		endif;
	endforeach;

	foreach ($arr as $k => $v):
		if (!isset($v['1EM']))
			$arr[$k]['1EM'] = 'N/A';
		if (!isset($v['2EM']))
			$arr[$k]['2EM'] = 'N/A';
		if (!isset($v['3EM']))
			$arr[$k]['3EM'] = 'N/A';
		if (!isset($v['4EM']))
			$arr[$k]['4EM'] = 'N/A';
		if (!isset($v['5EM']))
			$arr[$k]['5EM'] = 'N/A';
	endforeach;

	/**
	 * DATA
	 */
	foreach ($arr as $k => $v):
		$code = str_replace('-', ' ', $k);
		$objSS->getActiveSheet()->setCellValue('A' . $i, $code);
		$objSS->getActiveSheet()->getStyle('A' . $i)->applyFromArray($saCellCenter);

		$objSS->getActiveSheet()->setCellValue('B' . $i, $v['descripcion']);
		$objSS->getActiveSheet()->getStyle('B' . $i)->applyFromArray($saCell);
		$objSS->getActiveSheet()->getStyle('B' . $i)->getAlignment()->setWrapText(true);

		$objSS->getActiveSheet()->setCellValue('C' . $i, $v['umbral']);
		$objSS->getActiveSheet()->getStyle('C' . $i)->applyFromArray($saCellCenter);

		$objSS->getActiveSheet()->setCellValue('D' . $i, $v['1EM']);
		$objSS->getActiveSheet()->getStyle('D' . $i)->applyFromArray($saCellCenter);

		$objSS->getActiveSheet()->setCellValue('E' . $i, $v['2EM']);
		$objSS->getActiveSheet()->getStyle('E' . $i)->applyFromArray($saCellCenter);

		$objSS->getActiveSheet()->setCellValue('F' . $i, $v['3EM']);
		$objSS->getActiveSheet()->getStyle('F' . $i)->applyFromArray($saCellCenter);

		$objSS->getActiveSheet()->setCellValue('G' . $i, $v['4EM']);
		$objSS->getActiveSheet()->getStyle('G' . $i)->applyFromArray($saCellCenter);

		$objSS->getActiveSheet()->setCellValue('H' . $i, $v['5EM']);
		$objSS->getActiveSheet()->getStyle('H' . $i)->applyFromArray($saCellCenter);

		$per_total = ($v['total'] > 0) ? ($v['si'] / $v['total']) * 100 : 0;
		$objSS->getActiveSheet()->setCellValue('I' . $i, round($per_total, 0));
		$objSS->getActiveSheet()->getStyle('I' . $i)->applyFromArray($saCellCenter);

		$umbral = str_replace('%', '', $v['umbral']);
		$cumple = ($umbral <= $per_total) ? 'SI' : 'NO';
		if ($umbral > $per_total):
			$objSS->getActiveSheet()->getStyle('I' . $i . ':J' . $i)->getFont()->getColor()->setRGB('FF0000');
			$objSS->getActiveSheet()->getStyle('I' . $i . ':J' . $i)->getFont()->setBold(true);
		endif;
		$objSS->getActiveSheet()->setCellValue('J' . $i, $cumple);
		$objSS->getActiveSheet()->getStyle('J' . $i)->applyFromArray($saCellCenter);

		$objSS->getActiveSheet()->setCellValue('K' . $i, $v['comment']);
		$objSS->getActiveSheet()->getStyle('K' . $i)->applyFromArray($saCell);
		$objSS->getActiveSheet()->getStyle('K' . $i)->getAlignment()->setWrapText(true);
		$objSS->getActiveSheet()->getStyle('K' . $i)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);

		$i++;
	endforeach;

	if (count($arr) == 0):
		$objSS->getActiveSheet()->getStyle('A' . $i . ':K' . $i)->getFont()->setBold(true);
		$objSS->getActiveSheet()->mergeCells('A' . $i . ':K' . $i);
		$objSS->getActiveSheet()->setCellValue('A' . $i, 'No existen valores ingresados para estas características');
		$objSS->getActiveSheet()->getStyle('K' . $i)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
		$i++;
	endif;

	$objSS->getActiveSheet()->getStyle('A' . $i . ':K' . $i)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);

	$i += 2;

	/**
	 * RESUMENES
	 */
	$objSS->getActiveSheet()->setCellValue('A' . $i, 'III. RESUMEN RESULTADO FINAL DE AUTOEVALUACIÓN');
	$objSS->getActiveSheet()->mergeCells('A' . $i . ':K' . $i);
	$objSS->getActiveSheet()->getStyle('A' . $i . ':K' . $i)->applyFromArray($saHeaderType);

	$i += 2;

	/**
	 * TABLAS RESUMENES
	 */
	$objSS->getActiveSheet()->setCellValue('B' . $i, 'CARACTERÍSTICAS OBLIGATORIAS');
	$objSS->getActiveSheet()->getStyle('B' . $i)->applyFromArray($saCellHeader);
	$objSS->getActiveSheet()->getStyle('B' . $i)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);

	$objSS->getActiveSheet()->setCellValue('C' . $i, '');
	$objSS->getActiveSheet()->getStyle('C' . $i)->applyFromArray($saCellHeader);
	$objSS->getActiveSheet()->getStyle('C' . $i)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
	$i++;

	$objSS->getActiveSheet()->setCellValue('B' . $i, 'N° Características Obligatorias Aplican');
	$objSS->getActiveSheet()->getStyle('B' . $i)->applyFromArray($saCell);
	$objSS->getActiveSheet()->getStyle('B' . $i)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);

	$objSS->getActiveSheet()->setCellValue('C' . $i, $totalo_apl);
	$objSS->getActiveSheet()->getStyle('C' . $i)->applyFromArray($saCellCenter);
	$objSS->getActiveSheet()->getStyle('C' . $i)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
	$i++;

	$objSS->getActiveSheet()->setCellValue('B' . $i, 'N° Características Obligatorias Cumplen');
	$objSS->getActiveSheet()->getStyle('B' . $i)->applyFromArray($saCell);
	$objSS->getActiveSheet()->getStyle('B' . $i)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);

	$objSS->getActiveSheet()->setCellValue('C' . $i, $totalo_si);
	$objSS->getActiveSheet()->getStyle('C' . $i)->applyFromArray($saCellCenter);
	$objSS->getActiveSheet()->getStyle('C' . $i)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
	$i++;

	$objSS->getActiveSheet()->setCellValue('B' . $i, '% Características Obligatorias');
	$objSS->getActiveSheet()->getStyle('B' . $i)->applyFromArray($saCellCenter);
	$objSS->getActiveSheet()->getStyle('B' . $i)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
	$objSS->getActiveSheet()->getStyle('B' . $i)->getFont()->setBold(true);

	$por_total = ($totalo_apl > 0) ? $totalo_si / $totalo_apl * 100 : 0;
	$objSS->getActiveSheet()->setCellValue('C' . $i, number_format($por_total, 0, '.', ',') . '%');
	$objSS->getActiveSheet()->getStyle('C' . $i)->applyFromArray($saCellCenter);
	$objSS->getActiveSheet()->getStyle('C' . $i)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
	$objSS->getActiveSheet()->getStyle('C' . $i)->getFont()->setBold(true);
	$i++;

	$objSS->getActiveSheet()->getStyle('B' . $i . ':C' . $i)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
	$i++;

	$objSS->getActiveSheet()->setCellValue('B' . $i, 'CARACTERÍSTICAS NO OBLIGATORIAS');
	$objSS->getActiveSheet()->getStyle('B' . $i)->applyFromArray($saCellHeader);
	$objSS->getActiveSheet()->getStyle('B' . $i)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);

	$objSS->getActiveSheet()->setCellValue('C' . $i, '');
	$objSS->getActiveSheet()->getStyle('C' . $i)->applyFromArray($saCellHeader);
	$objSS->getActiveSheet()->getStyle('C' . $i)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
	$i++;

	$objSS->getActiveSheet()->setCellValue('B' . $i, 'N° Características No Obligatorias Aplican');
	$objSS->getActiveSheet()->getStyle('B' . $i)->applyFromArray($saCell);
	$objSS->getActiveSheet()->getStyle('B' . $i)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);

	$objSS->getActiveSheet()->setCellValue('C' . $i, $totalno_apl);
	$objSS->getActiveSheet()->getStyle('C' . $i)->applyFromArray($saCellCenter);
	$objSS->getActiveSheet()->getStyle('C' . $i)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
	$i++;

	$objSS->getActiveSheet()->setCellValue('B' . $i, 'N° Características No Obligatorias Cumplen');
	$objSS->getActiveSheet()->getStyle('B' . $i)->applyFromArray($saCell);
	$objSS->getActiveSheet()->getStyle('B' . $i)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);

	$objSS->getActiveSheet()->setCellValue('C' . $i, $totalno_si);
	$objSS->getActiveSheet()->getStyle('C' . $i)->applyFromArray($saCellCenter);
	$objSS->getActiveSheet()->getStyle('C' . $i)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
	$i++;

	$objSS->getActiveSheet()->setCellValue('B' . $i, '% Características No Obligatorias');
	$objSS->getActiveSheet()->getStyle('B' . $i)->applyFromArray($saCellCenter);
	$objSS->getActiveSheet()->getStyle('B' . $i)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
	$objSS->getActiveSheet()->getStyle('B' . $i)->getFont()->setBold(true);

	$por_total = ($totalno_apl > 0) ? $totalno_si / $totalno_apl * 100 : 0;
	$objSS->getActiveSheet()->setCellValue('C' . $i, number_format($por_total, 0, ',', '.') . '%');
	$objSS->getActiveSheet()->getStyle('C' . $i)->applyFromArray($saCellCenter);
	$objSS->getActiveSheet()->getStyle('C' . $i)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
	$objSS->getActiveSheet()->getStyle('C' . $i)->getFont()->setBold(true);
	$i++;

	$objSS->getActiveSheet()->getStyle('B' . $i . ':C' . $i)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);

	// Rename worksheet
	$objSS->getActiveSheet()->setTitle('SERVICIO ' . removeAccents(substr($subpv->spv_nombre, 0, 20)));

	// Set active sheet index to the first sheet, so Excel opens this as the first sheet
	$objSS->setActiveSheetIndex(0);

	// Save Excel 2007 file
	$objWriter = new Xlsx($objSS);
	$objWriter->save('../upload/Reporte_' . str_replace(' ', '_', removeAccents($subpv->spv_nombre)) . '_' . $month . '-' . $year . '.xlsx');

	$response = array('type' => true, 'msg' => str_replace(' ', '_', removeAccents($subpv->spv_nombre)) . '_' . $month . '-' . $year);
	echo json_encode($response);
endif;