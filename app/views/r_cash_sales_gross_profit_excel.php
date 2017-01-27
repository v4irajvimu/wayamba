<?php error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);

$this->excel->setActiveSheetIndex(0);

foreach($branch as $ress){
	$this->excel->headerSet3($ress->name,$ress->address,$ress->tp,$ress->fax,$ress->email);
}

$this->excel->setHeading("Cash Sales - Gross Profit ");

$sno=$this->excel->NextRowNum();

$this->excel->getActiveSheet()->setCellValue('A'.$this->excel->NextRowNum(),"Date Between");
$this->excel->getActiveSheet()->setCellValue('B'.$this->excel->LastRowNum(),$dfrom);

$this->excel->getActiveSheet()->setCellValue('A'.$this->excel->NextRowNum(),"To");
$this->excel->getActiveSheet()->setCellValue('B'.$this->excel->LastRowNum(),$dto);

if($Thcluster!= null){
	$this->excel->getActiveSheet()->setCellValue('A'.$this->excel->NextRowNum(),"Cluster");
	$this->excel->getActiveSheet()->setCellValue('B'.$this->excel->LastRowNum(),$Thcluster);
}

if($Thbranch!=null){
	$this->excel->getActiveSheet()->setCellValue('A'.$this->excel->NextRowNum(),"Branch");
	$this->excel->getActiveSheet()->setCellValue('B'.$this->excel->LastRowNum(),$Thbranch);
}
if($item!=null){
	$this->excel->getActiveSheet()->setCellValue('A'.$this->excel->NextRowNum(),"Item");
	$this->excel->getActiveSheet()->setCellValue('B'.$this->excel->LastRowNum(),$item);
}
if($supplier!=null){
	$this->excel->getActiveSheet()->setCellValue('A'.$this->excel->NextRowNum(),"Supplier");
	$this->excel->getActiveSheet()->setCellValue('B'.$this->excel->LastRowNum(),$supplier);
}


$eno=$this->excel->LastRowNum();
$this->excel->SetFont('A'.$sno.":".'A'.$eno,"B",12,"","");
$this->excel->SetBlank();

$r=$this->excel->NextRowNum();
$this->excel->getActiveSheet()->setCellValue('A'.$r,"Item Code");
$this->excel->getActiveSheet()->setCellValue('B'.$r,"Item Name");
$this->excel->getActiveSheet()->setCellValue('C'.$r,"Qty");
$this->excel->getActiveSheet()->setCellValue('D'.$r,"Cost");
$this->excel->getActiveSheet()->setCellValue('E'.$r,"Sales Price");
$this->excel->getActiveSheet()->setCellValue('F'.$r,"Cost Value");
$this->excel->getActiveSheet()->setCellValue('G'.$r,"Sales Value");  
$this->excel->getActiveSheet()->setCellValue('H'.$r,"Discount");  
$this->excel->getActiveSheet()->setCellValue('I'.$r,"Sales Profit");  

$this->excel->SetBorders('A'.$r.":".'I'.$r);
$this->excel->SetFont('A'.$r.":".'I'.$r,"BC",12,"","");

$key=$this->excel->NextRowNum();

foreach($profit as $row){

	$this->excel->getActiveSheet()->setCellValue('A'.$key, $row->code);
	$this->excel->getActiveSheet()->setCellValue('B'.$key, $row->description);
	$this->excel->getActiveSheet()->setCellValue('C'.$key, $row->qty);
	$this->excel->getActiveSheet()->setCellValue('D'.$key, $row->cost);
	$this->excel->getActiveSheet()->setCellValue('E'.$key, $row->price);
	$this->excel->getActiveSheet()->setCellValue('F'.$key, $row->cost_val);  
	$this->excel->getActiveSheet()->setCellValue('G'.$key, $row->sales_val);
	$this->excel->getActiveSheet()->setCellValue('H'.$key, $row->discount);
	$this->excel->getActiveSheet()->setCellValue('I'.$key, $row->profit);

	$tot_cost_val+=(float)$row->cost_val;
	$tot_sales_val+=(float)$row->sales_val;
	$tot_discount+=(float)$row->discount;
	$tot_profit+=(float)$row->profit;

	$this->excel->SetBorders('A'.$key.":".'H'.$key);
	$key++;
}
$this->excel->getActiveSheet()->setCellValue('F'.$key,$tot_cost_val);
$this->excel->getActiveSheet()->setCellValue('G'.$key, $tot_sales_val);  
$this->excel->getActiveSheet()->setCellValue('H'.$key, $tot_discount);  
$this->excel->getActiveSheet()->setCellValue('I'.$key, $tot_profit);

$this->excel->AllSettings(array("borders"=>"all",));
$this->excel->SetOutput(array("data"=>$this->excel,"title"=>$header));



























