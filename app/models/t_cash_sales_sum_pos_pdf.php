<?php
error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
$this->pdf->setPrintFooter(false,'0',$is_cur_time);
$this->pdf->setPrintHeader(true);
$page="POS";
$this->pdf->getPageSizeFromFormat($page);
$pos_print=$this->pdf->getPageSizeFromFormat($page);
$this->pdf->AddPage("P",$pos_print); 
$this->pdf->SetFont('helvetica', 'B', 8);

$tot_free_item=(float)0;

foreach($tot_free_items as $free){
	$free_price = $free->price;
	$tot_free_item+=(float)$free_price;	
}

foreach($branch as $ress){
	$this->pdf->headerSet5($ress->name,$ress->address,$ress->tp,$ress->fax,$ress->email);
}
$cus_name=$cus_address=$add=$deduct= "";

foreach($customer as $cus){
	$cus_name=$cus->name;
	$cus_address=$cus->address1." ".$cus->address2." ".$cus->address3;
	$cus_id=$cus->code;
}

foreach($cash_sum as $csum){
	$scus_name=$csum->cus_name;
	$scus_address=$csum->cus_address;
}

if($scus_name==""){
	$scus_name=$cus_name;
}else{
	$scus_name=$scus_name;
}

foreach($user as $r){
	$operator=$r->discription;
	$date =$r->ddate;
}

foreach($employees as $emp){
	$salesman=$emp->name;

}


foreach($session as $ses){
	$invoice_no=$session[0].$session[1].'CA'.$session[2];
}

foreach($amount as $amo){
	$gross = $amo->gross_amount;
	$discount = $amo->discount_amount;
	$add = $amo->additional_add;
	$deduct = $amo->additional_deduct;
	$net = $amo->net_amount;
}
$tot_addi=$add-$deduct;

$customer_name="";
$customer_address="";
$customer_id="";
$cus_status="";


$this->pdf->setY(24);
$this->pdf->setX(0);          
$this->pdf->SetLineStyle(array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0.01, 'color' => array(0, 0, 0)));            
$this->pdf->Cell(100, 1,"",B,false, 'C', 0, '', 0, false, 'M', 'M'); 


$this->pdf->setY(30);
$this->pdf->SetFont('helvetica', 'B',12);
$this->pdf->Cell(50, 1,"CASH BILL  ",0,false, 'C', 0, '', 0, false, 'M', 'M');            
$this->pdf->Ln();

$this->pdf->setY(32);
$this->pdf->setX(0);          
$this->pdf->SetLineStyle(array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0.01, 'color' => array(0, 0, 0)));            
$this->pdf->Cell(100, 1,"",B,false, 'C', 0, '', 0, false, 'M', 'M'); 


$this->pdf->setY(36);
$this->pdf->setX(2);


$this->pdf->SetFont('helvetica', 'B', 9);
$this->pdf->Cell(20, 5, "Invoice No", '0', 0, 'L', 0);
$this->pdf->SetFont('helvetica', '', 9);
$this->pdf->Cell(25, 5,$invoice_no, '0', 0, 'L', 0);
$this->pdf->SetFont('helvetica', 'B', 9);
$this->pdf->Cell(10, 5, "Date", '0', 0, 'L', 0);
$this->pdf->SetFont('helvetica', '', 9);
$this->pdf->Cell(10, 5, $date, '0', 0, 'L', 0);

$this->pdf->Ln();
$this->pdf->setX(2);
$this->pdf->SetFont('helvetica', 'B', 9);
$this->pdf->Cell(20, 5, "Customer", '0', 0, 'L', 0);
$this->pdf->SetFont('helvetica', '', 9);
$this->pdf->Cell(75, 5,$scus_name, '0', 0, 'L', 0);

$this->pdf->setY(44);
$this->pdf->setX(0);          
$this->pdf->SetLineStyle(array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0.01, 'color' => array(0, 0, 0)));            
$this->pdf->Cell(100, 1,"",B,false, 'C', 0, '', 0, false, 'M', 'M');            

$this->pdf->SetY(45);
$this->pdf->SetX(2);
$this->pdf->SetFont('helvetica','B',9);
$this->pdf->Cell(24, 6,"Item", '0', 0, 'L', 0);
$this->pdf->Cell(25, 6,"Price", '0', 0, 'R', 0);
$this->pdf->Cell(12, 6,"Qty", '0', 0, 'R', 0);
$this->pdf->Cell(15, 6,"Amount", '0', 0, 'R', 0);

$this->pdf->setY(48);
$this->pdf->setX(0);          
$this->pdf->SetLineStyle(array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0.01, 'color' => array(0, 0, 0)));            
$this->pdf->Cell(100, 1,"",B,false, 'C', 0, '', 0, false, 'M', 'M'); 


$this->pdf->SetY(52);
foreach($items as $row){
	$this->pdf->SetX(2);
	$this->pdf->SetFont('helvetica','',9);
	$this->pdf->MultiCell(33, 4, $row->code,  0, 'L', 0, 0, '', '', true, 0, false, true, 0);
	$this->pdf->MultiCell(20, 4, $row->price,  0, 'R', 0, 0, '', '', true, 0, false, true, 0);
	$this->pdf->MultiCell(8, 4, $row->qty,  0, 'R', 0, 0, '', '', true, 0, false, true, 0);
	$this->pdf->MultiCell(16, 4, $row->amount, 0, 'R', 0, 1, '', '', true, 0, false, true, 0);


	$aa = $this->pdf->getNumLines($row->description, 60);
	$heigh=4*$aa;

	$this->pdf->SetX(2);
	$this->pdf->SetFont('helvetica','',9);
	$this->pdf->MultiCell(60, $heigh,$row->description,  0, 'L', 0, 0, '', '', true, 0, false, true, 0);
	$this->pdf->MultiCell(20, $heigh, "",  0, 'R', 0, 0, '', '', true, 0, false, true, 0);
	$this->pdf->MultiCell(25, $heigh, "",  0, 'R', 0, 0, '', '', true, 0, false, true, 0);
	$this->pdf->MultiCell(35, $heigh, "",  0, 'R', 0, 1, '', '', true, 0, false, true, 0);


}


$this->pdf->setX(0);          
$this->pdf->SetLineStyle(array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 2.00, 'color' => array(0, 0, 0)));            
$this->pdf->Cell(100, 1,"",B,false, 'C', 0, '', 0, false, 'M', 'M'); 
$this->pdf->Ln(2);
$this->pdf->setX(0);          
$this->pdf->SetLineStyle(array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 2.00, 'color' => array(0, 0, 0)));            
$this->pdf->Cell(100, 1,"",B,false, 'C', 0, '', 0, false, 'M', 'M'); 
$this->pdf->Ln();


$this->pdf->GetY();
$this->pdf->SetX(5);
$this->pdf->SetFont('helvetica','B',9);
$this->pdf->Cell(25, 4,"", '0', 0, 'L', 0);
$this->pdf->Cell(30, 4,"Total", '0', 0, 'L', 0);
$this->pdf->Cell(18, 4,number_format($gross,2), '0', 0, 'R', 0);
$this->pdf->Ln();

$this->pdf->SetX(5);
$this->pdf->SetFont('helvetica','B',9);
$this->pdf->Cell(25, 4,"", '0', 0, 'L', 0);
$this->pdf->Cell(30, 4,"Discount", '0', 0, 'L', 0);
$this->pdf->Cell(18, 4,number_format($discount,2), '0', 0, 'R', 0);
$this->pdf->Ln();

$this->pdf->SetX(5);
$this->pdf->SetFont('helvetica','B',9);
$this->pdf->Cell(25, 4,"", '0', 0, 'L', 0);
$this->pdf->Cell(30, 4,"Additional", '0', 0, 'L', 0);
$this->pdf->Cell(18, 4,number_format($tot_addi,2), '0', 0, 'R', 0);
$this->pdf->Ln();

$this->pdf->Ln();
$this->pdf->SetX(5);
$this->pdf->SetFont('helvetica','B',15);
$this->pdf->Cell(10, 4,"", '0', 0, 'L', 0);
$this->pdf->Cell(45, 4,"Net Amount", '0', 0, 'L', 0);
$this->pdf->Cell(18, 4,number_format($net,2), '0', 0, 'R', 0);
$this->pdf->Ln();

$this->pdf->setX(0);          
$this->pdf->SetLineStyle(array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 2.00, 'color' => array(0, 0, 0)));            
$this->pdf->Cell(100, 1,"",B,false, 'C', 0, '', 0, false, 'M', 'M'); 
$this->pdf->Ln();

$this->pdf->setX(3); 
$this->pdf->SetFont('helvetica', 'B', 9);
$this->pdf->Cell(20, 5, "Operator", '0', 0, 'L', 0);
$this->pdf->SetFont('helvetica', '', 8);
$this->pdf->Cell(70, 5,$operator, '0', 0, 'L', 0);
$this->pdf->Ln();

$this->pdf->setX(3); 
$this->pdf->SetFont('helvetica', 'B', 9);
$this->pdf->Cell(20, 5, "Salesman", '0', 0, 'L', 0);
$this->pdf->SetFont('helvetica', '', 8);
$this->pdf->Cell(70, 5,$salesman, '0', 0, 'L', 0);
$this->pdf->Ln();
$this->pdf->Ln();

$this->pdf-> HaveMorePages(6);
$this->pdf->SetX(5);
$this->pdf->SetFont('helvetica','B',9);
$this->pdf->Cell(70, 4,"** Thank You,Come Again. **", '0', 0, 'C', 0);
$this->pdf->Ln();


$this->pdf->setX(0);          
$this->pdf->SetLineStyle(array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 2.00, 'color' => array(0, 0, 0)));            
$this->pdf->Cell(100, 1,"",B,false, 'C', 0, '', 0, false, 'M', 'M'); 
$this->pdf->Ln();

$this->pdf->SetX(5);
$this->pdf->SetFont('helvetica','',7);
$this->pdf->Cell(70, 4,"Copyrights  Soft-Master Technologies (Pvt) Ltd.", '0', 0, 'C', 0);
$this->pdf->Ln();
$this->pdf->SetX(5);
$this->pdf->SetFont('helvetica','',7);
$this->pdf->Cell(70, 4,"0812-204130, 0814-921402,  0773-889082/3", '0', 0, 'C', 0);
$this->pdf->Ln();

$this->pdf->Output("Cash Sales_".date('Y-m-d').".pdf", 'I');

?>