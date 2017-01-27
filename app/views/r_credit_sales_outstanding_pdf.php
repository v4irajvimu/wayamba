<?php
error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
$this->pdf->setPrintHeader($header,$type,$duration);
$this->pdf->setPrintFooter(true);
$this->pdf->SetFont('helvetica', 'B', 16);
	$this->pdf->AddPage($orientation,$page);   // L or P amd page type A4 or A3

	foreach($branch as $ress){
		$this->pdf->headerSet3($ress->name,$ress->address,$ress->tp,$ress->fax,$ress->email);
	}
	foreach ($sum as $value) {
		$date=$value->ddate;
	}

	$this->pdf->setY(26);
	$this->pdf->SetFont('helvetica', 'BU',12);
	$this->pdf->Cell(0, 5, 'TOTAL CREDIT SALES OUTSTANDING',0,false, 'L', 0, '', 0, false, 'M', 'M');
	$this->pdf->Ln();
	
	$this->pdf->Ln(); 
	$this->pdf->SetFont('helvetica', '',9);
	$this->pdf->Cell(0, 5, 'As At Date '.$dto ,0,false, 'L', 0, '', 0, false, 'M', 'M');
	$this->pdf->Ln();

	$Goss=array();
	$net=array();
	$tot=0;
	$dis=0;
	$cus=$_POST['cus_id'];
	$cus_name=$_POST['customer'];
	$rep="default";
	$xx=0;
	$len = count($sum);

	if($_POST['cus_id']!=""){
		$this->pdf->SetY(40);
		$this->pdf->SetX(15);
		$this->pdf->SetFont('helvetica', 'B', 9);
		$this->pdf->Cell(18, 1, "Customer -  ", '0', 0, 'L', 0);
		$this->pdf->SetFont('helvetica', '', 9);
		$this->pdf->Cell(50, 1, $cus." - ".$cus_name, '0', 0, 'L', 0);

	}
	
	$tot_net=$rep_net=0;
	$tot_pan=$rep_pan=0;
	$tot_bal=$rep_bal=0;

	$this->pdf->SetX(15);

	foreach ($sum as $value) {
		if($rep==$value->rep && $rep!='default'){

			$heigh=6*(max($this->pdf->getNumLines($value->cus_name, 40),$this->pdf->getNumLines($value->item, 100)));
			$this->pdf-> HaveMorePages($heigh);
			$this->pdf->SetX(15);
			$this->pdf->SetLineStyle(array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0.1, 'color' => array(0, 0, 0)));
			$this->pdf->SetFont('helvetica','',8);
			
			$this->pdf->MultiCell(22, $heigh, $value->nno, 1, 'L', 0, 0, '', '', true, 0, false, true, 0);
			$this->pdf->MultiCell(20, $heigh, $value->cus_id,1, 'L', 0, 0, '', '', true, 0, false, true, 0);
			$this->pdf->MultiCell(40, $heigh, $value->cus_name,1, 'L', 0, 0, '', '', true, 0, false, true, 0);
			$this->pdf->MultiCell(100, $heigh, $value->item, 1, 'L', 0, 0, '', '', true, 0, false, true, 0);
			$this->pdf->MultiCell(30, $heigh, $value->net_amount, 1, 'R', 0, 0, '', '', true, 0, false, true, 0);
			$this->pdf->MultiCell(30, $heigh, $value->paid, 1, 'R', 0, 0, '', '', true, 0, false, true, 0);
			$this->pdf->MultiCell(20, $heigh, $value->balance, 1, 'R', 0, 1, '', '', true, 0, false, true, 0);

		}else{
			if($xx!=0){
				$this->pdf-> HaveMorePages(6);
				$this->pdf->SetX(15);
				$this->pdf->SetFont('helvetica','B',8);
				$this->pdf->Cell(22, 6,"", '0', 0, 'C', 0);
				$this->pdf->Cell(20, 6,"", '0', 0, 'C', 0);
				$this->pdf->Cell(40, 6,"", '0', 0, 'C', 0);
				$this->pdf->Cell(100, 6,"Total", '0', 0, 'R', 0);
				$this->pdf->Cell(30, 6,number_format($rep_net,2), 'TB', 0, 'R', 0);
				$this->pdf->Cell(1, 6,"", '0', 0, 'C', 0);
				$this->pdf->Cell(29, 6,number_format($rep_paid,2), 'TB', 0, 'R', 0);
				$this->pdf->Cell(1, 6,"", '0', 0, 'C', 0);
				$this->pdf->Cell(19, 6,number_format($rep_bal,2), 'TB', 0, 'R', 0);
				$this->pdf->Ln();
			}

			$rep_net=(float)0;
			$rep_paid=(float)0;
			$rep_bal=(float)0;
			$this->pdf->Ln();
			$this->pdf->Cell(15, 6,$value->rep."  -  ".$value->rep_name, '0', 0, 'L', 0);
			$this->pdf->Ln();
			$this->pdf->Ln();
			$this->pdf-> HaveMorePages(6);
			$this->pdf->SetFont('helvetica','B',8);
			$this->pdf->Cell(22, 6,"No", '1', 0, 'C', 0);
			$this->pdf->Cell(20, 6,"Code", '1', 0, 'C', 0);
			$this->pdf->Cell(40, 6,"Name", '1', 0, 'C', 0);
			$this->pdf->Cell(100, 6,"Item Name", '1', 0, 'C', 0);
			$this->pdf->Cell(30, 6,"Sale Value", '1', 0, 'C', 0);
			$this->pdf->Cell(30, 6,"Total Paid Amount", '1', 0, 'C', 0);
			$this->pdf->Cell(20, 6,"Balance", '1', 0, 'C', 0);
			$this->pdf->Ln();
			$this->pdf->SetFont('helvetica','',8);
			$heigh=6*(max($this->pdf->getNumLines($value->cus_name, 40),$this->pdf->getNumLines($value->item, 100)));
			$this->pdf-> HaveMorePages($heigh);
			$this->pdf->MultiCell(22, $heigh, $value->nno, 1, 'L', 0, 0, '', '', true, 0, false, true, 0);
			$this->pdf->MultiCell(20, $heigh, $value->cus_id,1, 'L', 0, 0, '', '', true, 0, false, true, 0);
			$this->pdf->MultiCell(40, $heigh, $value->cus_name,1, 'L', 0, 0, '', '', true, 0, false, true, 0);
			$this->pdf->MultiCell(100, $heigh, $value->item, 1, 'L', 0, 0, '', '', true, 0, false, true, 0);
			$this->pdf->MultiCell(30, $heigh, $value->net_amount, 1, 'R', 0, 0, '', '', true, 0, false, true, 0);
			$this->pdf->MultiCell(30, $heigh, $value->paid, 1, 'R', 0, 0, '', '', true, 0, false, true, 0);
			$this->pdf->MultiCell(20, $heigh, $value->balance, 1, 'R', 0, 1, '', '', true, 0, false, true, 0);
		}

		$tot_net+=(float)$value->net_amount;
		$tot_paid+=(float)$value->paid;
		$tot_bal+=(float)$value->balance;

		$rep_net+=(float)$value->net_amount;
		$rep_paid+=(float)$value->paid;
		$rep_bal+=(float)$value->balance;

		$xx++;
		$rep = $value->rep;

	}

	if($xx == $len){
		$this->pdf-> HaveMorePages(6);
		$this->pdf->SetX(15);
		$this->pdf->SetFont('helvetica','B',8);
		$this->pdf->Cell(22, 6,"", '0', 0, 'C', 0);
		$this->pdf->Cell(20, 6,"", '0', 0, 'C', 0);
		$this->pdf->Cell(40, 6,"", '0', 0, 'C', 0);
		$this->pdf->Cell(100, 6,"Total", '0', 0, 'R', 0);
		$this->pdf->Cell(30, 6,number_format($rep_net,2), 'TB', 0, 'R', 0);
		$this->pdf->Cell(1, 6,"", '0', 0, 'C', 0);
		$this->pdf->Cell(29, 6,number_format($rep_paid,2), 'TB', 0, 'R', 0);
		$this->pdf->Cell(1, 6,"", '0', 0, 'C', 0);
		$this->pdf->Cell(19, 6,number_format($rep_bal,2), 'TB', 0, 'R', 0);
		$this->pdf->Ln();
	}
	$this->pdf->Ln();
	$this->pdf->HaveMorePages(6);
	$this->pdf->SetX(15);
	$this->pdf->SetFont('helvetica','B',8);
	$this->pdf->Cell(22, 6,"", '0', 0, 'C', 0);
	$this->pdf->Cell(20, 6,"", '0', 0, 'C', 0);
	$this->pdf->Cell(40, 6,"", '0', 0, 'C', 0);
	$this->pdf->Cell(100, 6,"Final Total", '0', 0, 'R', 0);
	$this->pdf->Cell(30, 6,number_format($tot_net,2), 'TB', 0, 'R', 0);
	$this->pdf->Cell(1, 6,"", '0', 0, 'C', 0);
	$this->pdf->Cell(29, 6,number_format($tot_paid,2), 'TB', 0, 'R', 0);
	$this->pdf->Cell(1, 6,"", '0', 0, 'C', 0);
	$this->pdf->Cell(19, 6,number_format($tot_bal,2), 'TB', 0, 'R', 0);

	$this->pdf->Output("Credit Sales Outstanding".date('Y-m-d').".pdf", 'I');

	?>