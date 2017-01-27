<?php
error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
//$this->pdf->setPrintHeader($header,$type,$duration);

		$this->pdf->setPrintFooter(true);
		$this->pdf->setPrintHeader(true);
		$this->pdf->setPrintHeader($header,$type); 

        $this->pdf->SetFont('helvetica', 'B', 16);
		$this->pdf->AddPage($orientation,$page);   // L or P amd page type A4 or A3
 		foreach($branch as $ress){
 			
 			$this->pdf->headerSet3($ress->name,$ress->address,$ress->tp,$ress->fax,$ress->email);
		}
		$cus_name=$cus_address="";
		foreach($customer as $cus){
			$cus_name=$cus->name;
			$cus_address=$cus->address1." ".$cus->address2." ".$cus->address3;
			$cus_id=$cus->code;
		}

		

			$this->pdf->setY(25);
            
		 	$this->pdf->SetFont('helvetica', 'BU',10);
    		$this->pdf->Cell(0, 5, 'PRICE CHANGE  ',0,false, 'L', 0, '', 0, false, 'M', 'M');
		 	
    		
		 	$this->pdf->SetFont('helvetica', 'B', 8);
		 	$this->pdf->setY(30);
		 	$this->pdf->Cell(20, 1, "Item - ", '0', 0, 'L', 0);
		 	$this->pdf->Cell(30, 1, $item, '0', 0, 'L', 0);

		 	$this->pdf->setY(35);
		 	$this->pdf->Cell(30, 1, 'Date Between  -'. $df.' and '.$dto , '0', 0, 'L', 0);
		 	$this->pdf->Ln();
		 	
		 	$this->pdf->Ln();

		 	
		 	$this->pdf->SetY(45);
			$this->pdf->SetFont('helvetica','B',8);
                        $this->pdf->Cell(20, 6,"Trans Code", '1', 0, 'C', 0);
						$this->pdf->Cell(20, 6,"Trans Date", '1', 0, 'C', 0);
                        $this->pdf->Cell(30, 6,"Cost", '1', 0, 'C', 0);
                        $this->pdf->Cell(30, 6,"Last Price", '1', 0, 'C', 0);
                        $this->pdf->Cell(30, 6,"New last Price", '1', 0, 'C', 0);
                        $this->pdf->Cell(30, 6,"Max Price", '1', 0, 'C', 0);
                        $this->pdf->Cell(30, 6,"New max price", '1', 0, 'C', 0);                
                        $this->pdf->Ln();
                        $x=1;
                        foreach($items as $row){
                        $this->pdf->GetY();
						$this->pdf->Cell(20, 6,$row->nno, '1', 0, 'L', 0);
                        $this->pdf->Cell(20, 6,$row->ddate, '1', 0, 'L', 0);
                        $this->pdf->Cell(30, 6,$row->cost, '1', 0, 'L', 0);
                        $this->pdf->Cell(30, 6,$row->last_price, '1', 0, 'R', 0);
                        $this->pdf->Cell(30, 6,$row->last_price_new, '1', 0, 'R', 0);
                        $this->pdf->Cell(30, 6,$row->max_price, '1', 0, 'R', 0);
                        $this->pdf->Cell(30, 6,$row->max_price_new, '1', 0, 'R', 0);
                        $this->pdf->Ln();
                        $x++;
                        }

	$this->pdf->footerSet3($employee,$amount,$additional,$discount,$user);

	$this->pdf->Output("Price Change_".date('Y-m-d').".pdf", 'I');

?>