<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class r_hp_sales_details extends CI_Model{
    
  private $sd;
  private $mtb;
  
  private $mod = '003';
  
  function __construct(){
  parent::__construct();

  $this->sd = $this->session->all_userdata();
  $this->load->database($this->sd['db'], true);
  $this->mtb = $this->tables->tb['t_privilege_card'];
  $this->m_customer = $this->tables->tb['m_customer'];
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
    $customer=$_POST['cus_id'];

   $sql="SELECT 
              sd.`nno`,
              ss.`ddate`,
              ss.`cus_id`,
              c.`name`,
              sd.item_code,
              i.`description`,
              ss.`agreement_no`,
              sd.qty,
              sd.sales_price,
              sd.amount,
              sd.discount,
              (sd.amount - sd.discount) AS net_value,
               j.amount AS tot_amount
              FROM
              t_hp_sales_det sd 
              JOIN m_item i ON i.`code` = sd.`item_code` 
              JOIN `t_hp_sales_sum` ss ON ss.`nno` = sd.`nno` 
              JOIN m_customer c ON c.`code` = ss.`cus_id` 
              JOIN(SELECT cl,bc,nno,SUM(amount) AS amount FROM t_hp_sales_det GROUP BY cl,bc,nno)j ON j.cl=sd.cl AND j.bc=sd.bc AND j.nno=sd.nno
              WHERE `sd`.`bc`= '".$this->sd['branch']."'
              and `ss`.`ddate` between '".$_POST['from']."' and '".$_POST['to']."' 
              AND ss.is_cancel!='1'";

      if(!empty($customer))
        {
            $sql.=" AND ss.cus_id = '$customer'";
        } 
      
        $query=$this->db->query($sql);
        if($query->num_rows>0){
        $r_detail['sum']=$query->result();
        }else{
          echo "<script>alert('No data found ');close();</script>";
        }

      $sql1="SELECT d.cl,d.bc,d.nno,SUM(d.amount) AS amount FROM t_hp_sales_det d 
              JOIN `t_hp_sales_sum` s ON s.`nno`=d.`nno`
              WHERE `d`.`bc`= '".$this->sd['branch']."' 
              AND `s`.`ddate` BETWEEN '".$_POST['from']."' AND '".$_POST['to']."'
              AND s.is_cancel!='1'"; 
              
      if(!empty($customer))
        {
            $sql1.=" AND s.cus_id = '$customer'";
        } 
      
        $query1=$this->db->query($sql1);
        if($query1->num_rows>0){
        $r_detail['sum1']=$query1->result();      
      }else{
          echo "<script>alert('No data found ');close();</script>";
      } 
      $this->load->view($_POST['by'].'_'.'pdf',$r_detail);
}
}
