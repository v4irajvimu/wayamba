
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class r_seettu_history extends CI_Model{
    
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
            s.`nno`,
            s.`ddate`,
            s.`book_no`,
            s.`book_edition`,
            s.`organizer`,
            s.`sales_rep`,
            s.`description`,
            me.`name` AS salaeman_name,
            mc.`name` AS Organizer_name,
            mc.`address1`,
            mc.`address2`,
            mc.`address3`
          FROM `t_settu_sum` s
          LEFT JOIN t_settu_det d ON s.nno=d.nno AND s.`cl`=d.`cl` AND s.`bc`=d.`cl`
          JOIN m_employee me ON me.`code`=s.`sales_rep`
          JOIN m_customer mc ON mc.`code`=s.`organizer` 
          WHERE s.`nno`='$seettu_no'";
      
      if(!empty($cluster))
      {
          $sql.=" AND s.cl = '$cluster'";
      }
      if(!empty($branch))
      {
          $sql.=" AND s.bc = '$branch'";
      }

      $sql_1="SELECT 
                  d.`nno`,
                  d.`item_code` As item_cat,
                  d.`value`,
                  d.`no_ins`,
                  d.`ins_amount`,
                  ss.`code`,
                  ss.`name` As discription,
                  ss.`item_value`,
                  sd.`item_code`,
                  sd.`qty`,
                  sd.`item_max_price`,
                  mi.`description` AS dis
                FROM `t_settu_sum` s
                LEFT JOIN t_settu_det d ON s.nno=d.nno AND d.`cl`=s.`cl` AND d.`bc`=s.`bc` 
                LEFT JOIN m_settu_item_sum ss ON ss.`code`=d.`item_code`
                JOIN m_settu_item_det sd ON sd.`category_code`=d.`item_code` AND sd.`cl`=ss.`cl` AND sd.`bc`=ss.`bc` AND sd.`no`=ss.`no`
                JOIN m_item mi ON mi.`code`=sd.`item_code`
                 WHERE s.`nno`='$seettu_no'";

      if(!empty($cluster))
      {
          $sql_1.=" AND d.cl = '$cluster'";
      }
      if(!empty($branch))
      {
          $sql_1.=" AND d.bc = '$branch'";
      }

       $query_1=$this->db->query($sql_1);

      // if(!empty($seettu_no))
      // {
      //     $sql.=" AND t.nno = '$seettu_no'";
      // }

      //$sql.=" ORDER BY t.nno"; 
    
      $query=$this->db->query($sql);

      $r_detail['sum']=$query->result();
      $r_detail['det']=$query_1->result();
     
     
      if($query->num_rows()>0){
        $this->load->view($_POST['by'].'_'.'pdf',$r_detail);

      }else{
        echo "<script>alert('No Data');window.close();</script>";
      }
  }
}