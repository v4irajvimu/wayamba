<?php
		error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
		$this->pdf->setPrintHeader($header,$type,$duration);
        $this->pdf->setPrintFooter(true,'0',$is_cur_time);
        $this->pdf->SetFont('helvetica', 'B', 16);
		$this->pdf->AddPage($orientation,$page);   // L or P amd page type A4 or A3

 		foreach($branch as $ress){
 			$this->pdf->headerSet4($ress->name,$ress->address,$ress->tp,$ress->fax,$ress->email);
		}

		foreach($sum as $row){
			$date=$row->ddate;
			$no=$row->nno;
			$ref_no=$row->ref_no;
			$note=$row->note;
		}

		foreach($user as $row){
		 		$operator=$row->loginName;
		}

		/*foreach($session as $ses){
			$invoice_no=$session[0].$session[1].$session[2];
		}*/

			$align_h=$this->utility->heading_align();
			$this->pdf->setY(12);
        	$this->pdf->SetFont('helvetica', 'BU', 10);
			$this->pdf->Ln();
		 	$this->pdf->Cell(0, 5,'HP OTHER CHARGERS',0,false, $align_h, 0, '', 0, false, 'M', 'M');
		 	$this->pdf->Ln();
	     	$this->pdf->SetFont('helvetica', '', 10);

		 	$this->pdf->Cell(30, 1, "Date : ", '0', 0, 'L', 0);
		 	$this->pdf->Cell(20, 1, $date.$save_time, '0', 0, 'L', 0);
		 	$this->pdf->Cell(2, 1,'', '0', 0, 'L', 0);
		 	$this->pdf->Cell(1, 1, "", '0', 0, 'L', 0);
		 	$this->pdf->Ln();

	
		 	$this->pdf->Cell(30, 1, "No : ", '0', 0, 'L', 0);
		 	$this->pdf->Cell(20, 1, $no, '0', 0, 'L', 0);
		 	$this->pdf->Cell(2, 1, '', '0', 0, 'L', 0);
		 	$this->pdf->Cell(1, 1, '', '0', 0, 'L', 0);
		 	$this->pdf->Ln();

		 	
		 	$this->pdf->Cell(30, 1, "Ref No : ", '0', 0, 'L', 0);
		 	$this->pdf->Cell(20, 1, $ref_no, '0', 0, 'L', 0);
		 	$this->pdf->Cell(2, 1, '', '0', 0, 'L', 0);
		 	$this->pdf->Cell(1, 1, '', '0', 0, 'L', 0);
		 
		 	$this->pdf->Ln();		 


		 	$this->pdf->Cell(30, 1, "___________________________________________________________________________________________", '0', 0, 'L', 0);
		 	$this->pdf->Ln();
	$this->pdf->Ln();

		 	$this->pdf->SetFont('helvetica', 'B',9);
		 	$this->pdf->SetX(12);
			$this->pdf->Cell(30, 1,"Type", '1', 0, 'C', 0);
		 	$this->pdf->Cell(65, 1,"Description", '1', 0, 'C', 0);
		 	$this->pdf->Cell(65, 1,"Description", '1', 0, 'C', 0);
		 	$this->pdf->Cell(25, 1,"Amount", '1', 0, 'C', 0);
		 	$this->pdf->Ln();

		 	$tot=(float)0;
		 	foreach ($dets as $row) {		

		 		$aa = $this->pdf->getNumLines($row->des, 65);
		 		$bb = $this->pdf->getNumLines($row->des, 65);
	        	
	        	if($aa>$bb){
	        		$heigh=5*$aa;
	        	}else{
	        		$heigh=5*$bb;	
	        	}
	        	
			    $this->pdf->SetX(12);
			    $this->pdf->SetFont('helvetica', '',9);
			    $this->pdf->SetLineStyle(array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0.1, 'color' => array(0, 0, 0)));
			    $this->pdf->MultiCell(30, $heigh,$row->chg_type,  1, 'L', 0, 0, '', '', true, 0, false, true, 0);
		        $this->pdf->MultiCell(65, $heigh,$row->des,  1, 'L', 0, 0, '', '', true, 0, false, true, 0);
		        $this->pdf->MultiCell(65, $heigh,$row->description,  1, 'L', 0, 0, '', '', true, 0, false, true, 0);
		        $this->pdf->MultiCell(25, $heigh,number_format($row->amount,2), 1, 'R', 0, 1, '', '', true, 0, false, true, 0);			    
				$tot += $row->amount;
			}
		 	$this->pdf->Ln();
			$this->pdf->SetFont('helvetica', 'B',9);
		 	$this->pdf->Cell(30, 1,"", '0', 0, 'L', 0);
		 	$this->pdf->Cell(65, 1,"", '0', 0, 'L', 0);
		 	$this->pdf->Cell(63, 1,"Total", '0', 0, 'R', 0);
		 	$this->pdf->Cell(25, 1,number_format($tot,2), '0', 0, 'R', 0);

		 	$this->pdf->SetFont('helvetica', '', 9);
		
	        $this->pdf->Ln();
	        $this->pdf->Ln();
	        $this->pdf->Cell(30, 1,"Note : ", '0', 0, 'L', 0);
		 	$this->pdf->Cell(25, 1,$note, '0', 0, 'L', 0);
		 	$this->pdf->Ln();
		 	$this->pdf->Ln();
		 	$this->pdf->Cell(50, 1, '', '0', 0, 'L', 0);
		 	$this->pdf->Cell(50, 1, '', '0', 0, 'L', 0);
		 	$this->pdf->Cell(45, 1, '...................................', '0', 0, 'L', 0);
		 	$this->pdf->Cell(50, 1, '...................................', '0', 0, 'L', 0);
			$this->pdf->Ln();
		 	$this->pdf->Cell(50, 1, '       ', '0', 0, 'L', 0);
		 	$this->pdf->Cell(50, 1, '         ', '0', 0, 'L', 0);
		 	$this->pdf->Cell(50, 1, ' Authorize Signature', '0', 0, 'L', 0);
		 	$this->pdf->Cell(50, 1, 'Approved By', '0', 0, 'L', 0);
		 
		 	$this->pdf->Ln();
		 
		 	$this->pdf->Ln();
		 	$this->pdf->Cell(20, 1, "Operator ", '0', 0, 'L', 0);
		 	$this->pdf->Cell(1, 1, $operator, '0', 0, 'L', 0);
		 	$this->pdf->Ln();

		 	$tt = date("H:i");

		 	
		 	$this->pdf->Cell(20, 1, "Print Time ", '0', 0, 'L', 0);
		 	$this->pdf->Cell(1, 1, $tt, '0', 0, 'L', 0);
		 	$this->pdf->Ln();

	$this->pdf->Output("Voucher".date('Y-m-d').".pdf", 'I');

?>