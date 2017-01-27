<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class r_credit_sales_outstanding extends CI_Model{
    
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
    $r_detail['orientation']='L';  
    $r_detail['card_no']=$_POST['card_no1'];
    $r_detail['dfrom']=$_POST['from'];
    $r_detail['dto']=$_POST['to'];
    $customer=$_POST['cus_id'];
    $cus_name=$_POST['customer'];
    $agreement_no=$_POST['agreemnt_no'];
    $salesman=$_POST['rep'];


    $sql="SELECT  s.`nno`, 
                  s.`cus_id`,
                  cc.`name` AS cus_name,
                  s.`rep`,
                  ee.`name` AS rep_name,
                  GROUP_CONCAT(i.`description`) AS item,
                  IFNULL(s.`net_amount`,0.00) AS net_amount,
                  IFNULL(st.paid,0.00) AS paid,
                  IFNULL(st.balance,0.00) AS balance
        FROM t_credit_sales_sum s
        JOIN m_customer cc ON cc.`code` = s.`cus_id`
        JOIN m_employee ee ON ee.`code` = s.`rep`
        JOIN t_credit_sales_det d ON s.`cl`=d.cl AND s.`bc`=d.bc AND s.`nno`=d.nno
        JOIN m_item i ON i.`code` = d.`code`
        JOIN (SELECT cl, bc, trans_code, trans_no, SUM(cr) AS paid, SUM(dr)-SUM(cr) AS balance 
              FROM t_cus_settlement GROUP BY cl,bc,trans_code,trans_no) st
              ON st.cl=s.cl AND st.bc=s.bc AND st.trans_no=s.`nno` AND st.trans_code='5' 
        WHERE s.`ddate` <= '".$_POST['to']."'";

    if($_POST['cluster'] !='0'){
      $sql.=" AND s.cl = '".$_POST['cluster']."'";
    } 
    if($_POST['branch'] !='0'){
      $sql.=" AND s.bc = '".$_POST['branch']."'";
    } 
    if(!empty($salesman)){
      $sql.=" AND s.rep = '$salesman'";
    } 
    $sql.="GROUP BY s.cl,s.bc,s.nno HAVING balance > 0 ORDER BY s.rep ";

    $query=$this->db->query($sql);
    if($query->num_rows>0){
      $r_detail['sum']=$query->result();
      $this->load->view($_POST['by'].'_'.'pdf',$r_detail);
    }else{
      echo "<script>alert('No data found ');close();</script>";
    }
  }
}