<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class t_sales_order extends CI_Model {
    
  private $sd;
  private $mtb;
  private $max_no;
  private $mod = '003';
    
  function __construct(){
    parent::__construct();
  
    $this->sd = $this->session->all_userdata();
    $this->load->database($this->sd['db'], true);
    $this->load->model('user_permissions');
    $this->load->model('trans_settlement');
    $this->mtb = $this->tables->tb['t_so_sum'];
    $this->sales_order_store = $this->utility->sales_order_store(); 
    $this->max_no=$this->utility->get_max_no("t_so_sum","no");
  }
    
  public function base_details(){
  
    $this->load->model('m_customer');
    $a['customer']=$this->m_customer->select();
    $a['max_no']= $this->utility->get_max_no("t_so_sum","no");
    $this->load->model('m_stores');
    $a['stores'] = $this->m_stores->select();

    return $a;
  }
  
  public function validation(){
    

    $status=1;


    $check_customer_validation=$this->validation->check_is_customer($_POST['customer']);
    if($check_customer_validation!=1){
      return "Please select valid customer";
    }
    $employee_validation = $this->validation->check_is_employer($_POST['sales_rep']);
    if ($employee_validation != 1) {
        return "Please enter valid sales rep";
    }
    $store_validation = $this->validation->check_item_with_store($_POST['stores'], '0_');
    if ($store_validation != 1) {
        return $store_validation;
    }
    $minimum_price_validation = $this->validation->check_min_price('0_', '3_');
    if ($minimum_price_validation != 1){
    return $minimum_price_validation;
    }
    $serial_validation_status = $this->validation->serial_update('0_', '5_',"all_serial_");
    if ($serial_validation_status != 1) {
        return $serial_validation_status;
    }
    $check_zero_value=$this->validation->empty_net_value($_POST['net_amount']);
    if($check_zero_value!=1){
      return $check_zero_value;
    }
    $check_settled_limit = $this->check_advance_settled_limit();
    if ($check_settled_limit != 1) {
        return $check_settled_limit;
    }
    /*
    $account_update=$this->account_update(0);
    if($account_update!=1){
        return "Invalid account entries";
    }  
    */
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

      
      $sum=array(
        "cl"                =>$this->sd['cl'],
        "bc"                =>$this->sd['branch'],
        "no"                =>$this->max_no,
        "date"              =>$_POST['date'],
        "ref_no"            =>$_POST['ref_no'],
        "cus_id"            =>$_POST['customer'],
        "memo"              =>$_POST['memo'],
        "store"             =>$_POST['stores'],
        "rep_id"            =>$_POST['sales_rep'],
        "gross_amount"      =>$_POST['total2'],
        "additional_amount" =>$_POST['addi_tot'],
        "net_amount"        =>$_POST['net_amount'],
        "is_invoiced"       =>"0",
        "inv_no"            =>$_POST['inv_no'],
        "post"              =>"",
        "post_by"           =>"",
        "post_date"         =>$_POST['date'],
        "discount_amount"   =>$_POST['total_discount'],
        "oc"                =>$this->sd['oc'],
      );


      for($x = 0; $x<25; $x++){
        if(isset($_POST['0_'.$x],$_POST['5_'.$x],$_POST['3_'.$x])){
          if($_POST['0_'.$x] != "" && $_POST['5_'.$x] != "" && $_POST['3_'.$x] != "" ){
            if(isset($_POST['rcv_'.$x])){
              $is_rcv="1";
            }else{
              $is_rcv="0";
            }
            $det[]= array(
              "cl"          =>$this->sd['cl'],
              "bc"          =>$this->sd['branch'],
              "no"          =>$this->max_no,
              "code"        =>$_POST['0_'.$x],
              "batch_no"    =>$_POST['1_'.$x],
              "qty"         =>$_POST['5_'.$x],
              "discount_p"  =>$_POST['6_'.$x],
              "discount"    =>$_POST['7_'.$x],
              "amount"      =>$_POST['8_'.$x],
              "cost"        =>$_POST['3_'.$x],
              "is_reserve"  =>$is_rcv,
              "advance_detail"=>$_POST["alldata_".$x],
              "advance_amount"=>$_POST["adamnt_".$x]
            ); 
          }
        }
      }

      for ($x = 0; $x < 25; $x++) {
        if (isset($_POST['00_' . $x], $_POST['11_' . $x], $_POST['tt_' . $x])) {
          if ($_POST['00_' . $x] != "" && $_POST['11_' . $x] != "" && $_POST['tt_' . $x] != "") {
              $t_sales_order_additional_item[] = array(
                "cl"        => $this->sd['cl'],
                "bc"        => $this->sd['branch'],
                "no"       => $this->max_no,
                "type"      => $_POST['00_' . $x],
                "rate_p"    => $_POST['11_' . $x],
                "amount"    => $_POST['tt_' . $x]
            );
          }
        }
      }

      for ($x = 0; $x < 25; $x++) {
        if (isset($_POST['0_' . $x], $_POST['5_' . $x], $_POST['rcv_' . $x])) {
          if ($_POST['0_' . $x] != "" && $_POST['5_' . $x] != "") {
            
              $t_item_movement_out[] = array(
                  "cl"        => $this->sd['cl'],
                  "bc"        => $this->sd['branch'],
                  "item"      => $_POST['0_' . $x],
                  "trans_code"=> 68,
                  "trans_no"  => $this->max_no,
                  "ddate"     => $_POST['date'],
                  "qty_in"    => 0,
                  "qty_out"   => $_POST['5_' . $x],
                  "store_code"=> $_POST['stores'],
                  "avg_price" => $this->utility->get_cost_price($_POST['0_' . $x]),
                  "batch_no"  => $_POST['1_' . $x],
                  "sales_price"=> $_POST['3_' . $x],
                  "last_sales_price"=> $this->utility->get_min_price($_POST['0_' . $x]),
                  "cost"      => $this->utility->get_cost_price($_POST['0_' . $x]),
                  "group_sale_id"=> 1,
              );

              $t_item_movement_in[] = array(
                  "cl"        => $this->sd['cl'],
                  "bc"        => $this->sd['branch'],
                  "item"      => $_POST['0_' . $x],
                  "trans_code"=> 68,
                  "trans_no"  => $this->max_no,
                  "ddate"     => $_POST['date'],
                  "qty_in"    => $_POST['5_' . $x],
                  "qty_out"   => 0,
                  "store_code"=> $this->sales_order_store,
                  "avg_price" => $this->utility->get_cost_price($_POST['0_' . $x]),
                  "batch_no"  => $_POST['1_' . $x],
                  "sales_price"=> $_POST['3_' . $x],
                  "last_sales_price"=> $this->utility->get_min_price($_POST['0_' . $x]),
                  "cost"      => $this->utility->get_cost_price($_POST['0_' . $x]),
                  "group_sale_id"=> 1,
              );
          }
        }
      }

      

      if($_POST['hid'] == "0" || $_POST['hid'] == ""){
        if($this->user_permissions->is_add('t_sales_order')){
          $this->db->insert($this->mtb, $sum);
          $this->db->insert("t_so_sum_history", $sum);
          if(count($det)){
            $this->db->insert_batch("t_so_det",$det);
          }
          if(count($det)){
            $this->db->insert_batch("t_so_det_history",$det);
          }
          $this->save_sub_items();
          if (isset($t_sales_order_additional_item)) {
            if (count($t_sales_order_additional_item)) {
              $this->db->insert_batch("t_so_additional_items", $t_sales_order_additional_item);
            }
          }
          if(isset($t_item_movement_out)){
            if (count($t_item_movement_out)) {
               $this->db->insert_batch("t_item_movement", $t_item_movement_out);
            }
          }
          if(isset($t_item_movement_in)){
            if (count($t_item_movement_in)) {
               $this->db->insert_batch("t_item_movement", $t_item_movement_in);
            }
          }
          for($x = 0; $x<25; $x++){
            if(isset($_POST['0_'.$x],$_POST['5_'.$x],$_POST['3_'.$x])){
              if($_POST['0_'.$x] != "" && $_POST['5_'.$x] != "" && $_POST['3_'.$x] != "" ){
                $all_data=$_POST["alldata_".$x];
                $count_data = explode(",",$all_data);
                $arr_length= (int)sizeof($count_data)-1;
                for($i=0; $i<$arr_length ; $i++){ 
                  $s_data = (explode(",",$count_data[$i])); 
                  $rr = explode("|",$s_data[0]);
                  $ad_no = $rr[1];
                  $total = $rr[4];
                  $cr_no = $rr[5];

                  $this->trans_settlement->save_settlement2("t_credit_note_trans", $_POST['customer'], $_POST['date'], 17, $cr_no, 68, $this->max_no, "0", $total,$_POST['0_'.$x]);
                }
              }
            }
          }
          $this->delete_temp_table($this->max_no);
          //$this->account_update(1);
          $this->utility->save_logger("SAVE",68,$this->max_no,$this->mod);
          echo $this->db->trans_commit();
        }else{
          $this->db->trans_commit();
          echo "No permission to save records";
        }
      }else{
        if($this->user_permissions->is_edit('t_sales_order')){
          $this->db->where('no',$_POST['hid']);
          $this->db->where('cl',$this->sd['cl']);
          $this->db->where('bc',$this->sd['branch']);
          $this->db->update($this->mtb, $sum);

          $this->set_delete();

          $this->db->insert("t_so_sum_history", $sum);

          if(count($det)){
            $this->db->insert_batch("t_so_det_history",$det);
          }

          if(count($det)){
            $this->db->insert_batch("t_so_det",$det);
          }

          $this->save_sub_items();

          if (isset($t_sales_order_additional_item)) {
            if (count($t_sales_order_additional_item)) {
              $this->db->insert_batch("t_so_additional_items", $t_sales_order_additional_item);
            }
          }
          if(isset($t_item_movement_out)){
            if (count($t_item_movement_out)) {
               $this->db->insert_batch("t_item_movement", $t_item_movement_out);
            }
          }
          if(isset($t_item_movement_in)){
            if (count($t_item_movement_in)) {
               $this->db->insert_batch("t_item_movement", $t_item_movement_in);
            }
          }

          $this->trans_settlement->delete_settlement_sub("t_credit_note_trans","68",$this->max_no); 
          for($x = 0; $x<25; $x++){
            if(isset($_POST['0_'.$x],$_POST['5_'.$x],$_POST['3_'.$x])){
              if($_POST['0_'.$x] != "" && $_POST['5_'.$x] != "" && $_POST['3_'.$x] != "" ){
                $all_data=$_POST["alldata_".$x];
                $count_data = explode(",",$all_data);
                $arr_length= (int)sizeof($count_data)-1;
                for($i=0; $i<$arr_length ; $i++){ 
                  $s_data = (explode(",",$count_data[$i])); 
                  $rr = explode("|",$s_data[0]);
                  $ad_no = $rr[1];
                  $total = $rr[4];
                  $cr_no = $rr[5];

                  $this->trans_settlement->save_settlement2("t_credit_note_trans", $_POST['customer'], $_POST['date'], 17, $cr_no, 68, $this->max_no, "0", $total,$_POST['0_'.$x]);
                }
              }
            }
          }



          if($_POST['df_is_serial']=='1'){
            $this->serial_save_out();  
            $this->serial_save_in();    
          }

          $this->delete_temp_table($this->max_no);
          //$this->account_update(1);
          $this->utility->save_logger("EDIT",68,$this->max_no,$this->mod);
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
    }catch(Exception $e){ 
        $this->db->trans_rollback();
        echo $e->getMessage()." - Operation fail please contact admin"; 
    }  
  }

  public function serial_save_out() {
      if ($_POST['hid'] == "0" || $_POST['hid'] == "") {
        for ($x = 0; $x < 25; $x++) {
          if (isset($_POST['0_' . $x], $_POST['rcv_' . $x])) {
            if ($_POST['0_' . $x] != "" || !empty($_POST['0_' . $x])) {
            if ($this->check_is_serial_items($_POST['0_'.$x]) == 1) {
              $serial = $_POST['all_serial_'.$x];
              $p=explode(",",$serial);
              for($i=0; $i<count($p); $i++){
                  if ($_POST['hid'] == "0" || $_POST['hid'] == "") {
                      $t_seriall = array(
                          "engine_no"   => "",
                          "chassis_no"  => '',
                          "out_doc"     => 68,
                          "out_no"      => $this->max_no,
                          "out_date"    => $_POST['date'],
                          "available"   => '0'
                      );

                      $this->db->where("cl", $this->sd['cl']);
                      $this->db->where("bc", $this->sd['branch']);
                      $this->db->where('serial_no', $p[$i]);
                      $this->db->where("item", $_POST['0_' . $x]);
                      $this->db->update("t_serial", $t_seriall);

                      $this->db->query("INSERT INTO t_serial_movement_out SELECT * FROM t_serial_movement WHERE item='".$_POST['0_' . $x]."' AND serial_no='".$p[$i]."' ");

                      $t_serial_movement_out[] = array(
                          "cl" => $this->sd['cl'],
                          "bc" => $this->sd['branch'],
                          "trans_type" => 68,
                          "trans_no" => $this->max_no,
                          "item" => $_POST['0_' . $x],
                          "batch_no" => $this->get_batch_serial_wise($_POST['0_' . $x], $p[$i]),
                          "serial_no" => $p[$i],
                          "qty_in" => 0,
                          "qty_out" => 1,
                          "cost" => $_POST['3_' . $x],
                          "store_code" => $_POST['stores'],
                          "computer" => $this->input->ip_address(),
                          "oc" => $this->sd['oc'],
                      );

                      $this->db->where("cl", $this->sd['cl']);
                      $this->db->where("bc", $this->sd['branch']);
                      $this->db->where("item", $_POST['0_' . $x]);
                      $this->db->where("serial_no", $p[$i]);
                      $this->db->delete("t_serial_movement");
                  }

                }
                }
              }
            }
          }

        }else{
           /*
           $t_serial = array(
           "engine_no" => "",
           "chassis_no" => '',
           "out_doc" => "",
           "out_no" => "",
           "out_date" => date("Y-m-d", time()),
           "available" => '1'
           );

           $this->db->where("cl", $this->sd['cl']);
           $this->db->where("bc", $this->sd['branch']);
           $this->db->where("out_no", $this->max_no);
           $this->db->where("out_doc", 68);
           $this->db->update("t_serial", $t_serial);
          */

           $t_serial = array(
             "store_code"  => $_POST['stores'],
             "engine_no" => "",
             "chassis_no" => '',
             "out_doc" => "",
             "out_no" => "",
             "out_date" => "",
             "available" => '1'
           );

           $this->db->select(array('item', 'serial_no'));
           $this->db->where("trans_no", $this->max_no);
           $this->db->where("trans_type", 68);
           $this->db->where("cl", $this->sd['cl']);
           $this->db->where("bc", $this->sd['branch']);
           $query1 = $this->db->get("t_serial_movement");

          foreach ($query1->result() as $row) {
            $this->db->where("cl", $this->sd['cl']);
            $this->db->where("bc", $this->sd['branch']);
            $this->db->where("item", $row->item);
            $this->db->where("serial_no", $row->serial_no);
            $this->db->update("t_serial", $t_serial);
          }

           $this->db->select(array('item', 'serial_no'));
           $this->db->where("trans_no", $this->max_no);
           $this->db->where("trans_type", 68);
           $this->db->where("cl", $this->sd['cl']);
           $this->db->where("bc", $this->sd['branch']);
           $query = $this->db->get("t_serial_movement_out");

           foreach ($query->result() as $row) {
           $this->db->query("INSERT INTO t_serial_movement SELECT * FROM t_serial_movement_out WHERE item='$row->item' AND serial_no='$row->serial_no'");
           $this->db->where("item", $row->item);
           $this->db->where("serial_no", $row->serial_no);
           $this->db->where("cl", $this->sd['cl']);
           $this->db->where("bc", $this->sd['branch']);
           $this->db->delete("t_serial_movement_out");
           }

           $this->db->where("cl", $this->sd['cl']);
           $this->db->where("bc", $this->sd['branch']);
           $this->db->where("trans_no", $this->max_no);
           $this->db->where("trans_type", 68);
           $this->db->delete("t_serial_movement");

           $this->db->where("cl", $this->sd['cl']);
           $this->db->where("bc",$this->sd['branch']);
           $this->db->where("trans_no", $this->max_no);
           $this->db->where("trans_type", 68);
           $this->db->delete("t_serial_movement_out");


           for ($x = 0; $x < 25; $x++) {
            if (isset($_POST['0_' . $x], $_POST['rcv_' . $x])) {
                if ($_POST['0_' . $x] != "" || !empty($_POST['0_' . $x])) {
               if ($this->check_is_serial_items($_POST['0_' . $x]) == 1) {
                    $serial = $_POST['all_serial_'.$x];
                    $p=explode(",",$serial);
                    for($i=0; $i<count($p); $i++){

                           $t_seriall = array(
                               "engine_no" => "",
                               "chassis_no" => '',
                               "out_doc" => 68,
                               "out_no" => $this->max_no,
                               "out_date" => $_POST['date'],
                               "available" => '0'
                           );

                           $this->db->where("cl", $this->sd['cl']);
                           $this->db->where("bc", $this->sd['branch']);
                           $this->db->where('serial_no', $p[$i]);
                           $this->db->where("item", $_POST['0_'.$x]);
                           $this->db->update("t_serial", $t_seriall);

                           $this->db->query("INSERT INTO t_serial_movement_out SELECT * FROM t_serial_movement WHERE item='".$_POST['0_'.$x]."' AND serial_no='".$p[$i]."'");

                           $t_serial_movement_out[] = array(
                               "cl" => $this->sd['cl'],
                               "bc" => $this->sd['branch'],
                               "trans_type" => 68,
                               "trans_no" => $this->max_no,
                               "item" => $_POST['0_'.$x],
                               "batch_no" => $this->get_batch_serial_wise($_POST['0_'.$x], $p[$i]),
                               "serial_no" => $p[$i],
                               "qty_in" => 0,
                               "qty_out" => 1,
                               "cost" => $_POST['3_' . $x],
                               "store_code" => $_POST['stores'],
                               "computer" => $this->input->ip_address(),
                               "oc" => $this->sd['oc'],
                           );

                           $this->db->where("cl", $this->sd['cl']);
                           $this->db->where("bc", $this->sd['branch']);
                           $this->db->where("item", $_POST['0_' . $x]);
                           $this->db->where("serial_no", $p[$i]);
                           $this->db->delete("t_serial_movement");
                        }
                       // $execute = 1;
                    }
                } 
            }
        }
    }

      if($_POST['hid'] == "0" || $_POST['hid'] == "") {
          if(isset($t_serial_movement_out)) {
              if(count($t_serial_movement_out)) {
                  $this->db->insert_batch("t_serial_movement_out", $t_serial_movement_out);
              }
          }
      }else{
          if(isset($t_serial_movement_out)) {
              if(count($t_serial_movement_out)) {
                  $this->db->insert_batch("t_serial_movement_out", $t_serial_movement_out);
              }
          }
      }
  }


    public function serial_save_in() {
      if ($_POST['hid'] == "0" || $_POST['hid'] == "") {
        for ($x = 0; $x < 25; $x++) {
          if (isset($_POST['0_' . $x], $_POST['rcv_' . $x])) {
            if ($_POST['0_' . $x] != "" || !empty($_POST['0_' . $x])) {
            if ($this->check_is_serial_items($_POST['0_'.$x]) == 1) {
              $serial = $_POST['all_serial_'.$x];
              $p=explode(",",$serial);
              for($i=0; $i<count($p); $i++){
                  if ($_POST['hid'] == "0" || $_POST['hid'] == "") {
                      $t_seriall = array(
                          "store_code"  => $this->sales_order_store ,
                          "engine_no"   => "",
                          "chassis_no"  => '',
                          "out_doc"     => "",
                          "out_no"      => "",
                          "out_date"    => "",
                          "available"   => '1'
                      );

                      $this->db->where("cl", $this->sd['cl']);
                      $this->db->where("bc", $this->sd['branch']);
                      $this->db->where('serial_no', $p[$i]);
                      $this->db->where("item", $_POST['0_' . $x]);
                      $this->db->update("t_serial", $t_seriall);

                      $this->db->query("INSERT INTO t_serial_movement SELECT * FROM t_serial_movement_out WHERE item='".$_POST['0_' . $x]."' AND serial_no='".$p[$i]."' ");

                      $t_serial_movement[] = array(
                          "cl" => $this->sd['cl'],
                          "bc" => $this->sd['branch'],
                          "trans_type" => 68,
                          "trans_no" => $this->max_no,
                          "item" => $_POST['0_' . $x],
                          "batch_no" => $this->get_batch_serial_wise($_POST['0_' . $x], $p[$i]),
                          "serial_no" => $p[$i],
                          "qty_in" => 1,
                          "qty_out" => 0,
                          "cost" => $_POST['3_' . $x],
                          "store_code" => $this->sales_order_store,
                          "computer" => $this->input->ip_address(),
                          "oc" => $this->sd['oc'],
                      );

                      $this->db->where("cl", $this->sd['cl']);
                      $this->db->where("bc", $this->sd['branch']);
                      $this->db->where("item", $_POST['0_' . $x]);
                      $this->db->where("serial_no", $p[$i]);
                      $this->db->delete("t_serial_movement_out");
                  }

                }
                }
              }
            }
          }

        }else{
           $t_serial = array(
             "store_code"  => $_POST['stores'],
             "engine_no" => "",
             "chassis_no" => '',
             "out_doc" => "",
             "out_no" => "",
             "out_date" => "",
             "available" => '1'
           );

           $this->db->select(array('item', 'serial_no'));
           $this->db->where("trans_no", $this->max_no);
           $this->db->where("trans_type", 68);
           $this->db->where("cl", $this->sd['cl']);
           $this->db->where("bc", $this->sd['branch']);
           $query = $this->db->get("t_serial_movement");


          /*   $this->db->where("cl", $this->sd['cl']);
             $this->db->where("bc", $this->sd['branch']);
             $this->db->where("item", $row->item);
             $this->db->where("serial_no", $row->serial_no);
             $this->db->update("t_serial", $t_serial);

             var_dump($query->result());
*/



           foreach ($query->result() as $row) {
             $this->db->query("INSERT INTO t_serial_movement_out SELECT * FROM t_serial_movement WHERE item='$row->item' AND serial_no='$row->serial_no'");
             $this->db->where("item", $row->item);
             $this->db->where("serial_no", $row->serial_no);
             $this->db->where("cl", $this->sd['cl']);
             $this->db->where("bc", $this->sd['branch']);
             $this->db->delete("t_serial_movement");

           }

           /*$this->db->where("cl", $this->sd['cl']);
           $this->db->where("bc", $this->sd['branch']);
           $this->db->where("trans_no", $this->max_no);
           $this->db->where("trans_type", 68);
           $this->db->delete("t_serial_movement_out");*/

           $this->db->where("cl", $this->sd['cl']);
           $this->db->where("bc",$this->sd['branch']);
           $this->db->where("trans_no", $this->max_no);
           $this->db->where("trans_type", 68);
           $this->db->delete("t_serial_movement");


           for ($x = 0; $x < 25; $x++) {
            if (isset($_POST['0_' . $x], $_POST['rcv_' . $x])) {
                if ($_POST['0_' . $x] != "" || !empty($_POST['0_' . $x])) {
               if ($this->check_is_serial_items($_POST['0_' . $x]) == 1) {
                    $serial = $_POST['all_serial_'.$x];
                    $p=explode(",",$serial);
                    for($i=0; $i<count($p); $i++){

                           $t_seriall = array(
                                "store_code"  => $this->sales_order_store,
                                "engine_no"   => "",
                                "chassis_no"  => '',
                                "out_doc"     => "",
                                "out_no"      => "",
                                "out_date"    => "",
                                "available"   => '1'
                           );

                             $this->db->where("cl", $this->sd['cl']);
                             $this->db->where("bc", $this->sd['branch']);
                             $this->db->where('serial_no', $p[$i]);
                             $this->db->where("item", $_POST['0_'.$x]);
                             $this->db->update("t_serial", $t_seriall);

                           $this->db->query("INSERT INTO t_serial_movement SELECT * FROM t_serial_movement_out WHERE item='".$_POST['0_'.$x]."' AND serial_no='".$p[$i]."'");

                           $t_serial_movement[] = array(
                               "cl" => $this->sd['cl'],
                               "bc" => $this->sd['branch'],
                               "trans_type" => 68,
                               "trans_no" => $this->max_no,
                               "item" => $_POST['0_'.$x],
                               "batch_no" => $this->get_batch_serial_wise($_POST['0_'.$x], $p[$i]),
                               "serial_no" => $p[$i],
                               "qty_in" => 1,
                               "qty_out" => 0,
                               "cost" => $_POST['3_' . $x],
                               "store_code" => $this->sales_order_store,
                               "computer" => $this->input->ip_address(),
                               "oc" => $this->sd['oc'],
                           );

                           $this->db->where("cl", $this->sd['cl']);
                           $this->db->where("bc", $this->sd['branch']);
                           $this->db->where("item", $_POST['0_' . $x]);
                           $this->db->where("serial_no", $p[$i]);
                           $this->db->delete("t_serial_movement_out");
                        }
                    }
                } 
            }
        }
    }

      if($_POST['hid'] == "0" || $_POST['hid'] == "") {
          if(isset($t_serial_movement)) {
              if(count($t_serial_movement)) {
                  $this->db->insert_batch("t_serial_movement", $t_serial_movement);
              }
          }
      }else{
          if(isset($t_serial_movement)) {
              if(count($t_serial_movement)) {
                  $this->db->insert_batch("t_serial_movement", $t_serial_movement);
              }
          }
      }
  }

  public function check_is_serial_items($code) {
    $this->db->select(array('serial_no'));
    $this->db->where("code", $code);
    $this->db->limit(1);
    $query = $this->db->get('m_item');
    if ($query->num_rows() > 0) {
        foreach ($query->result() as $row) {
            return $row->serial_no;
        }
    }
  }

  public function get_batch_serial_wise($item, $serial) {
    $this->db->select("batch");
    $this->db->where("cl", $this->sd['cl']);
    $this->db->where("bc", $this->sd['branch']);
    $this->db->where("item", $item);
    $this->db->where("serial_no", $serial);
    return $this->db->get('t_serial')->first_row()->batch;
  }



  public function save_sub_items(){
    for ($x = 0; $x < 25; $x++) {
      if (isset($_POST['0_' . $x], $_POST['rcv_' . $x])) {
        if ($_POST['0_' . $x] != "") {

          $item_code=$_POST['0_'.$x];
          $qty=$_POST['5_'.$x];
          $batch=$_POST['1_'.$x];
          $date=$_POST['date'];
          $store=$_POST['stores'];
          $price=$_POST['3_'.$x];
          $max=$this->max_no;

          $sql="SELECT s.sub_item , r.qty 
              FROM t_item_movement_sub s
              JOIN r_sub_item r ON r.`code`=s.`sub_item`
              WHERE s.`item`='$item_code' AND s.cl='".$this->sd['cl']."' AND s.bc ='".$this->sd['branch']."' AND s.`batch_no`='$batch' 
              GROUP BY r.`code`";
          $query=$this->db->query($sql);

          foreach($query->result() as $row) {
              $total_qty=$qty*(int)$row->qty;

              $t_sub_item_movement_out[] = array(
                "cl" => $this->sd['cl'],
                "bc" => $this->sd['branch'],
                "item" => $item_code,
                "sub_item"=>$row->sub_item,
                "trans_code" => 68,
                "trans_no" => $max,
                "ddate" => $date,
                "qty_in" => 0,
                "qty_out" => $total_qty,
                "store_code" => $store,
                "avg_price" => $this->utility->get_cost_price($item_code),
                "batch_no" => $batch,
                "sales_price" => $price,
                "last_sales_price" => $this->utility->get_min_price($item_code),
                "cost" => $this->utility->get_cost_price($item_code),
                "group_sale_id" => 1,
              );

              $t_sub_item_movement_in[] = array(
                "cl" => $this->sd['cl'],
                "bc" => $this->sd['branch'],
                "item" => $item_code,
                "sub_item"=>$row->sub_item,
                "trans_code" => 68,
                "trans_no" => $max,
                "ddate" => $date,
                "qty_in" => $total_qty,
                "qty_out" => 0,
                "store_code" => $this->sales_order_store,
                "avg_price" => $this->utility->get_cost_price($item_code),
                "batch_no" => $batch,
                "sales_price" => $price,
                "last_sales_price" => $this->utility->get_min_price($item_code),
                "cost" => $this->utility->get_cost_price($item_code),
                "group_sale_id" => 1,
              );
          }
        }
      }
    }
    if ($_POST['hid'] == "0" || $_POST['hid'] == "") {
        if(isset($t_sub_item_movement_out)){if(count($t_sub_item_movement_out)){$this->db->insert_batch("t_item_movement_sub",$t_sub_item_movement_out);}}
        if(isset($t_sub_item_movement_in)){if(count($t_sub_item_movement_in)){$this->db->insert_batch("t_item_movement_sub",$t_sub_item_movement_in);}}
    }else{
        $this->db->where("cl", $this->sd['cl']);
        $this->db->where("bc", $this->sd['branch']);
        $this->db->where("trans_code", 68);
        $this->db->where("trans_no", $_POST['hid']);
        $this->db->delete("t_item_movement_sub");

        if(isset($t_sub_item_movement_out)){if(count($t_sub_item_movement_out)){$this->db->insert_batch("t_item_movement_sub",$t_sub_item_movement_out);}}
        if(isset($t_sub_item_movement_in)){if(count($t_sub_item_movement_in)){$this->db->insert_batch("t_item_movement_sub",$t_sub_item_movement_in);}}
    }   
  }

  private function set_delete(){
    $this->db->where('no', $this->max_no);
    $this->db->where('cl', $this->sd['cl']);
    $this->db->where('bc',$this->sd['branch']);
    $this->db->delete("t_so_det");

    $this->db->where("no", $this->max_no);
    $this->db->where("cl", $this->sd['cl']);
    $this->db->where("bc", $this->sd['branch']);
    $this->db->delete("t_so_additional_items");

    $this->db->where("cl", $this->sd['cl']);
    $this->db->where("bc", $this->sd['branch']);
    $this->db->where("trans_code", 68);
    $this->db->where("trans_no", $this->max_no);
    $this->db->delete("t_item_movement");

  }
    
  public function check_code(){
    $this->db->where('cl',$this->sd['cl']);
    $this->db->where('bc',$this->sd['branch']);
    $this->db->where('no', $_POST['id']);
    $this->db->limit(1);
    echo $this->db->get($this->mtb)->num_rows;
  }
    
  public function load(){

    $x=1;

    $sql_sum="SELECT  cus_id,
                      c.`name` AS cus_name,
                      CONCAT(c.`address1`,', ', c.`address2`,', ',c.`address3`) AS address,
                      store,
                      no,
                      date,
                      ref_no,
                      inv_no,
                      gross_amount,
                      additional_amount,
                      discount_amount,
                      net_amount,
                      memo,
                      rep_id,
                      e.`name` AS rep_name,
                      is_cancel
            FROM t_so_sum s
            JOIN m_customer c ON c.`cl` = s.`cl` AND c.`bc` = s.`bc` AND s.`cus_id` = c.`code`
            JOIN m_employee e ON e.`code` = s.`rep_id`
            WHERE s.`cl` ='".$this->sd['cl']."'
              AND s.`bc`='".$this->sd['branch']."'
              AND s.`no`='".$_POST['no']."'";

    $query_sum = $this->db->query($sql_sum); 

    if($query_sum->num_rows()>0){ 
      $a['sum']=$query_sum->result();         
    }else{
      $x=2;      
    }        

    $sql_det="SELECT  d.code AS item,
                      m.`description`,
                      m.`model`,
                      batch_no,
                      d.qty,
                      discount_p,
                      discount,
                      amount,
                      d.cost,
                      is_reserve,
                      m.`min_price`,
                      d.advance_detail,
                      d.advance_amount,
                      d.delivered_qty                      
              FROM t_so_det d
              JOIN m_item m ON m.`code` = d.`code`
              WHERE cl='".$this->sd['cl']."' 
              AND bc='".$this->sd['branch']."'
              AND no='".$_POST['no']."'";
    
    $sql_det = $this->db->query($sql_det); 

    if($query_sum->num_rows()>0){ 
      $a['det']=$sql_det->result();         
    }else{
      $x=2;      
    }    

    $sql_serial="SELECT s.item,serial_no
                 FROM t_serial_movement s
                 WHERE s.`cl` ='".$this->sd['cl']."' 
                  AND s.`bc` ='".$this->sd['branch']."' 
                  AND s.`trans_type` ='68' 
                  AND s.`trans_no` ='".$_POST['no']."'
                 GROUP BY item,serial_no";

    $query_serial = $this->db->query($sql_serial);
                 
    if ($query_serial->num_rows() > 0) {
        $a['serial'] = $query_serial->result();
    } else {
        $a['serial']=2; 
    }

    $this->db->select(array(
        't_so_additional_items.type as sales_type',
        't_so_additional_items.rate_p',
        't_so_additional_items.amount',
        'r_additional_item.description'
    ));

    $this->db->from('t_so_additional_items');
    $this->db->join('r_additional_item', 'r_additional_item.code=t_so_additional_items.type');
    $this->db->where('t_so_additional_items.cl', $this->sd['cl']);
    $this->db->where('t_so_additional_items.bc', $this->sd['branch']);
    $this->db->where('t_so_additional_items.no', $_POST['no']);
    $query_add = $this->db->get();

    if ($query_add->num_rows() > 0) {
        $a['add'] = $query_add->result();
    } else {
        $a['add']=2; 
    }

    if($x==1){
      echo json_encode($a);
    }else{
      echo json_encode("2");
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
      if($this->user_permissions->is_delete('t_sales_order')){

        $this->db->where('no', $_POST['id']);
        $this->db->where('cl', $this->sd['cl']);
        $this->db->where('bc',$this->sd['branch']);
        $this->db->update('t_so_sum', array("is_cancel"=>1));
        
        $this->db->where("cl", $this->sd['cl']);
        $this->db->where("bc", $this->sd['branch']);
        $this->db->where("trans_code", 68);
        $this->db->where("trans_no", $_POST['id']);
        $this->db->delete("t_item_movement");

        $this->db->where("cl", $this->sd['cl']);
        $this->db->where("bc", $this->sd['branch']);
        $this->db->where("trans_code", 68);
        $this->db->where("trans_no", $_POST['id']);
        $this->db->delete("t_item_movement_sub");

        $t_serial = array(
         "store_code" => $_POST['store'],
         "engine_no"  => "",
         "chassis_no" => '',
         "out_doc"    => "",
         "out_no"     => "",
         "out_date"   => "",
         "available"  => '1'
        );

        $this->db->select(array('item', 'serial_no'));
        $this->db->where("trans_no", $_POST['id']);
        $this->db->where("trans_type", 68);
        $this->db->where("cl", $this->sd['cl']);
        $this->db->where("bc", $this->sd['branch']);
        $query1 = $this->db->get("t_serial_movement");

        foreach ($query1->result() as $row) {
          $this->db->where("cl", $this->sd['cl']);
          $this->db->where("bc", $this->sd['branch']);
          $this->db->where("item", $row->item);
          $this->db->where("serial_no", $row->serial_no);
          $this->db->update("t_serial", $t_serial);
        }

        $this->db->where("trans_no", $_POST['id']);
        $this->db->where("trans_type", 68);
        $this->db->where("cl", $this->sd['cl']);
        $this->db->where("bc", $this->sd['branch']);
        $this->db->delete("t_serial_movement");

        $this->trans_settlement->delete_settlement_sub("t_credit_note_trans","68",$_POST['id']);
        $this->delete_temp_table($this->max_no);
        $this->utility->save_logger("CANCEL",68,$_POST['id'],$this->mod);
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
    
  public function select(){  
    $query = $this->db->get($this->mtb);   
    $s = "<select name='sales_ref' id='sales_ref'>";
    $s .= "<option value='0'>---</option>";
    foreach($query->result() as $r){
      $s .= "<option title='".$r->name."' value='".$r->code."'>".$r->code." | ".$r->name."</option>";
    }
    $s .= "</select>";
    
    return $s;
    }

  public function item_list_all(){
    
    if($_POST['search'] == 'Key Word: code, name'){$_POST['search'] = "";}
             
     $sql = "SELECT DISTINCT(m_item.code), 
            m_item.`description`,
            m_item.`model`,
            t_item_batch.`max_price`, 
            t_item_batch.`min_price`,
            t_item_batch.purchase_price 
            FROM m_item 
            JOIN qry_current_stock ON m_item.`code`=qry_current_stock.`item`
            JOIN t_item_batch ON t_item_batch.`item` = m_item.`code` AND t_item_batch.`batch_no`= qry_current_stock.`batch_no`
            WHERE qry_current_stock.`store_code`='$_POST[stores]' 
            AND qry_current_stock.qty > 0 
            AND qry_current_stock.cl='$cl' 
            AND qry_current_stock.bc='$branch' 
            AND (m_item.`description` LIKE '%$_POST[search]%' 
            OR m_item.`code` LIKE '%$_POST[search]%' 
            OR m_item.model LIKE '$_POST[search]%' 
            OR t_item_batch.`max_price` LIKE '$_POST[search]%'
            OR `t_item_batch`.`min_price` LIKE '$_POST[search]%' 
            OR `t_item_batch`.`max_price` LIKE '$_POST[search]%') 
            AND `m_item`.`inactive`='0'
            GROUP BY  m_item.code
             LIMIT 25";  

      $query = $this->db->query($sql);
        
      $a = "<table id='item_list' style='width : 100%' >";
        
      $a .= "<thead><tr>";
        $a .= "<th class='tb_head_th'>Code</th>";
        $a .= "<th class='tb_head_th'>Item Name</th>";
        $a .= "<th class='tb_head_th'>Model</th>";
        $a .= "<th class='tb_head_th'>Price</th>";       
      $a .= "</thead></tr>";

      $a .= "<tr class='cl'>";
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
          $a .= "<td>".$r->max_price."</td>";            
        $a .= "</tr>";
      }
      $a .= "</table>";
        
      echo $a;
    }

  public function get_item(){
    $this->db->select(array('code','description','model','max_price'));
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


  public function PDF_report(){

    $this->db->select(array('name','address','tp','fax','email'));
    $this->db->where("cl",$this->sd['cl']);
    $this->db->where("bc",$this->sd['branch']);
    $r_detail['branch']=$this->db->get('m_branch')->result();
      
    $invoice_number= $this->utility->invoice_format($_POST['qno']);
    $session_array = array(
         $this->sd['cl'],
         $this->sd['branch'],
         $invoice_number
    );
    $r_detail['session'] = $session_array;

    $r_detail['type']=$_POST['type'];        
    $r_detail['dt']=$_POST['dt'];
    $r_detail['qno']=$_POST['qno'];
    $r_detail['page']=$_POST['page'];
    $r_detail['header']=$_POST['header'];
    $r_detail['orientation']=$_POST['orientation'];
     
    $sql_sum="SELECT  cus_id,
                      c.`name` AS cus_name,
                      CONCAT(c.`address1`,', ', c.`address2`,', ',c.`address3`) AS address,
                      store,
                      no,
                      date,
                      ref_no,
                      inv_no,
                      gross_amount,
                      additional_amount,
                      discount_amount,
                      net_amount,
                      memo,
                      rep_id,
                      e.`name` AS rep_name,
                      is_cancel
            FROM t_so_sum s
            JOIN m_customer c ON c.`cl` = s.`cl` AND c.`bc` = s.`bc` AND s.`cus_id` = c.`code`
            JOIN m_employee e ON e.`code` = s.`rep_id`
            WHERE s.`cl` ='".$this->sd['cl']."'
              AND s.`bc`='".$this->sd['branch']."'
              AND s.`no`='".$_POST['qno']."'";

    $r_detail['sum'] = $this->db->query($sql_sum)->result(); 

    $sql_det="SELECT  d.code AS item,
                      m.`description`,
                      m.`model`,
                      batch_no,
                      d.qty,
                      discount_p,
                      discount,
                      amount,
                      d.cost,
                      is_reserve,
                      m.`min_price`,
                      r_sub_item.`code` AS sub_item,
                      r_sub_item.`description` AS des,
                      r_sub_item.`qty` * d.qty AS sub_qty
              FROM t_so_det d
              JOIN m_item m ON m.`code` = d.`code`
              LEFT JOIN `m_item_sub` ON `m_item_sub`.`item_code` = m.`code` 
              LEFT JOIN `r_sub_item` ON `r_sub_item`.`code` = `m_item_sub`.`sub_item`
              WHERE cl='".$this->sd['cl']."' 
              AND bc='".$this->sd['branch']."'
              AND no='".$_POST['qno']."'
              GROUP BY d.code,r_sub_item.`code`
              order by d.auto_no";
    
    $r_detail['det'] = $this->db->query($sql_det)->result(); 

    $sql_serial="SELECT s.item as s_item,serial_no
                 FROM t_serial_movement s
                 WHERE s.`cl` ='".$this->sd['cl']."' 
                  AND s.`bc` ='".$this->sd['branch']."' 
                  AND s.`trans_type` ='68' 
                  AND s.`trans_no` ='".$_POST['qno']."'
                 GROUP BY item,serial_no";

    $r_detail['serial'] = $this->db->query($sql_serial)->result(); 
                   
    $this->db->select(array(
        't_so_additional_items.type as sales_type',
        't_so_additional_items.rate_p',
        't_so_additional_items.amount',
        'r_additional_item.description',
        'r_additional_item.is_add'
    ));

    $this->db->from('t_so_additional_items');
    $this->db->join('r_additional_item', 'r_additional_item.code=t_so_additional_items.type');
    $this->db->where('t_so_additional_items.cl', $this->sd['cl']);
    $this->db->where('t_so_additional_items.bc', $this->sd['branch']);
    $this->db->where('t_so_additional_items.no', $_POST['qno']);
    $query_add = $this->db->get();

    $r_detail['additonal'] = $query_add->result(); 


    $this->db->select(array('loginName'));
    $this->db->where('cCode',$this->sd['oc']);
    $r_detail['user']=$this->db->get('users')->result();

    $this->load->view($_POST['by'].'_'.'pdf',$r_detail);
  }

public function customer_list(){

    if($_POST['search'] == 'Key Word: code, name'){$_POST['search'] = "";}
      
      $sql = "SELECT * FROM m_customer  WHERE name LIKE '%$_POST[search]%' OR code LIKE '%$_POST[search]%'  OR nic LIKE '%$_POST[search]%' LIMIT 25";
    
      $query = $this->db->query($sql);
      $a  = "<table id='item_list' style='width : 100%' >";
      $a .= "<thead><tr>";
      $a .= "<th class='tb_head_th'>Code</th>";
      $a .= "<th class='tb_head_th' colspan='2'>Name</th>";
      $a .= "<th class='tb_head_th'>NIC</th>";
      $a .= "</thead></tr><tr class='cl'><td>&nbsp;</td><td colspan='2'>&nbsp;</td></tr>";

    foreach($query->result() as $r){
      $a .= "<tr class='cl'>";
      $a .= "<td>".$r->code."</td>";
      $a .= "<td colspan='2'>".$r->name."</td>";
      $a .= "<td>".$r->nic."</td>";
      $a .= "<td style='display:none;'>".$r->address1." ".$r->address2." ".$r->address3."</td>";
      $a .= "</tr>";
    }
      $a .= "</table>";
      echo $a;
  }

   public function load_advance(){
    
    if($_POST['search'] == 'Key Word: code, name'){$_POST['search'] = "";}
    
     $sql = "SELECT t.ddate, 
                    tc.description, 
                    t.sub_trans_no AS no , 
                    t.dr AS amount, 
                    SUM(t.dr)-SUM(t.cr) balance,
                    t.trans_no AS cr_no 
            FROM `t_credit_note_trans` t
            JOIN t_trans_code tc ON tc.code=t.sub_trans_code
            WHERE t.acc_code='".$_POST['customer']."'
                AND t.cl='".$this->sd['cl']."' AND t.bc='".$this->sd['branch']."'
            GROUP BY t.sub_cl,t.sub_bc, t.trans_no 
            HAVING balance>0  
            LIMIT 50 ";  

    $query = $this->db->query($sql);
        
    $a = "<table id='advance_list' style='width : 100%' >";
        
    $a .= "<thead><tr>";
    $a .= "<th class='tb_head_th'>Details</th>";
    $a .= "<th class='tb_head_th'>No</th>";
    $a .= "<th class='tb_head_th'>Amount</th>";
    $a .= "<th class='tb_head_th'>Balance</th>"; 
    $a .= "<th class='tb_head_th' style='width:150px;'>Paid</th>";      
    $a .= "</thead></tr>";

   
    $x =(int)0;
    foreach($query->result() as $r){
      $a .= "<tr class='cl'>";
      $a .= "<td>".$r->ddate."&nbsp;&nbsp;&nbsp;&nbsp; - &nbsp;&nbsp;&nbsp;&nbsp;".$r->description."</td>";
      $a .= "<td>".$r->no."</td>";
      $a .= "<td>".$r->amount."</td>";
      $a .= "<td>".$r->balance."</td>";  
      $a .= "<td><input type='text' name='paid_".$x."' id='paid_".$x."' class='g_input_amo sst' style='border: 1px solid #003399;width:100%;'/></td>";             
      $a .= "<td style='display:none;'>".$r->cr_no."</td>";  
      $a .= "</tr>";
      $x++;
    }
    $a .= "</table>";
    echo $a;
    }  


    public function load_saved_advance(){
    
    $de_qty = $_POST['deliverd_qty'];

    $sql = "SELECT ddate, trans_no,cr
             FROM t_credit_note_trans
             WHERE sub_trans_code='68'
              AND ref_code='".$_POST['item']."'
              AND sub_trans_no='".$_POST['no']."'
              AND cl='".$this->sd['cl']."'
              AND bc='".$this->sd['branch']."'";  

    $query = $this->db->query($sql);
        
    $a = "<table id='item_list' style='width : 100%' >";
        
    $a .= "<thead><tr>";
    $a .= "<th class='tb_head_th'>Details</th>";
    $a .= "<th class='tb_head_th'>No</th>";
    $a .= "<th class='tb_head_th'>Amount</th>";
    $a .= "<th class='tb_head_th'>Balance</th>"; 
    $a .= "<th class='tb_head_th' style='width:150px;'>Paid</th>";      
    $a .= "</thead></tr>";

    $a .= "<tr class='cl'>";
    $a .= "<td>&nbsp;</td>";
    $a .= "<td>&nbsp;</td>";
    $a .= "<td>&nbsp;</td>";
    $a .= "<td>&nbsp;</td>";   
    $a .= "<td>&nbsp;</td>";                 
    $a .= "</tr>";
    $x =(int)0;
    foreach($query->result() as $r){
      $a .= "<tr class='cl'>";
      $a .= "<td>".$r->ddate."</td>";
      $a .= "<td>".$r->trans_no."</td>";
      $a .= "<td>".$r->cr."</td>";
      $a .= "<td>".$r->cr."</td>";  
      if($de_qty>0){
        $a .= "<td><input type='text' name='paid_".$x."' id='paid_".$x."' readonly='readonly' class='g_input_txt g_col_fixed sst' value='".$r->cr."' style='border: 1px solid #003399;width:100%;'/></td>";             
      }else{
        $a .= "<td><input type='text' name='paid_".$x."' id='paid_".$x."' class='g_input_amo sst' value='".$r->cr."' style='border: 1px solid #003399;width:100%;'/></td>";             
      }
      $a .= "<td style='display:none;'>".$r->trans_no."</td>";  
      $a .= "</tr>";
      $x++;
    }
    $a .= "</table>";
    echo $a;
    }  


    public function save_temp(){
      $nno=$_POST['no'];
      $all_data=$_POST["all_data"];
      $count_data = explode(",",$all_data);
      $arr_length= (int)sizeof($count_data)-1;
      for ($i=0; $i<$arr_length ; $i++) { 
        $s_data = (explode(",",$count_data[$i])); 
        $rr = explode("|",$s_data[0]);

        $ad_no = $rr[1];
        $bal = $rr[3];
        $settle = $rr[4];
        $temp_det[]=array(
          'cl' =>$this->sd['cl'],
          'bc' =>$this->sd['branch'],
          'so_no' =>$nno,
          'advance_no' =>$ad_no, 
          'balance' =>$bal ,
          'paid' =>$settle ,
          'item' =>$_POST['item'] ,
        );
      }
      
      $this->db->where("item", $_POST['item']);
      $this->db->where("so_no", $nno);
      $this->db->where("cl", $this->sd['cl']);
      $this->db->where("bc", $this->sd['branch']);
      $this->db->delete("t_check_settled_advance");
     
     // var_dump($temp_det);
      if(isset($temp_det)){
        if(count($temp_det)){
          echo $this->db->insert_batch("t_check_settled_advance",$temp_det);
        }
      }
    }

    public function delete_temp_table($nno){
      $this->db->where("so_no", $nno);
      $this->db->where("cl", $this->sd['cl']);
      $this->db->where("bc", $this->sd['branch']);
      $this->db->delete("t_check_settled_advance");
    }

    public function check_advance_settled_limit(){
      $status="1";
      $sql="SELECT advance_no,balance ,SUM(paid),balance-SUM(paid) AS settled
            FROM t_check_settled_advance
            WHERE SO_NO='".$this->max_no."'
            AND cl='".$this->sd['cl']."' AND bc='".$this->sd['branch']."'
            GROUP BY cl,bc,so_no,advance_no";

      $query=$this->db->query($sql);
     
      foreach($query->result() as $row){

        $tot = $row->balance;
        $settled = $row->settled;
        $advance_no = $row->advance_no;

        if($settled<0){
          $status="Over settled amount in adavance no (".$advance_no.") ";
        }
      }
      return $status;
    }

    public function delete_trance_recode(){
      $item=$_POST['item'];
      $no=$_POST['no'];

      $this->db->where("ref_code", $item);
      $this->db->where("sub_trans_code", 68);
      $this->db->where("sub_trans_no", $no);
      $this->db->where("cl", $this->sd['cl']);
      $this->db->where("bc", $this->sd['branch']);
      echo $this->db->delete("t_credit_note_trans");
    }
}