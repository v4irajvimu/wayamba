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
	

	$this->pdf->setY(25);

	$this->pdf->SetFont('helvetica', 'BU',12);
 	$this->pdf->Cell(0, 5, 'Stock Details  ',0,false, 'L', 0, '', 0, false, 'M', 'M');
	$this->pdf->Ln();
	    
    $this->pdf->setX(15);
    $this->pdf->SetFont('helvetica', 'B', 10);
    $this->pdf->Cell(180, 1, "Date From " .$from. " To ". $to, '0', 0, 'L', 0);
    $this->pdf->Ln();
    
	$this->pdf->setX(15);
    $this->pdf->SetFont('helvetica', 'B', 8);
            
    if($cl_code!=""){
    $this->pdf->Cell(25, 1, "Cluster", '0', 0, 'L', 0);
    $this->pdf->Cell(80, 1, ": ".$cl_code." - ".$claster_name, '0', 0, 'L', 0);
    }
    if($s_cat_code!=""){
    $this->pdf->Cell(25, 1, "Sub Category", '0', 0, 'L', 0);
    $this->pdf->Cell(20, 1,": ".$s_cat_code." - ".$s_cat, '0', 0, 'L', 0);
    }
    $this->pdf->Ln();
    $this->pdf->setX(15);
    if($b_code!=""){
    $this->pdf->Cell(25, 1, "Branch", '0', 0, 'L', 0);
    $this->pdf->Cell(80, 1,": ".$b_code." - ".$b_name, '0', 0, 'L', 0);
    }
    if($i_code!=""){
    $this->pdf->Cell(25, 1, "Item", '0', 0, 'L', 0);
    $this->pdf->Cell(20, 1,": ".$i_code." - ".$i_name, '0', 0, 'L', 0);
    }
    $this->pdf->Ln();
    $this->pdf->setX(15);
    if($s_code!=""){
    $this->pdf->Cell(25, 1, "Store", '0', 0, 'L', 0);
    $this->pdf->Cell(80, 1,": ".$s_code." - ".$s_name, '0', 0, 'L', 0);
    }
    if($u_code!=""){
    $this->pdf->Cell(25, 1, "Unit", '0', 0, 'L', 0);
    $this->pdf->Cell(20, 1,": ".$u_code." - ".$u_name, '0', 0, 'L', 0);
    }
    $this->pdf->Ln();
    $this->pdf->setX(15);
    if($d_code!=""){
    $this->pdf->Cell(25, 1, "Department", '0', 0, 'L', 0);
    $this->pdf->Cell(80, 1,": ".$d_code." - ".$d_name, '0', 0, 'L', 0);
    }
    if($br_code!=""){
    $this->pdf->Cell(25, 1, "Brand", '0', 0, 'L', 0);
    $this->pdf->Cell(20, 1,": ".$br_code." - ".$br_name, '0', 0, 'L', 0);
    }
    $this->pdf->Ln();
    $this->pdf->setX(15);
    if($m_cat_code!=""){
    $this->pdf->Cell(25, 1, "Main Category", '0', 0, 'L', 0);
    $this->pdf->Cell(80, 1,": ".$m_cat_code." - ".$m_cat, '0', 0, 'L', 0);
    }
    if($su_code!=""){
    $this->pdf->Cell(25, 1, "Supplier", '0', 0, 'L', 0);
    $this->pdf->Cell(20, 1,": ".$su_code." - ".$su_name, '0', 0, 'L', 0);
    }


    
    $this->pdf->Ln();

    $this->pdf->SetFont('helvetica', 'B', 8);
	$this->pdf->SetY(66);
	$this->pdf->SetX(25);
	
    foreach ($customer as $value) {

    $heigh=6*(max(1,$this->pdf->getNumLines($value->description, 50),$this->pdf->getNumLines($value->code, 30),$this->pdf->getNumLines($value->model, 35)));
    $this->pdf->HaveMorePages($heigh);	


	$this->pdf->SetLineStyle(array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0.1, 'color' => array(0, 0, 0)));

	$this->pdf->SetX(15);
	$this->pdf->SetFont('helvetica','',8);

    // $aa = $this->pdf->getNumLines($value->description, 25);
    // $bb = $this->pdf->getNumLines($value->code, 25);
    
    // if ($aa>=$bb) {
    //     $heigh =5*$aa; 
    // }
    // else{
    //     $heigh =5*$bb;

    // }
    //$heigh = ($aa<$bb) ? : 5*$bb ;


    $this->pdf->MultiCell(30, $heigh, $value->code,  1, 'L', false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
    $this->pdf->MultiCell(50, $heigh, $value->description,  1, 'L', false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
    $this->pdf->MultiCell(35, $heigh, $value->model,  1, 'L', false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
    $this->pdf->MultiCell(20, $heigh, $value->OPB,  1, 'R', false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
    $this->pdf->MultiCell(15, $heigh, $value->GRN,  1, 'R', false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
    $this->pdf->MultiCell(15, $heigh, $value->CashSales,  1, 'R', false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
    $this->pdf->MultiCell(15, $heigh, $value->CreditSales,  1, 'R', false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
    $this->pdf->MultiCell(20, $heigh, $value->SalesReturn,  1, 'R', false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
    $this->pdf->MultiCell(25, $heigh, $value->clossingStock,  1, 'R', false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
    $this->pdf->MultiCell(15, $heigh, $value->roq,  1, 'R', false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
    $this->pdf->MultiCell(15, $heigh, $value->eoq,  1, 'R', false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
    $this->pdf->MultiCell(15, $heigh, $value->buffer_stock,  1, 'R', false, 1, '', '', true, 0, false, true, $heigh,'M' ,false);

    	
    }

                   	



	//$this->pdf->footerSet($employee,$amount,$additional,$discount,$user);
	$this->pdf->Output("Item List".date('Y-m-d').".pdf", 'I');

?>