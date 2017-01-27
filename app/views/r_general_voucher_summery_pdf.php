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
    
    $this->pdf->SetFont('helvetica', 'BUI',12);
    $this->pdf->Cell(300, 1,"General Voucher List - Summery  ",0,false, 'L', 0, '', 0, false, 'M', 'M');
    $this->pdf->Ln();



    $this->pdf->SetFont('helvetica', '', 10);
    $this->pdf->Cell(180, 1,"Date Form - ".$dfrom."  To - ".$dto,0,false, 'L', 0, '', 0, false, 'M', 'M');
    $this->pdf->Ln(3);

    
    //----------------------------------------------------------------------------------------------------




    foreach($r_branch_name as $row){
        
       $branch_name=$row->name;
       $cluster_name=$row->description;
       $cl_id=$row->code;
       $bc_id=$row->bc;


}

   $this->pdf->SetFont('helvetica', '', 10);
   $this->pdf->Cell(20, 4,'Cluster', '0', 0, 'L', 0);
   $this->pdf->Cell(5, 4,':', '0', 0, 'L', 0);
   $this->pdf->Cell(120, 4,"$cl_id - $cluster_name", '0', 0, 'L', 0);
   $this->pdf->Ln();
   $this->pdf->Cell(20, 4,'Branch', '0', 0, 'L', 0);
   $this->pdf->Cell(5, 4,':', '0', 0, 'L', 0);
   $this->pdf->Cell(20, 4,"$bc_id - $branch_name", '0', 0, 'L', 0);
       
    
   // Headings

   $this->pdf->SetFont('helvetica', 'B', 9);
   $this->pdf->Ln();
   $this->pdf->SetX(16);

         
   $this->pdf->Cell(20, 6,"Date", '1', 0, 'C', 0);
   $this->pdf->Cell(25, 6,"Voucher No", '1', 0, 'C', 0);
   $this->pdf->Cell(85, 6,"Description", '1', 0, 'C', 0);
   $this->pdf->Cell(30, 6,"Cash", '1', 0, 'C', 0);
   $this->pdf->Cell(30, 6,"Cheque", '1', 0, 'C', 0);
   $this->pdf->Cell(30, 6,"Total Paid", '1', 0, 'C', 0);
   $this->pdf->Ln();
   

  // Deatils loop            
  foreach($r_general_voucher_summery as $row){
   $this->pdf->SetX(16);
   $this->pdf->SetFont('helvetica','',9);

   $aa = $this->pdf->getNumLines($row->note, 85);
   $heigh=6*$aa;

   $cash=$row->cash_amount;
   $cheque=$row->cheque_amount;
   $totalamt=$cash+$cheque;

   $this->pdf->SetLineStyle(array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0.1, 'color' => array(0, 0, 0)));
  
   $this->pdf->SetFont('helvetica', '', 9);
   $this->pdf->SetX(16);

   $this->pdf->MultiCell(20, $heigh, $row->ddate,1, 'L', 0, 0, '', '', true, 0, false, true, 0);
   $this->pdf->MultiCell(25, $heigh, $row->nno, 1, 'R', 0, 0, '', '', true, 0, false, true, 0);
   $this->pdf->MultiCell(85, $heigh, $row->note, 1, 'L', 0, 0, '', '', true, 0, false, true, 0);
   $this->pdf->MultiCell(30, $heigh, number_format($row->cash_amount,2), 1, 'R', 0, 0, '', '', true, 0, false, true, 0);
   $this->pdf->MultiCell(30, $heigh, number_format($row->cheque_amount,2), 1, 'R', 0, 0, '', '', true, 0, false, true, 0);
   $this->pdf->MultiCell(30, $heigh, number_format($totalamt,2), 1, 'R', 0, 1, '', '', true, 0, false, true, 0);
  
  $cash_tot+=$row->cash_amount;
  $cheque_tot+=$row->cheque_amount;
  $Tot_paid+=$totalamt;
    
          
}
  $this->pdf->SetFont('helvetica', 'B', 9);
  $this->pdf->SetX(16);

  $this->pdf->MultiCell(20, $heigh, "",0, 'L', 0, 0, '', '', true, 0, false, true, 0);
  $this->pdf->MultiCell(25, $heigh, "", 0, 'L', 0, 0, '', '', true, 0, false, true, 0);
  $this->pdf->MultiCell(85, $heigh, "Total", 0, 'C', 0, 0, '', '', true, 0, false, true, 0);
  $this->pdf->MultiCell(30, $heigh, number_format($cash_tot,2), 1, 'R', 0, 0, '', '', true, 0, false, true, 0);
  $this->pdf->MultiCell(30, $heigh, number_format($cheque_tot,2), 1, 'R', 0, 0, '', '', true, 0, false, true, 0);
  $this->pdf->MultiCell(30, $heigh, number_format($Tot_paid,2), 1, 'R', 0, 1, '', '', true, 0, false, true, 0);


  $this->pdf->Ln();
  $this->pdf->Ln();
  $this->pdf->Ln();

 foreach ($cancled as $value) {
              
      $this->pdf->SetFont('helvetica', 'BU',12);
      $this->pdf->Cell(0, 5, 'Cancled Voucher List     ',0,false, 'L', 0, '', 0, false, 'M', 'M');
      $this->pdf->Ln();
      $this->pdf->Ln();
      
      $this->pdf->SetX(15);
      // Headings


       $this->pdf->SetFont('helvetica', 'B', 9);
       $this->pdf->Ln();
       $this->pdf->SetX(16);

             
       $this->pdf->Cell(20, 6,"Date", '1', 0, 'C', 0);
       $this->pdf->Cell(25, 6,"Voucher No", '1', 0, 'C', 0);
       $this->pdf->Cell(85, 6,"Description", '1', 0, 'C', 0);
       $this->pdf->Cell(30, 6,"Cash", '1', 0, 'C', 0);
       $this->pdf->Cell(30, 6,"Cheque", '1', 0, 'C', 0);
       $this->pdf->Cell(30, 6,"Total Paid", '1', 0, 'C', 0);
       $this->pdf->Ln();
       

      // Deatils loop            
      foreach($cancled as $row){
       $this->pdf->SetX(16);
       $this->pdf->SetFont('helvetica','',9);

       $aa = $this->pdf->getNumLines($row->note, 85);
       $heigh=6*$aa;

       $cash=$row->cash_amount;
       $cheque=$row->cheque_amount;
       $totalamt=$cash+$cheque;

       $this->pdf->SetLineStyle(array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0.1, 'color' => array(0, 0, 0)));
      
       $this->pdf->SetFont('helvetica', '', 9);
       $this->pdf->SetX(16);

       $this->pdf->MultiCell(20, $heigh, $row->ddate,1, 'L', 0, 0, '', '', true, 0, false, true, 0);
       $this->pdf->MultiCell(25, $heigh, $row->nno, 1, 'R', 0, 0, '', '', true, 0, false, true, 0);
       $this->pdf->MultiCell(85, $heigh, $row->note, 1, 'L', 0, 0, '', '', true, 0, false, true, 0);
       $this->pdf->MultiCell(30, $heigh, number_format($row->cash_amount,2), 1, 'R', 0, 0, '', '', true, 0, false, true, 0);
       $this->pdf->MultiCell(30, $heigh, number_format($row->cheque_amount,2), 1, 'R', 0, 0, '', '', true, 0, false, true, 0);
       $this->pdf->MultiCell(30, $heigh, number_format($totalamt,2), 1, 'R', 0, 1, '', '', true, 0, false, true, 0);
      
      $cash_tot+=$row->cash_amount;
      $cheque_tot+=$row->cheque_amount;
      $Tot_paid+=$totalamt;
        
              
    }
      $this->pdf->SetFont('helvetica', 'B', 9);
      $this->pdf->SetX(16);

      $this->pdf->MultiCell(20, $heigh, "",0, 'L', 0, 0, '', '', true, 0, false, true, 0);
      $this->pdf->MultiCell(25, $heigh, "", 0, 'L', 0, 0, '', '', true, 0, false, true, 0);
      $this->pdf->MultiCell(85, $heigh, "Total", 0, 'C', 0, 0, '', '', true, 0, false, true, 0);
      $this->pdf->MultiCell(30, $heigh, number_format($cash_tot,2), 1, 'R', 0, 0, '', '', true, 0, false, true, 0);
      $this->pdf->MultiCell(30, $heigh, number_format($cheque_tot,2), 1, 'R', 0, 0, '', '', true, 0, false, true, 0);
      $this->pdf->MultiCell(30, $heigh, number_format($Tot_paid,2), 1, 'R', 0, 1, '', '', true, 0, false, true, 0);



}
        $this->pdf->Output("general_reciept_summery".date('Y-m-d').".pdf", 'I');
           
?>
        


