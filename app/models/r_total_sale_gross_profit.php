<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class r_total_sale_gross_profit extends CI_Model 
{

  private $sd;
  private $w = 210;
  private $h = 297;

  private $mtb;
  private $tb_client;
  private $tb_branch;

  function __construct()
  {
    parent::__construct();
    $this->sd = $this->session->all_userdata();
    $this->load->database($this->sd['db'], true);
  }

  public function base_details(){
		//return $a;
  }


  public function PDF_report($RepTyp=""){
    $r_detail['type']=$_POST['type'];
    $r_detail['page']=$_POST['page'];
    $r_detail['header']=$_POST['header'];
    $r_detail['orientation']="L";
    $r_detail['type']="";
    $r_detail['to']=$_POST['to'];
    $r_detail['from']=$_POST['from'];
    $cluster=$_POST['cluster'];
    $branch =$_POST['branch'];
    $items    =$_POST['item'];
    $to_date=$_POST['to'];
    $f_date =$_POST['from'];
    $r_detail['cluster']=$_POST['cluster'];
    $r_detail['branchs']=$_POST['branch'];
    $r_detail['item']=$_POST['item'];
    $r_detail['item_des']=$_POST['item_des'];


    if($cluster!="0"){
      $cl=" AND s.cl='$cluster'";
    }else{
      $cl=" ";
    }

    if($branch !="0"){
      $bc=" AND s.bc='$branch'";
    }else{
      $bc=" ";
    }

    if(!empty($items)){
      $item=" AND c.code='$items'";
      $item1=" AND c.item_code='$items'";
      $item2=" AND m.code='$items'";
    }else{
      $item=" ";
      $item1=" ";
      $item2=" ";
    }

    $this->db->select(array('name','address','tp','fax','email'));
    $this->db->where("cl",$this->sd['cl']);
    $this->db->where("bc",$this->sd['branch']);
    $r_detail['branch']=$this->db->get('m_branch')->result();

    $this->db->select(array('description','code'));
    $this->db->where("code",$_POST['cluster']);
    $r_detail['clus']=$this->db->get('m_cluster')->row()->description;

    $this->db->select(array('name','bc'));
    $this->db->where("bc",$_POST['branch']);
    $r_detail['bran']=$this->db->get('m_branch')->row()->name;

    $sql="  SELECT 
    m.`code`,
    m.`description`,
    IFNULL(cs.qty, 0) AS cash_qty,
    IFNULL(css.qty, 0) AS credit_qty,
    IFNULL(cc.qty, 0) AS card_qty,
    IFNULL(so.qty, 0) AS so_qty,
    IFNULL(hp.qty, 0) AS hp_qty,
    IFNULL(IFNULL(cs.qty, 0) + IFNULL(css.qty, 0) + IFNULL(cc.qty, 0) + IFNULL(so.qty, 0) + IFNULL(hp.qty, 0),0) AS tot_qty,m.`purchase_price` AS cost,m.`max_price`,
    (m.`purchase_price` * IFNULL(IFNULL(cs.qty, 0) + IFNULL(css.qty, 0) + IFNULL(cc.qty, 0) + IFNULL(so.qty, 0) + IFNULL(hp.qty, 0),0)) AS cost_value,
    (IFNULL(IFNULL(cs.amount, 0) + IFNULL(css.amount, 0) + IFNULL(cc.amount, 0) + IFNULL(so.amount, 0) + IFNULL(hp.amount, 0),0)) AS amount,
    IFNULL(cs.discount, 0) + IFNULL(css.discount, 0) + IFNULL(cc.discount, 0) + IFNULL(so.discount, 0) + IFNULL(hp.discount, 0) AS discount,
    (m.`max_price` * IFNULL(IFNULL(cs.qty, 0) + IFNULL(css.qty, 0) + IFNULL(cc.qty, 0) + IFNULL(so.qty, 0) + IFNULL(hp.qty, 0),0)) AS sales_value,
    (IFNULL(IFNULL(cs.amount, 0) + IFNULL(css.amount, 0) + IFNULL(cc.amount, 0) + IFNULL(so.amount, 0) + IFNULL(hp.amount, 0),0)) - (m.`purchase_price` * IFNULL(IFNULL(cs.qty, 0) + IFNULL(css.qty, 0) + IFNULL(cc.qty, 0) + IFNULL(so.qty, 0) + IFNULL(hp.qty, 0),0)) AS profit 
    FROM m_item m
    LEFT JOIN (SELECT `code`,SUM(qty) AS qty,c.amount,c.discount  FROM t_cash_sales_det c  JOIN t_cash_sales_sum s ON s.cl = c.cl AND s.bc = c.bc AND s.nno =c.nno WHERE s.ddate BETWEEN '$f_date' AND '$to_date' $cl $bc $item AND s.`is_cancel` != '1' GROUP BY c.code) cs ON cs.code=m.code 
    LEFT JOIN (SELECT `code`,SUM(qty) AS qty,c.amount,c.discount  FROM t_credit_sales_det c  JOIN t_credit_sales_sum s ON s.cl = c.cl AND s.bc = c.bc AND s.nno =c.nno WHERE s.ddate BETWEEN '$f_date' AND '$to_date' $cl $bc $item AND s.`is_cancel` != '1' GROUP BY c.code) css ON css.code=m.code 
    LEFT JOIN (SELECT `code`,SUM(qty) AS qty,c.amount,c.discount  FROM t_cash_and_card_sales_det c  JOIN t_cash_and_card_sales_sum s ON s.cl = c.cl AND s.bc = c.bc AND s.nno =c.nno WHERE s.ddate BETWEEN '$f_date' AND '$to_date' $cl $bc $item AND s.`is_cancel` != '1' GROUP BY c.code) cc ON cc.code=m.code 
    LEFT JOIN (SELECT `code`,SUM(qty) AS qty,c.amount,c.discount  FROM t_sales_order_sales_det c  JOIN t_sales_order_sales_sum s ON s.cl = c.cl AND s.bc = c.bc AND s.nno =c.nno WHERE s.ddate BETWEEN '$f_date' AND '$to_date' $cl $bc $item AND s.`is_cancel` != '1'  GROUP BY c.code) so ON so.code=m.code 
    LEFT JOIN (SELECT `item_code`,SUM(qty) AS qty,c.amount,c.discount   FROM t_hp_sales_det c  JOIN t_hp_sales_sum s ON s.cl = c.cl AND s.bc = c.bc AND s.nno =c.nno WHERE s.ddate BETWEEN '$f_date' AND '$to_date' $cl $bc $item1 AND s.`is_cancel` != '1' GROUP BY c.item_code) hp ON hp.item_code=m.code 
    WHERE  m.`code` !='' $item2
    GROUP BY m.code
    Having tot_qty>0 
    ORDER BY m.code";


    $data=$this->db->query($sql); 
    if($data->num_rows()>0){
      $r_detail['r_data']=$data->result();
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
?>