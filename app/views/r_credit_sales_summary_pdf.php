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
foreach ($purchase as $value){
	  $inv_no=$value->nno;
	  $name=$value->name;
	}
		
		foreach ($category as $cat){
	  $code=$cat->code;
	  $des=$cat->description;
	}

		// $this->pdf->setY(20);
			// $this->pdf->Ln(3);
        	$this->pdf->SetFont('helvetica', 'BU',10);
		 	$this->pdf->Cell(0, 6, 'CREDIT SALES SUMMARY',0,false, 'L', 0, '', 0, false, 'M', 'M');
			$this->pdf->Ln();
			// $this->pdf->Ln();
			$this->pdf->SetFont('helvetica', '',9);
		 	$this->pdf->Cell(0, 6, 'Date Between '. $dfrom.' and '.$dto ,0,false, 'L', 0, '', 0, false, 'M', 'M');
			// $this->pdf->Ln();
			$this->pdf->Ln(3);

			if($category_field!="0"){
				$this->pdf->SetX(10);
				$this->pdf->SetFont('helvetica', 'B',8);
				$this->pdf->Cell(45, 6,"Category : ".$code." - ".$des, '0', 0, 'R', 0);

				// $this->pdf->Ln();
			}
				// $this->pdf->Ln();			

			 //----check data is available for print ----        
           if($value->nno == "")
           {
           	$this->pdf->SetX(80);
			$this->pdf->Cell(20, 1, "No Records For View ! ! !", '0', 0, 'L', 0);     
           }
           else
           {

		 			// 	$this->pdf->SetY(55);
		 			// 	$this->pdf->SetX(16);
						// $this->pdf->SetFont('helvetica','B',8);
      //                   $this->pdf->Cell(10, 6,"No", '1', 0, 'C', 0);
      //                   $this->pdf->Cell(15, 6,"Sub No", '1', 0, 'C', 0);
						// $this->pdf->Cell(20, 6,"Date", '1', 0, 'C', 0);
						// $this->pdf->Cell(20, 6,"Store", '1', 0, 'C', 0);
      //                   $this->pdf->Cell(60, 6,"Customer", '1', 0, 'C', 0);
      //                   $this->pdf->Cell(25, 6,"Gross Amount", '1', 0, 'C', 0);
      //                   $this->pdf->Cell(15, 6,"Discount", '1', 0, 'C', 0);
      //                   $this->pdf->Cell(20, 6,"Net Amount", '1', 0, 'C', 0);
                        
                   
                        $this->pdf->Ln(12);
                        $tot_dis=(float)0;
                        $tot_gross=(float)0;
                        $tot_net=(float)0;

                        foreach ($purchase as $value) {
						//$this->pdf->SetY(45);
    $heigh=6*(max(1,$this->pdf->getNumLines($value->description, 20),$this->pdf->getNumLines($value->cus_id." | ".$value->name, 65)));
    $this->pdf->HaveMorePages($heigh);

		 				$this->pdf->SetX(16);
		 				$this->pdf->SetLineStyle(array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0.1, 'color' => array(0, 0, 0)));
						$this->pdf->SetFont('helvetica','',8);

						// $aa = $this->pdf->getNumLines($value->cus_id." | ".$value->name, 65);
		    //             $bb = $this->pdf->getNumLines($value->description, 20);
		    //             if($aa>$bb){
		    //                 $heigh=5*$aa;
		    //             }else{
		    //                 $heigh=5*$bb;
		    //             }
						$this->pdf->MultiCell(10, $heigh, $value->nno,  1, 'R', false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
						$this->pdf->MultiCell(15, $heigh, $value->sub_no,  1, 'R', false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
						$this->pdf->MultiCell(20, $heigh, $value->ddate,  1, 'R', false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
						$this->pdf->MultiCell(20, $heigh, $value->description,  1, 'L', false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
						$this->pdf->MultiCell(60, $heigh, $value->cus_id." | ".$value->name,  1, 'L', false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
						$this->pdf->MultiCell(25, $heigh, $value->gross,  1, 'R', false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
						$this->pdf->MultiCell(15, $heigh, $value->discount,  1, 'R', false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
						$this->pdf->MultiCell(20, $heigh, $value->net_amount,  1, 'R', false, 1, '', '', true, 0, false, true, $heigh,'M' ,false);
						 
                        $tot_disc+=(float)$value->discount;
                        $tot_gross+=(float)$value->gross;
                        $tot_net+=(float)$value->net_amount;
                        	
                        }

                        foreach ($sum as $sum) {
                        	$Goss=$sum->gsum;
                        	$net=$sum->nsum;
                        	$addi =$sum->addi;
                        }

                   
                        $this->pdf->SetFont('helvetica', 'B', 9);
						$this->pdf->SetX(16);
					 	$this->pdf->Cell(10, 6, "", '0', 0, 'L', 0);
					 	$this->pdf->Cell(15, 6, "", '0', 0, 'R', 0);
					 	$this->pdf->Cell(20, 6, "", '0', 0, 'C', 0);
					 	$this->pdf->Cell(20, 6, "", '0', 0, 'C', 0);
					 	$this->pdf->Cell(60, 6, "Total", '0', 0, 'C', 0);
					 	$this->pdf->Cell(25, 6, number_format($tot_gross,2), '1', 0, 'R', 0);
					 	$this->pdf->Cell(15, 6, number_format($tot_disc,2), '1', 0, 'R', 0);
					 	$this->pdf->Cell(20, 6, number_format($tot_net,2), '1', 0, 'R', 0);
					 	

}

	
	$this->pdf->Output("Credit Sale Summary".date('Y-m-d').".pdf", 'I');

?>