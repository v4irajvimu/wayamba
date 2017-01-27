<?php
		error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
		$this->pdf->setPrintHeader($header,$type,$duration);
		$this->pdf->setPrintHeader(true,$type);
        $this->pdf->setPrintFooter(true);

        
        $this->pdf->SetFont('helvetica', 'B', 16);
		$this->pdf->AddPage($orientation,$page);   // L or P amd page type A4 or A3

 		foreach($branch as $ress){
			$this->pdf->headerSet4($ress->name,$ress->address,$ress->tp,$ress->fax,$ress->email);
		}

		// foreach($session as $ses){
		// 	$invoice_no=$session[0].$session[1].$session[2];
		// }

		foreach($sum as $s){
			$seettu_no=$s->nno;
			$cus_id   = $s->organizer;
			$cus_name = $s->Organizer_name;
			$date     = $s->ddate;   
			$rep_id   = $s->sales_rep;
			$rep_name = $s->salaeman_name;
			$book_no  = $s->book_no;
			$book_edition  = $s->book_edition;
			$address=$s->address1.",  ".$s->address2.",  ".$s->address3;
		}

		$this->pdf->setY(20);
		$this->pdf->SetFont('helvetica', 'BU', 12);
		$this->pdf->Ln();
		$orgin_print=$_POST['org_print'];

	  	$this->pdf->Cell(0, 5,'SEETTU HISTORY',0,false, 'L', 0, '', 0, false, 'M', 'M');
	  	
	 	$this->pdf->SetFont('helvetica', '', 11);
	 	$this->pdf->setY(25);
	 	$this->pdf->Ln();

	 	
		$this->pdf->SetFont('helvetica', 'B', 11);

	 	$this->pdf->Cell(20, 1,"Seettu No.", '0', 0, 'L', 0);
	 	$this->pdf->Cell(5, 1, ':	', '0', 0, 'L', 0);

	 	$this->pdf->SetFont('helvetica', '', 11);
	 	$this->pdf->Cell(40, 1, $seettu_no, '0', 0, 'L', 0);
	 	$this->pdf->Cell(30, 1, "", '0', 0, 'L', 0);

	 	$this->pdf->SetFont('helvetica', 'B', 11);
	 	$this->pdf->Cell(20, 1, "Date ", '0', 0, 'L', 0);
	 	$this->pdf->Cell(5, 1, ':	', '0', 0, 'L', 0);

	 	$this->pdf->SetFont('helvetica', '', 11);
	 	$this->pdf->Cell(60, 1,$date, '0', 0, 'L', 0);

	 	$this->pdf->Ln();
	 	$this->pdf->SetFont('helvetica', 'B', 11);
	 	$this->pdf->Cell(20, 1, 'Salesman', '0', 0, 'L', 0);
	 	$this->pdf->Cell(5, 1, ':	', '0', 0, 'L', 0);

	 	$this->pdf->SetFont('helvetica', '', 11);
	 	$this->pdf->Cell(40, 1, $rep_id." - ".$rep_name, '0', 0, 'L', 0);
	 	$this->pdf->Cell(30, 1, "", '0', 0, 'L', 0);

	 	$this->pdf->SetFont('helvetica', 'B', 11);
	 	$this->pdf->Cell(20, 1, 'Book No', '0', 0, 'L', 0);
	 	$this->pdf->Cell(5, 1, ':	', '0', 0, 'L', 0);

	 	$this->pdf->SetFont('helvetica', '', 11);
	 	$this->pdf->Cell(40, 1, $book_no." - ".$book_edition , '0', 0, 'L', 0);
	 	$this->pdf->Cell(30, 1, "", '0', 0, 'L', 0);

	 	$this->pdf->Ln();

	 	$this->pdf->SetFont('helvetica', 'B', 11);
	 	$this->pdf->Cell(20, 1,"Organizer", '0', 0, 'L', 0);
	 	$this->pdf->Cell(5, 1, ':	', '0', 0, 'L', 0);

	 	$this->pdf->SetFont('helvetica', '', 11);
	 	$this->pdf->Cell(40, 1,$cus_id." 	- 	".$cus_name, '0', 0, 'L', 0);
	 	$this->pdf->Cell(30, 1, "", '0', 0, 'L', 0);

	 	$this->pdf->Ln();

	 	$this->pdf->SetFont('helvetica', 'B', 11);
	 	$this->pdf->Cell(20, 1, "Address", '0', 0, 'L', 0);
	 	$this->pdf->Cell(5, 1, ':'	, '0', 0, 'L', 0);

	 	$this->pdf->SetFont('helvetica', '', 11);
	 	$this->pdf->Cell(60, 1, $address, '0', 0, 'L', 0);
	 	$this->pdf->Ln();
	 	$this->pdf->Ln();
	 	
	 	
		$this->pdf->SetY(55);
		$this->pdf->SetX(16);
		$x=$z=$a=1;
		foreach($det as $row){
			if($x==1){	// Category summery 

				$this->pdf->SetX(16);
				$this->pdf->SetFont('helvetica', 'B',9);
				$this->pdf->SetLineStyle(array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0.1, 'color' => array(0, 0, 0)));
				
				// Headings-------------------------------------

				$this->pdf->Cell(15, 6,"No.", '1', 0, 'C', 0);
				$this->pdf->Cell(30, 6,"Seettu Item", '1', 0, 'C', 0);
				$this->pdf->Cell(55, 6,"Description", '1', 0, 'C', 0);
				$this->pdf->Cell(25, 6,"Value", '1', 0, 'C', 0);
				$this->pdf->Cell(20, 6,"No. of Ins.", '1', 0, 'C', 0);
				$this->pdf->Cell(20, 6,"Installment", '1', 0, 'C', 0);
				$this->pdf->Ln();


    			// Deatils loop---------------------------------
	        	
	        	$this->pdf->GetY();
	            $this->pdf->SetX(16);
	        	$aa = $this->pdf->getNumLines($row->discription, 55);
		        $heigh=5*$aa;
	        	$this->pdf->SetLineStyle(array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0.1, 'color' => array(0, 0, 0)));

	           

				$this->pdf->SetFont('helvetica','',9);

				$this->pdf->MultiCell(15, $heigh, $a, 1, 'R', 0, 0, '', '', true, 0, false, true, 0);
				$this->pdf->MultiCell(30, $heigh, $row->item_cat, 1, 'L', 0, 0, '', '', true, 0, false, true, 0);
				$this->pdf->MultiCell(55, $heigh, $row->discription, 1, 'L', 0, 0, '', '', true, 0, false, true, 0);
				$this->pdf->MultiCell(25, $heigh, number_format($row->value,2), 1, 'R', 0, 0, '', '', true, 0, false, true, 0);
				$this->pdf->MultiCell(20, $heigh, $row->no_ins, 1, 'R', 0, 0, '', '', true, 0, false, true, 0);
				$this->pdf->MultiCell(20, $heigh, number_format($row->ins_amount,2), 1, 'R', 0, 1, '', '', true, 0, false, true, 0);
				

				$this->pdf->Ln();
				$this->pdf->SetX(31);
	        	$this->pdf->SetLineStyle(array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0.1, 'color' => array(0, 0, 0)));
				$this->pdf->SetFont('helvetica','B',10);
	        	$this->pdf->Cell(40, 6, "Category Code :	".$row->item_cat, '0', 0, 'L', 0);
	        	$this->pdf->Ln();

	        	$this->pdf->SetX(31);
				//$this->pdf->GetY(60);
		    	$this->pdf->SetFont('helvetica','B',9);
		    	$this->pdf->MultiCell(15, 6, "No.", $border=1, $align='C', $fill=false, $ln=0, $x=($this->pdf->GetX()), $y=$this->pdf->GetY(), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=6, $valign='M', $fitcell=true);
				$this->pdf->MultiCell(30, 6, "Item Code", $border=1, $align='C', $fill=false, $ln=0, $x=($this->pdf->GetX()), $y=$this->pdf->GetY(), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=6, $valign='M', $fitcell=true);
		        $this->pdf->MultiCell(60, 6, "Item Name", $border=1, $align='C', $fill=false, $ln=0, $x=($this->pdf->GetX()), $y=$this->pdf->GetY(), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=6, $valign='M', $fitcell=true);
		        $this->pdf->MultiCell(25, 6, "Quantity", $border=1, $align='C', $fill=false, $ln=0, $x=($this->pdf->GetX()), $y=$this->pdf->GetY(), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=6, $valign='M', $fitcell=true);
		        $this->pdf->MultiCell(20, 6, "Unit Price", $border=1, $align='C', $fill=false, $ln=0, $x=($this->pdf->GetX()), $y=$this->pdf->GetY(), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=6, $valign='M', $fitcell=true);
		        $this->pdf->Ln();

		        $d_item_cat=$row->item_cat;

		        $this->pdf->SetX(31);
				//$this->pdf->GetY(60);
		    	$this->pdf->SetFont('helvetica','',9);
		        $this->pdf->MultiCell(15, $heigh, $z, 1, 'R', 0, 0, '', '', true, 0, false, true, 0);
			 	$this->pdf->MultiCell(30, $heigh, $row->item_code, 1, 'L', 0, 0, '', '', true, 0, false, true, 0);
			 	$this->pdf->MultiCell(60, $heigh, $row->dis, 1, 'L', 0, 0, '', '', true, 0, false, true, 0);
			 	$this->pdf->MultiCell(25, $heigh, $row->qty, 1, 'R', 0, 0, '', '', true, 0, false, true, 0);
			 	$this->pdf->MultiCell(20, $heigh, $row->item_max_price, 1, 'R', 0, 1, '', '', true, 0, false, true, 0);
				$item_code=$row->code;

		        $x++;
				$a++;
				$z++;
			}
			else{
				
				$item_code=$row->code;
				
				if($d_item_cat==$item_code){	//display Items in detail
					$this->pdf->SetX(31);
					//$this->pdf->GetY(60);
			    	$this->pdf->SetFont('helvetica','',9);
			        $this->pdf->MultiCell(15, $heigh, $z, 1, 'R', 0, 0, '', '', true, 0, false, true, 0);
				 	$this->pdf->MultiCell(30, $heigh, $row->item_code, 1, 'L', 0, 0, '', '', true, 0, false, true, 0);
				 	$this->pdf->MultiCell(60, $heigh, $row->dis, 1, 'L', 0, 0, '', '', true, 0, false, true, 0);
				 	$this->pdf->MultiCell(25, $heigh, $row->qty, 1, 'R', 0, 0, '', '', true, 0, false, true, 0);
				 	$this->pdf->MultiCell(20, $heigh, $row->item_max_price, 1, 'R', 0, 1, '', '', true, 0, false, true, 0);
					$z++;
					//$a++;

					$d_item_cat=$row->item_cat;
				}

				elseif ($d_item_cat!=$item_code) {
					
				$this->pdf->Ln();
				$z=$z-1;

				$this->pdf->SetFont('helvetica','B',9);
				$this->pdf->MultiCell(167, $heigh, "No. of Items :	".$z, 0, 'R', 0, 1, '', '', true, 0, false, true, 0);
				//$a=1;
				$z=1;
				$this->pdf->Ln();
				$this->pdf->Ln();

				$this->pdf->SetX(16);
				$this->pdf->SetFont('helvetica', 'B',9);
				$this->pdf->SetLineStyle(array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0.1, 'color' => array(0, 0, 0)));
				
				// Headings-------------------------------------

				$this->pdf->Cell(15, 6,"No.", '1', 0, 'C', 0);
				$this->pdf->Cell(30, 6,"Seettu Item", '1', 0, 'C', 0);
				$this->pdf->Cell(55, 6,"Description", '1', 0, 'C', 0);
				$this->pdf->Cell(25, 6,"Value", '1', 0, 'C', 0);
				$this->pdf->Cell(20, 6,"No. of Ins.", '1', 0, 'C', 0);
				$this->pdf->Cell(20, 6,"Installment", '1', 0, 'C', 0);
				$this->pdf->Ln();


    			// Deatils loop---------------------------------
	        	
	        	$this->pdf->GetY();
	            $this->pdf->SetX(16);
	        	$aa = $this->pdf->getNumLines($row->discription, 55);
		        $heigh=5*$aa;
	        	$this->pdf->SetLineStyle(array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0.1, 'color' => array(0, 0, 0)));

	           

				$this->pdf->SetFont('helvetica','',9);

				$this->pdf->MultiCell(15, $heigh, $a, 1, 'R', 0, 0, '', '', true, 0, false, true, 0);
				$this->pdf->MultiCell(30, $heigh, $row->item_cat, 1, 'L', 0, 0, '', '', true, 0, false, true, 0);
				$this->pdf->MultiCell(55, $heigh, $row->discription, 1, 'L', 0, 0, '', '', true, 0, false, true, 0);
				$this->pdf->MultiCell(25, $heigh, number_format($row->value,2), 1, 'R', 0, 0, '', '', true, 0, false, true, 0);
				$this->pdf->MultiCell(20, $heigh, $row->no_ins, 1, 'R', 0, 0, '', '', true, 0, false, true, 0);
				$this->pdf->MultiCell(20, $heigh, number_format($row->ins_amount,2), 1, 'R', 0, 1, '', '', true, 0, false, true, 0);
				

				$this->pdf->Ln();
				$this->pdf->SetX(31);
	        	$this->pdf->SetLineStyle(array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0.1, 'color' => array(0, 0, 0)));
				$this->pdf->SetFont('helvetica','B',10);
	        	$this->pdf->Cell(40, 6, "Category Code :	".$row->item_cat, '0', 0, 'L', 0);
	        	$this->pdf->Ln();

	        	$this->pdf->SetX(31);
				//$this->pdf->GetY(60);
		    	$this->pdf->SetFont('helvetica','B',9);
		    	$this->pdf->MultiCell(15, 6, "No.", $border=1, $align='C', $fill=false, $ln=0, $x=($this->pdf->GetX()), $y=$this->pdf->GetY(), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=6, $valign='M', $fitcell=true);
				$this->pdf->MultiCell(30, 6, "Item Code", $border=1, $align='C', $fill=false, $ln=0, $x=($this->pdf->GetX()), $y=$this->pdf->GetY(), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=6, $valign='M', $fitcell=true);
		        $this->pdf->MultiCell(60, 6, "Item Name", $border=1, $align='C', $fill=false, $ln=0, $x=($this->pdf->GetX()), $y=$this->pdf->GetY(), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=6, $valign='M', $fitcell=true);
		        $this->pdf->MultiCell(25, 6, "Quantity", $border=1, $align='C', $fill=false, $ln=0, $x=($this->pdf->GetX()), $y=$this->pdf->GetY(), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=6, $valign='M', $fitcell=true);
		        $this->pdf->MultiCell(20, 6, "Unit Price", $border=1, $align='C', $fill=false, $ln=0, $x=($this->pdf->GetX()), $y=$this->pdf->GetY(), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=6, $valign='M', $fitcell=true);
		        $this->pdf->Ln();

		        $d_item_cat=$row->item_cat;

		        $this->pdf->SetX(31);
				//$this->pdf->GetY(60);
		    	$this->pdf->SetFont('helvetica','',9);
		        $this->pdf->MultiCell(15, $heigh, $z, 1, 'R', 0, 0, '', '', true, 0, false, true, 0);
			 	$this->pdf->MultiCell(30, $heigh, $row->item_code, 1, 'L', 0, 0, '', '', true, 0, false, true, 0);
			 	$this->pdf->MultiCell(60, $heigh, $row->dis, 1, 'L', 0, 0, '', '', true, 0, false, true, 0);
			 	$this->pdf->MultiCell(25, $heigh, $row->qty, 1, 'R', 0, 0, '', '', true, 0, false, true, 0);
			 	$this->pdf->MultiCell(20, $heigh, $row->item_max_price, 1, 'R', 0, 1, '', '', true, 0, false, true, 0);
				$item_code=$row->code;

		        $x++;
				$a++;
				$z++;
				}
			}
		}

			$z=$z-1;
			$a=$a-1;
			$this->pdf->Ln();
			$this->pdf->SetFont('helvetica','B',9);
			$this->pdf->MultiCell(167, 6, "No. of Items :	".$z, 0, 'R', 0, 1, '', '', true, 0, false, true, 0);
				
			$this->pdf->Ln();
			$this->pdf->SetFont('helvetica','B',9);
			$this->pdf->MultiCell(100, 6, "No. of Customers :	".$a, 0, 'L', 0, 1, '', '', true, 0, false, true, 0);
			
		
		$this->pdf->Output("Settu_History".date('Y-m-d').".pdf", 'I');
    	//}

?>