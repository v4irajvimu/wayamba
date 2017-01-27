<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class r_cash_sales_summary extends CI_Model{

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
  

  public function PDF_report($RepTyp=""){

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

    $r_detail['category_field']=$_POST['sales_category'];


    if($_POST['cluster']!="0"){
        $scl=" AND t_cash_sales_sum.cl= '".$_POST['cluster']."' ";
        $scl1=" AND s.cl= '".$_POST['cluster']."' ";
        $scl2=" AND cl= '".$_POST['cluster']."' ";
    }else{
        $scl="";
        $scl1="";
        $scl2="";
    }

    if($_POST['branch']!="0"){
        $sbc=" AND t_cash_sales_sum.bc= '".$_POST['branch']."' ";
        $sbc1=" AND s.bc= '".$_POST['branch']."' ";
        $sbc2=" AND bc= '".$_POST['branch']."' ";
    }else{
        $sbc="";
        $sbc1="";
        $sbc2="";
    }

    if($_POST['sales_category']!="0"){

      $query1=$this->db->query("SELECT SUM(`t_cash_sales_sum`.gross_amount) AS gsum,t_cash_sales_sum.additional_add,t_cash_sales_sum.additional_deduct,
        SUM(`t_cash_sales_sum`.`net_amount`) AS nsum,
        IFNULL(SUM(ad.amount),0) AS addi 
        FROM `t_cash_sales_sum`           
        LEFT JOIN `t_cash_sales_additional_item` ad 
        ON ad.nno = `t_cash_sales_sum`.`nno`
        AND `t_cash_sales_sum`.`cl` = `ad`.`cl`
        AND `t_cash_sales_sum`.`bc` = `ad`.`bc`          
        WHERE t_cash_sales_sum.is_cancel=0 AND t_cash_sales_sum.category ='".$_POST['sales_category']."' $scl $sbc
        and `t_cash_sales_sum`.`ddate` between '".$_POST['from']."' and '".$_POST['to']."' ");


      

      $r_detail['sum']=$query1->result();

      $query = $this->db->query("SELECT  s.`nno`,
        s.`sub_no`,
        s.`cus_id`,
        c.`name`,
        s.`ddate`,
        (s.`gross_amount` -s.`total_foc_amount` )gross,
        discount_amount AS discount,
        s.`net_amount`,
        s.additional_add,
        s.additional_deduct,
        ms.description
        FROM `t_cash_sales_sum` s
        JOIN `m_customer` c ON s.`cus_id`=c.`code`
        JOIN `m_stores` ms ON ms.`code` = s.`store` 
        WHERE s.category = '".$_POST['sales_category']."'  ".$scl1."    ".$sbc1."

        AND s.is_cancel=0
        AND s.`ddate` BETWEEN '".$_POST['from']."' AND '".$_POST['to']."' 

        GROUP BY s.nno  ");
      
     
      $r_detail['purchase']=$query->result();  



    }else{  

      $query1=$this->db->query("SELECT SUM(`t_cash_sales_sum`.gross_amount) AS gsum,t_cash_sales_sum.additional_add,t_cash_sales_sum.additional_deduct,
        SUM(`t_cash_sales_sum`.`net_amount`) AS nsum,
        IFNULL(SUM(ad.amount),0) AS addi 
        FROM `t_cash_sales_sum`           
        LEFT JOIN `t_cash_sales_additional_item` ad 
        ON ad.nno = `t_cash_sales_sum`.`nno`
        AND `t_cash_sales_sum`.`cl` = `ad`.`cl`
        AND `t_cash_sales_sum`.`bc` = `ad`.`bc` 
        WHERE `t_cash_sales_sum`.is_cancel=0 
        and `t_cash_sales_sum`.`ddate` between '".$_POST['from']."' and '".$_POST['to']."' $scl $sbc ");
      $r_detail['sum']=$query1->result();

      $query = $this->db->query("SELECT  s.`nno`,
        s.`sub_no`,
        s.`cus_id`,
        c.`name`,
        s.`ddate`,
        (s.`gross_amount` -s.`total_foc_amount` )gross,
        discount_amount AS discount,
        s.`net_amount`,
        s.additional_add,
        s.additional_deduct,
        ms.description
        FROM `t_cash_sales_sum` s
        JOIN `m_customer` c ON s.`cus_id`=c.`code`
        JOIN `m_stores` ms ON ms.`code` = s.`store` 
        WHERE s.is_cancel=0
        $scl1 $sbc1
        AND s.`ddate` BETWEEN '".$_POST['from']."' 
        AND '".$_POST['to']."' 
        GROUP BY s.nno ");



      $r_detail['purchase']=$query->result();   
    }

    

    $sql_crn="SELECT ifnull(sum(amount),0) as tot_amount FROM t_credit_note
    WHERE `acc_code` IN (SELECT acc_code FROM `m_default_account` WHERE CODE='SALES_DISCOUNT') $scl2 $sbc2
    AND `ddate` BETWEEN '".$_POST['from']."' AND '".$_POST['to']."' AND dis_type='4' AND is_cancel=0";

    $query_crn = $this->db->query($sql_crn);

    if($query_crn->num_rows()>0){
      $r_detail['crn'] = $query_crn->row()->tot_amount;
    }else{
      $r_detail['crn'] = 0;
    }

    if($query->num_rows()>0){

     $exTy=($RepTyp=="")?'pdf':'excel';
     $this->load->view($_POST['by'].'_'.$exTy,$r_detail);
   }else{
    echo "<script>alert('No Data');window.close();</script>";
  }

}

public function Excel_report(){
  $this->PDF_report("Excel");
}
}