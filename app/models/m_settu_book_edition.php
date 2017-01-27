<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class m_settu_book_edition extends CI_Model {
    
    private $sd;
    private $mtb;
    
    private $mod = '003';
    
    function __construct(){
    parent::__construct();
    
    $this->sd = $this->session->all_userdata();
    $this->load->database($this->sd['db'], true);
    $this->load->model('user_permissions');
    
    }
    
    public function base_details(){
    $a['table_data'] = $this->get_data_table();
    return $a;
    }

    
    
    public function data_table(){
        $this->load->library('table');
        $this->load->library('useclass');
        
        $this->table->set_template($this->useclass->grid_style());
        $nno = array("data"=>"Code", "style"=>"width: 60px; cursor : pointer;");
        $employee_id = array("data"=>"Description", "style"=>"cursor : pointer;");
        $is_active = array("data"=>"Active", "style"=>"cursor : pointer;");
        $action = array("data"=>"Action", "style"=>"width: 60px;");
    
        $this->table->set_heading($nno,$employee_id,$is_active,$action);//
       
        $sql = "SELECT * FROM m_settu_book_edition
                Limit 15";
        $query = $this->db->query($sql);
        
        foreach($query->result() as $r){
            $but = "<img src='".base_url()."img/edit.gif' onclick='set_edit(\"".$r->code."\")' title='Edit' />&nbsp;&nbsp;";
            if($this->user_permissions->is_delete('m_settu_book_edition')){$but .= "<img src='".base_url()."img/delete.gif' onclick='set_delete(\"".$r->code."\")' title='Delete' />";}
            $ed = array("data"=>$but, "style"=>"text-align: center; width: 68px;");
            $nno = array("data"=>$this->useclass->limit_text($r->code, 20), "style"=>"text-align: left;  width: 50px;");
            $emp = array("data"=>$this->useclass->limit_text($r->description, 20), "style"=>"text-align: left;  width: 300px;");
            if($r->is_active=="1"){
                $active = "<img src='".base_url()."img/tick.png' title='Active' style='width:15px;height:15px;margin-left:15px;'/>&nbsp;&nbsp;";
            }else{
                $active = "<img src='".base_url()."img/no.png' title='Inactive' style='width:15px;height:15px;margin-left:15px;'/>&nbsp;&nbsp;";
            }
            
            $this->table->add_row($nno,$emp,$active,$ed);//
        } 
        return $this->table->generate();
    }
    
    public function validation(){
        $status=1;
        return $status;
    }

    public function check_emp($emp,$cat){
        $status=1;
        $sql="SELECT * 
              FROM m_settu_book_edition
              WHERE employee_id ='$emp' AND category='$cat'";

        $query=$this->db->query($sql);

        if($query->num_rows()>0){
            $status="Employee No '$emp' already in category id '$cat'";
        }
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
            $validation = $this->validation();
            if($validation==1){
                if(isset($_POST['is_active'])){
                    $active="1";
                }else{
                    $active="0";
                }
                $data_arr=array(
                    'code'          => $_POST['codes'],
                    'description'   => $_POST['des'], 
                    'note'          => $_POST['note'],
                    'is_active'     => $active, 
                    'oc'            => $this->sd['oc'] 

                );
                if($_POST['code_']=="0"||$_POST['code_']==""){  
                    if($this->user_permissions->is_add('m_settu_book_edition')){
                        $this->db->insert('m_settu_book_edition', $data_arr);
                        echo $this->db->trans_commit();
                    }else{
                        echo "No permission to save records";
                        $this->db->trans_commit();
                    }  
                }else{
                    if($this->user_permissions->is_edit('m_settu_book_edition')){
                        $this->db->where("code", $_POST['code_']);
                        $this->db->update('m_settu_book_edition',$data_arr);
                        echo $this->db->trans_commit();
                    }else{
                        echo "No permission to update records";
                        $this->db->trans_commit();
                    }  
                }
            }else{
                echo $validation;
                $this->db->trans_commit();
            }
        }catch(Exception $e){ 
            $this->db->trans_rollback();
            echo $e->getMessage()."Operation fail please contact admin"; 
        } 
    }
    
    public function check_code(){
        $this->db->where('code', $_POST['code']);
        $this->db->limit(1);
        echo $this->db->get('m_settu_book_edition')->num_rows;
    }

    public function load(){

        $nno=$_POST['code'];    
        $sql="SELECT *
              FROM m_settu_book_edition a
              WHERE a.code ='$nno'";    

        $query=$this->db->query($sql);
           
        if($query->num_rows()>0){
          $a=$query->result();
        }else{
          $a=2;
        }
        echo json_encode($a);
    } 

    public function get_data_table(){
    return $this->data_table();
    }

    public function delete(){
        $this->db->trans_begin();
        error_reporting(E_ALL); 
        function exceptionThrower($type, $errMsg, $errFile, $errLine) { 
            throw new Exception($errMsg); 
        }
        set_error_handler('exceptionThrower'); 
        try {
            if($this->user_permissions->is_delete('m_settu_book_edition')){
                $this->db->where('code', $_POST['code']);
                $this->db->delete("m_settu_book_edition");     
                echo $this->db->trans_commit();
            }else{
                $this->db->trans_commit();
                echo "No permission to delete records";
            }
        }catch(Exception $e){ 
            $this->db->trans_rollback();
            echo $e->getMessage()."Operation fail please contact admin"; 
        }  
    }

    public function search_result(){
        $this->load->library('table');
        $this->load->library('useclass');
        
        $this->table->set_template($this->useclass->grid_style());
        $nno = array("data"=>"No", "style"=>"width: 60px; cursor : pointer;");
        $employee_id = array("data"=>"Employee", "style"=>"cursor : pointer;");
        $is_active = array("data"=>"Active", "style"=>"cursor : pointer;");
        $action = array("data"=>"Action", "style"=>"width: 60px;");
    
        $this->table->set_heading($nno,$employee_id,$is_active,$action);//
       
        $sql = "SELECT * FROM m_settu_book_edition
                WHERE code LIKE '%".$_POST['code']."%' OR description LIKE  '%".$_POST['code']."%'
                Limit 15";
        $query = $this->db->query($sql);
        
        foreach($query->result() as $r){
            $but = "<img src='".base_url()."img/edit.gif' onclick='set_edit(\"".$r->code."\")' title='Edit' />&nbsp;&nbsp;";
            if($this->user_permissions->is_delete('m_settu_book_edition')){$but .= "<img src='".base_url()."img/delete.gif' onclick='set_delete(\"".$r->code."\")' title='Delete' />";}
            $ed = array("data"=>$but, "style"=>"text-align: center; width: 68px;");
            $nno = array("data"=>$this->useclass->limit_text($r->code, 20), "style"=>"text-align: left;  width: 50px;");
            $emp = array("data"=>$this->useclass->limit_text($r->description, 20), "style"=>"text-align: left;  width: 300px;");
            if($r->is_active=="1"){
                $active = "<img src='".base_url()."img/tick.png' title='Active' style='width:15px;height:15px;margin-left:15px;'/>&nbsp;&nbsp;";
            }else{
                $active = "<img src='".base_url()."img/no.png' title='Inactive' style='width:15px;height:15px;margin-left:15px;'/>&nbsp;&nbsp;";
            }
            
            $this->table->add_row($nno,$emp,$active,$ed);//
        } 
        echo $this->table->generate();
    }

    public function check_category($cat){
        $status=1;
        $sql="SELECT COUNT(code) as no
              FROM m_employee_category
              WHERE CODE='$cat'";

        $query=$this->db->query($sql);

        if($query->row()->no==0){
            $status="Please Enter Valid Employee Category";
        }
        return $status;
    }
}