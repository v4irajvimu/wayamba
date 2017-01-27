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
	        $i=0;
		    $a=-1;
			static $j=-1;
			$my_array=array();
			$Goss=array();
			$net=array();

			foreach ($purchase as $value) {
                  $my_array[]=$value->nno;
			}

			foreach ($sum as $sum){
                        	$Goss[]=$sum->gsum;
                        	$net[]=$sum->nsum;
                        	$addi[]=$sum->addi;
                        	$a++;
                        }

		    



        	$this->pdf->SetFont('helvetica', 'BUI',12);
		 	$this->pdf->Cell(0, 5, 'PURCHASE DETAILS',0,false, 'L', 0, '', 0, false, 'M', 'M');
			$this->pdf->Ln();
			
			
			$this->pdf->SetFont('helvetica', '',9);
		 	$this->pdf->Cell(0, 5, 'Date Between '. $dfrom.' and '.$dto ,0,false, 'L', 0, '', 0, false, 'M', 'M');


			 //----check data is available for print ----        
           if($value->nno == "")
           {
           	$this->pdf->SetX(80);
			$this->pdf->Cell(20, 1, "No Records For View ! ! !", '0', 0, 'L', 0);     
           }
           else
           {

		 	$this->pdf->SetFont('helvetica', 'B', 8);
		 	foreach ($purchase as $value) 
		 		{	


					if ($i==0 || $my_array[$i]!=$my_array[$i-1]) 
					{
						if ($j>=0) 
						{	
    $this->pdf->HaveMorePages(6);
							$this->pdf->Ln(1);
							$this->pdf->SetX(70);
							$this->pdf->SetFont('helvetica','B',8);
						 	$this->pdf->Cell(20, 1, "", '0', 0, 'L', 0);
						 	$this->pdf->Cell(50, 1, "", '0', 0, 'L', 0);
						 	$this->pdf->Cell(35, 1, "Total Goss               Rs", '0', 0, 'L', 0);
						 	$this->pdf->Cell(20, 1, $Goss[$j], '0', 0, 'R', 0);
						 	$this->pdf->Cell(20, 1, "", '0', 0, 'L', 0);
			 
			 				$this->pdf->Ln();
    $this->pdf->HaveMorePages(6);
							$this->pdf->SetX(70);
						 	$this->pdf->Cell(20, 1, "", '0', 0, 'L', 0);
						 	$this->pdf->Cell(50, 1, "", '0', 0, 'L', 0);
						 	$this->pdf->Cell(35, 1, "Additional                Rs", '0', 0, 'L', 0);
						 	$this->pdf->Cell(20, 1, $addi[$j], '0', 0, 'R', 0);
						 	$this->pdf->Cell(20, 1, "", '0', 0, 'L', 0);
			 
			 				$this->pdf->Ln();
    $this->pdf->HaveMorePages(6);
							$this->pdf->SetX(70);
						 	$this->pdf->Cell(20, 1, "", '0', 0, 'L', 0);
						 	$this->pdf->Cell(50, 1, "", '0', 0, 'L', 0);
						 	$this->pdf->Cell(35, 1, "Total Net Amount    Rs", '0', 0, 'L', 0);
						 	$this->pdf->Cell(20, 1, $net[$j], 'TB', 0, 'R', 0);
						 	$this->pdf->Cell(20, 1, "", '', 0, 'L', 0);

							// $this->pdf->Ln();
$this->pdf->Ln(3);$this->pdf->Cell(0,0,"",array('B' => array('dash' => 2),));$this->pdf->SetLineStyle(array('dash' => 0));
		 					$this->pdf->Ln();
						}

					$j++;


		 			if ($i==0) 
		 			{
		 				$this->pdf->setY(35);
		 			}

    $this->pdf->HaveMorePages(6*5);
				    $this->pdf->Ln();
				 	$this->pdf->SetX(16);
		 			$this->pdf->SetFont('helvetica', 'B', 8);
				 	$this->pdf->Cell(15, 1, 'GRAN No  ', '0', 0, 'L', 0);
		 			$this->pdf->SetFont('helvetica', '', 8);
				 	$this->pdf->Cell(60, 1, ":- ".$value->nno, '0', 0, 'L', 0);				 					 	
				 	$this->pdf->Cell(60, 1, '', '0', 0, 'L', 0);
		 			$this->pdf->SetFont('helvetica', 'B', 8);
				 	$this->pdf->Cell(15, 1, "Invoice No", '0', 0, 'L', 0);
		 			$this->pdf->SetFont('helvetica', '', 8);
				 	$this->pdf->Cell(20, 1, ":- ".$value->inv_no, '0', 0, 'L', 0);

				 	
				 	$this->pdf->Ln();

					$this->pdf->SetX(16);
		 			$this->pdf->SetFont('helvetica', 'B', 8);
				 	$this->pdf->Cell(15, 1, "Date  ", '0', 0, 'L', 0);
		 			$this->pdf->SetFont('helvetica', '', 8);
				 	$this->pdf->Cell(50, 1, ":- ".$value->ddate, '0', 0, 'L', 0);
				 	$this->pdf->Cell(20, 1, "", '0', 0, 'L', 0);
				 	$this->pdf->Cell(20, 1, "", '0', 0, 'L', 0);
				 	$this->pdf->Cell(20, 1, "", '0', 0, 'L', 0);
		 
		 			$this->pdf->Ln();

					$this->pdf->SetX(16);
		 			$this->pdf->SetFont('helvetica', 'B', 8);
				 	$this->pdf->Cell(15, 1, "Supplier  ", '0', 0, 'L', 0);
		 			$this->pdf->SetFont('helvetica', '', 8);
				 	$this->pdf->Cell(50, 1, ":- ".$value->supp_id." | ".$value->name, '0', 0, 'L', 0);
				 	$this->pdf->Cell(20, 1, "", '0', 0, 'L', 0);
				 	$this->pdf->Cell(20, 1, "", '0', 0, 'L', 0);
				 	$this->pdf->Cell(20, 1, "", '0', 0, 'L', 0);
		 	
					$this->pdf->Ln();
					$this->pdf->Ln();


	 				//$this->pdf->SetY(45);
	 				$this->pdf->SetX(16);
					$this->pdf->SetFont('helvetica','B',8);
                    $this->pdf->Cell(30, 6," Item Code", '1', 0, 'C', 0);
					$this->pdf->Cell(60, 6," Description", '1', 0, 'C', 0);
                    $this->pdf->Cell(10, 6,"Qty ", '1', 0, 'C', 0);
                    $this->pdf->Cell(20, 6,"Price ", '1', 0, 'C', 0);
                    $this->pdf->Cell(20, 6,"Gross Amount ", '1', 0, 'C', 0);
                    $this->pdf->Cell(20, 6,"Discount ", '1', 0, 'C', 0);
                    $this->pdf->Cell(20, 6,"Net Amount ", '1', 0, 'C', 0);
                    $this->pdf->Ln();

 				}
    $this->pdf->HaveMorePages(6);
				//$this->pdf->SetY(45);
 				$this->pdf->SetX(16);
				$this->pdf->SetFont('helvetica','',8);
				$this->pdf->SetLineStyle(array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0.1, 'color' => array(0, 0, 0)));
                $this->pdf->Cell(30, 6,$value->code, '1', 0, 'L', 0);
				$this->pdf->Cell(60, 6,$value->description,'1', 0, 'L', 0);
                $this->pdf->Cell(10, 6,$value->qty, '1', 0, 'R', 0);
                $this->pdf->Cell(20, 6,$value->price, '1', 0, 'R', 0);
                $this->pdf->Cell(20, 6,$value->gross_a, '1', 0, 'R', 0);
                $this->pdf->Cell(20, 6,$value->discount, '1', 0, 'R', 0);
                $this->pdf->Cell(20, 6,$value->amount, '1', 0, 'R', 0);
                $this->pdf->Ln();
                $i++;
                	
            }
        $this->pdf->Ln(1);
      
		$this->pdf->SetX(76);
		$this->pdf->SetFont('helvetica','B',8);
	 	$this->pdf->Cell(20, 1, "", '0', 0, 'L', 0);
	 	$this->pdf->Cell(50, 1, "", '0', 0, 'L', 0);
	 	$this->pdf->Cell(30, 1, "Total Goss               Rs", '0', 0, 'L', 0);
	 	$this->pdf->Cell(20, 1, $Goss[$a], '0', 0, 'R', 0);
	 	$this->pdf->Cell(20, 1, "", '0', 0, 'L', 0);
		 
		  $this->pdf->Ln();
      
		$this->pdf->SetX(76);
	 	$this->pdf->Cell(20, 1, "", '0', 0, 'L', 0);
	 	$this->pdf->Cell(50, 1, "", '0', 0, 'L', 0);
	 	$this->pdf->Cell(30, 1, "Additional                Rs", '0', 0, 'L', 0);
	 	$this->pdf->Cell(20, 1, $addi[$a], '0', 0, 'R', 0);
	 	$this->pdf->Cell(20, 1, "", '0', 0, 'L', 0);
	 	 
		$this->pdf->Ln();
		$this->pdf->SetX(76);
	 	$this->pdf->Cell(20, 1, "", '0', 0, 'L', 0);
	 	$this->pdf->Cell(50, 1, "", '0', 0, 'L', 0);
	 	$this->pdf->Cell(30, 1, "Total Net Amount    Rs", '0', 0, 'L', 0);
	 	$this->pdf->Cell(20, 1, $net[$a], 'TB', 0, 'R', 0);
	 	$this->pdf->Cell(20, 1, "", '', 0, 'L', 0);
$this->pdf->Ln(3);$this->pdf->Cell(0,0,"",array('B' => array('dash' => 2),));$this->pdf->SetLineStyle(array('dash' => 0));
		$this->pdf->Ln();


	}
		$this->pdf->Output("Purchase Detail".date('Y-m-d').".pdf", 'I');

?>