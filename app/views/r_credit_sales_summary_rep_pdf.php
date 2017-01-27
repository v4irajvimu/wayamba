<?php
error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
$this->pdf->setPrintHeader($header,$type,$duration);
$this->pdf->setPrintFooter(true);

$this->pdf->SetFont('helvetica', 'B', 16);
$this->pdf->AddPage($orientation,$page);   // L or P amd page type A4 or A3

foreach($branch as $ress){
	$this->pdf->headerSet3($ress->name,$ress->address,$ress->tp,$ress->fax,$ress->email);
}
foreach ($purchase as $value){
	$inv_no=$value->nno;
	$name=$value->name;
}

foreach ($category as $cat){
	$code=$cat->code;
	$des=$cat->description;
}

$this->pdf->setY(22);

$this->pdf->SetFont('helvetica', 'BU',10);
$this->pdf->Cell(0, 5, 'TOTAL CREDIT SALES SUMMARY REP WISE',0,false, 'C', 0, '', 0, false, 'M', 'M');
$this->pdf->Ln();$this->pdf->Ln();

$this->pdf->SetFont('helvetica', '',9);
$this->pdf->Cell(0, 5, 'Date Between '. $dfrom.' and '.$dto ,0,false, 'C', 0, '', 0, false, 'M', 'M');
$this->pdf->Ln();
$this->pdf->Ln();

if($category_field!="0"){
	$this->pdf->SetX(20);
	$this->pdf->SetFont('helvetica', 'B',8);
	$this->pdf->Cell(45, 6,"Category : ".$code." - ".$des, '0', 0, 'R', 0);
	$this->pdf->Ln();
	$this->pdf->Ln();
}

if($report_type="1"){
	
	$this->pdf->SetY(40);
	$this->pdf->SetX(10);
	

	$tot_gross=(float)0;
	$tot_net=(float)0;
	$tot_disc=(float)0;
	$tot_add=(float)0;
	$rep="default";

	$cus_gross=(float)0;
	$cus_net=(float)0;
	$cus_dis=(float)0;
	$cus_add=(float)0;
	$xx=0;
	$len = count($data);

	foreach ($data as $value) {

		if($rep==$value->rep && $rep!='default'){
			$this->pdf->SetX(10);
			$this->pdf->SetLineStyle(array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0.1, 'color' => array(0, 0, 0)));
			$this->pdf->SetFont('helvetica','',7);			
			$heigh=6*(max(1,$this->pdf->getNumLines($value->cus_id." | ".$value->cus_name,70)));
			$this->pdf-> HaveMorePages($heigh);
			$this->pdf->SetX(10);
			$this->pdf->MultiCell(15, $heigh,$value->nno,  1, 'L', 0, 0, '', '', true, 0, false, true, 0);
			$this->pdf->MultiCell(20, $heigh,$value->ddate,  1, 'L', 0, 0, '', '', true, 0, false, true, 0);
			$this->pdf->MultiCell(70, $heigh,$value->cus_id." | ".$value->cus_name,  1, 'L', 0, 0, '', '', true, 0, false, true, 0);
			$this->pdf->MultiCell(20, $heigh,number_format($value->gross,2),  1, 'R', 0, 0, '', '', true, 0, false, true, 0);
			$this->pdf->MultiCell(20, $heigh,number_format((float)$value->discount+(float)$value->additional_deduct,2),  1, 'R', 0, 0, '', '', true, 0, false, true, 0);
			$this->pdf->MultiCell(20, $heigh,number_format($value->additional_add,2),  1, 'R', 0, 0, '', '', true, 0, false, true, 0);
			$this->pdf->MultiCell(20, $heigh,number_format($value->net_amount,2),  1, 'R', 0, 0, '', '', true, 0, false, true, 0);

	
		}else{
			
			if($xx!=0){
				$this->pdf->SetFont('helvetica','B',8);
				$this->pdf-> HaveMorePages(5);
				$this->pdf->SetX(5);
				$this->pdf->Cell(15, 6,"", '0', 0, 'L', 0);
				$this->pdf->Cell(25, 6,"", '0', 0, 'R', 0);
				$this->pdf->Cell(70, 6,"Total ", '0', 0, 'R', 0);
				$this->pdf->Cell(20, 6,number_format($cus_gross,2), 'TB', 0, 'R', 0);
				$this->pdf->Cell(1, 6,"", '0', 0, 'R', 0);
				$this->pdf->Cell(19, 6,number_format((float)$cus_dis,2), 'TB', 0, 'R', 0);
				$this->pdf->Cell(1, 6,"", '0', 0, 'R', 0);
				$this->pdf->Cell(20, 6,number_format((float)$cus_add,2), 'TB', 0, 'R', 0);
				$this->pdf->Cell(20, 6,number_format($cus_net,2), 'TB', 0, 'R', 0);
				$this->pdf->Cell(20, 6,"", '0', 0, 'R', 0);
				$this->pdf->Ln();
			}

			$cus_gross=(float)0;
			$cus_net=(float)0;
			$cus_dis=(float)0;
			$cus_add=(float)0;

			$this->pdf->SetX(10);
			$this->pdf->SetFont('helvetica','B',8);
			$this->pdf->Cell(15, 6,$value->rep."  -  ".$value->rep_name, '0', 0, 'L', 0);
			$this->pdf->Ln();
			$this->pdf->Ln();
			$this->pdf-> HaveMorePages(6);
			$this->pdf->SetX(10);
			$this->pdf->SetFont('helvetica','B',7);
			$this->pdf->Cell(15, 6,"No", '1', 0, 'C', 0);
			$this->pdf->Cell(20, 6,"Date", '1', 0, 'C', 0);
			$this->pdf->Cell(70, 6,"Customer", '1', 0, 'C', 0);
			$this->pdf->Cell(20, 6,"Gross Amount", '1', 0, 'C', 0);
			$this->pdf->Cell(20, 6,"Discount", '1', 0, 'C', 0);
			$this->pdf->Cell(20, 6,"Additional", '1', 0, 'C', 0);
			$this->pdf->Cell(20, 6,"Net Amount", '1', 0, 'C', 0);
			$this->pdf->Ln();
			
			$this->pdf->SetFont('helvetica','',7);
			$this->pdf->SetLineStyle(array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0.1, 'color' => array(0, 0, 0)));
			$heigh=6*(max(1,$this->pdf->getNumLines($value->cus_id." | ".$value->cus_name,70)));
			$this->pdf-> HaveMorePages($heigh);
			$this->pdf->SetX(10);
			$this->pdf->MultiCell(15, $heigh,$value->nno,  1, 'L', 0, 0, '', '', true, 0, false, true, 0);
			$this->pdf->MultiCell(20, $heigh,$value->ddate,  1, 'L', 0, 0, '', '', true, 0, false, true, 0);
			$this->pdf->MultiCell(70, $heigh,$value->cus_id." | ".$value->cus_name,  1, 'L', 0, 0, '', '', true, 0, false, true, 0);
			$this->pdf->MultiCell(20, $heigh,number_format($value->gross,2),  1, 'R', 0, 0, '', '', true, 0, false, true, 0);
			$this->pdf->MultiCell(20, $heigh,number_format((float)$value->discount+(float)$value->additional_deduct,2),  1, 'R', 0, 0, '', '', true, 0, false, true, 0);
			$this->pdf->MultiCell(20, $heigh,number_format($value->additional_add,2),  1, 'R', 0, 0, '', '', true, 0, false, true, 0);
			$this->pdf->MultiCell(20, $heigh,number_format($value->net_amount,2),  1, 'R', 0, 0, '', '', true, 0, false, true, 0);


		}

		$rep = $value->rep;
		$tot_gross+=(float)$value->gross;
		$tot_net+=(float)$value->net_amount;
		$tot_disc+=(float)$value->discount+(float)$value->additional_deduct;
		$tot_add+=(float)$value->additional_add;


		$cus_gross+=(float)$value->gross;
		$cus_net+=(float)$value->net_amount;
		$cus_dis+=(float)$value->discount+(float)$value->additional_deduct;
		$cus_add+=(float)$value->additional_add;


		$this->pdf->Ln();
		$xx++;
	}
	if($xx == $len){
		$this->pdf->SetFont('helvetica','B',8);
		$this->pdf-> HaveMorePages(5);
		$this->pdf->SetX(5);
		$this->pdf->Cell(15, 6,"", '0', 0, 'L', 0);
		$this->pdf->Cell(25, 6,"", '0', 0, 'R', 0);
		$this->pdf->Cell(70, 6,"Total ", '0', 0, 'R', 0);
		$this->pdf->Cell(20, 6,number_format($cus_gross,2), 'TB', 0, 'R', 0);
		$this->pdf->Cell(1, 6,"", '0', 0, 'R', 0);
		$this->pdf->Cell(19, 6,number_format((float)$cus_dis,2), 'TB', 0, 'R', 0);
		$this->pdf->Cell(1, 6,"", '0', 0, 'R', 0);
		$this->pdf->Cell(20, 6,number_format((float)$cus_add,2), 'TB', 0, 'R', 0);
		$this->pdf->Cell(20, 6,number_format($cus_net,2), 'TB', 0, 'R', 0);
		$this->pdf->Cell(20, 6,"", '0', 0, 'R', 0);
		$this->pdf->Ln();
	}
	$this->pdf->Ln();

	$this->pdf->SetFont('helvetica','B',8);
	$this->pdf-> HaveMorePages(5);
	$this->pdf->SetX(5);
	$this->pdf->Cell(15, 6,"", '0', 0, 'L', 0);
	$this->pdf->Cell(25, 6,"", '0', 0, 'R', 0);
	$this->pdf->Cell(70, 6,"Final Total ", '0', 0, 'R', 0);
	$this->pdf->Cell(20, 6,number_format($tot_gross,2), 'TB', 0, 'R', 0);
	$this->pdf->Cell(1, 6,"", '0', 0, 'R', 0);
	$this->pdf->Cell(19, 6,number_format((float)$tot_disc,2), 'TB', 0, 'R', 0);
	$this->pdf->Cell(1, 6,"", '0', 0, 'R', 0);
	$this->pdf->Cell(20, 6,number_format((float)$tot_add,2), 'TB', 0, 'R', 0);
	$this->pdf->Cell(20, 6,number_format($tot_net,2), 'TB', 0, 'R', 0);
	$this->pdf->Cell(20, 6,"", '0', 0, 'R', 0);

                      


}




$this->pdf->Output("Credit Sale Summary".date('Y-m-d').".pdf", 'I');

?>