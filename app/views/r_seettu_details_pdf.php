<?php
error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);


		$this->pdf->setPrintHeader($header,$type,$duration);
        $this->pdf->setPrintFooter(true);
        
        $this->pdf->SetFont('helvetica', 'B', 16);
		$this->pdf->AddPage($orientation,$page);   // L or P amd page type A4 or A3

 		foreach($branch as $ress){
			$this->pdf->headerSet3($ress->name,$ress->address,$ress->tp,$ress->fax,$ress->email);
		}

		
		$this->pdf->setY(22);

    	$this->pdf->SetFont('helvetica', 'BU',12);
	 	$this->pdf->Cell(0, 5, "	SEETTU DETAILS",0,false, 'C', 0, '', 0, false, 'M', 'M');
		$this->pdf->Ln();$this->pdf->Ln();



	 	$this->pdf->SetFont('helvetica', '',10);
	 	$this->pdf->Cell(0, 5, 'Date   From '. $dfrom.' To '.$dto ,0,false, 'L', 0, '', 0, false, 'M', 'M');
		$this->pdf->Ln();

    
    //----------------------------------------------------------------------------------------------------
		
		$this->pdf->SetX(16);
		$this->pdf->SetFont('helvetica', 'B',9);
		$this->pdf->SetLineStyle(array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0.1, 'color' => array(0, 0, 0)));
					
		$this->pdf->Cell(20, 6,"Seettu No:  1", '0', 0, 'C', 0);
		$this->pdf->Ln();

		$this->pdf->SetX(17);
		$this->pdf->SetFont('helvetica', 'B',9);
		$this->pdf->SetLineStyle(array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0.1, 'color' => array(0, 0, 0)));
		
		// Headings-------------------------------------
		$this->pdf->Cell(15, 6,"Seettu No", '1', 0, 'C', 0);
		$this->pdf->Cell(20, 6,"Date", '1', 0, 'C', 0);
		$this->pdf->Cell(25, 6,"Organizer ID", '1', 0, 'C', 0);
		$this->pdf->Cell(60, 6,"Organizer Name", '1', 0, 'C', 0);
		$this->pdf->Cell(60, 6,"Salesman Name", '1', 0, 'C', 0);
        $this->pdf->Ln();
        
        $x=$z=$a=0;
        
        
        foreach($sum as $value)
        {

        	if($x==0)
        	{
        		$this->pdf->SetX(17);
				$this->pdf->SetLineStyle(array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0.1, 'color' => array(0, 0, 0)));
				$this->pdf->SetFont('helvetica','',9);

				$bb=$this->pdf->getNumLines($value->name, 50); 
			    $heigh=6*$bb;

			     
		        // Deatils loop---------------------------------
				$this->pdf->MultiCell(15, $heigh, $value->nno, 1, 'R', 0, 0, '', '', true, 0, false, true, 0);
		        $this->pdf->MultiCell(20, $heigh, $value->ddate, 1, 'L', 0, 0, '', '', true, 0, false, true, 0);
		        $this->pdf->MultiCell(25, $heigh, $value->organizer, 1, 'L', 0, 0, '', '', true, 0, false, true, 0);
		        $this->pdf->MultiCell(60, $heigh, $value->org_name, 1, 'L', 0, 0, '', '', true, 0, false, true, 0);
		        $this->pdf->MultiCell(60, $heigh, $value->sales_name, 1, 'L', 0, 1, '', '', true, 0, false, true, 0);    
						
		                
		        $y++;
		        $x++;
		        $sum_nno=$value->nno;
        	}
        		$det_nno=$value->item_no;
        		
        		if($sum_nno==$det_nno)
        		{
        			if($z==0)
        			{
        		
        				 $this->pdf->Ln();

        				$this->pdf->SetX(33);
						$this->pdf->SetFont('helvetica', 'B',9);
						$this->pdf->SetLineStyle(array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0.1, 'color' => array(0, 0, 0)));
						
						$this->pdf->Cell(20, 6,"Item Details", '0', 0, 'C', 0);
					    $this->pdf->Ln();

						
						$this->pdf->SetX(33);
						$this->pdf->SetFont('helvetica', 'B',9);
						$this->pdf->SetLineStyle(array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0.1, 'color' => array(0, 0, 0)));
						

        				// Headings-------------------------------------
						$this->pdf->Cell(33, 6,"Item Code", '1', 0, 'C', 0);
						$this->pdf->Cell(60, 6,"Item Name", '1', 0, 'C', 0);
						$this->pdf->Cell(20, 6,"Value", '1', 0, 'C', 0);
						$this->pdf->Cell(30, 6,"No. of Installment", '1', 0, 'C', 0);
						$this->pdf->Cell(20, 6,"Installment", '1', 0, 'C', 0);
				        $this->pdf->Ln();

				        $z++;	
        			}

        		if($z==1){

        				
        				$this->pdf->SetX(33);
						$this->pdf->SetFont('helvetica', '',9);
						$this->pdf->SetLineStyle(array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0.1, 'color' => array(0, 0, 0)));
						
						$bb=$this->pdf->getNumLines($value->det_item_name, 50); 
			    		$heigh=6*$bb;
						
        				// Deatils loop---------------------------------
						$this->pdf->MultiCell(33, $heigh, $value->item_code, 1, 'L', 0, 0, '', '', true, 0, false, true, 0);
				        $this->pdf->MultiCell(60, $heigh, $value->det_item_name , 1, 'L', 0, 0, '', '', true, 0, false, true, 0);
				        $this->pdf->MultiCell(20, $heigh, $value->value, 1, 'R', 0, 0, '', '', true, 0, false, true, 0);
				        $this->pdf->MultiCell(30, $heigh, $value->no_ins, 1, 'R', 0, 0, '', '', true, 0, false, true, 0);
				        $this->pdf->MultiCell(20, $heigh, $value->ins_amount, 1, 'R', 0, 1, '', '', true, 0, false, true, 0);    
						$z=1;
						$y++;
						$a++;
        			}
        		}

        		if($sum_nno!=$det_nno)
        		{
        			$this->pdf->SetX(33);
			    	$this->pdf->SetLineStyle(array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0.1, 'color' => array(0, 0, 0)));
					$this->pdf->SetFont('helvetica','B',9);

			    	$this->pdf->Cell(160, 6,"Total Items.  :  ".$a, '0', 0, 'R', 0);
			    	
			    	
					$this->pdf->Ln();

        			$this->pdf->SetX(17);
					$this->pdf->SetFont('helvetica', 'B',9);
					$this->pdf->SetLineStyle(array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0.1, 'color' => array(0, 0, 0)));
								
					$sum_nno=$value->nno;

					$this->pdf->Cell(20, 6,"Seettu No:  ".$sum_nno, '0', 0, 'C', 0);
					$this->pdf->Ln();

					$this->pdf->SetX(17);
					$this->pdf->SetFont('helvetica', 'B',9);
					$this->pdf->SetLineStyle(array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0.1, 'color' => array(0, 0, 0)));
					
					// Headings-------------------------------------
					$this->pdf->Cell(15, 6,"Seettu No", '1', 0, 'C', 0);
					$this->pdf->Cell(20, 6,"Date", '1', 0, 'C', 0);
					$this->pdf->Cell(25, 6,"Organizer ID", '1', 0, 'C', 0);
					$this->pdf->Cell(60, 6,"Organizer Name", '1', 0, 'C', 0);
					$this->pdf->Cell(60, 6,"Salesman Name", '1', 0, 'C', 0);
			        $this->pdf->Ln();
			        $x=$z=$a=0;
        		}
        	

		}
				
        $this->pdf->SetX(30);
    	$this->pdf->SetLineStyle(array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0.1, 'color' => array(0, 0, 0)));
		$this->pdf->SetFont('helvetica','B',9);

    	$this->pdf->Cell(160, 6,"Total Items.  :  ".$a, '0', 0, 'R', 0);
    	       
               
        $this->pdf->Ln();
		$this->pdf->Ln();

		$this->pdf->SetX(16);
    	$this->pdf->SetLineStyle(array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0.1, 'color' => array(0, 0, 0)));
		$this->pdf->SetFont('helvetica','B',9);

    	
    	$this->pdf->Cell(30, 6,"Total Seettu No.  :  ".$sum_nno, '0', 0, 'L', 0);
    	$this->pdf->Ln();


	$this->pdf->Output("Seettu Summary".date('Y-m-d').".pdf", 'I');

?>