<?php
error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
	$this->pdf->setPrintHeader($header,$type,$duration);
	$this->pdf->setPrintHeader(true,$type);
    $this->pdf->setPrintFooter(true);
    //$this->pdf->setPageOrientation('MediaBox',true,11);
    //print_r($customer);
    $this->pdf->SetFont('helvetica', 'B', 16);
	$this->pdf->AddPage("P",$page);   // L or P amd page type A4 or A3

 	$branch_name="";
    
    foreach($branch as $ress){
        $branch_name=$ress->name;
        $this->pdf->setY(10);
        $this->pdf->setX(2);
        $this->pdf->SetFont('helvetica', 'B', 10);
        $this->pdf->Cell(0, 5, 'WAYAMBA TRADING AND INVESTMENT - '.$ress->name,0, false, 'L', 0, '', 0, false, 'M', 'M');
        $this->pdf->Ln();
        $this->pdf->setY(15);
        $this->pdf->SetFont('helvetica', '', 8);
        $this->pdf->Cell(0, 5,$ress->address." Tel: ".$ress->tp." Fax: ".$ress->fax.".  Email: ".$ress->email,0, false, 'L', 0, '', 0, false, 'M', 'M');
            
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
		
//	$this->pdf->setY(25);
    $this->pdf->Ln();    
    $this->pdf->SetX(2); 
	$this->pdf->SetFont('helvetica', 'BU',10);
 	$this->pdf->Cell(0, 5, 'Item List  ',0,false, 'L', 0, '', 0, false, 'M', 'M');
	$this->pdf->Ln();


	$this->pdf->setX(2);
    $this->pdf->SetFont('helvetica', 'B', 8);
    $this->pdf->Cell(25, 1, "Cluster", '0', 0, 'L', 0);
    $this->pdf->Cell(120, 1, ": ".$cl_code." - ".$claster_name, '0', 0, 'L', 0);
    $this->pdf->Cell(20, 1, "Sub Category", '0', 0, 'L', 0);
    $this->pdf->Cell(20, 1,": ".$s_cat_code." - ".$s_cat, '0', 0, 'L', 0);
    $this->pdf->Ln();

    $this->pdf->setX(2);
    $this->pdf->Cell(25, 1, "Branch", '0', 0, 'L', 0);
    $this->pdf->Cell(120, 1,": ".$b_code." - ".$b_name, '0', 0, 'L', 0);
    $this->pdf->Cell(20, 1, "Item", '0', 0, 'L', 0);
    $this->pdf->Cell(20, 1,": ".$i_code." - ".$i_name, '0', 0, 'L', 0);
    $this->pdf->Ln();

    $this->pdf->setX(2);
    $this->pdf->Cell(25, 1, "Store", '0', 0, 'L', 0);
    $this->pdf->Cell(120, 1,": ".$s_code." - ".$s_name, '0', 0, 'L', 0);
    $this->pdf->Cell(20, 1, "Unit", '0', 0, 'L', 0);
    $this->pdf->Cell(20, 1,": ".$u_code." - ".$u_name, '0', 0, 'L', 0);
    $this->pdf->Ln();

    $this->pdf->setX(2);
    $this->pdf->Cell(25, 1, "Department", '0', 0, 'L', 0);
    $this->pdf->Cell(120, 1,": ".$d_code." - ".$d_name, '0', 0, 'L', 0);
    $this->pdf->Cell(20, 1, "Brand", '0', 0, 'L', 0);
    $this->pdf->Cell(20, 1,": ".$br_code." - ".$br_name, '0', 0, 'L', 0);
    $this->pdf->Ln();

    $this->pdf->setX(2);
    $this->pdf->Cell(25, 1, "Main Category", '0', 0, 'L', 0);
    $this->pdf->Cell(120, 1,": ".$m_cat_code." - ".$m_cat, '0', 0, 'L', 0);
    $this->pdf->Cell(20, 1, "Supplier", '0', 0, 'L', 0);
    $this->pdf->Cell(20, 1,": ".$su_code." - ".$su_name, '0', 0, 'L', 0);
    $this->pdf->Ln();
    $this->pdf->Ln();
    $this->pdf->Ln(5);





    foreach ($customer as $value) { 

    $heigh=6*(max(1,$this->pdf->getNumLines($value->description, 40)));
    $this->pdf->HaveMorePages($heigh);

    $this->pdf->SetLineStyle(array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0.1, 'color' => array(0, 0, 0)));
    $this->pdf->SetFont('helvetica','',8);



    
    $borders = '1';


    $this->pdf->setX(2);
    $this->pdf->MultiCell(30, $heigh,$value->code, $borders, 'L', false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
    $this->pdf->MultiCell(40, $heigh,$value->description, $borders, 'L', false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
    $this->pdf->MultiCell(20, $heigh,$value->brand_des,$borders, 'L', false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
    $this->pdf->MultiCell(20, $heigh,$value->model, $borders, 'L', false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
    $this->pdf->MultiCell(15, $heigh,$value->max_price, $borders, 'L', false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
    $this->pdf->MultiCell(15, $heigh,$value->min_price,$borders, 'L', false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
    $this->pdf->MultiCell(45, $heigh,$value->department." - ".$value->Department_Name, $borders, 'L', false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
    $this->pdf->MultiCell(20, $heigh,$value->Category, $borders, 'L', false, 1, '', '', true, 0, false, true, $heigh,'M' ,false);
    

    	
    }
$this->pdf->Cell(205,0,'','T');  //last bottom border
	//$this->pdf->footerSet($employee,$amount,$additional,$discount,$user);
	$this->pdf->Output("Item List".date('Y-m-d').".pdf", 'I');





?>

