<?php if (!defined('BASEPATH'))
exit('No direct script access allowed');

class t_hp_early_settlement extends CI_Model {

    private $sd;
    private $mod = '003';

    function __construct() {
        parent::__construct();
        $this->sd = $this->session->all_userdata();
        $this->load->database($this->sd['db'], true);
        $this->load->model('user_permissions');
        $this->max_no = $this->utility->get_max_no("t_hp_early_settlement_sum", "nno");
    }

    public function base_details() {
       $a['max']  = $this->utility->get_max_no("t_hp_early_settlement_sum", "nno"); 
       $a['type'] = 'HP_EARLY_SETTLEMENT';
       return $a;
   }


   public function get_form_data(){
    $result = $this->get_agreement_format();
    echo json_encode($result);
}

public function validation() {
    $this->max_no = $this->utility->get_max_no("t_hp_early_settlement_sum", "nno");
    $status = 1;
    if (empty($_POST['save_status']) && $_POST['save_status'] != "1") {
        return "Please check the payment option";
    }
    
    $payment_option_validation = $this->validation->payment_option_calculation();
    if ($payment_option_validation != 1) {
        return $payment_option_validation;
    }
    $check_zero_value=$this->validation->empty_net_value($_POST['net']);
    if($check_zero_value!=1){
        return $check_zero_value;
    } 
    $check_valid_dr_no=$this->validation->check_valid_trans_no2('customer','t_code_','no2_','cl_','bc_');
    if($check_valid_dr_no!=1){
      return $check_valid_dr_no;
  }
  $check_valid_trans_settle_status=$this->validation->check_valid_trans_settle2('customer','t_code_','no2_','settle2_','cl_','bc_');
  if($check_valid_trans_settle_status!=1){
      return $check_valid_trans_settle_status; 
  }
  $check_valid_dr_no2=$this->validation->check_valid_trans_no2('customer','t_code3_','no3_','cl3_','bc3_');
  if($check_valid_dr_no2!=1){
      return $check_valid_dr_no2;
  }
  $check_valid_trans_settle_status2=$this->validation->check_valid_trans_settle2('customer','t_code3_','no3_','settle3_','cl3_','bc3_');
  if($check_valid_trans_settle_status2!=1){
      return $check_valid_trans_settle_status2; 
  }
        /*$account_update=$this->account_update(0);
        if($account_update!=1){
            return "Invalid account entries";
        }  */
        return $status;
    }

    public function save() {
        $this->db->trans_begin();
        error_reporting(E_ALL); 
        function exceptionThrower($type, $errMsg, $errFile, $errLine) { 
            throw new Exception($errFile." - ".$errMsg." - ".$errLine); 
        }
        set_error_handler('exceptionThrower'); 
        try {
            $validation_status = $this->validation();
            if ($validation_status == 1){
                if(isset($_POST['cash'])){
                    $pay_cash=$_POST['cash'];
                }else{
                    $pay_cash="0.00";
                }
                if(isset($_POST['cheque_recieve'])){
                    $pay_cheque=$_POST['cheque_recieve'];
                }else{
                    $pay_cheque="0.00";
                }
                if(isset($_POST['credit_card'])){
                    $pay_ccard=$_POST['credit_card'];
                }else{
                    $pay_ccard="0.00";
                }
                if(isset($_POST['credit_note'])){
                    $pay_cnote=$_POST['credit_note'];
                }else{
                    $pay_cnote="0.00";
                }

                $_POST['acc_codes']=$_POST['customer'];
                
                $sum = array(
                    "cl"                => $this->sd['cl'],
                    "bc"                => $this->sd['branch'],
                    "nno"               => $this->max_no,
                    "ddate"             => $_POST['date'],
                    "ref_no"            => $_POST['ref_no'],
                    "agr_no"            => $_POST['agreement_no'],
                    "customer"          => $_POST['customer'],
                    "inv_no"            => $_POST['inv_no'],
                    //"description"       => $_POST['description'],
                    //"balance"           => $_POST['tot_bal'],
                    "rebeat_amount"     => $_POST['rebeat_tot'],
                    "rebeat_capital"    => $_POST['rebeat_capital'],
                    "rebeat_interest"   => $_POST['rebeat_interest'],
                    "rebeat_panelty"    => $_POST['rebeat_panelty'],
                    "rebeat_other"      => $_POST['rebeat_other'],
                    "paid_amount"       => $_POST['net'],
                    "pay_cash"          => $pay_cash,
                    "pay_cheque"        => $pay_cheque,
                    "pay_ccard"         => $pay_ccard,
                    "pay_cnote"         => $pay_cnote,
                    "oc"                => $this->sd['oc'],                    
                    "exceed_amount"     =>$_POST['exceed_amount'],
                    "collection_officer"=>$_POST['officer'],
                    "loan_amount"       =>$_POST['loan_amo'],
                    "down_payment"      =>$_POST['dwn_amo'],
                    "no_ins"            =>$_POST['no_ins'],
                    "ins_amount"        =>$_POST['ins_amo'],
                    "int_amount"        =>$_POST['int_amo'],
                    "pay_advance"       =>$_POST['advance_amo'],
                    "reb_no"            =>$_POST['reb_no'],
                    );

                for ($x = 0; $x < $_POST['grid_tot']; $x++) {

                    if (isset($_POST['ins_tcode_' . $x], $_POST['date_' . $x], $_POST['settle_' . $x])) {
                        if ($_POST['ins_tcode_' . $x] != "" && $_POST['date_' . $x] != "" && $_POST['settle_' . $x] != "0.00") {
                          $settle = (float)$_POST['rebeat_'.$x]+(float)$_POST['paid_'.$x];

                          $det[] = array(
                            "cl"            => $this->sd['cl'],
                            "bc"            => $this->sd['branch'],
                            "sub_cl"        => $_POST['scl_'.$x],
                            "sub_bc"        => $_POST['sbc_'.$x],
                            "nno"           => $this->max_no,
                            "ins_no"        => $_POST['ins_no_'.$x],
                            "order_type"    => $_POST['rcode_'.$x],
                               /* "trans_code"    => $_POST['tcode_'.$x],
                               "trans_no"      => $_POST['tno_'.$x],*/
                               "date"          => $_POST['date_'.$x],
                               "amount"        => $_POST['amount_'.$x],
                               "rebeat"        => $_POST['rebeat_'.$x],
                               "balance"       => $_POST['balance_'.$x],
                               "paid"          => $_POST['paid_'.$x],
                               "ins_tcode"     => $_POST['ins_tcode_'.$x]
                               );

                          if($_POST['tp_'.$x] !=4){
                            $due_ins_trans[] = array(
                                "scl" => $_POST['scl_'.$x],
                                "bc" => $_POST['sbc_'.$x],
                                "sub_cl" => $this->sd['cl'],
                                "sub_bc" => $this->sd['branch'],
                                "ddate" => $_POST['date_'.$x],
                                "agr_no" => $_POST['agreement_no'],
                                "acc_code" => $_POST['customer'],
                                "due_date" => $_POST['date_'.$x],
                                   //"trans_code" => $_POST['tcode_'.$x],
                                   //"trans_no" => $_POST['trans_no_'.$x],
                                "sub_trans_code" => 95,
                                "sub_trans_no" => $this->max_no,
                                "ins_trans_code" => $_POST['ins_tcode_'.$x],
                                "ins_no" => $_POST['ins_no_'.$x],
                                "dr" => $_POST['balance_'.$x],
                                "oc" => $this->sd['oc']
                                );
                        }
                        $pay_ins_trans[] = array(
                            "cl" => $_POST['scl_'.$x],
                            "bc" => $_POST['sbc_'.$x],
                            "sub_cl" => $this->sd['cl'],
                            "sub_bc" => $this->sd['branch'],
                            "ddate" => $_POST['date_'.$x],
                            "agr_no" => $_POST['agreement_no'],
                            "acc_code" => $_POST['customer'],
                            "due_date" => $_POST['date_'.$x],
                            "trans_code" =>95,
                            "trans_no" => $this->max_no,
                            "sub_trans_code" => 72,
                            "sub_trans_no" => $_POST['reb_no'],
                            "ins_trans_code" => $_POST['ins_tcode_'.$x],
                            "ins_no" => $_POST['ins_no_'.$x],
                            "cr" => $settle,
                            "oc" => $this->sd['oc']
                            );
                    }
                } 
            }
            $settle_exceed=array(
                "cl"            => $this->sd['cl'],
                "bc"            => $this->sd['branch'],
                "ddate"         => $_POST['date'],
                "sub_cl"        => "",
                "sub_bc"        => "",
                "agr_no"        => $_POST['agreement_no'],
                "acc_code"      => $_POST['customer'],
                "trans_code"    => 95,
                "trans_no"      => $this->max_no,
                "sub_trans_code"=> "",
                "sub_trans_no"  => "",
                "dr"            => "0.00",
                "cr"            => $_POST['advance_amo'],
                "oc"            => $this->sd['oc']
                );

            $exceed=array(
                "cl"            => $this->sd['cl'],
                "bc"            => $this->sd['branch'],
                "ddate"         => $_POST['date'],
                "sub_cl"        => "",
                "sub_bc"        => "",
                "agr_no"        => $_POST['agreement_no'],
                "acc_code"      => $_POST['customer'],
                "trans_code"    => 95,
                "trans_no"      => $this->max_no,
                "sub_trans_code"=> "",
                "sub_trans_no"  => "",
                "dr"            => $_POST['exceed_amount'],
                "cr"            => "0.00",
                "oc"            => $this->sd['oc']
                );


            if($_POST['hid'] == "0" || $_POST['hid'] == ""){
                if($this->user_permissions->is_add('t_hp_early_settlement')){
                    $this->db->insert('t_hp_early_settlement_sum', $sum);
                    
                    if(isset($det)){
                       if(count($det)){
                        $this->db->insert_batch("t_hp_early_settlement_det", $det);
                    }
                }
                $date = $_POST['date'];
                $no   = $this->max_no;
                $oc   = $this->sd['oc'];
                $cl   = $this->sd['cl'];
                $bc   = $this->sd['branch'];
                $agr  = $_POST['agreement_no'];

                $this->db->query(
                    "INSERT INTO `t_ins_trans` (`cl`,`bc`,`agr_no`,`acc_code`,due_date ,`ddate`,  `trans_code`, `trans_no`,`ins_trans_code`,`ins_no`,`dr`,`cr`,`oc`)    
                    SELECT s.`cl`,s.`bc`, s.`agr_no`,ss.`cus_id` AS `acc_code`,s.`due_date`,$date, 95  , $no, 1 AS o ,s.`ins_no`,SUM(s.`capital_amount`)AS payble,0, $oc
                    FROM `t_ins_schedule` s 
                    JOIN t_hp_sales_sum ss ON s.`agr_no` = ss.`agreement_no` AND s.`cl` = ss.`cl` AND s.`bc` = ss.`bc`
                    WHERE ss.cl ='$cl' AND ss.bc ='$bc' AND ss.`agreement_no` = '$agr' AND s.is_post='0'

                    UNION ALL

                    SELECT s.`cl`,s.`bc`, s.`agr_no`,ss.`cus_id` AS `acc_code`,s.`due_date`,$date, 95 , $no, 2 AS o ,s.`ins_no`,SUM(s.`int_amount`)AS payble,0,$oc
                    FROM `t_ins_schedule` s 
                    JOIN t_hp_sales_sum ss ON s.`agr_no` = ss.`agreement_no` AND s.`cl` = ss.`cl` AND s.`bc` = ss.`bc`
                    WHERE s.cl ='$cl' AND s.bc ='$bc' AND ss.`agreement_no`='$agr' AND s.is_post='0'
                    ");


/*
                    if(isset($due_ins_trans)){
                       if(count($due_ins_trans)){
                            $this->db->insert_batch("t_ins_trans", $due_ins_trans);
                        }
                    }*/

                    if(isset($pay_ins_trans)){
                       if(count($pay_ins_trans)){
                        $this->db->insert_batch("t_ins_trans", $pay_ins_trans);
                    }
                }

                $this->db->query("UPDATE t_ins_schedule SET is_post = 1 
                    WHERE bc = '".$this->sd['branch']."' AND cl = '".$this->sd['cl']."' AND `agr_no` = '".$_POST['agreement_no']."'");

                if($_POST['exceed_amount']>0){
                    $this->db->insert('t_advance_trans', $exceed);
                }

                if($_POST['advance_amo']>0){
                    $this->db->insert('t_advance_trans', $settle_exceed);
                }

                $this->db->where("cl", $this->sd['cl']);
                $this->db->where("bc", $this->sd['branch']);
                $this->db->where('agreement_no', $_POST['agreement_no']);
                $this->db->update('t_hp_sales_sum', array("is_closed"=>1,'receipt_closed_date'=>$_POST['date'],'receipt_closed_no'=>$this->max_no));

                $this->load->model('t_payment_option');
                $this->t_payment_option->save_payment_option($this->max_no, 95);
                $this->account_update(1);
                $this->utility->save_logger("SAVE",95,$this->max_no,$this->mod);
                echo $this->db->trans_commit();
            }else{
                echo "No permission to save records";
                $this->db->trans_commit();
            }
        }else{
            if($this->user_permissions->is_edit('t_hp_early_settlement')){

                $this->db->where("cl", $this->sd['cl']);
                $this->db->where("bc", $this->sd['branch']);
                $this->db->where('nno', $this->max_no);
                $this->db->update('t_hp_receipt_sum', $sum);
                
                $this->db->where("cl", $this->sd['cl']);
                $this->db->where("bc", $this->sd['branch']);
                $this->db->where('nno', $this->max_no);
                $this->db->delete('t_hp_receipt_det');

                $this->db->where("sub_cl", $this->sd['cl']);
                $this->db->where("sub_bc", $this->sd['branch']);
                $this->db->where('sub_trans_code', 95);
                $this->db->where('sub_trans_no', $this->max_no);
                $this->db->delete('t_ins_trans');

                $this->db->where("cl", $this->sd['cl']);
                $this->db->where("bc", $this->sd['branch']);
                $this->db->where('trans_code', 95);
                $this->db->where('trans_no', $this->max_no);
                $this->db->delete('t_advance_trans');

                if(isset($det)){
                   if(count($det)){
                    $this->db->insert_batch("t_hp_receipt_det", $det);
                }
            }
            if(isset($ins_trans)){
               if(count($ins_trans)){
                $this->db->insert_batch("t_ins_trans", $ins_trans);
            }
        }

        if($_POST['exceed_amount']>0){
            $this->db->insert('t_advance_trans', $exceed);
        }

        if($_POST['advance_amo']>0){
            $this->db->insert('t_advance_trans', $settle_exceed);
        }

        $this->db->where("cl", $this->sd['cl']);
        $this->db->where("bc", $this->sd['branch']);
        $this->db->where('agreement_no', $_POST['agreement_no']);
        $this->db->update('t_hp_sales_sum', array("is_closed"=>1,'receipt_closed_date'=>$_POST['date'],'receipt_closed_no'=>$this->max_no));

        $this->load->model('t_payment_option');
        $this->t_payment_option->delete_all_payments_opt(95, $this->max_no);
        $this->t_payment_option->save_payment_option($this->max_no, 95);
        $this->account_update(1);
        $this->utility->save_logger("EDIT",95,$this->max_no,$this->mod);
        echo $this->db->trans_commit();
    }else{
        echo "No permission to edit records";    
        $this->db->trans_commit();
    }   

}
}else{
    echo $validation_status;
    $this->db->trans_commit();
}
}catch(Exception $e){ 
    $this->db->trans_rollback();
    echo $e->getMessage()."Operation fail please contact admin"; 
}     
}




public function account_update($condition){
    $this->db->where("trans_no", $this->max_no);
    $this->db->where("trans_code", 95);
    $this->db->where("cl", $this->sd['cl']);
    $this->db->where("bc", $this->sd['branch']);
    $this->db->delete("t_check_double_entry");


    if ($_POST['hid'] != "0" || $_POST['hid'] != "") {
        $this->db->where('cl',$this->sd['cl']);
        $this->db->where('bc',$this->sd['branch']);
        $this->db->where('trans_code',95);
        $this->db->where('trans_no',$this->max_no);
        $this->db->delete('t_account_trans');
    }

    $config = array(
        "ddate" => $_POST['date'],
        "trans_code" => 95,
        "trans_no" => $this->max_no,
        "op_acc" => 0,
        "reconcile" => 0,
        "cheque_no" => 0,
        "narration" => "",
        "ref_no" => $_POST['ref_no']
        );

    $sql = "SELECT name from m_customer where code = '".$_POST['customer']."' LIMIT 1";
    $cus_name = $this->db->query($sql)->first_row()->name;

    $des = "HP Early Settlement - ".$cus_name;
    $this->load->model('account');
    $this->account->set_data($config);

    $balance_amnt = (float)$_POST['net2'] - (float)$_POST['exceed_amount'];
    $this->account->set_value2($des, $balance_amnt, "cr", $_POST['customer'],$condition);

    if($_POST['exceed_amount']>0){
        $acc_code = $this->utility->get_default_acc('ADVANCED_RECEIVED');
        $this->account->set_value2($des, $_POST['exceed_amount'], "cr", $acc_code,$condition);
    }

    if(isset($_POST['cash']) && !empty($_POST['cash']) && $_POST['cash']>0){
      $acc_code = $this->utility->get_default_acc('CASH_IN_HAND');
      $this->account->set_value2($des, $_POST['cash'], "dr", $acc_code,$condition);    
  }

  if(isset($_POST['cheque_recieve']) && !empty($_POST['cheque_recieve']) && $_POST['cheque_recieve']>0){
      $acc_code = $this->utility->get_default_acc('CHEQUE_IN_HAND');
      $this->account->set_value2($des, $_POST['cheque_recieve'], "dr", $acc_code,$condition);    
  }

  if(isset($_POST['credit_card']) && !empty($_POST['credit_card']) && $_POST['credit_card']>0){
    for($x = 0; $x<25; $x++){
        if(isset($_POST['type1_'.$x]) && isset($_POST['amount1_'.$x]) && isset($_POST['bank1_'.$x]) && isset($_POST['no1_'.$x])){
            if(!empty($_POST['type1_'.$x]) && !empty($_POST['amount1_'.$x]) && !empty($_POST['bank1_'.$x]) && !empty($_POST['no1_'.$x])){
                            // $acc_code = $this->utility->get_default_acc('CREDIT_CARD_IN_HAND');
                $acc_code = $_POST['acc1_'.$x];
                $this->account->set_value2('credit_card', $_POST['amount1_'.$x], "dr", $acc_code,$condition);    

                $acc_code_dr = $this->utility->get_default_acc('CREDIT_CARD_INTEREST');
                $this->account->set_value2('Merchant commission', $_POST['amount_rate1_'.$x], "dr", $acc_code_dr,$condition);    

                $acc_code_cr = $this->utility->get_default_acc('CREDIT_CARD_IN_HAND');
                $this->account->set_value2('Merchant commission', $_POST['amount_rate1_'.$x], "cr", $acc_code_cr,$condition); 

            }
        }
    }  
}


if(isset($_POST['credit_note']) && !empty($_POST['credit_note']) && $_POST['credit_note']>0){
  $acc_code = $this->utility->get_default_acc('CREDIT_NOTE');
  $this->account->set_value2('credit_note', $_POST['credit_note'], "dr", $acc_code,$condition);    
}

if(isset($_POST['debit_note']) && !empty($_POST['debit_note'])  && $_POST['debit_note']>0){
  $acc_code = $this->utility->get_default_acc('DEBIT_NOTE');
  $this->account->set_value2('debit_note', $_POST['debit_note'], "cr", $acc_code,$condition);    
}

$panelty_tot=(float)0;

for($y=0; $y<$_POST['grid_tot']; $y++){
    if(isset($_POST['paid_'.$y]) && isset($_POST['rcode_'.$y])){
        if(!empty($_POST['paid_'.$y]) && !empty($_POST['rcode_'.$y])){
            if($_POST['rcode_'.$y]==3){
                $panelty_tot += (float)$_POST['paid_'.$y];
            }            
        }
    }    
}

$acc_code=$this->utility->get_default_acc('DEFAULT_INT_INCOME');
$this->account->set_value2($des, $panelty_tot, "cr", $acc_code,$condition);

$acc_code=$this->utility->get_default_acc('DEFAULT_INT_RECEIVE');
$this->account->set_value2($des, $panelty_tot, "dr", $acc_code,$condition);

if($condition==0){
 $query = $this->db->query("
     SELECT (IFNULL( SUM( t.`dr_amount`),0) = IFNULL(SUM(t.`cr_amount`),0)) AS ok 
     FROM `t_check_double_entry` t
     LEFT JOIN `m_account` a ON t.`acc_code` = a.`code`
     WHERE  t.`cl`='" . $this->sd['cl'] . "'  AND t.`bc`='" . $this->sd['branch'] . "'  AND t.`trans_code`='95'  AND t.`trans_no` ='" . $this->max_no . "' AND 
     a.`is_control_acc`='0'");

 if ($query->row()->ok == "0") {
    $this->db->where("trans_no", $this->max_no);
    $this->db->where("trans_code",95);
    $this->db->where("cl", $this->sd['cl']);
    $this->db->where("bc", $this->sd['branch']);
    $this->db->delete("t_check_double_entry");
    return "0";
} else {
    return "1";
}
}
}

public function load_grid(){
 $x=0;
 $sql_load="SELECT ddate,inv_no,paid_amount FROM `t_hp_receipt_sum` WHERE inv_no='".$_POST['ins_id']."' ";
 $query_sum = $this->db->query($sql_load);

 if($query_sum->num_rows()>0){
    $a['load']=$query_sum->result();
}else{
    $x=2;
}
if($x==0){
  echo json_encode($a);
}else{
  echo json_encode($x);
}
}

public function set_edit(){
    $x=0;  
    $no=$_POST['code'];

    $sql_sum="SELECT nno,
    ddate,
    ref_no,
    agr_no,
    customer,
    m.`name`,
    GROUP_CONCAT(m.`address1`, m.`address2`,m.`address3`)AS address,
    inv_no,
    description,
    balance,
    rebeat_amount,
    rebeat_capital,
    rebeat_interest,
    rebeat_panelty,
    rebeat_other,
    paid_amount,
    is_cancel,
    pay_cash,
    pay_ccard,
    pay_cheque,
    pay_cnote,
    exceed_amount,
    t.collection_officer,
    loan_amount,
    down_payment,
    no_ins,
    ins_amount,
    int_amount,
    pay_advance,
    reb_no,
    e.name as officer_name
    FROM t_hp_early_settlement_sum t
    JOIN m_customer m ON m.`code` = t.`customer`
    JOIN m_employee e on e.code = t.collection_officer
    WHERE t.`nno` ='$no' AND t.cl='".$this->sd['cl']."' AND t.bc='".$this->sd['branch']."'";

    $query_sum = $this->db->query($sql_sum);

    if($query_sum->num_rows()>0){
        $a['sum'] = $query_sum->result();
    }else{
        $x = "2";
    }

    $sql_det="SELECT t.*,
    r.`description`
    FROM t_hp_early_settlement_det t
    JOIN r_hp_trans_type r ON r.`code` = t.`order_type` 
    WHERE t.`nno`='$no' AND cl='".$this->sd['cl']."' AND bc='".$this->sd['branch']."'
    ORDER BY t.auto_no asc";

    $query_det = $this->db->query($sql_det);

        //if($query_det->num_rows()>0){
    $a['det'] = $query_det->result();
        //}else{
        //    $x = "2";
        //}

    if($x==0){
        echo json_encode($a);
    }else{
        echo json_encode($x);
    }
}

public function delete() {
    $this->db->trans_begin();
    error_reporting(E_ALL); 
    function exceptionThrower($type, $errMsg, $errFile, $errLine) { 
        throw new Exception($errMsg); 
    }
    set_error_handler('exceptionThrower'); 
    try{
        if($this->user_permissions->is_delete('t_hp_early_settlement')){
            $data=array('is_cancel'=>'1');
            $this->db->where('cl',$this->sd['cl']);
            $this->db->where('bc',$this->sd['branch']);
            $this->db->where('nno',$_POST['code']);
            $this->db->update('t_hp_early_settlement_sum',$data);

            $this->db->where("cl", $this->sd['cl']);
            $this->db->where("bc", $this->sd['branch']);
            $this->db->where('trans_code', 95);
            $this->db->where('trans_no', $_POST['code']);
            $this->db->delete('t_ins_trans');

            $this->db->where('cl',$this->sd['cl']);
            $this->db->where('bc',$this->sd['branch']);
            $this->db->where('trans_code','95');
            $this->db->where('trans_no',$_POST['code']);
            $this->db->delete('t_account_trans');

            $this->db->where("cl", $this->sd['cl']);
            $this->db->where("bc", $this->sd['branch']);
            $this->db->where('trans_code', 95);
            $this->db->where('trans_no', $_POST['code']);
            $this->db->delete('t_advance_trans');

            $this->db->where("cl", $this->sd['cl']);
            $this->db->where("bc", $this->sd['branch']);
            $this->db->where('agreement_no', $_POST['agr_no']);
            $this->db->update('t_hp_sales_sum',array("is_closed"=>0));

            $this->utility->save_logger("DELETE",95,$_POST['code'],$this->mod);
            echo $this->db->trans_commit();
        }else{
            $this->db->trans_commit();
            echo "No permission to delete records";
        }  
    }catch(Exception $e){ 
        $this->db->trans_rollback();
        echo $e->getMessage()."Operation fail please contact admin".$e; 
    }  
}

public function load_agreement_no(){

    if($_POST['search'] == 'Key Word: code, name'){$_POST['search'] = "";}
    if($_POST['cus']!=""){
        $cus=" AND h.`cus_id` ='".$_POST['cus']."'";
    }else{
        $cus="";
    }

    $sql="SELECT t.agr_no, 
    h.`cus_id`, 
    h.nno, 
    h.ddate,
    c.`name`,
    c.nic,
    CONCAT(c.address1,' ',c.address2,' ',c.address3) as address 
    FROM t_ins_trans t
    LEFT JOIN t_hp_sales_sum h ON h.`agreement_no` = t.`agr_no` AND h.`cl` = t.`cl` AND h.`bc` = t.`bc`
    JOIN m_customer c ON c.`code` = h.`cus_id`  
    WHERE (t.agr_no LIKE '%$_POST[search]%' 
    OR h.`cus_id` LIKE '%$_POST[search]%' 
    OR c.`name` LIKE '%$_POST[search]%'
    OR c.`nic` LIKE '%$_POST[search]%')
    $cus
    AND h.cl='".$this->sd['cl']."' AND h.bc='".$this->sd['branch']."'
    AND is_closed='0'
    group by t.agr_no
    LIMIT 20";

    $query=$this->db->query($sql);

    $a  = "<table id='item_list' style='width : 100%' >";
    $a .= "<thead><tr>";
    $a .= "<th class='tb_head_th'>Agreement No</th>";
    $a .= "<th class='tb_head_th' colspan='2'>Customer</th>";
    $a .= "<th class='tb_head_th'>NIC</th>";
    $a .= "<th class='tb_head_th'>Invoice No</th>";
    $a .= "</thead></tr><tr class='cl'><td>&nbsp;</td><td colspan='2'>&nbsp;</td></tr>";

    foreach($query->result() as $r){
      $a .= "<tr class='cl'>";
      $a .= "<td>".$r->agr_no."</td>";
      $a .= "<td colspan='2'>".$r->name."</td>";
      $a .= "<td>".$r->nic."</td>";
      $a .= "<td>".$r->nno."</td>";
      $a .= "<td style='display:none;'>".$r->cus_id."</td>";    
      $a .= "<td style='display:none;'>".$r->ddate."</td>";    
      $a .= "<td style='display:none;'>".$r->address."</td>";     

      $a .= "</tr>";
  }
  $a .= "</table>";
  echo $a;
}

public function load_balance_breakup(){

    if($_POST['search'] == 'Key Word: code, name'){$_POST['search'] = "";}

    if($_POST['is_multi']=="s"){
        $sql="SELECT r.description,
        SUM(t.dr) - SUM(t.cr) AS balance,
        SUM(t.cr) AS cr,
        SUM(t.dr) AS dr
        FROM t_ins_trans t
        JOIN r_hp_trans_type r ON r.code = t.ins_trans_code
        WHERE t.cl = '".$this->sd['cl']."' 
        AND t.bc = '".$this->sd['branch']."' 
        AND t.agr_no = '".$_POST['agr_no']."' 
        GROUP BY r.code
        HAVING (dr) - (cr) > 0 
        ORDER BY r.order_no  ";
    }

    if($_POST['is_multi']=="m"){
        $sql="SELECT r.description,
        SUM(t.dr) - SUM(t.cr) AS balance,
        SUM(t.cr) AS cr,
        SUM(t.dr) AS dr
        FROM t_ins_trans t
        JOIN r_hp_trans_type r ON r.code = t.ins_trans_code
        WHERE t.agr_no = '".$_POST['agr_no']."' 
        GROUP BY r.code
        HAVING (dr) - (cr) > 0 
        ORDER BY r.order_no  ";
    }



    $query=$this->db->query($sql);

    $a['grid'] = "<table id='item_list' style='width : 100%'>";
    $a['grid'] .= "<thead><tr>";
    $a['grid'] .= "<th class='tb_head_th' colspan='2'>Description</th>";
    $a['grid'] .= "<th class='tb_head_th'>Balance</th>";
    $a['grid'] .= "</thead></tr><tr class='cl'></tr><tbody>";
    $tot=(float)0;
    foreach($query->result() as $r){
        $a['grid'] .= "<td colspan='2'>".$r->description."</td>";
        $a['grid'] .= "<td>".$r->balance."</td>";
        $a['grid'] .= "</tr></tbody>";
        $tot+=(float)$r->balance;
    }
    $a['grid'] .= "</table>";
    $a['tot'] = $tot;
    echo json_encode($a);
}

public function load_instalment_list(){


         /*
         move penalty from t_penalty_trans_hp to t_ins_trans        
            $this->load->model('t_day_process');
            $this->t_day_process->move_penalty_ti_ins_trans( $_POST['date'],$_POST['max_no'],$_POST['agr_no'], $this->sd['oc'] ,$this->sd['branch'], $this->sd['cl'] );
        END ----
        */
        $cl =$this->sd['cl'];
        $bc =$this->sd['branch'];
        $agr=$_POST['agr_no'];

        $sql_intfr="SELECT m.`is_intfree` FROM t_hp_sales_sum s
        JOIN `m_hp_payment_scheme` m ON m.`code`=s.`scheme_id`
        WHERE s.cl = '$cl' AND s.bc = '$bc' AND s.agreement_no = '$agr'";

        $query_intr_fre=$this->db->query($sql_intfr);
        $is_int_fr=$query_intr_fre->first_row()->is_intfree;

        if($is_int_fr!='1'){
            $sql="SELECT '1' as tp,'CAPITAL' AS des,s.`cl`,s.`bc`, s.`agr_no`,ss.`cus_id` AS `acc_code`,s.`due_date`, 47  , 1 AS o ,s.`ins_no`,SUM(s.`capital_amount`)AS payble,SUM(i.cr) AS paid, (SUM(s.`capital_amount`)-(ifnull(i.cr,0))) AS balance
            FROM `t_ins_schedule` s 
            JOIN t_hp_sales_sum ss ON s.`agr_no` = ss.`agreement_no` AND s.`cl` = ss.`cl` AND s.`bc` = ss.`bc`
            LEFT JOIN (SELECT cl,bc,agr_no, SUM(cr) AS cr FROM t_ins_trans WHERE cl='$cl' AND bc='$bc' AND agr_no='$agr' AND ins_trans_code='1') i ON i.`cl` = ss.cl AND i.`bc` = ss.`bc`  AND ss.`agreement_no` = i.`agr_no`
            WHERE ss.cl ='$cl' AND ss.bc ='$bc' AND ss.`agreement_no` = '$agr' 
            HAVING balance > 0


            UNION ALL

            SELECT '2' as tp,'INTEREST' AS des,s.`cl`,s.`bc`, s.`agr_no`,ss.`cus_id` AS `acc_code`,s.`due_date`, 47 ,  2 AS o ,s.`ins_no`,SUM(s.`int_amount`)AS payble,SUM(i.cr) AS paid, (SUM(s.`int_amount`)-(ifnull(i.cr,0))) AS balance
            FROM `t_ins_schedule` s 
            JOIN t_hp_sales_sum ss ON s.`agr_no` =ss.`agreement_no` AND s.`cl` = ss.`cl` AND s.`bc` = ss.`bc`
            LEFT JOIN (SELECT cl,bc,agr_no, SUM(cr) AS cr FROM t_ins_trans WHERE cl='$cl' AND bc='$bc' AND agr_no='$agr' AND ins_trans_code='2') i ON i.`cl` = ss.cl AND i.`bc` = ss.`bc`  AND ss.`agreement_no` = i.`agr_no`
            WHERE s.cl ='$cl' AND s.bc ='$bc' AND ss.`agreement_no`='$agr'
            HAVING balance > 0

            UNION ALL

                /*SELECT '3' as tp,'PENELTY' AS des,IT.cl,IT.bc,IT.`agr_no`,SS.`cus_id` AS `acc_code`,IT.`due_date`,47,3 AS o ,IT.`ins_no`,
                IFNULL(ROUND(((SUM(IT.`dr`) - SUM(IT.`cr`)) * (SELECT penalty_rate FROM def_option_account) / 100) / 30,2),0) AS `penalty_amount` ,
                i.cr AS paid, IFNULL(ROUND(((SUM(IT.`dr`) - SUM(IT.`cr`)) * (SELECT penalty_rate FROM def_option_account) / 100) / 30,2),0) - ifnull(i.cr,0) AS balance
                FROM `t_ins_trans` IT 
                JOIN t_hp_sales_sum SS ON IT.`agr_no` = SS.`agreement_no` AND IT.`cl` = SS.`cl` AND IT.`bc` = SS.`bc`
                LEFT JOIN (SELECT cl,bc,agr_no, SUM(cr) AS cr FROM t_ins_trans WHERE cl='$cl' AND bc='$bc' AND agr_no='$agr' AND ins_trans_code='3') i ON i.`cl` = SS.cl AND i.`bc` = SS.`bc`  AND SS.`agreement_no` = i.`agr_no`
                WHERE IT.agr_no='$agr' AND IT.`bc` = '$bc' AND IT.`cl` = '$cl' AND IT.`ins_trans_code` IN (1,2) 
                GROUP BY IT.`agr_no`
                HAVING balance> 0 
                */
                SELECT '3' AS tp,'PENELTY' AS des,IT.cl,IT.bc,IT.`agr_no`,ss.`cus_id` AS `acc_code`,IT.`due_date`,47,3 AS o,IT.`ins_no`,IFNULL(SUM(IT.`dr`) - SUM(IT.`cr`),0) AS penalty_amount,SUM(IT.cr) AS paid,IFNULL(SUM(IT.`dr`) - SUM(IT.`cr`),0) AS balance 
                FROM `t_ins_trans` IT 
                JOIN t_hp_sales_sum ss ON IT.`agr_no` = ss.`agreement_no` AND IT.`cl` = ss.`cl` AND IT.`bc` = ss.`bc` 
                WHERE IT.`ins_trans_code` ='3' AND IT.cl = '$cl' AND IT.bc = '$bc' AND IT.agr_no = '$agr' 
                HAVING balance >0

                UNION ALL 

                SELECT '4' as tp,r.description,t.cl,t.bc,t.agr_no,ss.`cus_id` AS `acc_code`,t.`due_date`,47,t.ins_trans_code AS o,t.`ins_no`,SUM(t.dr) AS payble, SUM(t.cr) AS paid, ifnull(SUM(t.dr),0) - ifnull(SUM(t.cr),0) AS balance
                FROM t_ins_trans t 
                JOIN r_hp_trans_type r ON r.code = t.ins_trans_code 
                JOIN t_hp_sales_sum ss ON t.`agr_no` = ss.`agreement_no` AND t.`cl` = ss.`cl` AND t.`bc` = ss.`bc`
                WHERE t.cl = '$cl' 
                AND t.bc = '$bc' 
                AND t.agr_no = '$agr' 
                AND (t.ins_trans_code ='4' OR t.ins_trans_code ='5')
                GROUP BY t.agr_no,t.ins_trans_code
                HAVING SUM(t.dr)-SUM(t.cr)>0
                ORDER BY o DESC";
            }else{
                $sql="SELECT '1' as tp,'CAPITAL' AS des,s.`cl`,s.`bc`, s.`agr_no`,ss.`cus_id` AS `acc_code`,s.`due_date`, 47  , 1 AS o ,s.`ins_no`,SUM(s.`capital_amount`)AS payble,SUM(i.cr) AS paid, (SUM(s.`capital_amount`)-(ifnull(i.cr,0))) AS balance
                FROM `t_ins_schedule` s 
                JOIN t_hp_sales_sum ss ON s.`agr_no` = ss.`agreement_no` AND s.`cl` = ss.`cl` AND s.`bc` = ss.`bc`
                LEFT JOIN (SELECT cl,bc,agr_no, SUM(cr) AS cr FROM t_ins_trans WHERE cl='$cl' AND bc='$bc' AND agr_no='$agr' AND ins_trans_code='1') i ON i.`cl` = ss.cl AND i.`bc` = ss.`bc`  AND ss.`agreement_no` = i.`agr_no`
                WHERE ss.cl ='$cl' AND ss.bc ='$bc' AND ss.`agreement_no` = '$agr' 
                HAVING balance > 0


                UNION ALL

                /*SELECT '3' as tp,'PENELTY' AS des,IT.cl,IT.bc,IT.`agr_no`,SS.`cus_id` AS `acc_code`,IT.`due_date`,47,3 AS o ,IT.`ins_no`,
                IFNULL(ROUND(((SUM(IT.`dr`) - SUM(IT.`cr`)) * (SELECT penalty_rate FROM def_option_account) / 100) / 30,2),0) AS `penalty_amount` ,
                i.cr AS paid, IFNULL(ROUND(((SUM(IT.`dr`) - SUM(IT.`cr`)) * (SELECT penalty_rate FROM def_option_account) / 100) / 30,2),0) - ifnull(i.cr,0) AS balance
                FROM `t_ins_trans` IT 
                JOIN t_hp_sales_sum SS ON IT.`agr_no` = SS.`agreement_no` AND IT.`cl` = SS.`cl` AND IT.`bc` = SS.`bc`
                LEFT JOIN (SELECT cl,bc,agr_no, SUM(cr) AS cr FROM t_ins_trans WHERE cl='$cl' AND bc='$bc' AND agr_no='$agr' AND ins_trans_code='3') i ON i.`cl` = SS.cl AND i.`bc` = SS.`bc`  AND SS.`agreement_no` = i.`agr_no`
                WHERE IT.agr_no='$agr' AND IT.`bc` = '$bc' AND IT.`cl` = '$cl' AND IT.`ins_trans_code` IN (1,2) 
                GROUP BY IT.`agr_no`
                HAVING balance> 0 
                */
                SELECT '3' AS tp,'PENELTY' AS des,IT.cl,IT.bc,IT.`agr_no`,ss.`cus_id` AS `acc_code`,IT.`due_date`,47,3 AS o,IT.`ins_no`,IFNULL(SUM(IT.`dr`) - SUM(IT.`cr`),0) AS penalty_amount,SUM(IT.cr) AS paid,IFNULL(SUM(IT.`dr`) - SUM(IT.`cr`),0) AS balance 
                FROM `t_ins_trans` IT 
                JOIN t_hp_sales_sum ss ON IT.`agr_no` = ss.`agreement_no` AND IT.`cl` = ss.`cl` AND IT.`bc` = ss.`bc` 
                WHERE IT.`ins_trans_code` ='3' AND IT.cl = '$cl' AND IT.bc = '$bc' AND IT.agr_no = '$agr' 
                HAVING balance >0

                UNION ALL 

                SELECT '4' as tp,r.description,t.cl,t.bc,t.agr_no,ss.`cus_id` AS `acc_code`,t.`due_date`,47,t.ins_trans_code AS o,t.`ins_no`,SUM(t.dr) AS payble, SUM(t.cr) AS paid, ifnull(SUM(t.dr),0) - ifnull(SUM(t.cr),0) AS balance
                FROM t_ins_trans t 
                JOIN r_hp_trans_type r ON r.code = t.ins_trans_code 
                JOIN t_hp_sales_sum ss ON t.`agr_no` = ss.`agreement_no` AND t.`cl` = ss.`cl` AND t.`bc` = ss.`bc`
                WHERE t.cl = '$cl' 
                AND t.bc = '$bc' 
                AND t.agr_no = '$agr' 
                AND (t.ins_trans_code ='4' OR t.ins_trans_code ='5')
                GROUP BY t.agr_no,t.ins_trans_code
                HAVING SUM(t.dr)-SUM(t.cr)>0
                ORDER BY o DESC";
            }



            $query=$this->db->query($sql);
            $a  ="<fieldset>";
            $a .="<legend>Installment</legend>";
            $a .= "<table id='tgrid'>";
            $a .= "<thead><tr>";
            $a .= "<th class='tb_head_th' style='width:40px;'>No</th>";
            $a .= "<th class='tb_head_th' style='width:30px; text-align:center;'>Ins No</th>";
            $a .= "<th class='tb_head_th' style='width:100px; text-align:center;'>Type</th>";
            /* $a .= "<th class='tb_head_th' style='width:30px; text-align:left;'>Trans No</th>";*/
            $a .= "<th class='tb_head_th' style='width:60px;'>Date</th>";
            $a .= "<th class='tb_head_th' style='width:55px;'>Amount</th>";
            $a .= "<th class='tb_head_th' style='width:55px;'>Balance</th>";
            $a .= "<th class='tb_head_th' style='width:55px;'>Rebeat</th>";
            $a .= "<th class='tb_head_th' style='width:55px;'>Paid</th>";
            $a .= "<th class='tb_head_th' style='width:55px;'>Tot Settle</th>";
            $a .= "</thead></tr><tr class='cl'></tr><tbody>";
            $x=0;
            $y=1;
            $tot=$bal=(float)0;

            foreach($query->result() as $r){
                $a .= "<td style='width:40px;'><input type='text' style='width:100%; text-align:right;' readonly name='no_".$x."' id='no_".$x."' title='".$y."' value='".$y."'/></td>";
                $a .= "<td style='width:30px;'><input type='text' style='width:100%; text-align:right;' readonly name='ins_no_".$x."' id='ins_no_".$x."' title='$r->ins_no' value='$r->ins_no'/></td>";
                $a .= "<td style='width:100px;'>
                <input type='text' style='width:100%; text-align:left;' readonly name='types_".$x."' id='types_".$x."' title='$r->des' value='$r->des'/>
                <input type='hidden' style='width:100%; text-align:left;' readonly name='rcode_".$x."' id='rcode_".$x."' value='$r->o'/>
                <input type='hidden' style='width:100%; text-align:left;' readonly name='scl_".$x."' id='scl_".$x."' value='$r->cl'/>
                <input type='hidden' style='width:100%; text-align:left;' readonly name='sbc_".$x."' id='sbc_".$x."' value='$r->bc'/>
                <input type='hidden' style='width:100%; text-align:left;' readonly name='tcode_".$x."' id='tcode_".$x."' value=''/>
                <input type='hidden' style='width:100%; text-align:left;' readonly name='tno_".$x."' id='tno_".$x."' value=''/>
                <input type='hidden' style='width:100%; text-align:left;' readonly name='ins_tcode_".$x."' id='ins_tcode_".$x."' value='$r->o'/>

            </td>";
            /* $a .= "<td style='width:40px;'><input type='text' style='width:100%; text-align:right;' readonly name='trans_no_".$x."' id='trans_no_".$x."' title='' value=''/></td>";*/
            $a .= "<td style='width:60px;'><input type='text' style='width:100%; text-align:right;' readonly name='date_".$x."' id='date_".$x."' title='$r->due_date' value='$r->due_date'/></td>";
            $a .= "<td style='width:55px;'><input type='text' style='width:100%; text-align:right;' readonly name='amount_".$x."' id='amount_".$x."' title='$r->payble' value='$r->payble'/></td>";
            $a .= "<td style='width:55px;'><input type='text' style='width:100%; text-align:right;' readonly name='balance_".$x."' id='balance_".$x."' title='$r->balance' value='$r->balance'/></td>";
            $a .= "<td style='width:55px;'><input type='text' style='width:100%; text-align:right;' readonly name='rebeat_".$x."' id='rebeat_".$x."' title='0.00' value='0.00'/></td>";
            $a .= "<td style='width:55px;'><input type='text' style='width:100%; text-align:right;' class='ins' readonly name='paid_".$x."' id='paid_".$x."' title='0.00' value='0.00'/></td>";
            $a .= "<td style='width:55px;'><input type='text' style='width:100%; text-align:right;' class='ins' readonly name='settle_".$x."' id='settle_".$x."' title='0.00' value='0.00'/></td>";
            $a .= "<td style='display:none;'><input type='hidden' style='width:100%; text-align:right;' name='tp_".$x."' id='tp_".$x."' value='$r->tp'/></td>";

            $x++;
            $y++;
            $tot+=(float)$r->payble;
            $bal+=(float)$r->balance;
            $a .= "</tr></tbody>";
        }
        $a .= "<tr><tfoot style='margin-right:40px;'>";
        $a .= "<td></td>";
        $a .= "<td></td>";
        $a .= "<td></td>";
        $a .= "<td style='text-align:left; font-size:15px;'><b>Total</b></td>";
        $a .= "<td style='text-align:right; font-size:15px; padding-right:9px;'><b>".number_format($tot,2)."</b></td>";
        $a .= "<td style='text-align:right; font-size:15px; padding-right:9px;'><b><input type='hidden' name='bal_tot2' id='bal_tot2' value='".$bal."'/><span id ='bal_tot'>".number_format($bal,2)."</span></b></td>";
        $a .= "<td style='text-align:right; font-size:15px; padding-right:12px;'><b><span id ='re_tot'>0.00</span></b></td>";
        $a .= "<td style='text-align:right; font-size:15px; padding-right:0px;'><b><span id ='paid_tot'>0.00</span></b></td>";
        $a .= "<td style='text-align:right; font-size:15px; padding-right:20px; '><b><span id ='settle_tot'>0.00</span></b></td>";
        $a .= "</tr></tfoot>";

        $a.="</table>";
        $a.="</fieldset>";
        $a.="<input type='hidden' name='grid_tot' id='grid_tot' value='".$x."'/>";
        echo $a;

    }

    public function load_advance_amo(){
        $sql="SELECT SUM(dr-cr) AS balance 
        FROM t_advance_trans  
        WHERE cl='".$this->sd['cl']."' 
        AND bc='".$this->sd['branch']."' 
        AND agr_no='".$_POST['agr_no']."' 
        HAVING balance >0";

        $query=$this->db->query($sql);

        if($query->num_rows()>0){
            $result=$query->row()->balance;
        }else{
            $result=0;
        }

        echo $result;
    }

    public function load_rebeat(){
        $sql="SELECT *, sum(rbt_capital+rbt_interest+rbt_panalty+rbt_other_chg)  as amount
        FROM t_hp_rebate 
        WHERE cl='".$this->sd['cl']."' 
        AND bc='".$this->sd['branch']."' 
        AND loan_no='".$_POST['agr_no']."'
        AND is_cancel='0'";

        $query = $this->db->query($sql);

        $a['grid'] = "<table id='item_list' style='width : 100%'>";
        $a['grid'] .= "<thead><tr>";
        $a['grid'] .= "<th class='tb_head_th'>Loan No</th>";
        $a['grid'] .= "<th class='tb_head_th'>Rebeat Amount</th>";
        $a['grid'] .= "</thead></tr><tr class='cl'></tr><tbody>";
        $tot=(float)0;
        foreach($query->result() as $r){
            $a['grid'] .= "<tr class='cl'>";
            $a['grid'] .= "<td>".$r->loan_no."</td>";
            $a['grid'] .= "<td>".$r->amount."</td>";
            $a['grid'] .= "<td style='display:none;'>".$r->rbt_capital."</td>";
            $a['grid'] .= "<td style='display:none;'>".$r->rbt_interest."</td>";
            $a['grid'] .= "<td style='display:none;'>".$r->rbt_panalty."</td>";
            $a['grid'] .= "<td style='display:none;'>".$r->rbt_other_chg."</td>";
            $a['grid'] .= "<td style='display:none;'>".$r->nno."</td>";
            $a['grid'] .= "</tr></tbody>";
        }
        $a['grid'] .= "</table>";
        echo json_encode($a);
    } 

    public function PDF_report() {
        $this->db->select(array('name', 'address', 'tp', 'fax', 'email'));
        $this->db->where("cl", $this->sd['cl']);
        $this->db->where("bc", $this->sd['branch']);
        $r_detail['branch'] = $this->db->get('m_branch')->result();


        $invoice_number= $this->utility->invoice_format($_POST['qno']);
        $session_array = array(
            $this->sd['cl'],
            $this->sd['branch'],
            $invoice_number
            );
        $r_detail['session'] = $session_array;

        $r_detail['type'] = $_POST['type'];
        $r_detail['qno'] = $_POST['qno'];
        $num = $_POST['tot'];

        $r_detail['page'] = "A5";
        $r_detail['header'] = $_POST['header'];
        $r_detail['orientation'] = "L";
        $agreement_no = $balance =0;

        $sql_sum="SELECT s.nno,
        s.ddate,
        s.ref_no,
        s.agr_no,
        s.customer,
        s.inv_no,
        CONCAT(m.`address1`,m.`address2`,m.`address3`)AS address,
        description,m.`name`,
        pay_cash,
        pay_ccard,
        pay_cheque,
        pay_cnote,
        rebeat_amount,
        paid_amount,
        loan_amount,
        down_payment,
        no_ins,
        ins_amount,
        int_amount,
        pay_advance
        FROM t_hp_early_settlement_sum s
        JOIN m_customer m ON m.`code` = customer
        WHERE s.cl='".$this->sd['cl']."' 
        AND s.bc='".$this->sd['branch']."' 
        AND s.nno='".$_POST['qno']."'";

        $query_sum=$this->db->query($sql_sum);
        $r_detail['sum'] = $query_sum->result();
        $agreement_no = $query_sum->row()->agr_no;

        $sql_det="SELECT t.*,
        r.`description`
        FROM t_hp_early_settlement_det t
        JOIN r_hp_trans_type r ON r.`code` = t.`order_type` 
        WHERE t.`nno`='".$_POST['qno']."' 
        AND cl='".$this->sd['cl']."' 
        AND bc='".$this->sd['branch']."'
        ORDER BY t.auto_no asc";

        $query_det=$this->db->query($sql_det);
        $r_detail['det'] = $query_det->result();

        $sql_type="SELECT t.`description`, d.`paid` 
        FROM t_hp_early_settlement_det d
        JOIN `r_hp_trans_type` t ON t.`code` = d.order_type
        WHERE cl='".$this->sd['cl']."' AND bc='".$this->sd['branch']."' AND nno='".$_POST['qno']."'";

        $query_type=$this->db->query($sql_type);
        $r_detail['types'] = $query_type->result();

        $exceed_sql="SELECT t.dr 
        FROM t_advance_trans t
        JOIN t_hp_early_settlement_sum s ON s.`cl` = t.`cl` AND  s.`bc` = t.`bc` AND s.`agr_no` = t.`agr_no` AND s.`nno` = t.`trans_no` 
        WHERE t.trans_code='95'
        AND s.cl='".$this->sd['cl']."'
        AND s.bc='".$this->sd['branch']."'
        AND s.nno='".$_POST['qno']."'
        GROUP BY t.trans_code,t.trans_no,t.cl,t.bc,t.agr_no";

        $e_query=$this->db->query($exceed_sql);
        $r_detail['exceed'] = $e_query->result();

        $sql_dr="SELECT sum(t.dr) as dr
        FROM t_ins_trans t 
        WHERE cl='".$this->sd['cl']."' 
        AND bc='".$this->sd['branch']."' 
        AND agr_no='$agreement_no'
        AND (t.`ins_trans_code` ='4' OR t.`ins_trans_code` ='3' )
        GROUP BY t.`agr_no`";

        $dr = $this->db->query($sql_dr)->row()->dr;


        $sql_cr="SELECT sum(t.cr) as cr
        FROM t_ins_trans t 
        WHERE cl='".$this->sd['cl']."' 
        AND bc='".$this->sd['branch']."' 
        AND agr_no='$agreement_no'
        GROUP BY t.`agr_no`";

        $cr = $this->db->query($sql_cr)->row()->cr;


        $hp="SELECT net_amount 
        FROM t_hp_sales_sum
        WHERE cl='".$this->sd['cl']."' 
        AND bc='".$this->sd['branch']."' 
        AND agreement_no='$agreement_no'";

        $hp_sum = $this->db->query($hp)->row()->net_amount;


        $balance = ((float)$dr - (float)$cr)+ (float)$hp_sum ;

        //var_dump($hp_sum);
        $r_detail['pay_balance'] = $balance;

        $this->utility->num_in_letter($num);
        $r_detail['rec'] = convertNum($num);;

        $this->db->select(array('loginName'));
        $this->db->where('cCode', $this->sd['oc']);
        $r_detail['user'] = $this->db->get('users')->result();

        $r_detail['is_cur_time'] = $this->utility->get_cur_time();

        $s_time=$this->utility->save_time();
        if($s_time==1){
            $r_detail['save_time']="  -  ".$this->utility->get_save_time('t_hp_receipt_sum','action_date',$_POST['qno'],'nno');

        }else{
          $r_detail['save_time']="";
      } 

      $this->load->view($_POST['by'] . '_' . 'pdf', $r_detail);
  }

  public function cus_add(){
    $sql="SELECT concat(address1,' ',address2,' ',address3) as address FROM m_customer WHERE code='".$_POST['customer']."' LIMIT 1";
    $query=$this->db->query($sql);

    if($query->num_rows()>0){
        $cus=$query->row()->address;
    }else{
        $cus="";
    }
    echo $cus;
}

public function load_agr_details(){
    $sql="SELECT net_amount,
    down_payment,
    no_of_installments,
    installment_amount,
    interest_amount 
    FROM t_hp_sales_sum
    WHERE cl='".$this->sd['cl']."' 
    AND bc='".$this->sd['branch']."' 
    AND agreement_no='".$_POST['agr_no']."'";

    $sql2="SELECT SUM(t.dr) AS dr
    FROM t_ins_trans t 
    WHERE cl='".$this->sd['cl']."' 
    AND bc='".$this->sd['branch']."' 
    AND agr_no='".$_POST['agr_no']."'
    AND (t.`ins_trans_code` ='4' OR t.`ins_trans_code` ='3' )
    GROUP BY t.`agr_no";

    $query2=$this->db->query($sql2);

    if($query2->num_rows()>0){
        $loan_amo = $query2->row()->dr;
    }else{
        $loan_amo=0;
    }

    $query=$this->db->query($sql);

    if($query->num_rows()>0){
        $result['det'] = $query->result();
        $result['loan_tot'] = (float)$loan_amo + (float)$query->row()->net_amount;
    }else{
        $result=2;
    }

    echo json_encode($result);
}
}
