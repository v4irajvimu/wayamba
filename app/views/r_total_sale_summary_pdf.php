<?php
error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
		$this->pdf->setPrintHeader(true,'total_sale_summary_qty',$duration);
		//$this->pdf->setPrintHeader($header);
        $this->pdf->setPrintFooter(true);
        
        //print_r($purchase);
        $this->pdf->SetFont('helvetica', 'B', 16);
		$this->pdf->AddPage($orientation,$page);   // L or P amd page type A4 or A3

    $tr_code="default";
 		foreach($branch as $ress){
 				$this->pdf->headerSet3($ress->name,$ress->address,$ress->tp,$ress->fax,$ress->email);
 			}

			$this->pdf->setY(25);

        	$this->pdf->SetFont('helvetica', 'BIU',10);
		 	$this->pdf->Cell(70, 5, 'Total Sales Report Summary',0,false, 'L', 0, '', 0, false, 'M', 'M');
			$this->pdf->Ln();

			$this->pdf->SetFont('helvetica', '',9);
		 	$this->pdf->Cell(0, 5, 'Date Between '. $dfrom.' and '.$dto ,0,false, 'L', 0, '', 0, false, 'M', 'M');
			$this->pdf->Ln();			

			$this->pdf->SetY(42);
           foreach ($value as $row){

           	if($row->tr_code=='4'){
           		$type='Cash Sale';
           	}else if($row->tr_code=='5'){
           		$type='Credit Sale';
           	}else{
           		$type='HP Sale';
           	}

			$this->pdf->SetX(15);
			$this->pdf->SetLineStyle(array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0.1, 'color' => array(0, 0, 0)));
			$this->pdf->SetFont('helvetica','',7);

			$heigh=5*(max(1,$this->pdf->getNumLines($row->code." - ".$row->item_name, 60)));
    		$this->pdf->HaveMorePages($heigh);

	    if($tr_code!="default" && $tr_code==$type){
        $this->pdf->MultiCell(15, $heigh, '',L, 'L', 0, 0, '', '', true, 0, false, true, 0);
        $this->pdf->MultiCell(15, $heigh, $row->nno,1, 'R', 0, 0, '', '', true, 0, false, true, 0);
        $this->pdf->MultiCell(20, $heigh, $row->ddate,1, 'R', 0, 0, '', '', true, 0, false, true, 0);
        $this->pdf->MultiCell(60, $heigh, $row->code." - ".$row->item_name,1, 'L', 0, 0, '', '', true, 0, false, true, 0);
        $this->pdf->MultiCell(10, $heigh, $row->qty,1, 'R', 0, 0, '', '', true, 0, false, true, 0);
        $this->pdf->MultiCell(20, $heigh, $row->price,1, 'R', 0, 0, '', '', true, 0, false, true, 0);
        $this->pdf->MultiCell(20, $heigh, $row->discount,1, 'R', 0, 0, '', '', true, 0, false, true, 0);
        $this->pdf->MultiCell(20, $heigh, $row->amount,1, 'R', 0, 1, '', '', true, 0, false, true, 0);
      }else{
        $this->pdf->MultiCell(15, $heigh, $type ,1, 'L', 0, 0, '', '', true, 0, false, true, 0);
        $this->pdf->MultiCell(15, $heigh, $row->nno,1, 'R', 0, 0, '', '', true, 0, false, true, 0);
        $this->pdf->MultiCell(20, $heigh, $row->ddate,1, 'R', 0, 0, '', '', true, 0, false, true, 0);
        $this->pdf->MultiCell(60, $heigh, $row->code." - ".$row->item_name,1, 'L', 0, 0, '', '', true, 0, false, true, 0);
        $this->pdf->MultiCell(10, $heigh, $row->qty,1, 'R', 0, 0, '', '', true, 0, false, true, 0);
        $this->pdf->MultiCell(20, $heigh, $row->price,1, 'R', 0, 0, '', '', true, 0, false, true, 0);
        $this->pdf->MultiCell(20, $heigh, $row->discount,1, 'R', 0, 0, '', '', true, 0, false, true, 0);
        $this->pdf->MultiCell(20, $heigh, $row->amount,1, 'R', 0, 1, '', '', true, 0, false, true, 0);
      }

      $tr_code=$type;  
 
  			$net_qty +=  $row->qty;
        $price +=  $row->price;
        $discount +=  $row->discount;
        $amount +=  $row->amount;
      }
      $this->pdf->MultiCell(180, 1, '',T, 'R', 0, 1, '', '', true, 0, false, true, 0);
            
      $this->pdf->SetFont('helvetica','B',8);
		  $this->pdf->Cell(15, 6," ", '0', 0, 'C', 0);
		  $this->pdf->Cell(15, 6," ", '0', 0, 'C', 0);
		  $this->pdf->Cell(20, 6," ", '0', 0, 'C', 0);
		  $this->pdf->Cell(60, 6,"Total ", '0', 0, 'R', 0);
		  $this->pdf->Cell(10, 6,$net_qty, 'BU', 0, 'R', 0);
      $this->pdf->Cell(20, 6,number_format($price,2), 'BU', 0, 'R', 0);
      $this->pdf->Cell(20, 6,number_format($discount,2), 'BU', 0, 'R', 0);
      $this->pdf->Cell(20, 6,number_format($amount,2), 'BU', 0, 'R', 0);

          $this->pdf->Output("Total Sale Summary".date('Y-m-d').".pdf", 'I');

?>