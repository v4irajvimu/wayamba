<?php
error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
	$this->pdf->setPrintHeader($header,$type,$duration);
	$this->pdf->setPrintHeader(true,$type);
    $this->pdf->setPrintFooter(true);
    //print_r($customer);
    $this->pdf->SetFont('helvetica', 'B', 16);
	$this->pdf->AddPage("P",$page);   // L or P amd page type A4 or A3

 	$branch_name="";
    
    foreach($branch as $ress){
        $branch_name=$ress->name;
        $this->pdf->setY(10);
        $this->pdf->setX(10);
        $this->pdf->SetFont('helvetica', 'B', 10);
        $this->pdf->Cell(0, 5, 'Nisaco Furniture - '.$ress->name,0, false, 'L', 0, '', 0, false, 'M', 'M');
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
		
  // $this->pdf->setY(25);
    $this->pdf->Ln();
    $this->pdf->SetFont('helvetica', 'BU',10);
    $this->pdf->Cell(0, 5, 'ITEM SALES DETAILS ',0,false, 'L', 0, '', 0, false, 'M', 'M');
    $this->pdf->Ln();

    $this->pdf->setX(15);
    $this->pdf->SetFont('helvetica', 'B', 8);

    if($cl_code!=""){
    $this->pdf->Cell(25, 1, "Cluster", '0', 0, 'L', 0);
    $this->pdf->Cell(60, 1, ": ".$cl_code." - ".$claster_name, '0', 0, 'L', 0);
    }
    if($s_cat_code!=""){
    $this->pdf->Cell(25, 1, "Sub Category", '0', 0, 'L', 0);
    $this->pdf->Cell(20, 1,": ".$s_cat_code." - ".$s_cat, '0', 0, 'L', 0);
    }
    $this->pdf->Ln();
    $this->pdf->setX(15);
    if($b_code!=""){
    $this->pdf->Cell(25, 1, "Branch", '0', 0, 'L', 0);
    $this->pdf->Cell(60, 1,": ".$b_code." - ".$b_name, '0', 0, 'L', 0);
    }
    if($i_code!=""){
    $this->pdf->Cell(25, 1, "Item", '0', 0, 'L', 0);
    $this->pdf->Cell(20, 1,": ".$i_code." - ".$i_name, '0', 0, 'L', 0);
    }
    $this->pdf->Ln();
    $this->pdf->setX(15);
    if($s_code!=""){
    $this->pdf->Cell(25, 1, "Store", '0', 0, 'L', 0);
    $this->pdf->Cell(60, 1,": ".$s_code." - ".$s_name, '0', 0, 'L', 0);
    }
    if($u_code!=""){
    $this->pdf->Cell(25, 1, "Unit", '0', 0, 'L', 0);
    $this->pdf->Cell(20, 1,": ".$u_code." - ".$u_name, '0', 0, 'L', 0);
    }
    $this->pdf->Ln();
    $this->pdf->setX(15);
    if($d_code!=""){
    $this->pdf->Cell(25, 1, "Department", '0', 0, 'L', 0);
    $this->pdf->Cell(60, 1,": ".$d_code." - ".$d_name, '0', 0, 'L', 0);
    }
    if($br_code!=""){
    $this->pdf->Cell(25, 1, "Brand", '0', 0, 'L', 0);
    $this->pdf->Cell(20, 1,": ".$br_code." - ".$br_name, '0', 0, 'L', 0);
    }
    $this->pdf->Ln();
    $this->pdf->setX(15);
    if($m_cat_code!=""){
    $this->pdf->Cell(25, 1, "Main Category", '0', 0, 'L', 0);
    $this->pdf->Cell(60, 1,": ".$m_cat_code." - ".$m_cat, '0', 0, 'L', 0);
    }
    if($su_code!=""){
    $this->pdf->Cell(25, 1, "Supplier", '0', 0, 'L', 0);
    $this->pdf->Cell(20, 1,": ".$su_code." - ".$su_name, '0', 0, 'L', 0);
    }


	//$this->pdf->SetY(53);
	/*$this->pdf->SetFont('helvetica','IB',8);

    $this->pdf->Cell(30, 6,"Code", '1', 0, 'C', 0);
	$this->pdf->Cell(60, 6,"Description", '1', 0, 'C', 0);
    $this->pdf->Cell(15, 6,"Dep", '1', 0, 'C', 0);
    $this->pdf->Cell(30, 6,"Department Name", '1', 0, 'C', 0);
	$this->pdf->Cell(30, 6,"Category ", '1', 0, 'C', 0);
    $this->pdf->Cell(20, 6,"Brand", '1', 0, 'C', 0);
    $this->pdf->Cell(30, 6,"Model", '1', 0, 'C', 0);
    $this->pdf->Cell(15, 6,"Terms", '1', 0, 'C', 0);
    $this->pdf->Cell(18, 6,"Max Price", '1', 0, 'C', 0);
    $this->pdf->Cell(18, 6,"Min Price", '1', 0, 'C', 0);*/
    // $this->pdf->Ln();
    $this->pdf->Ln(12);


    $count=0;
    foreach ($customer as $value) {
    $heigh=6*(max(1,$this->pdf->getNumLines($value->description, 55)));
    $this->pdf->HaveMorePages($heigh);	

	$this->pdf->SetLineStyle(array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0.1, 'color' => array(0, 0, 0)));


    $this->pdf->SetX(10);
    $this->pdf->SetFont('helvetica','',8);
    $this->pdf->MultiCell(30, $heigh, $value->code, 1, 'L', false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
    $this->pdf->MultiCell(55, $heigh, $value->description, 1, 'L', false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
    $this->pdf->MultiCell(20, $heigh, $value->sup_price, 1, 'R', false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
    $this->pdf->MultiCell(20, $heigh, $value->present."%", 1, 'R', false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
    $this->pdf->MultiCell(20, $heigh, $value->purchase_price, 1, 'R', false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
    $this->pdf->MultiCell(20, $heigh, $value->max_price, 1, 'R', false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
    $this->pdf->MultiCell(20, $heigh, $value->min_price, 1, 'R', false, 1, '', '', true, 0, false, true, $heigh,'M' ,false);
	$count++;
    	
    }

    $this->pdf->Ln();
    $this->pdf->SetX(22);
    $this->pdf->Cell(15, 6,"Total Item Count :  ".$count, '0', 0, 'C', 0);
 
	//$this->pdf->footerSet($employee,$amount,$additional,$discount,$user);
	$this->pdf->Output("Item List".date('Y-m-d').".pdf", 'I');

?>