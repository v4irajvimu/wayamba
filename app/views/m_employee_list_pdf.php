<?php
error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
		$this->pdf->setPrintHeader($header,$type,$duration);
        $this->pdf->setPrintFooter(true);
        $this->pdf->setPrintHeader(true);
        //print_r($sum);
        $this->pdf->SetFont('helvetica', 'B', 16);
		$this->pdf->AddPage("P","A4");   // L or P amd page type A4 or A3

 		foreach($branch as $ress){//Common
 		 			$this->pdf->headerSet3($ress->name,$ress->address,$ress->tp,$ress->fax,$ress->email);
 				}

			$this->pdf->Ln(3);
        	$this->pdf->SetFont('helvetica', 'IBU',12);
		 	$this->pdf->Cell(0, 5, 'Employee List  ',0,false, 'L', 0, '', 0, false, 'M', 'M');

			$this->pdf->Ln();$this->pdf->Ln();

		 	$this->pdf->SetFont('helvetica', 'B', 10);
		 	//$this->pdf->setY($Yac);


		 	$this->pdf->Cell(15, 6,"Code", '1', 0, 'C', 0);
		 	$this->pdf->Cell(50, 6,"Name", '1', 0, 'C', 0);
		 	$this->pdf->Cell(50, 6,"Address", '1', 0, 'C', 0);
		 	$this->pdf->Cell(30, 6,"Tel", '1', 0, 'C', 0);
		 	$this->pdf->Cell(25, 6,"Date Of Join", '1', 0, 'C', 0);
		 	$this->pdf->Cell(15, 6,"Status", '1', 0, 'C', 0);




		 	$this->pdf->Ln();

			$this->pdf->SetFont('helvetica', 'N', 10);

 		foreach($employee as $res){

 			if (empty($res->address1)) {
 				$address="-";
 			}
 			else {
				if (empty($res->address2)) {
 					$address=($res->address1); 					
 				}
 				else {
					if (empty($res->address3)) {
	 					$address=($res->address1).", ".($res->address2); 					
	 				} 
	 				else {
	 					$address=($res->address1).", ".($res->address2).", ".($res->address3); 
	 				}				

 				}

 			}

 			if (empty($res->tp1)) {
 				$tp="-";
 			}
 			else {
				if (empty($res->tp2)) {
 					$tp=($res->tp1); 					
 				}
 				else {
					if (empty($res->tp3)) {
	 					$tp=($res->tp1).", ".($res->tp2); 					
	 				} 
	 				else {
	 					$tp=($res->tp1).", ".($res->tp2).", ".($res->tp3); 
	 				}				

 				}

 			}


			$inactive=$res->inactive;
				if ($inactive=="0") $inactive="Active"; else $inactive="Inactive";


	        $this->pdf->MultiCell(15, 6, $res->code, $border=1, $align='L', $fill=false, $ln=0, $x=($this->pdf->GetX()), $y=$this->pdf->GetY(), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=6, $valign='M', $fitcell=true);
	        $this->pdf->MultiCell(50, 6, $res->name, $border=1, $align='L', $fill=false, $ln=0, $x=($this->pdf->GetX()), $y=$this->pdf->GetY(), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=6, $valign='M', $fitcell=true);
	        $this->pdf->MultiCell(50, 6, $address, $border=1, $align='L', $fill=false, $ln=0, $x=($this->pdf->GetX()), $y=$this->pdf->GetY(), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=6, $valign='M', $fitcell=true);
	        $this->pdf->MultiCell(30, 6, $tp, $border=1, $align='L', $fill=false, $ln=0, $x=($this->pdf->GetX()), $y=$this->pdf->GetY(), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=6, $valign='M', $fitcell=true);
	        $this->pdf->MultiCell(25, 6, $res->doj, $border=1, $align='L', $fill=false, $ln=0, $x=($this->pdf->GetX()), $y=$this->pdf->GetY(), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=6, $valign='M', $fitcell=true);
	        $this->pdf->MultiCell(15, 6, $inactive, $border=1, $align='L', $fill=false, $ln=1, $x=($this->pdf->GetX()), $y=$this->pdf->GetY(), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=6, $valign='M', $fitcell=true);
			}


//$retVal = (condition) ? a : b ;
	
	$this->pdf->Output("Employee Details_".date('Y-m-d').".pdf", 'I');

?>