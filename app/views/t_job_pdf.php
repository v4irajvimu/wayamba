<?php
error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);

$this->pdf->setPrintHeader(true);
$this->pdf->setPrintHeader($header,$type); 
$this->pdf->AddPage($orientation,$page);

    
foreach($branch as $ress){
	$this->pdf->headerSet4($ress->name,$ress->address,$ress->tp,$ress->fax,$ress->email);
}
$align_h=$this->utility->heading_align();
$this->pdf->Ln();
$this->pdf->setY(15);
$this->pdf->SetFont('helvetica', 'B', 10);
$this->pdf->Cell(0, 5,'Service Received Note',0,false, $align_h, 0, '', 0, false, 'M', 'M');
$this->pdf->Ln();
$this->pdf->Cell(0, 0,"", 'T', 1, 'L', 0);
foreach ($jobs as $row){
	$invoice_type=$row->inv_type;
	$nno=$row->nno;
	$invoice_date=$row->inv_date;
	$ref_no = $row->ref_no;
	$ddate = $row->ddate;
	$cus_id = $row->cus_id;
	$cus_name= $row->cus_name;
	$inv_no = $row->inv_no;
	$sup_code = $row->sup_code;
	$sup_name = $row->sup_name;
	$address1 = $row->address1;
	$address2 = $row->address2;
	$address3 = $row->address3;
	$w_start_dt = $row->w_start_date;
	$w_end_dt = $row->w_end_date;
	$gur_no = $row->guarantee_cardno;

}


$this->pdf->SetFont('helvetica', 'B', 8);
$this->pdf->Cell(20, 1, 'Invoice Type', '0', 0, 'L', 0);
$this->pdf->Cell(3, 1, '-', '0', 0, 'C', 0);
$this->pdf->SetFont('helvetica', '0', 8);
$this->pdf->Cell(25, 1,$invoice_type, '0', 0, 'L', 0);

$this->pdf->SetFont('helvetica', 'BU', 8);
$this->pdf->Cell(88, 1, 'Customer', '0', 0, 'L', 0);
$this->pdf->SetFont('helvetica', 'B', 8);
$this->pdf->Cell(15, 1, 'No', '0', 0, 'L', 0);
$this->pdf->Cell(3, 1, '-', '0', 0, 'C', 0);
$this->pdf->SetFont('helvetica', '0', 8);
$this->pdf->Cell(25, 1,$nno, '0', 0, 'L', 0);
$this->pdf->Ln(5);
$this->pdf->SetFont('helvetica', 'B', 8);
$this->pdf->Cell(20, 1, 'Invoice No', '0', 0, 'L', 0);
$this->pdf->Cell(3, 1, '-', '0', 0, 'C', 0);
$this->pdf->SetFont('helvetica', '0', 8);
$this->pdf->Cell(25, 1,$inv_no, '0', 0, 'L', 0);
$this->pdf->SetFont('helvetica', 'B', 8);
$this->pdf->Cell(20, 1, 'ID', '0', 0, 'L', 0);
$this->pdf->Cell(3, 1, '-', '0', 0, 'C', 0);
$this->pdf->SetFont('helvetica', '', 8);
$this->pdf->Cell(65, 1,$cus_id, '0', 0, 'L', 0);
$this->pdf->SetFont('helvetica', 'B', 8);
$this->pdf->Cell(15, 1, 'Ref No', '0', 0, 'L', 0);
$this->pdf->SetFont('helvetica', '', 8);
$this->pdf->Cell(25, 1,"-".$ref_no, '0', 0, 'L', 0);
$this->pdf->Ln(5);
$this->pdf->SetFont('helvetica', 'B', 8);
$this->pdf->Cell(20, 1, 'Invoice Date', '0', 0, 'L', 0);
$this->pdf->Cell(3, 1, '-', '0', 0, 'C', 0);
$this->pdf->SetFont('helvetica', '', 8);

if($invoice_date == "0000-00-00"){
	$invoice_date = "";
}

$this->pdf->Cell(25, 1,$invoice_date, '0', 0, 'L', 0);
$this->pdf->SetFont('helvetica', 'B', 8);
$this->pdf->Cell(20, 1, 'Name', '0', 0, 'L', 0);
$this->pdf->Cell(3, 1, '-', '0', 0, 'C', 0);
$this->pdf->SetFont('helvetica', '', 8);
$this->pdf->Cell(65, 1,$cus_name, '0', 0, 'L', 0);
$this->pdf->SetFont('helvetica', 'B', 8);
$this->pdf->Cell(15, 1, 'Date', '0', 0, 'L', 0);
$this->pdf->Cell(3, 1, '-', '0', 0, 'C', 0);
$this->pdf->SetFont('helvetica', '', 8);
$this->pdf->Cell(25, 1,$ddate, '0', 0, 'L', 0);
$this->pdf->Ln(5);
$this->pdf->SetFont('helvetica', 'B', 8);
$this->pdf->Cell(20, 1, 'Job No', '0', 0, 'L', 0);
$this->pdf->Cell(3, 1, '-', '0', 0, 'C', 0);
$this->pdf->SetFont('helvetica', '', 8);
$this->pdf->Cell(25, 1,$nno, '0', 0, 'L', 0);
$this->pdf->SetFont('helvetica', 'B', 8);
$this->pdf->Cell(20, 1, 'Address', '0', 0, 'L', 0);
$this->pdf->Cell(3, 1, '-', '0', 0, 'C', 0);
$this->pdf->SetFont('helvetica', '', 8);
$this->pdf->Cell(65, 1,$address1.' '.$address2.' '.$address3, '0', 0, 'L', 0);
$this->pdf->Ln(8);
$this->pdf->SetFont('helvetica', 'B', 8);
$this->pdf->Cell(20, 1, 'Supplier', '0', 0, 'L', 0);
$this->pdf->Cell(3, 1, '-', '0', 0, 'C', 0);
$this->pdf->SetFont('helvetica', '', 8);
$this->pdf->Cell(80, 1,$sup_code ." - ".$sup_name, '0', 0, 'L', 0);
$this->pdf->Ln(7);
$this->pdf->SetFont('helvetica', 'B', 9);
$this->pdf->Cell(80, 1, 'Item', '1', 0, 'C', 0);
$this->pdf->Cell(25, 1, 'Brand', '1', 0, 'L', 0);
$this->pdf->Cell(25, 1, 'Model', '1', 0, 'L', 0);
$this->pdf->Cell(25, 1, 'Serial', '1', 0, 'L', 0);
$this->pdf->Cell(30, 1, 'Gurantee Card No', '1', 0, 'L', 0);
$this->pdf->Ln();


foreach($jobs as $item_data){
$heigh=6*(max(1,$this->pdf->getNumLines($item_data->item_code." - ".$item_data->Item_name,80)));
$this->pdf->SetFont('helvetica','',9);
$this->pdf->SetLineStyle(array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0.1, 'color' => array(0, 0, 0)));
$this->pdf->MultiCell(80, $heigh,$item_data->item_code." - ".$item_data->Item_name,1, 'L',false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
$this->pdf->MultiCell(25, $heigh,$item_data->brand_name,1, 'L',false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
$this->pdf->MultiCell(25, $heigh,$item_data->model,1, 'L',false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
$this->pdf->MultiCell(25, $heigh,$item_data->serial_no,1, 'R',false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
$this->pdf->MultiCell(30, $heigh,$item_data->gur_no,1, 'R',false, 1, '', '', true, 0, false, true, $heigh,'M' ,false);
}
$this->pdf->SetFont('helvetica', 'B', 9);
$this->pdf->Ln(5);
$this->pdf->Cell(15, 1,'Fault', '0', 0, 'L', 0);
$this->pdf->Cell(3, 1, '-', '0', 0, 'C', 0);
$this->pdf->SetFont('helvetica', '', 9);
$heigh=6*(max(1,$this->pdf->getNumLines($item_data->fault,60)));
$this->pdf->MultiCell(60, $heigh,$item_data->fault,0, 'L',false, 1, '', '', true, 0, false, true, $heigh,'M' ,false);

$this->pdf->SetFont('helvetica', 'B', 9);
$this->pdf->Cell(32, 1,'Gurantee Card No', '0', 0, 'L', 0);
$this->pdf->Cell(3, 1, '-', '0', 0, 'C', 0);
$this->pdf->SetFont('helvetica', '', 9);
$this->pdf->Cell(40, 1,$gur_no, '0', 0, 'L', 0);
$this->pdf->Ln(5);

$this->pdf->SetFont('helvetica', 'B', 9);
$this->pdf->Cell(32, 1,'Warranty Start Date', '0', 0, 'L', 0);
$this->pdf->Cell(3, 1, '-', '0', 0, 'C', 0);
$this->pdf->SetFont('helvetica', '', 9);
$w_start_dt=($w_end_dt=="0000-00-00")?"":$w_start_dt;
$this->pdf->Cell(20, 1,$w_start_dt, '0', 0, 'L', 0);	

$this->pdf->SetFont('helvetica', 'B', 9);
$this->pdf->Cell(35, 1,'Warranty Expire Date', '0', 0, 'L', 0);
$this->pdf->Cell(3, 1, '-', '0', 0, 'C', 0);
$this->pdf->SetFont('helvetica', '', 9);
$w_end_dt=($w_end_dt=="0000-00-00")?"":$w_end_dt;
$this->pdf->Cell(20, 1,$w_end_dt, '0', 0, 'L', 0);	

$this->pdf->Ln(5);
$this->pdf->SetFont('helvetica', 'B', 9);
$this->pdf->Cell(30, 1,'Amount Received', '0', 0, 'L', 0);
$this->pdf->Cell(3, 1, '-', '0', 0, 'C', 0);
$this->pdf->SetFont('helvetica', '', 9);
$item_data->advance_amount=($item_data->advance_amount=="0.00")?"":$item_data->advance_amount;
$this->pdf->Cell(30, 1,number_format($item_data->advance_amount,2), '0', 0, 'L', 0);
$this->pdf->Ln();

$this->pdf->footer_set_services($user);

$this->pdf->Output("Service Receive_".date('Y-m-d').".pdf", 'I');

?>