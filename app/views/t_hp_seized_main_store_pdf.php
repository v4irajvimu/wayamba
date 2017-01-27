<?php
error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
$this->pdf->setPrintFooter(true,'0',$is_cur_time);
$this->pdf->setPrintHeader(true);
$this->pdf->setPrintHeader($header,$type); 
$this->pdf->SetFont('helvetica', 'B', 16);
$this->pdf->AddPage($orientation,$page);   
foreach($branch as $ress){
	$this->pdf->headerSet4($ress->name,$ress->address,$ress->tp,$ress->fax,$ress->email,$is_print_logo);
}

foreach($sum as $s){
	$agr_no 	= $s->agr_no;
	$f_store 	= $s->from_store;
	$f_store_des= $s->f_store_des;
	$t_store 	= $s->to_store;
	$t_store_des= $s->t_store_des;
	$date 		= $s->ddate;
	$ref_no 	= $s->ref_no;
	$customer	= $s->customer;
	$customer_n = $s->cus_name;
	$dr_acc		= $s->dr_acc.' - '.$s->acc_des;
}

foreach($session as $ses){
	$invoice_no=$session[0].$session[1].$session[2];
}

$align_h=$this->utility->heading_align();
$this->pdf->Ln();
$this->pdf->setY(20);

$this->pdf->SetFont('helvetica', 'BU', 10);
$this->pdf->Cell(0, 5, 'SEIZE ITEMS TO MAIN STORE',0,false, $align_h, 0, '', 0, false, 'M', 'M');

$this->pdf->SetFont('helvetica', 'b', 8);
$this->pdf->setY(25);
$this->pdf->Cell(20, 1, 'No.', '0', 0, 'L', 0);
$this->pdf->SetFont('helvetica', '', 8);
$this->pdf->Cell(30, 1, $invoice_no, '0', 0, 'L', 0);
$this->pdf->Cell(40, 1, "", '0', 0, 'L', 0);
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
$this->pdf->Cell(40, 1, "", '0', 0, 'L', 0);
$this->pdf->SetFont('helvetica', 'b', 8);
$this->pdf->Cell(30, 1, "Customer ID", '0', 0, 'L', 0);
$this->pdf->SetFont('helvetica', '', 8);
$this->pdf->Cell(30, 1, $customer, '0', 0, 'L', 0);
$this->pdf->Ln();

$this->pdf->SetFont('helvetica', 'B', 8);
$this->pdf->Cell(20, 1, 'Ref No', '0', 0, 'L', 0);
$this->pdf->SetFont('helvetica', '', 8);
$this->pdf->Cell(30, 1, $ref_no, '0', 0, 'L', 0);
$this->pdf->Cell(40, 1, "", '0', 0, 'L', 0);
$this->pdf->SetFont('helvetica', 'b', 8);
$this->pdf->Cell(30, 1, "Name", '0', 0, 'L', 0);
$this->pdf->SetFont('helvetica', '', 8);
$this->pdf->Cell(30, 1, $customer_n, '0', 0, 'L', 0);
$this->pdf->Ln();

$this->pdf->SetFont('helvetica', 'B', 8);
$this->pdf->Cell(20, 1, 'From Store', '0', 0, 'L', 0);
$this->pdf->SetFont('helvetica', '', 8);
$this->pdf->Cell(30, 1, $f_store.' - '.$f_store_des, '0', 0, 'L', 0);
$this->pdf->Cell(40, 1, "", '0', 0, 'L', 0);
$this->pdf->SetFont('helvetica', 'b', 8);
$this->pdf->Cell(30, 1, "To Store", '0', 0, 'L', 0);
$this->pdf->SetFont('helvetica', '', 8);
$this->pdf->Cell(30, 1, $t_store.' - '.$t_store_des, '0', 0, 'L', 0);

$this->pdf->Ln();
$this->pdf->Ln();

$this->pdf->setX(8);
$this->pdf->SetFont('helvetica','B',9);
$this->pdf->Cell(10, 6,"No", '1', 0, 'C', 0);
$this->pdf->Cell(30, 6,"Code", '1', 0, 'C', 0);
$this->pdf->Cell(55, 6,"Description", '1', 0, 'C', 0);
$this->pdf->Cell(20, 6,"Model", '1', 0, 'C', 0);
$this->pdf->Cell(10, 6,"Qty", '1', 0, 'C', 0);
$this->pdf->Cell(18, 6,"Price", '1', 0, 'C', 0);
$this->pdf->Cell(20, 6,"Net Value", '1', 0, 'C', 0);
$this->pdf->Cell(30, 6,"N.Item Code", '1', 0, 'C', 0);

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
	$aa = $this->pdf->getNumLines($row->description, 55);
	$heigh=5*$aa;
	$this->pdf->MultiCell(10, $heigh,$x,  1, 'R', 0, 0, '', '', true, 0, false, true, 0);
	$this->pdf->MultiCell(30, $heigh,$row->code, 1, 'L', 0, 0, '', '', true, 0, false, true, 0);
	$this->pdf->MultiCell(55, $heigh,$row->description, 1, 'L', 0, 0, '', '', true, 0, false, true, 0);
	$this->pdf->MultiCell(20, $heigh,$row->model, 1, 'L', 0, 0, '', '', true, 0, false, true, 0);
	$this->pdf->MultiCell(10, $heigh,$row->qty, 1, 'R', 0, 0, '', '', true, 0, false, true, 0);
	$this->pdf->MultiCell(18, $heigh,number_format($row->max,2),  1, 'R', 0, 0, '', '', true, 0, false, true, 0);
	$this->pdf->MultiCell(20, $heigh,number_format($row->amount,2), 1, 'R', 0, 0, '', '', true, 0, false, true, 0);
	$this->pdf->MultiCell(30, $heigh,$row->new_item_code, 1, 'L', 0, 1, '', '', true, 0, false, true, 0);

	foreach($serial as $rows){
		if($row->new_item_code==$rows->item){
			$ss=$rows->serial_no;
		}
	}
  	$all_serial="";
	foreach ($serial as $rows){
		if($row->new_item_code==$rows->item){					
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
		$this->pdf->MultiCell(20, $heigh, "",  1, 'R', 0, 0, '', '', true, 0, false, true, 0);
		$this->pdf->MultiCell(30, $heigh, "",  1, 'R', 0, 1, '', '', true, 0, false, true, 0);
	}
	$code=$row->code;
	$amt+=$row->amount;
	$x++;
}
$this->pdf->setX(8);
$this->pdf->SetFont('helvetica','B',9);
$this->pdf->Cell(113, 6," ", '0', 0, 'L', 0);
$this->pdf->Cell(25, 6,"Net Amount ", '0', 0, 'L', 0);
$this->pdf->SetFont('helvetica','',9);
$this->pdf->Cell(25, 6,number_format($amt,2), 'TB', 0, 'R', 0);
$this->pdf->Ln();

$this->pdf->setX(8);
$this->pdf->SetFont('helvetica','B',9);
$this->pdf->Cell(20, 6,"DR Account ", '0', 0, 'L', 0);
$this->pdf->SetFont('helvetica','',9);
$this->pdf->Cell(25, 6,$dr_acc, '0', 0, 'L', 0);

$this->pdf->Output("seize items to main store".date('Y-m-d').".pdf", 'I');

?>