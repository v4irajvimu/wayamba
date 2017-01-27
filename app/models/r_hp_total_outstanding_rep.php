<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class r_hp_total_outstanding_rep extends CI_Model{
    
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
    $salesman=$_POST['salesman_id'];


    $sql="SELECT GROUP_CONCAT(i.`description`) AS description,
                  s.agreement_no,
                  s.cus_id,
                  mc.`nic`,
                  mc.`name`,
                  d.`item_code`,
                  s.`net_amount`,
                  s.rep,
                  rp.name as rep_name,
                  IFNULL(c.panalty,0) AS panalty,
                  IFNULL(c1.other_c,0) AS othr_charges,
                  IFNULL(c2.tot_paid,0) AS total_paid, 
                  IFNULL(s.`net_amount`,0) -IFNULL(c2.tot_paid, 0)  AS bal
    FROM `t_hp_sales_sum` s
    JOIN `t_hp_sales_det` d ON d.`nno`=s.`nno` AND d.cl=s.cl AND d.bc=s.`bc`
    JOIN m_customer mc ON mc.`code`=s.`cus_id`
    JOIN m_employee rp ON rp.`code`=s.`rep`
    JOIN m_item i ON i.code=d.`item_code`
    LEFT JOIN(SELECT rs.nno,rs.cl,rs.bc,rs.`agr_no`,SUM(rd.paid) AS panalty FROM `t_hp_receipt_det` rd JOIN `t_hp_receipt_sum` rs ON rs.cl=rd.cl AND rs.bc=rd.`bc` AND rs.`nno`=rd.`nno` WHERE order_type='3')c ON c.cl=s.`cl` AND c.bc=s.bc AND c.agr_no=s.`agreement_no`
    LEFT JOIN(SELECT rs.nno,rs.cl,rs.bc,rs.`agr_no`,SUM(rd.paid) AS other_c FROM `t_hp_receipt_det` rd JOIN `t_hp_receipt_sum` rs ON rs.cl=rd.cl AND rs.bc=rd.`bc` AND rs.`nno`=rd.`nno` WHERE order_type='2')c1 ON c1.cl=s.`cl` AND c1.bc=s.bc AND c1.agr_no=s.`agreement_no`
    LEFT JOIN(SELECT rs.nno,rs.cl,rs.bc,rs.`agr_no`,SUM(rd.paid) AS tot_paid FROM `t_hp_receipt_det` rd JOIN `t_hp_receipt_sum` rs ON rs.cl=rd.cl AND rs.bc=rd.`bc` AND rs.`nno`=rd.`nno` GROUP BY rs.agr_no)c2 ON c2.cl=s.`cl` AND c2.bc=s.bc AND c2.agr_no=s.`agreement_no`
    WHERE s.cl='".$this->sd['cl']."' 
          AND s.bc='".$this->sd['branch']."'
          AND s.`ddate` <='".$_POST['to']."' 
     ";

    if(!empty($customer)){
      $sql.=" AND s.cus_id = '$customer'";
    } 
    if(!empty($agreement_no)){
      $sql.=" AND s.agreement_no = '$agreement_no'";
    } 
    if(!empty($salesman)){
      $sql.=" AND s.rep = '$salesman'";
    } 
    $sql.="GROUP BY s.cl,s.bc,s.nno ORDER BY s.rep";

    $query=$this->db->query($sql);
    if($query->num_rows>0){
      $r_detail['sum']=$query->result();
      $this->load->view($_POST['by'].'_'.'pdf',$r_detail);
    }else{
      echo "<script>alert('No data found ');close();</script>";
    }
  }
}