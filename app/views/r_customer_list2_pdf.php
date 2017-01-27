<?php
error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
$this->pdf->setPrintHeader($header,$type,$duration);
// $this->pdf->setPrintHeader(true,$type);
$this->pdf->setPrintFooter(true);
$this->pdf->SetFont('helvetica', 'B', 16);
$this->pdf->AddPage($orientation,$page);   // L or P amd page type A4 or A3

foreach($branch as $ress){
    $this->pdf->headerSet3($ress->name,$ress->address,$ress->tp,$ress->fax,$ress->email);
}

$this->pdf->setY(23);
$this->pdf->Ln();
$this->pdf->SetFont('helvetica', 'BIU',12);
$this->pdf->Cell(0, 5, 'Customer Details   ',0,false, 'L', 0, '', 0, false, 'M', 'M');
$this->pdf->Ln();
    
// $this->pdf->setY(30);
// $this->pdf->Cell(50, 1,"",'T',0, 'L', 0);
// $this->pdf->Ln(); 

// $this->pdf->SetY(35);
// $this->pdf->SetX(10);
// $this->pdf->SetFont('helvetica','B',9);
// $this->pdf->Cell(10, 6,"No", '1', 0, 'C', 0);
// $this->pdf->Cell(25, 6,"Code", '1', 0, 'C', 0);
// $this->pdf->Cell(55, 6,"Name", '1', 0, 'C', 0);
// $this->pdf->Cell(40, 6,"Description", '1', 0, 'C', 0);
// $this->pdf->Cell(30, 6,"Type", '1', 0, 'C', 0);
// $this->pdf->Cell(30, 6,"Number", '1', 0, 'C', 0);
$this->pdf->Ln();

$sup="";
// $supS="";

// $x=1;
// $y=0;

// $t=2;
// $ss[]=0;

// foreach ($customer as $val) {

//     if($supS!=$val->code){
//         $t=2;
//         $y++;
  
//     }else{
//         $t++;    
//     }

//     $ss[$y]= $t;
//     $supS=$val->code;    

// }
// print_r($ss);

foreach ($customer as $value) {

// var_dump($ss[$x]*6);exit();

// print($x."\n");



    // $this->pdf->SetX(10);
    $this->pdf->SetLineStyle(array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0.1, 'color' => array(0, 0, 0)));
    if($sup!=$value->code){


    $heigh=6*(max(1,$this->pdf->getNumLines($value->description, 40),$this->pdf->getNumLines(trim($value->name), 55)));
    // $thH=$ss[$x]*6;
    // $this->pdf->HaveMorePages($thH);

        // $rc=false;
        // $aa = ;
        // $heigh=5*$aa;
    // $this->pdf->SetX(10);       

        $thH=12;//row hight * 2
        $this->pdf->HaveMorePages($thH);
             
        $this->pdf->SetFont('helvetica','',8);
        $this->pdf->Ln(3);
        $this->pdf->MultiCell(10, $heigh,$x, 'B', 'L', false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
        $this->pdf->MultiCell(25, $heigh,$value->code,  'B', 'L', false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
        $this->pdf->MultiCell(55, $heigh,trim($value->name),  'B', 'L', false, 1, '', '', true, 0, false, true, $heigh,'M' ,false);

        $this->pdf->MultiCell(10, $heigh,"",  0, 'L', false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
        $this->pdf->MultiCell(25, $heigh,"",  0, 'L', false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
        $this->pdf->MultiCell(55, $heigh,"",  0, 'L', false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
        $this->pdf->MultiCell(40, $heigh,ucfirst(strtolower($value->description)),  1, 'L', false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
        $this->pdf->MultiCell(30, $heigh, ucfirst(strtolower($value->type)),  1, 'L', false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
        $this->pdf->MultiCell(30, $heigh,$value->tp,  1, 'R', false, 1, '', '', true, 0, false, true, $heigh,'M' ,false);
        $x++;

   
    }else{
    // $this->pdf->SetX(10);          
        // $bb = $;
        // $heigh=5*$bb;
        $thH=6;//row hight
        $this->pdf->HaveMorePages($thH);

        $this->pdf->SetFont('helvetica','',8);
        $this->pdf->MultiCell(10, $heigh,"",  0, 'L', false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
        $this->pdf->MultiCell(25, $heigh,"",  0, 'L', false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
        $this->pdf->MultiCell(55, $heigh,"",  0, 'L', false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
        $this->pdf->MultiCell(40, $heigh,ucfirst(strtolower($value->description)),  1, 'L', false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
        $this->pdf->MultiCell(30, $heigh, ucfirst(strtolower($value->type)),  1, 'L', false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
        $this->pdf->MultiCell(30, $heigh,$value->tp,  1, 'R', false, 1, '', '', true, 0, false, true, $heigh,'M' ,false);

    }
    $sup=$value->code;

}
    $this->pdf->Output("Customer contact Details".date('Y-m-d').".pdf", 'I');
?>



<!-- foreach ($customer as $value) {
    $heigh=6*(max(1,$this->pdf->getNumLines($value->description, 40),$this->pdf->getNumLines(trim($value->name), 55)));


}
 -->