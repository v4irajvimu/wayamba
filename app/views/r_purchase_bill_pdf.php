<?php
    error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
    $this->pdf->setPrintHeader($header,$type,$duration);
    $this->pdf->setPrintHeader(true,$type);
    $this->pdf->setPrintFooter(true);
        
    $this->pdf->SetFont('helvetica', 'B', 16);
    $this->pdf->AddPage($orientation,$page); 

    $branch_name="";

    foreach($branch as $ress)
    {
        $branch_name=$ress->name;
        $this->pdf->headerSet3($ress->name,$ress->address,$ress->tp,$ress->fax,$ress->email);
    }     

    $this->pdf->setY(25);
    $this->pdf->SetFont('helvetica', 'BU',10);
    $this->pdf->Cell(180,6,"Purchase Bill Summary ",0,false, 'L', 0, '', 0, false, 'M', 'M');
    $this->pdf->Ln();


    $this->pdf->SetFont('helvetica', '',8);
    $this->pdf->Cell(180, 6,"Date From ".$from." To ".$to,0,false, 'L', 0, '', 0, false, 'M', 'M');
    // $this->pdf->Ln();

    // $this->pdf->setY(40);
    // $this->pdf->SetFont('helvetica','B',7);
    // $this->pdf->Cell(15, 6," Date", '1', 0, 'L', 0);
    // $this->pdf->Cell(15, 6,"GRN No ", '1', 0, 'R', 0);
    // $this->pdf->Cell(15, 6,"PO No ", '1', 0, 'R', 0);
    // $this->pdf->Cell(15, 6,"Inv No ", '1', 0, 'R', 0);
    // $this->pdf->Cell(20, 6,"Amount ", '1', 0, 'R', 0);
    // $this->pdf->Cell(20, 6,"Discount ", '1', 0, 'R', 0);
    // $this->pdf->Cell(20, 6,"Net Amount ", '1', 0, 'R', 0);
    // $this->pdf->Cell(20, 6,"Paid ", '1', 0, 'R', 0);
    // $this->pdf->Cell(20, 6,"Returned ", '1', 0, 'R', 0);
    // $this->pdf->Cell(20, 6,"Balance ", '1', 0, 'R', 0);
    $this->pdf->Ln(12);

    $supp='default';
    $bal=(int)0;

// $supS="";

// $y=0;
// $x=1;
// $t=2;
// $ss[]=0;

// foreach ($item_det as $val) {

//     if($supS!="default" && $supS==$val->supp_id){
//         $t++;  
//     }else{
//         $t=2;
//         $y++;          
//     }

//     $ss[$y]= $t;
//     $supS=$val->supp_id;    

// }
// print_r($ss);
// var_dump($ss);

    $thH=12;
    foreach($item_det as $row)
    {


        $bal=(int)$row->net_amount -((int)$row->paid+(int)$row->return_q);

        $this->pdf->GetY(40);

        $this->pdf->SetLineStyle(array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0.1, 'color' => array(0, 0, 0)));

        $this->pdf->SetFont('helvetica','',7);
    
        if($supp!="default" && $supp==$row->supp_id)
        {
            $thH=6;//row hight
            $this->pdf->HaveMorePages($thH);
            $this->pdf->Cell(25, 6,$row->ddate, '1', 0, 'L', 0);
            $this->pdf->Cell(15, 6,$row->nno, '1', 0, 'R', 0);
            $this->pdf->Cell(20, 6,$row->inv_no, '1', 0, 'R', 0);
            $this->pdf->Cell(20, 6,$row->amount, '1', 0, 'R', 0);
            $this->pdf->Cell(20, 6,$row->discount, '1', 0, 'R', 0);
            $this->pdf->Cell(20, 6,$row->net_amount, '1', 0, 'R', 0);
            $this->pdf->Cell(20, 6,$row->paid, '1', 0, 'R', 0);
            $this->pdf->Cell(20, 6,$row->return_q, '1', 0, 'R', 0);
            $this->pdf->Cell(20, 6,number_format($bal,2,'.',''), '1', 0, 'R', 0);
            $this->pdf->Ln();  
            $bal=0;          
        }
        else
        {


    // print($thH." ");
            $thH=12;//row hight * 2
            $this->pdf->HaveMorePages($thH);
            $this->pdf->Cell(15, 6,$row->supp_id." - ".$row->name , '0', 0, 'L', 0);
            $this->pdf->Cell(15, 6,"", '0', 0, 'L', 0);
            $this->pdf->Cell(15, 6,"", '0', 0, 'R', 0);
            $this->pdf->Cell(15, 6,"", '0', 0, 'R', 0);
            $this->pdf->Cell(20, 6,"", '0', 0, 'R', 0);
            $this->pdf->Cell(20, 6,"", '0', 0, 'R', 0);
            $this->pdf->Cell(20, 6,"", '0', 0, 'R', 0);
            $this->pdf->Cell(20, 6,"", '0', 0, 'R', 0);
            $this->pdf->Cell(20, 6,"", '0', 0, 'R', 0);
            $this->pdf->Cell(20, 6,"", '0', 0, 'R', 0);
            $this->pdf->Ln();



            $this->pdf->Cell(25, 6,$row->ddate, '1', 0, 'L', 0);
            $this->pdf->Cell(15, 6,$row->nno, '1', 0, 'R', 0);
            $this->pdf->Cell(20, 6,$row->inv_no, '1', 0, 'R', 0);
            $this->pdf->Cell(20, 6,$row->amount, '1', 0, 'R', 0);
            $this->pdf->Cell(20, 6,$row->discount, '1', 0, 'R', 0);
            $this->pdf->Cell(20, 6,$row->net_amount, '1', 0, 'R', 0);
            $this->pdf->Cell(20, 6,$row->paid, '1', 0, 'R', 0);
            $this->pdf->Cell(20, 6,$row->return_q, '1', 0, 'R', 0);
            $this->pdf->Cell(20, 6,number_format($bal,2,'.',''), '1', 0, 'R', 0);
            $this->pdf->Ln();
            $bal=0;  
            $x++;        
        }
        $supp=$row->supp_id;
    }          
    $this->pdf->Output("Purchase Bill Summery".date('Y-m-d').".pdf", 'I');
?>
