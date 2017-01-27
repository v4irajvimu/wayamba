<?php
		error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
		$this->pdf->setPrintHeader($header,$type,$duration);
		$this->pdf->setPrintHeader(true,$type);
        $this->pdf->setPrintFooter(true);
        $this->pdf->SetFont('helvetica', 'B', 16);
		$this->pdf->AddPage($orientation,$page);   // L or P amd page type A4 or A3

 		foreach($branch as $ress){
			$this->pdf->headerSet4($ress->name,$ress->address,$ress->tp,$ress->fax,$ress->email);
		}

		foreach($session as $ses){
			$invoice_no=$session[0].$session[1].$session[2];
		}

		foreach($sum as $s){
			$nno   = $s->nno;
			$date     = $s->ddate; 
			$ref_no   = $s->ref_no;
			$route_name = $s->root_name;
			$store_f_name = $s->f_store;
			$store_t_name = $s->t_store;
			$driver_name = $s->driv_name;
			$salesman_name = $s->sal_name;
			$helper_name = $s->hel_name;

		}

		$this->pdf->setY(20);
		$this->pdf->SetFont('helvetica', 'BU', 10);
		$this->pdf->Ln();
		$orgin_print=$_POST['org_print'];
		if($orgin_print=="1"){
	  	$this->pdf->Cell(0, 5,' SEETTU LOADING',0,false, 'C', 0, '', 0, false, 'M', 'M');
	  	}else{
	  	$this->pdf->Cell(0, 5,' SEETTU LOADING (Duplicate) ',0,false, 'C', 0, '', 0, false, 'M', 'M');
	  	}
	 	$this->pdf->SetFont('helvetica', '', 9);
	 	$this->pdf->setY(25);
	 	$this->pdf->Ln();

	 	$this->pdf->Cell(20, 1,"No", '0', 0, 'L', 0);
	 	$this->pdf->Cell(5, 1, ':', '0', 0, 'L', 0);
	 	$this->pdf->Cell(40, 1,$nno, '0', 0, 'L', 0);
	 	$this->pdf->Cell(30, 1, "", '0', 0, 'L', 0);
	 	
	 	$this->pdf->Cell(30, 1, "Date ", '0', 0, 'L', 0);
	 	$this->pdf->Cell(5, 1, ':', '0', 0, 'L', 0);
	 	$this->pdf->Cell(60, 1,$date, '0', 0, 'L', 0);
	 	$this->pdf->Ln();

	 	$this->pdf->Cell(20, 1,"Root", '0', 0, 'L', 0);
	 	$this->pdf->Cell(5, 1, ':', '0', 0, 'L', 0);
	 	$this->pdf->Cell(40, 1,$route_name, '0', 0, 'L', 0);
	 	$this->pdf->Cell(30, 1, "", '0', 0, 'L', 0);
	 	
	 	$this->pdf->Cell(30, 1, "Driver ", '0', 0, 'L', 0);
	 	$this->pdf->Cell(5, 1, ':', '0', 0, 'L', 0);
	 	$this->pdf->Cell(60, 1,$driver_name, '0', 0, 'L', 0);
	 	$this->pdf->Ln();

	 	$this->pdf->Cell(20, 1, 'Store From', '0', 0, 'L', 0);
	 	$this->pdf->Cell(5, 1, ':', '0', 0, 'L', 0);
	 	$this->pdf->Cell(40, 1, $store_f_name, '0', 0, 'L', 0);
	 	$this->pdf->Cell(30, 1, "", '0', 0, 'L', 0);
	 	
	 	$this->pdf->Cell(30, 1, "Salesman ", '0', 0, 'L', 0);
	 	$this->pdf->Cell(5, 1, ':', '0', 0, 'L', 0);
	 	$this->pdf->Cell(60, 1, $salesman_name, '0', 0, 'L', 0);
	 	$this->pdf->Ln();

	 	$this->pdf->Cell(20, 1, 'Store To', '0', 0, 'L', 0);
	 	$this->pdf->Cell(5, 1, ':', '0', 0, 'L', 0);
	 	$this->pdf->Cell(40, 1, $store_t_name, '0', 0, 'L', 0);
	 	$this->pdf->Cell(30, 1, "", '0', 0, 'L', 0);
	 	

	 	$this->pdf->Cell(30, 1, 'Helper', '0', 0, 'L', 0);
	 	$this->pdf->Cell(5, 1, ':', '0', 0, 'L', 0);
	 	$this->pdf->Cell(60, 1, $helper_name, '0', 0, 'L', 0);
	 	$this->pdf->Ln();

		$this->pdf->SetY(50);
		$this->pdf->SetX(25);
		
    	$this->pdf->SetFont('helvetica','B',9);
		$this->pdf->MultiCell(30, 6, "Organizer", $border=1, $align='C', $fill=false, $ln=0, $x=($this->pdf->GetX()-5), $y=($this->pdf->GetY()), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=6, $valign='M', $fitcell=true);
        $this->pdf->MultiCell(15, 6, "Settu No", $border=1, $align='C', $fill=false, $ln=0, $x=($this->pdf->GetX()), $y=$this->pdf->GetY(), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=6, $valign='M', $fitcell=true);
        $this->pdf->MultiCell(15, 6, "Req No", $border=1, $align='C', $fill=false, $ln=0, $x=($this->pdf->GetX()), $y=$this->pdf->GetY(), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=6, $valign='M', $fitcell=true);
        $this->pdf->MultiCell(20, 6, "Req Date", $border=1, $align='C', $fill=false, $ln=0, $x=($this->pdf->GetX()), $y=$this->pdf->GetY(), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=6, $valign='M', $fitcell=true);
        $this->pdf->MultiCell(20, 6, "Category", $border=1, $align='C', $fill=false, $ln=0, $x=($this->pdf->GetX()), $y=$this->pdf->GetY(), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=6, $valign='M', $fitcell=true);
        $this->pdf->MultiCell(20, 6, "Item", $border=1, $align='C', $fill=false, $ln=0, $x=($this->pdf->GetX()), $y=$this->pdf->GetY(), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=6, $valign='M', $fitcell=true);
        $this->pdf->MultiCell(20, 6, "Description", $border=1, $align='C', $fill=false, $ln=0, $x=($this->pdf->GetX()), $y=$this->pdf->GetY(), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=6, $valign='M', $fitcell=true);
        $this->pdf->MultiCell(40, 6, "Status", $border=1, $align='C', $fill=false, $ln=0, $x=($this->pdf->GetX()), $y=$this->pdf->GetY(), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=6, $valign='M', $fitcell=true);

        $v=1;
        $this->pdf->SetY(56);
            
        foreach($det as $row){
        	$aa = $this->pdf->getNumLines($row->name, 75);
	        $heigh=5*$aa;
        	$this->pdf->SetLineStyle(array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0.1, 'color' => array(0, 0, 0)));
        	$this->pdf->SetX(20);

			$this->pdf->SetFont('helvetica','',9);
			$this->pdf->MultiCell(30, $heigh, $row->name, $border=1, $align='L', $fill=false, $ln=0, $x=($this->pdf->GetX()), $y=($this->pdf->GetY()), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=6, $valign='M', $fitcell=true);
            $this->pdf->MultiCell(15, $heigh, $row->settu_no, $border=1, $align='L', $fill=false, $ln=0, $x=($this->pdf->GetX()), $y=$this->pdf->GetY(), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=6, $valign='M', $fitcell=true);
            $this->pdf->MultiCell(15, $heigh, $row->req_no, $border=1, $align='L', $fill=false, $ln=0, $x=($this->pdf->GetX()), $y=$this->pdf->GetY(), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=6, $valign='M', $fitcell=true);
            $this->pdf->MultiCell(20, $heigh, $row->req_date, $border=1, $align='R', $fill=false, $ln=0, $x=($this->pdf->GetX()), $y=$this->pdf->GetY(), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=6, $valign='M', $fitcell=true);
            $this->pdf->MultiCell(20, $heigh, $row->code, $border=1, $align='L', $fill=false, $ln=0, $x=($this->pdf->GetX()), $y=($this->pdf->GetY()), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=6, $valign='M', $fitcell=true);
            $this->pdf->MultiCell(20, $heigh, $row->item, $border=1, $align='L', $fill=false, $ln=0, $x=($this->pdf->GetX()), $y=$this->pdf->GetY(), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=6, $valign='M', $fitcell=true);
            $this->pdf->MultiCell(20, $heigh, $row->des, $border=1, $align='L', $fill=false, $ln=0, $x=($this->pdf->GetX()), $y=$this->pdf->GetY(), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=6, $valign='M', $fitcell=true);
            if($row->reason!=""){
            	$this->pdf->MultiCell(40, $heigh, $row->reason, $border=1, $align='L', $fill=false, $ln=0, $x=($this->pdf->GetX()), $y=$this->pdf->GetY(), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=6, $valign='M', $fitcell=true);
            }else{
            	$this->pdf->MultiCell(40, $heigh, 'Loaded', $border=1, $align='L', $fill=false, $ln=0, $x=($this->pdf->GetX()), $y=$this->pdf->GetY(), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=6, $valign='M', $fitcell=true);
            }
            
            
            $this->pdf->Ln();
            $v++;
        }
       
       
        $this->pdf->Ln();
        $this->pdf->Ln();
        $this->pdf->Ln();
 		$this->pdf->SetFont('helvetica','',9);
 		$this->pdf->Cell(30, 1, "........................................ ", '0', 0, 'L', 0);
	 	$this->pdf->Cell(100, 1, ' ', '0', 0, 'L', 0);
	 	$this->pdf->Cell(60, 1, ".........................................", '0', 0, 'L', 0);
	 	$this->pdf->Ln();


		$this->pdf->Cell(40, 1, "Prepaired By ", '0', 0, 'C', 0);
	 	$this->pdf->Cell(90, 1, ' ', '0', 0, 'L', 0);
	 	$this->pdf->Cell(40, 1, "Approved By", '0', 0, 'C', 0);
	 	$this->pdf->Ln();

		$this->pdf->Output("Settu loading_".date('Y-m-d').".pdf", 'I');

?>