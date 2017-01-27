
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class r_seettu_summery extends CI_Model{
    
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

    $r_detail['page']='A4';
    $r_detail['orientation']='L';  
    $r_detail['dfrom']=$_POST['from'];
    $r_detail['dto']=$_POST['to'];
    // $sql = "SELECT
    //               S_SUM.no,
    //               S_SUM.settu_item_category,
    //               S_SUM.code,
    //               S_SUM.name AS dis,
    //               S_SUM.item_value,
    //               S_SUM.free_item_value,
    //               S_DET.`item_code`,
    //               S_DET.`qty`,
    //               S_DET.`item_max_price`,
    //               M_ITEM.`description`,
    //               CT.`name`
    //           FROM `m_settu_item_sum` AS S_SUM
    //             JOIN m_settu_item_det  S_DET ON
    //              S_DET.`no`=S_SUM.`no` AND
    //              S_DET.`cl`=S_SUM.`cl` AND
    //              S_DET.`bc`=S_SUM.`bc`
    //           LEFT JOIN m_item  AS M_ITEM ON
    //             M_ITEM.`code`=S_DET.`item_code`
    //           LEFT JOIN m_settu_item_category AS CT ON
    //             CT.`code`=S_SUM.`settu_item_category`
    //           WHERE is_cancel = '0' AND S_SUM.settu_item_category='".$_POST['settu_item_category']."'  ";

    //   $query=$this->db->query($sql);
    $sql="SELECT 
            s.`nno`,
            s.`ddate`,
            s.`organizer`,
            s.`sales_rep`,
            s.`value_amount`,
            MC.`name`,
            MC.`address1`,
            MC.`address2`,
            MC.`address3`,
            MC.tp,
           M_emp.name AS sales_name,
            t.no_of_cat
          FROM t_settu_sum AS s
            JOIN m_customer AS MC ON  MC.code=s.organizer 
            JOIN m_employee AS M_emp ON M_emp.code=s.sales_rep
            JOIN (SELECT nno, COUNT(nno) AS no_of_cat FROM t_settu_det GROUP BY nno) t ON  s.`nno`=t.`nno`
          WHERE s.`ddate` BETWEEN '$from' AND '$to'";
      
      if(!empty($cluster))
      {
          $sql.=" AND s.cl = '$cluster'";
      }
      if(!empty($branch))
      {
          $sql.=" AND s.bc = '$branch'";
      } 
    
      $query=$this->db->query($sql);

      $r_detail['sum']=$query->result();
     
     
      if($query->num_rows()>0){
        $this->load->view($_POST['by'].'_'.'pdf',$r_detail);

      }else{
        echo "<script>alert('No Data');window.close();</script>";
      }
  }
}