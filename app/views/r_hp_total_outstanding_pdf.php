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
	$this->pdf->SetFont('helvetica', 'BU',12);
	$this->pdf->Cell(0, 5, 'TOTAL OUTSTANDING',0,false, 'L', 0, '', 0, false, 'M', 'M');
	$this->pdf->Ln();
	
    $this->pdf->Ln(); 
    $this->pdf->SetFont('helvetica', '',9);
	$this->pdf->Cell(0, 5, 'As At Date '.$dto ,0,false, 'L', 0, '', 0, false, 'M', 'M');
	$this->pdf->Ln();
			
	$Goss=array();
	$net=array();
	$tot=0;
 	$dis=0;
  	$net_tot=0;
  	$cus=$_POST['cus_id'];
  	$cus_name=$_POST['customer'];
  	$agr=$_POST['agreemnt_no'];

			if($_POST['cus_id']!=""){
				$this->pdf->SetY(40);
			 	$this->pdf->SetX(15);
			 	$this->pdf->SetFont('helvetica', 'B', 9);
		 		$this->pdf->Cell(18, 1, "Customer -  ", '0', 0, 'L', 0);
		 		$this->pdf->SetFont('helvetica', '', 9);
		 		$this->pdf->Cell(50, 1, $cus." - ".$cus_name, '0', 0, 'L', 0);
		 		
			}
			if($_POST['agreemnt_no']!=""){
				$this->pdf->SetY(45);
			 	$this->pdf->SetX(15);
		 		$this->pdf->SetFont('helvetica', 'B', 9);
		 		$this->pdf->Cell(25, 1, 'Agreement No - ', '0', 0, 'L', 0);
		 		$this->pdf->SetFont('helvetica', '', 9);
		 		$this->pdf->Cell(35, 1, $agr, '0', 0, 'L', 0);
			 }
				$this->pdf->SetY(50);
 				$this->pdf->SetX(15);
				$this->pdf->SetFont('helvetica','B',8);
    			$this->pdf->Cell(22, 6,"Agreement No", '1', 0, 'C', 0);
				$this->pdf->Cell(20, 6,"NIC", '1', 0, 'C', 0);
		        $this->pdf->Cell(40, 6,"Name", '1', 0, 'C', 0);
		        $this->pdf->Cell(70, 6,"Item Name", '1', 0, 'C', 0);
		        $this->pdf->Cell(30, 6,"Agreement Value", '1', 0, 'C', 0);
		        $this->pdf->Cell(20, 6,"Total Penalty", '1', 0, 'C', 0);
				$this->pdf->Cell(23, 6,"Other Chargers", '1', 0, 'C', 0);
		        $this->pdf->Cell(30, 6,"Total Paid Amount", '1', 0, 'C', 0);
		        $this->pdf->Cell(20, 6,"Balance", '1', 0, 'C', 0);
		        $this->pdf->Ln();


		foreach ($sum as $value) {
                   	
			$this->pdf->SetX(15);
			$this->pdf->SetLineStyle(array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0.1, 'color' => array(0, 0, 0)));
			$this->pdf->SetFont('helvetica','',8);
			$aa = $this->pdf->getNumLines($value->description, 70);
			$bb = $this->pdf->getNumLines($value->name, 40);
			if($aa>$bb){
				$heigh=$aa*5;
			}else{
				$heigh=$bb*5;
			}
			$this->pdf->MultiCell(22, $heigh, $value->agreement_no, 1, 'L', 0, 0, '', '', true, 0, false, true, 0);
	        $this->pdf->MultiCell(20, $heigh, $value->nic,1, 'L', 0, 0, '', '', true, 0, false, true, 0);
	        $this->pdf->MultiCell(40, $heigh, $value->name,1, 'L', 0, 0, '', '', true, 0, false, true, 0);
	        $this->pdf->MultiCell(70, $heigh, $value->description, 1, 'L', 0, 0, '', '', true, 0, false, true, 0);
	        $this->pdf->MultiCell(30, $heigh, $value->net_amount, 1, 'R', 0, 0, '', '', true, 0, false, true, 0);
	        $this->pdf->MultiCell(20, $heigh, $value->panalty, 1, 'R', 0, 0, '', '', true, 0, false, true, 0);
	        $this->pdf->MultiCell(23, $heigh, $value->othr_charges, 1, 'R', 0, 0, '', '', true, 0, false, true, 0);
	        $this->pdf->MultiCell(30, $heigh, $value->total_paid, 1, 'R', 0, 0, '', '', true, 0, false, true, 0);
	        $this->pdf->MultiCell(20, $heigh, $value->bal, 1, 'R', 0, 1, '', '', true, 0, false, true, 0);

	        $tot_net+=(float)$value->net_amount;
	        $tot_pan+=(float)$value->panalty;
	        $tot_other+=(float)$value->othr_charges;
	        $tot_paid+=(float)$value->total_paid;
	        $tot_bal+=(float)$value->bal;
	        
    	}

    			$this->pdf->SetX(15);
				$this->pdf->SetFont('helvetica','B',8);
    			$this->pdf->Cell(22, 6,"", '0', 0, 'C', 0);
				$this->pdf->Cell(20, 6,"", '0', 0, 'C', 0);
		        $this->pdf->Cell(40, 6,"", '0', 0, 'C', 0);
		        $this->pdf->Cell(70, 6,"Total", '0', 0, 'R', 0);
		        $this->pdf->Cell(30, 6,number_format($tot_net,2), 'TB', 0, 'R', 0);
		        $this->pdf->Cell(1, 6,"", '0', 0, 'C', 0);
		        $this->pdf->Cell(19, 6,number_format($tot_pan,2), 'TB', 0, 'R', 0);
		        $this->pdf->Cell(1, 6,"", '0', 0, 'C', 0);
				$this->pdf->Cell(22, 6,number_format($tot_other,2), 'TB', 0, 'R', 0);
				$this->pdf->Cell(1, 6,"", '0', 0, 'C', 0);
		        $this->pdf->Cell(29, 6,number_format($tot_paid,2), 'TB', 0, 'R', 0);
		        $this->pdf->Cell(1, 6,"", '0', 0, 'C', 0);
		        $this->pdf->Cell(19, 6,number_format($tot_bal,2), 'TB', 0, 'R', 0);

	$this->pdf->Output("Other Chargers Detail".date('Y-m-d').".pdf", 'I');

?>