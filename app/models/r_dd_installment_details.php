<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class r_dd_installment_details extends CI_Model{

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

    $sql="SELECT t.ddate,t.`agr_no`,SUM(t.dr) AS due_amo,s.`installment_amount` AS ins_amo,s.`net_amount` AS agr_amo,s.`cus_id`,m.`name`
    FROM t_ins_trans t
    JOIN t_hp_sales_sum s ON s.`agreement_no`=t.`agr_no`
    JOIN m_customer m ON m.`code`=s.`cus_id`
    WHERE t.`bc`= '".$this->sd['branch']."'AND t.`ddate` between '".$_POST['from']."' AND '".$_POST['to']."'
    AND s.is_closed!='1'";

    if(!empty($customer))
    {
        $sql.=" AND m.code = '$customer'";
    } 
    if(!empty($agreement))
    {
        $sql.=" AND t.`agr_no` = '$agreement'";
    } 
    if(!empty($area))
    {
        $sql.=" AND m.`area` = '$area'";
    } 

    $sql.=" GROUP BY t.agr_no";

    $query=$this->db->query($sql);
    if($query->num_rows>0){
        $r_detail['daily_due']=$query->result();
        $this->load->view($_POST['by'].'_'.'pdf',$r_detail);
    }else{
      echo "<script>alert('No data found ');close();</script>";
  }
}
}