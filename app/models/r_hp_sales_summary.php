<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class r_hp_sales_summary extends CI_Model{
    
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
    $r_detail['orientation']='P';  
    $r_detail['card_no']=$_POST['card_no1'];
    $r_detail['dfrom']=$_POST['from'];
    $r_detail['dto']=$_POST['to'];
    $agreement=$_POST['agreemnt_no'];
    $customer=$_POST['cus_id'];
    $salesman=$_POST['salesman_id'];
    $area=$_POST['area_code'];

   $sql="SELECT `t_hp_sales_sum`.`net_amount` as net_sum , `t_hp_sales_sum`.`down_payment`  as downp_sum, 
   `t_hp_sales_sum`.`interest_amount` as interest_sum, `t_hp_sales_sum`.`document_charges` as other_char_sum,
    `t_hp_sales_sum`.`installment_amount` as inst_sum, `t_hp_sales_sum`.`no_of_installments` as no_of_inst_sum 
      FROM `t_hp_sales_sum`
      JOIN m_customer ON m_customer.`code`=t_hp_sales_sum.`cus_id`
      LEFT JOIN `t_hp_sales_det`ON `t_hp_sales_sum`.`nno` = `t_hp_sales_det`.`nno`
      JOIN r_area ON r_area.`code`=m_customer.`area`
      WHERE `t_hp_sales_sum`.`bc`= '".$this->sd['branch']."' AND t_hp_sales_sum.is_cancel='0'
      and `t_hp_sales_sum`.`ddate` between '".$_POST['from']."' and '".$_POST['to']."' ";

      if(!empty($customer))
        {
            $sql.=" AND m_customer.code = '$customer'";
        } 
      if(!empty($agreement))
        {
            $sql.=" AND `t_hp_sales_sum`.`agreement_no` = '$agreement'";
        } 
      if(!empty($salesman))
        {
            $sql.=" AND `t_hp_sales_sum`.`rep` = '$salesman'";
        } 
      if(!empty($area))
        {
            $sql.=" AND `m_customer`.`area` = '$area'";
        } 


    $query=$this->db->query($sql);
      if($query->num_rows>0){
        $r_detail['sum']=$query->result();
      }
    
    $sql="SELECT `t_hp_sales_sum`.`nno`, `t_hp_sales_sum`.`agreement_no`,`t_hp_sales_sum`.`cus_id`, `t_hp_sales_sum`.`ddate`,`m_customer`.`name`, `t_hp_sales_sum`.`net_amount`,`t_hp_sales_sum`.`down_payment`,`t_hp_sales_sum`.`interest_amount`,`t_hp_sales_sum`.`document_charges`, `m_stores`.`description`,`t_hp_sales_sum`.`installment_amount`,`t_hp_sales_sum`.`no_of_installments`
      FROM `t_hp_sales_sum`
      LEFT JOIN `m_customer` ON `t_hp_sales_sum`.`cus_id` = `m_customer`.`code`
			LEFT JOIN `t_hp_sales_det` ON `t_hp_sales_sum`.`nno` = `t_hp_sales_det`.`nno`
			LEFT JOIN `m_stores` ON `m_stores`.`code` = `t_hp_sales_sum`.`store_id`
      JOIN r_area ON r_area.`code`=m_customer.`area`
      WHERE `t_hp_sales_sum`.`bc`= '".$this->sd['branch']."' AND t_hp_sales_sum.is_cancel='0'
      and `t_hp_sales_sum`.`ddate` between '".$_POST['from']."' and '".$_POST['to']."' ";

      if(!empty($customer))
        {
            $sql.=" AND m_customer.code = '$customer'";
        } 
      if(!empty($agreement))
        {
            $sql.=" AND `t_hp_sales_sum`.`agreement_no` = '$agreement'";
        } 
        if(!empty($salesman))
        {
            $sql.=" AND `t_hp_sales_sum`.`rep` = '$salesman'";
        } 
        if(!empty($area))
        {
            $sql.=" AND `m_customer`.`area` = '$area'";
        } 
        $sql.=" group by nno";


      $query=$this->db->query($sql);
      if($query->num_rows>0){
        $r_detail['purchase']=$query->result();
        $this->load->view($_POST['by'].'_'.'pdf',$r_detail);
      
      }else{
          echo "<script>alert('No data found ');close();</script>";
      }
}
}