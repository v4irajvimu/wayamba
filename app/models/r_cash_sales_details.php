<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class r_cash_sales_details extends CI_Model{
    
    private $sd;
    private $mtb;
    
    private $mod = '003';
    
    function __construct(){
      parent::__construct();
      $this->sd = $this->session->all_userdata();
      $this->load->database($this->sd['db'], true);
      $this->mtb = $this->tables->tb['t_privilege_card'];
      $this->m_customer = $this->tables->tb['m_customer'];
      $this->t_sales_sum=$this->tables->tb['t_cash_sales_sum'];
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
          //$r_detail['type']='r_cash_sales_details';

          if($_POST['cluster']!="0"){
            $scl1=' AND s.cl= "'.$_POST['cluster'].'" ';
          }else{
            $scl1="";
          }

          if($_POST['branch']!="0"){
            $sbc1=' AND s.bc= "'.$_POST['branch'].'" ';
          }else{
            $sbc1="";
          }
          
          $r_detail['category_field']=$_POST['sales_category'];

          if($_POST['sales_category']!="0"){

            $query1=$this->db->query("SELECT  SUM(e.`qty`*e.`price`) AS gsum, s.`net_amount` AS nsum, s.`net_amount` - s.`gross_amount` as addi
            FROM `t_cash_sales_sum` s
            LEFT JOIN `t_cash_sales_det` e ON s.`nno`=e.`nno` AND s.`cl`=e.`cl` AND s.`bc`=e.`bc`
            WHERE s.category='".$_POST['sales_category']."' $scl1 $sbc1
            and s.ddate between '".$_POST['from']."' and '".$_POST['to']."' GROUP BY e.`nno` order by e.`nno` ASC");
            $r_detail['sum']=$query1->result();
          
            $query = $this->db->query("SELECT s.`nno` ,s.`ddate` ,s.`cus_id` ,d.`qty`*d.`price` as `gross_amount` ,d.`amount` as net_amount ,c.`name` , s.`rep` as rep_id ,s.`store`,e.`name` as rep
            ,d.`code` ,d.`price` ,d.`qty` ,d.`discount` * d.`qty` as discount  ,i.`description`
            FROM `t_cash_sales_sum` s
            LEFT JOIN `m_customer` c ON s.`cus_id`=c.`code`
            LEFT JOIN `m_employee` e ON e.`code` = s.`rep` 
            LEFT JOIN `t_cash_sales_det` d ON s.`cl`=d.`cl` AND s.`bc`=d.`bc` AND s.`nno`=d.`nno`
            LEFT JOIN `m_item` i ON d.`code`=i.`code` 
            WHERE s.category='".$_POST['sales_category']."' 
            $scl1 $sbc1
            and s.ddate between '".$_POST['from']."' and '".$_POST['to']."' AND s.is_cancel != '1' order by d.`nno` ASC");
            $r_detail['purchase']=$query->result();

          }else{

            $query1=$this->db->query("SELECT  SUM(e.`qty`*e.`price`) AS gsum, s.`net_amount` AS nsum, s.`net_amount` - s.`gross_amount` as addi
            FROM `t_cash_sales_sum` s
            LEFT JOIN `t_cash_sales_det` e ON s.`nno`=e.`nno` AND s.`cl`=e.`cl` AND s.`bc`=e.`bc`
            WHERE s.ddate between '".$_POST['from']."' and '".$_POST['to']."' $scl1 $sbc1
            GROUP BY e.`nno` order by e.`nno` ASC ");
            $r_detail['sum']=$query1->result();
          
            $query = $this->db->query("SELECT s.`nno` ,s.`ddate` ,s.`cus_id` ,d.`qty`*d.`price` as `gross_amount` ,d.`amount` as net_amount ,c.`name` , s.`rep` as rep_id ,s.`store`,e.`name` as rep,s.`net_amount` - s.`gross_amount` as addi
            ,d.`code` ,d.`price` ,d.`qty` ,d.`discount` * d.`qty` as discount  ,i.`description`
            FROM `t_cash_sales_sum` s
            LEFT JOIN `m_customer` c ON s.`cus_id`=c.`code`
            LEFT JOIN `m_employee` e ON e.`code` = s.`rep` 
            LEFT JOIN `t_cash_sales_det` d ON s.`cl`=d.`cl` AND s.`bc`=d.`bc` AND s.`nno`=d.`nno`
            LEFT JOIN `m_item` i ON d.`code`=i.`code` 
            WHERE is_cancel!='1' 
            $scl1 $sbc1
            and s.ddate between '".$_POST['from']."' and '".$_POST['to']."'  order by d.`nno` ASC");
            $r_detail['purchase']=$query->result();

          }
          

          

          if($query->num_rows()>0)
          {
            $this->load->view($_POST['by'].'_'.'pdf',$r_detail);
          }
          else
          {
            echo "<script>alert('No Data');window.close();</script>";
          }
     }
}