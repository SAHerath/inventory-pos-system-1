<?php
require_once(APPROOT . '/extensions/tcpdf/tcpdf.php');

// create new PDF document
$pdf = new TCPDF('L', 'mm', 'A5', true, 'UTF-8', false);

// set document information
$pdf->SetCreator('TCPDF');
$pdf->SetAuthor('S. A. Herath');
$pdf->SetTitle('Nawa Lanka Enterprises');
$pdf->SetSubject('INVOICE');

// remove default header/footer
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

$pdf->SetMargins(10, 0, 10);  // left , top, right, bottom
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

$pdf->MultiCell(70, 5, $contact[0], $border, 'R', 0, 1, 130, 10, true);
$pdf->MultiCell(70, 5, $contact[1], $border, 'R', 0, 1, 130, 15, true);
$pdf->MultiCell(70, 5, $contact[2], $border, 'R', 0, 1, 130, 20, true);

$pdf->SetFont('helvetica', 'B', 18);
$pdf->SetTextColor(127, 31, 0);
$pdf->Cell('', '', 'INVOICE', $border, 1, 'C', 0, '', 0);  // Cell( $w, $h = 0, $txt = '', $border = 0, $ln = 0, $align = '', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M' );

$pdf->SetFont('helvetica', '', 10);
$y = $pdf->getY();
$x = $pdf->getX();

$pdf->SetTextColor(0, 48, 207);
$pdf->MultiCell(80, '', 'BILL TO', $border, 'L', 0, 1, $x, $y, true);
$pdf->SetTextColor(0, 0, 0);
$pdf->MultiCell(80, '', $data['order']['ordr_cust_name'] . "\n" . str_replace(PHP_EOL, '', $data['order']['ordr_cust_address']) . "\n" . $data['order']['ordr_cust_phone'], $border, 'L', 0, 1, $x, $y + 5, true);

// $pdf->SetTextColor(0, 48, 207);
// $pdf->MultiCell(26, '', 'PAY METHOD', $border, 'L', 0, 1, $x, $y + 20, true);
// $pdf->SetTextColor(0, 0, 0);
// $pdf->MultiCell(20, '', $data['order']['ordr_pay_method'], $border, 'L', 0, 1, $x + 26, $y + 20, true);

$pdf->SetTextColor(0, 48, 207);
$pdf->MultiCell(25, '', 'ORDER NO', $border, 'L', 0, 0, $pageWidth - 70, $y, true);
$pdf->SetTextColor(0, 0, 0);
$pdf->MultiCell(35, '', $data['order']['order_incno'], $border, 'L', 0, 1, $pageWidth - 45, $y, true);

$pdf->SetTextColor(0, 48, 207);
$pdf->MultiCell(25, '', 'DATE', $border, 'L', 0, 0, $pageWidth - 70, $y + 7, true);
$pdf->SetTextColor(0, 0, 0);
$pdf->MultiCell(35, '', $data['order']['ordr_date'], $border, 'L', 0, 1, $pageWidth - 45, $y + 7, true);

$pdf->SetTextColor(0, 48, 207);
$pdf->MultiCell(25, '', 'ISSUED BY', $border, 'L', 0, 0, $pageWidth - 70, $y + 14, true);
$pdf->SetTextColor(0, 0, 0);
$pdf->MultiCell(35, '', $data['user']['user_first_name'], $border, 'L', 0, 1, $pageWidth - 45, $y + 14, true);
$pdf->Ln(10);

$y = $pdf->getY();
$x = $pdf->getX();

//table head

$pdf->SetTextColor(0, 48, 207);
$pdf->MultiCell(90, '', 'Item', $border, 'L', 0, 1, $x, $y, true);
$pdf->MultiCell(20, '', 'Qty', $border, 'R', 0, 1, $x + 90, $y, true);
$pdf->MultiCell(30, '', 'Rate Rs.', $border, 'R', 0, 1, $x + 110, $y, true);
$pdf->MultiCell(20, '', 'Disc %', $border, 'R', 0, 1, $x + 140, $y, true);
$pdf->MultiCell(30, '', 'Amount Rs.', $border, 'R', 0, 1, $x + 160, $y, true);
$pdf->Line($x, $y + 6, $pageWidth - $x, $y + 6, '');  // Line( $x1, $y1, $x2, $y2, $style = array() )
$pdf->Ln(5);

//table body
$fill = 1;
$y = $pdf->getY();
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFillColor(240, 240, 240);

foreach ($data['ordprd'] as $item) {
  $pdf->MultiCell(90, '', $item['prodt_sku'] . ', ' . $item['prod_name'], $border, 'L', $fill, 1, $x, $y, true);
  $pdf->MultiCell(20, '', $item['odpd_quantity'], $border, 'R', $fill, 1, $x + 90, $y, true);
  $pdf->MultiCell(30, '', $item['odpd_unit_price'], $border, 'R', $fill, 1, $x + 110, $y, true);
  $pdf->MultiCell(20, '', $item['odpd_discount'], $border, 'R', $fill, 1, $x + 140, $y, true);
  $pdf->MultiCell(30, '', $item['odpd_sub_amount'], $border, 'R', $fill, 1, $x + 160, $y, true);
  $y = $y + 6;
  $fill = !$fill;
}
$pdf->Ln(5);
$y = $pdf->getY();
$pdf->Line($x, $y, $pageWidth - $x, $y, '');
$fill = 1;

$pdf->SetTextColor(0, 48, 207);
$pdf->MultiCell(20, '', 'Sub Total', $border, 'L', $fill, 1, $pageWidth - 60, $y + 5, true);
$pdf->SetTextColor(0, 0, 0);
$pdf->MultiCell(30, '', number_format((float)$data['order']['ordr_sub_total'], 2), $border, 'R', $fill, 1, $pageWidth - 40, $y + 5, true);

$pdf->SetTextColor(0, 48, 207);
$pdf->MultiCell(20, '', 'Taxes', $border, 'L', $fill, 1, $pageWidth - 60, $y + 10, true);
$pdf->SetTextColor(0, 0, 0);
$pdf->MultiCell(30, '', number_format((float)$data['order']['ordr_taxes'], 2), $border, 'R', $fill, 1, $pageWidth - 40, $y + 10, true);

$pdf->SetFont('helvetica', 'B', 10);
$pdf->SetTextColor(0, 48, 207);
$pdf->MultiCell(20, '', 'Total', $border, 'L', $fill, 1, $pageWidth - 60, $y + 15, true);
$pdf->SetTextColor(0, 0, 0);
$pdf->MultiCell(30, '', number_format((float)$data['order']['ordr_total'], 2), $border, 'R', $fill, 1, $pageWidth - 40, $y + 15, true);

// force print dialog
$js = 'print(true);';
// set javascript
$pdf->IncludeJS($js);
//Close and output PDF document
$pdf->Output($data['order']['order_incno'] . '.pdf', 'I');
