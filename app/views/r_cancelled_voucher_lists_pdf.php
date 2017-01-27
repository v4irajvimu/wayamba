<?php
error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
$this->pdf->setPrintHeader($header,$type,$duration);
$this->pdf->setPrintFooter(true);
$this->pdf->SetFont('helvetica', 'B', 16);
$this->pdf->AddPage($orientation,$page);   // L or P amd page type A4 or A3

foreach($branch as $ress){
$this->pdf->headerSet3($ress->name,$ress->address,$ress->tp,$ress->fax,$ress->email);
}


$this->pdf->SetLineStyle(array('width' => 0.25, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0)));

$this->pdf->setY(22);$this->pdf->SetFont('helvetica', 'BI',12);
$this->pdf->Cell(0, 5, 'Cancelled Voucher List - (Supplier Payment)	 ',0,false, 'L', 0, '', 0, false, 'M', 'M');
$this->pdf->Ln();
$this->pdf->setY(25);$this->pdf->Cell(60, 1,"",'T',0, 'L', 0);
$this->pdf->Ln(); 
$this->pdf->SetFont('helvetica', '',10);
$this->pdf->Cell(0, 5, 'Date   From '. $dfrom.' To '.$dto ,0,false, 'L', 0, '', 0, false, 'M', 'M');
$this->pdf->Ln();

$this->pdf->Ln();
$this->pdf->Ln();

foreach($r_branch_name as $row){
	$branch_name=$row->name;
	$cluster_name=$row->description;
	$cl_id=$row->code;
	$bc_id=$row->bc;
}

$this->pdf->SetX(20);
$this->pdf->setY(28);$this->pdf->SetFont('helvetica', '', 8);
$this->pdf->Ln();
$this->pdf->Cell(30, 6,'Cluster', '0', 0, 'L', 0);
$this->pdf->Cell(5, 6,':', '0', 0, 'L', 0);
$this->pdf->Cell(120, 6,"$cl_id - $cluster_name", '0', 0, 'L', 0);
$this->pdf->Ln();

$this->pdf->Cell(30, 6,'Branch', '0', 0, 'L', 0);
$this->pdf->Cell(5, 6,':', '0', 0, 'L', 0);
$this->pdf->Cell(20, 6,"$bc_id - $branch_name", '0', 0, 'L', 0);
$this->pdf->Ln();

if($acc!=""){
	$this->pdf->SetFont('helvetica', '', 8);
	$this->pdf->Cell(30, 6,'Supplier', '0', 0, 'L', 0);
	$this->pdf->Cell(5, 6,':', '0', 0, 'L', 0);
	$this->pdf->Cell(55, 6,$acc."  -  ".$acc_des, '0', 0, 'L', 0);
	$this->pdf->Ln();
}

if($t_no_from!=""){
	$this->pdf->SetFont('helvetica', '', 8);
	$this->pdf->Cell(30, 6,'Transaction Range     ', '0', 0, 'L', 0);
	$this->pdf->Cell(5, 6,':', '0', 0, 'L', 0);
	$this->pdf->Cell(15, 6,"From  -  ".$t_no_from, '0', 0, 'L', 0);
}

if($t_no_to!=""){
	$this->pdf->Cell(25, 6,"To  -  ".$t_no_to, '0', 0, 'L', 0);
	$this->pdf->Ln(); 
}

$this->pdf->SetFont('helvetica','B',10);
$this->pdf->Cell(20, 6,"Date", '1', 0, 'C', 0);
$this->pdf->Cell(25, 6,"Voucher No", '1', 0, 'C', 0);
$this->pdf->Cell(60, 6,"Description", '1', 0, 'C', 0);
$this->pdf->Cell(30, 6,"Cach", '1', 0, 'C', 0);
$this->pdf->Cell(30, 6,"Cheque", '1', 0, 'C', 0);
$this->pdf->Cell(25, 6,"Credit Card", '1', 0, 'C', 0);
$this->pdf->Cell(25, 6,"Debit Note", '1', 0, 'C', 0);
$this->pdf->Cell(25, 6,"Discount", '1', 0, 'C', 0);
$this->pdf->Cell(30, 6,"Total Settlement", '1', 0, 'C', 0);
$this->pdf->Ln();


foreach ($sum as $value) {	
	$this->pdf->SetX(15);
	$this->pdf->SetLineStyle(array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0.1, 'color' => array(0, 0, 0)));
	$this->pdf->SetFont('helvetica','',9);
	$bb=$this->pdf->getNumLines($value->memo, 60); 
	$heigh=6*$bb;

	$this->pdf->MultiCell(20, $heigh, $value->ddate, 1, 'R', 0, 0, '', '', true, 0, false, true, 0);
	$this->pdf->MultiCell(25, $heigh, $value->nno, 1, 'R', 0, 0, '', '', true, 0, false, true, 0);
	$this->pdf->MultiCell(60, $heigh, $value->memo, 1, 'L', 0, 0, '', '', true, 0, false, true, 0);
	$this->pdf->MultiCell(30, $heigh, number_format($value->pay_cash,2), 1, 'R', 0, 0, '', '', true, 0, false, true, 0);
	$this->pdf->MultiCell(30, $heigh, number_format($value->pay_issue_chq,2), 1, 'R', 0, 0, '', '', true, 0, false, true, 0);
	$this->pdf->MultiCell(25, $heigh, number_format($value->pay_credit,2), 1, 'R', 0, 0, '', '', true, 0, false, true, 0);
	$this->pdf->MultiCell(25, $heigh, number_format($value->pay_dnote,2), 1, 'R', 0, 0, '', '', true, 0, false, true, 0);
	$this->pdf->MultiCell(25, $heigh, number_format($value->discount,2), 1, 'R', 0, 0, '', '', true, 0, false, true, 0);
	$this->pdf->MultiCell(30, $heigh, number_format($value->settle_amount,2), 1, 'R', 0, 1, '', '', true, 0, false, true, 0);

	$cash+=$value->pay_cash;
	$cheque+=$value->pay_issue_chq;
	$credit+=$value->pay_credit;
	$dnote+=$value->pay_dnote;
	$discount+=$value->discount;
	$amt+=$value->settle_amount;                   	
}

$this->pdf->SetX(15);
$this->pdf->SetLineStyle(array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0.1, 'color' => array(0, 0, 0)));
$this->pdf->SetFont('helvetica','B',10);
$this->pdf->Cell(20, 6,"", '0', 0, 'R', 0);
$this->pdf->Cell(25, 6,"", '0', 0, 'L', 0);
$this->pdf->Cell(60, 6,"Total", '0', 0, 'C', 0);
$this->pdf->SetLineStyle(array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0.1, 'color' => array(0, 0, 0)));
$this->pdf->SetFont('helvetica','B',9);
$this->pdf->Cell(30, 6, number_format($cash,2), '1', 0, 'R', 0);
$this->pdf->Cell(30, 6, number_format($cheque,2),'1', 0, 'R', 0);
$this->pdf->Cell(25, 6, number_format($credit,2), '1', 0, 'R', 0);
$this->pdf->Cell(25, 6, number_format($dnote,2), '1', 0, 'R', 0);
$this->pdf->Cell(25, 6, number_format($discount,2), '1', 0, 'R', 0);
$this->pdf->Cell(30, 6, number_format($amt,2), '1', 0, 'R', 0);
$this->pdf->Output("Cancelled Voucher List-Supplier Payment".date('Y-m-d').".pdf", 'I');

?>