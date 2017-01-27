<?php
error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);

$this->pdf->setPrintHeader(true,$type); 
$this->pdf->setPrintFooter(true);
$this->pdf->SetFont('helvetica', 'B', 16);
$this->pdf->AddPage("L","A5");   
foreach($branch as $ress){
	$this->pdf->headerSet4($ress->name,$ress->address,$ress->tp,$ress->fax,$ress->email);
}

$cus_name=$cus_address="";


foreach($session as $ses){
	$invoice_no=$session[0].$session[1].$session[2];
}

foreach($sum as $s){
	$f_branch=$s->from_bc." - ".$s->f_b_name;
	$t_branch=$s->to_bc." - ".$s->t_bc_des;
	$f_store=$s->from_store." - ".$s->from_store_des;
	$t_store=$s->to_store." - ".$s->t_store_des;
	$dt=$s->ddate;
	$memo=$s->memo;
}

$this->pdf->setY(20);

$this->pdf->SetFont('helvetica', 'BU', 12);
$orgin_print=$_POST['org_print'];
if($orgin_print=="1"){
	$this->pdf->Cell(0, 5, $r_type.' DIRECT INTERNAL TRANSFER ',0,false, 'C', 0, '', 0, false, 'M', 'M');
}else{
	$this->pdf->Cell(0, 5, $r_type.' DIRECT INTERNAL TRANSFER (Duplicate) ',0,false, 'C', 0, '', 0, false, 'M', 'M');

}
$this->pdf->SetFont('helvetica', '', 9);
$this->pdf->setY(30);
$this->pdf->Cell(30, 1, 'No.', '0', 0, 'L', 0);
$this->pdf->Cell(20, 1, $invoice_no, '0', 0, 'L', 0);
$this->pdf->Cell(20, 1, "", '0', 0, 'L', 0);
$this->pdf->Cell(1, 1, "", '0', 0, 'L', 0);
$this->pdf->Cell(20, 1, "From Branch", '0', 0, 'L', 0);
$this->pdf->Cell(60, 1, $f_branch, '0', 0, 'L', 0);

$this->pdf->Ln();

$this->pdf->Cell(30, 1, 'Date', '0', 0, 'L', 0);
$this->pdf->Cell(20, 1, $dt, '0', 0, 'L', 0);
$this->pdf->Cell(20, 1, "", '0', 0, 'L', 0);
$this->pdf->Cell(1, 1, "", '0', 0, 'L', 0);
$this->pdf->Cell(20, 1, "To Branch", '0', 0, 'L', 0);
$this->pdf->Cell(30, 1, $t_branch, '0', 0, 'L', 0);


$this->pdf->Ln();

$this->pdf->Cell(30, 1, 'From Store', '0', 0, 'L', 0);
$this->pdf->Cell(20, 1, $f_store, '0', 0, 'L', 0);
$this->pdf->Cell(20, 1, "", '0', 0, 'L', 0);
$this->pdf->Cell(1, 1, "", '0', 0, 'L', 0);
$this->pdf->Cell(20, 1, "To Store", '0', 0, 'L', 0);
$this->pdf->Cell(30, 1, $t_store, '0', 0, 'L', 0);

$this->pdf->Ln();
$this->pdf->Cell(30, 1, "Memo", '0', 0, 'L', 0);
$this->pdf->Cell(30, 1, $memo, '0', 0, 'L', 0);

$this->pdf->Ln();
$this->pdf->SetX(7);
$this->pdf->SetFont('helvetica','B',9);
$this->pdf->Cell(10, 6,"Sr. No", '1', 0, 'C', 0);
$this->pdf->Cell(25, 6,"Item Code", '1', 0, 'C', 0);
$this->pdf->Cell(55, 6,"Item Description", '1', 0, 'C', 0);
$this->pdf->Cell(25, 6,"Model", '1', 0, 'C', 0);
$this->pdf->Cell(18, 6,"Unit Price", '1', 0, 'C', 0);
$this->pdf->Cell(18, 6,"Min Price", '1', 0, 'C', 0);
$this->pdf->Cell(18, 6,"Max Price", '1', 0, 'C', 0);
$this->pdf->Cell(10, 6,"Qty", '1', 0, 'C', 0);
$this->pdf->Cell(20, 6,"Net Value", '1', 0, 'C', 0);
$this->pdf->Ln();
$z=1;
$code="default";
$amount =0;
foreach($det as $row){
	$this->pdf->SetX(7);
	$this->pdf->SetFont('helvetica','',8);
	$aa = max($this->pdf->getNumLines($row->item_name, 55), $this->pdf->getNumLines($row->model, 25)  );
	$heigh=5*$aa;
	$this->pdf->haveMorePages($heigh);

	$this->pdf->MultiCell(10, $heigh, $z, 1, 'L', 0, 0, '', '', true, 0, false, true, 0);
	$this->pdf->MultiCell(25, $heigh, $row->code, 1, 'L', 0, 0, '', '', true, 0, false, true, 0);
	$this->pdf->MultiCell(55, $heigh, $row->item_name, 1, 'L', 0, 0, '', '', true, 0, false, true, 0);
	$this->pdf->MultiCell(25, $heigh, $row->model, 1, 'L', 0, 0, '', '', true, 0, false, true, 0);
	$this->pdf->MultiCell(18, $heigh, $row->cost, 1, 'R', 0, 0, '', '', true, 0, false, true, 0);
	$this->pdf->MultiCell(18, $heigh, $row->min, 1, 'R', 0, 0, '', '', true, 0, false, true, 0);
	$this->pdf->MultiCell(18, $heigh, $row->max, 1, 'R', 0, 0, '', '', true, 0, false, true, 0);
	$this->pdf->MultiCell(10, $heigh, $row->qty, 1, 'R', 0, 0, '', '', true, 0, false, true, 0);
	$this->pdf->MultiCell(20, $heigh, number_format($row->amount,2), 1, 'R', 0, 1, '', '', true, 0, false, true, 0);
	$amount+=$row->amount;
	$z++;

	$all_serial="";
		foreach ($serial as $rows) {
    		if($row->code==$rows->item && $row->batch_no==$rows->batch_no){		
	 			$all_serial=$all_serial.$rows->serial_no."   ";
 			}
		}
	if($all_serial!=""){
		$this->pdf->SetX(7);
		$aa = $this->pdf->getNumLines($all_serial, 105);
	    $heigh2=5*$aa;
		$this->pdf->MultiCell(10, $heigh2, '', 1, 'L', 0, 0, '', '', true, 0, false, true, 0);
		$this->pdf->MultiCell(105, $heigh2, $all_serial, 1, 'L', 0, 0, '', '', true, 0, false, true, 0);
		$this->pdf->MultiCell(18, $heigh2, '', 1, 'R', 0, 0, '', '', true, 0, false, true, 0);
		$this->pdf->MultiCell(18, $heigh2, '', 1, 'R', 0, 0, '', '', true, 0, false, true, 0);
		$this->pdf->MultiCell(18, $heigh2, '', 1, 'R', 0, 0, '', '', true, 0, false, true, 0);
		$this->pdf->MultiCell(10, $heigh2, '', 1, 'R', 0, 0, '', '', true, 0, false, true, 0);
		$this->pdf->MultiCell(20, $heigh2, '', 1, 'R', 0, 1, '', '', true, 0, false, true, 0);
	}

}
$this->pdf->footer_set_direct_transfer($employee,$amount,$additional,$discount,$user,$credit_card);
$this->pdf->Output("t_direct_internal_transfer".date('Y-m-d').".pdf", 'I');

?>