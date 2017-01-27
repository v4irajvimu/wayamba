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
    $this->pdf->Cell(180, 1,"General Recipt Summery   ",0,false, 'L', 0, '', 0, false, 'M', 'M');
    $this->pdf->Ln();
    $this->pdf->Ln(); 


    $this->pdf->setY(28);$this->pdf->SetFont('helvetica', '',10);
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
   $this->pdf->setY(28);$this->pdf->SetFont('helvetica', '', 10);
   $this->pdf->Ln();
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


         $this->pdf->SetFont('helvetica','B',8);
         $this->pdf->Cell(15, 6,"No", '1', 0, 'C', 0);
         $this->pdf->Cell(20, 6,"Date", '1', 0, 'C', 0);
         $this->pdf->Cell(15, 6,"Type", '1', 0, 'C', 0);
         $this->pdf->Cell(110, 6,"Description", '1', 0, 'C', 0);
         $this->pdf->Cell(25, 6,"Acc No", '1', 0, 'C', 0);
         $this->pdf->Cell(50, 6,"Acc Name", '1', 0, 'C', 0); 
         $this->pdf->Cell(25, 6,"Amount", '1', 0, 'C', 0);
         $this->pdf->Ln();
          $tot=(float)0;


         // Deatils loop            
         foreach($r_general_recipt_summery as $row){
         $this->pdf->SetX(16);
         $this->pdf->SetLineStyle(array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0.1, 'color' => array(0, 0, 0)));
         $this->pdf->SetFont('helvetica','',9);
         $this->pdf->Cell(15, 6,$row->nno, '1', 0, 'R', 0);
         $this->pdf->Cell(20, 6,$row->ddate, '1', 0, 'R', 0);
         $this->pdf->Cell(15, 6,$row->type, '1', 0, 'L', 0);
         $this->pdf->Cell(110, 6,$row->note, '1', 0, 'L', 0);
         $this->pdf->Cell(25, 6,$row->paid_acc, '1', 0, 'L', 0);
         $this->pdf->Cell(50, 6,$row->description, '1', 0, 'L', 0);

         if($row->type=="cash")
          $this->pdf->Cell(25, 6,$row->cash_amount, '1', 0, 'R', 0);
         else
           $this->pdf->Cell(25, 6,$row->cheque_amount, '1', 0, 'R', 0);
         $this->pdf->Ln();

         
          $tot+=(float)$row->cash_amount+cheque_amount;

         }
 
            $this->pdf->SetFont('helvetica','B',8);             
            $this->pdf->SetX(16);
            $this->pdf->Cell(15, 6, "", '0', 0, 'L', 0);
            $this->pdf->Cell(20, 6, "", '0', 0, 'R', 0);
            $this->pdf->Cell(15, 6, "", '0', 0, 'R', 0);
            $this->pdf->Cell(110, 6, "", '0', 0, 'R', 0);
            $this->pdf->Cell(25, 6, "", '0', 0, 'R', 0);
            $this->pdf->Cell(50, 6, "Total ", '0', 0, 'C', 0);
            $this->pdf->Cell(25, 6, number_format($tot,2), '1', 0, 'R', 0);
            $this->pdf->Ln();  
    //----------------------------------------------------------

         
         

        $this->pdf->Output("general_recipt_summery".date('Y-m-d').".pdf", 'I');

?>
        


