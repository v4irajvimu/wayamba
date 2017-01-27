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
		$this->pdf->Cell(0, 5, 'CREDIT SALES DETAILS REP WISE',0,false, 'L', 0, '', 0, false, 'M', 'M');
		$this->pdf->Ln(); 

		$this->pdf->SetFont('helvetica', '',9);
		$this->pdf->Cell(0, 5, 'Date Between '. $dfrom.' and '.$dto ,0,false, 'L', 0, '', 0, false, 'M', 'M');
		$this->pdf->Ln();

		$rep_id = "";
		$x=0;

		foreach($data as $value){
			if($value->rep != $rep_id){

				$heigh=6*(max(1,$this->pdf->getNumLines($value->item,68)));
				$this->pdf->HaveMorePages($heigh);

				if($x!=0){
					$this->pdf->Ln(3);
					$this->pdf->HaveMorePages(6);
					$this->pdf->SetFont('helvetica','B',8);
					$this->pdf->Cell(50, 1, "", '0', 0, 'L', 0);
					$this->pdf->Cell(85, 1, "", '0', 0, 'L', 0);
					$this->pdf->Cell(35, 1, "Total Goss Rs", '0', 0, 'L', 0);
					$this->pdf->Cell(20, 1,number_format($gross,2), '0', 0, 'R', 0);
					$this->pdf->Ln();
					$this->pdf->HaveMorePages(6);

					$this->pdf->Cell(50, 1, "", '0', 0, 'L', 0);
					$this->pdf->Cell(85, 1, "", '0', 0, 'L', 0);
					$this->pdf->Cell(35, 1, "Additional Rs", '0', 0, 'L', 0);
					$this->pdf->Cell(20, 1,number_format($addi,2), '0', 0, 'R', 0);
					$this->pdf->Ln();
					$this->pdf->HaveMorePages(6);
					$this->pdf->Cell(50, 1, "", '0', 0, 'L', 0);
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
				$this->pdf->Cell(20, 1, "Rep", '0', 0, 'L', 0);
				$this->pdf->SetFont('helvetica','',8);
				$this->pdf->Cell(50, 1, $value->rep." | ".$value->rep_name, '0', 0, 'L', 0);
				$this->pdf->Ln(5);
				
				$this->pdf->SetFont('helvetica','B',8);
				$this->pdf->Cell(10, 6,"No", '1', 0, 'C', 0);
				$this->pdf->Cell(30, 6,"Item Code", '1', 0, 'C', 0);
				$this->pdf->Cell(60, 6,"Description", '1', 0, 'C', 0);
				$this->pdf->Cell(10, 6,"Qty", '1', 0, 'C', 0);
				$this->pdf->Cell(20, 6,"Price", '1', 0, 'C', 0);
				$this->pdf->Cell(20, 6,"Gross", '1', 0, 'C', 0);
				$this->pdf->Cell(20, 6,"Discount", '1', 0, 'C', 0);
				$this->pdf->Cell(20, 6,"Amount", '1', 0, 'C', 0);
				$this->pdf->Ln();
				$this->pdf->SetFont('helvetica','',8);
				$this->pdf->HaveMorePages(6);
				$this->pdf->SetLineStyle(array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0.1, 'color' => array(0, 0, 0)));
				$this->pdf->MultiCell(10, $heigh,$value->nno,1, 'L',false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
				$this->pdf->MultiCell(30, $heigh,$value->code,1, 'L',false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
				$this->pdf->MultiCell(60, $heigh,$value->item,1, 'L',false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
				$this->pdf->MultiCell(10, $heigh,$value->qty,1, 'R',false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
				$this->pdf->MultiCell(20, $heigh,$value->price,1, 'R',false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
				$this->pdf->MultiCell(20, $heigh,$value->gross_amount,1, 'R',false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
				$this->pdf->MultiCell(20, $heigh,$value->discount,1, 'R',false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
				$this->pdf->MultiCell(20, $heigh,$value->net_amount,1, 'R',false, 1, '', '', true, 0, false, true, $heigh,'M' ,false);
				$this->pdf->SetLineStyle(array('width' => 0.3, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0.1, 'color' => array(0, 0, 0)));

				$gross+= (float) $value->gross_amount;
				$discount+=(float) $value->discount;
				$addi =(float)$value->additional_add;
				$net +=(float)$value->net_amount;
				

			}else{
				$this->pdf->SetFont('helvetica','',8);
				$this->pdf->HaveMorePages(6);
				$this->pdf->SetLineStyle(array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0.1, 'color' => array(0, 0, 0)));
				$this->pdf->MultiCell(10, $heigh,$value->nno,1, 'L',false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
				$this->pdf->MultiCell(30, $heigh,$value->code,1, 'L',false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
				$this->pdf->MultiCell(60, $heigh,$value->item,1, 'L',false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
				$this->pdf->MultiCell(10, $heigh,$value->qty,1, 'R',false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
				$this->pdf->MultiCell(20, $heigh,$value->price,1, 'R',false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
				$this->pdf->MultiCell(20, $heigh,$value->gross_amount,1, 'R',false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
				$this->pdf->MultiCell(20, $heigh,$value->discount,1, 'R',false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
				$this->pdf->MultiCell(20, $heigh,$value->net_amount,1, 'R',false, 1, '', '', true, 0, false, true, $heigh,'M' ,false);
				$this->pdf->SetLineStyle(array('width' => 0.3, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0.1, 'color' => array(0, 0, 0)));

				$gross+= (float) $value->gross_amount;
				$discount+=(float) $value->discount+$value->additional_deduct;
				$addi =(float)$value->additional_add;
				$net +=(float)$value->net_amount;


				
				

			}

			$tot_gross+=(float)$value->gross_amount;
			$tot_net+=(float)$value->net_amount;
			$tot_disc+=(float)$value->discount+(float)$value->additional_deduct;
			$tot_add+=(float)$value->additional_add;
			$rep_id = $value->rep;
		}
		$this->pdf->SetFont('helvetica','B',8);
		$this->pdf->HaveMorePages(6);
		$this->pdf->Ln(3);
		$this->pdf->Cell(50, 1, "", '0', 0, 'L', 0);
		$this->pdf->Cell(85, 1, "", '0', 0, 'L', 0);
		$this->pdf->Cell(35, 1, "Total Goss Rs", '0', 0, 'L', 0);
		$this->pdf->Cell(20, 1,number_format($gross,2), '0', 0, 'R', 0);
		$this->pdf->Ln();
		$this->pdf->HaveMorePages(6);
		$this->pdf->Cell(50, 1, "", '0', 0, 'L', 0);
		$this->pdf->Cell(85, 1, "", '0', 0, 'L', 0);
		$this->pdf->Cell(35, 1, "Additional Rs", '0', 0, 'L', 0);
		$this->pdf->Cell(20, 1,number_format($addi,2), '0', 0, 'R', 0);
		$this->pdf->Ln();
		$this->pdf->HaveMorePages(6);
		$this->pdf->Cell(50, 1, "", '0', 0, 'L', 0);
		$this->pdf->Cell(85, 1, "", '0', 0, 'L', 0);
		$this->pdf->Cell(35, 1, "Total Net Amount    Rs", '0', 0, 'L', 0);
		$this->pdf->Cell(20, 1,number_format($net+$addi,2),'0', 0, 'R', 0);
		$this->pdf->Ln();
		$this->pdf->Ln();

		$this->pdf->SetFont('helvetica','B',10);
		$this->pdf-> HaveMorePages(5);
		$this->pdf->Ln(3);
		$this->pdf->Cell(50, 1, "", '0', 0, 'L', 0);
		$this->pdf->Cell(55, 1, "", '0', 0, 'L', 0);
		$this->pdf->Cell(50, 1, "Final Total Goss", '0', 0, 'L', 0);
		$this->pdf->Cell(5, 1, "Rs.  ", '0', 0, 'L', 0);
		$this->pdf->Cell(30, 1,number_format($tot_gross,2), '0', 0, 'R', 0);
		$this->pdf->Ln();
		$this->pdf->HaveMorePages(6);
		$this->pdf->Cell(50, 1, "", '0', 0, 'L', 0);
		$this->pdf->Cell(55, 1, "", '0', 0, 'L', 0);
		$this->pdf->Cell(50, 1, "Final Additional", '0', 0, 'L', 0);
		$this->pdf->Cell(5, 1, "Rs.  ", '0', 0, 'L', 0);
		$this->pdf->Cell(30, 1,number_format($tot_add,2), '0', 0, 'R', 0);
		$this->pdf->Ln();
		$this->pdf->HaveMorePages(6);
		$this->pdf->Cell(50, 1, "", '0', 0, 'L', 0);
		$this->pdf->Cell(55, 1, "", '0', 0, 'L', 0);
		$this->pdf->Cell(50, 1, "Final Total Net Amount", '0', 0, 'L', 0);
		$this->pdf->Cell(5, 1, "Rs.  ", '0', 0, 'L', 0);
		$this->pdf->Cell(30, 1,number_format($tot_net,2),'0', 0, 'R', 0);


		$this->pdf->Output("Cash Sale Detail".date('Y-m-d').".pdf", 'I');

		?>