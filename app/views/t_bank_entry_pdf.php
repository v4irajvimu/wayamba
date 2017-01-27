<?php
    error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
    $this->pdf->setPrintHeader($header,$type,$duration);
    $this->pdf->setPrintHeader(true,$type);
   $this->pdf->setPrintFooter(true,'0',$is_cur_time);
    
    $this->pdf->SetFont('helvetica', 'B', 16);
    $this->pdf->AddPage('L','A5'); 

    $branch_name="";

    //set header -----------------------------------------------------------------------------------------
    foreach($branch as $ress){
               $this->pdf->headerSet4($ress->name,$ress->address,$ress->tp,$ress->fax,$ress->email);
            }

    $align_h=$this->utility->heading_align();

    $this->pdf->SetLineStyle(array('width' => 0.25, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0)));
    
    $this->pdf->setY(22);$this->pdf->SetFont('helvetica', 'BU',10);
    $orgin_print=$_POST['org_print'];
    if($orgin_print=="1"){
    $this->pdf->Cell(180, 1,"BANK ENTRY ",0,false, $align_h, 0, '', 0, false, 'M', 'M');
    }else{
    $this->pdf->Cell(180, 1,"BANK ENTRY (DUPLICATE) ",0,false, $align_h, 0, '', 0, false, 'M', 'M');
    }
    $this->pdf->Ln();

    

    foreach($session as $ses){
        $invoice_no=$session[0].$session[1].$session[2];
    }

    foreach($r_bank_entry as $row){
        $date        = $row->dDate;
        $type        = $row->type;
        $ref         = $row->ref_no;
        $cr          = $row->craccId;
        $cr_des      = $row->cracc_des;
        $dr          = $row->draccId;
        $dr_des      = $row->dracc_des;
        $description = $row->description;
        $narration   = $row->narration;
        $batch       = $row->batch_code;
        $amount      = $row->amount;                          
    }


    $amount_latter = $rec;

    if($type=="OtherBankEntry"){
        $types = "Other Bank Entry";
    }else if($type=="CashEntry"){
        $types = "Cash Entry";
    }

        $this->pdf->SetX(20);
        $this->pdf->Ln();
        
        $this->pdf->SetFont('helvetica','B',8);
        $this->pdf->Cell(105, 6,"", '0', 0, 'L', 0);
        $this->pdf->Cell(25, 6,"No", '0', 0, 'L', 0);
        $this->pdf->SetFont('helvetica','',8);
        $this->pdf->Cell(10, 6,$invoice_no, '0', 0, 'L', 0);
        $this->pdf->Ln();

        $this->pdf->SetFont('helvetica','B',8);
        $this->pdf->Cell(105, 6,"", '0', 0, 'L', 0);
        $this->pdf->Cell(25, 6,"Date", '0', 0, 'L', 0);
        $this->pdf->SetFont('helvetica','',8);
        $this->pdf->Cell(10, 6,$date.$save_time, '0', 0, 'L', 0);
        $this->pdf->Ln();

        $this->pdf->SetFont('helvetica','B',8);
        $this->pdf->Cell(105, 6,"", '0', 0, 'L', 0);
        $this->pdf->Cell(25, 6,"Ref. No", '0', 0, 'L', 0);
        $this->pdf->SetFont('helvetica','',8);
        $this->pdf->Cell(10, 6,$ref, '0', 0, 'L', 0);
        $this->pdf->Ln();

        $this->pdf->SetFont('helvetica','B',8);
        $this->pdf->Cell(25, 6,"Type", '0', 0, 'L', 0);
        $this->pdf->SetFont('helvetica','',8);
        $this->pdf->Cell(25, 6,$types, '0', 0, 'L', 0);

        $this->pdf->Ln();

        $this->pdf->SetFont('helvetica','B',8);
        $this->pdf->Cell(25, 6,"Credit Account", '0', 0, 'L', 0);
        $this->pdf->SetFont('helvetica','',8);
        $this->pdf->Cell(55, 6,$cr." - ".$cr_des, '0', 0, 'L', 0);

        $this->pdf->Ln();

        $this->pdf->SetFont('helvetica','B',8);
        $this->pdf->Cell(25, 6,"Debit Account", '0', 0, 'L', 0);
        $this->pdf->SetFont('helvetica','',8);
        $this->pdf->Cell(55, 6,$dr." - ".$dr_des, '0', 0, 'L', 0);

        $this->pdf->Ln();

        $this->pdf->SetFont('helvetica','B',8);
        $this->pdf->Cell(25, 6,"Description", '0', 0, 'L', 0);
        $this->pdf->SetFont('helvetica','',8);
        $this->pdf->Cell(55, 6,$description, '0', 0, 'L', 0);

        $this->pdf->Ln();

        $this->pdf->SetFont('helvetica','B',8);
        $this->pdf->Cell(25, 6,"Narration", '0', 0, 'L', 0);
        $this->pdf->SetFont('helvetica','',8);
        $this->pdf->Cell(55, 6,$narration, '0', 0, 'L', 0);

        $this->pdf->Ln();

        $this->pdf->SetFont('helvetica','B',8);
        $this->pdf->Cell(25, 6,"Batch", '0', 0, 'L', 0);
        $this->pdf->SetFont('helvetica','',8);
        $this->pdf->Cell(55, 6,$batch, '0', 0, 'L', 0);

   
        $this->pdf->Ln();
   
        $this->pdf->SetFont('helvetica','',8);
        $this->pdf->Cell(25, 6,"", '0', 0, 'L', 0);
        $this->pdf->Cell(105, 6,"Amount invert".$amount_latter, '0', 0, 'L', 0);
       
        $this->pdf->Ln();
       
        $this->pdf->SetFont('helvetica','B',8);
        $this->pdf->Cell(25, 6,"Amount", '0', 0, 'L', 0);
        $this->pdf->SetFont('helvetica','B',15);
        $this->pdf->Cell(55, 6,"Rs.  ".$amount, '1', 0, 'R', 0);

        $this->pdf->Ln();

      
        

        

//$this->pdf->Cell(20, 6,"Rs  ".number_format($amount,2), 'T,B', 0, 'C', 0);

    //----------------------------------------------------------------------------------------------------

            $this->pdf->SetFont('helvetica', '', 8);
                    
            $this->pdf->Ln();
            $this->pdf->Cell(50, 1, '...................................', '0', 0, 'L', 0);
            $this->pdf->Cell(50, 1, '...................................', '0', 0, 'L', 0);
            $this->pdf->Cell(50, 1, '...................................', '0', 0, 'L', 0);

            $this->pdf->Ln();
            $this->pdf->Cell(50, 1, '       Prepaired By', '0', 0, 'L', 0);
            $this->pdf->Cell(50, 1, '         Checked By', '0', 0, 'L', 0);
            $this->pdf->Cell(50, 1, ' Cashier Signature', '0', 0, 'L', 0);
         
            $this->pdf->Ln();  
            $this->pdf->Ln();  


            $tt = date("H:i");
            
            $this->pdf->Cell(20, 6, "Print Time ", '0', 0, 'L', 0);
            $this->pdf->Cell(1, 6, $tt, '0', 0, 'L', 0);
            $this->pdf->Ln();


    $this->pdf->Output("Bank Entry ".date('Y-m-d').".pdf", 'I');

?>
        


