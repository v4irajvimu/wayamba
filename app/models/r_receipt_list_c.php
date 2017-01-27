<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class r_receipt_list_c extends CI_Model{
    
  private $sd;
  private $mtb;
  
  private $mod = '003';
  
  function __construct(){
  parent::__construct();

  $this->sd = $this->session->all_userdata();
  $this->load->database($this->sd['db'], true);
  $this->mtb = $this->tables->tb['t_privilege_card'];
  $this->m_customer = $this->tables->tb['m_customer'];
  $this->t_sales_sum=$this->tables->tb['t_sales_sum'];
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
    $r_detail['orientation']='L';  
    $r_detail['card_no']=$_POST['card_no1'];
    $r_detail['dfrom']=$_POST['from'];
    $r_detail['dto']=$_POST['to'];
    $area=$_POST['area_code'];
    $agreement=$_POST['agreemnt_no'];
    $customer=$_POST['cus_id'];
    $col_officer=$_POST['col_officer_id'];
    $route=$_POST['route_id'];

    $r_detail['agr']=$_POST['agreemnt_no'];
    $r_detail['cus']=$_POST['cus_id'];
    $r_detail['col']=$_POST['col_officer_id'];
    $r_detail['route']=$_POST['route_id'];
    $r_detail['col_name']=$_POST['col_officer'];
    $r_detail['area']=$_POST['area_code'];
    $r_detail['route_name']=$_POST['route_des'];
    $r_detail['area_name']=$_POST['area'];

    $sql="SELECT s.ddate,
                s.nno,
                s.ref_no,
                s.agr_no,
                CONCAT(s.customer,' - ',c.name) AS customer, 
                s.pay_cash AS cash_amount,
                s.pay_cheque AS cheque_amount,
                s.pay_ccard AS card_amount,
                s.pay_cnote AS credit_note,
                s.`paid_amount` AS total
        FROM t_hp_receipt_sum s
        JOIN m_customer c ON c.`code` = s.`customer`
        WHERE s.ddate BETWEEN '".$_POST['from']."' AND '".$_POST['to']."' 
            AND s.cl='".$this->sd['cl']."' AND s.bc='".$this->sd['branch']."'
            AND is_cancel='0'";

      if(!empty($customer)){
        $sql.=" AND s.customer = '$customer'";
      } 
      if(!empty($agreement)){
        $sql.=" AND s.agr_no = '$agreement'";
      } 
      if(!empty($col_officer)){
        $sql.=" AND s.collection_officer = '$col_officer'";
      } 
      if(!empty($route)){
        $sql.=" AND c.root = '$route'";
      } 
      if(!empty($area)){
        $sql.=" AND c.area = '$area'";
      } 

      $sql.=" GROUP BY s.cl,s.bc,s.nno";
      
      $query=$this->db->query($sql);

      if($query->num_rows>0){
        $r_detail['sum']=$query->result();
        $this->load->view($_POST['by'].'_'.'pdf',$r_detail);
      }else{
          echo "<script>alert('No data found ');close();</script>";
      }
}
}