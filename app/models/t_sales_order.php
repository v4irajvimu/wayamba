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
    
  }
    
  public function base_details(){
  
    $this->load->model('m_customer');
    $a['customer']=$this->m_customer->select();
    $a['max_no']= $this->utility->get_max_no("t_so_sum","no");
    $this->load->model('m_stores');
    $a['stores'] = $this->m_stores->select();
    $a['sale_price'] = $this->utility->use_sale_prices(); 


    return $a;
  }

  public function get_credit_max_no() {
    $field = "nno";
    $this->db->select_max($field);
    $this->db->where("cl", $this->sd['cl']);
    $this->db->where("bc", $this->sd['branch']);
    return $this->db->get("t_credit_note")->first_row()->$field + 1;
  }

  public function get_advance_max_no() {
    $field = "nno";
    $this->db->select_max($field);
    $this->db->where("cl", $this->sd['cl']);
    $this->db->where("bc", $this->sd['branch']);
    return $this->db->get("t_advance_sum")->first_row()->$field + 1;
  }
  
  public function validation(){
    $status=1;
    $this->max_no=$this->utility->get_max_no("t_so_sum","no");
 
    $check_customer_validation=$this->validation->check_is_customer($_POST['customer']);

    if($check_customer_validation!=1){
      return "Please select valid customer";
    }
    $employee_validation = $this->validation->check_is_employer($_POST['sales_rep']);
    if ($employee_validation != 1) {
        return "Please enter valid sales rep";
    }
    $minimum_price_validation = $this->validation->check_min_price2('0_', '3_', 'item_min_price_','7_','f_','1_','5_');
    if ($minimum_price_validation != 1){
    return $minimum_price_validation;
    }
    $serial_validation_status = $this->validation->serial_update('0_', 'rcvqty_',"all_serial_");
    if ($serial_validation_status != 1) {
        return $serial_validation_status;
    }
    /*$check_zero_value=$this->validation->empty_net_value($_POST['net_amount']);
    if($check_zero_value!=1){
      return $check_zero_value;
    }*/
    /*$batch_validation_status = $this->batch_avbl_qty('0_', '1_', 'rcvqty_');
    if ($batch_validation_status != 1) {
        return $batch_validation_status;
    }*/
    /*$check_settled_limit = $this->check_advance_settled_limit();
    if ($check_settled_limit != 1) {
        return $check_settled_limit;
    }
    
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
        throw new Exception($errLine); 
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
        "post"              =>"",
        "post_by"           =>"",
        "post_date"         =>$_POST['date'],
        "discount_amount"   =>$_POST['total_discount'],
        "pay_cash"          =>$_POST['cash_ad'],
        "pay_card"          =>$_POST['card_ad'],
        "pay_cheque"        =>$_POST['chq_ad'],
        "pay_tot"           =>$_POST['tot_ad'],
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
              "is_free"        =>$_POST['f_'.$x],              
              //"is_reserve"  =>$is_rcv, -- not use status
              "reserve_qty" =>$_POST['rcvqty_'.$x],
              "advance_amount"=>$_POST["adamnt_".$x]
            ); 
          }
        }
      }
// var_dump($det);
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

/*      for ($x = 0; $x < 25; $x++) {
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
*/
      

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
          //---
          $this->load->model('trans_settlement');

          // var_dump($_POST['stores']);exit();

          for($x = 0; $x<25; $x++){
            if (isset($_POST['0_' . $x], $_POST['5_' . $x], $_POST['rcvqty_' . $x], $_POST['1_' . $x])) {
              if ($_POST['0_' . $x] != "" && $_POST['5_' . $x] != "" && $_POST['rcvqty_' . $x] >0 && $_POST['f_' . $x] == "") {

                $this->trans_settlement->save_item_movement('t_item_movement',
                  $_POST['0_'.$x],
                  68,
                  $this->max_no,
                  $_POST['date'],
                  0,
                  $_POST['rcvqty_'.$x],
                  $_POST['stores'],
                  $this->utility->get_cost_price($_POST['0_' . $x]),
                  $_POST['1_'.$x],
                  $_POST['3_' . $x],
                  $this->utility->get_min_price($_POST['0_' . $x]),
                  $_POST['3_'.$x],
                  1);

                $this->trans_settlement->save_item_movement('t_item_movement',
                  $_POST['0_'.$x],
                  68,
                  $this->max_no,
                  $_POST['date'],
                  $_POST['rcvqty_'.$x],
                  0,
                  $this->sales_order_store,
                  $this->utility->get_cost_price($_POST['0_' . $x]),
                  $_POST['1_'.$x],
                  $_POST['3_' . $x],
                  $this->utility->get_min_price($_POST['0_' . $x]),
                  $_POST['3_'.$x],
                  1);

              }
            }
          }
          //---
          $this->save_sub_items();
          if($_POST['df_is_serial']=='1'){
            $this->serial_save_out();  
            $this->serial_save_in();    
          }
          if (isset($t_sales_order_additional_item)) {
            if (count($t_sales_order_additional_item)) {
              $this->db->insert_batch("t_so_additional_items", $t_sales_order_additional_item);
            }
          }
          /*if(isset($t_item_movement_out)){
            if (count($t_item_movement_out)) {
               $this->db->insert_batch("t_item_movement", $t_item_movement_out);
            }
          }
          if(isset($t_item_movement_in)){
            if (count($t_item_movement_in)) {
               $this->db->insert_batch("t_item_movement", $t_item_movement_in);
            }
          }*/

          $cash_crd=(float)$_POST['cash_ad'] +(float)$_POST['card_ad']; 
          $endDate = date('Y-m-d', strtotime("+3 months", strtotime("now")));

          if($cash_crd>0){
            $this->save_card_details($endDate,$cash_crd);
          }

          if($_POST['chq_ad']>0){
            $this->save_chq_details($endDate);
          }

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

          $this->set_delete($_POST['hid']);

          if($_POST['df_is_serial']=='1'){
            $this->serial_save_out();  
            $this->serial_save_in();    
          }
          $this->save_sub_items();

          $cash_crd=(float)$_POST['cash_ad'] +(float)$_POST['card_ad']; 
          $endDate = date('Y-m-d', strtotime("+3 months", strtotime("now")));
          
          $chq=$card=0;
          $crd_c_note=$chq_c_note=0;
          $xx=0;
          $yy=0;

          $sql="SELECT a.`nno` 
            FROM t_so_sum s
            JOIN t_advance_sum a ON a.`cl` = s.`cl` AND a.`bc` = s.`bc` AND a.`so_no` = s.`no`
            WHERE a.`so_type` ='1'
            AND so_pay_type ='1'
            AND a.so_no = '".$_POST['hid']."' 
            AND a.cl ='".$this->sd['cl']."'
            AND a.bc ='".$this->sd['branch']."'
            ORDER BY a.nno ASC";

          $query=$this->db->query($sql);
          if($query->num_rows()>0){
            $card =  $query->row()->nno;
          }

          $sql5="SELECT a.`nno` 
            FROM t_so_sum s
            JOIN t_advance_sum a ON a.`cl` = s.`cl` AND a.`bc` = s.`bc` AND a.`so_no` = s.`no`
            WHERE a.`so_type` ='1'
            AND so_pay_type ='2'
            AND a.so_no = '".$_POST['hid']."' 
            AND a.cl ='".$this->sd['cl']."'
            AND a.bc ='".$this->sd['branch']."'
            ORDER BY a.nno ASC";

          $query5=$this->db->query($sql5);
          if($query5->num_rows()>0){
            $chq =  $query5->row()->nno;
          }


          $sql2="SELECT nno FROM t_credit_note
                    WHERE cl='".$this->sd['cl']."'
                    and bc='".$this->sd['branch']."'
                    and ref_trans_code='24'
                    and ref_trans_no='$card' 
                    ORDER BY nno";
          $query2=$this->db->query($sql2);
          if($query2->num_rows()>0){
            $crd_c_note =  $query2->row()->nno;
          }

          $sql6="SELECT nno FROM t_credit_note
                    WHERE cl='".$this->sd['cl']."'
                    and bc='".$this->sd['branch']."'
                    and ref_trans_code='24'
                    and ref_trans_no='$chq' 
                    ORDER BY nno";
          $query6=$this->db->query($sql6);
          if($query6->num_rows()>0){
            $chq_c_note =  $query6->row()->nno;
          }

          if($card!=0){
            if($cash_crd>0){
              $this->update_card($endDate,$cash_crd,$card,$crd_c_note);
            }
          }else{
            if($cash_crd>0){
              $this->save_card_details($endDate,$cash_crd);
            }
          }   

          if($chq!=0){
            if($_POST['chq_ad']>0){
              $this->update_chq($endDate,$chq,$chq_c_note);
            }
          }else{
            if($_POST['chq_ad']>0){
              $this->save_chq_details($endDate);
            }
          }

          $this->db->insert("t_so_sum_history", $sum);

          if(count($det)){
            $this->db->insert_batch("t_so_det_history",$det);
          }

          if(count($det)){
            $this->db->insert_batch("t_so_det",$det);
          }

          if (isset($t_sales_order_additional_item)) {
            if (count($t_sales_order_additional_item)) {
              $this->db->insert_batch("t_so_additional_items", $t_sales_order_additional_item);
            }
          }
          $this->load->model('trans_settlement');
          for($x = 0; $x<25; $x++){

            // var_dump($_POST['stores']);exit();

            if (isset($_POST['0_' . $x], $_POST['5_' . $x], $_POST['rcvqty_' . $x], $_POST['1_' . $x])) {
              if ($_POST['0_' . $x] != "" && $_POST['5_' . $x] != "" && $_POST['rcvqty_' . $x] >0 && $_POST['f_' . $x] != "1") {

                $this->trans_settlement->save_item_movement('t_item_movement',
                  $_POST['0_'.$x],
                  68,
                  $this->max_no,
                  $_POST['date'],
                  0,
                  $_POST['rcvqty_'.$x],
                  $_POST['stores'],
                  $this->utility->get_cost_price($_POST['0_' . $x]),
                  $_POST['1_'.$x],
                  $_POST['3_' . $x],
                  $this->utility->get_min_price($_POST['0_' . $x]),
                  $_POST['3_'.$x],
                  1);

                $this->trans_settlement->save_item_movement('t_item_movement',
                  $_POST['0_'.$x],
                  68,
                  $this->max_no,
                  $_POST['date'],
                  $_POST['rcvqty_'.$x],
                  0,
                  $this->sales_order_store,
                  $this->utility->get_cost_price($_POST['0_' . $x]),
                  $_POST['1_'.$x],
                  $_POST['3_' . $x],
                  $this->utility->get_min_price($_POST['0_' . $x]),
                  $_POST['3_'.$x],
                  1);

              }
            }
          }
          /*if(isset($t_item_movement_out)){
            if (count($t_item_movement_out)) {
               $this->db->insert_batch("t_item_movement", $t_item_movement_out);
            }
          }
          if(isset($t_item_movement_in)){
            if (count($t_item_movement_in)) {
               $this->db->insert_batch("t_item_movement", $t_item_movement_in);
            }
          }*/

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


public function save_card_details($endDate,$cash_crd){
  $t_advance_cash_card = array(
     "cl"             =>$this->sd['cl'],
     "bc"             =>$this->sd['branch'],
     "nno"            =>$this->get_advance_max_no(),
     "ddate"          =>$_POST['date'],
     "ref_no"         =>$_POST['ref_no'],
     "acc_code"       =>$_POST['customer'],
     "description"    =>"Advance payment for sales order no [".$this->max_no."]",
     "expire_date"    =>$endDate,
     "cash_amount"    =>isset($_POST['cash_ad'])?$_POST['cash_ad']:'',
     "card_amount"    =>isset($_POST['card_ad'])?$_POST['card_ad']:'',                            
     "cheque_amount"  =>'',
     "total_amount"   =>$cash_crd,
     "cn_no"          =>$this->get_credit_max_no(),
     "so_no"          =>$this->max_no,
     "so_type"        => 1,
     "so_pay_type"    => 1
  );

  $t_credit_note_for_cash_card = array(
    "cl" => $this->sd['cl'],
    "bc" => $this->sd['branch'],
    "nno" => $this->get_credit_max_no(),
    "ddate" => $_POST['date'],
    "ref_no" => $_POST['ref_no'],
    "memo" => "Advance payment for sales order no - [" . $this->max_no . "]",
    "is_customer" => 1,
    "code" => $_POST['customer'],
    "acc_code" => $this->utility->get_default_acc('STOCK_ACC'),
    "amount" => $cash_crd,
    "oc" => $this->sd['oc'],
    "post" => "",
    "post_by" => "",
    "post_date" => "",
    "is_cancel" => 0,
    "ref_trans_no" => $this->get_advance_max_no(),
    "ref_trans_code" => 24,
    "balance"=>$cash_crd
  );

  for($x=0;$x<10;$x++){
    if(isset($_POST['type1_'.$x]) && !empty($_POST['type1_'.$x])){ 
      if(isset($_POST['no1_'.$x]) && !empty($_POST['no1_'.$x])){ 
        if(isset($_POST['amount1_'.$x]) && !empty($_POST['amount1_'.$x])){
          $credit_data[]=array(
            "cl"=>$this->sd['cl'],
            "bc"=>$this->sd['branch'],
            "trans_code"=>24,
            "trans_no"=>$this->get_advance_max_no(),
            "card_type"=>$_POST['type1_'.$x],
            "card_no"=>$_POST['no1_'.$x],
            "amount"=>$_POST['amount1_'.$x],
            "int_amount"=>$_POST['amount_rate1_'.$x],
            "rate"=>$_POST['rate1_'.$x],
            "month"=>$_POST['month1_'.$x],
            "bank_id"=>$_POST['bank1_'.$x],
            "merchant_id"=>$_POST['merchant1_'.$x],  
            "acc_code"=>$_POST['acc1_'.$x],   
            "date"=>$_POST['date'],
          );
        }
      } 
    }
  }

  if(isset($credit_data)){
    if(count($credit_data)) {
      $this->db->insert_batch("opt_credit_card_det", $credit_data);
    }
  }

  $this->trans_settlement->save_settlement("t_credit_note_trans", $_POST['customer'], $_POST['date'], 17,$this->get_credit_max_no(), 24, $this->get_advance_max_no(), $cash_crd, "0");
  $this->db->insert('t_credit_note', $t_credit_note_for_cash_card);
  $this->db->insert('t_advance_sum', $t_advance_cash_card);
}


public function save_chq_details($endDate){
  $t_advance_chq = array(
     "cl"             =>$this->sd['cl'],
     "bc"             =>$this->sd['branch'],
     "nno"            =>$this->get_advance_max_no(),
     "ddate"          =>$_POST['date'],
     "ref_no"         =>$_POST['ref_no'],
     "acc_code"       =>$_POST['customer'],
     "description"    =>"Advance payment for sales order no [".$this->max_no."]",
     "expire_date"    =>$endDate,
     "cash_amount"    =>'',
     "card_amount"    =>'',                            
     "cheque_amount"  =>$_POST['chq_ad'],
     "total_amount"   =>$_POST['chq_ad'],
     "cn_no"          =>$this->get_credit_max_no(),
     "so_no"          =>$this->max_no,
     "so_type"        => 1,
     "so_pay_type"    => 2,

  );

  $t_credit_note_for_chq = array(
    "cl"              => $this->sd['cl'],
    "bc"              => $this->sd['branch'],
    "nno"             => $this->get_credit_max_no(),
    "ddate"           => $_POST['date'],
    "ref_no"          => $_POST['ref_no'],
    "memo"            => "Advance payment for sales order no - [" . $this->max_no . "]",
    "is_customer"     => 1,
    "code"            => $_POST['customer'],
    "acc_code"        => $this->utility->get_default_acc('STOCK_ACC'),
    "amount"          => $_POST['chq_ad'],
    "oc"              => $this->sd['oc'],
    "post"            => "",
    "post_by"         => "",
    "post_date"       => "",
    "is_cancel"       => 0,
    "ref_trans_no"    => $this->get_advance_max_no(),
    "ref_trans_code"  => 24,
    "balance"         => $_POST['chq_ad'],
  );
  for($x=0;$x<10;$x++){
    if(isset($_POST['bank9_'.$x]) && !empty($_POST['bank9_'.$x])){ 
      if(isset($_POST['branch9_'.$x]) && !empty($_POST['branch9_'.$x])){ 
        if(isset($_POST['acc9_'.$x]) && !empty($_POST['acc9_'.$x])){
          if(isset($_POST['cheque9_'.$x]) && !empty($_POST['cheque9_'.$x])){
            if(isset($_POST['amount9_'.$x]) && !empty($_POST['amount9_'.$x])){
               $opt_chq_data[]=array(
                "cl"=>$this->sd['cl'],
                "bc"=>$this->sd['branch'],
                "trans_code"=>24,
                "trans_no"=>$this->get_advance_max_no(),
                "bank"=>$_POST['bank9_'.$x],
                "branch"=>$_POST['branch9_'.$x],
                "account_no"=>$_POST['acc9_'.$x],
                "cheque_no"=>$_POST['cheque9_'.$x],
                "amount"=>$_POST['amount9_'.$x],
                "cheque_date"=>$_POST['date9_'.$x],
                );
                        
                $rcv_chq_data[]=array(
                  "cl"=>$this->sd['cl'],
                  "bc"=>$this->sd['branch'],
                  "trans_code"=>24,
                  "trans_no"=>$this->get_advance_max_no(),
                  "bank"=>$_POST['bank9_'.$x],
                  "branch"=>$_POST['branch9_'.$x],
                  "account"=>$_POST['acc9_'.$x],
                  "cheque_no"=>$_POST['cheque9_'.$x],
                  "amount"=>$_POST['amount9_'.$x],
                  "bank_date"=>$_POST['date9_'.$x],
                  "status"=>"P",
                  "received_from_acc"=>$_POST['customer'],
                  "ddate" =>$_POST['date'],
                );
              }
            }  
          }
        } 
      }
   }
  if(isset($opt_chq_data)){
    if(count($opt_chq_data)) {
      $this->db->insert_batch("opt_receive_cheque_det", $opt_chq_data);
    }
  }
  if(isset($rcv_chq_data)){
    if(count($rcv_chq_data)) {
      $this->db->insert_batch("t_cheque_received", $rcv_chq_data);
    }
  }

  $this->trans_settlement->save_settlement("t_credit_note_trans", $_POST['customer'], $_POST['date'], 17, $this->get_credit_max_no(), 24, $this->get_advance_max_no(), $_POST['chq_ad'],"0");
  $this->db->insert('t_credit_note', $t_credit_note_for_chq);
  $this->db->insert('t_advance_sum', $t_advance_chq);
}


public function update_card($endDate,$cash_crd,$card,$crd_c_note){
   $t_advance_cash_card = array(
     "cl"             =>$this->sd['cl'],
     "bc"             =>$this->sd['branch'],
     "nno"            =>$card,
     "ddate"          =>$_POST['date'],
     "ref_no"         =>$_POST['ref_no'],
     "acc_code"       =>$_POST['customer'],
     "description"    =>"Advance payment for sales order no [".$this->max_no."]",
     "expire_date"    =>$endDate,
     "cash_amount"    =>isset($_POST['cash_ad'])?$_POST['cash_ad']:'',
     "card_amount"    =>isset($_POST['card_ad'])?$_POST['card_ad']:'',                            
     "cheque_amount"  =>'',
     "total_amount"   =>$cash_crd,
     "cn_no"          =>$crd_c_note,
     "so_no"          =>$this->max_no,
     "so_type"        => 1,
     "so_pay_type"    => 1
  );

  $t_credit_note_for_cash_card = array(
    "cl" => $this->sd['cl'],
    "bc" => $this->sd['branch'],
    "nno" => $crd_c_note,
    "ddate" => $_POST['date'],
    "ref_no" => $_POST['ref_no'],
    "memo" => "Advance payment for sales order no - [" . $this->max_no . "]",
    "is_customer" => 1,
    "code" => $_POST['customer'],
    "acc_code" => $this->utility->get_default_acc('STOCK_ACC'),
    "amount" => $cash_crd,
    "oc" => $this->sd['oc'],
    "post" => "",
    "post_by" => "",
    "post_date" => "",
    "is_cancel" => 0,
    "ref_trans_no" => $card,
    "ref_trans_code" => 24,
    "balance"=>$cash_crd
  );

  for($x=0;$x<10;$x++){
    if(isset($_POST['type1_'.$x]) && !empty($_POST['type1_'.$x])){ 
      if(isset($_POST['no1_'.$x]) && !empty($_POST['no1_'.$x])){ 
        if(isset($_POST['amount1_'.$x]) && !empty($_POST['amount1_'.$x])){
          $credit_data[]=array(
            "cl"=>$this->sd['cl'],
            "bc"=>$this->sd['branch'],
            "trans_code"=>24,
            "trans_no"=>$card,
            "card_type"=>$_POST['type1_'.$x],
            "card_no"=>$_POST['no1_'.$x],
            "amount"=>$_POST['amount1_'.$x],
            "int_amount"=>$_POST['amount_rate1_'.$x],
            "rate"=>$_POST['rate1_'.$x],
            "month"=>$_POST['month1_'.$x],
            "bank_id"=>$_POST['bank1_'.$x],
            "merchant_id"=>$_POST['merchant1_'.$x],  
            "acc_code"=>$_POST['acc1_'.$x],   
            "date"=>$_POST['date'],
          );
        }
      } 
    }
  }

  if(isset($credit_data)){
    if(count($credit_data)) {
      $this->db->insert_batch("opt_credit_card_det", $credit_data);
    }
  }

  $this->trans_settlement->save_settlement("t_credit_note_trans", $_POST['customer'], $_POST['date'], 17,$crd_c_note, 24, $card, $cash_crd, "0");

  $this->db->where('nno',$card);
  $this->db->where('cl',$this->sd['cl']);
  $this->db->where('bc',$this->sd['branch']);
  $this->db->update('t_advance_sum', $t_advance_cash_card);

  $this->db->where('ref_trans_no',$crd_c_note);
  $this->db->where('ref_trans_code',24);
  $this->db->where('cl',$this->sd['cl']);
  $this->db->where('bc',$this->sd['branch']);
  $this->db->update('t_credit_note', $t_credit_note_for_cash_card);
}



public function update_chq($endDate,$chq,$chq_c_note){
  $t_advance_chq = array(
     "cl"             =>$this->sd['cl'],
     "bc"             =>$this->sd['branch'],
     "nno"            =>$chq,
     "ddate"          =>$_POST['date'],
     "ref_no"         =>$_POST['ref_no'],
     "acc_code"       =>$_POST['customer'],
     "description"    =>"Advance payment for sales order no [".$this->max_no."]",
     "expire_date"    =>$endDate,
     "cash_amount"    =>'',
     "card_amount"    =>'',                            
     "cheque_amount"  =>$_POST['chq_ad'],
     "total_amount"   =>$_POST['chq_ad'],
     "cn_no"          =>$chq_c_note,
     "so_no"          =>$this->max_no,
     "so_type"        => 1,
     "so_pay_type"    => 2
  );

  $t_credit_note_for_chq = array(
    "cl"              => $this->sd['cl'],
    "bc"              => $this->sd['branch'],
    "nno"             => $chq,
    "ddate"           => $_POST['date'],
    "ref_no"          => $_POST['ref_no'],
    "memo"            => "Advance payment for sales order no - [" . $this->max_no . "]",
    "is_customer"     => 1,
    "code"            => $_POST['customer'],
    "acc_code"        => $this->utility->get_default_acc('STOCK_ACC'),
    "amount"          => $_POST['chq_ad'],
    "oc"              => $this->sd['oc'],
    "post"            => "",
    "post_by"         => "",
    "post_date"       => "",
    "is_cancel"       => 0,
    "ref_trans_no"    => $chq_c_note,
    "ref_trans_code"  => 24,
    "balance"         => $_POST['chq_ad'],
  );
  for($x=0;$x<10;$x++){
    if(isset($_POST['bank9_'.$x]) && !empty($_POST['bank9_'.$x])){ 
      if(isset($_POST['branch9_'.$x]) && !empty($_POST['branch9_'.$x])){ 
        if(isset($_POST['acc9_'.$x]) && !empty($_POST['acc9_'.$x])){
          if(isset($_POST['cheque9_'.$x]) && !empty($_POST['cheque9_'.$x])){
            if(isset($_POST['amount9_'.$x]) && !empty($_POST['amount9_'.$x])){
               $opt_chq_data[]=array(
                "cl"=>$this->sd['cl'],
                "bc"=>$this->sd['branch'],
                "trans_code"=>24,
                "trans_no"=>$chq,
                "bank"=>$_POST['bank9_'.$x],
                "branch"=>$_POST['branch9_'.$x],
                "account_no"=>$_POST['acc9_'.$x],
                "cheque_no"=>$_POST['cheque9_'.$x],
                "amount"=>$_POST['amount9_'.$x],
                "cheque_date"=>$_POST['date9_'.$x],
                );
                        
                $rcv_chq_data[]=array(
                  "cl"=>$this->sd['cl'],
                  "bc"=>$this->sd['branch'],
                  "trans_code"=>24,
                  "trans_no"=>$chq,
                  "bank"=>$_POST['bank9_'.$x],
                  "branch"=>$_POST['branch9_'.$x],
                  "account"=>$_POST['acc9_'.$x],
                  "cheque_no"=>$_POST['cheque9_'.$x],
                  "amount"=>$_POST['amount9_'.$x],
                  "bank_date"=>$_POST['date9_'.$x],
                  "status"=>"P",
                  "received_from_acc"=>$_POST['customer'],
                  "ddate" =>$_POST['date'],
                );
              }
            }  
          }
        } 
      }
   }
  if(isset($opt_chq_data)){
    if(count($opt_chq_data)) {
      $this->db->insert_batch("opt_receive_cheque_det", $opt_chq_data);
    }
  }
  if(isset($rcv_chq_data)){
    if(count($rcv_chq_data)) {
      $this->db->insert_batch("t_cheque_received", $rcv_chq_data);
    }
  }
  $this->trans_settlement->save_settlement("t_credit_note_trans", $_POST['customer'], $_POST['date'], 17, $chq_c_note, 24, $chq, $_POST['chq_ad'],"0");
  
  $this->db->where('nno',$chq);
  $this->db->where('cl',$this->sd['cl']);
  $this->db->where('bc',$this->sd['branch']);
  $this->db->update('t_advance_sum', $t_advance_chq);

  $this->db->where('ref_trans_no',$chq_c_note);
  $this->db->where('ref_trans_code',24);
  $this->db->where('cl',$this->sd['cl']);
  $this->db->where('bc',$this->sd['branch']);
  $this->db->update('t_credit_note', $t_credit_note_for_chq);
}




  public function serial_save_out() {
      if ($_POST['hid'] == "0" || $_POST['hid'] == "") {
        for ($x = 0; $x < 25; $x++) {
          if (isset($_POST['0_'.$x]) && $_POST['rcvqty_'.$x] > 0) {
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
            if (isset($_POST['0_'.$x]) && $_POST['rcvqty_'.$x] > 0) {
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
          if (isset($_POST['0_'.$x]) && $_POST['rcvqty_'.$x] > 0) {
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
            if (isset($_POST['0_'.$x]) && $_POST['rcvqty_'.$x] > 0) {
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
      if (isset($_POST['0_'.$x]) && $_POST['rcvqty_'.$x] > 0) {
        if ($_POST['0_' . $x] != "") {

          $item_code=$_POST['0_'.$x];
          $qty=$_POST['rcvqty_'.$x];
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

  private function set_delete($trans_no){

    $chq=$card=0;

    $sql="SELECT a.`nno` 
      FROM t_so_sum s
      JOIN t_advance_sum a ON a.`cl` = s.`cl` AND a.`bc` = s.`bc` AND a.`so_no` = s.`no`
      WHERE a.`so_type` ='1'
      AND so_pay_type ='1'
      AND a.so_no = '$trans_no' 
      AND a.cl ='".$this->sd['cl']."'
      AND a.bc ='".$this->sd['branch']."'
      ORDER BY a.nno ASC";

    $query=$this->db->query($sql);
    if($query->num_rows()>0){
      $card =  $query->row()->nno;
    }

    $sql5="SELECT a.`nno` 
      FROM t_so_sum s
      JOIN t_advance_sum a ON a.`cl` = s.`cl` AND a.`bc` = s.`bc` AND a.`so_no` = s.`no`
      WHERE a.`so_type` ='1'
      AND so_pay_type ='2'
      AND a.so_no = '$trans_no' 
      AND a.cl ='".$this->sd['cl']."'
      AND a.bc ='".$this->sd['branch']."'
      ORDER BY a.nno ASC";

    $query5=$this->db->query($sql5);
    if($query5->num_rows()>0){
      $chq =  $query5->row()->nno;
    }

    $this->db->where("cl", $this->sd['cl']);
    $this->db->where("bc", $this->sd['branch']);
    $this->db->where("sub_trans_code", 24);
    $this->db->where("sub_trans_no", $card);
    $this->db->delete("t_credit_note_trans");

    $this->db->where("cl", $this->sd['cl']);
    $this->db->where("bc", $this->sd['branch']);
    $this->db->where("sub_trans_code", 24);
    $this->db->where("sub_trans_no", $chq);
    $this->db->delete("t_credit_note_trans");


    $this->db->where("cl", $this->sd['cl']);
    $this->db->where("bc", $this->sd['branch']);
    $this->db->where("trans_code", 24);
    $this->db->where("trans_no", $chq);
    $this->db->delete("opt_receive_cheque_det");

    $this->db->where("cl", $this->sd['cl']);
    $this->db->where("bc", $this->sd['branch']);
    $this->db->where("trans_code", 24);
    $this->db->where("trans_no", $chq);
    $this->db->delete("t_cheque_received");

    $this->db->where("cl", $this->sd['cl']);
    $this->db->where("bc", $this->sd['branch']);
    $this->db->where("trans_code", 24);
    $this->db->where("trans_no", $card);
    $this->db->delete("opt_credit_card_det");

    $this->db->where('no', $this->max_no);
    $this->db->where('cl', $this->sd['cl']);
    $this->db->where('bc',$this->sd['branch']);
    $this->db->delete("t_so_det");

    $this->db->where("no", $this->max_no);
    $this->db->where("cl", $this->sd['cl']);
    $this->db->where("bc", $this->sd['branch']);
    $this->db->delete("t_so_additional_items");

    $this->load->model('trans_settlement');
    $this->trans_settlement->delete_item_movement('t_item_movement',68,$this->max_no);

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
                      gross_amount,
                      additional_amount,
                      discount_amount,
                      net_amount,
                      memo,
                      rep_id,
                      e.`name` AS rep_name,
                      is_cancel,
                      s.pay_cash,
                      s.pay_card,
                      s.pay_cheque,
                      s.pay_tot
            FROM t_so_sum s
            JOIN m_customer c ON s.`cus_id` = c.`code`
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
                      is_free,
                      m.`min_price`,
                      d.advance_amount,
                      d.delivered_qty,
                      d.reserve_qty                      
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

    $chq=$card=0;

    $sql="SELECT a.`nno` 
      FROM t_so_sum s
      JOIN t_advance_sum a ON a.`cl` = s.`cl` AND a.`bc` = s.`bc` AND a.`so_no` = s.`no`
      WHERE a.`so_type` ='1'
      AND so_pay_type ='1'
      AND a.so_no = '".$_POST['no']."' 
      AND a.cl ='".$this->sd['cl']."'
      AND a.bc ='".$this->sd['branch']."'
      ORDER BY a.nno ASC";

    $query=$this->db->query($sql);
    if($query->num_rows()>0){
      $card =  $query->row()->nno;
    }

    $sql5="SELECT a.`nno` 
      FROM t_so_sum s
      JOIN t_advance_sum a ON a.`cl` = s.`cl` AND a.`bc` = s.`bc` AND a.`so_no` = s.`no`
      WHERE a.`so_type` ='1'
      AND so_pay_type ='2'
      AND a.so_no = '".$_POST['no']."' 
      AND a.cl ='".$this->sd['cl']."'
      AND a.bc ='".$this->sd['branch']."'
      ORDER BY a.nno ASC";

    $query5=$this->db->query($sql5);
    if($query5->num_rows()>0){
      $chq =  $query5->row()->nno;
    }


    $this->db->select(array(
        'opt_credit_card_det.card_type',
        'opt_credit_card_det.card_no',
        'opt_credit_card_det.amount',
        'opt_credit_card_det.bank_id',
        'opt_credit_card_det.month',
        'opt_credit_card_det.rate',
        'opt_credit_card_det.int_amount',
        'opt_credit_card_det.merchant_id',
        'opt_credit_card_det.acc_code',
        'm_bank.description'
    ));
     
    $this->db->from('opt_credit_card_det');
    $this->db->join('m_bank', 'm_bank.code = opt_credit_card_det.bank_id');
    $this->db->where('opt_credit_card_det.cl',$this->sd['cl'] );
    $this->db->where('opt_credit_card_det.bc',$this->sd['branch']);
    $this->db->where('opt_credit_card_det.trans_no',$card);
    $this->db->where('opt_credit_card_det.trans_code',24);
    $query=$this->db->get();

    if($query->num_rows()>0){
      $a['opt_credit_card_det']=$query->result();
    }else{
      $a['opt_credit_card_det']=2;
    }

    $this->db->select(array(
        'opt_receive_cheque_det.bank',
        'opt_receive_cheque_det.branch',
        'opt_receive_cheque_det.account_no',
        'opt_receive_cheque_det.cheque_no',
        'opt_receive_cheque_det.amount',
        'opt_receive_cheque_det.cheque_date'  
    ));
     
    $this->db->from('opt_receive_cheque_det');
    $this->db->where('opt_receive_cheque_det.cl',$this->sd['cl'] );
    $this->db->where('opt_receive_cheque_det.bc',$this->sd['branch'] );
    $this->db->where('opt_receive_cheque_det.trans_no',$chq);
    $this->db->where('opt_receive_cheque_det.trans_code',24); 
    $query=$this->db->get();

    if($query->num_rows()>0){
      $a['opt_receive_cheque_det']=$query->result();
    }else{
      $a['opt_receive_cheque_det']=2;
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
        throw new Exception($errLine); 
    }
    set_error_handler('exceptionThrower'); 
    try { 
      if($this->user_permissions->is_delete('t_sales_order')){

        $this->db->where('no', $_POST['id']);
        $this->db->where('cl', $this->sd['cl']);
        $this->db->where('bc',$this->sd['branch']);
        $this->db->update('t_so_sum', array("is_cancel"=>1));
        
        $this->load->model('trans_settlement');
        $this->trans_settlement->delete_item_movement('t_item_movement',68,$_POST['id']);

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

        $chq=$card=0;

        $sql="SELECT a.`nno` 
          FROM t_so_sum s
          JOIN t_advance_sum a ON a.`cl` = s.`cl` AND a.`bc` = s.`bc` AND a.`so_no` = s.`no`
          WHERE a.`so_type` ='1'
          AND so_pay_type ='1'
          AND a.so_no = '".$_POST['id']."' 
          AND a.cl ='".$this->sd['cl']."'
          AND a.bc ='".$this->sd['branch']."'
          ORDER BY a.nno ASC";

        $query=$this->db->query($sql);
        if($query->num_rows()>0){
          $card =  $query->row()->nno;
        }

        $sql5="SELECT a.`nno` 
          FROM t_so_sum s
          JOIN t_advance_sum a ON a.`cl` = s.`cl` AND a.`bc` = s.`bc` AND a.`so_no` = s.`no`
          WHERE a.`so_type` ='1'
          AND so_pay_type ='2'
          AND a.so_no = '".$_POST['id']."' 
          AND a.cl ='".$this->sd['cl']."'
          AND a.bc ='".$this->sd['branch']."'
          ORDER BY a.nno ASC";

        $query5=$this->db->query($sql5);
        if($query5->num_rows()>0){
          $chq =  $query5->row()->nno;
        }else{
          $chq =0;
        }

        $sql2="SELECT nno FROM t_credit_note
                    WHERE cl='".$this->sd['cl']."'
                    and bc='".$this->sd['branch']."'
                    and ref_trans_code='24'
                    and ref_trans_no='$card' 
                    ORDER BY nno";
        $query2=$this->db->query($sql2);
        if($query2->num_rows()>0){
          $crd_c_note =  $query2->row()->nno;
        }

        $sql6="SELECT nno FROM t_credit_note
                  WHERE cl='".$this->sd['cl']."'
                  and bc='".$this->sd['branch']."'
                  and ref_trans_code='24'
                  and ref_trans_no='$chq' 
                  ORDER BY nno";
        $query6=$this->db->query($sql6);
        if($query6->num_rows()>0){
          $chq_c_note =  $query6->row()->nno;
        }else{
          $chq_c_note =0;
        }

        $this->db->where("cl", $this->sd['cl']);
        $this->db->where("bc", $this->sd['branch']);
        $this->db->where("nno", $crd_c_note);
        $this->db->update("t_credit_note",array("is_cancel"=>1));

        $this->db->where("cl", $this->sd['cl']);
        $this->db->where("bc", $this->sd['branch']);
        $this->db->where("nno", $chq_c_note);
        $this->db->update("t_credit_note",array("is_cancel"=>1));

        $this->db->where("cl", $this->sd['cl']);
        $this->db->where("bc", $this->sd['branch']);
        $this->db->where("nno", $card);
        $this->db->update("t_advance_sum",array("is_cancel"=>1));

        $this->db->where("cl", $this->sd['cl']);
        $this->db->where("bc", $this->sd['branch']);
        $this->db->where("nno", $chq);
        $this->db->update("t_advance_sum",array("is_cancel"=>1));

        $this->db->where("cl", $this->sd['cl']);
        $this->db->where("bc", $this->sd['branch']);
        $this->db->where("sub_trans_code", 24);
        $this->db->where("sub_trans_no", $card);
        $this->db->delete("t_credit_note_trans");

        $this->db->where("cl", $this->sd['cl']);
        $this->db->where("bc", $this->sd['branch']);
        $this->db->where("sub_trans_code", 24);
        $this->db->where("sub_trans_no", $chq);
        $this->db->delete("t_credit_note_trans");

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
        echo $e->getMessage()."Operation fail please contact admin"; 
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

        $cl=$this->sd['cl'];
        $branch=$this->sd['branch'];
    
    if($_POST['search'] == 'Key Word: code, name'){$_POST['search'] = "";}
             
     $sql = "SELECT DISTINCT(m_item.code), 
            m_item.`description`,
            m_item.`model`,
            m_item.`max_price`, 
            m_item.`min_price`,
            m_item.purchase_price 
            FROM m_item 
            WHERE  (m_item.`description` LIKE '%$_POST[search]%' 
            OR m_item.`code` LIKE '%$_POST[search]%' 
            OR m_item.model LIKE '$_POST[search]%' 
            OR m_item.`max_price` LIKE '$_POST[search]%'
            OR `m_item`.`min_price` LIKE '$_POST[search]%' 
            OR `m_item`.`max_price` LIKE '$_POST[search]%') 
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
          $a .= "<td style='text-align:right;'>" . $r->max_price . "</td>";
          $a .= "<td style='display:none'>" . $r->min_price . "</td>";
          $a .= "<td style='display:none'>" . $r->purchase_price . "</td>";          
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

    public function get_save_time(){
      $sql="SELECT SUBSTRING(action_date,11) as action_date FROM t_so_sum WHERE no='".$_POST['qno']."' AND cl='".$this->sd['cl']."' AND bc='".$this->sd['branch']."'";
      $query=$this->db->query($sql);

      if ($query->num_rows() > 0) {
          $action_time=$query->first_row()->action_date;
      }
      return $action_time; 
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
    $r_detail['page']="A5";
    $r_detail['header']=$_POST['header'];
    $r_detail['orientation']="L";
     
    $sql_sum="SELECT  cus_id,
                      c.`name` AS cus_name,
                      CONCAT(c.`address1`,', ', c.`address2`,', ',c.`address3`) AS address,
                      store,
                      no,
                      date,
                      ref_no,                     
                      gross_amount,
                      additional_amount,
                      discount_amount,
                      net_amount,
                      memo,
                      rep_id,
                      e.`name` AS rep_name,
                      is_cancel
            FROM t_so_sum s
            JOIN m_customer c ON s.`cus_id` = c.`code`
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
                      d.is_free,
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

    $r_detail['is_cur_time'] = $this->utility->get_cur_time();

      $s_time=$this->utility->save_time();
      if($s_time==1){

      $r_detail['save_time']="  -  ".$this->utility->get_save_time('t_so_sum','action_date',$_POST['qno'],'no');

      }else{
        $r_detail['save_time']="";
      }
    

    $sql_paid="SELECT SUM(pay_cash+pay_cheque+pay_card) AS paid 
                FROM t_so_sum
                WHERE cl='".$this->sd['cl']."' AND bc='".$this->sd['branch']."' AND no='".$_POST['qno']."'";
    $query_paid=$this->db->query($sql_paid);
   
   
      $this->load->view($_POST['by'].'_'.'pdf',$r_detail);
       
  }

public function get_data_print(){

   $a['card']= $a['chq']=0;

   $sql="SELECT a.`nno` ,a.acc_code,a.total_amount as amount,a.ddate  
      FROM t_so_sum s
      JOIN t_advance_sum a ON a.`cl` = s.`cl` AND a.`bc` = s.`bc` AND a.`so_no` = s.`no`
      WHERE a.`so_type` ='1'
      AND so_pay_type ='1'
      AND a.so_no = '".$_POST['no']."' 
      AND a.cl ='".$this->sd['cl']."'
      AND a.bc ='".$this->sd['branch']."'
      ORDER BY a.nno ASC";

    $query=$this->db->query($sql);
    if($query->num_rows()>0){
      $a['card'] =  $query->row()->nno;
      $a['c_amount'] = $query->row()->amount;
      $a['c_acc'] = $query->row()->acc_code;
      $a['c_ddate'] = $query->row()->ddate;
    }

    $sql5="SELECT a.`nno`,a.acc_code,a.cheque_amount as amount,a.ddate 
      FROM t_so_sum s
      JOIN t_advance_sum a ON a.`cl` = s.`cl` AND a.`bc` = s.`bc` AND a.`so_no` = s.`no`
      WHERE a.`so_type` ='1'
      AND so_pay_type ='2'
      AND a.so_no = '".$_POST['no']."' 
      AND a.cl ='".$this->sd['cl']."'
      AND a.bc ='".$this->sd['branch']."'
      ORDER BY a.nno ASC";

    $query5=$this->db->query($sql5);
    if($query5->num_rows()>0){
      $a['chq'] =  $query5->row()->nno;
      $a['chq_amount'] = $query5->row()->amount;
      $a['chq_acc'] = $query5->row()->acc_code;
      $a['chq_ddate'] = $query5->row()->ddate;
    }
    echo json_encode($a);
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


    
public function f1_card_type(){

    $sql = "SELECT * FROM m_credit_card_type  WHERE card_type LIKE '%$_POST[search]%' LIMIT 25";
     
      $query = $this->db->query($sql);
      $a  = "<table id='item_list' style='width : 100%' >";
      $a .= "<thead><tr>";
      $a .= "<th class='tb_head_th'>Type</th>";
      $a .= "</thead></tr><tr class='cl'><td>&nbsp;</td></tr>";

    foreach($query->result() as $r){
      $a .= "<tr class='cl'>";
      $a .= "<td>".$r->card_type."</td>";
      $a .= "</tr>";
    }
      $a .= "</table>";
      echo $a;
  }


public function chek_credit_note_can_edit($so_no,$type){
    $status=1;

    $sql="SELECT  * 
            FROM t_credit_note_trans 
            WHERE so_no = '$so_no' 
              AND so_type = '$type' 
              AND cl = '".$this->sd['cl']."' 
              AND bc = '".$this->sd['branch']."'";

    $query=$this->db->query($sql);
    foreach ($query->result() as $row){
        $sql2="SELECT * 
                FROM t_credit_note_trans
                  WHERE cl='".$this->sd['cl']."'
                  AND bc='".$this->sd['branch']."'
                  AND trans_code='".$row->trans_code."'
                  AND trans_no='".$row->trans_no."'
                  AND sub_trans_code != '".$row->trans_code."'
                  AND sub_trans_no != '".$row->trans_no."'";

        $query2=$this->db->query($sql2);

        if($query2->num_rows()>0){
            $status="This sales order cann't update or delete";
        }
    }    
    return $status;
}

public function load_item_img(){
  $sql="SELECT `name`,picture FROM `m_item_picture`
        WHERE item_code='".$_POST['item']."'";

  $query=$this->db->query($sql);
  if($query->num_rows()>0){
    $a=$query->result();
  }else{
    $a=2;
  }
  echo json_encode($a);
}

public function batch_avbl_qty($item_pre,$batch_pre,$qty_pre){
      $status=1;
      $cl=$this->sd['cl'];
      $bc=$this->sd['branch'];
      $store=$_POST['stores'];
      $table = 't_so_det';

      for($x = 0; $x<25; $x++){
        if(isset($_POST[$item_pre.$x]) && !empty($_POST[$item_pre.$x])) {
            $batch_no=$_POST[$batch_pre.$x];
            $item=$_POST[$item_pre.$x];
            $total_qty=(int)$_POST[$qty_pre.$x];
            $no=$_POST['hid'];


            if(isset($_POST['hid']) && $_POST['hid']=="0"){
              $sql="SELECT IFNULL(SUM(qty_in - qty_out),0) AS qty FROM t_item_movement WHERE batch_no='$batch_no' AND store_code='$store' AND item='$item' AND cl='$cl'  AND bc='$bc'";
              foreach($this->db->query($sql)->result() as $row){
                $actual_qty=(int)$row->qty; 
              }
            
              if($actual_qty<$total_qty){
                $status="This (".$item.") does not have enough quantity in this batch(".$batch_no.")";
              }
        
            }else{

              $sql="SELECT SUM(qry_current_stock.`qty`)+SUM(c.qty) as qty FROM (`qry_current_stock`)  
              INNER JOIN (SELECT qty,code,batch_no,cl,bc FROM $table WHERE  `batch_no` = '$batch_no'  AND  no='$no' AND `code` = '$item') c 
              ON c.code=qry_current_stock.`item` AND c.cl=qry_current_stock.cl AND c.bc=qry_current_stock.bc AND c.batch_no=qry_current_stock.batch_no
              WHERE qry_current_stock.`batch_no` = '$batch_no' AND qry_current_stock.`store_code` = '$store' AND `item` = '$item'";
              
              foreach($this->db->query($sql)->result() as $row){
                $actual_qty=(int)$row->qty; 
              }
            
              if($actual_qty<$total_qty){
                $status="This (".$item.") does not have enough quantity in this batch(".$batch_no.")";
              }
            }
        }
      }
      return $status;
    }

  public function cur_stock(){
    $sql="SELECT * FROM qry_current_stock
          WHERE cl='".$this->sd['cl']."' 
          AND bc='".$this->sd['branch']."' 
          AND store_code='".$_POST['store']."' 
          AND item='".$_POST['code']."' 
          AND batch_no='".$_POST['batch']."'
          LIMIT 1 ";

    $query=$this->db->query($sql);
    if($query->num_rows() > 0){
      $result=$query->result();
    }else{
      $result=2;
    }
    echo json_encode($result);
  }
  public function pop_cus(){

    if($_POST['search'] == 'Key Word: code, name'){$_POST['search'] = "";}
  
        $sql = "SELECT 
        t.`bc`,
        t.`no`,
        t.`date`,
        t.`cus_id`,
        m.`name`,
        m.`nic`

         FROM t_so_sum t 
         JOIN`m_customer` m ON m.`code` = t.`cus_id` 
         WHERE t.`cl`='".$this->sd['cl']."' 
         AND t.`bc` = '".$this->sd['branch']."' 
         AND (t.`cus_id` LIKE '%$_POST[search]%' OR m.`name` LIKE '%$_POST[search]%' OR m.`nic` LIKE '%$_POST[search]%' )
         GROUP BY t.`bc`, t.`cl`,  t.`no` ";



       $query = $this->db->query($sql);
      $a  = "<table id='item_list' style='width : 100%' >";
      $a .= "<thead><tr>";
      $a .= "<th class='tb_head_th'>Date</th>";
      $a .= "<th class='tb_head_th' colspan='1'>No</th>";
      $a .= "<th class='tb_head_th'>Customer ID</th>";
      $a .= "<th class='tb_head_th'>Name </th>";
      $a .= "<th class='tb_head_th'>NIC</th>";
      $a .= "</thead></tr><tr class='cl'><td>&nbsp;</td><td colspan='2'>&nbsp;</td></tr>";

  foreach($query->result() as $r){
      $a .= "<tr class='cl'>";
      $a .= "<td>".$r->date."</td>";
      $a .= "<td class='td1'>".$r->no."</td>";
      $a .= "<td>".$r->cus_id."</td>";
      $a .= "<td>".$r->name."</td>";
      $a .= "<td>".$r->nic."</td>";
      $a .= "</tr>";
    }
      $a .= "</table>";
      echo $a;
  }


}