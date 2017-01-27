<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class s_users extends CI_Model {

    private $sd;
    private $mtb;
    private $branch;
    private $mod = '003';
    
    function __construct(){
      parent::__construct();
      $this->sd          = $this->session->all_userdata();
      $this->mtb         = $this->tables->tb['a_users'];
      $this->mtbl        = $this->tables->tb['s_users'];
      $this->tb_cal_date = $this->tables->tb['t_interest_cal_date'];
      $this->branch      =$this->tables->tb['m_branch'];
      $this->load->model("utility");
  }

  public function base_details(){
      $a['table_data'] = $this->data_table();
      $a['branch']     = $this->select();
      $a['cluster']    = $this->select_cluster();
      $a['use_pos']=$this->get_def_options();
      return $a;
  }

  public function data_table(){
    $this->load->library('table');
    $this->load->library('useclass');

    $this->table->set_template($this->useclass->grid_style());

    $code = array("data"=>"Code", "style"=>"width: 100px;");
    $name = array("data"=>"User Name", "style"=>"width: 150px;");
    $address = array("data"=>"Description", "style"=>"");
    $action = array("data"=>"Action", "style"=>"width: 100px;");

        $this->table->set_heading($code, $name, $address, $action);//, $phone
        
        $this->db->select(array('cCode', 'loginName', 'discription', 'isAdmin'));
        $query = $this->db->get($this->mtb);
        
        foreach($query->result() as $r){
            $but = "<img src='".base_url()."img/edit.gif' onclick='set_edit(\"".$r->cCode."\")' title='Edit' />&nbsp;&nbsp;";
            if($this->user_permissions->is_delete('s_users')){$but .= "<img src='".base_url()."img/delete.gif' onclick='set_delete(\"".$r->cCode."\")' title='Delete' />";}
            $code = array("data"=>$r->cCode, "value"=>"code");
            $name = array("data"=>$this->useclass->limit_text($r->loginName, 25));
            $address = array("data"=>$r->discription);
            $action = array("data"=>$but, "style"=>"text-align: center;");
            $this->table->add_row($code, $name, $address, $action);//, $phone
        }
        return $this->table->generate();
    }
    
    public function save(){
        $this->load->model('user_permissions');
        $this->db->trans_begin();
        error_reporting(E_ALL); 
        function exceptionThrower($type, $errMsg, $errFile, $errLine) { 
          throw new Exception($errMsg); 
      }
      set_error_handler('exceptionThrower'); 
      try { 
         if(! isset($_POST['isAdmin'])){ $_POST['isAdmin'] = 0; }
         $_POST['userPassword'] = md5($_POST['userPassword']);
         if(! isset($_POST['is_use_pos'])){ $_POST['is_use_pos'] = 0; }

         if($_POST['code_'] == "0" || $_POST['code_'] == ""){
            if($this->user_permissions->is_add('s_users')){
                unset($_POST['code_']);
                $this->db->insert($this->mtb, $_POST);
                $this->utility->save_logger("SAVE",41,$_POST['cCode'],$this->mod);
                echo $this->db->trans_commit();
            }else{
                echo "No permission to save records";
                $this->db->trans_commit();
            }
        }else{
            if($this->user_permissions->is_edit('s_users')){
                $this->db->where("cCode", $_POST['code_']);
                unset($_POST['code_']);
                $this->db->update($this->mtb, $_POST);
                $this->utility->save_logger("UPDATE",41,$_POST['cCode'],$this->mod);
                echo $this->db->trans_commit();
            }else{
                echo "No permission to edit records";
                $this->db->trans_commit();
            }
        }
    }catch(Exception $e){ 
        $this->db->trans_rollback();
        echo $e->getMessage()."Operation fail please contact admin";
    } 	
}

public function select_branch(){
   $this->db->where('cl',$_POST['code']);
   $query = $this->db->get('m_branch');

   $s = "<select name='bc' id='bc'>";
   $s .= "<option value='0'>---</option>";
   foreach($query->result() as $r){
    $s .= "<option title='".$r->name."' value='".$r->bc."'>".$r->name."</option>";
}
$s .= "</select>";

echo $s;
}

public function select_cluster(){

    $query = $this->db->get('m_cluster');

    $s = "<select name='cl' id='cl'>";
    $s .= "<option value='0'>---</option>";
    foreach($query->result() as $r){
        $s .= "<option title='".$r->description."' value='".$r->code."'>".$r->description."</option>";
    }
    $s .= "</select>";

    return $s;
}

public function check_code(){
	$this->db->where('cCode', $_POST['code']);
	$this->db->limit(1);
	
	echo $this->db->get($this->mtb)->num_rows;
}

public function load(){
   $this->db->select(array(           
    's_users.cl',
    's_users.bc',
    's_users.cCode',
    's_users.loginName',
    's_users.discription',
    's_users.userPassword',
    's_users.isAdmin',
    's_users.permission',
    'm_branch.name',
    's_users.is_use_pos',
    's_users.acc_code',
    'm_account.description AS account_name' 

    ));
   $this->db->from($this->mtb);
   $this->db->join('m_branch', 's_users.bc=m_branch.bc');
   $this->db->join('m_account','m_account.code=s_users.acc_code','left');
   $this->db->where('cCode', $_POST['code']);
   $this->db->limit(1);

   echo json_encode($this->db->get()->first_row());
}

public function delete(){
    $this->load->model('user_permissions');
    $this->db->trans_begin();
    error_reporting(E_ALL); 
    function exceptionThrower($type, $errMsg, $errFile, $errLine) { 
      throw new Exception($errMsg); 
  }
  set_error_handler('exceptionThrower'); 
  try {
    if($this->user_permissions->is_delete('s_users')){
     $this->db->where('cCode', $_POST['code']);
     $this->db->limit(1);
     $this->db->delete($this->mtb);
     $this->utility->save_logger("DELETE",41,$_POST['code'],$this->mod);
     echo $this->db->trans_commit();
 }else{
    echo "No permission to delete records";
    $this->db->trans_commit();
}
}catch(Exception $e){ 
    $this->db->trans_rollback();
    echo "Operation fail please contact admin"; 
}	
}

public function authenticate(){
    $this->load->database('seetha', true);
    $qury="SELECT * FROM ".$this->branch." LIMIT 1";
    $rslt=$this->db->query($qury);
    
    if($rslt->num_rows>0){
        $this->db->select(array('code', 'db_name'));
        $this->db->where('code', '001');
        $query = $this->db->get('db');

        if($query->num_rows){
            $r = $query->first_row();
            $this->session->set_userdata(array('db_code'=>$r->code, 'db'=>$r->db_name));
            $this->load->database($r->db_name, true);

            $ddate=date("Y-m-d");
            $query="SELECT s.cCode, s.isAdmin, s.discription, s.`loginName`, s.`userPassword`
            FROM s_users s 
            WHERE s.`loginName`='".$_POST['userName']."' 
            AND `userPassword` = md5(".$this->db->escape($_POST['userPassword']).")                
            AND s.`isAdmin`='1' 
            LIMIT 1 
            ";

            $result = $this->db->query($query);

            if($result->num_rows){
                $r = $result->first_row();
                $a = array(
                    "oc"=>$r->cCode,
                    "last_login"=>time(),
                    "last_active"=>time()
                    );

                $this->db->where("oc", $r->cCode);
                $this->db->delete($this->tables->tb['a_log_users']);
                $this->db->insert($this->tables->tb['a_log_users'], $a);

                $session_data = array(
                    "up_is_login"=>true,
                    "up_oc"=>$r->cCode,
                    "up_isAdmin"=>$r->isAdmin,
                    "up_user_des"=>$r->discription,
                    "up_bc"=>"B1",
                    "up_cl"=>"C1",
                    "up_branch"=>"B1"
                    );

                $this->session->set_userdata($session_data);
                return 1;
            }else{
                return 0;
            }
        }else{
            return 2;
        }
    }
}


public function check_previous_process_login(){
    $date = isset($this->sd['date']) ? $this->sd['date'] : date('Y-m-d');
    $previous_date = date('Y-m-d', strtotime($date .' -1 day'));

    $sql="SELECT `date` FROM $this->tb_cal_date WHERE `date`='$previous_date'";

    $qry=$this->db->query($sql);
    $r=$qry->first_row();

    if(empty($r->date)){
        $session_data = array(
          "is_process"=>false,
          "prv_date"=>$previous_date
          );
        $this->session->set_userdata($session_data);

    }else{
        $session_data = array(
           "is_process"=>true ,
           "prv_date"=>""
           );
        $this->session->set_userdata($session_data);
    }    
    return 1;

}


public function get_log_user(){
	$this->db->limit(1);
	$this->db->where('cCode', $this->sd['up_oc']);
	
	return $this->db->get($this->mtb)->first_row();
}

public function select(){

    $query = $this->db->get($this->mtbl);     
    $s = "<select name='loginName' id='user'>";
    $s .= "<option value='0'>---</option>";
    foreach($query->result() as $r){
        $s .= "<option title='".$r->loginName."' value='".$r->cCode."'>".$r->loginName."</option>";
    }
    $s .= "</select>";
    return $s;
}

public function get_def_options(){

    $this->db->select(array('def_use_pos'));
    return $this->db->get('def_option_sales')->first_row()->def_use_pos;

}


}