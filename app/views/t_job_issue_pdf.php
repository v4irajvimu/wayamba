<?php
error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);

$this->pdf->setPrintHeader(true);
$this->pdf->setPrintHeader($header,$type); 
$this->pdf->AddPage($orientation,$page);


foreach ($branch as $ress) {
	$this->pdf->headerSet4($ress->name,$ress->address,$ress->tp,$ress->fax,$ress->email);
}

foreach($sum as $row){
  $cus_id = $row->cus_id;
  $cus_name = $row->name;
  $no = $row->nno;
  $ref_no = $row->ref_no;
  $memo = $row->memo;
  $date=$row->ddate;
  $drn = $row->drn_no;
}

$align_h=$this->utility->heading_align();

$this->pdf->setY(15);
$this->pdf->SetFont('helvetica', 'B', 10);
$this->pdf->Cell(0, 5,'Issue to Customer Note',0,false, $align_h, 0, '', 0, false, 'M', 'M');
$this->pdf->Ln();
$this->pdf->Cell(0, 1,"", 'T', 1, 'L', 0);
$this->pdf->SetFont('helvetica', 'B', 9);
$this->pdf->Cell(20, 1, "Customer", '0', 0, 'L', 0);
$this->pdf->Cell(3, 1," - ", '', 0, 'C', 0);
$this->pdf->SetFont('helvetica', '0', 9);
$this->pdf->Cell(112, 1,$cus_id." - ".$cus_name, '0', 0, 'L', 0);


$this->pdf->SetFont('helvetica', 'B', 9);
$this->pdf->Cell(15, 1, "No" , '0', 0, 'L', 0);
$this->pdf->Cell(3, 1," - ", '0', 0, 'C', 0);
$this->pdf->SetFont('helvetica', '0', 9);
$this->pdf->Cell(22, 1,$no, '0', 0, 'L', 0);
$this->pdf->Ln(5);
$this->pdf->SetFont('helvetica', 'B', 9);
$this->pdf->Cell(20, 1,"Comment ", '0', 0, 'L', 0);
$this->pdf->Cell(3, 1," - ", '', 0, 'C', 0);
$this->pdf->SetFont('helvetica', '', 9);
$this->pdf->Cell(112, 1,$memo, '0', 0, 'L', 0);

$this->pdf->SetFont('helvetica', 'B', 9);
$this->pdf->Cell(15, 1, "Date" , '0', 0, 'L', 0);
$this->pdf->Cell(3, 1," - ", '', 0, 'C', 0);
$this->pdf->SetFont('helvetica', '0', 9);
$this->pdf->Cell(22, 1,$date, '0', 0, 'L', 0);
$this->pdf->Ln(5);
$this->pdf->SetFont('helvetica', 'B', 9);
$this->pdf->Cell(135, 1," ", '0', 0, 'L', 0);
$this->pdf->Cell(15, 1, "Ref No" , '0', 0, 'L', 0);
$this->pdf->Cell(3, 1," - ", '', 0, 'C', 0);
$this->pdf->SetFont('helvetica', '0', 9);
$this->pdf->Cell(22, 1,$ref_no, '0', 0, 'L', 0);
$this->pdf->Ln(6);

$this->pdf->SetFont('helvetica', 'B', 9);
$this->pdf->Cell(135, 1," ", '0', 0, 'L', 0);
$this->pdf->Cell(15, 1, "Drn No" , '0', 0, 'L', 0);
$this->pdf->Cell(3, 1," - ", '', 0, 'C', 0);
$this->pdf->SetFont('helvetica', '0', 9);
$this->pdf->Cell(22, 1,$drn, '0', 0, 'L', 0);
$this->pdf->Ln(6);

$this->pdf->SetFont('helvetica', 'B', 9);
$this->pdf->Cell(10, 6,"No" , '1', 0, 'C', 0);
$this->pdf->Cell(15, 6,"Job No" , '1', 0, 'C', 0);
$this->pdf->Cell(22, 6,"Receive Date" , '1', 0, 'C', 0);
$this->pdf->Cell(65, 6,"Item" , '1', 0, 'C', 0);
$this->pdf->Cell(50, 6,"Fault" , '1', 0, 'C', 0);
$this->pdf->Cell(25, 6,"Amount" , '1', 0, 'C', 0);

$this->pdf->Ln();
$this->pdf->SetFont('helvetica', '0', 9);
$x =1;

foreach($det as $dt){
$heigh=6*(max(1,$this->pdf->getNumLines($dt->item_code ." - ". $dt->Item_name,65),$this->pdf->getNumLines($dt->fault,50)));
$this->pdf->SetFont('helvetica','',9);
$this->pdf->SetLineStyle(array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0.1, 'color' => array(0, 0, 0)));
$this->pdf->MultiCell(10, $heigh,$x,1, 'R',false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
$this->pdf->MultiCell(15, $heigh,$dt->job_no,1, 'R',false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
$this->pdf->MultiCell(22, $heigh,$dt->r_date,1, 'L',false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
$this->pdf->MultiCell(65, $heigh,$dt->item_code ." - ". $dt->Item_name,1, 'L',false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
$this->pdf->MultiCell(50, $heigh,$dt->fault,1, 'L',false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
$this->pdf->MultiCell(25, $heigh,$dt->job_amt,1, 'R',false, 1, '', '', true, 0, false, true, $heigh,'M' ,false);

 $x++;	
}

$this->pdf->Ln(6);

$this->pdf->SetFont('helvetica','B',9);
$this->pdf->Cell(132, 6,"" , '0', 0, 'R', 0);
$this->pdf->Cell(30, 6,"Total" , '0', 0, 'L', 0);
$this->pdf->Cell(25, 6,number_format($row->amount,2) , '1', 0, 'R', 0);
$this->pdf->Ln();
$this->pdf->SetFont('helvetica','B',9);
$this->pdf->Cell(132, 6,"" , '0', 0, 'R', 0);
$this->pdf->Cell(30, 6,"Advance Amount" , '0', 0, 'L', 0);
$this->pdf->Cell(25, 6,number_format($row->advance,2) , '1', 0, 'R', 0);
$this->pdf->Ln();
$this->pdf->SetFont('helvetica','B',9);
$this->pdf->Cell(132, 6,"" , '0', 0, 'R', 0);
$this->pdf->Cell(30, 6,"Balance Amount" , '0', 0, 'L', 0);
$this->pdf->Cell(25, 6,number_format($row->balance,2) , '1', 0, 'R', 0);

$this->pdf->Ln(6);
$this->pdf->footer_set_services($user);
$this->pdf->Output("Service Reject_".date('Y-m-d').".pdf", 'I');
?>