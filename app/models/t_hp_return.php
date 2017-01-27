<?php
if (!defined('BASEPATH'))
  exit('No direct script access allowed');

class t_hp_return extends CI_Model {

  private $sd;
  private $mtb;
  private $max_no;
  private $credit_max_no;
  private $mod = '003';

  function __construct() {
    parent::__construct();
    $this->sd = $this->session->all_userdata();
    $this->load->database($this->sd['db'], true);
    $this->load->model('user_permissions');
  }

  public function base_details() {
    $a['nno'] = $this->utility->get_max_no('t_hp_return_sum', 'nno');
       //$this->load->model('m_stores');
        //$a['stores'] = $this->m_stores->select();
    $a["crn_no"] = $this->get_credit_max_no();
    return $a;
  }

  public function get_credit_max_no() {

    $field = "nno";
    $this->db->select_max($field);
    $this->db->where("cl", $this->sd['cl']);
    $this->db->where("bc", $this->sd['branch']);
    return $this->db->get("t_credit_note")->first_row()->$field + 1;

  }

  public function validation(){
    $this->max_no = $this->utility->get_max_no("t_hp_return_sum", "nno");
    
    $status=1;
    
    $check_is_delete=$this->validation->check_is_cancel($this->max_no,'t_hp_return_sum');
    if($check_is_delete!=1){
      return "HP return already deleted.";
    }
    $serial_validation_status=$this->validation->serial_update('0_','1_',"all_serial_");
    if($serial_validation_status!=1){
      return $serial_validation_status;
    }
    $check_zero_value=$this->validation->empty_net_value($_POST['net_amount']);
      if($check_zero_value!=1){
        return $check_zero_value;
    } 
    $chk_zero_qty=$this->validation->empty_qty('0_','1_');
    if($chk_zero_qty!=1){
      return $chk_zero_qty;
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
    try {

      $this->credit_max_no = $this->get_credit_max_no();
      $validation_status = $this->validation();

      if ($validation_status == 1) {

        $t_hp_return_sum = array(
          "cl"            => $this->sd['cl'],
          "bc"            => $this->sd['branch'],
          "nno"           => $this->max_no,
          "ddate"         => $_POST['date'],
          "ref_no"        => $_POST['ref_no'],
          "cus_id"        => $_POST['customer_id'],
          "agr_no"        => $_POST['agr_no'],
          "inv_no"        => $_POST['inv_no'],
          "ref_bill_no"   => $_POST['ref_bill'],
          "memo"          => $_POST['description'],
          "store"         => $_POST['store_id'],
          "salesman_id"   => $_POST['salesman_id'],
          "gross_amount"  => $_POST['gross_amount'],
          "discount"      => $_POST['dis_amount'],
          "net_amount"    => $_POST['net_amount'],
          "crn_amount"    => $_POST['crn_amount'],
          "paid_amount"   => $_POST['paid_amount'],
          "crn_no"        => $this->credit_max_no,
          "oc"            => $this->sd['oc']

          );



        $t_credit_note = array(
          "cl" => $this->sd['cl'],
          "bc" => $this->sd['branch'],
          "nno" => $this->credit_max_no,
          "ddate" => $_POST['date'],
          "ref_no" => $_POST['ref_no'],
          "memo" => "HP RETURN [" . $this->max_no . "]",
          "is_customer" => 1,
          "code" => $_POST['customer_id'],
          "acc_code" => $this->utility->get_default_acc('STOCK_ACC'),
          "amount" => $_POST['paid_amount'],
          "oc" => $this->sd['oc'],
          "post" => "",
          "post_by" => "",
          "post_date" => "",
          "is_cancel" => 0,
          "ref_trans_no" => $this->max_no,
          "ref_trans_code" => 107,
          "balance"=>$_POST['paid_amount']
          );


        $subs="";

        for ($x = 0; $x < 25; $x++) {
          if (isset($_POST['0_' . $x])) {
            if ($_POST['0_' . $x] != "" || !empty($_POST['0_' . $x])) {
              if(isset($_POST['subcode_'.$x])){
                $subs = $_POST['subcode_'.$x];
                if($_POST['subcode_'.$x]!="0" && $_POST['subcode_'.$x]!=""){

                  $sub_items = (explode(",",$subs));
                  $arr_length= sizeof($sub_items);

                  for($y = 0; $y<$arr_length; $y++){
                    $item_sub = (explode("-",$sub_items[$y]));
                    $sub_qty = (int)$_POST['1_'.$x] * (int)$item_sub[1];

                    $t_sub_item_movement[] = array(
                      "cl" => $this->sd['cl'],
                      "bc" => $this->sd['branch'],
                      "item" => $_POST['0_' . $x],
                      "sub_item"=>$item_sub[0],
                      "trans_code" => 107,
                      "trans_no" => $this->max_no,
                      "ddate" => $_POST['date'],
                      "qty_in" =>$sub_qty,
                      "qty_out" => 0,
                      "store_code" => $_POST['store_id'],
                      "avg_price" => $this->utility->get_cost_price($_POST['0_' . $x]),
                      "batch_no" =>  $_POST['bt_' . $x],
                      "sales_price" => $_POST['2_' . $x],
                      "last_sales_price" => $this->get_sales_min_price($_POST['inv_no'],$_POST['0_' . $x]),
                      "cost" =>$this->get_sales_purchase_price($_POST['inv_no'],$_POST['0_' . $x])
                      );
                  }
                }
              }

              $t_hp_return_det[] = array(
                "cl" => $this->sd['cl'],
                "bc" => $this->sd['branch'],
                "nno" => $this->max_no,
                "code" => $_POST['0_' . $x],
                "qty" => $_POST['1_' . $x],
                "discountp" => $_POST['3_' . $x],
                "discount" => $_POST['4_' . $x],
                "price" => $_POST['2_' . $x],
                "cost" => $this->get_sales_purchase_price($_POST['inv_no'],$_POST['0_' . $x]),
                "batch_no" => $_POST['bt_' . $x],
                "amount" => $_POST['5_' . $x],
                "min_price"=>$this->get_sales_min_price($_POST['inv_no'],$_POST['0_' . $x]),
                "is_free"=>$_POST['is_free_'.$x]
                );
            }
          }   
        }


        $approve = array(
          "is_approve"=> "1"
          );


        if ($_POST['hid'] == "0" || $_POST['hid'] == "") {
          if($this->user_permissions->is_add('t_hp_return')){

            $this->db->insert('t_hp_return_sum', $t_hp_return_sum);             
            if (count($t_hp_return_det)) {
              $this->db->insert_batch("t_hp_return_det", $t_hp_return_det);
            }
            $this->utility->save_logger("SAVE",107,$this->max_no,$this->mod);
            echo $this->db->trans_commit();

          }else{
            $this->db->trans_commit();
            echo "No permission to save records";
          }
        }else{
          if($this->user_permissions->is_edit('t_hp_return') ){

              //$status=$this->trans_cancellation->sales_return_update_status($_POST['hid']);     

              //if($status=="OK"){
            $this->set_delete();
            if($this->user_permissions->is_approve('t_hp_return')){   


             $this->db->where("cl", $this->sd['cl']);
             $this->db->where("bc", $this->sd['branch']);
             $this->db->where('nno', $_POST['hid']);
             $this->db->update('t_hp_return_sum', $t_hp_return_sum);        

             if (count($t_hp_return_det)) {
              $this->db->insert_batch("t_hp_return_det", $t_hp_return_det);
            }       


            if($_POST['approve']=="2"){
              $account_update=$this->account_update(0);
              if($account_update==1){
                $this->db->where("cl", $this->sd['cl']);
                $this->db->where("bc", $this->sd['branch']);
                $this->db->where('nno', $_POST['hid']);
                $this->db->update('t_hp_return_sum', $approve);

                $this->cancel_hp();

                $this->account_update(1);

                if($_POST["df_is_serial"]=='1'){
                  $this->save_serial();     
                }
                $this->load->model('trans_settlement');
                $this->db->insert('t_credit_note', $t_credit_note);
                $this->trans_settlement->save_settlement("t_credit_note_trans", $_POST['customer_id'], $_POST['date'], 17, $this->credit_max_no, 107, $this->max_no, $_POST['paid_amount'], "0");


                for($x = 0; $x < 25; $x++){
                  if(isset($_POST['0_'.$x])){
                    if($_POST['0_'.$x] != "" || !empty($_POST['0_'.$x])){
                      $this->trans_settlement->save_item_movement('t_item_movement',$_POST['0_'.$x],'107',$this->max_no,$_POST['date'],$_POST['1_' . $x],0,$_POST['store_id'],$this->utility->get_cost_price($_POST['0_' . $x]),$_POST['bt_'.$x],$this->get_sales_min_price($_POST['inv_no'],$_POST['0_' . $x]),$_POST['2_'.$x],$this->get_sales_purchase_price($_POST['inv_no'],$_POST['0_' . $x]),001);
                    }
                  }
                }

                if(isset($t_sub_item_movement)){if(count($t_sub_item_movement)){$this->db->insert_batch("t_item_movement_sub",$t_sub_item_movement);}}

                $this->utility->update_credit_note_balance($_POST['customer_id']);

                $this->utility->save_logger("APPROVE",107,$this->max_no,$this->mod);
              }else{
                return "Invalid account entries";
                $this->db->trans_commit();
              }

            }
          }else{
            echo "No permission to approve records";
            $this->db->trans_commit();
          }


          $this->utility->save_logger("EDIT",107,$this->max_no,$this->mod);

          echo $this->db->trans_commit();

            //}else{
              //echo $status;
              //$this->db->trans_commit();
            //}
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

public function cancel_hp(){

  $this->db->where('cl',$this->sd['cl']);
  $this->db->where('bc',$this->sd['branch']);
  $this->db->where('nno',$_POST['inv_no']);
  $this->db->update('t_hp_sales_sum', array("is_cancel"=>1));  

  $this->db->where('cl',$this->sd['cl']);
  $this->db->where('bc',$this->sd['branch']);
  $this->db->where('nno',$_POST['inv_no']);
  $this->db->update('t_hp_sales_sum', array("is_closed"=>1));  

}

public function get_sales_min_price($trans_no,$item){
  $this->db->select(array('min_price'));
  $this->db->where('cl',$this->sd['cl']);
  $this->db->where('bc',$this->sd['branch']);
  $this->db->where('nno',$trans_no);
  $this->db->where('item_code',$item);

  return $this->db->get('t_hp_sales_det')->row()->min_price;

}

public function get_sales_purchase_price($trans_no,$item){
  $this->db->select(array('pur_price'));
  $this->db->where('cl',$this->sd['cl']);
  $this->db->where('bc',$this->sd['branch']);
  $this->db->where('nno',$trans_no);
  $this->db->where('item_code',$item);

  return $this->db->get('t_hp_sales_det')->row()->pur_price;


}


public function account_update($condition) {
  $this->db->where("trans_no", $this->max_no);
  $this->db->where("trans_code", 107);
  $this->db->where("cl", $this->sd['cl']);
  $this->db->where("bc", $this->sd['branch']);
  $this->db->delete("t_check_double_entry");


  if($condition==1){
    if($_POST['hid'] != "0" || $_POST['hid'] != "") {
      $this->db->where("trans_no",  $this->max_no);
      $this->db->where("trans_code", 107);
      $this->db->where("cl", $this->sd['cl']);
      $this->db->where("bc", $this->sd['branch']);
      $this->db->delete("t_account_trans");
    }
  }


  $config = array(
    "ddate" => $_POST['date'],
    "trans_code" => 107,
    "trans_no" => $this->max_no,
    "op_acc" => 0,
    "reconcile" => 0,
    "cheque_no" => 0,
    "narration" => "",
    "ref_no" => $_POST['ref_no']
    );


  $sql_cus="SELECT name FROM m_customer WHERE code='".$_POST['customer_id']."' LIMIT 1";
  $cus = $this->db->query($sql_cus)->row()->name;
  $des = $cus;

  $this->load->model('account');
  $this->account->set_data($config);

  $this->account->set_value2("HP Return - ". $this->max_no, $_POST['paid_amount'], "cr", $_POST['customer_id'],$condition);

  $acc_code=$this->utility->get_default_acc('HP_RETURN');
  $this->account->set_value2($des, $_POST['paid_amount'], "dr", $acc_code,$condition);

  $total_item_cost=0;
  for($x=0;$x<25;$x++){
    if(isset($_POST['0_' . $x])){
      $total_item_cost=$total_item_cost+(($_POST['1_' . $x])*(double)$this->utility->get_cost_price($_POST['0_'.$x]));
    }
  }    

  $acc_code=$this->utility->get_default_acc('STOCK_ACC');
  $this->account->set_value2($des, $total_item_cost, "dr", $acc_code,$condition);

  $acc_code=$this->utility->get_default_acc('COST_OF_SALES');
  $this->account->set_value2($des, $total_item_cost, "cr", $acc_code,$condition);



  if($condition==0){
    $query = $this->db->query("
     SELECT (IFNULL( SUM( t.`dr_amount`),0) = IFNULL(SUM(t.`cr_amount`),0)) AS ok 
     FROM `t_check_double_entry` t
     LEFT JOIN `m_account` a ON t.`acc_code` = a.`code`
     WHERE  t.`cl`='" . $this->sd['cl'] . "'  AND t.`bc`='" . $this->sd['branch'] . "'  AND t.`trans_code`='8'  AND t.`trans_no` ='" . $this->max_no . "' AND 
     a.`is_control_acc`='0'");

    if($query->row()->ok == "0") {
      $this->db->where("trans_no", $this->max_no);
      $this->db->where("trans_code",8);
      $this->db->where("cl", $this->sd['cl']);
      $this->db->where("bc", $this->sd['branch']);
      $this->db->delete("t_check_double_entry");

      return "0";
    } else {

      return "1";
    }
  }
}

public function save_serial(){

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
                "trans_type" => 8,
                "trans_no" => $this->max_no,
                "item" => $_POST['0_'.$x],
                "batch_no" => $_POST['bt_'.$x],
                "serial_no" => $p[$i],
                "qty_in" => 1,
                "qty_out" => 0,
                "cost" => $_POST['2_'.$x],
                "store_code" => $_POST['store_id'],
                "computer" => $this->input->ip_address(),
                "oc" => $this->sd['oc'],
                );

              if(isset($t_serial_movement)) {
                $this->db->insert("t_serial_movement", $t_serial_movement);
              }

              $t_serial = array(
                    // "other_no1" => isset($p[2])?$p[2]:'',
                    // "other_no2" => isset($p[3])?$p[3]:'',
                "out_doc" => "",
                "out_no" => "",
                "out_date" => date("Y-m-d", time()),
                "available" => '1',
                "store_code" => $_POST['store_id']
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
}


public function check_code() {
  $this->db->where('code', $_POST['code']);
  $this->db->limit(1);
  echo $this->db->get($this->mtb)->num_rows;
}

private function set_delete() {
  $this->db->where("nno",$this->max_no);
  $this->db->where("cl", $this->sd['cl']);
  $this->db->where("bc", $this->sd['branch']);
  $this->db->delete("t_hp_return_det");

  $this->load->model('trans_settlement');
  $this->trans_settlement->delete_item_movement('t_item_movement',8,$this->max_no);

  $this->db->where("bc", $this->sd['branch']);
  $this->db->where("cl", $this->sd['cl']);
  $this->db->where("trans_no", $this->max_no);
  $this->db->where("trans_code", 107);
  $this->db->delete("t_item_movement_sub");

  $this->db->where("bc", $this->sd['branch']);
  $this->db->where("cl", $this->sd['cl']);
  $this->db->where("nno", $this->max_no);
  $this->db->delete("t_credit_note");
}

public function load() {
  $sqls="SELECT t_hp_return_sum.cl,
  t_hp_return_sum.bc,
  t_hp_return_sum.nno,
  t_hp_return_sum.ddate,
  t_hp_return_sum.ref_no,
  t_hp_return_sum.ref_bill_no,
  t_hp_return_sum.cus_id,
  m_customer.name,
  t_hp_return_sum.agr_no,
  t_hp_return_sum.inv_no,
  t_hp_return_sum.ref_bill_no,
  t_hp_return_sum.memo,
  t_hp_return_sum.store,
  m_stores.description AS store_name,
  t_hp_return_sum.salesman_id,
  m_employee.name AS salsman_name,
  t_hp_return_sum.gross_amount,
  t_hp_return_sum.discount,
  t_hp_return_sum.free_tot,
  t_hp_return_sum.net_amount,
  t_hp_return_sum.crn_no,
  t_hp_return_sum.crn_amount,
  t_hp_return_sum.paid_amount,
  t_hp_return_sum.is_cancel,
  t_hp_return_sum.is_approve
  FROM t_hp_return_sum
  JOIN m_customer ON m_customer.code=t_hp_return_sum.cus_id
  JOIN m_employee ON m_employee.code=t_hp_return_sum.salesman_id
  JOIN m_stores ON m_stores.code=t_hp_return_sum.store
  WHERE t_hp_return_sum.cl  ='".$this->sd['cl']."'
  AND t_hp_return_sum.bc ='".$this->sd['branch']."'
  AND t_hp_return_sum.nno ='".$_POST['id']."'";

  $querys=$this->db->query($sqls);

  if($querys->num_rows() > 0){
    $a['sum'] = $querys->result();
  } else {
    $a = 2;
  }


  $sql="SELECT t_hp_return_det.cl,
  t_hp_return_det.bc,
  t_hp_return_det.nno,
  t_hp_return_det.code,
  m_item.description,
  m_item.model,
  t_hp_return_det.qty,
  t_hp_return_det.discountp,
  t_hp_return_det.discount,
  t_hp_return_det.price,
  t_hp_return_det.amount,
  t_hp_return_det.batch_no,
  t_hp_return_det.foc,
  t_hp_return_det.is_free
  FROM t_hp_return_det
  JOIN m_item ON m_item.code=t_hp_return_det.code
  WHERE t_hp_return_det.cl  ='".$this->sd['cl']."'
  AND t_hp_return_det.bc ='".$this->sd['branch']."'
  AND t_hp_return_det.nno ='".$_POST['id']."'
  GROUP BY t_hp_return_det.code
  ORDER BY t_hp_return_det.auto_num";

  $query=$this->db->query($sql);

  if($query->num_rows() > 0){
    $a['det'] = $query->result();
  } else {
    $a = 2;
  }
  $this->db->select(array('t_serial_movement.item', 't_serial_movement.serial_no', 'other_no1', 'other_no2'));
  $this->db->from('t_serial_movement');
  $this->db->join('t_serial', 't_serial_movement.item=t_serial.item');
  $this->db->where('t_serial_movement.trans_no', $_POST['id']);
  $this->db->where('t_serial_movement.trans_type', 8);
  $this->db->where('t_serial_movement.cl', $this->sd['cl']);
  $this->db->where('t_serial_movement.bc', $this->sd['branch']);
  $this->db->group_by("t_serial_movement.serial_no");

  $query = $this->db->get();

  if ($query->num_rows() > 0) {
    $a['serial'] = $query->result();
  }else{
    $a['serial'] = 2;
  }

  echo json_encode($a);

}

public function delete() {
  $this->db->trans_begin();
  error_reporting(E_ALL); 
  function exceptionThrower($type, $errMsg, $errFile, $errLine) { 
    throw new Exception($errLine); 
  }
  set_error_handler('exceptionThrower'); 
  try { 

    if($this->user_permissions->is_delete('t_hp_return')){

      $bc=$this->sd['branch'];
      $cl=$this->sd['cl'];
      $trans_no=$_POST['trans_no'];
      $status=$this->trans_cancellation->hp_return_update_status();     

      if($status=="OK"){

        $this->db->where('cl',$this->sd['cl']);
        $this->db->where('bc',$this->sd['branch']);
        $this->db->where('trans_code','107');
        $this->db->where('trans_no',$trans_no);
        $this->db->delete('t_account_trans');

        $this->load->model('trans_settlement');
        $this->trans_settlement->delete_item_movement('t_item_movement',107,$trans_no);

        $this->db->where('cl',$cl);
        $this->db->where('bc',$bc);
        $this->db->where('trans_code','107');
        $this->db->where('trans_no',$trans_no);
        $this->db->delete('t_item_movement_sub');

        $this->db->select(array('inv_no'));
        $this->db->where('cl',$this->sd['cl']);
        $this->db->where('bc',$this->sd['branch']);
        $this->db->where('nno',$trans_no);
        $inv_no=$this->db->get('t_hp_return_sum')->row()->inv_no;

        $this->db->select(array('item','serial_no'));
        $this->db->where('cl',$this->sd['cl']);
        $this->db->where('bc',$this->sd['branch']);
        $this->db->where('trans_type',107);
        $this->db->where('trans_no',$trans_no);
        $query=$this->db->get('t_serial_movement');

        $t_serial = array(
          "out_doc" => 'HP',
          "out_no" => $inv_no,
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
        $this->db->where('trans_type',107);
        $this->db->where('trans_no',$trans_no);
        $this->db->delete("t_serial_movement_out");


        $data=array('is_cancel'=>'1');
        $this->db->where('cl',$this->sd['cl']);
        $this->db->where('bc',$this->sd['branch']);
        $this->db->where('nno',$trans_no);
        $this->db->update('t_hp_return_sum',$data);

        $this->db->where('cl',$this->sd['cl']);
        $this->db->where('bc',$this->sd['branch']);
        $this->db->where('nno',$trans_no);
        $this->db->update('t_hp_sales_sum', array("is_cancel"=>0));  

        $this->db->where('cl',$this->sd['cl']);
        $this->db->where('bc',$this->sd['branch']);
        $this->db->where('nno',$trans_no);
        $this->db->update('t_hp_sales_sum', array("is_closed"=>0));  


        $sql="UPDATE t_credit_note SET is_cancel='1' WHERE cl='$cl' AND bc='$bc' AND  nno IN (SELECT crn_no FROM t_hp_return_sum WHERE  cl='$cl' AND bc='$bc' AND nno='$trans_no')";
        $this->db->query($sql);

        $sql="DELETE  FROM t_credit_note_trans  WHERE cl='$cl' AND bc='$bc' AND  trans_no IN (SELECT crn_no FROM t_hp_return_sum WHERE  cl='$cl' AND bc='$bc' AND nno='$trans_no')";
        $this->db->query($sql);

        $sql="SELECT cus_id FROM t_hp_return_sum WHERE cl='".$this->sd['cl']."' AND bc='".$this->sd['branch']."' AND nno='".$_POST['trans_no']."'";
        $cus_id=$this->db->query($sql)->first_row()->cus_id;
        $this->utility->update_credit_note_balance($cus_id);

        $this->utility->save_logger("CANCEL",107,$trans_no,$this->mod);

        echo $this->db->trans_commit();
      }else{
        echo $status;
      }
    }else{

      $this->db->trans_commit();
      echo "No permission to delete records";
    }

  }catch(Exception $e){ 
    $this->db->trans_rollback();
    echo $e->getMessage(). "Operation fail please contact admin"; 
  }
}


public function f1_selection_agr_no() {
  if ($_POST['search'] == 'Key Word: code, name') {
    $_POST['search'] = "";
  }
  $sql = "SELECT s.nno,s.agreement_no,s.ref_no
  FROM `t_hp_sales_sum` s 
  WHERE s.`is_cancel`!='1' AND s.`is_closed`!='1' AND s.cl='".$this->sd['cl']."' AND s.bc='".$this->sd['branch']."'
  AND (s.nno LIKE '%$_POST[search]%' OR s.agreement_no LIKE '%$_POST[search]%') LIMIT 25";
  $query = $this->db->query($sql);
  $a = "<table id='item_list' style='width : 100%' >";
  $a .= "<thead><tr>";
  $a .= "<th class='tb_head_th'>Agreement</th>";
  $a .= "<th class='tb_head_th'>Invoice No</th>";
  $a .= "<th class='tb_head_th'>Ref Bill no</th>";
  $a .= "</thead></tr>";
  $a .= "<tr class='cl'>";
  $a .= "<td>&nbsp;</td>";
  $a .= "<td>&nbsp;</td>";
  $a .= "<td>&nbsp;</td>";
  $a .= "</tr>";

  foreach ($query->result() as $r) {
    $a .= "<tr class='cl'>";
    $a .= "<td>" . $r->agreement_no . "</td>";
    $a .= "<td>" . $r->nno . "</td>";
    $a .= "<td>" . $r->ref_no . "</td>";
    $a .= "</tr>";
  }
  $a .= "</table>";
  echo $a;
}

public function sum_details(){
  if($_POST['type']=='1'){
    $no='AND s.agreement_no="'.$_POST['agr'].'"';
  }else if($_POST['type']=='2'){
    $no='AND s.nno="'.$_POST['inv_no'].'"';
  }else{
    $no='AND s.ref_no="'.$_POST['bill_no'].'"';
  }

  $sql="SELECT s.nno,s.agreement_no,s.ref_no,s.`cus_id`,c.`name`,s.`store_id`,ms.description AS store,s.`rep`,e.`name` AS salesman
  FROM `t_hp_sales_sum` s 
  JOIN m_customer c ON c.`code`=s.`cus_id`
  JOIN `m_stores` ms ON ms.code=s.`store_id`
  JOIN m_employee e ON e.`code`=s.`rep`
  WHERE s.`is_cancel`!='1' AND s.`is_closed`!='1'
  AND s.cl='".$this->sd['cl']."' AND s.bc='".$this->sd['branch']."' $no  ";

  $query = $this->db->query($sql)->first_row();

  echo json_encode( $query);

}

public function load_grid_data(){
  $agr_no=$_POST['agr_no'];
  $sql="SELECT d.cl,d.bc,d.nno,d.item_code,i.`description`,i.`model`,d.batch_no,d.qty,d.sales_price,d.amount,d.discount_pre,d.discount,d.foc,d.is_free
  FROM `t_hp_sales_det` d
  JOIN `t_hp_sales_sum` s ON s.`nno`=d.`nno` AND s.cl=d.`cl` AND s.`bc`=d.`bc`
  JOIN m_item i ON i.`code`=d.`item_code`
  WHERE s.`is_cancel`!='1' AND s.`is_closed`!='1'AND s.agreement_no='$agr_no'";
  $query = $this->db->query($sql);
  if ($query->num_rows() > 0) {
    $data['a'] = $query->result();
  } else {
    $data['a'] = 2;
  }

  $sql_amount="SELECT s.`nno`,SUM(s.`gross_amount`)AS gross_amount ,SUM(s.`discount`) AS discount ,SUM(s.`foc_tot`) AS foc_tot,SUM(s.`net_amount`) AS net_amount
  FROM `t_hp_sales_sum` s
  WHERE s.`is_cancel`!='1' AND s.`is_closed`!='1'AND s.agreement_no='$agr_no'
  GROUP BY s.`nno`,s.agreement_no";
  $query_amount = $this->db->query($sql_amount);
  if ($query_amount->num_rows() > 0) {
    $data['b'] = $query_amount->result();
  } else {
    $data['b'] = 2;
  }

  $this->db->select(array('t_serial.item', 't_serial.serial_no'));
  $this->db->from('t_serial');
  $this->db->join('t_cash_sales_sum', 't_serial.out_no=t_cash_sales_sum.nno');
  $this->db->where('t_serial.out_doc', 6);
  $this->db->where('t_serial.out_no', $_POST['id']);
  $this->db->where('t_cash_sales_sum.cl', $this->sd['cl']);
  $this->db->where('t_cash_sales_sum.bc', $this->sd['branch']);
  $query = $this->db->get();

  if ($query->num_rows() > 0) {
    $data['serial'] = $query->result();
  } else {
    $data['serial'] = 2;
  }


  echo json_encode($data);
}

public function load_crn_data(){
  $agr_no=$_POST['agr_no'];
  $inv_no=$_POST['id'];

  $sql="SELECT agr_no,SUM(cr) AS crn_amount FROM `t_ins_trans` 
  WHERE cl='".$this->sd['cl']."' AND bc='".$this->sd['branch']."' AND agr_no='$agr_no'  GROUP BY cl,bc,agr_no";

  $query = $this->db->query($sql)->first_row();

  echo json_encode( $query);

}
public function get_crn_no() {
  $field = "nno";
  $this->db->select_max($field);
  $this->db->where("cl", $this->sd['cl']);
  $this->db->where("bc", $this->sd['branch']);
  return $this->db->get("t_credit_note")->first_row()->$field + 1;
}

public function check_is_serial_items($code) {
  $this->db->select(array('serial_no'));
  $this->db->where("code", $code);
  $this->db->limit(1);
  return $this->db->get("m_item")->first_row()->serial_no;
}


public function PDF_report() {
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

  $r_detail['type'] = $_POST['type'];
  $r_detail['dt'] = $_POST['dt'];
  $r_detail['qno'] = $_POST['qno'];
  $r_detail['agr_no'] = $_POST['agrmnt_no'];

  $r_detail['page'] = $_POST['page'];
  $r_detail['header'] = $_POST['header'];
  $r_detail['orientation'] = $_POST['orientation'];

  $this->db->select(array('nic as code', 'name', 'address1', 'address2', 'address3'));
  $this->db->where("code", $_POST['cus_id']);
  $r_detail['customer'] = $this->db->get('m_customer')->result();

  $this->db->select(array('name'));
  $this->db->where("code", $_POST['salesp_id']);
  $query = $this->db->get('m_employee');

  foreach ($query->result() as $row) {
    $r_detail['employee'] = $row->name;
  }

  $sql="SELECT `t_hp_return_det`.`code`,
  `t_hp_return_det`.`qty`,
  `t_hp_return_det`.`discount`,
  `t_hp_return_det`.`price`,
  `t_hp_return_det`.`amount`,
  `m_item`.`description`,
  `m_item`.`model`,
  c.`cc` AS sub_item,
  c.`deee` AS des,
  c.qty * t_hp_return_det.qty AS sub_qty FROM (`t_hp_return_det`) 
  JOIN `m_item` 
  ON `m_item`.`code` = `t_hp_return_det`.`code` 
  LEFT JOIN `m_item_sub` 
  ON `m_item_sub`.`item_code` = `m_item`.`code` 
  LEFT JOIN `r_sub_item` 
  ON `r_sub_item`.`code` = `m_item_sub`.`sub_item` 
  LEFT JOIN 
  (SELECT 
  t_hp_return_det.`code`,
  r_sub_item.`description` AS deee,
  r_sub_item.`code` AS cc,
  r_sub_item.`qty` AS qty,
  t_item_movement_sub.cl,
  t_item_movement_sub.bc,
  t_item_movement_sub.item,
  t_item_movement_sub.`sub_item` 
  FROM
  t_item_movement_sub 
  LEFT JOIN t_hp_return_det 
  ON t_hp_return_det.`code` = t_item_movement_sub.`item` 
  AND t_hp_return_det.`cl` = t_item_movement_sub.`cl` 
  AND t_hp_return_det.`bc` = t_item_movement_sub.`bc` 
  JOIN r_sub_item 
  ON t_item_movement_sub.`sub_item` = r_sub_item.`code` 
  WHERE t_item_movement_sub.batch_no = t_hp_return_det.`batch_no`  AND `t_hp_return_det`.`cl` = '".$this->sd['cl']."' 
  AND `t_hp_return_det`.`bc` = '".$this->sd['branch']."' AND `t_hp_return_det`.`nno` = '".$_POST['qno']."'  )c ON c.code = t_hp_return_det.`code`
  WHERE `t_hp_return_det`.`cl` = '".$this->sd['cl']."' 
  AND `t_hp_return_det`.`bc` = '".$this->sd['branch']."'
  AND `t_hp_return_det`.`nno` = '".$_POST['qno']."' 
  GROUP BY c.cc ,t_hp_return_det.`code`
  ORDER BY `t_hp_return_det`.`auto_num` ASC 
  ";

  $query = $this->db->query($sql);
  $r_detail['items'] = $this->db->query($sql)->result();

  $this->db->SELECT(array('serial_no','item'));
  $this->db->FROM('t_serial_movement');
  $this->db->WHERE('t_serial_movement.cl', $this->sd['cl']);
  $this->db->WHERE('t_serial_movement.bc', $this->sd['branch']);
  $this->db->WHERE('t_serial_movement.trans_type','8');
  $this->db->WHERE('t_serial_movement.trans_no',$_POST['qno']);
  $r_detail['serial'] = $this->db->get()->result();


  $this->db->select(array('gross_amount', 'net_amount'));
  $this->db->where('t_hp_return_sum.cl', $this->sd['cl']);
  $this->db->where('t_hp_return_sum.bc', $this->sd['branch']);
  $this->db->where('t_hp_return_sum.nno', $_POST['qno']);
  $r_detail['amount'] = $this->db->get('t_hp_return_sum')->result();

  $fee="SELECT sum(price*qty) AS free FROM t_hp_return_det WHERE is_free='1' AND nno = '".$_POST['qno']."'  AND cl='".$this->sd['cl']."' AND bc='".$this->sd['branch']."'";
  $r_detail['free_tot']=$this->db->query($fee)->result(); 

  $this->db->select_sum("discount");
  $this->db->where('cl', $this->sd['cl']);
  $this->db->where('bc', $this->sd['branch']);
  $this->db->where('nno', $_POST['qno']);
  $r_detail['discount'] = $this->db->get('t_hp_return_det')->result();

  $this->db->select(array('loginName'));
  $this->db->where('cCode', $this->sd['oc']);
  $r_detail['user'] = $this->db->get('users')->result();

  $this->load->view($_POST['by'] . '_' . 'pdf', $r_detail);
}



}