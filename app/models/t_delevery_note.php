<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class t_delevery_note extends CI_Model {

  private $sd;
  private $mtb;
  private $max_no;
  private $mod = '003';

  function __construct() {
    parent::__construct();
    $this->sd = $this->session->all_userdata();
    $this->load->database($this->sd['db'], true);
    $this->load->model('user_permissions');
    $this->load->model('default_settings');
  }

  public function base_details() {
    $this->load->model("utility");
    $a['max_no'] = $this->utility->get_max_no("t_deliver_sum", "nno");
    return $a;
  }

  public function load_delevery_data(){
    $cus_id=$_POST['customer_id'];
    $sql="SELECT t.sub_trans_code AS t_code,
              tc.description AS t_name,
              t.ddate,
              t.sub_trans_no,
              t.item,
              m.description AS item_name,
              SUM(t.`issued_qty`) AS deleverd_qty,
              SUM(t.`deliver_qty`)-SUM(t.`issued_qty`) AS balance
          FROM `t_delivery_trans` t
          JOIN m_item m ON m.code = t.item
          JOIN t_trans_code tc ON tc.`code` = t.`sub_trans_code`
          WHERE t.cl='".$this->sd['cl']."' 
          AND t.`bc`='".$this->sd['branch']."' 
          AND t.`customer`='$cus_id'
          GROUP BY t.cl,t.bc,t.`trans_code`,t.`trans_no`,t.item
          HAVING balance>0
          ORDER BY t.auto_no
          LIMIT 25";  
    $query=$this->db->query($sql);
    if($query->num_rows()>0){
        $a['det']=$query->result();
    }else{
        $a['det']=2;
    }
    echo json_encode($a);
  }

  public function validation() {
    $this->max_no = $this->utility->get_max_no("t_deliver_sum", "nno");
    $status = 1;

    $check_is_delete = $this->validation->check_is_cancel($this->max_no, 't_deliver_sum');
    if ($check_is_delete != 1) {
        return "This delivery note already deleted";
    }

    $customer_validation = $this->validation->check_is_customer($_POST['customer']);
    if ($customer_validation != 1) {
        return "Please enter valid customer";
    }

    $employee_validation = $this->validation->check_is_employer($_POST['driver_id']);
    if ($employee_validation != 1) {
        return "Please enter valid Driver";
    }

    $employee_validation1 = $this->validation->check_is_employer($_POST['helper_id']);
    if ($employee_validation1 != 1) {
        return "Please enter valid Helper";
    }

    return $status;
  }

  public function save(){
    $this->db->trans_begin();
    error_reporting(E_ALL); 
    function exceptionThrower($type, $errMsg, $errFile, $errLine) { 
      throw new Exception($errFile); 
    }
    set_error_handler('exceptionThrower'); 
    try{
      $validation_status = $this->validation();
      if($validation_status == 1){
        $sum=array(
            "cl"        => $this->sd['cl'],
            "bc"        => $this->sd['branch'],
            "nno"       => $this->max_no, 
            "ddate"     => $_POST['date'], 
            "ref_no"    => $_POST['ref_no'], 
            "customer"  => $_POST['customer'], 
            "note"      => $_POST['memo'], 
            "vehicle"   => $_POST['vehicle_no'], 
            "driver"    => $_POST['driver_id'], 
            "helper"    => $_POST['helper_id'] 
        );

        for($x = 0; $x < 25; $x++){
            if (isset($_POST['0_' . $x], $_POST['2_' . $x], $_POST['5_'. $x])) {
                if ($_POST['0_' . $x] != "" && $_POST['2_' . $x] != "" && $_POST['5_'. $x] != "") {
                    $det[] = array(
                      "cl"            => $this->sd['cl'],
                      "bc"            => $this->sd['branch'],
                      "nno"           => $this->max_no,
                      "inv_type"      => $_POST['invtype_'.$x],
                      "inv_date"      => $_POST['n_'.$x],
                      "inv_no"        => $_POST['1_'.$x],    
                      "item"          => $_POST['2_'.$x],
                      "balance"       => $_POST['4_'.$x],
                      "qty"           => $_POST['5_'.$x],
                      "deliverd_qty"  => $_POST['6_'.$x]
                    );

                    $delivery_trans[] = array(
                      "cl"              =>$this->sd['cl'],
                      "bc"              =>$this->sd['branch'],
                      "sub_cl"          =>$this->sd['cl'],
                      "sub_bc"          =>$this->sd['branch'],
                      "ddate"           =>$_POST['date'],
                      "customer"        =>$_POST['customer'],
                      "trans_code"      =>$_POST['invtype_'.$x],
                      "trans_no"        =>$_POST['1_'.$x],
                      "sub_trans_code"  =>112,
                      "sub_trans_no"    =>$this->max_no,
                      "item"            =>$_POST['2_'.$x],
                      "deliver_qty"     =>0,
                      "issued_qty"      =>$_POST['5_'.$x],
                      "oc"              =>$this->sd['oc']
                    );
                }
            }
        }

        if($_POST['hid'] == "0" || $_POST['hid'] == ""){
          if($this->user_permissions->is_add('t_delevery_note')){                    
            $this->db->insert("t_deliver_sum", $sum);
            if(count($det)){
              $this->db->insert_batch("t_deliver_det", $det);
            }
            if(count($delivery_trans)){
              $this->db->insert_batch("t_delivery_trans", $delivery_trans);
            }
            $this->utility->save_logger("SAVE",112,$this->max_no,$this->mod);
            echo $this->db->trans_commit()."@".$this->max_no;
          }else{
            echo "No permission to save records";
            $this->db->trans_commit();
          }    
        }else{
          if($this->user_permissions->is_edit('t_delevery_note')){
            $this->set_delete();

            $this->db->where('nno', $_POST['hid']);
            $this->db->where("cl", $this->sd['cl']);
            $this->db->where("bc", $this->sd['branch']);
            $this->db->update("t_deliver_sum", $sum);

            if(count($det)){
              $this->db->insert_batch("t_deliver_det", $det);
            }
            if(count($delivery_trans)){
              $this->db->insert_batch("t_delivery_trans", $delivery_trans);
            }
            $this->utility->save_logger("EDIT",112,$this->max_no,$this->mod);
            echo $this->db->trans_commit()."@".$this->max_no;
          }else{
            echo "No permission to edit records";    
            $this->db->trans_commit();
          }    
        }
      }else{
        echo $validation_status;
        $this->db->trans_commit();
      }
    }catch(Exception $e){ 
      $this->db->trans_rollback();
      echo $e->getMessage()."Operation fail please contact admin"; 
    }   
  }

  public function set_delete(){
    $this->db->where('nno', $this->max_no);
    $this->db->where("cl", $this->sd['cl']);
    $this->db->where("bc", $this->sd['branch']);
    $this->db->delete("t_deliver_det");

    $this->db->where('sub_trans_code', 112);
    $this->db->where('sub_trans_no', $this->max_no);
    $this->db->where("cl", $this->sd['cl']);
    $this->db->where("bc", $this->sd['branch']);
    $this->db->delete("t_delivery_trans");
  }

  public function load(){
    $res=1;
    $sql_sum="SELECT  s.nno,
                      s.ddate,
                      s.`ref_no`,
                      s.`customer`,
                      c.`name` AS cus_name,
                      CONCAT(c.address1,'-',c.address2,'-',c.address3) AS cus_address,
                      s.`note`,
                      s.`vehicle`,
                      s.`driver`,
                      e.`name` AS driver_name,
                      s.`helper`,
                      ee.`name` AS helper_name,
                      s.is_cancel 
              FROM t_deliver_sum s
              JOIN m_customer c ON s.`customer` = c.`code`
              JOIN m_employee e ON e.`code` = s.`driver`
              JOIN m_employee ee ON ee.`code` = s.`helper`
              WHERE s.cl='".$this->sd['cl']."'
              AND s.bc='".$this->sd['branch']."'
              AND s.`nno`='".$_POST['no']."'";
    $query=$this->db->query($sql_sum);
    if($query->num_rows()>0){
      $a['sum']=$query->result();
    }else{
      $res=2;
    }

    $sql_det="SELECT  d.`inv_type`, 
                      t.`description` AS t_des,
                      d.`inv_date`,
                      d.`inv_no`,
                      d.`item`,
                      m.`description` AS item_name,
                      d.`balance`,
                      d.`qty`,
                      d.`deliverd_qty`
              FROM `t_deliver_det` d
              JOIN m_item m ON m.`code` = d.`item`
              JOIN t_trans_code t ON t.`code` = d.`inv_type`
              WHERE d.`cl`='".$this->sd['cl']."'
              AND d.`bc`='".$this->sd['branch']."'
              AND d.`nno`='".$_POST['no']."'";
    $query=$this->db->query($sql_det);
    if($query->num_rows()>0){
      $a['det']=$query->result();
    }else{
      $res=2;
    }

    if($res!=2){
      echo json_encode($a);
    }else{
      echo json_encode(2);
    }

  }

  public function delete() {
    $this->db->trans_begin();
    error_reporting(E_ALL); 
    function exceptionThrower($type, $errMsg, $errFile, $errLine) { 
      throw new Exception($errMsg); 
    }
    set_error_handler('exceptionThrower'); 
    try {
      if($this->user_permissions->is_delete('t_delevery_note')){
        $bc=$this->sd['branch'];
        $cl=$this->sd['cl'];
        $trans_no=$_POST['trans_no'];

        $this->db->where('nno',$trans_no);
        $this->db->where("cl", $this->sd['cl']);
        $this->db->where("bc", $this->sd['branch']);
        $this->db->update("t_deliver_sum",array("is_cancel"=>1));

        $this->db->where('sub_trans_code', 112);
        $this->db->where('sub_trans_no', $trans_no);
        $this->db->where("cl", $this->sd['cl']);
        $this->db->where("bc", $this->sd['branch']);
        $this->db->delete("t_delivery_trans");

        $this->utility->save_logger("CANCEL",112,$_POST['trans_no'],$this->mod);
        echo $this->db->trans_commit();
      }else{
        $this->db->trans_commit();
        echo "No permission to delete records";
      }  
    }catch(Exception $e){ 
      $this->db->trans_rollback();
      echo $e->getMessage()." - Operation fail please contact admin"; 
    } 
  }

  public function PDF_report() {
    $this->db->select(array(
      'name',
      'address',
      'tp',
      'fax',
      'email'
    ));
    $this->db->where("cl", $this->sd['cl']);
    $this->db->where("bc", $this->sd['branch']);
    $r_detail['branch']        = $this->db->get('m_branch')->result();
    
    $r_detail['qno']           = $_POST['qno'];
    $r_detail['page']          = "A5";
    $r_detail['orientation']   = "L";

    $invoice_number= $this->utility->invoice_format($_POST['qno']);
        $session_array = array(
             $this->sd['cl'],
             $this->sd['branch'],
             $invoice_number
        );
    $r_detail['session'] = $session_array;

    $sql_sum="SELECT  s.nno,
                      s.ddate,
                      s.`ref_no`,
                      s.`customer`,
                      c.`name` AS cus_name,
                      CONCAT(c.address1,'-',c.address2,'-',c.address3) AS cus_address,
                      s.`note`,
                      s.`vehicle`,
                      s.`driver`,
                      e.`name` AS driver_name,
                      s.`helper`,
                      ee.`name` AS helper_name,
                      s.is_cancel 
              FROM t_deliver_sum s
              JOIN m_customer c ON s.`customer` = c.`code`
              JOIN m_employee e ON e.`code` = s.`driver`
              JOIN m_employee ee ON ee.`code` = s.`helper`
              WHERE s.cl='".$this->sd['cl']."'
              AND s.bc='".$this->sd['branch']."'
              AND s.`nno`='".$_POST['qno']."'";
    $query=$this->db->query($sql_sum);
    $r_detail['sum'] = $query->result();
   
    $sql_det="SELECT  d.`inv_type`, 
                      t.`description` AS t_des,
                      d.`inv_date`,
                      d.`inv_no`,
                      d.`item`,
                      m.`description` AS item_name,
                      d.`balance`,
                      d.`qty`,
                      d.`deliverd_qty`
              FROM `t_deliver_det` d
              JOIN m_item m ON m.`code` = d.`item`
              JOIN t_trans_code t ON t.`code` = d.`inv_type`
              WHERE d.`cl`='".$this->sd['cl']."'
              AND d.`bc`='".$this->sd['branch']."'
              AND d.`nno`='".$_POST['qno']."'";
    $query=$this->db->query($sql_det);
    $r_detail['det'] = $query->result();
    
    $r_detail['is_cur_time'] = $this->utility->get_cur_time();
    $s_time=$this->utility->save_time();
    if($s_time==1){
      $r_detail['save_time']="  -  ".$this->utility->get_save_time('t_deliver_sum','action_date',$_POST['qno'],'nno');
    }else{
      $r_detail['save_time']="";
    }
    $this->load->view($_POST['by'] . '_' . 'pdf', $r_detail);
  }











}
