<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class r_customer_action extends CI_Model {
    
    private $sd;
    private $mtb;
   
	
    function __construct(){
	parent::__construct();
    	$this->sd = $this->session->all_userdata();
    	$this->load->database($this->sd['db'], true);
        $this->load->model('user_permissions');
    }
    
    public function base_details(){
    	$a['table_data'] = $this->data_table();
        $a['max_no'] = $this->utility->is_auto_genarate("r_customer_action","max_no","1","2");
    	return $a;
    }
    
    public function data_table(){
        $this->load->library('table');
        $this->load->library('useclass');
        $this->table->set_template($this->useclass->grid_style());
        $code = array("data"=>"Code", "style"=>"width: 100px; cursor : pointer;", "onclick"=>"set_short(1)");
        $des = array("data"=>"Description", "style"=>"cursor : pointer;width: 200px;", "onclick"=>"set_short(2)");
        $dt = array("data"=>"Privi.Rate", "style"=>"width: 100px;");
        $action = array("data"=>"Action", "style"=>"width: 100px;");
        $this->table->set_heading($code, $des,$dt,$action);
        
        $this->db->select(array('code', 'description', 'action_date'));
        $this->db->limit(10);
        $query = $this->db->get('r_customer_action');
        foreach($query->result() as $r){
            $but = "<img src='".base_url()."img/edit.gif' onclick='set_edit(\"".$r->code."\")' title='Edit' />&nbsp;&nbsp;";
            if($this->user_permissions->is_delete('r_customer_action')){$but .= "<img src='".base_url()."img/delete.gif' onclick='set_delete(\"".$r->code."\")' title='Delete' />";}
            $ed = array("data"=>$but, "style"=>"text-align: center; width: 100px;");
            
            $dis = array("data"=>$this->useclass->limit_text($r->description, 50), "style"=>"text-align: left; width: 200px;");
            $code = array("data"=>$r->code, "style"=>"text-align: left; width: 100px; ", "value"=>"code");
            $this->table->add_row($code, $dis,$ed);
        } 
        
        return $this->table->generate();
    }
    
    public function check_exist($root){
	$this->db->select('code');
	$this->db->where('description', $root);
	$this->db->or_where('code', $root);
	$this->db->limit(1);
	$query = $this->db->get('r_customer_action');
	
	if($query->num_rows){
	    return $query->first_row()->code;
	}else{
	    return false;
	}
    }
   

    public function save(){  

        $this->db->trans_begin();
        error_reporting(E_ALL); 
        function exceptionThrower($type, $errMsg, $errFile, $errLine) { 
            throw new Exception($errMsg); 
        }
        set_error_handler('exceptionThrower'); 
        try { 
            $_POST['oc']=$this->sd['oc'];
            $_POST['code'] = strtoupper($_POST['code']);
            $_POST['code_gen'] = strtoupper($_POST['code_gen']);

            if($_POST['code_'] == "0" || $_POST['code_'] == ""){
                if($this->user_permissions->is_add('r_customer_action')){
            		$insert_values=array(
            			"code"=>$_POST['code'],
            			"description"=>$_POST['description'],
                        "code_gen"=>$_POST['code'],
            			"oc"=>$this->sd['oc'],
                        "max_no"=>$this->utility->max_nno("r_customer_action","max_no")
            		);
            		$this->db->insert('r_customer_action', $insert_values);
                    echo $this->db->trans_commit();
                }else{
                    echo "No permission to save records";
                    $this->db->trans_commit();
                }
    	  
            }else{
                if($this->user_permissions->is_edit('r_customer_action')){
            		$this->db->where("code", $_POST['code_']);
                    $update_values=array(
                        "code"=>$_POST['code_'],
                        "description"=>$_POST['description'],
                        "code_gen"=>$_POST['code_'],
                        "oc"=>$this->sd['oc'],
                        "max_no"=>$this->utility->max_nno("r_customer_action","max_no")
                    );
            		$this->db->update('r_customer_action', $update_values);
                    echo $this->db->trans_commit();
                }else{
                    echo "No permission to edit records";
                    $this->db->trans_commit();
                }
            }
        } catch ( Exception $e ) { 
            $this->db->trans_rollback();
            echo "Operation fail please contact admin"; 
        } 
    }

	public function get_data_table(){
    echo $this->data_table();
    }
 
    public function check_code(){
	$this->db->where('code', $_POST['code']);
	$this->db->limit(1);
	echo $this->db->get('r_customer_action')->num_rows;
    }
    
    public function load(){
	$this->db->where('code', $_POST['code']);
	$this->db->limit(1);
	echo json_encode($this->db->get('r_customer_action')->first_row());
    }

    public function delete_validation(){
        $status=1;
        $codes=$_POST['code'];
        $check_cancellation = $this->utility->check_account_trans($codes,'Customer Action','r_customer_action','m_customer_inquiries','action');
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
            if($this->user_permissions->is_delete('r_customer_action')){
                $delete_validation_status=$this->delete_validation();
                if($delete_validation_status==1){
                	$this->db->where('code', $_POST['code']);
                	$this->db->limit(1);
                	$this->db->delete('r_customer_action');
                    echo $this->db->trans_commit();
                }else{
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