<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class r_total_sales_report_02 extends CI_Model{
    
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
    $this->db->where("cl",$this->sd['cl']);
    $this->db->where("bc",$this->sd['branch']);
    $r_detail['branch']=$this->db->get('m_branch')->result();

    $this->db->select(array('code','description'));
    $this->db->where("code",$_POST['sales_category']);
    $r_detail['category']=$this->db->get('r_sales_category')->result();

    $r_detail['page']='A4';
    $r_detail['orientation']='P';  
    $r_detail['card_no']=$_POST['card_no1'];
    $r_detail['dfrom']=$_POST['from'];
    $r_detail['dto']=$_POST['to'];
    $r_detail['custom_name']=$_POST['r_customer_des'];
    $r_detail['catgory']=$_POST['sales_category'];
    $sales_cat=$_POST['sales_category'];
    $cus=$_POST['r_customer'];


    $sql='SELECT 
              s.`ddate`,
              s.`nno`,
              s.`sub_no`,
              s.`do_no`,
              s.`cus_id`,
              s.`gross_amount`,
              s.`discount_amount`,
              c.`nic`,
              c.`name`,
              s.`additional_add` - s.`additional_deduct` AS Additional,
              s.`net_amount`,
              s.`category`,
              c.`name`,
              sc.`description` FROM `t_credit_sales_sum` s 
              JOIN m_customer c 
              ON c.`code` = s.`cus_id` 
              JOIN r_sales_category sc 
                ON sc.`code` = s.`category` 
              WHERE  s.`cl`="'.$this->sd['cl'].'" AND s.`bc`= "'.$this->sd['branch'].'"
              AND s.`ddate` between "'.$_POST['from'].'" AND "'.$_POST['to'].'"';

   if(!empty($sales_cat))
    {
      $sql.=" AND s.`category` = '".$_POST['sales_category']."'";
    }
    if(!empty($cus))
    {
      $sql.=" AND s.`cus_id` = '".$_POST['r_customer']."'";
    }

      $sql.=" GROUP BY s.cl,s.bc,s.nno ";
            
    //  $r_detail['value']=$this->db->query($sql)->result(); 

    if($this->db->query($sql)->num_rows()>0){
$this->load->view($_POST['by'].'_'.'pdf',$r_detail);
     
 }else{
    echo "<script>alert('No Data');window.close();</script>";
  } 
  }
}