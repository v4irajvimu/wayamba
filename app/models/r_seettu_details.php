
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class r_seettu_details extends CI_Model{
    
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
  

  public function PDF_report(){


  
        
    $this->db->select(array('name','address','tp','fax','email'));
    $this->db->where("bc",$this->sd['branch']);

    $r_detail['branch']=$this->db->get('m_branch')->result();

    $from=$_POST['from'];
    $to=$_POST['to'];
    $cluster=$_POST['cluster'];
    $branch=$_POST['branch_id'];
    $seettu_no=$_POST['seettu_no'];

    $r_detail['page']='A4';
    $r_detail['orientation']='P';  
    $r_detail['dfrom']=$_POST['from'];
    $r_detail['dto']=$_POST['to'];
    
    $sql="SELECT 
              (SELECT COUNT(nno) FROM t_settu_sum) AS Counts,
                t.nno,
                t.ddate,
                t.organizer,
                t.sales_rep,
                MC.name AS org_name,
                M_emp.name AS sales_name,
                d.nno AS item_no,
                d.`value`,
                d.`no_ins`,
                d.`ins_amount`,
                d.`item_code`,
                MI.`name` AS det_item_name 
          FROM `t_settu_sum` AS t
          JOIN m_customer AS MC ON  MC.code=t.organizer 
          JOIN m_employee AS M_emp ON M_emp.code=t.sales_rep
          JOIN t_settu_det AS d ON d.`nno`=t.`nno` AND d.`cl`=t.`cl` AND d.`bc`=d.`bc`
          LEFT JOIN m_settu_item_sum AS MI ON MI.`code`=d.`item_code`
          WHERE t.`ddate` BETWEEN '$from' AND '$to'";
      
      if(!empty($cluster))
      {
          $sql.=" AND d.cl = '$cluster'";
      }
      if(!empty($branch))
      {
          $sql.=" AND d.bc = '$branch'";
      }

      if(!empty($seettu_no))
      {
          $sql.=" AND t.nno = '$seettu_no'";
      }

      $sql.=" ORDER BY t.nno"; 
    
      $query=$this->db->query($sql);

      $r_detail['sum']=$query->result();
     
     
      if($query->num_rows()>0){
        $this->load->view($_POST['by'].'_'.'pdf',$r_detail);

      }else{
        echo "<script>alert('No Data');window.close();</script>";
      }
  }
}