<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class r_total_sale_summary extends CI_Model{

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
    $r_detail['rep']=$_POST['emp'];


    if(!empty($item))
    {
      $item_code_cash= 'AND ca.code=$item';
      $item_code_credit='AND cr.code=$item';
      $item_code_hp='AND hs.item_code=$item';
    }

    if(!empty($_POST['emp']))
    {
      $emp_cash= 'AND css.rep="'.$_POST['emp'].'"';
      $emp_credit='AND crs.rep="'.$_POST['emp'].'"';
      $emp_hp='AND hss.rep="'.$_POST['emp'].'"';
    }

    if(!empty($_POST['cus']))
    {
      $cus_cash= 'AND css.cus_id="'.$_POST['cus'].'"';
      $cus_credit='AND crs.cus_id="'.$_POST['cus'].'"';
      $cus_hp='AND hss.cus_id="'.$_POST['cus'].'"';
    }


    $sql="SELECT ca.cl,ca.bc,ca.nno,css.ddate,ca.code,i.`description` AS item_name,ca.`batch_no`,ca.qty,ca.price,ca.discount,ca.amount,'4' AS tr_code,css.`cus_id`,mc.`name` AS cus
    FROM `t_cash_sales_det` ca
    JOIN `t_cash_sales_sum` css ON css.nno=ca.`nno` AND css.cl=ca.cl AND css.bc=ca.`bc`
    JOIN m_item i ON i.code=ca.`code`
    JOIN m_customer mc ON mc.`code`=css.`cus_id`
    WHERE ca.`cl`='".$this->sd['cl']."' AND ca.`bc`= '".$this->sd['branch']."'
    AND css.`ddate` between '".$_POST['from']."' AND '".$_POST['to']."' $item_code_cash $emp_cash $cus_cash AND is_cancel!='1'
    GROUP BY ca.code,ca.nno
    UNION ALL
    SELECT cr.cl,cr.bc,cr.nno,crs.ddate,cr.code,i.`description` AS item_name,cr.`batch_no`,cr.qty,cr.price,cr.discount,cr.amount,'5' AS tr_code,  crs.`cus_id`,mc.`name` AS cus
    FROM `t_credit_sales_det` cr
    JOIN `t_credit_sales_sum` crs ON crs.nno=cr.`nno` AND crs.cl=cr.cl AND crs.bc=cr.`bc`
    JOIN m_item i ON i.code=cr.`code`
    JOIN m_customer mc ON mc.`code`=crs.`cus_id`
    WHERE cr.`cl`='".$this->sd['cl']."' AND cr.`bc`= '".$this->sd['branch']."'
    AND crs.`ddate` between '".$_POST['from']."' AND '".$_POST['to']."' $item_code_credit $emp_credit  $cus_credit AND is_cancel!='1'
    GROUP BY cr.code,cr.nno
    UNION ALL
    SELECT hs.cl,hs.bc,hs.nno,hss.ddate,hs.item_code,i.`description` AS item_name,hs.`batch_no`,hs.qty,hs.sales_price AS price,hs.discount,hs.amount,'6' AS tr_code,  hss.`cus_id`,mc.`name` AS cus
    FROM `t_hp_sales_sum` hss
    JOIN `t_hp_sales_det` hs ON hss.nno=hs.`nno` AND hss.cl=hs.cl AND hss.bc=hs.`bc`
    JOIN m_item i ON i.code=hs.`item_code`
    JOIN m_customer mc ON mc.`code`=hss.`cus_id`
    WHERE hs.`cl`='".$this->sd['cl']."' AND hs.`bc`= '".$this->sd['branch']."'
    AND hss.`ddate` between '".$_POST['from']."' AND '".$_POST['to']."' $item_code_hp $emp_hp $cus_hp AND is_cancel!='1'
    GROUP BY hs.item_code,hs.nno
    ORDER BY tr_code";

    $data=$this->db->query($sql);
    if($this->db->query($sql)->num_rows()>0){
      $r_detail['value']=$data->result();
      $this->load->view($_POST['by'].'_'.'pdf',$r_detail);

    }else{
      echo "<script>alert('No Data');window.close();</script>";
    }
  }
}
