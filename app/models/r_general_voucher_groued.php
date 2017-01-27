<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class r_general_voucher_groued extends CI_Model{

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

    $cl=$this->sd['cl'];
    $bc=$this->sd['branch'];

    $r_detail['page']='A4';
    $r_detail['orientation']='L';  
    $r_detail['card_no']=$_POST['card_no1'];
    $r_detail['dfrom']=$_POST['from'];
    $r_detail['dto']=$_POST['to'];

    
    $sql="SELECT s.cl,c.description as cl_name,s.bc,b.name as b_name,dd.nno,dd.sub_no,s.ddate,s.note,dd.acc_code,a.`description` AS acc,dd.amount 
    FROM `t_voucher_gl_sum` s
    JOIN (SELECT d.cl,d.bc,d.nno,d.sub_no,d.acc_code,d.amount FROM `t_voucher_gl_det` d GROUP BY d.cl,d.bc,d.nno,d.`acc_code`)dd ON 
    dd.cl=s.cl AND dd.bc=s.bc AND dd.nno=s.nno
    JOIN m_account a ON a.`code`=dd.acc_code
    JOIN m_branch b on b.bc=s.bc
    JOIN m_cluster c on c.code=s.cl
    WHERE s.`is_cancel`!='1' AND s.`ddate` BETWEEN '".$_POST['from']."' AND '".$_POST['to']."' 
    AND s.`cl` = '$cl' AND s.`bc` = '$bc'
    ORDER BY acc_code";


    $r_detail['details']=$this->db->query($sql)->result();       
    
    if($this->db->query($sql)->num_rows()>0)
    {
      $this->load->view($_POST['by'].'_'.'pdf',$r_detail);
    }
    else
    {
      echo "<script>alert('No Data');window.close();</script>";
    }
  }
}