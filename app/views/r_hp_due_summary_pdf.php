<?php
error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
$this->pdf->setPrintHeader($header,$type,$duration);
$this->pdf->setPrintFooter(true);
$this->pdf->SetFont('helvetica', 'B', 16);
$this->pdf->AddPage($orientation,$page);   // L or P amd page type A4 or A3

foreach($branch as $ress){
	$this->pdf->headerSet3($ress->name,$ress->address,$ress->tp,$ress->fax,$ress->email);
}

$this->pdf->setY(22);

$this->pdf->SetFont('helvetica', 'BU',10);
$this->pdf->Cell(0, 5, 'HP DUE SUMMARY',0,false, 'C', 0, '', 0, false, 'M', 'M');
$this->pdf->Ln();$this->pdf->Ln();

$this->pdf->SetFont('helvetica', 'B',8);
$this->pdf->Cell(20, 6,'Date Between ', '0', 0, 'L', 0);
$this->pdf->SetFont('helvetica', '',8);
$this->pdf->Cell(40, 6,$dfrom.' And '.$dto , '0', 0, 'L', 0);
$this->pdf->Cell(40, 6,"", '0', 0, 'L', 0);

if($agreemnt_no!=""){
	$this->pdf->SetFont('helvetica', 'B',8);
	$this->pdf->Cell(25, 6,'Agreenment No ', '0', 0, 'L', 0);
	$this->pdf->SetFont('helvetica', '',8);
	$this->pdf->Cell(40, 6, $agreemnt_no , '0', 0, 'L', 0);
}
$this->pdf->Ln();


if($customer!=""){
	$this->pdf->SetFont('helvetica', 'B',8);
	$this->pdf->Cell(20, 6,'Customer ', '0', 0, 'L', 0);
	$this->pdf->SetFont('helvetica', '',8);
	$this->pdf->Cell(40, 6,$customer.' - '.$cus_name , '0', 0, 'L', 0);
	$this->pdf->Cell(40, 6,"", '0', 0, 'L', 0);
}

if($salesman!=""){
	$this->pdf->SetFont('helvetica', 'B',8);
	$this->pdf->Cell(20, 6,'Salesman ', '0', 0, 'L', 0);
	$this->pdf->SetFont('helvetica', '',8);
	$this->pdf->Cell(40, 6,$salesman.' - '.$s_name , '0', 0, 'L', 0);
}
$this->pdf->Ln();

$this->pdf->Ln();

$this->pdf->SetX(10);
$this->pdf->SetFont('helvetica','B',8);
$this->pdf->Cell(15, 6,"No", '1', 0, 'C', 0);
$this->pdf->Cell(20, 6,"Due Date", '1', 0, 'C', 0);
$this->pdf->Cell(25, 6,"Agr No", '1', 0, 'C', 0);
$this->pdf->Cell(68, 6,"Customer", '1', 0, 'C', 0);
$this->pdf->Cell(22, 6,"CR Amount", '1', 0, 'C', 0);
$this->pdf->Cell(22, 6,"DR Amount", '1', 0, 'C', 0);
$this->pdf->Cell(22, 6,"Balance", '1', 0, 'C', 0);

$this->pdf->Ln();
$t_dr=$t_cr=$t_bal=(float)0;


foreach ($result as $row) {
	$this->pdf->SetX(10);
	$this->pdf->SetLineStyle(array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0.1, 'color' => array(0, 0, 0)));
	$this->pdf->SetFont('helvetica','',8);
	$heigh=6*(max(1,$this->pdf->getNumLines($row->customer,68)));

	$this->pdf->MultiCell(15, $heigh,$row->nno,1, 'R',false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
	$this->pdf->MultiCell(20, $heigh,$row->due_date,1, 'L',false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
	$this->pdf->MultiCell(25, $heigh,$row->agreement_no,1, 'L',false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
	$this->pdf->MultiCell(68, $heigh,$row->customer,1, 'L',false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
	$this->pdf->MultiCell(22, $heigh,number_format($row->dr,2),1, 'R',false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
	$this->pdf->MultiCell(22, $heigh,number_format($row->cr,2),1, 'R',false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
	$this->pdf->MultiCell(22, $heigh,number_format($row->balance,2),1, 'R',false, 1, '', '', true, 0, false, true, $heigh,'M' ,false);

	$t_dr+=(float)$row->dr;
	$t_cr+=(float)$row->cr;
	$t_bal+=(float)$row->balance;
	$this->pdf->HaveMorePages($heigh);

}

$this->pdf->Ln();

$this->pdf->SetFont('helvetica','B',8);
$this->pdf->SetX(10);
$this->pdf->Cell(15, 6,"", '0', 0, 'L', 0);
$this->pdf->Cell(20, 6,"", '0', 0, 'L', 0);
$this->pdf->Cell(25, 6,"", '0', 0, 'L', 0);
$this->pdf->Cell(68, 6,"Total ", '0', 0, 'R', 0);
$this->pdf->Cell(22, 6,number_format($t_dr,2), 'TB', 0, 'R', 0);
$this->pdf->Cell(1, 6,"", '0', 0, 'R', 0);
$this->pdf->Cell(21, 6,number_format($t_cr,2), 'TB', 0, 'R', 0);
$this->pdf->Cell(1, 6,"", '0', 0, 'R', 0);
$this->pdf->Cell(22, 6,number_format($t_bal,2), 'TB', 0, 'R', 0);
$this->pdf->Cell(22, 6,"", '0', 0, 'R', 0);

$this->pdf->Output("Sale Return Summary 02".date('Y-m-d').".pdf", 'I');

?>