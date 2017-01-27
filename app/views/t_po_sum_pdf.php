<?php
		error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
		$this->pdf->setPrintHeader($header,$type,$duration);
		//$this->pdf->setPrintHeader(true,$type);
        $this->pdf->setPrintFooter(true,'0',$is_cur_time);

        $this->pdf->SetFont('helvetica', 'B', 16);
		$this->pdf->AddPage($orientation,$page);   // L or P amd page type A4 or A3

 		foreach($branch as $ress){
 			$this->pdf->headerSet3($ress->name,$ress->address,$ress->tp,$ress->fax,$ress->email);	
		}

		$sup_name;
		$sup_address;
		$sup_tp;
		$sup_email;
		$ship_branch_name;
		$ship_branch_add;
		$ship_branch_tp;
		$ship_branch_email;


		foreach($suppliers as $sup){
			$sup_code=$sup->code;
			$sup_name=$sup->name;
			$sup_address=$sup->address1." ".$sup->address2." ".$sup->address3;
			$sup_tp=$sup->tp;
			$sup_email=$sup->email;
		}

		foreach($ship_branch as $sb){
			$ship_branch_name=$sb->name;
			$ship_branch_add=$sb->address1." ".$sb->address2." ".$sb->address3;
			$ship_branch_tp=$sb->tp;
			$ship_branch_email=$sb->email;
		}


		foreach($session as $ses){
			$invoice_no=$session[0].$session[1].$session[2];
		}

			$align_h=$this->utility->heading_align();

			$this->pdf->setY(20);
        	$this->pdf->SetFont('helvetica', 'BU', 10);
        	$this->pdf->Ln();
        	$orgin_print=$_POST['org_print'];
			if($orgin_print=="1"){
		  	$this->pdf->Cell(0, 5,' PURCHASE ORDER',0,false, $align_h, 0, '', 0, false, 'M', 'M');
		  	}else{
		  	$this->pdf->Cell(0, 5,' PURCHASE ORDER (DUPLICATE) ',0,false, $align_h, 0, '', 0, false, 'M', 'M');
		  	}
		 	$this->pdf->SetFont('helvetica', '', 8);
		 	$this->pdf->setY(25);
		 	$this->pdf->Ln();

		 	$this->pdf->Cell(20, 1, 'Vendor Name ', '0', 0, 'L', 0);
		 	$this->pdf->Cell(5, 1, '', '0', 0, 'L', 0);
		 	$this->pdf->Cell(40, 1,$sup_code." - ".$sup_name, '0', 0, 'L', 0);
		 	$this->pdf->Cell(30, 1, "", '0', 0, 'L', 0);
		 	
		 	$this->pdf->Cell(30, 1, "Ship To Name ", '0', 0, 'L', 0);
		 	$this->pdf->Cell(5, 1, '', '0', 0, 'L', 0);
		 	$this->pdf->Cell(60, 1,strtoupper($ship_branch_name), '0', 0, 'L', 0);
		 	$this->pdf->Ln();

		 	$this->pdf->Cell(20, 1, 'Address', '0', 0, 'L', 0);
		 	$this->pdf->Cell(5, 1, '', '0', 0, 'L', 0);
		 	$this->pdf->Cell(40, 1, $sup_address, '0', 0, 'L', 0);
		 	$this->pdf->Cell(30, 1, "", '0', 0, 'L', 0);
		 	
		 	$this->pdf->Cell(30, 1, "Address ", '0', 0, 'L', 0);
		 	$this->pdf->Cell(5, 1, '', '0', 0, 'L', 0);
		 	$this->pdf->Cell(60, 1, $ship_branch_add, '0', 0, 'L', 0);
		 	$this->pdf->Ln();


		 	$this->pdf->Cell(20, 1, 'Telephone No ', '0', 0, 'L', 0);
		 	$this->pdf->Cell(5, 1, '', '0', 0, 'L', 0);
		 	$this->pdf->Cell(40, 1, $sup_tp, '0', 0, 'L', 0);
		 	$this->pdf->Cell(30, 1, "", '0', 0, 'L', 0);
		 	
		 	$this->pdf->Cell(30, 1, "Telephone No  ", '0', 0, 'L', 0);
		 	$this->pdf->Cell(5, 1, '', '0', 0, 'L', 0);
		 	$this->pdf->Cell(60, 1, $ship_branch_tp, '0', 0, 'L', 0);
		 	$this->pdf->Ln();

		 	$this->pdf->Cell(20, 1, 'E-mail ', '0', 0, 'L', 0);
		 	$this->pdf->Cell(5, 1, '', '0', 0, 'L', 0);
		 	$this->pdf->Cell(40, 1, $sup_email, '0', 0, 'L', 0);
		 	$this->pdf->Cell(30, 1, "", '0', 0, 'L', 0);
		 	
		 	$this->pdf->Cell(30, 1, "E-mail ", '0', 0, 'L', 0);
		 	$this->pdf->Cell(5, 1, '', '0', 0, 'L', 0);
		 	$this->pdf->Cell(60, 1, $ship_branch_email, '0', 0, 'L', 0);
		 	$this->pdf->Ln();

		 	

 			$this->pdf->Cell(20, 1, 'Po No ', '0', 0, 'L', 0);
		 	$this->pdf->Cell(5, 1, '', '0', 0, 'L', 0);
		 	$this->pdf->Cell(40, 1, $invoice_no, '0', 0, 'L', 0);
		 	$this->pdf->Cell(30, 1, "", '0', 0, 'L', 0);
		 	
		 	$this->pdf->Cell(30, 1, "Vendor", '0', 0, 'L', 0);
		 	$this->pdf->Cell(5, 1, '', '0', 0, 'L', 0);
		 	$this->pdf->Cell(60, 1, $sup_name, '0', 0, 'L', 0);
		 	$this->pdf->Ln();



 			$this->pdf->Cell(20, 1, 'Po Date ', '0', 0, 'L', 0);
		 	$this->pdf->Cell(5, 1, '', '0', 0, 'L', 0);
		 	$this->pdf->Cell(40, 1, $ddate.$save_time, '0', 0, 'L', 0);
		 	$this->pdf->Cell(30, 1, "", '0', 0, 'L', 0);
		 
		 	$this->pdf->Cell(30, 1, "Deliver On Or Before", '0', 0, 'L', 0);
		 	$this->pdf->Cell(5, 1, '', '0', 0, 'L', 0);
		 	$this->pdf->Cell(60, 1, $deliver_date, '0', 0, 'L', 0);
		 	$this->pdf->Ln();

			$this->pdf->SetY(60);
			$this->pdf->SetX(12);
			foreach($session as $ses){
				$invoice_no=$session[0].$session[1].$session[2];
			}


	        if($cost_print==1){
	        	$this->pdf->SetFont('helvetica','B',9);
				$this->pdf->MultiCell(10, 6, "No", $border=1, $align='C', $fill=false, $ln=0, $x=($this->pdf->GetX()-5), $y=($this->pdf->GetY()), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=6, $valign='M', $fitcell=true);
	            $this->pdf->MultiCell(30, 6, "Code", $border=1, $align='C', $fill=false, $ln=0, $x=($this->pdf->GetX()), $y=$this->pdf->GetY(), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=6, $valign='M', $fitcell=true);
	            $this->pdf->MultiCell(50, 6, "Description", $border=1, $align='C', $fill=false, $ln=0, $x=($this->pdf->GetX()), $y=$this->pdf->GetY(), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=6, $valign='M', $fitcell=true);
	            $this->pdf->MultiCell(25, 6, "Model", $border=1, $align='C', $fill=false, $ln=0, $x=($this->pdf->GetX()), $y=$this->pdf->GetY(), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=6, $valign='M', $fitcell=true);
	            $this->pdf->MultiCell(20, 6, "Current Qty", $border=1, $align='C', $fill=false, $ln=0, $x=($this->pdf->GetX()), $y=$this->pdf->GetY(), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=6, $valign='M', $fitcell=true);
	            $this->pdf->MultiCell(20, 6, "PO Qty", $border=1, $align='C', $fill=false, $ln=0, $x=($this->pdf->GetX()), $y=$this->pdf->GetY(), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=6, $valign='M', $fitcell=true);
	            $this->pdf->MultiCell(20, 6, "Cost ", $border=1, $align='C', $fill=false, $ln=0, $x=($this->pdf->GetX()), $y=$this->pdf->GetY(), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=6, $valign='M', $fitcell=true);
		        $this->pdf->MultiCell(20, 6, "Amount ", $border=1, $align='C', $fill=false, $ln=0, $x=($this->pdf->GetX()), $y=$this->pdf->GetY(), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=6, $valign='M', $fitcell=true);
		            
	            $this->pdf->Ln();
	            $op=1;
	            $tot=(int)0;

	            foreach($det as $row){
	            	$this->pdf->SetLineStyle(array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0.1, 'color' => array(0, 0, 0)));

		            $this->pdf->GetY();
		            $this->pdf->SetX(12);

					$this->pdf->SetFont('helvetica','',9);
					$this->pdf->MultiCell(10, 6, $op, $border=1, $align='R', $fill=false, $ln=0, $x=($this->pdf->GetX()-5), $y=($this->pdf->GetY()), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=6, $valign='M', $fitcell=true);
		            $this->pdf->MultiCell(30, 6, $row->code, $border=1, $align='L', $fill=false, $ln=0, $x=($this->pdf->GetX()), $y=$this->pdf->GetY(), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=6, $valign='M', $fitcell=true);
		            $this->pdf->MultiCell(50, 6, $row->description, $border=1, $align='L', $fill=false, $ln=0, $x=($this->pdf->GetX()), $y=$this->pdf->GetY(), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=6, $valign='M', $fitcell=true);
		            $this->pdf->MultiCell(25, 6, $row->model, $border=1, $align='L', $fill=false, $ln=0, $x=($this->pdf->GetX()), $y=$this->pdf->GetY(), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=6, $valign='M', $fitcell=true);
		            $this->pdf->MultiCell(20, 6, $row->current_qty, $border=1, $align='R', $fill=false, $ln=0, $x=($this->pdf->GetX()), $y=$this->pdf->GetY(), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=6, $valign='M', $fitcell=true);
		            $this->pdf->MultiCell(20, 6, $row->qty, $border=1, $align='R', $fill=false, $ln=0, $x=($this->pdf->GetX()), $y=$this->pdf->GetY(), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=6, $valign='M', $fitcell=true);
		            $this->pdf->MultiCell(20, 6, number_format($row->cost,2), $border=1, $align='R', $fill=false, $ln=0, $x=($this->pdf->GetX()), $y=$this->pdf->GetY(), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=6, $valign='M', $fitcell=true);
		            $this->pdf->MultiCell(20, 6, number_format($row->amount,2), $border=1, $align='R', $fill=false, $ln=0, $x=($this->pdf->GetX()), $y=$this->pdf->GetY(), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=6, $valign='M', $fitcell=true);
		            $this->pdf->Ln();
		            $tot+=$row->amount;
		            $op++;
	            }
	            $this->pdf->Ln();
	            $this->pdf->SetFont('helvetica','B',9);
	            $this->pdf->Cell(172, 1, "", '0', 0, 'L', 0);
	            $this->pdf->Cell(20, 1, number_format($tot,2), 'TB', 0, 'R', 0);

	        }else{
				$this->pdf->SetFont('helvetica','B',9);
				$this->pdf->MultiCell(10, 6, "No", $border=1, $align='C', $fill=false, $ln=0, $x=($this->pdf->GetX()-5), $y=($this->pdf->GetY()), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=6, $valign='M', $fitcell=true);
	            $this->pdf->MultiCell(30, 6, "Code", $border=1, $align='C', $fill=false, $ln=0, $x=($this->pdf->GetX()), $y=$this->pdf->GetY(), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=6, $valign='M', $fitcell=true);
	            $this->pdf->MultiCell(80, 6, "Description", $border=1, $align='C', $fill=false, $ln=0, $x=($this->pdf->GetX()), $y=$this->pdf->GetY(), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=6, $valign='M', $fitcell=true);
	            $this->pdf->MultiCell(35, 6, "Model", $border=1, $align='C', $fill=false, $ln=0, $x=($this->pdf->GetX()), $y=$this->pdf->GetY(), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=6, $valign='M', $fitcell=true);
	            $this->pdf->MultiCell(20, 6, "Current Qty", $border=1, $align='C', $fill=false, $ln=0, $x=($this->pdf->GetX()), $y=$this->pdf->GetY(), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=6, $valign='M', $fitcell=true);
	            $this->pdf->MultiCell(20, 6, "PO Qty", $border=1, $align='C', $fill=false, $ln=0, $x=($this->pdf->GetX()), $y=$this->pdf->GetY(), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=6, $valign='M', $fitcell=true);
	            $this->pdf->Ln();
	            $op=1;
	            

	            foreach($det as $row){
	            	$this->pdf->SetLineStyle(array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0.1, 'color' => array(0, 0, 0)));

		            $this->pdf->GetY();
		            $this->pdf->SetX(12);

					$this->pdf->SetFont('helvetica','',9);
					$this->pdf->MultiCell(10, 6, $op, $border=1, $align='R', $fill=false, $ln=0, $x=($this->pdf->GetX()-5), $y=($this->pdf->GetY()), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=6, $valign='M', $fitcell=true);
		            $this->pdf->MultiCell(30, 6, $row->code, $border=1, $align='L', $fill=false, $ln=0, $x=($this->pdf->GetX()), $y=$this->pdf->GetY(), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=6, $valign='M', $fitcell=true);
		            $this->pdf->MultiCell(80, 6, $row->description, $border=1, $align='L', $fill=false, $ln=0, $x=($this->pdf->GetX()), $y=$this->pdf->GetY(), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=6, $valign='M', $fitcell=true);
		            $this->pdf->MultiCell(35, 6, $row->model, $border=1, $align='L', $fill=false, $ln=0, $x=($this->pdf->GetX()), $y=$this->pdf->GetY(), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=6, $valign='M', $fitcell=true);
		            $this->pdf->MultiCell(20, 6, $row->current_qty, $border=1, $align='R', $fill=false, $ln=0, $x=($this->pdf->GetX()), $y=$this->pdf->GetY(), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=6, $valign='M', $fitcell=true);
		            $this->pdf->MultiCell(20, 6, $row->qty, $border=1, $align='R', $fill=false, $ln=1, $x=($this->pdf->GetX()), $y=$this->pdf->GetY(), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=6, $valign='M', $fitcell=true);
		            //$this->pdf->MultiCell(20, 6, number_format($row->cost,2), $border=1, $align='R', $fill=false, $ln=0, $x=($this->pdf->GetX()), $y=$this->pdf->GetY(), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=6, $valign='M', $fitcell=true);
		            //$this->pdf->MultiCell(25, 6, number_format($row->amount,2), $border=1, $align='R', $fill=false, $ln=0, $x=($this->pdf->GetX()), $y=$this->pdf->GetY(), $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=6, $valign='M', $fitcell=true);



		            $op++;
	            }
	        }

	$this->utility->send_email($status,"Purchase Order","Inventory System - Nisaco (PVT)LTD","nisacofurniture@gmail.com","Purchase Order",$send_list);


?>