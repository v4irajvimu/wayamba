<?php

	$this->pdf->setPrintHeader($header,$type,$duration);
    //$this->pdf->setPrintFooter(true);        
    $this->pdf->SetFont('helvetica', 'B', 11);
	$this->pdf->AddPage("P","A4");   // L or P amd page type A4 or A3

	$this->pdf->setY(25);

	$this->pdf->SetFont('helvetica', '',12);
 	$this->pdf->Cell(0, 5, 'Due Day Change',0,false, 'C', 0, '', 0, false, 'M', 'M');
	$this->pdf->Ln();$this->pdf->Ln();

	$this->pdf->SetY(35);
	$this->pdf->SetX(25);
	$this->pdf->SetFont('helvetica','',8);

    $this->pdf->Cell(25,0,"Agreement No", '0', 0, 'L', 0);
    $this->pdf->Cell(50,0,$sum->agr_no, '0', 0, 'L', 0);
    $this->pdf->Cell(50,0,"", '0', 0, 'R', 0);
    $this->pdf->Cell(10,0,"No", '0', 0, 'R', 0);
    $this->pdf->Cell(20,0,$sum->no, '0', 1, 'L', 0);    

    $this->pdf->SetX(25);
    $this->pdf->Cell(25,0,"Customer Code", '0', 0, 'L', 0);
    $this->pdf->Cell(50,0,$sum->cus_id, '0', 0, 'L', 0);
    $this->pdf->Cell(50,0,"", '0', 0, '', 0);
    $this->pdf->Cell(10,0,"Date", '0', 0, 'R', 0);
    $this->pdf->Cell(20,0,$sum->date, '0', 1, 'L', 0);

    $this->pdf->SetX(25);
    $this->pdf->Cell(25,0,"Customer Name", '0', 0, 'L', 0);
    $this->pdf->Cell(50,0,$sum->name, '0', 1, 'L', 0);

    $this->pdf->SetX(25);
    $this->pdf->Cell(25,0,"Loan Date", '0', 0, 'L', 0);
    $this->pdf->Cell(50,0,$sum->loan_date, '0', 1, 'L', 0);

    $this->pdf->SetX(25);
    $this->pdf->Cell(25,0,"Last Change Date", '0', 0, 'L', 0);
    $this->pdf->Cell(50,0,$sum->last_chge_date, '0', 1, 'L', 0);

    $this->pdf->SetX(25);
    $this->pdf->Cell(25,0,"No of installment", '0', 0, 'L', 0);
    $this->pdf->Cell(50,0,$sum->noi, '0', 1, 'L', 0);

    $this->pdf->SetX(25);
    $this->pdf->Cell(25,0,"New Due Day", '0', 0, 'L', 0);
    $this->pdf->Cell(50,0,$sum->new_due_day, '0', 1, 'L', 0);


    $this->pdf->Ln();


    	$this->pdf->SetX(25);
		$this->pdf->SetFont('helvetica','B',8);
		
        $this->pdf->Cell(15, 0,"Inst No", '1', 0, 'L', 0);		
        $this->pdf->Cell(20, 0,"Old Date", '1', 0, 'L', 0);		
        $this->pdf->Cell(20, 0,"New Date", '1', 0, 'L', 0);				
        $this->pdf->Ln();

    foreach ($det as $R) {
	
		$this->pdf->SetX(25);
		$this->pdf->SetFont('helvetica','',8);
		
        $this->pdf->Cell(15, 0,$R->ints_no, '1', 0, 'C', 0);		
        $this->pdf->Cell(20, 0,$R->old_date, '1', 0, 'L', 0);		
        $this->pdf->Cell(20, 0,$R->new_date, '1', 0, 'L', 0);				
        $this->pdf->Ln();
    	
    }
	
	$this->pdf->Output("due_day_change_".date('Y-m-d').".pdf", 'I');

?>