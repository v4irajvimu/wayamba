<?php
		// echo '<pre>'.print_r($det,true).'</pre>';
		//  		exit;

error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
		$this->pdf->setPrintHeader($header,$type,$duration);
		$this->pdf->setPrintHeader(true,$type);
        $this->pdf->setPrintFooter(true);
        //$this->pdf->setPrintHeader(true);
        
        $this->pdf->SetFont('helvetica', 'B', 16);
		$this->pdf->AddPage($orientation,$page);   // L or P amd page type A4 or A3
// L or P amd page type A4 or A3
		foreach($branch as $ress){
 			$this->pdf->headerSet3($ress->name,$ress->address,$ress->tp,$ress->fax,$ress->email);	
		}
		 foreach($det as $row){
		 	$vehicle_no=$row->vehicle_no;
		 	$driver=$row->driv;
		 	$salesman=$row->salesm;
		 	$route=$row->route;

		 }
		 	$from=$_POST['from'];
		 	$to=$_POST['to'];
			
			$this->pdf->setY(20);
        	$this->pdf->SetFont('helvetica', 'BU', 12);
        	$this->pdf->Ln();

		  	$this->pdf->Cell(0, 5,'Seettu Invoice  ',0,false, 'L', 0, '', 0, false, 'M', 'M');
		  	$this->pdf->Ln();

		 	$this->pdf->SetFont('helvetica', '', 8);
		    $this->pdf->Cell(180, 1,"Date From - ".$from."  To - ".$to,0,false, 'L', 0, '', 0, false, 'M', 'M');
		    $this->pdf->Ln();	

		    $this->pdf->SetFont('helvetica', '', 9);
		 	$this->pdf->setY(30);
		 	$this->pdf->Ln();
		 	$this->pdf->Cell(20, 1, 'Vehicle ', '0', 0, 'L', 0);
		 	$this->pdf->Cell(5, 1, '', '0', 0, 'L', 0);
		 	$this->pdf->Cell(40, 1, $vehicle_no, '0', 0, 'L', 0);
		 	$this->pdf->Cell(30, 1, "", '0', 0, 'L', 0);
		 	
		 	$this->pdf->Cell(30, 1, "Driver ", '0', 0, 'L', 0);
		 	$this->pdf->Cell(5, 1, '', '0', 0, 'L', 0);
		 	$this->pdf->Cell(60, 1, $driver, '0', 0, 'L', 0);
		 	$this->pdf->Ln();

		 	$this->pdf->Cell(20, 1, 'Salesman', '0', 0, 'L', 0);
		 	$this->pdf->Cell(5, 1, '', '0', 0, 'L', 0);
		 	$this->pdf->Cell(40, 1, $salesman, '0', 0, 'L', 0);
		 	$this->pdf->Cell(30, 1, "", '0', 0, 'L', 0);
		 	
		 	$this->pdf->Cell(30, 1, "Route ", '0', 0, 'L', 0);
		 	$this->pdf->Cell(5, 1, '', '0', 0, 'L', 0);
		 	$this->pdf->Cell(60, 1, $route, '0', 0, 'L', 0);
		 	$this->pdf->Ln();

			$this->pdf->SetY(45);
			$this->pdf->SetX(15);
			
	        	$this->pdf->SetFont('helvetica','B',9);
				$this->pdf->Cell(10, 6, 'No', '1', 0, 'C', 0);
			 	$this->pdf->Cell(40, 6, "Organizer", '1', 0, 'C', 0);
			 	$this->pdf->Cell(15, 6, "No of Ins", '1', 0, 'C', 0);
			 	$this->pdf->Cell(40, 6, "Item", '1', 0, 'C', 0);
			 	$this->pdf->Cell(20, 6, "Price", '1', 0, 'C', 0);
			 	$this->pdf->Cell(20, 6, "Inst Amount ", '1', 0, 'C', 0);
			 	$this->pdf->Cell(20, 6, "Addi Charge ", '1', 0, 'C', 0);
			 	$this->pdf->Cell(20, 6, "Paid", '1', 0, 'C', 0);

	            $this->pdf->Ln();
	            

	            foreach($det as $row){
	            	$this->pdf->SetLineStyle(array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0.1, 'color' => array(0, 0, 0)));

		            $this->pdf->GetY(60);
		            $this->pdf->SetX(15);
		            $aa = $this->pdf->getNumLines($row->description, 60);
	        		$heigh=5*$aa;
					$this->pdf->SetFont('helvetica','',9);
		            $this->pdf->MultiCell(10, $heigh, $row->seettu_no, $border=1, $align='L', $fill=false, $ln=0, $x=($this->pdf->GetX()), $y=$this->pdf->GetY(), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=6, $valign='M', $fitcell=true);
		            $this->pdf->MultiCell(40, $heigh, $row->organizer, $border=1, $align='L', $fill=false, $ln=0, $x=($this->pdf->GetX()), $y=$this->pdf->GetY(), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=6, $valign='M', $fitcell=true);
		            $this->pdf->MultiCell(15, $heigh, $row->no_of_ins, $border=1, $align='L', $fill=false, $ln=0, $x=($this->pdf->GetX()), $y=$this->pdf->GetY(), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=6, $valign='M', $fitcell=true);
		            $this->pdf->MultiCell(40, $heigh, $row->item, $border=1, $align='L', $fill=false, $ln=0, $x=($this->pdf->GetX()), $y=$this->pdf->GetY(), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=6, $valign='M', $fitcell=true);
		            $this->pdf->MultiCell(20, $heigh, $row->price, $border=1, $align='R', $fill=false, $ln=0, $x=($this->pdf->GetX()), $y=$this->pdf->GetY(), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=6, $valign='M', $fitcell=true);   
		            $this->pdf->MultiCell(20, $heigh, $row->installement, $border=1, $align='R', $fill=false, $ln=0, $x=($this->pdf->GetX()), $y=$this->pdf->GetY(), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=6, $valign='M', $fitcell=true);
		            $this->pdf->MultiCell(20, $heigh, $row->addit_charge, $border=1, $align='R', $fill=false, $ln=0, $x=($this->pdf->GetX()), $y=$this->pdf->GetY(), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=6, $valign='M', $fitcell=true);
		            $this->pdf->MultiCell(20, $heigh, $row->paid, $border=1, $align='R', $fill=false, $ln=1, $x=($this->pdf->GetX()), $y=$this->pdf->GetY(), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=6, $valign='M', $fitcell=true);
		            
	            }
	            	

	$this->pdf->Output("Purchase Order".date('Y-m-d').".pdf", 'I');

?>