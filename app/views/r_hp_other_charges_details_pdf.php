<?php
	error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
	$this->pdf->setPrintHeader($header,$type,$duration);
  $this->pdf->setPrintFooter(true);
  $this->pdf->SetFont('helvetica', 'B', 16);
	$this->pdf->AddPage($orientation,$page);   // L or P amd page type A4 or A3

	foreach($branch as $ress){
		$this->pdf->headerSet3($ress->name,$ress->address,$ress->tp,$ress->fax,$ress->email);
	}
	foreach ($sum as $value) {
    $date=$value->ddate;
	}
		
	$this->pdf->setY(26);
	$this->pdf->SetFont('helvetica', 'BI',12);
	$this->pdf->Cell(0, 5, 'OTHER CHARGERS DETAILS',0,false, 'L', 0, '', 0, false, 'M', 'M');
	$this->pdf->Ln();
			
	$this->pdf->setY(29);
    $this->pdf->Cell(60, 1,"",'T',0, 'L', 0);
    $this->pdf->Ln(); 
    $this->pdf->SetFont('helvetica', '',9);
	$this->pdf->Cell(0, 5, 'Date Between '. $dfrom.' and '.$dto ,0,false, 'L', 0, '', 0, false, 'M', 'M');
	$this->pdf->Ln();
			
	$i=$ss=0;
	$a=-1;
	static $j=-1;
	$my_array=array();
	$Goss=array();
	$net=array();
	$tot=0;
 	$dis=0;
  	$net_tot=0;
	foreach ($sum as $value) {
    $my_array[]=$value->nno;
	}

  if($value->nno == ""){
    $this->pdf->SetX(80);
		$this->pdf->Cell(20, 1, "No Records For View ! ! !", '0', 0, 'L', 0);     
  }else{
		foreach ($sum as $value) {	
 			if ($i==0 || $my_array[$i]!=$my_array[$i-1]) {
				if ($j>=0) {
				 	$this->pdf->SetFont('helvetica','B',8);
					$this->pdf->SetX(20);
		 			$this->pdf->Cell(40, 1, "", '0', 0, 'L', 0);
		 			$this->pdf->Cell(90, 1, "", '0', 0, 'L', 0);
		 			$this->pdf->Cell(20, 1, "Total", '0', 0, 'L', 0);
		 			$this->pdf->Cell(10, 1, "Rs   ", '0', 0, 'L', 0);
		 			$this->pdf->Cell(20, 1, number_format($tot,2), '0', 0, 'R', 0);
				 	$this->pdf->Ln();
					$this->pdf->Ln(); 
				}
				$j++;
			 	$this->pdf->SetFont('helvetica', 'B', 9);
			 	if ($i==0) {
			 		$this->pdf->setY(40);
		 		}
		 		$this->pdf->Ln();
			 	$this->pdf->SetX(15);
			 	$this->pdf->Cell(20, 1, 'Invoice No - ', '0', 0, 'L', 0);
			 	$this->pdf->SetFont('helvetica', '', 9);
		 		$this->pdf->Cell(6, 1, $value->nno, '0', 0, 'L', 0);
		 		$this->pdf->SetFont('helvetica', 'B', 9);
		 		$this->pdf->Cell(25, 1, 'Agreement No - ', '0', 0, 'L', 0);
		 		$this->pdf->SetFont('helvetica', '', 9);
		 		$this->pdf->Cell(35, 1, $value->agreement_no, '0', 0, 'L', 0);
		 		$this->pdf->SetFont('helvetica', 'B', 9);
		 		$this->pdf->Cell(18, 1, "Customer -  ", '0', 0, 'L', 0);
		 		$this->pdf->SetFont('helvetica', '', 9);
		 		$this->pdf->Cell(50, 1, $value->customer, '0', 0, 'L', 0);
		 		$this->pdf->SetFont('helvetica', 'B', 9);
			 	$this->pdf->Cell(10, 1, "Date -  ", '0', 0, 'L', 0);
			 	$this->pdf->SetFont('helvetica', '', 9);
			 	$this->pdf->Cell(20, 1,  $date, '0', 0, 'L', 0);

				$this->pdf->Ln();
				$this->pdf->Ln();
 				$this->pdf->SetX(15);
				$this->pdf->SetFont('helvetica','B',8);
    			$this->pdf->Cell(25, 6,"Type", '1', 0, 'C', 0);
				$this->pdf->Cell(70, 6,"Type Description", '1', 0, 'C', 0);
		        $this->pdf->Cell(65, 6,"Description", '1', 0, 'C', 0);
		        $this->pdf->Cell(25, 6,"Amount", '1', 0, 'C', 0);
		        $this->pdf->Ln();

			}
                                                	
			$this->pdf->SetX(15);
			$this->pdf->SetLineStyle(array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0.1, 'color' => array(0, 0, 0)));
			$this->pdf->SetFont('helvetica','',8);
			$this->pdf->Cell(25, 6,$value->chg_type, '1', 0, 'L', 0);
			$this->pdf->Cell(70, 6,$value->chg_description,'1', 0, 'L', 0);
			$this->pdf->Cell(65, 6,$value->description, '1', 0, 'L', 0);
			$this->pdf->Cell(25, 6,$value->amount, '1', 0, 'R', 0);
			$this->pdf->Ln();
			$i++;
      		$tot=$value->tot_amount;
     		$final_tot +=(float)$value->amount;
    }
		 	$this->pdf->SetFont('helvetica','B',8);
			$this->pdf->SetX(20);
		 	$this->pdf->Cell(40, 1, "", '0', 0, 'L', 0);
		 	$this->pdf->Cell(90, 1, "", '0', 0, 'L', 0);
		 	$this->pdf->Cell(20, 1, "Total", '0', 0, 'L', 0);
		 	$this->pdf->Cell(10, 1, "Rs   ", '0', 0, 'L', 0);
		 	$this->pdf->Cell(20, 1, number_format($tot,2), '0', 0, 'R', 0);
			$this->pdf->Ln();
		 	$this->pdf->Ln();
		 	$this->pdf->SetFont('helvetica','B',8);
			$this->pdf->SetX(20);
		 	$this->pdf->Cell(40, 1, "", '0', 0, 'L', 0);
		 	$this->pdf->Cell(90, 1, "", '0', 0, 'L', 0);
		 	$this->pdf->Cell(20, 1, "Final Total", '0', 0, 'L', 0);
		 	$this->pdf->Cell(10, 1, "Rs   ", '0', 0, 'L', 0);
		 	$this->pdf->Cell(20, 1, number_format($final_tot,2), 'TB', 0, 'R', 0); 
}

	$this->pdf->Output("Other Chargers Detail".date('Y-m-d').".pdf", 'I');

?>