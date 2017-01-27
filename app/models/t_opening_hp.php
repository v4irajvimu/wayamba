<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class t_opening_hp extends CI_Model {

  private $sd;
  private $mtb;
  private $tb_po_trans;
  private $max_no;
  private $mod = '003';
  private $trans_code="23";
  private $sub_trans_code="23";
  private $qty_out="0";
  private $bcc;
  private $occ;
  private $res4;
  

  function __construct(){
  	parent::__construct();
  	
  	$this->sd = $this->session->all_userdata();
    $this->load->database($this->sd['db'], true);
    $this->mtb = $this->tables->tb['t_po_sum'];
    $this->tb_po_trans= $this->tables->tb['t_po_trans'];
    $this->load->model('user_permissions');
    $this->load->model('utility');
    $this->max_no= $this->opening_hp_max_no("2");
    $this->bcc = $this->sd['branch'];
    $this->occ = $this->sd['oc'];


    //var_dump($max_serial_no);
  }


  public function base_details(){
    $this->load->model('m_stores');
    $a['stores'] = $this->m_stores->select();
    $a['max_no']= $this->opening_hp_max_no("2");
    $a['company'] = $this->s_company->get_company_name();
    $a['cluster']=$this->loder->select();
    $a['use_auto_agr']=$this->is_use_auto_arg();
    $this->load->model('r_sales_category');
    $a['sales_category'] = $this->r_sales_category->select();
    $a["crn_no"] = $this->get_credit_max_no();
    $this->load->model('r_groups');
    $a['groups'] = $this->r_groups->select();
    $a['use_settu'] = $this->is_settu_allow();
    return $a;
  }

  public function get_credit_max_no() {
    if (isset($_POST['hid'])) {
      if ($_POST['hid'] == "0" || $_POST['hid'] == "") {
        $field = "nno";
        $this->db->select_max($field);
        $this->db->where("cl", $this->sd['cl']);
        $this->db->where("bc", $this->sd['branch']);
        return $this->db->get("t_credit_note")->first_row()->$field + 1;
      }else{
        return $_POST['crn_no'];
      }
    }else{
      $field = "nno";
      $this->db->select_max($field);
      $this->db->where("cl", $this->sd['cl']);
      $this->db->where("bc", $this->sd['branch']);
      return $this->db->get("t_credit_note")->first_row()->$field + 1;
    }
  }

  public function load_branch(){
    $this->db->where("cl",$this->sd['cl']);
    $query = $this->db->get('m_branch');

    $A = "<select name='ship_to_bc' id='ship_to_bc'>";
    $B="";
    foreach($query->result() as $r){
      if($r->bc==$this->sd['branch']){
        $C = "<option title='".$r->name."'  value='".$r->bc."' selected='selected'>".$r->bc." | ".$r->name."</option>";
      }else{
        $B .= "<option title='".$r->name."' value='".$r->bc."' >".$r->bc." | ".$r->name."</option>";
      }     
    }       
    $D = "</select>";
    $s = $A.$C.$B.$D;
    return $s;
  }

  public function is_use_auto_arg(){
    $sql="SELECT use_auto_no_format FROM def_option_hp";

    $query=$this->db->query($sql)->row()->use_auto_no_format;

    if($query==1){
      $status="1";
    }else{
      $status="0";
    }
    return $status;
  } 
  
  public function load_cluster(){
    $this->db->select(array("description"));
    $this->db->where("code",$this->sd['cl']);
    return $this->db->get('m_cluster')->row()->description;
  }


  public function validation(){
    $status=1;  
    $check_is_delete = $this->validation->check_is_cancel($this->max_no, 't_hp_sales_sum');
    if ($check_is_delete != 1) {
      return "This HP sale already deleted";
    }
    $customer_validation = $this->validation->check_is_customer($_POST['customer']);
    if ($customer_validation != 1) {
      return "Please enter valid customer";
    }
    $employee_validation = $this->validation->check_is_employer($_POST['sales_rep']);
    if ($employee_validation != 1) {
      return "Please enter valid salesman";
    }
    /*$store_validation = $this->validation->check_item_with_store($_POST['stores'], '0_');
    if ($store_validation != 1) {
        return $store_validation;
    }
    $item_qty_check = $this->chk_item_qty('0_',$_POST['stores'],'7_',$_POST['hid'],'6_');
    if ($item_qty_check != 1) {
        return $item_qty_check;
      }*/
    /*$serial_validation_status = $this->validation->serial_update('0_', '7_',"all_serial_");
    if ($serial_validation_status != 1) {
        return $serial_validation_status;
      }*/
   /* $batch_validation_status = $this->validation->batch_update('0_', '6_', '7_', '8_');
    if ($batch_validation_status != 1) {
        return $batch_validation_status;
      }*/
      $payment_option_validation = $this->validation->payment_option_calculation();
      if ($payment_option_validation != 1) {
        return $payment_option_validation;
      }
      $check_zero_value=$this->validation->empty_net_value($_POST['net_amt']);
      if($check_zero_value!=1){
        return $check_zero_value;
      } 
   /* $account_update = $this->account_update(0);
    if ($account_update != 1) {
      return "Invalid account entries";
    }*/
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
      $this->serial_number("1"); 
      $validation_status=$this->validation();    
      if($validation_status==1){
        $this->credit_max_no = $this->get_credit_max_no();
        $t_hp_sum=array(
         "cl"                 =>$this->sd["cl"],
         "bc"                 =>$this->sd["branch"],
         "ddate"              =>$_POST['date'],
         "nno"                =>$this->max_no,
         "ref_no"             =>$_POST['ref_no'],
         "scheme_id"          =>$_POST['scheme'],
         "category_id"        =>$_POST['category'],
         "agreement_no"       =>$_POST['agreement_no'],
         "agr_serial_no"      =>$this->res4,
         "cus_id"             =>$_POST['customer'],
         "store_id"           =>$_POST['stores'],
         "guarantor_01"       =>$_POST['guarantor_1'],
         "guarantor_02"       =>$_POST['guarantor_2'],
         "rep"                =>$_POST['sales_rep'],
         "memo"               =>$_POST['memo'],
         "category"           =>$_POST['sales_category'],
         "crn_no"             =>$_POST['crn_no'],
         "sub_no"             =>$this->utility->get_max_sales_category2('sub_no','t_hp_sales_sum',$_POST['sales_category1']),
         "group_sale_Id"      =>$_POST['groups'],
         "gross_amount"       =>$_POST['total_amt'],
         "discount"           =>$_POST['tot_dis'],
         "net_amount"         =>$_POST['net_amt'],
         "document_charges"   =>$_POST['document_charges'],
         "balance"            =>$_POST['balance'],
         "no_of_installments" =>$_POST['num_of_installment'],
         "period_by_days"     =>$_POST['period'],
         "installment_amount" =>$_POST['installment'],
         "interest_rate"      =>$_POST['interest_rate'],
         "interest_amount"    =>$_POST['total_interest'],
         "down_payment"       =>$_POST['down_payment'],
         "due_date"           =>$_POST['date'],
         "oc"                 =>$this->sd['oc'],
         "settu_book_edition" =>$_POST['book_no'],
         "settu_category"     =>$_POST['s_cat_hid'],
         "settu_item"         =>$_POST['settu_item'],
         "is_opening_hp"      =>1,
         "balance_to_pay"     =>$_POST['balto_pay'],
         "paid_amount"        =>$_POST['paidto_amt']
         );
        
        $total=(float)"0";
        for ($x = 0; $x < 25; $x++) {
          if (isset($_POST['00_' . $x], $_POST['11_' . $x], $_POST['tt_' . $x])) {
            if ($_POST['00_' . $x] != "" && $_POST['11_' . $x] != "" && $_POST['tt_' . $x] != "") {
              $t_hp_additional_item[] = array(
                "cl" => $this->sd["cl"],
                "bc" => $this->sd['branch'],
                "nno" => $this->max_no,
                "type" => $_POST['00_' . $x],
                "rate_p" => $_POST['11_' . $x],
                "amount" => $_POST['tt_' . $x]
                );
            }
          }
        }

        $subs="";
        if($_POST['groups']!='0'){
          $group=$_POST['groups'];
        }else{
          $group =$this->utility->default_group();
        }  
        for($x = 0; $x<25; $x++){
          if(isset($_POST['0_'.$x],$_POST['2_'.$x],$_POST['7_'.$x])){
            if($_POST['0_'.$x] != "" && $_POST['2_'.$x] != "" && $_POST['7_'.$x] != "" ){

              $balance="0";
              $c =$_POST['bal_tot_' . $x];
              $d = explode("-",$c);


              if(isset($d[0])) {
               $balance = $d[0];
             }
             if(isset($d[1])) {
               $tot =(float)$d[1];
               $total=$total+$tot;
             }

             $t_hp_det[]= array(
              "cl"=>$this->sd["cl"],
              "bc"=>$this->bcc,
              "nno"=>$this->max_no,
              "item_code"=>$_POST['0_'.$x],
              "batch_no"=>$_POST['6_'.$x],
              "qty"=>$_POST['7_'.$x],
              "sales_price"=>$_POST['2_'.$x],
              "pur_price"=>$this->utility->get_cost_price($_POST['0_' . $x]),
              "min_price"=>$this->utility->get_min_price($_POST['0_' . $x]),
              "avg_price"=>$this->utility->get_cost_price($_POST['0_' . $x]),
              "amount"=>$_POST['4_'.$x],
              "discount_pre"=>$_POST['9_'.$x],
              "discount"=>$_POST['3_'.$x],
              "foc"=>$_POST['8_'.$x],
              "is_free"=>$_POST['f_'.$x],
              "free_balance"=>$balance,
              "foc_tot"=>$_POST['tot_free'],
              "warenty"=>$_POST['5_'.$x],
              ); 
           }
         }
       }

       $t_credit_note = array(
        "cl" => $this->sd['cl'],
        "bc" => $this->sd['branch'],
        "nno" => $this->credit_max_no,
        "ddate" => $_POST['date'],
        "ref_no" => $_POST['ref_no'],
        "memo" => "FREE ISSUE ITEM - HP_SALES - [" . $this->max_no . "]",
        "is_customer" => 1,
        "code" => $_POST['customer'],
        "acc_code" => $this->utility->get_default_acc('STOCK_ACC'),
        "amount" => $total,
        "oc" => $this->sd['oc'],
        "post" => "",
        "post_by" => "",
        "post_date" => "",
        "is_cancel" => 0,
        "ref_trans_no" => $this->max_no,
        "ref_trans_code" => 6,
        "balance"=>$total
        );

       $num_ins=$_POST['num_of_installment'];
       $num_of_installment=($num_ins+1);

       for ($x = 0; $x < $num_of_installment; $x++) {
        if (isset($_POST['duedate_'.$x], $_POST['installment_'.$x], $_POST['capital_'.$x], $_POST['interest_'.$x],$_POST['agreement_no'],$_POST['no_'.$x])) {
          if ($_POST['duedate_'.$x] != "" && $_POST['installment_'.$x] != "" && $_POST['capital_'.$x] != ""&& $_POST['interest_'.$x] != "" && $_POST['agreement_no']!= ""&& $_POST['no_'.$x]) {
            $t_hp_installement_schedual[] = array(
              "cl" => $this->sd["cl"],
              "bc" => $this->sd['branch'],
              "trans_no" => $this->max_no,
              "agr_no" => $_POST['agreement_no'],
              "ins_no" => $_POST['no_'.$x],
              "ins_paid" => "",
              "capital_paid" => "",
              "int_paid" => "",
              "penalty_amount" => "",
              "penalty_paid" => "",
              "due_date" => $_POST['duedate_'.$x],
              "ins_amount" => $_POST['installment_'.$x],
              "capital_amount" => $_POST['capital_'.$x],
              "int_amount" => $_POST['interest_'.$x]
              );
          }
        }
      }

      for ($x = 1; $x < $num_of_installment; $x++) {
        if (isset($_POST['duedate_'.$x], $_POST['installment_'.$x], $_POST['capital_'.$x], $_POST['interest_'.$x],$_POST['agreement_no'],$_POST['no_'.$x],$_POST['paid_'.$x])) {
          if ($_POST['duedate_'.$x] != "" && $_POST['installment_'.$x] != "" && $_POST['capital_'.$x] != ""&& $_POST['interest_'.$x] != "" && $_POST['agreement_no']!= "" && $_POST['paid_'.$x] > 0) {  

            $paid    =(float)$_POST['paid_'.$x];
            $interest=(float)$_POST['interest_'.$x];
            $capital =(float)$_POST['capital_'.$x];
            $balance =(float)0;
            $pay_int =(float)0;
            $pay_cap =(float)0;

            if($paid>=$interest){
              $pay_int = $interest;
              $balance = $paid - $interest;
            }else{
              $pay_int = $paid;
              $balance = 0;
            }

            if($balance>=$capital){
              $pay_cap = $capital;
              $balance = $balance - $capital;
            }else{
              $pay_cap = $balance;
              $balance = 0;
            }

            $ins_trans_capital[] = array(
              "cl" => $this->sd['cl'],
              "bc" => $this->sd['branch'],
              "sub_cl" => $this->sd['cl'],
              "sub_bc" => $this->sd['branch'],
              "ddate" => $_POST['date'],
              "agr_no" => $_POST['agreement_no'],
              "acc_code" => $_POST['customer'],
              "due_date" => $_POST['duedate_'.$x],
              "trans_code" => 6,
              "trans_no" => $this->max_no,
              "sub_trans_code" =>'' ,
              "sub_trans_no" => '',
              "ins_trans_code" => 1,
              "ins_no" => $_POST['no_'.$x],
              "cr" => $pay_cap,
              "oc" => $this->sd['oc']
              );

            $ins_trans_interest[] = array(
              "cl" => $this->sd['cl'],
              "bc" => $this->sd['branch'],
              "sub_cl" => $this->sd['cl'],
              "sub_bc" => $this->sd['branch'],
              "ddate" => $_POST['date'],
              "agr_no" => $_POST['agreement_no'],
              "acc_code" => $_POST['customer'],
              "due_date" => $_POST['duedate_'.$x],
              "trans_code" => 6,
              "trans_no" => $this->max_no,
              "sub_trans_code" =>'' ,
              "sub_trans_no" => '',
              "ins_trans_code" => 2,
              "ins_no" => $_POST['no_'.$x],
              "cr" => $pay_int,
              "oc" => $this->sd['oc']
              );
          }
        }
      }

      $down_pay = array(
        "bc" => $this->sd['branch'],
        "cl" => $this->sd['cl'],
        "ddate" => $_POST['date'],
        "agr_no" => $_POST['agreement_no'],
        "acc_code" => $_POST['customer'],
        "due_date" => $_POST['date'], 
        "trans_code" => 6,      
        "trans_no" => $this->max_no,   
        "ins_trans_code" => 5,  
        "dr" => $_POST['down_payment'], 
        "oc" => $this->sd['oc'] 
        );

      $document_pay = array(
        "bc" => $this->sd['branch'],
        "cl" => $this->sd['cl'],
        "ddate" => $_POST['date'],
        "agr_no" => $_POST['agreement_no'],
        "acc_code" => $_POST['customer'],
        "due_date" => $_POST['date'], 
        "trans_code" => 6,      
        "trans_no" => $this->max_no,   
        "ins_trans_code" => 4,  
        "dr" => $_POST['document_charges'], 
        "oc" => $this->sd['oc'] 
        );

      if($_POST['hid'] == "0" || $_POST['hid'] == ""){
        $this->load->model('trans_settlement');
        if($this->user_permissions->is_add('t_opening_hp')){
          $account_update=$this->account_update(0);
          if($account_update==1){
            $this->db->insert("t_hp_sales_sum",  $t_hp_sum);          

            if($_POST['down_payment']>0){
              $this->db->insert("t_ins_trans", $down_pay); 
            }    

            if($_POST['document_charges']>0){
              $this->db->insert("t_ins_trans", $document_pay); 
            }  

            if(count($t_hp_det)){$this->db->insert_batch("t_hp_sales_det",$t_hp_det);}

            if(isset($t_hp_additional_item)) {
              if(count($t_hp_additional_item)) {
                $this->db->insert_batch("t_hp_additional_item", $t_hp_additional_item);
              }
            }
            if(isset($t_hp_installement_schedual)) {
              if(count($t_hp_installement_schedual)) {
                $this->db->insert_batch("t_ins_schedule", $t_hp_installement_schedual);
              }
            }

            if(isset($ins_trans_capital)) {
              if(count($ins_trans_capital)) {
                $this->db->insert_batch("t_ins_trans", $ins_trans_capital);
              }
            }

            if(isset($ins_trans_interest)) {
              if(count($ins_trans_interest)) {
                $this->db->insert_batch("t_ins_trans", $ins_trans_interest);
              }
            }

            if($total!=0){
              $this->trans_settlement->save_settlement("t_credit_note_trans", $_POST['customer'], $_POST['date'], 17, $this->credit_max_no, 6, $this->max_no, $total, "0");
              $this->db->insert('t_credit_note', $t_credit_note);
            }

            /*if($_POST['df_is_serial']=='1'){
              $this->serial_save();    
            }
            $this->save_sub_items();*/
            $this->account_update(1);
            
            $this->utility->update_debit_note_balance($_POST['customer']);
            $this->utility->update_credit_note_balance($_POST['customer']); 

            $this->utility->save_logger("SAVE",6,$this->max_no,$this->mod);
            echo $this->db->trans_commit();
          }else{
            echo "Invalid account entries";
            $this->db->trans_commit();
          }
        }else{
          $this->db->trans_commit();
          echo "No permission to save records";
        }
      }else{
        if($this->user_permissions->is_edit('t_opening_hp')){
          $this->load->model('trans_settlement');
          $account_update=$this->account_update(0);
          if($account_update==1){
            $this->db->where('nno',$_POST['hid']);
            $this->db->where("cl", $this->sd['cl']);
            $this->db->where("bc", $this->sd['branch']);
            $this->db->update("t_hp_sales_sum", $t_hp_sum);

            $this->set_delete();

            if(count($t_hp_det)){$this->db->insert_batch("t_hp_sales_det",$t_hp_det);}
            if($_POST['down_payment']>0){
              $this->db->insert("t_ins_trans", $down_pay); 
            }    

            if($_POST['document_charges']>0){
              $this->db->insert("t_ins_trans", $document_pay); 
            } 
            if(isset($t_hp_additional_item)) {
              if(count($t_hp_additional_item)) {
                $this->db->insert_batch("t_hp_additional_item", $t_hp_additional_item);
              }
            }     
            if(isset($t_hp_installement_schedual)) {
              if(count($t_hp_installement_schedual)) {
               $this->db->insert_batch("t_ins_schedule", $t_hp_installement_schedual);
             }
           }

           if(isset($ins_trans_capital)) {
            if(count($ins_trans_capital)) {
              $this->db->insert_batch("t_ins_trans", $ins_trans_capital);
            }
          }

          if(isset($ins_trans_interest)) {
            if(count($ins_trans_interest)) {
              $this->db->insert_batch("t_ins_trans", $ins_trans_interest);
            }
          }

            /*if($_POST['df_is_serial']=='1'){
              $this->serial_save();    
            }
            $this->save_sub_items();*/
            $this->account_update(1);

            $this->trans_settlement->delete_settlement("t_credit_note_trans", 17, $this->credit_max_no);
            
            if($total!=0 && $_POST['crn_no_hid']!=0){
              $this->trans_settlement->save_settlement("t_credit_note_trans", $_POST['customer'], $_POST['date'], 17, $this->credit_max_no, 6, $this->max_no, $total, "0");
            } 
            if($_POST['crn_no_hid']!=0){ 
              $sql="select * from t_credit_note where nno='".$this->credit_max_no."'
              AND cl='".$this->sd['cl']."'
              AND bc='".$this->sd['branch']."'";
              $num = $this->db->query($sql)->num_rows();
              
              if($num>0){
                $countt=1;
              }else{
                $countt=0;
              }
              if($_POST['crn_no_hid']!=0){
                if($countt==1){
                  $this->db->where("cl", $this->sd['cl']);
                  $this->db->where("bc", $this->sd['branch']);
                  $this->db->where('nno', $this->credit_max_no);
                  $this->db->update('t_credit_note', $t_credit_note);
                }else{
                  $this->db->insert('t_credit_note', $t_credit_note);  
                }
              }else{
                $this->db->insert('t_credit_note', $t_credit_note);
              }
            }
            $this->utility->update_debit_note_balance($_POST['customer']);
            $this->utility->update_credit_note_balance($_POST['customer']);  
            $this->utility->save_logger("EDIT",6,$this->max_no,$this->mod);               
            echo $this->db->trans_commit();
          }else{
            echo "Invalid account entries";
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

  $sql = "SELECT name from m_customer where code = '".$_POST['customer']."' LIMIT 1";
  $cus_name = $this->db->query($sql)->first_row()->name;
  $des = "HP Sale - " .$cus_name;

  $this->load->model('account');
  $this->account->set_data($config);

  $total_discount=$_POST['tot_dis'];
  $total_amount=$_POST['total_amt2'];

  //-----------stock--------------
  $acc_code=$this->utility->get_default_acc('HP_STOCK');
  $this->account->set_value2($des, $_POST['total_amt'], "dr", $acc_code,$condition);

  $acc_code=$this->utility->get_default_acc('HP_REVENUE');
  $this->account->set_value2($des, $_POST['total_amt'], "cr", $acc_code,$condition);

  //-----------Interest--------------
  $acc_code=$this->utility->get_default_acc('HP_STOCK');
  $this->account->set_value2($des, $_POST['total_interest'], "dr", $acc_code,$condition);

  $acc_code=$this->utility->get_default_acc('HP_INTEREST_SUSPENSE ');
  $this->account->set_value2($des, $_POST['total_interest'], "cr", $acc_code,$condition);

  //-----------Other Chargers--------------
  $acc_code=$_POST['customer'];
  $this->account->set_value2($des, $_POST['document_charges'], "dr", $acc_code,$condition);

  $acc_code=$this->utility->get_default_acc('HP_OTHER_CHARGER_ACC');
  $this->account->set_value2($des, $_POST['document_charges'], "cr", $acc_code,$condition);

  //-----------Down Payment--------------
  $acc_code=$_POST['customer'];
  $this->account->set_value2($des, $_POST['down_payment'], "dr", $acc_code,$condition);

  $acc_code=$this->utility->get_default_acc('HP_STOCK');
  $this->account->set_value2($des, $_POST['down_payment'], "cr", $acc_code,$condition);

  //-----------Cost Of Value--------------
  $total_item_cost=0;
  for($x=0;$x<25;$x++){
    if(isset($_POST['0_' . $x])){
      $total_item_cost=$total_item_cost+(($_POST['7_' . $x])*(double)$this->utility->get_cost_price($_POST['0_'.$x]));
    }
  }    

  $acc_code=$this->utility->get_default_acc('HP_STOCK');
  $this->account->set_value2($des, $total_item_cost, "cr", $acc_code,$condition);

  $acc_code=$this->utility->get_default_acc('COST_OF_SALES');
  $this->account->set_value2($des, $total_item_cost, "dr", $acc_code,$condition);

  for($x = 0; $x<25; $x++){
    if(isset($_POST['00_'.$x]) && isset($_POST['tt_'.$x])){
      if(!empty($_POST['00_'.$x]) && !empty($_POST['tt_'.$x])){

        $sql="select is_add,account,description from r_additional_item where code ='".$_POST['00_'.$x]."'";

        $query   =$this->db->query($sql);

        $con     =$query->row()->is_add;
        $dess    =$query->row()->description;   
        $acc_code=$query->row()->account;

        if($con=="1"){
         $this->account->set_value2($dess,$_POST['tt_'.$x], "cr", $acc_code,$condition); 
         $acc_c=$this->utility->get_default_acc('HP_STOCK');
         $this->account->set_value2($dess,$_POST['tt_'.$x], "dr", $acc_c,$condition);  
       }elseif($con=="0"){
         $this->account->set_value2($dess,$_POST['tt_'.$x], "dr", $acc_code,$condition); 
         $acc_c=$this->utility->get_default_acc('HP_STOCK');
         $this->account->set_value2($dess,$_POST['tt_'.$x], "cr", $acc_c,$condition);
       }elseif($condition=="0"){
         $this->account->set_value2($dess,$_POST['tt_'.$x], "dr", $acc_code,$condition); 
         $acc_c=$this->utility->get_default_acc('HP_STOCK');
         $this->account->set_value2($dess,$_POST['tt_'.$x], "cr", $acc_c,$condition);   
       }
     }
   }
 }  


 if($_POST['tot_dis']>0){
  $acc_code = $this->utility->get_default_acc('SALES_DISCOUNT');
  $this->account->set_value2("HP Sales Discount", $_POST['tot_dis'], "dr", $acc_code,$condition);

  $acc_code=$this->utility->get_default_acc('HP_REVENUE');
  $this->account->set_value2($des, $_POST['tot_dis'], "cr", $acc_code,$condition);
}
  /*$acc_code = $this->utility->get_default_acc('CASH_SALES');
  $this->account->set_value2($des, $total_amount, "cr", $acc_code,$condition);*/
  
  
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

public function serial_save() {

  if ($_POST['hid'] == "0" || $_POST['hid'] == "") {
    for ($x = 0; $x < 25; $x++) {
      if (isset($_POST['0_' . $x])) {
        if ($_POST['0_' . $x] != "" || !empty($_POST['0_' . $x])) {
          if ($this->check_is_serial_items($_POST['0_'.$x]) == 1) {
            $serial = $_POST['all_serial_'.$x];
            $p=explode(",",$serial);
            for($i=0; $i<count($p); $i++){
              if ($_POST['hid'] == "0" || $_POST['hid'] == "") {

                $t_seriall = array(
                  "engine_no" => "",
                  "chassis_no" => '',
                  "out_doc" => 6,
                  "out_no" => $this->max_no,
                  "out_date" => $_POST['date'],
                  "available" => '0'
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
                  "trans_type" => 6,
                  "trans_no" => $this->max_no,
                  "item" => $_POST['0_' . $x],
                  "batch_no" => $this->get_batch_serial_wise($_POST['0_' . $x], $p[$i]),
                  "serial_no" => $p[$i],
                  "qty_in" => 0,
                  "qty_out" => 1,
                  "cost" => $_POST['2_' . $x],
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
   $this->db->where("out_doc", 6);
   $this->db->update("t_serial", $t_serial);

   $this->db->select(array('item', 'serial_no'));
   $this->db->where("trans_no", $this->max_no);
   $this->db->where("trans_type", 6);
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
   $this->db->where("trans_type", 6);
   $this->db->delete("t_serial_movement");

   $this->db->where("cl", $this->sd['cl']);
   $this->db->where("bc",$this->sd['branch']);
   $this->db->where("trans_no", $this->max_no);
   $this->db->where("trans_type", 6);
   $this->db->delete("t_serial_movement_out");


   for ($x = 0; $x < 25; $x++) {
    if (isset($_POST['0_' . $x])) {
      if ($_POST['0_' . $x] != "" || !empty($_POST['0_' . $x])) {
       if ($this->check_is_serial_items($_POST['0_' . $x]) == 1) {
        $serial = $_POST['all_serial_'.$x];
        $p=explode(",",$serial);
        for($i=0; $i<count($p); $i++){

         $t_seriall = array(
           "engine_no" => "",
           "chassis_no" => '',
           "out_doc" => 6,
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
           "trans_type" => 6,
           "trans_no" => $this->max_no,
           "item" => $_POST['0_'.$x],
           "batch_no" => $this->get_batch_serial_wise($_POST['0_'.$x], $p[$i]),
           "serial_no" => $p[$i],
           "qty_in" => 0,
           "qty_out" => 1,
           "cost" => $_POST['2_' . $x],
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

public function save_sub_items(){

  if($_POST['groups']!='0'){
    $group=$_POST['groups'];
  }else{
    $group=$this->utility->default_group();
  }

  for ($x = 0; $x < 25; $x++) {
    if (isset($_POST['0_' . $x])) {
      if ($_POST['0_' . $x] != "") {

        $item_code=$_POST['0_'.$x];
        $qty=$_POST['7_'.$x];
        $batch=$_POST['6_'.$x];
        $date=$_POST['date'];
        $store=$_POST['stores'];
        $price=$_POST['2_'.$x];
        $max=$this->max_no;

        $sql="SELECT s.sub_item , r.qty 
        FROM t_item_movement_sub s
        JOIN r_sub_item r ON r.`code`=s.`sub_item`
        WHERE s.`item`='$item_code' AND s.cl='".$this->sd['cl']."' AND s.bc ='".$this->sd['branch']."' AND s.`batch_no`='$batch' 
        GROUP BY r.`code`";
        $query=$this->db->query($sql);

        foreach($query->result() as $row) {
          $total_qty=$qty*(int)$row->qty;
          $t_sub_item_movement[] = array(
            "cl" => $this->sd['cl'],
            "bc" => $this->sd['branch'],
            "item" => $item_code,
            "sub_item"=>$row->sub_item,
            "trans_code" => 6,
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
            "group_sale_id" => $group,
            );
        }

      }
    }
  }
  if ($_POST['hid'] == "0" || $_POST['hid'] == "") {
    if(isset($t_sub_item_movement)){if(count($t_sub_item_movement)){$this->db->insert_batch("t_item_movement_sub",$t_sub_item_movement);}}
  }else{
    $this->db->where("cl", $this->sd['cl']);
    $this->db->where("bc", $this->sd['branch']);
    $this->db->where("trans_code", 6);
    $this->db->where("trans_no", $_POST['hid']);
    $this->db->delete("t_item_movement_sub");

    if(isset($t_sub_item_movement)){if(count($t_sub_item_movement)){$this->db->insert_batch("t_item_movement_sub",$t_sub_item_movement);}}
  }   

}

public function PDF_report(){

  $this->db->select(array('name', 'address', 'tp', 'fax','email'));
  $this->db->where("bc", $this->sd['branch']);
  $r_detail['branch'] = $this->db->get('m_branch')->result();

  $r_detail['type'] = $_POST['type'];
  $r_detail['dt'] = $_POST['dt'];
  $r_detail['qno'] = $_POST['qno'];

  $r_detail['page'] = $_POST['page'];
  $r_detail['header'] = $_POST['header'];
  $r_detail['orientation'] = $_POST['orientation'];

  $this->db->select(array('code', 'name', 'address1', 'address2', 'address3'));
  $this->db->where("code", $_POST['cus_id']);
  $r_detail['customer'] = $this->db->get('m_customer')->result();

  $this->db->select(array('name'));
  $this->db->where("code", $_POST['salesp_id']);
  $query = $this->db->get('m_employee');

  foreach ($query->result() as $row) {
    $r_detail['employee'] = $row->name;
  }

  $sql="SELECT `t_hp_sales_det`.`item_code` as code, 
  `t_hp_sales_det`.`qty`, 
  `t_hp_sales_det`.`discount`, 
  `t_hp_sales_det`.`sales_price` as price, 
  `t_hp_sales_det`.`amount`, 
  `t_hp_sales_det`.`is_free`, 
  `m_item`.`description`, 
  `m_item`.`model`, 
  c.`cc` AS sub_item,
  c.`deee` AS des,
  c.qty *  t_hp_sales_det.qty as sub_qty
  FROM (`t_hp_sales_det`) 
  JOIN `m_item` ON `m_item`.`code` = `t_hp_sales_det`.`item_code` 
  LEFT JOIN `m_item_sub` ON `m_item_sub`.`item_code` = `m_item`.`code` 
  LEFT JOIN `r_sub_item` ON `r_sub_item`.`code` = `m_item_sub`.`sub_item` 
  LEFT JOIN (
  SELECT t_hp_sales_det.`item_code`, 
  r_sub_item.`description` AS deee, 
  r_sub_item.`code` AS cc,
  r_sub_item.`qty` AS qty,
  t_item_movement_sub.cl,
  t_item_movement_sub.bc,
  t_item_movement_sub.item,
  t_item_movement_sub.`sub_item` 
  FROM t_item_movement_sub 
  LEFT JOIN t_hp_sales_det ON t_hp_sales_det.`item_code` = t_item_movement_sub.`item`  
  AND t_hp_sales_det.`cl` = t_item_movement_sub.`cl` AND t_hp_sales_det.`bc`=t_item_movement_sub.`bc`
  JOIN r_sub_item ON t_item_movement_sub.`sub_item` = r_sub_item.`code`
  WHERE t_item_movement_sub.batch_no = t_hp_sales_det.`batch_no` AND `t_hp_sales_det`.`cl` = '".$this->sd['cl']."'  
  AND `t_hp_sales_det`.`bc` = '".$this->sd['branch']."' AND `t_hp_sales_det`.`nno` = '".$_POST['qno']."'  )c ON c.item_code = t_hp_sales_det.`item_code`
  WHERE `t_hp_sales_det`.`cl` = '".$this->sd['cl']."' 
  AND `t_hp_sales_det`.`bc` = '".$this->sd['branch']."'
  AND `t_hp_sales_det`.`nno` = '".$_POST['qno']."'  
  GROUP BY c.cc ,t_hp_sales_det.`item_code`
  ORDER BY `t_hp_sales_det`.`auto_no` ASC ";

  $query = $this->db->query($sql);
  $r_detail['items'] = $this->db->query($sql)->result();

  $this->db->select(array('interest_amount','net_amount','down_payment','document_charges','balance','no_of_installments','installment_amount'));
  $this->db->from('t_hp_sales_sum');
  $this->db->join('t_hp_sales_det', 't_hp_sales_det.nno=t_hp_sales_sum.nno');
  $this->db->where('t_hp_sales_sum.bc', $this->sd['branch']);
  $this->db->where('t_hp_sales_sum.cl', $this->sd['cl']);
  $this->db->where('t_hp_sales_sum.nno', $_POST['qno']);
  $r_detail['amount'] = $this->db->get()->result();

  $this->db->select(array('t_hp_additional_item.type', 't_hp_additional_item.amount', 'r_additional_item.description', 'r_additional_item.is_add'));
  $this->db->from('t_hp_additional_item');
  $this->db->join('r_additional_item', 't_hp_additional_item.type=r_additional_item.code');
  $this->db->where('t_hp_additional_item.bc', $this->sd['branch']);
  $this->db->where('t_hp_additional_item.cl', $this->sd['cl']);
  $this->db->where('t_hp_additional_item.nno', $_POST['qno']);
  $r_detail['additional'] = $this->db->get()->result();


  $this->db->select_sum("discount");
  $this->db->where('cl', $this->sd['cl']);
  $this->db->where('bc', $this->sd['branch']);
  $this->db->where('nno', $_POST['qno']);
  $r_detail['discount'] = $this->db->get('t_hp_sales_det')->result();

  $this->db->select(array('loginName'));
  $this->db->where('cCode', $this->sd['oc']);
  $r_detail['user'] = $this->db->get('users')->result();

  $r_detail['is_cur_time'] = $this->utility->get_cur_time();

  $s_time=$this->utility->save_time();
  if($s_time==1){
    $r_detail['save_time']="  -  ".$this->utility->get_save_time('t_hp_sales_sum','action_date',$_POST['qno'],'nno');

  }else{
    $r_detail['save_time']="";
  }    


  $this->load->view($_POST['by'] . '_' . 'pdf', $r_detail);
}


private function set_delete(){
  $this->db->where("nno", $this->max_no);
  $this->db->where("cl", $this->sd["cl"]);
  $this->db->where("bc", $this->sd['branch']);
  $this->db->delete("t_hp_sales_det");

  $this->db->where("nno", $this->max_no);
  $this->db->where("cl", $this->sd["cl"]);
  $this->db->where("bc", $this->sd['branch']);
  $this->db->delete("t_hp_additional_item");

  $this->db->where("trans_no", $this->max_no);
  $this->db->where("cl", $this->sd["cl"]);
  $this->db->where("bc", $this->sd['branch']);
  $this->db->delete("t_ins_schedule");

  $this->db->where("trans_no", $this->max_no);
  $this->db->where("trans_code", 6);
  $this->db->where("cl", $this->sd["cl"]);
  $this->db->where("bc", $this->sd['branch']);
  $this->db->delete("t_ins_trans");

}

public function check_code(){
 $this->db->where('code', $_POST['code']);
 $this->db->limit(1);

 echo $this->db->get($this->mtb)->num_rows;
}

public function load(){

  $x=0;  

  $this->db->select(array(
    't_hp_sales_sum.cl',
    't_hp_sales_sum.bc',
    't_hp_sales_sum.ddate',
    't_hp_sales_sum.nno',
    't_hp_sales_sum.ref_no',
    't_hp_sales_sum.scheme_id',
    'm_hp_payment_scheme.description as scheme_des',
    't_hp_sales_sum.category_id',
    'm_hp_sales_category.description as cat_des',
    't_hp_sales_sum.agreement_no',
    't_hp_sales_sum.cus_id',
    'm_customer.name',
    't_hp_sales_sum.store_id',
    'm_stores.description as store_des',
    't_hp_sales_sum.guarantor_01',
    'g_01.name as g1',
    't_hp_sales_sum.guarantor_02',
    'g_02.name as g2',
    't_hp_sales_sum.guarantor_02',
    't_hp_sales_sum.gross_amount',
    't_hp_sales_sum.discount',
    't_hp_sales_sum.net_amount',
    't_hp_sales_sum.document_charges',
    't_hp_sales_sum.balance',
    't_hp_sales_sum.is_cancel',
    't_hp_sales_sum.no_of_installments',
    't_hp_sales_sum.period_by_days',
    't_hp_sales_sum.installment_amount',
    't_hp_sales_sum.interest_rate',
    't_hp_sales_sum.interest_amount',
    't_hp_sales_sum.down_payment',
    't_hp_sales_sum.crn_no',
    't_hp_sales_sum.group_sale_Id',
    't_hp_sales_sum.category',
    't_hp_sales_sum.memo',
    't_hp_sales_sum.sub_no',
    't_hp_sales_sum.rep',
    't_hp_sales_sum.is_opening_hp',
    't_hp_sales_sum.balance_to_pay',
    't_hp_sales_sum.paid_amount',
    't_hp_sales_sum.foc_tot',
    'm_employee.name as e_name',
    't_hp_sales_sum.settu_book_edition',
    't_hp_sales_sum.settu_category as hid_s_cat',
    't_hp_sales_sum.settu_item',
    'm_settu_book_edition.description as b_name',
    'm_settu_item_category.code as s_cat',
    'm_settu_item_category.name as s_cat_name',
    'm_settu_item_sum.name as settu_name'  
    ));

  $this->db->from('t_hp_sales_sum');
  $this->db->join('m_hp_payment_scheme', 'm_hp_payment_scheme.code=t_hp_sales_sum.scheme_id');
  $this->db->join('m_hp_sales_category', 'm_hp_sales_category.code=t_hp_sales_sum.category_id');
  $this->db->join('m_customer', 'm_customer.code=t_hp_sales_sum.cus_id');
  $this->db->join('m_employee', 'm_employee.code=t_hp_sales_sum.rep');
  $this->db->join('m_guarantor as g_01', 'g_01.code=t_hp_sales_sum.guarantor_01');
  $this->db->join('m_guarantor as g_02', 'g_02.code=t_hp_sales_sum.guarantor_02',"left");
  $this->db->join('m_stores', 'm_stores.code=t_hp_sales_sum.store_id');
  $this->db->join('m_settu_book_edition', 'm_settu_book_edition.code=t_hp_sales_sum.settu_book_edition','left');
  $this->db->join('m_settu_item_category', 'm_settu_item_category.ref_code=t_hp_sales_sum.settu_category','left');
  $this->db->join('m_settu_item_sum', 'm_settu_item_sum.code=t_hp_sales_sum.settu_item','left');
  $this->db->where('t_hp_sales_sum.bc', $this->sd['branch']);
  $this->db->where('t_hp_sales_sum.cl', $this->sd['cl']);
  $this->db->where('t_hp_sales_sum.nno', $_POST['id']);
  $query = $this->db->get();

  if($query->num_rows()>0){
    $a['sum']=$query->result();
  }else{
   $x=2;
 } 

 $this->db->select(array(
  't_hp_sales_det.item_code',
  'm_item.description',
  'm_item.model',
  't_hp_sales_det.batch_no',
  't_hp_sales_det.qty',
  't_hp_sales_det.foc',
  't_hp_sales_det.sales_price',
  't_hp_sales_det.discount',
  't_hp_sales_det.discount_pre',                    
  't_hp_sales_det.amount',
  't_hp_sales_det.warenty',
  't_hp_sales_det.is_free',
  't_hp_sales_det.free_balance',

  ));

 $this->db->from('t_hp_sales_det');
 $this->db->join('m_item', 'm_item.code=t_hp_sales_det.item_code','left');
 $this->db->where('t_hp_sales_det.bc', $this->sd['branch']);
 $this->db->where('t_hp_sales_det.cl', $this->sd['cl']);
 $this->db->where('t_hp_sales_det.nno', $_POST['id']);
 $this->db->order_by('t_hp_sales_det.auto_no', "asc");
 $query = $this->db->get();


 if($query->num_rows()>0){
  $a['det']=$query->result();
}else{
  $x=2;
}  

$this->db->select(array(
  't_hp_additional_item.type as sales_type',
  't_hp_additional_item.rate_p',
  't_hp_additional_item.amount',
  'r_additional_item.description',
  'r_additional_item.is_add'
  ));

$this->db->from('t_hp_additional_item');
$this->db->join('r_additional_item', 'r_additional_item.code=t_hp_additional_item.type');
$this->db->where('t_hp_additional_item.cl', $this->sd['cl']);
$this->db->where('t_hp_additional_item.bc', $this->sd['branch']);
$this->db->where('t_hp_additional_item.nno', $_POST['id']);
$query = $this->db->get();

if ($query->num_rows() > 0) {
  $a['add'] = $query->result();
} else {
  $a['add'] = 2;
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
    if($this->user_permissions->is_delete('t_opening_hp')){

      $this->db->where('cl',$this->sd['cl']);
      $this->db->where('bc',$this->sd['branch']);
      $this->db->where('nno',$_POST['id']);
      $this->db->update('t_hp_sales_sum', array("is_cancel"=>1));  

      $this->db->where("trans_no", $_POST['id']);
      $this->db->where("trans_code", 6);
      $this->db->where("cl", $this->sd["cl"]);
      $this->db->where("bc", $this->sd['branch']);
      $this->db->delete("t_ins_trans");

      $this->db->where('cl',$this->sd['cl']);
      $this->db->where('bc',$this->sd['branch']);
      $this->db->where('trans_code','6');
      $this->db->where('trans_no',$_POST['id']);
      $this->db->delete('t_account_trans');

      $this->load->model('trans_settlement');
      $this->trans_settlement->delete_settlement_sub("t_credit_note_trans","6",$_POST['id']);   
      $this->trans_settlement->delete_settlement_sub("t_debit_note_trans","6",$_POST['id']); 

      $sql="SELECT cus_id FROM t_hp_sales_sum WHERE cl='".$this->sd['cl']."' AND bc='".$this->sd['branch']."' AND nno='".$_POST['id']."'";
      $cus_id=$this->db->query($sql)->first_row()->cus_id;
      $this->utility->update_credit_note_balance($cus_id);
      $this->utility->update_debit_note_balance($cus_id);

      $this->utility->save_logger("CANCEL",6,$_POST['id'],$this->mod);
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
    /*$sql = "SELECT * FROM m_item  JOIN qry_current_stock ON m_item.code = qry_current_stock.item
    WHERE (m_item.description LIKE '$_POST[search]%' OR code LIKE '$_POST[search]%') AND inactive='0' AND qry_current_stock.store_code = '$_POST[stores]' LIMIT 25";
    */

    $sql="SELECT DISTINCT(m_item.code), 
    m_item.`description`,
    m_item.`model`,
    m_item.`max_price`, 
    m_item.`min_price`,
    m_item.purchase_price 
    FROM m_item 
    WHERE
    (m_item.`description` LIKE '%$_POST[search]%' 
    OR m_item.`code` LIKE '%$_POST[search]%' 
    OR m_item.model LIKE '$_POST[search]%' 
    OR m_item.`max_price` LIKE '$_POST[search]%'
    OR `m_item`.`min_price` LIKE '$_POST[search]%') 
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
    $this->db->select(array('code','description','purchase_price'));
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

  public function get_item2(){
    $code = $_POST['code'];
    $store = $_POST['stores'];

    $sql = "SELECT * 
    FROM
    m_item 
    LEFT JOIN qry_current_stock 
    ON m_item.`code` = qry_current_stock.`item` 
    WHERE m_item.`code` = ".$code." && qry_current_stock.`store_code` = ".$store." 
    ";

    $query = $this->db->query($sql);

    if ($query->num_rows() > 0) {
      $data['a'] = $this->db->query($sql)->result();
    } else {
      $data['a'] = 2;
    }

    echo json_encode($data);
  }


  function load_request_note(){
    $supplier=$this->input->post("supplier");
    $sql="SELECT m_item.`description`,
    m_item.`model`,
    m_item.`purchase_price`,
    `t_req_det`.`item`,
    t_req_det.`nno`,
    t_req_det.`cur_qty`,
    t_req_det.`approve_qty`,
    t_req_det.`approve_qty` * m_item.`purchase_price` AS total 
    FROM `t_req_det` 
    JOIN m_item ON m_item.`code` = t_req_det.`item` 
    WHERE `t_req_det`.`approved` = '1' 
    AND t_req_det.`orderd` = '0'
    AND cl = '".$this->sd['cl']."' 
    AND bc = '".$this->sd['branch']."' 
    ";

    $query=$this->db->query($sql);
    if($query->num_rows>0){
      $a['det']=$query->result();
      echo json_encode($a);
    }else{
      $a['det']=2;
      echo json_encode($a);       
    }    
  }

  public function is_batch_item() {        
    $this->db->select(array("batch_no", "qty"));
    $this->db->where("cl", $this->sd['cl']);
    $this->db->where("bc", $this->sd['branch']);
    $this->db->where("item", $_POST['code']);
    $this->db->where("store_code", $_POST['store']);
    $this->db->where("qty >", "0");
    $query = $this->db->get("qry_current_stock");

    if ($query->num_rows() == 1) {
      foreach ($query->result() as $row) {
        echo $row->batch_no . "-" . $row->qty;
      }
    } else if ($query->num_rows() > 0) {
      echo "1";
    } else {
      echo "0";
    }
  }

  function get_scheme(){

    $this->db->where("code",$this->input->post('code'));
    $this->db->limit(1);
    $query=$this->db->get('m_hp_payment_scheme');
    if($query->num_rows() > 0){      
      $data['a']=$query->result();            
    }         
    echo json_encode($data);
  }

  public function sep_bal(){
    $sql="SELECT is_separate_doc FROM def_option_hp LIMIT 1";
    $query=$this->db->query($sql);
    if($query->num_rows>0){
      $a=$query->row()->is_separate_doc;
    }else{
      $a=2;

    } 
    echo $a; 
  }


  //------------------------------------------------------------------------------------

  public function Agreement_max_no($num){

   $sql = "SELECT field_format FROM `def_hp_serial_format_det` WHERE field_name='serial_no'";
   $query=$this->db->query($sql);

   if ($query->num_rows> 0){
    $Agree_num_format=$query->row()->field_format;

    if($num==1){
      $Agree_num=$Agree_num_format;

    }else if($num <=9){
      $new_num=substr($Agree_num_format, 0, -1);
      $Agree_num=$new_num.$num;

    }else if($num<=99){
      $new_num=substr($Agree_num_format, 0, -2);
      $Agree_num=$new_num.$num;

    }else if($num<=999){
      $new_num=substr($Agree_num_format, 0, -3);
      $Agree_num=$new_num.$num;

    }else if($num<=9999){
     $new_num=substr($Agree_num_format, 0, -4);
     $Agree_num=$new_num.$num;

   }else if($num<=99999){
    $new_num=substr($Agree_num_format, 0, -5);
    $Agree_num=$new_num.$num;

  }else if($num>+100000){
    $Agree_num=$num;

  }
  return $Agree_num;

}

}

public function serial_number($type="0")
{



  if($type=="1"){
    $type='return';
    $category=$_POST['category'];
  }else{
    $category=$_POST['category_id'];
    $type='echo';
  }
        //$category="0001";*/

  $branch=$this->sd['branch'];

  $sql_auto="SELECT use_auto_no_format FROM def_option_hp";
  $res1 =$this->db->query($sql_auto)->row()->use_auto_no_format;


  $sql_sCategory="SELECT agriment_no_start_with FROM m_hp_sales_category WHERE `code`=".$category."";
  $res2 =$this->db->query($sql_sCategory)->row()->agriment_no_start_with;

        //$sql_serial="SELECT MAX(nno) AS num  FROM t_hp_sales_sum WHERE `bc`='".$branch."' AND `category_id`='".$category."'";
        //$res3 =$this->db->query($sql_serial)->row()->num;
        //$res3=$res3+1;
  $res3 = $this->opening_hp_max_no("2");
  $this->res4 = $res3;

  if($res1>0)
  {


    $Q2 = $this->db->query("SELECT * FROM `def_hp_serial_format_det` ORDER BY `field_order` ASC");
    if ($Q2->num_rows() > 0){
      $agree_no_text = "";
      $sepr = "";
      $no = 0;

      foreach($Q2->result() as $R2){

        if ($R2->field_name == "seperator"){ $sepr = $R2->field_format;} 

        if ($R2->field_order != "0"){               

          if ($R2->field_order =="1")
          {
            if ($R2->field_name == "year")
            { 
              $yer = $R2->field_format; 
              $newY=date($yer);
              $agree_no_text .=$newY. $sepr;

            }
            else if ($R2->field_name == "month")
            { 
              $mon= $R2->field_format; 

              $newM=date($mon);
              $agree_no_text .=$newM. $sepr;

            }

            else if ($R2->field_name == "day")
            { 
              $dy= $R2->field_format; 
              $newD=date($dy);                                
              $agree_no_text .=$newD. $sepr;

            }
            else if ($R2->field_name == "sales_category")
            { 
              $s_category= $res2;                                    
              $agree_no_text .=$s_category. $sepr;
            }

            else if ($R2->field_name == "branch_code")
            { 
              $b_code= $branch;                                
              $agree_no_text .=$b_code. $sepr;
            }
            else{
              $agree_no_text .= $this->Agreement_max_no($res3). $sepr;
                              //$agree_no_text .= $res3. $sepr;
            }

          }

          if ($R2->field_order =="2")
          {
            if ($R2->field_name == "year")
            { 
              $yer = $R2->field_format; 
              $newY=date($yer);
              $agree_no_text .=$newY. $sepr;
            }
            else if ($R2->field_name == "month")
            { 
              $mon= $R2->field_format; 
              $newM=date($mon);
              $agree_no_text .=$newM. $sepr;
            }

            else if ($R2->field_name == "day")
            { 
              $dy= $R2->field_format; 
              $newD=date($dy);      
              $agree_no_text .=$newD. $sepr;
            }

            else if ($R2->field_name == "sales_category")
            { 
              $s_category= $res2;                                  
              $agree_no_text .=$s_category. $sepr;
            }

            else if ($R2->field_name == "branch_code")
            { 
              $b_code= $branch;                                 
              $agree_no_text .=$b_code. $sepr;
            }

            else
              $agree_no_text .= $this->Agreement_max_no($res3). $sepr;
                            //$agree_no_text .= $res3. $sepr;
          }


          if ($R2->field_order =="3")
          {
            if ($R2->field_name == "year")
            { 
              $yer = $R2->field_format; 
              $newY=date($yer);
              $agree_no_text .=$newY. $sepr;

            }
            else if ($R2->field_name == "month")
            { 
              $mon= $R2->field_format; 
              $newM=date($mon); 
              $agree_no_text .=$newM. $sepr;

            }

            else if ($R2->field_name == "day")
            { 
              $dy= $R2->field_format; 
              $newD=date($dy);
              $agree_no_text .=$newD. $sepr;

            }

            else if ($R2->field_name == "sales_category")
            { 
              $s_category= $res2;                                 
              $agree_no_text .=$s_category. $sepr;
            }

            else if ($R2->field_name == "branch_code")
            { 
              $b_code= $branch;                                
              $agree_no_text .=$b_code. $sepr;
            }

            else
              $agree_no_text .= $this->Agreement_max_no($res3). $sepr;
          }

          if ($R2->field_order =="4")
          {
            if ($R2->field_name == "year")
            { 
              $yer = $R2->field_format; 
              $newY=date($yer);
              $agree_no_text .=$newY. $sepr;

            }
            else if ($R2->field_name == "month")
            { 
              $mon= $R2->field_format; 
              $newM=date($mon); 
              $agree_no_text .=$newM. $sepr;

            }

            else if ($R2->field_name == "day")
            { 
              $dy= $R2->field_format; 
              $newD=date($dy);
              $agree_no_text .=$newD. $sepr;

            }

            else if ($R2->field_name == "sales_category")
            { 
              $s_category= $res2;                                 
              $agree_no_text .=$s_category. $sepr;

            }

            else if ($R2->field_name == "branch_code")
            { 
              $b_code= $branch;                                
              $agree_no_text .=$b_code. $sepr;

            }

            else if ($R2->field_name == "serial_no")
            {
              $agree_no_text .= $this->Agreement_max_no($res3). $sepr;
                              //$agree_no_text .= $res3. $sepr;
            }
          }

          if ($R2->field_order =="5")
          {
            if ($R2->field_name == "year")
            { 
              $yer = $R2->field_format; 
              $newY=date($yer);
              $agree_no_text .=$newY. $sepr;

            }
            else if ($R2->field_name == "month")
            { 
              $mon= $R2->field_format; 
              $newM=date($mon); 
              $agree_no_text .=$newM. $sepr;

            }

            else if ($R2->field_name == "day")
            { 
              $dy= $R2->field_format; 
              $newD=date($dy);
              $agree_no_text .=$newD. $sepr;

            }

            else if ($R2->field_name == "sales_category")
            { 
              $s_category= $res2;                                
              $agree_no_text .=$s_category. $sepr;

            }

            else if ($R2->field_name == "branch_code")
            { 
              $b_code= $branch;                                
              $agree_no_text .=$b_code. $sepr;

            }


            else
              $agree_no_text .= $this->Agreement_max_no($res3). $sepr;
                                //$agree_no_text .= $res3. $sepr;
          }

          if ($R2->field_order =="6")
          {
            if ($R2->field_name == "year")
            { 
              $yer = $R2->field_format; 
              $newY=date($yer);
              $agree_no_text .=$newY;

            }
            else if ($R2->field_name == "month")
            { 
              $mon= $R2->field_format; 
              $newM=date($mon); 
              $agree_no_text .=$newM;

            }

            else if ($R2->field_name == "day")
            { 
              $dy= $R2->field_format; 
              $newD=date($dy);
              $agree_no_text .=$newD;

            }

            else if ($R2->field_name == "sales_category")
            { 
              $s_category= $res2; 
              $agree_no_text .=$s_category. $sepr;

            }

            else if ($R2->field_name == "branch_code")
            { 
              $b_code= $branch;                                
              $agree_no_text .=$b_code. $sepr;

            }
            else
              $agree_no_text .= $this->Agreement_max_no($res3). $sepr;
                                //$agree_no_text .= $res3. $sepr;
          }

        }else{
          $agree_no_text = "";
        }

      }


    } 
    $agree_no_text=rtrim($agree_no_text, $sepr);

            //var_dump($this->Max_serial);

    if($type=='return'){
      return $agree_no_text;

    }else{
      echo $agree_no_text;


    }
            //echo $agree_no_text; 
            //echo $max_serial_no;

  }
}
  //------------------------------------------------------------------------------------
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


public function item_free_delete(){

  $qty=$_POST['quantity'];
  $item_code=$_POST['item'];

  $query = $this->db->query("
   SELECT  m.code  
   FROM m_item m
   JOIN m_item_free_det mfd ON mfd.`item` = m.`code`
   JOIN m_item_free mf ON mf.`nno` = mfd.`nno`
   WHERE mf.`code`='$item_code'");

  if ($query->num_rows() > 0) {
    $a['a'] = $query->result();
  } else {
    $a = 2;
  }
  echo json_encode($a);
}

public function is_settu_allow(){
  $use_settu =0;
  $sql="SELECT def_use_seettu FROM def_option_sales";
  $query= $this->db->query($sql);
  if($query->num_rows()>0){
    if($query->first_row()->def_use_seettu==1){
      $use_settu = 1;
    }
  }
  return $use_settu;
}

public function all_settu_item(){
  $code = $_POST['item_code'];
  $store_code = $_POST['store_code'];
  $cl = $this->sd['cl'];
  $bc = $this->sd['branch'];

  $sql="SELECT m.`code`,
  m.`description`,
  m.`model`,
  b.`max_price`, 
  b.`min_price`,
  b.purchase_price,  
  '0' AS free,
  d.qty,
  IFNULL(qq.qty,0) AS stock_qty 
  FROM m_settu_item_sum s
  JOIN m_settu_item_det d ON d.`cl` = s.`cl` AND d.`bc` = s.`bc` AND d.`no` = s.`no`
  JOIN m_item m ON m.`code` = d.`item_code`
  LEFT JOIN qry_current_stock q ON m.`code`=q.`item` AND q.cl = d.cl AND q.bc = d.bc 
  LEFT JOIN t_item_batch b ON b.`item` = m.`code` AND b.`batch_no`= q.`batch_no`
  LEFT JOIN (SELECT * FROM qry_current_stock WHERE store_code = 'C1B01001' 
  AND cl='$cl' AND bc='$bc' ) qq ON qq.item = m.`code` AND d.`cl` = qq.cl AND d.bc = qq.bc
  WHERE s.code = '$code'
  UNION ALL
  SELECT m.`code`,
  m.`description`,
  m.`model`,
  m.`max_price`, 
  m.`min_price`,
  m.purchase_price,  
  '1' AS free,
  f.qty,
  IFNULL(qq.qty,0) AS stock_qty 
  FROM m_settu_item_sum s
  JOIN m_settu_item_det_free f ON f.`cl` = s.`cl` AND f.`bc` = s.`bc` AND f.`no` = s.`no`
  JOIN m_item m ON m.`code` = f.`item_code`
  LEFT JOIN qry_current_stock q ON m.`code`=q.`item`  AND q.cl = f.cl AND q.bc = f.bc 
  LEFT JOIN t_item_batch b ON b.`item` = m.`code` AND b.`batch_no`= q.`batch_no`
  LEFT JOIN (SELECT * FROM qry_current_stock WHERE store_code = 'C1B01001' 
  AND cl='$cl' AND bc='$bc' ) qq ON qq.item = m.`code` AND f.`cl` = qq.cl AND f.bc = qq.bc
  WHERE  s.code = '$code'";

  $query=$this->db->query($sql);

  if($query->num_rows()>0){
    $a['a'] = $query->result();
  }else{
    $a = "2";
  }
  echo json_encode($a);

}

function get_batch_qty() {

  $batch_no=$_POST['batch_no'];
  $store=$_POST['store'];
  $no=$_POST['hid'];
  $item=$_POST['code'];

  if(isset($_POST['hid']) && $_POST['hid']=="0"){
    $this->db->select(array('qty'));
    $this->db->where("cl", $this->sd['cl']);
    $this->db->where("bc", $this->sd['branch']);
    $this->db->where("batch_no", $this->input->post("batch_no"));
    $this->db->where("store_code", $this->input->post('store'));
    $this->db->where("item", $this->input->post('code'));
    $query = $this->db->get("qry_current_stock");

    if ($query->num_rows() > 0) {
      foreach ($query->result() as $row) {
        echo $row->qty;
      }
    }else{
      echo 0;
    }

  }
  else
  {
    $sql="SELECT SUM(qry_current_stock.`qty`)+SUM(c.qty) as qty 
    FROM (`qry_current_stock`)  
    INNER JOIN (SELECT qty,item_code,batch_no,cl,bc 
    FROM t_hp_sales_det 
    WHERE  `batch_no` = '$batch_no'  
    AND  nno='$no' 
    AND `item_code` = '$item') c 
    ON c.item_code=qry_current_stock.`item` AND c.cl=qry_current_stock.cl AND c.bc=qry_current_stock.bc AND c.batch_no=qry_current_stock.batch_no
    WHERE qry_current_stock.`batch_no` = '$batch_no' 
    AND qry_current_stock.`store_code` = '$store' 
    AND `item_code` = '$item'
    ";


    if ($this->db->query($sql)->num_rows() > 0) {
      foreach($this->db->query($sql)->result() as $row){
        echo $row->qty; 
      }
    }else{
      echo 0;
    }
  }
}

public function chk_item_qty($item,$store,$req_qty,$hid,$batch){
  $status = 1;
  $avbl_qty = 0;
  for($x=0; $x<25; $x++){
    $item_code=$_POST[$item.$x];
    $req_item_qty = $_POST[$req_qty.$x];
    $batch_no = $_POST[$batch.$x];
    if(isset($hid) && $hid=="0"){
      $sql="SELECT qty 
      FROM qry_current_stock 
      WHERE `cl` = '".$this->sd['cl']."' 
      AND `bc` = '".$this->sd['branch']."' 
      AND `store_code` = '$store' 
      AND batch_no ='$batch_no'
      AND `item` = '$item_code'"; 

      $query = $this->db->query($sql);
      foreach($query->result() as $row){
        $avbl_qty =(int)$row->qty; 
      }
    }else{
      $sql2="SELECT SUM(qry_current_stock.`qty`)+SUM(c.qty) as qty 
      FROM (`qry_current_stock`)  
      INNER JOIN (SELECT qty,item_code,batch_no,cl,bc 
      FROM t_hp_sales_det 
      WHERE nno='$hid' 
      AND cl ='".$this->sd['cl']."'
      AND batch_no ='$batch_no'
      AND bc ='".$this->sd['branch']."'
      AND `item_code` = '$item_code') c 
      ON c.item_code=qry_current_stock.`item` AND c.cl=qry_current_stock.cl AND c.bc=qry_current_stock.bc AND c.batch_no=qry_current_stock.batch_no
      WHERE qry_current_stock.`batch_no` = '$batch_no' 
      AND qry_current_stock.`store_code` = '$store' 
      AND `item_code` = '$item_code'";
      $query = $this->db->query($sql2);
      foreach($query->result() as $row){
        $avbl_qty =(int)$row->qty; 
      } 
    }
    if($avbl_qty<$req_item_qty){
      $status = "Not enough quantity in item (".$item_code.") .";
    }  
  }
  return $status;
}

public function opening_hp_max_no($model){
  $sql="SELECT  bc,
  def_use_opening_hp,
  no_of_opening_hp 
  FROM m_branch
  WHERE cl='".$this->sd['cl']."' 
  AND bc='".$this->sd['branch']."'";

  $query=$this->db->query($sql);
  $no_max = $query->row()->no_of_opening_hp;

  if($query->row()->def_use_opening_hp == "1"){
    return $this->hp_max_no('1',$no_max,$model);
  }else{
    return $this->hp_max_no('0',$no_max,$model);
  }
} 

public function hp_max_no($status,$count,$model){
  $cl=$this->sd['cl'];
  $bc=$this->sd['branch'];
    if($model=="1"){ // genaral hp
      if($status=="1"){
        $sql = "SELECT IFNULL(MAX(nno),0) AS max_no 
        FROM t_hp_sales_sum
        WHERE cl='$cl' AND bc='$bc'
        AND is_opening_hp='0'";

        $query=$this->db->query($sql);
        if($query->row()->max_no == "0"){
          if(isset($_POST['hid'])){
            if($_POST['hid'] == "0" || $_POST['hid'] == ""){   
              $max = $count+1;
            }else{
              $max = $_POST['hid'];  
            }
          }else{
            $max = $count+1;
          }
        }else{
          if(isset($_POST['hid'])){
            if($_POST['hid'] == "0" || $_POST['hid'] == ""){ 
              $sql1="SELECT IFNULL(MAX(nno),0)+1 AS max_no 
              FROM t_hp_sales_sum
              WHERE cl='$cl' AND bc='$bc'
              AND is_opening_hp='0'";
              $query1 = $this->db->query($sql1);
              $max = $query1->row()->max_no; 
            }else{
              $max = $_POST['hid']; 
            }
          }else{
            $sql1="SELECT IFNULL(MAX(nno),0)+1 AS max_no 
            FROM t_hp_sales_sum
            WHERE cl='$cl' AND bc='$bc'
            AND is_opening_hp='0'";
            $query1 = $this->db->query($sql1);
            $max = $query1->row()->max_no; 
          }  
        }
      }else{
        if(isset($_POST['hid'])){
          if($_POST['hid'] == "0" || $_POST['hid'] == ""){ 
            $sql3="SELECT IFNULL(MAX(nno),0)+1 AS max_no 
            FROM t_hp_sales_sum
            WHERE cl='$cl' AND bc='$bc'
            AND is_opening_hp='0'";
            $query3 = $this->db->query($sql3);
            $max = $query3->row()->max_no; 
          }else{
            $max = $_POST['hid']; 
          }
        }else{
          $sql3="SELECT IFNULL(MAX(nno),0)+1 AS max_no 
          FROM t_hp_sales_sum
          WHERE cl='$cl' AND bc='$bc'
          AND is_opening_hp='0'";
          $query3 = $this->db->query($sql3);
          $max = $query3->row()->max_no; 
        }
      }
    }else{ // op hp
      if(isset($_POST['hid'])){
        if($_POST['hid'] == "0" || $_POST['hid'] == ""){
          $sql2="SELECT IFNULL(MAX(nno),0)+1 AS max_no 
          FROM t_hp_sales_sum
          WHERE cl='$cl' AND bc='$bc'
          AND is_opening_hp='1'";
          $query2 = $this->db->query($sql2);
          $max = $query2->row()->max_no; 
        }else{
          $max = $_POST['hid']; 
        }
      }else{
        $sql2="SELECT IFNULL(MAX(nno),0)+1 AS max_no 
        FROM t_hp_sales_sum
        WHERE cl='$cl' AND bc='$bc'
        AND is_opening_hp='1'";
        $query2 = $this->db->query($sql2);
        $max = $query2->row()->max_no;
      }
    }
    return $max;
  }

}