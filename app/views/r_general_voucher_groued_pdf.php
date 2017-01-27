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
$this->pdf->SetLineStyle(array('width' => 0.25, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0)));

$this->pdf->SetFont('helvetica', 'B',15);
$this->pdf->Cell(180, 1,"General Voucher List - Grouped",0,false, 'L', 0, '', 0, false, 'M', 'M');
$this->pdf->Ln();
$this->pdf->SetFont('helvetica', '', 10);
$this->pdf->Cell(180, 1,"Date Form - ".$dfrom."  To - ".$dto,0,false, 'L', 0, '', 0, false, 'M', 'M');
$this->pdf->Ln(3);


    //----------------------------------------------------------------------------------------------------


foreach($details as $row){

 $branch_name=$row->b_name;
 $cluster_name=$row->cl_name;
 $cl_id=$row->cl;
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

$this->pdf->SetFont('helvetica', 'B', 10);
$this->pdf->Ln();
$this->pdf->SetX(15);

$this->pdf->Cell(35, 6,"", '0', 0, 'C', 0);
$this->pdf->Cell(25, 6,"Date", '1', 0, 'C', 0);
$this->pdf->Cell(20, 6,"No", '1', 0, 'C', 0);
$this->pdf->Cell(20, 6,"Sub No", '1', 0, 'C', 0);
$this->pdf->Cell(130, 6,"Description", '1', 0, 'C', 0);
$this->pdf->Cell(25, 6,"Amount", '1', 0, 'C', 0);
$this->pdf->Ln();


$code="default";

foreach($details as $row){

  if($code!="default" && $code==$row->acc_code){
    $this->pdf->HaveMorePages(6);
    $this->pdf->Cell(35, 6,"", '0', 0, 'L', 0);
    $this->pdf->Cell(25, 6,$row->ddate, '1', 0, 'L', 0);
    $this->pdf->Cell(20, 6,$row->nno, '1', 0, 'R', 0);
    $this->pdf->Cell(20, 6,$row->sub_no, '1', 0, 'R', 0);
    $this->pdf->Cell(130, 6,$row->note, '1', 0, 'L', 0);
    $this->pdf->Cell(25, 6,$row->amount, '1', 0, 'R', 0);
    $this->pdf->Ln();


  }else{
    $this->pdf->HaveMorePages(6);
    if($code!="default"){
      $this->pdf->SetFont('helvetica', 'B', 12);
      $this->pdf->Cell(35, 6,"", '0', 0, 'L', 0);
      $this->pdf->Cell(25, 6,"", '0', 0, 'L', 0);
      $this->pdf->Cell(20, 6,"", '0', 0, 'R', 0);
      $this->pdf->Cell(20, 6,"", '0', 0, 'R', 0);
      $this->pdf->Cell(130, 6,"Total", '0', 0, 'R', 0);
      $this->pdf->Cell(25, 6,number_format($tot,2), 'TB', 0, 'R', 0);
      $this->pdf->Ln();
      $tot=0;
    }
    $this->pdf->SetFont('helvetica', 'B', 12);
    $this->pdf->Cell(180, 8,$row->acc_code." - ".$row->acc  , '0', 0, 'L', 0);
    $this->pdf->Ln();
    $this->pdf->SetFont('helvetica', 'B', 10);
    $this->pdf->Cell(35, 6,"", '0', 0, 'L', 0);
    $this->pdf->Cell(25, 6,$row->ddate, '1', 0, 'L', 0);
    $this->pdf->Cell(20, 6,$row->nno, '1', 0, 'R', 0);
    $this->pdf->Cell(20, 6,$row->sub_no, '1', 0, 'R', 0);
    $this->pdf->Cell(130, 6,$row->note, '1', 0, 'L', 0);
    $this->pdf->Cell(25, 6,$row->amount, '1', 0, 'R', 0);
    $this->pdf->Ln();
    
  }
  $tot+=$row->amount;
  $code=$row->acc_code;
}


$this->pdf->Output("general_voucher_details".date('Y-m-d').".pdf", 'I');

?>



