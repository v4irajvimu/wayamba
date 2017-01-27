<?php
error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
$this->pdf->setPrintHeader($header,$type,$duration);
$this->pdf->setPrintFooter(true);

$this->pdf->SetFont('helvetica', 'B', 16);
		$this->pdf->AddPage($orientation,$page);   // L or P amd page type A4 or A3

		foreach($branch as $ress){
			$this->pdf->headerSet3($ress->name,$ress->address,$ress->tp,$ress->fax,$ress->email);
		}

		foreach ($category as $cat){
			$code=$cat->code;
			$des=$cat->description;
		}	
		


		$this->pdf->SetFont('helvetica', 'BUI',12);
		$this->pdf->Cell(0, 5, 'CASH SALES DETAILS',0,false, 'L', 0, '', 0, false, 'M', 'M');
		$this->pdf->Ln(); 

		$this->pdf->SetFont('helvetica', '',9);
		$this->pdf->Cell(0, 5, 'Date Between '. $dfrom.' and '.$dto ,0,false, 'L', 0, '', 0, false, 'M', 'M');
		$this->pdf->Ln();


		if($category_field!="0"){

			$this->pdf->SetFont('helvetica', 'B',8);
			$this->pdf->Cell(0, 6,"Category : ".$code." - ".$des, '0', 0, 'L', 0);
			$this->pdf->Ln();

		}

		/*$i=0;
		$a=-1;
		static $j=0;
		$my_array=array();
		$Goss=array();
		$net=array();

		foreach ($purchase as $value) {
			$my_array[]=$value->nno;

		}

		foreach ($sum as $sum){
			$Goss[]=$sum->gsum;
			$net[]=$sum->nsum;
			$addi[]=$sum->addi; 
			$a++;
		}*/

		$invoice_no = "";
		$x=0;

		foreach($purchase as $value){
			if($value->nno != $invoice_no){

				$heigh=6*(max(1,$this->pdf->getNumLines($value->description,68)));
				$this->pdf->HaveMorePages($heigh);

				if($x!=0){
					$this->pdf->Ln(3);

					$this->pdf->SetFont('helvetica','B',8);
					$this->pdf->Cell(40, 1, "", '0', 0, 'L', 0);
					$this->pdf->Cell(85, 1, "", '0', 0, 'L', 0);
					$this->pdf->Cell(35, 1, "Total Goss Rs", '0', 0, 'L', 0);
					$this->pdf->Cell(20, 1,number_format($gross,2), '0', 0, 'R', 0);
					$this->pdf->Ln();
					$this->pdf->HaveMorePages(6);

					$this->pdf->Cell(40, 1, "", '0', 0, 'L', 0);
					$this->pdf->Cell(85, 1, "", '0', 0, 'L', 0);
					$this->pdf->Cell(35, 1, "Additional Rs", '0', 0, 'L', 0);
					$this->pdf->Cell(20, 1,number_format($addi,2), '0', 0, 'R', 0);
					$this->pdf->Ln();
					$this->pdf->HaveMorePages(6);
					$this->pdf->Cell(40, 1, "", '0', 0, 'L', 0);
					$this->pdf->Cell(85, 1, "", '0', 0, 'L', 0);
					$this->pdf->Cell(35, 1, "Total Net Amount    Rs", '0', 0, 'L', 0);
					$this->pdf->Cell(20, 1,number_format($net+$addi,2),'0', 0, 'R', 0);
					$this->pdf->Ln();
					$this->pdf->Ln();
				}

				$x=1;
				$gross=0;
				$discount=0;
				$net =0;
				$addi =0;

				
				$this->pdf->Ln();
				$this->pdf->SetX(16);
				$this->pdf->SetFont('helvetica','B',8);
				$this->pdf->Cell(20, 1, 'INV No - ', '0', 0, 'L', 0);
				$this->pdf->SetFont('helvetica','',8);
				$this->pdf->Cell(100, 1, $value->nno, '0', 0, 'L', 0);
				$this->pdf->SetFont('helvetica','B',8);
				$this->pdf->Cell(20, 1, "Rep", '0', 0, 'L', 0);
				$this->pdf->SetFont('helvetica','',8);
				$this->pdf->Cell(50, 1, $value->rep_id." | ".$value->rep, '0', 0, 'L', 0);
				$this->pdf->Ln();
				$this->pdf->SetX(16);
				$this->pdf->SetFont('helvetica','B',8);
				$this->pdf->Cell(20, 1, "Date - ", '0', 0, 'L', 0);
				$this->pdf->SetFont('helvetica','',8);
				$this->pdf->Cell(100, 1, $value->ddate, '0', 0, 'L', 0);
				$this->pdf->SetFont('helvetica','B',8);
				$this->pdf->Cell(20, 1, "Store", '0', 0, 'L', 0);
				$this->pdf->SetFont('helvetica','',8);
				$this->pdf->Cell(20, 1, $value->store, '0', 0, 'L', 0);
				

				$this->pdf->Ln();
				$this->pdf->SetX(16);
				$this->pdf->SetFont('helvetica','B',8);
				$this->pdf->Cell(20, 1, "Customer - ", '0', 0, 'L', 0);
				$this->pdf->SetFont('helvetica','',8);
				$this->pdf->Cell(50, 1,$value->cus_id." | ".$value->name, '0', 0, 'L', 0);
				$this->pdf->Cell(20, 1, "", '0', 0, 'L', 0);
				$this->pdf->Cell(20, 1, "", '0', 0, 'L', 0);
				$this->pdf->Cell(20, 1, "", '0', 0, 'L', 0);
				$this->pdf->Ln(5);

				$this->pdf->SetFont('helvetica','B',8);
				$this->pdf->Cell(30, 6,"Item Code", '1', 0, 'C', 0);
				$this->pdf->Cell(60, 6,"Description", '1', 0, 'C', 0);
				$this->pdf->Cell(10, 6,"Qty", '1', 0, 'C', 0);
				$this->pdf->Cell(20, 6,"Price", '1', 0, 'C', 0);
				$this->pdf->Cell(20, 6,"Gross", '1', 0, 'C', 0);
				$this->pdf->Cell(20, 6,"Discount", '1', 0, 'C', 0);
				$this->pdf->Cell(20, 6,"Amount", '1', 0, 'C', 0);
				$this->pdf->Ln();
				$this->pdf->SetFont('helvetica','',8);
				$this->pdf->SetLineStyle(array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0.1, 'color' => array(0, 0, 0)));
				$this->pdf->MultiCell(30, $heigh,$value->code,1, 'L',false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
				$this->pdf->MultiCell(60, $heigh,$value->description,1, 'L',false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
				$this->pdf->MultiCell(10, $heigh,$value->qty,1, 'R',false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
				$this->pdf->MultiCell(20, $heigh,$value->price,1, 'R',false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
				$this->pdf->MultiCell(20, $heigh,$value->gross_amount,1, 'R',false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
				$this->pdf->MultiCell(20, $heigh,$value->discount,1, 'R',false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
				$this->pdf->MultiCell(20, $heigh,$value->net_amount,1, 'R',false, 1, '', '', true, 0, false, true, $heigh,'M' ,false);
				$this->pdf->SetLineStyle(array('width' => 0.3, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0.1, 'color' => array(0, 0, 0)));

				$gross+= (float) $value->gross_amount;
				$discount+=(float) $value->discount;
				$addi =(float)$value->addi;
				$net +=(float)$value->net_amount;
				

			}else{
				$this->pdf->SetFont('helvetica','',8);
				$this->pdf->SetLineStyle(array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0.1, 'color' => array(0, 0, 0)));
				$this->pdf->MultiCell(30, $heigh,$value->code,1, 'L',false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
				$this->pdf->MultiCell(60, $heigh,$value->description,1, 'L',false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
				$this->pdf->MultiCell(10, $heigh,$value->qty,1, 'R',false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
				$this->pdf->MultiCell(20, $heigh,$value->price,1, 'R',false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
				$this->pdf->MultiCell(20, $heigh,$value->gross_amount,1, 'R',false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
				$this->pdf->MultiCell(20, $heigh,$value->discount,1, 'R',false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
				$this->pdf->MultiCell(20, $heigh,$value->net_amount,1, 'R',false, 1, '', '', true, 0, false, true, $heigh,'M' ,false);
				$this->pdf->SetLineStyle(array('width' => 0.3, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0.1, 'color' => array(0, 0, 0)));

				$gross+= (float) $value->gross_amount;
				$discount+=(float) $value->discount;
				$addi =(float)$value->addi;
				$net +=(float)$value->net_amount;


				
				

			}
			$invoice_no = $value->nno;
		}
		$this->pdf->SetFont('helvetica','B',8);
		$this->pdf->Ln(3);
		$this->pdf->Cell(40, 1, "", '0', 0, 'L', 0);
		$this->pdf->Cell(85, 1, "", '0', 0, 'L', 0);
		$this->pdf->Cell(35, 1, "Total Goss Rs", '0', 0, 'L', 0);
		$this->pdf->Cell(20, 1,number_format($gross,2), '0', 0, 'R', 0);
		$this->pdf->Ln();
		$this->pdf->HaveMorePages(6);
		$this->pdf->Cell(40, 1, "", '0', 0, 'L', 0);
		$this->pdf->Cell(85, 1, "", '0', 0, 'L', 0);
		$this->pdf->Cell(35, 1, "Additional Rs", '0', 0, 'L', 0);
		$this->pdf->Cell(20, 1,number_format($addi,2), '0', 0, 'R', 0);
		$this->pdf->Ln();
		$this->pdf->HaveMorePages(6);
		$this->pdf->Cell(40, 1, "", '0', 0, 'L', 0);
		$this->pdf->Cell(85, 1, "", '0', 0, 'L', 0);
		$this->pdf->Cell(35, 1, "Total Net Amount    Rs", '0', 0, 'L', 0);
		$this->pdf->Cell(20, 1,number_format($net+$addi,2),'0', 0, 'R', 0);
		$this->pdf->Ln();
		$this->pdf->Ln();

			/*foreach ($purchase as $value) {	
				if ($i==0 || $my_array[$i]!=$my_array[$i-1]) {

					if ($j>=1) {
						$this->pdf->Ln(3);
						$this->pdf->HaveMorePages(6);
						$this->pdf->SetFont('helvetica','B',8);
						$this->pdf->SetX(5);
						$this->pdf->Cell(40, 1, "", '0', 0, 'L', 0);
						$this->pdf->Cell(100, 1, "", '0', 0, 'L', 0);
						$this->pdf->Cell(35, 1, "Total Goss               Rs", '0', 0, 'L', 0);
						$this->pdf->Cell(20, 1,$Goss[$j], '0', 0, 'R', 0);
						$this->pdf->Cell(20, 1, "", '0', 0, 'L', 0);

						$this->pdf->Ln();
						$this->pdf->HaveMorePages(6);
						$this->pdf->SetX(5);
						$this->pdf->Cell(40, 1, "", '0', 0, 'L', 0);
						$this->pdf->Cell(100, 1, "", '0', 0, 'L', 0);
						$this->pdf->Cell(35, 1, "Additional                Rs", '0', 0, 'L', 0);
						$this->pdf->Cell(20, 1,$addi[$j], '0', 0, 'R', 0);
						$this->pdf->Cell(20, 1, "", '0', 0, 'L', 0);
						$this->pdf->Ln();

						$this->pdf->HaveMorePages(6);
						$this->pdf->SetX(5);
						$this->pdf->Cell(40, 1, "", '0', 0, 'L', 0);
						$this->pdf->Cell(100, 1, "", '0', 0, 'L', 0);
						$this->pdf->Cell(35, 1, "Total Net Amount    Rs", '0', 0, 'L', 0);
						$this->pdf->Cell(20, 1,$net[$j], '0', 0, 'R', 0);
						$this->pdf->Cell(20, 1, "", '0', 0, 'L', 0);

						$this->pdf->Ln(3); 		 	
						$this->pdf->Cell(0,0,"",array('B' => array('dash' => 2),));$this->pdf->SetLineStyle(array('dash' => 0));	 	
						$this->pdf->Ln(); $this->pdf->Ln(); 
					}
					
					$j++;

					$this->pdf->SetFont('helvetica', '', 8);
				

					$this->pdf->HaveMorePages(6*5);
					$this->pdf->SetX(16);
					$this->pdf->Cell(30, 1, 'INV No - ', '0', 0, 'L', 0);
					$this->pdf->Cell(100, 1, $value->nno, '0', 0, 'L', 0);
					$this->pdf->Cell(20, 1, "Rep", '0', 0, 'L', 0);
					$this->pdf->Cell(20, 1, $value->rep_id." | ".$value->rep, '0', 0, 'L', 0);

					$this->pdf->Ln();
					$this->pdf->SetX(16);
					$this->pdf->Cell(30, 1, "Date - ", '0', 0, 'L', 0);
					$this->pdf->Cell(100, 1, $value->ddate, '0', 0, 'L', 0);
					$this->pdf->Cell(20, 1, "Store", '0', 0, 'L', 0);
					$this->pdf->Cell(20, 1, $value->store, '0', 0, 'L', 0);
					$this->pdf->Cell(20, 1, "", '0', 0, 'L', 0);

					$this->pdf->Ln();
					$this->pdf->SetX(16);
					$this->pdf->Cell(30, 1, "Customer - ", '0', 0, 'L', 0);
					$this->pdf->Cell(50, 1,$value->cus_id." | ".$value->name, '0', 0, 'L', 0);
					$this->pdf->Cell(20, 1, "", '0', 0, 'L', 0);
					$this->pdf->Cell(20, 1, "", '0', 0, 'L', 0);
					$this->pdf->Cell(20, 1, "", '0', 0, 'L', 0);

					$this->pdf->Ln();
					$this->pdf->Ln();


					$this->pdf->SetX(16);
					$this->pdf->SetFont('helvetica','B',8);
					$this->pdf->Cell(30, 6,"Item Code", '1', 0, 'C', 0);

					$this->pdf->Cell(60, 6,"Description", '1', 0, 'C', 0);
					$this->pdf->Cell(10, 6,"Qty", '1', 0, 'C', 0);
					$this->pdf->Cell(20, 6,"Price", '1', 0, 'C', 0);
					$this->pdf->Cell(20, 6,"Gross", '1', 0, 'C', 0);
					$this->pdf->Cell(20, 6,"Discount", '1', 0, 'C', 0);
					$this->pdf->Cell(20, 6,"Amount", '1', 0, 'C', 0);
					$this->pdf->Ln();

				}

				$this->pdf->HaveMorePages(6);
				$this->pdf->SetX(16);
				$this->pdf->SetFont('helvetica','',8);
				$this->pdf->SetLineStyle(array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0.1, 'color' => array(0, 0, 0)));
				$this->pdf->Cell(30, 6,$value->code, '1', 0, 'L', 0);

				$this->pdf->Cell(60, 6,$value->description,'1', 0, 'L', 0);
				$this->pdf->Cell(10, 6,$value->qty, '1', 0, 'R', 0);
				$this->pdf->Cell(20, 6,$value->price, '1', 0, 'R', 0);
				$this->pdf->Cell(20, 6,$value->gross_amount, '1', 0, 'R', 0);
				$this->pdf->Cell(20, 6,$value->discount, '1', 0, 'R', 0);
				$this->pdf->Cell(20, 6,$value->net_amount, '1', 0, 'R', 0);
				$this->pdf->Ln();

				$i++;

			}


			$this->pdf->Ln();
			$this->pdf->HaveMorePages(6);
			$this->pdf->SetX(31);
			$this->pdf->SetFont('helvetica','B',8);
			$this->pdf->Cell(30, 1, "", '0', 0, 'L', 0);
			$this->pdf->Cell(80, 1, "", '0', 0, 'L', 0);
			$this->pdf->Cell(35, 1, "Total Goss               Rs", '0', 0, 'L', 0);
			$this->pdf->Cell(20, 1,$Goss[$a], '0', 0, 'R', 0);
			$this->pdf->Cell(20, 1, "", '0', 0, 'L', 0);

			$this->pdf->Ln();
			$this->pdf->HaveMorePages(6);
			$this->pdf->SetX(31);
			$this->pdf->Cell(30, 1, "", '0', 0, 'L', 0);
			$this->pdf->Cell(80, 1, "", '0', 0, 'L', 0);
			$this->pdf->Cell(35, 1, "Additional                Rs", '0', 0, 'L', 0);
			$this->pdf->Cell(20, 1,$addi[$a], '0', 0, 'R', 0);
			$this->pdf->Cell(20, 1, "", '0', 0, 'L', 0);

			$this->pdf->Ln();
			$this->pdf->HaveMorePages(6);
			$this->pdf->SetX(31);
			$this->pdf->Cell(30, 1, "", '0', 0, 'L', 0);
			$this->pdf->Cell(80, 1, "", '0', 0, 'L', 0);
			$this->pdf->Cell(35, 1, "Total Net Amount    Rs", '0', 0, 'L', 0);
			$this->pdf->Cell(20, 1,$net[$a], '0', 0, 'R', 0);
			$this->pdf->Cell(20, 1, "", '0', 0, 'L', 0);

			$this->pdf->Ln();              

*/





			$this->pdf->Output("Cash Sale Detail".date('Y-m-d').".pdf", 'I');

			?>