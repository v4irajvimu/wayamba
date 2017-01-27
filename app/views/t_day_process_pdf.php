<?php
error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
$this->pdf->setPrintFooter(true,'0',$is_cur_time);
$this->pdf->setPrintHeader(true);
$this->pdf->setPrintHeader($header,$type); 
$this->pdf->SetFont('helvetica', 'B', 16);
$this->pdf->AddPage($orientation,$page);   // L or P amd page type A4 or A3

foreach($branch as $ress){
	$this->pdf->headerSet4($ress->name,$ress->address,$ress->tp,$ress->fax,$ress->email);
}

$this->pdf->setY(18);
$align_h=$this->utility->heading_align();

$this->pdf->SetFont('helvetica', 'BU', 10);
$orgin_print=$_POST['org_print'];
if($orgin_print=="1"){
$this->pdf->Cell(0, 5,' DAY PROCESS',0,false, $align_h, 0, '', 0, false, 'M', 'M');
}else{
$this->pdf->Cell(0, 5,' DAY PROCESS (DUPLICATE)',0,false, $align_h, 0, '', 0, false, 'M', 'M');	
}
$this->pdf->SetFont('helvetica', 'B', 10);
$this->pdf->setY(20);

$this->pdf->Cell(30, 1, 'No.', '0', 0, 'L', 0);
$this->pdf->SetFont('helvetica', '', 9);
$this->pdf->Cell(60, 1, $no, '0', 0, 'L', 0);
$this->pdf->Ln();
$this->pdf->SetFont('helvetica', 'B', 9);
$this->pdf->Cell(30, 1, 'Date', '0', 0, 'L', 0);
$this->pdf->SetFont('helvetica', '', 9);
$this->pdf->Cell(60, 1, $date, '0', 0, 'L', 0);
$this->pdf->Ln();

$this->pdf->SetY(35);
$this->pdf->setX(15);
$this->pdf->SetFont('helvetica','B',9);
$this->pdf->Cell(10, 6,"No", '1', 0, 'R', 0);
$this->pdf->Cell(12, 6,"Ins No", '1', 0, 'R', 0);
$this->pdf->Cell(30, 6,"Agreement No", '1', 0, 'L', 0);
$this->pdf->Cell(70, 6,"Customer", '1', 0, 'L', 0);
$this->pdf->Cell(30, 6,"Type", '1', 0, 'L', 0);
$this->pdf->Cell(30, 6,"Amount  ", '1', 0, 'R', 0);
$this->pdf->Ln();
$x=1;
$tot=0;
$arg=1;

foreach($details as $row){
	if($arg!=1 && $arg==$row->agr_no){
		$this->pdf->SetLineStyle(array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0.1, 'color' => array(0, 0, 0)));
		$this->pdf->setX(15);	
		$this->pdf->SetFont('helvetica','',10);
		$aa = $this->pdf->getNumLines($row->Customer, 70);
		$heigh=5*$aa;
		$this->pdf->MultiCell(10, $heigh,'',  0, 'R', 0, 0, '', '', true, 0, false, true, 0);
		$this->pdf->MultiCell(12, $heigh,'',  0, 'R', 0, 0, '', '', true, 0, false, true, 0);
		$this->pdf->MultiCell(30, $heigh,'',  0, 'L', 0, 0, '', '', true, 0, false, true, 0);
		$this->pdf->MultiCell(70, $heigh,'',  0, 'L', 0, 0, '', '', true, 0, false, true, 0);
		$this->pdf->MultiCell(30, $heigh,$row->description,  1, 'L', 0, 0, '', '', true, 0, false, true, 0);
		$this->pdf->MultiCell(30, $heigh,number_format($row->amount,2),  1, 'R', 0, 1, '', '', true, 0, false, true, 0);
	}else{
		$this->pdf->SetLineStyle(array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0.1, 'color' => array(0, 0, 0)));
		$this->pdf->setX(15);	
		$this->pdf->SetFont('helvetica','',10);
		$aa = $this->pdf->getNumLines($row->Customer, 70);
		$heigh=5*$aa;
		$this->pdf->MultiCell(10, $heigh,$x,  1, 'R', 0, 0, '', '', true, 0, false, true, 0);
		$this->pdf->MultiCell(12, $heigh,$row->ins_no,  1, 'R', 0, 0, '', '', true, 0, false, true, 0);
		$this->pdf->MultiCell(30, $heigh,$row->agr_no,  1, 'L', 0, 0, '', '', true, 0, false, true, 0);
		$this->pdf->MultiCell(70, $heigh,$row->customer,  1, 'L', 0, 0, '', '', true, 0, false, true, 0);
		$this->pdf->MultiCell(30, $heigh,$row->description,  1, 'L', 0, 0, '', '', true, 0, false, true, 0);
		$this->pdf->MultiCell(30, $heigh,number_format($row->amount,2),  1, 'R', 0, 1, '', '', true, 0, false, true, 0);
		$x++;
	}
	$arg=$row->agr_no;
	
	$tot += (float)$row->amount;
}

/*foreach($details as $row){
	
		$this->pdf->SetLineStyle(array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0.1, 'color' => array(0, 0, 0)));
		$this->pdf->setX(15);	
		$this->pdf->SetFont('helvetica','',10);
		$aa = $this->pdf->getNumLines($row->Customer, 70);
		$heigh=5*$aa;
		$this->pdf->MultiCell(10, $heigh,$x,  1, 'R', 0, 0, '', '', true, 0, false, true, 0);
		$this->pdf->MultiCell(12, $heigh,$row->ins_no,  1, 'R', 0, 0, '', '', true, 0, false, true, 0);
		$this->pdf->MultiCell(30, $heigh,$row->agr_no,  1, 'L', 0, 0, '', '', true, 0, false, true, 0);
		$this->pdf->MultiCell(70, $heigh,$row->customer,  1, 'L', 0, 0, '', '', true, 0, false, true, 0);
		$this->pdf->MultiCell(30, $heigh,$row->description,  1, 'L', 0, 0, '', '', true, 0, false, true, 0);
		$this->pdf->MultiCell(30, $heigh,number_format($row->amount,2),  1, 'R', 0, 1, '', '', true, 0, false, true, 0);
	
	$arg=$row->agr_no;
	$x++;
	$tot += (float)$row->amount;
}*/

$this->pdf->SetFont('helvetica','B',9);
$this->pdf->Cell(10, 6,"", '0', 0, 'R', 0);
$this->pdf->Cell(12, 6,"", '0', 0, 'R', 0);
$this->pdf->Cell(30, 6,"", '0', 0, 'L', 0);
$this->pdf->Cell(30, 6,"", '0', 0, 'L', 0);
$this->pdf->Cell(70, 6,"Total", '0', 0, 'C', 0);
$this->pdf->Cell(30, 6,number_format($tot,2), 'TBB', 0, 'R', 0);
$this->pdf->Output("Cash Sales_".date('Y-m-d').".pdf", 'I');
?>