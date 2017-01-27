<?php

		error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
		$this->pdf->setPrintHeader($header,$type,$duration);
        $this->pdf->setPrintFooter(true);
        //print_r($det);
        $this->pdf->SetFont('helvetica', 'B', 16);
		$this->pdf->AddPage($orientation,$page);   // L or P amd page type A4 or A3

 		foreach($branch as $ress){
 		 			$this->pdf->headerSet3($ress->name,$ress->address,$ress->tp,$ress->fax,$ress->email);
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
		}
			foreach($user as $row){
		 		$operator=$row->loginName;
		}

		foreach($session as $ses){
			$invoice_no=$session[0].$session[1].$session[2];
		}

			$this->pdf->setY(20);
        	$this->pdf->SetFont('helvetica', 'BU', 10);
			$this->pdf->Ln();
		 	$this->pdf->Cell(0, 5,'VOUCHER',0,false, 'C', 0, '', 0, false, 'M', 'M');

		 	$this->pdf->SetFont('helvetica', '', 8);
		 	$this->pdf->setY(25);

		 	// $this->pdf->Cell(20, 1, "Voucher Type -", '0', 0, 'L', 0);
		 	// $this->pdf->Cell(1, 1, $voucher_type, '0', 0, 'L', 0);
		 	// $this->pdf->Cell(1, 1,'', '0', 0, 'L', 0);
		 	// $this->pdf->Cell(1, 1, "", '0', 0, 'L', 0);

		 	$this->pdf->Cell(20, 1, "Date - ", '0', 0, 'L', 0);
		 	$this->pdf->Cell(1, 1, $ddate, '0', 0, 'L', 0);
		 	$this->pdf->Cell(1, 1, '', '0', 0, 'L', 0);
		 	$this->pdf->Cell(1, 1, '', '0', 0, 'L', 0);
		 

		 	$this->pdf->Ln();
		 	$this->pdf->Cell(20, 1, "Voucher No -", '0', 0, 'L', 0);
		 	$this->pdf->Cell(1, 1, $voucher_no, '0', 0, 'L', 0);
		 	$this->pdf->Cell(1, 1,'', '0', 0, 'L', 0);
		 	$this->pdf->Cell(1, 1, "", '0', 0, 'L', 0);

		 	$this->pdf->Ln();

		 	// $this->pdf->Cell(20, 1, "Category -", '0', 0, 'L', 0);
		 	// $this->pdf->Cell(1, 1, $category_id . "|" . $cat_des, '0', 0, 'L', 0);
		 	// $this->pdf->Cell(1, 1,'', '0', 0, 'L', 0);
		 	// $this->pdf->Cell(1, 1, "", '0', 0, 'L', 0);

		 	// $this->pdf->Ln();


		 	// $this->pdf->Cell(20, 1, "Group -", '0', 0, 'L', 0);
		 	// $this->pdf->Cell(1, 1, $group_id . "|" . $group_des, '0', 0, 'L', 0);
		 	// $this->pdf->Cell(1, 1,'', '0', 0, 'L', 0);
		 	// $this->pdf->Cell(1, 1, "", '0', 0, 'L', 0);
		 	// $this->pdf->Ln();


		 	
		 
		 	$this->pdf->Ln();
		 	
		 	$this->pdf->Cell(43, 1, 'Received With Thanks a Sum of  ' , '0', 0, 'L', 0);
		 	$this->pdf->Cell(1, 1, $rec, '0', 0, 'L', 0);
		 	$this->pdf->Cell(1, 1, "", '0', 0, 'L', 0);
		 	$this->pdf->Cell(1, 1, '', '0', 0, 'L', 0);
		 	$this->pdf->Ln();


		 	$this->pdf->Cell(30, 1, "_________________________________________________________________________________________________________________", '0', 0, 'L', 0);
		 	$this->pdf->Ln();
		 	$this->pdf->Ln();


		 	$this->pdf->Ln();

		 	$this->pdf->Cell(10, 1, 'To   ' , '0', 0, 'L', 0);
		 	$this->pdf->Cell(1, 1, $acc_code." | ".$acc_des, '0', 0, 'L', 0);

		 	$this->pdf->Ln();

		 	$this->pdf->Ln();

		 

		 	$this->pdf->Cell(20, 1,"Cheque No", '0', 0, 'L', 0);
		 	$this->pdf->Cell(20, 1,"Bank", '0', 0, 'L', 0);
		 	$this->pdf->Cell(20, 1,"Cheque Date", '0', 0, 'L', 0);
		 	$this->pdf->Cell(20, 1,"Amount", '0', 0, 'L', 0)
		 	$this->pdf->Ln();

		 	foreach ($det as $value) {
			   
			    $this->pdf->SetX(15);
			    $this->pdf->SetFont('helvetica', '', 7);
			    $this->pdf->SetLineStyle(array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0.1, 'color' => array(0, 0, 0)));
			    $this->pdf->Cell(20, 6, "$value->account_code", '1', 0, 'C', 0);
			    $this->pdf->Cell(20, 6, "$value->m_des", '1', 0, 'L', 0);
			    $this->pdf->Cell(20, 6, "$value->description", '1', 0, 'L', 0);
			    $this->pdf->Cell(20, 6, "$value->amount", '1', 0, 'L', 0);
			    $this->pdf->Ln();
			    
			}
		 	$this->pdf->Ln();

		 	$this->pdf->Cell(45, 1, "Towards Full Payment for In No ", '0', 0, 'L', 0);
		 	$this->pdf->Cell(1, 1, $vou_des, '0', 0, 'L', 0);
		 	$this->pdf->Ln();
		 	$this->pdf->Ln();
		 	
		 	
		 	// $this->pdf->Cell(30, 1, "_________________________________________________________________________________________________________________", '0', 0, 'L', 0);
		 	// $this->pdf->Ln();
		 	// $this->pdf->Ln();

		 	// $this->pdf->Ln();        
		 	// $this->pdf->Cell(35, 1, "Cheque Amount", '0', 0, 'L', 0);
		 	// $this->pdf->Cell(15, 1, "Rs", '0', 0, 'L', 0);
		 	// $this->pdf->Cell(10, 1,number_format($cheque_amount,2), '0', 0, 'R', 0);
		 	

		 	// $this->pdf->Ln();        	
		 	// $this->pdf->Cell(35, 1, "Cash Amount", '0', 0, 'L', 0);
		 	// $this->pdf->Cell(15, 1, "Rs", '0', 0, 'L', 0);
		 	// $this->pdf->Cell(10, 1,number_format($cash_amount,2), '0', 0, 'R', 0);
		 	
		 	
		 	$this->pdf->Ln();       
		 	
		 	$this->pdf->SetFont('helvetica', 'B', 20);
		 	$this->pdf->Cell(60, 1, $tot, '1', 0, 'R', 0);
		 	$this->pdf->Ln();

		 	$this->pdf->SetFont('helvetica', '', 8);
			$this->pdf->SetY(45);                        
        	$this->pdf->Ln();            
                        

            $this->pdf->Ln();
            $this->pdf->Ln();
         

		 	// $this->pdf->Cell(30, 1, 'Officer ', '0', 0, 'L', 0);
		 	// $this->pdf->Cell(30, 1, '........................................', '0', 0, 'L', 0);
		 
		 	$this->pdf->Ln();
		 	$this->pdf->Ln();
		 	$this->pdf->Ln();
		 	$this->pdf->Ln();
		 	$this->pdf->Cell(50, 1, '...................................', '0', 0, 'L', 0);
		 	$this->pdf->Cell(50, 1, '...................................', '0', 0, 'L', 0);
		 	$this->pdf->Cell(50, 1, '...................................', '0', 0, 'L', 0);
		 	$this->pdf->Cell(50, 1, '...................................', '0', 0, 'L', 0);
			$this->pdf->Ln();
		 	$this->pdf->Cell(50, 1, '       Prepaired By', '0', 0, 'L', 0);
		 	$this->pdf->Cell(50, 1, '         Checked By', '0', 0, 'L', 0);
		 	$this->pdf->Cell(50, 1, ' Cashier Signature', '0', 0, 'L', 0);
		 	$this->pdf->Cell(50, 1, 'Customer Signature', '0', 0, 'L', 0);
		 
		 	$this->pdf->Ln();
		 	$this->pdf->Ln();
		 	$this->pdf->Ln();

		 	$this->pdf->Ln();
		 	$this->pdf->Cell(20, 1, "Operator ", '0', 0, 'L', 0);
		 	$this->pdf->Cell(1, 1, $operator, '0', 0, 'L', 0);
		 	$this->pdf->Ln();

		 	$tt = date("H:i");

		 	
		 	$this->pdf->Cell(20, 1, "Print Time ", '0', 0, 'L', 0);
		 	$this->pdf->Cell(1, 1, $tt, '0', 0, 'L', 0);
		 	$this->pdf->Ln();



	//$this->pdf->footerSet($employee,$amount,$additional,$discount,$user);

	$this->pdf->Output("Voucher".date('Y-m-d').".pdf", 'I');

?>