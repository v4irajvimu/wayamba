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
			$this->pdf->Ln();$this->pdf->Ln();
		}

		
		$this->pdf->setY(28);

        	$this->pdf->SetFont('helvetica', 'BU',12);
		 	$this->pdf->Cell(0, 5, 'SEETTU ITEM SETUP  SUMMARY',0,false, 'L', 0, '', 0, false, 'M', 'M');
			$this->pdf->Ln();$this->pdf->Ln();

			
           
			$x=0;

			$this->pdf->setY(32);
			$this->pdf->Ln();
			foreach($sum as $value)
			{
				if($x==0)
			   {   
           	
		           
		           	$this->pdf->SetFont('helvetica', 'B',10);
				 	$this->pdf->Cell(30, 6, 'CATEGORY',0,false, 'L', 0);
				 	$this->pdf->Cell(5, 6," : ", '0', 0, 'C', 0);
				 	$this->pdf->Cell(10, 6,$value->settu_item_category , '0', 0, 'L', 0);
				 	$this->pdf->Cell(50, 6, $value->name , '0', 0, 'C', 0);
					$this->pdf->Ln();
					$this->pdf->SetFont('helvetica', 'B',9);
					$this->pdf->Cell(50, 6, strtoupper($value->discription) , '0', 0, 'L', 0);
					$this->pdf->Ln();
					
					$x++;
           		}

			}
            
			$final= $item_cat=0;
			$z=0;
            $y=1;
            foreach($sum as $value)
            { 

				
				//$this->pdf->SetY(45);
				if($z==0)
				{
					
					
					$this->pdf->SetX(16);
					$this->pdf->SetFont('helvetica', 'B',9);
					$this->pdf->Cell(50, 6,"Category Code  :  " .$value->code , '0', 0, 'L', 0);
					$item_cat=1;
					$this->pdf->Ln();
					$this->pdf->Ln();
					//$this->pdf->SetY(50);
					$this->pdf->SetX(16);

					$this->pdf->SetFont('helvetica','B',9);

					// Headings-------------------------------------
					$this->pdf->Cell(10, 6,"No", '1', 0, 'C', 0);
					$this->pdf->Cell(35, 6,"Item Code", '1', 0, 'C', 0);
					$this->pdf->Cell(70, 6,"Name", '1', 0, 'C', 0);
					$this->pdf->Cell(20, 6,"Quantity", '1', 0, 'C', 0);
					$this->pdf->Cell(30, 6,"Unit Price", '1', 0, 'C', 0);
		            //$this->pdf->Ln();
				 	
				 // 	$this->pdf->SetLineStyle(array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0.1, 'color' => array(0, 0, 0)));
					// $this->pdf->SetFont('helvetica','',9);
					// $this->pdf->SetX(16);

					// $bb=$this->pdf->getNumLines($value->description, 70); 
   
		   //     		$heigh=6*$bb;
		            
			  //       // Deatils loop---------------------------------
					// $this->pdf->MultiCell(10, $heigh, $y, 1, 'R', 0, 0, '', '', true, 0, false, true, 0);
			  //       $this->pdf->MultiCell(35, $heigh, $value->category_code, 1, 'L', 0, 0, '', '', true, 0, false, true, 0);
			  //       $this->pdf->MultiCell(70, $heigh, $value->description, 1, 'L', 0, 0, '', '', true, 0, false, true, 0);
			  //       $this->pdf->MultiCell(20, $heigh, $value->qty, 1, 'R', 0, 0, '', '', true, 0, false, true, 0);
			  //       $this->pdf->MultiCell(30, $heigh, $value->item_max_price, 1, 'R', 0, 0, '', '', true, 0, false, true, 0);    
					
					
	                $old_code_id=$value->code;
	                $old_no=$value->no;
	                $this->pdf->Ln();
	                //$y++;
	                $z++;

	                //var_dump($old_code_id);
				}
				
                $code_id=$value->code;
                $new_no=$value->no;
                
                
                	if($code_id==$old_code_id)
                	
	                {
	                	//if($new_no!= $old_no)
	                	//{
	                		$this->pdf->SetX(16);
		                	$this->pdf->SetLineStyle(array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0.1, 'color' => array(0, 0, 0)));
							$this->pdf->SetFont('helvetica','',9);
							
							$bb=$this->pdf->getNumLines($value->description, 70); 
	   
				       		$heigh=6*$bb;
				            
					        // Deatils loop---------------------------------
							$this->pdf->MultiCell(10, $heigh, $y, 1, 'R', 0, 0, '', '', true, 0, false, true, 0);
					        $this->pdf->MultiCell(35, $heigh, $value->item_code, 1, 'L', 0, 0, '', '', true, 0, false, true, 0);
					        $this->pdf->MultiCell(70, $heigh, $value->description, 1, 'L', 0, 0, '', '', true, 0, false, true, 0);
					        $this->pdf->MultiCell(20, $heigh, $value->qty, 1, 'R', 0, 0, '', '', true, 0, false, true, 0);
					        $this->pdf->MultiCell(30, $heigh, $value->item_max_price, 1, 'R', 0, 1, '', '', true, 0, false, true, 0);    
							
			                $old_code_id=$value->code;
			                //$this->pdf->Ln();
			                
			                $y++;
			                $final=1;	
	                	//}
	                	
	                }

	                else if($code_id!=$old_code_id)
	                {
	                	$y=$y-1;
	                	$this->pdf->SetX(16);
	                	$this->pdf->SetLineStyle(array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0.1, 'color' => array(0, 0, 0)));
						$this->pdf->SetFont('helvetica','B',9);

	                	$this->pdf->Cell(135, 6," ", '0', 0, 'L', 0);
	                	$this->pdf->Cell(30, 6,"Total Items  :  ".$y, '0', 0, 'R', 0);
	                	
	                	$y=1;
	                	//$this->pdf->SetY(45);
	                	$this->pdf->Ln();
	                	$this->pdf->SetX(16);
						$this->pdf->SetFont('helvetica', 'B',9);
						$this->pdf->Cell(50, 6, "Category Code  :  " .$code_id , '0', 0, 'L', 0);
						$this->pdf->Ln();
						$this->pdf->Ln();

						$item_cat++;

						//$this->pdf->SetY(50);
						$this->pdf->SetX(16);
						$this->pdf->SetFont('helvetica','B',9);
						$this->pdf->Cell(10, 6,"No", '1', 0, 'C', 0);
						$this->pdf->Cell(35, 6,"Item Code", '1', 0, 'C', 0);
						$this->pdf->Cell(70, 6,"Name", '1', 0, 'C', 0);
						$this->pdf->Cell(20, 6,"Quantity", '1', 0, 'C', 0);
						$this->pdf->Cell(30, 6,"Unit Price", '1', 0, 'C', 0);
			            $this->pdf->Ln();
					 	
					 	$this->pdf->SetX(16);
					 	$this->pdf->SetLineStyle(array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0.1, 'color' => array(0, 0, 0)));
						$this->pdf->SetFont('helvetica','',9);
						$this->pdf->SetX(16);
						$bb=$this->pdf->getNumLines($value->description, 70); 
   
			       		$heigh=6*$bb;
			            
				        // Deatils loop---------------------------------
						$this->pdf->MultiCell(10, $heigh, $y, 1, 'R', 0, 0, '', '', true, 0, false, true, 0);
				        $this->pdf->MultiCell(35, $heigh, $value->item_code, 1, 'L', 0, 0, '', '', true, 0, false, true, 0);
				        $this->pdf->MultiCell(70, $heigh, $value->description, 1, 'L', 0, 0, '', '', true, 0, false, true, 0);
				        $this->pdf->MultiCell(20, $heigh, $value->qty, 1, 'R', 0, 0, '', '', true, 0, false, true, 0);
				        $this->pdf->MultiCell(30, $heigh, $value->item_max_price, 1, 'R', 0, 1, '', '', true, 0, false, true, 0);    
						
		                $old_code_id=$value->code;
		                $old_no=$value->no;
		                $this->pdf->Ln();
		                $y++;
		                $final=1;
	                }

			}
			if($final==1)
			{
				$y=$y-1;
				$this->pdf->SetX(16);
				
            	$this->pdf->SetLineStyle(array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0.1, 'color' => array(0, 0, 0)));
				$this->pdf->SetFont('helvetica','B',9);


            	$this->pdf->Cell(135, 6," ", '0', 0, 'L', 0);
            	$this->pdf->Cell(30, 6,"Total Items  :  ".$y, '0', 0, 'R', 0);
            	$this->pdf->Ln();


            	$this->pdf->SetX(16);
            	$this->pdf->SetLineStyle(array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0.1, 'color' => array(0, 0, 0)));
				$this->pdf->SetFont('helvetica','B',10);
            	$this->pdf->Cell(60, 6,"Entered Total Item Category  :  ".$item_cat, '0', 0, 'L', 0);
            	$this->pdf->Ln();
				$this->pdf->Ln();
				$this->pdf->Ln();
            		
			
				$y=1;
				$this->pdf->SetX(16);
				$this->pdf->SetFont('helvetica', 'B',9);
				$this->pdf->Cell(50, 6,"FREE ITEMS   ", '0', 0, 'L', 0);
				
				$item_cat=1;
				$this->pdf->Ln();
				$this->pdf->Ln();
				$this->pdf->Ln();
				//$this->pdf->SetY(50);
				$this->pdf->SetX(16);

				$this->pdf->SetFont('helvetica','B',9);

				// Headings-------------------------------------
				$this->pdf->Cell(10, 6,"No", '1', 0, 'C', 0);
				$this->pdf->Cell(35, 6,"Item Code", '1', 0, 'C', 0);
				$this->pdf->Cell(70, 6,"Name", '1', 0, 'C', 0);
				$this->pdf->Cell(20, 6,"Quantity", '1', 0, 'C', 0);
				$this->pdf->Cell(30, 6,"Unit Price", '1', 0, 'C', 0);
	            $this->pdf->Ln();
			 	
			 	$this->pdf->SetLineStyle(array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0.1, 'color' => array(0, 0, 0)));
				$this->pdf->SetFont('helvetica','',9);
				$this->pdf->SetX(16);

				
	            foreach ($free_item as $row) 
	            {
	            	
	            	$bb=$this->pdf->getNumLines($row->description, 70); 

	       			$heigh=6*$bb;
	            	
			        // Deatils loop---------------------------------
					$this->pdf->MultiCell(10, $heigh, $y, 1, 'R', 0, 0, '', '', true, 0, false, true, 0);
			        $this->pdf->MultiCell(35, $heigh, $row->item_code, 1, 'L', 0, 0, '', '', true, 0, false, true, 0);
			        $this->pdf->MultiCell(70, $heigh, $row->description, 1, 'L', 0, 0, '', '', true, 0, false, true, 0);
			        $this->pdf->MultiCell(20, $heigh, $row->qty, 1, 'R', 0, 0, '', '', true, 0, false, true, 0);
			        $this->pdf->MultiCell(30, $heigh, $row->item_max_price, 1, 'R', 0, 0, '', '', true, 0, false, true, 0);    
					
					
		            $old_code_id=$row->code;
		            $old_no=$row->no;
		            $this->pdf->Ln();
		            $y++;
		       	}
		            $y=$y-1;
		            $this->pdf->SetX(16);
		        	$this->pdf->SetLineStyle(array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0.1, 'color' => array(0, 0, 0)));
					$this->pdf->SetFont('helvetica','B',9);

		        	$this->pdf->Cell(135, 6," ", '0', 0, 'L', 0);
		        	$this->pdf->Cell(30, 6,"Total Items  :  ".$y, '0', 0, 'R', 0);
		        	$this->pdf->Ln();

               }
	// $this->pdf->footerSet($employee,$amount,$additional,$discount,$user);
	$this->pdf->Output("Seettu Item Setup Summary".date('Y-m-d').".pdf", 'I');

?>