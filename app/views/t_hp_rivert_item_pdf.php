<?php
error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);

$this->pdf->setPrintFooter(true,'0',$is_cur_time);
$this->pdf->setPrintHeader(true);
$this->pdf->setPrintHeader($header,$type); 

$this->pdf->SetFont('helvetica', 'B', 16);
$this->pdf->AddPage($orientation,$page);   // L or P amd page type A4 or A3
foreach($branch as $ress){
	$this->pdf->headerSet4($ress->name,$ress->address,$ress->tp,$ress->fax,$ress->email,$is_print_logo);
}

foreach($sum as $s){
	$no 		= $s->nno;
	$date 		= $s->ddate;
	$ref 		= $s->ref_no;
	$agr_no 	= $s->agr_no;
	$cus_id 	= $s->cus_id;
	$cus_name = $s->cus_name;
	$tot_qty 		= $s->tot_qty;
	$from_store 	= $s->from_store;
	$address1 		= $s->address1;
	$address2 		= $s->address2;
	$address3 		= $s->address3;
	$hp_nno 		= $s->hp_nno;
	$hp_ddate 		= $s->hp_ddate;
	$hp_ref_no 		= $s->hpref_no;
	$store_name 	= $s->store_name;
	$note 			= $s->note;
	$rivert_person 	= $s->ret_person_name;
	$salesmn 	= $s->salesman_name;
}

foreach($session as $ses){
	$invoice_no=$session[0].$session[1].$session[2];
}

$align_h=$this->utility->heading_align();
$this->pdf->Ln();
$this->pdf->setY(20);

$this->pdf->SetFont('helvetica', 'B', 12);
$this->pdf->Cell(0, 5, 'Rivert Item to Customer',0,false, $align_h, 0, '', 0, false, 'M', 'M');

$this->pdf->SetFont('helvetica', 'b', 8);
$this->pdf->setY(25);
$this->pdf->Cell(25, 1, 'Agreenment No', '0', 0, 'L', 0);
$this->pdf->SetFont('helvetica', '', 8);
$this->pdf->Cell(115, 1,$agr_no, '0', 0, 'L', 0);
$this->pdf->Cell(2, 1, "", '0', 0, 'L', 0);
$this->pdf->SetFont('helvetica', 'b', 8);
$this->pdf->Cell(10, 1,"No", '0', 0, 'L', 0);
$this->pdf->SetFont('helvetica', '', 8);
$this->pdf->Cell(20, 1, $no, '0', 0, 'L', 0);
$this->pdf->Ln();

$this->pdf->SetFont('helvetica', 'B', 8);
$this->pdf->Cell(25, 1,'Customer ID', '0', 0, 'L', 0);
$this->pdf->SetFont('helvetica', '', 8);
$this->pdf->Cell(115, 1,$cus_id, '0', 0, 'L', 0);
$this->pdf->SetFont('helvetica', 'b', 8);
$this->pdf->Cell(2, 1, "", '0', 0, 'L', 0);
$this->pdf->SetFont('helvetica', 'b', 8);
$this->pdf->Cell(10, 1,"Date", '0', 0, 'L', 0);
$this->pdf->SetFont('helvetica', '', 8);
$this->pdf->Cell(20, 1, $date, '0', 0, 'L', 0);
$this->pdf->Ln();

$this->pdf->SetFont('helvetica', 'B', 8);
$this->pdf->Cell(25, 1,'Name', '0', 0, 'L', 0);
$this->pdf->SetFont('helvetica', '', 8);
$heigh1=6*(max(1,$this->pdf->getNumLines($row->cus_name,115)));
$this->pdf->MultiCell(115, $heigh1, $cus_name,0, 'L',false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
$this->pdf->Cell(2, 1, "", '0', 0, 'L', 0);
$this->pdf->SetFont('helvetica', 'b', 8);
$this->pdf->Cell(15, 1,"Ref No", '0', 0, 'L', 0);
$this->pdf->SetFont('helvetica', '', 8);
$this->pdf->Cell(20, 1, $ref, '0', 0, 'L', 0);
$this->pdf->Ln();
$this->pdf->SetFont('helvetica', 'b', 8);
$this->pdf->Cell(25, 1,"Address", '0', 0, 'L', 0);
$this->pdf->SetFont('helvetica', '', 8);
$heigh2=6*(max(1,$this->pdf->getNumLines($address1.",".$address2.",".$address3,80)));
$this->pdf->MultiCell(80, $heigh2,$address1.",".$address2.",".$address3,0, 'L',false, 1, '', '', true, 0, false, true, $heigh,'M' ,false);
$this->pdf->SetFont('helvetica', 'b', 8);
$this->pdf->Cell(25, 1,"Store", '0', 0, 'L', 0);
$this->pdf->SetFont('helvetica', '', 8);
$this->pdf->Cell(80, 1,$from_store."-".$store_name,'0', 0, 'L', 0);
$this->pdf->Ln();
$this->pdf->Ln();

$this->pdf->setX(15);
$this->pdf->SetFont('helvetica','B',8);
$this->pdf->Cell(10, 6,"No", '1', 0, 'C', 0);
$this->pdf->Cell(25, 6,"Item Code", '1', 0, 'C', 0);
$this->pdf->Cell(70, 6,"Item Name", '1', 0, 'C', 0);
$this->pdf->Cell(40, 6,"Serial No", '1', 0, 'C', 0);
$this->pdf->Cell(20, 6,"A/Qty", '1', 0, 'C', 0);
$this->pdf->Cell(20, 6,"T/Qty", '1', 0, 'C', 0);



$this->pdf->Ln();
$x=1;
$code="default";
$tot_qty=0;

foreach($det as $row){
	$this->pdf->SetLineStyle(array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0.1, 'color' => array(0, 0, 0)));
	$this->pdf->setX(15);
	$this->pdf->SetFont('helvetica','',8);

	$heigh=6*(max(1,$this->pdf->getNumLines($row->item_name,70)));
	$this->pdf->HaveMorePages($heigh);

	$this->pdf->MultiCell(10, $heigh,$x,1, 'R',false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
	$this->pdf->MultiCell(25, $heigh,$row->item_code,1, 'L',false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
	$this->pdf->MultiCell(70, $heigh,$row->item_name,1, 'L',false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
	$this->pdf->MultiCell(40, $heigh,$row->serial_no,1, 'L',false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
	$this->pdf->MultiCell(20, $heigh,$row->a_qty,1, 'R',false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
	$this->pdf->MultiCell(20, $heigh,$row->t_qty,1, 'R',false, 1, '', '', true, 0, false, true, $heigh,'M' ,false);
	$x++;
	$tot_qty+=$row->t_qty;

	$ss="";
	foreach ($serial as $rows) {
		if($row->item_code==$rows->item)
		{
			$ss=$rows->serial_no;
		}
	}
	if($ss!=""){
		$all_serial="";
		foreach ($serial as $rows) {
			if($row->item_code==$rows->item)
			{					
				$all_serial=$all_serial.$rows->serial_no."   ";
			}
		}

		$this->pdf->MultiCell(10, $heigh,"",0, 'R',false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
		$this->pdf->MultiCell(25, $heigh,"",0, 'L',false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
		$this->pdf->MultiCell(70, $heigh,$all_serial,1, 'L',false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
		$this->pdf->MultiCell(40, $heigh,"",0, 'L',false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
		$this->pdf->MultiCell(20, $heigh,"",0, 'R',false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
		$this->pdf->MultiCell(20, $heigh,"",0, 'R',false, 1, '', '', true, 0, false, true, $heigh,'M' ,false);
	}
}

$this->pdf->SetFont('helvetica','B',8);
$this->pdf->setX(8);
$this->pdf->Cell(152, 6," ", '0', 0, 'L', 0);
$this->pdf->Cell(20, 6,"Total Qty", '0', 0, 'L', 0);
$this->pdf->SetFont('helvetica','B',8);
$this->pdf->Cell(20, 6,$tot_qty, 'TB', 0, 'R', 0);
$this->pdf->Ln();
$this->pdf->setX(8);


$this->pdf->setX(15);
$this->pdf->SetFont('helvetica','B',8);
$this->pdf->Cell(20, 6,"Note ", '0', 0, 'L', 0);
$this->pdf->SetFont('helvetica','',8);
$this->pdf->Cell(130, 6,$note, '0', 0, 'L', 0);
$this->pdf->Ln();

$this->pdf->SetFont('helvetica','B',8);
$this->pdf->Cell(20, 6,"Rivert Person ", '0', 0, 'L', 0);
$this->pdf->SetFont('helvetica','',8);
$this->pdf->Cell(130, 6,$rivert_person, '0', 0, 'L', 0);
$this->pdf->Ln();

$this->pdf->SetFont('helvetica','B',8);
$this->pdf->Cell(20, 6,"Salesman ", '0', 0, 'L', 0);
$this->pdf->SetFont('helvetica','',8);
$this->pdf->Cell(130, 6,$salesmn, '0', 0, 'L', 0);
$this->pdf->Ln();
$this->pdf->Output("hire_purchase_seize".date('Y-m-d').".pdf", 'I');

?>