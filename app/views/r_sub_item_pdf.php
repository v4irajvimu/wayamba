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

        foreach($clus as $cl){
            $claster_name=$cl->description;
            $cl_code=$cl->code;
        }
        foreach($bran as $b){
            $b_name=$b->name;
            $b_code=$b->bc;
        }
        foreach($str as $s){
            $s_name=$s->description;
            $s_code=$s->code;
        }

         foreach($itm as $it){
            $i_name=$it->description;
            $i_code=$it->code;
        }
        
         
    $this->pdf->setX(15);
    $this->pdf->SetFont('helvetica', 'B', 10);
    $this->pdf->Cell(180, 1, "Date From " .$from. " To ". $to, '0', 0, 'L', 0);
    $this->pdf->Ln();
    
    $this->pdf->setX(15);
    $this->pdf->SetFont('helvetica', 'B', 8);
            
    if($cl_code!=""){
    $this->pdf->Cell(25, 1, "Cluster", '0', 0, 'L', 0);
    $this->pdf->Cell(80, 1, ": ".$cl_code." - ".$claster_name, '0', 0, 'L', 0);
    }
    if($s_cat_code!=""){
    $this->pdf->Cell(25, 1, "Sub Category", '0', 0, 'L', 0);
    $this->pdf->Cell(20, 1,": ".$s_cat_code." - ".$s_cat, '0', 0, 'L', 0);
    }
    $this->pdf->Ln();
    $this->pdf->setX(15);
    if($b_code!=""){
    $this->pdf->Cell(25, 1, "Branch", '0', 0, 'L', 0);
    $this->pdf->Cell(80, 1,": ".$b_code." - ".$b_name, '0', 0, 'L', 0);
    }
    if($i_code!=""){
    $this->pdf->Cell(25, 1, "Item", '0', 0, 'L', 0);
    $this->pdf->Cell(20, 1,": ".$i_code." - ".$i_name, '0', 0, 'L', 0);
    }
    $this->pdf->Ln();
    $this->pdf->setX(15);
    if($s_code!=""){
    $this->pdf->Cell(25, 1, "Store", '0', 0, 'L', 0);
    $this->pdf->Cell(80, 1,": ".$s_code." - ".$s_name, '0', 0, 'L', 0);
    }
    if($u_code!=""){
    $this->pdf->Cell(25, 1, "Unit", '0', 0, 'L', 0);
    $this->pdf->Cell(20, 1,": ".$u_code." - ".$u_name, '0', 0, 'L', 0);
    }
    $this->pdf->Ln();
    $this->pdf->setX(15);
    if($d_code!=""){
    $this->pdf->Cell(25, 1, "Department", '0', 0, 'L', 0);
    $this->pdf->Cell(80, 1,": ".$d_code." - ".$d_name, '0', 0, 'L', 0);
    }
    if($br_code!=""){
    $this->pdf->Cell(25, 1, "Brand", '0', 0, 'L', 0);
    $this->pdf->Cell(20, 1,": ".$br_code." - ".$br_name, '0', 0, 'L', 0);
    }
    $this->pdf->Ln();
    $this->pdf->setX(15);
    if($m_cat_code!=""){
    $this->pdf->Cell(25, 1, "Main Category", '0', 0, 'L', 0);
    $this->pdf->Cell(80, 1,": ".$m_cat_code." - ".$m_cat, '0', 0, 'L', 0);
    }
    if($su_code!=""){
    $this->pdf->Cell(25, 1, "Supplier", '0', 0, 'L', 0);
    $this->pdf->Cell(20, 1,": ".$su_code." - ".$su_name, '0', 0, 'L', 0);
    }


            $this->pdf->setY(66);

        foreach($sub_item_det as $row){
            
            
            $this->pdf->GetY(60);
            $this->pdf->SetX(15);
            $this->pdf->SetFont('helvetica','',9);
            $this->pdf->SetLineStyle(array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0.1, 'color' => array(0, 0, 0)));
        
            $aa = $this->pdf->getNumLines($row->description, 50);
            $bb = $this->pdf->getNumLines($row->sub_item, 35);
            if($aa>$bb){
                $heigh=5*$aa;
            }else{
                 $heigh=5*$bb;
            }

            $this->pdf->MultiCell(40, $heigh, $row->sub_item,  1, 'L', 0, 0, '', '', true, 0, false, true, 0);
            $this->pdf->MultiCell(80, $heigh, $row->item_name,  1, 'L', 0, 0, '', '', true, 0, false, true, 0);
            $this->pdf->MultiCell(20, $heigh, $row->qty,  1, 'R', 0, 1, '', '', true, 0, false, true, 0);
      
        }

            $this->pdf->Output("Sub Item Stock Report".date('Y-m-d').".pdf", 'I');

?>
