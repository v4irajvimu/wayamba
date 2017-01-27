<?php
error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
$this->pdf->setPrintHeader($header,$type,$duration);
$this->pdf->setPrintFooter(true,'0',$is_cur_time);
        //print_r($det);
$this->pdf->SetFont('helvetica', 'B', 16);
		$this->pdf->AddPage("L","A5");   // L or P amd page type A4 or A3

		foreach($branch as $ress)
		{
			$this->pdf->headerSet4($ress->name,$ress->address,$ress->tp,$ress->fax,$ress->email);
		}

		$cus_name=$cus_address="";

		foreach($det as $row){
			$description=$row->memo;
			$date=$row->ddate;
			$ref_no=$row->ref_no;
			$amount=$row->amount;
			$cus=$row->name;
		}
		
		foreach($session as $ses){
			$invoice_no=$session[0].$session[1]."AR".$session[2];
		}

		foreach($customer as $cus){
			$cus_name=$cus->name;
			$cus_id=$cus->code;
			$tp=$cus->tp;
		}
		foreach($items as $itm){
			$des=$itm->description;
			//$itm_amount=$itm->code;
		}
		foreach($user as $row){
			$operator=$row->loginName;
		}

		$align_h=$this->utility->heading_align();
		$this->pdf->setY(15);
		$this->pdf->SetFont('helvetica', 'BU', 10);
		$this->pdf->Ln();
		$orgin_print=$_POST['org_print'];
		if($orgin_print=="1"){
			$this->pdf->Cell(0, 5,'ADVANCE RECEIPT',0,false, $align_h, 0, '', 0, false, 'M', 'M');
		}else{
			$this->pdf->Cell(0, 5,'ADVANCE RECEIPT(DUPLICATE) ',0,false, $align_h, 0, '', 0, false, 'M', 'M');
		}


		$this->pdf->SetFont('helvetica', 'B', 10);
		$this->pdf->setY(30);

		$this->pdf->Cell(20, 1, "Receipt No - ", '0', 0, 'L', 0);
		$this->pdf->Cell(1, 1," ".$invoice_no, '0', 0, 'L', 0);
		$this->pdf->Cell(1, 1,'', '0', 0, 'L', 0);
		$this->pdf->Cell(1, 1, "", '0', 0, 'L', 0);
		$this->pdf->Ln();
		$this->pdf->Ln();

		$this->pdf->SetFont('helvetica', '', 10);
		$this->pdf->Cell(20, 1, "Date - ", '0', 0, 'L', 0);
		$this->pdf->Cell(1, 1, $dt.$save_time, '0', 0, 'L', 0);
		$this->pdf->Cell(1, 1, '', '0', 0, 'L', 0);
		$this->pdf->Cell(1, 1, '', '0', 0, 'L', 0);

		$this->pdf->Ln();
		$this->pdf->Ln();
		
		$this->pdf->Cell(50, 1, 'Received With Thanks a Sum of  ' , '0', 0, 'L', 0);
		$this->pdf->Cell(1, 1, $rec, '0', 0, 'L', 0);
		$this->pdf->Cell(1, 1, "", '0', 0, 'L', 0);
		$this->pdf->Cell(1, 1, '', '0', 0, 'L', 0);
		$this->pdf->Ln();
		$this->pdf->Ln();

		 	$this->pdf->Cell(20, 1, 'From   - ' , '0', 0, 'L', 0);
		 	$this->pdf->Cell(1, 1, $cus_name." - ". $tp, '0', 0, 'L', 0);
		 	$this->pdf->Ln();
		 	$this->pdf->Ln();
		 	$this->pdf->Cell(20, 1, "ID No -", '0', 0, 'L', 0);
		 	$this->pdf->Cell(1, 1, $cus_id, '0', 0, 'L', 0);
		 	$this->pdf->Ln();
		 	$this->pdf->Ln();

		$this->pdf->Cell(20, 1, "Description - ", '0', 0, 'L', 0);
		$this->pdf->Cell(1, 1, $description, '0', 0, 'L', 0);
		$this->pdf->Ln();
		$this->pdf->Ln();

		$this->pdf->Cell(14, 1, "Towards  ", '0', 0, 'L', 0);
		$this->pdf->Cell(1, 1, $des, '0', 0, 'L', 0);

		$this->pdf->SetFont('helvetica', 'B', 10);
		$this->pdf->Cell(30, 1, '', '0', 0, 'L', 0);
		$this->pdf->Cell(30, 1, "", '0', 0, 'L', 0);
		$this->pdf->Cell(30, 1, "", '0', 0, 'L', 0);
		$this->pdf->Cell(30, 1, "", '0', 0, 'L', 0);
		$this->pdf->Cell(30, 1, "Amount Received ", '0', 0, 'L', 0);
		$this->pdf->Cell(30, 1," Rs ". number_format($num,2), '0', 0, 'L', 0);

		if($credit_card!=null){
			$this->pdf->GetY();
			$this->pdf->SetFont('helvetica','B',10);
			$this->pdf->Cell(0, 10, 'Credit Card Details','0', 0, 'L', 0);
			$this->pdf->SetFont('helvetica','',10);
			$this->pdf->Ln();
			$this->pdf->Cell(30, 1, "Credit Card No", '1', 0, 'L', 0);
			$this->pdf->Cell(30, 1, "Date", '1', 0, 'L', 0);
			$this->pdf->Cell(30, 1, "Amount", '1', 0, 'R', 0);
			$this->pdf->Ln();
			foreach ($credit_card as $rowss) {
				$this->pdf->Cell(30, 1, $rowss->card_no, '1', 0, 'L', 0);
				$this->pdf->Cell(30, 1, $rowss->ddate, '1', 0, 'L', 0);
				$this->pdf->Cell(30, 1, number_format($rowss->amount,2), '1', 0, 'R', 0);
				$this->pdf->Ln();
			}
			
		}

		if($cheque!=null){
			$this->pdf->GetY();
			$this->pdf->SetFont('helvetica','B',10);
			$this->pdf->Cell(0, 10, 'Cheque Details','0', 0, 'L', 0);
			$this->pdf->SetFont('helvetica','',10);
			$this->pdf->Ln();
			$this->pdf->Cell(20, 1, "Date", '1', 0, 'L', 0);
			$this->pdf->Cell(25, 1, "Bank", '1', 0, 'L', 0);
			$this->pdf->Cell(40, 1, "Branch", '1', 0, 'L', 0);
			$this->pdf->Cell(20, 1, "Account No", '1', 0, 'L', 0);
			$this->pdf->Cell(20, 1, "Cheque No", '1', 0, 'L', 0);
			$this->pdf->Cell(20, 1, "Amount", '1', 0, 'R', 0);
			$this->pdf->Ln();
			foreach ($cheque as $rowss) {
				$this->pdf->Cell(20, 1, $rowss->cheque_date, '1', 0, 'L', 0);
				$this->pdf->Cell(25, 1, $rowss->bank, '1', 0, 'L', 0);
				$this->pdf->Cell(40, 1, $rowss->branch, '1', 0, 'L', 0);
				$this->pdf->Cell(20, 1, $rowss->account_no, '1', 0, 'L', 0);
				$this->pdf->Cell(20, 1, $rowss->cheque_no, '1', 0, 'L', 0);
				$this->pdf->Cell(20, 1, number_format($rowss->amount,2), '1', 0, 'R', 0);
				$this->pdf->Ln();
			}
		}	

		$this->pdf->SetFont('helvetica', '', 9);


		$this->pdf->footerSetAdvance($employee,$additional,$user,$credit_tot,$cash_tot,$cheque_tot);	

		$this->pdf->Output("Advance Payment".date('Y-m-d').".pdf", 'I');

		?>