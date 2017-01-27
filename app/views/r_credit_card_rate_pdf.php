<?php
		// echo '<pre>'.print_r($det,true).'</pre>';
		//  		exit;


error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
$this->pdf->setPrintFooter(true);
$this->pdf->setPrintHeader(true);
$this->pdf->setPrintHeader($header,$type); 


$this->pdf->SetFont('helvetica', 'B', 16);
$this->pdf->AddPage($orientation,$page);   // L or P amd page type A4 or A3

foreach($branch as $ress){
 			$this->pdf->headerSet3($ress->name,$ress->address,$ress->tp,$ress->fax,$ress->email);	
		}

$terminal_id;
$month;
$interest_rate;
$merchant_id;
$acc_code;
$acc_name;

foreach($credit_card as $credit){
$daate=$credit->ddate;
$nno=$credit->nno;
$terminal_id=$credit->terminal_id;
$acc_des=$credit->acc_des;
$bank=$credit->b_des;
$month=$credit->month;
$interest_rate=$credit->rate;
$merchant_id=$credit->merchant_id;

}

$this->pdf->setY(20);
$this->pdf->SetFont('helvetica', 'BU', 12);
$this->pdf->Ln();

$this->pdf->Cell(0, 5,' Credit Card Rate Setup',0,false, 'C', 0, '', 0, false, 'M', 'M');


$this->pdf->SetFont('helvetica', '', 9);


$this->pdf->setY(30);
$this->pdf->setX(25);

$this->pdf->Cell(20, 1, 'Terminal Id ', '0', 0, 'L', 0);
$this->pdf->Cell(10, 1, '', '0', 0, 'L', 0);
$this->pdf->Cell(40, 1, $terminal_id, '0', 0, 'L', 0);
$this->pdf->Cell(30, 1, "", '0', 0, 'L', 0);

$this->pdf->Cell(30, 1, "No ", '0', 0, 'L', 0);
$this->pdf->Cell(5, 1, '', '0', 0, 'L', 0);
$this->pdf->Cell(60, 1, $nno, '0', 0, 'L', 0);
$this->pdf->Ln();

$this->pdf->setX(25);
$this->pdf->Cell(20, 1, 'Bank', '0', 0, 'L', 0);
$this->pdf->Cell(10, 1, '', '0', 0, 'L', 0);
$this->pdf->Cell(40, 1, $bank, '0', 0, 'L', 0);
$this->pdf->Cell(30, 1, "", '0', 0, 'L', 0);

$this->pdf->Cell(30, 1, "Date ", '0', 0, 'L', 0);
$this->pdf->Cell(5, 1, '', '0', 0, 'L', 0);
$this->pdf->Cell(60, 1, $daate, '0', 0, 'L', 0);
$this->pdf->Ln();

	$this->pdf->setY(45);
    $this->pdf->setX(25);

    $this->pdf->SetFont('helvetica','B',10);
    $this->pdf->Cell(20, 6,"Month", '1', 0, 'C', 0);
    $this->pdf->Cell(30, 6," interest Rate % ", '1', 0, 'C', 0);
    $this->pdf->Cell(30, 6," Merchant Id ", '1', 0, 'C', 0);
    $this->pdf->Cell(30, 6,"Acc Code ", '1', 0, 'C', 0);
    $this->pdf->Cell(55, 6,"Account Name", '1', 0, 'C', 0);
    $this->pdf->Ln();

 	$this->pdf->GetY(45);
    $this->pdf->SetX(25);
    $this->pdf->SetLineStyle(array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0.1, 'color' => array(0, 0, 0)));
    $this->pdf->SetFont('helvetica','',9);

   
    foreach($credit_card as $row){
        $this->pdf->SetX(25);
        $this->pdf->Cell(20, 6,$row->month, '1', 0, 'C', 0);
        $this->pdf->Cell(30, 6,$row->rate, '1', 0, 'R', 0);
        $this->pdf->Cell(30, 6,$row->merchant_id, '1', 0, 'R', 0);
        $this->pdf->Cell(30, 6,$row->bank_id, '1', 0, 'C', 0);
        $this->pdf->Cell(55, 6,$row->acc_des, '1', 0, 'L', 0);
       
        $this->pdf->Ln();
    }																	

	$this->pdf->Output("Credit Card Rate".date('Y-m-d').".pdf", 'I');


?>