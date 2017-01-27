<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class r_hp_other_charges_details extends CI_Model{
    
  private $sd;
  private $mtb;
  private $mod = '003';
  
  function __construct(){
  parent::__construct();

  $this->sd = $this->session->all_userdata();
  $this->load->database($this->sd['db'], true);
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
    $customer=$_POST['cus_id'];
    $agreement_no=$_POST['agreemnt_no'];

    $sql="SELECT  s.nno, 
                  s.`agreement_no`, 
                  CONCAT(s.`customer`, ' - ' ,c.`name`) AS customer,
                  s.`ddate`,
                  d.`chg_type`,
                  t.`description` AS chg_description,
                  d.`amount`,
                  j.amount AS tot_amount,
                  d.`description` 
          FROM t_hp_chargers_det d
          JOIN t_hp_chargers_sum s ON s.`cl` = d.`cl` AND s.`bc` = d.`bc` AND s.`nno` = d.`nno` 
          JOIN r_hp_chargers_type t ON t.`code` = d.`chg_type`
          JOIN m_customer c ON c.`code` = s.`customer`
          JOIN(SELECT cl,bc,nno,SUM(amount) AS amount FROM t_hp_chargers_det GROUP BY cl,bc,nno)j ON j.cl=d.cl AND j.bc=d.bc AND j.nno=d.nno
          WHERE s.cl='".$this->sd['cl']."' 
                AND s.bc='".$this->sd['branch']."' 
                AND s.`ddate` BETWEEN '".$_POST['from']."' AND '".$_POST['to']."'";

    if(!empty($customer)){
      $sql.=" AND s.customer = '$customer'";
    } 
    if(!empty($agreement_no)){
      $sql.=" AND s.agreement_no = '$agreement_no'";
    } 
    $sql.=" ORDER BY s.nno";

    $query=$this->db->query($sql);
    if($query->num_rows>0){
      $r_detail['sum']=$query->result();
      $this->load->view($_POST['by'].'_'.'pdf',$r_detail);
    }else{
      echo "<script>alert('No data found ');close();</script>";
    }
  }
}