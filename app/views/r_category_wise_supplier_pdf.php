<?php
error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
$this->pdf->setPrintHeader($header,$type,$duration);
$this->pdf->setPrintHeader(true,$type);
        // var_dump($type);exit();
$this->pdf->setPrintFooter(true);
        //print_r($customer);
$this->pdf->SetFont('helvetica', 'B', 16);
		$this->pdf->AddPage($orientation,$page);   // L or P amd page type A4 or A3

   foreach($branch as $ress){



     $this->pdf->headerSet3($ress->name,$ress->address,$ress->tp,$ress->fax,$ress->email);
   }


   $this->pdf->setY(23);
   $this->pdf->Ln();
   $this->pdf->SetFont('helvetica', 'BUI',12);
   $this->pdf->Cell(0, 6, 'Category wise Supplier   ',0,false, 'L', 0, '', 0, false, 'M', 'M');
   $this->pdf->Ln(12);

   foreach ($customer as $value) {

    $heigh=6*(max(1,$this->pdf->getNumLines($value->address1, 70),$this->pdf->getNumLines($value->name,60)));
    $this->pdf->HaveMorePages($heigh);
    $this->pdf->SetX(16);
    $this->pdf->SetLineStyle(array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0.1, 'color' => array(0, 0, 0)));

    $this->pdf->SetFont('helvetica','',9);

    $this->pdf->MultiCell(35, $heigh,$value->Category,  1, 'L', 0, 0, '', '', true, 0, false, true, 0);
    $this->pdf->MultiCell(25, $heigh,$value->code,  1, 'L', 0, 0, '', '', true, 0, false, true, 0);
    $this->pdf->MultiCell(60, $heigh,$value->name,  1, 'L', 0, 0, '', '', true, 0, false, true, 0);
    $this->pdf->MultiCell(70, $heigh,$value->address1,  1, 'L', 0, 0, '', '', true, 0, false, true, 0);
    $this->pdf->MultiCell(20, $heigh,$value->type,  1, 'L', 0, 0, '', '', true, 0, false, true, 0);
    $this->pdf->MultiCell(25, $heigh,$value->tp,  1, 'L', 0, 1, '', '', true, 0, false, true, 0);

  }






  $this->pdf->Output("Category Wise".date('Y-m-d').".pdf", 'I');

  ?>