<?php
	error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
	$this->pdf->setPrintFooter(true);
	$this->pdf->setPrintHeader(true);
	$this->pdf->setPrintHeader($header,$type); 

  $this->pdf->SetFont('helvetica', 'B', 16);
	$this->pdf->AddPage($orientation,$page);   // L or P amd page type A4 or A3
 	foreach($branch as $ress){
 		$this->pdf->headerSet3($ress->name,$ress->address,$ress->tp,$ress->fax,$ress->email);
	}
	
	foreach ($sum as $key) {
		$cus 		= $key->cus_id;
		$cus_name	= $key->cus_name;
		$cus_add 	= $key->address;
		$store 		= $key->store;
		$no  		= $key->no;
		$date 		= $key->date;
		$ref 		= $key->ref_no;
		$gross 		= $key->gross_amount;
		$addi 		= $key->additional_amount;
		$discount   = $key->discount_amount;
		$net 		= $key->net_amount;
		$memo 		= $key->memo;
		$rep 		= $key->rep_id;
		$rep_name	= $key->rep_name;
		$inv 		= $key->inv_no;
	}
	$employee=$rep."-".$rep_name;


	foreach($session as $ses){
		$invoice_no=$session[0].$session[1].$session[2];
	}

	// $this->pdf->setY(23);
        
  	$this->pdf->SetFont('helvetica', 'BU', 10);

 	$this->pdf->Cell(100, 5, $r_type.'SALES ORDER',0,false, 'L', 0, '', 0, false, 'M', 'M');

 	$this->pdf->SetFont('helvetica', '',9);
 	// $this->pdf->setY(28);
 	$this->pdf->Ln();  
 	$this->pdf->Cell(30, 1, 'Invoice No.', '0', 0, 'L', 0);
 	$this->pdf->Cell(30, 1, $invoice_no, '0', 0, 'L', 0);
 	$this->pdf->Cell(10, 1, "", '0', 0, 'L', 0);
 	$this->pdf->Cell(10, 1, "", '0', 0, 'L', 0);
 	$this->pdf->Cell(20, 1, "Customer", '0', 0, 'L', 0);
 	$this->pdf->Cell(30, 1, $cus." - ".$cus_name, '0', 0, 'L', 0);
 	$this->pdf->Ln();

 	$this->pdf->Cell(30, 1, 'Invoice Date', '0', 0, 'L', 0);
 	$this->pdf->Cell(30, 1, $date, '0', 0, 'L', 0);
 	$this->pdf->Cell(10, 1, "", '0', 0, 'L', 0);
 	$this->pdf->Cell(10, 1, "", '0', 0, 'L', 0);
 	$this->pdf->Cell(20, 1, "Address", '0', 0, 'L', 0);
 	$this->pdf->Cell(30, 1, $cus_add, '0', 0, 'L', 0);
 	$this->pdf->Ln();

 	$this->pdf->Cell(30, 1, '','0', 0, 'L', 0);
 	$this->pdf->Cell(10, 1, '', '0', 0, 'L', 0);
 	$this->pdf->Cell(10, 1, "", '0', 0, 'L', 0);
 	$this->pdf->Cell(30, 1, "", '0', 0, 'L', 0);
 	$this->pdf->Cell(20, 1, "Store", '0', 0, 'L', 0);
 	$this->pdf->Cell(30, 1, $store , '0', 0, 'L', 0);
		 	
 	$this->pdf->Ln();
 	$this->pdf->Ln();
 	$this->pdf->SetY(45);
  $this->pdf->setX(5);
	$this->pdf->SetFont('helvetica','B',9);
  $this->pdf->Cell(35, 6,"Code", '1', 0, 'C', 0);
	$this->pdf->Cell(42, 6,"Description", '1', 0, 'C', 0);
  $this->pdf->Cell(25, 6,"Model", '1', 0, 'C', 0);
  $this->pdf->Cell(20, 6,"Is Received", '1', 0, 'C', 0);
  //$this->pdf->Cell(15, 6,"Batch", '1', 0, 'C', 0);
  $this->pdf->Cell(15, 6,"Quantity", '1', 0, 'C', 0);
  $this->pdf->Cell(18, 6,"Price", '1', 0, 'C', 0);
  $this->pdf->Cell(18, 6,"Discount", '1', 0, 'C', 0);
  $this->pdf->Cell(25, 6,"Amount", '1', 0, 'C', 0);
  
  $this->pdf->Ln();
  $x=1;
	$code="default";
  
foreach($det as $row){
	if($row->is_reserve==1){
		$receive="Received";
	}else{
		$receive="Not Receive";
	}
	$this->pdf->setX(5);
	$this->pdf->SetLineStyle(array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0.1, 'color' => array(0, 0, 0)));
	
	if($code!='default' && $code==$row->item){
		if($row->sub_item!=""){	
		  	$heigh=6*(max(1,$this->pdf->getNumLines($row->des, 42)));			
	    	$this->pdf->setX(5);	
		  	$this->pdf->SetFont('helvetica','',9);
			$this->pdf->MultiCell(35, $heigh,$row->sub_item,  1, 'L', false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
			$this->pdf->MultiCell(42, $heigh,$row->des,  1, 'L', false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
			$this->pdf->MultiCell(25, $heigh,"",  1, 'L', false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
			$this->pdf->MultiCell(20, $heigh,"",  1, 'L', false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
		//	$this->pdf->MultiCell(15, $heigh,"",  1, 'R', false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
			$this->pdf->MultiCell(15, $heigh,$row->sub_qty,  1, 'R', false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
			$this->pdf->MultiCell(18, $heigh,"",  1, 'R', false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
			$this->pdf->MultiCell(18, $heigh,"",  1, 'R', false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
			$this->pdf->MultiCell(25, $heigh,"", 1, 'R', false, 1, '', '', true, 0, false, true, $heigh,'M' ,false);
      	$x=$x-1;
    }
	}else{

		$this->pdf->GetY();
		$this->pdf->setX(5);


		  	$heigh=6*(max(1,$this->pdf->getNumLines($row->item, 35),$this->pdf->getNumLines($row->des, 42)));
		$this->pdf->SetFont('helvetica','',9);		
		if ($row->is_free==0) {
			  	$this->pdf->MultiCell(35, $heigh,$row->item,  1, 'L', false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
			  	$this->pdf->MultiCell(42, $heigh,$row->description,  1, 'L', false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
			  	$this->pdf->MultiCell(25, $heigh,$row->model,  1, 'L', false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
			  	$this->pdf->MultiCell(20, $heigh,$receive,  1, 'L', false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
			  //	$this->pdf->MultiCell(15, $heigh,$row->batch_no,  1, 'R', false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
			  	$this->pdf->MultiCell(15, $heigh,$row->qty,  1, 'R', false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
			  	$this->pdf->MultiCell(18, $heigh,$row->cost,  1, 'R', false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
			  	$this->pdf->MultiCell(18, $heigh,$row->discount,  1, 'R', false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
			  	$this->pdf->MultiCell(25, $heigh,$row->amount, 1, 'R', false, 1, '', '', true, 0, false, true, $heigh,'M' ,false);
		  	
		}
		else
		{
			  	$this->pdf->MultiCell(35, $heigh,$row->item,  1, 'L', false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
			  	$this->pdf->MultiCell(42, $heigh,$row->description,  1, 'L', false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
			  	$this->pdf->MultiCell(25, $heigh,"Free",  1, 'L', false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
			  	$this->pdf->MultiCell(20, $heigh,"",  1, 'L', false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
			//  	$this->pdf->MultiCell(15, $heigh,"",  1, 'R', false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
			  	$this->pdf->MultiCell(15, $heigh,$row->qty,  1, 'R', false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
			  	$this->pdf->MultiCell(18, $heigh,"",  1, 'R', false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
			  	$this->pdf->MultiCell(18, $heigh,"",  1, 'R', false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
			  	$this->pdf->MultiCell(25, $heigh,"", 1, 'R', false, 1, '', '', true, 0, false, true, $heigh,'M' ,false);
		
		$gross=floatval($gross)-floatval($row->amount);
		$net=floatval($net)-floatval($row->amount);

		}


  	$ss="";
		foreach ($serial as $rows){
			if($row->item==$rows->s_item){
				$ss=$rows->serial_no;
			}		
		}
		if($ss!=""){			
		$all_serial="";		
		foreach ($serial as $rows){
    		if($row->item==$rows->s_item){					
	 			$all_serial=$all_serial.$rows->serial_no."   ";
 			}
		}
    $this->pdf->GetY();
    $this->pdf->setX(5);	



		  	$heigh=6*(max(1,$this->pdf->getNumLines($all_serial, 42)));

		$this->pdf->SetFont('helvetica','',9);
	  	$this->pdf->MultiCell(35, $heigh,"",  1, 'L', false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
	  	$this->pdf->MultiCell(42, $heigh,$all_serial,  1, 'L', false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
	  	$this->pdf->MultiCell(25, $heigh,"",  1, 'L', false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
	  	$this->pdf->MultiCell(20, $heigh,"",  1, 'L', false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
	//  	$this->pdf->MultiCell(15, $heigh,"",  1, 'L', false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
	  	$this->pdf->MultiCell(15, $heigh,"",  1, 'L', false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
	  	$this->pdf->MultiCell(18, $heigh,"",  1, 'L', false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
	  	$this->pdf->MultiCell(18, $heigh,"",  1, 'L', false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
	  	$this->pdf->MultiCell(25, $heigh,"", 1, 'R', false, 1, '', '', true, 0, false, true, $heigh,'M' ,false);

    if($row->sub_item!=""){
	    $this->pdf->setX(5);
		  	$this->pdf->SetFont('helvetica','',9);

		  	$heigh=6*(max(1,$this->pdf->getNumLines($row->sub_item, 25),$this->pdf->getNumLines($row->des, 42)));

			$this->pdf->MultiCell(25, $heigh,$row->sub_item,  1, 'L', false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
		  	$this->pdf->MultiCell(42, $heigh,$row->des,  1, 'L', false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
		  	$this->pdf->MultiCell(25, $heigh,"",  1, 'L', false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
		  	$this->pdf->MultiCell(20, $heigh,"",  1, 'L', false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
		  	$this->pdf->MultiCell(15, $heigh,"",  1, 'L', false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
		  	$this->pdf->MultiCell(15, $heigh,$row->sub_qty,  1, 'R', false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
		  	$this->pdf->MultiCell(18, $heigh,"",  1, 'L', false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
		  	$this->pdf->MultiCell(18, $heigh,"",  1, 'L', false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
		  	$this->pdf->MultiCell(25, $heigh,"", 1, 'R', false, 1, '', '', true, 0, false, true, $heigh,'M' ,false);
		}
	}else{
		if($row->sub_item!=""){
	    $this->pdf->setX(5);
		  	$this->pdf->SetFont('helvetica','',9);

		  	$heigh=6*(max(1,$this->pdf->getNumLines($row->sub_item, 25),$this->pdf->getNumLines($row->des, 42)));

			$this->pdf->MultiCell(25, $heigh,$row->sub_item,  1, 'L', false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
		  	$this->pdf->MultiCell(42, $heigh,$row->des,  1, 'L', false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
		  	$this->pdf->MultiCell(25, $heigh,"",  1, 'L', false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
		  	$this->pdf->MultiCell(20, $heigh,"",  1, 'L', false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
		  	$this->pdf->MultiCell(15, $heigh,"",  1, 'L', false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
		  	$this->pdf->MultiCell(15, $heigh,$row->sub_qty,  1, 'R', false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
		  	$this->pdf->MultiCell(18, $heigh,"",  1, 'L', false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
		  	$this->pdf->MultiCell(18, $heigh,"",  1, 'L', false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
		  	$this->pdf->MultiCell(25, $heigh,"", 1, 'R', false, 1, '', '', true, 0, false, true, $heigh,'M' ,false);
	  }
  }
}

	$code=$row->item;
	$x++;
}
	$this->pdf->footerSetSalesOrder($employee,$gross,$addi,$discount,$net,$user,$additonal);

	$this->pdf->Output("Sales Order_".date('Y-m-d').".pdf", 'I');

?>