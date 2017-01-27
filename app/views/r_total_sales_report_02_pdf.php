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

        	$this->pdf->SetFont('helvetica', 'BI',10);
		 	$this->pdf->Cell(70, 5, 'Total Sales Report 02',0,false, 'L', 0, '', 0, false, 'M', 'M');
			

			$this->pdf->setY(25);
            $this->pdf->Cell(70, 1,"",'T',0, 'L', 0);
            $this->pdf->Ln(); 

			$this->pdf->SetFont('helvetica', '',9);
		 	$this->pdf->Cell(0, 5, 'Date Between '. $dfrom.' and '.$dto ,0,false, 'L', 0, '', 0, false, 'M', 'M');
			$this->pdf->Ln();

	
			if($catgory!="0"){
				$this->pdf->SetX(30);
				$this->pdf->SetFont('helvetica', 'B',8);
				if($catgory=="RSX"){
					$this->pdf->Cell(100, 6,"Category : ".$catgory." - Retail Sales", '0', 0, 'L', 0);
				}else{
					$this->pdf->Cell(100, 6,"Category : ".$catgory." - Whole Sales", '0', 0, 'L', 0);
				}
				$this->pdf->Ln();
				}

			if($custom_name!=""){
				$this->pdf->SetX(30);
				$this->pdf->SetFont('helvetica', 'B',8);
				$this->pdf->Cell(100, 6,"Customer : ".$custom_name, '0', 0, 'L', 0);
				$this->pdf->Ln();
				$this->pdf->Ln();
			}
			

			 //----check data is available for print ----        
           

		 				$this->pdf->GetY();
		 				$this->pdf->SetX(15);
						$this->pdf->SetFont('helvetica','B',7);
						$this->pdf->Cell(15, 6,"Date", '1', 0, 'C', 0);
                        $this->pdf->Cell(12, 6,"No", '1', 0, 'C', 0);
                        $this->pdf->Cell(20, 6,"NIC", '1', 0, 'C', 0);
                        $this->pdf->Cell(40, 6,"Customer", '1', 0, 'C', 0);
                        $this->pdf->Cell(20, 6,"Cash Gross", '1', 0, 'C', 0);
                        $this->pdf->Cell(20, 6,"Credit Gross", '1', 0, 'C', 0);
                        $this->pdf->Cell(20, 6,"Discount", '1', 0, 'C', 0);
                        $this->pdf->Cell(20, 6,"Additions", '1', 0, 'C', 0);
                        $this->pdf->Cell(18, 6,"Cash Net", '1', 0, 'C', 0);
                        $this->pdf->Cell(18, 6,"Credit Net", '1', 0, 'C', 0);
                        $this->pdf->Cell(18, 6,"Total Net", '1', 0, 'C', 0);
                      //  $this->pdf->Cell(20, 6,"Amount", '1', 0, 'C', 0);
                   
                        $this->pdf->Ln();

                       // $tot_gross=$tot_amt=$tot_amt1=$tot_gross1=$tot_discount=$tot_add=$tot_add2=$tot=(float)0;
                   

                       foreach ($value as $row){

						//$this->pdf->SetY(45);
		 				$this->pdf->SetX(15);
		 				$this->pdf->SetLineStyle(array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0.1, 'color' => array(0, 0, 0)));
						$this->pdf->SetFont('helvetica','',7);

						// $tot_gross=(float)$row->gross_amount;
                      //	$tot_amt=$tot_gross-(float)$row->discount_amount;
                      	
                      	/*if($row->is_add=="0"){
                      		$tot_amt1=	$tot_amt-(float)$row->additional;
                      	}

                      	if($row->is_add==1){
                      		$tot_amt1=	$tot_amt+(float)$row->additional;
                      	}*/
						

						$aa = $this->pdf->getNumLines($row->name, 50);
               			$heigh=6*$aa;

           			    
           			   $this->pdf->MultiCell(15, $heigh, $row->ddate,1, 'R', 0, 0, '', '', true, 0, false, true, 0);
		               $this->pdf->MultiCell(12, $heigh, $row->nno,1, 'R', 0, 0, '', '', true, 0, false, true, 0);
		               $this->pdf->MultiCell(12, $heigh, $row->sub_no,1, 'R', 0, 0, '', '', true, 0, false, true, 0);
		               $this->pdf->MultiCell(20, $heigh, $row->nic,1, 'L', 0, 0, '', '', true, 0, false, true, 0);
		               $this->pdf->MultiCell(40, $heigh, $row->name,1, 'L', 0, 0, '', '', true, 0, false, true, 0);
		               $this->pdf->MultiCell(20, $heigh, $row->gross_amount,1, 'R', 0, 0, '', '', true, 0, false, true, 0);
		               $this->pdf->MultiCell(20, $heigh, $row->discount_amount,1, 'R', 0, 0, '', '', true, 0, false, true, 0);
		               $this->pdf->MultiCell(20, $heigh, $row->Additional,1, 'R', 0, 0, '', '', true, 0, false, true, 0);
		               $this->pdf->MultiCell(18, $heigh, $row->net_amount,1, 'R', 0, 1, '', '', true, 0, false, true, 0);
		             
		      			$gross_amt += $row->gross_amount;
		      			$discount_amt +=$row->discount_amount;
		      			$addtional_amt += $row->Additional;
		      			$net_amt +=  $row->net_amount;

		               
		              // $this->pdf->MultiCell(5, $heigh, $tot_amt1,1, 'R', 0, 1, '', '', true, 0, false, true, 0);
                      
                      	

                     // 	$tot_gross1+=(float)$row->gross_amount;
                      //	$tot_discount+=(float)$row->discount_amount;

                     // 	if($row->is_add==0){
                      		//$tot_add+=(float)$row->additional;
                      	//}
                     //	if($row->is_add==1){
                      		//$tot_add2+=(float)$row->additional;
                      //	}
                      	
                      //  $tot+=$tot_amt1;                  
                        	
                         }

                        
                      $this->pdf->SetFont('helvetica','B',8);
					   // $this->pdf->SetX(15);
					  $this->pdf->Cell(79, 6,"", '0', 0, 'L', 0);
					  //  $this->pdf->Cell(12, 6,"", '0', 0, 'L', 0);
					  //  $this->pdf->Cell(12, 6,"", '0', 0, 'R', 0);
					  $this->pdf->Cell(20, 6,"Total ", '0', 0, 'C', 0);
					  $this->pdf->Cell(20, 6,number_format($gross_amt,2), 'BU', 0, 'R', 0);
					  $this->pdf->Cell(20, 6,number_format($discount_amt,2), 'BU', 0, 'R', 0);
					  $this->pdf->Cell(20, 6,number_format($addtional_amt,2), 'BU', 0, 'R', 0);
					  $this->pdf->Cell(18, 6,number_format($net_amt ,2), 'BU', 0, 'R', 0);
					   // $this->pdf->Cell(20, 6,number_format($tot,2), '1', 0, 'R', 0);

                        

	// $this->pdf->footerSet($employee,$amount,$additional,$discount,$user);
	$this->pdf->Output("Cash Sale Summary".date('Y-m-d').".pdf", 'I');

?>