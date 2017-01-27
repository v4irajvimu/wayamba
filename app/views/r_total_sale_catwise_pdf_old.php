<?php error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
$this->pdf->setPrintHeader(true,'tot_sales_summary_catwise',$duration);
$this->pdf->setPrintFooter(true);

$this->pdf->SetFont('helvetica', 'B', 16);
$this->pdf->AddPage($orientation,$page);   

$main_cat="default";
$cat="default";


foreach($branch as $ress){
 $this->pdf->headerSet3($ress->name,$ress->address,$ress->tp,$ress->fax,$ress->email);
}

$this->pdf->setY(25);

$this->pdf->SetFont('helvetica', 'BIU',10);
$this->pdf->Cell(70, 5, 'Total Sales Report Summary Category Wise',0,false,  'L', 0, '', 0, false, 'M', 'M');
$this->pdf->Ln();

$this->pdf->SetFont('helvetica', '',9);
$this->pdf->Cell(0, 5, 'Date Between '. $dfrom.' and '.$dto ,0,false, 'L', 0, '', 0, false, 'M', 'M');
$this->pdf->Ln();			

$this->pdf->SetY(42);
$this->pdf->SetX(15);
$this->pdf->SetLineStyle(array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0.1, 'color' => array(0, 0, 0)));
$this->pdf->SetFont('helvetica','',7);

//
$main_cat_qty_tot;
$main_cat_amount_tot;
foreach ($maincat_grouped as  $grouped) {
  $main_cat_qty_tot[$grouped->main_category] = $grouped->qty;
  $main_cat_amount_tot[$grouped->main_category] = $grouped->amount;
}

//


foreach ($value as $row){
  $heigh=5*(max(1,$this->pdf->getNumLines($row->description,50), $this->pdf->getNumLines($row->main_category,20),$this->pdf->getNumLines($row->category,20)));
  $this->pdf->HaveMorePages($heigh);


  if($main_cat!="default" && $main_cat==$row->main_category){

    $this->pdf->MultiCell(25, $heigh, '',L, 'L', false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
    
    if($cat!="default" && $cat==$row->category){
      $this->pdf->MultiCell(25, $heigh, '',L, 'L',false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
    }else{
      $this->pdf->MultiCell(25, $heigh, $row->sub_cat_des,TLR, 'L', false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
    }

    $this->pdf->MultiCell(40, $heigh, $row->description,1, 'L',false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
    $this->pdf->MultiCell(10, $heigh, $row->qty,1, 'R', false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);

    //
    $this->pdf->MultiCell(10, $heigh, "",0, 'L',false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
    
    //

    $this->pdf->MultiCell(20, $heigh, $row->price,1, 'R', false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
    $this->pdf->MultiCell(20, $heigh, $row->discount,1, 'R', false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
    $this->pdf->MultiCell(20, $heigh, $row->amount,1, 'R', false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
    $this->pdf->MultiCell(20, $heigh, '',R, 'R', false, 1, '', '', true, 0, false, true, $heigh,'M' ,false);
          
  }else{

    $this->pdf->MultiCell(25, $heigh, $row->cat_des ,TLR, 'L', false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
    if($cat!="default" && $cat==$row->category){
      $this->pdf->MultiCell(25, $heigh, '',L, 'L', false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
    }else{
      $this->pdf->MultiCell(25, $heigh, $row->sub_cat_des,TLR, 'L', false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
    }
    $this->pdf->MultiCell(40, $heigh, $row->description,1, 'L', false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
    $this->pdf->MultiCell(10, $heigh, $row->qty,1, 'R', false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
    
    //
    $this->pdf->MultiCell(10, $heigh, $main_cat_qty_tot[$row->main_category],TB, 'L',false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
    
    //

    $this->pdf->MultiCell(20, $heigh, $row->price,1, 'R', false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
    $this->pdf->MultiCell(20, $heigh, $row->discount,1, 'R', false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
    $this->pdf->MultiCell(20, $heigh, $row->amount,1, 'R', false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
    $this->pdf->MultiCell(20, $heigh, $main_cat_amount_tot[$row->main_category],TR, 'R', false, 1, '', '', true, 0, false, true, $heigh,'M' ,false);

    $tot_qty=0;
  }
    //$tot_qty+=$row->qty;

  $main_cat=$row->main_category; 
  $cat=$row->category; 

  $net_qty +=  $row->qty;
  $price +=  $row->price;
  $discount +=  $row->discount;
  $amount +=  $row->amount;
}

//$this->pdf->MultiCell(180, 1, '',T, 'R', 0, 1, '', '', true, 0, false, true, 0);

$this->pdf->Ln(); 

$this->pdf->SetFont('helvetica','B',8);
$this->pdf->Cell(25, 6," ", '0', 0, 'C', 0);
$this->pdf->Cell(25, 6," ", '0', 0, 'C', 0);
$this->pdf->Cell(40, 6," ", '0', 0, 'C', 0);
$this->pdf->Cell(10, 6,"Total ", '0', 0, 'R', 0);
$this->pdf->Cell(10, 6,$net_qty, 'BU', 0, 'R', 0);
$this->pdf->Cell(20, 6,number_format($price,2), 'BU', 0, 'R', 0);
$this->pdf->Cell(20, 6,number_format($discount,2), 'BU', 0, 'R', 0);
$this->pdf->Cell(20, 6,'', 'BU', 0, 'R', 0);
$this->pdf->Cell(20, 6,number_format($amount,2), 'BU', 0, 'R', 0);
$this->pdf->Output("Total Sale Summary".date('Y-m-d').".pdf", 'I');

?>