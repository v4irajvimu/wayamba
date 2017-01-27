<?php
error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
$this->pdf->setPrintHeader($header,$type,$duration);
$this->pdf->setPrintFooter(true,'0',$is_cur_time);
        //print_r($det);
$this->pdf->SetFont('helvetica', 'B', 16);
		$this->pdf->AddPage($orientation,$page);   // L or P amd page type A4 or A3

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

		foreach($supplier as $sup){
			$sup_name=$sup->name;
			$sup_id=$sup->code;
		}
		foreach($items as $itm){
			$itm_bal=$itm->bal;
			$dueAmount=$itm->balance;
			$memo=$itm->memo;

		}
		foreach($user as $row){
			$operator=$row->loginName;
		}

		foreach($session as $ses){
			$invoice_no=$session[0].$session[1].$session[2];
		}

		
		$align_h=$this->utility->heading_align();

		$this->pdf->setY(15);
		$this->pdf->SetFont('helvetica', 'BU', 10);
		$this->pdf->Ln();
		$orgin_print=$_POST['org_print'];
		if($orgin_print=="1"){
			$this->pdf->Cell(0, 5,'VOUCHER ',0,false, $align_h, 0, '', 0, false, 'M', 'M');
		}else{
			$this->pdf->Cell(0, 5,'VOUCHER (DUPLICATE) ',0,false, $align_h, 0, '', 0, false, 'M', 'M');			
		}
		$this->pdf->SetFont('helvetica', '', 8);
		$this->pdf->setY(20);
		$this->pdf->Ln();
		$this->pdf->Cell(20, 1, "Voucher No -", '0', 0, 'L', 0);
		$this->pdf->Cell(1, 1, $invoice_no, '0', 0, 'L', 0);
		$this->pdf->Cell(1, 1,'', '0', 0, 'L', 0);
		$this->pdf->Cell(1, 1, "", '0', 0, 'L', 0);

		$this->pdf->Ln();


		$this->pdf->Cell(20, 1, "Date - ", '0', 0, 'L', 0);
		$this->pdf->Cell(1, 1, $dt.$save_time, '0', 0, 'L', 0);
		$this->pdf->Cell(1, 1, '', '0', 0, 'L', 0);
		$this->pdf->Cell(1, 1, '', '0', 0, 'L', 0);

		$this->pdf->Ln();

		$this->pdf->Cell(30, 1, "_________________________________________________________________________________________________________________", '0', 0, 'L', 0);
		$this->pdf->Ln();


		$this->pdf->Cell(43, 1, 'Received With Thanks a Sum of  ' , '0', 0, 'L', 0);
		$this->pdf->Cell(1, 1, $rec, '0', 0, 'L', 0);
		$this->pdf->Cell(1, 1, "", '0', 0, 'L', 0);
		$this->pdf->Cell(1, 1, '', '0', 0, 'L', 0);
		$this->pdf->Ln();

		$this->pdf->Cell(20, 1, 'To   ' , '0', 0, 'L', 0);
		$this->pdf->Cell(1, 1, $sup_name, '0', 0, 'L', 0);
		$this->pdf->Ln();
		$this->pdf->Cell(20, 1, "ID No ", '0', 0, 'L', 0);
		$this->pdf->Cell(1, 1, $sup_id, '0', 0, 'L', 0);
		$this->pdf->Ln();

		$this->pdf->setX(15);
		$this->pdf->SetFont('helvetica','B',9);		 
		$this->pdf->MultiCell(50, 5,"Branch",  1, 'C', 0, 0, '', '', true, 0, false, true, 0);
		$this->pdf->MultiCell(20, 5,"Trans Type",  1, 'C', 0, 0, '', '', true, 0, false, true, 0);
		$this->pdf->MultiCell(10, 5,"No",  1, 'C', 0, 0, '', '', true, 0, false, true, 0);
		$this->pdf->MultiCell(20, 5,"Sup.Inv No",  1, 'C', 0, 0, '', '', true, 0, false, true, 0);
		$this->pdf->MultiCell(20, 5,"Date",  1, 'C', 0, 0, '', '', true, 0, false, true, 0);
		$this->pdf->MultiCell(20, 5,"Amount",  1, 'C', 0, 0, '', '', true, 0, false, true, 0);
		$this->pdf->MultiCell(20, 5,"Payment", 1, 'C', 0, 1, '', '', true, 0, false, true, 0);

		foreach($grid as $row){
			$this->pdf->setX(15);
			$this->pdf->SetLineStyle(array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0.1, 'color' => array(0, 0, 0)));
			$this->pdf->SetFont('helvetica','',9);
			$aa = $this->pdf->getNumLines($row->t_name, 20);
			$heigh=5*$aa;
			$this->pdf->MultiCell(50, $heigh,ucfirst(strtolower($row->mb_name))." - ".$row->sub_bc,  1, 'L', 0, 0, '', '', true, 0, false, true, 0);
			$this->pdf->MultiCell(20, $heigh,ucfirst(strtolower($row->t_name)),  1, 'L', 0, 0, '', '', true, 0, false, true, 0);
			$this->pdf->MultiCell(10, $heigh,$row->trans_no,  1, 'R', 0, 0, '', '', true, 0, false, true, 0);
			$this->pdf->MultiCell(20, $heigh,$row->inv_no,  1, 'R', 0, 0, '', '', true, 0, false, true, 0);
			$this->pdf->MultiCell(20, $heigh,$row->date,  1, 'L', 0, 0, '', '', true, 0, false, true, 0);
			$this->pdf->MultiCell(20, $heigh,$row->amount,  1, 'R', 0, 0, '', '', true, 0, false, true, 0);
			$this->pdf->MultiCell(20, $heigh,$row->payment, 1, 'R', 0, 1, '', '', true, 0, false, true, 0);

		}
		$this->pdf->Ln();
		$this->pdf->setX(15);
		$this->pdf->Cell(50, 1, "Towards Full Payment for In No :- ", '0', 0, 'L', 0);
		$this->pdf->Cell(1, 1, $memo, '0', 0, 'L', 0);
		$this->pdf->Ln();

		$this->pdf->setX(15);
		$this->pdf->SetFont('helvetica','B',9);
		$this->pdf->Cell(10, 1,"Rs.", '0', 0, 'R', 0);
		$this->pdf->Cell(30, 1,number_format($num,2), '1', 0, 'R', 0);
		$this->pdf->Ln();
		$this->pdf->Ln();

		if($credit_card!=2){
			$this->pdf->setX(15);
			$this->pdf->SetFont('helvetica','',9);
			$this->pdf->Cell(50, 2,"Credit Card Details", '0', 0, 'L', 0);
			$this->pdf->Ln();
			$this->pdf->Ln();
			$this->pdf->setX(15);
			$this->pdf->SetFont('helvetica','B',9);
			$this->pdf->Cell(25, 2,"Card Type", '1', 0, 'R', 0);
			$this->pdf->Cell(30, 2,"Card No", '1', 0, 'R', 0);
			$this->pdf->Cell(20, 2,"Amount", '1', 0, 'R', 0);
			$this->pdf->Ln();
			foreach ($credit_card as $cc) {
				$this->pdf->setX(15);
				$this->pdf->SetFont('helvetica','',9);
				$this->pdf->SetLineStyle(array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0.1, 'color' => array(0, 0, 0)));
				$this->pdf->Cell(25, 2,$cc->card_type, '1', 0, 'R', 0);
				$this->pdf->Cell(30, 2,$cc->card_no, '1', 0, 'R', 0);
				$this->pdf->Cell(20, 2,$cc->amount, '1', 0, 'R', 0);
				$this->pdf->Ln();
			}
		}

		
		if($issue_chq!=2){
			$this->pdf->setX(15);
			$this->pdf->SetFont('helvetica','',9);
			$this->pdf->Cell(50, 2,"Cheques Details", '0', 0, 'L', 0);
			$this->pdf->Ln();
			$this->pdf->setX(15);
			$this->pdf->SetFont('helvetica','B',9);
			$this->pdf->Cell(30, 2,"Bank", '1', 0, 'C', 0);
			$this->pdf->Cell(30, 2,"Cheque No", '1', 0, 'C', 0);
			$this->pdf->Cell(25, 2,"Cheque Date", '1', 0, 'C', 0);
			$this->pdf->Cell(20, 2,"Amount", '1', 0, 'C', 0);
			$this->pdf->Ln();
			foreach ($issue_chq as $cc) {
				$this->pdf->setX(15);
				$this->pdf->SetFont('helvetica','',9);
				$this->pdf->SetLineStyle(array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0.1, 'color' => array(0, 0, 0)));

				$this->pdf->Cell(30, 2,$cc->description, '1', 0, 'L', 0);
				$this->pdf->Cell(30, 2,$cc->cheque_no, '1', 0, 'R', 0);
				$this->pdf->Cell(25, 2,$cc->cheque_date, '1', 0, 'R', 0);
				$this->pdf->Cell(20, 2,$cc->amount, '1', 0, 'R', 0);
				$this->pdf->Ln();
			}
		}


		$this->pdf->SetFont('helvetica','',9);
		
		$this->pdf->Ln();
		$this->pdf->setX(15);
		$this->pdf->Cell(55, 1, "Total Amount Due    Rs", '0', 0, 'L', 0);
		$this->pdf->Cell(1, 1,number_format($dueAmount,2), '0', 0, 'R', 0);

		$this->pdf->Ln();
		$this->pdf->setX(15);
		$this->pdf->Cell(55, 1, "Amount Received     Rs", '0', 0, 'L', 0);
		$this->pdf->Cell(1, 1,number_format($num,2), '0', 0, 'R', 0);

		$this->pdf->Ln();
		$this->pdf->setX(15);
		$this->pdf->Cell(55, 1, "Balance Due             Rs", '0', 0, 'L', 0);
		$this->pdf->Cell(1, 1,number_format($itm_bal,2), '0', 0, 'R', 0);
		$this->pdf->Ln(); 
		$this->pdf->Ln(); 
		$this->pdf->HaveMorePages(10);

			//$this->pdf->SetY(45);                          

            //$this->pdf->GetX(); 

		$this->pdf->Cell(50, 1, '...................................', '0', 0, 'L', 0);
		$this->pdf->Cell(50, 1, '...................................', '0', 0, 'L', 0);
		$this->pdf->Cell(50, 1, '...................................', '0', 0, 'L', 0);
		$this->pdf->Cell(50, 1, '...................................', '0', 0, 'L', 0);

		$this->pdf->Ln();
		$this->pdf->Cell(25, 1, '       Prepaired By', '0', 0, 'C', 0);
		$this->pdf->Cell(75, 1, ' Checked By', '0', 0, 'C', 0);
		$this->pdf->Cell(30, 1, 'Authorized Signature', '0', 0, 'C', 0);
		$this->pdf->Cell(70, 1, 'Recipient Signature', '0', 0, 'C', 0);

		$this->pdf->Ln();
		$this->pdf->Ln();

		$this->pdf->Ln();
		//$this->pdf->Cell(20, 1, "Operator ", '0', 0, 'L', 0);
		//$this->pdf->Cell(1, 1, $operator, '0', 0, 'L', 0);
		$this->pdf->Ln();

		$tt = date("H:i");


		//$this->pdf->Cell(20, 1, "Print Time ", '0', 0, 'L', 0);
		//$this->pdf->Cell(1, 1, $tt, '0', 0, 'L', 0);
		$this->pdf->Ln();

		$this->pdf->Output("Voucher".date('Y-m-d').".pdf", 'I');

		?>