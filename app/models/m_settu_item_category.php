<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class m_settu_item_category extends CI_Model {

    private $sd;
    private $mtb;

    function __construct() {
        parent::__construct();

        $this->sd = $this->session->all_userdata();
        $this->load->database($this->sd['db'], true);
        $this->mtb = $this->tables->tb['m_settu_item_category'];
        $this->load->model('user_permissions');
    }

    public function base_details() {
        $a['table_data'] = $this->data_table();
        return $a;
    }

    public function data_table() {
        $this->load->library('table');
        $this->load->library('useclass');

        $this->table->set_template($this->useclass->grid_style());

        $code = array("data" => "Code", "style" => "width: 70px; cursor : pointer;", "onclick" => "set_short(1)");
        $des = array("data" => "Name", "style" => "cursor : pointer;", "onclick" => "set_short(2)");
        $value = array("data" => "Value", "style" => "width: 80px; cursor : pointer;", "onclick" => "set_short(1)");
        $no_of_int = array("data" => "No.int", "style" => "width: 40px; cursor : pointer;", "onclick" => "set_short(1)");
        $inst_amount= array("data" => "Inst.Amount", "style" => "width: 60px; cursor : pointer;", "onclick" => "set_short(1)");
        $action = array("data" => "Action", "style" => "width: 100px;");

        $this->table->set_heading($code, $des, $value,$no_of_int,$inst_amount, $action);

        $this->db->select(array('action_date', 'ref_code','name', 'code', 'value','no_of_installment','installment_amount'));
        $this->db->where("cl", $this->sd['cl']);
        $this->db->where("bc", $this->sd['branch']);
        $this->db->limit(10);
        $query = $this->db->get('m_settu_item_category');

        foreach ($query->result() as $r) {


            $but = "<img src='" . base_url() . "img/edit.gif' onclick='set_edit(\"" . $r->ref_code . "\")' title='Edit' />&nbsp;&nbsp;";
            $but .= "<img src='" . base_url() . "img/delete.gif' onclick='set_delete(\"" . $r->ref_code . "\")' title='Delete' />";
            $ed = array("data" => $but, "style" => "text-align: center; width: 100px;");
            $dis = array("data" => $this->useclass->limit_text($r->name, 50), "style" => "text-align: left;");
            $code = array("data" => $r->code, "style" => "text-align: left; width: 70px; ", "value" => "code");
            $value = array("data" => $r->value, "style" => "text-align: left; width: 80px; ", "value" => "value");
            $no_of_int = array("data" => $r->no_of_installment, "style" => "text-align: left; width:40px; ", "value" => "no_of_installment");
             $inst_amount = array("data" => $r->installment_amount, "style" => "text-align: left; width:60px; ", "value" => "no_of_installment");
            $this->table->add_row($code, $dis, $value,$no_of_int,$inst_amount, $ed);
        }

        return $this->table->generate();
    }

    public function get_data_table() {
        echo $this->data_table();
    }

    public function save() {
        $this->db->trans_begin();
        error_reporting(E_ALL);

        function exceptionThrower($type, $errMsg, $errFile, $errLine) {
            throw new Exception($errMsg);
        }

        set_error_handler('exceptionThrower');
        try {
            $_POST['cl'] = $this->sd['cl'];
            $_POST['bc'] = $this->sd['branch'];
            $_POST['oc'] = $this->sd['oc'];
            $_POST['code'] = strtoupper($_POST['code']);

            $sum=array(
                "cl"                =>$this->sd["cl"],
                "bc"                =>$this->sd["branch"],
                "book_edition"      =>$_POST["book_no"],
                "code"              =>$_POST["code"],
                "ref_code"          =>$_POST['book_no'].$_POST["code"],
                "name"              =>$_POST["name"],
                "value"             =>$_POST["value"],
                "no_of_installment" =>$_POST["no_of_installment"],
                "installment_amount"=>$_POST["installment_amount"],
                "oc"                =>$this->sd["oc"]
            );


            if ($_POST['code_'] == "0" || $_POST['code_'] == "") {
                if($this->user_permissions->is_add('m_settu_item_category')){
                    $this->db->insert('m_settu_item_category', $sum);
                    echo $this->db->trans_commit();
                }else{
                  $this->db->trans_commit();
                  echo "No permission to save records";
                }
            } else {
                if($this->user_permissions->is_edit('m_settu_item_category')){
                    $this->db->where("code", $_POST['code_']);
                    $this->db->where("book_edition", $_POST['book_no']);
                    $this->db->where("cl", $this->sd['cl']);
                    $this->db->where("bc", $this->sd['branch']);
                    $this->db->update('m_settu_item_category', $sum);
                    echo $this->db->trans_commit();
                }else{
                    $this->db->trans_commit();
                    echo "No permission to edit records";
                }
            }
        } catch (Exception $e) {
            $this->db->trans_rollback();
            echo "Operation fail please contact admin";
        }
    }

    public function check_code() {
        $this->db->where('ref_code', $_POST['code']);
        $this->db->where('cl', $this->sd['cl']);
        $this->db->where('bc', $this->sd['branch']);
        $this->db->limit(1);
        echo $this->db->get($this->mtb)->num_rows;
    }

    public function load() {
        $sql="SELECT c.*,b.`description` b_name 
                FROM m_settu_item_category c
                JOIN m_settu_book_edition b ON b.`code` = c.`book_edition`
                WHERE c.ref_code= '".$_POST['code']."'
                AND cl='".$this->sd['cl']."'
                AND bc='".$this->sd['branch']."'
                LIMIT 1";
        $query=$this->db->query($sql)->first_row();
        echo json_encode($query);
    }

    public function delete() {
        $this->db->trans_begin();
        error_reporting(E_ALL);

        function exceptionThrower($type, $errMsg, $errFile, $errLine) {
            throw new Exception($errMsg);
        }

        set_error_handler('exceptionThrower');
        try {
            if($this->user_permissions->is_delete('m_settu_item_category')){
                $this->db->where('ref_code', $_POST['code']);
                $this->db->where('cl', $this->sd['cl']);
                $this->db->where('bc', $this->sd['branch']);
                $this->db->limit(1);
                $this->db->delete($this->mtb);
                echo $this->db->trans_commit();
            }else{
                $this->db->trans_commit();
                echo "No permission to delete records";
            }
        } catch (Exception $e) {
            $this->db->trans_rollback();
            echo "Operation fail please contact admin";
        }
    }

    public function select() {
        $cl = $this->sd['cl'];
        $bc = $this->sd['branch'];
        $sql = "SELECT * FROM $this->mtb WHERE cl='$cl' AND bc='$bc' AND (sales='1' OR group_sale='1')";
        $query = $this->db->query($sql);

        $s = "<select name='stores' id='stores' class='store11'>";
        $s .= "<option value='0'>---</option>";
        foreach ($query->result() as $r) {
            $s .= "<option title='" . $r->description . "' value='" . $r->code . "'>" . $r->code . '-' . $r->description . "</option>";
        }
        $s .= "</select>";

        return $s;
    }

    public function select2() {
        $this->db->where("cl", $this->sd['cl']);
        $this->db->where("bc", $this->sd['branch']);
        $this->db->where("purchase", "1");
        $query = $this->db->get($this->mtb);

        $s = "<select name='stores' id='stores' >";
        $s .= "<option value='0'>---</option>";
        foreach ($query->result() as $r) {
            $s .= "<option title='" . $r->description . "' value='" . $r->code . "'>" . $r->code . '-' . $r->description . "</option>";
        }
        $s .= "</select>";
        return $s;
    }

    public function select3() {
        $this->db->where("cl", $this->sd['cl']);
        $this->db->where("bc", $this->sd['branch']);
        $query = $this->db->get($this->mtb);
        $s = "<select name='stores' id='stores' >";
        $s .= "<option value='0'>---</option>";
        foreach ($query->result() as $r) {
            $s .= "<option title='" . $r->description . "' value='" . $r->code . "'>" . $r->code . ' | ' . $r->description . "</option>";
        }
        $s .= "</select>";
        return $s;
    }

    public function get_data_table2(){
        echo $this->data_table3();
    }

    public function data_table3(){
        $this->load->library('table');
        $this->load->library('useclass');
        $this->table->set_template($this->useclass->grid_style());
        $codes=$_POST['code'];
         
        $code = array("data"=>"Code", "style"=>"width: 100px; cursor : pointer;", "onclick"=>"set_short(1)");
        $des = array("data"=>"Name", "style"=>"cursor : pointer;", "onclick"=>"set_short(2)");
        $value = array("data"=>"Value", "style"=>"cursor : pointer;", "onclick"=>"set_short(3)");
        $ins = array("data"=>"  No.int", "style"=>"cursor : pointer;", "onclick"=>"set_short(4)");
        $amt = array("data"=>"  Inst.Amount", "style"=>"cursor : pointer;", "onclick"=>"set_short(5)");
        $action = array("data"=>"Action", "style"=>"width: 100px;");

        $this->table->set_heading($code, $des, $value,$ins,$amt, $action);

         
            $sql="SELECT  `code`,
                          `name`,
                          `value`,
                          `no_of_installment`,
                          `installment_amount`  FROM m_settu_item_category WHERE `code` like '%$codes%' OR `name` like '%$codes%' OR `value` like '%$codes%'";
          
            
          $query=$this->db->query($sql);

        
              foreach($query->result() as $r){
                $but = "<img src='".base_url()."img/edit.gif' onclick='set_edit(\"".$r->code."\")' title='Edit' />&nbsp;&nbsp;";
                $but .= "<img src='".base_url()."img/delete.gif' onclick='set_delete(\"".$r->code."\")' title='Delete' />";
                $ed = array("data"=>$but, "style"=>"text-align: center; width: 100px;");
                $des = array("data"=>$this->useclass->limit_text($r->name, 50), "style"=>"text-align: left;");
                $field_body = array("data"=>$this->useclass->limit_text($r->no_of_installment, 50), "style"=>"text-align: left;");
                $field_body2 = array("data"=>$this->useclass->limit_text($r->value, 50), "style"=>"text-align: left;");
                $field_body3 = array("data"=>$this->useclass->limit_text($r->installment_amount, 50), "style"=>"text-align: left;");
                
                $code = array("data"=>$r->code, "style"=>"text-align: left; width: 100px; ", "value"=>"code");
               
                $this->table->add_row($code, $des, $field_body,$field_body2,$field_body3, $ed);
             
          }
      return $this->table->generate();
    }

}
