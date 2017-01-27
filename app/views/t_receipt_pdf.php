<?php 

error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
$this->pdf->setPrintHeader($header,$type,$duration);
$this->pdf->setPrintFooter(true,'0',$is_cur_time);
$this->pdf->SetFont('helvetica', 'B', 16);
		$this->pdf->AddPage('L','A5');   // L or P amd page type A4 or A3

		foreach($branch as $ress){
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
		foreach($customer as $cus){
			$cus_name=$cus->name;
			$cus_id=$cus->code;
		}
		foreach($items as $itm){
			$itm_bal=$itm->bal;
			$dueAmount=$itm->balance;
		}
		foreach($user as $row){
			$operator=$row->loginName;
		}
		foreach($session as $ses){
			$invoice_no=$session[0].$session[1].$session[2];
		}
		$this->pdf->setY(10	);
		$align_h=$this->utility->heading_align();

		$this->pdf->SetFont('helvetica', 'BU', 10);
		$this->pdf->Ln();
		$orgin_print=$_POST['org_print'];
		if($orgin_print=="1"){
			$this->pdf->Cell(0, 5,'RECEIPT',0,false, $align_h, 0, '', 0, false, 'M', 'M');
		}else{
			$this->pdf->Cell(0, 5,'RECEIPT (DUPLICATE) ',0,false,$align_h, 0, '', 0, false, 'M', 'M');
		}

		

		$this->pdf->Ln();
		$this->pdf->SetFont('helvetica', 'B', 8);
		$this->pdf->Cell(20, 1, "Receipt No -", '0', 0, 'L', 0);
		$this->pdf->SetFont('helvetica', '', 8);
		$this->pdf->Cell(1, 1, $invoice_no, '0', 0, 'L', 0);
		$this->pdf->Cell(1, 1,'', '0', 0, 'L', 0);
		$this->pdf->Cell(1, 1, "", '0', 0, 'L', 0);

		$this->pdf->Ln();

		$this->pdf->SetFont('helvetica', 'B', 8);
		$this->pdf->Cell(20, 1, "Date - ", '0', 0, 'L', 0);
		$this->pdf->SetFont('helvetica', '', 8);
		$this->pdf->Cell(1, 1, $dt.$save_time, '0', 0, 'L', 0);
		$this->pdf->Cell(1, 1, '', '0', 0, 'L', 0);
		$this->pdf->Cell(1, 1, '', '0', 0, 'L', 0);

		$this->pdf->Ln();
		$this->pdf->Ln();
		
		$this->pdf->SetFont('helvetica', 'B', 8);
		$this->pdf->Cell(43, 1, 'Received With Thanks a Sum of  ' , '0', 0, 'L', 0);
		$this->pdf->SetFont('helvetica', '', 8);
		$this->pdf->Cell(1, 1, $rec, '0', 0, 'L', 0);
		$this->pdf->Cell(1, 1, "", '0', 0, 'L', 0);
		$this->pdf->Cell(1, 1, '', '0', 0, 'L', 0);
		$this->pdf->Ln();

		$this->pdf->SetFont('helvetica', 'B', 8);
		$this->pdf->Cell(8, 1, 'From   ' , '0', 0, 'L', 0);
		$this->pdf->SetFont('helvetica', '', 8);
		$this->pdf->Cell(1, 1, $cus_name, '0', 0, 'L', 0);
		$this->pdf->Ln();
		$this->pdf->SetFont('helvetica', 'B', 8);
		$this->pdf->Cell(8, 1, "ID No ", '0', 0, 'L', 0);
		$this->pdf->SetFont('helvetica', '', 8);
		$this->pdf->Cell(1, 1, $cus_id, '0', 0, 'L', 0);
		$this->pdf->Ln();
		$this->pdf->SetFont('helvetica', 'B', 8);
		$this->pdf->Ln();
		$this->pdf->Cell(1, 1, "Towards Full Payment for In No ", '0', 0, 'L', 0);
		$this->pdf->SetFont('helvetica', '', 8);
		$this->pdf->Cell(1, 1, $payNo, '0', 0, 'L', 0);
		$this->pdf->Ln();

		$this->pdf->Cell(30, 1, "_________________________________________________________________________________________________________________", '0', 0, 'L', 0);
		$this->pdf->Ln();

		$this->pdf->Ln();
		$this->pdf->SetX(140); 
		$this->pdf->SetFont('helvetica', 'B', 8);
		$this->pdf->Cell(50, 1, "Total Amount Due    Rs", '0', 0, 'L', 0);
		$this->pdf->SetFont('helvetica', '', 8);
		$this->pdf->Cell(1, 1,number_format($dueAmount,2), '0', 0, 'R', 0);

		$this->pdf->Ln();
		$this->pdf->SetX(140); 
		$this->pdf->SetFont('helvetica', 'B', 8);
		$this->pdf->Cell(50, 1, "Amount Received     Rs", '0', 0, 'L', 0);
		$this->pdf->SetFont('helvetica', '', 8);
		$this->pdf->Cell(1, 1,number_format($num,2), '0', 0, 'R', 0);

		$this->pdf->Ln();
		$this->pdf->SetX(140); 
		$this->pdf->SetFont('helvetica', 'B', 8);
		$this->pdf->Cell(50, 1, "Balance Due             Rs", '0', 0, 'L', 0);
		$this->pdf->SetFont('helvetica', '', 8);
		$this->pdf->Cell(1, 1,number_format($itm_bal,2), '0', 0, 'R', 0);
		$this->pdf->Ln();

		//$this->pdf->Ln();

		if($credit_card!=null){
			$this->pdf->GetY();
			$this->pdf->SetFont('helvetica','B',8);
			$this->pdf->Cell(0, 10, 'Credit Card Details','0', 0, 'L', 0);
			$this->pdf->SetFont('helvetica','',8);
			$this->pdf->Ln();
			$this->pdf->Cell(30,5, "Credit Card No", '1', 0, 'L', 0);
			$this->pdf->Cell(30,5, "Date", '1', 0, 'L', 0);
			$this->pdf->Cell(30,5, "Amount", '1', 0, 'R', 0);
			$this->pdf->Ln();
			$this->pdf->SetFont('helvetica', '', 8);
			foreach ($credit_card as $rowss) {
				$heigh=5*(max(1,$this->pdf->getNumLines($rowss->card_no,30)));
				$this->pdf->HaveMorePages($heigh);
				$this->pdf->MultiCell(30, $heigh,$rowss->card_no,1, 'R',false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
				$this->pdf->MultiCell(30, $heigh,$rowss->ddate,1, 'L',false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
				$this->pdf->MultiCell(30, $heigh,number_format($rowss->amount,2),1, 'R',false, 1, '', '', true, 0, false, true, $heigh,'M' ,false);
			}
			
		}	

		if($cheque!=null){
			$this->pdf->GetY();
			$this->pdf->SetFont('helvetica','B',8);
			$this->pdf->Cell(0, 10, 'Cheque Details','0', 0, 'L', 0);
			$this->pdf->SetFont('helvetica','B',8);
			$this->pdf->Ln();
			$this->pdf->Cell(20, 6, "Date", '1', 0, 'C', 0);
			$this->pdf->Cell(25, 6, "Bank", '1', 0, 'C', 0);
			$this->pdf->Cell(60, 6, "Branch", '1', 0, 'C', 0);
			$this->pdf->Cell(30, 6, "Account No", '1', 0, 'C', 0);
			$this->pdf->Cell(20, 6, "Cheque No", '1', 0, 'C', 0);
			$this->pdf->Cell(20, 6, "Amount", '1', 0, 'C', 0);
			$this->pdf->Ln();
			$this->pdf->SetFont('helvetica','',8);
			foreach ($cheque as $rows) {
				$heigh=6*(max(1,$this->pdf->getNumLines($rows->branch,60)));
				$this->pdf->HaveMorePages($heigh);
				$this->pdf->SetLineStyle(array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0.1, 'color' => array(0, 0, 0)));
				$this->pdf->MultiCell(20, $heigh,$rows->cheque_date,1, 'L',false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
				$this->pdf->MultiCell(25, $heigh,$rows->bank,1, 'L',false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
				$this->pdf->MultiCell(60, $heigh,$rows->branch,1, 'L',false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
				$this->pdf->MultiCell(30, $heigh,$rows->account_no,1, 'R',false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
				$this->pdf->MultiCell(20, $heigh,$rows->cheque_no,1, 'R',false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
				$this->pdf->MultiCell(20, $heigh,number_format($rows->amount,2),1, 'R',false,1, '', '', true, 0, false, true, $heigh,'M' ,false);
			}
		}

		$this->pdf->Ln();
		
		$this->pdf->SetFont('helvetica', 'B', 8);
		$this->pdf->Cell(70, 1, '...................................', '0', 0, 'L', 0);
		$this->pdf->Cell(80, 1, '...................................', '0', 0, 'L', 0);
		$this->pdf->Cell(10, 1, '...................................', '0', 0, 'L', 0);
		$this->pdf->Ln();
		$this->pdf->Cell(70, 1, '       Prepaired By', '0', 0, 'L', 0);
		$this->pdf->Cell(80, 1, ' Cashier Signature', '0', 0, 'L', 0);
		$this->pdf->Cell(10, 1, 'Customer Signature', '0', 0, 'L', 0);
		

		$this->pdf->Ln();
		$this->pdf->Ln();

		$this->pdf->Ln();
		
		$this->pdf->Cell(20, 1, "Operator ", '0', 0, 'L', 0);
		$this->pdf->SetFont('helvetica', '', 8);
		$this->pdf->Cell(1, 1, $operator, '0', 0, 'L', 0);
		$this->pdf->Ln();

		$tt = date("H:i");
		$this->pdf->SetFont('helvetica', 'B', 8);
		$this->pdf->Cell(20, 1, "Print Time ", '0', 0, 'L', 0);
		$this->pdf->SetFont('helvetica', '', 8);
		$this->pdf->Cell(1, 1, $tt, '0', 0, 'L', 0);
		$this->pdf->Ln();
		$this->pdf->Output("Receipt".date('Y-m-d').".pdf", 'I');
		?>