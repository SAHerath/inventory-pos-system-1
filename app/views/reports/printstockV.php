<?php
require_once(APPROOT . '/extensions/tcpdf/tcpdf.php');

// create new PDF document
$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);

// set document information
$pdf->SetCreator('TCPDF');
$pdf->SetAuthor('S. A. Herath');
$pdf->SetTitle('Nawa Lanka Enterprises');
$pdf->SetSubject('REPORT');

// remove default header/footer
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

$pdf->SetMargins(10, 0, 10);  // left , top, right, bottom
// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, 5);
// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, 5);
// $pageMargin = $pdf->getOriginalMargins();
$bodyWidth = 210 - 20;
$pageWidth = $pdf->getPageWidth();
$border = 0;

$pdf->SetFont('helvetica', '', 18);  // font, B-bolt|I-itaic|U-underline, font size

$pdf->AddPage();

// Image( $file, $x = '', $y = '', $w = 0, $h = 0, $type = '', $link = '', $align = '', $resize = false, $dpi = 300, $palign = '', $ismask = false, $imgmask = false, $border = 0, $fitbox = false, $hidden = false, $fitonpage = false, $alt = false, $altimgs = array() )
$pdf->Image(URLROOT . 'img/nawalanka-logo-2.png', 15, 10, 16, '', 'PNG');

$logo = ['NAWA LANKA', 'ENTERPRISES'];
$contact = ['No: 33A, Colombo Road, Negombo', 'Tel: 0094-312-281441 / 0094-774-881655', 'Email: nawalankaent@gmail.com'];

// MultiCell( $w, $h, $txt, $border = 0, $align = 'J', $fill = false, $ln = 1, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false );
$pdf->SetFont('helvetica', 'B', 20);
$pdf->MultiCell(52, 6, $logo[0], $border, 'J', 0, 1, 38, 9, true);
$pdf->SetFont('helvetica', 'B', 11.5);
$pdf->MultiCell(52, 4, $logo[1], $border, 'C', 0, 1, 38, 17, true);

$pdf->SetFont('helvetica', '', 10);
$pdf->SetTextColor(0, 48, 207);

$pdf->MultiCell(70, 5, $contact[0], $border, 'R', 0, 1, $pageWidth - 80, 10, true);
$pdf->MultiCell(70, 5, $contact[1], $border, 'R', 0, 1, $pageWidth - 80, 15, true);
$pdf->MultiCell(70, 5, $contact[2], $border, 'R', 0, 1, $pageWidth - 80, 20, true);

$pdf->SetFont('helvetica', 'B', 18);
$pdf->SetTextColor(127, 31, 0);
$pdf->Cell('', '', $data['title'], $border, 1, 'C', 0, '', 0);  // Cell( $w, $h = 0, $txt = '', $border = 0, $ln = 0, $align = '', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M' );
$pdf->Ln(10);

$pdf->SetFont('helvetica', '', 10);
$y = $pdf->getY();
$x = $pdf->getX();

//table head

$pdf->SetTextColor(0, 48, 207);
$pdf->MultiCell(25, '', 'SKU', $border, 'L', 0, 1, $x, $y, true);
$pdf->MultiCell(85, '', 'Product Description', $border, 'L', 0, 1, $x + 25, $y, true);
$pdf->MultiCell(25, '', 'Quantity', $border, 'L', 0, 1, $x + 110, $y, true);
$pdf->MultiCell(25, '', 'Reorder Lvl.', $border, 'L', 0, 1, $x + 135, $y, true);
$pdf->MultiCell(30, '', 'Status', $border, 'L', 0, 1, $x + 160, $y, true);
$pdf->Line($x, $y + 6, $pageWidth - $x, $y + 6, '');  // Line( $x1, $y1, $x2, $y2, $style = array() )
$pdf->Ln(5);

//table body
$fill = 1;
$y = $pdf->getY();
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFillColor(240, 240, 240);

foreach ($data['stock'] as $item) {
  $prodLen = ceil(strlen($item['prodt_name']) / 50);
  $cellH = $prodLen * 6;

  $pdf->MultiCell(25, $cellH, 'PR-' . str_pad($item['prodt_id'], 8, '0', STR_PAD_LEFT), $border, 'L', $fill, 1, $x, $y, true, 0, false, true, $cellH, 'M', false);
  $pdf->MultiCell(85, $cellH, str_replace(PHP_EOL, ' ', $item['prodt_name']), $border, 'L', $fill, 1, $x + 25, $y, true, 0, false, true, $cellH, 'M', false);
  $pdf->MultiCell(25, $cellH, $item['prodt_qty'], $border, 'L', $fill, 1, $x + 110, $y, true, 0, false, true, $cellH, 'M', false);
  $pdf->MultiCell(25, $cellH, $item['prodt_rord'], $border, 'L', $fill, 1, $x + 135, $y, true, 0, false, true, $cellH, 'M', false);
  $pdf->MultiCell(30, $cellH, $item['prodt_stat'], $border, 'L', $fill, 1, $x + 160, $y, true, 0, false, true, $cellH, 'M', false);

  $y = $y + $cellH;
  $fill = !$fill;
}
$pdf->Ln(5);
$y = $pdf->getY();
$pdf->Line($x, $y, $pageWidth - $x, $y, '');

// force print dialog
$js = 'print(true);';
// set javascript
$pdf->IncludeJS($js);
//Close and output PDF document
$pdf->Output('rep_' . $data['title'] . '.pdf', 'I');
