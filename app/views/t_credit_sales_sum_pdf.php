<?php
error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);

$this->pdf->setPrintFooter(true,$type,$is_cur_time);
$this->pdf->setPrintHeader(true);
$this->pdf->setPrintHeader($header,$type); 


$tot_free_item=(float)0;

foreach($free_item as $free){
	$free_price = $free->price;
	$tot_free_item+=(float)$free_price;
}
		$this->pdf->SetFont('helvetica', 'B', 16);
		$this->pdf->AddPage($orientation,$page);   // L or P amd page type A4 or A3
		foreach($branch as $ress){

			$this->pdf->headerSet4($ress->name,$ress->address,$ress->tp,$ress->fax,$ress->email);
		}
		$cus_name=$cus_address="";
		foreach($customer as $cus){
			$cus_name=$cus->name;
			$cus_address=$cus->address1." ".$cus->address2." ".$cus->address3;
			$cus_id=$cus->code;
			$tp=$cus->tp;
		}

		foreach($session as $ses){
			$invoice_no=$session[0].$session[1].'CR'.$session[2];
		}

		foreach($credit_sum as $csum){
			$bname=$csum->cus_name;
			$baddress=$csum->cus_address;
			$bdo_no=$csum->do_no;
			$rcpt_no=$csum->receipt_no;
		}
		$this->pdf->Ln();
		$align_h=$this->utility->heading_align();
		$this->pdf->SetFont('helvetica', 'BU', 10);
		$orgin_print=$_POST['org_print'];
		if($orgin_print=="1"){
			$this->pdf->Cell(0, 5, $r_type.' INVOICE',0,false, $align_h, 0, '', 0, false, 'M', 'M');
		}else{
			$this->pdf->Cell(0, 5, $r_type.' INVOICE (DUPLICATE) ',0,false, $align_h, 0, '', 0, false, 'M', 'M');
		}

		$this->pdf->SetFont('helvetica', 'B', 8);
		$this->pdf->Ln();
		$this->pdf->Cell(30, 4, 'Invoice No.', '0', 0, 'L', 0);
		$this->pdf->SetFont('helvetica', '', 8);
		$this->pdf->Cell(60, 4, $invoice_no, '0', 0, 'L', 0);
		$this->pdf->SetFont('helvetica', '', 8);
		$this->pdf->Cell(5, 4, "", '0', 0, 'L', 0);
		$this->pdf->Cell(1, 4, "", '0', 0, 'L', 0);
		$this->pdf->SetFont('helvetica', 'B', 8);
		$this->pdf->Cell(60, 4, "Bill to Customer", '0', 0, 'L', 0);
		$this->pdf->Ln();

		$this->pdf->SetFont('helvetica', 'B', 8);
		$this->pdf->Cell(30, 4, 'Invoice Date', '0', 0, 'L', 0);
		$this->pdf->SetFont('helvetica', '', 8);
		$this->pdf->Cell(60, 4, $dt.$save_time, '0', 0, 'L', 0);
		$this->pdf->Cell(5, 4, "", '0', 0, 'L', 0);
		$this->pdf->Cell(1, 4, "", '0', 0, 'L', 0);
		$this->pdf->SetFont('helvetica', 'B', 8);
		$this->pdf->Cell(30, 4, "Name", '0', 0, 'L', 0);
		$this->pdf->SetFont('helvetica', '', 8);
		$this->pdf->Cell(30, 4,$bname , '0', 0, 'L', 0);
		$this->pdf->Ln();

		$this->pdf->SetFont('helvetica', 'B', 8);
		$this->pdf->Cell(30, 4, 'Customer ID', '0', 0, 'L', 0);
		$this->pdf->SetFont('helvetica', '', 8);
		$this->pdf->Cell(60, 4, $cus_id, '0', 0, 'L', 0);
		$this->pdf->Cell(5, 1, "", '0', 0, 'L', 0);
		$this->pdf->Cell(1, 1, "", '0', 0, 'L', 0);
		$this->pdf->SetFont('helvetica', 'B', 8);
		$this->pdf->Cell(30, 4, "Address", '0', 0, 'L', 0);	
		$this->pdf->SetFont('helvetica', '', 8);
		$this->pdf->Cell(30, 4, $baddress, '0', 0, 'L', 0);
		$this->pdf->Ln();
		
		$heigh=5*(max(1,$this->pdf->getNumLines($cus_name,60)));
		$this->pdf->SetFont('helvetica', 'B', 8);
		$this->pdf->Cell(30, $heigh, 'Customer Name', '0', 0, 'L', 0);
		$this->pdf->SetFont('helvetica', '', 8);
		$this->pdf->MultiCell(60,$heigh, $cus_name,0, 'L',false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);

		$this->pdf->Cell(5, 4, "", '0', 0, 'L', 0);
		$this->pdf->Cell(1, 4, "", '0', 0, 'L', 0);
		$this->pdf->SetFont('helvetica', 'B', 9);
		$this->pdf->Cell(30, 4, "Do No", '0', 0, 'L', 0);
		$this->pdf->SetFont('helvetica', '', 8);
		$this->pdf->Cell(30, 4, $bdo_no, '0', 0, 'L', 0);

		$this->pdf->Ln();
		$heigh=5*(max(1,$this->pdf->getNumLines($cus_address,60)));
		$this->pdf->SetFont('helvetica', 'B', 8);
		$this->pdf->Cell(30, 4, 'Customer Address', '0', 0, 'L', 0);
		$this->pdf->SetFont('helvetica', '',8);
		$this->pdf->MultiCell(60,$heigh, $cus_address,0, 'L',false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);

		$this->pdf->Cell(5, 4, "", '0', 0, 'L', 0);
		$this->pdf->Cell(1, 4, "", '0', 0, 'L', 0);
		$this->pdf->SetFont('helvetica', 'B', 8);
		$this->pdf->Cell(30, $heigh, "Receipt No", '0', 0, 'L', 0);
		$this->pdf->SetFont('helvetica', '', 8);
		$this->pdf->Cell(30, $heigh, $rcpt_no, '0', 0, 'L', 0);
		$this->pdf->Ln();

		$this->pdf->SetFont('helvetica', 'B', 8);
		$this->pdf->Cell(30, 4, 'Contact', '0', 0, 'L', 0);
		$this->pdf->SetFont('helvetica', '', 8);
		$this->pdf->Cell(60, 4, $tp, '0', 0, 'L', 0);
		$this->pdf->Cell(5, 1, "", '0', 0, 'L', 0);
		$this->pdf->Ln();
		$this->pdf->Ln();
		
		$this->pdf->setX(2);

		$this->pdf->SetFont('helvetica', 'B', 8);
		$this->pdf->Cell(10, 5,"Sr. No", '1', 0, 'C', 0);
		$this->pdf->Cell(25, 5,"Item Code", '1', 0, 'C', 0);
		$this->pdf->Cell(50, 5,"Item Description", '1', 0, 'C', 0);
		$this->pdf->Cell(25, 5,"Model", '1', 0, 'C', 0);
		$this->pdf->Cell(10, 5,"QTY", '1', 0, 'C', 0);
		$this->pdf->Cell(18, 5,"Unit Price", '1', 0, 'C', 0);
		$this->pdf->Cell(17, 5,"Discount", '1', 0, 'C', 0);
		$this->pdf->Cell(20, 5,"Net Value", '1', 0, 'C', 0);
		$this->pdf->Cell(30, 5,"Serial No", '1', 0, 'C', 0);
		$this->pdf->Ln();
		$x=1;
		$code="default";

		foreach($items as $row){
			$this->pdf->SetLineStyle(array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0.1, 'color' => array(0, 0, 0)));

			if($code!='default' && $code==$row->code)
			{
				if($row->sub_item!="")
				{	

					$heigh=5*(max(1,$this->pdf->getNumLines($row->des,50)));
					$this->pdf-> HaveMorePages($heigh);

					$this->pdf->setX(2);
					$this->pdf->SetFont('helvetica','',7);
					$this->pdf->MultiCell(10,$heigh,"",1, 'L',false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
					$this->pdf->MultiCell(25,$heigh,$row->sub_item,1, 'L',false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
					$this->pdf->MultiCell(50,$heigh,$row->des,1, 'L',false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
					$this->pdf->MultiCell(25,$heigh,"",1, 'C',false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
					$this->pdf->MultiCell(10,$heigh,$row->sub_qty,1, 'R',false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
					$this->pdf->MultiCell(18,$heigh,"",1, 'R',false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
					$this->pdf->MultiCell(17,$heigh,"",1, 'R',false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
					$this->pdf->MultiCell(20,$heigh,"",1, 'R',false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
					$this->pdf->MultiCell(30,$heigh,"",1, 'R',false, 1, '', '', true, 0, false, true, $heigh,'M' ,false);
					$x=$x-1;
				}	

			}
			else
			{
				$this->pdf->GetY();
				$this->pdf->setX(2);
				$this->pdf->SetFont('helvetica','',7);
				if($row->is_free=="1"){

					$heigh=5*(max(1,$this->pdf->getNumLines($row->description,50)));

					$this->pdf->MultiCell(10,$heigh,$x,1, 'R',false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
					$this->pdf->MultiCell(25,$heigh,$row->code,1, 'L',false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
					$this->pdf->MultiCell(50,$heigh,$row->description,1, 'L',false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
					$this->pdf->MultiCell(25,$heigh,"FREE",1, 'C',false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
					$this->pdf->MultiCell(10,$heigh,$row->qty,1, 'R',false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
					$this->pdf->MultiCell(18,$heigh,"",1, 'R',false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
					$this->pdf->MultiCell(17,$heigh,"",1, 'L',false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
					$this->pdf->MultiCell(20,$heigh,"",1, 'R',false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
					$this->pdf->MultiCell(30,$heigh,"",1, 'R',false, 1, '', '', true, 0, false, true, $heigh,'M' ,false);

					
				}else{
					$heigh=5*(max(1,$this->pdf->getNumLines($row->description,50),$this->pdf->getNumLines($row->serials,30)));

					$this->pdf->MultiCell(10,$heigh,$x,1, 'R',false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
					$this->pdf->MultiCell(25,$heigh,$row->code,1, 'L',false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
					$this->pdf->MultiCell(50,$heigh,$row->description,1, 'L',false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
					$this->pdf->MultiCell(25,$heigh,$row->model,1, 'L',false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
					$this->pdf->MultiCell(10,$heigh,$row->qty,1, 'R',false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
					$this->pdf->MultiCell(18,$heigh,number_format($row->price,2),1, 'R',false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
					$this->pdf->MultiCell(17,$heigh,number_format($row->discount,2),1, 'R',false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
					$this->pdf->MultiCell(20,$heigh,number_format($row->amount,2),1, 'R',false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
					$this->pdf->MultiCell(30,$heigh,$row->serials,1, 'L',false, 1, '', '', true, 0, false, true, $heigh,'M' ,false);
					
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
					$this->pdf->setX(2);
					$this->pdf->SetFont('helvetica','',7);

					$heigh_s=5*(max(1,$this->pdf->getNumLines($all_serial,50)));
					$this->pdf->MultiCell(10,$heigh_s,"",1, 'L',false, 0, '', '', true, 0, false, true, $heigh_s,'M' ,false);
					$this->pdf->MultiCell(25,$heigh_s,"",1, 'L',false, 0, '', '', true, 0, false, true, $heigh_s,'M' ,false);
					$this->pdf->MultiCell(50,$heigh_s,$all_serial,1, 'L',false, 0, '', '', true, 0, false, true, $heigh_s,'M' ,false);
					$this->pdf->MultiCell(25,$heigh_s,"",1, 'L',false, 0, '', '', true, 0, false, true, $heigh_s,'M' ,false);
					$this->pdf->MultiCell(10,$heigh_s,"",1, 'L',false, 0, '', '', true, 0, false, true, $heigh_s,'M' ,false);
					$this->pdf->MultiCell(18,$heigh_s,"",1, 'L',false, 0, '', '', true, 0, false, true, $heigh_s,'M' ,false);
					$this->pdf->MultiCell(17,$heigh_s,"",1, 'L',false, 0, '', '', true, 0, false, true, $heigh_s,'M' ,false);
					$this->pdf->MultiCell(20,$heigh_s,"",1, 'L',false, 0, '', '', true, 0, false, true, $heigh_s,'M' ,false);
					$this->pdf->MultiCell(30,$heigh_s,"",1, 'R',false, 1, '', '', true, 0, false, true, $heigh_s,'M' ,false);

					if($row->sub_item!="")
					{
						$heigh=5*(max(1,$this->pdf->getNumLines($row->des,50)));

						$this->pdf->setX(2);
						$this->pdf->SetFont('helvetica','',7);
						$this->pdf->MultiCell(10,$heigh,"",1, 'R',false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
						$this->pdf->MultiCell(25,$heigh,$row->sub_item,1, 'L',false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
						$this->pdf->MultiCell(50,$heigh,$row->des,1, 'L',false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
						$this->pdf->MultiCell(25,$heigh,"",1, 'C',false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
						$this->pdf->MultiCell(10,$heigh,$row->sub_qty,1, 'R',false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
						$this->pdf->MultiCell(18,$heigh,"",1, 'R',false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
						$this->pdf->MultiCell(17,$heigh,"",1, 'R',false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
						$this->pdf->MultiCell(20,$heigh,"",1, 'R',false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
						$this->pdf->MultiCell(30,$heigh,"",1, 'R',false, 1, '', '', true, 0, false, true, $heigh,'M' ,false);
					}

				}else{

					if($row->sub_item!="")
					{
						$heigh=5*(max(1,$this->pdf->getNumLines($row->des,50)));

						$this->pdf->setX(2);
						$this->pdf->SetFont('helvetica','',7);
						$this->pdf->MultiCell(10,$heigh,"",1, 'C',false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
						$this->pdf->MultiCell(25,$heigh,$row->sub_item,1, 'C',false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
						$this->pdf->MultiCell(50,$heigh,$row->des,1, 'L',false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
						$this->pdf->MultiCell(25,$heigh,"",1, 'L',false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
						$this->pdf->MultiCell(10,$heigh,$row->sub_qty,1, 'R',false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
						$this->pdf->MultiCell(18,$heigh,"",1, 'R',false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
						$this->pdf->MultiCell(17,$heigh,"",1, 'R',false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
						$this->pdf->MultiCell(20,$heigh,"",1, 'R',false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
						$this->pdf->MultiCell(30,$heigh,"",1, 'R',false, 1, '', '', true, 0, false, true, $heigh,'M' ,false);

					}
				}
			}

			$code=$row->code;
			$x++;
		}
		$this->pdf->footer_set_credit_sales($employee,$amount,$additional,$discount_total,$user,$ins_payment,$credit_card,$tot_free_item,$cheque_detail,$credit_card_sum,$other1,$other2,$additional_tot);
		$this->pdf->Output("Credit Sales_".date('Y-m-d').".pdf", 'I');

		?>