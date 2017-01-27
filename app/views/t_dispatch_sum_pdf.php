<?php
error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
$this->pdf->setPrintHeader($header,$type,$duration);
$this->pdf->setPrintFooter(true);
        //print_r($det);
$this->pdf->SetFont('helvetica', 'B', 16);
		$this->pdf->AddPage($orientation,$page);   // L or P amd page type A4 or A3

		foreach($branch as $ress){
			$this->pdf->headerSet3($ress->name,$ress->address,$ress->tp,$ress->fax,$ress->email);
		}

		$cus_name=$cus_address="";

		foreach($sum as $row){
			$from_store_code=$row->from_s_code;
			$from_store_des = $row->from_s_des;
			$to_store_code=$row->to_s_code;
			$to_store_des=$row->to_s_des;
			$date=$row->ddate;
			$officer=$row->name;
			$ref_no=$row->ref_no;
			$group_sale_id=$row->group_sale_id;
			$group_sales_des=$row->group_sales_des;
			$memo = $row->memo;

		}

		foreach($session as $ses){
			$invoice_no=$session[0].$session[1].$session[2];
		}
		$this->pdf->SetFont('helvetica', 'BU', 10);

		$align_h=$this->utility->heading_align();
		$orgin_print=$_POST['org_print'];
		if($orgin_print=="1"){
			$this->pdf->Cell(0, 5, ' DISPATCH '.$pdf_page_type,0,false, $align_h, 0, '', 0, false, 'M', 'M');
		}else{
			$this->pdf->Cell(0, 5, ' DISPATCH '.$pdf_page_type.' (DUPLICATE)',0,false, $align_h, 0, '', 0, false, 'M', 'M');
		}
		$this->pdf->SetFont('helvetica', '', 8);
		$this->pdf->setY(25);
		$this->pdf->Ln();
		$this->pdf->SetFont('helvetica', 'B', 8);
		$this->pdf->Cell(30, 1, 'From ', '0', 0, 'L', 0);
		$this->pdf->SetFont('helvetica', '', 8);
		$this->pdf->Cell(90, 1, $from_store_code ." - ".$from_store_des, '0', 0, 'L', 0);
		$this->pdf->SetFont('helvetica', 'B', 8);
		$this->pdf->Cell(30, 1, "No ", '0', 0, 'L', 0);
		$this->pdf->SetFont('helvetica', '', 8);
		$this->pdf->Cell(30, 1, $invoice_no, '0', 0, 'L', 0);

		$this->pdf->Ln();
		$this->pdf->SetFont('helvetica', 'B', 8);
		$this->pdf->Cell(30, 1, 'To ', '0', 0, 'L', 0);
		$this->pdf->SetFont('helvetica', '', 8);
		$this->pdf->Cell(90, 1, $to_store_code ." - ".$to_store_des, '0', 0, 'L', 0);
		$this->pdf->SetFont('helvetica', 'B', 8);
		$this->pdf->Cell(30, 1, "Date ", '0', 0, 'L', 0);
		$this->pdf->SetFont('helvetica', '', 8);
		$this->pdf->Cell(30, 1, $date, '0', 0, 'L', 0);


		$this->pdf->Ln();
		$this->pdf->SetFont('helvetica', 'B', 8);
		$this->pdf->Cell(30, 1, 'Memo', '0', 0, 'L', 0);
		$this->pdf->SetFont('helvetica', '', 8);
		$this->pdf->Cell(90, 1,$memo , '0', 0, 'L', 0);
		$this->pdf->SetFont('helvetica', 'B', 8);
		$this->pdf->Cell(30, 1, "RefNo", '0', 0, 'L', 0);
		$this->pdf->SetFont('helvetica', '', 8);
		$this->pdf->Cell(30, 1, $ref_no, '0', 0, 'L', 0);

		$this->pdf->Ln();
		$this->pdf->SetFont('helvetica', 'B', 8);
		$this->pdf->Cell(30, 1, 'Group Sale ID', '0', 0, 'L', 0);
		$this->pdf->SetFont('helvetica', '', 8);
		$this->pdf->Cell(90, 1, $group_sale_id." - ".$group_sales_des, '0', 0, 'L', 0);

		$this->pdf->Ln();
		$this->pdf->Ln();

		$this->pdf->SetFont('helvetica','B',8);
		$this->pdf->Cell(35, 6,"Code", '1', 0, 'C', 0);
		$this->pdf->Cell(75, 6,"Description", '1', 0, 'C', 0);
		$this->pdf->Cell(30, 6,"Batch No", '1', 0, 'C', 0);
		$this->pdf->Cell(30, 6,"Qty", '1', 0, 'C', 0);

		$this->pdf->Ln();



		foreach($det as $row){

			$heigh=6*(max(1,$this->pdf->getNumLines($row->item_name,75)));
			$this->pdf->HaveMorePages($heigh);

			$this->pdf->SetLineStyle(array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0.1, 'color' => array(0, 0, 0)));
			$this->pdf->GetY();
			
			$this->pdf->SetFont('helvetica','',7);

			$this->pdf->MultiCell(35, $heigh,$row->item_code,1, 'L',false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
			$this->pdf->MultiCell(75, $heigh,$row->item_name,1, 'L',false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
			$this->pdf->MultiCell(30, $heigh,$row->batch_no,1, 'R',false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
			$this->pdf->MultiCell(30, $heigh,$row->qty,1, 'R',false, 1, '', '', true, 0, false, true, $heigh,'M' ,false);


		}


		$this->pdf->Ln();
		$this->pdf->Ln();


		$this->pdf->SetFont('helvetica','B',7);
		$this->pdf->Cell(20, 1, 'Officer ', '0', 0, 'L', 0);
		$this->pdf->SetFont('helvetica', '', 7);
		$this->pdf->Cell(30, 1, $officer, '0', 0, 'L', 0);

		$this->pdf->Ln();
		$this->pdf->Ln();
		

		$this->pdf->Cell(30, 1, "..............................", '0', 0, 'C', 0);
		$this->pdf->Cell(90, 1, "..............................", '0', 0, 'C', 0);
		$this->pdf->Cell(30, 1, "..............................", '0', 0, 'C', 0);
		$this->pdf->Ln();
		$this->pdf->Cell(30, 1, 'Prepaired By', '0', 0, 'C', 0);
		$this->pdf->Cell(90, 1, 'Authorized', '0', 0, 'C', 0);
		$this->pdf->Cell(30, 1, "Recivied By ", '0', 0, 'C', 0);


		$this->pdf->Output("Dispatch loading_".date('Y-m-d').".pdf", 'I');

		?>