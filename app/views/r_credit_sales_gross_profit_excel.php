<?php error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);

$this->excel->setActiveSheetIndex(0);

foreach($branch as $ress){
	$this->excel->headerSet3($ress->name,$ress->address,$ress->tp,$ress->fax,$ress->email);
}

foreach($r_branch_name as $row){
	$branch_name=$row->name;
	$cluster_name=$row->description;
	$cl_id=$row->code;
	$bc_id=$row->bc;
}
foreach($r_supplier_name as $row){
	$supplier_code=$row->code;
	$supplier_name=$row->name;
}
foreach($r_item_name as $row){
	$item_code=$row->code;
	$item_name=$row->description;
}



$this->excel->setHeading("CREDIT SALES - GROSS PROFIT");

$sno=$this->excel->NextRowNum();

$this->excel->getActiveSheet()->setCellValue('A'.$this->excel->NextRowNum(),"Date Between");
$this->excel->getActiveSheet()->setCellValue('B'.$this->excel->LastRowNum(),$dfrom);

$this->excel->getActiveSheet()->setCellValue('A'.$this->excel->NextRowNum(),"To");
$this->excel->getActiveSheet()->setCellValue('B'.$this->excel->LastRowNum(),$dto);

if($r_branch_name != null){

	$this->excel->getActiveSheet()->setCellValue('A'.$this->excel->NextRowNum(),"Cluster");
	$this->excel->getActiveSheet()->setCellValue('B'.$this->excel->LastRowNum(),$cl_id."|".	$cluster_name);

	if($bc_id != ""){
		$this->excel->getActiveSheet()->setCellValue('A'.$this->excel->NextRowNum(),"Branch");
		$this->excel->getActiveSheet()->setCellValue('B'.$this->excel->LastRowNum(),$bc_id."|".	$branch_name);
	}
}

if($r_supplier_name != null){
	$this->excel->getActiveSheet()->setCellValue('A'.$this->excel->NextRowNum(),"Supplier");
	$this->excel->getActiveSheet()->setCellValue('B'.$this->excel->LastRowNum(),$supplier_code."|".	$supplier_name);
}

if($r_item_name != null){
	$this->excel->getActiveSheet()->setCellValue('A'.$this->excel->NextRowNum(),"Item");
	$this->excel->getActiveSheet()->setCellValue('B'.$this->excel->LastRowNum(),$item_code."|".	$item_name);
}



$eno=$this->excel->LastRowNum();
$this->excel->SetFont('A'.$sno.":".'A'.$eno,"B",12,"","");
$this->excel->SetBlank();

$r=$this->excel->NextRowNum();
$this->excel->getActiveSheet()->setCellValue('A'.$r,"No");
$this->excel->getActiveSheet()->setCellValue('B'.$r,"Code");
$this->excel->getActiveSheet()->setCellValue('C'.$r,"description");
$this->excel->getActiveSheet()->setCellValue('D'.$r,"Qty");
$this->excel->getActiveSheet()->setCellValue('E'.$r,"Cost");
$this->excel->getActiveSheet()->setCellValue('F'.$r,"Sales Price");
$this->excel->getActiveSheet()->setCellValue('G'.$r,"Cost Value");  
$this->excel->getActiveSheet()->setCellValue('H'.$r,"Price Value");  
$this->excel->getActiveSheet()->setCellValue('I'.$r,"Price Value");  
$this->excel->getActiveSheet()->setCellValue('J'.$r,"Profit");  


$this->excel->SetBorders('A'.$r.":".'J'.$r);
$this->excel->SetFont('A'.$r.":".'J'.$r,"BC",12,"","");

$key=$this->excel->NextRowNum();

foreach($sum as $row){

	$this->excel->getActiveSheet()->setCellValue('A'.$key, $row->nno);
	$this->excel->getActiveSheet()->setCellValue('B'.$key, $row->code);
	$this->excel->getActiveSheet()->setCellValue('C'.$key, $row->description);
	$this->excel->getActiveSheet()->setCellValue('D'.$key, $row->qty);
	$this->excel->getActiveSheet()->setCellValue('E'.$key, $row->cost);
	$this->excel->getActiveSheet()->setCellValue('F'.$key, $row->price);  
	$this->excel->getActiveSheet()->setCellValue('G'.$key, $row->cost_value);
	$this->excel->getActiveSheet()->setCellValue('H'.$key, $row->price_value);
	$this->excel->getActiveSheet()->setCellValue('I'.$key, $row->discount);
	$this->excel->getActiveSheet()->setCellValue('J'.$key, $row->profit);


	$tot_cost+=(float)$row->cost_value;
	$tot_price+=(float)$row->price_value;
	$tot_discount+=(float)$row->discount;
	$tot_profit+=(float)$row->profit;

	
	
	$this->excel->SetBorders('A'.$key.":".'I'.$key);
	$key++;
}

$this->excel->getActiveSheet()->setCellValue('G'.$key,$tot_cost);
$this->excel->getActiveSheet()->setCellValue('H'.$key,$tot_price);  
$this->excel->getActiveSheet()->setCellValue('I'.$key,$tot_discount);
$this->excel->getActiveSheet()->setCellValue('j'.$key,$tot_profit);


$this->excel->AllSettings(array("borders"=>"all",));
$this->excel->SetOutput(array("data"=>$this->excel,"title"=>$header));



























