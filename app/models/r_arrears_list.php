<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class r_arrears_list extends CI_Model{
    
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
    $agreement=$_POST['agreemnt_no'];
    $customer=$_POST['cus_id'];
    $sales_rep=$_POST['salesman_id'];
    $route=$_POST['route_id'];

    $r_detail['agr']=$_POST['agreemnt_no'];
    $r_detail['cus']=$_POST['cus_id'];
    $r_detail['col']=$_POST['salesman_id'];
    $r_detail['route']=$_POST['route_id'];
    $cl=$this->sd['cl'];
    $bc=$this->sd['branch'];
    $to_date = $_POST['to'];

    $sql1="SELECT f.all_item,
                  s.agr_no,
                  CONCAT(acc_code, ' - ', i.name) AS customer,
                  i.address1 AS cus_add,
                  i.cus_contact AS cus_tp,
                  IFNULL(i.installment,0.00) AS installment,
                  IFNULL(i.installment_amount, 0.00) AS m_installment,
                  IFNULL(o.other_chargers,0.00) AS other_chargers,
                  IFNULL(p.panelty,0.00) AS penalty
            FROM t_ins_trans s 
            LEFT JOIN (SELECT s.cl,s.bc,s.agr_no,c.name, SUM(dr)-SUM(cr) AS other_chargers 
                      FROM t_ins_trans s
                      JOIN m_customer c ON c.`code` = s.`acc_code` 
                      LEFT JOIN t_hp_sales_sum ss ON ss.agreement_no = s.agr_no 
                  WHERE ins_trans_code = '4' AND s.due_date < '$to_date' AND
                  s.cl = '$cl' AND s.bc = '$bc' AND ss.is_cancel!='1' AND ss.is_closed!='1'"; 

      if(!empty($customer)){
        $sql1.=" AND s.acc_code = '$customer'";
      } 
      if(!empty($agreement)){
        $sql1.=" AND s.agr_no = '$agreement'";
      } 
      if(!empty($sales_rep)){
        $sql1.=" AND ss.rep = '$sales_rep'";
      } 
      if(!empty($route)){
        $sql1.=" AND c.root = '$route'";
      }         
      $sql1.=" GROUP BY `agr_no`)o ON o.cl=s.cl AND o.bc=s.bc AND o.agr_no = s.agr_no ";


      $sql2=" LEFT JOIN (SELECT s.cl,s.bc,s.agr_no,
                          c.name, 
                          cc.tp AS cus_contact,
                          c.address1,
                          ss.installment_amount,
                          SUM(dr)-SUM(cr) AS installment 
              FROM t_ins_trans s
              JOIN m_customer c ON c.`code` = s.`acc_code` 
              LEFT JOIN m_customer_contact cc ON cc.code= c.code
              LEFT JOIN t_hp_sales_sum ss ON ss.agreement_no = s.agr_no 
              WHERE  ins_trans_code = '1' OR ins_trans_code = '2'  OR ins_trans_code = '5'
              AND s.due_date < '$to_date' 
              AND s.cl = '$cl' AND s.bc = '$bc' AND ss.is_cancel!='1' AND ss.is_closed!='1' ";         

      if(!empty($customer)){
        $sql2.=" AND s.acc_code = '$customer'";
      } 
      if(!empty($agreement)){
        $sql2.=" AND s.agr_no = '$agreement'";
      } 
      if(!empty($sales_rep)){
        $sql2.=" AND ss.rep = '$sales_rep'";
      } 
      if(!empty($route)){
        $sql2.=" AND c.root = '$route'";
      }             
      $sql2.=" GROUP BY `agr_no`)i ON i.cl=s.cl AND i.bc=s.bc AND i.agr_no = s.agr_no ";

      $sql3=" LEFT JOIN (SELECT s.cl,s.bc,s.agr_no,c.name, SUM(dr)-SUM(cr) AS panelty 
              FROM t_ins_trans s
              JOIN m_customer c ON c.`code` = s.`acc_code` 
              LEFT JOIN t_hp_sales_sum ss ON ss.agreement_no = s.agr_no 
              WHERE ins_trans_code = '3' AND s.due_date < '$to_date' 
              AND s.cl = '$cl' AND s.bc = '$bc' AND ss.is_cancel!='1' AND ss.is_closed!='1'";                     

      if(!empty($customer)){
        $sql3.=" AND s.acc_code = '$customer'";
      } 
      if(!empty($agreement)){
        $sql3.=" AND s.agr_no = '$agreement'";
      } 
      if(!empty($sales_rep)){
        $sql3.=" AND ss.rep = '$sales_rep'";
      } 
      if(!empty($route)){
        $sql3.=" AND c.root = '$route'";
      }            
      $sql3.=" GROUP BY `agr_no`)p ON p.cl=s.cl AND p.bc=s.bc AND p.agr_no = s.agr_no
            JOIN (SELECT GROUP_CONCAT(mi.`description`) AS `all_item`, de.item_code, su.agreement_no 
                  FROM  t_hp_sales_sum su 
                  JOIN t_hp_sales_det de ON de.cl = su.cl AND de.bc = su.bc AND de.nno = su.nno 
                  JOIN m_item mi ON mi.`code`=de.`item_code`  
                  WHERE su.is_cancel!='1' AND su.is_closed!='1'
                  AND su.cl = '$cl' AND su.bc = '$bc'
                  GROUP BY su.agreement_no) f  ON f.agreement_no = s.agr_no 
                  WHERE  s.cl = '$cl' AND s.bc = '$bc'
            GROUP BY s.`agr_no`
            ";

      $sql=$sql1.$sql2.$sql3;

      $query=$this->db->query($sql);
      if($query->num_rows>0){
        $r_detail['sum']=$query->result();
        $this->load->view($_POST['by'].'_'.'pdf',$r_detail);
      }else{
          echo "<script>alert('No data found ');close();</script>";
      }
}
}