<?php
    error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
    $this->pdf->setPrintHeader($header,$type,$duration);
    $this->pdf->setPrintHeader(true,$type);
    $this->pdf->setPrintFooter(true);
    
    $this->pdf->SetFont('helvetica', 'B', 16);
    $this->pdf->AddPage($orientation,$page); 

    $branch_name="";

    //set header -----------------------------------------------------------------------------------------
    foreach($branch as $ress)
    {
        $branch_name=$ress->name;
        $this->pdf->headerSet3($ress->name,$ress->address,$ress->tp,$ress->fax,$ress->email);
    }

    $this->pdf->SetLineStyle(array('width' => 0.25, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0)));
    
    $this->pdf->SetFont('helvetica', 'BI',12);
    $this->pdf->Cell(180, 1,"Debit Note Detailes Reoprt  ",0,false, 'L', 0, '', 0, false, 'M', 'M');
    $this->pdf->Ln(3);

    $this->pdf->Cell(60, 1,"",'T',0, 'L', 0);
    $this->pdf->Ln(3); 

    $this->pdf->SetFont('helvetica', '', 8);
    $this->pdf->Cell(180, 1,"Date From - ".$dfrom."  To - ".$dto,0,false, 'L', 0, '', 0, false, 'M', 'M');
    $this->pdf->Ln(3);

    //----------------------------------------------------------------------------------------------------

    $des="default";
    $tno="default";
    $amt=(float)0;

        $colwidth_1 = 10; //no
        $colwidth_2 = 20; //date
        $colwidth_3 = 26; //Account Code
        $colwidth_4 = 40; //Acc Descrition
        $colwidth_5 = 26; //Oposit.Account
        $colwidth_6 = 35; //Description
        $colwidth_7 = 30; //Amount
        $rowsheight= 4;

        $this->pdf->SetFont('helvetica', '', 8);$this->pdf->Cell(188, 1,"",'B',0, 'L', 0);$this->pdf->Ln();
        $this->pdf->SetX(15);
        $this->pdf->SetFont('helvetica','B',8);

        $this->pdf->SetX(15);
        $this->pdf->Cell($colwidth_1, 6,"No", 'B', 0, 'R', 0);
        $this->pdf->Cell($colwidth_2, 6,"Date", 'B', 0, 'R', 0);
        $this->pdf->Cell($colwidth_3, 6, "Account Code", 'B', 0, 'L', 0);
        $this->pdf->Cell($colwidth_4, 6, "Acc Description", 'B', 0, 'L', 0);
        $this->pdf->Cell($colwidth_5, 6,"Oposit.Account", 'B', 0, 'L', 0);
        $this->pdf->Cell($colwidth_6, 6,"Description", 'B', 0, 'L', 0);
        $this->pdf->Cell($colwidth_7, 6,"Amount", 'B', 0, 'R', 0);
        $this->pdf->Ln(); 

    $x=0;
    foreach($debit_note as $row)
    {
        $this->pdf->SetFont('helvetica','',8);
        $this->pdf->SetLineStyle(array('width' => 0.25, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0)));

        $this->pdf->SetX(15);
        $this->pdf->Cell($colwidth_1, 6,$row->nno, '0', 0, 'R', 0);
        $this->pdf->Cell($colwidth_2, 6,$row->ddate, '0', 0, 'R', 0);
        $this->pdf->Cell($colwidth_3, 6,$row->cus_code, '0', 0, 'L', 0);
        $this->pdf->Cell($colwidth_4, 6,$row->customer, '0', 0, 'L', 0);
        $this->pdf->Cell($colwidth_5, 6,$row->acc_code, '0', 0, 'L', 0);
        $this->pdf->Cell($colwidth_6, 6,$row->cr_account, '0', 0, 'L', 0);
        $this->pdf->Cell($colwidth_7, 6,$row->amount, '0', 0, 'R', 0);
        $this->pdf->Ln();  
        $des=$row->description;
        $tno=$row->trans_no; 
        $amt=(float)$amt+(float)$row->amount;
        $x=$x+1;

        if($x % 5==0){
            $this->pdf->SetLineStyle(array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 1.5, 'color' => array(0, 0, 0)));
            $this->pdf->Cell(180, 1,'', 'B', 0, 'L', 0);
            $this->pdf->Ln();
        }
    } 

    $this->pdf->SetFont('helvetica','B',8);
    $this->pdf->SetX(20);
    $this->pdf->Cell(117, 6,"", '', 0, 'L', 0);
    $this->pdf->Cell($colwidth_6, 6,Total, '', 0, 'L', 0);
    $this->pdf->Cell($colwidth_7, 6,number_format($amt,2, '.', ''), 'B', 0, 'R', 0);
    $this->pdf->Ln(); 

    $this->pdf->Output("Debit Note Detailes Report".date('Y-m-d').".pdf", 'I');

?>
        