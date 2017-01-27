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

		
		$this->pdf->setY(25);

    	$this->pdf->SetFont('helvetica', 'BU',12);
	 	$this->pdf->Cell(0, 5, 'SEETTU ITEM LIST',0,false, 'L', 0, '', 0, false, 'M', 'M');
		$this->pdf->Ln();$this->pdf->Ln();

        $y=1;
        

			$this->pdf->Ln();
			$this->pdf->SetY(40);
			$this->pdf->SetX(16);

			$this->pdf->SetFont('helvetica','B',9);

			// Headings-------------------------------------
			$this->pdf->Cell(15, 6,"No", '1', 0, 'C', 0);
			$this->pdf->Cell(25, 6,"Item Code", '1', 0, 'C', 0);
			$this->pdf->Cell(60, 6,"Name", '1', 0, 'C', 0);
			$this->pdf->Cell(20, 6,"Value", '1', 0, 'C', 0);
			$this->pdf->Cell(22, 6,"Installments", '1', 0, 'C', 0);
			$this->pdf->Cell(32, 6,"Installment Amount", '1', 0, 'C', 0);
            $this->pdf->Ln();
		 	
		 	
		foreach($sum as $value)
        { 
			$this->pdf->SetLineStyle(array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0.1, 'color' => array(0, 0, 0)));
			$this->pdf->SetFont('helvetica','',9);
			$this->pdf->SetX(16);

			$bb=$this->pdf->getNumLines($value->Name, 70); 

       		$heigh=6*$bb;
	            
	        // Deatils loop---------------------------------
			$this->pdf->MultiCell(15, $heigh, $y, 1, 'R', 0, 0, '', '', true, 0, false, true, 0);
	        $this->pdf->MultiCell(25, $heigh, $value->code, 1, 'L', 0, 0, '', '', true, 0, false, true, 0);
	        $this->pdf->MultiCell(60, $heigh, $value->name, 1, 'L', 0, 0, '', '', true, 0, false, true, 0);
	        $this->pdf->MultiCell(20, $heigh, $value->value, 1, 'R', 0, 0, '', '', true, 0, false, true, 0);
	        $this->pdf->MultiCell(22, $heigh, $value->no_of_installment, 1, 'R', 0, 0, '', '', true, 0, false, true, 0);    
			$this->pdf->MultiCell(32, $heigh, $value->installment_amount, 1, 'R', 0, 1, '', '', true, 0, false, true, 0);    
			//$this->pdf->Ln();
			//$this->pdf->Ln();   
           // $this->pdf->Ln();
            $y++;

			}
			$item_cat=$y-1;

			$this->pdf->Ln();
			$this->pdf->Ln();

        	$this->pdf->SetX(16);
        	$this->pdf->SetLineStyle(array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0.1, 'color' => array(0, 0, 0)));
			$this->pdf->SetFont('helvetica','B',10);
        	$this->pdf->Cell(60, 6,"No. of Category List :  ".$item_cat, '0', 0, 'L', 0);
        	
			$this->pdf->Ln();
            		
			
				
	// $this->pdf->footerSet($employee,$amount,$additional,$discount,$user);
	$this->pdf->Output("Seettu Item List".date('Y-m-d').".pdf", 'I');

?>