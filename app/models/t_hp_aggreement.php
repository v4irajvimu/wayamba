<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class t_hp_aggreement extends CI_Model {    


  function __construct(){
    parent::__construct();    
    $this->sd = $this->session->all_userdata();
    $this->load->database($this->sd['db'], true);
    $this->load->model('utility');
    $this->load->helper(array('form', 'url'));

  }


  public function base_details(){

  }

  public function PDF_report(){

    $this->db->select(array('name', 'address', 'tp', 'fax','email'));
    $this->db->where("bc", $this->sd['branch']);
    $r_detail['branch'] = $this->db->get('m_branch')->result();

    $r_detail['type'] = $_POST['type'];
    $r_detail['dt'] = $_POST['dt'];
    $r_detail['qno'] = $_POST['qno'];

    $r_detail['page'] = "A5";
    $r_detail['header'] = $_POST['header'];
    $r_detail['orientation'] = "L";

    $this->db->select(array('code', 'name', 'address1', 'address2', 'address3'));
    $this->db->where("code", $_POST['cus_id']);
    $r_detail['customer'] = $this->db->get('m_customer')->result();

  

    $sql = "SELECT
    m.`description`,
    dt.`item_code`,
    sm.`agreement_no`,
    sm.`ddate`,
    mc.`name` AS cus_name,
    mc.`address1`,
    mc.`address2`,
    mc.`address3`,
    mc.`tp`,
    mc.`nic`

    FROM t_hp_sales_sum sm 
    JOIN t_hp_sales_det dt 

    ON dt.`cl` = sm.`cl` 
    AND dt.`bc` = sm.`bc` 
    AND dt.`nno` = sm.`nno` 
    JOIN m_customer mc ON mc.`code`= sm.`cus_id`
    JOIN m_item m 
    ON m.`code` = dt.`item_code` 
    WHERE dt.`cl` = '".$this->sd['cl']."' 
    AND dt.bc = '".$this->sd['branch']."' 
    AND dt.`nno` = '".$_POST['qno1']."' ";

    $query = $this->db->query($sql);
    $r_detail['items'] = $this->db->query($sql)->result();



    $sql2 = "SELECT
    mg.`address1` AS gur1_addr1,
    mg.`address2` AS gur1_addr2,
    mg.`address3` AS gur1_addr3,
    mgg.`address1` AS gur2_addr1, 
    mgg.`address2` AS gur2_addr2,
    mgg.`address3` AS gur2_addr3,
    mg.`tp` AS  gur1_tp,
    mgg.`tp` AS gur2_tp,
    mg.`name` AS gur1_name,
    mgg.`name` AS gur2_name
    FROM t_hp_sales_sum sm
    JOIN m_guarantor mg ON mg.`code`= sm.`guarantor_01` 
    JOIN m_guarantor mgg ON mgg.`code`  = sm.`guarantor_02`
    WHERE sm.`agreement_no` = '".$_POST['aggr_no']."'";

    $query1 = $this->db->query($sql2);
    $r_detail['gurantor'] = $this->db->query($sql2)->result();

    $sql3 = "SELECT aggreement FROM t_hp_sales_sum LIMIT 1 ";

    $query2 = $this->db->query($sql3);
    $r_detail['agreement'] = $this->db->query($sql3)->first_row()->aggreement;

   /* $this->db->select(array('t_hp_sales_sum.oc', 's_users.discription'));
    $this->db->from('t_hp_sales_sum');
    $this->db->join('s_users', 't_hp_sales_sum.oc=s_users.cCode');
    $this->db->where('t_hp_sales_sum.cl', $this->sd['cl']);
    $this->db->where('t_hp_sales_sum.bc', $this->sd['branch']);
    $this->db->where('t_hp_sales_sum.nno', $_POST['qno']);
    $r_detail['user'] = $this->db->get()->result();*/

    if($query->num_rows()>0){
       $this->load->view($_POST['by'] . '_' . 'pdf', $r_detail);
     }else{
      echo "<script>alert('No Data');window.close();</script>";
     }

  }





}
