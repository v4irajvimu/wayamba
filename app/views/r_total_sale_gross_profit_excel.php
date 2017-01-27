<?php error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);

$this->excel->setActiveSheetIndex(0);

foreach($branch as $ress){
	$this->excel->headerSet3($ress->name,$ress->address,$ress->tp,$ress->fax,$ress->email);
}

$this->excel->setHeading("Total Sales - Gross Profit");

$sno=$this->excel->NextRowNum();

$this->excel->getActiveSheet()->setCellValue('A'.$this->excel->NextRowNum(),"Date Between");
$this->excel->getActiveSheet()->setCellValue('B'.$this->excel->LastRowNum(),$from);

$this->excel->getActiveSheet()->setCellValue('A'.$this->excel->NextRowNum(),"To");
$this->excel->getActiveSheet()->setCellValue('B'.$this->excel->LastRowNum(),$to);

if($cluster!=""){
	$this->excel->getActiveSheet()->setCellValue('A'.$this->excel->NextRowNum(),"Cluster");
	$this->excel->getActiveSheet()->setCellValue('B'.$this->excel->LastRowNum(),$clus);
}
if($branchs!=""){
	$this->excel->getActiveSheet()->setCellValue('A'.$this->excel->NextRowNum(),"Branch");
	$this->excel->getActiveSheet()->setCellValue('B'.$this->excel->LastRowNum(),$bran);
}
if($item!=""){
	$this->excel->getActiveSheet()->setCellValue('A'.$this->excel->NextRowNum(),"Item");
	$this->excel->getActiveSheet()->setCellValue('B'.$this->excel->LastRowNum(),$item);
}

if($supplier!= ""){
	$this->excel->getActiveSheet()->setCellValue('A'.$this->excel->NextRowNum(),"supplier");
	$this->excel->getActiveSheet()->setCellValue('B'.$this->excel->LastRowNum(),$supplier);
}

$eno=$this->excel->LastRowNum();
$this->excel->SetFont('A'.$sno.":".'A'.$eno,"B",12,"","");
$this->excel->SetBlank();

$r=$this->excel->NextRowNum();
$this->excel->getActiveSheet()->setCellValue('A'.$r,"Item Code");
$this->excel->getActiveSheet()->setCellValue('B'.$r,"Item Name");
$this->excel->getActiveSheet()->setCellValue('C'.$r,"Cash");
$this->excel->getActiveSheet()->setCellValue('D'.$r,"Credit");
$this->excel->getActiveSheet()->setCellValue('E'.$r,"C & C");
$this->excel->getActiveSheet()->setCellValue('F'.$r,"SO Sales");
$this->excel->getActiveSheet()->setCellValue('G'.$r,"HP");  
$this->excel->getActiveSheet()->setCellValue('H'.$r,"Total");  
$this->excel->getActiveSheet()->setCellValue('I'.$r,"Cost");  
$this->excel->getActiveSheet()->setCellValue('J'.$r,"Sales Price");  
$this->excel->getActiveSheet()->setCellValue('K'.$r,"Cost Value");  
$this->excel->getActiveSheet()->setCellValue('L'.$r,"Sales Value");  
$this->excel->getActiveSheet()->setCellValue('M'.$r,"Discount");  
$this->excel->getActiveSheet()->setCellValue('N'.$r,"Sales Profit");  

$this->excel->SetBorders('A'.$r.":".'N'.$r);
$this->excel->SetFont('A'.$r.":".'N'.$r,"BC",12,"","");

$key=$this->excel->NextRowNum();

foreach($r_data as $row){

	$this->excel->getActiveSheet()->setCellValue('A'.$key, $row->code);
	$this->excel->getActiveSheet()->setCellValue('B'.$key, $row->description);
	$this->excel->getActiveSheet()->setCellValue('C'.$key, $row->cash_qty);
	$this->excel->getActiveSheet()->setCellValue('D'.$key, $row->credit_qty);
	$this->excel->getActiveSheet()->setCellValue('E'.$key, $row->card_qty);
	$this->excel->getActiveSheet()->setCellValue('F'.$key, $row->so_qty);  
	$this->excel->getActiveSheet()->setCellValue('G'.$key, $row->hp_qty);
	$this->excel->getActiveSheet()->setCellValue('H'.$key, $row->tot_qty);
	$this->excel->getActiveSheet()->setCellValue('I'.$key, $row->cost);
	$this->excel->getActiveSheet()->setCellValue('J'.$key, $row->max_price);
	$this->excel->getActiveSheet()->setCellValue('K'.$key, $row->cost_value);
	$this->excel->getActiveSheet()->setCellValue('L'.$key, $row->sales_value);
	$this->excel->getActiveSheet()->setCellValue('M'.$key, $row->discount);
	$this->excel->getActiveSheet()->setCellValue('N'.$key, $row->profit);



	$tot_cost_val+=(float)$row->cost_value;
	$tot_sales_val+=(float)$row->sales_value;
	$tot_discount+=(float)$row->discount;
	$tot_profit+=(float)$row->profit;



	$this->excel->SetBorders('A'.$key.":".'N'.$key);
	$key++;
}

$this->excel->getActiveSheet()->setCellValue('K'.$key,$tot_cost_val);
$this->excel->getActiveSheet()->setCellValue('L'.$key,$tot_sales_val);  
$this->excel->getActiveSheet()->setCellValue('M'.$key,$tot_discount);
$this->excel->getActiveSheet()->setCellValue('N'.$key,$tot_profit);


$this->excel->AllSettings(array("borders"=>"all",));
$this->excel->SetOutput(array("data"=>$this->excel,"title"=>$header));



























