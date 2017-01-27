<?php
error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
		$this->pdf->setPrintHeader($header,$type,$duration);
		$this->pdf->setPrintHeader(true,$type);
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
		

  

		$this->pdf->setY(25);

    	$this->pdf->SetFont('helvetica', 'BUI',12);
	 	$this->pdf->Cell(0, 6, ' PURCHASE SUMMARY',0,false, 'L', 0, '', 0, false, 'M', 'M');
		$this->pdf->Ln();$this->pdf->Ln();

		
         

		$this->pdf->SetFont('helvetica', '',9);
	 	$this->pdf->Cell(0, 6, 'Date Between '. $dfrom.' and '.$dto ,0,false, 'L', 0, '', 0, false, 'M', 'M');
		$this->pdf->Ln();
		// $this->pdf->Ln();

			 //----check data is available for print ----        
           if($value->nno == "")
           {
           	$this->pdf->SetX(80);
			$this->pdf->Cell(20, 1, "No Records For View ! ! !", '0', 0, 'L', 0);     
           }
           else
           {


 			// 	$this->pdf->SetY(40);
 			// 	$this->pdf->SetX(16);
				// $this->pdf->SetFont('helvetica','',7);
    //             $this->pdf->Cell(10, 6,"GRN No", '1', 0, 'C', 0);
				// $this->pdf->Cell(20, 6,"Date", '1', 0, 'C', 0);
				// $this->pdf->Cell(10, 6,"Inv No", '1', 0, 'C', 0);
				// $this->pdf->Cell(20, 6,"Store", '1', 0, 'C', 0);
    //             $this->pdf->Cell(20, 6,"Memo", '1', 0, 'C', 0);
    //             $this->pdf->Cell(50, 6,"Supplier", '1', 0, 'C', 0);
    //             $this->pdf->Cell(20, 6,"Gross Amount", '1', 0, 'C', 0);
    //             $this->pdf->Cell(20, 6,"Discount", '1', 0, 'C', 0);
    //             $this->pdf->Cell(20, 6,"Net Amount", '1', 0, 'C', 0);
               
                $this->pdf->Ln();

                $tot_dis=(float)0;
		
                foreach ($purchase as $value) {

				    $heigh=5*(max(1,$this->pdf->getNumLines($value->name, 50)));
				    $this->pdf->HaveMorePages($heigh);

	             	$this->pdf->SetX(16);
					$this->pdf->SetFont('helvetica','',7);
					$this->pdf->SetLineStyle(array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0.1, 'color' => array(0, 0, 0)));
	                $this->pdf->MultiCell(10, $heigh, $value->nno,  1, 'R', 0, 0, '', '', true, 0, false, true, 0);
	                $this->pdf->MultiCell(15, $heigh, $value->ddate,  1, 'R', 0, 0, '', '', true, 0, false, true, 0);
	                $this->pdf->MultiCell(20, $heigh, $value->inv_no,  1, 'L', 0, 0, '', '', true, 0, false, true, 0);
	                $this->pdf->MultiCell(30, $heigh, $value->description,  1, 'L', 0, 0, '', '', true, 0, false, true, 0);
	                $this->pdf->MultiCell(50, $heigh, $value->name,  1, 'L', 0, 0, '', '', true, 0, false, true, 0);
	                $this->pdf->MultiCell(20, $heigh, $value->gross_amount,  1, 'R', 0, 0, '', '', true, 0, false, true, 0);
	                $this->pdf->MultiCell(20, $heigh, $value->discount,  1, 'R', 0, 0, '', '', true, 0, false, true, 0);
	                $this->pdf->MultiCell(20, $heigh, $value->amount,  1, 'R', 0, 1, '', '', true, 0, false, true, 0);
	  

                 	$tot_disc+=(float)$value->discount;
                	
                }

                foreach ($sum as $sum) {
                	$Goss=$sum->gsum;
                	$net=$sum->nsum;
                	$addi=$sum->addi;
                	$dis=$sum->discount;
                }

                $this->pdf->SetFont('helvetica','B',8);
		        $this->pdf->SetX(16);
		        
		        $this->pdf->Cell(10, 6,"", '0', 0, 'L', 0);
		        $this->pdf->Cell(15, 6,"", '0', 0, 'L', 0);
		        $this->pdf->Cell(20, 6,"", '0', 0, 'L', 0);
		        $this->pdf->Cell(30, 6,"", '0', 0, 'L', 0);
		        $this->pdf->Cell(50, 6,"Total", '0', 0, 'C', 0);
		        $this->pdf->Cell(20, 6,number_format($Goss,2), '1', 0, 'R', 0);
		        $this->pdf->Cell(20, 6,number_format($tot_disc,2), '1', 0, 'R', 0);
		        $this->pdf->Cell(20, 6,number_format($net,2), '1', 0, 'R', 0);
		        
		        

 } // --- end check data available

	// $this->pdf->footerSet($employee,$amount,$additional,$discount,$user);
	$this->pdf->Output("Purchase Summary".date('Y-m-d').".pdf", 'I');

?>