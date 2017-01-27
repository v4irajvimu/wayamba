<?php
    error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
    $this->pdf->setPrintHeader($header,$type,$duration);
    $this->pdf->setPrintHeader(true,$type);
    $this->pdf->setPrintFooter(true);
    
    $this->pdf->SetFont('helvetica', 'B', 16);
    $this->pdf->AddPage($orientation,$page); 

    $branch_name="";

    //set header -----------------------------------------------------------------------------------------
    foreach($branch as $ress){
               $this->pdf->headerSet3($ress->name,$ress->address,$ress->tp,$ress->fax,$ress->email);
            }

    $this->pdf->SetLineStyle(array('width' => 0.25, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0)));
    
    $this->pdf->setY(22);$this->pdf->SetFont('helvetica', 'BI',12);
    $this->pdf->Cell(180, 1,"Cheque Return List  ",0,false, 'L', 0, '', 0, false, 'M', 'M');
    $this->pdf->Ln();

    $this->pdf->setY(25);$this->pdf->Cell(60, 1,"",'T',0, 'L', 0);
    $this->pdf->Ln(); 

    $this->pdf->setY(28);$this->pdf->SetFont('helvetica', '', 8);
    $this->pdf->Cell(180, 1,"Date From - ".$dfrom."  To - ".$dto,0,false, 'L', 0, '', 0, false, 'M', 'M');
    $this->pdf->Ln();

    //----------------------------------------------------------------------------------------------------


    // set data ------------------------------------------------------------------------------------------

     // Headings

         $this->pdf->SetFont('helvetica', 'B', 8);
         $this->pdf->Ln();
         $this->pdf->SetX(20);


         $this->pdf->SetFont('helvetica','B',8);
         $this->pdf->Cell(15, 6,"Date", '1', 0, 'C', 0);
         $this->pdf->Cell(15, 6,"No", '1', 0, 'C', 0);
         $this->pdf->Cell(25, 6,"Cheque No", '1', 0, 'C', 0);
         $this->pdf->Cell(25, 6,"Bank", '1', 0, 'C', 0);
         $this->pdf->Cell(40, 6,"Bank Name", '1', 0, 'C', 0);
         $this->pdf->Cell(25, 6,"Realized Data", '1', 0, 'C', 0);
         $this->pdf->Cell(50, 6,"Trance Code", '1', 0, 'C', 0);
         $this->pdf->Cell(40, 6,"Transaction No", '1', 0, 'C', 0);
         $this->pdf->Cell(20, 6,"Amount", '1', 0, 'C', 0);


                        
         $this->pdf->Ln();
         

    // Deatils loop            
         foreach($r_cheque_return_list as $row){
         $this->pdf->SetX(20);
         $this->pdf->SetLineStyle(array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0.1, 'color' => array(0, 0, 0)));
         $this->pdf->SetFont('helvetica','',7);
         $this->pdf->Cell(15, 6,$row->ddate, '1', 0, 'L', 0);
         $this->pdf->Cell(15, 6,$row->no, '1', 0, 'L', 0);
         $this->pdf->Cell(25, 6,$row->cheque_no, '1', 0, 'L', 0);
         $this->pdf->Cell(25, 6,$row->code, '1', 0, 'L', 0);
         $this->pdf->Cell(40, 6,$row->BankName, '1', 0, 'L', 0);
         $this->pdf->Cell(25, 6,$row->new_bank_date, '1', 0, 'L', 0);
         $this->pdf->Cell(50, 6,$row->trans_code, '1', 0, 'L', 0);
         $this->pdf->Cell(40, 6,$row->trans_no, '1', 0, 'L', 0);
         $this->pdf->Cell(20, 6,$row->amount, '1', 0, 'R', 0);
          $this->pdf->Ln();

         $amount=$amount+$row->amount;
                  
         }

         // total
            $this->pdf->Ln();
            $this->pdf->Ln();
            $this->pdf->SetFont('helvetica','B',7);
            $this->pdf->Cell(15, 6,'', '0', 0, 'C', 0);
            $this->pdf->Cell(15, 6,'', '0', 0, 'C', 0);
            $this->pdf->Cell(25, 6,'', '0', 0, 'C', 0);
            $this->pdf->Cell(25, 6,'', '0', 0, 'C', 0);
            $this->pdf->Cell(40, 6,'', '0', 0, 'C', 0);
            $this->pdf->Cell(25, 6,'', '0', 0, 'C', 0);
            $this->pdf->Cell(50, 6,'', '0', 0, 'C', 0);
            $this->pdf->Cell(45, 6,'Total Amount', '0', 0, 'C', 0);
            $this->pdf->Cell(20, 6,"Rs  ".number_format($amount,2), 'T,B', 0, 'C', 0);

    //----------------------------------------------------------------------------------------------------



    $this->pdf->Output("Cheque Return List".date('Y-m-d').".pdf", 'I');

?>
        


