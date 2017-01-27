<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class r_seettu_invoice extends CI_Model {
    
    private $sd;
    private $mtb;
    private $mod = '003';
    private $max_no;
    
    function __construct(){
	parent::__construct();
	
	$this->sd = $this->session->all_userdata();
	$this->load->database($this->sd['db'], true);
	$this->load->model('user_permissions');
  
        

    }
    
    public function base_details(){

      
    }

    public function f1_load_vehicle(){

      if($_POST['search'] == 'Key Word: code, name'){$_POST['search'] = "";}  

      $sql="SELECT code,description FROM m_vehicle_setup 
              WHERE (code LIKE '%".$_POST['search']."%' OR description LIKE '%".$_POST['search']."%') 
                AND cl = '".$this->sd['cl']."' 
                AND bc = '".$this->sd['branch']."'
              LIMIT 25";

        $query = $this->db->query($sql);
        
        $a  = "<table id='item_list' style='width : 100%' >";
        $a .= "<thead><tr>";
        $a .= "<th class='tb_head_th'>Code</th>";
        $a .= "<th class='tb_head_th'>Name</th>";
        $a .= "</thead></tr><tr class='cl'><td>&nbsp;</td><td>&nbsp;</td></tr>";
        
        foreach($query->result() as $r){
          
          $a .= "<tr class='cl'><td>".$r->code."</td>";
          $a .= "<td>".$r->description."</td>";
          $a .= "</tr>";
        }

          $a .= "</table>";
          echo $a;
  }

 public function PDF_report(){
         
      $r_detail['no']=$_POST['nno'];
      $r_detail['page']=$_POST['page'];
      $r_detail['header']=$_POST['header'];
      $r_detail['orientation']=$_POST['orientation'];
      $from=$_POST['from'];
      $to=$_POST['to'];
      $cluster=$_POST['cluster'];
      $branch=$_POST['branch_id'];
      $customer=$_POST['cus_id'];
      $salesman=$_POST['salesman_id'];
      $c_officer=$_POST['c_officer_id'];
      $route=$_POST['route_id'];
      $vehicle=$_POST['vehicle_id'];
      $seettu=$_POST['seettu_no'];


      $this->db->select(array('name','address','tp','fax','email'));
      $this->db->where("cl",$this->sd['cl']);
      $this->db->where("bc",$this->sd['branch']);
      $r_detail['branch']=$this->db->get('m_branch')->result();

      $this->db->select(array('name','address','tp','fax','email'));
      $this->db->where("cl",$this->sd['cl']);
      $this->db->where("bc",$r_detail['ship_to_bc']);
      $r_detail['ship_branch']=$this->db->get('m_branch')->result();

      $sql="SELECT
                  seettu_no,
                  organizer_no,
                  c.name AS organizer,
                  s.`vehicle_no`,
                  s.`driver`,
                  e.`name` as driv, 
                  s.salesman,
                  e.`name` as salesm,
                  s.route,
                  r.`description` route,
                  i.`name` AS item,
                  s.c_officer,
                  e.`name` as c_off,
                  price,
                  installement,
                  addit_charge,
                  no_of_ins,
                  paid,
                  s.`ddate`
                  FROM
                  t_seettu_inv_det d 
                  JOIN m_customer c 
                  ON c.`code` = d.`organizer_no` 
                  JOIN m_settu_item_sum i 
                  ON i.`code` = d.`item` 
                  JOIN t_seettu_inv_sum s 
                  ON s.`nno`=d.`nno`
                  JOIN m_employee e ON e.`code`=s.`driver`
                  JOIN m_employee q ON q.`code`=s.`salesman`
                  JOIN m_employee w ON w.`code`=s.`c_officer`
                  join r_root r on r.`code`=s.`route`
                  WHERE s.`ddate` BETWEEN '$from' AND '$to'";


        if(!empty($cluster))
        {
            $sql.=" AND d.cl = '$cluster'";
        }
        if(!empty($branch))
        {
            $sql.=" AND d.bc = '$branch'";
        } 
        if(!empty($customer))
        {
            $sql.=" AND d.organizer_no = '$customer'";
        } 
        if(!empty($salesman))
        {
            $sql.=" AND s.salesman = '$salesman'";
        } 
        if(!empty($c_officer))
        {
            $sql.=" AND s.c_officer = '$c_officer'";
        } 
        if(!empty($route))
        {
            $sql.=" AND s.route = '$route'";
        } 
        if(!empty($vehicle))
        {
            $sql.=" AND s.vehicle_no = '$vehicle'";
        } 
        if(!empty($seettu))
        {
            $sql.=" AND d.seettu_no = '$seettu'";
        } 
        $sql.="group by seettu_no";


      
      $query=$this->db->query($sql);
      if($query->num_rows>0){
        $r_detail['det']=$query->result();
        $this->load->view($_POST['by'].'_'.'pdf',$r_detail);
      
      }else{
          echo "<script>alert('No data found ');close();</script>";
      }
    
  }



}