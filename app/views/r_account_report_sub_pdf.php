<?php
error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);


$this->pdf->setPrintFooter(true);
$this->pdf->setPrintHeader(true);
$this->pdf->setPrintHeader($header,$type); 

        $this->pdf->SetFont('helvetica', 'B', 16);
		$this->pdf->AddPage($orientation,$page);   // L or P amd page type A4 or A3
 		foreach($branch as $ress){
 			$this->pdf->headerSet3($ress->name,$ress->address,$ress->tp,$ress->fax,$ress->email);
		}

		foreach ($op as $key){
			$op = (float)$key->op;
			$cr = (float)$key->cr;
			$dr = (float)$key->dr;
		}

 			$this->pdf->setY(25);
            $this->pdf->SetFont('helvetica', 'BU',12);
            $this->pdf->Cell(180, 1,"Account's Details Report With Sub No",0,false, 'L', 0, '', 0, false, 'M', 'M');
            $this->pdf->Ln();

            $this->pdf->setY(30);
            $this->pdf->SetFont('helvetica', '', 8);
            
            $this->pdf->Cell(162, 1,"From - ".$dfrom."     To - ".$dto,0,false, 'L', 0, '', 0, false, 'M', 'M');
            $this->pdf->Ln();

            $this->pdf->SetFont('helvetica', 'B', 8);
            $this->pdf->setY(40);
            

            $this->pdf->Cell(180, 1,"Account - ".$acc_code." ".$account_det,0,false, 'L', 0, '', 0, false, 'M', 'M');
            $this->pdf->Ln();

            $this->pdf->setX(10);
		 	$this->pdf->Cell(20, 1, 'Date', '1', 0, 'L', 0);
		 	$this->pdf->Cell(20, 1, "Trans", '1', 0, 'L', 0);
		 	$this->pdf->Cell(10, 1, "No", '1', 0, 'L', 0);
		 	$this->pdf->Cell(15, 1, "Sub No", '1', 0, 'L', 0);
		 	$this->pdf->Cell(50, 1, "Description", '1', 0, 'L', 0);
		 	$this->pdf->Cell(25, 1, "Dr Amount", '1', 0, 'R', 0);
		 	$this->pdf->Cell(25, 1, "Cr Amount", '1', 0, 'R', 0);
		 	$this->pdf->Cell(30, 1, "Balance", '1', 0, 'R', 0);
		 	$this->pdf->SetLineStyle(array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0.1, 'color' => array(0, 0, 0)));
		 	
			$this->pdf->Ln();
			$this->pdf->setX(10);
			$this->pdf->SetFont('helvetica', 'B', 8);
			$this->pdf->Cell(20, 1, '', '1', 0, 'L', 0);
		 	$this->pdf->Cell(20, 1, "", '1', 0, 'L', 0);
		 	$this->pdf->Cell(10, 1, "", '1', 0, 'L', 0);
		 	$this->pdf->Cell(15, 1, "", '1', 0, 'L', 0);
		 	$this->pdf->Cell(50, 1, "Begining Balance", '1', 0, 'L', 0);
		 	$this->pdf->Cell(25, 1, number_format($dr,2), '1', 0, 'R', 0);
		 	$this->pdf->Cell(25, 1,  number_format($cr,2), '1', 0, 'R', 0);
		 	$this->pdf->Cell(30, 1,  number_format($op,2), '1', 0, 'R', 0);

		 	$this->pdf->Ln();

		 	$total=(float)$op;
		 	$cr_toal=$cr;
		 	$dr_toal=$dr;
		 	
		 	foreach($all_acc_det as $row){
		 		if($row->dr_amount==0){
		 			$total=$total-(float)$row->cr_amount;
		 		}else if($row->cr_amount==0){
		 			$total=$total+(float)$row->dr_amount;
		 		}

	 			$cr_toal=$cr_toal+(float)$row->cr_amount;
	 			$dr_toal=$dr_toal+(float)$row->dr_amount;
	 			$this->pdf->setX(10);
				$this->pdf->SetFont('helvetica', '', 8);
				$this->pdf->Cell(20, 1, $row->ddate, '1', 0, 'L', 0);
				$this->pdf->Cell(20, 1, $row->t_code, '1', 0, 'L', 0);
			 	$this->pdf->Cell(10, 1, $row->trans_no, '1', 0, 'L', 0);
			 	$this->pdf->Cell(15, 1, $row->sub_no, '1', 0, 'L', 0);
			 	$this->pdf->Cell(50, 1, ucfirst(strtolower($row->det)), '1', 0, 'L', 0);
			 	$this->pdf->Cell(25, 1, $row->dr_amount, '1', 0, 'R', 0);
			 	$this->pdf->Cell(25, 1, $row->cr_amount, '1', 0, 'R', 0);
			 	$this->pdf->Cell(30, 1, number_format($total,2, '.', ''), '1', 0, 'R', 0);	
			 	$this->pdf->Ln();	 		
		 	}

			$this->pdf->setX(10);
			$this->pdf->SetFont('helvetica', 'B', 8);
			$this->pdf->Cell(20, 1, '', '1', 0, 'L', 0);
		 	$this->pdf->Cell(20, 1, "", '1', 0, 'L', 0);
		 	$this->pdf->Cell(10, 1, "", '1', 0, 'L', 0);
		 	$this->pdf->Cell(15, 1, "", '1', 0, 'L', 0);
		 	$this->pdf->Cell(50, 1, "Ending Balance", '1', 0, 'L', 0);
		 	$this->pdf->Cell(25, 1, number_format($dr_toal,2), '1', 0, 'R', 0);
		 	$this->pdf->Cell(25, 1, number_format($cr_toal,2), '1', 0, 'R', 0);
		 	$this->pdf->Cell(30, 1, number_format($total,2), '1', 0, 'R', 0);

	$this->pdf->Output("Account Report With Sub No".date('Y-m-d').".pdf", 'I');

?>