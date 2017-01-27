<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class s_users extends CI_Model {
    
    private $sd;
    private $mtb;
    private $branch;
    
    function __construct(){
		parent::__construct();
		
		$this->sd = $this->session->all_userdata();
		$this->mtb = $this->tables->tb['a_users'];
	    $this->mtbl = $this->tables->tb['s_users'];
	    $this->tb_cal_date = $this->tables->tb['t_interest_cal_date'];
	    $this->branch=$this->tables->tb['m_branch'];
    }
    
    public function base_details(){
		$this->load->model('s_branch');
		$this->load->model('m_stores');
		
		$a['table_data'] = $this->data_table();
		$a['branch'] = $this->s_branch->select();

		//$a['stores_user'] = $this->m_stores->select_user();
		
		return $a;
    }
    
    public function data_table(){
        $this->load->library('table');
        $this->load->library('useclass');
        
        $this->table->set_template($this->useclass->grid_style());
        
        $code = array("data"=>"Code", "style"=>"width: 50px;");
        $name = array("data"=>"User Name", "style"=>"width: 150px;");
        $address = array("data"=>"Description", "style"=>"");
        $action = array("data"=>"Action", "style"=>"width: 60px;");
        
        $this->table->set_heading($code, $name, $address, $action);//, $phone
        
        $this->db->select(array('cCode', 'loginName', 'discription', 'isAdmin'));
        $query = $this->db->get($this->mtb);
        
        foreach($query->result() as $r){
            $but = "<img src='".base_url()."img/edit.gif' onclick='set_edit(\"".$r->cCode."\")' title='Edit' />&nbsp;&nbsp;";
            $but .= "<img src='".base_url()."img/delete.gif' onclick='set_delete(\"".$r->cCode."\")' title='Delete' />";
            
            $code = array("data"=>$r->cCode, "value"=>"code");
            $name = array("data"=>$this->useclass->limit_text($r->loginName, 25));
            $address = array("data"=>$r->discription);
            //$phone = array("data"=>$this->useclass->limit_text($r->phone01.", ".$r->phone02.", ".$r->phone03, 20));
            $action = array("data"=>$but, "style"=>"text-align: center;");
	    
            $this->table->add_row($code, $name, $address, $action);//, $phone
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
			if(! isset($_POST['isAdmin'])){ $_POST['isAdmin'] = 0; }
			$_POST['userPassword'] = md5($_POST['userPassword']);
			
			if($_POST['code_'] == "0" || $_POST['code_'] == ""){
				unset($_POST['code_']);
				$this->db->insert($this->mtb, $_POST);
			}else{
				$this->db->where("cCode", $_POST['code_']);
				unset($_POST['code_']);
				$this->db->update($this->mtb, $_POST);
			}
			echo $this->db->trans_commit();
			redirect(base_url()."?action=s_users");
		}catch(Exception $e){ 
            $this->db->trans_rollback();
            echo"<script>alert('Operation fail please contact admin');history.go(-1);</script>";
        } 	
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
    
    public function check_code(){
	$this->db->where('cCode', $_POST['code']);
	$this->db->limit(1);
	
	echo $this->db->get($this->mtb)->num_rows;
    }
    
    public function load(){
	$this->db->where('cCode', $_POST['code']);
	$this->db->limit(1);
	
	echo json_encode($this->db->get($this->mtb)->first_row());
    }
    
    public function delete(){
    	$this->db->trans_begin();
		error_reporting(E_ALL); 
		function exceptionThrower($type, $errMsg, $errFile, $errLine) { 
		    throw new Exception($errMsg); 
		}
		set_error_handler('exceptionThrower'); 
		try {
			$this->db->where('cCode', $_POST['code']);
			$this->db->limit(1);
			$this->db->delete($this->mtb);
			echo $this->db->trans_commit();
		}catch(Exception $e){ 
            $this->db->trans_rollback();
            echo "Operation fail please contact admin"; 
        }	
    }
    
    public function authenticate(){
	$this->load->database('seetha', true);

	$qury="SELECT * FROM ".$this->branch." WHERE cl =".$this->db->escape($_POST['cluster'])."
	AND bc=".$this->db->escape($_POST['company'])." LIMIT 1";

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
	    $query = "SELECT *
	    		  FROM s_users s JOIN 
                (SELECT user_id, cl, bc, is_active, from_date, to_date FROM u_branch_to_user) u
                ON s.ccode = u.user_id
			    WHERE `loginName` = ".$this->db->escape($_POST['userName'])."
			    AND `userPassword` = md5(".$this->db->escape($_POST['userPassword']).")
			    AND ((u.from_date <= '$ddate' AND u.to_date >= '$ddate')
                    OR (u.from_date='0000-00-00' AND u.to_date='0000-00-00'))
			    LIMIT 1 ";
	    
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

		$sql="SELECT IFNULL(MAX(ddate),'1990-01-01') AS ddate 
				FROM `t_day_end`
				WHERE cl='C1' AND bc='".$_POST['company']."'";
		$query = $this->db->query($sql);
		if($query->num_rows()>0){
			$last_day_end = $query->first_row()->ddate;
		}else{
			$last_day_end = '1990-01-01';
		}
		
		$session_data = array(
		    "is_login"=>true,
		    "isAdmin"=>$r->isAdmin,
		    "oc"=>$r->cCode,
		    "user_des"=>$r->discription,
		    "bc"=>$r->bc,
		    "is_reg"=>true,
		    "name"=>$r->loginName,
            "date"=>$_POST['date'],
            "cl"=>'C1',
            "branch"=>$_POST['company'],
            "day_end"=>$last_day_end,
            "delete_day"=>date("Y-m-d")

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
    
        public function check_previous_process_login()
     {
        $date = isset($this->sd['date']) ? $this->sd['date'] : date('Y-m-d');
        $previous_date = date('Y-m-d', strtotime($date .' -1 day'));
        
        $sql="SELECT `date` FROM $this->tb_cal_date WHERE `date`='$previous_date'";
        //echo $sql;exit;
        
        $qry=$this->db->query($sql);
        $r=$qry->first_row();
        
        if(empty($r->date))
        {
            $session_data = array(
		    "is_process"=>false,
		    "prv_date"=>$previous_date
	    );
            $this->session->set_userdata($session_data);
         	
	}
        else
        {
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
	$this->db->where('cCode', $this->sd['oc']);
	
	return $this->db->get($this->mtb)->first_row();
    }




}