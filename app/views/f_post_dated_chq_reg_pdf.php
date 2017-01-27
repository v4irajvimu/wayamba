<?php
    error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
    $this->pdf->setPrintHeader($header,$type,$duration);

    $this->pdf->setPrintFooter(true);
    $this->pdf->setPrintHeader(true);
    $this->pdf->setPrintHeader($header,$type);  
    
    $this->pdf->SetFont('helvetica', 'B', 16);
	$this->pdf->AddPage($orientation,$page); 
       
    foreach($branch as $ress){
 		$this->pdf->headerSet3($ress->name,$ress->address,$ress->tp,$ress->fax,$ress->email);
	}

	$this->pdf->setY(18);
    $this->pdf->Ln();
    $this->pdf->SetFont('helvetica', 'IBU', 14);
 	$this->pdf->Cell(280, 1,"POST DATED CHEQUES REGISTRY",0,false, 'L', 0, '', 0, false, 'M', 'M');

	$this->pdf->Ln();
    /*
    $this->pdf->SetFont('helvetica', 'B', 9);
    $this->pdf->Cell(25, 1,"As At Date",0,false, 'L', 0, '', 0, false, 'M', 'M');
    $this->pdf->Cell(225, 1,$all_det["date"],0,false, 'L', 0, '', 0, false, 'M', 'M');
    */
    $this->pdf->SetFont('helvetica','B',8);
    $this->pdf->Cell(20, 6, " Date", '1', 0, 'L', 0);
    $this->pdf->Cell(40, 6, " Customer", '1', 0, 'L', 0);
    $this->pdf->Cell(20, 6, " Chq No", '1', 0, 'R', 0);
    $this->pdf->Cell(25, 6, " Amount", '1', 0, 'R', 0);
    $this->pdf->Cell(25, 6, "Account ", '1', 0, 'L', 0);
    $this->pdf->Cell(40, 6, "Bank  ", '1', 0, 'L', 0);
    $this->pdf->Cell(40, 6, "Branch  ", '1', 0, 'L', 0);
    $this->pdf->Cell(10, 6, "A. No", '1', 0, 'R', 0);
    $this->pdf->Cell(20, 6, "Rpt Date  ", '1', 0, 'R', 0);
    $this->pdf->Cell(10, 6, "Rpt No", '1', 0, 'R', 0);
    $this->pdf->Cell(20, 6, "Bank Date", '1', 0, 'R', 0);
    $this->pdf->Ln();

	$this->pdf->setY(35);
	$len=count($all_det);
    $act_len=(int)(($len-11)/14);
    for($x=0; $x<$act_len; $x++){
        if($all_det['dt_'.$x]!="" && $all_det['chqn_'.$x] !=""){
            $this->pdf->SetLineStyle(array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0.1, 'color' => array(0, 0, 0)));
    		$this->pdf->setX(15);
            $this->pdf->SetFont('helvetica','',8);
            $aa = $this->pdf->getNumLines($all_det['ccode_'.$x]." - ".$all_det['c_'.$x], 40);
            $bb = $this->pdf->getNumLines($all_det['bcode_'.$x]." - ".$all_det['b_'.$x], 40);
            $cc = $this->pdf->getNumLines($all_det['bbcode_'.$x]." - ".$all_det['bb_'.$x], 40);
            if($aa>$bb){
                $heigh=5*$aa;
            }else if($bb>$aa){
                $heigh=5*$bb;
            }else{
                $heigh=5*$cc;
            }
            $this->pdf->MultiCell(20, $heigh,$all_det['dt_'.$x],  1, 'L', 0, 0, '', '', true, 0, false, true, 0);
            $this->pdf->MultiCell(40, $heigh,$all_det['ccode_'.$x]." - ".$all_det['c_'.$x], 1, 'L', 0, 0, '', '', true, 0, false, true, 0);
            $this->pdf->MultiCell(20, $heigh,$all_det['chqn_'.$x], 1, 'R', 0, 0, '', '', true, 0, false, true, 0);
            $this->pdf->MultiCell(25, $heigh,$all_det['amnt_'.$x], 1, 'R', 0, 0, '', '', true, 0, false, true, 0);
            $this->pdf->MultiCell(25, $heigh,$all_det['acc_'.$x], 1, 'L', 0, 0, '', '', true, 0, false, true, 0);
            $this->pdf->MultiCell(40, $heigh,$all_det['bcode_'.$x]." - ".$all_det['b_'.$x],  1, 'L', 0, 0, '', '', true, 0, false, true, 0);
            $this->pdf->MultiCell(40, $heigh,$all_det['bbcode_'.$x]." - ".$all_det['bb_'.$x], 1, 'L', 0, 0, '', '', true, 0, false, true, 0);
            $this->pdf->MultiCell(10, $heigh,$all_det['ack_'.$x], 1, 'R', 0, 0, '', '', true, 0, false, true, 0);
            $this->pdf->MultiCell(20, $heigh,$all_det['rd_'.$x], 1, 'R', 0, 0, '', '', true, 0, false, true, 0);
            $this->pdf->MultiCell(10, $heigh,$all_det['rn_'.$x], 1, 'R', 0, 0, '', '', true, 0, false, true, 0);
            $this->pdf->MultiCell(20, $heigh,$all_det['bd_'.$x], 1, 'R', 0, 1, '', '', true, 0, false, true, 0);
        }
    }
	$this->pdf->Output($title.date('Y-m-d').".pdf", 'I');
?>