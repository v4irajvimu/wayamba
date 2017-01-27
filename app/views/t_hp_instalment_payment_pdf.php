<?php
error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
//$this->pdf->setPrintHeader($header,$type,$duration);

$this->pdf->setPrintFooter(true,'0',$is_cur_time);
$this->pdf->setPrintHeader(true);
$this->pdf->setPrintHeader($header,$type); 
$this->pdf->SetFont('helvetica', 'B', 16);
$this->pdf->AddPage($orientation,$page);   // L or P amd page type A4 or A3

foreach($branch as $ress){
	$this->pdf->headerSet4($ress->name,$ress->address,$ress->tp,$ress->fax,$ress->email);
}

foreach($session as $ses){
	$invoice_no=$session[0].$session[1].'CA'.$session[2];
}

foreach($sum as $row){
	$date   	= $row->ddate;
	$agr_no		= $row->agr_no;
	$ref 		= $row->ref_no;
	$c_code 	= $row->customer;	
	$c_name 	= $row->name;
	$inv 		= $row->inv_no;
	$address	= $row->address;
	$des 		= $row->description;
	$pay_cash	= $row->pay_cash;
	$pay_cheque = $row->pay_cheque;
	$pay_ccard  = $row->pay_ccard;
	$pay_cnote  = $row->pay_cnote;
	$re_amount  = $row->rebeat_amount;

	$officer  	= $row->collection_officer;
	$officer_des= $row->emp_des;

	$tot 		= (float)$row->paid_amount+(float)$row->rebeat_amount;
}

foreach($exceed as $row){
	$exceed_amount  = $row->dr;
}


$align_h=$this->utility->heading_align();
$this->pdf->setY(20);
$this->pdf->SetFont('helvetica', 'BU', 10);
$orgin_print=$_POST['org_print'];
if($orgin_print=="1"){
	$this->pdf->Cell(0, 5,'HP INSTALLMENT PAYMENT',0,false, $align_h, 0, '', 0, false, 'M', 'M');
}else{
	$this->pdf->Cell(0, 5,'HP INSTALLMENT PAYMENT (Duplicate)',0,false, $align_h, 0, '', 0, false, 'M', 'M');	
}
$this->pdf->SetFont('helvetica', 'B', 9);
$this->pdf->setY(30);

$this->pdf->Cell(30, 1, 'Invoice No.', '0', 0, 'L', 0);
$this->pdf->Cell(80, 1, $invoice_no, '0', 0, 'L', 0);
$this->pdf->Cell(1, 1, "", '0', 0, 'L', 0);
$this->pdf->Cell(1, 1, "", '0', 0, 'L', 0);
$this->pdf->SetFont('helvetica', '', 9);
$this->pdf->Cell(30, 1, "Date", '0', 0, 'L', 0);
$this->pdf->Cell(30, 1, $date.$save_time, '0', 0, 'L', 0);
$this->pdf->Ln();

$this->pdf->SetFont('helvetica', '', 9);
$this->pdf->Cell(30, 1, 'Agreement No', '0', 0, 'L', 0);
$this->pdf->Cell(80, 1, $agr_no, '0', 0, 'L', 0);
$this->pdf->Cell(1, 1, "", '0', 0, 'L', 0);
$this->pdf->Cell(1, 1, "", '0', 0, 'L', 0);
$this->pdf->Cell(30, 1, "Ref No", '0', 0, 'L', 0);
$this->pdf->Cell(30, 1, $ref, '0', 0, 'L', 0);
$this->pdf->Ln();

$this->pdf->Cell(30, 1, 'Customer', '0', 0, 'L', 0);
$this->pdf->Cell(80, 1, $c_code." - ".$c_name, '0', 0, 'L', 0);
$this->pdf->Cell(1, 1, "", '0', 0, 'L', 0);
$this->pdf->Cell(1, 1, "", '0', 0, 'L', 0);
$this->pdf->Cell(30, 1, "Inv No", '0', 0, 'L', 0);
$this->pdf->Cell(30, 1, $inv, '0', 0, 'L', 0);
$this->pdf->Ln();

$this->pdf->Cell(30, 1, 'Address', '0', 0, 'L', 0);
$this->pdf->Cell(80, 1, $address, '0', 0, 'L', 0);
$this->pdf->Cell(1, 1, "", '0', 0, 'L', 0);
$this->pdf->Cell(1, 1, "", '0', 0, 'L', 0);
$this->pdf->Cell(30, 1, "", '0', 0, 'L', 0);
$this->pdf->Cell(30, 1, "", '0', 0, 'L', 0);

$this->pdf->Ln();
$this->pdf->Cell(30, 1, 'Description', '0', 0, 'L', 0);
$this->pdf->Cell(80, 1, $des, '0', 0, 'L', 0);
$this->pdf->Cell(1, 1, "", '0', 0, 'L', 0);
$this->pdf->Cell(1, 1, "", '0', 0, 'L', 0);
$this->pdf->Cell(30, 1, "", '0', 0, 'L', 0);
$this->pdf->Cell(30, 1, "", '0', 0, 'L', 0);

foreach($item_det as $a){

	$this->pdf->Ln();
	$this->pdf->MultiCell(30, $heigh,'Item Details',0, 'L',false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
	$this->pdf->MultiCell(160, $heigh,$a->description,0, 'L',false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);

}

$this->pdf->Ln();
$this->pdf->Ln();
$this->pdf->SetLineStyle(array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0.1, 'color' => array(0, 0, 0)));

foreach($types as $r){
	$this->pdf->SetFont('helvetica', 'B', 9);
	$this->pdf->Cell(30, 1,$r->description, '0', 0, 'L', 0);
	$this->pdf->Cell(10, 1,':', '0', 0, 'C', 0);
	$this->pdf->Cell(20, 1, number_format($r->paid,2), '0', 0, 'R', 0);
	$this->pdf->Ln();
}

if($exceed_amount > 0){
	$this->pdf->SetFont('helvetica', 'B', 9);
	$this->pdf->Cell(30, 1,"OVER PAYMENT", '0', 0, 'L', 0);
	$this->pdf->Cell(10, 1,':', '0', 0, 'C', 0);
	$this->pdf->Cell(20, 1, number_format($exceed_amount,2), '0', 0, 'R', 0);
}



$this->pdf->Ln();
$this->pdf->Ln();
$this->pdf->SetFont('helvetica', '', 9);
$this->pdf->Cell(30, 1, 'Cash', '1', 0, 'L', 0);
$this->pdf->SetFont('helvetica', 'B', 9);
$this->pdf->Cell(30, 1, number_format($pay_cash,2), '1', 0, 'R', 0);

if($re_amount!="0.00"){
	$this->pdf->Ln();
	$this->pdf->SetFont('helvetica', '', 9);
	$this->pdf->Cell(30, 4, 'Rebeat Amount', '1', 0, 'L', 0);
	$this->pdf->SetFont('helvetica', 'B', 9);
	$this->pdf->Cell(30, 4, number_format($re_amount,2), '1', 0, 'R', 0);
}

if($pay_cheque!="0.00"){
	$this->pdf->Ln();
	$this->pdf->SetFont('helvetica', '', 9);
	$this->pdf->Cell(30, 4, 'Cheque', '1', 0, 'L', 0);
	$this->pdf->SetFont('helvetica', 'B', 9);
	$this->pdf->Cell(30, 4, number_format($pay_cheque,2), '1', 0, 'R', 0);
}

if($pay_ccard!="0.00"){
	$this->pdf->Ln();
	$this->pdf->SetFont('helvetica', '', 9);
	$this->pdf->Cell(30, 4, 'Credit Card', '1', 0, 'L', 0);
	$this->pdf->SetFont('helvetica', 'B', 9);
	$this->pdf->Cell(30, 4, number_format($pay_ccard,2), '1', 0, 'R', 0);
}

if($pay_cnote!="0.00"){
	$this->pdf->Ln();
	$this->pdf->SetFont('helvetica', '', 9);
	$this->pdf->Cell(30, 4, 'Credit Note', '1', 0, 'L', 0);
	$this->pdf->SetFont('helvetica', 'B', 9);
	$this->pdf->Cell(30, 4, number_format($pay_cnote,2), '1', 0, 'R', 0);
}

$this->pdf->Ln();
$this->pdf->SetFont('helvetica', '', 9);
$this->pdf->Cell(30, 4, 'Total Settled', '1', 0, 'L', 0);
$this->pdf->SetFont('helvetica', 'B', 9);
$this->pdf->Cell(30, 4, number_format($tot,2), '1', 0, 'R', 0);

$this->pdf->Ln();
$this->pdf->Ln();
$this->pdf->SetFont('helvetica', '', 9);
$this->pdf->Cell(30, 1, 'Amount in word : ', '0', 0, 'L', 0);
$this->pdf->SetFont('helvetica', 'B', 9);
$this->pdf->Cell(30, 1, $rec, '0', 0, 'L', 0);

$this->pdf->Ln();
$this->pdf->Ln();


$bal_to_pay = (float)$pay_balance;
$this->pdf->SetFont('helvetica', 'B', 10);
$this->pdf->Cell(70, 1, "Balance To Be Pay. ".number_format($bal_to_pay,2), '0', 0, 'L', 0);
$this->pdf->Ln();

$this->pdf->Ln();
$this->pdf->SetFont('helvetica', 'B', 9);
$this->pdf->Cell(17, 4, 'Officer - ', '0', 0, 'L', 0);
$this->pdf->SetFont('helvetica', '', 9);
$this->pdf->Cell(30, 4, $officer."  (".$officer_des.")", '0', 0, 'L', 0);
$this->pdf->Ln();

$this->pdf->SetFont('helvetica', '', 9);
$this->pdf->Ln();


$this->pdf->Cell(30, 1, ".....................................", '0', 0, 'L', 0);
$this->pdf->Cell(45, 1, "", '0', 0, 'L', 0);
$this->pdf->Cell(30, 1, "......................................", '0', 0, 'L', 0);
$this->pdf->Cell(15, 1, "", '0', 0, 'L', 0);
$this->pdf->Cell(30, 1, "", '0', 0, 'L', 0);
$this->pdf->Cell(30, 1, "......................................", '0', 0, 'L', 0);
	

$this->pdf->Ln();


$this->pdf->Cell(30, 1, "Authorized Signature", '0', 0, 'C', 0);
$this->pdf->Cell(45, 1, "", '0', 0, 'L', 0);
$this->pdf->Cell(30, 1, "Cashier Signature", '0', 0, 'C', 0);
$this->pdf->Cell(15, 1, "", '0', 0, 'L', 0);
$this->pdf->Cell(30, 1, "", '0', 0, 'L', 0);
$this->pdf->Cell(30, 1, "Customer Signature", '0', 0, 'C', 0);

//$this->pdf->footer_set_cash_sales($employee,$amount,$additional,$discount,$user,$credit_card,$tot_free_item,$cheque_detail,$credit_card_sum,$other1,$other2,$additional_tot);
$this->pdf->Output("HP installment payment_".date('Y-m-d').".pdf", 'I');

?>