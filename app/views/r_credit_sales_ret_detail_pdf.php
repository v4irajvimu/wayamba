<?php
error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
		$this->pdf->setPrintHeader($header,$type,$duration);
        $this->pdf->setPrintFooter(true);
        //$this->pdf->setPrintHeader(true);
        //print_r($sum);
        $this->pdf->SetFont('helvetica', 'B', 16);
		$this->pdf->AddPage($orientation,$page);   // L or P amd page type A4 or A3

 		foreach($branch as $ress){
 				$this->pdf->headerSet3($ress->name,$ress->address,$ress->tp,$ress->fax,$ress->email);
 			}

		
		$this->pdf->setY(20);

        	$this->pdf->SetFont('helvetica', 'BU',10);
		 	$this->pdf->Cell(0, 5, 'CREDIT SALES RETURN DETAILS',0,false, 'L', 0, '', 0, false, 'M', 'M');
			$this->pdf->Ln();
			$this->pdf->Ln();
			$this->pdf->SetFont('helvetica', '',9);
		 	$this->pdf->Cell(0, 5, 'Date Between '. $dfrom.' and '.$dto ,0,false, 'L', 0, '', 0, false, 'M', 'M');
			$this->pdf->Ln();
			$this->pdf->Ln();
			$i=0;
		    $a=-1;
			static $j=-1;
			$my_array=array();
			$Goss=array();
			$net=array();

			foreach ($purchase as $value) {
                  $my_array[]=$value->nno;
			}

			foreach ($sum as $sum){
                        	$Goss[]=$sum->gsum;
                        	$net[]=$sum->nsum;
                        	$a++;
                        }
 			 if($value->nno == "")
           {
           	$this->pdf->SetX(80);
			$this->pdf->Cell(20, 1, "No Records For View ! ! !", '0', 0, 'L', 0);     
           }
           else
           {

				

			foreach ($purchase as $value) {	
				if ($i==0 || $my_array[$i]!=$my_array[$i-1]) {

					if ($j>=0) {
			$this->pdf->Ln();
			$this->pdf->SetFont('helvetica','B',8);
			$this->pdf->SetX(20);
		 	$this->pdf->Cell(40, 1, "", '0', 0, 'L', 0);
		 	$this->pdf->Cell(100, 1, "", '0', 0, 'L', 0);
		 	$this->pdf->Cell(20, 1, "Goss", '0', 0, 'L', 0);
		 	$this->pdf->Cell(20, 1, "Rs   ".$Goss[$j], '0', 0, 'L', 0);
		 	$this->pdf->Cell(20, 1, "", '0', 0, 'L', 0);
		 
		 	$this->pdf->Ln();
			$this->pdf->SetX(20);
		 	$this->pdf->Cell(40, 1, "", '0', 0, 'L', 0);
		 	$this->pdf->Cell(100, 1, "", '0', 0, 'L', 0);
		 	$this->pdf->Cell(20, 1, "Net Amount", '0', 0, 'L', 0);
		 	$this->pdf->Cell(20, 1, "Rs   ".$net[$j], '0', 0, 'L', 0);
		 	$this->pdf->Cell(20, 1, "", '0', 0, 'L', 0);
		 	
			$this->pdf->Ln(); $this->pdf->Ln(); 
					}
					
				$j++;

		 	$this->pdf->SetFont('helvetica', '', 8);
		 	if ($i==0) {
		 		$this->pdf->setY(40);
		 	}
		 	$this->pdf->Ln();
		 	
		 	$this->pdf->SetX(20);
		 	$this->pdf->Cell(30, 1, 'INV No - ', '0', 0, 'L', 0);
		 	$this->pdf->Cell(100, 1, $value->nno, '0', 0, 'L', 0);
		 	$this->pdf->Cell(20, 1, "Rep", '0', 0, 'L', 0);
		 	$this->pdf->Cell(20, 1, $value->rep_id." | ".$value->rep, '0', 0, 'L', 0);
		 	$this->pdf->Cell(20, 1, "", '0', 0, 'L', 0);
		 	
		 	$this->pdf->Ln();
			$this->pdf->SetX(20);
		 	$this->pdf->Cell(30, 1, "Date - ", '0', 0, 'L', 0);
		 	$this->pdf->Cell(100, 1, $value->ddate, '0', 0, 'L', 0);
		 	$this->pdf->Cell(20, 1, "Store", '0', 0, 'L', 0);
		 	$this->pdf->Cell(20, 1, $value->store, '0', 0, 'L', 0);
		 	$this->pdf->Cell(20, 1, "", '0', 0, 'L', 0);
		 
		 	$this->pdf->Ln();
			$this->pdf->SetX(20);
		 	$this->pdf->Cell(30, 1, "Customer - ", '0', 0, 'L', 0);
		 	$this->pdf->Cell(50, 1, $value->cus_id." | ".$value->name, '0', 0, 'L', 0);
		 	$this->pdf->Cell(20, 1, "", '0', 0, 'L', 0);
		 	$this->pdf->Cell(20, 1, "", '0', 0, 'L', 0);
		 	$this->pdf->Cell(20, 1, "", '0', 0, 'L', 0);
		 	
			$this->pdf->Ln();
			$this->pdf->Ln();
				//$this->pdf->SetY(45);
		 				$this->pdf->SetX(20);
						$this->pdf->SetFont('helvetica','B',8);
                        $this->pdf->Cell(30, 6,"Item Code", '1', 0, 'C', 0);
                       
						$this->pdf->Cell(60, 6,"Description", '1', 0, 'C', 0);
                        $this->pdf->Cell(10, 6,"Qty", '1', 0, 'C', 0);
                        $this->pdf->Cell(20, 6,"Price", '1', 0, 'C', 0);
                        $this->pdf->Cell(20, 6,"Gross", '1', 0, 'C', 0);
                        $this->pdf->Cell(20, 6,"Discount", '1', 0, 'C', 0);
                        $this->pdf->Cell(20, 6,"Net Amount", '1', 0, 'C', 0);
                        $this->pdf->Ln();

                        $tot_price=(float)0;
                        $tot_dis=(float)0;

}

                        
						//$this->pdf->SetY(45);
                        	
                        	
		 				$this->pdf->SetX(20);
						$this->pdf->SetFont('helvetica','',8);
						$this->pdf->SetLineStyle(array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0.1, 'color' => array(0, 0, 0)));
                        $this->pdf->Cell(30, 6,$value->code, '1', 0, 'L', 0);
						$this->pdf->Cell(60, 6,$value->description,'1', 0, 'L', 0);
                        $this->pdf->Cell(10, 6,$value->qty, '1', 0, 'R', 0);
                        $this->pdf->Cell(20, 6,$value->price, '1', 0, 'R', 0);
                        $this->pdf->Cell(20, 6,$value->gross_a, '1', 0, 'R', 0);
                        $this->pdf->Cell(20, 6,$value->discount, '1', 0, 'R', 0);
                        $this->pdf->Cell(20, 6,$value->net_amount, '1', 0, 'R', 0);
                        $this->pdf->Ln();

                        $tot_price+=(float)$value->price;
                        $tot_dis+=(float)$value->discount;


                        $i++;
                        	
                        }

                        $this->pdf->Ln(); 
						$this->pdf->SetFont('helvetica', 'B', 9);               
						$this->pdf->SetX(20);
						$this->pdf->Cell(30, 6, "", '0', 0, 'L', 0);
					 	$this->pdf->Cell(60, 6, "Total", '0', 0, 'R', 0);
					 	$this->pdf->Cell(10, 6, "", '0', 0, 'R', 0);
					 	$this->pdf->Cell(20, 6, number_format($tot_price,2), 'TB', 0, 'R', 0);
					 	$this->pdf->Cell(1, 6,"", '0', 0, 'R', 0);
					 	$this->pdf->Cell(19, 6, number_format($Goss[$a],2), 'TB', 0, 'R', 0);
					 	$this->pdf->Cell(1, 6, "", '0', 0, 'C', 0);
					 	$this->pdf->Cell(19, 6, number_format($tot_dis,2), 'TB', 0, 'R', 0);
					 	$this->pdf->Cell(1, 6, "", '0', 0, 'C', 0);
					 	$this->pdf->Cell(19, 6, number_format($net[$a],2), 'TB', 0, 'R', 0);

                       
/*$this->pdf->Ln();
$this->pdf->SetX(50);
			$this->pdf->SetFont('helvetica','B',8);
		 	$this->pdf->Cell(30, 1, "", '0', 0, 'L', 0);
		 	$this->pdf->Cell(80, 1, "", '0', 0, 'L', 0);
		 	$this->pdf->Cell(20, 1, "Goss", '0', 0, 'L', 0);
		 	$this->pdf->Cell(20, 1,"Rs   " .$Goss[$a], '0', 0, 'L', 0);
		 	$this->pdf->Cell(20, 1, "", '0', 0, 'L', 0);
		 
		 	$this->pdf->Ln();
$this->pdf->SetX(50);
		 	$this->pdf->Cell(30, 1, "", '0', 0, 'L', 0);
		 	$this->pdf->Cell(80, 1, "", '0', 0, 'L', 0);
		 	$this->pdf->Cell(20, 1, "Net Amount", '0', 0, 'L', 0);
		 	$this->pdf->Cell(20, 1,"Rs   ". $net[$a], '0', 0, 'L', 0);
		 	$this->pdf->Cell(20, 1, "", '0', 0, 'L', 0);
		 	
			$this->pdf->Ln();              
		 	*/


}
	
	$this->pdf->Output("Credit Sale Return Detail".date('Y-m-d').".pdf", 'I');

?>