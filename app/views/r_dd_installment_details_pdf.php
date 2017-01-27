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

		$agreement=$_POST['agreemnt_no'];
		$customer_name=$_POST['customer'];
		$salesman_name=$_POST['salesman'];
		$area_name=$_POST['area'];
		
		$this->pdf->setY(22);
		$this->pdf->Ln();
		$this->pdf->SetFont('helvetica', 'BU',10);
		$this->pdf->Cell(0, 5, 'Daily Due Installment Agreement Details ',0,false, 'L', 0, '', 0, false, 'M', 'M');
		$this->pdf->Ln();

		$this->pdf->SetFont('helvetica', '',9);
		$this->pdf->Cell(0, 5, 'Date Between '. $dfrom.' and '.$dto ,0,false, 'L', 0, '', 0, false, 'M', 'M');
		$this->pdf->Ln();

		if($agreement!=""){
			$this->pdf->SetFont('helvetica', '',9);
			$this->pdf->Cell(100, 5, 'Agreement No - '. $agreement,0,false, 'L', 0, '', 0, false, 'M', 'M');
		}
		if($customer_name!=""){
			$this->pdf->SetFont('helvetica', '',9);
			$this->pdf->Cell(0, 5, 'Customer - '. $customer_name,0,false, 'L', 0, '', 0, false, 'M', 'M');
			$this->pdf->Ln();
		}
		
		if($area_name!=""){
			$this->pdf->SetFont('helvetica', '',9);
			$this->pdf->Cell(0, 5, 'Area - '. $area_name,0,false, 'L', 0, '', 0, false, 'M', 'M');
			$this->pdf->Ln();
		}
		$this->pdf->Ln();

		$net_sum=$downp_sum=$interest_sum=$other_char_su=$inst_sum=$no_of_inst_sum=0;

		$this->pdf->SetY(35);
		$this->pdf->SetX(15);
		$this->pdf->SetFont('helvetica','B',7);
		$this->pdf->Cell(20, 6,"Date", '1', 0, 'C', 0);
		$this->pdf->Cell(25, 6,"Agr. No.", '1', 0, 'C', 0);
		$this->pdf->Cell(80, 6,"Customer", '1', 0, 'C', 0);
		$this->pdf->Cell(20, 6,"Agr. Amount", '1', 0, 'C', 0);
		$this->pdf->Cell(20, 6,"Installment", '1', 0, 'C', 0);
		$this->pdf->Cell(20, 6,"Due Amount", '1', 0, 'C', 0);		
		$this->pdf->Ln();

		foreach ($daily_due as $value) {
			$aa = $this->pdf->getNumLines($value->name, 80);
			$heigh=5*$aa;
			$this->pdf->HaveMorePages($heigh);
			$this->pdf->SetX(15);
			$this->pdf->SetLineStyle(array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0.1, 'color' => array(0, 0, 0)));
			$this->pdf->SetFont('helvetica','',7);
			
			$this->pdf->MultiCell(20, $heigh,$value->ddate, $border=1, $align='L', $fill=false, $ln=0, $x=($this->pdf->GetX()), $y=$this->pdf->GetY(), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=6, $valign='M', $fitcell=true);
			$this->pdf->MultiCell(25, $heigh,$value->agr_no, $border=1, $align='L', $fill=false, $ln=0, $x=($this->pdf->GetX()), $y=$this->pdf->GetY(), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=6, $valign='M', $fitcell=true);
			$this->pdf->MultiCell(80, $heigh,$value->name, $border=1, $align='L', $fill=false, $ln=0, $x=($this->pdf->GetX()), $y=$this->pdf->GetY(), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=6, $valign='M', $fitcell=true);
			$this->pdf->MultiCell(20, $heigh,$value->agr_amo, $border=1, $align='R', $fill=false, $ln=0, $x=($this->pdf->GetX()), $y=$this->pdf->GetY(), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=6, $valign='M', $fitcell=true);
			$this->pdf->MultiCell(20, $heigh,$value->ins_amo, $border=1, $align='R', $fill=false, $ln=0, $x=($this->pdf->GetX()), $y=$this->pdf->GetY(), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=6, $valign='M', $fitcell=true);
			$this->pdf->MultiCell(20, $heigh,$value->due_amo, $border=1, $align='R', $fill=false, $ln=1, $x=($this->pdf->GetX()), $y=$this->pdf->GetY(), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=6, $valign='M', $fitcell=true);   
			
			$due_amount+=$value->due_amo;	
		}

		$this->pdf->SetFont('helvetica', 'B', 7);
		$this->pdf->Cell(145, 5, "", '0', 0, 'L', 0);
		$this->pdf->Cell(20, 5, "TOTAL", '0', 0, 'C', 0);
		$this->pdf->Cell(20, 5, number_format($due_amount,2), '1', 0, 'R', 0);
		$this->pdf->Ln();

		$this->pdf->Output("Daily Due Installment Summary".date('Y-m-d').".pdf", 'I');

		?>