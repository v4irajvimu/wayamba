<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class t_hp_seize extends CI_Model{    
  private $mod = '003';
  
  function __construct(){
    parent::__construct();    
    $this->sd = $this->session->all_userdata();
    $this->load->database($this->sd['db'], true);
    $this->load->model('user_permissions');
    $this->load->model('utility');
  }


  public function base_details(){
    $a['max_no']= $this->utility->get_max_no("t_hp_seize_sum", "nno");
    $a['cl']    = $this->sd['cl'];
    $a['bc']    = $this->sd['branch'];
    return $a;
  }

  public function validation(){
    $status=1;  
    $this->max_no= $this->utility->get_max_no("t_hp_seize_sum", "nno");
    $check_is_delete = $this->validation->check_is_cancel($this->max_no, 't_hp_seize_sum');
    if ($check_is_delete != 1) {
      return "This HP Seize number already deleted";
    }
    $customer_validation = $this->validation->check_is_customer($_POST['cus_id']);
    if ($customer_validation != 1) {
      return "Please enter valid customer";
    }
    $rivert_validation = $this->validation->check_is_employer($_POST['rivert_person']);
    if ($rivert_validation != 1) {
      return "Please enter valid rivert person";
    }
    $cofficer_validation = $this->validation->check_is_employer($_POST['officer']);
    if ($cofficer_validation != 1) {
      return "Please enter valid collection officer";
    }
    $serial_validation_status = $this->validation->serial_update('0_', 'qty1_',"all_serial_");
    if ($serial_validation_status != 1) {
      return $serial_validation_status;
    }
    $check_zero_value=$this->validation->empty_net_value($_POST['tot_amount']);
    if($check_zero_value!=1){
      return $check_zero_value;
    } 
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
      $validation_status=$this->validation();    
      if($validation_status==1){
        $t_seize_sum=array(
          "cl"                 =>$this->sd["cl"],
          "bc"                 =>$this->sd["branch"],
          "nno"                =>$this->max_no,
          "ddate"              =>$_POST['date'],
          "ref_no"             =>$_POST['ref_no'],
          "agr_no"             =>$_POST['agr_no'],
          "customer"           =>$_POST['cus_id'],
          "hp_nno"             =>$_POST['hp_no'],
          "rivert_person"      =>$_POST['rivert_person'],
          "note"               =>$_POST['note'],
          "stores"             =>$_POST['store_code'],
          "collection_officer" =>$_POST['officer'],
          "net_amount"         =>$_POST['tot_amount'],
          "revert_chargers"    =>$_POST['rt_chargers'],
          "oc"                 =>$this->sd["oc"]
          );

        for ($x = 0; $x < 25; $x++) {
          if (isset($_POST['0_' . $x], $_POST['qty1_' . $x], $_POST['net1_' . $x])) {
            if ($_POST['0_' . $x] != "" && $_POST['qty1_' . $x] != "" && $_POST['net1_' . $x] != "") {
              $t_seize_det[] = array(
                "cl"            => $this->sd["cl"],
                "bc"            => $this->sd['branch'],
                "nno"           => $this->max_no,
                "item_code"     => $_POST['0_' . $x],
                "batch"         => $_POST['btt1_' . $x],
                "qty"           => $_POST['qty1_' . $x],
                "price"         => $_POST['price1_' . $x],
                "amount"        => $_POST['amt1_' . $x],
                "discount"      => $_POST['discount1_' . $x],
                "net_amount"    => $_POST['net1_' . $x],
                "serials"       => $_POST['serial1_' . $x]                
              );
            }
          }
        }

        if($_POST['hid'] == "0" || $_POST['hid'] == ""){
          if($this->user_permissions->is_add('t_hp_seize')){  

            $this->db->insert("t_hp_seize_sum",$t_seize_sum);   

            if(count($t_seize_det)){$this->db->insert_batch("t_hp_seize_det",$t_seize_det);}  

            $this->db->where('cl',$this->sd['cl']);
            $this->db->where('bc',$this->sd['branch']);
            $this->db->where('nno',$_POST['hp_no']);
            $this->db->update('t_hp_sales_sum', array("is_seize"=>1)); 

            $this->load->model('trans_settlement');
            for($x = 0; $x < 25; $x++){
              if(isset($_POST['0_'.$x],$_POST['qty1_'.$x])){
                if($_POST['0_' . $x] != "" && $_POST['qty1_' . $x] != "" ){
                  $this->trans_settlement->save_item_movement('t_item_movement',$_POST['0_'.$x],'116',$this->max_no,$_POST['date'],$_POST['qty1_'.$x],0,$_POST['store_code'],$this->utility->get_cost_price($_POST['0_'.$x]),$_POST['btt1_'.$x],$this->utility->get_min_price($_POST['0_'.$x]),$_POST['price1_'.$x],$this->utility->get_min_price($_POST['0_'.$x]),001);
                }
              }
            }

            if($_POST["df_is_serial"]=='1'){
              $this->save_serial();     
            }

            $this->utility->save_logger("SAVE",116,$this->max_no,$this->mod);
            echo $this->db->trans_commit();
          }else{
            $this->db->trans_commit();
            echo "No permission to save records";
          }
        }else{
          if($this->user_permissions->is_edit('t_hp_seize')){

            $this->db->where('nno',$_POST['hid']);
            $this->db->where("cl", $this->sd['cl']);
            $this->db->where("bc", $this->sd['branch']);
            $this->db->update("t_hp_seize_sum",$t_seize_sum);

            $this->db->where('cl',$this->sd['cl']);
            $this->db->where('bc',$this->sd['branch']);
            $this->db->where('nno',$_POST['hp_no']);
            $this->db->update('t_hp_sales_sum', array("is_seize"=>1)); 

            $this->set_delete();

            if(count($t_seize_det)){$this->db->insert_batch("t_hp_seize_det",$t_seize_det);} 

            $this->load->model('trans_settlement');
            for($x = 0; $x < 25; $x++){
              if(isset($_POST['0_'.$x],$_POST['qty1_'.$x])){
                if($_POST['0_' . $x] != "" && $_POST['qty1_' . $x] != "" ){
                  $this->trans_settlement->save_item_movement('t_item_movement',$_POST['0_'.$x],'116',$this->max_no,$_POST['date'],$_POST['qty1_'.$x],0,$_POST['store_code'],$this->utility->get_cost_price($_POST['0_'.$x]),$_POST['btt1_'.$x],$this->utility->get_min_price($_POST['0_'.$x]),$_POST['price1_'.$x],$this->utility->get_min_price($_POST['0_'.$x]),001);
                }
              }
            }

            if($_POST["df_is_serial"]=='1'){
              $this->save_serial();     
            }

            $this->utility->save_logger("EDIT",116,$this->max_no,$this->mod);               
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
    }catch(Exception $e){ 
      $this->db->trans_rollback();
      echo  $e->getMessage()." - Operation fail please contact admin"; 
    } 
  }


  public function save_serial(){
    if ($_POST['hid'] == "0" || $_POST['hid'] == "") {
      for ($x = 0; $x < 25; $x++) {
        if (isset($_POST['0_' . $x])) {
          if ($_POST['0_' . $x] != "" || !empty($_POST['0_' . $x])) {
            if ($this->check_is_serial_items($_POST['0_'.$x]) == 1) {
              $serial = $_POST['all_serial_'.$x];
              $p=explode(",",$serial);
              for($i=0; $i<count($p); $i++){
                if ($_POST['hid'] == "0" || $_POST['hid'] == "") {

                  $this->db->query("INSERT INTO t_serial_movement SELECT * FROM t_serial_movement_out WHERE item='".$_POST['0_'.$x]."' AND serial_no='".$p[$i]."' ");  
                  
                  $t_serial_movement= array(
                    "cl" => $this->sd['cl'],
                    "bc" => $this->sd['branch'],
                    "trans_type" => 116,
                    "trans_no" => $this->max_no,
                    "item" => $_POST['0_'.$x],
                    "batch_no" => $_POST['btt1_'.$x],
                    "serial_no" => $p[$i],
                    "qty_in" => 1,
                    "qty_out" => 0,
                    "cost" => $_POST['price1_'.$x],
                    "store_code" => $_POST['store_code'],
                    "computer" => $this->input->ip_address(),
                    "oc" => $this->sd['oc'],
                    );

                  if(isset($t_serial_movement)) {
                    $this->db->insert("t_serial_movement", $t_serial_movement);
                  }

                  $t_serial = array(
                    "out_doc" => "",
                    "out_no" => "",
                    "out_date" => date("Y-m-d", time()),
                    "available" => '1',
                    "store_code" => $_POST['store_code']
                  );

                  $this->db->where('cl',$this->sd['cl']);
                  $this->db->where('bc',$this->sd['branch']);
                  $this->db->where("item", $_POST['0_'.$x]);
                  $this->db->where("serial_no", $p[$i]);
                  $this->db->update("t_serial", $t_serial);

                  $this->db->where('cl',$this->sd['cl']);
                  $this->db->where('bc',$this->sd['branch']);
                  $this->db->where("item", $_POST['0_'.$x]);
                  $this->db->where("serial_no", $p[$i]);
                  $this->db->delete("t_serial_movement_out");
                }  
              }
            }
          }        
        }
      }    
    }else{
      for ($x = 0; $x < 25; $x++) {
        if (isset($_POST['0_' . $x])) {
          if ($_POST['0_' . $x] != "" || !empty($_POST['0_' . $x])) {
           if ($this->check_is_serial_items($_POST['0_'.$x]) == 1) {
            $this->db->select(array('item','serial_no'));
            $this->db->where('cl',$this->sd['cl']);
            $this->db->where('bc',$this->sd['branch']);
            $this->db->where('trans_type',116);
            $this->db->where('trans_no',$this->max_no);
            $query=$this->db->get('t_serial_movement');

            $t_serial = array(
              "out_doc" => 6,
              "out_no" => $_POST['hp_no'],
              "out_date" => date("Y-m-d", time()),
              "available" => '0'
            );

            foreach($query->result() as $row){
              $this->db->query("INSERT INTO t_serial_movement_out SELECT * FROM t_serial_movement WHERE item='$row->item' AND serial_no='$row->serial_no'");  
              $this->db->where('cl',$this->sd['cl']);
              $this->db->where('bc',$this->sd['branch']);
              $this->db->where("item", $row->item);
              $this->db->where("serial_no", $row->serial_no);
              $this->db->update("t_serial", $t_serial);
              
              $this->db->where('cl',$this->sd['cl']);
              $this->db->where('bc',$this->sd['branch']);
              $this->db->where("item", $row->item);
              $this->db->where("serial_no", $row->serial_no);
              $this->db->delete("t_serial_movement");
            }

            $this->db->where('cl',$this->sd['cl']);
            $this->db->where('bc',$this->sd['branch']);
            $this->db->where('trans_type',116);
            $this->db->where('trans_no',$this->max_no);
            $this->db->delete("t_serial_movement_out");

            $serial = $_POST['all_serial_'.$x];
            $p=explode(",",$serial);
            for($i=0; $i<count($p); $i++){
              $this->db->query("INSERT INTO t_serial_movement SELECT * FROM t_serial_movement_out WHERE item='".$_POST['0_'.$x]."' AND serial_no='".$p[$i]."' ");  
              
              $t_serial_movement= array(
                "cl" => $this->sd['cl'],
                "bc" => $this->sd['branch'],
                "trans_type" => 116,
                "trans_no" => $this->max_no,
                "item" => $_POST['0_'.$x],
                "batch_no" => $_POST['btt1_'.$x],
                "serial_no" =>$p[$i],
                "qty_in" => 1,
                "qty_out" => 0,
                "cost" => $_POST['price1_' . $x],
                "store_code" => $_POST['store_code'],
                "computer" => $this->input->ip_address(),
                "oc" => $this->sd['oc'],
              );

              if(isset($t_serial_movement)){$this->db->insert("t_serial_movement", $t_serial_movement);}
              
              $t_serial2 = array(
                "out_doc" => "",
                "out_no" => "",
                "out_date" => date("Y-m-d", time()),
                "available" => '1',
                "store_code" => $_POST['store_code']
              );

              $this->db->where('cl',$this->sd['cl']);
              $this->db->where('bc',$this->sd['branch']);
              $this->db->where("item", $_POST['0_'.$x]);
              $this->db->where("serial_no", $p[$i]);
              $this->db->update("t_serial", $t_serial2);

              $this->db->where('cl',$this->sd['cl']);
              $this->db->where('bc',$this->sd['branch']);
              $this->db->where("item", $_POST['0_'.$x]);
              $this->db->where("serial_no", $p[$i]);
              $this->db->delete("t_serial_movement_out");
              }  
            }//end serial for loop
          }//check is serial item     
        }
      }   
    }
  }

  public function account_update($condition) {

    $this->db->where("trans_no", $this->max_no);
    $this->db->where("trans_code", 6);
    $this->db->where("cl", $this->sd['cl']);
    $this->db->where("bc", $this->sd['branch']);
    $this->db->delete("t_check_double_entry");


    if ($_POST['hid'] != "0" || $_POST['hid'] != "") {
      $this->db->where('cl',$this->sd['cl']);
      $this->db->where('bc',$this->sd['branch']);
      $this->db->where('trans_code',6);
      $this->db->where('trans_no',$this->max_no);
      $this->db->delete('t_account_trans');
    }

    $config = array(
      "ddate" => $_POST['date'],
      "trans_code" => 6,
      "trans_no" => $this->max_no,
      "op_acc" => 0,
      "reconcile" => 0,
      "cheque_no" => 0,
      "narration" => "",
      "ref_no" => $_POST['ref_no']
      );

    $des = "HP Sale - " . $_POST['customer'];
    $this->load->model('account');
    $this->account->set_data($config);
    $total_discount=$_POST['tot_dis'];
    $total_amount=$_POST['total_amt2'];

    
    $acc_code=$_POST['customer'];
    $this->account->set_value2($des, $_POST['down_payment'], "dr", $acc_code,$condition);

    $acc_code=$this->utility->get_default_acc('HP_STOCK');
    $this->account->set_value2($des, $_POST['down_payment'], "cr", $acc_code,$condition);


    
    if($condition==0){
      $query = $this->db->query("
       SELECT (IFNULL( SUM( t.`dr_amount`),0) = IFNULL(SUM(t.`cr_amount`),0)) AS ok 
       FROM `t_check_double_entry` t
       LEFT JOIN `m_account` a ON t.`acc_code` = a.`code`
       WHERE  t.`cl`='" . $this->sd['cl'] . "'  AND t.`bc`='" . $this->sd['branch'] . "'  AND t.`trans_code`='6'  AND t.`trans_no` ='" . $this->max_no . "' AND 
       a.`is_control_acc`='0'");

      if ($query->row()->ok == "0") {
        $this->db->where("trans_no", $this->max_no);
        $this->db->where("trans_code", 6);
        $this->db->where("cl", $this->sd['cl']);
        $this->db->where("bc", $this->sd['branch']);
        $this->db->delete("t_check_double_entry");
        return "0";
      } else {
        return "1";
      }
    }
  }

  private function set_delete(){
    $this->db->where("nno", $this->max_no);
    $this->db->where("cl", $this->sd["cl"]);
    $this->db->where("bc", $this->sd['branch']);
    $this->db->delete("t_hp_seize_det");

    $this->load->model('trans_settlement');
    $this->trans_settlement->delete_item_movement('t_item_movement',116,$this->max_no);

  }

  public function check_is_serial_items($code) {
    $this->db->select(array('serial_no'));
    $this->db->where("code", $code);
    $this->db->limit(1);
    return $this->db->get("m_item")->first_row()->serial_no;
  }
  
  public function load(){
    $cl=$this->sd['cl'];
    $bc=$this->sd['branch'];
    $no=$_POST['id'];
    $hp_no=$agr_no=0;
    $sql="SELECT  nno,
                  ddate,
                  ref_no,
                  agr_no,
                  customer,
                  hp_nno,
                  rivert_person,
                  e.`name` AS rivertp_name,
                  note,
                  stores,
                  st.description as store_name,
                  collection_officer,
                  ee.`name` AS col_name,
                  net_amount,
                  revert_chargers,
                  tot_due_amount,
                  is_cancel
          FROM `t_hp_seize_sum` s
          JOIN m_stores st ON st.`code` = s.`stores`
          JOIN m_employee e ON e.`code` = s.`rivert_person`
          JOIN m_employee ee ON ee.`code` = s.`collection_officer`
          WHERE s.cl='$cl' AND s.bc='$bc' AND s.nno='$no'";

    $query=$this->db->query($sql);
    if($query->num_rows()>0){
      $result['sum']=$query->result();
      $hp_no=$query->first_row()->hp_nno;
      $agr_no=$query->first_row()->agr_no;
    }else{
      $result['sum']=2;
    }

    $sql="SELECT  item_code,
                  m.`description` AS item_name,
                  batch,
                  d.qty,
                  price,
                  amount,
                  discount,
                  net_amount,
                  serials
          FROM t_hp_seize_det d
          JOIN m_item m ON m.code = d.`item_code` 
          WHERE d.cl='$cl' AND d.`bc`='$bc' AND d.`nno`='$no'";

    $query=$this->db->query($sql);
    if($query->num_rows()>0){
      $result['det']=$query->result();
    }else{
      $result['det']=2;
    }

    $sql="SELECT  nno,
                agreement_no,
                ddate,
                cus_id,
                s.`ref_no`, 
                c.`name` AS cus_name,
                CONCAT(c.`address1`,' ',c.`address2`,' ',c.`address3`) AS cus_address,
                c.`tp`,
                s.`net_amount`,
                s.`down_payment`,
                s.`installment_amount`,
                s.no_of_installments,
                s.`interest_rate`,
                s.`document_charges`,
                s.`guarantor_01`,
                g1.`name` AS gurantor1_name,
                CONCAT(g1.`address1`,' ',g1.`address2`,' ',g1.`address3`) AS g1_address,
                g1.`tp` AS g1_tp,
                s.`guarantor_02`,
                g2.`name` AS gurantor2_name,
                CONCAT(g2.`address1`,' ',g2.`address2`,' ',g2.`address3`) AS g2_address,
                g2.`tp` AS g2_tp,
                s.store_id,
                ss.description AS store_name
        FROM t_hp_sales_sum s
        JOIN m_customer c ON c.`code` = s.`cus_id` 
        JOIN m_customer g1 ON g1.`code` = s.`guarantor_01`
        JOIN m_customer g2 ON g2.`code` = s.`guarantor_02`
        JOIN m_stores ss ON ss.code = s.store_id
        WHERE s.`cl`='$cl'
        AND s.`bc`='$bc'
        AND s.nno='$hp_no'";

    $query=$this->db->query($sql);
    if($query->num_rows()>0){
      $result['hp_sum']=$query->result();
    }else{
      $result['hp_sum']=2;
    }

    $sql="SELECT m.item, m.serial_no, s.other_no1, s.other_no2
          FROM t_serial_movement m
          JOIN t_serial s ON s.serial_no = m.serial_no AND s.item=m.item
          WHERE m.trans_no='$no'
          AND m.cl='$cl'
          AND m.bc='$bc'
          AND m.trans_type='116'";

    $query=$this->db->query($sql);
    if($query->num_rows()>0){
      $result['serial']=$query->result();
    }else{
      $result['serial']=2;
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
      if($this->user_permissions->is_delete('t_hp_seize')){
        $this->db->where('cl',$this->sd['cl']);
        $this->db->where('bc',$this->sd['branch']);
        $this->db->where('nno',$_POST['id']);
        $this->db->update('t_hp_seize_sum', array("is_cancel"=>1)); 

        $this->db->where('cl',$this->sd['cl']);
        $this->db->where('bc',$this->sd['branch']);
        $this->db->where('nno',$_POST['hp_no']);
        $this->db->update('t_hp_sales_sum', array("is_seize"=>0));  

        $this->db->where('cl',$this->sd['cl']);
        $this->db->where('bc',$this->sd['branch']);
        $this->db->where('trans_code','116');
        $this->db->where('trans_no',$_POST['id']);
        $this->db->delete('t_account_trans');

        $this->load->model('trans_settlement');
        $this->trans_settlement->delete_item_movement('t_item_movement',116,$_POST['id']);

        $this->db->select(array('item','serial_no'));
        $this->db->where('cl',$this->sd['cl']);
        $this->db->where('bc',$this->sd['branch']);
        $this->db->where('trans_type',116);
        $this->db->where('trans_no',$_POST['id']);
        $query=$this->db->get('t_serial_movement');

        $t_serial = array(
          "out_doc" => 6,
          "out_no" => $_POST['hp_no'],
          "out_date" => date("Y-m-d", time()),
          "available" => '0'
        );

        foreach($query->result() as $row){
          $this->db->query("INSERT INTO t_serial_movement_out SELECT * FROM t_serial_movement WHERE item='$row->item' AND serial_no='$row->serial_no'");  

          $this->db->where('cl',$this->sd['cl']);
          $this->db->where('bc',$this->sd['branch']);
          $this->db->where("item", $row->item);
          $this->db->where("serial_no", $row->serial_no);
          $this->db->update("t_serial", $t_serial);

          $this->db->where('cl',$this->sd['cl']);
          $this->db->where('bc',$this->sd['branch']);
          $this->db->where("item", $row->item);
          $this->db->where("serial_no", $row->serial_no);
          $this->db->delete("t_serial_movement");
        }

        $this->db->where('cl',$this->sd['cl']);
        $this->db->where('bc',$this->sd['branch']);
        $this->db->where('trans_type',116);
        $this->db->where('trans_no',$_POST['id']);
        $this->db->delete("t_serial_movement_out");

        $this->utility->save_logger("CANCEL",116,$_POST['id'],$this->mod);
        echo $this->db->trans_commit();

      }else{
        $this->db->trans_commit();
        echo "No permission to delete records";
      }
    }catch(Exception $e){ 
      $this->db->trans_rollback();
      echo "Operation fail please contact admin"; 
    }   
  }



public function load_agr_no(){
  $sql="SELECT  nno,
                agreement_no,
                ddate,
                cus_id,
                s.`ref_no`, 
                c.`name` AS cus_name,
                CONCAT(c.`address1`,' ',c.`address2`,' ',c.`address3`) AS cus_address,
                c.`tp`,
                s.`net_amount`,
                s.`down_payment`,
                s.`installment_amount`,
                s.no_of_installments,
                s.`interest_rate`,
                s.`document_charges`,
                s.`guarantor_01`,
                g1.`name` AS gurantor1_name,
                CONCAT(g1.`address1`,' ',g1.`address2`,' ',g1.`address3`) AS g1_address,
                g1.`tp` AS g1_tp,
                s.`guarantor_02`,
                g2.`name` AS gurantor2_name,
                CONCAT(g2.`address1`,' ',g2.`address2`,' ',g2.`address3`) AS g2_address,
                g2.`tp` AS g2_tp,
                s.store_id,
                ss.description AS store_name

        FROM t_hp_sales_sum s
        JOIN m_customer c ON c.`code` = s.`cus_id` 
        JOIN m_customer g1 ON g1.`code` = s.`guarantor_01`
        JOIN m_customer g2 ON g2.`code` = s.`guarantor_02`
        JOIN m_stores ss ON ss.code = s.store_id
        WHERE s.is_cancel='0' 
        AND s.is_closed='0' 
        AND s.is_seize ='0'
        AND s.`cl`='".$this->sd['cl']."'
        AND s.`bc`='".$this->sd['branch']."'
        AND (agreement_no LIKE '%$_POST[search]%' OR cus_id LIKE '%$_POST[search]%'
            OR c.`name` LIKE '%$_POST[search]%'
          )
        LIMIT 25";
  $query = $this->db->query($sql);
  $a = "<table id='item_list' style='width : 100%' >";
  $a .= "<thead><tr>";
  $a .= "<th class='tb_head_th'>Date</th>";
  $a .= "<th class='tb_head_th'>Agreenment No</th>";
  $a .= "<th class='tb_head_th'>Customer ID</th>";
  $a .= "<th class='tb_head_th'>Customer</th>";   
  $a .= "</thead></tr>";
  $a .= "<tr class='cl'>";
  $a .= "<td>&nbsp;</td>";
  $a .= "<td>&nbsp;</td>";
  $a .= "<td>&nbsp;</td>";
  $a .= "</tr>";
  foreach($query->result() as $r){
    $a .= "<tr class='cl'>";
    $a .= "<td>".$r->ddate."</td>";
    $a .= "<td>".$r->agreement_no."</td>";
    $a .= "<td>".$r->cus_id."</td>"; 
    $a .= "<td>".$r->cus_name."</td>";  

    $a .= "<td style='display: none;'>".$r->agreement_no."</td>";  
    $a .= "<td style='display: none;'>".$r->cus_id."</td>";  
    $a .= "<td style='display: none;'>".$r->cus_name."</td>";  
    $a .= "<td style='display: none;'>".$r->cus_address."</td>";  
    $a .= "<td style='display: none;'>".$r->tp."</td>";  
    $a .= "<td style='display: none;'>".$r->nno."</td>";  
    $a .= "<td style='display: none;'>".$r->ddate."</td>";  
    $a .= "<td style='display: none;'>".$r->ref_no."</td>";  
    $a .= "<td style='display: none;'>".$r->net_amount."</td>";  
    $a .= "<td style='display: none;'>".$r->down_payment."</td>"; 
    $a .= "<td style='display: none;'>".$r->installment_amount."</td>";  
    $a .= "<td style='display: none;'>".$r->no_of_installments."</td>";  
    $a .= "<td style='display: none;'>".$r->interest_rate."</td>";  
    $a .= "<td style='display: none;'>".$r->document_charges."</td>";  
    $a .= "<td style='display: none;'>".$r->g1_address."</td>";  
    $a .= "<td style='display: none;'>".$r->gurantor1_name."</td>";  
    $a .= "<td style='display: none;'>".$r->g1_tp."</td>";  
    $a .= "<td style='display: none;'>".$r->g2_address."</td>";  
    $a .= "<td style='display: none;'>".$r->gurantor2_name."</td>";  
    $a .= "<td style='display: none;'>".$r->g2_tp."</td>"; 
    $a .= "<td style='display: none;'>".$r->store_id."</td>";  
    $a .= "<td style='display: none;'>".$r->store_name."</td>"; 
    $a .= "</tr>";
  }
  $a .= "</table>";
  echo $a;
}


public function load_agr_receipt_details(){
  $sql="SELECT nno,ddate,paid_amount
        FROM `t_hp_receipt_sum`
        WHERE cl='".$this->sd['cl']."' AND bc='".$this->sd['branch']."' 
        AND agr_no='".$_POST['agr_no']."' AND is_cancel='0'";
  $query=$this->db->query($sql);
  if($query->num_rows()>0){
    $result['c'] = $query->result();
  }else{
    $result['c'] = 2;
  }

  $sql="SELECT ins_no,due_date,ins_amount 
          FROM t_ins_schedule 
          WHERE agr_no='".$_POST['agr_no']."' 
          AND cl='".$this->sd['cl']."' AND bc='".$this->sd['branch']."' 
          ORDER BY ins_no";
  $query=$this->db->query($sql);
  if($query->num_rows()>0){
    $result['s'] = $query->result();
  }else{
    $result['s'] = 2;
  }

  $sql="SELECT  d.item_code,
                m.`description` AS item_name,
                d.`batch_no`,
                d.`qty`,
                d.`sales_price` AS price,
                (d.`qty` * d.`sales_price`) AS amount,
                d.`discount`,
                d.amount AS net_amount,
                d.`serials`,
                d.`is_free`
        FROM t_hp_sales_det d 
        JOIN m_item m ON m.`code` = d.`item_code`
        WHERE cl='".$this->sd['cl']."' AND bc='".$this->sd['branch']."' 
        AND nno='".$_POST['no']."'
        ORDER BY auto_no
        LIMIT 25";
  $query=$this->db->query($sql);
  if($query->num_rows()>0){
    $result['items'] = $query->result();
  }else{
    $result['items'] = 2;
  }

/*  $sql_serial="SELECT s.`item`,s.`serial_no`,s.`other_no1`,s.`other_no2` 
              FROM t_serial s
              JOIN t_hp_sales_sum p ON p.`cl` = s.`cl` AND p.`bc` = s.`bc` AND p.`nno`=s.`out_no`
              WHERE p.`cl`='".$this->sd['cl']."'
              AND p.`bc`='".$this->sd['branch']."'
              AND s.`out_doc` ='6'
              AND s.`out_no` ='".$_POST['no']."'";
  $query_serial=$this->db->query($sql_serial);
  $result['serial'] = $query_serial->result();*/ 

  echo json_encode($result);
}


public function get_free_item(){
  $item=$_POST["item_code"];
  $buy_date=$_POST["b_date"];
  $sql_select="SELECT 
  MIFD.`item`
  FROM m_item_free AS MIF
  JOIN m_item_free_det AS MIFD 
  ON (MIF.`nno`=MIFD.`nno`) 
  WHERE `code`='$item' AND `date_from`<='$buy_date' AND `date_to`>='$buy_date';";
  $query = $this->db->query($sql_select);
  $det['free'] = $query->result();
  echo json_encode($det);
}  

public function PDF_report(){

  $this->db->select(array('name', 'address', 'tp', 'fax','email'));
  $this->db->where("bc", $this->sd['branch']);
  $r_detail['branch'] = $this->db->get('m_branch')->result();

  $this->db->select(array('is_print_logo'));
  $r_detail['is_print_logo']= $this->db->get('def_opt_common')->first_row()->is_print_logo;

  $r_detail['type'] = $_POST['type'];
  $r_detail['dt'] = $_POST['dt'];
  $r_detail['qno'] = $_POST['qno'];

  $r_detail['page'] = "A5";
  $r_detail['header'] = $_POST['header'];
  $r_detail['orientation'] = "L";

  $invoice_number= $this->utility->invoice_format($_POST['qno']);
  $session_array = array(
   $this->sd['cl'],
   $this->sd['branch'],
   $invoice_number
   );
  $r_detail['session'] = $session_array;

  $cl=$this->sd['cl'];
  $bc=$this->sd['branch'];
  $no=$_POST['qno'];

  $sql_sum="SELECT  nno,
                ddate,
                ref_no,
                agr_no,
                customer,
                c.name AS cus_name,
                hp_nno,
                rivert_person,
                e.`name` AS rivertp_name,
                note,
                stores,
                st.description as store_name,
                collection_officer,
                ee.`name` AS col_name,
                net_amount,
                revert_chargers,
                tot_due_amount,
                is_cancel
        FROM `t_hp_seize_sum` s
        JOIN m_stores st ON st.`code` = s.`stores`
        JOIN m_customer c ON c.`code` = s.`customer`
        JOIN m_employee e ON e.`code` = s.`rivert_person`
        JOIN m_employee ee ON ee.`code` = s.`collection_officer`
        WHERE s.cl='$cl' AND s.bc='$bc' AND s.nno='$no'";

  $query_sum = $this->db->query($sql_sum);
  $r_detail['sum'] = $query_sum->result();

  $sql="SELECT  item_code,
                m.`description` AS item_name,
                m.model,
                batch,
                d.qty,
                price,
                amount,
                discount,
                net_amount,
                serials
        FROM t_hp_seize_det d
        JOIN m_item m ON m.code = d.`item_code` 
        WHERE d.cl='$cl' AND d.`bc`='$bc' AND d.`nno`='$no'";

  $query = $this->db->query($sql);
  $r_detail['det'] = $this->db->query($sql)->result();


  $sql="SELECT m.item, m.serial_no, s.other_no1, s.other_no2
        FROM t_serial_movement m
        JOIN t_serial s ON s.serial_no = m.serial_no AND s.item=m.item
        WHERE m.trans_no='$no'
        AND m.cl='$cl'
        AND m.bc='$bc'
        AND m.trans_type='116'";

  $query = $this->db->query($sql);
  $r_detail['serial'] = $this->db->query($sql)->result();

  $this->db->select(array('t_hp_seize_sum.oc', 's_users.discription'));
  $this->db->from('t_hp_seize_sum');
  $this->db->join('s_users', 't_hp_seize_sum.oc=s_users.cCode');
  $this->db->where('t_hp_seize_sum.cl', $this->sd['cl']);
  $this->db->where('t_hp_seize_sum.bc', $this->sd['branch']);
  $this->db->where('t_hp_seize_sum.nno', $_POST['qno']);
  $r_detail['user'] = $this->db->get()->result();

  $r_detail['is_cur_time'] = $this->utility->get_cur_time();

  $s_time=$this->utility->save_time();
  if($s_time==1){
    $r_detail['save_time']="  -  ".$this->utility->get_save_time('t_hp_seize_sum','action_date',$_POST['qno'],'nno');
  }else{
    $r_detail['save_time']="";
  } 

  if($query_sum->num_rows()>0){
    $this->load->view($_POST['by'].'_'.'pdf',$r_detail);
  }else{
    echo "<script>alert('No Data');window.close();</script>";
  }
}







}
