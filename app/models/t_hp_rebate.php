<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class t_hp_rebate extends CI_Model {

  private $sd;
  private $mtb;
  private $max_no;

  private $mod = '003';

  function __construct(){
   parent::__construct();

   $this->sd = $this->session->all_userdata();
   $this->load->database($this->sd['db'], true);
   $this->load->model('user_permissions');

 }
 public function base_details(){
   $a['max_no']=$this->utility->get_max_no("t_hp_rebate","nno");
   return $a;
 }

 public function validation(){
   $status = 1;
   $chk_delete_trans = $this->chk_delete_trans($_POST['loan_no'],$_POST['hid']);
   if ($chk_delete_trans != 0) {
    return "This Rebate Already Settled";
  }
  return $status;
}



public function advane_amo(){
  $sql="SELECT SUM(dr)-SUM(cr) AS advance 
  FROM t_advance_trans 
  WHERE agr_no='".$_POST['agr_no']."' ";
  echo $query=$this->db->query($sql)->first_row()->advance;
}




public function capital()
{

  $capital=$_POST['ins_capital'];

  $sql_capital="SELECT 
  capital_amount,
  int_amount,
  SUM(int_amount),
  SUM(capital_amount) - aa.capital AS cap_balance,
  SUM(int_amount) - bb.inte AS intr_bal,
  SUM(penalty_amount) - IFNULL(cc.panalty,0) AS penalty_bal 
  FROM
  `t_ins_schedule` 
  LEFT JOIN (SELECT IFNULL(SUM(cr),0) AS capital,agr_no FROM t_ins_trans WHERE ins_trans_code='1' AND agr_no='".$capital."')aa ON aa.agr_no=t_ins_schedule.agr_no
  LEFT JOIN (SELECT IFNULL(SUM(cr),0) AS inte,agr_no FROM t_ins_trans WHERE ins_trans_code='2' AND agr_no='".$capital."')bb ON bb.agr_no=t_ins_schedule.agr_no
  LEFT JOIN (SELECT IFNULL(SUM(cr),0) AS panalty,agr_no FROM t_ins_trans WHERE ins_trans_code='3' AND agr_no='".$capital."')cc ON cc.agr_no=t_ins_schedule.agr_no
  WHERE t_ins_schedule.agr_no='".$capital."' AND t_ins_schedule. cl = '".$this->sd['cl']."' AND t_ins_schedule.bc = '".$this->sd['branch']."' ";
  $query = $this->db->query($sql_capital);
  if($query->num_rows()>0)
  {
    $data['a']=$query->result();
  }
  else
  {
    $data['a']=2;
  }            
  echo json_encode($data);

}

public function other_charges()
{

  $loan_no=$_POST['loan_no'];

  $sql_loan="SELECT 
  SUM(dr) - SUM(cr) AS other_balance 
  FROM
  `t_ins_trans` 
  WHERE ins_trans_code = 4 AND agr_no='".$loan_no."' AND cl = '".$this->sd['cl']."' AND bc = '".$this->sd['branch']."'";
  $query = $this->db->query($sql_loan);
  if($query->num_rows()>0)
  {
    $data['b']=$query->result();
  }
  else
  {
    $data['b']=2;
  }            
  echo json_encode($data);

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
   if ($validation_status == 1){
    $_POST['cl']=$this->sd['cl'];
    $_POST['branch']=$this->sd['branch'];
    $_POST['oc']=$this->sd['oc']; 

    $t_hp_rebate=array(
     "cl"                 =>$_POST['cl'],
     "bc"                 =>$_POST['branch'],
     "oc"                 =>$_POST['oc'],
     "nno"                =>$_POST['no'],
     "ddate"              =>$_POST['date'],
     "loan_no"            =>$_POST['loan_no'],
     "ref_no"             =>$_POST['ref_no'],

     "bal_capital"        =>$_POST['capital'],
     "rbt_capital"        =>$_POST['capital_rebate'],
     "paid_capital"        =>$_POST['capital_paid'],

     "bal_interest"       =>$_POST['interrest'],
     "rbt_interest"       =>$_POST['Interest_rebate'],
     "paid_interest"       =>$_POST['interest_paid'],

     "bal_panalty"        =>$_POST['panalty'],
     "rbt_panalty"        =>$_POST['panalty_rebate'],
     "paid_panalty"       =>$_POST['panalty_paid'],


     "bal_other_Chg"      =>$_POST['other_charges'],
     "rbt_other_chg"      =>$_POST['other_rebate'],
     "paid_other_chg"     =>$_POST['other_charges_paid'],

     "tot_balance"        =>$_POST['tot'],
     "tot_rebate"         =>$_POST['tot_reb'],
     "tot_paid"           =>$_POST['tot_paid'],

     "bill_no"            =>$_POST['bill_no'],
     "advance_amount"     =>$_POST['advance']
     );


    if($_POST['hid'] == "0" || $_POST['hid'] == ""){
      if($this->user_permissions->is_add('t_hp_rebate')){ 
        $this->db->insert("t_hp_rebate",  $t_hp_rebate);
        $this->utility->save_logger("SAVE",72,$this->max_no,$this->mod);
        echo $this->db->trans_commit();
      }else{
        echo "No permission to save records";
        $this->db->trans_commit();
      } 
    }else{
      if($this->user_permissions->is_edit('t_hp_rebate')){ 
        $this->db->where('nno',$_POST['hid']);
        $this->db->where("cl", $_POST['cl']);
        $this->db->where("bc", $_POST['branch']);
        $this->db->update("t_hp_rebate", $t_hp_rebate);
        $this->utility->save_logger("EDIT",72,$this->max_no,$this->mod); 
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



public function load(){


  $this->db->select(array(
    't_hp_rebate.cl' ,
    't_hp_rebate.bc' ,
    't_hp_rebate.nno',
    't_hp_rebate.ddate',
    't_hp_rebate.loan_no',
    't_hp_rebate.ref_no',
    'm_customer.name',
    't_hp_rebate.bill_no',

    't_hp_rebate.bal_capital',
    't_hp_rebate.rbt_capital',
    't_hp_rebate.paid_capital',

    't_hp_rebate.bal_interest',
    't_hp_rebate.rbt_interest',
    't_hp_rebate.paid_interest',

    't_hp_rebate.bal_panalty',
    't_hp_rebate.rbt_panalty',
    't_hp_rebate.paid_panalty',
    
    't_hp_rebate.bal_other_Chg',
    't_hp_rebate.rbt_other_chg',
    't_hp_rebate.paid_other_chg',
    
    't_hp_rebate.tot_balance',
    't_hp_rebate.tot_rebate',
    't_hp_rebate.tot_paid',

    't_hp_rebate.is_cancel',
    't_hp_rebate.is_settled',

    't_hp_rebate.advance_amount',

    't_ins_schedule.capital_amount',
    't_ins_schedule.int_amount',
    't_ins_schedule.ins_amount'
    ));

  $this->db->from('t_hp_rebate');
  $this->db->join('t_hp_sales_sum','t_hp_sales_sum.agreement_no=t_hp_rebate.loan_no');
  $this->db->join('m_customer','m_customer.code=t_hp_sales_sum.cus_id');
  $this->db->join('t_ins_schedule','t_ins_schedule.agr_no=t_hp_rebate.loan_no');
  $this->db->where('t_hp_rebate.cl',$this->sd['cl'] );
  $this->db->where('t_hp_rebate.bc',$this->sd['branch'] );
  $this->db->where('t_hp_rebate.nno',$_POST['id']);
  $query=$this->db->get();

  if($query->num_rows()>0){

    $a['hp_reb']=$query->result();
  }else{
    $a=2;
  }
  echo json_encode($a);

}

public function PDF_report(){

  $r_detail['no']=$_POST['nno'];
  $r_detail['page']=$_POST['page'];
  $r_detail['header']=$_POST['header'];
  $r_detail['orientation']=$_POST['orientation'];

  $this->db->select(array('name','address','tp','fax','email'));
  $this->db->where("cl",$this->sd['cl']);
  $this->db->where("bc",$this->sd['branch']);
  $r_detail['branch']=$this->db->get('m_branch')->result();

  $this->db->select(array('name','address','tp','fax','email'));
  $this->db->where("cl",$this->sd['cl']);
  $this->db->where("bc",$r_detail['ship_to_bc']);
  $r_detail['ship_branch']=$this->db->get('m_branch')->result();


  $sql="SELECT
  `cl`,
  `bc`,
  `oc`,
  `nno`,
  `ref_no`,
  `ddate`,
  `loan_no`,
  `bal_capital`,
  `bal_interest`,
  `bal_panalty`,
  `bal_other_Chg`,
  `rbt_capital`,
  `rbt_interest`,
  `rbt_panalty`,
  `rbt_other_chg`,
  `tot_balance`,
  `tot_rebate`
  FROM `t_hp_rebate`
  WHERE nno='".$_POST['nno']."' AND cl='".$this->sd['cl']."' AND bc='".$this->sd['branch']."' 
  LIMIT 1";

  $query=$this->db->query($sql);

  if($query->num_rows>0){
    $r_detail['det']=$query->result();
  }else{
    $r_detail['det']=2;
  }
  $this->load->view($_POST['by'].'_'.'pdf',$r_detail);

}

public function cancel(){
  $this->db->trans_begin();
  error_reporting(E_ALL); 
  function exceptionThrower($type, $errMsg, $errFile, $errLine) { 
    throw new Exception($errMsg); 
  }
  set_error_handler('exceptionThrower'); 
  try { 
    if($this->user_permissions->is_delete('t_hp_rebate')){
      $validation_status = $this->delete_validation();
      if ($validation_status == 1){
        $this->db->where('cl',$this->sd['cl']);
        $this->db->where('bc',$this->sd['branch']);
        $this->db->where('nno',$_POST['id']);
        $this->db->update('t_hp_rebate',array('is_cancel' => 1)); 
        $this->utility->save_logger("CANCEL",72,$this->max_no,$this->mod); 
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
    echo $e->getMessage()." - Operation fail please contact admin"; 
  }
}

public function load_agreement_no(){

  if($_POST['search'] == 'Key Word: code, name'){$_POST['search'] = "";}

  $sql="  SELECT h.agreement_no AS agr_no,
  h.`cus_id`, 
  h.nno, 
  h.ddate,
  c.`name`,
  c.nic,
  h.memo,
  h.ref_no
  FROM t_hp_sales_sum h 
  left JOIN t_ins_trans t  ON h.`agreement_no` = t.`agr_no` AND h.`cl` = t.`cl` AND h.`bc` = t.`bc`
  JOIN m_customer c ON c.`code` = h.`cus_id`  
  WHERE (h.agreement_no LIKE '%$_POST[search]%' 
  OR h.`ref_no` LIKE '%$_POST[search]%' 
  OR c.`name` LIKE '%$_POST[search]%'
  OR c.`nic` LIKE '%$_POST[search]%')
  AND h.cl='".$this->sd['cl']."' 
  AND h.bc='".$this->sd['branch']."'
  AND h.is_closed='0'
  AND h.is_cancel='0'
  group by t.agr_no
  LIMIT 25";

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
    $a .= "<td>".$r->ref_no."</td>";
    $a .= "<td style='display:none;'>".$r->cus_id."</td>";    
    $a .= "<td style='display:none;'>".$r->ddate."</td>";  
    $a .= "<td style='display:none;'>".$r->memo."</td>";        

    $a .= "</tr>";
  }
  $a .= "</table>";
  echo $a;
}

public function delete_validation(){
  $result=1;
  $chk_delete_trans = $this->chk_delete_trans($_POST['loan_no'],$_POST['id']);
  if ($chk_delete_trans != 0) {
    return "This Rebate Already Settled";
  }
  return $result;  
}

public function chk_delete_trans($agr_no,$id){

  $sql="SELECT * FROM t_ins_trans WHERE agr_no='$agr_no' AND sub_trans_code='72' AND sub_trans_no='$id'"; 

  $query = $this->db->query($sql);
  if ($query->num_rows() > 0) {
    $a= 1;
  } else {
    $a = 0;
  }
  return $a;
}

}