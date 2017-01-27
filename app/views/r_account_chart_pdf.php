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

    $this->pdf->setY(25);
    $this->pdf->SetFont('helvetica', 'BU',10);
    $this->pdf->Cell(180, 1,"CHART OF ACCOUNT",0,false, 'L', 0, '', 0, false, 'M', 'M');
    $this->pdf->Ln();

    $this->pdf->setY(27);
    $this->pdf->setX(25);
    $this->pdf->SetFont('helvetica', '', 8);

    $this->pdf->Ln();
    // $this->pdf->setY(40);

    // $this->pdf->SetY(43);
    // $this->pdf->SetX(20);
    // $this->pdf->Ln();

    $rtype="default";
    $type="default";
    $count=(Int)0;


    $this->pdf->Ln();  

    foreach($acc_det as $row){
        $this->pdf->SetLineStyle(array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0.1, 'color' => array(0, 0, 0)));
        $this->pdf->SetFont('helvetica', 'B', 8);
        $this->pdf->Cell(5, 6,$row->code, 'TR', 0, 'L', 0);
        $this->pdf->Cell(265, 6,$row->heading, 'TR', 0, 'L', 0);
        $this->pdf->Ln();


        $sql2="SELECT * FROM `m_account_type` t WHERE t.`control_category`='".$row->code."'"; 
        $query=$this->db->query($sql2)->result();
        foreach($query as $row2){
            $this->pdf->SetFont('helvetica', '', 8);
            $this->pdf->SetTextColor(11,0,0);
            $this->pdf->Cell(15, 6,"", 'TR', 0, 'L', 0);
            $this->pdf->Cell(25, 6,$row2->code, 'TR', 0, 'L', 0);
            $this->pdf->Cell(230, 6,$row2->heading, 'TR', 0, 'L', 0);
            $this->pdf->Ln(); 

            $sql3="SELECT * FROM `m_account_type` t WHERE t.`control_category`='".$row2->code."'"; 
            $query=$this->db->query($sql3)->result();
            foreach($query as $row3){
                $this->pdf->SetFont('helvetica', '', 8);
                $this->pdf->SetTextColor(11,0,0);
                $this->pdf->Cell(40, 6,"", 'TR', 0, 'L', 0);
                $this->pdf->Cell(25, 6,$row3->code, 'TR', 0, 'L', 0);
                $this->pdf->Cell(205, 6,$row3->heading, 'TR', 0, 'L', 0);

                $this->pdf->Ln(); 

                $sql4="SELECT * FROM `m_account_type` t WHERE t.`control_category`='".$row3->code."'"; 
                $query=$this->db->query($sql4)->result();
                foreach($query as $row4){
                    $this->pdf->SetFont('helvetica', '', 8);
                    $this->pdf->SetTextColor(11,0,0);
                    $this->pdf->Cell(65, 6,"", 'TR', 0, 'L', 0);
                    $this->pdf->Cell(25, 6,$row4->code, 'TR', 0, 'L', 0);
                    $this->pdf->Cell(180, 6,$row4->heading, 'TR', 0, 'L', 0);
                    $this->pdf->Ln(); 


                    $sql5="SELECT * FROM `m_account_type` t WHERE t.`control_category`='".$row4->code."'"; 
                    $query=$this->db->query($sql5)->result();
                    foreach($query as $row5){
                        $this->pdf->SetFont('helvetica', '', 8);
                        $this->pdf->SetTextColor(11,0,0);
                        $this->pdf->Cell(90, 6,"", 'TR', 0, 'L', 0);
                        $this->pdf->Cell(25, 6,$row5->code, 'TR', 0, 'L', 0);
                        $this->pdf->Cell(155, 6,$row5->heading, 'TR', 0, 'L', 0);
                        $this->pdf->Ln(); 

                        $sql6="SELECT * FROM `m_account_type` t WHERE t.`control_category`='".$row5->code."'"; 
                        $query=$this->db->query($sql6)->result();
                        foreach($query as $row6){
                            $this->pdf->SetFont('helvetica', 'B', 8);
                            $this->pdf->SetTextColor(14,19,169);
                            $this->pdf->Cell(115, 6,"", 'TR', 0, 'L', 0);
                            $this->pdf->Cell(25, 6,$row6->code, 'TR', 0, 'L', 0);
                            $this->pdf->Cell(130, 6,$row6->heading, 'TR', 0, 'L', 0);
                            $this->pdf->Ln(); 
                        }
                    }
                }


            }
        }




    }

    // foreach($acc_det as $row)
    // {
    //     $this->pdf->SetX(20);
    //     $this->pdf->SetFont('helvetica','',7);
    //     $this->pdf->SetLineStyle(array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0.1, 'color' => array(0, 0, 0)));
    
    //     if($rtype!="default" && $rtype==$row->rtype)
    //     {
    //         if($type!="default" && $type==$row->type)
    //         {
    //             $this->pdf->Cell(40, 6,"", '1', 0, 'L', 0);
    //             $this->pdf->Cell(25, 6,"", '1', 0, 'L', 0);
    //             $this->pdf->Cell(17, 6,$row->code, '1', 0, 'L', 0);
    //             $this->pdf->Cell(55, 6,$row->description, '1', 0, 'L', 0);
    //             $this->pdf->Cell(15, 6,$row->control_acc, '1', 0, 'L', 0);
    //             $this->pdf->Cell(20, 6,$row->is_control_acc, '1', 0, 'L', 0);
    //             $this->pdf->Ln();   
    //         }
    //         else
    //         {  
    //             $this->pdf->SetX(60);
    //             $this->pdf->SetFont('helvetica','B',7);
    //             $this->pdf->Cell(60, 6,"Number Of Accounts : ".$count, '', 0, 'L', 0);
    //             $this->pdf->Ln(); 
                
    //             $this->pdf->SetFont('helvetica','',7);
    //             $this->pdf->SetX(20);
    //             $this->pdf->Cell(40, 6,"", '1', 0, 'L', 0);
    //             $this->pdf->Cell(25, 6,$row->type, '1', 0, 'L', 0);
    //             $this->pdf->Cell(17, 6,"", '1', 0, 'L', 0);
    //             $this->pdf->Cell(55, 6,"", '1', 0, 'L', 0);
    //             $this->pdf->Cell(15, 6,"", '1', 0, 'L', 0);
    //             $this->pdf->Cell(20, 6,"", '1', 0, 'L', 0);
    //             $this->pdf->Ln(); 

    //             $this->pdf->SetX(20);
    //             $this->pdf->Cell(40, 6,"", '1', 0, 'L', 0);
    //             $this->pdf->Cell(25, 6,"", '1', 0, 'L', 0);
    //             $this->pdf->Cell(17, 6,$row->code, '1', 0, 'L', 0);
    //             $this->pdf->Cell(55, 6,$row->description, '1', 0, 'L', 0);
    //             $this->pdf->Cell(15, 6,$row->control_acc, '1', 0, 'L', 0);
    //             $this->pdf->Cell(20, 6,$row->is_control_acc, '1', 0, 'L', 0);
    //             $this->pdf->Ln(); 

    //             $count=0;                  
    //         }
    //         $type=$row->type;                       
    //     }
    //     else
    //     {
    //         if($type!="default" && $type==$row->type)
    //         {
    //             $this->pdf->Cell(40, 6,$row->rtype, '1', 0, 'L', 0);
    //             $this->pdf->Cell(25, 6,"", '1', 0, 'L', 0);
    //             $this->pdf->Cell(17, 6,$row->code, '1', 0, 'L', 0);
    //             $this->pdf->Cell(55, 6,$row->description, '1', 0, 'L', 0);
    //             $this->pdf->Cell(15, 6,$row->control_acc, '1', 0, 'L', 0);
    //             $this->pdf->Cell(20, 6,$row->is_control_acc, '1', 0, 'L', 0);
    //             $this->pdf->Ln();
    //         }
    //         else
    //         {
    //             if($type=="default")
    //             {
    //                 $this->pdf->SetX(20);
    //                 $this->pdf->Cell(40, 6,$row->rtype, '1', 0, 'L', 0);
    //                 $this->pdf->Cell(25, 6,"", '1', 0, 'L', 0); 
    //                 $this->pdf->Cell(17, 6,"", '1', 0, 'L', 0);
    //                 $this->pdf->Cell(55, 6,"", '1', 0, 'L', 0);
    //                 $this->pdf->Cell(15, 6,"", '1', 0, 'L', 0);
    //                 $this->pdf->Cell(20, 6,"", '1', 0, 'L', 0);
    //                 $this->pdf->Ln();   

    //                 $this->pdf->SetX(20);
    //                 $this->pdf->Cell(40, 6,"", '1', 0, 'L', 0);
    //                 $this->pdf->Cell(25, 6,$row->type, '1', 0, 'L', 0); 
    //                 $this->pdf->Cell(17, 6,"", '1', 0, 'L', 0);
    //                 $this->pdf->Cell(55, 6,"", '1', 0, 'L', 0);
    //                 $this->pdf->Cell(15, 6,"", '1', 0, 'L', 0);
    //                 $this->pdf->Cell(20, 6,"", '1', 0, 'L', 0);
    //                 $this->pdf->Ln();   

    //                 $this->pdf->SetX(20);
    //                 $this->pdf->Cell(40, 6,"", '1', 0, 'L', 0);
    //                 $this->pdf->Cell(25, 6,"", '1', 0, 'L', 0); 
    //                 $this->pdf->Cell(17, 6,$row->code, '1', 0, 'L', 0);
    //                 $this->pdf->Cell(55, 6,$row->description, '1', 0, 'L', 0);
    //                 $this->pdf->Cell(15, 6,$row->control_acc, '1', 0, 'L', 0);
    //                 $this->pdf->Cell(20, 6,$row->is_control_acc, '1', 0, 'L', 0);
    //                 $this->pdf->Ln();   
    //             }
    //             else
    //             {
    //                 $this->pdf->SetX(60);
    //                 $this->pdf->SetFont('helvetica','B',7);
    //                 $this->pdf->Cell(60, 6,"Number Of Accounts : ".$count, '', 0, 'L', 0);
    //                 $this->pdf->Ln(); 

    //                 $this->pdf->SetFont('helvetica','',7);
    //                 $this->pdf->SetX(20);
    //                 $this->pdf->Cell(40, 6,$row->rtype, '1', 0, 'L', 0);
    //                 $this->pdf->Cell(25, 6,"", '1', 0, 'L', 0); 
    //                 $this->pdf->Cell(17, 6,"", '1', 0, 'L', 0);
    //                 $this->pdf->Cell(55, 6,"", '1', 0, 'L', 0);
    //                 $this->pdf->Cell(15, 6,"", '1', 0, 'L', 0);
    //                 $this->pdf->Cell(20, 6,"", '1', 0, 'L', 0);
    //                 $this->pdf->Ln();              

    //                 $this->pdf->SetX(20);
    //                 $this->pdf->Cell(40, 6,"", '1', 0, 'L', 0);
    //                 $this->pdf->Cell(25, 6,$row->type, '1', 0, 'L', 0); 
    //                 $this->pdf->Cell(17, 6,"", '1', 0, 'L', 0);
    //                 $this->pdf->Cell(55, 6,"", '1', 0, 'L', 0);
    //                 $this->pdf->Cell(15, 6,"", '1', 0, 'L', 0);
    //                 $this->pdf->Cell(20, 6,"", '1', 0, 'L', 0);
    //                 $this->pdf->Ln();   

    //                 $this->pdf->SetX(20);
    //                 $this->pdf->Cell(40, 6,"", '1', 0, 'L', 0);
    //                 $this->pdf->Cell(25, 6,"", '1', 0, 'L', 0); 
    //                 $this->pdf->Cell(17, 6,$row->code, '1', 0, 'L', 0);
    //                 $this->pdf->Cell(55, 6,$row->description, '1', 0, 'L', 0);
    //                 $this->pdf->Cell(15, 6,$row->control_acc, '1', 0, 'L', 0);
    //                 $this->pdf->Cell(20, 6,$row->is_control_acc, '1', 0, 'L', 0);
    //                 $this->pdf->Ln(); 

    //                 $count=0;
    //             }
    //         }
    //         $type=$row->type;
    //     }
    //     $rtype=$row->rtype;    
    //     $count=$count+1;                       
    // } 
    // $this->pdf->SetX(60);
    // $this->pdf->SetFont('helvetica','B',7);
    // $this->pdf->Cell(60, 6,"Number Of Accounts : ".$count, '', 0, 'L', 0);                       

    $this->pdf->Output("Chart Of Account Report".date('Y-m-d').".pdf", 'I');

?>
