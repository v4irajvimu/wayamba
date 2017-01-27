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
 			$this->pdf->headerSet4($ress->name,$ress->address,$ress->tp,$ress->fax,$ress->email);	
		}
		
			foreach($det as $row){

				$loan_no=$row->loan_no;
				$no=$row->nno;
				$date=$row->ddate;
				$ref_no=$row->ref_no;
				$bal_capital=$row->bal_capital;
				$bal_interest=$row->bal_interest;
				$bal_panalty=$row->bal_panalty;
				$bal_other=$row->bal_other_Chg;
				$capital_reb=$row->rbt_capital;
				$interest_reb=$row->rbt_interest;
				$panalty_reb=$row->rbt_panalty;
				$other_reb=$row->rbt_other_chg;
				$tot=$row->tot_balance;
				$tot_reb=$row->tot_rebate;
				
			}
		
			$this->pdf->setY(15);
        	$this->pdf->SetFont('helvetica', 'BU', 12);
        	$this->pdf->Ln();
        $orgin_print=$_POST['org_print'];
		if($orgin_print=="1"){
		  	$this->pdf->Cell(0, 5,'Rebate Approve ',0,false, 'C', 0, '', 0, false, 'M', 'M');
			}
		else{
		  	$this->pdf->Cell(0, 5,'Rebate Approve (Duplicate) ',0,false, 'C', 0, '', 0, false, 'M', 'M');
			}
		 	
		 	$this->pdf->setY(25);
		 	$this->pdf->Ln();
		 	$this->pdf->SetFont('helvetica', 'B',9);
		 	$this->pdf->Cell(20, 1, 'Loan No', '0', 0, 'L', 0);
		 	$this->pdf->Cell(5, 1, '', '0', 0, 'L', 0);
		 	$this->pdf->SetFont('helvetica', '',9);
		 	$this->pdf->Cell(40, 1, $loan_no, '0', 0, 'L', 0);
		 	$this->pdf->Cell(30, 1, "", '0', 0, 'L', 0);
		 	
		 	$this->pdf->SetFont('helvetica', 'B',9);
		 	$this->pdf->Cell(30, 1, "No ", '0', 0, 'L', 0);
		 	$this->pdf->Cell(5, 1, '', '0', 0, 'L', 0);
		 	$this->pdf->SetFont('helvetica', '',9);
		 	$this->pdf->Cell(60, 1, $no, '0', 0, 'L', 0);
		 	$this->pdf->Cell(30, 1, "", '0', 0, 'L', 0);
		 	$this->pdf->Ln();

		 	$this->pdf->Cell(20, 1, '', '0', 0, 'L', 0);
		 	$this->pdf->Cell(5, 1, '', '0', 0, 'L', 0);
		 	$this->pdf->Cell(40, 1, '', '0', 0, 'L', 0);
		 	$this->pdf->Cell(30, 1, "", '0', 0, 'L', 0);
		 	
		 	$this->pdf->SetFont('helvetica', 'B',9);
		 	$this->pdf->Cell(30, 1, "Date ", '0', 0, 'L', 0);
		 	$this->pdf->Cell(5, 1, '', '0', 0, 'L', 0);
		 	$this->pdf->SetFont('helvetica', '',9);
		 	$this->pdf->Cell(60, 1, $date, '0', 0, 'L', 0);
		 	$this->pdf->Ln();


		 	$this->pdf->Cell(20, 1, ' ', '0', 0, 'L', 0);
		 	$this->pdf->Cell(5, 1, '', '0', 0, 'L', 0);
		 	$this->pdf->Cell(40, 1, '', '0', 0, 'L', 0);
		 	$this->pdf->Cell(30, 1, "", '0', 0, 'L', 0);

		 	$this->pdf->SetFont('helvetica', 'B',9);
		 	$this->pdf->Cell(30, 1, "Ref No  ", '0', 0, 'L', 0);
		 	$this->pdf->Cell(5, 1, '', '0', 0, 'L', 0);
		 	$this->pdf->SetFont('helvetica', '',9);
		 	$this->pdf->Cell(60, 1, $ref_no, '0', 0, 'L', 0);
		 	$this->pdf->Ln();

			$this->pdf->SetY(50);
			$this->pdf->SetX(20);
			
	        	$this->pdf->SetFont('helvetica','B',9);
				$this->pdf->MultiCell(30, 6, "Balance Capital", $border=0, $align='L', $fill=false, $ln=0, $x=($this->pdf->GetX()-5), $y=($this->pdf->GetY()), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=6, $valign='M', $fitcell=true);
	            $this->pdf->SetFont('helvetica','',9);
	            $this->pdf->MultiCell(30, 6, $bal_capital, $border=0, $align='R', $fill=false, $ln=0, $x=($this->pdf->GetX()), $y=$this->pdf->GetY(), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=6, $valign='M', $fitcell=true);
	            $this->pdf->MultiCell(35, 6, '', $border=0, $align='R', $fill=false, $ln=0, $x=($this->pdf->GetX()), $y=$this->pdf->GetY(), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=6, $valign='M', $fitcell=true);
	            $this->pdf->SetFont('helvetica','B',9);
	            $this->pdf->MultiCell(35, 6, "Capital Rebate", $border=0, $align='L', $fill=false, $ln=0, $x=($this->pdf->GetX()), $y=$this->pdf->GetY(), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=6, $valign='M', $fitcell=true);
	            $this->pdf->SetFont('helvetica','',9);
	            $this->pdf->MultiCell(30, 6, $capital_reb, $border=0, $align='R', $fill=false, $ln=0, $x=($this->pdf->GetX()), $y=$this->pdf->GetY(), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=6, $valign='M', $fitcell=true);
	            
	            $this->pdf->Ln();
	            $this->pdf->SetX(20);

	            $this->pdf->SetFont('helvetica','B',9);
				$this->pdf->MultiCell(30, 6, "Balance Interest", $border=0, $align='L', $fill=false, $ln=0, $x=($this->pdf->GetX()-5), $y=($this->pdf->GetY()), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=6, $valign='M', $fitcell=true);
	            $this->pdf->SetFont('helvetica','',9);
	            $this->pdf->MultiCell(30, 6, $bal_interest, $border=0, $align='R', $fill=false, $ln=0, $x=($this->pdf->GetX()), $y=$this->pdf->GetY(), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=6, $valign='M', $fitcell=true);
				$this->pdf->MultiCell(35, 6, '', $border=0, $align='R', $fill=false, $ln=0, $x=($this->pdf->GetX()), $y=$this->pdf->GetY(), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=6, $valign='M', $fitcell=true);
	            $this->pdf->SetFont('helvetica','B',9);
	            $this->pdf->MultiCell(35, 6, "Interest Rebate", $border=0, $align='L', $fill=false, $ln=0, $x=($this->pdf->GetX()), $y=$this->pdf->GetY(), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=6, $valign='M', $fitcell=true);
	            $this->pdf->SetFont('helvetica','',9);
	            $this->pdf->MultiCell(30, 6, $interest_reb, $border=0, $align='R', $fill=false, $ln=0, $x=($this->pdf->GetX()), $y=$this->pdf->GetY(), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=6, $valign='M', $fitcell=true);
	            
	            $this->pdf->Ln();
	            $this->pdf->SetX(20);

	            $this->pdf->SetFont('helvetica','B',9);
				$this->pdf->MultiCell(30, 6, "Balance Penalty", $border=0, $align='L', $fill=false, $ln=0, $x=($this->pdf->GetX()-5), $y=($this->pdf->GetY()), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=6, $valign='M', $fitcell=true);
	            $this->pdf->SetFont('helvetica','',9);
	            $this->pdf->MultiCell(30, 6, $bal_panalty, $border=0, $align='R', $fill=false, $ln=0, $x=($this->pdf->GetX()), $y=$this->pdf->GetY(), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=6, $valign='M', $fitcell=true);
	            $this->pdf->MultiCell(35, 6, '', $border=0, $align='R', $fill=false, $ln=0, $x=($this->pdf->GetX()), $y=$this->pdf->GetY(), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=6, $valign='M', $fitcell=true);	           
	            $this->pdf->SetFont('helvetica','B',9);
	            $this->pdf->MultiCell(35, 6, "Penalty Rebate", $border=0, $align='L', $fill=false, $ln=0, $x=($this->pdf->GetX()), $y=$this->pdf->GetY(), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=6, $valign='M', $fitcell=true);
	            $this->pdf->SetFont('helvetica','',9);
	            $this->pdf->MultiCell(30, 6, $panalty_reb, $border=0, $align='R', $fill=false, $ln=0, $x=($this->pdf->GetX()), $y=$this->pdf->GetY(), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=6, $valign='M', $fitcell=true);
	            
	            $this->pdf->Ln();
	            $this->pdf->SetX(20);

	            $this->pdf->SetFont('helvetica','B',9);
				$this->pdf->MultiCell(30, 6, "Balance Other Charges", $border=0, $align='L', $fill=false, $ln=0, $x=($this->pdf->GetX()-5), $y=($this->pdf->GetY()), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=6, $valign='M', $fitcell=true);
	            $this->pdf->SetFont('helvetica','',9);
	            $this->pdf->MultiCell(30, 6, $bal_other, $border=0, $align='R', $fill=false, $ln=0, $x=($this->pdf->GetX()), $y=$this->pdf->GetY(), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=6, $valign='M', $fitcell=true);
	            $this->pdf->MultiCell(35, 6, '', $border=0, $align='R', $fill=false, $ln=0, $x=($this->pdf->GetX()), $y=$this->pdf->GetY(), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=6, $valign='M', $fitcell=true);
	            $this->pdf->SetFont('helvetica','B',9);
	            $this->pdf->MultiCell(35, 6, "Other Charges Rebate", $border=0, $align='L', $fill=false, $ln=0, $x=($this->pdf->GetX()), $y=$this->pdf->GetY(), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=6, $valign='M', $fitcell=true);
	            $this->pdf->SetFont('helvetica','',9);
	            $this->pdf->MultiCell(30, 6, $other_reb, $border=0, $align='R', $fill=false, $ln=0, $x=($this->pdf->GetX()), $y=$this->pdf->GetY(), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=6, $valign='M', $fitcell=true);
	            
	            $this->pdf->Ln();
	            $this->pdf->SetX(20);
	            $this->pdf->SetFont('helvetica','B',9);
				$this->pdf->MultiCell(30, 6, "Total", $border=0, $align='L', $fill=false, $ln=0, $x=($this->pdf->GetX()-5), $y=($this->pdf->GetY()), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=6, $valign='M', $fitcell=true);
	            $this->pdf->SetFont('helvetica','',9);
	            $this->pdf->MultiCell(30, 6, $tot, $border="TB", $align='R', $fill=false, $ln=0, $x=($this->pdf->GetX()), $y=$this->pdf->GetY(), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=6, $valign='M', $fitcell=true);
	     	    $this->pdf->MultiCell(35, 6, '', $border=0, $align='R', $fill=false, $ln=0, $x=($this->pdf->GetX()), $y=$this->pdf->GetY(), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=6, $valign='M', $fitcell=true);
	            $this->pdf->SetFont('helvetica','B',9);
	            $this->pdf->MultiCell(35, 6, "Rebate Amount Total", $border=0, $align='L', $fill=false, $ln=0, $x=($this->pdf->GetX()), $y=$this->pdf->GetY(), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=6, $valign='M', $fitcell=true);
	            $this->pdf->SetFont('helvetica','',9);
	            $this->pdf->MultiCell(30, 6, $tot_reb, $border="TB", $align='R', $fill=false, $ln=0, $x=($this->pdf->GetX()), $y=$this->pdf->GetY(), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=6, $valign='M', $fitcell=true);
	            
	            $this->pdf->Ln();
	            $this->pdf->Ln();
	            $this->pdf->Ln();
	            $this->pdf->SetX(20);
	            $this->pdf->SetFont('helvetica','B',9);
				$this->pdf->MultiCell(30, 6, "", $border=0, $align='L', $fill=false, $ln=0, $x=($this->pdf->GetX()-5), $y=($this->pdf->GetY()), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=6, $valign='M', $fitcell=true);
	            $this->pdf->MultiCell(30, 6, '', $border=0, $align='R', $fill=false, $ln=0, $x=($this->pdf->GetX()), $y=$this->pdf->GetY(), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=6, $valign='M', $fitcell=true);
	     	    $this->pdf->MultiCell(35, 6, '', $border=0, $align='R', $fill=false, $ln=0, $x=($this->pdf->GetX()), $y=$this->pdf->GetY(), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=6, $valign='M', $fitcell=true);
	            $this->pdf->MultiCell(60, 6, ".....................................................................", $border=0, $align='L', $fill=false, $ln=0, $x=($this->pdf->GetX()), $y=$this->pdf->GetY(), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=6, $valign='M', $fitcell=true);
	            $this->pdf->MultiCell(0, 6, '', $border=0, $align='R', $fill=false, $ln=0, $x=($this->pdf->GetX()), $y=$this->pdf->GetY(), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=6, $valign='M', $fitcell=true);
	            
	            $this->pdf->Ln();
	            $this->pdf->SetX(20);
	            $this->pdf->SetFont('helvetica','B',9);
				$this->pdf->MultiCell(30, 6, "", $border=0, $align='L', $fill=false, $ln=0, $x=($this->pdf->GetX()-5), $y=($this->pdf->GetY()), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=6, $valign='M', $fitcell=true);
	            $this->pdf->MultiCell(30, 6, '', $border=0, $align='R', $fill=false, $ln=0, $x=($this->pdf->GetX()), $y=$this->pdf->GetY(), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=6, $valign='M', $fitcell=true);
	     	    $this->pdf->MultiCell(35, 6, '', $border=0, $align='R', $fill=false, $ln=0, $x=($this->pdf->GetX()), $y=$this->pdf->GetY(), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=6, $valign='M', $fitcell=true);
	            $this->pdf->MultiCell(60, 6, "Authorise Signature", $border=0, $align='C', $fill=false, $ln=0, $x=($this->pdf->GetX()), $y=$this->pdf->GetY(), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=6, $valign='M', $fitcell=true);
	            $this->pdf->MultiCell(0, 6, '', $border=0, $align='R', $fill=false, $ln=0, $x=($this->pdf->GetX()), $y=$this->pdf->GetY(), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=6, $valign='M', $fitcell=true);
	            

	$this->pdf->Output("Purchase Order".date('Y-m-d').".pdf", 'I');

?>