<?php error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);

$this->pdf->setPrintFooter(true,'0',$is_cur_time);
$this->pdf->setPrintHeader(true);

$this->pdf->SetFont('helvetica', 'B', 16);
$this->pdf->AddPage($orientation,$page);   // L or P amd page type A4 or A3
foreach($branch as $ress){
	$this->pdf->headerSet4($ress->name,$ress->address,$ress->tp,$ress->fax,$ress->email);
}

foreach ($items as  $value) {
	$agr_no = $value->agreement_no;
	$date = $value->ddate;
	$cus_name = $value->cus_name;
	$tp=$value->tp; 
	$addres1 =$value->address1;
	$addres2=$value->address2;
	$addres3=$value->address3;
	$nic =$value->nic;
}


foreach ($gurantor as  $value) {
	$g1_name = $value ->gur1_name;
	$g1_tp =$value->gur1_tp;
	$g1_addr1 =$value->gur1_addr1;
	$g1_addr2 =$value->gur1_addr2;
	$g1_addr3 =$value->gur1_addr3;

	$g2_name =$value->gur2_name;
	$g2_tp =$value->gur2_tp;
	$g2_addr1 =$value->gur2_addr1;
	$g2_addr2 =$value->gur2_addr2;
	$g2_addr3 =$value->gur2_addr3;
}


$this->pdf->Ln();

$fontname = $this->pdf->addTTFfont('fonts/Maya.ttf', 'TrueTypeUnicode', '', 96);

$this->pdf->SetFont($fontname, '', 12);
$this->pdf->Cell(70, 1, '', '0', 0,'C', 0);
$this->pdf->Cell(30, 1, 'gf¦s<» p&kAVy', 'B', 0,'C', 0);

$this->pdf->Ln();
$this->pdf->Ln();
$this->pdf->SetFont('helvetica', 'B', 8);
$this->pdf->Cell(25, 4, 'Agreement No', '0', 0,'C', 0);
$this->pdf->Cell(3, 4, '-', '', 0,'C', 0);
$this->pdf->SetFont('helvetica', '', 8);
$this->pdf->Cell(30, 4, $agr_no, '0', 0,'C', 0);
$this->pdf->Cell(85, 4, '', '0', 0,'C', 0);
$this->pdf->SetFont('helvetica', 'B', 8);
$this->pdf->Cell(15, 4, 'Date', '0', 0,'L', 0);
$this->pdf->Cell(3, 4, '-', '', 0,'C', 0);
$this->pdf->SetFont('helvetica', '', 8);
$this->pdf->Cell(25, 4, $date, '0', 0,'C', 0);
$this->pdf->Ln();
$this->pdf->Cell(143, 4, '', '0', 0,'C', 0);
$this->pdf->SetFont('helvetica', 'B', 8);
$this->pdf->Cell(15, 4, 'Time', '0', 0,'L', 0);
$this->pdf->Cell(3, 4, '-', '', 0,'C', 0);
$this->pdf->Cell(25, 4, '', '0', 0,'C', 0);
$this->pdf->Ln(10);

$this->pdf->Cell(15, 4, 'Sr No', '1', 0,'C', 0);
$this->pdf->Cell(40, 4, 'Item Code', '1', 0,'C', 0);
$this->pdf->Cell(131, 4, 'Description', '1', 0,'C', 0);
$this->pdf->Ln();
$this->pdf->SetFont('helvetica', '', 8);

$x =1;

foreach($items as $row){
	$heigh=6*(max(1,$this->pdf->getNumLines($row->description,131)));
	$this->pdf->HaveMorePages($heigh);
	$this->pdf->SetLineStyle(array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0.1, 'color' => array(0, 0, 0)));

	$this->pdf->MultiCell(15, $heigh,$x,1, 'R',false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
	$this->pdf->MultiCell(40, $heigh,$row->item_code,1, 'L',false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
	$this->pdf->MultiCell(131, $heigh,$row->description,1, 'L',false, 1, '', '', true, 0, false, true, $heigh,'M' ,false);

	$x+=1;
}


$this->pdf->SetFont($fontname, 'B', 9);

$heigha=6*(max(1,$this->pdf->getNumLines($agreement,186)));
$this->pdf->HaveMorePages($heigha);
$this->pdf->MultiCell(186, $heigha,$agreement,'0', 'L',false,1, '', '', true, 0, false, true, $heigha,'M' ,false);

$this->pdf->SetFont($fontname, 'B', 9);

$this->pdf->SetLineStyle(array('width' => 0.2, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0.1, 'color' => array(0, 0, 0)));

$this->pdf->Cell(40, 4, 'nm', '1', 0,'C', 0);
$this->pdf->Cell(56, 4, 'lfpfny', '1', 0,'C', 0);
$this->pdf->Cell(30, 4, 'jA.h[.a^ky', '1', 0,'C', 0);
$this->pdf->Cell(30, 4, 'z<rkTn a^ky', '1', 0,'C', 0);
$this->pdf->Cell(30, 4, 'at!sn', '1', 0,'C', 0);
$this->pdf->Ln();
$this->pdf->SetFont('helvetica', '', 8);

$this->pdf->SetLineStyle(array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0.1, 'color' => array(0, 0, 0)));

$heigh=6*(max(1,$this->pdf->getNumLines($cus_name,40),$this->pdf->getNumLines($addres1." ".$addres2." ".$addres3,56)));
$this->pdf->HaveMorePages($heigh);
$this->pdf->MultiCell(40, $heigh,$cus_name,1, 'L',false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
$this->pdf->MultiCell(56, $heigh,$addres1." ".$addres2." ".$addres3,1, 'L',false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
$this->pdf->MultiCell(30, $heigh,$nic,1, 'L',false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
$this->pdf->MultiCell(30, $heigh,$tp,1, 'L',false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
$this->pdf->MultiCell(30, $heigh,"",1, 'L',false, 1, '', '', true, 0, false, true, $heigh,'M' ,false);

$heigh1=6*(max(1,$this->pdf->getNumLines($g1_name,40),$this->pdf->getNumLines($g1_addr1." ".$g1_addr2." ".$g1_addr3,56)));
$this->pdf->HaveMorePages($heigh1);
$this->pdf->MultiCell(40, $heigh1,$g1_name,1, 'L',false, 0, '', '', true, 0, false, true, $heigh1,'M' ,false);
$this->pdf->MultiCell(56, $heigh1,$g1_addr1." ".$g1_addr2." ".$g1_addr3,1, 'L',false, 0, '', '', true, 0, false, true, $heigh1,'M' ,false);
$this->pdf->MultiCell(30, $heigh1,"",1, 'L',false, 0, '', '', true, 0, false, true, $heigh1,'M' ,false);
$this->pdf->MultiCell(30, $heigh1,$g1_tp,1, 'L',false, 0, '', '', true, 0, false, true, $heigh1,'M' ,false);
$this->pdf->MultiCell(30, $heigh1,"",1, 'L',false, 1, '', '', true, 0, false, true, $heigh1,'M' ,false);

$heigh2=6*(max(1,$this->pdf->getNumLines($g2_name,40),$this->pdf->getNumLines($g2_addr1." ".$g2_addr2." ".$g2_addr3,56)));
$this->pdf->HaveMorePages($heigh2);

$this->pdf->MultiCell(40, $heigh2,$g2_name,1, 'L',false, 0, '', '', true, 0, false, true, $heigh2,'M' ,false);
$this->pdf->MultiCell(56, $heigh2,$g2_addr1." ".$g2_addr2." ".$g2_addr3,1, 'L',false, 0, '', '', true, 0, false, true, $heigh2,'M' ,false);
$this->pdf->MultiCell(30, $heigh2,"",1, 'L',false, 0, '', '', true, 0, false, true, $heigh2,'M' ,false);
$this->pdf->MultiCell(30, $heigh2,$g2_tp,1, 'L',false, 0, '', '', true, 0, false, true, $heigh2,'M' ,false);
$this->pdf->MultiCell(30, $heigh2,"",1, 'L',false, 1, '', '', true, 0, false, true, $heigh2,'M' ,false);

$this->pdf->Output("hire_purchase_aggreement".date('Y-m-d').".pdf", 'I');

?>