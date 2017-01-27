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
	$tot 		= (float)$row->paid_amount+(float)$row->rebeat_amount;

	$loan_amo	= $row->loan_amount;
	$down_pay	= $row->down_payment;
	$nofins		= $row->no_ins;
	$ins_amo	= $row->ins_amount;
	$inter_amo	= $row->int_amount;
	$adv_amo	= $row->pay_advance;

}
$grand_tot=(float)$pay_cash+$pay_cheque+$pay_ccard+$pay_cnote;

foreach($exceed as $row){
	$exceed_amount  = $row->dr;
}


$align_h=$this->utility->heading_align();
$this->pdf->setY(20);
$this->pdf->SetFont('helvetica', 'BU', 10);
$orgin_print=$_POST['org_print'];
if($orgin_print=="1"){
	$this->pdf->Cell(0, 5,'HP EARLY SETTLEMENT',0,false, $align_h, 0, '', 0, false, 'M', 'M');
}else{
	$this->pdf->Cell(0, 5,'HP  EARLY SETTLEMENT (Duplicate)',0,false, $align_h, 0, '', 0, false, 'M', 'M');	
}
$this->pdf->SetFont('helvetica', 'B', 9);
$this->pdf->setY(30);

$this->pdf->Cell(30, 4, 'Invoice No.', '0', 0, 'L', 0);
$this->pdf->Cell(80, 4, $invoice_no, '0', 0, 'L', 0);
$this->pdf->Cell(1, 4, "", '0', 0, 'L', 0);
$this->pdf->Cell(1, 4, "", '0', 0, 'L', 0);
$this->pdf->SetFont('helvetica', '', 9);
$this->pdf->Cell(30, 4, "Date", '0', 0, 'L', 0);
$this->pdf->Cell(30, 4, $date.$save_time, '0', 0, 'L', 0);
$this->pdf->Ln();

$this->pdf->SetFont('helvetica', '', 9);
$this->pdf->Cell(30, 4, 'Agreement No', '0', 0, 'L', 0);
$this->pdf->Cell(80, 4, $agr_no, '0', 0, 'L', 0);
$this->pdf->Cell(1, 4, "", '0', 0, 'L', 0);
$this->pdf->Cell(1, 4, "", '0', 0, 'L', 0);
$this->pdf->Cell(30, 4, "Ref No", '0', 0, 'L', 0);
$this->pdf->Cell(30, 4, $ref, '0', 0, 'L', 0);
$this->pdf->Ln();

$this->pdf->Cell(30, 4, 'Customer', '0', 0, 'L', 0);
$this->pdf->Cell(80, 4, $c_code." - ".$c_name, '0', 0, 'L', 0);
$this->pdf->Cell(1, 4, "", '0', 0, 'L', 0);
$this->pdf->Cell(1, 4, "", '0', 0, 'L', 0);
$this->pdf->Cell(30, 4, "", '0', 0, 'L', 0);
$this->pdf->Cell(30, 4, "", '0', 0, 'L', 0);
$this->pdf->Ln();

$this->pdf->Cell(30, 4, 'Address', '0', 0, 'L', 0);
$this->pdf->Cell(80, 4, $address, '0', 0, 'L', 0);
$this->pdf->Cell(1, 4, "", '0', 0, 'L', 0);
$this->pdf->Cell(1, 4, "", '0', 0, 'L', 0);
$this->pdf->Cell(30, 4, "", '0', 0, 'L', 0);
$this->pdf->Cell(30, 4, "", '0', 0, 'L', 0);
$this->pdf->Ln(5);

$this->pdf->SetLineStyle(array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0.1, 'color' => array(0, 0, 0)));
$this->pdf->SetFont('helvetica', 'B', 9);
$this->pdf->Cell(30, 8,"INSTALLMENT DETAILS", '0', 0, 'L', 0);
$this->pdf->Cell(5, 8,'', '0', 0, 'C', 0);
$this->pdf->Cell(15, 8, "", '0', 0, 'R', 0);
$this->pdf->Ln();

$this->pdf->SetFont('helvetica', 'B', 9);
$this->pdf->Cell(30, 3,"Loan Amount", '0', 0, 'L', 0);
$this->pdf->Cell(5, 3,':', '0', 0, 'C', 0);
$this->pdf->Cell(25, 3, $loan_amo, '0', 0, 'R', 0);
$this->pdf->Cell(5, 3,'|', '0', 0, 'C', 0);

$this->pdf->Cell(30, 3,"Down Payment", '0', 0, 'L', 0);
$this->pdf->Cell(5, 3,':', '0', 0, 'C', 0);
$this->pdf->Cell(25, 3, $down_pay, '0', 0, 'R', 0);
$this->pdf->Cell(5, 3,'|', '0', 0, 'C', 0);

$this->pdf->Cell(30, 3,"No of Installment", '0', 0, 'L', 0);
$this->pdf->Cell(5, 3,':', '0', 0, 'C', 0);
$this->pdf->Cell(15, 3, $nofins, '0', 0, 'R', 0);

$this->pdf->Ln();

$this->pdf->SetFont('helvetica', 'B', 9);
$this->pdf->Cell(30, 3,"Installment Amount", '0', 0, 'L', 0);
$this->pdf->Cell(5, 3,':', '0', 0, 'C', 0);
$this->pdf->Cell(25, 3, $ins_amo, '0', 0, 'R', 0);
$this->pdf->Cell(5, 3,'|', '0', 0, 'C', 0);

$this->pdf->Cell(30, 3,"Interest Payment", '0', 0, 'L', 0);
$this->pdf->Cell(5, 3,':', '0', 0, 'C', 0);
$this->pdf->Cell(25, 3, $inter_amo, '0', 0, 'R', 0);
$this->pdf->Cell(5, 3,'', '0', 0, 'C', 0);

$this->pdf->Cell(30, 3,"", '0', 0, 'L', 0);
$this->pdf->Cell(5, 3,'', '0', 0, 'C', 0);
$this->pdf->Cell(15, 3, "", '0', 0, 'R', 0);
$this->pdf->Ln();

$this->pdf->SetFont('helvetica', 'B', 9);
$this->pdf->Cell(30, 8,"INSTALLMENTS ", '0', 0, 'L', 0);
$this->pdf->Cell(5, 8,'', '0', 0, 'C', 0);
$this->pdf->Cell(15, 8, "", '0', 0, 'R', 0);
$this->pdf->Ln();

$this->pdf->Cell(10, 6,"No", '1', 0, 'C', 0);
$this->pdf->Cell(10, 6,'Ins No', '1', 0, 'C', 0);
$this->pdf->Cell(30, 6,'Type', '1', 0, 'C', 0);
$this->pdf->Cell(20, 6,'Date', '1', 0, 'C', 0);
$this->pdf->Cell(25, 6,"Amount", '1', 0, 'C', 0);
$this->pdf->Cell(25, 6,'Balance', '1', 0, 'C', 0);
$this->pdf->Cell(25, 6,'Rebate', '1', 0, 'C', 0);
$this->pdf->Cell(25, 6,'Paid', '1', 0, 'C', 0);
$this->pdf->Cell(25, 6,'To Settle', '1', 0, 'C', 0);

$tot = 0;
$bal =0;
$this->pdf->Ln();
$this->pdf->SetFont('helvetica', '', 9);
foreach ($det as $row){

$heigh=6*(max(1,$this->pdf->getNumLines($row->description,30)));
$this->pdf->HaveMorePages($heigh);
$this->pdf->SetLineStyle(array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0.1, 'color' => array(0, 0, 0)));
$this->pdf->MultiCell(10, $heigh,$row->nno,1, 'R',false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
$this->pdf->MultiCell(10, $heigh,$row->ins_no,1, 'R',false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
$this->pdf->MultiCell(30, $heigh,$row->description,1, 'L',false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
$this->pdf->MultiCell(20, $heigh,$row->date,1, 'L',false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
$this->pdf->MultiCell(25, $heigh,number_format($row->amount,2),1, 'R',false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
$this->pdf->MultiCell(25, $heigh,number_format($row->balance,2),1, 'R',false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
$this->pdf->MultiCell(25, $heigh,number_format($row->rebate,2),1, 'R',false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
$this->pdf->MultiCell(25, $heigh,number_format($row->paid,2),1, 'R',false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
$this->pdf->MultiCell(25, $heigh,number_format($row->balance,2),1, 'R',false, 1, '', '', true, 0, false, true, $heigh,'M' ,false);
$tot+=$row->paid;
$bal+=$row->balance;
}
$this->pdf->SetFont('helvetica', 'B', 9);
$this->pdf->Cell(145, 4, 'Total', '0', 0, 'R', 0);
$this->pdf->Cell(25, 4, number_format($tot,2), '1', 0, 'R', 0);
$this->pdf->Cell(25, 4, number_format($bal,2), '1', 0, 'R', 0);




$this->pdf->SetFont('helvetica', '', 9);

if($pay_cash!="0.00"){
	$this->pdf->Ln();
	$this->pdf->SetFont('helvetica', '', 9);
	$this->pdf->Cell(25, 4, 'Cash', '1', 0, 'L', 0);
	$this->pdf->SetFont('helvetica', 'B', 9);
	$this->pdf->Cell(30, 4, number_format($pay_cash,2), '1', 0, 'R', 0);
}

if($re_amount!="0.00"){
	$this->pdf->Ln();
	$this->pdf->SetFont('helvetica', '', 9);
	$this->pdf->Cell(25, 4, 'Rebeat Amount', '1', 0, 'L', 0);
	$this->pdf->SetFont('helvetica', 'B', 9);
	$this->pdf->Cell(30, 4, number_format($re_amount,2), '1', 0, 'R', 0);
}

if($pay_cheque!="0.00"){
	$this->pdf->Ln();
	$this->pdf->SetFont('helvetica', '', 9);
	$this->pdf->Cell(25, 4, 'Cheque', '1', 0, 'L', 0);
	$this->pdf->SetFont('helvetica', 'B', 9);
	$this->pdf->Cell(30, 4, number_format($pay_cheque,2), '1', 0, 'R', 0);
}

if($pay_ccard!="0.00"){
	$this->pdf->Ln();
	$this->pdf->SetFont('helvetica', '', 9);
	$this->pdf->Cell(25, 4, 'Credit Card', '1', 0, 'L', 0);
	$this->pdf->SetFont('helvetica', 'B', 9);
	$this->pdf->Cell(30, 4, number_format($pay_ccard,2), '1', 0, 'R', 0);
}

if($pay_cnote!="0.00"){
	$this->pdf->Ln();
	$this->pdf->SetFont('helvetica', '', 9);
	$this->pdf->Cell(25, 4, 'Credit Note', '1', 0, 'L', 0);
	$this->pdf->SetFont('helvetica', 'B', 9);
	$this->pdf->Cell(30, 4, number_format($pay_cnote ,2), '1', 0, 'R', 0);
}
$this->pdf->Ln();
$this->pdf->SetFont('helvetica', 'B', 9);
$this->pdf->Cell(25, 4, 'Total', '1', 0, 'L', 0);
$this->pdf->Cell(30, 4, number_format($grand_tot,2), '1', 0, 'R', 0);

$this->pdf->Ln();
$this->pdf->Ln();
$this->pdf->SetFont('helvetica', '', 9);
$this->pdf->Cell(30, 1, 'Amount in word : ', '0', 0, 'L', 0);
$this->pdf->SetFont('helvetica', 'B', 9);
$this->pdf->Cell(30, 1, $rec, '0', 0, 'L', 0);

$this->pdf->Ln();
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