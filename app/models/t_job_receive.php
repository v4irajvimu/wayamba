<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class t_job_receive extends CI_Model {

  private $sd;
  private $mod = '003';

  function __construct(){
   parent::__construct();

   $this->sd = $this->session->all_userdata();
   $this->load->database($this->sd['db'], true);
   $this->load->model('user_permissions');
 }

 public function base_details(){

  $this->load->model("utility");
  $a['max_no'] = $this->utility->get_max_no("t_job_receive", "nno");
  return $a;
}


public function validation(){
  $status =1;
  $this->max_no = $this->utility->get_max_no("t_job_receive","nno");
  return $status;
}
public function save(){
  $this->db->trans_begin();
  error_reporting(E_ALL);
  function exceptionThrower($type,$errMsg,$errFile, $errLine){
    throw new Exception($errMsg);     
  }
  set_error_handler('exceptionThrower');
  try{
    $validate = $this->validation();
    if($validate ==1){

      $sum = array(
       "cl"=>$this->sd['cl'],
       "bc"=>$this->sd['branch'],
       "nno"=>$this->max_no,
       "ref_no"=>$_POST['ref_no'],
       "crn_no"=>$_POST['crn'],
       "ddate"=>$_POST['date'],
       "supplier"=>$_POST['supplier'],
       "memo"=>$_POST['comment'],
       "amount"=>$_POST['amount'],
       "oc"=>$this->sd['oc']
       );
      for($x =0;$x<25;$x++){
        if(isset($_POST['0_'.$x],$_POST['n_'.$x],$_POST['sel_'.$x])){
          if($_POST['0_'.$x]!="" && $_POST['n_'.$x]!=""){
            $det[] = array(
             "cl"=>$this->sd['cl'],
             "bc"=>$this->sd['branch'],
             "nno"=>$this->max_no,
             "job_no"=>$_POST['0_'.$x],
             "amount"=>$_POST['5_'.$x] );
          }

        }
      }

      if($_POST['hid']== "0" || $_POST['hid'] == ""){
        if($this->user_permissions->is_add('t_job_receive')){
          $this->db->insert("t_job_receive",$sum);
          if(count($det)){
            $this->db->insert_batch("t_job_receive_det",$det);  
          }
          for($x=0;$x<25;$x++){
            if(isset($_POST['sel_'.$x])){
              $this->db->where("cl",$this->sd['cl']);
              $this->db->where("bc",$this->sd['branch']);
              $this->db->where("nno",$_POST['0_'.$x]);
              $this->db->update("t_job", array("status" =>"3"));
            }
          }
          $this->utility->save_logger("SAVE",98,$this->max_no,$this->mod);
          echo $this->db->trans_commit();
        }else{
          $this->db->trans_commit();
          echo "No permission to save records";
        }   
      }else{
        if($this->user_permissions->is_edit('t_job_receive')){
          $this->db->where("cl",$this->sd['cl']);
          $this->db->where("bc",$this->sd['branch']);
          $this->db->where("nno",$_POST['hid']);
          $this->db->update("t_job_receive",$sum);

          $this->db->where("cl",$this->sd['cl']);
          $this->db->where("bc",$this->sd['branch']);
          $this->db->where("nno",$_POST['hid']);
          $this->db->delete("t_job_receive_det");

          if(count($det)){
            $this->db->insert_batch("t_job_receive_det",$det);
          }
          for($x=0;$x<25;$x++){
            $this->db->where("cl",$this->sd['cl']);
            $this->db->where("bc",$this->sd['branch']);
            $this->db->where("nno",$_POST['0_'.$x]);
            $this->db->update("t_job",array("status"=>"2"));

          if(isset($_POST['sel_'.$x])){
              $this->db->where("cl",$this->sd['cl']);
              $this->db->where("bc",$this->sd['branch']);
              $this->db->where("nno",$_POST['0_'.$x]);
              $this->db->update("t_job",array("status"=>"3"));
            }
          }
          $this->utility->save_logger("EDIT",91,$this->max_no,$this->mod);
          echo $this->db->trans_commit();  

        }else{
          $this->db->trans_commit();
          echo "No permission to edit record";
        }

      }   

    }else{
     $this->db->trans_commit();
     echo $validate;
   }

 }catch(Exception $e){

   $this->db->trans_rollback();
   echo $e->getMessage()."Operation fail please contatct admin";
 }        


}

public function load(){

  $sql_sum = "SELECT
  tr.`ddate`,
  tr.`ref_no`,
  tr.`crn_no`,
  tr.`memo`,
  tr.`supplier`,
  ms.`name`,
  tr.`amount`,
  tr.`is_cancel`
  FROM 
  t_job_receive tr
  JOIN m_supplier ms ON ms.`code`= tr.`supplier`
  WHERE tr.cl='".$this->sd['cl']."'
  AND tr.bc='".$this->sd['branch']."'
  AND tr.nno='".$_POST['id']."' ";

  $query_sum =$this->db->query($sql_sum);

  $sql_det="SELECT 
  td.`job_no`,
  tj.`ddate` AS service_receive_dt,
  tj.`fault`,
  tj.`item_code`,
  tj.`Item_name`,
  tjs.`ddate` AS send_sup_dt,
  td.`amount` AS item_amt,
  tj.`w_start_date`,
  tj.`w_end_date`  
  FROM 
  t_job tj
  JOIN t_job_receive_det td ON td.`cl`=tj.`cl` AND td.`bc`=tj.`bc` AND td.`job_no`=tj.`nno`
  JOIN t_job_receive tr ON tr.`cl`=td.`cl` AND tr.`bc`=td.`bc` AND tr.`nno`=td.`nno`
  JOIN t_job_send_det tjt ON tjt.`cl`=tj.`cl` AND tjt.`bc`=tj.`bc`AND tjt.`job_no`=tj.`nno`
  JOIN t_job_send_sum tjs ON tjs.`cl`=tjt.`cl` AND tjs.`bc`=tjt.`bc` AND tjs.`nno`=tjt.`nno`
  WHERE tj.cl='".$this->sd['cl']."'
  AND tj.bc='".$this->sd['branch']."' 
  AND td.nno = '".$_POST['id']."'";

  $query_det=$this->db->query($sql_det);

  if($query_sum->num_rows()>0){
    $a['a']=$this->db->query($sql_sum)->result();
  }else{
    $a['a']=2;
  }

  if($query_det-> num_rows()>0){
    $a['b']=$this->db->query($sql_det)->result();
  }else{
    $a['b']=2;
  }

  echo json_encode($a);
}
public function delete(){

  $this->db->trans_begin();
  error_reporting(E_ALL);
  function exceptionThrower($type,$errMsg,$errFile,$errLine){
    throw new Exception($errMsg); 
  }
  set_error_handler('exceptionThrower');
  try{
    if($this->user_permissions->is_delete('t_job_receive')){
      $this->db->where("nno",$_POST['id']);
      $this->db->where("cl",$this->sd['cl']);
      $this->db->where("bc",$this->sd['branch']);
      $this->db->update("t_job_receive",array("is_cancel"=>"1"));

      $sql = "SELECT nno,job_no FROM `t_job_receive_det` where nno = '".$_POST['id']."'";
      $query = $this->db->query($sql);

      foreach ($query->result() as $row){
        $this->db->where("cl",$this->sd['cl']);
        $this->db->where("bc",$this->sd['branch']);
        $this->db->where("nno",$row->job_no);
        $this->db->update("t_job",array("status"=>"2"));
      }
      $this->utility->save_logger("CANCEL",91,$_POST['id'],$this->mod);    
      echo $this->db->trans_commit();
    }else{
      echo "No Permission to delte records";
      $this->db->trans_commit();
    }

  }catch(Exception $e){
    $this->db->trans_rollback();
    echo $e->getMessage()."Operation fail please contact admin";
  }

}
public function select_supplier(){
  if($_POST['search'] == 'Key Word: code, name'){$_POST['search'] = "";}
  $sql = "SELECT 
  tj.`supplier`,
  ms.`name`  
  FROM t_job tj
  JOIN `m_supplier` ms ON ms.`code`= tj.`supplier`
  WHERE tj.`status` = '2'
  AND tj.`cl`='".$this->sd['cl']."'
  AND tj.`bc`='".$this->sd['branch']."'
  AND(tj.supplier LIKE '%$_POST[search]%'OR ms.name LIKE '%$_POST[search]%')
  GROUP BY tj.`supplier` LIMIT 25";

  $query = $this->db->query($sql);
  $a ="<table id='item_list' style='width:100%'>";
  $a.="<thead><tr>";
  $a.="<th class ='tb_head_th'>Code</th>";
  $a.="<th class='tb_head_th' colspan='2'>Description</th>";
  $a.="</thead></tr><tr class='cl' style='visibility:hidden;'><td>&nbsp;</td><td colspan='2'>&nbsp;</td></tr>";

  foreach($query->result() as $r){
    $a.="<tr class='cl'>";
    $a.="<td>".$r->supplier."</td>";
    $a.="<td colspan='2'>".$r->name."</td>";
    $a.="</tr>";
  }
  $a."</table>";
  echo $a;

}
public function load_services(){
if($_POST['search'] == 'Key Word: code, name'){$_POST['search'] = "";}
  $sql="SELECT
  td.`job_no`,
  ts.`ddate` AS send_date,
  tj.`ddate` AS receive_dt,
  tj.`item_code`,
  tj.`Item_name`,
  tj.`fault`,
  tj.`w_start_date`,
  tj.`w_end_date`
  FROM t_job tj
  JOIN `t_job_send_det` td ON td.`bc` = tj.`bc` AND td.`cl`=tj.`cl` AND td.`job_no`=tj.`nno`
  JOIN `t_job_send_sum` ts ON ts.`cl`= td.`cl` AND ts.`bc` = td.`bc` AND ts.`nno` =td.`nno`
  WHERE tj.`supplier`= '".$_POST['supplier']."'
  AND tj.cl='".$this->sd['cl']."'
  AND tj.bc='".$this->sd['branch']."'
  AND tj.`status` = '2'
  AND(td.job_no LIKE '%$_POST[search]%'OR tj.item_code LIKE '%$_POST[search]%' OR tj.Item_name LIKE '%$_POST[search]%')
  LIMIT 25";

  $query = $this->db->query($sql);
  if($query->num_rows > 0){
    $a['a']=$this->db->query($sql)->result();
  }else{
    $a['a'] = 2;
  }
  echo json_encode($a);
}

public function PDF_report(){
  $this->db->select(array('name','address','tp','fax','email'));
  $this->db->where("cl",$this->sd['cl']);
  $this->db->where("bc",$this->sd['branch']);
  $r_detail['branch'] = $this->db->get('m_branch')->result();

  $this->db->select(array('loginName'));
  $this->db->where('cCode',$this->sd['oc']);
  $r_detail['user']=$this->db->get('users')->result();

  $r_detail['session'] = $session_array;

  $r_detail['orientation'] = "L";
  $r_detail['page']="A5";

  $sql1 = "SELECT
    tr.`nno`, 
    tr.`ddate`,
    tr.`ref_no`,
    tr.`crn_no`,
    tr.`memo`,
    tr.`supplier`,
    ms.`name` AS sup_name,
    tr.`amount`
    FROM 
    t_job_receive tr
    JOIN m_supplier ms ON ms.`code`= tr.`supplier`
    WHERE tr.cl='".$this->sd['cl']."'
    AND tr.bc='".$this->sd['branch']."'
    AND tr.nno='".$_POST['qno']."' ";

$r_detail['sum']= $this->db->query($sql1)->result();

$sql="SELECT 
  td.`job_no`,
  tj.`ddate` AS r_date,
  tj.`fault`,
  tj.`item_code`,
  tj.`Item_name`,
  tjs.`ddate` AS s_date,
  td.`amount` AS item_amt,
  tj.`w_start_date`,
  tj.`w_end_date`  
  FROM 
  t_job tj
  JOIN t_job_receive_det td ON td.`cl`=tj.`cl` AND td.`bc`=tj.`bc` AND td.`job_no`=tj.`nno`
  JOIN t_job_receive tr ON tr.`cl`=td.`cl` AND tr.`bc`=td.`bc` AND tr.`nno`=td.`nno`
  JOIN t_job_send_det tjt ON tjt.`cl`=tj.`cl` AND tjt.`bc`=tj.`bc`AND tjt.`job_no`=tj.`nno`
  JOIN t_job_send_sum tjs ON tjs.`cl`=tjt.`cl` AND tjs.`bc`=tjt.`bc` AND tjs.`nno`=tjt.`nno`
  WHERE tj.cl='".$this->sd['cl']."'
  AND tj.bc='".$this->sd['branch']."' 
  AND td.nno = '".$_POST['qno']."'";

  $r_detail['det']= $this->db->query($sql)->result();

  $this->load->view($_POST['by'].'_'.'pdf',$r_detail);
}

}