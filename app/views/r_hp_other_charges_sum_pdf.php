<?php
	error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
	$this->pdf->setPrintHeader($header,$type,$duration);
	$this->pdf->setPrintFooter(true);
	$this->pdf->SetFont('helvetica', 'B', 16);
	$this->pdf->AddPage($orientation,$page);   // L or P amd page type A4 or A3

	foreach($branch as $ress){
		$this->pdf->headerSet3($ress->name,$ress->address,$ress->tp,$ress->fax,$ress->email);
	}

	foreach ($purchase as $value){
		$inv_no=$value->nno;
		$name=$value->name;
	}

	$this->pdf->setY(22);
	$this->pdf->Ln();$this->pdf->Ln();
	$this->pdf->SetFont('helvetica', 'BU',10);
	$this->pdf->Cell(0, 5, 'OTHER CHARGERS SUMMARY',0,false, 'L', 0, '', 0, false, 'M', 'M');
	$this->pdf->Ln();

	$this->pdf->SetFont('helvetica', '',9);
	$this->pdf->Cell(0, 5, 'Date Between '. $dfrom.' and '.$dto ,0,false, 'L', 0, '', 0, false, 'M', 'M');
	$this->pdf->Ln();
	$this->pdf->Ln();

	$this->pdf->SetY(43);
	$this->pdf->SetX(20);
	$this->pdf->SetFont('helvetica','B',9);
	$this->pdf->Cell(10, 6,"No", '1', 0, 'C', 0);
	$this->pdf->Cell(25, 6,"Date.", '1', 0, 'C', 0);
	$this->pdf->Cell(40, 6,"Agreement No.", '1', 0, 'C', 0);
	$this->pdf->Cell(60, 6,"Customer", '1', 0, 'C', 0);
	$this->pdf->Cell(20, 6,"Amount", '1', 0, 'C', 0);
	$this->pdf->Ln();
	$total =0;
	foreach ($sum as $value) {
		$aa = $this->pdf->getNumLines($value->customer, 45);
		$heigh=5*$aa;
		$this->pdf->SetX(20);
		$this->pdf->SetLineStyle(array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0.1, 'color' => array(0, 0, 0)));
		$this->pdf->SetFont('helvetica','',9);

		$this->pdf->MultiCell(10, $heigh,$value->nno, $border=1, $align='L', $fill=false, $ln=0, $x=($this->pdf->GetX()), $y=$this->pdf->GetY(), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=6, $valign='M', $fitcell=true);
		$this->pdf->MultiCell(25, $heigh,$value->ddate, $border=1, $align='R', $fill=false, $ln=0, $x=($this->pdf->GetX()), $y=$this->pdf->GetY(), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=6, $valign='M', $fitcell=true);
		$this->pdf->MultiCell(40, $heigh,$value->agreement_no, $border=1, $align='L', $fill=false, $ln=0, $x=($this->pdf->GetX()), $y=$this->pdf->GetY(), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=6, $valign='M', $fitcell=true);
		$this->pdf->MultiCell(60, $heigh,$value->customer, $border=1, $align='L', $fill=false, $ln=0, $x=($this->pdf->GetX()), $y=$this->pdf->GetY(), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=6, $valign='M', $fitcell=true);
		$this->pdf->MultiCell(20, $heigh,$value->paid_amount, $border=1, $align='R', $fill=false, $ln=1, $x=($this->pdf->GetX()), $y=$this->pdf->GetY(), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=6, $valign='M', $fitcell=true);   
		$total+=(float)$value->paid_amount;
	}

	$this->pdf->Ln();
	$this->pdf->SetFont('helvetica', 'B', 9);
	$this->pdf->SetX(20);
	$this->pdf->Cell(10, 6,"", '0', 0, 'C', 0);
	$this->pdf->Cell(25, 6,"", '0', 0, 'C', 0);
	$this->pdf->Cell(40, 6,"", '0', 0, 'C', 0);
	$this->pdf->Cell(60, 6,"Total", '0', 0, 'R', 0);
	$this->pdf->Cell(20, 6,number_format($total,2), 'TB', 0, 'R', 0);
	$this->pdf->Ln();

	$this->pdf->Output("Other Chargers Summary".date('Y-m-d').".pdf", 'I');

?>