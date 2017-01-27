<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class r_int_tr_rec_sum extends CI_Model{
    
  private $sd;
  private $mtb;
  
  private $mod = '003';
  
  function __construct(){
  parent::__construct();

  $this->sd = $this->session->all_userdata();
  $this->load->database($this->sd['db'], true);
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
    $r_detail['dfrom']=$_POST['from'];
    $r_detail['dto']=$_POST['to'];
    $r_detail['cl']=$_POST['cluster'];
    $r_detail['bc']=$_POST['branch'];


     $query = $this->db->query("SELECT 
                s.cl AS to_cl,
                s.bc AS to_bc,
                c1.`description` AS to_cl,
                b1.`name` AS to_bc_name,
                s.nno,
                s.ddate,
                s.store,
                ms.`description` AS sto_name,
                s.sub_no,
                s.vehicle,
                ms1.`description` AS lo_st,
                s.driver,
                me2.`name` AS hel,
                ss.order_no,
                ss.cl,
                ss.bc,
                ss.f_b_name,
                j.tot_amount
              FROM
                t_internal_transfer_sum s 
                JOIN `m_cluster` c1 ON c1.`code` = s.`cl` 
                JOIN `m_branch` b1 ON b1.bc = s.`bc` 
                JOIN (SELECT d.*,b.`name` AS f_b_name 
              FROM
                t_internal_transfer_sum d 
                JOIN m_branch b ON b.`bc` = d.`bc`) ss ON ss.nno = s.`ref_trans_no` AND ss.to_bc = s.bc 
                JOIN m_stores ms ON ms.`code` = s.`store` 
                Left JOIN m_vehicle_setup mv ON mv.`code` = s.`vehicle` 
                JOIN m_stores ms1 ON ms1.`code` = s.`location_store` 
                Left JOIN m_employee me1 ON me1.`code`=s.`driver`
                Left JOIN m_employee me2 ON me2.`code`=s.`helper`
                JOIN `t_internal_transfer_det` de ON de.`nno`=s.`nno` AND de.`bc`=s.`bc` AND de.`cl`=s.`cl`
                JOIN m_item i ON i.`code`=de.`item_code`
                JOIN(SELECT cl,bc,nno,SUM(item_cost*qty) AS tot_amount FROM t_internal_transfer_det GROUP BY cl,bc,nno)j ON j.cl=s.`cl` AND j.bc=s.bc AND j.nno=s.`nno`
              WHERE s.trans_code = '43'  
              AND s.ddate between'".$_POST['from']."' AND '".$_POST['to']."' AND s.cl='".$_POST['cluster']."' AND s.bc='".$_POST['branch']."' 
              ORDER BY s.nno");
            
      $r_detail['rec_sum']=$query->result();  

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