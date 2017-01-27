<?php
	error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
	$this->pdf->setPrintHeader($header,$type,$duration);
	$this->pdf->setPrintFooter(true);
	$this->pdf->SetFont('helvetica', 'B', 16);
	$this->pdf->AddPage("L","A3");   // L or P amd page type A4 or A3

	foreach($branch as $ress){
		$this->pdf->headerSet3($ress->name,$ress->address,$ress->tp,$ress->fax,$ress->email);
	}

	foreach ($purchase as $value){
		$inv_no=$value->nno;
		$name=$value->name;
	}

	foreach ($sum as $value) {
		$cust = $value->customer;
	}


	$this->pdf->setY(22);
	$this->pdf->Ln();$this->pdf->Ln();
	$this->pdf->SetFont('helvetica', 'BU',10);
	$this->pdf->Cell(0, 5, ' ARREARS LIST',0,false, 'L', 0, '', 0, false, 'M', 'M');
	$this->pdf->Ln();

	$this->pdf->SetFont('helvetica', '',9);
	$this->pdf->Cell(0, 5, 'As at Date '.$dto ,0,false, 'L', 0, '', 0, false, 'M', 'M');
	$this->pdf->Ln();
	
	
	$this->pdf->Cell(30, 6,"Agreenment No - ", '0', 0, 'L', 0);
	if($agr!=""){
		$this->pdf->Cell(30, 6,$agr, '0', 0, 'L', 0);
	}else{
		$this->pdf->Cell(30, 6,"", '0', 0, 'L', 0);
	}
	$this->pdf->Cell(90, 6,"",'0', 0, 'L', 0);
	$this->pdf->Cell(30, 6,"Organizer - ", '0', 0, 'L', 0);
	if($cus!=""){
		$this->pdf->Cell(30, 6,$cust, '0', 0, 'L', 0);
	}else{
		$this->pdf->Cell(30, 6,"", '0', 0, 'L', 0);
	}
	$this->pdf->Ln();
	$this->pdf->Cell(30, 6,"Collection Officer - ", '0', 0, 'L', 0);
	if($col!=""){
		$this->pdf->Cell(30, 6,$col, '0', 0, 'L', 0);
	}else{
		$this->pdf->Cell(30, 6,"", '0', 0, 'L', 0);
	}
	$this->pdf->Cell(90, 6,"",'0', 0, 'L', 0);
	$this->pdf->Cell(30, 6,"Route - ", '0', 0, 'L', 0);
	if($route!=""){
		$this->pdf->Cell(30, 6,$route, '0', 0, 'L', 0);
	}else{
		$this->pdf->Cell(30, 6,"", '0', 0, 'L', 0);
	}
		

	$this->pdf->Ln();
	$this->pdf->SetY(55);
	$this->pdf->SetX(15);
	$this->pdf->SetFont('helvetica','B',9);
	$this->pdf->Cell(10, 6,"No", '1', 0, 'C', 0);
	$this->pdf->Cell(25, 6,"Agreement No.", '1', 0, 'C', 0);
	$this->pdf->Cell(70, 6,"Customer", '1', 0, 'C', 0);
	$this->pdf->Cell(75, 6,"Address", '1', 0, 'C', 0);
	$this->pdf->Cell(40, 6,"TP", '1', 0, 'C', 0);
	$this->pdf->Cell(80, 6,"Item", '1', 0, 'C', 0);
	$this->pdf->Cell(25, 6,"Other Chargers", '1', 0, 'C', 0);
	$this->pdf->Cell(25, 6,"Panelty", '1', 0, 'C', 0);
	$this->pdf->Cell(25, 6,"Installment", '1', 0, 'C', 0);
	$this->pdf->Cell(25, 6,"Total Arrears ", '1', 0, 'C', 0);
	$this->pdf->Ln();
	$tot_other=$total_penalty=$total_ins=$final_tot=$tot_amount=0;
	$T=1;
	foreach ($sum as $value) {
		$other=$ins=$pen=$arr_amount=0;
		$aa = max(1,
			$this->pdf->getNumLines($value->customer, 70),
			$this->pdf->getNumLines($value->cus_add, 75),
			$this->pdf->getNumLines($value->cus_tp, 40),
			$this->pdf->getNumLines($value->all_item, 80)
			);
		
		$heigh=5*$aa;
		$this->pdf->haveMorePages($heigh);			
		$this->pdf->SetX(15);
		$this->pdf->SetLineStyle(array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0.1, 'color' => array(0, 0, 0)));
		$this->pdf->SetFont('helvetica','',9);

		if($value->other_chargers>0 || $value->penalty>0 || $value->installment>0){
		
		$this->pdf->MultiCell(10, $heigh,$T, $border=1, $align='R', $fill=false, $ln=0, $x=($this->pdf->GetX()), $y=$this->pdf->GetY(), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=$heigh, $valign='M', $fitcell=true);
		$this->pdf->MultiCell(25, $heigh,$value->agr_no, $border=1, $align='L', $fill=false, $ln=0, $x=($this->pdf->GetX()), $y=$this->pdf->GetY(), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=$heigh, $valign='M', $fitcell=true);
		$this->pdf->MultiCell(70, $heigh,$value->customer, $border=1, $align='L', $fill=false, $ln=0, $x=($this->pdf->GetX()), $y=$this->pdf->GetY(), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=$heigh, $valign='M', $fitcell=true);   
		$this->pdf->MultiCell(75, $heigh,$value->cus_add, $border=1, $align='L', $fill=false, $ln=0, $x=($this->pdf->GetX()), $y=$this->pdf->GetY(), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=$heigh, $valign='M', $fitcell=true);   
		$this->pdf->MultiCell(40, $heigh,$value->cus_tp, $border=1, $align='L', $fill=false, $ln=0, $x=($this->pdf->GetX()), $y=$this->pdf->GetY(), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=$heigh, $valign='M', $fitcell=true);   
		$this->pdf->MultiCell(80, $heigh,$value->all_item, $border=1, $align='L', $fill=false, $ln=0, $x=($this->pdf->GetX()), $y=$this->pdf->GetY(), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=$heigh, $valign='M', $fitcell=true);
		if($value->other_chargers>0){
			$other=$value->other_chargers;
			$this->pdf->MultiCell(25, $heigh,$other, $border=1, $align='R', $fill=false, $ln=0, $x=($this->pdf->GetX()), $y=$this->pdf->GetY(), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=$heigh, $valign='M', $fitcell=true);
		}else{
			$other=0;
			$this->pdf->MultiCell(25, $heigh,$other, $border=1, $align='R', $fill=false, $ln=0, $x=($this->pdf->GetX()), $y=$this->pdf->GetY(), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=$heigh, $valign='M', $fitcell=true);
		}

		if($value->penalty>0){
			$pen  =$value->penalty;
			$this->pdf->MultiCell(25, $heigh,$pen, $border=1, $align='R', $fill=false, $ln=0, $x=($this->pdf->GetX()), $y=$this->pdf->GetY(), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=$heigh, $valign='M', $fitcell=true);
		}else{
			$pen  =0;
			$this->pdf->MultiCell(25, $heigh,$pen, $border=1, $align='R', $fill=false, $ln=0, $x=($this->pdf->GetX()), $y=$this->pdf->GetY(), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=$heigh, $valign='M', $fitcell=true);
		}

		if($value->m_installment>0){
			$ins  =$value->m_installment;
			$this->pdf->MultiCell(25, $heigh,$ins, $border=1, $align='R', $fill=false, $ln=0, $x=($this->pdf->GetX()), $y=$this->pdf->GetY(), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=$heigh, $valign='M', $fitcell=true);
		}else{
			$ins  =0;
			$this->pdf->MultiCell(25, $heigh,$ins, $border=1, $align='R', $fill=false, $ln=0, $x=($this->pdf->GetX()), $y=$this->pdf->GetY(), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=$heigh, $valign='M', $fitcell=true);
		}
		$arr_amount = (float)$other + (float)$pen + (float)$value->installment;
		$this->pdf->MultiCell(25, $heigh,number_format($arr_amount,2), $border=1, $align='R', $fill=false, $ln=1, $x=($this->pdf->GetX()), $y=$this->pdf->GetY(), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=$heigh, $valign='M', $fitcell=true);
		$T++;
		}
		$tot_other+=(float)$other;
		$total_penalty+=(float)$pen;
		$total_ins+=(float)$ins;
		$tot_amount+=(float)$arr_amount;
		
		
	}

	$this->pdf->SetFont('helvetica', 'B', 9);
	$this->pdf->SetX(15);
	$this->pdf->Cell(10, 6,"", '0', 0, 'C', 0);
	$this->pdf->Cell(40, 6,"", '0', 0, 'C', 0);
	$this->pdf->Cell(180, 6,'', '0', 0, 'C', 0);
	$this->pdf->Cell(70, 6,'Total', '0', 0, 'C', 0);
	$this->pdf->Cell(25, 6,number_format($tot_other,2), 'TB', 0, 'R', 0);
	$this->pdf->Cell(25, 6,number_format($total_penalty,2), 'TB', 0, 'R', 0);
	$this->pdf->Cell(25, 6,number_format($total_ins,2), 'TB', 0, 'R', 0);
	$this->pdf->Cell(25, 6,number_format($tot_amount,2), 'TB', 0, 'R', 0);
	$this->pdf->Ln();

	$this->pdf->Output("HP Receipt List Summary".date('Y-m-d').".pdf", 'I');

?>