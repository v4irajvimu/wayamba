<?php
error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
	$this->pdf->setPrintHeader($header,$type,$duration);
	$this->pdf->setPrintHeader(true,$type);
    $this->pdf->setPrintFooter(true);
    //print_r($customer);
    $this->pdf->SetFont('helvetica', 'B', 16);
	$this->pdf->AddPage($orientation,$page);   // L or P amd page type A4 or A3

 	$branch_name="";
    
    foreach($branch as $ress){
        $branch_name=$ress->name;
        $this->pdf->headerSet3($ress->name,$ress->address,$ress->tp,$ress->fax,$ress->email);
    }
    foreach($clus as $cl){
        $claster_name=$cl->description;
        $cl_code=$cl->code;
    }
    foreach($bran as $b){
        $b_name=$b->name;
        $b_code=$b->bc;
    }
    foreach($str as $s){
        $s_name=$s->description;
        $s_code=$s->code;
    }
    foreach($dp as $d){
        $d_name=$d->description;
        $d_code=$d->code;
    }
    foreach($cat as $mc){
        $m_cat=$mc->description;
        $m_cat_code=$mc->code;
    }
    foreach($scat as $sc){
        $s_cat=$sc->description;
        $s_cat_code=$sc->code;
    }
     foreach($itm as $it){
        $i_name=$it->description;
        $i_code=$it->code;
    }
     foreach($unt as $u){
        $u_name=$u->description;
        $u_code=$u->code;
    }
     foreach($brnd as $br){
        $br_name=$br->description;
        $br_code=$br->code;
    }
     foreach($sup as $su){
        $su_name=$su->name;
        $su_code=$su->code;
    }
		
	// $this->pdf->setY(25);

	$this->pdf->SetFont('helvetica', 'BU',12);
 	$this->pdf->Cell(0, 6, 'Purchase Order Quantity To Be Received  ',0,false, 'L', 0, '', 0, false, 'M', 'M');
	$this->pdf->Ln();
	

    // $this->pdf->setY(27);
    // $this->pdf->Cell(85, 6,"",'T',0, 'L', 0);
    // $this->pdf->Ln(); 

	$this->pdf->setX(15);
    $this->pdf->SetFont('helvetica', 'B', 8);
    $this->pdf->Cell(25, 6, "Cluster", '0', 0, 'L', 0);
    $this->pdf->Cell(100, 6, ": ".$cl_code." - ".$claster_name, '0', 0, 'L', 0);
    $this->pdf->Cell(20, 6, "Branch", '0', 0, 'L', 0);
    $this->pdf->Cell(20, 6,": ".$b_code." - ".$b_name, '0', 0, 'L', 0);
    $this->pdf->Ln();

    $this->pdf->SetFont('helvetica', 'B', 8);


/*	$this->pdf->SetX(15);
    $this->pdf->SetFont('helvetica','B',8);
    $this->pdf->Cell(70, 6,"  Supplier", '1', 0, 'C', 0);
    $this->pdf->Cell(15, 6,"Po No  ", '1', 0, 'C', 0);
    $this->pdf->Cell(20, 6,"  Date", '1', 0, 'C', 0);
    $this->pdf->Cell(35, 6,"  Item  ", '1', 0, 'C', 0);
    $this->pdf->Cell(70, 6,"  Description  ", '1', 0, 'C', 0);
    $this->pdf->Cell(20, 6,"Order Qty  ", '1', 0, 'C', 0);
    $this->pdf->Cell(20, 6,"Received Qty  ", '1', 0, 'C', 0);
    $this->pdf->Cell(20, 6,"Balance Qty  ", '1', 0, 'C', 0);*/
    $this->pdf->Ln(12);


    foreach ($customer as $value) {
	$SuNm=$value->supplier." - ".$value->name;
    $heigh=6*(max(1,$this->pdf->getNumLines($SuNm, 70),$this->pdf->getNumLines($value->description, 75)));
    $this->pdf->HaveMorePages($heigh);

	$this->pdf->SetLineStyle(array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0.1, 'color' => array(0, 0, 0)));

	$this->pdf->SetX(15);
	$this->pdf->SetFont('helvetica','',8);
 //    $aa = $this->pdf->getNumLines($value->description, 70);
	// $heigh=5*$aa;
	
    $this->pdf->MultiCell(70, $heigh, $value->supplier." - ".$value->name,  1, 'L', false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
    $this->pdf->MultiCell(15, $heigh, $value->nno,  1, 'R', false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
    $this->pdf->MultiCell(20, $heigh, $value->ddate,  1, 'R', false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
    $this->pdf->MultiCell(35, $heigh, $value->item,  1, 'L', false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
    $this->pdf->MultiCell(75, $heigh, $value->description,  1, 'L', false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
    $this->pdf->MultiCell(20, $heigh, $value->qty,  1, 'R', false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
    $this->pdf->MultiCell(20, $heigh, $value->Received,  1, 'L', false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
    $this->pdf->MultiCell(20, $heigh, $value->ToBeReceive,  1, 'L', false, 1, '', '', true, 0, false, true, $heigh,'M' ,false);
       
    	
    }

	$this->pdf->Output("Purchase order qty received".date('Y-m-d').".pdf", 'I');

?>