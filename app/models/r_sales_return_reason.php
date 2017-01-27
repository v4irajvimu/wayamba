<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class r_sales_return_reason extends CI_Model {

    private $sd;
    private $mtb;
    private $mod = '018';
    
    function __construct(){
	parent::__construct();
	
	$this->sd = $this->session->all_userdata();
    $this->load->database($this->sd['db'], true);
	
	$this->mtb = $this->tables->tb['r_sales_return_reason'];
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
        $des = array("data"=>"Description", "style"=>"cursor : pointer;", "onclick"=>"set_short(2)");
        $dt = array("data"=>"Date/Time", "style"=>"width: 150px;");
        $action = array("data"=>"Action", "style"=>"width: 100px;");
	
        $this->table->set_heading($code, $des, $action);
        
        $this->db->select(array('action_date', 'description', 'code'));
        $this->db->limit(10);
        $query = $this->db->get($this->mtb);
        
        foreach($query->result() as $r){
            $but = "<img src='".base_url()."img/edit.gif' onclick='set_edit(\"".$r->code."\")' title='Edit' />&nbsp;&nbsp;";
            $but .= "<img src='".base_url()."img/delete.gif' onclick='set_delete(\"".$r->code."\")' title='Delete' />";
            $ed = array("data"=>$but, "style"=>"text-align: center; width: 108px;");
            $dt = array("data"=>$r->action_date, "style"=>"text-align: center;  width: 158px;");
            $dis = array("data"=>$this->useclass->limit_text($r->description, 50), "style"=>"text-align: left;");
            $code = array("data"=>$r->code, "style"=>"text-align: left; width: 108px; ", "value"=>"code");
	    
            $this->table->add_row($code, $dis, $ed);
        }
        
        return $this->table->generate();
    }
    
    public function get_data_table(){
    echo $this->data_table();
    }
    
    public function save(){
        $_POST['oc']=$this->sd['oc'];
        $_POST['code']=strtoupper($_POST['code']);
        if($_POST['code_'] == "0" || $_POST['code_'] == ""){
	   
		unset($_POST['code_']);
		$arr=array(
			"code"=>$_POST['code'],
			"description"=>$_POST['description'],
			"oc"=>$this->sd['oc'],
			"action_date"=>date("Y-m-d")
		);
		echo $this->db->insert($this->mtb,$arr);
	  
        }else{
			
			$this->db->where("code", $_POST['code_']);
			unset($_POST['code_']);
			echo $this->db->update($this->mtb, $_POST);
			
        } 
    }
    
    public function check_code(){
	$this->db->where('code', $_POST['code']);
	$this->db->limit(1);
	
	echo $this->db->get($this->mtb)->num_rows;
    }
    
    public function load(){
	$this->db->where('code', $_POST['code']);
	$this->db->limit(1);
	
	echo json_encode($this->db->get($this->mtb)->first_row());
    }
    
   public function delete(){
	    $this->db->where('code', $_POST['code']);
	    $this->db->limit(1);
	    
	    echo $this->db->delete($this->mtb);
	
    }
    
    public function select(){
        $query = $this->db->get($this->mtb);
        
        $s = "<select name='brand' id='brand'>";
        $s .= "<option value='0'>---</option>";
        foreach($query->result() as $r){
            $s .= "<option title='".$r->description."' value='".$r->code."'>".$r->code.'-'.$r->description."</option>";
        }
        $s .= "</select>";
        
        return $s;
    }

     public function auto_com(){
        $this->db->like('code', $_GET['q']);
        $this->db->or_like($this->mtb.'.description', $_GET['q']);
        $query = $this->db->select(array('code', $this->mtb.'.description'))->get($this->mtb);
        $abc = "";
            foreach($query->result() as $r){
                $abc .= $r->code."|".$r->description;
            $abc .= "\n";
            }
        
        echo $abc;
        }  


    public function auto_com2(){
        $this->db->like('code', $_GET['q']);
        $this->db->or_like('description', $_GET['q']);
        $query = $this->db->select(array('code','description'))->get("r_sales_return_reason");
        $abc = "";
        foreach($query->result() as $r){
            $abc .= $r->code."|".ucwords(strtolower($r->description));
            $abc .= "\n";
        }
        echo $abc;
    }  
}