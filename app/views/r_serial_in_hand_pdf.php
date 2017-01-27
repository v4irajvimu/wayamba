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
            $this->pdf->Cell(180, 1,"Stock In Hand Serial Wise Report  ",0,false, 'L', 0, '', 0, false, 'M', 'M');
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

            $this->pdf->Ln();
            $this->pdf->setY(50);



        $x=0;
        $last_code="default"; 
        foreach($serial_det as $row){
            if($last_code==$row->code && $last_code!="default"){
               $this->pdf->SetLineStyle(array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0.1, 'color' => array(0, 0, 0)));
        
              $this->pdf->SetFont('helvetica','',8);
                
              if($x==9){

               $x=1;
               $this->pdf->Ln();
              
               }

               if($x==1){

                $this->pdf->SetX(15);
                $this->pdf->GetY();
                
                $this->pdf->Cell(20, 6,$row->serial_no, '1', 0, 'L', 0);
                }
                elseif ($x==2) {
                    $this->pdf->GetX();
                $this->pdf->Cell(20, 6,$row->serial_no, '1', 0, 'L', 0);
                }
                elseif ($x==3) {
                   $this->pdf->GetX();
                $this->pdf->Cell(20, 6,$row->serial_no, '1', 0, 'L', 0);
                }
                elseif ($x==4) {
                $this->pdf->GetX();
                $this->pdf->Cell(20, 6,$row->serial_no, '1', 0, 'L', 0);
                }
                elseif ($x==5) {
                $this->pdf->GetX();
                $this->pdf->Cell(20, 6,$row->serial_no, '1', 0, 'L', 0);
                }
                elseif ($x==6) {
                $this->pdf->GetX();
                $this->pdf->Cell(20, 6,$row->serial_no, '1', 0, 'L', 0);    
                }
                elseif ($x==7) {
                $this->pdf->GetX();
                $this->pdf->Cell(20, 6,$row->serial_no, '1', 0, 'L', 0);
                }
                elseif ($x==8) {
                $this->pdf->GetX();
                $this->pdf->Cell(20, 6,$row->serial_no, '1', 0, 'L', 0);    
                }

               

              

            }else{
            $x=0;
            $this->pdf->Ln();
            $this->pdf->Ln();
                $this->pdf->GetY();
                $this->pdf->SetX(15);
                $this->pdf->SetFont('helvetica','',8);
                $this->pdf->SetLineStyle(array('width' => 0.2, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0)));
        
                $this->pdf->Cell(30, 6,$row->code, '1', 0, 'L', 0);
                $this->pdf->Cell(60, 6,$row->description, '1', 0, 'L', 0);
                $this->pdf->Cell(30, 6,$row->model, '1', 0, 'L', 0);
                $this->pdf->Cell(20, 6,$row->qty, '1', 0, 'R', 0);
                $this->pdf->Cell(20, 6,$row->serial_no, '1', 0, 'L', 0);
                $this->pdf->Ln();
                $this->pdf->Ln();

               

            }
            
            $last_code=$row->code;
            $x++;
       

        }



        /*    
        $x=0;  
        $last_code="default"; 
        foreach($serial_det as $row){
            if($last_code==$row->code && $last_code!="default"){
                $this->pdf->GetY();
                $this->pdf->SetX(25);
                $this->pdf->SetFont('helvetica','',8);
                $this->pdf->Cell(30, 6,"", '1', 0, 'L', 0);
                $this->pdf->Cell(60, 6,"", '1', 0, 'L', 0);
                $this->pdf->Cell(30, 6,"", '1', 0, 'L', 0);
                $this->pdf->Cell(20, 6,"", '1', 0, 'R', 0);
                $this->pdf->Cell(20, 6,$row->serial_no, '1', 0, 'L', 0);
            }else{
                $this->pdf->GetY();
                $this->pdf->SetX(25);
                $this->pdf->SetFont('helvetica','',8);
                $this->pdf->Cell(30, 6,$row->code, '1', 0, 'L', 0);
                $this->pdf->Cell(60, 6,$row->description, '1', 0, 'L', 0);
                $this->pdf->Cell(30, 6,$row->model, '1', 0, 'L', 0);
                $this->pdf->Cell(20, 6,$row->qty, '1', 0, 'R', 0);
                $this->pdf->Cell(20, 6,$row->serial_no, '1', 0, 'L', 0);
            }

                $this->pdf->Ln();
                $last_code=$row->code;
        $x++;
        }
    
*/
    $this->pdf->Output("Serial In Hand Report".date('Y-m-d').".pdf", 'I');

?>
