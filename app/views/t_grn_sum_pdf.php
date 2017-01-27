<?php
	
		error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
		$this->pdf->setPrintHeader($header,$type,$duration);
		$this->pdf->setPrintHeader(true,$type);
        $this->pdf->setPrintFooter(true,'0',$is_cur_time);
        //$this->pdf->setPrintHeader(true);
        
        $this->pdf->SetFont('helvetica', 'B', 16);
		$this->pdf->AddPage($orientation,$page);   // L or P amd page type A4 or A3

 		foreach($branch as $ress){
 			$this->pdf->headerSet3($ress->name,$ress->address,$ress->tp,$ress->fax,$ress->email);	
		}

		foreach($sum as $s){
 			$check = $s->check_by;
 			$check_des = $s->name;
 			$vehicle_no=$s->vehicle_no;
 			$del_officer=$s->del_officer;
		}

		
		$sup_name;
		$sup_address;
		$sup_tp;
		$sup_email;
		$ship_branch_name;
		$ship_branch_add;
		$ship_branch_tp;
		$ship_branch_email;


		foreach($suppliers as $sup){
			$sup_name=$sup->name;
			$sup_address=$sup->address1." ".$sup->address2." ".$sup->address3;
			$sup_tp=$sup->tp;
			$sup_email=$sup->email;
		}

		foreach($ship_branch as $sb){
			$ship_branch_name=$sb->name;
			$ship_branch_add=$sb->address1." ".$sb->address2." ".$sb->address3;
			$ship_branch_tp=$sb->tp;
			$ship_branch_email=$sb->email;
		}

		foreach($session as $ses){
			$invoice_no=$session[0].$session[1]."GR".$session[2];
		}

		foreach($user as $row){
		 	$operator=$row->loginName;
		}

			$align_h=$this->utility->heading_align();
			$this->pdf->setY(20);
        	$this->pdf->SetFont('helvetica', 'BU', 10);
        	$this->pdf->Ln();
        	$orgin_print=$_POST['org_print'];
			if($orgin_print=="1"){
		  	$this->pdf->Cell(0, 5,' GOODS RECEIVED NOTE',0,false, $align_h, 0, '', 0, false, 'M', 'M');
		  	}else{
		  	$this->pdf->Cell(0, 5,' GOODS RECEIVED NOTE (DUPLICATE) ',0,false, $align_h, 0, '', 0, false, 'M', 'M');
		  	}
		 	$this->pdf->SetFont('helvetica', 'B', 9);
		 	$this->pdf->setY(25);
		 	$this->pdf->Ln();
		 	$this->pdf->Cell(20, 1, 'GRN No ', '0', 0, 'L', 0);
		 	$this->pdf->Cell(5, 1, '', '0', 0, 'L', 0);

		 	$this->pdf->SetFont('helvetica','',9);
		 	$this->pdf->Cell(40, 1, $invoice_no, '0', 0, 'L', 0);
		 	$this->pdf->Cell(30, 1, "", '0', 0, 'L', 0);
		 	
		 	$this->pdf->SetFont('helvetica','B',9);
		 	$this->pdf->Cell(30, 1, "Vendor Name ", '0', 0, 'L', 0);
		 	$this->pdf->Cell(5, 1, '', '0', 0, 'L', 0);
		 	$this->pdf->SetFont('helvetica','',9);
		 	$this->pdf->Cell(60, 1, $sup_name, '0', 0, 'L', 0);
		 	$this->pdf->Ln();

		 	$this->pdf->SetFont('helvetica','B',9);
		 	$this->pdf->Cell(20, 1, 'Date', '0', 0, 'L', 0);
		 	$this->pdf->Cell(5, 1, '', '0', 0, 'L', 0);

		 	$this->pdf->SetFont('helvetica','',9);
		 	$this->pdf->Cell(40, 1, $inv_date.$save_time, '0', 0, 'L', 0);
		 	$this->pdf->Cell(30, 1, "", '0', 0, 'L', 0);
		 	
		 	$this->pdf->SetFont('helvetica','B',9);
		 	$this->pdf->Cell(30, 1, "Address ", '0', 0, 'L', 0);
		 	$this->pdf->Cell(5, 1, '', '0', 0, 'L', 0);
		 	$this->pdf->SetFont('helvetica','',9);
		 	$this->pdf->Cell(60, 1, $sup_address, '0', 0, 'L', 0);
		 	$this->pdf->Ln();


		 	$this->pdf->SetFont('helvetica','B',9);
		 	$this->pdf->Cell(20, 1, 'Invoice No ', '0', 0, 'L', 0);
		 	$this->pdf->Cell(5, 1, '', '0', 0, 'L', 0);
		 	$this->pdf->SetFont('helvetica','',9);
		 	$this->pdf->Cell(40, 1, $inv_nop, '0', 0, 'L', 0);
		 	$this->pdf->Cell(30, 1, "", '0', 0, 'L', 0);
		 	
		 	$this->pdf->SetFont('helvetica','B',9);
		 	$this->pdf->Cell(30, 1, "Email  ", '0', 0, 'L', 0);
		 	$this->pdf->Cell(5, 1, '', '0', 0, 'L', 0);
		 	$this->pdf->SetFont('helvetica','',9);
		 	$this->pdf->Cell(60, 1, $sup_email, '0', 0, 'L', 0);
		 	$this->pdf->Ln();

		 	$this->pdf->SetFont('helvetica','B',9);
		 	$this->pdf->Cell(19, 1, 'PO No ', '0', 0, 'L', 0);
		 	$this->pdf->Cell(6, 1, '', '0', 0, 'L', 0);
		 	$this->pdf->SetFont('helvetica','',9);
		 	$this->pdf->Cell(40, 1, $po_nop, '0', 0, 'L', 0);
		 	$this->pdf->Cell(30, 1, "", '0', 0, 'L', 0);
		 	
		 	$this->pdf->SetFont('helvetica','B',9);
		 	$this->pdf->Cell(30, 1, "Telephone No ", '0', 0, 'L', 0);
		 	$this->pdf->Cell(5, 1, '', '0', 0, 'L', 0);
		 	$this->pdf->SetFont('helvetica','',9);
		 	$this->pdf->Cell(60, 1, $sup_tp, '0', 0, 'L', 0);
		 	$this->pdf->Ln();

		 	$this->pdf->SetFont('helvetica','B',9);
		 	$this->pdf->Cell(20, 1, 'PO Date ', '0', 0, 'L', 0);
		 	$this->pdf->Cell(5, 1, '', '0', 0, 'L', 0);
		 	$this->pdf->SetFont('helvetica','',9);
		 	$this->pdf->Cell(40, 1, $po_dt, '0', 0, 'L', 0);
		 	$this->pdf->Cell(30, 1, "", '0', 0, 'L', 0);
		 	
		 	$this->pdf->SetFont('helvetica','B',9);
		 	$this->pdf->Cell(30, 1, "Credit Period ", '0', 0, 'L', 0);
		 	$this->pdf->Cell(5, 1, '', '0', 0, 'L', 0);
		 	$this->pdf->SetFont('helvetica','',9);
		 	$this->pdf->Cell(60, 1, $credit_prd, '0', 0, 'L', 0);
		
			$this->pdf->Ln();
			
			$this->pdf->SetY(69);




$x=1;
$code="default";


foreach($det as $row){

	$lpm=(float)0;
	$lpm=round(((float)$row->last_price-(float)$row->unit_price)/(float)$row->last_price*100,2);

	$spm=(float)0;
	$spm=round(((float)$row->sales_price-(float)$row->unit_price)/(float)$row->sales_price*100,2);

	$hi = $this->pdf->getNumLines($row->description, 30);
	$row_hight=6*$hi;

	$this->pdf->SetX(2);

	$this->pdf->SetLineStyle(array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0.1, 'color' => array(0, 0, 0)));

	
	if($code!='default' && $code==$row->code)
	{
				if($row->sub_item!="")
	     		{	
	     		$this->pdf->SetX(2);
		        $this->pdf->SetFont('helvetica','',9);

		        $this->pdf->MultiCell(8, $row_hight, "", 1, 'R', 0, 0, '', '', true, 0, false, true, 0);
		        $this->pdf->MultiCell(28, $row_hight, $row->sub_item, 1, 'L', 0, 0, '', '', true, 0, false, true, 0);
		        $this->pdf->MultiCell(30, $row_hight, $row->des, 1, 'L', 0, 0, '', '', true, 0, false, true, 0);
		        $this->pdf->MultiCell(20, $row_hight, "", 1, 'L', 0, 0, '', '', true, 0, false, true, 0);
				$this->pdf->MultiCell(8, $row_hight, $row->sub_qty, 1, 'R', 0, 0, '', '', true, 0, false, true, 0);
				$this->pdf->MultiCell(8, $row_hight, "", 1, 'R', 0, 0, '', '', true, 0, false, true, 0);
				$this->pdf->MultiCell(17, $row_hight, "", 1, 'R', 0, 0, '', '', true, 0, false, true, 0);
				$this->pdf->MultiCell(17, $row_hight, "", 1, 'R', 0, 0, '', '', true, 0, false, true, 0);
				$this->pdf->MultiCell(15, $row_hight, "", 1, 'R', 0, 0, '', '', true, 0, false, true, 0);
				//$this->pdf->MultiCell(10, $row_hight, "", 1, 'R', 0, 0, '', '', true, 0, false, true, 0);
				$this->pdf->MultiCell(15, $row_hight, "", 1, 'R', 0, 0, '', '', true, 0, false, true, 0);
				//$this->pdf->MultiCell(10, $row_hight, "", 1, 'R', 0, 0, '', '', true, 0, false, true, 0);
				$this->pdf->MultiCell(10, $row_hight, "", 1, 'R', 0, 0, '', '', true, 0, false, true, 0);
				$this->pdf->MultiCell(10, $row_hight, "", 1, 'R', 0, 0, '', '', true, 0, false, true, 0);
				$this->pdf->MultiCell(20, $row_hight, "", 1, 'R', 0, 1, '', '', true, 0, false, true, 0);
		       
		        $x=$x-1;
		    }
			
	}
	else
	{

			$this->pdf->GetY();
			$this->pdf->SetFont('helvetica','',8);

			$this->pdf->MultiCell(8, $row_hight, $x, 1, 'R', 0, 0, '', '', true, 0, false, true, 0);
			$this->pdf->MultiCell(28, $row_hight, $row->code, 1, 'L', 0, 0, '', '', true, 0, false, true, 0);
			$this->pdf->MultiCell(30, $row_hight, $row->description, 1, 'L', 0, 0, '', '', true, 0, false, true, 0);
	    	$this->pdf->MultiCell(20, $row_hight, $row->model, 1, 'L', 0, 0, '', '', true, 0, false, true, 0);
	    	$this->pdf->MultiCell(8, $row_hight, $row->qty, 1, 'R', 0, 0, '', '', true, 0, false, true, 0);
	    	$this->pdf->MultiCell(8, $row_hight, $row->foc, 1, 'R', 0, 0, '', '', true, 0, false, true, 0);
	    	
	    	$this->pdf->MultiCell(17, $row_hight, number_format($row->unit_price,2), 1, 'R', 0, 0, '', '', true, 0, false, true, 0);
	    	$this->pdf->MultiCell(17, $row_hight, number_format($row->last_price,2), 1, 'R', 0, 0, '', '', true, 0, false, true, 0);
	    	$this->pdf->MultiCell(15, $row_hight, number_format($row->sales_price,2), 1, 'R', 0, 0, '', '', true, 0, false, true, 0);
	    	//$this->pdf->MultiCell(10, $row_hight, number_format($row->s_profit,2), 1, 'R', 0, 0, '', '', true, 0, false, true, 0);
	    	$this->pdf->MultiCell(15, $row_hight, number_format($row->discount,2), 1, 'R', 0, 0, '', '', true, 0, false, true, 0);
	    	
	    	//$this->pdf->MultiCell(10, $row_hight, number_format($row->profit,2), 1, 'R', 0, 0, '', '', true, 0, false, true, 0);
	    	$this->pdf->MultiCell(10, $row_hight, number_format($lpm,2), 1, 'R', 0, 0, '', '', true, 0, false, true, 0);
			$this->pdf->MultiCell(10, $row_hight, number_format($spm,2), 1, 'R', 0, 0, '', '', true, 0, false, true, 0);

	    	$this->pdf->MultiCell(20, $row_hight, number_format($row->amount,2), 1, 'R', 0, 1, '', '', true, 0, false, true, 0);
	

 		 
		$ss="";
		foreach ($serial as $rows) {
			if($row->code==$rows->item)
		 	{
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
	        $this->pdf->SetX(2);
			$this->pdf->SetFont('helvetica','',8);

	        $aa = $this->pdf->getNumLines($all_serial, 25);
	        $heigh=5*$aa;

	    	$this->pdf->MultiCell(8, $heigh, "", 1, 'R', 0, 0, '', '', true, 0, false, true, 0);
	    	$this->pdf->MultiCell(28, $heigh, "", 1, 'L', 0, 0, '', '', true, 0, false, true, 0);
			$this->pdf->MultiCell(30, $heigh, $all_serial, 1, 'L', 0, 0, '', '', true, 0, false, true, 0);
	        $this->pdf->MultiCell(20, $heigh, "", 1, 'L', 0, 0, '', '', true, 0, false, true, 0);
	        $this->pdf->MultiCell(8, $heigh, "", 1, 'L', 0, 0, '', '', true, 0, false, true, 0);
	        $this->pdf->MultiCell(8, $heigh, "", 1, 'L', 0, 0, '', '', true, 0, false, true, 0);
	        $this->pdf->MultiCell(17, $heigh, "", 1, 'L', 0, 0, '', '', true, 0, false, true, 0);
	        $this->pdf->MultiCell(17, $heigh, "", 1, 'L', 0, 0, '', '', true, 0, false, true, 0);
	        $this->pdf->MultiCell(15, $heigh, "", 1, 'L', 0, 0, '', '', true, 0, false, true, 0);
	        //$this->pdf->MultiCell(10, $heigh, "", 1, 'L', 0, 0, '', '', true, 0, false, true, 0);
	        $this->pdf->MultiCell(15, $hight, "", 1, 'R', 0, 0, '', '', true, 0, false, true, 0);
			//$this->pdf->MultiCell(10, $hight, "", 1, 'R', 0, 0, '', '', true, 0, false, true, 0);
			$this->pdf->MultiCell(10, $heigh, "", 1, 'L', 0, 0, '', '', true, 0, false, true, 0);
			$this->pdf->MultiCell(10, $heigh, "", 1, 'L', 0, 0, '', '', true, 0, false, true, 0);
	        $this->pdf->MultiCell(20, $heigh, "", 1, 'L', 0, 1, '', '', true, 0, false, true, 0);
	        


	        if($row->sub_item!="")
	     	{	$this->pdf->SetX(2);
		        $this->pdf->SetFont('helvetica','',8);
				$this->pdf->MultiCell(8, $row_hight, "", 1, 'R', 0, 0, '', '', true, 0, false, true, 0);
		        $this->pdf->MultiCell(28, $row_hight, $row->sub_item, 1, 'L', 0, 0, '', '', true, 0, false, true, 0);
		        $this->pdf->MultiCell(30, $row_hight, $row->des, 1, 'L', 0, 0, '', '', true, 0, false, true, 0);
		        $this->pdf->MultiCell(20, $row_hight, "", 1, 'L', 0, 0, '', '', true, 0, false, true, 0);
				$this->pdf->MultiCell(8, $row_hight, $row->sub_qty, 1, 'R', 0, 0, '', '', true, 0, false, true, 0);
				$this->pdf->MultiCell(8, $row_hight, "", 1, 'R', 0, 0, '', '', true, 0, false, true, 0);
				$this->pdf->MultiCell(17, $row_hight, "", 1, 'R', 0, 0, '', '', true, 0, false, true, 0);
				$this->pdf->MultiCell(17, $row_hight, "", 1, 'R', 0, 0, '', '', true, 0, false, true, 0);
				$this->pdf->MultiCell(15, $row_hight, "", 1, 'R', 0, 0, '', '', true, 0, false, true, 0);
				//$this->pdf->MultiCell(10, $row_hight, "", 1, 'R', 0, 0, '', '', true, 0, false, true, 0);
				$this->pdf->MultiCell(15, $row_hight, "", 1, 'R', 0, 0, '', '', true, 0, false, true, 0);
				//$this->pdf->MultiCell(10, $row_hight, "", 1, 'R', 0, 0, '', '', true, 0, false, true, 0);
				$this->pdf->MultiCell(10, $row_hight, "", 1, 'R', 0, 0, '', '', true, 0, false, true, 0);
				$this->pdf->MultiCell(10, $row_hight, "", 1, 'R', 0, 0, '', '', true, 0, false, true, 0);
				$this->pdf->MultiCell(20, $row_hight, "", 1, 'R', 0, 1, '', '', true, 0, false, true, 0);
		       
	     	}
		}else{




			  if($row->sub_item!="")
	     	{	$this->pdf->SetX(2);
		        $this->pdf->SetFont('helvetica','',8);
				$this->pdf->MultiCell(8, $row_hight, "", 1, 'R', 0, 0, '', '', true, 0, false, true, 0);
		        $this->pdf->MultiCell(28, $row_hight, $row->sub_item, 1, 'L', 0, 0, '', '', true, 0, false, true, 0);
		        $this->pdf->MultiCell(30, $row_hight, $row->des, 1, 'L', 0, 0, '', '', true, 0, false, true, 0);
		        $this->pdf->MultiCell(20, $row_hight, "", 1, 'L', 0, 0, '', '', true, 0, false, true, 0);
				$this->pdf->MultiCell(8, $row_hight, $row->sub_qty, 1, 'R', 0, 0, '', '', true, 0, false, true, 0);
				$this->pdf->MultiCell(8, $row_hight, "", 1, 'R', 0, 0, '', '', true, 0, false, true, 0);
				$this->pdf->MultiCell(17, $row_hight, "", 1, 'R', 0, 0, '', '', true, 0, false, true, 0);
				$this->pdf->MultiCell(17, $row_hight, "", 1, 'R', 0, 0, '', '', true, 0, false, true, 0);
				$this->pdf->MultiCell(15, $row_hight, "", 1, 'R', 0, 0, '', '', true, 0, false, true, 0);
				//$this->pdf->MultiCell(10, $row_hight, "", 1, 'R', 0, 0, '', '', true, 0, false, true, 0);
				$this->pdf->MultiCell(15, $row_hight, "", 1, 'R', 0, 0, '', '', true, 0, false, true, 0);
			    //$this->pdf->MultiCell(10, $row_hight, "", 1, 'R', 0, 0, '', '', true, 0, false, true, 0);
				$this->pdf->MultiCell(10, $row_hight, "", 1, 'R', 0, 0, '', '', true, 0, false, true, 0);
				$this->pdf->MultiCell(10, $row_hight, "", 1, 'R', 0, 0, '', '', true, 0, false, true, 0);
				$this->pdf->MultiCell(20, $row_hight, "", 1, 'R', 0, 1, '', '', true, 0, false, true, 0);
		       
	     	}


	
    	}
	}

	$code=$row->code;
	$x++;
}
			

    $this->pdf->SetFont('helvetica','',9);
	

    $this->pdf->footerSetgrn($total_amount,$discount,$tot,$additional);

    $this->pdf->SetFont('helvetica','B',9);
    $this->pdf->Ln();
 	$this->pdf->Cell(30, 1, "Note ", '0', 0, 'L', 0);

 	$this->pdf->SetFont('helvetica','',9);
 	$this->pdf->Cell(1, 1,$memo, '0', 0, 'L', 0);
	$this->pdf->Ln();

 	$this->pdf->SetFont('helvetica','B',9);
 	$this->pdf->Cell(30, 1, "Check By ", '0', 0, 'L', 0);
 	$this->pdf->SetFont('helvetica','',9);
 	$this->pdf->Cell(1, 1,$check." - ".$check_des, '0', 0, 'L', 0);


 	$this->pdf->SetFont('helvetica','B',9);
 	$this->pdf->Ln();
    $this->pdf->Ln();
 	$this->pdf->Cell(30, 1, "Vehicle No. 	", '0', 0, 'L', 0);

 	$this->pdf->SetFont('helvetica','',9);
 	$this->pdf->Cell(20, 1, $vehicle_no, '0', 0, 'L', 0);
 	$this->pdf->Ln();
 	$this->pdf->SetFont('helvetica','B',9);
 	$this->pdf->Cell(30, 1, "Delivery Officer 	", '0', 0, 'L', 0);

 	$this->pdf->SetFont('helvetica','',9);
 	$this->pdf->Cell(1, 1, $del_officer, '0', 0, 'L', 0);
 	$this->pdf->Cell(20, 1, "", '0', 0, 'L', 0);
 	$this->pdf->Cell(30, 1, ".......................................................", '0', 0, 'L', 0);
 	$this->pdf->Ln();

 	$this->pdf->SetFont('helvetica','B',9);
 	$this->pdf->Ln();
    $this->pdf->Ln();
 	$this->pdf->Cell(30, 1, "Operator ", '0', 0, 'L', 0);
 	$this->pdf->SetFont('helvetica','',9);
 	$this->pdf->Cell(1, 1, $operator, '0', 0, 'L', 0);
 	$this->pdf->Ln();




 	$tt = date("H:i");

 	
 	$this->pdf->Cell(30, 1, "Print Time ", '0', 0, 'L', 0);
 	$this->pdf->Cell(1, 1, $tt, '0', 0, 'L', 0);
 	$this->pdf->Ln();

	$this->pdf->Output("Purchase_".date('Y-m-d').".pdf", 'I');

?>