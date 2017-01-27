<?php

   
    error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
    $this->pdf->setPrintHeader($header,$type,$duration);
    $this->pdf->setPrintHeader(true,$type);
    $this->pdf->setPrintFooter(true);
    
    $this->pdf->SetFont('helvetica', 'B', 16);
    $this->pdf->AddPage($orientation,$page); 

    $branch_name="";
    foreach($branch as $ress){
        $branch_name=$ress->name;
        $this->pdf->headerSet3($ress->name,$ress->address,$ress->tp,$ress->fax,$ress->email);
    }

    $this->pdf->SetX(15);
    $this->pdf->setY(25);
    $this->pdf->SetFont('helvetica', 'BU',10);
    $this->pdf->Cell(180, 1,"LEDGER ACCOUNT REPORT",0,false, 'L', 0, '', 0, false, 'M', 'M');
    $this->pdf->Ln();

    // $this->pdf->setY(35);
    // $this->pdf->setX(25);
    // $this->pdf->SetFont('helvetica', '', 8);

    $this->pdf->Ln();
    $this->pdf->setY(30);

    // $this->pdf->SetY(43);
    // $this->pdf->SetX(20);
    // $this->pdf->Ln();

    $rtype="default";
    $type="default";
    $count=(Int)0;


    $this->pdf->Ln();  

    //$sql6="SELECT * FROM `m_account_type` t WHERE t.`control_category`='".$row5->code."'"; 
    $this->pdf->SetLineStyle(array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0.1, 'color' => array(0, 0, 0)));
    $this->pdf->SetFont('helvetica', 'B', 8);

    $this->pdf->Cell(30, 6,"Account Code", '1', 0, 'C', 0);
    $this->pdf->Cell(100, 6,"Account Name", '1', 0, 'C', 0);
    $this->pdf->Ln();
    $this->pdf->SetLineStyle(array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0.1, 'color' => array(0, 0, 0)));
    $this->pdf->SetFont('helvetica', '', 8);
    $sql6="SELECT * FROM `m_account_type` t WHERE t.is_ledger_acc=1";
    $query=$this->db->query($sql6)->result();
    foreach($query as $row6){
       // $this->pdf->Cell(115, 6,"", 'TR', 0, 'L', 0);
        $this->pdf->Cell(30, 6,$row6->code, '1', 0, 'L', 0);
        $this->pdf->Cell(100, 6,$row6->heading, '1', 0, 'L', 0);
        $this->pdf->Ln(); 
    }
                                      

    $this->pdf->Output("Chart Of Account Report".date('Y-m-d').".pdf", 'I');

?>
