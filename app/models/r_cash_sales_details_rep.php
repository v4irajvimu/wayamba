<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class r_cash_sales_details_rep extends CI_Model{

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

      $r_detail['category_field']=$_POST['sales_category'];


      if($_POST['cluster']!="0"){
        $scl1=" AND s.cl= '".$_POST['cluster']."' ";
    }else{
        $scl1="";
    }

    if($_POST['branch']!="0"){
        $sbc1=" AND s.bc= '".$_POST['branch']."' ";
    }else{
        $sbc1="";
    }

    if($_POST['sales_category']!="0"){
        $cat="s.category ='".$_POST['sales_category']."'";
    }else{
        $cat="";
    }

    if($_POST['rep']!=""){
        $rep="AND s.rep ='".$_POST['rep']."'";
    }else{
        $rep="";
    }

    $sql="SELECT  s.`nno`,
    s.`sub_no`,
    d.`code`,
    i.`description` AS item,
    s.`rep`,
    d.`qty`,
    d.price,
    s.`cus_id`,
    s.`store`,
    e.`name` AS rep_name,
    c.`name` AS cus_name,
    s.`ddate`,
   (d.price * d.`qty`) AS gross_amount,
    (d.discount * (d.`qty` - d.foc) ) AS discount,
    (d.price * d.`qty`) - (d.discount * (d.`qty` - d.foc) ) AS net_amount,
    s.additional_add,
    s.additional_deduct
    FROM `t_cash_sales_sum` s
    JOIN t_cash_sales_det d ON d.`nno`=s.nno AND d.`cl`=s.cl AND d.bc=s.`bc`
    JOIN m_employee e ON e.`code` = s.rep    
    JOIN m_customer c ON c.`code` = s.cus_id   
    JOIN m_item i ON i.code=d.`code`    
    WHERE s.is_cancel='0' AND s.`ddate` BETWEEN '".$_POST['from']."' AND '".$_POST['to']."' 
    $scl1 $sbc1 $cat $rep
    GROUP BY s.nno,d.code 
    ORDER BY s.rep";
    

    $query=$this->db->query($sql);
    $r_detail['data'] = $query->result();

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