<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class r_hp_other_charges_sum extends CI_Model{
    
  private $sd;
  private $mtb;
  
  private $mod = '003';
  
  function __construct(){
  parent::__construct();

  $this->sd = $this->session->all_userdata();
  $this->load->database($this->sd['db'], true);
  $this->mtb = $this->tables->tb['t_privilege_card'];
  $this->t_previlliage_trans=$this->tables->tb['t_previlliage_trans'];
  $this->t_privilege_card=$this->tables->tb['t_privilege_card']; 
  }
  
  public function base_details(){
    $a['table_data'] = $this->data_table();
    return $a;
  }
  
  public function PDF_report(){
        
    $this->db->select(array('name','address','tp','fax','email'));
    $this->db->where("bc",$this->sd['branch']);

    $r_detail['branch']=$this->db->get('m_branch')->result();

    $r_detail['page']='A4';
    $r_detail['orientation']='P';  
    $r_detail['card_no']=$_POST['card_no1'];
    $r_detail['dfrom']=$_POST['from'];
    $r_detail['dto']=$_POST['to'];
    $agreement=$_POST['agreement'];
    $customer=$_POST['cus_id'];

      
    $sql="SELECT nno,
                 ddate,
                 agreement_no,
                 CONCAT(s.customer, ' - ' , c.`name`) AS customer,
                 paid_amount
          FROM `t_hp_chargers_sum` s
          JOIN m_customer c ON c.`code` = s.`customer`
          WHERE s.cl='".$this->sd['cl']."' AND s.bc='".$this->sd['branch']."' 
          AND ddate BETWEEN '".$_POST['from']."' AND '".$_POST['to']."'";

    if(!empty($customer)){
      $sql.=" AND s.code = '$customer'";
    } 
    if(!empty($agreement)){
      $sql.=" AND s.`agreement_no` = '$agreement'";
    } 
    $sql.=" group by s.nno";

    $query=$this->db->query($sql);
    if($query->num_rows>0){
      $r_detail['sum']=$query->result();
      $this->load->view($_POST['by'].'_'.'pdf',$r_detail);
    }else{
      echo "<script>alert('No data found ');close();</script>";
    }
  }
}