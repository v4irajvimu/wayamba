<?php
error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
$this->pdf->setPrintFooter(true);
$this->pdf->setPrintHeader(true);
$this->pdf->setPrintHeader($header,$type); 
$this->pdf->SetFont('helvetica', 'B', 16);
$this->pdf->AddPage("L","A5");   // L or P amd page type A4 or A3

foreach($branch as $ress){
	$this->pdf->headerSet3($ress->name,$ress->address,$ress->tp,$ress->fax,$ress->email);
}

foreach($session as $ses){
	$invoice_no=$session[0].$session[1].'CA'.$session[2];
}

foreach($sum as $ss){
	$customer_id   		=$ss->customer;
	$customer_name 		=$ss->cus_name;	
	$dt 				=$ss->ddate;	
	$ref_no				=$ss->ref_no;	
	$customer_address	=$ss->cus_address;	
	$driver 			=$ss->driver_name;	
	$helper 			=$ss->helper_name;	
	$vehicle 			=$ss->vehicle;	
	$note 				=$ss->note;	
}

$this->pdf->setY(20);
$this->pdf->SetFont('helvetica', 'BU', 10);
$this->pdf->Cell(0, 5, 'DELIVERY NOTE',0,false, 'R', 0, '', 0, false, 'M', 'M');

$this->pdf->SetFont('helvetica', 'B', 9);
$this->pdf->setY(25);

$this->pdf->Cell(30, 1, 'Invoice No.', '0', 0, 'L', 0);
$this->pdf->Cell(60, 1, $invoice_no, '0', 0, 'L', 0);
$this->pdf->Cell(2, 1, "", '0', 0, 'L', 0);
$this->pdf->SetFont('helvetica', 'B', 8);
$this->pdf->Cell(30, 1, "ID No", '0', 0, 'L', 0);
$this->pdf->Cell(30, 1, $customer_id, '0', 0, 'L', 0);
$this->pdf->Ln();

$this->pdf->SetFont('helvetica', '', 8);
$this->pdf->Cell(30, 1, 'Invoice Date', '0', 0, 'L', 0);
$this->pdf->Cell(60, 1, $dt, '0', 0, 'L', 0);
$this->pdf->Cell(1, 1, "", '0', 0, 'L', 0);
$this->pdf->Cell(1, 1, "", '0', 0, 'L', 0);
$this->pdf->Cell(30, 1, "Name", '0', 0, 'L', 0);
$this->pdf->Cell(30, 1, $customer_name, '0', 0, 'L', 0);

$this->pdf->Ln();
$this->pdf->Cell(30, 1, 'Ref No', '0', 0, 'L', 0);
$this->pdf->Cell(60, 1, $ref_no, '0', 0, 'L', 0);
$this->pdf->Cell(1, 1, "", '0', 0, 'L', 0);
$this->pdf->Cell(1, 1, "", '0', 0, 'L', 0);
$this->pdf->Cell(30, 1, "Address", '0', 0, 'L', 0);
$this->pdf->Cell(30, 1, $customer_address, '0', 0, 'L', 0);

$this->pdf->Ln();
$this->pdf->Cell(30, 1, 'Driver', '0', 0, 'L', 0);
$this->pdf->Cell(60, 1, $driver, '0', 0, 'L', 0);
$this->pdf->Cell(1, 1, "", '0', 0, 'L', 0);
$this->pdf->Cell(1, 1, "", '0', 0, 'L', 0);
$this->pdf->Cell(30, 1, "Helper", '0', 0, 'L', 0);
$this->pdf->Cell(30, 1, $helper, '0', 0, 'L', 0);

$this->pdf->Ln();
$this->pdf->Cell(30, 1, 'Vehicle', '0', 0, 'L', 0);
$this->pdf->Cell(60, 1, $vehicle, '0', 0, 'L', 0);
$this->pdf->Cell(1, 1, "", '0', 0, 'L', 0);
$this->pdf->Cell(1, 1, "", '0', 0, 'L', 0);
$this->pdf->Cell(30, 1, "", '0', 0, 'L', 0);
$this->pdf->Cell(30, 1, "", '0', 0, 'L', 0);

$this->pdf->Ln();
$this->pdf->Ln();
$this->pdf->setX(5);
$this->pdf->SetFont('helvetica','B',9);
$this->pdf->Cell(10, 6,"No", '1', 0, 'C', 0);
$this->pdf->Cell(30, 6,"INV Type", '1', 0, 'C', 0);
$this->pdf->Cell(19, 6,"INV Date", '1', 0, 'C', 0);
$this->pdf->Cell(14, 6,"INV No", '1', 0, 'C', 0);
$this->pdf->Cell(30, 6,"Item", '1', 0, 'C', 0);
$this->pdf->Cell(65, 6,"Description", '1', 0, 'C', 0);
$this->pdf->Cell(14, 6,"Balance", '1', 0, 'C', 0);
$this->pdf->Cell(14, 6,"Qty", '1', 0, 'C', 0);
$this->pdf->Cell(12, 6,"D.Qty", '1', 0, 'C', 0);
$this->pdf->Ln();
$x=1;
foreach($det as $row){
	$this->pdf->setX(5);
	$this->pdf->SetFont('helvetica','',9);
	$aa = $this->pdf->getNumLines($row->item_name, 65);
    $heigh=5*$aa;
	$this->pdf->MultiCell(10, $heigh,$x,  1, 'L', 0, 0, '', '', true, 0, false, true, 0);
	$this->pdf->MultiCell(30, $heigh,$row->t_des, 1, 'L', 0, 0, '', '', true, 0, false, true, 0);
	$this->pdf->MultiCell(19, $heigh,$row->inv_date, 1, 'L', 0, 0, '', '', true, 0, false, true, 0);
    $this->pdf->MultiCell(14, $heigh,$row->inv_no, 1, 'L', 0, 0, '', '', true, 0, false, true, 0);
    $this->pdf->MultiCell(30, $heigh,$row->item, 1, 'L', 0, 0, '', '', true, 0, false, true, 0);
    $this->pdf->MultiCell(65, $heigh,$row->item_name,  1, 'L', 0, 0, '', '', true, 0, false, true, 0);
    $this->pdf->MultiCell(14, $heigh,$row->balance, 1, 'R', 0, 0, '', '', true, 0, false, true, 0);
    $this->pdf->MultiCell(14, $heigh,$row->qty, 1, 'R', 0, 0, '', '', true, 0, false, true, 0);
    $this->pdf->MultiCell(12, $heigh,$row->deliverd_qty, 1, 'R', 0, 1, '', '', true, 0, false, true, 0);
    $x++;
}
$this->pdf->Ln();
$this->pdf->Ln();
$this->pdf->Cell(30, 1, 'Note', '0', 0, 'L', 0);
$this->pdf->Cell(60, 1, $note, '0', 0, 'L', 0);


$this->pdf->Output("Cash Sales_".date('Y-m-d').".pdf", 'I');
?>