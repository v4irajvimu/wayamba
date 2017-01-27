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
        foreach($dp as $d){
            $d_name=$d->description;
            $d_code=$d->code;
        }
        foreach($cat as $mc){
            $m_cat=$mc->description;
            $m_cat_code=$mc->code;
        }
        foreach($scat as $sc){
            $s_cat=$sc->description;
            $s_cat_code=$sc->code;
        }
         foreach($itm as $it){
            $i_name=$it->description;
            $i_code=$it->code;
        }
         foreach($unt as $u){
            $u_name=$u->description;
            $u_code=$u->code;
        }
         foreach($brnd as $br){
            $br_name=$br->description;
            $br_code=$br->code;
        }
         foreach($sup as $su){
            $su_name=$su->name;
            $su_code=$su->code;
        }

        foreach($dealer as $deal){
            $de_name=$deal->name;
            $de_code=$deal->code;
        }

        foreach($groupS as $gpS){
            $groupS_name=$gpS->name;
            $groupS_code=$gpS->code;
        }     

            $this->pdf->setY(25);
            $this->pdf->SetFont('helvetica', 'BU',12);
            $this->pdf->Cell(180, 1,"Stock In Hand Report - Without Qty Zero  ",0,false, 'L', 0, '', 0, false, 'M', 'M');
            $this->pdf->Ln();

            $this->pdf->SetFont('helvetica', 'B', 8);
            $this->pdf->Cell(180, 1,"As At Date - ".$to,0,false, 'L', 0, '', 0, false, 'M', 'M');
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
    if($b_code!=""){
    $this->pdf->Ln();
    $this->pdf->setX(15);        
    $this->pdf->Cell(25, 1, "Branch", '0', 0, 'L', 0);
    $this->pdf->Cell(80, 1,": ".$b_code." - ".$b_name, '0', 0, 'L', 0);
    }
    if($i_code!=""){
    $this->pdf->Cell(25, 1, "Item", '0', 0, 'L', 0);
    $this->pdf->Cell(20, 1,": ".$i_code." - ".$i_name, '0', 0, 'L', 0);
    }
    if($s_code!=""){
    $this->pdf->Ln();
    $this->pdf->setX(15);        
    $this->pdf->Cell(25, 1, "Store", '0', 0, 'L', 0);
    $this->pdf->Cell(80, 1,": ".$s_code." - ".$s_name, '0', 0, 'L', 0);
    }
    if($u_code!=""){
    $this->pdf->Cell(25, 1, "Unit", '0', 0, 'L', 0);
    $this->pdf->Cell(20, 1,": ".$u_code." - ".$u_name, '0', 0, 'L', 0);
    }
    if($d_code!=""){
    $this->pdf->Ln();
    $this->pdf->setX(15);        
    $this->pdf->Cell(25, 1, "Department", '0', 0, 'L', 0);
    $this->pdf->Cell(80, 1,": ".$d_code." - ".$d_name, '0', 0, 'L', 0);
    }
    if($br_code!=""){
    $this->pdf->Cell(25, 1, "Brand", '0', 0, 'L', 0);
    $this->pdf->Cell(20, 1,": ".$br_code." - ".$br_name, '0', 0, 'L', 0);
    }

    if($m_cat_code!=""){
    $this->pdf->Ln();
    $this->pdf->setX(15);        
    $this->pdf->Cell(25, 1, "Main Category", '0', 0, 'L', 0);
    $this->pdf->Cell(80, 1,": ".$m_cat_code." - ".$m_cat, '0', 0, 'L', 0);
    }
    if($su_code!=""){
    $this->pdf->Ln();
    $this->pdf->Cell(25, 1, "Supplier", '0', 0, 'L', 0);
    $this->pdf->Cell(20, 1,": ".$su_code." - ".$su_name, '0', 0, 'L', 0);
    }  
    if($de_code!=""){
    $this->pdf->Ln();
    $this->pdf->Cell(25, 1, "Dealer", '0', 0, 'L', 0);
    $this->pdf->Cell(20, 1,": ".$de_code." - ".$de_name, '0', 0, 'L', 0);
    }
    if($groupS_code!=""){
    $this->pdf->Ln();
    $this->pdf->Cell(25, 1, "Group", '0', 0, 'L', 0);
    $this->pdf->Cell(20, 1,": ".$groupS_code." - ".$groupS_name, '0', 0, 'L', 0);
    }    

                      
    $this->pdf->Ln();
    $this->pdf->setY(61);

        $tot; 
        $tot_cost; 
        $cost; 
        foreach($item_det as $row){
            
        $heigh=6*(max(1,$this->pdf->getNumLines($row->description, 40),$this->pdf->getNumLines($row->code, 25)));
        $this->pdf->HaveMorePages($heigh);

                $this->pdf->SetX(15);
                $this->pdf->SetFont('helvetica','',9);
                $this->pdf->SetLineStyle(array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0.1, 'color' => array(0, 0, 0)));
        

                $cost=(int)$row->qty*(float)$row->purchase_price;
                $this->pdf->MultiCell(25, $heigh, $row->code,  1, 'L', false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
                $this->pdf->MultiCell(40, $heigh, $row->description,  1, 'L', false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
                $this->pdf->MultiCell(20, $heigh, $row->model,  1, 'L', false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
                $this->pdf->MultiCell(10, $heigh, $row->qty,  1, 'R', false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
                $this->pdf->MultiCell(25, $heigh, $row->purchase_price,  1, 'R', false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
                $this->pdf->MultiCell(20, $heigh, $row->min_price,  1, 'R', false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
                $this->pdf->MultiCell(20, $heigh, $row->max_price,  1, 'R', false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
                $this->pdf->MultiCell(25, $heigh, number_format($cost,2),  1, 'R', false, 1, '', '', true, 0, false, true, $heigh,'M' ,false);
     
                $tot=$tot+$row->qty;
                $tot_cost=(float)$tot_cost+(float)$cost;

        //$x++;
        }
        //$this->pdf->Ln();
         $this->pdf->SetFont('helvetica','B',9);
        $this->pdf->SetX(5);    
        $this->pdf->MultiCell(35, 1, "",  0, 'L', 0, 0, '', '', true, 0, false, true, 0);
        $this->pdf->MultiCell(40, 1, "",  0, 'L', 0, 0, '', '', true, 0, false, true, 0);
        $this->pdf->MultiCell(20, 1, "",  0, 'L', 0, 0, '', '', true, 0, false, true, 0);
        $this->pdf->MultiCell(10, 1, "",  0, 'R', 0, 0, '', '', true, 0, false, true, 0);
        $this->pdf->MultiCell(25, 1, "",  0, 'R', 0, 0, '', '', true, 0, false, true, 0);
        $this->pdf->MultiCell(20, 1, "",  0, 'R', 0, 0, '', '', true, 0, false, true, 0);
    
        $this->pdf->Cell(20, 6, "Total", '0', 0, 'L', 0);
        $this->pdf->Cell(25, 6, number_format($tot_cost,2), '1', 0, 'R', 0);

           

    $this->pdf->Output("Stock In Hand Report".date('Y-m-d').".pdf", 'I');

?>
