<?php

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

/** Include \PhpOffice\PhpSpreadsheet\Spreadsheet */
require '../vendor/autoload.php';

/** Include Classes */
include("../class/classMyDBC.php");
include("../class/classIndicador.php");
include("../class/classPuntoVerificacion.php");
include("../class/classElementoMed.php");
include("../class/classAutoevaluation.php");
include("../src/fn.php");

if (extract($_POST)):
	try {
		$ind = new Indicador();
		$pv = new PuntoVerificacion();
		$em = new ElementoMed();
		$au = new Autoevaluation();

		$tmp = explode('/', $idatei);
		$month = $tmp[1];
		$month_num = ($month[0] == '0') ? substr($month, 1) : $month;
		$month_words = getMonth($month_num);
		$year = $tmp[2];
		$totalo_apl = 0;
		$totalo_si = 0;
		$totalno_apl = 0;
		$totalno_si = 0;
		$idatei = setDateBD($idatei);
		$idatet = setDateBD($idatet);

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
				'horizontal' => Alignment::HORIZONTAL_LEFT,
				'vertical' => Alignment::VERTICAL_CENTER
			)
		);

		$saHeader = array(
			'font' => array(
				'bold' => true,
				'size' => 12
			),
			'alignment' => array(
				'horizontal' => Alignment::HORIZONTAL_CENTER,
				'vertical' => Alignment::VERTICAL_CENTER
			)
		);

		$saHeaderType = array(
			'font' => array(
				'bold' => true,
				'size' => 12
			),
			'alignment' => array(
				'horizontal' => Alignment::HORIZONTAL_LEFT,
				'vertical' => Alignment::VERTICAL_CENTER
			)
		);

		// Celda cabecera de tabla
		$saCellHeader = array(
			'font' => array(
				'bold' => true,
				'size' => 8
			),
			'alignment' => array(
				'horizontal' => Alignment::HORIZONTAL_CENTER,
				'vertical' => Alignment::VERTICAL_CENTER
			),
			'borders' => array(
				'top' => array(
					'borderStyle' => Border::BORDER_MEDIUM,
					'color' => ['rgb' => '000000']
				),
				'bottom' => array(
					'borderStyle' => Border::BORDER_MEDIUM,
					'color' => ['rgb' => '000000']
				),
				'right' => array(
					'borderStyle' => Border::BORDER_THIN,
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
				'horizontal' => Alignment::HORIZONTAL_LEFT,
				'vertical' => Alignment::VERTICAL_CENTER
			),
			'borders' => array(
				'bottom' => array(
					'borderStyle' => Border::BORDER_THIN,
					'color' => ['rgb' => '000000']
				),
				'right' => array(
					'borderStyle' => Border::BORDER_THIN,
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
				'horizontal' => Alignment::HORIZONTAL_CENTER,
				'vertical' => Alignment::VERTICAL_CENTER
			),
			'borders' => array(
				'bottom' => array(
					'borderStyle' => Border::BORDER_THIN,
					'color' => ['rgb' => '000000']
				),
				'right' => array(
					'borderStyle' => Border::BORDER_THIN,
					'color' => ['rgb' => '000000']
				)
			)
		);

		$objSS->getActiveSheet()->getColumnDimension('A')->setWidth(10);
		$objSS->getActiveSheet()->getColumnDimension('B')->setWidth(90);
		$objSS->getActiveSheet()->getColumnDimension('C')->setWidth(10);
		$objSS->getActiveSheet()->getColumnDimension('D')->setWidth(10);
		$objSS->getActiveSheet()->getColumnDimension('E')->setWidth(10);
		$objSS->getActiveSheet()->getColumnDimension('F')->setWidth(10);
		$objSS->getActiveSheet()->getColumnDimension('G')->setWidth(10);
		$objSS->getActiveSheet()->getColumnDimension('H')->setWidth(10);
		$objSS->getActiveSheet()->getColumnDimension('I')->setWidth(10);
		$objSS->getActiveSheet()->getColumnDimension('J')->setWidth(10);
		$objSS->getActiveSheet()->getColumnDimension('K')->setWidth(10);
		$objSS->getActiveSheet()->getColumnDimension('L')->setWidth(10);

		/**
		 * CABECERAS
		 */
		$objSS->getActiveSheet()->setCellValue('A2', 'SERVICIO DE SALUD CONCEPCIÓN');
		$objSS->getActiveSheet()->mergeCells('A2:L2');
		$objSS->getActiveSheet()->setCellValue('A3', 'HOSPITAL GUILLERMO GRANT BENAVENTE');
		$objSS->getActiveSheet()->mergeCells('A3:L3');
		$objSS->getActiveSheet()->setCellValue('A4', 'UNIDAD DE CALIDAD Y SEGURIDAD DEL PACIENTE');
		$objSS->getActiveSheet()->mergeCells('A4:L4');
		$objSS->getActiveSheet()->getStyle('A2:A4')->applyFromArray($saHeaderTop);

		/**
		 * TITULO
		 */
		$objSS->getActiveSheet()->setCellValue('A6', 'AUTOEVALUACIÓN ' . strtoupper($month_words) . ' ' . $year);
		$objSS->getActiveSheet()->mergeCells('A6:L6');
		$objSS->getActiveSheet()->getStyle('A6:L6')->applyFromArray($saHeader);

		/**
		 * CARACTERISTICAS OBLIGATORIAS
		 */
		$objSS->getActiveSheet()->setCellValue('A8', 'I. RESUMEN CUMPLIMIENTO DE CARACTERÍSTICAS OBLIGATORIAS');
		$objSS->getActiveSheet()->mergeCells('A8:L8');
		$objSS->getActiveSheet()->getStyle('A8:L8')->applyFromArray($saHeaderType);

		/**
		 * TABLA DE DATOS
		 */
		$objSS->getActiveSheet()->setCellValue('A10', 'COD');
		$objSS->getActiveSheet()->getStyle('A10')->applyFromArray($saCellHeader);
		$objSS->getActiveSheet()->setCellValue('B10', 'DESCRIPCIÓN');
		$objSS->getActiveSheet()->getStyle('B10')->applyFromArray($saCellHeader);
		$objSS->getActiveSheet()->setCellValue('C10', '% UMBRAL');
		$objSS->getActiveSheet()->getStyle('C10')->applyFromArray($saCellHeader);
		$objSS->getActiveSheet()->setCellValue('D10', 'N° VERIF. APLICAN');
		$objSS->getActiveSheet()->getStyle('D10')->applyFromArray($saCellHeader);
		$objSS->getActiveSheet()->setCellValue('E10', 'N° VERIF CUMPL.');
		$objSS->getActiveSheet()->getStyle('E10')->applyFromArray($saCellHeader);
		$objSS->getActiveSheet()->setCellValue('F10', '% CUMPLE');
		$objSS->getActiveSheet()->getStyle('F10')->applyFromArray($saCellHeader);
		$objSS->getActiveSheet()->setCellValue('G10', 'CUMPLE (SI / NO)');
		$objSS->getActiveSheet()->getStyle('G10')->applyFromArray($saCellHeader);
		$objSS->getActiveSheet()->setCellValue('H10', '1EM');
		$objSS->getActiveSheet()->getStyle('H10')->applyFromArray($saCellHeader);
		$objSS->getActiveSheet()->setCellValue('I10', '2EM');
		$objSS->getActiveSheet()->getStyle('I10')->applyFromArray($saCellHeader);
		$objSS->getActiveSheet()->setCellValue('J10', '3EM');
		$objSS->getActiveSheet()->getStyle('J10')->applyFromArray($saCellHeader);
		$objSS->getActiveSheet()->setCellValue('K10', '4EM');
		$objSS->getActiveSheet()->getStyle('K10')->applyFromArray($saCellHeader);
		$objSS->getActiveSheet()->setCellValue('L10', '5EM');
		$objSS->getActiveSheet()->getStyle('L10')->applyFromArray($saCellHeader);
		$objSS->getActiveSheet()->getStyle('L10')->getBorders()->getRight()->setBorderStyle(Border::BORDER_MEDIUM);
		$objSS->getActiveSheet()->getStyle('D10:L10')->getAlignment()->setWrapText(true);

		$i = 11;
		$ind_data = $ind->getByTypeCar(1);
		$totalo_caract = 0;
		$totalo_caract_cumplen = 0;

		foreach ($ind_data as $k => $v):
			$objSS->getActiveSheet()->setCellValue('A' . $i, $v->samb_sigla . ' ' . $v->cod_descripcion);
			$objSS->getActiveSheet()->getStyle('A' . $i)->applyFromArray($saCellCenter);

			$objSS->getActiveSheet()->setCellValue('B' . $i, $v->ind_descripcion);
			$objSS->getActiveSheet()->getStyle('B' . $i)->applyFromArray($saCell);
			$objSS->getActiveSheet()->getStyle('B' . $i)->getAlignment()->setWrapText(true);

			$objSS->getActiveSheet()->setCellValue('C' . $i, $v->ind_umbral);
			$objSS->getActiveSheet()->getStyle('C' . $i)->applyFromArray($saCellCenter);
			$objSS->getActiveSheet()->getStyle('C' . $i)->getFont()->setBold(true);

			$puntos = $pv->getByInd($v->ind_id);
			$elems = $em->getByInd($v->samb_id, $v->cod_id);
			$verificables = count($puntos) * count($elems);
			$totalo_apl += $verificables;
			$objSS->getActiveSheet()->setCellValue('D' . $i, $verificables);
			$objSS->getActiveSheet()->getStyle('D' . $i)->applyFromArray($saCellCenter);

			$fail_em = 0;
			$arr_elem = ['1EM' => 'N/A', '2EM' => 'N/A', '3EM' => 'N/A', '4EM' => 'N/A', '5EM' => 'N/A'];
			foreach ($elems as $ek => $ev):
				$fail_verif = 0;

				foreach ($puntos as $pk => $pve):
					$failed = $au->getFailedByPVEMDate($pve->pv_id, $ev->elm_id, $idatei, $idatet);
					if (count($failed) > 0)
						$fail_verif++;
				endforeach;

				if ($fail_verif > 0):
					$fail_em++;
					$arr_elem[$ev->elm_numero] = 'NO';
				else:
					$arr_elem[$ev->elm_numero] = 'SI';
				endif;
			endforeach;

			$cumplidos = $verificables - $fail_verif;
			$totalo_si += $cumplidos;
			$objSS->getActiveSheet()->setCellValue('E' . $i, $cumplidos);
			$objSS->getActiveSheet()->getStyle('E' . $i)->applyFromArray($saCellCenter);

			$perc = ($verificables > 0) ? ($cumplidos / $verificables) * 100 : 100;
			$objSS->getActiveSheet()->setCellValue('F' . $i, round($perc));
			$objSS->getActiveSheet()->getStyle('F' . $i)->applyFromArray($saCellCenter);
			$objSS->getActiveSheet()->getStyle('F' . $i)->getFont()->setBold(true);

			$cumple_str = ($v->ind_umbral <= $perc) ? 'SI' : 'NO';
			if ($v->ind_umbral <= $perc) $totalo_caract_cumplen++;
			if ($v->ind_umbral > $perc):
				$objSS->getActiveSheet()->getStyle('F' . $i . ':G' . $i)->getFont()->getColor()->setRGB('FF0000');
				$objSS->getActiveSheet()->getStyle('F' . $i . ':G' . $i)->getFont()->setBold(true);
			endif;
			$objSS->getActiveSheet()->setCellValue('G' . $i, $cumple_str);
			$objSS->getActiveSheet()->getStyle('G' . $i)->applyFromArray($saCellCenter);

			$objSS->getActiveSheet()->setCellValue('H' . $i, $arr_elem['1EM']);
			$objSS->getActiveSheet()->getStyle('H' . $i)->applyFromArray($saCellCenter);
			if ($arr_elem['1EM'] == 'NO'):
				$objSS->getActiveSheet()->getStyle('H' . $i)->getFont()->getColor()->setRGB('FF0000');
				$objSS->getActiveSheet()->getStyle('H' . $i)->getFont()->setBold(true);
			endif;

			$objSS->getActiveSheet()->setCellValue('I' . $i, $arr_elem['2EM']);
			$objSS->getActiveSheet()->getStyle('I' . $i)->applyFromArray($saCellCenter);
			if ($arr_elem['2EM'] == 'NO'):
				$objSS->getActiveSheet()->getStyle('I' . $i)->getFont()->getColor()->setRGB('FF0000');
				$objSS->getActiveSheet()->getStyle('I' . $i)->getFont()->setBold(true);
			endif;

			$objSS->getActiveSheet()->setCellValue('J' . $i, $arr_elem['3EM']);
			$objSS->getActiveSheet()->getStyle('J' . $i)->applyFromArray($saCellCenter);
			if ($arr_elem['3EM'] == 'NO'):
				$objSS->getActiveSheet()->getStyle('J' . $i)->getFont()->getColor()->setRGB('FF0000');
				$objSS->getActiveSheet()->getStyle('J' . $i)->getFont()->setBold(true);
			endif;

			$objSS->getActiveSheet()->setCellValue('K' . $i, $arr_elem['4EM']);
			$objSS->getActiveSheet()->getStyle('K' . $i)->applyFromArray($saCellCenter);
			if ($arr_elem['4EM'] == 'NO'):
				$objSS->getActiveSheet()->getStyle('K' . $i)->getFont()->getColor()->setRGB('FF0000');
				$objSS->getActiveSheet()->getStyle('K' . $i)->getFont()->setBold(true);
			endif;

			$objSS->getActiveSheet()->setCellValue('L' . $i, $arr_elem['5EM']);
			$objSS->getActiveSheet()->getStyle('L' . $i)->applyFromArray($saCellCenter);
			if ($arr_elem['5EM'] == 'NO'):
				$objSS->getActiveSheet()->getStyle('L' . $i)->getFont()->getColor()->setRGB('FF0000');
				$objSS->getActiveSheet()->getStyle('L' . $i)->getFont()->setBold(true);
			endif;

			$i++;
			$totalo_caract++;
		endforeach;

		$objSS->getActiveSheet()->getStyle('A' . $i . ':L' . $i)->getBorders()->getTop()->setBorderStyle(Border::BORDER_MEDIUM);
		$i += 2;

		/**
		 * CARACTERISTICAS NO OBLIGATORIAS
		 */
		$objSS->getActiveSheet()->setCellValue('A' . $i, 'II. RESUMEN CUMPLIMIENTO DE CARACTERÍSTICAS NO OBLIGATORIAS');
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
		$objSS->getActiveSheet()->setCellValue('C' . $i, '% UMBRAL');
		$objSS->getActiveSheet()->getStyle('C' . $i)->applyFromArray($saCellHeader);
		$objSS->getActiveSheet()->setCellValue('D' . $i, 'N° VERIF. APLICAN');
		$objSS->getActiveSheet()->getStyle('D' . $i)->applyFromArray($saCellHeader);
		$objSS->getActiveSheet()->setCellValue('E' . $i, 'N° VERIF CUMPL.');
		$objSS->getActiveSheet()->getStyle('E' . $i)->applyFromArray($saCellHeader);
		$objSS->getActiveSheet()->setCellValue('F' . $i, '% CUMPLE');
		$objSS->getActiveSheet()->getStyle('F' . $i)->applyFromArray($saCellHeader);
		$objSS->getActiveSheet()->setCellValue('G' . $i, 'CUMPLE (SI / NO)');
		$objSS->getActiveSheet()->getStyle('G' . $i)->applyFromArray($saCellHeader);
		$objSS->getActiveSheet()->setCellValue('H' . $i, '1EM');
		$objSS->getActiveSheet()->getStyle('H' . $i)->applyFromArray($saCellHeader);
		$objSS->getActiveSheet()->setCellValue('I' . $i, '2EM');
		$objSS->getActiveSheet()->getStyle('I' . $i)->applyFromArray($saCellHeader);
		$objSS->getActiveSheet()->setCellValue('J' . $i, '3EM');
		$objSS->getActiveSheet()->getStyle('J' . $i)->applyFromArray($saCellHeader);
		$objSS->getActiveSheet()->setCellValue('K' . $i, '4EM');
		$objSS->getActiveSheet()->getStyle('K' . $i)->applyFromArray($saCellHeader);
		$objSS->getActiveSheet()->setCellValue('L' . $i, '5EM');
		$objSS->getActiveSheet()->getStyle('L' . $i)->applyFromArray($saCellHeader);
		$objSS->getActiveSheet()->getStyle('L' . $i)->getBorders()->getRight()->setBorderStyle(Border::BORDER_MEDIUM);
		$objSS->getActiveSheet()->getStyle('D' . $i . ':L' . $i)->getAlignment()->setWrapText(true);

		$i++;
		$ind_data = $ind->getByTypeCar(2);
		$totalno_caract = 0;
		$totalno_caract_cumplen = 0;

		foreach ($ind_data as $k => $v):
			$objSS->getActiveSheet()->setCellValue('A' . $i, $v->samb_sigla . ' ' . $v->cod_descripcion);
			$objSS->getActiveSheet()->getStyle('A' . $i)->applyFromArray($saCellCenter);

			$objSS->getActiveSheet()->setCellValue('B' . $i, $v->ind_descripcion);
			$objSS->getActiveSheet()->getStyle('B' . $i)->applyFromArray($saCell);
			$objSS->getActiveSheet()->getStyle('B' . $i)->getAlignment()->setWrapText(true);

			$objSS->getActiveSheet()->setCellValue('C' . $i, $v->ind_umbral);
			$objSS->getActiveSheet()->getStyle('C' . $i)->applyFromArray($saCellCenter);
			$objSS->getActiveSheet()->getStyle('C' . $i)->getFont()->setBold(true);

			$puntos = $pv->getByInd($v->ind_id);
			$elems = $em->getByInd($v->samb_id, $v->cod_id);
			$verificables = count($puntos) * count($elems);
			$totalno_apl += $verificables;
			$objSS->getActiveSheet()->setCellValue('D' . $i, $verificables);
			$objSS->getActiveSheet()->getStyle('D' . $i)->applyFromArray($saCellCenter);

			$fail_verif = 0;
			$arr_elem = ['1EM' => 'N/A', '2EM' => 'N/A', '3EM' => 'N/A', '4EM' => 'N/A', '5EM' => 'N/A'];
			foreach ($puntos as $pk => $pve):
				foreach ($elems as $ek => $ev):
					$failed = $au->getFailedByPVEMDate($pve->pv_id, $ev->elm_id, $idatei, $idatet);
					if (count($failed) > 0):
						$fail_verif++;
						$arr_elem[$ev->elm_numero] = 'NO';
					else:
						$arr_elem[$ev->elm_numero] = 'SI';
					endif;
				endforeach;
			endforeach;

			$cumplidos = $verificables - $fail_verif;
			$totalno_si += $cumplidos;
			$objSS->getActiveSheet()->setCellValue('E' . $i, $cumplidos);
			$objSS->getActiveSheet()->getStyle('E' . $i)->applyFromArray($saCellCenter);

			$perc = ($verificables > 0) ? ($cumplidos / $verificables) * 100 : 100;
			$objSS->getActiveSheet()->setCellValue('F' . $i, round($perc));
			$objSS->getActiveSheet()->getStyle('F' . $i)->applyFromArray($saCellCenter);
			$objSS->getActiveSheet()->getStyle('F' . $i)->getFont()->setBold(true);

			$cumple_str = ($v->ind_umbral <= $perc) ? 'SI' : 'NO';
			if ($v->ind_umbral <= $perc) $totalno_caract_cumplen++;
			if ($v->ind_umbral > $perc):
				$objSS->getActiveSheet()->getStyle('F' . $i . ':G' . $i)->getFont()->getColor()->setRGB('FF0000');
				$objSS->getActiveSheet()->getStyle('F' . $i . ':G' . $i)->getFont()->setBold(true);
			endif;
			$objSS->getActiveSheet()->setCellValue('G' . $i, $cumple_str);
			$objSS->getActiveSheet()->getStyle('G' . $i)->applyFromArray($saCellCenter);

			$objSS->getActiveSheet()->setCellValue('H' . $i, $arr_elem['1EM']);
			$objSS->getActiveSheet()->getStyle('H' . $i)->applyFromArray($saCellCenter);
			if ($arr_elem['1EM'] == 'NO'):
				$objSS->getActiveSheet()->getStyle('H' . $i)->getFont()->getColor()->setRGB('FF0000');
				$objSS->getActiveSheet()->getStyle('H' . $i)->getFont()->setBold(true);
			endif;

			$objSS->getActiveSheet()->setCellValue('I' . $i, $arr_elem['2EM']);
			$objSS->getActiveSheet()->getStyle('I' . $i)->applyFromArray($saCellCenter);
			if ($arr_elem['2EM'] == 'NO'):
				$objSS->getActiveSheet()->getStyle('I' . $i)->getFont()->getColor()->setRGB('FF0000');
				$objSS->getActiveSheet()->getStyle('I' . $i)->getFont()->setBold(true);
			endif;

			$objSS->getActiveSheet()->setCellValue('J' . $i, $arr_elem['3EM']);
			$objSS->getActiveSheet()->getStyle('J' . $i)->applyFromArray($saCellCenter);
			if ($arr_elem['3EM'] == 'NO'):
				$objSS->getActiveSheet()->getStyle('J' . $i)->getFont()->getColor()->setRGB('FF0000');
				$objSS->getActiveSheet()->getStyle('J' . $i)->getFont()->setBold(true);
			endif;

			$objSS->getActiveSheet()->setCellValue('K' . $i, $arr_elem['4EM']);
			$objSS->getActiveSheet()->getStyle('K' . $i)->applyFromArray($saCellCenter);
			if ($arr_elem['4EM'] == 'NO'):
				$objSS->getActiveSheet()->getStyle('K' . $i)->getFont()->getColor()->setRGB('FF0000');
				$objSS->getActiveSheet()->getStyle('K' . $i)->getFont()->setBold(true);
			endif;

			$objSS->getActiveSheet()->setCellValue('L' . $i, $arr_elem['5EM']);
			$objSS->getActiveSheet()->getStyle('L' . $i)->applyFromArray($saCellCenter);
			if ($arr_elem['5EM'] == 'NO'):
				$objSS->getActiveSheet()->getStyle('L' . $i)->getFont()->getColor()->setRGB('FF0000');
				$objSS->getActiveSheet()->getStyle('L' . $i)->getFont()->setBold(true);
			endif;

			$i++;
			$totalno_caract++;
		endforeach;

		$objSS->getActiveSheet()->getStyle('A' . $i . ':L' . $i)->getBorders()->getTop()->setBorderStyle(Border::BORDER_MEDIUM);
		$i += 2;

		/**
		 * RESUMENES
		 */

		$objSS->getActiveSheet()->setCellValue('A' . $i, 'III. RESUMEN RESULTADO FINAL DE AUTOEVALUACIÓN');
		$objSS->getActiveSheet()->mergeCells('A' . $i . ':L' . $i);
		$objSS->getActiveSheet()->getStyle('A' . $i . ':L' . $i)->applyFromArray($saHeaderType);

		$i += 2;

		/**
		 * TABLAS RESUMENES
		 */
		$objSS->getActiveSheet()->setCellValue('B' . $i, 'CARACTERÍSTICAS OBLIGATORIAS');
		$objSS->getActiveSheet()->getStyle('B' . $i)->applyFromArray($saCellHeader);
		$objSS->getActiveSheet()->getStyle('B' . $i)->getBorders()->getLeft()->setBorderStyle(Border::BORDER_MEDIUM);

		$objSS->getActiveSheet()->setCellValue('C' . $i, '');
		$objSS->getActiveSheet()->getStyle('C' . $i)->applyFromArray($saCellHeader);

		$objSS->getActiveSheet()->setCellValue('D' . $i, '');
		$objSS->getActiveSheet()->getStyle('D' . $i)->applyFromArray($saCellHeader);
		$objSS->getActiveSheet()->getStyle('D' . $i)->getBorders()->getRight()->setBorderStyle(Border::BORDER_MEDIUM);
		$i++;

		$objSS->getActiveSheet()->setCellValue('B' . $i, 'N° Verificables Aplican');
		$objSS->getActiveSheet()->getStyle('B' . $i)->applyFromArray($saCell);
		$objSS->getActiveSheet()->getStyle('B' . $i)->getBorders()->getLeft()->setBorderStyle(Border::BORDER_MEDIUM);

		$objSS->getActiveSheet()->setCellValue('C' . $i, $totalo_apl);
		$objSS->getActiveSheet()->getStyle('C' . $i)->applyFromArray($saCellCenter);

		$objSS->getActiveSheet()->setCellValue('D' . $i, $totalo_caract);
		$objSS->getActiveSheet()->getStyle('D' . $i)->applyFromArray($saCellCenter);
		$objSS->getActiveSheet()->getStyle('D' . $i)->getBorders()->getRight()->setBorderStyle(Border::BORDER_MEDIUM);
		$i++;

		$objSS->getActiveSheet()->setCellValue('B' . $i, 'N° Verificables Cumplen');
		$objSS->getActiveSheet()->getStyle('B' . $i)->applyFromArray($saCell);
		$objSS->getActiveSheet()->getStyle('B' . $i)->getBorders()->getLeft()->setBorderStyle(Border::BORDER_MEDIUM);

		$objSS->getActiveSheet()->setCellValue('C' . $i, $totalo_si);
		$objSS->getActiveSheet()->getStyle('C' . $i)->applyFromArray($saCellCenter);

		$objSS->getActiveSheet()->setCellValue('D' . $i, $totalo_caract_cumplen);
		$objSS->getActiveSheet()->getStyle('D' . $i)->applyFromArray($saCellCenter);
		$objSS->getActiveSheet()->getStyle('D' . $i)->getBorders()->getRight()->setBorderStyle(Border::BORDER_MEDIUM);
		$i++;

		$objSS->getActiveSheet()->setCellValue('B' . $i, '% Cumplimiento');
		$objSS->getActiveSheet()->getStyle('B' . $i)->applyFromArray($saCellCenter);
		$objSS->getActiveSheet()->getStyle('B' . $i)->getBorders()->getLeft()->setBorderStyle(Border::BORDER_MEDIUM);
		$objSS->getActiveSheet()->getStyle('B' . $i)->getFont()->setBold(true);

		$por_total = ($totalo_apl > 0) ? $totalo_si / $totalo_apl * 100 : 0;
		$por_total_car = ($totalo_caract > 0) ? $totalo_caract_cumplen / $totalo_caract * 100 : 0;
		$objSS->getActiveSheet()->setCellValue('C' . $i, round($por_total) . '%');
		$objSS->getActiveSheet()->getStyle('C' . $i)->applyFromArray($saCellCenter);
		$objSS->getActiveSheet()->getStyle('C' . $i)->getFont()->setBold(true);

		$objSS->getActiveSheet()->setCellValue('D' . $i, round($por_total_car) . '%');
		$objSS->getActiveSheet()->getStyle('D' . $i)->applyFromArray($saCellCenter);
		$objSS->getActiveSheet()->getStyle('D' . $i)->getFont()->setBold(true);
		$objSS->getActiveSheet()->getStyle('D' . $i)->getBorders()->getRight()->setBorderStyle(Border::BORDER_MEDIUM);
		$i++;

		$objSS->getActiveSheet()->getStyle('B' . $i . ':D' . $i)->getBorders()->getTop()->setBorderStyle(Border::BORDER_MEDIUM);
		$i++;

		$objSS->getActiveSheet()->setCellValue('B' . $i, 'CARACTERÍSTICAS NO OBLIGATORIAS');
		$objSS->getActiveSheet()->getStyle('B' . $i)->applyFromArray($saCellHeader);
		$objSS->getActiveSheet()->getStyle('B' . $i)->getBorders()->getLeft()->setBorderStyle(Border::BORDER_MEDIUM);

		$objSS->getActiveSheet()->setCellValue('C' . $i, '');
		$objSS->getActiveSheet()->getStyle('C' . $i)->applyFromArray($saCellHeader);

		$objSS->getActiveSheet()->setCellValue('D' . $i, '');
		$objSS->getActiveSheet()->getStyle('D' . $i)->applyFromArray($saCellHeader);
		$objSS->getActiveSheet()->getStyle('D' . $i)->getBorders()->getRight()->setBorderStyle(Border::BORDER_MEDIUM);
		$i++;

		$objSS->getActiveSheet()->setCellValue('B' . $i, 'N° Verificables Aplican');
		$objSS->getActiveSheet()->getStyle('B' . $i)->applyFromArray($saCell);
		$objSS->getActiveSheet()->getStyle('B' . $i)->getBorders()->getLeft()->setBorderStyle(Border::BORDER_MEDIUM);

		$objSS->getActiveSheet()->setCellValue('C' . $i, $totalno_apl);
		$objSS->getActiveSheet()->getStyle('C' . $i)->applyFromArray($saCellCenter);

		$objSS->getActiveSheet()->setCellValue('D' . $i, $totalno_caract);
		$objSS->getActiveSheet()->getStyle('D' . $i)->applyFromArray($saCellCenter);
		$objSS->getActiveSheet()->getStyle('D' . $i)->getBorders()->getRight()->setBorderStyle(Border::BORDER_MEDIUM);
		$i++;

		$objSS->getActiveSheet()->setCellValue('B' . $i, 'N° Verificables Cumplen');
		$objSS->getActiveSheet()->getStyle('B' . $i)->applyFromArray($saCell);
		$objSS->getActiveSheet()->getStyle('B' . $i)->getBorders()->getLeft()->setBorderStyle(Border::BORDER_MEDIUM);

		$objSS->getActiveSheet()->setCellValue('C' . $i, $totalno_si);
		$objSS->getActiveSheet()->getStyle('C' . $i)->applyFromArray($saCellCenter);

		$objSS->getActiveSheet()->setCellValue('D' . $i, $totalno_caract_cumplen);
		$objSS->getActiveSheet()->getStyle('D' . $i)->applyFromArray($saCellCenter);
		$objSS->getActiveSheet()->getStyle('D' . $i)->getBorders()->getRight()->setBorderStyle(Border::BORDER_MEDIUM);
		$i++;

		$objSS->getActiveSheet()->setCellValue('B' . $i, '% Cumplimiento');
		$objSS->getActiveSheet()->getStyle('B' . $i)->applyFromArray($saCellCenter);
		$objSS->getActiveSheet()->getStyle('B' . $i)->getBorders()->getLeft()->setBorderStyle(Border::BORDER_MEDIUM);
		$objSS->getActiveSheet()->getStyle('B' . $i)->getFont()->setBold(true);

		$por_total = ($totalno_apl > 0) ? $totalno_si / $totalno_apl * 100 : 0;
		$por_total_car = ($totalno_caract > 0) ? $totalno_caract_cumplen / $totalno_caract * 100 : 0;
		$objSS->getActiveSheet()->setCellValue('C' . $i, round($por_total) . '%');
		$objSS->getActiveSheet()->getStyle('C' . $i)->applyFromArray($saCellCenter);
		$objSS->getActiveSheet()->getStyle('C' . $i)->getFont()->setBold(true);

		$objSS->getActiveSheet()->setCellValue('D' . $i, round($por_total_car) . '%');
		$objSS->getActiveSheet()->getStyle('D' . $i)->applyFromArray($saCellCenter);
		$objSS->getActiveSheet()->getStyle('D' . $i)->getFont()->setBold(true);
		$objSS->getActiveSheet()->getStyle('D' . $i)->getBorders()->getRight()->setBorderStyle(Border::BORDER_MEDIUM);
		$i++;

		$objSS->getActiveSheet()->getStyle('B' . $i . ':D' . $i)->getBorders()->getTop()->setBorderStyle(Border::BORDER_MEDIUM);

		// Rename worksheet
		$objSS->getActiveSheet()->setTitle('RESUMEN');

		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
		$objSS->setActiveSheetIndex(0);

		// Save Excel 2007 file
		$objWriter = new Xlsx($objSS);
		$objWriter->save('../upload/Resumen_' . $month . '-' . $year . '.xlsx');

		$response = array('type' => true, 'msg' => $month . '-' . $year);
		echo json_encode($response);
	} catch (\PhpOffice\PhpSpreadsheet\Exception $e) {
	}
endif;
