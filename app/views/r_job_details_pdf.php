<?php error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
		$this->pdf->setPrintHeader($header,$type,$duration);
        $this->pdf->setPrintFooter(true);
        $this->pdf->setPrintHeader(true);
        $this->pdf->SetFont('helvetica', 'B', 16);
		$this->pdf->AddPage("L","A4");   // L or P amd page type A4 or A3

 		foreach($branch as $ress){//Common
 		 			$this->pdf->headerSet3($ress->name,$ress->address,$ress->tp,$ress->fax,$ress->email);
 				}

			$this->pdf->Ln(3);
        	$this->pdf->SetFont('helvetica', 'IBU',12);
		 	$this->pdf->Cell(0, 5, 'Service Job Details  ',0,false, 'L', 0, '', 0, false, 'M', 'M');
			//var_dump($cluster);exit();
			
			$this->pdf->SetFont('helvetica', 'N', 10);
			$this->pdf->Ln(3);
			$this->pdf->Cell(10, 6, "From :", '0', 0, 'L', 0);					
			$this->pdf->Cell(25, 6, $dfrom, '0', 0, 'L', 0);	
			$this->pdf->Cell(10, 6, "To :", '0', 0, 'L', 0);					
			$this->pdf->Cell(25, 6, $dto, '0', 0, 'L', 0);
				if (!empty($clusterS)) {
					$this->pdf->Ln();
					$this->pdf->Cell(15, 6, "Cluster :", '0', 0, 'L', 0);			
					$this->pdf->Cell(80, 6,  $clusterS, '0', 0, 'L', 0);					
				}

				if (!empty($branchS)) {
					$this->pdf->Ln();			
					$this->pdf->Cell(15, 6, "Branch :", '0', 0, 'L', 0);					
					$this->pdf->Cell(80, 6, $branchS, '0', 0, 'L', 0);			

				}

			$this->pdf->Ln();
		 	//$this->pdf->setY($Yac);

		 	$net_tot_amo=0;
		 	$NoS=0;

 		foreach($r_job_dt_gr as $res_gr){

		 		$tot_amo=0;

				$this->pdf->Ln();
			 	$this->pdf->SetFont('helvetica', 'B', 10);
			 	$this->pdf->Cell(20, 6,"Supplier : ", '0', 0, 'L', 0);
			 	$this->pdf->Cell(0, 6,$res_gr->supplier." - ". $res_gr->su_name, '0', 0, 'L', 0);

				$this->pdf->Ln();

			 	$this->pdf->Cell(20, 6,"Date", '1', 0, 'C', 0);
			 	$this->pdf->Cell(10, 6,"No", '1', 0, 'C', 0);
			 	$this->pdf->Cell(25, 6,"Inv.Type", '1', 0, 'C', 0);
			 	$this->pdf->Cell(15, 6,"Inv. No", '1', 0, 'C', 0);
			 	$this->pdf->Cell(20, 6,"Inv. Date", '1', 0, 'C', 0);
			 	$this->pdf->Cell(80, 6,"Customer", '1', 0, 'C', 0);
			 	$this->pdf->Cell(80, 6,"Item", '1', 0, 'C', 0);
			 	$this->pdf->Cell(25, 6,"Amount", '1', 0, 'C', 0);


			 	$this->pdf->Ln();

				$this->pdf->SetFont('helvetica', 'N', 10);

				
	 		foreach($r_job_dt as $res){
				// var_dump($r_job_dt);
				//exit();
				if ($res_gr->supplier==$res->supplier) {
					
					$item="";
					if (!empty($res->item_code)) {
						$item=$res->item_code." - ".$res->description;
					}
					else {
						$item=$res->Item_name;
					}


			        $this->pdf->MultiCell(20, 6, $res->ddate, $border=1, $align='L', $fill=false, $ln=0, $x=($this->pdf->GetX()), $y=$this->pdf->GetY(), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=6, $valign='M', $fitcell=true);
			        $this->pdf->MultiCell(10, 6, $res->nno, $border=1, $align='R', $fill=false, $ln=0, $x=($this->pdf->GetX()), $y=$this->pdf->GetY(), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=6, $valign='M', $fitcell=true);
			        $this->pdf->MultiCell(25, 6, $res->inv_type, $border=1, $align='L', $fill=false, $ln=0, $x=($this->pdf->GetX()), $y=$this->pdf->GetY(), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=6, $valign='M', $fitcell=true);
			        $this->pdf->MultiCell(15, 6, $res->inv_no, $border=1, $align='R', $fill=false, $ln=0, $x=($this->pdf->GetX()), $y=$this->pdf->GetY(), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=6, $valign='M', $fitcell=true);
			        $this->pdf->MultiCell(20, 6, $res->inv_date, $border=1, $align='L', $fill=false, $ln=0, $x=($this->pdf->GetX()), $y=$this->pdf->GetY(), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=6, $valign='M', $fitcell=true);
			        $this->pdf->MultiCell(80, 6, $res->cus_id." - ".$res->cu_name, $border=1, $align='L', $fill=false, $ln=0, $x=($this->pdf->GetX()), $y=$this->pdf->GetY(), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=6, $valign='M', $fitcell=true);
			        $this->pdf->MultiCell(80, 6, $item, $border=1, $align='L', $fill=false, $ln=0, $x=($this->pdf->GetX()), $y=$this->pdf->GetY(), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=6, $valign='M', $fitcell=true);
			        $this->pdf->MultiCell(25, 6, $res->advance_amount, $border=1, $align='R', $fill=false, $ln=1, $x=($this->pdf->GetX()), $y=$this->pdf->GetY(), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=6, $valign='M', $fitcell=true);
			        //$this->pdf->MultiCell(20, 6, $res->supplier, $border=1, $align='L', $fill=false, $ln=1, $x=($this->pdf->GetX()), $y=$this->pdf->GetY(), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=6, $valign='M', $fitcell=true);
					$tot_amo+=(floatval($res->advance_amount));
					$net_tot_amo+=(floatval($res->advance_amount));
				}
			}		
					$this->pdf->SetFont('helvetica', 'B', 10);		
			        $this->pdf->MultiCell(20, 6, "", $border=0, $align='L', $fill=false, $ln=0, $x=($this->pdf->GetX()), $y=$this->pdf->GetY(), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=6, $valign='M', $fitcell=true);
			        $this->pdf->MultiCell(10, 6, "", $border=0, $align='R', $fill=false, $ln=0, $x=($this->pdf->GetX()), $y=$this->pdf->GetY(), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=6, $valign='M', $fitcell=true);
			        $this->pdf->MultiCell(20, 6, "", $border=0, $align='R', $fill=false, $ln=0, $x=($this->pdf->GetX()), $y=$this->pdf->GetY(), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=6, $valign='M', $fitcell=true);
			        $this->pdf->MultiCell(15, 6, "", $border=0, $align='R', $fill=false, $ln=0, $x=($this->pdf->GetX()), $y=$this->pdf->GetY(), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=6, $valign='M', $fitcell=true);
			        $this->pdf->MultiCell(25, 6, "", $border=0, $align='L', $fill=false, $ln=0, $x=($this->pdf->GetX()), $y=$this->pdf->GetY(), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=6, $valign='M', $fitcell=true);
			        $this->pdf->MultiCell(80, 6, "", $border=0, $align='L', $fill=false, $ln=0, $x=($this->pdf->GetX()), $y=$this->pdf->GetY(), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=6, $valign='M', $fitcell=true);
			        $this->pdf->MultiCell(80, 6, "Total     ", $border=0, $align='R', $fill=false, $ln=0, $x=($this->pdf->GetX()), $y=$this->pdf->GetY(), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=6, $valign='M', $fitcell=true);
			        $this->pdf->MultiCell(25, 6, number_format($tot_amo,2), $border='TB', $align='R', $fill=false, $ln=1, $x=($this->pdf->GetX()), $y=$this->pdf->GetY(), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=6, $valign='M', $fitcell=true);
			
			        $NoS++;

		}

					$this->pdf->SetFont('helvetica', 'B', 10);		
			        $this->pdf->MultiCell(30, 6, "Number Of Suppliers", $border=0, $align='L', $fill=false, $ln=0, $x=($this->pdf->GetX()), $y=$this->pdf->GetY(), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=6, $valign='M', $fitcell=true);
			        $this->pdf->MultiCell(15, 6, $NoS, $border=0, $align='R', $fill=false, $ln=0, $x=($this->pdf->GetX()), $y=$this->pdf->GetY(), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=6, $valign='M', $fitcell=true);
			        $this->pdf->MultiCell(10, 6, "", $border=0, $align='R', $fill=false, $ln=0, $x=($this->pdf->GetX()), $y=$this->pdf->GetY(), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=6, $valign='M', $fitcell=true);
			        $this->pdf->MultiCell(10, 6, "", $border=0, $align='R', $fill=false, $ln=0, $x=($this->pdf->GetX()), $y=$this->pdf->GetY(), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=6, $valign='M', $fitcell=true);
			        $this->pdf->MultiCell(25, 6, "", $border=0, $align='L', $fill=false, $ln=0, $x=($this->pdf->GetX()), $y=$this->pdf->GetY(), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=6, $valign='M', $fitcell=true);
			        $this->pdf->MultiCell(80, 6, "", $border=0, $align='L', $fill=false, $ln=0, $x=($this->pdf->GetX()), $y=$this->pdf->GetY(), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=6, $valign='M', $fitcell=true);
			        $this->pdf->MultiCell(80, 6, "Net Amount    ", $border=0, $align='R', $fill=false, $ln=0, $x=($this->pdf->GetX()), $y=$this->pdf->GetY(), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=6, $valign='M', $fitcell=true);
			        $this->pdf->MultiCell(25, 6, number_format($net_tot_amo,2), $border='TB', $align='R', $fill=false, $ln=1, $x=($this->pdf->GetX()), $y=$this->pdf->GetY(), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=6, $valign='M', $fitcell=true);



	$this->pdf->Output("Job_Details_".date('Y-m-d').".pdf", 'I');

?>
