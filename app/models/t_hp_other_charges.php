<?php
if (!defined('BASEPATH'))
  exit('No direct script access allowed');

class t_hp_other_charges extends CI_Model{

  private $sd;
  private $mtb;
  
  private $mod = '003';
  
  function __construct()
  {
    parent::__construct();
    
    $this->sd = $this->session->all_userdata();
    $this->load->database($this->sd['db'], true);
    $this->load->model('user_permissions');
    $this->max_no = $this->utility->get_max_no("t_hp_chargers_sum", "nno");
  }
  
  public function base_details()
  {
    $a['max_no']=$this->max_no;
    return $a;
  }

  public function validation(){
    $status         = 1;
  /*  $account_update = $this->account_update(0);
    if ($account_update != 1) {
      return "Invalid account entries";
    }*/
    return $status;
  }
  

  public function save(){
    $this->db->trans_begin();
    error_reporting(E_ALL);    
    function exceptionThrower($type, $errMsg, $errFile, $errLine){
      throw new Exception($errMsg);
    }    
    set_error_handler('exceptionThrower');
    try {      
      $validation_status = $this->validation();
      if ($validation_status == 1) {

        $sum = array(
          "cl" => $this->sd['cl'],
          "bc" => $this->sd['branch'],
          "nno" => $this->max_no,
          "ddate" => $_POST['date'],
          "ref_no" => $_POST['ref_no'],
          "agreement_no" => $_POST['agri_no'],
          "customer" => $_POST['customer'],
          "total_amount" => $_POST['net'],
          "paid_amount" => $_POST['net'],
          "note" => $_POST['note'],
          "oc" => $this->sd['oc']          
          );
        
        $other = array(
          "bc" => $this->sd['branch'],
          "cl" => $this->sd['cl'],
          "ddate" => $_POST['date'],
          "agr_no" => $_POST['agri_no'],
          "acc_code" => $_POST['customer'],
          "due_date" => $_POST['date'], 
          "trans_code" => 67,      
          "trans_no" => $this->max_no,   
          "ins_trans_code" => 4,  
          "dr" => $_POST['net'], 
          );

        for ($i = 0; $i < 25; $i++) {
          if ($_POST['0_' . $i] != "" && $_POST['2_' . $i] != "" && $_POST['2_' . $i] != "0") {            
            $det[] = array(
              "bc" => $this->sd['branch'],
              "cl" => $this->sd['cl'],
              "nno" => $this->max_no,
              "chg_type" => $_POST['0_' . $i],
              "acc_code" => $_POST['acc_' . $i],
              "description" => $_POST['1_' . $i],
              "amount" => $_POST['2_' . $i],         
              );
          }
        }
        
        if ($_POST['hid'] == "0" || $_POST['hid'] == "") {          
          if ($this->user_permissions->is_add('t_hp_other_charges')) { 
            $account_update=$this->account_update(0);
            if($account_update==1){
              $this->db->insert("t_hp_chargers_sum", $sum);  

              $this->db->insert("t_ins_trans", $other);            

              if (count($det)) {
                $this->db->insert_batch("t_hp_chargers_det", $det);
              }

            /*if (count($other)) {
              $this->db->insert_batch("t_ins_trans", $other);
            }*/

            $this->account_update(1);

            $this->utility->save_logger("SAVE",67,$this->max_no,$this->mod);
            echo $this->db->trans_commit();
          }else{
            echo "Invalid account entries";
            $this->db->trans_commit();
          }
        } else {
          echo "No permission to save records";
          $this->db->trans_commit();
        }
      } else {
        if ($this->user_permissions->is_edit('t_hp_other_charges')) {
          $account_update=$this->account_update(0);
          if($account_update==1){
            $this->db->where('nno', $this->max_no);
            $this->db->where("cl", $this->sd['cl']);
            $this->db->where("bc", $this->sd['branch']);
            $this->db->delete("t_hp_chargers_det");

            $this->db->where('trans_code', 67);
            $this->db->where('trans_no', $this->max_no);
            $this->db->where("cl", $this->sd['cl']);
            $this->db->where("bc", $this->sd['branch']);
            $this->db->delete("t_ins_trans");

            $this->db->where('nno', $this->max_no);
            $this->db->where("cl", $this->sd['cl']);
            $this->db->where("bc", $this->sd['branch']);
            $this->db->update("t_hp_chargers_sum", $sum);

            $this->db->insert("t_ins_trans", $other);         

            if (count($det)) {
              $this->db->insert_batch("t_hp_chargers_det", $det);
            }

            /* 
            if (count($other)) {
              $this->db->insert_batch("t_ins_trans", $other);
            }
            */
            
            $this->account_update(1);
            $this->utility->save_logger("EDIT",67,$this->max_no,$this->mod);
            echo $this->db->trans_commit();
          }else{
            echo "Invalid account entries";
            $this->db->trans_commit();
          }
        } else {
          echo "No permission to save records";
          $this->db->trans_commit();
        }
      }

    } else {
      echo $validation_status;
      $this->db->trans_commit();
    }

  }
  catch (Exception $e) {
    $this->db->trans_rollback();
    echo $e->getMessage()."Operation fail please contact admin";
  }

}




public function account_update($condition)
{
  $this->db->where("trans_no", $this->max_no);
  $this->db->where("trans_code",67);
  $this->db->where("cl", $this->sd['cl']);
  $this->db->where("bc", $this->sd['branch']);
  $this->db->delete("t_check_double_entry");

  if ($condition == 1) {
    if ($_POST['hid'] != "0" || $_POST['hid'] != "") {
      $this->db->where('cl', $this->sd['cl']);
      $this->db->where('bc', $this->sd['branch']);
      $this->db->where('trans_code',67);
      $this->db->where('trans_no', $this->max_no);
      $this->db->delete('t_account_trans');
    }
  }
  $config = array(
    "ddate" => $_POST['date'],
    "trans_code" => 67,
    "trans_no" => $this->max_no,
    "op_acc" => 0,
    "reconcile" => 0,
    "cheque_no" => 0,
    "narration" => "",
    "ref_no" => $_POST['ref_no']
    );

  $sql = "SELECT name from m_customer where code = '".$_POST['customer']."' LIMIT 1";
  $cus_name = $this->db->query($sql)->first_row()->name;
  $des = "OTHER CHARGERS - " .$cus_name;

  $this->load->model('account');
  $this->account->set_data($config);

  $this->account->set_value2($des, $_POST['net'], "dr", $_POST['customer'], $condition);

  for ($i = 0; $i < 25; $i++) {
    if ($_POST['acc_' . $i] != "" && $_POST['acc_' . $i] != "0" && $_POST['0_' . $i] != "" && $_POST['0_' . $i] != "0") {
      $dess = "OTHER CHARGERS - " . $_POST['0_' . $i];
      $this->account->set_value2($dess, $_POST['2_'.$i], "cr", $_POST['acc_'.$i], $condition);
    }
  }

  if ($condition == 0) {
    $query = $this->db->query("
     SELECT (IFNULL( SUM( t.`dr_amount`),0) = IFNULL(SUM(t.`cr_amount`),0)) AS ok 
     FROM `t_check_double_entry` t
     LEFT JOIN `m_account` a ON t.`acc_code` = a.`code`
     WHERE  t.`cl`='" . $this->sd['cl'] . "'  AND t.`bc`='" . $this->sd['branch'] . "'  AND t.`trans_code`='67'  AND t.`trans_no` ='" . $this->max_no . "' AND 
     a.`is_control_acc`='0'");

    if ($query->row()->ok == "0") {
      $this->db->where("trans_no", $this->max_no);
      $this->db->where("trans_code", 67);
      $this->db->where("cl", $this->sd['cl']);
      $this->db->where("bc", $this->sd['branch']);
      $this->db->delete("t_check_double_entry");
      return "0";
    } else {
      return "1";
    }
  }
}



public function delete(){

  $this->db->trans_begin();
  error_reporting(E_ALL);

  function exceptionThrower($type, $errMsg, $errFile, $errLine)
  {
    throw new Exception($errMsg);
  }

  set_error_handler('exceptionThrower');
  try {
    if ($this->user_permissions->is_delete('t_hp_other_charges')) {
      $this->db->where("nno", $_POST['code']);
      $this->db->where("bc", $this->sd['branch']);
      $this->db->where("cl", $this->sd['cl']);
      $this->db->limit(1);
      $this->db->update("t_hp_chargers_sum", array("is_cancel" => 1));

      $this->db->where('cl', $this->sd['cl']);
      $this->db->where('bc', $this->sd['branch']);
      $this->db->where('trans_code', 67);
      $this->db->where('trans_no', $_POST['code']);
      $this->db->delete('t_account_trans');

      $this->db->where('cl', $this->sd['cl']);
      $this->db->where('bc', $this->sd['branch']);
      $this->db->where('trans_code', 67);
      $this->db->where('trans_no', $_POST['code']);
      $this->db->delete('t_ins_trans');

      $this->utility->save_logger("CANCEL", 67, $_POST['code'], $this->mod);
      echo $this->db->trans_commit();
    } else {
      echo "No permission to delete records";
      $this->db->trans_commit();
    }
  }
  catch (Exception $e) {
    $this->db->trans_rollback();
    echo "Operation fail please contact admin";
  }
}

public function select()
{
  $query = $this->db->get($this->mtb);

  $s = "<select name='sales_ref' id='sales_ref'>";
  $s .= "<option value='0'>---</option>";
  foreach ($query->result() as $r) {
    $s .= "<option title='" . $r->name . "' value='" . $r->code . "'>" . $r->code . " | " . $r->name . "</option>";
  }
  $s .= "</select>";

  return $s;
}


public function get_data(){


  $sql="SELECT  t.nno,
  t.ddate,
  t.ref_no,
  t.agreement_no,
  t.customer,
  t.paid_amount,
  t.note,
  t.is_cancel,
  c.name,
  s.`ddate` AS inv_date,
  s.`nno` AS inv_no
  FROM t_hp_chargers_sum t
  JOIN m_customer c ON c.`code` = t.`customer` 
  JOIN t_hp_sales_sum s ON s.`cl` = t.`cl` AND s.`bc`=t.`bc` AND s.`agreement_no` = t.`agreement_no` 
  WHERE t.cl ='" . $this->sd['cl'] . "' 
  AND t.bc='" . $this->sd['branch'] . "' 
  AND t.`nno`='" . $_POST['id'] . "'
  LIMIT 1";
  $query    = $this->db->query($sql);
  $a['sum'] = $query->result();


  $sql = "SELECT chg_type,
  r.acc_code,
  d.description,
  d.amount,
  r.`description` as des
  FROM t_hp_chargers_det d
  JOIN r_hp_chargers_type r ON r.`code` = d.`chg_type`
  WHERE d.cl ='" . $this->sd['cl'] . "' 
  AND d.bc='" . $this->sd['branch'] . "' 
  AND d.`nno`='" . $_POST['id'] . "'
  ";
  $query    = $this->db->query($sql);
  $a['det'] = $query->result();

  if($query->num_rows()>0){
    echo json_encode($a);
  }else{
    echo json_encode("2");
  }
}



public function PDF_report()
{


  $this->db->select(array(
    'name',
    'address',
    'tp',
    'fax',
    'email'
    ));
  $this->db->where("cl", $this->sd['cl']);
  $this->db->where("bc", $this->sd['branch']);
  $r_detail['branch'] = $this->db->get('m_branch')->result();



  $invoice_number      = $this->utility->invoice_format($_POST['qno']);
  $session_array       = array(
    $this->sd['cl'],
    $this->sd['branch'],
    $invoice_number
    );
  $r_detail['session'] = $session_array;

  $this->db->where("code", $_POST['sales_type']);
  $query = $this->db->get('t_trans_code');
  if ($query->num_rows() > 0) {
    foreach ($query->result() as $row) {
      $r_detail['r_type'] = $row->description;
    }
  }


  $r_detail['type']         = $_POST['type'];
  $r_detail['dt']           = $_POST['dt'];
  $r_detail['qno']          = $_POST['qno'];
  $r_detail['voucher_type'] = $_POST['voucher_type'];

  $r_detail['voucher_no']  = $_POST['qno'];
  $r_detail['category_id'] = $_POST['category_id'];
  $r_detail['cat_des']     = $_POST['cat_des'];
  $r_detail['group_id']    = $_POST['group_id'];
  $r_detail['group_des']   = $_POST['group_des'];
  $r_detail['ddate']       = $_POST['ddate'];
  $r_detail['tot']         = $_POST['tot'];



  $r_detail['num'] = $_POST['tot'];

  $num = $_POST['tot'];

  $this->utility->num_in_letter($num);

//-------------------------------------------------

  $r_detail['rec'] = convertNum($num);
  ;

  $r_detail['page']        = "A5";
  $r_detail['header']      = $_POST['header'];
  $r_detail['orientation'] = "L";

  $r_detail['acc_code'] = $_POST['acc_code'];
  $r_detail['acc_des']  = $_POST['acc_des'];
  $r_detail['vou_des']  = $_POST['vou_des'];

  $sql="SELECT chg_type,
  d.acc_code,
  d.description,
  d.amount,
  r.`description` as des
  FROM t_hp_chargers_det d
  JOIN r_hp_chargers_type r ON r.`code` = d.`chg_type`
  WHERE d.cl='".$this->sd['cl']."' AND d.bc='".$this->sd['branch']."' 
  AND nno = '".$_POST['qno']."'";
  $r_detail['dets'] = $this->db->query($sql)->result(); 

  $sql="SELECT * FROM t_hp_chargers_sum 
  WHERE cl='".$this->sd['cl']."' AND bc='".$this->sd['branch']."' 
  AND nno = '".$_POST['qno']."'";
  $r_detail['sum'] = $this->db->query($sql)->result(); 

  $this->db->select(array(
    'name'
    ));
  $this->db->where("code", $_POST['salesp_id']);
  $query = $this->db->get('m_employee');

  foreach ($query->result() as $row) {
    $r_detail['employee'] = $row->name;
  }

  $this->db->select(array(
    'loginName'
    ));
  $this->db->where('cCode', $this->sd['oc']);
  $r_detail['user'] = $this->db->get('users')->result();

  $r_detail['is_cur_time'] = $this->utility->get_cur_time();

  $s_time=$this->utility->save_time();
  if($s_time==1){
    $r_detail['save_time']="  -  ".$this->utility->get_save_time('t_hp_chargers_sum','action_date',$_POST['qno'],'nno');

  }else{
    $r_detail['save_time']="";
  }    



  $this->load->view($_POST['by'] . '_' . 'pdf', $r_detail);
}

public function get_default_acc(){
  $sql = "SELECT * FROM m_account WHERE CODE  = '103000006001'";
  $query = $this->db->query($sql);

  if($query->num_rows()>0){
    $a = $query->result();
  }else{
    $a =2;
  }
  echo json_encode($a);
}

public function load_chargers(){

  if($_POST['search'] == 'Key Word: code, name'){$_POST['search'] = "";}

  $sql = "SELECT * FROM `r_hp_chargers_type`  WHERE code LIKE '%$_POST[search]%' OR description LIKE '%$_POST[search]%' LIMIT 25";

  $query = $this->db->query($sql);
  $a  = "<table id='item_list' style='width : 100%' >";
  $a .= "<thead><tr>";
  $a .= "<th class='tb_head_th'>Code</th>";
  $a .= "<th class='tb_head_th' colspan='2'>Description</th>";
  $a .= "<th class='tb_head_th'>Account</th>";
  $a .= "</thead></tr><tr class='cl'><td>&nbsp;</td><td colspan='2'>&nbsp;</td></tr>";

  foreach($query->result() as $r){
    $a .= "<tr class='cl'>";
    $a .= "<td>".$r->code."</td>";
    $a .= "<td colspan='2'>".$r->description."</td>";
    $a .= "<td>".$r->acc_code."</td>";
    $a .= "<td style='display:none'>".$r->amount."</td>";
    $a .= "</tr>";
  }
  $a .= "</table>";
  echo $a;
}

public function load_agreement_no(){
  if($_POST['search'] == 'Key Word: code, name'){$_POST['search'] = "";}


  $sql="  SELECT t.agr_no, 
  h.`cus_id`, 
  h.nno, 
  h.ddate,
  c.`name`,
  c.nic 
  FROM t_ins_trans t
  JOIN t_hp_sales_sum h ON h.`agreement_no` = t.`agr_no` AND h.`cl` = t.`cl` AND h.`bc` = t.`bc`
  JOIN m_customer c ON c.`code` = h.`cus_id`  
  WHERE (t.agr_no LIKE '%$_POST[search]%' 
  OR h.`cus_id` LIKE '%$_POST[search]%' 
  OR c.`name` LIKE '%$_POST[search]%'
  OR c.`nic` LIKE '%$_POST[search]%')
  AND h.cl='".$this->sd['cl']."' AND h.bc='".$this->sd['branch']."'
  group by t.agr_no";

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

    $a .= "</tr>";
  }
  $a .= "</table>";
  echo $a;
}
}