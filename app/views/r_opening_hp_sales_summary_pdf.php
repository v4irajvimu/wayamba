<?php
error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);


		$this->pdf->setPrintHeader($header,$type,$duration);
        $this->pdf->setPrintFooter(true);
        //$this->pdf->setPrintHeader(true);
        //print_r($purchase);
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
		 	$this->pdf->Cell(0, 5, 'OPENING HP SALES SUMMARY',0,false, 'L', 0, '', 0, false, 'M', 'M');
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
		if($salesman_name!=""){
			$this->pdf->SetFont('helvetica', '',9);
		 	$this->pdf->Cell(100, 5, 'Salesman - '. $salesman_name,0,false, 'L', 0, '', 0, false, 'M', 'M');
			
		}
		if($area_name!=""){
			$this->pdf->SetFont('helvetica', '',9);
		 	$this->pdf->Cell(0, 5, 'Area - '. $area_name,0,false, 'L', 0, '', 0, false, 'M', 'M');
			$this->pdf->Ln();
		}
		$this->pdf->Ln();

			 //----check data is available for print ----        
           if($value->nno == "")
           {
           	$this->pdf->SetX(80);
			$this->pdf->Cell(20, 1, "No Records For View ! ! !", '0', 0, 'L', 0);     
           }
           else
           {

		 				$this->pdf->SetY(45);
		 				$this->pdf->SetX(16);
						$this->pdf->SetFont('helvetica','B',7);
						$this->pdf->Cell(15, 6,"Date", '1', 0, 'C', 0);
						$this->pdf->Cell(15, 6,"Invoice No.", '1', 0, 'C', 0);
						$this->pdf->Cell(30, 6,"Agreement No.", '1', 0, 'C', 0);
                        $this->pdf->Cell(40, 6,"Customer", '1', 0, 'C', 0);
                        $this->pdf->Cell(15, 6,"Amount", '1', 0, 'C', 0);
                        $this->pdf->Cell(15, 6,"D/payment", '1', 0, 'C', 0);
                        $this->pdf->Cell(15, 6,"interest", '1', 0, 'C', 0);
                        $this->pdf->Cell(15, 6,"Other Char.", '1', 0, 'C', 0);
                        $this->pdf->Cell(15, 6,"Ins.", '1', 0, 'C', 0);
                        $this->pdf->Cell(15, 6,"No. Of Ins.", '1', 0, 'C', 0);
                   
                        $this->pdf->Ln();

                        foreach ($purchase as $value) {

						//$this->pdf->SetY(45);
                        $aa = $this->pdf->getNumLines($value->cus_id." | ".$value->name, 40);
	        		  	$heigh=5*$aa;
		 				$this->pdf->SetX(16);
		 				$this->pdf->SetLineStyle(array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0.1, 'color' => array(0, 0, 0)));
						$this->pdf->SetFont('helvetica','',7);
						
                      	$this->pdf->MultiCell(15, $heigh,$value->ddate, $border=1, $align='L', $fill=false, $ln=0, $x=($this->pdf->GetX()), $y=$this->pdf->GetY(), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=6, $valign='M', $fitcell=true);
			            $this->pdf->MultiCell(15, $heigh,$value->nno, $border=1, $align='L', $fill=false, $ln=0, $x=($this->pdf->GetX()), $y=$this->pdf->GetY(), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=6, $valign='M', $fitcell=true);
			            $this->pdf->MultiCell(30, $heigh,$value->agreement_no, $border=1, $align='L', $fill=false, $ln=0, $x=($this->pdf->GetX()), $y=$this->pdf->GetY(), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=6, $valign='M', $fitcell=true);
			            $this->pdf->MultiCell(40, $heigh,$value->cus_id." | ".$value->name, $border=1, $align='L', $fill=false, $ln=0, $x=($this->pdf->GetX()), $y=$this->pdf->GetY(), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=6, $valign='M', $fitcell=true);
			            $this->pdf->MultiCell(15, $heigh,$value->net_amount, $border=1, $align='R', $fill=false, $ln=0, $x=($this->pdf->GetX()), $y=$this->pdf->GetY(), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=6, $valign='M', $fitcell=true);   
			            $this->pdf->MultiCell(15, $heigh,$value->down_payment, $border=1, $align='R', $fill=false, $ln=0, $x=($this->pdf->GetX()), $y=$this->pdf->GetY(), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=6, $valign='M', $fitcell=true);
			            $this->pdf->MultiCell(15, $heigh,$value->interest_amount, $border=1, $align='R', $fill=false, $ln=0, $x=($this->pdf->GetX()), $y=$this->pdf->GetY(), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=6, $valign='M', $fitcell=true);
			            $this->pdf->MultiCell(15, $heigh,$value->document_charges, $border=1, $align='R', $fill=false, $ln=0, $x=($this->pdf->GetX()), $y=$this->pdf->GetY(), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=6, $valign='M', $fitcell=true);
			            $this->pdf->MultiCell(15, $heigh,$value->installment_amount, $border=1, $align='R', $fill=false, $ln=0, $x=($this->pdf->GetX()), $y=$this->pdf->GetY(), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=6, $valign='M', $fitcell=true);
			            $this->pdf->MultiCell(15, $heigh,$value->no_of_installments, $border=1, $align='R', $fill=false, $ln=1, $x=($this->pdf->GetX()), $y=$this->pdf->GetY(), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=6, $valign='M', $fitcell=true);
			            
                       
                        	
                        }



                        foreach ($sum as $sum) {
                        	
                       		$net_sum=$net_sum+$sum->net_sum;
                        	$net_sum=$sum->net_sum;
                        	$downp_sum=$sum->downp_sum;
                        	$interest_sum=$sum->interest_sum;
                        	$other_char_sum=$sum->other_char_sum;
                        	$inst_sum=$sum->inst_sum;
                        	$no_of_inst_sum=$sum->no_of_inst_sum;
                        }

     					
                        $this->pdf->SetX(35);
                        $this->pdf->Ln();
                        $this->pdf->SetFont('helvetica', 'B', 7);
						$this->pdf->SetX(12);
					 	$this->pdf->Cell(60, 1, "", '0', 0, 'L', 0);
					 	$this->pdf->Cell(45, 1, "TOTAL", '0', 0, 'R', 0);
					 	$this->pdf->Cell(15, 1, number_format($net_sum,2), '1', 0, 'R', 0);
					 	$this->pdf->Cell(15, 1, number_format($downp_sum,2), '1', 0, 'R', 0);
					 	$this->pdf->Cell(15, 1, number_format($interest_sum,2), '1', 0, 'R', 0);
					 	$this->pdf->Cell(15, 1, number_format($other_char_sum,2), '1', 0, 'R', 0);
					 	$this->pdf->Cell(15, 1, number_format($inst_sum,2), '1', 0, 'R', 0);
					 	$this->pdf->Cell(15, 1, $no_of_inst_sum, '1', 0, 'R', 0);

					 	$this->pdf->Ln();
					 // 	$this->pdf->SetX(20);
					 // 	$this->pdf->Cell(40, 1, "", '0', 0, 'L', 0);
					 // 	$this->pdf->Cell(80, 1, "", '0', 0, 'L', 0);
					 // 	$this->pdf->Cell(30, 1, "Additional                Rs", '0', 0, 'L', 0);
					 // 	$this->pdf->Cell(20, 1, $addi, '0', 0, 'R', 0);
					 // 	$this->pdf->Cell(20, 1, "", '0', 0, 'L', 0);
					 
					 // 	$this->pdf->Ln();
						// $this->pdf->SetX(20);
					 // 	$this->pdf->Cell(40, 1, "", '0', 0, 'L', 0);
					 // 	$this->pdf->Cell(80, 1, "", '0', 0, 'L', 0);
					 // 	$this->pdf->Cell(30, 1, "Total Net Amount    Rs", '0', 0, 'L', 0);
					 // 	$this->pdf->Cell(20, 1, $net, '0', 0, 'R', 0);
					 // 	$this->pdf->Cell(20, 1, "", '0', 0, 'L', 0);




}
	// $this->pdf->footerSet($employee,$amount,$additional,$discount,$user);
	$this->pdf->Output("Cash Sale Summary".date('Y-m-d').".pdf", 'I');

?>