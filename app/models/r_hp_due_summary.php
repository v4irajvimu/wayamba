<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class r_hp_due_summary extends CI_Model{
  private $sd;
  private $mtb;

  private $mod = '003';

  function __construct(){
    parent::__construct();
    $this->sd = $this->session->all_userdata();
    $this->load->database($this->sd['db'], true);
  }

  public function base_details(){
    $a ='';
    return $a;
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

    $r_detail['customer']=$_POST['cus_id'];
    $r_detail['cus_name']=$_POST['customer'];
    $r_detail['agreemnt_no']=$_POST['agreemnt_no'];
    $r_detail['salesman']=$_POST['salesman_id'];
    $r_detail['s_name']=$_POST['salesman'];
   
    

    $sql="SELECT  s.cl,
                  s.bc,
                  s.agreement_no,
                  CONCAT(s.cus_id,' - ',c.name) AS customer ,
                  s.nno,
                  t.`due_date`,
                  SUM(t.cr) AS cr, 
                  SUM(t.dr) AS dr,
                  SUM(t.dr)-SUM(t.cr) AS balance,
                  s.agreement_no
          FROM t_hp_sales_sum s
          JOIN `t_ins_trans` t ON s.cl=t.cl AND s.bc=t.bc AND s.agreement_no = t.agr_no
          JOIN m_customer c ON c.code = s.cus_id
          WHERE s.cl = '".$this->sd['cl']."' 
          AND s.bc = '".$this->sd['branch']."' 
          AND t.due_date BETWEEN '".$_POST['from']."' AND '".$_POST['to']."'        
        "; 

    if($_POST['cus_id']!=""){
      $sql.=" AND s.cus_id ='".$_POST['cus_id']."' ";
    }  
    if($_POST['agreemnt_no']!=""){
      $sql.=" AND s.agreement_no  ='".$_POST['agreemnt_no']."' ";
    } 
    if($_POST['salesman_id']!=""){
      $sql.=" AND s.rep  ='".$_POST['salesman_id']."' ";
    } 


    $sql.=" GROUP BY s.cl,s.bc,s.agreement_no
            HAVING balance>0
            ORDER BY t.due_date ";
    
    $query = $this->db->query($sql); 

    $r_detail['result'] = $query->result();
    if($query->num_rows()>0){
      $this->load->view($_POST['by'].'_'.'pdf',$r_detail);
    }else{
      echo "<script>alert('No Data');window.close();</script>";
    }


  }
}