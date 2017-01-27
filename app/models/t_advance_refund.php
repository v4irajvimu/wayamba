<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class t_advance_refund extends CI_Model {

  private $sd;
  private $mtb;
  private $max_no;
  private $mod = '003';
  private $trans_code=17;
  private $subtrans_code=24;
  private $ref_trans_code=24;

  function __construct(){
   parent::__construct();

   $this->sd = $this->session->all_userdata();
   $this->load->database($this->sd['db'], true);
   $this->load->model('user_permissions');
 }

 public function base_details(){

   $this->load->model('m_customer');
   $a['customer']=$this->m_customer->select();
   $a['max_no']= $this->utility->get_max_no("t_advance_refund","nno");
   $a['type'] = 'ADVANCE';
   return $a;
 }

 public function validation(){
  $status=1;

  $this->max_no=$this->utility->get_max_no("t_advance_refund","nno");

  $check_is_delete=$this->validation->check_is_cancel($this->max_no,'t_advance_refund');
  if($check_is_delete!=1){
    return "Advance payment already deleted";
  }
  /*if($_POST['credit']!='0.00'){
    return "Card Payment Refund Tempory Disabled";
  }
  if($_POST['cheque']!='0.00'){
    return "Cheque Payment Refund Tempory Disabled";
  }*/
  return $status;
}

public function save(){

  $this->db->trans_begin();
  error_reporting(E_ALL); 
  function exceptionThrower($type, $errMsg, $errFile, $errLine) { 
    throw new Exception($errMsg); 
  }
  set_error_handler('exceptionThrower'); 
  try { 

    $validation_status=$this->validation();
    if($validation_status==1){


      $a=array(
        "cl"=>$this->sd['cl'],
        "bc"=>$this->sd['branch'],
        "nno"=>$_POST['id'],
        "ddate"=>$_POST['date'],
        "advance_date"=>$_POST['ddate'],
        "ref_no"=>$_POST['ref_no'],
        "acc_code"=>$_POST['cus_id'],
        "receip_no"=>$_POST['rec_no'],
        "description"=>$_POST['rec_no_des'],
        "cash_amount"=>isset($_POST['cash_amo'])?$_POST['cash_amo']:'',
        "card_amount"=>isset($_POST['credit'])?$_POST['credit']:'',                            
        "cheque_amount"=>isset($_POST['cheque'])?$_POST['cheque']:'',
        "total_amount"=>$_POST['total']
        );


      if($_POST['hid'] == "0" || $_POST['hid'] == ""){
        if($this->user_permissions->is_add('t_advance_refund')){

          $account_update=$this->account_update(0);
          if($account_update==1){
            $this->db->insert('t_advance_refund', $a);

            $sql="INSERT INTO `t_credit_note_trans_refund` (`cl`,`bc`,`sub_cl`,`sub_bc`, `acc_code`,`trans_code`,`trans_no`,`sub_trans_code`,`sub_trans_no`, `dr`,`cr`,`ddate`,`ref_code`) 
            SELECT `cl`,`bc`,`sub_cl`,`sub_bc`,`acc_code`,`trans_code`,`trans_no`,`sub_trans_code`,`sub_trans_no`,`dr`,`cr`,`ddate`,`ref_code` FROM`t_credit_note_trans` 
            WHERE sub_trans_no='".$_POST['rec_no']."' AND cl='".$this->sd['cl']."' AND bc='".$this->sd['branch']."' AND acc_code='".$_POST['cus_id']."' AND sub_trans_code='24'";
            $query=$this->db->query($sql);

            $this->db->where("sub_trans_no", $_POST['rec_no']);
            $this->db->where("cl", $this->sd['cl']);
            $this->db->where("bc", $this->sd['branch']);
            $this->db->where("acc_code", $_POST['cus_id']);
            $this->db->where("sub_trans_code", '24');
            $this->db->delete("t_credit_note_trans");

            $this->db->where("ref_trans_no", $_POST['rec_no']);
            $this->db->where("cl", $this->sd['cl']);
            $this->db->where("bc", $this->sd['branch']);
            $this->db->where("code", $_POST['cus_id']);
            $this->db->where("ref_trans_code", '24');
            $this->db->update("t_credit_note",array("is_refund" =>'1'));

            $this->db->where("nno", $_POST['rec_no']);
            $this->db->where("cl", $this->sd['cl']);
            $this->db->where("bc", $this->sd['branch']);
            $this->db->where("acc_code", $_POST['cus_id']);
            $this->db->update("t_advance_sum",array("is_refund" =>'1'));

            $this->utility->save_logger("SAVE",113,$this->max_no,$this->mod);
            $this->account_update(1);
            echo $this->db->trans_commit();
          }else{
            echo "Invalid account entries";
            $this->db->trans_commit();
          }

        }else{
          echo "No permission to save records";
          $this->db->trans_commit();
        }  
      }/*else{
        if($this->user_permissions->is_edit('t_advance_refund')){
          $status=$this->trans_cancellation->advance_status($this->max_no);
          if($status=="OK"){
            $account_update=$this->account_update(0);
            if($account_update==1){

              $this->db->where('nno',$this->max_no);
              $this->db->update('t_advance_refund', $a);

              $this->db->where("sub_trans_no", $_POST['hid']);
              $this->db->where("cl", $this->sd['cl']);
              $this->db->where("bc", $this->sd['branch']);
              $this->db->where("acc_code", $_POST['cus_id']);
              $this->db->where("sub_trans_code", '24');
              $this->db->delete("t_credit_note_trans_refund");

              $sql="INSERT INTO `t_credit_note_trans_refund` (`cl`,`bc`,`sub_cl`,`sub_bc`, `acc_code`,`trans_code`,`trans_no`,`sub_trans_code`,`sub_trans_no`, `dr`,`cr`,`ddate`,`ref_code`) 
              SELECT `cl`,`bc`,`sub_cl`,`sub_bc`,`acc_code`,`trans_code`,`trans_no`,`sub_trans_code`,`sub_trans_no`,`dr`,`cr`,`ddate`,`ref_code` FROM`t_credit_note_trans` 
              WHERE sub_trans_no='".$_POST['rec_no']."' AND cl='".$this->sd['cl']."' AND bc='".$this->sd['branch']."' AND acc_code='".$_POST['cus_id']."' AND sub_trans_code='24'";
              $query=$this->db->query($sql);

              $this->db->where("ref_trans_no", $_POST['hid']);
              $this->db->where("cl", $this->sd['cl']);
              $this->db->where("bc", $this->sd['branch']);
              $this->db->where("code", $_POST['cus_id']);
              $this->db->where("ref_trans_code", '24');
              $this->db->update("t_credit_note",array("is_refund" =>'1'));

              $this->db->where("nno", $_POST['hid']);
              $this->db->where("cl", $this->sd['cl']);
              $this->db->where("bc", $this->sd['branch']);
              $this->db->update("t_advance_sum",array("is_refund" =>'1'));

              $this->utility->save_logger("EDIT",113,$this->max_no,$this->mod);
              $this->account_update(1);
              echo $this->db->trans_commit();
            }else{
              echo "Invalid account entries";
              $this->db->trans_commit();
            }

          }else{
            echo $status;
            $this->db->trans_commit();
          } 
        }else{
          echo "No permission to edit records";
          $this->db->trans_commit();
        }   
      } */     
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
  $this->db->where("trans_code", 113);
  $this->db->where("cl", $this->sd['cl']);
  $this->db->where("bc", $this->sd['branch']);
  $this->db->delete("t_check_double_entry");

  if($condition==1){
    if ($_POST['hid'] != "0" || $_POST['hid'] != "") {
      $this->db->where('cl',$this->sd['cl']);
      $this->db->where('bc',$this->sd['branch']);
      $this->db->where('trans_code',113);
      $this->db->where('trans_no',$this->max_no);
      $this->db->delete('t_account_trans');
    }
  }
  $config = array(
    "ddate" => $_POST['date'],
    "trans_code"=>113,
    "trans_no"=>$this->max_no,
    "op_acc"=>0,
    "reconcile"=>0,
    "cheque_no"=>0,
    "narration"=>"",
    "ref_no" => $_POST['ref_no']
    );

  $this->load->model('account');
  $this->account->set_data($config);


  $this->account->set_value2($_POST['rec_no_des'],  $_POST['cash_amo'], "dr", $_POST['cus_id'],$condition);

  if(isset($_POST['cash_amo']) && !empty($_POST['cash_amo']) && $_POST['cash_amo']>0){
    $acc_code = $this->utility->get_default_acc('CASH_IN_HAND');
    $this->account->set_value2($_POST['rec_no_des'], $_POST['cash_amo'], "cr", $acc_code,$condition);    
  }


  if($condition==0){
    $query = $this->db->query("
     SELECT (IFNULL( SUM( t.`dr_amount`),0) = IFNULL(SUM(t.`cr_amount`),0)) AS ok 
     FROM `t_check_double_entry` t
     LEFT JOIN `m_account` a ON t.`acc_code` = a.`code`
     WHERE  t.`cl`='" . $this->sd['cl'] . "'  AND t.`bc`='" . $this->sd['branch'] . "'  AND t.`trans_code`='113'  AND t.`trans_no` ='" . $this->max_no . "' AND 
     a.`is_control_acc`='0'");

    if($query->row()->ok=="0"){
      $this->db->where("trans_no", $_POST['hid']);
      $this->db->where("trans_code", 113);
      $this->db->where("cl", $this->sd['cl']);
      $this->db->where("bc", $this->sd['branch']);
      $this->db->delete("t_check_double_entry");
      return "0";
    }else{
      return "1";
    }
  }
}  

public function load(){

  $this->db->select(array(
    't_advance_refund.ddate' ,
    't_advance_refund.advance_date',
    't_advance_refund.ref_no',
    't_advance_refund.receip_no',
    't_advance_refund.acc_code',
    'm_customer.name' ,
    't_advance_refund.description',
    't_advance_refund.cash_amount',
    't_advance_refund.cheque_amount',
    't_advance_refund.card_amount',
    't_advance_refund.total_amount',
    't_advance_refund.is_cancel',
    ));

  $this->db->from('t_advance_refund');
  $this->db->join('m_customer','t_advance_refund.acc_code=m_customer.code');
  $this->db->where('t_advance_refund.nno',$_POST['id']);
  $this->db->where("t_advance_refund.cl", $this->sd['cl']);
  $this->db->where("t_advance_refund.bc", $this->sd['branch']);
  $query=$this->db->get();

  if($query->num_rows()>0){
    $a['det']=$query->result();
    echo json_encode($a);
  }else{
    echo json_encode("2");
  }
}

public function delete(){
  $this->db->trans_begin();
  error_reporting(E_ALL); 
  function exceptionThrower($type, $errMsg, $errFile, $errLine) { 
    throw new Exception($errLine."-".$errMsg); 
  }
  set_error_handler('exceptionThrower'); 
  try {
    if($this->user_permissions->is_delete('t_advance_refund')){
      $nno=$_POST['no'];
      $status="OK";
      $cl=$this->sd['cl'];
      $bc=$this->sd['branch'];

      if($status=="OK"){
       $trans_code=113;
       $table_trans='t_credit_note_trans';


       $sql="INSERT INTO `t_credit_note_trans` (`cl`,`bc`,`sub_cl`,`sub_bc`, `acc_code`,`trans_code`,`trans_no`,`sub_trans_code`,`sub_trans_no`, `dr`,`cr`,`ddate`,`ref_code`) 
       SELECT `cl`,`bc`,`sub_cl`,`sub_bc`,`acc_code`,`trans_code`,`trans_no`,`sub_trans_code`,`sub_trans_no`,`dr`,`cr`,`ddate`,`ref_code` FROM`t_credit_note_trans_refund` 
       WHERE sub_trans_no='".$_POST['rec_no']."' AND cl='".$this->sd['cl']."' AND bc='".$this->sd['branch']."' AND acc_code='".$_POST['cus_id']."' AND sub_trans_code='24'";
       $query=$this->db->query($sql);

       $this->db->where("sub_trans_no", $_POST['rec_no']);
       $this->db->where("cl", $this->sd['cl']);
       $this->db->where("bc", $this->sd['branch']);
       $this->db->where("acc_code", $_POST['cus_id']);
       $this->db->where("sub_trans_code", '24');
       $this->db->delete("t_credit_note_trans_refund");

       $this->db->where('cl',$this->sd['cl']);
       $this->db->where('bc',$this->sd['branch']);
       $this->db->where('trans_code','113');
       $this->db->where('trans_no',$nno);
       $this->db->delete('t_account_trans');

       $this->db->where('nno',$nno);
       $this->db->where('cl',$cl);
       $this->db->where('bc',$bc);
       $this->db->update('t_advance_refund', array("is_cancel"=>1));

       $this->db->where("nno", $_POST['no']);
       $this->db->where("cl", $this->sd['cl']);
       $this->db->where("bc", $this->sd['branch']);
       $this->db->update("t_advance_sum",array("is_refund" =>'0'));

       
       $sql="Update t_credit_note cn
       set cn.`is_refund`='0'
       where cn.cl ='".$cl."' and cn.bc='".$bc."'
       and cn.nno = (select cn_no FROM t_advance_sum WHERE nno='".$nno."' AND cl='".$cl."' AND bc='".$bc."')";

       $this->db->query($sql); 

       $this->utility->save_logger("CANCEL",113,$nno,$this->mod);
       echo $this->db->trans_commit();

     }else{

      echo $status;
      $this->db->trans_commit();
    }
  }else{
    echo "No permission to delete records";
    $this->db->trans_commit();
  }  
}catch(Exception $e){ 
  $this->db->trans_rollback();
  echo $e->getMessage()."Operation fail please contact admin"; 
}    
}


public function load_rece_details(){

  $sql = "SELECT *,s.acc_code,c.name,SUM(t.cr) as tot_cr FROM `t_advance_sum` s
  JOIN `t_credit_note_trans` t ON t.`trans_no`=s.`cn_no` AND t.`sub_trans_code`='24'
  JOIN m_customer c ON c.`code`=s.`acc_code`
  WHERE (nno LIKE '%$_POST[search]%' OR description LIKE '%$_POST[search]%') AND s.cl='".$this->sd['cl']."' AND s.bc='".$this->sd['branch']."' AND is_cancel!='1' AND is_refund!='1' AND so_type='0'
  GROUP BY s.nno
  HAVING tot_cr=0";

  $query = $this->db->query($sql);

  if ($query->num_rows() > 0) {

    $a = "<table id='item_list' style='width : 100%' >";
    $a .= "<thead><tr>";
    $a .= "<th class='tb_head_th'>Receipt No</th>";
    $a .= "<th class='tb_head_th'>Description</th>";

    $a .= "</thead></tr>";
    $a .= "<tr class='cl'>";
    $a .= "<td>&nbsp;</td>";
    $a .= "<td>&nbsp;</td>";
    $a .= "</tr>";

    $x=0;
    foreach ($query->result() as $r) {
      $a .= "<tr class='cl'>";
      $a .= "<td>" . $r->nno . "</td>";
      $a .= "<td>" . $r->description . "</td>";
      $a .= "<td style='display: none;'>" . $r->ddate . "</td>";
      $a .= "<td style='display: none;'>" . $r->acc_code . "</td>";
      $a .= "<td style='display: none;'>" . $r->name . "</td>";
      $a .= "<td style='display: none;'>" . $r->cash_amount . "</td>";
      $a .= "<td style='display: none;'>" . $r->card_amount . "</td>";
      $a .= "<td style='display: none;'>" . $r->cheque_amount . "</td>";
      $a .= "<td style='display: none;'>" . $r->total_amount . "</td>";
      $a .= "</tr>";
      $x++;
    }
    $a .= "</table>";


  } else {
    $a = 'No Data';
  }
  echo $a;
}

public function load_other_details(){

  $sql = "SELECT *,c.name FROM `t_advance_sum` s
  JOIN `t_credit_note_trans` t ON t.`trans_no`=s.`cn_no` AND t.`sub_trans_code`='24'
  JOIN m_customer c ON c.`code`=s.`acc_code`
  AND s.acc_code='".$_POST['cus_id']."' AND s.nno!='".$_POST['rece_no']."'
  AND so_type='0'
  GROUP BY s.nno HAVING cr=0";  

  $query = $this->db->query($sql);

  if ($query->num_rows() > 0) {
    $data['a'] = $this->db->query($sql)->result();
  } else {
    $data['a'] = 2;
  }

  echo json_encode($data);
}


public function load_cheque_details(){

  $sql = "SELECT ch.`cl`,ch.`bc`,ch.`trans_code`,ch.`trans_no`,ch.`bank`,ch.`branch`,ch.`account_no`,ch.`cheque_no`,ch.`amount`,ch.`cheque_date` 
  FROM `opt_receive_cheque_det` ch 
  WHERE trans_code='24' AND trans_no='".$_POST['rece_no']."'";  

  $query = $this->db->query($sql);

  if ($query->num_rows() > 0) {
    $data['b'] = $this->db->query($sql)->result();
  } else {
    $data['b'] = 2;
  }

  echo json_encode($data);
}


public function load_credit_details(){

  $sql = "SELECT *,b.`description`
  FROM `opt_credit_card_det`
  JOIN m_bank b ON b.`code`=opt_credit_card_det.`bank_id`
  WHERE trans_code='24' AND trans_no='".$_POST['rece_no']."'";  

  $query = $this->db->query($sql);

  if ($query->num_rows() > 0) {
    $data['c'] = $this->db->query($sql)->result();
  } else {
    $data['c'] = 2;
  }

  echo json_encode($data);
}


public function PDF_report(){
  $this->db->select(array('name','address','tp','fax','email'));
  $this->db->where("cl",$this->sd['cl']);
  $this->db->where("bc",$this->sd['branch']);
  $r_detail['branch']=$this->db->get('m_branch')->result();

  $invoice_number= $this->utility->invoice_format($_POST['qno']);
  $session_array = array(
   $this->sd['cl'],
   $this->sd['branch'],
   $invoice_number
   );
  $r_detail['session'] = $session_array;

  $this->db->where("code",$_POST['sales_type']);
  $query= $this->db->get('t_trans_code'); 
  if ($query->num_rows() > 0){
    foreach ($query->result() as $row){
      $r_detail['r_type']= $row->description;       
    }
  } 

  $ssql=" SELECT card_no, ddate, opt_credit_card_det.amount   
  FROM opt_credit_card_det
  JOIN t_advance_refund ON t_advance_refund.nno = opt_credit_card_det.`trans_no` 
  AND t_advance_refund.cl = opt_credit_card_det.cl
  AND t_advance_refund.bc = opt_credit_card_det.bc
  WHERE trans_code = '24' AND trans_no = '".$_POST['qno']."' AND t_advance_refund.cl='".$this->sd['cl']."' AND t_advance_refund.bc = '".$this->sd['branch']."'
  GROUP BY card_no,trans_no 
  ";

  $query_card = $this->db->query($ssql);
  $r_detail['credit_card'] = $this->db->query($ssql)->result();


  $sql_chq=" SELECT cheque_date,m_bank.description as bank,m_bank_branch.description as branch,account_no,cheque_no,amount   
  FROM opt_receive_cheque_det
  JOIN t_advance_refund ON t_advance_refund.nno = opt_receive_cheque_det.`trans_no` 
  JOIN m_bank ON m_bank.code = opt_receive_cheque_det.`bank` 
  JOIN m_bank_branch ON m_bank_branch.code = opt_receive_cheque_det.`branch` 
  AND t_advance_refund.cl = opt_receive_cheque_det.cl
  AND t_advance_refund.bc = opt_receive_cheque_det.bc
  WHERE trans_code = '24' AND trans_no = '".$_POST['qno']."' AND t_advance_refund.cl='".$this->sd['cl']."' AND t_advance_refund.bc = '".$this->sd['branch']."'
  ";
  $query = $this->db->query($sql_chq);
  $r_detail['cheque'] = $this->db->query($sql_chq)->result();


  $r_detail['type']="A5";        
  $r_detail['dt']=$_POST['dt'];
  $r_detail['qno']=$_POST['qno'];
  $r_detail['num']=$_POST['reciviedAmount'];

  $num =$_POST['reciviedAmount'];

  $this->utility->num_in_letter($num);

  $r_detail['rec']=convertNum($num);
  $r_detail['page']=$_POST['page'];
  $r_detail['header']=$_POST['header'];
  $r_detail['orientation']="L";

  $sql_cus="SELECT c.nic AS code,c.name,GROUP_CONCAT(cc.tp) AS tp FROM m_customer c
  LEFT JOIN m_customer_contact cc ON cc.code=c.`code`
  WHERE c.code='".$_POST['cus_id_print']."'
  GROUP BY c.code";
  $query = $this->db->query($sql_cus);
  $r_detail['customer'] = $this->db->query($sql_cus)->result();

  $this->db->select(array('t_advance_refund.description','t_advance_refund.card_amount','t_advance_refund.cash_amount','t_advance_refund.cheque_amount'));
  $this->db->from('t_advance_refund');
  $this->db->where('t_advance_refund.cl',$this->sd['cl'] );
  $this->db->where('t_advance_refund.bc',$this->sd['branch']);
  $this->db->where('t_advance_refund.nno',$_POST['qno']);
  $r_detail['items']=$this->db->get()->result_array();

  $r_detail['description']=$r_detail['items'][0]["description"];
  $r_detail['credit_tot']=$r_detail['items'][0]["card_amount"];
  $r_detail['cash_tot']=$r_detail['items'][0]["cash_amount"];
  $r_detail['cheque_tot']=$r_detail['items'][0]["cheque_amount"];


  $this->db->select(array('loginName'));
  $this->db->where('cCode',$this->sd['oc']);
  $r_detail['user']=$this->db->get('users')->result();

  $r_detail['is_cur_time'] = $this->utility->get_cur_time();

  $s_time=$this->utility->save_time();
  if($s_time==1){
    $r_detail['save_time']="  -  ".$this->utility->get_save_time('t_advance_refund','action_date',$_POST['qno'],'nno');

  }else{
    $r_detail['save_time']="";
  }

  $this->load->view($_POST['by'].'_'.'pdf',$r_detail);
} 



}