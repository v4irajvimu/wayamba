<?php if (!defined('BASEPATH'))
exit('No direct script access allowed');

class t_hp_instalment_payment extends CI_Model {

    private $sd;
    private $mod = '003';

    function __construct() {
        parent::__construct();
        $this->sd = $this->session->all_userdata();
        $this->load->database($this->sd['db'], true);
        $this->load->model('user_permissions');
        $this->max_no = $this->utility->get_max_no("t_hp_receipt_sum", "nno");
    }

    public function base_details() {
     $a['max']  = $this->utility->get_max_no("t_hp_receipt_sum", "nno");
     $a['type'] = 'HP_INSTALMENT';
     return $a;
 }


 public function get_form_data(){
    $result = $this->get_agreement_format();
    echo json_encode($result);
}

public function check_last_day_end(){
    $sql="SELECT DATE_FORMAT(ADDDATE(DATE_SUB(NOW(),INTERVAL 1 DAY),INTERVAL +630 MINUTE),'%Y-%m-%d') AS last_date";
    $last_date = $this->db->query($sql)->first_row()->last_date;

    $sql2="SELECT ddate
    FROM t_day_end
    WHERE cl='".$this->sd['cl']."' AND bc='".$this->sd['branch']."'
    ORDER BY ddate DESC LIMIT 1";
    $last_day_end_date = $this->db->query($sql2)->first_row()->ddate;

    if($last_day_end_date>=$last_date){
        $result =  1;
    }else{
        $result= "Please do the day end process before save the receipt";
    }
    return $result;
}

public function validation() {
    $this->max_no = $this->utility->get_max_no("t_hp_receipt_sum", "nno");
    $status = 1;
    if (empty($_POST['save_status']) && $_POST['save_status'] != "1") {
        return "Please check the payment option";
    }
    $check_is_delete = $this->validation->check_is_cancel($this->max_no, 't_hp_receipt_sum');
    if ($check_is_delete != 1) {
        return "This cash sale already deleted";
    }
    $payment_option_validation = $this->validation->payment_option_calculation();
    if ($payment_option_validation != 1) {
        return $payment_option_validation;
    }
    $check_zero_value=$this->validation->empty_net_value($_POST['net']);
    if($check_zero_value!=1){
        return $check_zero_value;
    }
    $chk_delete_trans = $this->chk_delete_trans($_POST['agreement_no'],$_POST['hid']);
    if ($chk_delete_trans != 0) {
        return "This Agreement Already Settled";
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
  $check_day_end=$this->check_last_day_end();
  if($check_day_end!=1){
    return $check_day_end;
}
return $status;
}

public function save() {
    $this->db->trans_begin();
    error_reporting(E_ALL);
    function exceptionThrower($type, $errMsg, $errFile, $errLine) {
        throw new Exception($errMsg."-".$errFile."-".$errLine);
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
                "cl" => $this->sd['cl'],
                "bc" => $this->sd['branch'],
                "nno" => $this->max_no,
                "ddate" => $_POST['date'],
                "ref_no" => $_POST['ref_no'],
                "agr_no" => $_POST['agreement_no'],
                "customer" => $_POST['customer'],
                "inv_no" => $_POST['ins_id'],
                "description" => $_POST['description'],
                "balance" => $_POST['tot_bal'],
                "rebeat_amount" => $_POST['rebeat_tot'],
                "rebeat_capital" => $_POST['rebeat_capital'],
                "rebeat_interest" => $_POST['rebeat_interest'],
                "rebeat_panelty" => $_POST['rebeat_panelty'],
                "rebeat_other" => $_POST['rebeat_other'],
                "paid_amount" => $_POST['net'],
                "pay_cash" => $pay_cash,
                "pay_cheque" => $pay_cheque,
                "pay_ccard" => $pay_ccard,
                "pay_cnote" => $pay_cnote,
                "oc" => $this->sd['oc'],
                "exceed_amount"=>$_POST['exceed_amount'],
                "collection_officer"=>$_POST['officer']
                );

            for ($x = 0; $x < $_POST['grid_tot']; $x++) {
                if (isset($_POST['trans_no_' . $x], $_POST['date_' . $x], $_POST['settle_' . $x])) {
                    if ($_POST['trans_no_' . $x] != "" && $_POST['date_' . $x] != "" && $_POST['settle_' . $x] != "0.00") {

                      $settle = (float)$_POST['rebeat_'.$x]+(float)$_POST['paid_'.$x];

                      $det[] = array(
                        "cl" => $this->sd['cl'],
                        "bc" => $this->sd['branch'],
                        "sub_cl" => $_POST['scl_'.$x],
                        "sub_bc" => $_POST['sbc_'.$x],
                        "nno" => $this->max_no,
                        "ins_no" => $_POST['ins_no_'.$x],
                        "order_type" => $_POST['rcode_'.$x],
                        "trans_code" => $_POST['tcode_'.$x],
                        "trans_no" => $_POST['tno_'.$x],
                        "date" => $_POST['date_'.$x],
                        "amount" => $_POST['amount_'.$x],
                        "rebeat" => $_POST['rebeat_'.$x],
                        "balance" => $_POST['balance_'.$x],
                        "paid" => $_POST['paid_'.$x],
                        "ins_tcode" => $_POST['ins_tcode_'.$x]
                        );


                      $ins_trans[] = array(
                        "cl" => $_POST['scl_'.$x],
                        "bc" => $_POST['sbc_'.$x],
                        "sub_cl" => $this->sd['cl'],
                        "sub_bc" => $this->sd['branch'],
                        "ddate" => $_POST['date_'.$x],
                        "agr_no" => $_POST['agreement_no'],
                        "acc_code" => $_POST['customer'],
                        "due_date" => $_POST['date_'.$x],
                        "trans_code" => $_POST['tcode_'.$x],
                        "trans_no" => $_POST['trans_no_'.$x],
                        "sub_trans_code" => 66,
                        "sub_trans_no" => $this->max_no,
                        "ins_trans_code" => $_POST['ins_tcode_'.$x],
                        "ins_no" => $_POST['ins_no_'.$x],
                        "cr" => $settle,
                        "oc" => $this->sd['oc']
                        );
                  }
              }
          }

          $exceed=array(
            "cl"            => $this->sd['cl'],
            "bc"            => $this->sd['branch'],
            "ddate"         => $_POST['date'],
            "sub_cl"        => "",
            "sub_bc"        => "",
            "agr_no"        => $_POST['agreement_no'],
            "acc_code"      => $_POST['customer'],
            "trans_code"    => 66,
            "trans_no"      => $this->max_no,
            "sub_trans_code"=> "",
            "sub_trans_no"  => "",
            "dr"            => $_POST['exceed_amount'],
            "cr"            => "0.00",
            "oc"            => $this->sd['oc']
            );

          if($_POST['hid'] == "0" || $_POST['hid'] == ""){
            if($this->user_permissions->is_add('t_hp_instalment_payment')){
                $account_update=$this->account_update(0);
                if($account_update==1){
                    $this->db->insert('t_hp_receipt_sum', $sum);
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

            $this->load->model('t_payment_option');
            $this->t_payment_option->save_payment_option($this->max_no, 66);
            $this->account_update(1);
            $this->is_close_hp();
            $this->utility->save_logger("SAVE",66,$this->max_no,$this->mod);
            echo $this->db->trans_commit();
        }else{
            echo "Invalid account entries";
            $this->db->trans_commit();
        }
    }else{
        echo "No permission to save records";
        $this->db->trans_commit();
    }
}else{
    if($this->user_permissions->is_edit('t_hp_instalment_payment')){
        $account_update=$this->account_update(0);
        if($account_update==1){
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
            $this->db->where('sub_trans_code', 66);
            $this->db->where('sub_trans_no', $this->max_no);
            $this->db->delete('t_ins_trans');

            $this->db->where("cl", $this->sd['cl']);
            $this->db->where("bc", $this->sd['branch']);
            $this->db->where('trans_code', 66);
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

    $this->load->model('t_payment_option');
    $this->t_payment_option->delete_all_payments_opt(66, $this->max_no);
    $this->t_payment_option->save_payment_option($this->max_no, 66);
    $this->account_update(1);
    $this->is_close_hp();
    $this->utility->save_logger("EDIT",66,$this->max_no,$this->mod);
    echo $this->db->trans_commit();
}else{
    echo "Invalid account entries";
    $this->db->trans_commit();
}
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


public function is_close_hp(){
    $sql="SELECT  ss.cl,ss.bc,iss.agr_no,
    IFNULL(SUM(ins_amount), 0) AS full_amount,
    IFNULL(paid,0) AS paid ,
    IFNULL(bal,0) AS bal,
    IFNULL(paid,0)+IFNULL(bal,0) AS tot_pay
    FROM `t_ins_schedule` iss
    JOIN t_hp_sales_sum ss ON ss.agreement_no=iss.agr_no
    LEFT JOIN (SELECT agr_no,SUM(cr) AS paid ,cl,bc FROM t_ins_trans WHERE (ins_trans_code = '1' OR ins_trans_code = '2')
    AND cl='".$this->sd['cl']."' AND bc='".$this->sd['branch']."' AND agr_no='".$_POST['agreement_no']."'
    GROUP BY `agr_no`) it
    ON it.agr_no = iss.`agr_no` AND it.cl = iss.`cl`  AND it.bc = iss.`bc`
    LEFT JOIN (SELECT SUM(dr-cr) AS bal,cl,bc,agr_no
    FROM t_advance_trans
    WHERE cl='".$this->sd['cl']."' AND bc='".$this->sd['branch']."' AND agr_no='".$_POST['agreement_no']."'
    GROUP BY agr_no) ad ON ad.cl=iss.`cl` AND ad.bc=iss.`bc` AND ad.agr_no=iss.`agr_no`
    WHERE iss.cl='".$this->sd['cl']."' AND iss.bc='".$this->sd['branch']."' AND iss.agr_no='".$_POST['agreement_no']."'
    GROUP BY iss.cl,iss.bc,iss.`agr_no`
    HAVING full_amount <= tot_pay AND full_amount!='0'";

    $query =$this->db->query($sql);
    if($query->num_rows()>0){
      $this->db->where("cl", $this->sd['cl']);
      $this->db->where("bc", $this->sd['branch']);
      $this->db->where('nno', $_POST['ins_id']);
      $this->db->where('agreement_no', $_POST['agreement_no']);
      $this->db->update('t_hp_sales_sum', array("is_closed"=>1,'receipt_closed_date'=>$_POST['date'],'receipt_closed_no'=>$this->max_no));
  }
}


public function account_update($condition){
    $this->db->where("trans_no", $this->max_no);
    $this->db->where("trans_code", 66);
    $this->db->where("cl", $this->sd['cl']);
    $this->db->where("bc", $this->sd['branch']);
    $this->db->delete("t_check_double_entry");


    if ($_POST['hid'] != "0" || $_POST['hid'] != "") {
        $this->db->where('cl',$this->sd['cl']);
        $this->db->where('bc',$this->sd['branch']);
        $this->db->where('trans_code',66);
        $this->db->where('trans_no',$this->max_no);
        $this->db->delete('t_account_trans');
    }

    $config = array(
        "ddate" => $_POST['date'],
        "trans_code" => 66,
        "trans_no" => $this->max_no,
        "op_acc" => 0,
        "reconcile" => 0,
        "cheque_no" => 0,
        "narration" => "",
        "ref_no" => $_POST['ref_no']
        );

    $sql = "SELECT name from m_customer where code = '".$_POST['customer']."' LIMIT 1";
    $cus_name = $this->db->query($sql)->first_row()->name;
    $des = "HP Installment Payment - " .$cus_name;

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

  if(isset($_POST['oth_settl']) && !empty($_POST['oth_settl']) && $_POST['oth_settl']>0){
      $acc_code = $this->utility->get_default_acc('GROUP_SALE_PAYBLE');
      $this->account->set_value2("other settlement", $_POST['oth_settl'], "dr", $acc_code,$condition);
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
       WHERE  t.`cl`='" . $this->sd['cl'] . "'  AND t.`bc`='" . $this->sd['branch'] . "'  AND t.`trans_code`='66'  AND t.`trans_no` ='" . $this->max_no . "' AND
       a.`is_control_acc`='0'");

   if ($query->row()->ok == "0") {
    $this->db->where("trans_no", $this->max_no);
    $this->db->where("trans_code",66);
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
    $sql_load="SELECT ddate,nno,paid_amount
    FROM `t_hp_receipt_sum`
    WHERE agr_no='".$_POST['agr_no']."'
    AND cl='".$this->sd['cl']."'
    AND bc='".$this->sd['branch']."'
    AND is_cancel='0'";
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

public function load_gridFBI(){
   $x=0;
   $sql_load="SELECT
   i.`ins_no`,
   i.`due_date`,
   i.`ins_amount`
   FROM
   t_ins_schedule i
   WHERE ((i.`ins_amount` - i.`ins_paid`) > 0)
   AND (i.`agr_no` = '".$_POST['ins_id']."') ";

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
    e.name as officer_name
    FROM t_hp_receipt_sum t
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
    FROM t_hp_receipt_det t
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

public function delete_validation(){
    $result=1;
    $chk_delete_trans = $this->chk_delete_trans($_POST['agr_no'],$_POST['hid']);
    if ($chk_delete_trans != 0) {
        return "This Agreement Already Settled";
    }
    return $result;

}
public function delete() {
    $this->db->trans_begin();
    error_reporting(E_ALL);
    function exceptionThrower($type, $errMsg, $errFile, $errLine) {
        throw new Exception($errMsg);
    }
    set_error_handler('exceptionThrower');
    try{
        if($this->user_permissions->is_delete('t_hp_instalment_payment')){
            $validation_status = $this->delete_validation();
            if ($validation_status == 1){

                $data=array('is_cancel'=>'1');
                $this->db->where('cl',$this->sd['cl']);
                $this->db->where('bc',$this->sd['branch']);
                $this->db->where('nno',$_POST['code']);
                $this->db->update('t_hp_receipt_sum',$data);

                $this->db->where("sub_cl", $this->sd['cl']);
                $this->db->where("sub_bc", $this->sd['branch']);
                $this->db->where('sub_trans_code', 66);
                $this->db->where('sub_trans_no', $_POST['code']);
                $this->db->delete('t_ins_trans');

                $this->db->where('cl',$this->sd['cl']);
                $this->db->where('bc',$this->sd['branch']);
                $this->db->where('trans_code','66');
                $this->db->where('trans_no',$_POST['code']);
                $this->db->delete('t_account_trans');

                $this->db->where("cl", $this->sd['cl']);
                $this->db->where("bc", $this->sd['branch']);
                $this->db->where('trans_code', 66);
                $this->db->where('trans_no', $_POST['code']);
                $this->db->delete('t_advance_trans');

                $this->utility->save_logger("DELETE",66,$_POST['code'],$this->mod);
                echo $this->db->trans_commit();
            }else{
                echo $validation_status;
                $this->db->trans_commit();
            }

        }else{
            $this->db->trans_commit();
            echo "No permission to delete records";
        }
    }catch(Exception $e){
        $this->db->trans_rollback();
        echo $e->getMessage()."Operation fail please contact admin".$e;
    }
}

public function chk_delete_trans($agr_no,$id){

    $sql="SELECT SUM(it.cr) cr FROM t_ins_trans it
    JOIN(SELECT * FROM t_advance_trans tat WHERE tat.agr_no='$agr_no' AND tat.trans_no='$id' )ta
    ON ta.agr_no=it.`agr_no` AND ta.sub_trans_code=it.`trans_code` AND ta.sub_trans_no=it.`trans_no`
    WHERE it.agr_no='$agr_no'
    HAVING cr>0";

    $query = $this->db->query($sql);
    if ($query->num_rows() > 0) {
        $a= 1;
    } else {
        $a = 0;
    }
    return $a;
}

public function load_agreement_no(){

    if($_POST['search'] == 'Key Word: code, name'){$_POST['search'] = "";}

    if($_POST['is_close']!="1"){
        $close = " AND h.is_closed='0'";
    }else{
        $close ="";
    }

    if($_POST['is_multi']=="s"){
       $sql="  SELECT h.agreement_no AS agr_no,
       h.`cus_id`,
       h.nno,
       h.ddate,
       c.`name`,
       c.nic,
       h.memo,
       h.is_closed
       FROM t_hp_sales_sum h
       left JOIN t_ins_trans t  ON h.`agreement_no` = t.`agr_no` AND h.`cl` = t.`cl` AND h.`bc` = t.`bc`
       JOIN m_customer c ON c.`code` = h.`cus_id`
       WHERE (h.agreement_no LIKE '%$_POST[search]%'
       OR h.`cus_id` LIKE '%$_POST[search]%'
       OR c.`name` LIKE '%$_POST[search]%'
       OR c.`nic` LIKE '%$_POST[search]%')
       AND h.cl='".$this->sd['cl']."'
       AND h.bc='".$this->sd['branch']."'
       AND h.is_cancel='0'
       $close
       group by t.agr_no
       LIMIT 25";
   }

   if($_POST['is_multi']=="m"){
       $sql="  SELECT h.agreement_no AS agr_no,
       h.`cus_id`,
       h.nno,
       h.ddate,
       c.`name`,
       c.nic,
       h.memo,
       h.is_closed
       FROM t_hp_sales_sum h
       left JOIN t_ins_trans t ON h.`agreement_no` = t.`agr_no` AND h.`cl` = t.`cl` AND h.`bc` = t.`bc`
       JOIN m_customer c ON c.`code` = h.`cus_id`
       WHERE (h.agreement_no LIKE '%$_POST[search]%'
       OR h.`cus_id` LIKE '%$_POST[search]%'
       OR c.`name` LIKE '%$_POST[search]%'
       OR c.`nic` LIKE '%$_POST[search]%')
       AND h.is_cancel='0'
       $close
       group by t.agr_no
       LIMIT 25";
   }


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
      $a .= "<td style='display:none;'>".$r->memo."</td>";
      $a .= "<td style='display:none;'>".$r->is_closed."</td>";

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


        // move penalty from t_penalty_trans_hp to t_ins_trans
    $this->load->model('t_day_process');
    $this->t_day_process->move_penalty_ti_ins_trans( $_POST['date'],$_POST['max_no'],$_POST['agr_no'], $this->sd['oc'] ,$this->sd['branch'], $this->sd['cl'] );
        // END ----

    if($_POST['is_multi']=="s"){
       $sql="SELECT t.`ins_no`,
       t.`trans_no`,
       t.`due_date`,
       r.description,
       SUM(t.cr) AS cr,
       SUM(t.dr) AS dr,
       SUM(t.dr)-SUM(t.cr) AS balance,
       r.code as r_code,
       t.cl,
       t.bc,
       t.ins_trans_code,
       t.trans_no,
       t.trans_code
       FROM t_ins_trans t
       JOIN r_hp_trans_type r ON r.code = t.ins_trans_code
       WHERE t.cl = '".$this->sd['cl']."'
       AND t.bc = '".$this->sd['branch']."'
       AND t.agr_no = '".$_POST['agr_no']."'
       -- GROUP BY t.`ins_no`, t.`trans_no`, t.`due_date`, r.code
       GROUP BY  t.`trans_no`, r.code
       HAVING SUM(t.dr)-SUM(t.cr)>0
       ORDER BY r.order_no ";
   }

   if($_POST['is_multi']=="m"){
       $sql="SELECT t.`ins_no`,
       t.`trans_no`,
       t.`due_date`,
       r.description,
       SUM(t.cr) AS cr,
       SUM(t.dr) AS dr,
       SUM(t.dr)-SUM(t.cr) AS balance,
       r.code as r_code,
       t.cl,
       t.bc,
       t.ins_trans_code,
       t.trans_no,
       t.trans_code
       FROM t_ins_trans t
       JOIN r_hp_trans_type r ON r.code = t.ins_trans_code
       WHERE t.agr_no = '".$_POST['agr_no']."'
       GROUP BY t.`ins_no`, t.`trans_no`, t.`due_date`, r.code
       HAVING SUM(t.dr)-SUM(t.cr)>0
       ORDER BY r.order_no ";
   }

   $query=$this->db->query($sql);
   $a  ="<fieldset>";
   $a .="<legend>Installment</legend>";
   $a .= "<table id='tgrid'>";
   $a .= "<thead><tr>";
   $a .= "<th class='tb_head_th' style='width:40px;'>No</th>";
   $a .= "<th class='tb_head_th' style='width:30px; text-align:center;'>Ins No</th>";
   $a .= "<th class='tb_head_th' style='width:100px; text-align:center;'>Type</th>";
   $a .= "<th class='tb_head_th' style='width:30px; text-align:left;'>Trans No</th>";
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
    <input type='text' style='width:100%; text-align:left;' readonly name='types_".$x."' id='types_".$x."' title='$r->description' value='$r->description'/>
    <input type='hidden' style='width:100%; text-align:left;' readonly name='rcode_".$x."' id='rcode_".$x."' value='$r->r_code'/>
    <input type='hidden' style='width:100%; text-align:left;' readonly name='scl_".$x."' id='scl_".$x."' value='$r->cl'/>
    <input type='hidden' style='width:100%; text-align:left;' readonly name='sbc_".$x."' id='sbc_".$x."' value='$r->bc'/>
    <input type='hidden' style='width:100%; text-align:left;' readonly name='tcode_".$x."' id='tcode_".$x."' value='$r->trans_code'/>
    <input type='hidden' style='width:100%; text-align:left;' readonly name='tno_".$x."' id='tno_".$x."' value='$r->trans_no'/>
    <input type='hidden' style='width:100%; text-align:left;' readonly name='ins_tcode_".$x."' id='ins_tcode_".$x."' value='$r->ins_trans_code'/>

</td>";
$a .= "<td style='width:40px;'><input type='text' style='width:100%; text-align:right;' readonly name='trans_no_".$x."' id='trans_no_".$x."' title='$r->trans_no' value='$r->trans_no'/></td>";
$a .= "<td style='width:60px;'><input type='text' style='width:100%; text-align:right;' readonly name='date_".$x."' id='date_".$x."' title='$r->due_date' value='$r->due_date'/></td>";
$a .= "<td style='width:55px;'><input type='text' style='width:100%; text-align:right;' readonly name='amount_".$x."' id='amount_".$x."' title='$r->dr' value='$r->dr'/></td>";
$a .= "<td style='width:55px;'><input type='text' style='width:100%; text-align:right;' readonly name='balance_".$x."' id='balance_".$x."' title='$r->balance' value='$r->balance'/></td>";
$a .= "<td style='width:55px;'><input type='text' style='width:100%; text-align:right;' readonly name='rebeat_".$x."' id='rebeat_".$x."' title='0.00' value='0.00'/></td>";
$a .= "<td style='width:55px;'><input type='text' style='width:100%; text-align:right;' class='ins' readonly name='paid_".$x."' id='paid_".$x."' title='0.00' value='0.00'/></td>";
$a .= "<td style='width:55px;'><input type='text' style='width:100%; text-align:right;' class='ins' readonly name='settle_".$x."' id='settle_".$x."' title='0.00' value='0.00'/></td>";

$x++;
$y++;
$tot+=(float)$r->dr;
$bal+=(float)$r->balance;
$a .= "</tr></tbody>";
}
$a .= "<tr><tfoot style='margin-right:40px;'>";
$a .= "<td></td>";
$a .= "<td></td>";
$a .= "<td></td>";
$a .= "<td></td>";
$a .= "<td style='text-align:left; font-size:15px;'><b>Total</b></td>";
$a .= "<td style='text-align:right; font-size:15px; padding-right:9px;'><b>".number_format($tot,2)."</b></td>";
$a .= "<td style='text-align:right; font-size:15px; padding-right:9px;'><b><span id ='bal_tot'>".number_format($bal,2)."</span></b></td>";
$a .= "<td style='text-align:right; font-size:15px; padding-right:12px;'><b><span id ='re_tot'>0.00</span></b></td>";
$a .= "<td style='text-align:right; font-size:15px; padding-right:0px;'><b><span id ='paid_tot'>0.00</span></b></td>";
$a .= "<td style='text-align:right; font-size:15px; padding-right:20px; '><b><span id ='settle_tot'>0.00</span></b></td>";
$a .= "</tr></tfoot>";

$a.="</table>";
$a.="</fieldset>";
$a.="<input type='hidden' name='grid_tot' id='grid_tot' value='".$x."'/>";
echo $a;

}

public function load_rebeat(){
    $sql="SELECT *, sum(rbt_capital+rbt_interest+rbt_panalty+rbt_other_chg)  as amount
    FROM t_hp_rebate
    WHERE cl='".$this->sd['cl']."'
    AND bc='".$this->sd['branch']."'
    AND loan_no='".$_POST['agr_no']."'";

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
    $r_detail['org_print'] = $_POST['org_print'];
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
    paid_amount
    FROM t_hp_receipt_sum s
    JOIN m_customer m ON m.`code` = customer
    WHERE s.cl='".$this->sd['cl']."'
    AND s.bc='".$this->sd['branch']."'
    AND s.nno='".$_POST['qno']."'";

    $query_sum=$this->db->query($sql_sum);
    $r_detail['sum'] = $query_sum->result();
    $agreement_no = $query_sum->row()->agr_no;

    $sql_det="SELECT t.*,
    r.`description`
    FROM t_hp_receipt_det t
    JOIN r_hp_trans_type r ON r.`code` = t.`order_type`
    WHERE t.`nno`='".$_POST['qno']."'
    AND cl='".$this->sd['cl']."'
    AND bc='".$this->sd['branch']."'
    ORDER BY t.auto_no asc";

    $query_det=$this->db->query($sql_det);
    $r_detail['det'] = $query_det->result();

    $sql_type="SELECT t.`description`, d.`paid`
    FROM t_hp_receipt_det d
    JOIN `r_hp_trans_type` t ON t.`code` = d.order_type
    WHERE cl='".$this->sd['cl']."' AND bc='".$this->sd['branch']."' AND nno='".$_POST['qno']."'";

    $query_type=$this->db->query($sql_type);
    $r_detail['types'] = $query_type->result();

    $exceed_sql="SELECT t.dr
    FROM t_advance_trans t
    JOIN t_hp_receipt_sum s ON s.`cl` = t.`cl` AND  s.`bc` = t.`bc` AND s.`agr_no` = t.`agr_no` AND s.`nno` = t.`trans_no`
    WHERE t.trans_code='66'
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
    GROUP BY t.`agr_no` -- gewanna thiyena ewwa";

    $dr = $this->db->query($sql_dr)->row()->dr;


    $sql_cr="SELECT sum(t.cr) as cr
    FROM t_ins_trans t
    WHERE cl='".$this->sd['cl']."'
    AND bc='".$this->sd['branch']."'
    AND agr_no='$agreement_no'
    GROUP BY t.`agr_no`";

    $cr = $this->db->query($sql_cr)->row()->cr;

    $sql_idet="SELECT GROUP_CONCAT(i.`description`) AS description
    FROM t_hp_sales_sum s
    JOIN t_hp_sales_det d ON d.cl=s.cl AND d.bc=s.bc AND d.`nno`=s.`nno`
    JOIN m_item i ON i.`code`=d.item_code
    WHERE s.cl='".$this->sd['cl']."'
    AND s.bc='".$this->sd['branch']."'
    AND s.agreement_no='$agreement_no'";

    $query_idet=$this->db->query($sql_idet);
    $r_detail['item_det'] = $query_idet->result();


    $hp="SELECT (net_amount+interest_amount+document_charges) AS net_amount
    FROM t_hp_sales_sum
    WHERE cl='".$this->sd['cl']."'
    AND bc='".$this->sd['branch']."'
    AND agreement_no='$agreement_no'";

    $hp_sum = $this->db->query($hp)->row()->net_amount;



    $paid="SELECT IFNULL(SUM(paid_amount),0)+IFNULL(SUM(rebeat_amount),0) AS e_pay
    FROM t_hp_receipt_sum WHERE agr_no='$agreement_no' AND is_cancel='0' AND cl='".$this->sd['cl']."'
    AND bc='".$this->sd['branch']."' GROUP BY agr_no";
    $paid_sum = $this->db->query($paid)->row()->e_pay;

    $paid2="SELECT IFNULL(SUM(paid_amount),0)+IFNULL(SUM(rebeat_amount),0) AS e_pay
    FROM t_hp_early_settlement_sum WHERE agr_no='$agreement_no' AND is_cancel='0' AND cl='".$this->sd['cl']."'
    AND bc='".$this->sd['branch']."' GROUP BY agr_no";
    $paid_sum2 = $this->db->query($paid2)->row()->e_pay;


    //$balance = (float)$hp_sum -(float)$cr;

    //$balance = ((float)$dr - (float)$cr)+ (float)$hp_sum;
    //var_dump($paid_sum."-".$hp_sum);
    $balance = (float)$hp_sum - ((float)$paid_sum + (float)$paid_sum2);

        //var_dump($balance);
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
}
