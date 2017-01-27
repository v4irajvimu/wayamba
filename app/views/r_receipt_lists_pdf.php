<?php
error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
		$this->pdf->setPrintHeader($header,$type,$duration);
        $this->pdf->setPrintFooter(true);
       //$this->pdf->setPrintHeader(true);
        //print_r($purchase);
        $this->pdf->SetFont('helvetica', 'B', 16);
		$this->pdf->AddPage($orientation,$page);   // L or P amd page type A4 or A3

		foreach($branch as $ress){
				$this->pdf->headerSet3($ress->name,$ress->address,$ress->tp,$ress->fax,$ress->email);
			}

		


        	$this->pdf->SetFont('helvetica', 'BU',10);
			$this->pdf->Cell(0, 5, 'RECEIPTS LISTS',0,false, 'L', 0, '', 0, false, 'M', 'M');
			$this->pdf->Ln();

			$this->pdf->SetFont('helvetica', '',9);
			$this->pdf->Cell(0, 5, 'Date Between '. $dfrom.' and '.$dto ,0,false, 'L', 0, '', 0, false, 'M', 'M');
			$this->pdf->Ln();
			$i=0;
			$a=-1;
			$j=-1;
			$Goss=array();
			$net=array();
			$my_array=array();
			foreach ($purchase as $value) {
                  $my_array[]=$value->name;
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

			/*if ($j>=0) {
				$this->pdf->SetX(45);
				$this->pdf->Cell(30, 1, "", '0', 0, 'L', 0);
				$this->pdf->Cell(50, 1, "", '0', 0, 'L', 0);
				$this->pdf->Cell(20, 1, "Goss", '0', 0, 'L', 0);
				$this->pdf->Cell(20, 1, $Goss[$j], '0', 0, 'L', 0);
				$this->pdf->Cell(20, 1, "", '0', 0, 'L', 0);
		 
				$this->pdf->Ln();
				$this->pdf->SetX(45);
			 	$this->pdf->Cell(30, 1, "", '0', 0, 'L', 0);
			 	$this->pdf->Cell(50, 1, "", '0', 0, 'L', 0);
			 	$this->pdf->Cell(20, 1, "Net Amount", '0', 0, 'L', 0);
			 	$this->pdf->Cell(20, 1, $net[$j], '0', 0, 'L', 0);
			 	$this->pdf->Cell(20, 1, "", '0', 0, 'L', 0);
		 	
			$this->pdf->Ln();$this->pdf->Ln();     
			 
					}
					
				$j++;			
			*/	

		 	$this->pdf->SetFont('helvetica', 'B', 8);
		 	if ($i==0) {
		 		$this->pdf->setY(30);
		 	}
		 	$this->pdf->Ln();
				//$this->pdf->SetY(45);
		 				$this->pdf->SetX(16);
						$this->pdf->SetFont('helvetica','B',9);
                        $this->pdf->Cell(10, 6,"No", '1', 0, 'C', 0);
                        $this->pdf->Cell(20, 6,"Date", '1', 0, 'C', 0);
                         $this->pdf->Cell(50, 6,"Customer", '1', 0, 'C', 0);
						$this->pdf->Cell(50, 6,"Rep", '1', 0, 'C', 0);
                       //$this->pdf->Cell(22, 6,"Gross Amount", '1', 0, 'C', 0);
                       //$this->pdf->Cell(20, 6,"Additional", '1', 0, 'C', 0);
                       //$this->pdf->Cell(22, 6,"Discount", '1', 0, 'C', 0);
                        $this->pdf->Cell(22, 6,"Payment", '1', 0, 'C', 0);
                        $this->pdf->Cell(25, 6,"Balance", '1', 0, 'C', 0);
                        $this->pdf->Ln();


	foreach ($purchase as $value) {	
				//if ($i==0 || $my_array[$i]!=$my_array[$i-1]) {
						//$this->pdf->SetY(45);
		 				$this->pdf->SetX(16);
		 				$this->pdf->SetLineStyle(array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0.1, 'color' => array(0, 0, 0)));
						$this->pdf->SetFont('helvetica','',9);

						$cus_acc=$value->cus_acc." | ".$value->cus_name;
						$rep=$value->rep." | ".$value->emp_name;

						$aa = $this->pdf->getNumLines($cus_acc, 50);
		                $bb = $this->pdf->getNumLines($rep, 50);
		                if($aa>$bb){
		                    $heigh=5*$aa;
		                }else{
		                    $heigh=5*$bb;
		                }
                        $this->pdf->MultiCell(10,  $heigh,$value->nno,  1, 'R', 0, 0, '', '', true, 0, false, true, 0);
                        $this->pdf->MultiCell(20,  $heigh,$value->ddate,  1, 'L', 0, 0, '', '', true, 0, false, true, 0);
                        $this->pdf->MultiCell(50,  $heigh,$value->cus_acc." | ".$value->cus_name,  1, 'L', 0, 0, '', '', true, 0, false, true, 0);
						$this->pdf->MultiCell(50,  $heigh,$value->rep." | ".$value->emp_name, 1, 'L', 0, 0, '', '', true, 0, false, true, 0);
                      //$this->pdf->Cell(22, 6,$value->gross_amount, '1', 0, 'R', 0);
                      //$this->pdf->Cell(20, 6,$value->other, '1', 0, 'R', 0);
                      //$this->pdf->Cell(22, 6,$value->discount, '1', 0, 'R', 0);
                        $this->pdf->MultiCell(22,  $heigh,$value->payment, 1, 'R', 0, 0, '', '', true, 0, false, true, 0);
                        $this->pdf->MultiCell(25,  $heigh,$value->balance,  1, 'R', 0, 1, '', '', true, 0, false, true, 0);
                        
                        $i++;
                        	
                   //     }
}
   
			$this->pdf->SetFont('helvetica','B',9);
			$this->pdf->SetX(16);
			$this->pdf->Cell(10, 6, "", '0', 0, 'L', 0);
		 	$this->pdf->Cell(20, 6, "", '0', 0, 'R', 0);
		 	$this->pdf->Cell(50, 6, "", '0', 0, 'R', 0);
		 	$this->pdf->Cell(50, 6, "Total  ", '0', 0, 'C', 0);
		 	$this->pdf->Cell(22, 6, number_format($Goss[$a],2), '1', 0, 'R', 0);
		 	$this->pdf->Cell(25, 6, number_format($net[$a],2), '1', 0, 'R', 0);
		 	

		 	/*$this->pdf->Cell(50, 1, "", '0', 0, 'L', 0);
		 	$this->pdf->Cell(70, 1, "", '0', 0, 'L', 0);
		 	$this->pdf->Cell(30, 1, "Total Payment"."     Rs", '0', 0, 'L', 0);
		 	$this->pdf->Cell(20, 1, number_format($Goss[$a],2), '0', 0, 'R', 0);
		 	$this->pdf->Cell(20, 1, "", '0', 0, 'L', 0);
		 
		 	$this->pdf->Ln();
			$this->pdf->SetX(20);
		 	$this->pdf->Cell(50, 1, "", '0', 0, 'L', 0);
		 	$this->pdf->Cell(70, 1, "", '0', 0, 'L', 0);
		 	$this->pdf->Cell(30, 1, "Total Balance"."      Rs", '0', 0, 'L', 0);
		 	$this->pdf->Cell(20, 1, number_format($net[$a],2) , '0', 0, 'R', 0);
		 	$this->pdf->Cell(20, 1, "", '0', 0, 'L', 0);
		 	
			$this->pdf->Ln();*/              
		 	


}
	//$this->pdf->footerSet($employee,$amount,$additional,$discount,$user);
	$this->pdf->Output("Receipts List".date('Y-m-d').".pdf", 'I');

?>