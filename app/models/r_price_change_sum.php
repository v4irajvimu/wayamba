<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class r_price_change_sum extends CI_Model {
    
    private $sd;
    private $mtb;
    private $max_no;
    private $mod = '003';
    
    function __construct(){
	   parent::__construct();
      $this->sd = $this->session->all_userdata();
      $this->load->database($this->sd['db'], true);
      // $this->mtb = $this->tables->tb['t_quotation_sum'
      $this->load->model('user_permissions');
    }
    
    public function base_details(){
    	
    }
    
    
    public function PDF_report(){

      $this->db->select(array('name','address','tp','fax','email'));
      $this->db->where("cl",$this->sd['cl']);
      $this->db->where("bc",$this->sd['branch']);
      $r_detail['branch']=$this->db->get('m_branch')->result();
      
      $r_detail['type']=$_POST['type']; 
      $r_detail['df']=$_POST['df'];       
      $r_detail['dto']=$_POST['dto'];
      $r_detail['qno']=$_POST['qno'];
      $r_detail['item']=$_POST['item'];

      $r_detail['page']=$_POST['page'];
      $r_detail['header']=$_POST['header'];
      $r_detail['orientation']=$_POST['orientation'];

       $sql="SELECT 
              d.`item`,
              i.`description`,
              d.`nno`,
              s.`ddate`,
              d.`cost`,
              d.`last_price`,
              d.`max_price`,
              d.`last_price_new`,
              d.`max_price_new` 
            FROM
              `t_price_change_det` d 
              JOIN `t_price_change_sum` s ON s.`nno` = d.`nno` 
              JOIN m_item i ON i.`code`=d.`item` 
              WHERE d.`item`='".$_POST['item']."' AND s.`ddate` BETWEEN '".$_POST[df]."' AND '".$_POST[dto]."' ";

     $r_detail['items']=$this->db->query($sql)->result(); 

    if($this->db->query($sql)->num_rows()>0){
      $this->load->view($_POST['by'].'_'.'pdf',$r_detail);
    }else{
      echo "<script>alert('No Data');window.close();</script>";
    }
    
 
}
}