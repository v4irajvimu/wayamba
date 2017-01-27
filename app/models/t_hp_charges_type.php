<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class t_hp_charges_type extends CI_Model {
    
    private $sd;
    private $mtb;
    private $occ;
   
    
    private $mod = '003';
    
    function __construct(){
	parent::__construct();
	
	  $this->sd = $this->session->all_userdata();
    $this->load->database($this->sd['db'], true);
    $this->mtb = $this->tables->tb['r_hp_chargers_type'];
    $this->load->model('user_permissions');
    $this->occ = $this->sd['oc'];

    }
    public function base_details(){

      $a['table_data'] = $this->data_table();
    return $a;
         
    }

    public function data_table(){
        $this->load->library('table');
        $this->load->library('useclass');
        $this->table->set_template($this->useclass->grid_style());
        $code = array("data"=>"Code", "style"=>"width: 100px; cursor : pointer;", "onclick"=>"set_short(1)");
        $des = array("data"=>"Description", "style"=>"cursor : pointer;width: 200px;", "onclick"=>"set_short(2)");
        $action = array("data"=>"Action", "style"=>"width: 100px;");
        $this->table->set_heading($code, $des,$action);
        
        $this->db->select(array('code', 'description','action_date'));
        $this->db->limit(10);
        $query = $this->db->get($this->mtb);
        foreach($query->result() as $r){
            $but = "<img src='".base_url()."img/edit.gif' onclick='set_edit(\"".$r->code."\")' title='Edit' />&nbsp;&nbsp;";
            if($this->user_permissions->is_delete('t_hp_charges_type')){$but .= "<img src='".base_url()."img/delete.gif' onclick='set_delete(\"".$r->code."\")' title='Delete' />";}
            $ed = array("data"=>$but, "style"=>"text-align: center; width: 100px;");
            
            $dis = array("data"=>$this->useclass->limit_text($r->description, 50), "style"=>"text-align: left; width: 200px;");
            $code = array("data"=>$r->code, "style"=>"text-align: left; width: 100px; ", "value"=>"code");
      
            $this->table->add_row($code, $dis, $ed);
        } 
        
        return $this->table->generate();
    }


    public function save(){
    $this->db->trans_begin();
  
    error_reporting(E_ALL); 
    function exceptionThrower($type, $errMsg, $errFile, $errLine) { 
        throw new Exception($errMsg); 
    }
    set_error_handler('exceptionThrower'); 
    try {
        
    if (isset($_POST['code'], $_POST['des'], $_POST['value'], $_POST['amount'])) {

if ($_POST['code'] != "" && $_POST['des'] != "" && $_POST['value'] != "" && $_POST['amount'] != "" ) {
            
              $t_hp_charges_type = array(
                  "cl" => $this->sd["cl"],
                  "bc" => $this->sd['branch'],
                  "oc"=>$this->occ,   
                  "code" => $_POST['code'],
                  "description" => $_POST['des'],
                  "acc_code" => $_POST['value'],
                  "amount" => $_POST['amount'],

              ); 
        }
          
      }
          
      if($_POST['hid'] == "0" || $_POST['hid'] == ""){
        
        if($this->user_permissions->is_add('t_hp_charges_type')){
        $this->db->insert("r_hp_chargers_type",$t_hp_charges_type);  
        echo $this->db->trans_commit();  
           }else{
                echo "No permission to save records";
                    $this->db->trans_commit();
          }
      }else{
    if($this->user_permissions->is_edit('t_hp_charges_type')){
          $t_hp_charges_type_update = array(
                  "cl" => $this->sd["cl"],
                  "bc" => $this->sd['branch'],
                  "oc"=>$this->occ,   
                  "description" => $_POST['des'],
                  "acc_code" => $_POST['value'],
                  "amount" => $_POST['amount'],

              );
            $this->db->where('cl', $this->sd['cl']);
            $this->db->where("bc", $this->sd['branch']);
            $this->db->where("code", $_POST['code']);
            $this->db->update("r_hp_chargers_type", $t_hp_charges_type_update);    
            echo $this->db->trans_commit();        
          } 

  }
}
  catch(Exception $e){ 
    $this->db->trans_rollback();
    echo  $e->getMessage()." - Operation fail please contact admin"; 
  }     
}

public function get_data_table(){

    echo $this->data_table();
    }

 public function load(){
  $this->db->select(array(
    'r_hp_chargers_type.cl',
    'r_hp_chargers_type.bc',
    'r_hp_chargers_type.code',
    'r_hp_chargers_type.description',
    'r_hp_chargers_type.acc_code',
    'm_account.description as acc_description',
    'r_hp_chargers_type.amount',
    ));

    $this->db->from('r_hp_chargers_type');
    $this->db->join('m_account', 'm_account.code=r_hp_chargers_type.acc_code');
    $this->db->where('r_hp_chargers_type.cl', $this->sd['cl']);
    $this->db->where('r_hp_chargers_type.bc', $this->sd['branch']);
    $this->db->where('r_hp_chargers_type.code', $_POST['id']);
    $query = $this->db->get();


  if ($query->num_rows() > 0) {
        $a['add'] = $query->result();
    } else {
        $a['add'] = 2;
    }
      echo json_encode($a);
  
  }

  public function delete_validation(){
        $status=1;
        $codes=$_POST['id'];
        $check_cancellation = $this->utility->check_account_trans($codes,'Chargers Type','t_hp_chargers_det','t_hp_chargers_det','chg_type');
        if ($check_cancellation != 1) {
          return $check_cancellation;
        }
        return $status;
    }

  public function delete(){

        $this->db->trans_begin();
        error_reporting(E_ALL); 
        function exceptionThrower($type, $errMsg, $errFile, $errLine) { 
            throw new Exception($errMsg); 
        }
       set_error_handler('exceptionThrower'); 
       try { 
        if($this->user_permissions->is_delete('t_hp_charges_type')){
              $delete_validation_status=$this->delete_validation();
                if($delete_validation_status==1){
                  $this->db->where('code', $_POST['id']);
                  $this->db->where('bc',$this->sd['branch']);
                  $this->db->where('cl',$this->sd['cl']);
                  $this->db->limit(1);
                  $this->db->delete($this->mtb);
                  echo $this->db->trans_commit();
                  }
                  else{
                    echo $delete_validation_status;
                    $this->db->trans_commit();
                  }
                  }else{
                echo "No permission to delete records";
                $this->db->trans_commit();
            }
           
        } catch ( Exception $e ) { 
            $this->db->trans_rollback();
            echo "Operation fail please contact admin"; 
        } 
    }
  

}
?>