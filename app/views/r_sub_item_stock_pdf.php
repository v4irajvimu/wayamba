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
     

            $this->pdf->setY(25);
            $this->pdf->SetFont('helvetica', 'BU',10);
            $this->pdf->Cell(180, 1,"Sub Item Stock Report  ",0,false, 'C', 0, '', 0, false, 'M', 'M');

            $this->pdf->Ln();
            $this->pdf->SetFont('helvetica', '', 10);
            $this->pdf->Cell(180, 1,"As At Date - ".$to,0,false, 'C', 0, '', 0, false, 'M', 'M');

            $this->pdf->Ln();
            $this->pdf->setY(35);
            $this->pdf->setX(25);
            $this->pdf->SetFont('helvetica', 'B', 10);
            $this->pdf->Cell(25, 1, "Cluster", '0', 0, 'L', 0);
            $this->pdf->Cell(80, 1, ": ".$cl_code." - ".$claster_name,'0', 0, 'L', 0);
            $this->pdf->Cell(20, 1, "Sub Category", '0', 0, 'L', 0);
            $this->pdf->Cell(20, 1,": ".$s_cat_code." - ".$s_cat, '0', 0, 'L', 0);
            
            $this->pdf->Ln();

            $this->pdf->setX(25);
            $this->pdf->Cell(25, 1, "Branch", '0', 0, 'L', 0);
            $this->pdf->Cell(80, 1,": ".$b_code." - ".$b_name, '0', 0, 'L', 0);
            $this->pdf->Cell(20, 1, "Item", '0', 0, 'L', 0);
            $this->pdf->Cell(20, 1,": ".$i_code." - ".$i_name, '0', 0, 'L', 0);
            
            $this->pdf->Ln();

            $this->pdf->setX(25);
            $this->pdf->Cell(25, 1, "Store", '0', 0, 'L', 0);
            $this->pdf->Cell(80, 1,": ".$s_code." - ".$s_name, '0', 0, 'L', 0);
            $this->pdf->Cell(20, 1, "Unit", '0', 0, 'L', 0);
            $this->pdf->Cell(20, 1,": ".$u_code." - ".$u_name, '0', 0, 'L', 0);
            
            $this->pdf->Ln();
            $this->pdf->setY(66);

        $tot; 
        foreach(sub_item_det as $row){
            
            
                $this->pdf->GetY(40);
                $this->pdf->SetX(5);
                $this->pdf->SetFont('helvetica','',9);
                $this->pdf->SetLineStyle(array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0.1, 'color' => array(0, 0, 0)));
        
                $aa = $this->pdf->getNumLines($row->description, 50);
                $bb = $this->pdf->getNumLines($row->model, 30);
                if($aa>$bb){
                    $heigh=5*$aa;
                }else{
                    $heigh=5*$bb;
                }

                $this->pdf->MultiCell(35, $heigh, $row->code,  1, 'L', 0, 0, '', '', true, 0, false, true, 0);
                $this->pdf->MultiCell(50, $heigh, $row->description,  1, 'L', 0, 0, '', '', true, 0, false, true, 0);
                $this->pdf->MultiCell(15, $heigh, $row->qty,  1, 'R', 0, 1, '', '', true, 0, false, true, 0);
                
             
                //$tot=$tot+$row->qty;
      
        }
    

    
           

    $this->pdf->Output("Sub Item Stock Report".date('Y-m-d').".pdf", 'I');

?>
