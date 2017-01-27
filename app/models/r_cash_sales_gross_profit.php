<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class r_cash_sales_gross_profit extends CI_Model{

  private $sd;
  private $mtb;
  
  private $mod = '003';
  
  function __construct(){
    parent::__construct();

    $this->sd = $this->session->all_userdata();

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
    $r_detail['type']='r_cash_sales_gross_profit';

    $qCl = $this->db->get_where('m_supplier', array('code' => $_POST['supplier']))->row_array(0);
    $r_detail['supplier']=(!empty($_POST['supplier']))?$_POST['supplier']." - ".$qCl['name']:"";

    $qCl = $this->db->get_where('m_item', array('code' => $_POST['item']))->row_array(0);
    $r_detail['item']=(!empty($_POST['item']))?$_POST['item']." - ".$qCl['description']:"";

    $qCl = $this->db->get_where('m_cluster', array('code' => $_POST['cluster']))->row_array(0);
    $r_detail['Thcluster']=(!empty($_POST['cluster']))?$_POST['cluster']." - ".$qCl['description']:"";

    $qBc = $this->db->get_where('m_branch', array('bc' => $_POST['branch']))->row_array(0);
    $r_detail['Thbranch']=(!empty($_POST['branch']))?$_POST['branch']." - ".$qBc['name']:"";



    $sql="SELECT
    css.`ddate`
    , csd.`cl`
    , csd.`bc`
    , `m_item`.`supplier`
    , csd.`code`
    , `m_item`.`description`
    , csd.`qty`
    , csd.`cost`
    , csd.`price`,
    csd.`amount`,
    (csd.`qty` * csd.`cost`) AS cost_val,
    (csd.`qty` * csd.`price`) AS sales_val,
    (csd.`qty` * csd.`price`)-csd.`amount` AS discount,
    csd.`amount` - (csd.`qty` * csd.`cost`) AS profit FROM `t_cash_sales_det` csd 
    INNER JOIN `t_cash_sales_sum` css 
    ON (csd.`cl` = css.`cl`) AND (csd.`bc` = css.`bc`) AND (csd.`nno` = css.`nno`)
    INNER JOIN `m_item` 
    ON (csd.`code` = `m_item`.`code`)
    WHERE css.`ddate` BETWEEN '".$_POST['from']."' AND '".$_POST['to']."'";



    if ($_POST['supplier']!="")  {$sql.="AND `m_item`.`supplier`= '".$_POST['supplier']."'";}

    if ($_POST['item']!="")  {$sql.="AND csd.`code`= '".$_POST['item']."'";}

    if ($_POST['cluster']!="0")  {$sql.=" AND csd.`cl`= '".$_POST['cluster']."'";}

    if ($_POST['branch']!="0")  {$sql.=" AND csd.`bc`= '".$_POST['branch']."'";}


    $query=$this->db->query($sql);
    $r_detail['profit']=$query->result();

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