<?php error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
$this->pdf->setPrintHeader($header,$type,$duration);
$this->pdf->setPrintHeader(true,$type);
$this->pdf->setPrintFooter(true);
    //print_r($customer);
$this->pdf->SetFont('helvetica', 'B', 16);
	$this->pdf->AddPage($orientation,$page);   // L or P amd page type A4 or A3
    foreach($branch as $ress){
        $branch_name=$ress->name;
        $this->pdf->headerSet3($ress->name,$ress->address,$ress->tp,$ress->fax,$ress->email);
    }

    $this->pdf->SetFont('helvetica', 'BU',10);
    $this->pdf->Cell(0, 5, 'Cash Sales - Gross Profit  ',0,false, 'L', 0, '', 0, false, 'M', 'M');


    $this->pdf->Ln(4); 
    $this->pdf->SetFont('helvetica', 'B', 8);	
    $this->pdf->Cell(25, 1, "Date", '0', 0, 'L', 0);
    $this->pdf->SetFont('helvetica', '', 8);    
    $this->pdf->Cell(80, 1, ": From : ".$dfrom."  To : ".$dto, '0', 0, 'L', 0);

    if($Thcluster!=""){
     $this->pdf->Ln();    	
     $this->pdf->SetFont('helvetica', 'B', 8);
     $this->pdf->Cell(25, 1, "Cluster", '0', 0, 'L', 0);
     $this->pdf->SetFont('helvetica', '', 8);    
     $this->pdf->Cell(80, 1, ": ".$Thcluster, '0', 0, 'L', 0);
 }

 if($Thbranch!=""){
    $this->pdf->Ln();    	
    $this->pdf->SetFont('helvetica', 'B', 8);
    $this->pdf->Cell(25, 1, "Branch", '0', 0, 'L', 0);
    $this->pdf->SetFont('helvetica', '', 8);    
    $this->pdf->Cell(80, 1, ": ".$Thbranch, '0', 0, 'L', 0);
}

if($item!=""){
    $this->pdf->Ln();    	
    $this->pdf->SetFont('helvetica', 'B', 8);
    $this->pdf->Cell(25, 1, "Item", '0', 0, 'L', 0);
    $this->pdf->SetFont('helvetica', '', 8);    
    $this->pdf->Cell(20, 1,": ".$item, '0', 0, 'L', 0);
}

if($supplier!=""){
    $this->pdf->Ln();    	
    $this->pdf->SetFont('helvetica', 'B', 8);
    $this->pdf->Cell(25, 1, "Supplier", '0', 0, 'L', 0);
    $this->pdf->SetFont('helvetica', '', 8);    
    $this->pdf->Cell(20, 1,": ".$supplier, '0', 0, 'L', 0);
}
$this->pdf->Ln(); 
$this->pdf->Ln(); 

$this->pdf->SetFont('helvetica','B',8);
$this->pdf->Cell(25, 6,"Item Code", '1', 0, 'C', 0);
$this->pdf->Cell(45, 6,"Item Name", '1', 0, 'C', 0);
$this->pdf->Cell(8, 6,"Qty", '1', 0, 'C', 0);
$this->pdf->Cell(18, 6,"Cost", '1', 0, 'C', 0);
$this->pdf->Cell(18, 6,"Sales Price", '1', 0, 'C', 0);
$this->pdf->Cell(18, 6,"Cost Value", '1', 0, 'C', 0);
$this->pdf->Cell(18, 6,"Sales Value", '1', 0, 'C', 0);
$this->pdf->Cell(18, 6,"Discount", '1', 0, 'C', 0);
$this->pdf->Cell(18, 6,"Sales Profit", '1', 0, 'C', 0);
$this->pdf->Ln();

$tot_cost_val=(float)0;
$tot_discount=(float)0;
$tot_sales_val=(float)0;
$tot_profit=(float)0;

foreach ($profit as $value) {

    $heigh=6*(max(1,$this->pdf->getNumLines($value->code,30),$this->pdf->getNumLines($value->description, 45)));
    $this->pdf->HaveMorePages($heigh);

    $this->pdf->SetLineStyle(array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0.1, 'color' => array(0, 0, 0)));
    
    $this->pdf->SetFont('helvetica','',8);
    $this->pdf->MultiCell(25, $heigh,$value->code,'1', 'L', false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
    $this->pdf->MultiCell(45, $heigh,$value->description,'1', 'L', false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
    $this->pdf->MultiCell(8, $heigh,$value->qty,'1', 'R', false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
    $this->pdf->MultiCell(18, $heigh,$value->cost,'1', 'R', false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
    $this->pdf->MultiCell(18, $heigh,$value->price,'1', 'R', false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
    $this->pdf->MultiCell(18, $heigh,$value->cost_val,'1', 'R', false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
    $this->pdf->MultiCell(18, $heigh,$value->sales_val,'1', 'R', false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
    $this->pdf->MultiCell(18, $heigh,$value->discount,'1', 'R', false, 0, '', '', true, 0, false, true, $heigh,'M' ,false);
    $this->pdf->MultiCell(18, $heigh,$value->profit,'1', 'R', false, 1, '', '', true, 0, false, true, $heigh,'M' ,false);


    $tot_cost_val+=(float)$value->cost_val;
    $tot_sales_val+=(float)$value->sales_val;
    $tot_discount+=(float)$value->discount;
    $tot_profit+=(float)$value->profit;

}

$this->pdf->SetFont('helvetica','B',8);

$this->pdf->Cell(96, 6,"", '0', 0, 'R', 0);
$this->pdf->Cell(18, 6,"Total", '0', 0, 'R', 0);
$this->pdf->Cell(18, 6,number_format($tot_cost_val,2), 'TB', 0, 'R', 0);
$this->pdf->Cell(18, 6,number_format($tot_sales_val,2), 'TB', 0, 'R', 0);
$this->pdf->Cell(18, 6,number_format($tot_discount,2), 'TB', 0, 'R', 0);
$this->pdf->Cell(18, 6,number_format($tot_profit,2), 'TB', 0, 'R', 0);    	



	//$this->pdf->footerSet($employee,$amount,$additional,$discount,$user);
$this->pdf->Output("Cash Sales_".date('Y-m-d').".pdf", 'I');

?>