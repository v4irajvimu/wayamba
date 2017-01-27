<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class m_customer_inquiries extends CI_Model {

  private $sd;
  private $mtb;

  function __construct(){
    parent::__construct();

    $this->sd = $this->session->all_userdata();
    $this->load->database($this->sd['db'], true);
    $this->mtb = 'm_customer_inquiries';
    $this->load->model('user_permissions');
  }

  public function base_details(){
    $a="";
    return $a;
  }

  public function validation() {
    $this->max_no = $this->utility->get_max_no("m_customer_inquiries", "nno");
    $status = 1;

    return $status;
  }

  public function save(){
    $this->db->trans_begin();
    error_reporting(E_ALL); 
    function exceptionThrower($type, $errMsg, $errFile, $errLine) { 
      throw new Exception($errMsg); 
    }
    set_error_handler('exceptionThrower'); 
    try { 
      $validation_status = $this->validation();
      if ($validation_status == 1){
        $a=array(
          "cl"              =>$this->sd['cl'],
          "bc"              =>$this->sd['branch'],
          "nno"             =>$this->max_no,
          "customer"        =>$_POST['cus_id'],
          "action"          =>$_POST['act'],
          "officer"         =>$_POST['officer'],
          "note"            =>$_POST['note'],
          "promiss_date"    =>$_POST['p_date'],
          "salary_date"     =>$_POST['s_date'],
          "amount"          =>$_POST['amount'],
          "oc"              =>$this->sd['oc']
          );

        if($_POST['hid'] == "0" || $_POST['hid'] == "") {
          if($this->user_permissions->is_add('m_customer_inquiries')){
            $this->db->insert('m_customer_inquiries', $a);
            echo $this->db->trans_commit();
          }else{
            $this->db->trans_commit();
            echo "No permission to save records";
          }
        }else{             
          if($this->user_permissions->is_edit('m_customer_inquiries')){
            $this->db->where("cl", $this->sd['cl']);
            $this->db->where("bc",$this->sd['branch']);
            $this->db->where("nno", $this->max_no);
            $this->db->update('m_customer_inquiries', $a);
            echo $this->db->trans_commit();
          }else{
            echo "No permission to edit records";
            $this->db->trans_commit();
          }   
        }  
      }else{
        echo $validation_status;
        $this->db->trans_commit();
      }            
    }catch( Exception $e ){ 
      $this->db->trans_rollback();
      echo "Operation fail please contact admin"; 
    } 
  }

  public function load(){
    $code=$_POST['code'];    
    $sql="SELECT  i.`customer`,
                  c.`name`,
                  c.`address1`,
                  i.nno,
                  i.note,
                  i.`promiss_date`,
                  i.`salary_date`,
                  i.`amount`,
                  i.officer,
                  e.name as emp_name,
                  i.action,
                  a.description as action_des
          FROM m_customer_inquiries i
          JOIN m_customer c ON c.`code` = i.`customer`
          JOIN m_employee e ON e.`code` = i.`officer`
          JOIN r_customer_action a ON a.`code` = i.`action`
          WHERE i.cl='".$this->sd['cl']."' 
          AND i.bc='".$this->sd['branch']."' 
          AND i.nno='$code'";
    $query=$this->db->query($sql);
    if($query->num_rows()>0){
      $result = $query->result();
    }else{
      $result = 2;
    }
    echo json_encode($result);
  }

  public function customer_history(){
    $cus=$_POST['customer'];
    $sql="SELECT  i.`customer`,
                  c.`name`,
                  c.`address1`,
                  i.nno,
                  i.action,
                  i.note,
                  i.`promiss_date`,
                  i.`salary_date`,
                  i.`amount`,
                  e.name as emp_name
          FROM m_customer_inquiries i
          JOIN m_customer c ON c.`code` = i.`customer`
          JOIN m_employee e ON e.`code` = i.`officer`
          WHERE i.cl='".$this->sd['cl']."' 
          AND i.bc='".$this->sd['branch']."' 
          AND i.customer='$cus'
          AND is_cancel='0'";
    $query=$this->db->query($sql);
    if($query->num_rows()>0){
      $result = $query->result();
    }else{
      $result = 2;
    }
    echo json_encode($result);
  }

  public function delete(){
    $this->db->trans_begin();
    error_reporting(E_ALL); 
    function exceptionThrower($type, $errMsg, $errFile, $errLine) { 
      throw new Exception($errMsg); 
    }
    set_error_handler('exceptionThrower'); 
    try { 
      if($this->user_permissions->is_delete('m_customer_inquiries')){
          $this->db->where('cl',$this->sd['cl']);
          $this->db->where('bc',$this->sd['branch']);
          $this->db->where('nno', $_POST['code']);
          $this->db->update('m_customer_inquiries',array("is_cancel"=>1));
          echo $this->db->trans_commit();
      }else{
       echo "No permission to delete records";
     }
   } catch ( Exception $e ) { 
    $this->db->trans_rollback();
    echo $e->getMessage()."Operation fail please contact admin"; 
  } 
}



}