<?php
error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
//$this->pdf->setPrintHeader($header,$type,$duration);

$this->pdf->setPrintFooter(true);
$this->pdf->setPrintHeader(true);
//$this->pdf->setPrintHeader($header,$type); 
$this->pdf->SetFont('helvetica', 'B', 16);
$this->pdf->AddPage($orientation,$page);   // L or P amd page type A4 or A3

$tot_free_item=(float)0;

foreach($tot_free_items as $free){
	$free_price = $free->price;
	$tot_free_item+=(float)$free_price;	
}


foreach($branch as $ress){
	$this->pdf->headerSet3($ress->name,$ress->address,$ress->tp,$ress->fax,$ress->email);
}

$cus_name=$cus_address="";

foreach($customer as $cus){
	$cus_name=$cus->name;
	$cus_address=$cus->address1." ".$cus->address2." ".$cus->address3;
	$cus_id=$cus->code;
}

foreach($cash_sum as $csum){
	$scus_name=$csum->cus_name;
	$scus_address=$csum->cus_address;
}

foreach($session as $ses){
	$invoice_no=$session[0].$session[1].'CA'.$session[2];
}


$customer_name="";
$customer_address="";
$customer_id="";
$cus_status="";

if($cus_id==$cash_customer){

	$customer_name=$scus_name;
	$customer_address=$scus_address;
	$customer_id=$cash_customer;
	$cus_status="Bill To Customer";
}else{
	$customer_name=$cus_name;
	$customer_address=$cus_address;
	$customer_id=$cus_id;
	$cus_status="Customer";
}


$this->pdf->Ln();

$this->pdf->SetFont('helvetica', 'BU', 10);
$this->pdf->Cell(0, 5, $r_type.' INVOICE',0,false, 'C', 0, '', 0, false, 'M', 'M');

$this->pdf->SetFont('helvetica', 'B', 9);
$this->pdf->Ln();

$this->pdf->Cell(30, 1, 'Invoice No.', '0', 0, 'L', 0);
$this->pdf->Cell(60, 1, $invoice_no, '0', 0, 'L', 0);
$this->pdf->Cell(1, 1, "", '0', 0, 'L', 0);
$this->pdf->Cell(1, 1, "", '0', 0, 'L', 0);
$this->pdf->SetFont('helvetica', 'B', 8);
$this->pdf->Cell(60, 1, $cus_status, '0', 0, 'L', 0);
$this->pdf->Ln();

$this->pdf->SetFont('helvetica', '', 8);
$this->pdf->Cell(30, 1, 'Invoice Date', '0', 0, 'L', 0);
$this->pdf->Cell(60, 1, $dt, '0', 0, 'L', 0);
$this->pdf->Cell(1, 1, "", '0', 0, 'L', 0);
$this->pdf->Cell(1, 1, "", '0', 0, 'L', 0);
$this->pdf->Cell(30, 1, "ID No", '0', 0, 'L', 0);
$this->pdf->Cell(30, 1, $customer_id, '0', 0, 'L', 0);


$this->pdf->Ln();

$this->pdf->Cell(30, 1, '', '0', 0, 'L', 0);
$this->pdf->Cell(60, 1, "", '0', 0, 'L', 0);
$this->pdf->Cell(1, 1, "", '0', 0, 'L', 0);
$this->pdf->Cell(1, 1, "", '0', 0, 'L', 0);
$this->pdf->Cell(30, 1, "Name", '0', 0, 'L', 0);
$this->pdf->Cell(30, 1, $customer_name." (".$scus_name.")", '0', 0, 'L', 0);

$this->pdf->Ln();

$this->pdf->Cell(30, 1, '', '0', 0, 'L', 0);
$this->pdf->Cell(60, 1, "", '0', 0, 'L', 0);
$this->pdf->Cell(1, 1, "", '0', 0, 'L', 0);
$this->pdf->Cell(1, 1, "", '0', 0, 'L', 0);
$this->pdf->Cell(30, 1, "Address", '0', 0, 'L', 0);
$this->pdf->Cell(30, 1, $customer_address." (".$scus_address.")", '0', 0, 'L', 0);

$this->pdf->Ln();
$this->pdf->Ln();


$this->pdf->setX(10);
$this->pdf->SetFont('helvetica','B',8);
$this->pdf->Cell(10, 6,"Sr. No", '1', 0, 'C', 0);
$this->pdf->Cell(35, 6,"Item Code", '1', 0, 'C', 0);
$this->pdf->Cell(55, 6,"Item Description", '1', 0, 'C', 0);
$this->pdf->Cell(25, 6,"Module", '1', 0, 'C', 0);
$this->pdf->Cell(10, 6,"QTY", '1', 0, 'C', 0);
$this->pdf->Cell(18, 6,"Unit Price", '1', 0, 'C', 0);
$this->pdf->Cell(17, 6,"Discount", '1', 0, 'C', 0);
$this->pdf->Cell(20, 6,"Net Value", '1', 0, 'C', 0);
$this->pdf->Ln();

$x=1;
$code="default";


foreach($items as $row){
	//var_dump($row->is_free);

	$this->pdf->setX(10);

	//$this->pdf->SetLineStyle(array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0.1, 'color' => array(0, 0, 0)));

	
	if($code!='default' && $code==$row->code)
	{
				if($row->sub_item!="")
	     		{	
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
			
	}
	else
	{

			$this->pdf->GetY();
			$this->pdf->setX(10);
			$this->pdf->SetFont('helvetica','B',9);
			$aa = $this->pdf->getNumLines($row->description, 55);
	        $heigh=5*$aa;
	        if($row->is_free=="1"){
	        	$this->pdf->MultiCell(10, $heigh,$x,  1, 'L', 0, 0, '', '', true, 0, false, true, 0);
		    	$this->pdf->MultiCell(35, $heigh,$row->code, 1, 'L', 0, 0, '', '', true, 0, false, true, 0);
		    	$this->pdf->MultiCell(55, $heigh,$row->description, 1, 'L', 0, 0, '', '', true, 0, false, true, 0);
		        $this->pdf->MultiCell(25, $heigh,"FREE", 1, 'L', 0, 0, '', '', true, 0, false, true, 0);
		        $this->pdf->MultiCell(10, $heigh,$row->qty, 1, 'L', 0, 0, '', '', true, 0, false, true, 0);
		        $this->pdf->MultiCell(18, $heigh,"",  1, 'L', 0, 0, '', '', true, 0, false, true, 0);
		        $this->pdf->MultiCell(17, $heigh,"", 1, 'L', 0, 0, '', '', true, 0, false, true, 0);
		        $this->pdf->MultiCell(20, $heigh,"", 1, 'R', 0, 1, '', '', true, 0, false, true, 0);
	        }else{
		    	$this->pdf->MultiCell(10, $heigh,$x,  1, 'L', 0, 0, '', '', true, 0, false, true, 0);
		    	$this->pdf->MultiCell(35, $heigh,$row->code, 1, 'L', 0, 0, '', '', true, 0, false, true, 0);
		    	$this->pdf->MultiCell(55, $heigh,$row->description, 1, 'L', 0, 0, '', '', true, 0, false, true, 0);
		        $this->pdf->MultiCell(25, $heigh,$row->model, 1, 'L', 0, 0, '', '', true, 0, false, true, 0);
		        $this->pdf->MultiCell(10, $heigh,$row->qty, 1, 'L', 0, 0, '', '', true, 0, false, true, 0);
		        $this->pdf->MultiCell(18, $heigh,number_format($row->price,2),  1, 'L', 0, 0, '', '', true, 0, false, true, 0);
		        $this->pdf->MultiCell(17, $heigh,number_format($row->discount,2), 1, 'L', 0, 0, '', '', true, 0, false, true, 0);
		        $this->pdf->MultiCell(20, $heigh,number_format($row->amount,2), 1, 'R', 0, 1, '', '', true, 0, false, true, 0);
	        }
	       


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

				$this->pdf->MultiCell(10, $heigh,"", 1, 'L', 0, 0, '', '', true, 0, false, true, 0);
				$this->pdf->MultiCell(35, $heigh,$row->sub_item, 1, 'L', 0, 0, '', '', true, 0, false, true, 0);
		        $this->pdf->MultiCell(55, $heigh,$row->des, 1, 'L', 0, 0, '', '', true, 0, false, true, 0);
		        $this->pdf->MultiCell(25, $heigh,"", 1, 'L', 0, 0, '', '', true, 0, false, true, 0);
		        $this->pdf->MultiCell(10, $heigh,$row->sub_qty, 1, 'L', 0, 0, '', '', true, 0, false, true, 0);
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

				$this->pdf->MultiCell(10, $heigh,"",1, 'L', 0, 0, '', '', true, 0, false, true, 0);
				$this->pdf->MultiCell(35, $heigh,$row->sub_item, 1, 'L', 0, 0, '', '', true, 0, false, true, 0);
		        $this->pdf->MultiCell(55, $heigh,$row->des,1, 'L', 0, 0, '', '', true, 0, false, true, 0);
		        $this->pdf->MultiCell(25, $heigh,"", 1, 'L', 0, 0, '', '', true, 0, false, true, 0);
		        $this->pdf->MultiCell(10, $heigh,$row->sub_qty,1, 'L', 0, 0, '', '', true, 0, false, true, 0);
		        $this->pdf->MultiCell(18, $heigh,"",1, 'L', 0, 0, '', '', true, 0, false, true, 0);
		        $this->pdf->MultiCell(17, $heigh,"",1, 'L', 0, 0, '', '', true, 0, false, true, 0);
		        $this->pdf->MultiCell(20, $heigh,"", 1, 'R', 0, 1, '', '', true, 0, false, true, 0);
		        //$this->pdf->Ln();
	     	}


	
    	}
	}

	$code=$row->code;
	$x++;

}

$this->pdf->footer_set_cash_sales($employee,$amount,$additional,$discount,$user,$credit_card,$tot_free_item,$cheque_detail,$credit_card_sum,$other1,$other2,$additional_tot);
$this->pdf->Output("Card And Cash Sales_".date('Y-m-d').".pdf", 'I');

?>