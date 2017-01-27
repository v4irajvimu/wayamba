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
    $this->pdf->Cell(180, 1,"Pending Credit Card Details  ",0,false, 'L', 0, '', 0, false, 'M', 'M');
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
         $this->pdf->SetX(40);


         $this->pdf->SetFont('helvetica','B',8);
         $this->pdf->Cell(20, 6,"Date", '1', 0, 'C', 0);
         $this->pdf->Cell(50, 6,"Bank", '1', 0, 'C', 0);
         $this->pdf->Cell(30, 6,"Merchant Id", '1', 0, 'C', 0);
         $this->pdf->Cell(30, 6,"Rate", '1', 0, 'C', 0);
         $this->pdf->Cell(30, 6,"Amount", '1', 0, 'C', 0);
         $this->pdf->Cell(40, 6,"Int Amount", '1', 0, 'C', 0);
         $this->pdf->Cell(30, 6,"Balance", '1', 0, 'C', 0);
         
                                 
         $this->pdf->Ln();
         

    // Deatils loop            
         foreach($r_pending_credit_card as $row){
         $this->pdf->SetX(40);
         $this->pdf->SetLineStyle(array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0.1, 'color' => array(0, 0, 0)));
         $this->pdf->SetFont('helvetica','',7);
         $this->pdf->Cell(20, 6,$row->date, '1', 0, 'R', 0);
         $this->pdf->Cell(50, 6,$row->description, '1', 0, 'R', 0);
         $this->pdf->Cell(30, 6,$row->merchant_id, '1', 0, 'R', 0);
         $this->pdf->Cell(30, 6,$row->rate, '1', 0, 'R', 0);
         $this->pdf->Cell(30, 6,$row->amount, '1', 0, 'R', 0);
         $this->pdf->Cell(40, 6,$row->int_amount, '1', 0, 'R', 0);
         $this->pdf->Cell(30, 6,$row->balance, '1', 0, 'R', 0);
          $this->pdf->Ln();

         $amount=$amount+$row->amount;
         $int_amount=$int_amount+$row->int_amount;
         $balance=$balance+$row->balance;

                         
         }

         // total
             $this->pdf->SetX(40);
            $this->pdf->SetFont('helvetica','B',7);
            $this->pdf->Cell(20, 6,'', '0', 0, 'C', 0);
            $this->pdf->Cell(50, 6,'', '0', 0, 'C', 0);
            $this->pdf->Cell(30, 6,'', '0', 0, 'C', 0);
            $this->pdf->Cell(30, 6,'Total', '0', 0, 'C', 0);
            $this->pdf->Cell(30, 6,"Rs  ".number_format($amount,2), 'TB', 0, 'R', 0);
            $this->pdf->Cell(2, 6,'', '0', 0, 'C', 0);
            $this->pdf->Cell(38, 6,"Rs  ".number_format($int_amount,2), 'TB', 0, 'R', 0);
            $this->pdf->Cell(2, 6,'', '0', 0, 'C', 0);
            $this->pdf->Cell(28, 6,"Rs  ".number_format($balance,2), 'TB', 0, 'R', 0);
            

    //----------------------------------------------------------------------------------------------------



    $this->pdf->Output("Bank Entry List".date('Y-m-d').".pdf", 'I');

?>
        


