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
	

			//$this->pdf->setY(20);
			// $this->pdf->Ln(3);
        	$this->pdf->SetFont('helvetica', 'BU',10);
		 	$this->pdf->Cell(0, 6, 'CREDIT SALES - GROSS PROFIT',0,false, 'L', 0, '', 0, false, 'M', 'M');
			$this->pdf->Ln();
			// $this->pdf->Ln();
			$this->pdf->SetX(16);
			$this->pdf->SetFont('helvetica', '',9);
		 	$this->pdf->Cell(0, 6, 'Date Between '. $dfrom.' and '.$dto ,0,false, 'L', 0, '', 0, false, 'M', 'M');
			 //$this->pdf->Ln();
			//$this->pdf->Ln(7);
			//$this->pdf->Ln(3);
             
                        //$this->pdf->Ln(12);
                       // $tot_dis=(float)0;
                        //$tot_gross=(float)0;
                        //$tot_net=(float)0;

		 	 foreach($r_branch_name as $row){
		        
		       $branch_name=$row->name;
		       $cluster_name=$row->description;
		       $cl_id=$row->code;
		       $bc_id=$row->bc;

		       	$this->pdf->SetX(16);
			   	$this->pdf->setY(32);
			   	$this->pdf->SetFont('helvetica', 'B', 9);
			   	$this->pdf->Cell(30,5,'Cluster', '0', 0, 'L', 0);
			   	$this->pdf->Cell(5, 5,':', '0', 0, 'L', 0);
			   	$this->pdf->SetFont('helvetica', '', 9);
			   	$this->pdf->Cell(120, 5,"$cl_id - $cluster_name", '0', 0, 'L', 0);
			   	$this->pdf->Ln();

			   	//$this->pdf->setY(32);
			   	$this->pdf->SetX(16);
			   	$this->pdf->SetFont('helvetica', 'B', 9);
			   	$this->pdf->Cell(30, 5,'Branch', '0', 0, 'L', 0);
			   	$this->pdf->Cell(5, 5,':', '0', 0, 'L', 0);
			   	$this->pdf->SetFont('helvetica', '', 9);
			   	$this->pdf->Cell(20, 5,"$bc_id - $branch_name", '0', 0, 'L', 0);
			   	$this->pdf->Ln();

			}


			
		   	
		   	foreach($r_supplier_name as $row){
		        
		       $supplier_code=$row->code;
		       $supplier_name=$row->name;

			    // $this->pdf->setY(36);
		       	$this->pdf->SetX(16);
			    $this->pdf->SetFont('helvetica', 'B', 9);
			   	$this->pdf->Cell(30, 5,'Supplier', '0', 0, 'L', 0);
			   	$this->pdf->Cell(5, 5,':', '0', 0, 'L', 0);
			   	$this->pdf->SetFont('helvetica', '', 9);
			   	$this->pdf->Cell(120, 5,"$supplier_code - $supplier_name", '0', 0, 'L', 0);
			   	$this->pdf->Ln(); 
			}

			foreach($r_item_name as $row){
		        
		       $item_code=$row->code;
		       $item_name=$row->description;

			    // $this->pdf->setY(36);
		       	$this->pdf->SetX(16);
			    $this->pdf->SetFont('helvetica', 'B', 9);
			   	$this->pdf->Cell(30, 5,'Item', '0', 0, 'L', 0);
			   	$this->pdf->Cell(5, 5,':', '0', 0, 'L', 0);
			   	$this->pdf->SetFont('helvetica', '', 9);
			   	$this->pdf->Cell(120, 5,"$item_code - $item_name", '0', 0, 'L', 0);
			   	$this->pdf->Ln(); 
			}

		   	

		   	
			
			$this->pdf->SetY(58);
                        foreach ($sum as $value) {
						
    $heigh=6*(max(1,$this->pdf->getNumLines($value->description,35),$this->pdf->getNumLines($value->code, 30)));
    $this->pdf->HaveMorePages($heigh);

		 				$this->pdf->SetX(16);
		 				
		 				$this->pdf->SetLineStyle(array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0.1, 'color' => array(0, 0, 0)));
						$this->pdf->SetFont('helvetica','',8);

						// $aa = $this->pdf->getNumLines($value->description, 65);
		    //             $bb = $this->pdf->getNumLines($value->code, 20);
		    //             if($aa>$bb){
		    //                 $heigh=5*$aa;
		    //             }else{
		    //                 $heigh=5*$bb;
		    //             }
						$this->pdf->MultiCell(10, $heigh, $value->nno,  1, 'R', false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
						$this->pdf->MultiCell(25, $heigh, $value->code,  1, 'L', false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
						$this->pdf->MultiCell(35, $heigh, $value->description,  1, 'L', false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
						$this->pdf->MultiCell(10, $heigh, $value->qty,  1, 'R', false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
						$this->pdf->MultiCell(18, $heigh, $value->cost,  1, 'R', false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
						$this->pdf->MultiCell(18, $heigh, $value->price,  1, 'R', false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
						$this->pdf->MultiCell(18, $heigh, $value->cost_value,  1, 'R', false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
						$this->pdf->MultiCell(18, $heigh, $value->price_value,  1, 'R', false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
						$this->pdf->MultiCell(18, $heigh, $value->discount,  1, 'R', false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
						$this->pdf->MultiCell(18, $heigh, $value->profit,  1, 'R', false, 1, '', '', true, 0, false, true, $heigh,'M' ,false);
						 
                        $tot_cost+=(float)$value->cost_value;
                        $tot_price+=(float)$value->price_value;
                        $tot_discount+=(float)$value->discount;
                        $tot_profit+=(float)$value->profit;
                        	
                        }

                       
                        $this->pdf->SetFont('helvetica', 'B', 9);
						$this->pdf->SetX(16);
					 	$this->pdf->Cell(10, 6, "", '0', 0, 'L', 0);
					 	$this->pdf->Cell(25, 6, "", '0', 0, 'R', 0);
					 	$this->pdf->Cell(35, 6, "", '0', 0, 'C', 0);
					 	$this->pdf->Cell(10, 6, "", '0', 0, 'C', 0);
					 	$this->pdf->Cell(18, 6, "", '0', 0, 'C', 0);
					 	$this->pdf->Cell(18, 6, "Total", '0', 0, 'C', 0);
					 	$this->pdf->Cell(18, 6, number_format( $tot_cost,2), '1', 0, 'R', 0);
					 	$this->pdf->Cell(18, 6, number_format( $tot_price,2), '1', 0, 'R', 0);
					 	$this->pdf->Cell(18, 6, number_format( $tot_discount,2), '1', 0, 'R', 0);
					 	$this->pdf->Cell(18, 6, number_format($tot_profit,2), '1', 0, 'R', 0);
					 	



	
	$this->pdf->Output("Credit Sale Summary".date('Y-m-d').".pdf", 'I');

?>