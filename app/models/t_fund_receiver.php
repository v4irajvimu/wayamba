<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class t_fund_receiver extends CI_Model {
  private $max_no;
  private $mod='003';
    function __construct() {
    parent::__construct();
    $this->sd = $this->session->all_userdata();
    $this->load->database($this->sd['db'], true);
    $this->load->model('user_permissions');
      
  }

  public function base_details(){
   $a['id'] = $this->utility->get_max_no("t_fund_receive_sum", "nno");
   return $a;
  }

  public function load_login_bc(){
    $sql="SELECT b.bc,b.name FROM `m_branch` b where  b.bc='".$this->sd['branch']."'";
    $query = $this->db->query($sql)->row();
  
    $ar['bc'] = $query->bc;
    $ar['name'] = $query->name;
    return $ar;
  }

  public function load_branch(){

    if($_POST['search'] == 'Key Word: code, name'){$_POST['search'] = "";}

    $sql = "SELECT b.bc, b.name,c.code 
            FROM m_branch b 
            JOIN m_cluster c ON c.code = b.cl
            WHERE b.name LIKE '%$_POST[search]%' OR b.bc LIKE '%$_POST[search]%' LIMIT 25";
     
      $query = $this->db->query($sql);
      $a  = "<table id='item_list' style='width : 100%' >";
      $a .= "<thead><tr>";
      $a .= "<th class='tb_head_th'>Branch Code</th>";
      $a .= "<th class='tb_head_th' colspan='2'>Name</th>";
      $a .= "</thead></tr><tr class='cl'><td>&nbsp;</td><td colspan='2'>&nbsp;</td></tr>";

    foreach($query->result() as $r){
      $a .= "<tr class='cl'>";
      $a .= "<td>".$r->bc."</td>";
      $a .= "<td>".$r->name."</td>";
      $a .= "<td style='display:none;'>".$r->code."</td>";
      $a .= "</tr>";
    }
    $a .= "</table>";
    echo $a;
  }

  public function transfer_no(){
    $sql="SELECT  s.nno,
                  s.ddate,
                  CONCAT(s.cashier, ' - ', e.`name`) AS cashier_a ,
                  s.cash_transit_acc_code,
                  a.`description`,
                  s.cashier,
                  e.name AS cashier_name,
                  s.hand_over,
                  ee.`name` AS hand_des,
                  s.transfer_amount
          FROM t_fund_transfer_sum s 
          JOIN m_employee e  ON e.`code` = s.cashier 
          JOIN m_employee ee  ON ee.`code` = s.hand_over
          JOIN m_account a ON a.code = s.cash_transit_acc_code
          WHERE s.sub_cl='".$this->sd['cl']."' 
          AND s.sub_bc='".$this->sd['branch']."' 
          AND s.cl='".$_POST['s_cl']."' 
          AND s.bc='".$_POST['s_bc']."' 
          AND s.`status` ='1'
          AND (s.nno LIKE '%$_POST[search]%' OR s.ddate LIKE '%$_POST[search]%' OR s.cashier LIKE '%$_POST[search]%')";

    $query = $this->db->query($sql);
      $a  = "<table id='item_list' style='width : 100%' >";
      $a .= "<thead><tr>";
      $a .= "<th class='tb_head_th'>Transfer No</th>";
      $a .= "<th class='tb_head_th'>Date</th>";
      $a .= "<th class='tb_head_th' colspan='2'>Cashier</th>";
      $a .= "</thead></tr><tr class='cl'><td>&nbsp;</td><td colspan='2'>&nbsp;</td></tr>";

    foreach($query->result() as $r){
      $a .= "<tr class='cl'>";
      $a .= "<td>".$r->nno."</td>";
      $a .= "<td>".$r->ddate."</td>";
      $a .= "<td>".$r->cashier_a."</td>";
      $a .= "<td style='display:none;'>".$r->cash_transit_acc_code."</td>";
      $a .= "<td style='display:none;'>".$r->description."</td>";
      $a .= "<td style='display:none;'>".$r->cashier."</td>";
      $a .= "<td style='display:none;'>".$r->cashier_name."</td>";
      $a .= "<td style='display:none;'>".$r->hand_over."</td>";
      $a .= "<td style='display:none;'>".$r->hand_des."</td>";
      $a .= "<td style='display:none;'>".$r->transfer_amount."</td>";
      $a .= "</tr>";
    }
    $a .= "</table>";
    echo $a;
  }

  public function validation(){
    $this->max_no = $this->utility->get_max_no("t_fund_receive_sum", "nno");
    return 1;
  }


  public function save(){
    $this->db->trans_begin();
        error_reporting(E_ALL); 
        function exceptionThrower($type, $errMsg, $errFile, $errLine) { 
            throw new Exception($errMsg); 
        }
        set_error_handler('exceptionThrower'); 
        try {
          $validation_status = $this->validation();
          if($validation_status == 1) {
            $sum = array(
              "cl"                    => $this->sd['cl'],
              "bc"                    => $this->sd['branch'],
              "nno"                   => $this->max_no,
              "ddate"                 => $_POST['date'],
              "ref_no"                => $_POST['ref_no'],
              "transfer_no"           => $_POST['transfer_no'],
              "cash_transit_acc_code" => $_POST['tr_acc'],
              "cashier"               => $_POST['cashier_code'],
              "hand_over"             => $_POST['hand_ot'],
              "cash_amount"           => $_POST['cash_amount'],
              "received_by"           => $_POST['received_by'],
              "from_cl"               => $_POST['fr_cl'],
              "from_bc"               => $_POST['fr_branch'],
              "note"                  => $_POST['note'],
              "oc"                    => $this->sd['oc']
            );


            if ($_POST['hid'] == "0" || $_POST['hid'] == ""){
              if($this->user_permissions->is_add('t_fund_receiver')){
                $account_update=$this->account_update(0,$_POST['fr_branch'],$_POST['fr_cl']);
                if($account_update==1){
                  $this->db->insert('t_fund_receive_sum', $sum);

                  $this->db->where("sub_cl", $this->sd['cl']);
                  $this->db->where("sub_bc", $this->sd['branch']);
                  $this->db->where("cl", $_POST['fr_cl']);
                  $this->db->where("bc", $_POST['fr_branch']);
                  $this->db->where('nno', $_POST['transfer_no']);
                  $this->db->update('t_fund_transfer_sum', array("status" => 2));

                  $this->account_update(1,$_POST['fr_branch'],$_POST['fr_cl']);
                  echo $this->db->trans_commit();
                }else{
                  return "Invalid account entries";
                }
              }else{
                echo "No permission to save records";
                $this->db->trans_commit();
              }    

            }else{
              if($this->user_permissions->is_edit('t_fund_receiver')){
                $account_update=$this->account_update(0,$_POST['fr_branch'],$_POST['fr_cl']);
                if($account_update==1){
                  $this->db->where("cl", $this->sd['cl']);
                  $this->db->where("bc", $this->sd['branch']);
                  $this->db->where('nno', $this->max_no);
                  $this->db->update('t_fund_receive_sum', $sum);

                  $this->account_update(1,$_POST['fr_branch'],$_POST['fr_cl']);
                  echo $this->db->trans_commit();
                }else{
                  return "Invalid account entries";
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

  public function load(){
    $sql="SELECT  s.nno,
                  b.`name` AS b_name,
                  s.ddate,
                  s.cash_transit_acc_code,
                  a.`description`,
                  s.transfer_no,
                  s.cashier,
                  e.name AS cashier_name,
                  s.hand_over,
                  ee.`name` AS hand_des,
                  s.cash_amount,
                  s.from_cl,
                  s.from_bc,
                  s.received_by,
                  eee.name AS receive_name,
                  note,
                  s.is_cancel
          FROM t_fund_receive_sum s 
          JOIN m_employee e  ON e.`code` = s.cashier 
          JOIN m_employee ee  ON ee.`code` = s.hand_over
          JOIN m_employee eee  ON eee.`code` = s.received_by
          JOIN m_account a ON a.code = s.cash_transit_acc_code
          JOIN m_branch b ON b.`bc` = s.from_bc
          WHERE s.cl='".$this->sd['cl']."' 
          AND s.bc='".$this->sd['branch']."' 
          AND s.nno='".$_POST['id']."' ";

    $query = $this->db->query($sql);

    if($query->num_rows()>0){
      $result = $query->result();
    }else{
      $result = "2";
    }
    echo json_encode($result);

  }

  public function delete(){
    $this->db->trans_begin();
      error_reporting(E_ALL); 
      function exceptionThrower($type, $errMsg, $errFile, $errLine) { 
          throw new Exception($errLine); 
      }
      set_error_handler('exceptionThrower'); 
      try {
        if($this->user_permissions->is_delete('t_fund_receiver')){
          
          $this->db->where("cl", $this->sd['cl']);
          $this->db->where("bc", $this->sd['branch']);
          $this->db->where('nno', $_POST['id']);
          $this->db->update('t_fund_receive_sum', array("is_cancel" =>1));

          $this->db->where("sub_cl", $this->sd['cl']);
          $this->db->where("sub_bc", $this->sd['branch']);
          $this->db->where("cl", $_POST['fr_cl']);
          $this->db->where("bc", $_POST['fr_branch']);
          $this->db->where('nno', $_POST['transfer_no']);
          $this->db->update('t_fund_transfer_sum', array("status" =>1));

          $this->db->where('ref_cl',$this->sd['cl']);
          $this->db->where('ref_bc',$this->sd['branch']);
          $this->db->where('trans_code',97);
          $this->db->where('trans_no',$_POST['id']);
          $this->db->delete('t_account_trans');
                
          echo $this->db->trans_commit();
        }else{
          echo "No permission to delete records";
          $this->db->trans_commit();
        }  

      }catch(Exception $e){ 
        $this->db->trans_rollback();
        echo $e->getMessage()."Operation fail please contact admin"; 
      } 
  }

public function account_update($condition,$issue_bc,$issue_cl) {

  $this->db->where("trans_no", $this->max_no);
  $this->db->where("trans_code", 97);
  $this->db->where("ref_cl", $this->sd['cl']);
  $this->db->where("ref_bc", $this->sd['branch']);
  $this->db->delete("t_check_double_entry");

  if ($_POST['hid'] != "0" || $_POST['hid'] != "") {
    $this->db->where("ref_cl", $this->sd['cl']);
    $this->db->where("ref_bc", $this->sd['branch']);
    $this->db->where('trans_code',97);
    $this->db->where('trans_no',$this->max_no);
    $this->db->delete('t_account_trans');
  }

  $sql="SELECT acc_code FROM r_branch_current_acc
        WHERE ref_bc='$issue_bc'";
  $issue_bc_acc = $this->db->query($sql)->first_row()->acc_code;

  $sql_b="SELECT name from m_branch where bc='$issue_bc'";
  $issue_bc_name=$this->db->query($sql_b)->first_row()->name;

  $sql_bb="SELECT name from m_branch where bc='".$this->sd['branch']."'";
  $receive_bc_name=$this->db->query($sql_bb)->first_row()->name;
      
  $config = array(
      "ddate" => $_POST['date'],
      "trans_code" => 97,
      "trans_no" => $this->max_no,
      "op_acc" => 0,
      "reconcile" => 0,
      "cheque_no" => 0,
      "narration" => "",
      "ref_no" => $_POST['ref_no']
  );

  $des = "Fund Transfer Receive From- " . $issue_bc_name;
  $des_r = "Fund Transfer Receive By- " . $receive_bc_name;

  $this->load->model('account');
  $this->account->set_data($config);
  $amount = $_POST['cash_amount'];

  $sql="SELECT acc_code FROM r_branch_current_acc
        WHERE ref_bc='".$_POST['fr_branch']."'";
  $issue_bc_acc = $this->db->query($sql)->first_row()->acc_code;
      
  $cash_book=$this->utility->get_default_acc('CASH_IN_HAND');
  $this->account->set_value_internal($this->sd['cl'],$this->sd['branch'], $des, $amount, "dr", $cash_book,$condition);

  $cash_transit=$this->utility->get_default_acc('CASH_TRANSIT');
  $this->account->set_value_internal($this->sd['cl'],$this->sd['branch'], $des, $amount, "cr", $cash_transit,$condition);
  
  //---------issue branch accout updates

  $this->account->set_value_internal($issue_cl,$issue_bc,$des_r, $amount, "cr", $cash_transit,$condition);
  $this->account->set_value_internal($issue_cl,$issue_bc,$des_r, $amount, "dr", $issue_bc_acc,$condition);

  if($condition==0){
     $query = $this->db->query("
         SELECT (IFNULL( SUM( t.`dr_amount`),0) = IFNULL(SUM(t.`cr_amount`),0)) AS ok 
         FROM `t_check_double_entry` t
         LEFT JOIN `m_account` a ON t.`acc_code` = a.`code`
         WHERE  t.`ref_cl`='" . $this->sd['cl'] . "'  AND t.`ref_bc`='" . $this->sd['branch'] . "'  AND t.`trans_code`='97'  AND t.`trans_no` ='" . $this->max_no . "' AND 
         a.`is_control_acc`='0'");

    if ($query->row()->ok == "0") {
        $this->db->where("trans_no", $this->max_no);
        $this->db->where("trans_code", 97);
        $this->db->where("ref_cl", $this->sd['cl']);
        $this->db->where("ref_bc", $this->sd['branch']);
        $this->db->delete("t_check_double_entry");
        return "0";
    } else {
        return "1";
    }
  }
}  

/*
public function account_update($condition) {
        $this->db->where("trans_no", $this->max_no);
        $this->db->where("trans_code", 97);
        $this->db->where("cl", $this->sd['cl']);
        $this->db->where("bc", $this->sd['branch']);
        $this->db->delete("t_check_double_entry");

        if ($_POST['hid'] != "0" || $_POST['hid'] != "") {
            $this->db->where('cl',$this->sd['cl']);
            $this->db->where('bc',$this->sd['branch']);
            $this->db->where('trans_code',97);
            $this->db->where('trans_no',$this->max_no);
            $this->db->delete('t_account_trans');
        }

        $config = array(
            "ddate" => $_POST['date'],
            "trans_code" => 97,
            "trans_no" => $this->max_no,
            "op_acc" => 0,
            "reconcile" => 0,
            "cheque_no" => 0,
            "narration" => "",
            "ref_no" => $_POST['ref_no']
        );

        
        $amount = $_POST['cash_amount'];
        $this->load->model('account');
        $this->account->set_data($config);

        $sql="SELECT acc_code FROM r_branch_current_acc
           WHERE ref_bc='".$_POST['fr_branch']."'";
        $from_bc_acc = $this->db->query($sql)->first_row()->acc_code;

        $sql="SELECT acc_code FROM r_branch_current_acc
            WHERE ref_bc='".$this->sd['branch']."'";
        $to_bc_acc = $this->db->query($sql)->first_row()->acc_code;

        $sql_b="SELECT name from m_branch where bc='".$_POST['fr_branch']."'";
        $from_bc_name=$this->db->query($sql_b)->first_row()->name;

        $des = "Fund Transfer Receive From- (" . $from_bc_name." - No ".$_POST['transfer_no'].")";
         
        $cash_book=$this->utility->get_default_acc('CASH_IN_HAND');
        $this->account->set_value2($des, $amount, "dr", $cash_book,$condition);

        $cash_transit=$this->utility->get_default_acc('CASH_TRANSIT');
        $this->account->set_value2($des, $amount, "cr", $cash_transit,$condition);

        //--------- Update inter branch current account---------

        $this->account->set_value2($des, $amount, "cr", $from_bc_acc,$condition);
        $this->account->set_value2($des, $amount, "dr", $to_bc_acc ,$condition);

        if($condition==0){
             $query = $this->db->query("
                 SELECT (IFNULL( SUM( t.`dr_amount`),0) = IFNULL(SUM(t.`cr_amount`),0)) AS ok 
                 FROM `t_check_double_entry` t
                 LEFT JOIN `m_account` a ON t.`acc_code` = a.`code`
                 WHERE  t.`cl`='" . $this->sd['cl'] . "'  AND t.`bc`='" . $this->sd['branch'] . "'  AND t.`trans_code`='97'  AND t.`trans_no` ='" . $this->max_no . "' AND 
                 a.`is_control_acc`='0'");

            if ($query->row()->ok == "0") {
                $this->db->where("trans_no", $this->max_no);
                $this->db->where("trans_code", 97);
                $this->db->where("cl", $this->sd['cl']);
                $this->db->where("bc", $this->sd['branch']);
                $this->db->delete("t_check_double_entry");
                return "0";
            } else {
                return "1";
            }
        }
    }
*/
} 
