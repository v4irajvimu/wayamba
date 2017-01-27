<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class m_person extends CI_Model {
    
    private $sd;
    private $mtb;
    
    function __construct(){
	parent::__construct();
	
	$this->sd = $this->session->all_userdata();
	$this->load->database($this->sd['db'], true);
	
	$this->mtb = $this->tables->tb['m_person'];
    }
    
    public function base_details(){
	$a['table_data'] = $this->data_table();
	
	return $a;
    }
    
        function max_person()
    {
        if($_POST['acc_type']=='1')
        {
            $sql="SELECT MAX(RIGHT(`code`,3)) AS max_no  FROM `m_person` WHERE `type`='".$_POST['acc_type']."'";
            
            $query = $this->db->query($sql);
            $r = $query->result();
            foreach ($r as $v)
            {
                $no=$v->max_no;
                
            }
            $no++;
        
            if(($no)<10)$r[0]="000".$no;
            if(($no)<100)$r[0]="00".$no;
            elseif(($no)<1000)$r[0]="0".$no;
            
            echo json_encode($r[0]);
            
        }
        if($_POST['acc_type']=='2')
        {
            $sql="SELECT MAX(RIGHT(`code`,3)) AS max_no  FROM `m_person` WHERE `type`='".$_POST['acc_type']."'";
            
            $query = $this->db->query($sql);
            $r = $query->result();
            foreach ($r as $v)
            {
                $no=$v->max_no;
                
            }
            $no++;
        
            if(($no)<10)$r[0]="000".$no;
            if(($no)<100)$r[0]="00".$no;
            elseif(($no)<1000)$r[0]="0".$no;
            
            echo json_encode($r[0]);
            
        }
        if($_POST['acc_type']=='3')
        {
            $sql="SELECT MAX(RIGHT(`code`,3)) AS max_no  FROM `m_person` WHERE `type`='".$_POST['acc_type']."'";
            
            $query = $this->db->query($sql);
            $r = $query->result();
            foreach ($r as $v)
            {
                $no=$v->max_no;
                
            }
            $no++;
        
            if(($no)<10)$r[0]="000".$no;
            if(($no)<100)$r[0]="00".$no;
            elseif(($no)<1000)$r[0]="0".$no;
            
            echo json_encode($r[0]);
            
        }


    }

    public function data_table(){
        $this->load->library('table');
        $this->load->library('useclass');
        
        $this->table->set_template($this->useclass->grid_style());
        
        $code = array("data"=>"Code", "style"=>"width: 50px;");
        $name = array("data"=>"Name", "style"=>"");
        $address = array("data"=>"Address", "style"=>"width: 100px;");
        $phone = array("data"=>"Phones", "style"=>"width: 100px;");
        $action = array("data"=>"Action", "style"=>"width: 60px;");
        
        $this->table->set_heading($code, $name, $address, $phone, $action);
        
        $this->db->select(array('code', 'name', 'address01', 'address02', 'address03', 'phone01', 'phone02', 'phone03'));
        $query = $this->db->get($this->mtb);
        
        foreach($query->result() as $r){
            $but = "<img src='".base_url()."img/edit.gif' onclick='set_edit(\"".$r->code."\")' title='Edit' />&nbsp;&nbsp;";
            $but .= "<img src='".base_url()."img/delete.gif' onclick='set_delete(\"".$r->code."\")' title='Delete' />";
            
            $code = array("data"=>$r->code);
            $name = array("data"=>$this->useclass->limit_text($r->name, 25));
            $address = array("data"=>$this->useclass->limit_text($r->address01." ".$r->address02." ".$r->address03, 17));
            $phone = array("data"=>$this->useclass->limit_text($r->phone01.", ".$r->phone02.", ".$r->phone03, 17));
            $action = array("data"=>$but, "style"=>"text-align: center;");
        
            $this->table->add_row($code, $name, $address, $phone, $action);
        }
        
        return $this->table->generate();
    }
    
    public function save(){
	
	if($_POST['phone01'] == "Mobile"){ $_POST['phone01'] = ""; }
	if($_POST['phone02'] == "Office"){ $_POST['phone02'] = ""; }
	if($_POST['phone03'] == "Fax"){ $_POST['phone03'] = ""; }
	
	if($_POST['address01'] == "No"){ $_POST['address01'] = ""; }
	if($_POST['address02'] == "Street"){ $_POST['address02'] = ""; }
	if($_POST['address03'] == "City"){ $_POST['address03'] = ""; }
	
        if($_POST['code_'] == "0" || $_POST['code_'] == ""){
            unset($_POST['code_']);
            $this->db->insert($this->mtb, $_POST);
        }else{
            $this->db->where("code", $_POST['code_']);
            unset($_POST['code_']);
            $this->db->update($this->mtb, $_POST);
        }
	
	redirect(base_url()."?action=m_person");
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
        
  
        $sql = "SELECT * from m_person where type='3'";
        $query = $this->db->query($sql);
        
        $s = "<select name='trans_codi' id='trans_codi'>";
        $s .= "<option value='0'>---</option>";
        foreach($query->result() as $r){
            $s .= "<option title='".$r->name."' value='".$r->code."'>".$r->code."</option>";
        }
        $s .= "</select>";
        
        return $s;
    }
    public function select1(){
        
  
        $sql = "SELECT * from m_person where type='1'";
        $query = $this->db->query($sql);
        
        $s = "<select name='mar_codi' id='mar_codi'>";
        $s .= "<option value='0'>---</option>";
        foreach($query->result() as $r){
            $s .= "<option title='".$r->name."' value='".$r->code."'>".$r->code."</option>";
        }
        $s .= "</select>";
        
        return $s;
    }
    public function select2(){
        
  
        $sql = "SELECT * from m_person where type='2'";
        $query = $this->db->query($sql);
        
        $s = "<select name='driver' id='driver'>";
        $s .= "<option value='0'>---</option>";
        foreach($query->result() as $r){
            $s .= "<option title='".$r->name."' value='".$r->code."'>".$r->code."</option>";
        }
        $s .= "</select>";
        
        return $s;
    }
    
    
}