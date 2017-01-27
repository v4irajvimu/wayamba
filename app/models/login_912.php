<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class login extends CI_Model {
    private $mtb;
    private $sd;

    function __construct(){
	parent::__construct();
	
	$this->sd = $this->session->all_userdata();
	$this->mtb = $this->tables->tb['m_branch'];

    }
    
    public function base_details(){
	$this->load->model('s_company');
	$a['company'] = $this->s_company->get_company_name();
    $a['branch']=$this->select2();
	$a['cluster']=$this->loder->select();

	return $a;
    }

    public function get_subitem_data(){
	$this->db->where('code', $_POST['cluster']);
	$this->db->limit(1);
	
	echo json_encode($this->db->get($this->mtb)->first_row());
    }


    public function select(){
    	$query = $this->db->get_where($this->mtb,array('cl'=>'C1'));
    
        $s = "<select name='branch' id='company' style='width:180px;box-shadow:1px 1px 4px #000 inset;'>";
       // $s .= "<option value='0'>---</option>";
        foreach($query->result() as $r){
        
		$s .= "<option title='".$r->name."' value='".$r->bc."'>".$r->bc." - ".$r->name."</option>";
        }
        $s .= "</select>";
     $data['result']=$s;
       echo json_encode($data);

    }

    public function select2(){
        $query = $this->db->get_where($this->mtb,array('cl'=>'C1'));
    
        $s = "<select name='branch' id='company' style='width:180px;box-shadow:1px 1px 4px #000 inset;'>";
        foreach($query->result() as $r){
        $s .= "<option title='".$r->name."' value='".$r->bc."'>".$r->bc." - ".$r->name."</option>";
        }
        $s .= "</select>";
return $s;

    }

}