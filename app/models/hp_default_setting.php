<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class hp_default_setting extends CI_Model {

    private $sd;
    private $mod = '003';

    function __construct() {
        parent::__construct();
        $this->sd = $this->session->all_userdata();
        $this->load->database($this->sd['db'], true);
    }

    public function base_details() {

       
    }

    public function get_form_data(){

        $result = $this->get_agreement_format();
        echo json_encode($result);
    }
    public function save() {

        $sql2 = "DELETE FROM def_hp_serial_format_det"; 
        $this->db->query($sql2);

        $sql1 = "DELETE FROM def_hp_serial_format_sum"; 
        $this->db->query($sql1);
     

        $sql3 = "DELETE FROM def_option_hp"; 
        $this->db->query($sql3);
      
        if(isset($_POST['restart_type'])){
            $restart_type = $_POST['restart_type'];
        }
        else{
            $restart_type = "n/a";
        }
             
        if(isset($_POST['restart_branch_code'])){
            $restart_branch_code = $_POST['restart_branch_code'];
        }
        else{
            $restart_branch_code = 0;
        }
        if(isset($_POST['restart_sales_cat'])){
            $restart_sales_cat = $_POST['restart_sales_cat'];
        }
        else{
            $restart_sales_cat = 0;
        }
        if(isset($_POST['is_use_auto_no_format'])){ 
            $is_use_auto_no_format = $_POST['is_use_auto_no_format'];
        }
        else{
             $is_use_auto_no_format = 0;
        }

        $this->db->trans_start();
        
        $def_hp_serial_format_sum = array(
            "code_place" => $_POST['code_place'],
            "cp_description" => $_POST['description'],
            "table_name" => $_POST['table_name'],
            "serial_field" => $_POST['serial_field'],
            "date_field" => $_POST['date_field'],
            "restart_in_each" => $restart_type,
            "restart_branch_code" => $restart_branch_code,
            "restart_sales_cat" => $restart_sales_cat
           
        );

        $this->db->insert('def_hp_serial_format_sum', $def_hp_serial_format_sum);

       

        for($x = 0; $x<=6; $x++){


            if(!(isset($_POST['fn_'.$x]))){
                $_POST['fn_'.$x] = "";
            }
          
          
            if(!(isset($_POST['sample_'.$x]))){
                $_POST['sample_'.$x] == "";
            }
          

            if($x == 6){

                $_POST['order_'.$x] = "n/a"; 
            }
            else{
                if(!(isset($_POST['order_'.$x]))){
                    $_POST['order_'.$x] == "";  
                }

            }
          
            $def_hp_serial_format_det[]= array(
                "code_place"=>$_POST['code_place'],
                "field_name"=>$_POST['fn_'.$x],
                "field_order"=>$_POST['order_'.$x],
                "field_format"=>$_POST['sample_'.$x]              
            );                 
            
        }

       
        $this->db->insert_batch('def_hp_serial_format_det', $def_hp_serial_format_det);


        $def_option_hp = array(
            "use_auto_no_format" => $is_use_auto_no_format    
        );
        $this->db->insert('def_option_hp', $def_option_hp);

        echo $this->db->trans_complete();
    }

    private function set_delete() {
        
    }

    public function check_code() {
        $this->db->where('code', $_POST['code']);
        $this->db->limit(1);
        echo $this->db->get($this->mtb)->num_rows;
    }

    public function load() {
        $query = $this->db->get('def_option_account');
        if ($query->num_rows() > 0) {
            $a['option_account'] = $query->result();
        } else {
            $a['option_account'] = 2;
        }

        $query = $this->db->get('def_option_stock');
        if ($query->num_rows() > 0) {
            $a['option_stock'] = $query->result();
        } else {
            $a['option_stock'] = 2;
        }

        $query = $this->db->get('def_option_sales');
        if ($query->num_rows() > 0) {
            $a['option_sales'] = $query->result();
        } else {
            $a['option_sales'] = 2;
        }
        $query = $this->db->get('def_option_stock');
        if ($query->num_rows() > 0) {
            $a['auto_deptm'] = $query->result();
        } else {
            $a['auto_deptm'] = 2;
        }
        $query = $this->db->get('def_option_stock');
        if ($query->num_rows() > 0) {
            $a['auto_mcat'] = $query->result();
        } else {
            $a['auto_mcat'] = 2;
        }
        $query = $this->db->get('def_option_stock');
        if ($query->num_rows() > 0) {
            $a['gen_itemcode_by_department'] = $query->result();
        } else {
            $a['gen_itemcode_by_department'] = 2;
        }
        $query = $this->db->get('def_option_stock');
        if ($query->num_rows() > 0) {
            $a['auto_sbcat'] = $query->result();
        } else {
            $a['auto_sbcat'] = 2;
        }

        echo json_encode($a);
    }

    public function delete() {
        $p = $this->user_permissions->get_permission($this->mod, array('is_delete'));
        if ($p->is_delete) {
            $this->db->where('code', $_POST['code']);
            $this->db->limit(1);

            echo $this->db->delete($this->mtb);
        } else {
            echo 2;
        }
    }

    public function get_payment_option() {
        $this->db->where("code", $_POST['code']);
        $data['result'] = $this->db->get("r_payment_option")->result();
        echo json_encode($data);
    }

    public function check_pv_no() {
        $this->db->select(array("card_no"));
        $this->db->where('card_no', $_POST['privi_card']);
        $this->db->limit(1);
        echo $this->db->get("t_privilege_card")->num_rows;
    }

    public function is_serial_entered($trans_no, $item, $serial) {
        $this->db->select(array('available'));
        $this->db->where("serial_no", $serial);
        $this->db->where("item", $item);
        $query = $this->db->get("t_serial");

        if ($query->num_rows() > 0) {
            return 1;
        } else {
            return 0;
        }
    }

    public function get_agreement_format(){

        $sql1 = "SELECT * FROM def_hp_serial_format_sum";
        $res1 = $this->db->query($sql1)->row_array();

        $sql2 = "SELECT * FROM def_option_hp";
        $res2 = $this->db->query($sql2)->row_array();

        $sql3 = "SELECT * FROM def_hp_serial_format_det";
        $res3 = $this->db->query($sql3)->result();

        $num = $this->db->query($sql3)->num_rows(); 

        $result[0] = $res1;
        $result[1] = $res2;
        $result[2] = $res3;
        $result[3] = $num;
 
        return $result;

    }

}
