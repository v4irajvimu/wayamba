<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class t_free_purchase extends CI_Model {

  private $sd;
  private $mtb;
  private $max_no;
  private $tb_po_trans;

  private $mod = '003';
  private $trans_code="3";
  private $sub_trans_code="3";
  private $qty_in="0";

  function __construct(){
    parent::__construct();
    $this->sd = $this->session->all_userdata();
    $this->load->database($this->sd['db'], true);
    $this->mtb = $this->tables->tb['t_grn_sum'];
    $this->load->model('user_permissions');
    $this->tb_po_trans= $this->tables->tb['t_po_trans'];
  }

  public function base_details(){
    $this->load->model("m_stores");

    $a['stores']=$this->m_stores->select2();
    $a['max_no']=$this->utility->get_max_no("t_grn_sum","nno");
    return $a;
  }

  public function max_no($table_name,$field_name){
    $this->db->select_max($field_name);
    return $this->db->get($table_name)->first_row()->$field_name+1;
  }

  public function validation(){
    $this->max_no=$this->utility->get_max_no("t_grn_sum","nno"); 

    $this->price_change_max_no=$this->max_no("t_price_change_sum","nno");

    $status=1;
    $check_is_delete=$this->validation->check_is_cancel($this->max_no,'t_grn_sum');
    if($check_is_delete!=1){
      return "This purchase has been already cancelled";
    }

    $purchase_update_status=$this->trans_cancellation->purchase_update_status($this->max_no);
    if($purchase_update_status!="OK"){
      return $purchase_update_status;
    }

    $supplier_validation = $this->validation->check_is_supplier($_POST['supplier_id']);
    if ($supplier_validation != 1) {
      return $supplier_validation; 
    } 
    $serial_validation_status = $this->validation->serial_update('0_', '2_','all_serial_');
    if ($serial_validation_status != 1) {
      return $serial_validation_status;
    }
    /*$check_zero_value=$this->validation->empty_net_value($_POST['net_amount']);
    if($check_zero_value!=1){
      return $check_zero_value;
    }*/


    return $status;
  }


  public function get_debit_max_no(){
    $field = "nno";
    $this->db->select_max($field);
    $this->db->where("cl", $this->sd['cl']);
    $this->db->where("bc", $this->sd['branch']);
    return $this->db->get("t_debit_note")->first_row()->$field + 1;
  }

  public function save(){
    $this->db->trans_begin();
    error_reporting(E_ALL); 
    function exceptionThrower($type, $errMsg, $errFile, $errLine) { 
      throw new Exception($errFile); 
    }
    set_error_handler('exceptionThrower'); 
    try {
      $validation_status=$this->validation();

      if($validation_status==1){
        $this->debit_max_no = $this->get_debit_max_no();

        $t_grn_sum=array(
          "cl"=>$this->sd['cl'],
          "bc"=>$this->sd['branch'],
          "oc"=> $this->sd['oc'],
          "nno"=>$this->max_no,
          "ddate"=> $_POST['date'],
          "ref_no"=> $_POST['ref_no'],
          "supp_id"=> $_POST['supplier_id'],
          "credit_period"=> $_POST['credit_period'],
          "inv_no"=> $_POST['inv_no'],
          "inv_date"=> $_POST['ddate'],
          "memo"=> $_POST['memo'],
          "store"=> $_POST['stores'],
          "gross_amount"=> $_POST['gross_amount'],
          "discount_amount"=> $_POST['dis_amount'],
          "additional"=> $_POST['total'],
          "net_amount"=> $_POST['net_amount'],
          "post"=> $this->sd['oc'],
          "post_by"=> $this->sd['oc'],
          "post_date"=> $this->sd['oc'],
          "balance"=> $_POST['net_amount'],
          "type" => $_POST['typess'],
          "check_by" => $_POST['checkby'],
          "vehicle_no" => $_POST['vehicleNo'],
          "del_officer" => $_POST['del_officer'],
          "is_free_purchase"=>1,
          );



for($x =0; $x<25; $x++){
  if(isset($_POST['0_'.$x],$_POST['2_'.$x], $_POST['4_'.$x])){
    if($_POST['0_'.$x] != "" && $_POST['2_'.$x] != ""  && $_POST['4_'.$x] != "" ){
      $po_pur=$_POST['po_'.$x];
      $pp=explode(",",$po_pur);
      for($t=0; $t<count($pp)-1; $t++){
        $p = explode("-",$pp[$t]);
        $nno=$p[0];
        $qty=$p[1];

        $t_grn_free_trans[]= array(
          "cl"=>$this->sd['cl'],
          "bc"=>$this->sd['branch'],
          "item_code"=>$_POST['0_'.$x],
          "trans_code"=>3,
          "trans_no"=>$nno,
          "sub_trans_code"=>3,
          "sub_trans_no"=>$this->max_no,
          "receivable_qty"=>0,
          "received_qty"=>$qty,
          ); 
      }              
    }
  }
}

for($x =0; $x<25; $x++){
  if(isset($_POST['0_'.$x],$_POST['2_'.$x],$_POST['4_'.$x])){
    if($_POST['0_'.$x] != "" && $_POST['2_'.$x] != "" && $_POST['4_'.$x] != "" ){
      $t_grn_det[]= array(
        "cl"=>$this->sd['cl'],
        "bc"=>$this->sd['branch'],
        "nno"=>$this->max_no,
        "code"=>$_POST['0_'.$x],
        "qty"=>$_POST['2_'.$x],
        "price"=>$_POST['4_'.$x],
        "max_price"=>$_POST['max_'.$x],
        "min_price"=>$_POST['min_'.$x],
        "discountp"=>$_POST['5_'.$x],
        "discount"=>$_POST['6_'.$x], 
        "foc"=>$_POST['freeqty_'.$x],
        "amount"=>$_POST['t_'.$x],
        "color"=>$_POST['colc_'.$x],
        "batch_no"=>$this->utility->get_batch_no($_POST['0_'.$x],$_POST['4_'.$x],$_POST['max_'.$x],$_POST['min_'.$x],$_POST['colc_'.$x],$_POST['colc_'.$x])
        ); 

      $change[]= array(
        "code"            =>$_POST['0_'.$x],
        "purchase_price"  =>$_POST['4_'.$x],
        "min_price"       =>$_POST['min_'.$x],
        "max_price"       =>$_POST['max_'.$x],
        ); 

            //----------------------------------   

      $cost_price=$this->utility->get_cost_price($_POST['0_'.$x]);
      $max_price=$this->utility->get_max_price($_POST['0_'.$x]);
      $min_price=$this->utility->get_min_price($_POST['0_'.$x]);

      $new_price=$_POST['4_'.$x];
      $new_max_price=$_POST['max_'.$x];
      $new_min_price=$_POST['min_'.$x];

      if($new_price!=$cost_price){
        $price_change_sum=array(
          "nno"=>$this->price_change_max_no,
          "ddate"=> $_POST['date'],
          "ref_no"=> "FROM GRN ".$this->max_no,
          "oc"=> $this->sd['oc']
          );

        $price_change_det[]=array(
          "nno"=>$this->price_change_max_no,
          "item"=>$_POST['0_'.$x],
          "cost"=>$new_price,
          "last_price"=>$min_price,
          "max_price"=>$max_price,
          "last_price_new" =>$new_min_price,
          "max_price_new" =>$new_max_price
          );
      }
    }
  }
}

$wordChunks = explode(",",$_POST['srls']);
$execute=0;
$subs=0;

for($x = 0; $x<25; $x++){
  if(isset($_POST['0_'.$x])){
    if($_POST['0_'.$x] != ""){
      if(isset($_POST['subcode_'.$x])){
        $subs = $_POST['subcode_'.$x];
        if($_POST['subcode_'.$x]!="0" && $_POST['subcode_'.$x]!=""){
          $sub_items = (explode(",",$subs));
          $arr_length= (int)sizeof($sub_items)-1;
          for($y = 0; $y<$arr_length; $y++){
            $item_sub = (explode("-",$sub_items[$y]));
            if(isset($item_sub[1] , $item_sub[0])){
              $sub_qty = (int)$_POST['2_'.$x] * (int)$item_sub[1];
            }
            $t_sub_item_movement[]=array(
              "cl"=>$this->sd['cl'],
              "bc"=>$this->sd['branch'],
              "item"=>$_POST['0_'.$x],
              "sub_item"=>$item_sub[0],
              "trans_code"=>3,
              "trans_no"=>$this->max_no,
              "ddate"=>$_POST['date'],
              "qty_in"=>$sub_qty,
              "qty_out"=>0,
              "store_code"=>$_POST['stores'],
              "avg_price"=>$_POST['4_'.$x],
              "batch_no"=>$this->utility->get_batch_no($_POST['0_'.$x],$_POST['4_'.$x],$_POST['max_'.$x],$_POST['min_'.$x],$_POST['colc_'.$x],$_POST['colc_'.$x]),
              "sales_price"=>$_POST['max_'.$x],
              "last_sales_price"=>$_POST['min_'.$x],
              "cost"=>$_POST['4_'.$x]
              );
          }
        }
      }

    }
  }       
}

if($_POST['hid'] == "0" || $_POST['hid'] == ""){
  if($this->user_permissions->is_add('t_free_purchase')){

    $this->db->insert($this->mtb,  $t_grn_sum);
    if(count($t_grn_det)){$this->db->insert_batch("t_grn_det",$t_grn_det);}

    $this->utility->save_logger("SAVE",3,$this->max_no,$this->mod);
    echo $this->db->trans_commit();
  }else{
    $this->db->trans_commit();
    echo "No permission to save records";
  }  
}else{
  if($this->user_permissions->is_edit('t_free_purchase')){
    $status=$this->trans_cancellation->purchase_update_status($this->max_no);     
    if($status=="OK"){

      $this->set_delete();

      $this->db->where("cl",$this->sd['cl']);
      $this->db->where("bc",$this->sd['branch']);
      $this->db->where('nno',$_POST['hid']);
      $this->db->update($this->mtb, $t_grn_sum);

      if(count($t_grn_det)){$this->db->insert_batch("t_grn_det",$t_grn_det);}

      if($_POST['app_status']=="2"){
        $account_update=$this->account_update(0);
        if($account_update==1){

          if(isset($_POST['bal_item'])){
            for($x =0; $x<25; $x++){
              if(isset($_POST['0_'.$x],$_POST['2_'.$x], $_POST['4_'.$x])){
                if($_POST['0_'.$x] != "" && $_POST['2_'.$x] != ""  && $_POST['4_'.$x] != "" ){
                  $po_pur=$_POST['po_'.$x];
                  $pp=explode(",",$po_pur);
                  for($t=0; $t<count($pp)-1; $t++){
                    $p = explode("-",$pp[$t]);
                    $nno=$p[0];
                    $qty=$p[1];

                    $t_grn_free_transs[]= array(
                      "cl"=>$this->sd['cl'],
                      "bc"=>$this->sd['branch'],
                      "item_code"=>$_POST['0_'.$x],
                      "trans_code"=>3,
                      "trans_no"=>$nno,
                      "sub_trans_code"=>3,
                      "sub_trans_no"=>$this->max_no,
                      "receivable_qty"=>0,
                      "received_qty"=>$qty,
                      "is_cancel"=>1
                      );

                  }              
                }
              }
            }
            //--------check from below--------
            if(isset($t_grn_free_transs)){
              if(count($t_grn_free_transs)){$this->db->insert_batch("t_grn_free_trans",$t_grn_free_transs);}
            }

            $this->db->where("cl",$this->sd['cl']);
            $this->db->where("bc",$this->sd['branch']);
            $this->db->where('nno',$_POST['hid']);
            $this->db->update($this->mtb, array("is_approve"=>"1"));
            
            echo $this->db->trans_commit(); 
          }else{

            if(isset($t_grn_free_trans)){
              if(count($t_grn_free_trans)){$this->db->insert_batch("t_grn_free_trans",$t_grn_free_trans);}
            }

            if($_POST["df_is_serial"]=='1') {
              $this->save_serial();
            }
            $this->account_update(1);

            if(isset($price_change_sum)){
              $this->db->insert("t_price_change_sum", $price_change_sum);
            }

            if(isset($price_change_det)){
              if(count($price_change_det)){
                $this->db->insert_batch("t_price_change_det", $price_change_det);                
              }
            }

            //$this->utility->remove_batch_item($this->sd['cl'],$this->sd['branch'],3,$this->max_no,"t_item_batch");
            $this->load->model('trans_settlement');
            for($x =0; $x<25; $x++){
              if(isset($_POST['0_'.$x],$_POST['2_'.$x])){
                if($_POST['0_'.$x] != "" && $_POST['2_'.$x] != "" ){

                  $bbatch_no = $this->utility->get_batch_no($_POST['0_'.$x],$_POST['4_'.$x],$_POST['max_'.$x],$_POST['min_'.$x],$_POST['colc_'.$x]);


                  for($y=0;$y<sizeof($change);$y++){
                    $item=array(
                      "purchase_price"  =>$change[$y]['purchase_price'],
                      "min_price"       =>$change[$y]['min_price'],
                      "max_price"       =>$change[$y]['max_price'], 
                      );
                    $this->db->where('code',$change[$y]['code']);
                    $this->db->update('m_item',$item);
                  }


                  if($this->utility->is_batch_item($_POST['0_'.$x])){
                    if($this->utility->batch_in_item_batch_tb($_POST['0_'.$x],$bbatch_no)){
                      $this->load->model('utility');

                      $this->utility->insert_batch_items(
                        $this->sd['cl'],
                        $this->sd['branch'],
                        $_POST['0_'.$x],
                        3,
                        $this->max_no,
                        $bbatch_no,
                        $_POST['4_'.$x],
                        $_POST['min_'.$x],
                        $_POST['max_'.$x],
                        '0.00',
                        '0.00',
                        '0.00',
                        '0.00',
                        $_POST['colc_'.$x],
                        $_POST['supplier_id'],
                        $this->sd['oc'],
                        "t_item_batch"
                        );                      
                    }
                  }else if($this->utility->check_item_in_batch_table($_POST['0_'.$x])){
                   $this->utility->insert_batch_items(
                    $this->sd['cl'],
                    $this->sd['branch'],
                    $_POST['0_'.$x],
                    3,
                    $this->max_no,
                    $bbatch_no,
                    $_POST['4_'.$x],
                    $_POST['min_'.$x],
                    $_POST['max_'.$x],
                    '0.00',
                    '0.00',
                    '0.00',
                    '0.00',
                    $_POST['colc_'.$x],
                    $_POST['supplier_id'],
                    $this->sd['oc'],
                    "t_item_batch"
                    );
                 }             


                 $this->trans_settlement->save_item_movement('t_item_movement',
                  $_POST['0_'.$x],
                  '3',
                  $this->max_no,
                  $_POST['date'],
                  $_POST['2_'.$x],
                  0,
                  $_POST['stores'],
                  $_POST['4_'.$x],
                  $bbatch_no,
                  $_POST['min_'.$x],
                  $_POST['max_'.$x],
                  $_POST['4_'.$x],
                  '001');
               }
             }
           }
             //$this->trans_settlement->delete_settlement("t_sup_settlement",3,$this->max_no);
             //$this->trans_settlement->save_settlement("t_sup_settlement",$_POST['supplier_id'],$_POST['ddate'],3,$this->max_no,3,$this->max_no,$_POST['net_amount'],"0");

           if(isset($t_sub_item_movement)){if(count($t_sub_item_movement)){$this->db->insert_batch("t_item_movement_sub",$t_sub_item_movement);}}

           $this->utility->update_purchase_balance($_POST['supplier_id']); 

           $this->db->where("cl",$this->sd['cl']);
           $this->db->where("bc",$this->sd['branch']);
           $this->db->where('nno',$_POST['hid']);
           $this->db->update($this->mtb, array("is_approve"=>"1"));

           echo $this->db->trans_commit();  
         }
       }else{
        echo "Invalid account entries";
        $this->db->trans_commit();
      }
    }

    if($_POST['app_status']=="2"){
      $this->utility->save_logger("APPROVE",3,$this->max_no,$this->mod);  
    }else{
      $this->utility->save_logger("EDIT",3,$this->max_no,$this->mod);  
      echo $this->db->trans_commit();  
    }
  }else{
    echo $status;
    $this->db->trans_commit();
  }
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

public function account_update($condition){

  $this->db->where("trans_no", $this->max_no);
  $this->db->where("trans_code", 3);
  $this->db->where("cl", $this->sd['cl']);
  $this->db->where("bc", $this->sd['branch']);
  $this->db->delete("t_check_double_entry");

  if($condition==1){
    if($_POST['hid'] != "0" || $_POST['hid'] != "") {
      $this->db->where("trans_no",  $this->max_no);
      $this->db->where("trans_code", 3);
      $this->db->where("cl", $this->sd['cl']);
      $this->db->where("bc", $this->sd['branch']);
      $this->db->delete("t_account_trans");
    }
  }

  $config = array(
    "ddate" => $_POST['date'],
    "trans_code"=>3,
    "trans_no"=>$this->max_no,
    "op_acc"=>0,
    "reconcile"=>0,
    "cheque_no"=>0,
    "narration"=>"",
    "ref_no" => $_POST['ref_no']
    );

  $sql_s="SELECT name FROM m_supplier WHERE code='".$_POST['supplier_id']."' ";
  $s_name=$this->db->query($sql_s)->row()->name;
  $des = $s_name;
  
  $this->load->model('account');
  $this->account->set_data($config);

  for($x = 0; $x<25; $x++){
    if(isset($_POST['00_'.$x],$_POST['22_'.$x],$_POST['hh_'.$x])){
      if($_POST['00_'.$x] != "" && $_POST['22_'.$x] != "" && $_POST['hh_'.$x] != "" ){

        $sql="select is_add,account from r_additional_item where code ='".$_POST['00_'.$x]."' ";

        $query=$this->db->query($sql);
        $con=$query->row()->is_add;
        $acc_code=$query->row()->account;

        if(isset($_POST['cost_'.$x])){  
          if($_POST['cost_'.$x]!="1"){ 
            if($con=="1"){
              $this->account->set_value2($des,$_POST['22_'.$x], "dr", $acc_code,$condition);  
            }elseif($con=="0"){
              $this->account->set_value2($des,$_POST['22_'.$x], "cr", $acc_code,$condition);    
            }
          } 
        }else{
          if($con=="1"){
            $this->account->set_value2($des,$_POST['22_'.$x], "dr", $acc_code,$condition);  
          }elseif($con=="0"){
            $this->account->set_value2($des,$_POST['22_'.$x], "cr", $acc_code,$condition);    
          }
        }   

      }
    }
  }

  $acc_code=$this->utility->get_default_acc('STOCK_ACC');  

  if($_POST['freet']!="0" && $_POST['freet']!=""){
    //$tot= (float)$_POST['gross_amount']+(float)$_POST['freet'];
    $tot= (float)$_POST['gross_amount'];
    $free_code=$this->utility->get_default_acc('TOUR_OF_BANGKOK');

    $this->account->set_value2($des,$_POST['freet'], "cr", $free_code,$condition); 
    $this->account->set_value2($des, $_POST['net_amount'], "cr", $_POST['supplier_id'],$condition);
    $this->account->set_value2($des, $tot, "dr", $acc_code,$condition); 
  }else{
    $this->account->set_value2($des, $_POST['net_amount'], "cr", $_POST['supplier_id'],$condition);
    $this->account->set_value2($des, $_POST['gross_amount'], "dr", $acc_code,$condition);  
  } 


  if($condition==0){

    $query = $this->db->query("
     SELECT (IFNULL( SUM( t.`dr_amount`),0) = IFNULL(SUM(t.`cr_amount`),0)) AS ok 
     FROM `t_check_double_entry` t
     LEFT JOIN `m_account` a ON t.`acc_code` = a.`code`
     WHERE  t.`cl`='" . $this->sd['cl'] . "'  AND t.`bc`='" . $this->sd['branch'] . "'  AND t.`trans_code`='3'  AND t.`trans_no` ='" . $this->max_no . "' AND 
     a.`is_control_acc`='0'");


    if($query->row()->ok == "0") {
      $this->db->where("trans_no", $this->max_no);
      $this->db->where("trans_code",3);
      $this->db->where("cl", $this->sd['cl']);
      $this->db->where("bc", $this->sd['branch']);
      $this->db->delete("t_check_double_entry");
      return "0";
    }else {
      return "1";
    }
  }
}  

public function check_code() {
  $this->db->where('code', $_POST['code']);
  $this->db->where("cl",$this->sd['cl']);
  $this->db->where("bc",$this->sd['branch']);
  $this->db->limit(1);
  echo $this->db->get($this->mtb)->num_rows;
}

public function save_serial(){

  for($x = 0; $x<25; $x++){
    if(isset($_POST['0_'.$x])){
      if($_POST['0_'.$x] != "" || !empty($_POST['0_' . $x])){
        if($this->check_is_serial_items($_POST['0_'.$x])==1){
          $serial = $_POST['all_serial_'.$x];
          $pp=explode(",",$serial);

          for($t=0; $t<count($pp); $t++){
            $p = explode("-",$pp[$t]);

            $t_serial[]=array(
              "cl"=>$this->sd['cl'],
              "bc"=>$this->sd['branch'],
              "trans_type"=>3,
              "trans_no"=>$this->max_no,
              "date"=>$_POST['ddate'],
              "item"=>$_POST['0_'.$x],
              "batch"=>$this->utility->get_batch_no($_POST['0_'.$x],$_POST['4_'.$x],$_POST['max_'.$x],$_POST['min_'.$x],$_POST['colc_'.$x]),
              "serial_no"=>$p[0],
              "other_no1"=>$p[1],
              "other_no2"=>$p[2],
              "cost"=>$_POST['4_'.$x],
              "max_price"=>$this->utility->get_max_price($_POST['0_'.$x]),
              "last_price"=>$this->utility->get_min_price($_POST['0_'.$x]),
              "store_code"=>$_POST['stores'],
              "engine_no"=>"",
              "chassis_no"=>'',
              "out_doc"=>'',
              "out_no"=>'',
              "out_date"=>''
              );

            $t_serial_movement[]=array(
              "cl"=>$this->sd['cl'],
              "bc"=>$this->sd['branch'],
              "trans_type"=>3,
              "trans_no"=>$this->max_no,
              "item"=>$_POST['0_'.$x],
              "batch_no"=>$this->utility->get_batch_no($_POST['0_'.$x],$_POST['4_'.$x],$_POST['max_'.$x],$_POST['min_'.$x],$_POST['colc_'.$x]),
              "serial_no"=>$p[0],
              "qty_in"=>1,
              "qty_out"=>0,
              "cost"=>$_POST['4_'.$x],
              "store_code"=>$_POST['stores'],
              "computer"=>$this->input->ip_address(),
              "oc"=>$this->sd['oc'],
              ); 
          }                  
        }
      }
    }
  }

  if($_POST['hid'] == "0" || $_POST['hid'] == ""){
    if(isset($t_serial)){if(count($t_serial)){  $this->db->insert_batch("t_serial", $t_serial);}}
    if(isset($t_serial_movement)){if(count($t_serial_movement)){  $this->db->insert_batch("t_serial_movement", $t_serial_movement);}}

  }else{

    $this->db->where("bc",$this->sd['branch']);
    $this->db->where("cl", $this->sd['cl']);
    $this->db->where("trans_type",3);
    $this->db->where("trans_no", $this->max_no);
    $this->db->delete("t_serial_movement");

    $this->db->where("bc",$this->sd['branch']);
    $this->db->where("cl", $this->sd['cl']);
    $this->db->where("trans_type",3);
    $this->db->where("trans_no", $this->max_no);
    $query=$this->db->get("t_serial");

    foreach($query->result() as $row){
      $this->db->where("bc",$this->sd['branch']);
      $this->db->where("cl", $this->sd['cl']);
      $this->db->where("item",$row->item);
      $this->db->where("serial_no", $row->serial_no);
      $this->db->delete("t_serial");

      $this->db->where("bc",$this->sd['branch']);
      $this->db->where("cl", $this->sd['cl']);
      $this->db->where("item",$row->item);
      $this->db->where("serial_no", $row->serial_no);
      $this->db->delete("t_serial_movement");
    } 

    if(isset($t_serial)){if(count($t_serial)){  $this->db->insert_batch("t_serial", $t_serial);}}
    if(isset($t_serial_movement)){if(count($t_serial_movement)){  $this->db->insert_batch("t_serial_movement", $t_serial_movement);}}
  }
}   

private function set_delete(){ 
  if($_POST['hid'] != "0" || $_POST['hid'] != ""){   
    $this->db->where("nno",  $this->max_no);
    $this->db->where("cl", $this->sd['cl']);
    $this->db->where("bc", $this->sd['branch']);
    $this->db->delete("t_grn_det");

    $this->db->where("cl", $this->sd['cl']);
    $this->db->where("bc", $this->sd['branch']);
    $this->db->where("sub_trans_code", 3);
    $this->db->where("sub_trans_no", $this->max_no);
    $this->db->delete("t_grn_free_trans");      

    $this->load->model('trans_settlement');
    $this->trans_settlement->delete_item_movement('t_item_movement',3,$this->max_no);

    $this->db->where("trans_code", 3);
    $this->db->where("trans_no",  $this->max_no);
    $this->db->where("cl", $this->sd['cl']);
    $this->db->where("bc", $this->sd['branch']);
    $this->db->delete("t_item_movement_sub");

    $this->db->where("bc",$this->sd['branch']);
    $this->db->where("cl", $this->sd['cl']);
    $this->db->where("trans_code",3);
    $this->db->where("trans_no", $this->max_no);
    $this->db->delete("t_item_batch");


  }  
}


public function load(){

  $cl=$this->sd['cl'];
  $bc=$this->sd['branch'];
  $this->db->select(array(
    'm_supplier.code as scode' ,
    'm_supplier.name',
    'm_stores.code as stcode',
    'm_stores.description',
    't_grn_sum.nno',
    't_grn_sum.ddate',
    't_grn_sum.ref_no',
    't_grn_sum.credit_period',
    't_grn_sum.po_no',
    't_grn_sum.po_no2',
    't_grn_sum.po_no3',
    't_grn_sum.inv_no',
    't_grn_sum.inv_date',
    't_grn_sum.memo',
    't_grn_sum.gross_amount',
    't_grn_sum.additional',
    't_grn_sum.type',
    't_grn_sum.net_amount',
    't_grn_sum.is_cancel',
    't_grn_sum.check_by',
    't_grn_sum.is_approve',
    't_grn_sum.del_officer',
    't_grn_sum.vehicle_no',
    'm_employee.name as check_by_des',
    't_grn_sum.po_active',
    't_grn_sum.is_free_purchase',
    't_grn_sum.is_debit_note'
    
    ));

  $this->db->from('m_supplier');
  $this->db->join('t_grn_sum','m_supplier.code=t_grn_sum.supp_id');
  $this->db->join('m_stores','m_stores.code=t_grn_sum.store');
  $this->db->join('m_employee','m_employee.code=t_grn_sum.check_by','left');
  $this->db->where('t_grn_sum.cl',$this->sd['cl'] );
  $this->db->where('t_grn_sum.bc',$this->sd['branch'] );
  $this->db->where('t_grn_sum.nno',$_POST['id']);
  $query=$this->db->get();

  $x=0;
  if($query->num_rows()>0){
    $a['sum']=$query->result();
  }else{
    $x=2;
  }

  $this->db->select(array(              
    'm_item.code as icode',
    'm_item.description as idesc',
    'm_item.model',
    't_grn_det.nno',
    't_grn_det.qty',
    't_grn_det.foc',
    't_grn_det.discountp',
    't_grn_det.discount',
    't_grn_det.price',
    't_grn_det.min_price',
    't_grn_det.max_price',
    't_grn_det.sale_price_3',
    't_grn_det.sale_price_4',
    't_grn_det.amount',
    't_grn_det.po_pur',
    't_grn_det.is_free',
    't_grn_det.color',
    'r_color.description'
    ));

  $this->db->from('m_item'); 
  $this->db->join('t_grn_det','m_item.code=t_grn_det.code');     
  $this->db->join('r_color','t_grn_det.color=r_color.code','LEFT');              
  $this->db->where('t_grn_det.cl',$this->sd['cl'] );
  $this->db->where('t_grn_det.bc',$this->sd['branch'] );
  $this->db->where('t_grn_det.nno',$_POST['id']);
  $this->db->order_by('t_grn_det.auto_num','asc');
  $query=$this->db->get();

  if($query->num_rows()>0){
    $a['det']=$query->result();
  }else{
    $x=2;
  }   




  $sql="SELECT t_serial.`item`, t_serial.`serial_no`,t_serial.`other_no1`, t_serial.`other_no2` 
  FROM `t_serial_movement` 
  INNER JOIN t_serial ON t_serial.`serial_no`=t_serial_movement.`serial_no` 
  WHERE t_serial_movement.trans_no = '$_POST[id]' AND t_serial_movement.trans_type='3' AND t_serial_movement.`cl` = '$cl' AND t_serial_movement.`bc` = '$bc'
  UNION ALL
  SELECT t_serial.`item`, t_serial.`serial_no`,t_serial.`other_no1`, t_serial.`other_no2`
  FROM `t_serial_movement_out` 
  INNER JOIN t_serial ON t_serial.`serial_no`=t_serial_movement_out.`serial_no` 
  WHERE t_serial_movement_out.trans_no = '$_POST[id]' AND t_serial_movement_out.trans_type='3' AND t_serial_movement_out.`cl` = '$cl' AND t_serial_movement_out.`bc` = '$bc'";


  $query=$this->db->query($sql);

  if($query->num_rows()>0){
    $a['serial']=$query->result();
  }else{
    $a['serial']=2;
  }


  if($x==0){
    echo json_encode($a);
  }else{
    echo json_encode($x);
  }
}

public function delete(){
  $this->db->trans_begin();
  error_reporting(E_ALL); 
  function exceptionThrower($type, $errMsg, $errFile, $errLine) { 
    throw new Exception($errMsg); 
  }
  set_error_handler('exceptionThrower'); 
  try { 
    if($this->user_permissions->is_delete('t_free_purchase')){
      $status=$this->trans_cancellation->purchase_update_status($_POST['trans_no']);     
      if($status=="OK"){

        $trans_no=$_POST['trans_no'];

        $this->db->where('cl',$this->sd['cl']);
        $this->db->where('bc',$this->sd['branch']);
        $this->db->where('trans_code','3');
        $this->db->where('trans_no',$_POST['trans_no']);
        $this->db->delete('t_sup_settlement');

        $this->db->where("cl", $this->sd['cl']);
        $this->db->where("bc", $this->sd['branch']);
        $this->db->where("sub_trans_code", 3);
        $this->db->where("sub_trans_no", $_POST['trans_no']);
        $this->db->delete("t_grn_free_trans");      

        $this->db->where('cl',$this->sd['cl']);
        $this->db->where('bc',$this->sd['branch']);
        $this->db->where('trans_code','3');
        $this->db->where('trans_no',$_POST['trans_no']);
        $this->db->delete('t_item_batch');
        
        $this->db->where('cl',$this->sd['cl']);
        $this->db->where('bc',$this->sd['branch']);
        $this->db->where('trans_type','3');
        $this->db->where('trans_no',$_POST['trans_no']);
        $this->db->delete('t_serial_movement');

        $this->db->where('cl',$this->sd['cl']);
        $this->db->where('bc',$this->sd['branch']);
        $this->db->where('trans_type','3');
        $this->db->where('trans_no',$_POST['trans_no']);
        $this->db->delete('t_serial');

        $this->load->model('trans_settlement');
        $this->trans_settlement->delete_item_movement('t_item_movement',3,$_POST['trans_no']);

        $this->db->where('cl',$this->sd['cl']);
        $this->db->where('bc',$this->sd['branch']);
        $this->db->where('trans_code','3');
        $this->db->where('trans_no',$_POST['trans_no']);
        $this->db->delete('t_item_movement_sub');

        $this->db->where('cl',$this->sd['cl']);
        $this->db->where('bc',$this->sd['branch']);
        $this->db->where('trans_code','3');
        $this->db->where('trans_no',$_POST['trans_no']);
        $this->db->delete('t_account_trans');


        $this->utility->remove_batch_item($this->sd['cl'],$this->sd['branch'],3,$_POST['trans_no'],"t_item_batch");

        $this->db->where("bc", $this->sd['branch']);
        $this->db->where("cl", $this->sd['cl']);
        $this->db->where("ref_trans_code", 3);
        $this->db->where("ref_trans_no", $_POST['trans_no']);
        $this->db->update("t_debit_note",array("is_cancel"=>1));

        $this->db->where("bc", $this->sd['branch']);
        $this->db->where("cl", $this->sd['cl']);
        $this->db->where("sub_trans_code", 3);
        $this->db->where("sub_trans_no", $_POST['trans_no']);
        $this->db->delete("t_debit_note_trans");

        $data=array('is_cancel'=>'1');
        $this->db->where('cl',$this->sd['cl']);
        $this->db->where('bc',$this->sd['branch']);
        $this->db->where('nno',$_POST['trans_no']);
        $this->db->update('t_grn_sum',$data);

        $sql="SELECT supp_id FROM t_grn_sum WHERE cl='".$this->sd['cl']."' AND bc='".$this->sd['branch']."' AND nno='".$_POST['trans_no']."'";
        $sup_id=$this->db->query($sql)->first_row()->supp_id;

        $this->utility->update_purchase_balance($sup_id);     

        $this->utility->save_logger("CANCEL",3,$_POST['trans_no'],$this->mod);  
        
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
    echo "Operation fail please contact admin"; 
  } 
}

public function get_item(){
  $this->db->select(array('code','description','purchase_price','model'));
  $this->db->where("code",$this->input->post('code'));
  $this->db->limit(1);
  $query=$this->db->get('m_item');
  if($query->num_rows() > 0){
    $data['a']=$query->result();
  }else{
    $data['a']=2;
  }
  echo json_encode($data);
}


public function load_po_nos(){

  $cl=$this->sd['cl'];
  $bc=$this->sd['branch'];

  if($_POST['search'] == 'Key Word: code, name'){$_POST['search'] = "";}

  if($_POST['sup'] != ""){

   $supplier = $_POST['sup'];
   $sql="SELECT trans_no AS nno, SUM(request_qty),SUM(received_qty),p.ddate AS date
   FROM t_po_trans
   JOIN (SELECT * FROM t_po_sum WHERE inactive='0' AND TYPE='".$_POST['type']."' AND cl ='$cl' AND bc='$bc' AND supplier = '$supplier') p
   ON p.`nno` = t_po_trans.`trans_no` AND p.cl=t_po_trans.`cl` AND p.bc = t_po_trans.bc
   WHERE t_po_trans.cl='$cl' AND t_po_trans.bc='$bc' AND inactive = '0' AND t_po_trans.type='".$_POST['type']."' AND trans_no LIKE '%$_POST[search]%' AND p.supplier = '$supplier'
   GROUP BY trans_no
   HAVING  SUM(request_qty)>SUM(received_qty)
   LIMIT 25 ";

 }else{
  $sql="SELECT trans_no AS nno, SUM(request_qty),SUM(received_qty),p.ddate AS date
  FROM t_po_trans
  JOIN (SELECT * FROM t_po_sum WHERE inactive='0' AND TYPE='".$_POST['type']."' AND cl ='$cl' AND bc='$bc') p
  ON p.`nno` = t_po_trans.`trans_no` AND p.cl=t_po_trans.`cl` AND p.bc = t_po_trans.bc
  WHERE t_po_trans.cl='$cl' AND t_po_trans.bc='$bc' AND inactive = '0' AND t_po_trans.type='".$_POST['type']."' AND trans_no LIKE '%$_POST[search]%'
  GROUP BY trans_no
  HAVING  SUM(request_qty)>SUM(received_qty)
  LIMIT 25 ";
}

   // $sql="SELECT nno,supplier FROM t_po_sum WHERE cl='".$this->sd['cl']."' AND bc='".$this->sd['branch']."' AND pending='1' AND type='".$_POST['type']."' AND nno LIKE '%$_POST[search]%'";

$query = $this->db->query($sql);

$a = "<table id='po_list' style='width : 100%' >";
$a .= "<thead><tr>";
$a .= "<th class='tb_head_th'>Po Number</th>";
$a .= "<th class='tb_head_th'>Date</th>";
$a .= "</tr>";

     /*$a .= "<th class='tb_head_th'>Supplier</th>";
      $a .= "</thead></tr>";
      $a .= "<tr class='cl'>";
      $a .= "<td>&nbsp;</td>";
      $a .= "<td>&nbsp;</td>";*/
      

      foreach($query->result() as $r){
        $a .= "<tr class='cl'>";
        $a .= "<td>".$r->nno."</td>";
        $a .= "<td>".$r->date."</td>";
         // $a .= "<td>".$r->supplier."</td>";
        $a .= "</tr>";
      }

      $a .= "</table>";
      echo $a;
    }

    public function load_po_sel(){

      $cl=$this->sd['cl'];
      $bc=$this->sd['branch'];
      if($_POST['po_no']!=""){    
       $pono = " AND t_po_trans.`trans_no`='".$_POST['po_no']."' ";
     }else{
      $pono = "";
    }

    if($_POST['sup'] != ""){

     $item = $_POST['item'];
     $supplier = $_POST['sup'];
     $sql="SELECT trans_no AS nno,request_qty,received_qty,SUM(request_qty - received_qty) AS balance_qty ,p.ddate AS date
     FROM t_po_trans
     JOIN (SELECT * FROM t_po_sum WHERE inactive='0' AND TYPE='".$_POST['type']."' AND cl ='$cl' AND bc='$bc' AND supplier = '$supplier') p
     ON p.`nno` = t_po_trans.`trans_no` AND p.cl=t_po_trans.`cl` AND p.bc = t_po_trans.bc
     WHERE t_po_trans.cl='$cl' AND t_po_trans.bc='$bc' AND t_po_trans.`item_code`='$item' $pono AND inactive = '0' AND t_po_trans.type='".$_POST['type']."' AND trans_no LIKE '%$_POST[search]%' AND p.supplier = '$supplier'
     GROUP BY trans_no,item_code
     HAVING  SUM(request_qty)>SUM(received_qty)
     LIMIT 25 ";

   }else{
     $item = $_POST['item'];
     $sql="SELECT trans_no AS nno,request_qty,received_qty,SUM(request_qty - received_qty) AS balance_qty,p.ddate AS date
     FROM t_po_trans
     JOIN (SELECT * FROM t_po_sum WHERE inactive='0' AND TYPE='".$_POST['type']."' AND cl ='$cl' AND bc='$bc') p
     ON p.`nno` = t_po_trans.`trans_no` AND p.cl=t_po_trans.`cl` AND p.bc = t_po_trans.bc
     WHERE t_po_trans.cl='$cl' AND t_po_trans.bc='$bc' AND t_po_trans.`item_code`='$item' $pono AND inactive = '0' AND t_po_trans.type='".$_POST['type']."' AND trans_no LIKE '%$_POST[search]%'
     GROUP BY trans_no,item_code
     HAVING  SUM(request_qty)>SUM(received_qty)
     LIMIT 25 ";
   }

   // $sql="SELECT nno,supplier FROM t_po_sum WHERE cl='".$this->sd['cl']."' AND bc='".$this->sd['branch']."' AND pending='1' AND type='".$_POST['type']."' AND nno LIKE '%$_POST[search]%'";

   $query = $this->db->query($sql);

   $a = "<table id='po_list' style='width : 100%' >";
   $a .= "<thead><tr>";
   $a .= "<th class='tb_head_th'>Po Number</th>";
   $a .= "<th class='tb_head_th'>Request Qty</th>";
   $a .= "<th class='tb_head_th'>Balance Qty</th>";
   $a .= "<th class='tb_head_th'>Purchase Qty</th>";
   $a .= "</tr>";

   $x=0;
   foreach($query->result() as $r){
    $a .= "<tr class='cl'>";
    $a .= "<td style='text-align:center;'><input type='text' value=".$r->nno." readonly='readonly' style='width:100%;'  id='nno_$x'></td>";
    $a .= "<td style='text-align:right;'><input type='text' value=".$r->request_qty." readonly='readonly' style='width:100%;' class='req_qty'id='req_$x'></td>";
    $a .= "<td style='text-align:right;'><input type='text' value=".$r->balance_qty." readonly='readonly' style='width:100%;' class='bal_qty' id='balanqty_$x'></td>";
    $a .= "<td style='text-align:center;'><input type='text' style='width:100%;' class='pur_qty' id='purchqty_$x' value=''></td>";
         // $a .= "<td>".$r->supplier."</td>";
    $a .= "</tr>";
    $x++;
  }

  $a .= "</table>";
  echo $a;
}


public function item_list_all(){

  $id = $_POST['id'];
  if($_POST['search'] == 'Key Word: code, name'){$_POST['search'] = "";}
  $sql = "SELECT * FROM m_item  WHERE description LIKE '$_POST[search]%' OR code LIKE '$_POST[search]%' AND inactive='0' LIMIT 25";
  
  $query = $this->db->query($sql);
  $a = "<table id='item_list' style='width : 100%' >";
  $a .= "<thead><tr>";
  $a .= "<th class='tb_head_th'>Code</th>";
  $a .= "<th class='tb_head_th'>Item Name</th>";
  $a .= "<th class='tb_head_th'>Model</th>";
  $a .= "<th class='tb_head_th'>Price</th>";
  $a .= "<th class='tb_head_th'>Max Price</th>";
  $a .= "<th class='tb_head_th'>Min Price</th>";
  if($_POST['sale3']!="0"){
   $a .= "<th class='tb_head_th'>Sale Price 3</th>";
 }
 if($_POST['sale4']!="0"){
  $a .= "<th class='tb_head_th'>Sale Price 4</th>";
}
$a .= "</thead></tr>";
$a .= "<tr class='cl'>";
$a .= "<td>&nbsp;</td>";
$a .= "<td>&nbsp;</td>";
$a .= "<td>&nbsp;</td>";
$a .= "<td>&nbsp;</td>";
$a .= "<td>&nbsp;</td>";
$a .= "<td>&nbsp;</td>";
$a .= "</tr>";

foreach($query->result() as $r){
  $a .= "<tr class='cl'>";
  $a .= "<td>".$r->code."</td>";
  $a .= "<td>".$r->description."</td>";
  $a .= "<td>".$r->model."</td>";
  $a .= "<td>".$r->purchase_price."</td>";
  $a .= "<td>".$r->max_price."</td>";
  $a .= "<td>".$r->min_price."</td>";
  if($_POST['sale3']!="0"){
    $a .= "<td>".$r->sale_price_3."</td>";
  }
  if($_POST['sale4']!="0"){
    $a .= "<td>".$r->sale_price_4."</td>";
  }
  $a .= "</tr>";
}



$a .= "</table>";
echo $a;
}


public function get_pono() {

  $code = $_POST['po_no'];
  $cl=$this->sd['cl'];
  $bc=$this->sd['branch'];
  $type=$_POST['type'];

  $sql = "SELECT  t_po_trans.cl,
  t_po_trans.bc,
  trans_no,
  description,
  model,
  purchase_price AS cost,
  max_price,
  min_price,
  request_qty,
  sale_price_3,
  sale_price_4,
  IFNULL((SELECT received_qty FROM t_po_trans WHERE sub_trans_code!='23' AND  trans_no='$code' AND cl='$cl' AND bc='$bc' group by trans_no),0) AS received_qty,
  item_code,
  SUM(`request_qty`) - SUM(`received_qty`) AS balance 
  FROM t_po_trans 
  JOIN m_item ON  m_item.code=t_po_trans.`item_code`
  JOIN t_po_sum p ON p.`nno` = t_po_trans.`trans_no` AND p.cl = t_po_trans.`cl` AND p.bc = t_po_trans.bc  
  WHERE trans_no='$code' AND t_po_trans.cl='$cl' AND t_po_trans.bc='$bc' AND t_po_trans.type='$type'AND p.inactive='0'
  GROUP BY item_code
  HAVING balance>0
  ORDER BY t_po_trans.`auto_no` ASC
  LIMIT 25 ";

  $query = $this->db->query($sql);

  $sql = "SELECT s.supplier,d.name FROM t_po_sum s JOIN m_supplier d ON s.supplier=d.code
  WHERE s.cl='$cl' AND s.bc='$bc' AND s.nno='$code' AND s.type='$type'";
  $qury= $this->db->query($sql);
  $a['sum'] = $qury->result();
  if ($query->num_rows() > 0) {
    $a['det'] = $query->result();
  } else {
    $a['det'] = 2;
  }
  echo json_encode($a);
}

public function get_pono_code() {

  $code = $_POST['po_no'];
  $supp = $_POST['supplier'];

  if($supp==""){
    $sup='';
  }else{
    $sup=" AND p.supplier='$supp' ";
  }

  if($code==""){
    $cl=$this->sd['cl'];
    $bc=$this->sd['branch'];
    $type=$_POST['type'];
    $sql = "SELECT  t_po_trans.cl,
    t_po_trans.bc,
    trans_no,
    description,
    model,
    purchase_price AS cost,
    max_price,
    min_price,
    request_qty,
    sale_price_3,
    sale_price_4,
    IFNULL((SELECT received_qty FROM t_po_trans WHERE sub_trans_code!='23' AND  trans_no='$code' AND cl='$cl' AND bc='$bc' group by trans_no),0) AS received_qty,
    item_code,
    SUM(`request_qty`) - SUM(`received_qty`) AS balance 
    FROM t_po_trans 
    JOIN m_item ON  m_item.code=t_po_trans.`item_code`
    JOIN t_po_sum p ON p.`nno` = t_po_trans.`trans_no` AND p.cl = t_po_trans.`cl` AND p.bc = t_po_trans.bc  
    WHERE  t_po_trans.cl='$cl' AND t_po_trans.bc='$bc' AND t_po_trans.type='$type'AND p.inactive='0' $sup
    AND (item_code LIKE '$_POST[search]%' OR description LIKE '$_POST[search]%')
    GROUP BY item_code
    HAVING balance>0
    ORDER BY t_po_trans.`auto_no` ASC
    LIMIT 25 ";
  }else{

    $cl=$this->sd['cl'];
    $bc=$this->sd['branch'];
    $type=$_POST['type'];

    $sql = "SELECT  t_po_trans.cl,
    t_po_trans.bc,
    trans_no,
    description,
    model,
    purchase_price AS cost,
    max_price,
    min_price,
    request_qty,
    sale_price_3,
    sale_price_4,
    IFNULL((SELECT received_qty FROM t_po_trans WHERE sub_trans_code!='23' AND  trans_no='$code' AND cl='$cl' AND bc='$bc' group by trans_no),0) AS received_qty,
    item_code,
    SUM(`request_qty`) - SUM(`received_qty`) AS balance 
    FROM t_po_trans 
    JOIN m_item ON  m_item.code=t_po_trans.`item_code`
    JOIN t_po_sum p ON p.`nno` = t_po_trans.`trans_no` AND p.cl = t_po_trans.`cl` AND p.bc = t_po_trans.bc  
    WHERE trans_no='$code' AND t_po_trans.cl='$cl' AND t_po_trans.bc='$bc'                
    AND t_po_trans.type='$type'AND p.inactive='0' $sup
    AND (item_code LIKE '$_POST[search]%' OR description LIKE '$_POST[search]%')
    GROUP BY item_code
    HAVING balance>0
    ORDER BY t_po_trans.`auto_no` ASC
    LIMIT 25 ";

  }


  $query = $this->db->query($sql);
  $a = "<table id='item_list' style='width : 100%' >";
  $a .= "<thead><tr>";
  $a .= "<th class='tb_head_th'>Code</th>";
  $a .= "<th class='tb_head_th'>Item Name</th>";
  $a .= "<th class='tb_head_th'>Model</th>";
  if($this->utility->show_cost_price()=="1"){
    $a .= "<th class='tb_head_th'>Price</th>";
  }if($this->utility->show_max_price()=="1"){
    $a .= "<th class='tb_head_th'>Max Price</th>";
  }if($this->utility->show_min_price()=="1"){
    $a .= "<th class='tb_head_th'>Min Price</th>";
  }
  if($_POST['sale3']!="0" && $this->utility->show_cost_price()=="1"){
    $a .= "<th class='tb_head_th'>Sale Price 3</th>";
  } if($_POST['sale4']!="0" && $this->utility->show_cost_price()=="1"){
    $a .= "<th class='tb_head_th'>Sale Price 4</th>";
  }
  $a .= "</thead></tr>";
  $a .= "<tr class='cl'>";
  $a .= "<td>&nbsp;</td>";
  $a .= "<td>&nbsp;</td>";
  $a .= "<td>&nbsp;</td>";
  if($this->utility->show_cost_price()=="1"){
    $a .= "<td>&nbsp;</td>";
  }if($this->utility->show_max_price()=="1"){
    $a .= "<td>&nbsp;</td>";
  }if($this->utility->show_min_price()=="1"){
    $a .= "<td>&nbsp;</td>";
  }
  $a .= "</tr>";

  foreach($query->result() as $r){
    $a .= "<tr class='cl'>";
    $a .= "<td>".$r->item_code."</td>";
    $a .= "<td>".$r->description."</td>";
    $a .= "<td>".$r->model."</td>";
    if($this->utility->show_cost_price()=="1"){
      $a .= "<td>".$r->cost."</td>";
    }else{
      $a .= "<td style='display:none;'>".$r->cost."</td>";
    }
    if($this->utility->show_max_price()=="1"){
      $a .= "<td>".$r->max_price."</td>";
    }else{
      $a .= "<td style='display:none;'>".$r->max_price."</td>";
    }
    if($this->utility->show_min_price()=="1"){
      $a .= "<td>".$r->min_price."</td>";
    }else{
      $a .= "<td style='display:none;'>".$r->min_price."</td>";
    }
    if($_POST['sale3']!="0" && $this->utility->show_cost_price()=="1"){
      $a .= "<td>".$r->sale_price_3."</td>";
    }else{
      $a .= "<td style='display:none;'>".$r->sale_price_3."</td>";
    }
    if($_POST['sale4']!="0" && $this->utility->show_cost_price()=="1"){
      $a .= "<td>".$r->sale_price_4."</td>";
    }else{
      $a .= "<td style='display:none;'>".$r->sale_price_4."</td>";
    }
    $a .= "</tr>";
  }

  $a .= "</table>";
  echo $a;

}


public function balnce_free(){
  if($_POST['use_bal']=="1"){

    $sql="SELECT  f.cl,
    f.bc, 
    f.trans_code,
    f.`trans_no`,
    f.item_code, 
    m.`description`, 
    m.`model`, 
    purchase_price AS cost,
    max_price,
    min_price,
    sale_price_3,
    sale_price_4,
    SUM(receivable_qty - received_qty) AS balance
    FROM t_grn_free_trans f
    JOIN m_item m ON  m.code=f.`item_code`
    WHERE cl='".$this->sd['cl']."'
    AND bc='".$this->sd['branch']."' 
    -- AND f.is_cancel='0'
    AND (item_code LIKE '$_POST[search]%' OR description LIKE '$_POST[search]%')
    GROUP BY cl, bc, item_code
    HAVING balance > 0";

    $query=$this->db->query($sql);

    $a  = "<table id='item_list' style='width : 100%' >";
    $a .= "<thead><tr>";
    $a .= "<th class='tb_head_th'>Code</th>";
    $a .= "<th class='tb_head_th'>Item Name</th>";
    $a .= "<th class='tb_head_th'>Model</th>";
    $a .= "<th class='tb_head_th'>Price</th>";
    $a .= "<th class='tb_head_th'>Max Price</th>";
    $a .= "<th class='tb_head_th'>Min Price</th>";

    $a .= "<th class='tb_head_th'>Balance Qty</th>";
    $a .= "</thead></tr>";
    $a .= "<tr class='cl'>";
    $a .= "<td>&nbsp;</td>";
    $a .= "<td>&nbsp;</td>";
    $a .= "<td>&nbsp;</td>";
    $a .= "<td>&nbsp;</td>";
    $a .= "<td>&nbsp;</td>";
    $a .= "<td>&nbsp;</td>";
    $a .= "<td>&nbsp;</td>";
    $a .= "</tr>";

    foreach($query->result() as $r){
      $a .= "<tr class='cl'>";
      $a .= "<td>".$r->item_code."</td>";
      $a .= "<td>".$r->description."</td>";
      $a .= "<td>".$r->model."</td>";
      $a .= "<td>".$r->cost."</td>";
      $a .= "<td>".$r->max_price."</td>";
      $a .= "<td>".$r->min_price."</td>";
      $a .= "<td style='text-align:right;'>".$r->balance."</td>";
      $a .= "</tr>";
    }
    $a .= "</table>";
  }else{
    $sql = "SELECT * FROM m_item  WHERE description LIKE '$_POST[search]%' OR code LIKE '$_POST[search]%' AND inactive='0' LIMIT 25";
    $query=$this->db->query($sql);
    $a  = "<table id='item_list' style='width : 100%' >";
    $a .= "<thead><tr>";
    $a .= "<th class='tb_head_th'>Code</th>";
    $a .= "<th class='tb_head_th'>Item Name</th>";
    $a .= "<th class='tb_head_th'>Model</th>";
    $a .= "<th class='tb_head_th'>Price</th>";
    $a .= "<th class='tb_head_th'>Max Price</th>";
    $a .= "<th class='tb_head_th'>Min Price</th>";
    $a .= "</thead></tr>";
    $a .= "<tr class='cl'>";
    $a .= "<td>&nbsp;</td>";
    $a .= "<td>&nbsp;</td>";
    $a .= "<td>&nbsp;</td>";
    $a .= "<td>&nbsp;</td>";
    $a .= "<td>&nbsp;</td>";
    $a .= "<td>&nbsp;</td>";
    $a .= "</tr>";

    foreach($query->result() as $r){
      $a .= "<tr class='cl'>";
      $a .= "<td>".$r->code."</td>";
      $a .= "<td>".$r->description."</td>";
      $a .= "<td>".$r->model."</td>";
      $a .= "<td>".$r->purchase_price."</td>";
      $a .= "<td>".$r->max_price."</td>";
      $a .= "<td>".$r->min_price."</td>";
      $a .= "</tr>";
    }
    $a .= "</table>";
  }
  echo $a;
}


public function load_pendings(){

  $sql="SELECT  f.cl,
  f.bc, 
  f.trans_code,
  f.`trans_no`,
  f.item_code, 
  m.`description`, 
  m.`model`, 
  purchase_price AS cost,
  max_price,
  min_price,
  sale_price_3,
  sale_price_4,
  receivable_qty,
  received_qty,
  SUM(receivable_qty - received_qty) AS balance
  FROM t_grn_free_trans f
  JOIN m_item m ON  m.code=f.`item_code`
  WHERE cl='".$this->sd['cl']."'
  AND bc='".$this->sd['branch']."'
  AND item_code='".$_POST['item']."'
  -- AND f.is_cancel='0'
  GROUP BY cl, bc, item_code,trans_code,trans_no
  HAVING balance > 0";


  $query = $this->db->query($sql);

  $a = "<table id='po_list' style='width : 100%' >";
  $a .= "<thead><tr>";
  $a .= "<th class='tb_head_th'>Number</th>";
  $a .= "<th class='tb_head_th'>Request Qty</th>";
  $a .= "<th class='tb_head_th'>Balance Qty</th>";
  $a .= "<th class='tb_head_th'>Purchase Qty</th>";
  $a .= "</tr>";

  $x=0;
  foreach($query->result() as $r){
    $a .= "<tr class='cl'>";
    $a .= "<td style='text-align:center;'><input type='text' value=".$r->trans_no." readonly='readonly' style='width:100%;'  id='nno_$x'></td>";
    $a .= "<td style='text-align:right;'><input type='text' value=".$r->receivable_qty." readonly='readonly' style='width:100%;' class='req_qty'id='req_$x'></td>";
    $a .= "<td style='text-align:right;'><input type='text' value=".$r->balance." readonly='readonly' style='width:100%;' class='bal_qty' id='balanqty_$x'></td>";
    $a .= "<td style='text-align:center;'><input type='text' style='width:100%;' class='pur_qty' id='purchqty_$x' value=''></td>";
         // $a .= "<td>".$r->supplier."</td>";
    $a .= "</tr>";
    $x++;
  }

  $a .= "</table>";
  echo $a;
}


public function is_show_lp_sp(){
  $sql="SELECT is_show_lp,is_show_sp FROM `m_branch` WHERE cl='".$this->sd['cl']."' AND bc='".$this->sd['branch']."'";
  $query = $this->db->query($sql)->row();

  $ar['is_show_lp'] = $query->is_show_lp;
  $ar['is_show_sp'] = $query->is_show_sp;

  return $ar;
}

public function get_item_without_po(){
  $sql = "SELECT i.code AS item_code,i.description,i.model,i.purchase_price AS cost,i.max_price,i.min_price,sale_price_3,sale_price_4 
  FROM `m_item` i
  WHERE code LIKE '$_POST[search]%' OR description LIKE '$_POST[search]%' OR model LIKE '$_POST[search]%' LIMIT 25";
  $query = $this->db->query($sql);
  $a = "<table id='item_list' style='width : 100%' >";
  $a .= "<thead><tr>";
  $a .= "<th class='tb_head_th'>Code</th>";
  $a .= "<th class='tb_head_th'>Item Name</th>";
  $a .= "<th class='tb_head_th'>Model</th>";
  if($this->utility->show_cost_price()=="1"){
    $a .= "<th class='tb_head_th'>Price</th>";
  }if($this->utility->show_max_price()=="1"){
    $a .= "<th class='tb_head_th'>Max Price</th>";
  }if($this->utility->show_min_price()=="1"){
    $a .= "<th class='tb_head_th'>Min Price</th>";
  }

  $a .= "</thead></tr>";
  $a .= "<tr class='cl'>";
  $a .= "<td>&nbsp;</td>";
  $a .= "<td>&nbsp;</td>";
  $a .= "<td>&nbsp;</td>";
  if($this->utility->show_cost_price()=="1"){
    $a .= "<td>&nbsp;</td>";
  }if($this->utility->show_max_price()=="1"){
    $a .= "<td>&nbsp;</td>";
  }if($this->utility->show_min_price()=="1"){
    $a .= "<td>&nbsp;</td>";
  }
  $a .= "</tr>";

  foreach($query->result() as $r){
    $a .= "<tr class='cl'>";
    $a .= "<td>".$r->item_code."</td>";
    $a .= "<td>".$r->description."</td>";
    $a .= "<td>".$r->model."</td>";
    if($this->utility->show_cost_price()=="1"){
      $a .= "<td>".$r->cost."</td>";
    }else{
      $a .= "<td style='display:none;'>".$r->cost."</td>";
    }
    if($this->utility->show_max_price()=="1"){
      $a .= "<td>".$r->max_price."</td>";
    }else{
      $a .= "<td style='display:none;'>".$r->max_price."</td>";
    }
    if($this->utility->show_min_price()=="1"){
      $a .= "<td>".$r->min_price."</td>";
    }else{
      $a .= "<td style='display:none;'>".$r->min_price."</td>";
    }
    $a .= "</tr>";
  }

  $a .= "</table>";
  echo $a;
}


public function check_is_serial_items($code){
 $this->db->select(array('serial_no'));
 $this->db->where("code",$code);
 $this->db->limit(1);
 return $this->db->get("m_item")->first_row()->serial_no;
}



public function PDF_report(){
  $r_detail['deliver_date'];
  $r_detail['ship_to_bc'];
  $r_detail['supplier'];
  $r_detail['ddate'];
  $r_detail['total_amount'];

  $this->db->where("nno",$_POST['qno']);
  $this->db->where("cl",$this->sd['cl']);
  $this->db->where("bc",$this->sd['branch']);
  $this->db->join('m_employee', 'm_employee.code=t_grn_sum.check_by');
  $query= $this->db->get('t_grn_sum'); 

  $r_detail['sum']=$query->result();


  $invoice_number= $this->utility->invoice_format($_POST['qno']);
  $session_array = array(
   $this->sd['cl'],
   $this->sd['branch'],
   $invoice_number
   );
  $r_detail['session'] = $session_array;

  if($query->num_rows() > 0){
    foreach ($query->result() as $row){
      $r_detail['supplier']=$row->supp_id;
      $r_detail['total_amount']=$row->net_amount;
    }
  } 


  $this->db->select(array('name','address','tp','fax','email'));
  $this->db->where("cl",$this->sd['cl']);
  $this->db->where("bc",$this->sd['branch']);
  $r_detail['branch']=$this->db->get('m_branch')->result();

  $this->db->select(array('name','address','tp','fax','email'));
  $this->db->where("cl",$this->sd['cl']);
  $this->db->where("bc",$r_detail['ship_to_bc']);
  $r_detail['ship_branch']=$this->db->get('m_branch')->result();

  $this->db->select_sum("discount");
  $this->db->where('cl',$this->sd['cl'] );
  $this->db->where('bc',$this->sd['branch']);
  $this->db->where('nno',$_POST['qno']);
  $r_detail['discount']=$this->db->get('t_grn_det')->result();

  $this->db->select(array('t_grn_sum.net_amount as tot', 't_grn_sum.gross_amount as gross', 'is_free_purchase','is_debit_note'));
  $this->db->where('t_grn_sum.cl',$this->sd['cl'] );
  $this->db->where('t_grn_sum.bc',$this->sd['branch']);
  $this->db->where('t_grn_sum.nno',$_POST['qno']);
  $r_detail['tot']=$this->db->get('t_grn_sum')->result();

  $this->db->select(array('t_grn_additional_item.type', 't_grn_additional_item.amount', 'r_additional_item.description', 'r_additional_item.is_add'));
  $this->db->from('t_grn_additional_item');
  $this->db->join('r_additional_item', 't_grn_additional_item.type=r_additional_item.code');
  $this->db->where('t_grn_additional_item.cl', $this->sd['cl']);
  $this->db->where('t_grn_additional_item.bc', $this->sd['branch']);
  $this->db->where('t_grn_additional_item.nno', $_POST['qno']);
  $r_detail['additional'] = $this->db->get()->result();

  $r_detail['qno']=$_POST['qno'];
  $r_detail['page']="A5";
  $r_detail['format']="A5";
  $r_detail['header']=$_POST['header'];
  $r_detail['orientation']="L";
  $r_detail['type']=$_POST['type'];
  $r_detail['inv_date']=$_POST['inv_date'];
  $r_detail['inv_nop']=$_POST['inv_nop'];
  $r_detail['po_nop']=$_POST['po_nop'];
  $r_detail['po_dt']=$_POST['po_dt'];
  $r_detail['memo']=$_POST['note'];
  $r_detail['credit_prd']=$_POST['credit_prd'];

  $sql="SELECT 
  `m_supplier`.`code`, 
  `m_supplier`.`name`, 
  `m_supplier`.`address1`, 
  IFNULL (`m_supplier`.`address2`,'') address2,
  IFNULL (`m_supplier`.`address3`,'') address3, 
  IFNULL (`m_supplier`.`email`,'') email,
  IFNULL (`m_supplier_contact`.`tp`,'') tp FROM (`m_supplier`) 
  LEFT JOIN `m_supplier_contact` ON `m_supplier_contact`.`code`=`m_supplier`.`code` WHERE `m_supplier`.`code`='".$r_detail['supplier']."' LIMIT 1";

  $r_detail['suppliers']=$this->db->query($sql)->result();


  $this->db->SELECT(array('serial_no','item'));
  $this->db->FROM('t_serial');
  $this->db->WHERE('t_serial.cl', $this->sd['cl']);
  $this->db->WHERE('t_serial.bc', $this->sd['branch']);
  $this->db->WHERE('t_serial.trans_type','3');
  $this->db->WHERE('t_serial.trans_no',$_POST['qno']);
  $r_detail['serial'] = $this->db->get()->result();


   //     $sql="SELECT `m_item`.`code`,
      //  `m_item`.`description`, 
      //  `m_item`.`model`, 
      //  `t_grn_det`.`qty`, 
      //  `m_item`.`purchase_price` AS unit_price, 
      //  `m_item`.`min_price` AS last_price,  
      //  `m_item`.`max_price` AS sales_price, 
      //  `t_grn_det`.`discount`,  
      //  ROUND(((`m_item`.`max_price` - `m_item`.`purchase_price`) / `m_item`.`purchase_price`)*100,2) AS profit,
      //  `m_item`.`purchase_price` * `t_grn_det`.`qty` as amount


      // FROM `t_grn_det` 
      // JOIN m_item ON m_item.`code`=t_grn_det.`code` 
   //         WHERE `t_grn_det`.`nno`=".$_POST['qno']." AND `t_grn_det`.`cl`='".$this->sd['cl']."' AND `t_grn_det`.`bc`='".$this->sd['branch']."'
   //         ORDER BY `t_grn_det`.`auto_num` asc";


  $sql="SELECT `m_item`.`code`,
  `m_item`.`description`, 
  `m_item`.`model`, 
  `t_grn_det`.`qty`,
  `t_grn_det`.`foc`, 
  GROUP_CONCAT(CONCAT(tr.trans_no,' - ',tr.received_qty)) AS po_qty, 
  c.`cc` AS sub_item,
  c.`deee` AS des,
  c.qty *  t_grn_det.qty AS sub_qty,
  `t_grn_det`.`price` AS unit_price, 
  `t_grn_det`.`min_price` AS last_price,  
  `t_grn_det`.`max_price` AS sales_price, 
  `t_grn_det`.`discount`,  
  ROUND(((`m_item`.`min_price` - `m_item`.`purchase_price`) / `m_item`.`min_price`)*100,2) AS profit,
  ROUND(((`m_item`.`max_price` - `m_item`.`purchase_price`) / `m_item`.`max_price`)*100,2) AS s_profit,
  `t_grn_det`.`price` * `t_grn_det`.`qty` as amount
  FROM `t_grn_det` 
  LEFT JOIN t_po_trans tr ON tr.cl=t_grn_det.`cl` AND tr.bc=t_grn_det.`bc` AND tr.sub_trans_code='3' AND tr.sub_trans_no=t_grn_det.`nno` AND tr.item_code=t_grn_det.`code`
  JOIN m_item ON m_item.`code`=t_grn_det.`code` 
  LEFT JOIN (SELECT t_grn_det.`code`, 
    r_sub_item.`description` AS deee, 
    r_sub_item.`code` AS cc,
    r_sub_item.`qty` AS qty,
    t_item_movement_sub.cl,
    t_item_movement_sub.bc,
    t_item_movement_sub.item
    ,                        t_item_movement_sub.`sub_item` 
    FROM t_item_movement_sub 
    LEFT JOIN t_grn_det ON t_grn_det.`code` = t_item_movement_sub.`item`  
    AND t_grn_det.`cl` = t_item_movement_sub.`cl` AND t_grn_det.`bc`=t_item_movement_sub.`bc`
    JOIN r_sub_item ON t_item_movement_sub.`sub_item` = r_sub_item.`code`
    WHERE t_item_movement_sub.batch_no = t_grn_det.`batch_no` AND `t_grn_det`.`cl` = '".$this->sd['cl']."'  
    AND `t_grn_det`.`bc` = '".$this->sd['branch']."' AND `trans_no` = '".$_POST['qno']."' AND trans_code='3'  )c ON c.code = t_grn_det.`code`

WHERE `t_grn_det`.`nno`='".$_POST['qno']."' AND `t_grn_det`.`cl`='".$this->sd['cl']."' AND `t_grn_det`.`bc`='".$this->sd['branch']."'
GROUP BY c.cc ,t_grn_det.`code`
ORDER BY `t_grn_det`.`auto_num` ASC 


";

$query=$this->db->query($sql);
if($query->num_rows>0){
  $r_detail['det']=$query->result();
}else{
  $r_detail['det']=2;
}

$this->db->select(array('loginName'));
$this->db->where('cCode',$this->sd['oc']);
$r_detail['user']=$this->db->get('s_users')->result();

$r_detail['is_cur_time'] = $this->utility->get_cur_time();

$s_time=$this->utility->save_time();
if($s_time==1){
  $r_detail['save_time']="  -  ".$this->utility->get_save_time('t_grn_sum','action_date',$_POST['qno'],'nno');

}else{
  $r_detail['save_time']="";
}

$r_detail['show_cost']=$this->utility->show_cost_price();
$r_detail['show_min']=$this->utility->show_min_price();
$r_detail['show_max']=$this->utility->show_max_price();

$this->load->view($_POST['by'].'_'.'pdf',$r_detail);

}



function supplier_credit_period(){
  $code=$_POST['code'];
  $sql="SELECT credit_period FROM m_supplier WHERE code='$code'";
  echo $this->db->query($sql)->first_row()->credit_period;
}



function load_purchase_stores(){
  $sql="SELECT 
  mb.def_purchase_store_code,
  ms.`description` 
  FROM
  m_branch mb 
  JOIN m_stores ms ON ms.`code` = mb.`def_purchase_store_code` 
  WHERE mb.cl ='".$this->sd['cl']."' AND mb.bc = '".$this->sd['bc']."' AND ms.`purchase` = '1' ";

  $query = $this->db->query($sql);

  if ($query->num_rows() > 0) {
   $a= $query->result();
 } else {
  $a = 2;
}
echo json_encode($a);
}

public function has_free_items(){
  $sql="SELECT `code` 
  FROM m_item_free_po m
  JOIN m_item_free_po_det d ON d.`cl`=m.`cl` AND d.`bc`=m.`bc` AND d.`nno`=m.`nno`
  WHERE m.`dfrom` <= '".$_POST['date']."' AND m.`dto` >= '".$_POST['date']."'
  AND d.po_item='".$_POST['code']."'
  AND m.cl='".$this->sd['cl']."' AND m.bc='".$this->sd['branch']."'
  AND is_cancel='0' AND is_inactive='0'";

  $query=$this->db->query($sql);
  if($query->num_rows()>0){
    $a=1;
  }else{
    $a=2;
  }
  echo $a;
}

public function views_free_items(){
  $this->load->model('utility');
  $sql="SELECT foc_item,
  foc_qty,
  po_qty,
  i.description,
  i.`model`,
  i.`purchase_price`
  FROM  m_item_free_po m 
  JOIN m_item_free_po_det d ON d.`cl` = m.`cl` AND d.`bc` = m.`bc` AND d.`nno` = m.`nno` 
  JOIN m_item i ON i.`code` = d.`foc_item`  
  WHERE m.`dfrom` <= '".$_POST['date']."' AND m.`dto` >= '".$_POST['date']."'
  AND d.po_item='".$_POST['code']."'
  AND m.cl='".$this->sd['cl']."' AND m.bc='".$this->sd['branch']."'
  AND po_qty <= '".$_POST['qty']."' 
  AND is_cancel='0' AND is_inactive='0'";

  $query=$this->db->query($sql);

  $a['tbl'] = "<table id='item_list' style='width : 100%' >";
  $a['tbl'] .= "<thead><tr class='cl'><td colspan='5' style='font-weight:bold;background:#aaa;color:#fff;font-size:14px; word-spacing: 2px'>Free Receive Items List ".$_POST['code']."</td></tr><tr>";
  $a['tbl'] .= "<thead><tr>";
  $a['tbl'] .= "<th class='tb_head_th'>Code</th>";
  $a['tbl'] .= "<th class='tb_head_th'>Description</th>";
  $a['tbl'] .= "<th class='tb_head_th'>model</th>";
  $a['tbl'] .= "<th class='tb_head_th'>Price</th>";
  $a['tbl'] .= "<th class='tb_head_th'>Qty</th>";

  $a['tbl'] .= "</thead></tr>";
  $a['tbl'] .= "<tr class='cl'>";
  $a['tbl'] .= "<td>&nbsp;</td>";
  $a['tbl'] .= "<td>&nbsp;</td>";
  $a['tbl'] .= "<td>&nbsp;</td>";
  $a['tbl'] .= "<td>&nbsp;</td>";
  $a['tbl'] .= "<td>&nbsp;</td>";

  $a['tbl'] .= "</tr>";
  $x=0;
  foreach ($query->result() as $r) {
    $chk_float = ((int)$_POST['qty'] / (int)$r->po_qty);

    if(is_float($chk_float)){
      $divide_no = floor($chk_float);
    }else{
      $divide_no = $chk_float;
    }

    $foc_qty = (int)$divide_no * (int)$r->foc_qty;

    $a['tbl'] .= "<tr class='cl frees'>";
    $a['tbl'] .= "<td id='main_".$x."' style='display:none;'>".$_POST['code']."</td>";
    $a['tbl'] .= "<td id='fitem_".$x."'>".$r->foc_item."</td>";
    $a['tbl'] .= "<td id='fdes_".$x."'>".$r->description."</td>";
    $a['tbl'] .= "<td id='fmodel_".$x."'>".$r->model."</td>";
    $a['tbl'] .= "<td id='fprice_".$x."'>".$r->purchase_price."</td>";
    $a['tbl'] .= "<td id='fqty_".$x."'>".$r->foc_qty."</td>";
    $a['tbl'] .= "<td style='display:none;' id='lp_".$x."'>".$this->utility->get_min_price($r->foc_item)."</td>";
    $a['tbl'] .= "<td style='display:none;' id='mxp_".$x."'>".$this->utility->get_max_price($r->foc_item)."</td>";
    $a['tbl'] .= "<td style='display:none;' id='ifoc_".$x."'>".$foc_qty."</td>";
    $a['tbl'] .= "<td style='display:none;' id='poq_".$x."'>".$r->po_qty."</td>";
    $a['tbl'] .= "</tr>";
    $x++;
  }
  $a['count'] =$x;
  $a['tbl'] .= "</table>";
  echo json_encode($a);
}











}