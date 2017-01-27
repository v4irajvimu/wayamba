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

		
		$this->pdf->setY(22);

    	$this->pdf->SetFont('helvetica', 'BU',12);
	 	$this->pdf->Cell(0, 5, "	SEETTU SUMMARY",0,false, 'C', 0, '', 0, false, 'M', 'M');
		$this->pdf->Ln();$this->pdf->Ln();



	 	$this->pdf->SetFont('helvetica', '',10);
	 	$this->pdf->Cell(0, 5, 'Date   From '. $dfrom.' To '.$dto ,0,false, 'L', 0, '', 0, false, 'M', 'M');
		$this->pdf->Ln();

    
    //----------------------------------------------------------------------------------------------------

		$this->pdf->SetX(16);
		$this->pdf->SetFont('helvetica', 'B',9);
		$this->pdf->SetLineStyle(array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0.1, 'color' => array(0, 0, 0)));
					
		// Headings-------------------------------------
		$this->pdf->Cell(20, 6,"Seettu No", '1', 0, 'C', 0);
		$this->pdf->Cell(20, 6,"Date", '1', 0, 'C', 0);
		$this->pdf->Cell(25, 6,"Organizer ID", '1', 0, 'C', 0);
		$this->pdf->Cell(50, 6,"Organizer Name", '1', 0, 'C', 0);
		$this->pdf->Cell(55, 6,"Address", '1', 0, 'C', 0);
		$this->pdf->Cell(20, 6,"Tel No.", '1', 0, 'C', 0);
		$this->pdf->Cell(45, 6,"Salesman Name", '1', 0, 'C', 0);
		$this->pdf->Cell(35, 6,"No. of Item Category", '1', 0, 'C', 0);
        $this->pdf->Ln();

        foreach($sum as $value)
        {

        	$this->pdf->SetX(16);
			$this->pdf->SetLineStyle(array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0.1, 'color' => array(0, 0, 0)));
			$this->pdf->SetFont('helvetica','',9);

						 

			$address= $value->address1 . ", ". $value->address2. ", ". $value->address3;
			$bb=$this->pdf->getNumLines($value->name, 55); 
			$aa=$this->pdf->getNumLines($address, 55); 
		   if($aa>$bb)
		    $heigh=6*$aa;
			else
		    $heigh=6*$bb;

		   
		    
	        // Deatils loop---------------------------------
			$this->pdf->MultiCell(20, $heigh, $value->nno, 1, 'R', 0, 0, '', '', true, 0, false, true, 0);
	        $this->pdf->MultiCell(20, $heigh, $value->ddate, 1, 'L', 0, 0, '', '', true, 0, false, true, 0);
	        $this->pdf->MultiCell(25, $heigh, $value->organizer, 1, 'L', 0, 0, '', '', true, 0, false, true, 0);
	        $this->pdf->MultiCell(50, $heigh, $value->name, 1, 'L', 0, 0, '', '', true, 0, false, true, 0);
	        $this->pdf->MultiCell(55, $heigh, $address, 1, 'L', 0, 0, '', '', true, 0, false, true, 0);    
			$this->pdf->MultiCell(20, $heigh, $value->tp, 1, 'L', 0, 0, '', '', true, 0, false, true, 0);    
			$this->pdf->MultiCell(45, $heigh, $value->sales_name, 1, 'L', 0, 0, '', '', true, 0, false, true, 0);    
			$this->pdf->MultiCell(35, $heigh, $value->no_of_cat, 1, 'R', 0, 1, '', '', true, 0, false, true, 0);    
			
					
	                
	        $y++;

		}
				
                
               
        $this->pdf->Ln();
		$this->pdf->Ln();

		$this->pdf->SetX(16);
    	$this->pdf->SetLineStyle(array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0.1, 'color' => array(0, 0, 0)));
		$this->pdf->SetFont('helvetica','B',9);

    	$this->pdf->Cell(20, 6," ", '0', 0, 'L', 0);
    	$this->pdf->Cell(30, 6,"Total Seettu No.  :  ".$y, '0', 0, 'R', 0);
    	$this->pdf->Ln();

	// $this->pdf->footerSet($employee,$amount,$additional,$discount,$user);
	$this->pdf->Output("Seettu Summary".date('Y-m-d').".pdf", 'I');

?>