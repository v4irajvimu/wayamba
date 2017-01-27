<?php
      error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
      $this->pdf->setPrintHeader($header,$type,$duration);
        $this->pdf->setPrintFooter(true);
       // print_r($det);
        $this->pdf->SetFont('helvetica', 'B', 16);
      $this->pdf->AddPage($orientation,$page);   // L or P amd page type A4 or A3

      foreach($branch as $ress){
               $this->pdf->headerSet3($ress->name,$ress->address,$ress->tp,$ress->fax,$ress->email);
            }

      $cus_name=$cus_address="";

      foreach($det as $row){
      $store=$row->store;
      $date=$row->ddate;
      $officer=$row->name;
      $ref_no=$row->ref_no;
      $memo=$row->memo;
      $nno=$row->nno;
      $amount=$row->amount;
      $sname=$row->sname;
      }
      foreach($session as $ses){
         $invoice_no=$session[0].$session[1].$session[2];
      }

         $this->pdf->setY(20);
         $this->pdf->SetFont('helvetica', 'BU', 10);
         $this->pdf->Ln();
         $this->pdf->Cell(0, 5, 'Bank Entry List  ',0,false, 'C', 0, '', 0, false, 'M', 'M');
         $this->pdf->Ln();

         // Headings

         $this->pdf->SetFont('helvetica', 'B', 8);
         $this->pdf->Ln();
         $this->pdf->SetX(20);


         $this->pdf->SetFont('helvetica','B',8);
         $this->pdf->Cell(15, 6,"Date", '1', 0, 'C', 0);
         $this->pdf->Cell(15, 6,"No", '1', 0, 'C', 0);
         $this->pdf->Cell(25, 6,"Type", '1', 0, 'C', 0);
         $this->pdf->Cell(25, 6,"Cr Acc", '1', 0, 'C', 0);
         $this->pdf->Cell(45, 6,"Cr Acc Name", '1', 0, 'C', 0);
         $this->pdf->Cell(25, 6,"Dr Acc", '1', 0, 'C', 0);
         $this->pdf->Cell(45, 6,"Dr Acc Name", '1', 0, 'C', 0);
         $this->pdf->Cell(40, 6,"Description", '1', 0, 'C', 0);
         $this->pdf->Cell(20, 6,"Amount", '1', 0, 'C', 0);


                        
         $this->pdf->Ln();
         

        // Deatils loop            
         foreach(t_bank_entry_list as $row){
         $this->pdf->SetX(20);
         $this->pdf->SetLineStyle(array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0.1, 'color' => array(0, 0, 0)));
         $this->pdf->SetFont('helvetica','',7);
         $this->pdf->Cell(15, 6,$row->dDate, '1', 0, 'L', 0);
         $this->pdf->Cell(15, 6,$row->nno, '1', 0, 'L', 0);
         $this->pdf->Cell(25, 6,$row->type, '1', 0, 'L', 0);
         $this->pdf->Cell(25, 6,$row->craccId, '1', 0, 'L', 0);
         $this->pdf->Cell(45, 6,$row->cracc_des, '1', 0, 'L', 0);
         $this->pdf->Cell(25, 6,$row->draccId, '1', 0, 'L', 0);
         $this->pdf->Cell(45, 6,$row->dracc_des, '1', 0, 'L', 0);
         $this->pdf->Cell(40, 6,$row->narration, '1', 0, 'L', 0);
         $this->pdf->Cell(20, 6,$row->amount, '1', 0, 'L', 0);

         $amount=$row->amount;
                  
         }

         // total
            $this->pdf->Ln();
            $this->pdf->Ln();
            $this->pdf->SetFont('helvetica','B',7);
            $this->pdf->Cell(15, 6,'', '0', 0, 'C', 0);
            $this->pdf->Cell(15, 6,'', '0', 0, 'C', 0);
            $this->pdf->Cell(25, 6,'', '0', 0, 'C', 0);
            $this->pdf->Cell(25, 6,'', '0', 0, 'C', 0);
            $this->pdf->Cell(45, 6,'', '0', 0, 'C', 0);
            $this->pdf->Cell(25, 6,'', '0', 0, 'C', 0);
            $this->pdf->Cell(45, 6,'', '0', 0, 'C', 0);
            $this->pdf->Cell(45, 6,'Total Amount', '0', 0, 'C', 0);
            $this->pdf->Cell(20, 6,"Rs  ".number_format($amount,2), 'T,B', 0, 'C', 0);


   //$this->pdf->footerSet($employee,$amount,$additional,$discount,$user);

   $this->pdf->Output("Bank Entry List".date('Y-m-d').".pdf", 'I');

?>