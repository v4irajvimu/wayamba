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
    
    $this->pdf->setY(22);$this->pdf->SetFont('helvetica', 'BUI',12);
    $this->pdf->Cell(180, 1,"Petty Cash Summery   ",0,false, 'L', 0, '', 0, false, 'M', 'M');
    $this->pdf->Ln();


    $this->pdf->setY(28);$this->pdf->SetFont('helvetica', '', 10);
    $this->pdf->Cell(180, 1,"Date Form - ".$dfrom."  To - ".$dto,0,false, 'L', 0, '', 0, false, 'M', 'M');
    $this->pdf->Ln();

    
    //----------------------------------------------------------------------------------------------------



   $this->pdf->Ln();
   $this->pdf->Ln();
  foreach($r_branch_name as $row){
        
   $branch_name=$row->name;
   $cluster_name=$row->description;
   $cl_id=$row->code;
   $bc_id=$row->bc;


}
       $this->pdf->SetX(20);
       $this->pdf->setY(22);$this->pdf->SetFont('helvetica', '', 10);
       $this->pdf->Ln();
       $this->pdf->Ln();
       $this->pdf->Cell(20,4,'Cluster', '0', 0, 'L', 0);
       $this->pdf->Cell(5,4,':', '0', 0, 'L', 0);
       $this->pdf->Cell(120, 4,"$cl_id - $cluster_name", '0', 0, 'L', 0);
       $this->pdf->Ln();
       $this->pdf->Cell(20,4,'Branch', '0', 0, 'L', 0);
       $this->pdf->Cell(5,4,':', '0', 0, 'L', 0);
       $this->pdf->Cell(20,4, "$bc_id - $branch_name", '0', 0, 'L', 0);
           
 
         // Headings

         $this->pdf->SetFont('helvetica', 'B', 9);
         $this->pdf->Ln();
         $this->pdf->SetX(16);


         $this->pdf->SetFont('helvetica','B',9);
         $this->pdf->Cell(20, 6,"No", '1', 0, 'C', 0);
         $this->pdf->Cell(25, 6,"Date", '1', 0, 'C', 0);
         $this->pdf->Cell(90, 6,"Description ", '1', 0, 'C', 0);
         $this->pdf->Cell(30, 6,"Amount", '1', 0, 'C', 0);
         $this->pdf->Ln();
         $tot_amount=(float)0;

         // Deatils loop            
         foreach($r_petty_cash_summery as $row){
         $this->pdf->SetX(16);
         $this->pdf->SetLineStyle(array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0.1, 'color' => array(0, 0, 0)));
         $this->pdf->SetFont('helvetica','',9);
          $aa = $this->pdf->getNumLines($row->dis, 90);
         
          $heigh=5*$aa;
           
         $this->pdf->MultiCell(20, 6,$row->no, 1, 'R', 0, 0, '', '', true, 0, false, true, 0);
         $this->pdf->MultiCell(25, 6,$row->date, 1, 'L', 0, 0, '', '', true, 0, false, true, 0);
         $this->pdf->MultiCell(90, 6,$row->dis, 1, 'L', 0, 0, '', '', true, 0, false, true, 0);
         $this->pdf->MultiCell(30, 6,number_format($row->total,2), 1, 'R', 0, 1, '', '', true, 0, false, true, 0);
          
          $tot_amount+=(float)$row->total;
                  
         }

      $this->pdf->SetFont('helvetica','B',9);             
      $this->pdf->SetX(16);
      $this->pdf->Cell(20, 6, "", '0', 0, 'L', 0);
      $this->pdf->Cell(25, 6, "", '0', 0, 'R', 0);
      $this->pdf->Cell(90, 6, "Total", '0', 0, 'C', 0);
      $this->pdf->Cell(30, 6, number_format($tot_amount,2), '1', 0, 'R', 0);

      $this->pdf->Ln();
      $this->pdf->Ln();
      $this->pdf->Ln();

      foreach($r_branch_name as $value){

        
        

         // Deatils loop            
         $x=0;
         foreach($cancelled as $row){
          if($row->count!="0")
          {
             
             if($x==0)
            {
               $this->pdf->SetFont('helvetica', 'BU',12);
               $this->pdf->Cell(0, 5, 'Cancelled Voucher List   ',0,false, 'L', 0, '', 0, false, 'M', 'M');
               $this->pdf->Ln();
               $this->pdf->Ln();
  

               $this->pdf->SetX(16);
               $this->pdf->SetFont('helvetica','B',9);
               $this->pdf->Cell(20, 6,"No", '1', 0, 'C', 0);
               $this->pdf->Cell(25, 6,"Date", '1', 0, 'C', 0);
               $this->pdf->Cell(90, 6,"Description ", '1', 0, 'C', 0);
               $this->pdf->Cell(30, 6,"Amount", '1', 0, 'C', 0);
               $this->pdf->Ln();
               $x++;
            }
         }
         $tot_amount=(float)0;

         $this->pdf->SetX(16);
         $this->pdf->SetLineStyle(array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0.1, 'color' => array(0, 0, 0)));
         $this->pdf->SetFont('helvetica','',9);
          $aa = $this->pdf->getNumLines($row->dis, 90);
         
          $heigh=5*$aa;
           
         $this->pdf->MultiCell(20, 6,$row->no, 1, 'R', 0, 0, '', '', true, 0, false, true, 0);
         $this->pdf->MultiCell(25, 6,$row->date, 1, 'L', 0, 0, '', '', true, 0, false, true, 0);
         $this->pdf->MultiCell(90, 6,$row->dis, 1, 'L', 0, 0, '', '', true, 0, false, true, 0);
         $this->pdf->MultiCell(30, 6,number_format($row->total,2), 1, 'R', 0, 1, '', '', true, 0, false, true, 0);
          
          $tot_amount+=(float)$row->total;

      }

          if($x==1){  
          $this->pdf->SetFont('helvetica','B',9);             
          $this->pdf->SetX(16);
          $this->pdf->Cell(20, 6, "", '0', 0, 'L', 0);
          $this->pdf->Cell(25, 6, "", '0', 0, 'R', 0);
          $this->pdf->Cell(90, 6, "Total", '0', 0, 'C', 0);
          $this->pdf->Cell(30, 6, number_format($tot_amount,2), '1', 0, 'R', 0);
          }

    }
       
    //----------------------------------------------------------

        $this->pdf->Output("petty_cash_summery".date('Y-m-d').".pdf", 'I');

?>
        


