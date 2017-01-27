<?php
error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
$this->pdf->setPrintHeader($header,$type,$duration);
$this->pdf->setPrintHeader(true,$type);		
$this->pdf->setPrintFooter(true);

        //print_r($purchase);
$this->pdf->SetFont('helvetica', 'B', 16);
		$this->pdf->AddPage($orientation,$page);   // L or P amd page type A4 or A3

		foreach($branch as $ress){
			$this->pdf->headerSet3($ress->name,$ress->address,$ress->tp,$ress->fax,$ress->email);
		}

		
		$this->pdf->setY(25);

		$this->pdf->SetFont('helvetica', 'BIU',12);
		$this->pdf->Cell(0, 6, 'Hp SALES RETURN SUMMARY ',0,false, 'L', 0, '', 0, false, 'M', 'M');

		 	// $this->pdf->setY(27);
    //         $this->pdf->Cell(70, 1,"",'T',0, 'L', 0);
		$this->pdf->Ln(); 

		$this->pdf->SetFont('helvetica', '',9);
		$this->pdf->Cell(0, 6, 'Date Between '. $dfrom.' and '.$dto ,0,false, 'L', 0, '', 0, false, 'M', 'M');
		$this->pdf->Ln();
			// $this->pdf->Ln();
		$i=0;
		$a=-1;
		$j=-1;
		$Goss=array();
		$net=array();
		$my_array=array();
		foreach ($purchase as $value) {
			$my_array[]=$value->name;
		}
		foreach ($sum as $sum){
			$Goss[]=$sum->gsum;
			$net[]=$sum->nsum;
			$a++;
		}

		if($value->nno == "")
		{
			$this->pdf->SetX(80);
			$this->pdf->Cell(20, 1, "No Records For View ! ! !", '0', 0, 'L', 0);     
		}
		else
		{
			$this->pdf->SetFont('helvetica', 'B', 8);
			if ($i==0) {
				$this->pdf->setY(40);
			}
			$this->pdf->Ln();
			
			$tot_dis=(float)0;

			foreach ($purchase as $value) {	
				$Fh=$value->cus_id." | ".$value->name;
				$heigh=6*(max(1,$this->pdf->getNumLines($Fh, 60)));
				$this->pdf->HaveMorePages($heigh);

				$this->pdf->SetX(15);
				$this->pdf->SetLineStyle(array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0.1, 'color' => array(0, 0, 0)));
				$this->pdf->SetFont('helvetica','',8);
				$this->pdf->MultiCell(10, $heigh,$value->nno,1, 'L',false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
				$this->pdf->MultiCell(20, $heigh,$value->ddate,1, 'L',false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
				$this->pdf->MultiCell(25, $heigh,$value->store,1, 'L',false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
				$this->pdf->MultiCell(60, $heigh,$value->cus_id." | ".$value->name,1, 'L',false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
				$this->pdf->MultiCell(22, $heigh,$value->gross_amount,1, 'R',false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
				$this->pdf->MultiCell(22, $heigh,$value->discount,1, 'R',false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
				$this->pdf->MultiCell(22, $heigh,$value->net_amount,1, 'R',false,1, '', '', true, 0, false, true, $heigh,'M' ,false);
				$i++;

				$tot_disc+=(float)$value->discount;

			}

			$this->pdf->SetX(15);
			$this->pdf->SetFont('helvetica','B',8);
			$this->pdf->Cell(10, 6,"", '0', 0, 'L', 0);
			$this->pdf->Cell(20, 6,"", '0', 0, 'L', 0);
			$this->pdf->Cell(25, 6,"", '0', 0, 'R', 0);
			$this->pdf->Cell(60, 6,"Total ", '0', 0, 'C', 0);
			$this->pdf->Cell(22, 6,number_format($Goss[$a],2), '1', 0, 'R', 0);
			$this->pdf->Cell(22, 6,number_format($tot_disc,2), '1', 0, 'R', 0);
			$this->pdf->Cell(22, 6,number_format($net[$a],2), '1', 0, 'R', 0);

		}

		$this->pdf->Output("Hp Sales Return".date('Y-m-d').".pdf", 'I');

		?>