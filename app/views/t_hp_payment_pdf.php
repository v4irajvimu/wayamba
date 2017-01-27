<?php
error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
//$this->pdf->setPrintHeader($header,$type,$duration);

$this->pdf->setPrintFooter(true);
$this->pdf->setPrintHeader(true);
$this->pdf->setPrintHeader($header,$type); 
$this->pdf->SetFont('helvetica', 'B', 16);
$this->pdf->AddPage($orientation,$page);   // L or P amd page type A4 or A3

foreach($branch as $ress){
	$this->pdf->headerSet4($ress->name,$ress->address,$ress->tp,$ress->fax,$ress->email);
}

foreach($session as $ses){
	$invoice_no=$session[0].$session[1].'CA'.$session[2];
}

$agr="";
$itemz="";
foreach($pay_sum as $row){

	$agr_no   	= $row->agreement_no;
	$date   	= $row->ddate;
	$salsman   	= $row->sm_name;
	$salmn_con1 = $row->sm_tp1;
	$salmn_con2 = $row->sm_tp2;
	$salmn_con3 = $row->sm_tp3;
	$customer   = $row->cm_name;
	$cus_con   	= $row->cm_tp;
	$addres1   	= $row->cm_add1;
	$addres2   	= $row->cm_add2;
	$addres3   	= $row->cm_add3;
	$nic     	= $row->nic;

}



$this->pdf->setY(20);
$this->pdf->SetFont('helvetica', 'BU', 10);
$orgin_print=$_POST['org_print'];
if($orgin_print=="1"){
	$this->pdf->Cell(0, 5,'HP PAYMENT',0,false, 'C', 0, '', 0, false, 'M', 'M');
}else{
	$this->pdf->Cell(0, 5,'HP PAYMENT (Duplicate)',0,false, 'C', 0, '', 0, false, 'M', 'M');	
}
$this->pdf->setY(30);
$this->pdf->SetFont('helvetica', 'B', 9);
$this->pdf->Cell(30, 1, 'Agreement No.', '0', 0, 'L', 0);
$this->pdf->SetFont('helvetica', '', 9);
$this->pdf->Cell(70, 1, $agr_no, '0', 0, 'L', 0);
$this->pdf->SetFont('helvetica', 'B', 9);
$this->pdf->Cell(30, 1, 'Date', '0', 0, 'L', 0);
$this->pdf->SetFont('helvetica', '', 9);
$this->pdf->Cell(70, 1, $date, '0', 0, 'L', 0);
$this->pdf->Ln();

$this->pdf->SetFont('helvetica', 'B', 9);
$this->pdf->Cell(30, 1, 'Salesman', '0', 0, 'L', 0);
$this->pdf->SetFont('helvetica', '', 9);
$this->pdf->Cell(70, 1, $salsman, '0', 0, 'L', 0);
$this->pdf->SetFont('helvetica', 'B', 9);
$this->pdf->Cell(30, 1, 'Sale Contacts', '0', 0, 'L', 0);
$this->pdf->SetFont('helvetica', '', 9);
$this->pdf->Cell(70, 1, $salmn_con1." ,". $salmn_con2 ." ,". $salmn_con3, '0', 0, 'L', 0);
$this->pdf->Ln();

$this->pdf->SetFont('helvetica', 'B', 9);
$this->pdf->Cell(30, 1, 'Customer', '0', 0, 'L', 0);
$this->pdf->SetFont('helvetica', '', 9);
$this->pdf->Cell(70, 1, $customer, '0', 0, 'L', 0);
$this->pdf->SetFont('helvetica', 'B', 9);
$this->pdf->Cell(30, 1, "Cus Contacts", '0', 0, 'L', 0);
$this->pdf->SetFont('helvetica', '', 9);
$this->pdf->Cell(70, 1, $cus_con, '0', 0, 'L', 0);
$this->pdf->Ln();

$this->pdf->SetFont('helvetica', 'B', 9);
$this->pdf->Cell(30, 1, 'Address', '0', 0, 'L', 0);
$this->pdf->SetFont('helvetica', '', 9);
$this->pdf->Cell(70, 1, $addres1." ,".$addres2." ,".$addres3, '0', 0, 'L', 0);
$this->pdf->SetFont('helvetica', 'B', 9);
$this->pdf->Cell(30, 1, 'N.I.C', '0', 0, 'L', 0);
$this->pdf->SetFont('helvetica', '', 9);
$this->pdf->Cell(70, 1, $nic, '0', 0, 'L', 0);
$this->pdf->Ln();
$this->pdf->Ln();

$this->pdf->Cell(180, 1, "", 'T', 0, 'L', 0);
$this->pdf->Ln();

$this->pdf->SetLineStyle(array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0.1, 'color' => array(0, 0, 0)));

			foreach($amount as $row){
				$netamt=$row->net_amount;
				$interest=$row->interest_amount;
				$no_ins=$row->no_of_installments;
				$dwn_paymnt=$row->down_payment;
				$charge=$row->document_charges;
				$insAmt=$row->installment_amount;
				$balance=$row->balance;
			}

				$this->pdf->GetY();
				$this->pdf->SetFont('helvetica','B',9);
				$this->pdf->Cell(15, 1,"Net Value", '0', 0, 'L', 0);
				$this->pdf->Cell(15, 1,"", '0', 0, 'L', 0);
				$this->pdf->SetFont('helvetica','',9);
				$this->pdf->Cell(30, 1,number_format($netamt,2), '0', 0, 'L', 0);

				$this->pdf->SetFont('helvetica','B',9);
				$this->pdf->Cell(15, 1,"Interest", '0', 0, 'L', 0);
				$this->pdf->Cell(15, 1,"", '0', 0, 'L', 0);
				$this->pdf->SetFont('helvetica','',9);
				$this->pdf->Cell(30, 1,number_format($interest,2), '0', 0, 'L', 0);

				$this->pdf->SetFont('helvetica','B',9);
				$this->pdf->Cell(15, 1,"No. of Installment", '0', 0, 'L', 0);
				$this->pdf->Cell(15, 1,"", '0', 0, 'L', 0);
				$this->pdf->SetFont('helvetica','',9);
				$this->pdf->Cell(30, 1,$no_ins, '0', 0, 'L', 0);

				$this->pdf->Ln();

				$this->pdf->SetFont('helvetica','B',9);
				$this->pdf->Cell(15, 1,"Down Payment", '0', 0, 'L', 0);
				$this->pdf->Cell(15, 1,"", '0', 0, 'L', 0);
				$this->pdf->SetFont('helvetica','',9);
				$this->pdf->Cell(30, 1,number_format($dwn_paymnt,2), '0', 0, 'L', 0);

				$this->pdf->SetFont('helvetica','B',9);
				$this->pdf->Cell(15, 1,"Document Charge", '0', 0, 'L', 0);
				$this->pdf->Cell(15, 1,"", '0', 0, 'L', 0);
				$this->pdf->SetFont('helvetica','',9);
				$this->pdf->Cell(30, 1,number_format($charge,2), '0', 0, 'L', 0);

				$this->pdf->SetFont('helvetica','B',9);
				$this->pdf->Cell(15, 1,"Installment", '0', 0, 'L', 0);
				$this->pdf->Cell(15, 1,"", '0', 0, '0', 0);
				$this->pdf->SetFont('helvetica','',9);
				$this->pdf->Cell(30, 1,number_format($insAmt,2), '0', 0, '0', 0);

				$this->pdf->Ln();

				$this->pdf->SetFont('helvetica','B',9);
				$this->pdf->Cell(15, 6,"Balance Amount", '0', 0, 'L', 0);
				$this->pdf->Cell(15, 6,"", '0', 0, 'L', 0);
				$this->pdf->SetFont('helvetica','',9);
				$this->pdf->Cell(30, 6,number_format($balance,2), '0', 0, 'L', 0);

				$this->pdf->Ln();
				
				$this->pdf->SetFont('helvetica','B',9);
				$this->pdf->Cell(180, 1, "", 'T', 0, 'L', 0);
				$this->pdf->Ln();

				$this->pdf->SetFont('helvetica', 'B', 9);
				$this->pdf->Cell(20, 6,"Item ID", '1', 0, 'C', 0);
				$this->pdf->Cell(40, 6,"Item", '1', 0, 'C', 0);
				$this->pdf->Cell(30, 6,"Qty", '1', 0, 'C', 0);
				$this->pdf->Cell(30, 6,"Price", '1', 0, 'C', 0);
				$this->pdf->Ln();

				foreach($pay_sum as $row){
					
				$this->pdf->SetFont('helvetica', '', 9);
				$this->pdf->Cell(20, 6,$row->item_code, '1', 0, 'L', 0);
				$this->pdf->Cell(40, 6,$row->description, '1', 0, 'L', 0);
				$this->pdf->Cell(30, 6,$row->qty, '1', 0, 'R', 0);
				$this->pdf->Cell(30, 6,$row->sales_price, '1', 0, 'R', 0);
				$this->pdf->Ln();

				
			}

			$this->pdf->Ln();
			$this->pdf->SetFont('helvetica', 'B', 9);
			$this->pdf->Cell(20, 6,"Inst No", '1', 0, 'C', 0);
			$this->pdf->Cell(40, 6,"Due Date", '1', 0, 'C', 0);
			$this->pdf->Cell(30, 6,"Installement", '1', 0, 'C', 0);
			$this->pdf->Cell(30, 6,"Paid Amount", '1', 0, 'C', 0);
			$this->pdf->Cell(30, 6,"balance ", '1', 0, 'C', 0);
			$this->pdf->Ln();

			foreach($pay_sched as $row){
				$amount=$row->ins_amount;
				$paid=$row->ins_paid;
				$balance=$amount-$paid;

			$this->pdf->SetFont('helvetica', '', 9);
			$this->pdf->Cell(20, 6,$row->ins_no, '1', 0, 'L', 0);
			$this->pdf->Cell(40, 6,$row->due_date, '1', 0, 'L', 0);
			$this->pdf->Cell(30, 6,$row->ins_amount, '1', 0, 'R', 0);
			$this->pdf->Cell(30, 6,$row->ins_paid, '1', 0, 'R', 0);
			$this->pdf->Cell(30, 6,number_format($balance,2), '1', 0, 'R', 0);
			$this->pdf->Ln();
			$am_tot+=$row->ins_amount;
			$pa_tot+=$row->ins_paid;
			$bal_tot+=$balance;
			}

			$this->pdf->SetFont('helvetica', 'B', 9);
			$this->pdf->Cell(20, 6,"", '1', 0, 'L', 0);
			$this->pdf->Cell(40, 6,"Total", '1', 0, 'L', 0);
			$this->pdf->Cell(30, 6,number_format($am_tot,2), '1', 0, 'R', 0);
			$this->pdf->Cell(30, 6,number_format($pa_tot,2), '1', 0, 'R', 0);
			$this->pdf->Cell(30, 6,number_format($bal_tot,2), '1', 0, 'R', 0);
			$this->pdf->Ln();


			$this->pdf->Ln();
			$this->pdf->SetFont('helvetica', 'B', 9);
			$this->pdf->Cell(20, 6,"Receipt Date", '1', 0, 'C', 0);
			$this->pdf->Cell(40, 6,"Receipt No", '1', 0, 'C', 0);
			$this->pdf->Cell(30, 6,"Receipt Amount", '1', 0, 'C', 0);
			$this->pdf->Ln();

			foreach($pay_recie as $row){
				
			$this->pdf->SetFont('helvetica', '', 9);
			$this->pdf->Cell(20, 6,$row->ddate, '1', 0, 'L', 0);
			$this->pdf->Cell(40, 6,$row->inv_no, '1', 0, 'L', 0);
			$this->pdf->Cell(30, 6,$row->paid_amount, '1', 0, 'R', 0);
			$this->pdf->Ln();
			$a_tot+=$row->paid_amount;
			
			}

			$this->pdf->SetFont('helvetica', 'B', 9);
			$this->pdf->Cell(20, 6,"", '1', 0, 'R', 0);
			$this->pdf->Cell(40, 6,"Total", '1', 0, 'L', 0);
			$this->pdf->Cell(30, 6,number_format($a_tot,2), '1', 0, 'R', 0);
			$this->pdf->Ln();
			//$this->pdf->footer_set_cash_sales($employee,$amount,$additional,$discount,$user,$credit_card,$tot_free_item,$cheque_detail,$credit_card_sum,$other1,$other2,$additional_tot);
			$this->pdf->Output("HP installment payment_".date('Y-m-d').".pdf", 'I');

?>