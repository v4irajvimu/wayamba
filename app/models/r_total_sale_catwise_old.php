<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class r_total_sale_catwise extends CI_Model{

  private $sd;
  private $mtb;
  
  private $mod = '003';
  
  function __construct(){
    parent::__construct();

    $this->sd = $this->session->all_userdata();
    $this->load->database($this->sd['db'], true);
  }

  public function base_details(){

  }


  public function PDF_report(){

    $this->db->select(array('name','address','tp','fax','email'));
    $this->db->where("cl",$this->sd['cl']);
    $this->db->where("bc",$this->sd['branch']);
    $r_detail['branch']=$this->db->get('m_branch')->result();

    $r_detail['page']='A4';
    $r_detail['orientation']='P';  
    $r_detail['dfrom']=$_POST['from'];
    $r_detail['dto']=$_POST['to'];
    $r_detail['item']=$_POST['item'];

    if(!empty($item))
    {
      $item_code_cash= 'AND ca.code=$item';
      $item_code_credit='AND cr.code=$item';
      $item_code_hp='AND hs.item_code=$item';
    }





    $sql="SELECT 
    i.`description`,
    i.`main_category`,
    i.`category`,
    r_cat.`description` AS cat_des,
    r_sub_cat.`description` AS sub_cat_des,
    A.code, SUM(A.price)AS price, 
    A.code, SUM(A.qty)AS qty, 
    A.code, SUM(A.amount)AS amount,
    A.code, SUM(A.discount)AS discount
    FROM (

    SELECT '4' AS t_code,ca.`code`,
    IFNULL(SUM(ca.`price`),0)AS price,
    IFNULL(SUM(ca.`qty`),0)AS qty,
    IFNULL(SUM(ca.`discount`),0)AS discount,
    IFNULL(SUM(ca.`amount`),0)AS amount 
    FROM t_cash_sales_det ca 
    JOIN t_cash_sales_sum ca_s ON ca.`bc` = ca_s.`bc` AND ca.`cl` = ca_s.`cl` AND ca.`nno` = ca_s.`nno`
    WHERE ca_s.ddate BETWEEN '".$_POST['from']."' AND '".$_POST['to']."'
    GROUP BY ca.`code` 

    UNION ALL

    SELECT '5' AS t_code,ca.`code`,
    IFNULL(SUM(ca.`price`),0)AS price,
    IFNULL(SUM(ca.`qty`),0)AS qty,
    IFNULL(SUM(ca.`discount`),0)AS discount,
    IFNULL(SUM(ca.`amount`),0)AS amount 
    FROM t_credit_sales_det ca 
    JOIN t_credit_sales_sum ca_s ON ca.`bc` = ca_s.`bc` AND ca.`cl` = ca_s.`cl` AND ca.`nno` = ca_s.`nno`
    WHERE ca_s.ddate BETWEEN '".$_POST['from']."' AND '".$_POST['to']."'
    GROUP BY ca.`code` 

    UNION ALL

    SELECT '6' AS t_code,ca.item_code AS `code`,
    IFNULL(SUM(ca.`sales_price`),0)AS price,
    IFNULL(SUM(ca.`qty`),0)AS qty,
    IFNULL(SUM(ca.`discount`),0)AS discount,
    IFNULL(SUM(ca.`amount`),0)AS amount 
    FROM t_hp_sales_det ca 
    JOIN t_hp_sales_sum ca_s ON ca.`bc` = ca_s.`bc` AND ca.`cl` = ca_s.`cl` AND ca.`nno` = ca_s.`nno`
    WHERE ca_s.ddate BETWEEN '".$_POST['from']."' AND '".$_POST['to']."'
    GROUP BY ca.`item_code`

    ) A 

    JOIN m_item i ON i.code=A.code
    JOIN `r_category` r_cat ON r_cat.code = i.`main_category`
    JOIN `r_sub_category` r_sub_cat ON r_sub_cat.code = i.`category` AND r_sub_cat.`main_category` = i.`main_category`
    GROUP BY A.code
    ORDER BY `main_category`, `category`
    ";

    //
    $sql2="SELECT 
    i.`description`,
    i.`main_category`,
    i.`category`,
    r_cat.`description` AS cat_des,
    r_sub_cat.`description` AS sub_cat_des,
    A.code, SUM(A.price)AS price, 
    A.code, SUM(A.qty)AS qty, 
    A.code, SUM(A.amount)AS amount,
    A.code, SUM(A.discount)AS discount
    FROM (

    SELECT '4' AS t_code,ca.`code`,
    IFNULL(SUM(ca.`price`),0)AS price,
    IFNULL(SUM(ca.`qty`),0)AS qty,
    IFNULL(SUM(ca.`discount`),0)AS discount,
    IFNULL(SUM(ca.`amount`),0)AS amount 
    FROM t_cash_sales_det ca 
    JOIN t_cash_sales_sum ca_s ON ca.`bc` = ca_s.`bc` AND ca.`cl` = ca_s.`cl` AND ca.`nno` = ca_s.`nno`
    WHERE ca_s.ddate BETWEEN '".$_POST['from']."' AND '".$_POST['to']."'
    GROUP BY ca.`code` 

    UNION ALL

    SELECT '5' AS t_code,ca.`code`,
    IFNULL(SUM(ca.`price`),0)AS price,
    IFNULL(SUM(ca.`qty`),0)AS qty,
    IFNULL(SUM(ca.`discount`),0)AS discount,
    IFNULL(SUM(ca.`amount`),0)AS amount 
    FROM t_credit_sales_det ca 
    JOIN t_credit_sales_sum ca_s ON ca.`bc` = ca_s.`bc` AND ca.`cl` = ca_s.`cl` AND ca.`nno` = ca_s.`nno`
    WHERE ca_s.ddate BETWEEN '".$_POST['from']."' AND '".$_POST['to']."'
    GROUP BY ca.`code` 

    UNION ALL

    SELECT '6' AS t_code,ca.item_code AS `code`,
    IFNULL(SUM(ca.`sales_price`),0)AS price,
    IFNULL(SUM(ca.`qty`),0)AS qty,
    IFNULL(SUM(ca.`discount`),0)AS discount,
    IFNULL(SUM(ca.`amount`),0)AS amount 
    FROM t_hp_sales_det ca 
    JOIN t_hp_sales_sum ca_s ON ca.`bc` = ca_s.`bc` AND ca.`cl` = ca_s.`cl` AND ca.`nno` = ca_s.`nno`
    WHERE ca_s.ddate BETWEEN '".$_POST['from']."' AND '".$_POST['to']."'
    GROUP BY ca.`item_code`

    ) A 

    JOIN m_item i ON i.code=A.code
    JOIN `r_category` r_cat ON r_cat.code = i.`main_category`
    JOIN `r_sub_category` r_sub_cat ON r_sub_cat.code = i.`category` AND r_sub_cat.`main_category` = i.`main_category`
    
    GROUP BY i.`main_category`
    ORDER BY `main_category`, `category`
    ";
    //

    $data=$this->db->query($sql); 
    $data2=$this->db->query($sql2);   
    if($this->db->query($sql)->num_rows()>0){

      $r_detail['value']=$data->result();

      //
      $r_detail['maincat_grouped']=$data2->result();
      //
      $this->load->view($_POST['by'].'_'.'pdf',$r_detail);

    }else{
      echo "<script>alert('No Data');window.close();</script>";
    } 
  }
}