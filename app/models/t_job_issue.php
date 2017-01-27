<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class t_job_issue extends CI_Model {

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
    $a['max_no'] = $this->utility->get_max_no("t_job_issue", "nno");
    return $a;
}

public function validation(){
  $status =1;
  $this->max_no = $this->utility->get_max_no("t_job_issue","nno");
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
         "ddate"=>$_POST['date'],
         "customer"=>$_POST['cus_id'],
         "memo"=>$_POST['comment'],
         "drn_no"=>$_POST['drn'],
         "amount"=>$_POST['amount'],
         "advance"=>$_POST['adv_amount'],
         "balance"=>$_POST['bl_amount'],
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
               "amount"=>$_POST['6_'.$x] );
        }

    }
}

if($_POST['hid']== "0" || $_POST['hid'] == ""){
    if($this->user_permissions->is_add('t_job_issue')){
      $this->db->insert("t_job_issue",$sum);
      if(count($det)){
        $this->db->insert_batch("t_job_issue_det",$det);  
    }
    for($x=0;$x<25;$x++){
        if(isset($_POST['sel_'.$x])){
          $this->db->where("cl",$this->sd['cl']);
          $this->db->where("bc",$this->sd['branch']);
          $this->db->where("nno",$_POST['0_'.$x]);
          $this->db->update("t_job", array("status" =>"4"));
      }
  }
  $this->utility->save_logger("SAVE",98,$this->max_no,$this->mod);
  echo $this->db->trans_commit();
}else{
  $this->db->trans_commit();
  echo "No permission to save records";
}   
}else{
    if($this->user_permissions->is_edit('t_job_issue')){
      $this->db->where("cl",$this->sd['cl']);
      $this->db->where("bc",$this->sd['branch']);
      $this->db->where("nno",$_POST['hid']);
      $this->db->update("t_job_issue",$sum);

      $this->db->where("cl",$this->sd['cl']);
      $this->db->where("bc",$this->sd['branch']);
      $this->db->where("nno",$_POST['hid']);
      $this->db->delete("t_job_issue_det");

      if(count($det)){
        $this->db->insert_batch("t_job_issue_det",$det);
    }
    for($x=0;$x<25;$x++){
        $this->db->where("cl",$this->sd['cl']);
        $this->db->where("bc",$this->sd['branch']);
        $this->db->where("nno",$_POST['0_'.$x]);
        $this->db->update("t_job",array("status"=>"3"));

        if(isset($_POST['sel_'.$x])){
          $this->db->where("cl",$this->sd['cl']);
          $this->db->where("bc",$this->sd['branch']);
          $this->db->where("nno",$_POST['0_'.$x]);
          $this->db->update("t_job",array("status"=>"4"));
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

public function check_code(){
	$this->db->where('code', $_POST['code']);
	$this->db->limit(1);
	
	echo $this->db->get($this->mtb)->num_rows;
}

public function select_customer(){
  if($_POST['search'] == 'Key Word: code, name'){$_POST['search'] = "";}
  $sql = "SELECT 
  tj.`cus_id`,
  mc.`name`  
  FROM t_job tj
  JOIN `m_customer` mc ON mc.`code`= tj.`cus_id`
  WHERE tj.`status` = '3'
  AND tj.`cl`='".$this->sd['cl']."'
  AND tj.`bc`='".$this->sd['branch']."'
  AND(tj.nno LIKE '%$_POST[search]%' OR tj.item_code LIKE '%$_POST[search]%' OR tj.Item_name LIKE '%$_POST[search]%')
  GROUP BY tj.`cus_id`";

  $query = $this->db->query($sql);
  $a ="<table id='item_list' style='width:100%'>";
  $a.="<thead><tr>";
  $a.="<th class ='tb_head_th'>Code</th>";
  $a.="<th class='tb_head_th' colspan='2'>Description</th>";
  $a.="</thead></tr><tr class='cl' style='visibility:hidden;'><td>&nbsp;</td><td colspan='2'>&nbsp;</td></tr>";

  foreach($query->result() as $r){
    $a.="<tr class='cl'>";
    $a.="<td>".$r->cus_id."</td>";
    $a.="<td colspan='2'>".$r->name."</td>";
    $a.="</tr>";
}
$a."</table>";
echo $a;
}

public function load_services(){

  $sql="SELECT
  td.`job_no`,
  tj.`ddate` AS receive_dt,
  tj.`item_code`,
  tj.`Item_name`,
  tj.`fault`,
  tj.`advance_amount`,
  tj.`w_start_date`,
  tj.`w_end_date`
  FROM t_job tj
  JOIN `t_job_receive_det` td ON td.`bc` = tj.`bc` AND td.`cl`=tj.`cl` AND td.`job_no`=tj.`nno`
  JOIN `t_job_receive` ts ON ts.`cl`= td.`cl` AND ts.`bc` = td.`bc` AND ts.`nno` =td.`nno`
  WHERE tj.`cus_id`= '".$_POST['customer']."'
  AND tj.cl='".$this->sd['cl']."'
  AND tj.bc='".$this->sd['branch']."'
  AND tj.`status` = '3'
  LIMIT 25";

  $query = $this->db->query($sql);
  if($query->num_rows > 0){
    $a['a']=$this->db->query($sql)->result();
}else{
    $a['a'] = 2;
}
echo json_encode($a);
}

public function load(){

  $sql_sum = "SELECT 
              ti.`customer`,
              mc.`name`,
              ti.`memo`,
              ti.`ddate`,
              ti.`ref_no`,
              ti.`drn_no`,
              ti.`is_cancel`,
              ti.`amount`,
              ti.`advance`,
              ti.`balance`
          FROM 
          t_job_issue ti
          JOIN m_customer mc ON mc.`code`=ti.`customer`
          WHERE ti.cl='".$this->sd['cl']."'
          AND ti.bc='".$this->sd['branch']."'
          AND ti.nno='".$_POST['id']."' ";

        $query_sum =$this->db->query($sql_sum);

  $sql_det="SELECT
            dt.`job_no`, 
            tj.`item_code`,
            tj.`Item_name`,
            tj.`ddate` AS r_date,
            tj.`fault`,
            tj.`w_end_date`,
            tj.`w_start_date`,
            dt.`amount`
        FROM t_job tj
        JOIN t_job_issue_det dt ON dt.`cl`=tj.`cl` AND dt.`bc`=tj.`bc` AND dt.`job_no`= tj.`nno`
        JOIN t_job_issue ti ON ti.`cl`=dt.`cl` AND ti.`bc`=dt.`bc` AND ti.`nno`= dt.`nno`
        WHERE tj.cl='".$this->sd['cl']."'
        AND tj.bc='".$this->sd['branch']."' 
        AND dt.nno = '".$_POST['id']."'
        GROUP BY dt.cl,dt.`bc`,dt.`nno` ";
 
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
        if($this->user_permissions->is_delete('t_job_reject')){
            $this->db->where("nno",$_POST['id']);
            $this->db->where("bc",$this->sd['branch']);
            $this->db->where("cl",$this->sd['cl']);
            $this->db->update("t_job_issue", array("is_cancel"=>"1"));

            $sql = "SELECT nno,job_no FROM `t_job_issue_det` where nno= '".$_POST['id']."'";
            $query = $this->db->query($sql);
            foreach ($query->result() as $row) {
                $this->db->where("cl",$this->sd['cl']);
                $this->db->where("bc",$this->sd['branch']);
                $this->db->where("nno",$row->job_no);
                $this->db->update("t_job",array("status"=>"3"));
            }
            
            $this->utility->save_logger("CANCEL",91,$_POST['id'],$this->mod);
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

        $sql = "SELECT 
              ti.`customer` AS cus_id,
              mc.`name`,
              ti.`memo`,
              ti.`ddate`,
              ti.`ref_no`,
              ti.`drn_no`,
              ti.`amount`,
              ti.`advance`,
              ti.`balance`
          FROM 
          t_job_issue ti
          JOIN m_customer mc ON mc.`code`=ti.`customer`
          WHERE ti.cl='".$this->sd['cl']."'
          AND ti.bc='".$this->sd['branch']."'
          AND ti.nno='".$_POST['qno']."' ";

          $r_detail['sum']= $this->db->query($sql)->result();

            $sql1="SELECT
            dt.job_no, 
            tj.`item_code`,
            tj.`Item_name`,
            tj.`ddate` AS r_date,
            tj.`fault`,
            dt.`amount` AS job_amt

        FROM t_job tj
        JOIN t_job_issue_det dt ON dt.`cl`=tj.`cl` AND dt.`bc`=tj.`bc` AND dt.`job_no` AND tj.`nno`
        JOIN t_job_issue ti ON ti.`cl`=dt.`cl` AND ti.`bc`=dt.`bc` AND ti.`nno`= dt.`nno`
        WHERE tj.cl='".$this->sd['cl']."'
        AND tj.bc='".$this->sd['branch']."' 
        AND dt.nno = '".$_POST['qno']."'
        GROUP BY dt.cl,dt.`bc`,dt.`nno` ";
                  
        $r_detail['det']= $this->db->query($sql1)->result();

        $this->load->view($_POST['by'].'_'.'pdf',$r_detail);

    }


}