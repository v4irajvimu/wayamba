<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class r_sales_order_sales_gross_profit extends CI_Model{
    
  private $sd;
  private $mtb;
  
  private $mod = '003';
  
  function __construct(){
  parent::__construct();

  $this->sd = $this->session->all_userdata();
  // $this->load->database($this->sd['db'], true);
  // $this->mtb = $this->tables->tb['t_privilege_card'];
  // $this->m_customer = $this->tables->tb['m_customer'];
  // $this->t_sales_sum=$this->tables->tb['t_sales_sum'];
  // $this->t_previlliage_trans=$this->tables->tb['t_previlliage_trans'];
  // $this->t_privilege_card=$this->tables->tb['t_privilege_card']; 
  }
  
  public function base_details(){
      $a=true;

    // $a['table_data'] = $this->data_table();

    return $a;
  }
  

  public function PDF_report(){
      // var_dump($_POST);
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
    $r_detail['type']='r_sales_order_sales_gross_profit';

    $qCl = $this->db->get_where('m_supplier', array('code' => $_POST['supplier']))->row_array(0);
    $r_detail['supplier']=(!empty($_POST['supplier']))?$_POST['supplier']." - ".$qCl['name']:"";

    $qCl = $this->db->get_where('m_item', array('code' => $_POST['item']))->row_array(0);
    $r_detail['item']=(!empty($_POST['item']))?$_POST['item']." - ".$qCl['description']:"";

    $qCl = $this->db->get_where('m_cluster', array('code' => $_POST['cluster']))->row_array(0);
    $r_detail['Thcluster']=(!empty($_POST['cluster']))?$_POST['cluster']." - ".$qCl['description']:"";

    $qBc = $this->db->get_where('m_branch', array('bc' => $_POST['branch']))->row_array(0);
    $r_detail['Thbranch']=(!empty($_POST['branch']))?$_POST['branch']." - ".$qBc['name']:"";


// var_dump($r_detail['cluster']);exit();

$sql="SELECT 
          soss.`ddate`,
          sosd.`cl`,
          sosd.`bc`,
          `m_item`.`supplier`,
          sosd.`code`,
          `m_item`.`description`,
          sosd.`qty`,
          sosd.`cost`,
          sosd.`price`,
          sosd.`amount`,
          (sosd.`qty` * sosd.`cost`) AS cost_val,
          (sosd.`qty` * sosd.`price`) AS sales_val,
          (sosd.`qty` * sosd.`price`) - (sosd.`qty` * sosd.`cost`) AS profit 
        FROM
          `t_sales_order_sales_det` sosd 
          INNER JOIN `t_sales_order_sales_sum` soss 
            ON (sosd.`cl` = soss.`cl`) 
            AND (sosd.`bc` = soss.`bc`) 
            AND (sosd.`nno` = soss.`nno`) 
          INNER JOIN `m_item` 
            ON (sosd.`code` = `m_item`.`code`) 
      WHERE soss.`ddate` BETWEEN '".$_POST['from']."' AND '".$_POST['to']."'";



if ($_POST['supplier']!="")  {$sql.="AND `m_item`.`supplier`= '".$_POST['supplier']."'";}

if ($_POST['item']!="")  {$sql.="AND sosd.`code`= '".$_POST['item']."'";}

if ($_POST['cluster']!="0")  {$sql.=" AND sosd.`cl`= '".$_POST['cluster']."'";}

if ($_POST['branch']!="0")  {$sql.=" AND sosd.`bc`= '".$_POST['branch']."'";}


$query=$this->db->query($sql);
$r_detail['profit']=$query->result();


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