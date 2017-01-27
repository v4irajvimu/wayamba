<?php
error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);

$this->pdf->setPrintFooter(true,'0',$is_cur_time);
$this->pdf->setPrintHeader(true);
$this->pdf->setPrintHeader($header,$type); 

$this->pdf->SetFont('helvetica', 'B', 16);
$this->pdf->AddPage($orientation,$page);   // L or P amd page type A4 or A3
foreach($branch as $ress){
	$this->pdf->headerSet4($ress->name,$ress->address,$ress->tp,$ress->fax,$ress->email);
}

$cus_name=$cus_address="";
foreach($customer as $cus){
	$cus_name=$cus->name;
	$cus_address=$cus->address1." ".$cus->address2." ".$cus->address3;
	$cus_id=$cus->code;
}

foreach($amount as $row){
	$agr_no=$row->agreement_no;
}

$align_h=$this->utility->heading_align();
$this->pdf->Ln();
$this->pdf->setY(20);

$this->pdf->SetFont('helvetica', 'BU', 10);
$this->pdf->Cell(0, 5, 'HIRE PURCHASE INVOICE',0,false, $align_h, 0, '', 0, false, 'M', 'M');

$this->pdf->SetFont('helvetica', 'b', 9);
$this->pdf->setY(25);
$this->pdf->Cell(30, 1, 'Invoice No.', '0', 0, 'L', 0);
$this->pdf->SetFont('helvetica', '', 9);
$this->pdf->Cell(30, 1, $qno, '0', 0, 'L', 0);
$this->pdf->Cell(8, 1, "", '0', 0, 'L', 0);
$this->pdf->SetFont('helvetica', 'b', 9);
$this->pdf->Cell(30, 1, "Customer Name", '0', 0, 'L', 0);
$this->pdf->SetFont('helvetica', '', 9);
$this->pdf->Cell(30, 1, $cus_name, '0', 0, 'L', 0);
//$this->pdf->Cell(60, 1, "Bill to Customer", '0', 0, 'L', 0);
$this->pdf->Ln();

$this->pdf->SetFont('helvetica', 'B', 9);
$this->pdf->Cell(30, 1, 'Invoice Date', '0', 0, 'L', 0);
$this->pdf->SetFont('helvetica', '', 9);
$this->pdf->Cell(30, 1, $dt.$save_time, '0', 0, 'L', 0);
$this->pdf->SetFont('helvetica', 'b', 9);
$this->pdf->Cell(8, 1, "", '0', 0, 'L', 0);
$this->pdf->SetFont('helvetica', 'b', 9);
$this->pdf->Cell(30, 1, "ID No", '0', 0, 'L', 0);
$this->pdf->SetFont('helvetica', '', 9);
$this->pdf->Cell(30, 1, $cus_id, '0', 0, 'L', 0);
$this->pdf->Ln();

$this->pdf->SetFont('helvetica', 'B', 9);
$this->pdf->Cell(30, 1, 'Agreement No', '0', 0, 'L', 0);
$this->pdf->SetFont('helvetica', '', 9);
$this->pdf->Cell(30, 1, $agr_no, '0', 0, 'L', 0);
$this->pdf->Cell(8, 1, "", '0', 0, 'L', 0);
$this->pdf->SetFont('helvetica', 'b', 9);
$this->pdf->Cell(30, 1, "Address", '0', 0, 'L', 0);
$this->pdf->SetFont('helvetica', '', 9);
$cc = $this->pdf->getNumLines($cus_address, 85);
$heigh=1*$cc;
$this->pdf->MultiCell(85, $heigh,$cus_address,  0, 'L', 0, 0, '', '', true, 0, false, true, 0);


$this->pdf->Ln();
$this->pdf->SetY(40);
$this->pdf->setX(10);
$this->pdf->SetFont('helvetica','B',9);
$this->pdf->Cell(5, 6,"Sr.", '1', 0, 'C', 0);
$this->pdf->Cell(30, 6,"Code", '1', 0, 'C', 0);
$this->pdf->Cell(50, 6,"Description", '1', 0, 'C', 0);
$this->pdf->Cell(20, 6,"Model", '1', 0, 'C', 0);
$this->pdf->Cell(10, 6,"QTY", '1', 0, 'C', 0);
$this->pdf->Cell(18, 6,"Unit Price", '1', 0, 'C', 0);
$this->pdf->Cell(17, 6,"Discount", '1', 0, 'C', 0);
$this->pdf->Cell(20, 6,"Net Value", '1', 0, 'C', 0);
$this->pdf->Cell(20, 6,"Serial", '1', 0, 'C', 0);

$this->pdf->Ln();
$x=1;
$code="default";
$amt=0;

foreach($items as $row){
	$this->pdf->setX(10);
	$this->pdf->SetLineStyle(array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0.1, 'color' => array(0, 0, 0)));
//	if($code!='default' && $code==$row->code){
		if($row->sub_item!=""){	
			$this->pdf->setX(10);	
			$this->pdf->SetFont('helvetica','',9);
			$aa = $this->pdf->getNumLines($row->des, 55);
			$heigh=5*$aa;
			$this->pdf->MultiCell(10, $heigh,"",  1, 'L', 0, 0, '', '', true, 0, false, true, 0);
			$this->pdf->MultiCell(35, $heigh,$row->sub_item,  1, 'L', 0, 0, '', '', true, 0, false, true, 0);
			$this->pdf->MultiCell(55, $heigh,$row->des,  1, 'L', 0, 0, '', '', true, 0, false, true, 0);
			$this->pdf->MultiCell(25, $heigh,"",  1, 'L', 0, 0, '', '', true, 0, false, true, 0);
			$this->pdf->MultiCell(10, $heigh,$row->sub_qty,  1, 'L', 0, 0, '', '', true, 0, false, true, 0);
			$this->pdf->MultiCell(18, $heigh,"",  1, 'L', 0, 0, '', '', true, 0, false, true, 0);
			$this->pdf->MultiCell(17, $heigh,"",  1, 'L', 0, 0, '', '', true, 0, false, true, 0);
			$this->pdf->MultiCell(20, $heigh,"", 1, 'R', 0, 1, '', '', true, 0, false, true, 0);
		    // $this->pdf->Ln();
			$x=$x-1;
		}
//	}else{
		$this->pdf->GetY();
		$this->pdf->setX(10);
		$this->pdf->SetFont('helvetica','B',9);
		$aa = $this->pdf->getNumLines($row->description, 50);
		$heigh=5*$aa;
		if($row->is_free=="1"){
			$this->pdf->MultiCell(5, $heigh,$x,  1, 'R', 0, 0, '', '', true, 0, false, true, 0);
			$this->pdf->MultiCell(30, $heigh,$row->code, 1, 'L', 0, 0, '', '', true, 0, false, true, 0);
			$this->pdf->MultiCell(50, $heigh,$row->description, 1, 'L', 0, 0, '', '', true, 0, false, true, 0);
			$this->pdf->MultiCell(20, $heigh,"FREE", 1, 'L', 0, 0, '', '', true, 0, false, true, 0);
			$this->pdf->MultiCell(10, $heigh,$row->qty, 1, 'R', 0, 0, '', '', true, 0, false, true, 0);
			$this->pdf->MultiCell(18, $heigh,number_format($row->price,2),  1, 'L', 0, 0, '', '', true, 0, false, true, 0);
			$this->pdf->MultiCell(17, $heigh,number_format($row->discount,2), 1, 'L', 0, 0, '', '', true, 0, false, true, 0);
			$this->pdf->MultiCell(20, $heigh,number_format($row->amount,2),  1, 'L', 0, 0, '', '', true, 0, false, true, 0);
			$this->pdf->MultiCell(20, $heigh,$row->serials,  1, 'L', 0, 1, '', '', true, 0, false, true, 0);
		}else{
			$this->pdf->MultiCell(5, $heigh,$x,  1, 'R', 0, 0, '', '', true, 0, false, true, 0);
			$this->pdf->MultiCell(30, $heigh,$row->code, 1, 'L', 0, 0, '', '', true, 0, false, true, 0);
			$this->pdf->MultiCell(50, $heigh,$row->description, 1, 'L', 0, 0, '', '', true, 0, false, true, 0);
			$this->pdf->MultiCell(20, $heigh,$row->model, 1, 'L', 0, 0, '', '', true, 0, false, true, 0);
			$this->pdf->MultiCell(10, $heigh,$row->qty, 1, 'R', 0, 0, '', '', true, 0, false, true, 0);
			$this->pdf->MultiCell(18, $heigh,number_format($row->price,2),  1, 'L', 0, 0, '', '', true, 0, false, true, 0);
			$this->pdf->MultiCell(17, $heigh,number_format($row->discount,2), 1, 'L', 0, 0, '', '', true, 0, false, true, 0);
			$this->pdf->MultiCell(20, $heigh,number_format($row->amount,2),  1, 'L', 0, 0, '', '', true, 0, false, true, 0);
			$this->pdf->MultiCell(20, $heigh,$row->serials,  1, 'L', 0, 1, '', '', true, 0, false, true, 0);
		}
		$ss="";
		foreach($serial as $rows){
			if($row->code==$rows->item){
				$ss=$rows->serial_no;
			}
		}

		if($ss!=""){



			$all_serial="";

			foreach ($serial as $rows) {
				if($row->code==$rows->item)
				{					
					$all_serial=$all_serial.$rows->serial_no."   ";
				}
			}


			$this->pdf->GetY();
			$this->pdf->setX(10);

			$this->pdf->SetFont('helvetica','',9);
			$aa = $this->pdf->getNumLines($all_serial, 55);
			$heigh=5*$aa;
			$this->pdf->MultiCell(10, $heigh, "", 1, 'L', 0, 0, '', '', true, 0, false, true, 0);
			$this->pdf->MultiCell(35, $heigh, "", 1, 'L', 0, 0, '', '', true, 0, false, true, 0);
			$this->pdf->MultiCell(55, $heigh, $all_serial, 1, 'L', 0, 0, '', '', true, 0, false, true, 0);
			$this->pdf->MultiCell(25, $heigh, "", 1, 'L', 0, 0, '', '', true, 0, false, true, 0);
			$this->pdf->MultiCell(10, $heigh, "", 1, 'L', 0, 0, '', '', true, 0, false, true, 0);
			$this->pdf->MultiCell(18, $heigh, "", 1, 'L', 0, 0, '', '', true, 0, false, true, 0);
			$this->pdf->MultiCell(17, $heigh, "", 1, 'L', 0, 0, '', '', true, 0, false, true, 0);
			$this->pdf->MultiCell(20, $heigh, "",  1, 'R', 0, 1, '', '', true, 0, false, true, 0);
	       // $this->pdf->Ln();




			if($row->sub_item!="")
			{
				$this->pdf->setX(10);
				$this->pdf->SetFont('helvetica','',9);
				$aa = $this->pdf->getNumLines($row->des, 55);
				$heigh=5*$aa;

				$this->pdf->MultiCell(10, $heigh,"", 1, 'R', 0, 0, '', '', true, 0, false, true, 0);
				$this->pdf->MultiCell(35, $heigh,$row->sub_item, 1, 'L', 0, 0, '', '', true, 0, false, true, 0);
				$this->pdf->MultiCell(55, $heigh,$row->des, 1, 'L', 0, 0, '', '', true, 0, false, true, 0);
				$this->pdf->MultiCell(25, $heigh,"", 1, 'L', 0, 0, '', '', true, 0, false, true, 0);
				$this->pdf->MultiCell(10, $heigh,$row->sub_qty, 1, 'R', 0, 0, '', '', true, 0, false, true, 0);
				$this->pdf->MultiCell(18, $heigh,"", 1, 'L', 0, 0, '', '', true, 0, false, true, 0);
				$this->pdf->MultiCell(17, $heigh,"",1, 'L', 0, 0, '', '', true, 0, false, true, 0);
				$this->pdf->MultiCell(20, $heigh,"",  1, 'R', 0, 1, '', '', true, 0, false, true, 0);
		        //$this->pdf->Ln();
			}
		}else{




			if($row->sub_item!="")
			{
				$this->pdf->setX(10);
				$this->pdf->SetFont('helvetica','',9);
				$aa = $this->pdf->getNumLines($row->des, 55);
				$heigh=5*$aa;

				$this->pdf->MultiCell(10, $heigh,"",1, 'R', 0, 0, '', '', true, 0, false, true, 0);
				$this->pdf->MultiCell(35, $heigh,$row->sub_item, 1, 'L', 0, 0, '', '', true, 0, false, true, 0);
				$this->pdf->MultiCell(55, $heigh,$row->des,1, 'L', 0, 0, '', '', true, 0, false, true, 0);
				$this->pdf->MultiCell(25, $heigh,"", 1, 'L', 0, 0, '', '', true, 0, false, true, 0);
				$this->pdf->MultiCell(10, $heigh,$row->sub_qty,1, 'R', 0, 0, '', '', true, 0, false, true, 0);
				$this->pdf->MultiCell(18, $heigh,"",1, 'L', 0, 0, '', '', true, 0, false, true, 0);
				$this->pdf->MultiCell(17, $heigh,"",1, 'L', 0, 0, '', '', true, 0, false, true, 0);
				$this->pdf->MultiCell(20, $heigh,"", 1, 'R', 0, 1, '', '', true, 0, false, true, 0);
		        //$this->pdf->Ln();
			}


		}
	//}

	$code=$row->code;
	$x++;

}

$this->pdf->Ln(2);




//------------------ GRID END -------------------



$this->pdf->SetLineStyle(array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0.1, 'color' => array(0, 0, 0)));

foreach($amount as $row){
	$netamt=$row->net_amount;
	$interest=$row->interest_amount;
	$no_ins=$row->no_of_installments;
	$dwn_paymnt=$row->down_payment;
	$charge=$row->document_charges;
	$insAmt=$row->installment_amount;
	$balance=$row->balance;
	$emp_name=$row->name;
}
$this->pdf->GetY();
$this->pdf->SetFont('helvetica','B',9);
$this->pdf->Cell(15, 6,"Net Value", '0', 0, 'L', 0);
$this->pdf->Cell(15, 6,"", '0', 0, 'L', 0);
$this->pdf->SetFont('helvetica','',9);
$this->pdf->Cell(30, 6,number_format($netamt,2), '0', 0, 'L', 0);

$this->pdf->SetFont('helvetica','B',9);
$this->pdf->Cell(15, 6,"Interest", '0', 0, 'L', 0);
$this->pdf->Cell(15, 6,"", '0', 0, 'L', 0);
$this->pdf->SetFont('helvetica','',9);
$this->pdf->Cell(30, 6,number_format($interest,2), '0', 0, 'L', 0);

$this->pdf->SetFont('helvetica','B',9);
$this->pdf->Cell(15, 6,"No. of Installment", '0', 0, 'L', 0);
$this->pdf->Cell(15, 6,"", '0', 0, 'L', 0);
$this->pdf->SetFont('helvetica','',9);
$this->pdf->Cell(30, 6,$no_ins, '0', 0, 'L', 0);

$this->pdf->Ln();

$this->pdf->SetFont('helvetica','B',9);
$this->pdf->Cell(15, 6,"Down Payment", '0', 0, 'L', 0);
$this->pdf->Cell(15, 6,"", '0', 0, 'L', 0);
$this->pdf->SetFont('helvetica','',9);
$this->pdf->Cell(30, 6,number_format($dwn_paymnt,2), '0', 0, 'L', 0);

$this->pdf->SetFont('helvetica','B',9);
$this->pdf->Cell(15, 6,"Document Charge", '0', 0, 'L', 0);
$this->pdf->Cell(15, 6,"", '0', 0, 'L', 0);
$this->pdf->SetFont('helvetica','',9);
$this->pdf->Cell(30, 6,number_format($charge,2), '0', 0, 'L', 0);

$this->pdf->SetFont('helvetica','B',12);
$this->pdf->Cell(15, 6,"Installment", 'T L B', 0, 'L', 0);
$this->pdf->Cell(15, 6,"", 'T B', 0, '0', 0);
$this->pdf->Cell(30, 6,number_format($insAmt,2), 'T B R', 0, '0', 0);

$this->pdf->Ln();

$this->pdf->SetFont('helvetica','B',9);
$this->pdf->Cell(15, 6,"Balance Amount", '0', 0, 'L', 0);
$this->pdf->Cell(15, 6,"", '0', 0, 'L', 0);
$this->pdf->SetFont('helvetica','',9);
$this->pdf->Cell(30, 6,number_format($balance,2), '0', 0, 'L', 0);


$this->pdf->Ln();
$this->pdf->SetFont('helvetica','B',9);
$this->pdf->Cell(15, 6,"Salesman", '0', 0, 'L', 0);
$this->pdf->Cell(15, 6,"", '0', 0, 'L', 0);
$this->pdf->SetFont('helvetica','',9);
$this->pdf->Cell(30, 6,$emp_name, '0', 0, 'L', 0);

$this->pdf->Ln();
$this->pdf->Ln();
$this->pdf->SetX(20);
$this->pdf->SetFont('helvetica','',9);
$this->pdf->Cell(25, 6,"---------------------------------", '0', 0, 'C', 0);
$this->pdf->Cell(20, 6,"", '0', 0, 'L', 0);
$this->pdf->Cell(25, 6,"---------------------------------", '0', 0, 'C', 0);
$this->pdf->Cell(20, 6,"", '0', 0, 'L', 0);
$this->pdf->Cell(25, 6,"---------------------------------", '0', 0, 'C', 0);
$this->pdf->Cell(20, 6,"", '0', 0, 'L', 0);
$this->pdf->Cell(35, 6,"----------------------------------", '0', 0, 'C', 0);
$this->pdf->Ln();


$this->pdf->Cell(25, 6,"Salesman", '0', 0, 'C', 0);
$this->pdf->Cell(20, 6,"", '0', 0, 'C', 0);
$this->pdf->Cell(25, 6,"Credit Officer", '0', 0, 'C', 0);
$this->pdf->Cell(20, 6,"", '0', 0, 'C', 0);
$this->pdf->Cell(30, 6,"Manager", '0', 0, 'C', 0);
$this->pdf->Cell(20, 6,"", '0', 0, 'C', 0);
$this->pdf->Cell(35, 6,"Customer Singature", '0', 0, 'C', 0);
$this->pdf->Cell(20, 6,"", '0', 0, 'C', 0);

$this->pdf->Ln();
foreach($user as $row){
	$this->pdf->SetFont('helvetica','B',9);
	$this->pdf->Cell(15, 6,"O\C :", '0', 0, 'L', 0);
	$this->pdf->SetFont('helvetica','',9);
	$this->pdf->Cell(30, 6,$row->loginName, '0', 0, 'L', 0);
}	
$this->pdf->Output("hire_purchase_".date('Y-m-d').".pdf", 'I');

?>