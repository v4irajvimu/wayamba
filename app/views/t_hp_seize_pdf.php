<?php
error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);

$this->pdf->setPrintFooter(true,'0',$is_cur_time);
$this->pdf->setPrintHeader(true);
$this->pdf->setPrintHeader($header,$type); 

$this->pdf->SetFont('helvetica', 'B', 16);
$this->pdf->AddPage($orientation,$page);   // L or P amd page type A4 or A3
foreach($branch as $ress){
	$this->pdf->headerSet4($ress->name,$ress->address,$ress->tp,$ress->fax,$ress->email,$is_print_logo);
}

foreach($sum as $s){
	$no 			= $s->nno;
	$date 		= $s->ddate;
	$ref 			= $s->ref_no;
	$agr_no 	= $s->agr_no;
	$cus 			= $s->customer;
	$cus_name = $s->cus_name;
	$note 		= $s->note;
	$rvt_chg	= $s->revert_chargers;
}

foreach($session as $ses){
	$invoice_no=$session[0].$session[1].$session[2];
}

$align_h=$this->utility->heading_align();
$this->pdf->Ln();
$this->pdf->setY(20);

$this->pdf->SetFont('helvetica', 'BU', 10);
$this->pdf->Cell(0, 5, 'HIRE PURCHASE SEIZE',0,false, $align_h, 0, '', 0, false, 'M', 'M');

$this->pdf->SetFont('helvetica', 'b', 8);
$this->pdf->setY(25);
$this->pdf->Cell(20, 1, 'No.', '0', 0, 'L', 0);
$this->pdf->SetFont('helvetica', '', 8);
$this->pdf->Cell(30, 1, $invoice_no, '0', 0, 'L', 0);
$this->pdf->Cell(2, 1, "", '0', 0, 'L', 0);
$this->pdf->SetFont('helvetica', 'b', 8);
$this->pdf->Cell(30, 1, "Agreenment No", '0', 0, 'L', 0);
$this->pdf->SetFont('helvetica', '', 8);
$this->pdf->Cell(30, 1, $agr_no, '0', 0, 'L', 0);
$this->pdf->Ln();

$this->pdf->SetFont('helvetica', 'B', 8);
$this->pdf->Cell(20, 1, 'Date', '0', 0, 'L', 0);
$this->pdf->SetFont('helvetica', '', 8);
$this->pdf->Cell(30, 1, $date.$save_time, '0', 0, 'L', 0);
$this->pdf->SetFont('helvetica', 'b', 8);
$this->pdf->Cell(2, 1, "", '0', 0, 'L', 0);
$this->pdf->SetFont('helvetica', 'b', 8);
$this->pdf->Cell(30, 1, "Customer ID", '0', 0, 'L', 0);
$this->pdf->SetFont('helvetica', '', 8);
$this->pdf->Cell(30, 1, $cus, '0', 0, 'L', 0);
$this->pdf->Ln();

$this->pdf->SetFont('helvetica', 'B', 8);
$this->pdf->Cell(20, 1, 'Ref No', '0', 0, 'L', 0);
$this->pdf->SetFont('helvetica', '', 8);
$this->pdf->Cell(30, 1, $ref, '0', 0, 'L', 0);
$this->pdf->Cell(2, 1, "", '0', 0, 'L', 0);
$this->pdf->SetFont('helvetica', 'b', 8);
$this->pdf->Cell(30, 1, "Name", '0', 0, 'L', 0);
$this->pdf->SetFont('helvetica', '', 8);
$this->pdf->Cell(30, 1, $cus_name, '0', 0, 'L', 0);

$this->pdf->Ln();
$this->pdf->SetY(40);
$this->pdf->setX(8);
$this->pdf->SetFont('helvetica','B',9);
$this->pdf->Cell(10, 6,"No", '1', 0, 'C', 0);
$this->pdf->Cell(30, 6,"Code", '1', 0, 'C', 0);
$this->pdf->Cell(55, 6,"Description", '1', 0, 'C', 0);
$this->pdf->Cell(20, 6,"Model", '1', 0, 'C', 0);
$this->pdf->Cell(10, 6,"QTY", '1', 0, 'C', 0);
$this->pdf->Cell(18, 6,"Price", '1', 0, 'C', 0);
$this->pdf->Cell(17, 6,"Discount", '1', 0, 'C', 0);
$this->pdf->Cell(20, 6,"Net Value", '1', 0, 'C', 0);
$this->pdf->Cell(25, 6,"Serial No", '1', 0, 'C', 0);

$this->pdf->Ln();
$x=1;
$code="default";
$amt=0;

foreach($det as $row){
	$this->pdf->setX(10);
	$this->pdf->SetLineStyle(array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0.1, 'color' => array(0, 0, 0)));
	$this->pdf->GetY();
	$this->pdf->setX(8);
	$this->pdf->SetFont('helvetica','',9);
	$aa = $this->pdf->getNumLines($row->item_name, 55);
	$heigh=5*$aa;
	$this->pdf->MultiCell(10, $heigh,$x,  1, 'R', 0, 0, '', '', true, 0, false, true, 0);
	$this->pdf->MultiCell(30, $heigh,$row->item_code, 1, 'L', 0, 0, '', '', true, 0, false, true, 0);
	$this->pdf->MultiCell(55, $heigh,$row->item_name, 1, 'L', 0, 0, '', '', true, 0, false, true, 0);
	$this->pdf->MultiCell(20, $heigh,$row->model, 1, 'L', 0, 0, '', '', true, 0, false, true, 0);
	$this->pdf->MultiCell(10, $heigh,$row->qty, 1, 'R', 0, 0, '', '', true, 0, false, true, 0);
	$this->pdf->MultiCell(18, $heigh,number_format($row->price,2),  1, 'R', 0, 0, '', '', true, 0, false, true, 0);
	$this->pdf->MultiCell(17, $heigh,number_format($row->discount,2), 1, 'R', 0, 0, '', '', true, 0, false, true, 0);
	$this->pdf->MultiCell(20, $heigh,number_format($row->net_amount,2), 1, 'R', 0, 0, '', '', true, 0, false, true, 0);
	$this->pdf->MultiCell(25, $heigh,$row->serials, 1, 'R', 0, 1, '', '', true, 0, false, true, 0);

	foreach($serial as $rows){
		if($row->code==$rows->item){
			$ss=$rows->serial_no;
		}
	}
  $all_serial="";
	foreach ($serial as $rows){
		if($row->item_code==$rows->item){					
			$all_serial=$all_serial.$rows->serial_no."   ";
		}
	}
	$this->pdf->GetY();
	$this->pdf->setX(8);
	if($all_serial!=""){
		$this->pdf->SetFont('helvetica','',9);
		$aa = $this->pdf->getNumLines($all_serial, 55);
		$heigh=5*$aa;
		$this->pdf->MultiCell(10, $heigh, "", 1, 'L', 0, 0, '', '', true, 0, false, true, 0);
		$this->pdf->MultiCell(30, $heigh, "", 1, 'L', 0, 0, '', '', true, 0, false, true, 0);
		$this->pdf->MultiCell(55, $heigh, $all_serial, 1, 'L', 0, 0, '', '', true, 0, false, true, 0);
		$this->pdf->MultiCell(20, $heigh, "", 1, 'L', 0, 0, '', '', true, 0, false, true, 0);
		$this->pdf->MultiCell(10, $heigh, "", 1, 'L', 0, 0, '', '', true, 0, false, true, 0);
		$this->pdf->MultiCell(18, $heigh, "", 1, 'L', 0, 0, '', '', true, 0, false, true, 0);
		$this->pdf->MultiCell(17, $heigh, "", 1, 'L', 0, 0, '', '', true, 0, false, true, 0);
		$this->pdf->MultiCell(20, $heigh, "",  1, 'R', 0, 0, '', '', true, 0, false, true, 0);
		$this->pdf->MultiCell(25, $heigh, "",  1, 'R', 0, 1, '', '', true, 0, false, true, 0);
	}
	$code=$row->code;
	$amt+=$row->net_amount;
	$x++;
}
$this->pdf->setX(8);
$this->pdf->SetFont('helvetica','B',9);
$this->pdf->Cell(130, 6," ", '0', 0, 'L', 0);
$this->pdf->Cell(25, 6,"Gross Amount ", '0', 0, 'L', 0);
$this->pdf->SetFont('helvetica','',9);
$this->pdf->Cell(25, 6,number_format($amt,2), '0', 0, 'R', 0);
$this->pdf->Ln();
$this->pdf->setX(8);
$this->pdf->SetFont('helvetica','B',9);
$this->pdf->Cell(130, 6," ", '0', 0, 'L', 0);
$this->pdf->Cell(25, 6,"Revert Chargers ", '0', 0, 'L', 0);
$this->pdf->SetFont('helvetica','',9);
$this->pdf->Cell(25, 6,number_format($rvt_chg,2), '0', 0, 'R', 0);
$this->pdf->Ln();
$this->pdf->setX(8);
$this->pdf->SetFont('helvetica','B',9);
$this->pdf->Cell(130, 6," ", '0', 0, 'L', 0);
$this->pdf->Cell(25, 6,"Net Amount ", '0', 0, 'L', 0);
$this->pdf->SetFont('helvetica','',9);
$this->pdf->Cell(25, 6,number_format((float)$rvt_chg+(float)$amt,2), 'TB', 0, 'R', 0);
$this->pdf->Ln();

$this->pdf->setX(8);
$this->pdf->SetFont('helvetica','B',9);
$this->pdf->Cell(15, 6,"Note ", '0', 0, 'L', 0);
$this->pdf->SetFont('helvetica','',9);
$this->pdf->Cell(25, 6,$note, '0', 0, 'L', 0);

$this->pdf->Output("hire_purchase_seize".date('Y-m-d').".pdf", 'I');

?>