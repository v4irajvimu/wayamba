<?php
error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
//$this->pdf->setPrintHeader($header,$type,$duration);

$this->pdf->setPrintFooter(true);
$this->pdf->setPrintHeader(true);
$this->pdf->setPrintHeader($header,$type); 

$this->pdf->SetFont('helvetica', 'B', 16);
		$this->pdf->AddPage($orientation,$page);   // L or P amd page type A4 or A3

		$free_total =(float)0;

		foreach($free_tot as $row){
			$free_total=$row->free;
		}

		
		foreach($branch as $ress){

			$this->pdf->headerSet4($ress->name,$ress->address,$ress->tp,$ress->fax,$ress->email);
		}
		$cus_name=$cus_address="";
		foreach($customer as $cus){
			$cus_name=$cus->name;
			$cus_address=$cus->address1." ".$cus->address2." ".$cus->address3;
			$cus_id=$cus->code;
		}

		foreach($session as $ses){
			$invoice_no=$session[0].$session[1].$session[2];
		}

		$this->pdf->setY(20);

		$this->pdf->SetFont('helvetica', 'BU', 10);
		 	//$this->pdf->Cell(50, 1, $r_type.' SALES INVOICE', '0', 0, 'L', 0); 
		$orgin_print=$_POST['org_print'];
		if($orgin_print=="1"){
			$this->pdf->Cell(0, 5,'HP RETURN NOTE',0,false, 'C', 0, '', 0, false, 'M', 'M');
		}else{
			$this->pdf->Cell(0, 5,'HP RETURN NOTE (Duplicate) ',0,false, 'C', 0, '', 0, false, 'M', 'M');
		}

		$this->pdf->SetFont('helvetica', '', 8);
		$this->pdf->setY(30);
		$this->pdf->Cell(30, 1, 'HP Return No.', '0', 0, 'L', 0);
		$this->pdf->Cell(30, 1, $invoice_no, '0', 0, 'L', 0);
		$this->pdf->Cell(10, 1, "", '0', 0, 'L', 0);
		$this->pdf->Cell(30, 1, "", '0', 0, 'L', 0);
		$this->pdf->Cell(60, 1, "Bill to Customer", '0', 0, 'L', 0);
		$this->pdf->Ln();

		$this->pdf->Cell(30, 1, 'Agreement No', '0', 0, 'L', 0);
		$this->pdf->Cell(30, 1, $agr_no, '0', 0, 'L', 0);
		$this->pdf->Cell(10, 1, "", '0', 0, 'L', 0);
		$this->pdf->Cell(30, 1, "", '0', 0, 'L', 0);
		$this->pdf->Cell(30, 1, "Name", '0', 0, 'L', 0);
		$this->pdf->Cell(30, 1, $cus_name, '0', 0, 'L', 0);
		$this->pdf->Ln();

		$this->pdf->Cell(30, 1, 'Invoice Date', '0', 0, 'L', 0);
		$this->pdf->Cell(30, 1, $dt, '0', 0, 'L', 0);
		$this->pdf->Cell(10, 1, "", '0', 0, 'L', 0);
		$this->pdf->Cell(30, 1, "", '0', 0, 'L', 0);
		$this->pdf->Cell(30, 1, "ID No", '0', 0, 'L', 0);
		$this->pdf->Cell(30, 1, $cus_id, '0', 0, 'L', 0);
		$this->pdf->Ln();

		$this->pdf->Cell(30, 1, '', '0', 0, 'L', 0);
		$this->pdf->Cell(30, 1, "", '0', 0, 'L', 0);
		$this->pdf->Cell(10, 1, "", '0', 0, 'L', 0);
		$this->pdf->Cell(30, 1, "", '0', 0, 'L', 0);
		$this->pdf->Cell(30, 1, "Ref Bill No", '0', 0, 'L', 0);
		$this->pdf->Cell(30, 1, $qno, '0', 0, 'L', 0);
		$this->pdf->Ln();

		$this->pdf->Cell(30, 1, '', '0', 0, 'L', 0);
		$this->pdf->Cell(30, 1, "", '0', 0, 'L', 0);
		$this->pdf->Cell(10, 1, "", '0', 0, 'L', 0);
		$this->pdf->Cell(30, 1, "", '0', 0, 'L', 0);
		$this->pdf->Cell(30, 1, "Ref Bill Date", '0', 0, 'L', 0);
		$this->pdf->Cell(30, 1, $dt, '0', 0, 'L', 0);



		$this->pdf->Ln();
		$this->pdf->SetY(55);
		$this->pdf->SetFont('helvetica','B',8);
		$this->pdf->Cell(10, 6,"HPR.", '1', 0, 'C', 0);
		$this->pdf->Cell(25, 6,"Item Code", '1', 0, 'C', 0);
		$this->pdf->Cell(55, 6,"Description", '1', 0, 'C', 0);
		$this->pdf->Cell(25, 6,"Model", '1', 0, 'C', 0);
		$this->pdf->Cell(15, 6,"Qty", '1', 0, 'C', 0);
		$this->pdf->Cell(20, 6,"Unit Price", '1', 0, 'C', 0);
		$this->pdf->Cell(20, 6,"Discount", '1', 0, 'C', 0);
		$this->pdf->Cell(20, 6,"Net Value", '1', 0, 'C', 0);
		$this->pdf->Ln();



		$x=1;
		$code="default";


		foreach($items as $row){


			$this->pdf->SetLineStyle(array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0.1, 'color' => array(0, 0, 0)));


			if($code!='default' && $code==$row->code)
			{
				if($row->sub_item!="")
				{	
					$this->pdf->SetFont('helvetica','',7);
					$this->pdf->Cell(10, 6,"", '1', 0, 'C', 0);
					$this->pdf->Cell(25, 6,$row->sub_item, '1', 0, 'L', 0);
					$this->pdf->Cell(55, 6,$row->des, '1', 0, 'L', 0);
					$this->pdf->Cell(25, 6,"", '1', 0, 'C', 0);
					$this->pdf->Cell(15, 6,$row->sub_qty, '1', 0, 'R', 0);
					$this->pdf->Cell(20, 6,"", '1', 0, 'R', 0);
					$this->pdf->Cell(20, 6,"", '1', 0, 'R', 0);
					$this->pdf->Cell(20, 6,"", '1', 0, 'R', 0);
					$this->pdf->Ln();
					$x=$x-1;
				}

			}
			else
			{

				$this->pdf->GetY();
				$this->pdf->SetFont('helvetica','B',7);
				$this->pdf->Cell(10, 6,$x, '1', 0, 'C', 0);
				$this->pdf->Cell(25, 6,$row->code, '1', 0, 'L', 0);
				$this->pdf->Cell(55, 6,$row->description, '1', 0, 'L', 0);
				$this->pdf->Cell(25, 6,$row->model, '1', 0, 'C', 0);
				$this->pdf->Cell(15, 6,$row->qty, '1', 0, 'R', 0);
				$this->pdf->Cell(20, 6,number_format($row->price,2), '1', 0, 'R', 0);
				$this->pdf->Cell(20, 6,number_format($row->discount,2), '1', 0, 'R', 0);
				$this->pdf->Cell(20, 6,number_format($row->amount,2), '1', 0, 'R', 0);
				$this->pdf->Ln();


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

					$this->pdf->SetFont('helvetica','',7);
					$aa = $this->pdf->getNumLines($all_serial, 55);
					$heigh=5*$aa;

					$this->pdf->MultiCell(10, $heigh, "", 1, 'L', 0, 0, '', '', true, 0, false, true, 0);
					$this->pdf->MultiCell(25, $heigh, "", 1, 'L', 0, 0, '', '', true, 0, false, true, 0);
					$this->pdf->MultiCell(55, $heigh, $all_serial, 1, 'L', 0, 0, '', '', true, 0, false, true, 0);
					$this->pdf->MultiCell(25, $heigh, "", 1, 'L', 0, 0, '', '', true, 0, false, true, 0);
					$this->pdf->MultiCell(15, $heigh, "", 1, 'L', 0, 0, '', '', true, 0, false, true, 0);
					$this->pdf->MultiCell(20, $heigh, "", 1, 'L', 0, 0, '', '', true, 0, false, true, 0);
					$this->pdf->MultiCell(20, $heigh, "", 1, 'L', 0, 0, '', '', true, 0, false, true, 0);
					$this->pdf->MultiCell(20, $heigh, "", 1, 'L', 0, 0, '', '', true, 0, false, true, 0);
					$this->pdf->Ln();




					if($row->sub_item!="")
					{
						$this->pdf->SetFont('helvetica','',7);
						$this->pdf->Cell(10, 6,"", '1', 0, 'C', 0);
						$this->pdf->Cell(25, 6,$row->sub_item, '1', 0, 'L', 0);
						$this->pdf->Cell(55, 6,$row->des, '1', 0, 'L', 0);
						$this->pdf->Cell(25, 6,"", '1', 0, 'C', 0);
						$this->pdf->Cell(15, 6,$row->sub_qty, '1', 0, 'R', 0);
						$this->pdf->Cell(20, 6,"", '1', 0, 'R', 0);
						$this->pdf->Cell(20, 6,"", '1', 0, 'R', 0);
						$this->pdf->Cell(20, 6,"", '1', 0, 'R', 0);
						$this->pdf->Ln();
					}
				}else{




					if($row->sub_item!="")
					{
						$this->pdf->SetFont('helvetica','',7);
						$this->pdf->Cell(10, 6,"", '1', 0, 'C', 0);
						$this->pdf->Cell(25, 6,$row->sub_item, '1', 0, 'L', 0);
						$this->pdf->Cell(55, 6,$row->des, '1', 0, 'L', 0);
						$this->pdf->Cell(25, 6,"", '1', 0, 'C', 0);
						$this->pdf->Cell(15, 6,$row->sub_qty, '1', 0, 'R', 0);
						$this->pdf->Cell(20, 6,"", '1', 0, 'R', 0);
						$this->pdf->Cell(20, 6,"", '1', 0, 'R', 0);
						$this->pdf->Cell(20, 6,"", '1', 0, 'R', 0);
						$this->pdf->Ln();
					}



				}
			}

			$code=$row->code;
			$x++;
		}

		$this->pdf->sales_return($employee,$amount,$additional,$discount,$user,$free_total);

		$this->pdf->Output("HP Return_".date('Y-m-d').".pdf", 'I');

		?>