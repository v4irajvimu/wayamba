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

	foreach ($sum as $value) {
		$cust = $value->customer;
	}

	$this->pdf->setY(22);
	$this->pdf->Ln();$this->pdf->Ln();
	$this->pdf->SetFont('helvetica', 'BU',10);
	$this->pdf->Cell(0, 5, 'HP - RECEIPT LIST (DOWNPAYMENT)',0,false, 'L', 0, '', 0, false, 'M', 'M');
	$this->pdf->Ln();

	$this->pdf->SetFont('helvetica', '',9);
	$this->pdf->Cell(0, 5, 'Date Between '. $dfrom.' and '.$dto ,0,false, 'L', 0, '', 0, false, 'M', 'M');
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
	$this->pdf->Cell(20, 6,"Date.", '1', 0, 'C', 0);
	$this->pdf->Cell(15, 6,"Rec no.", '1', 0, 'C', 0);
	$this->pdf->Cell(40, 6,"Agreement No.", '1', 0, 'C', 0);
	$this->pdf->Cell(60, 6,"Customer", '1', 0, 'C', 0);
	$this->pdf->Cell(22, 6,"Cash", '1', 0, 'C', 0);
	$this->pdf->Cell(22, 6,"Cheque", '1', 0, 'C', 0);
	$this->pdf->Cell(22, 6,"Card", '1', 0, 'C', 0);
	$this->pdf->Cell(22, 6,"Settlement", '1', 0, 'C', 0);
	$this->pdf->Cell(22, 6,"Mixed", '1', 0, 'C', 0);
	$this->pdf->Cell(22, 6,"Total", '1', 0, 'C', 0);
	$this->pdf->Ln();
	$total_cnote=$mix_total=$total_cash=$total_cheque=$total_card=$final_tot=0;
	$T=1;
	foreach ($sum as $value) {
		$cnot_amount=$mix=$cash_amount=$cheque_amount=$card_amount="0.00";
		$aa = $this->pdf->getNumLines($value->customer, 60);
		$heigh=5*$aa;
		$this->pdf->SetX(15);
		$this->pdf->SetLineStyle(array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0.1, 'color' => array(0, 0, 0)));
		$this->pdf->SetFont('helvetica','',9);

		if($value->cash_amount!="0.00"){
			if($value->cash_amount!="0.00" && $value->credit_note=="0.00" && $value->cheque_amount=="0.00" && $value->card_amount=="0.00"){
				$cash_amount = $value->down_amount;
				$total_cash+=(float)$value->down_amount;
			}else if($value->cheque_amount!="0.00" || $value->card_amount!="0.00" || $value->credit_note!="0.00"){
				$mix = $value->down_amount;
			}
		}
		if($value->cheque_amount!="0.00"){
			if($value->cheque_amount!="0.00" && $value->credit_note=="0.00" && $value->cash_amount=="0.00" && $value->card_amount=="0.00"){
				$cheque_amount = $value->down_amount;
				$total_cheque+=(float)$value->down_amount;
			}else if($value->cash_amount!="0.00" || $value->card_amount!="0.00" || $value->credit_note!="0.00"){
				$mix = $value->down_amount;
			}
		}
		if($value->card_amount!="0.00"){
			if($value->card_amount!="0.00" && $value->credit_note=="0.00" && $value->cheque_amount=="0.00" && $value->cash_amount=="0.00"){
				$card_amount = $value->down_amount;
				$total_card+=(float)$value->down_amount;
			}else if($value->cash_amount!="0.00" || $value->cheque_amount!="0.00" || $value->credit_note!="0.00"){
				$mix = $value->down_amount;
			}
		}
		if($value->credit_note!="0.00"){
			if($value->credit_note!="0.00" && $value->cheque_amount=="0.00" && $value->cash_amount=="0.00" && $value->card_amount=="0.00"){
				$cnot_amount = $value->down_amount;
				$total_cnote+=(float)$value->down_amount;
			}else if($value->cash_amount!="0.00" || $value->cheque_amount!="0.00" || $value->card_amount!="0.00"){
				$mix = $value->down_amount;
			}
		}
		$final_tot+=(float)$value->down_amount;
		$mix_total+=(float)$mix;
		$this->pdf->MultiCell(10, $heigh,$T, $border=1, $align='R', $fill=false, $ln=0, $x=($this->pdf->GetX()), $y=$this->pdf->GetY(), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=6, $valign='M', $fitcell=true);
		$this->pdf->MultiCell(20, $heigh,$value->ddate, $border=1, $align='L', $fill=false, $ln=0, $x=($this->pdf->GetX()), $y=$this->pdf->GetY(), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=6, $valign='M', $fitcell=true);
		$this->pdf->MultiCell(15, $heigh,$value->nno, $border=1, $align='R', $fill=false, $ln=0, $x=($this->pdf->GetX()), $y=$this->pdf->GetY(), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=6, $valign='M', $fitcell=true);
		$this->pdf->MultiCell(40, $heigh,$value->agr_no, $border=1, $align='L', $fill=false, $ln=0, $x=($this->pdf->GetX()), $y=$this->pdf->GetY(), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=6, $valign='M', $fitcell=true);
		$this->pdf->MultiCell(60, $heigh,$value->customer, $border=1, $align='L', $fill=false, $ln=0, $x=($this->pdf->GetX()), $y=$this->pdf->GetY(), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=6, $valign='M', $fitcell=true);   
		$this->pdf->MultiCell(22, $heigh,$cash_amount, $border=1, $align='R', $fill=false, $ln=0, $x=($this->pdf->GetX()), $y=$this->pdf->GetY(), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=6, $valign='M', $fitcell=true);
		$this->pdf->MultiCell(22, $heigh,$cheque_amount, $border=1, $align='R', $fill=false, $ln=0, $x=($this->pdf->GetX()), $y=$this->pdf->GetY(), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=6, $valign='M', $fitcell=true);
		$this->pdf->MultiCell(22, $heigh,$card_amount, $border=1, $align='R', $fill=false, $ln=0, $x=($this->pdf->GetX()), $y=$this->pdf->GetY(), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=6, $valign='M', $fitcell=true);
		$this->pdf->MultiCell(22, $heigh,$cnot_amount, $border=1, $align='R', $fill=false, $ln=0, $x=($this->pdf->GetX()), $y=$this->pdf->GetY(), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=6, $valign='M', $fitcell=true);
		$this->pdf->MultiCell(22, $heigh,$mix, $border=1, $align='R', $fill=false, $ln=0, $x=($this->pdf->GetX()), $y=$this->pdf->GetY(), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=6, $valign='M', $fitcell=true);
		$this->pdf->MultiCell(22, $heigh,$value->down_amount, $border=1, $align='R', $fill=false, $ln=1, $x=($this->pdf->GetX()), $y=$this->pdf->GetY(), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=6, $valign='M', $fitcell=true);
		$T++;
	}

	$this->pdf->SetFont('helvetica', 'B', 9);
	$this->pdf->SetX(15);
	$this->pdf->Cell(10, 6,"", '0', 0, 'C', 0);
	$this->pdf->Cell(20, 6,"", '0', 0, 'C', 0);
	$this->pdf->Cell(15, 6,"", '0', 0, 'C', 0);
	$this->pdf->Cell(40, 6,"", '0', 0, 'C', 0);
	$this->pdf->Cell(60, 6,"TOTAL", '0', 0, 'C', 0);
	$this->pdf->Cell(22, 6,number_format($total_cash,2), '1', 0, 'R', 0);
	$this->pdf->Cell(22, 6,number_format($total_cheque,2), '1', 0, 'R', 0);
	$this->pdf->Cell(22, 6,number_format($total_card,2), '1', 0, 'R', 0);
	$this->pdf->Cell(22, 6,number_format($total_cnote,2), '1', 0, 'R', 0);
	$this->pdf->Cell(22, 6,number_format($mix_total,2), '1', 0, 'R', 0);
	$this->pdf->Cell(22, 6,number_format($final_tot,2), '1', 0, 'R', 0);
	$this->pdf->Ln();

	$this->pdf->Output("downpayment Summary".date('Y-m-d').".pdf", 'I');

?>