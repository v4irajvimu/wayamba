<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class t_settu extends CI_Model {

    private $sd;
    private $mtb;
    private $mod = '003';

    function __construct() {
        parent::__construct();

        $this->sd = $this->session->all_userdata();
        $this->load->database($this->sd['db'], true);
        $this->load->model('user_permissions');
    }

    public function base_details() {

        $a['max_no'] = $this->utility->get_max_no("t_settu_sum","nno");
        return $a;
    }

    public function validation(){
      $this->max_no = $this->utility->get_max_no("t_settu_sum", "nno");
      $status = 1;
      $customer_validation = $this->validation->check_is_customer($_POST['organizer_id']);
      if ($customer_validation != 1) {
          return "Please enter valid Orgenizer";
      }
      $employee_validation = $this->validation->check_is_employer($_POST['sales_rep_id']);
      if ($employee_validation != 1) {
          return "Please enter valid sales rep";
      }
      $check_zero_value=$this->validation->empty_net_value($_POST['total_value']);
      if($check_zero_value!=1){
          return "Value can't be 0";
      } 
      return $status;
    }
    
    public function save() {
        $this->db->trans_begin();
        error_reporting(E_ALL);

        function exceptionThrower($type, $errMsg, $errFile, $errLine) {
            throw new Exception($errLine);
        }

        set_error_handler('exceptionThrower');
        try {
          $validation_status = $this->validation();
          if($validation_status == 1) {
            $settu_sum = array(
              "cl"          => $this->sd['cl'],
              "bc"          => $this->sd['branch'],
              "nno"         => $this->max_no,
              "ddate"       => $_POST['date'],
              "ref_no"      => $_POST['ref_no'],
              "book_no"     => $_POST['book_no'],
              "book_edition"=> $_POST['book_edition'],
              "organizer"   => $_POST['organizer_id'],       
              "sales_rep"   => $_POST['sales_rep_id'],
              "description" => $_POST['discription'],
              "value_amount"=> $_POST['total_value'],
              "ins_total"   => $_POST['installment'],
              "oc"          => $this->sd['oc'],    
            );

                 
            for ($x=0; $x<25; $x++) {
              if (isset($_POST['0_' . $x],$_POST['2_' . $x],$_POST['3_' . $x],$_POST['4_' . $x],$_POST['5_' . $x])) {
                if ($_POST['0_'.$x]!="" && $_POST['2_'.$x]!="" && $_POST['3_'.$x]!="" && $_POST['4_'.$x]!="" && $_POST['5_'.$x]!=""){
                  $settu_det[] = array(
                    "cl"        => $this->sd['cl'],
                    "bc"        => $this->sd['branch'],
                    "nno"       => $this->max_no,
                    "item_code" => $_POST['0_'.$x],
                    "value"     => $_POST['3_'.$x],
                    "no_ins"    => $_POST['4_'.$x],
                    "ins_amount"=> $_POST['5_'.$x]
                  );
                }
              }    
            }

            if ($_POST['hid']== "0" || $_POST['hid']== "") {
                if($this->user_permissions->is_add('t_settu')){
                    $this->db->insert('t_settu_sum',$settu_sum);
                    if(count($settu_det)){
                      $this->db->insert_batch("t_settu_det", $settu_det);
                    } 
                    $this->utility->save_logger("SAVE",74,$this->max_no,$this->mod);
                    echo $this->db->trans_commit();
                }else{
                    $this->db->trans_commit();
                    echo "No permission to save records";
                }
            } else {
              if($this->user_permissions->is_edit('t_settu')){
                $this->db->where("nno",$this->max_no);
                $this->db->where("cl", $this->sd['cl']);
                $this->db->where("bc", $this->sd['branch']);
                $this->db->update('t_settu_sum', $settu_sum);
                 
                $this->db->where("nno",$this->max_no);
                $this->db->where("cl", $this->sd['cl']);
                $this->db->where("bc", $this->sd['branch']);
                $this->db->delete('t_settu_det');

                if(count($settu_det)){
                  $this->db->insert_batch("t_settu_det", $settu_det);
                } 
                $this->utility->save_logger("EDIT",74,$this->max_no,$this->mod);
                echo $this->db->trans_commit();
              }else{
                $this->db->trans_commit();
                echo "No permission to edit records";
              }
            }
          }else{
            echo $validation_status;
            $this->db->trans_commit();
          }
        } catch (Exception $e) {
          $this->db->trans_rollback();
          echo $e->getMessage(). "Operation fail please contact admin";
        }
    }

    public function load() {
      $x = 0; 
      $sql="SELECT s.*, 
                  c.`name` AS c_name, 
                  c.`address1`, 
                  e.`name` AS e_name,
                  b.description as b_name 
            FROM t_settu_sum s
            JOIN m_customer c ON c.`code` = s.`organizer`
            JOIN m_employee e ON e.`code` = s.`sales_rep`
            JOIN m_settu_book_edition b ON b.`code` = s.`book_edition`
            WHERE s.cl='".$this->sd['cl']."' AND s.bc='".$this->sd['branch']."' 
            AND s.nno='".$_POST['no']."'";

      $query=$this->db->query($sql);      
          
      if ($query->num_rows() > 0) {
          $a['sum'] = $query->result();
      } else {
          $x = 2;
      }

      $sql="SELECT d.* , s.`name`, s.`settu_item_category` as hidcat, c.code as settu_item_category FROM t_settu_det d
            JOIN m_settu_item_sum s ON s.`code` = d.`item_code`
            JOIN m_settu_item_category c ON c.`ref_code` = s.`settu_item_category`
            WHERE d.cl='".$this->sd['cl']."' 
            AND d.bc='".$this->sd['branch']."' 
            AND d.nno='".$_POST['no']."'";

      $query=$this->db->query($sql);          

      if ($query->num_rows() > 0) {
          $a['det'] = $query->result();
      } else {
          $x = 2;
      }

      if($x==0) {
        echo json_encode($a);
      }else{
        echo json_encode($x);
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
            if($this->user_permissions->is_delete('t_settu')){
               $this->db->where("nno",$_POST['trans_no']);
               $this->db->where("cl", $this->sd['cl']);
               $this->db->where("bc", $this->sd['branch']);
               $this->db->update('t_settu_sum',array("is_cancel" => 1));
               $this->utility->save_logger("DELETE",74,$_POST['trans_no'],$this->mod);
               echo $this->db->trans_commit();
            }else{
                $this->db->trans_commit();
                echo "No permission to delete records";
            }
        } catch (Exception $e) {
            $this->db->trans_rollback();
            echo $e->getMessage()." - Operation fail please contact admin";
        }
    }

  

     public function get_item() {

        $code=$_POST['code'];
        
        $sql = "SELECT s.code, 
                    s.name, 
                    t.`value` AS amount, 
                    t.`no_of_installment` AS no_int, 
                    t.`installment_amount` AS int_amount 
            FROM m_settu_item_sum s 
            JOIN m_settu_item_category t ON t.`cl` = s.`cl` 
            AND s.`bc` = t.`bc` 
            AND t.code = s.`settu_item_category`
            AND s.code='$code'";
       
         $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            $data['a'] = $this->db->query($sql)->result();
        } else {
            $data['a'] = 2;
        }

        echo json_encode($data);

    }

    public function item_list_all() {
       
        if ($_POST['search'] == 'Key Word: code, name') {
            $_POST['search'] = "";
        }
        if($_POST['category']==""){
          $sql = "SELECT s.code, 
                        s.name, 
                        t.`value` AS amount, 
                        t.`no_of_installment` AS no_int, 
                        t.`installment_amount` AS int_amount 
                FROM m_settu_item_sum s 
                JOIN m_settu_item_category t ON t.`cl` = s.`cl` 
                JOIN m_settu_book_edition b ON b.`code` = s.book_edition
                AND s.`bc` = t.`bc` 
                AND t.ref_code = s.`settu_item_category`
                WHERE (s.code LIKE '%$_POST[search]%' OR s.name LIKE '%$_POST[search]%') 
                AND b.code='".$_POST['book']."'";
          
        }else{
          $sql = "SELECT s.code, 
                        s.name, 
                        t.`value` AS amount, 
                        t.`no_of_installment` AS no_int, 
                        t.`installment_amount` AS int_amount 
                FROM m_settu_item_sum s 
                JOIN m_settu_item_category t ON t.`cl` = s.`cl`
                JOIN m_settu_book_edition b ON b.`code` = s.book_edition
                AND s.`bc` = t.`bc` 
                AND t.ref_code = s.`settu_item_category`
                WHERE s.`settu_item_category` ='".$_POST['category']."' AND (s.code LIKE '%$_POST[search]%' OR s.name LIKE '%$_POST[search]%')
                AND b.code='".$_POST['book']."'";
        
        }
        
        $query = $this->db->query($sql);
        $a = "<table id='item_list' style='width : 100%' >";
        $a .= "<thead><tr>";
        $a .= "<th class='tb_head_th'>Code</th>";
        $a .= "<th class='tb_head_th' colspan='2'>Name</th>";
        $a .= "<th class='tb_head_th'>Amount</th>";
        $a .= "<th class='tb_head_th'>No Of Intallment</th>";
        $a .= "<th class='tb_head_th'>Installment Amount</th>";

        $a .= "</thead></tr>";
        $a .= "<tr class='cl'>";
        $a .= "<td>&nbsp;</td>";
        $a .= "<td colspan='2'>&nbsp;</td>";
        $a .= "<td>&nbsp;</td>";
        $a .= "<td>&nbsp;</td>";
        $a .= "<td>&nbsp;</td>";

        $a .= "</tr>";
        foreach ($query->result() as $r) {
            $a .= "<tr class='cl'>";
            $a .= "<td>" . $r->code . "</td>";
            $a .= "<td colspan='2'>" . $r->name . "</td>";
            $a .= "<td>" . $r->amount. "</td>";
            $a .= "<td>" . $r->no_int . "</td>";
            $a .= "<td>" . $r->int_amount . "</td>";
            $a .= "</tr>";
        }
        $a .= "</table>";
        echo $a;
    }


    public function load_orgernizer(){

      if($_POST['search'] == 'Key Word: code, name'){$_POST['search'] = "";}
        $sql = "SELECT * FROM m_customer  WHERE category = '005' AND (code LIKE '%$_POST[search]%' OR name LIKE '%$_POST[search]%') LIMIT 25";
  
      $query = $this->db->query($sql);
      $a  = "<table id='item_list' style='width : 100%' >";
      $a .= "<thead><tr>";
      $a .= "<th class='tb_head_th'>Code</th>";
      $a .= "<th class='tb_head_th' colspan='2'>Name</th>";
      $a .= "</thead></tr><tr class='cl'><td>&nbsp;</td><td colspan='2'>&nbsp;</td></tr>";

    foreach($query->result() as $r){
      $a .= "<tr class='cl'>";
      $a .= "<td>".$r->code."</td>";
      $a .= "<td>".$r->name."</td>";
      $a .= "<td style='display:none;'>".$r->address1."</td>";
      $a .= "</tr>";
    }
      $a .= "</table>";
      echo $a;
  }


    public function PDF_report(){
     
      $this->db->select(array('name', 'address', 'tp', 'fax', 'email'));
      $this->db->where("cl", $this->sd['cl']);
      $this->db->where("bc", $this->sd['branch']);
      $r_detail['branch'] = $this->db->get('m_branch')->result();

      $invoice_number= $this->utility->invoice_format($_POST['qno']);
      $session_array = array(
           $this->sd['cl'],
           $this->sd['branch'],
           $invoice_number
      );
      $r_detail['session'] = $session_array;

      $r_detail['qno']=$_POST['qno'];
      $r_detail['page']=$_POST['page'];
      $r_detail['header']=$_POST['header'];
      $r_detail['orientation']=$_POST['orientation'];


      $sql="SELECT s.*, 
                c.`name` AS c_name, 
                c.`address1`, 
                e.`name` AS e_name 
          FROM t_settu_sum s
          JOIN m_customer c ON c.`code` = s.`organizer`
          JOIN m_employee e ON e.`code` = s.`sales_rep`
          WHERE s.cl='".$this->sd['cl']."' AND s.bc='".$this->sd['branch']."' 
          AND s.nno='".$_POST['qno']."'";
      $r_detail['sum'] = $this->db->query($sql)->result();    

      $sql="SELECT d.* , s.`name` FROM t_settu_det d
            JOIN m_settu_item_sum s ON s.`code` = d.`item_code`
            WHERE d.cl='".$this->sd['cl']."' 
            AND d.bc='".$this->sd['branch']."' 
            AND d.nno='".$_POST['qno']."'";
      $r_detail['det'] = $this->db->query($sql)->result();        




      $this->load->view($_POST['by'].'_'.'pdf',$r_detail);

    }


}

