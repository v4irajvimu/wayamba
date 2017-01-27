<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class r_service_job extends CI_Model {

    function __construct(){
	parent::__construct();
	
	$this->sd = $this->session->all_userdata();
    $this->load->database($this->sd['db'], true);
	$this->mtb = $this->tables->tb['m_employee'];

    }


    public function base_details(){
    	//$this->load->model('m_stores');
    	$this->load->model('m_branch');
    	$a['cluster']=$this->get_cluster_name();
    	//$a['branch']=$this->get_branch_name();
    	//$a['stores']=$this->get_stores();
        $a['d_cl']=$this->sd['cl'];
        $a['d_bc']=$this->sd['branch'];
    	return $a;
	}


	public function get_cluster_name(){
		$sql="  SELECT `code`,description 
                FROM m_cluster m
                JOIN u_branch_to_user u ON u.cl = m.code
                WHERE user_id='".$this->sd['oc']."'
                GROUP BY m.code";
        $query=$this->db->query($sql);

		$s = "<select name='cluster' id='cluster' >";
        $s .= "<option value='0'>---</option>";
        foreach($query->result() as $r){
            $s .= "<option title='".$r->description."' value='".$r->code."'>".$r->code.'-'.$r->description."</option>";
	    }
        $s .= "</select>";
        
        return $s;
    }

    public function get_branch_name(){

    	$cls=$_POST['cl'];
		$this->db->select(array('bc','name'));
		$this->db->where('cl', $cls);
		$query = $this->db->get('m_branch');

		$s = "<select name='branch' id='branch' >";
        $s .= "<option value='0'>---</option>";
        foreach($query->result() as $r){
            $s .= "<option title='".$r->name."' value='".$r->bc."'>".$r->bc.'-'.$r->name."</option>";
	    }
        $s .= "</select>";
        
        echo $s;

    }









}

