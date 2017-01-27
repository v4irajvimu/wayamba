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
			$nno   		= $s->nno;
			$date     	= $s->date; 
			$ref_no   	= $s->ref_no;
			$load_no 	= $s->load_no;
			$route_name = $s->route_name;
			$store_f_name = $s->store_from_name;
			$store_t_name = $s->store_to_name;
			
		}

		$this->pdf->setY(20);
		$this->pdf->SetFont('helvetica', 'BU', 10);
		$this->pdf->Ln();
		$orgin_print=$_POST['org_print'];
		if($orgin_print=="1"){
	  	$this->pdf->Cell(0, 5,' SEETTU UNLOADING',0,false, 'C', 0, '', 0, false, 'M', 'M');
	  	}else{
	  	$this->pdf->Cell(0, 5,' SEETTU UNLOADING (Duplicate) ',0,false, 'C', 0, '', 0, false, 'M', 'M');
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

	 	$this->pdf->Cell(20, 1,"Load No", '0', 0, 'L', 0);
	 	$this->pdf->Cell(5, 1, ':', '0', 0, 'L', 0);
	 	$this->pdf->Cell(40, 1,$load_no, '0', 0, 'L', 0);
	 	$this->pdf->Cell(30, 1, "", '0', 0, 'L', 0);
	 	
	 	$this->pdf->Cell(30, 1, "Route ", '0', 0, 'L', 0);
	 	$this->pdf->Cell(5, 1, ':', '0', 0, 'L', 0);
	 	$this->pdf->Cell(60, 1,$route_name, '0', 0, 'L', 0);
	 	$this->pdf->Ln();

	 	$this->pdf->Cell(20, 1, 'Store From', '0', 0, 'L', 0);
	 	$this->pdf->Cell(5, 1, ':', '0', 0, 'L', 0);
	 	$this->pdf->Cell(40, 1, $store_f_name, '0', 0, 'L', 0);
	 	$this->pdf->Cell(30, 1, "", '0', 0, 'L', 0);
	 	
	 	$this->pdf->Cell(30, 1, 'Store To', '0', 0, 'L', 0);
	 	$this->pdf->Cell(5, 1, ':', '0', 0, 'L', 0);
	 	$this->pdf->Cell(40, 1, $store_t_name, '0', 0, 'L', 0);
	 	$this->pdf->Cell(30, 1, "", '0', 0, 'L', 0);
	 	$this->pdf->Ln();

		$this->pdf->SetY(50);
		$this->pdf->SetX(25);
		
    	$this->pdf->SetFont('helvetica','B',9);
		$this->pdf->MultiCell(40, 6, "Organizer", $border=1, $align='C', $fill=false, $ln=0, $x=($this->pdf->GetX()-5), $y=($this->pdf->GetY()), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=6, $valign='M', $fitcell=true);
        $this->pdf->MultiCell(20, 6, "Settu No", $border=1, $align='C', $fill=false, $ln=0, $x=($this->pdf->GetX()), $y=$this->pdf->GetY(), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=6, $valign='M', $fitcell=true);
        $this->pdf->MultiCell(20, 6, "Category", $border=1, $align='C', $fill=false, $ln=0, $x=($this->pdf->GetX()), $y=$this->pdf->GetY(), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=6, $valign='M', $fitcell=true);
        $this->pdf->MultiCell(20, 6, "Item", $border=1, $align='C', $fill=false, $ln=0, $x=($this->pdf->GetX()), $y=$this->pdf->GetY(), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=6, $valign='M', $fitcell=true);
        $this->pdf->MultiCell(50, 6, "Description", $border=1, $align='C', $fill=false, $ln=0, $x=($this->pdf->GetX()), $y=$this->pdf->GetY(), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=6, $valign='M', $fitcell=true);

        $v=1;
        $this->pdf->SetY(56);
            
        foreach($det as $row){
        	$aa = $this->pdf->getNumLines($row->name, 75);
	        $heigh=5*$aa;
        	$this->pdf->SetLineStyle(array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0.1, 'color' => array(0, 0, 0)));
        	$this->pdf->SetX(20);

			$this->pdf->SetFont('helvetica','',9);
			$this->pdf->MultiCell(40, $heigh, $row->name, $border=1, $align='L', $fill=false, $ln=0, $x=($this->pdf->GetX()), $y=($this->pdf->GetY()), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=6, $valign='M', $fitcell=true);
            $this->pdf->MultiCell(20, $heigh, $row->seettu_no, $border=1, $align='L', $fill=false, $ln=0, $x=($this->pdf->GetX()), $y=$this->pdf->GetY(), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=6, $valign='M', $fitcell=true);
            $this->pdf->MultiCell(20, $heigh, $row->cat, $border=1, $align='L', $fill=false, $ln=0, $x=($this->pdf->GetX()), $y=($this->pdf->GetY()), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=6, $valign='M', $fitcell=true);
            $this->pdf->MultiCell(20, $heigh, $row->code, $border=1, $align='L', $fill=false, $ln=0, $x=($this->pdf->GetX()), $y=$this->pdf->GetY(), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=6, $valign='M', $fitcell=true);
            $this->pdf->MultiCell(50, $heigh, $row->des, $border=1, $align='L', $fill=false, $ln=0, $x=($this->pdf->GetX()), $y=$this->pdf->GetY(), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=6, $valign='M', $fitcell=true);
                      
            
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

		$this->pdf->Output("Settu unloading_".date('Y-m-d').".pdf", 'I');

?>