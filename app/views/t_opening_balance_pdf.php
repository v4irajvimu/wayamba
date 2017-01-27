<?php

error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
$this->pdf->setPrintHeader($header, $type, $duration);
$this->pdf->setPrintHeader(true, $type);
 $this->pdf->setPrintFooter(true,'0',$is_cur_time);
//$this->pdf->setPrintHeader(true);

$this->pdf->SetFont('helvetica', 'B', 16);
$this->pdf->AddPage($orientation, $page);   // L or P amd page type A4 or A3

foreach ($branch as $ress) {
    $this->pdf->headerSet4($ress->name, $ress->address, $ress->tp, $ress->fax, $ress->email);
}

$sup_name;
$sup_address;
$sup_tp;
$sup_email;
$ship_branch_name;
$ship_branch_add;
$ship_branch_tp;
$ship_branch_email;


foreach ($suppliers as $sup) {
    $sup_name = $sup->name;
    $sup_address = $sup->address1 . " " . $sup->address2 . " " . $sup->address3;
    $sup_tp = $sup->tp;
    $sup_email = $sup->email;
}

foreach($session as $ses){
    $invoice_no=$session[0].$session[1].$session[2];
}

foreach ($ship_branch as $sb) {
    $ship_branch_name = $sb->name;
    $ship_branch_add = $sb->address1 . " " . $sb->address2 . " " . $sb->address3;
    $ship_branch_tp = $sb->tp;
    $ship_branch_email = $sb->email;
}






if (isset($jtype_desc)) {
    $description = $jtype_desc;
}




$no = "1";

$align_h=$this->utility->heading_align();
$this->pdf->setY(15);
$this->pdf->SetFont('helvetica', 'BU', 10);
$this->pdf->Ln();
$this->pdf->Cell(0, 5, ' OPENING BALANCE', 0, false, $align_h, 0, '', 0, false, '0', '0');

$this->pdf->SetFont('helvetica', '', 7);
$this->pdf->setY(25);
$this->pdf->Ln();
//foreach ($opn_bl_head as $value) {
//    $this->pdf->Cell(10, 1, 'Cluster :', '0', 0, 'L', 0);
//    $this->pdf->Cell(30, 1, $value->name, '0', 0, 'L', 0);
//}
//foreach ($opn_bl_head as $value) {
//    $this->pdf->Cell(15, 1, 'Cluster ID :', '0', 0, 'L', 0);
//    $this->pdf->Cell(20, 1, $value->code, '0', 0, 'L', 0);
//}
//$this->pdf->Ln();
//foreach ($opn_bl_head as $value) {
//    $this->pdf->Cell(10, 1, "Branch :", '0', 0, 'L', 0);
//    $this->pdf->Cell(30, 1, $value->description, '0', 0, 'L', 0);
//}
//foreach ($opn_bl_head as $value) {
//    $this->pdf->Cell(15, 1, 'Branch ID :', '0', 0, 'L', 0);
//    $this->pdf->Cell(20, 1, $value->bc, '0', 0, 'L', 0);
//    $this->pdf->Ln();
//}

$this->pdf->Cell(180, 1, "______________________________________________________________________________________________________________________ ", '0', 0, 'L', 0);
$this->pdf->Ln();
foreach ($opn_bl_head as $value) {
    $this->pdf->Cell(10, 1, 'Cluster :', '0', 0, 'L', 0);
    $this->pdf->Cell(30, 1, $value->name, '0', 0, 'L', 0);
}
foreach ($opn_bl_head as $value) {
    $this->pdf->Cell(15, 1, 'Cluster ID :', '0', 0, 'L', 0);
    $this->pdf->Cell(20, 1, $value->code, '0', 0, 'L', 0);
}

$this->pdf->setX(120);
foreach ($opn_bl_head as $value) {
    $this->pdf->Cell(15, 1, "Date      :", '0', 0, 'L', 0);
    $this->pdf->Cell(5, 1, '', '0', 0, 'L', 0);
    $this->pdf->Cell(30, 1, $value->date.$save_time, '0', 0, 'L', 0);
    $this->pdf->Ln();
}
foreach ($opn_bl_head as $value) {
    $this->pdf->Cell(10, 1, "Branch :", '0', 0, 'L', 0);
    $this->pdf->Cell(30, 1, $value->description, '0', 0, 'L', 0);
}
foreach ($opn_bl_head as $value) {
    $this->pdf->Cell(15, 1, 'Branch ID :', '0', 0, 'L', 0);
    $this->pdf->Cell(20, 1, $value->bc, '0', 0, 'L', 0);
    $this->pdf->Ln();
}
$this->pdf->setX(120);
foreach ($opn_bl_head as $value) {
    $this->pdf->Cell(15, 1, "No         :", '0', 0, 'L', 0);
    $this->pdf->Cell(5, 1, '', '0', 0, 'L', 0);
    $this->pdf->Cell(30, 1, $invoice_no, '0', 0, 'L', 0);
    $this->pdf->Ln();
}
$this->pdf->SetY(45);
foreach ($opn_bl_head as $value) {
    $this->pdf->SetX(120);
    $this->pdf->Cell(15, 1, 'Ref.No   :', '0', 0, 'L', 0);
    $this->pdf->Cell(5, 1, '', '0', 0, 'L', 0);
    $this->pdf->Cell(30, 1, $value->ref_no, '0', 0, 'L', 0);
}

$this->pdf->SetY(50);




$x = 1;
$code = "default";
$this->pdf->SetX(15);
$this->pdf->SetFont('helvetica', 'B', 8);
$this->pdf->Cell(30, 6, "Account", '1', 0, 'C', 0);
$this->pdf->Cell(70, 6, "Discription", '1', 0, 'C', 0);
$this->pdf->Cell(30, 6, "Ac.Type", '1', 0, 'C', 0);
$this->pdf->Cell(20, 6, "Dr Amount", '1', 0, 'C', 0);
$this->pdf->Cell(20, 6, "Cr Amount", '1', 0, 'C', 0);
$this->pdf->Ln();
$totdr = (float) '';
$totcr = (float) '';
foreach ($jrn_en_body as $value) {
    $x = 1;

    $code = "default";
    $this->pdf->SetX(15);
    $this->pdf->SetFont('helvetica', '', 7);
    $this->pdf->SetLineStyle(array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0.1, 'color' => array(0, 0, 0)));
    $this->pdf->Cell(30, 6, "$value->account_code", '1', 0, 'L', 0);
    $this->pdf->Cell(70, 6, "$value->description", '1', 0, 'L', 0);
    $this->pdf->Cell(30, 6, "$value->heading", '1', 0, 'L', 0);
    $this->pdf->Cell(20, 6, number_format("$value->dr_amount",2), '1', 0, 'R', 0);
    $this->pdf->Cell(20, 6, number_format("$value->cr_amount",2), '1', 0, 'R', 0);
    $this->pdf->Ln();
    $totdr = $totdr + (float) $value->dr_amount;
    $totcr = $totcr + (float) $value->cr_amount;
}
//$this->pdf->SetX(15);
$this->pdf->SetFont('helvetica', 'B', 8);
$this->pdf->Cell(100, 5, "", '0', 0, 'c', 0);
$this->pdf->Cell(30, 5, 'Total', '1', 0, 'C', 0);
$this->pdf->Cell(20, 5, number_format($totdr, 2), '1', 0, 'R', 0);
$this->pdf->Cell(20, 5, number_format($totcr, 2), '1', 0, 'R', 0);
$this->pdf->Ln();
$this->pdf->SetFont('helvetica', 'B', 10);
foreach ($opn_bl_head as $value) {
    $this->pdf->Cell(20, 1, 'Description ', '0', 0, 'L', 0);
    $this->pdf->Cell(5, 1, '', '0', 0, 'L', 0);
    $this->pdf->Cell(100, 1, $value->description, '1', 0, 'L', 0);
    $this->pdf->Cell(30, 1, "", '0', 0, 'L', 0);
}

$this->pdf->GetY();
$this->pdf->SetFont('helvetica', 'B', 6);




$this->pdf->Output("Purchase Qutoation_" . date('Y-m-d') . ".pdf", 'I');
?>