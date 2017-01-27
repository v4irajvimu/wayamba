<?php
if (!defined('BASEPATH'))
  exit('No direct script access allowed');

class t_guarantor_change extends CI_Model{
  
  private $sd;
  private $mtb;
  
  private $mod = '003';
  
  function __construct(){
    parent::__construct();
    
    $this->sd = $this->session->all_userdata();
    $this->load->database($this->sd['db'], true);
    $this->load->model('user_permissions');
    $this->max_no = 0;
  }
  
    public function base_details(){
        $a['max_no'] = $this->max_no();
        return $a;
    }
    
    public function save(){

        $no = $_POST['no'];
        $date = $_POST['date'];
        $agr_no = $_POST['agreement_no'];        
        $cus_id = $_POST['customer_id'];
        $new_g1 = $_POST['new_g1'];
        $new_g2 = $_POST['new_g2'];
        $oc = $this->sd['oc'];
        $cl = $this->sd['cl'];
        $bc = $this->sd['branch'];

        $g1_old = $_POST['g1_h'];
        $g2_old = $_POST['g2_h'];

        if ($new_g1 == ""){ $new_g1 = $g1_old; }
        if ($new_g2 == ""){ $new_g2 = $g2_old; }
        
        $Q = $this->db->query("INSERT INTO `t_guarantor_change_log` VALUES('','$no','$date','$agr_no','$cus_id','$new_g1','$new_g2',now(),'$oc','$cl','$bc')");
        $Q2= $this->db->query(" UPDATE `t_hp_sales_sum` SET `guarantor_01`='$new_g1',`guarantor_02` ='$new_g2'
                                WHERE cl = '$cl' AND bc = '$bc' AND agreement_no = '$agr_no'");

    }
    
    public function delete(){

    }
  
    public function get_data(){

    }
  
  
  
  public function PDF_report(){        
    $no = $_POST['qno'];
    $r_detail['sum'] = $this->db->query("SELECT * FROM `t_due_day_change_sum` S JOIN m_customer C ON S.`cus_id` = C.`code` WHERE `no` = '$no'")->row();
    $r_detail['det'] = $this->db->query("SELECT * FROM `t_due_day_change_det` WHERE NO = '$no'")->result();

    $this->load->view($_POST['by'] . '_' . 'pdf', $r_detail);
  }



  public function max_no(){
    return $this->db->query("SELECT IFNULL(MAX(NO)+1,1) AS `max_no` FROM t_guarantor_change_log")->row()->max_no;
  }


    public function load_agreement(){
        $agr_no = $_POST['agr_no'];
        $bc     = $this->sd['branch'];
        $cl     = $this->sd['cl'];
        

        $Q = $this->db->query("SELECT `guarantor1` AS `g1`,c1.`name` AS `n1`, `guarantor2` AS `g2` , c2.`name` AS `n2`, g.`date` FROM `t_guarantor_change_log` g LEFT JOIN m_guarantor c1 ON g.`guarantor1` = c1.`code` LEFT JOIN m_guarantor c2 ON g.`guarantor2` = c2.`code` WHERE cl = '$cl' AND bc = '$bc' AND agr_no = '$agr_no' ORDER BY id desc");

        if ($Q->num_rows() > 0){
            $a['g'] = $Q->result();            
        }else{            
            $QQ = $this->db->query("SELECT `guarantor1` AS `g1`,c1.`name` as `n1`,`guarantor2` AS `g2`,c2.`name` as `n2` ,g.`date` FROM `t_guarantor_change_log` g LEFT JOIN m_guarantor c1 ON g.`guarantor1` = c1.`code`LEFT JOIN m_guarantor c2 ON g.`guarantor2` = c2.`code` WHERE cl = '$cl' AND bc = '$bc' AND agr_no = '$agr_no'");
            $a['g'] = $QQ->result();            
        }

        $a['b'] =$this->db->query(" SELECT SS.`agreement_no`,C.code,C.`name`, concat(`address1`,' ',`address2`,' ',`address3`) as `address`,SS.`guarantor_01`,SS.`guarantor_02`
                                    FROM t_hp_sales_sum SS
                                    JOIN m_customer C ON SS.`cus_id` = C.code
                                    WHERE SS.`cl` = '$cl' AND SS.`bc` ='$bc' AND SS.agreement_no = '$agr_no'")->row();
                


        echo json_encode($a);

    }   



    function isValidDate($date){
        $dtInfo = date_parse($date);    
        if($dtInfo['warning_count'] == 0 && $dtInfo['error_count'] == 0 ){
            return true;
        }else{
            return false;
        }
    }


    public function load_data(){
        
        $no = $_POST['no'];
        $Q = $this->db->query("SELECT *,concat(`address1`,' ',`address2`,' ',`address3`) as `address` FROM `t_guarantor_change_log` S JOIN m_customer C ON S.`cus_id` = C.`code` WHERE no = '$no'");

        if ($Q->num_rows() > 0){
            
            $a['sum'] = $Q->row();
            
            $a['a'] = 1;
        }else{
            $a['a'] = 0;
        }

        echo json_encode($a);

    }


  
}