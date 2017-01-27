<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class m_employee_list extends CI_Model {
    
    private $sd;
    private $mtb;
    
    private $mod = '003';
    
    function __construct(){
    parent::__construct();
    
    $this->sd = $this->session->all_userdata();
    $this->load->database($this->sd['db'], true);
   // $this->mtb = $this->tables->tb['m_employee'];
    
    }

 public function PDF_report(){

    $this->db->select(array('name','address','tp','fax','email'));
    $this->db->where("cl",$this->sd['cl']);
    $this->db->where("bc",$this->sd['branch']);
    $r_detail['branch']=$this->db->get('m_branch')->result();
    $r_detail['page']=$_POST['page'];
    $r_detail['type']=$_POST['type']; 




    $sql="SELECT `code`,`name`,`address1`,`address2`,`address3`,`tp1`,`tp2`,`tp3`,`doj`,`inactive` FROM `m_employee`;";

  
     $r_detail['employee']=$this->db->query($sql)->result(); 

    if($this->db->query($sql)->num_rows()>0){
   	
      $this->load->view($_POST['by'].'_'.'pdf',$r_detail);
    }else{
      echo "<script>alert('No Data');window.close();</script>";
    }
    
  }



}
