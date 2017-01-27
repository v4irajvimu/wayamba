<?php
if (!defined('BASEPATH'))
  exit('No direct script access allowed');

class t_hp_seized_main_store extends CI_Model {

  private $sd;
  private $mtb;
  private $max_no;
  private $debit_max_no;
  private $mod = '003';

  function __construct() {
    parent::__construct();
    $this->sd = $this->session->all_userdata();
    $this->load->database($this->sd['db'], true);
    $this->load->model('user_permissions');
    $this->load->model('m_stores');
  }

  public function base_details() {
    $a['stores'] = $this->m_stores->select();
    $a['nno'] = $this->utility->get_max_no("t_seized_items_main_store_sum", "nno");
    $a["crn_no"] = $this->get_credit_max_no();
   /* $cost = $this->utility->show_price();
    $a['show_max']=($cost[0]['isShowMaxPrice']);
    $a['is_show_cost']=$cost[0]['isShowCost'];
    $a['is_show_min']=$cost[0]['isShowMinPrice'];
    $a['is_show_max']=$cost[0]['isShowMaxPrice'];*/
    $a['cl']=$this->sd['cl'];
    $a['bc']=$this->sd['branch'];
    
    return $a;
  }

  public function get_credit_max_no(){
    if (isset($_POST['hid'])) {
      if ($_POST['hid'] == "0" || $_POST['hid'] == "") {
        $field = "nno";
        $this->db->select_max($field);
        $this->db->where("cl", $this->sd['cl']);
        $this->db->where("bc", $this->sd['branch']);
        return $this->db->get("t_credit_note")->first_row()->$field + 1;
      }else{
        return $_POST['cn_no'];
      }
    }else{
      $field = "nno";
      $this->db->select_max($field);
      $this->db->where("cl", $this->sd['cl']);
      $this->db->where("bc", $this->sd['branch']);
      return $this->db->get("t_credit_note")->first_row()->$field + 1;
    }
  }


  public function validation() {
    $status = 1;
    $this->max_no = $this->utility->get_max_no("t_seized_items_main_store_sum", "nno");
    $this->credit_max_no = $this->get_credit_max_no();

    $check_is_delete = $this->validation->check_is_cancel($this->max_no, 't_seized_items_main_store_sum');
    if ($check_is_delete != 1) {
      return "This record already deleted";
    }

    $customer_validation = $this->validation->check_is_customer($_POST['cus_id']);
    if ($customer_validation != 1) {
      return "Please enter valid customer";
    }

    $serial_validation_status = $this->validation->serial_update('0_', 'sqty_',"all_serial_");
    if ($serial_validation_status != 1) {
      return $serial_validation_status;
    }

    $check_zero_value=$this->validation->empty_net_value($_POST['gross_amount']);
    if($check_zero_value!=1){
      return $check_zero_value;
    }

    $check_item_code_length=$this->item_code_length('0_');
    if($check_item_code_length!=1){
      return $check_item_code_length;
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
      if ($validation_status == 1) {
        $sum = array(
          "cl"            => $this->sd['cl'],
          "bc"            => $this->sd['branch'],
          "nno"           => $this->max_no,
          "ddate"         => $_POST['date'],
          "ref_no"        => $_POST['ref_no'],
          "agr_no"        => $_POST['agr_no'],
          "hp_no"         => $_POST['hp_no'],
          "crn_no"        => $_POST['cn_no'],
          "from_store"    => $_POST['f_store_code'],
          "to_store"      => $_POST['to_store'],
          "hp_amount"     => $_POST['agr_amount'],
          "arr_amount"    => $_POST['ar_amount'],
          "paid_amount"   => $_POST['paid_amount'],
          "customer"      => $_POST['cus_id'],
          "dr_acc"        => $_POST['dr_acc'],
          "gross_amount"  => $_POST['gross_amount'],
          "crn_amount"    => $_POST['amt'],
          "oc"            => $this->sd['oc'],
          "seize_no"      => $_POST['seize_no']
        );

        $t_credit_note = array(
          "cl"            => $this->sd['cl'],
          "bc"            => $this->sd['branch'],
          "nno"           => $this->credit_max_no,
          "ddate"         => $_POST['date'],
          "ref_no"        => $_POST['ref_no'],
          "memo"          => "HP SEIZE ITEM RETURN TO MAIN STORE [" . $this->max_no . "]",
          "is_customer"   => 1,
          "code"          => $_POST['cus_id'],
          "acc_code"      => $this->utility->get_default_acc('STOCK_ACC'),
          "amount"        => $_POST['amt'],
          "oc"            => $this->sd['oc'],
          "post"          => "",
          "post_by"       => "",
          "post_date"     => "",
          "is_cancel"     => 0,
          "ref_trans_no"  => $this->max_no,
          "ref_trans_code"=> 118,
          "balance"       => $_POST['amt']
        );

        for($x=0; $x<25; $x++){
          if(isset($_POST['0_'.$x],$_POST['bt1_'.$x],$_POST['sqty_'.$x])){
            if($_POST['0_'.$x]!="" && $_POST['bt1_'.$x]!="" && $_POST['sqty_'.$x]!=""){
              $det[]=array(
                "cl"      => $this->sd['cl'],
                "bc"      => $this->sd['branch'],
                "nno"     => $this->max_no,
                "code"    => $_POST['0_'.$x],
                "batch_no"=> $_POST['bt1_'.$x],
                "qty"     => $_POST['sqty_'.$x],
                "cost"    => $_POST['scost_'.$x],
                "min"     => $_POST['slprice_'.$x],
                "max"     => $_POST['smprice_'.$x],
                "amount"  => $_POST['samount_'.$x]
              );             
            }
          }
        }

        if ($_POST['hid'] == "0" || $_POST['hid'] == "") {
          if($this->user_permissions->is_add('t_hp_seized_main_store')){

            $this->db->insert('t_seized_items_main_store_sum', $sum);     

            if(count($det)){
              $this->db->insert_batch("t_seized_items_main_store_det", $det);
            } 

            $this->db->where("trans_no", $this->max_no);
            $this->db->where("trans_code", 118);
            $this->db->where("cl", $this->sd['cl']);
            $this->db->where("bc", $this->sd['branch']);
            $this->db->delete("t_serial_trans");

            $this->save_tempory_serials();

            $this->utility->save_logger("SAVE",118,$this->max_no,$this->mod); 
            echo $this->db->trans_commit();
          }else{
            echo "No permission to save records";
            $this->db->trans_commit();
          }
        } else {
          if($this->user_permissions->is_edit('t_hp_seized_main_store')){

            $this->set_delete();
            
            $this->db->where("cl", $this->sd['cl']);
            $this->db->where("bc", $this->sd['branch']);
            $this->db->where('nno', $this->max_no);
            $this->db->update('t_seized_items_main_store_sum', $sum); 

            if(count($det)){
              $this->db->insert_batch("t_seized_items_main_store_det", $det);
            } 

            if($_POST['is_approve']=='1'){
              $account_update=$this->account_update(0);
              if($account_update==1){

                $this->remove_tempory_serials();

                $this->db->where("cl", $this->sd['cl']);
                $this->db->where("bc", $this->sd['branch']);
                $this->db->where('nno', $this->max_no);
                $this->db->delete('t_seized_items_main_store_det'); 

                $this->db->where("cl", $this->sd['cl']);
                $this->db->where("bc", $this->sd['branch']);
                $this->db->where('nno', $this->max_no);
                $this->db->update('t_seized_items_main_store_sum', array("is_approve"=>1)); 

                for($x = 0; $x < 25; $x++){
                  if(isset($_POST['0_'.$x])){
                    if($_POST['0_'.$x] != "" || !empty($_POST['0_'.$x])){
                      
                      $item_detials = $this->get_item_details($_POST['0_'.$x]);
                      $item_color   = $this->get_item_color($_POST['0_'.$x],$_POST['bt1_'.$x]);

                      $item=array(
                      "code"          =>strtoupper(trim($_POST['0_'.$x].'SZ')),
                      "description"   =>$item_detials[0]->description,
                      "department"    =>$item_detials[0]->department,
                      "main_category" =>$item_detials[0]->main_category,
                      "category"      =>$item_detials[0]->category,
                      "inactive"      =>$item_detials[0]->inactive,
                      "serial_no"     =>$item_detials[0]->serial_no,
                      "batch_item"    =>$item_detials[0]->batch_item,
                      "unit"          =>$item_detials[0]->unit,
                      "brand"         =>$item_detials[0]->brand,
                      "model"         =>$item_detials[0]->model,
                      "rol"           =>$item_detials[0]->rol,
                      "roq"           =>$item_detials[0]->roq,
                      "supplier"      =>$item_detials[0]->supplier,
                      "barcode"       =>$item_detials[0]->barcode,
                      "purchase_price"=>$_POST['scost_'.$x],
                      "min_price"     =>$_POST['slprice_'.$x],
                      "max_price"     =>$_POST['smprice_'.$x],
                      "sale_price_3"  =>$item_detials[0]->sale_price_3,
                      "sale_price_4"  =>$item_detials[0]->sale_price_4,
                      "sale_price_5"  =>$item_detials[0]->sale_price_5,
                      "sale_price_6"  =>$item_detials[0]->sale_price_6,
                      "is_color_item" =>$item_detials[0]->is_color_item,
                      "is_seize_item" =>1,
                      "oc"            =>$this->sd['oc'],
                      );

                      $item_branch=array(
                      "cl"            =>$this->sd['cl'],
                      "bc"            =>$this->sd['branch'],
                      "code"          =>strtoupper(trim($_POST['0_'.$x].'SZ')),
                      "description"   =>$item_detials[0]->description,
                      "department"    =>$item_detials[0]->department,
                      "main_category" =>$item_detials[0]->main_category,
                      "category"      =>$item_detials[0]->category,
                      "inactive"      =>$item_detials[0]->inactive,
                      "serial_no"     =>$item_detials[0]->serial_no,
                      "batch_item"    =>$item_detials[0]->batch_item,
                      "unit"          =>$item_detials[0]->unit,
                      "brand"         =>$item_detials[0]->brand,
                      "model"         =>$item_detials[0]->model,
                      "rol"           =>$item_detials[0]->rol,
                      "roq"           =>$item_detials[0]->roq,
                      "supplier"      =>$item_detials[0]->supplier,
                      "barcode"       =>$item_detials[0]->barcode,
                      "purchase_price"=>$_POST['scost_'.$x],
                      "min_price"     =>$_POST['slprice_'.$x],
                      "max_price"     =>$_POST['smprice_'.$x],
                      "sale_price_3"  =>$item_detials[0]->sale_price_3,
                      "sale_price_4"  =>$item_detials[0]->sale_price_4,
                      "sale_price_5"  =>$item_detials[0]->sale_price_5,
                      "sale_price_6"  =>$item_detials[0]->sale_price_6,
                      "is_color_item" =>$item_detials[0]->is_color_item,
                      "is_seize_item" =>1,
                      "oc"            =>$this->sd['oc'],
                      );

                      $sql1="SELECT * FROM m_item WHERE code='".$_POST['0_'.$x].'SZ'."' ";
                      $query1=$this->db->query($sql1);
                      
                      if($query1->num_rows()<=0){
                        $this->db->insert("m_item",$item);
                      }
                      
                      $sql2="SELECT * FROM m_item_branch 
                              WHERE code='".$_POST['0_'.$x].'SZ'."' 
                              AND cl='".$this->sd['cl']."'
                              AND bc='".$this->sd['branch']."' ";
                      $query2=$this->db->query($sql2);

                      if($query2->num_rows()<=0){
                        $this->db->insert("m_item_branch",$item_branch);
                      }

                      $bbatch_no = $this->utility->get_batch_no($_POST['0_'.$x].'SZ',$_POST['scost_'.$x],$_POST['smprice_'.$x],$_POST['slprice_'.$x],$item_color);

                      if($this->utility->is_batch_item($_POST['0_'.$x].'SZ')){
                        if($this->utility->batch_in_item_batch_tb($_POST['0_'.$x].'SZ',$bbatch_no)){
                          $this->utility->insert_batch_items(
                          $this->sd['cl'],
                          $this->sd['branch'],
                          strtoupper(trim($_POST['0_'.$x].'SZ')),
                          118,
                          $this->max_no,
                          $bbatch_no,
                          $_POST['scost_'.$x],
                          $_POST['slprice_'.$x],
                          $_POST['smprice_'.$x],
                          $item_detials[0]->sale_price_3,
                          $item_detials[0]->sale_price_4,
                          $item_detials[0]->sale_price_5,
                          $item_detials[0]->sale_price_6,
                         
                          $item_detials[0]->supplier,
                          $this->sd['oc'],
                          "t_item_batch"
                          ); 
                        }
                      }else if($this->utility->check_item_in_batch_table($_POST['0_'.$x].'SZ')){
                        $this->utility->insert_batch_items(
                        $this->sd['cl'],
                        $this->sd['branch'],
                        strtoupper(trim($_POST['0_'.$x].'SZ')),
                        118,
                        $this->max_no,
                        $bbatch_no,
                        $_POST['scost_'.$x],
                        $_POST['slprice_'.$x],
                        $_POST['smprice_'.$x],
                        $item_detials[0]->sale_price_3,
                        $item_detials[0]->sale_price_4,
                        $item_detials[0]->sale_price_5,
                        $item_detials[0]->sale_price_6,
                        
                        $item_detials[0]->supplier,
                        $this->sd['oc'],
                        "t_item_batch"
                        ); 
                      }    

                      /*$this->utility->insert_batch_items(
                      $this->sd['cl'],
                      $this->sd['branch'],
                      strtoupper(trim($_POST['0_'.$x].'SZ')),
                      118,
                      $this->max_no,
                      1,
                      $_POST['scost_'.$x],
                      $_POST['slprice_'.$x],
                      $_POST['smprice_'.$x],
                      $item_detials[0]->sale_price_3,
                      $item_detials[0]->sale_price_4,
                      $item_detials[0]->sale_price_5,
                      $item_detials[0]->sale_price_6,
                      $item_color,
                      $item_detials[0]->supplier,
                      $this->sd['oc'],
                      "t_item_batch"
                      ); */

                      $det_approve[]=array(
                        "cl"              => $this->sd['cl'],
                        "bc"              => $this->sd['branch'],
                        "nno"             => $this->max_no,
                        "code"            => $_POST['0_'.$x],
                        "batch_no"        => $_POST['bt1_'.$x],
                        "qty"             => $_POST['sqty_'.$x],
                        "cost"            => $_POST['scost_'.$x],
                        "min"             => $_POST['slprice_'.$x],
                        "max"             => $_POST['smprice_'.$x],
                        "amount"          => $_POST['samount_'.$x],
                        "new_item_code"   => $_POST['0_'.$x].'SZ',
                      );  

                      $this->trans_settlement->save_item_movement('t_item_movement',
                      $_POST['0_'.$x],
                      '118',
                      $this->max_no,
                      $_POST['date'],
                      0,
                      $_POST['sqty_' . $x],
                      $_POST['f_store_code'],
                      $_POST['scost_'.$x],
                      $_POST['bt1_'.$x],
                      $_POST['slprice_'.$x],
                      $_POST['smprice_'.$x],
                      $_POST['scost_'.$x],
                      001);

                      $this->trans_settlement->save_item_movement('t_item_movement',
                      $_POST['0_'.$x].'SZ',
                      '118',
                      $this->max_no,
                      $_POST['date'],
                      $_POST['sqty_' . $x],
                      0,
                      $_POST['to_store'],
                      $_POST['scost_'.$x],
                      $bbatch_no,
                      $_POST['slprice_'.$x],
                      $_POST['smprice_'.$x],
                      $_POST['scost_'.$x],
                      001);

                      $this->db->where("cl", $this->sd['cl']);
                      $this->db->where("bc", $this->sd['branch']);
                      $this->db->where("nno", $_POST['seize_no']);
                      $this->db->where("item_code", $_POST['0_'.$x]);
                      $this->db->update("t_hp_seize_det",array("status"=>2));

                      $this->save_out_serial($x);
                      $this->save_serial($x,$bbatch_no);
                    }
                  }
                }

                if(count($det)){
                  $this->db->insert_batch("t_seized_items_main_store_det", $det_approve);
                } 
                   
                
                //$this->account_update(1);

                if($_POST['amt']>0){
                  $this->db->insert('t_credit_note', $t_credit_note);
                  $this->load->model('trans_settlement');
                  $this->trans_settlement->save_settlement("t_credit_note_trans", $_POST['cus_id'], $_POST['date'], 17, $this->credit_max_no, 118, $this->max_no, $_POST['amt'], "0");
                }

                $this->utility->save_logger("APPROVE",118,$this->max_no,$this->mod); 
                echo $this->db->trans_commit();
              }else{
                echo "Invalid account entries";
                $this->db->trans_commit();
              }
            }else{
              $this->db->where("trans_no", $this->max_no);
              $this->db->where("trans_code", 118);
              $this->db->where("cl", $this->sd['cl']);
              $this->db->where("bc", $this->sd['branch']);
              $this->db->delete("t_serial_trans");
              
              $this->save_tempory_serials();

              $this->utility->save_logger("EDIT",118,$this->max_no,$this->mod); 
              echo $this->db->trans_commit();
            }
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


  public function save_tempory_serials(){
    for($x =0; $x<25; $x++){
      if(isset($_POST['0_'.$x])){
        if($_POST['0_'.$x] != "" || !empty($_POST['0_' . $x])){
          if($this->check_is_serial_items($_POST['0_'.$x])==1){
            $serial = $_POST['all_serial_'.$x];
            $pp=explode(",",$serial);

            for($t=0; $t<count($pp); $t++){
              $p = explode("-",$pp[$t]);  

              $t_serial_trans[]=array(
                "cl"=>$this->sd['cl'],
                "bc"=>$this->sd['branch'],
                "trans_code"=>118,
                "trans_no"=>$this->max_no,
                "item_code"=>$_POST['0_'.$x],
                "serial_no"=>$p[0],
                "qty"=>1,
                "computer"=>$this->input->ip_address(),
                "oc"=>$this->sd['oc'],
                ); 
            }                  
          }
        }
      }
    }
    if(isset($t_serial_trans)){if(count($t_serial_trans)){  $this->db->insert_batch("t_serial_trans", $t_serial_trans);}}
  }

  public function remove_tempory_serials(){
    $this->db->where("trans_no", $this->max_no);
    $this->db->where("trans_code", 118);
    $this->db->where("cl", $this->sd['cl']);
    $this->db->where("bc", $this->sd['branch']);
    $this->db->delete("t_serial_trans");
  }

  public function check_is_serial_items($code) {
    $this->db->select(array('serial_no'));
    $this->db->where("code", $code);
    $this->db->limit(1);
    return $this->db->get("m_item")->first_row()->serial_no;
  }

  public function get_item_details($item){
    $sql="SELECT * FROM m_item WHERE code='$item'";
    $query= $this->db->query($sql);
    return $query->result();
  }

  public function get_item_color($item,$batch){
    $sql="SELECT color_code FROM t_item_batch WHERE item='$item' AND batch_no='$batch'";
    $query=$this->db->query($sql);
    if($query->num_rows()>0){
      return $query->first_row()->color_code;
    }else{
      return '001';
    }
  }

  public function load() {
    $cl=$this->sd['cl'];
    $bc=$this->sd['branch'];
    $no=$_POST['id'];

    $sql="SELECT nno,
            ddate,
            ref_no,
            agr_no,
            hp_no,
            crn_no,
            from_store,
            fs.`description` AS f_store_des,
            to_store,
            ts.`description` AS t_store_des,
            hp_amount,
            arr_amount,
            paid_amount,
            s.customer,
            c.`name` AS cus_name,
            dr_acc,
            a.`description` AS acc_des,
            s.`gross_amount`,
            s.`crn_amount`,  
            s.`is_cancel`,
            s.`is_approve`,
            s.seize_no
          FROM `t_seized_items_main_store_sum` s
          JOIN m_stores ts ON ts.`code`=s.`to_store`
          JOIN m_stores fs ON fs.`code`=s.`from_store`
          JOIN m_customer c ON c.`code` =s.`customer`
          JOIN m_account a ON a.`code` =s.`dr_acc`
          WHERE s.cl='$cl' AND s.bc='$bc' AND s.nno='$no'";
          $query_sum=$this->db->query($sql);
          $x = 0;
          $app = 0; 

          if($query_sum->num_rows()>0){
            $result['sum'] = $query_sum->result();
            $app= $query_sum->row()->is_approve;
          }else{
            $x=2;
          }

    $sql_det="SELECT d.`code`,
                i.`description`,
                i.`model`,
                d.`batch_no`,
                d.`qty`,
                d.`cost`,
                d.`min`,
                d.`max`,
                d.`new_item_code`  
              FROM `t_seized_items_main_store_det` d
              JOIN m_item i ON i.`code` = d.`code`
              WHERE d.`cl`='$cl' AND d.`bc`='$bc' AND d.`nno`='$no'
              GROUP BY d.code";
    $query_det=$this->db->query($sql_det);
    if($query_det->num_rows() > 0){
      $result['det'] = $query_det->result();
    }else{
      $x=2;
    }

    if($app!=0){
      $this->db->select(array('t_serial.item', 't_serial.serial_no', 'other_no1', 'other_no2'));
      $this->db->from('t_serial');
      $this->db->where('t_serial.trans_no', $no);
      $this->db->where('t_serial.trans_type', 118);
      $this->db->where('t_serial.cl', $this->sd['cl']);
      $this->db->where('t_serial.bc', $this->sd['branch']);
      $this->db->group_by("t_serial.serial_no");
      $query = $this->db->get();
    }else{
      $sql="SELECT item_code AS item , serial_no, '' AS other_no1 , '' AS other_no2
      FROM t_serial_trans
      WHERE cl='".$this->sd['cl']."' 
      AND bc='".$this->sd['branch']."' 
      AND trans_code='118' 
      AND trans_no='$no'
      GROUP BY item_code,serial_no";
      $query=$this->db->query($sql);
    }
    if($query->num_rows()>0) {
      $result['serial'] = $query->result();
    }else{
      $result['serial'] = 2;
    }

    if($x==0){
      echo json_encode($result);
    }else{
      echo json_encode($x);
    }
  }

  public function save_out_serial($x){
    if($this->check_is_serial_items($_POST['0_'.$x])==1){
      $serial = $_POST['all_serial_'.$x];
      $pp=explode(",",$serial);
          
      for($t=0; $t<count($pp); $t++){
        $p = explode("-",$pp[$t]);

        $this->db->where("cl", $this->sd['cl']);
        $this->db->where("bc", $this->sd['branch']);
        $this->db->where("item",$_POST['0_'.$x] );
        $this->db->where("serial_no", $p[0]);
        $this->db->update("t_serial",array("out_doc"=>118,"out_no"=>$this->max_no));

        $t_serial_movement[]=array(
          "cl"=>$this->sd['cl'],
          "bc"=>$this->sd['branch'],
          "trans_type"=>118,
          "trans_no"=>$this->max_no,
          "item"=>$_POST['0_'.$x],
          "batch_no"=>$_POST['bt1_'.$x],
          "serial_no"=>$p[0],
          "qty_in"=>0,
          "qty_out"=>1,
          "cost"=>$_POST['scost_'.$x],
          "store_code"=>$_POST['f_store_code'],
          "computer"=>$this->input->ip_address(),
          "oc"=>$this->sd['oc'],
          ); 
      }                  
    }
    if(isset($t_serial_movement)){if(count($t_serial_movement)){  $this->db->insert_batch("t_serial_movement_out", $t_serial_movement);}}
  }

  public function save_serial($x,$batch){
    if($this->check_is_serial_items($_POST['0_'.$x])==1){
      $serial = $_POST['all_serial_'.$x];
      $pp=explode(",",$serial);
          
      for($t=0; $t<count($pp); $t++){
        $p = explode("-",$pp[$t]);
         
        $t_serial[]=array(
          "cl"=>$this->sd['cl'],
          "bc"=>$this->sd['branch'],
          "trans_type"=>118,
          "trans_no"=>$this->max_no,
          "date"=>$_POST['date'],
          "item"=>$_POST['0_'.$x].'SZ',
          "batch"=>$batch,
          "serial_no"=>$p[0],
          "other_no1"=>'',
          "other_no2"=>'',
          "cost"=>$_POST['scost_'.$x],
          "max_price"=>$_POST['smprice_'.$x],
          "last_price"=>$_POST['slprice_'.$x],
          "store_code"=>$_POST['to_store']          
        );

        $t_serial_movement[]=array(
          "cl"=>$this->sd['cl'],
          "bc"=>$this->sd['branch'],
          "trans_type"=>118,
          "trans_no"=>$this->max_no,
          "item"=>$_POST['0_'.$x].'SZ',
          "batch_no"=>$batch,
          "serial_no"=>$p[0],
          "qty_in"=>1,
          "qty_out"=>0,
          "cost"=>$_POST['scost_'.$x],
          "store_code"=>$_POST['to_store'],
          "computer"=>$this->input->ip_address(),
          "oc"=>$this->sd['oc'],
          ); 
        }                  
      }
    if(isset($t_serial)){if(count($t_serial)){  $this->db->insert_batch("t_serial", $t_serial);}}
    if(isset($t_serial_movement)){if(count($t_serial_movement)){  $this->db->insert_batch("t_serial_movement", $t_serial_movement);}}
  }

  public function PDF_report() {
    $this->db->select(array('name', 'address', 'tp', 'fax', 'email'));
    $this->db->where("cl", $this->sd['cl']);
    $this->db->where("bc", $this->sd['branch']);
    $r_detail['branch'] = $this->db->get('m_branch')->result();

    $this->db->where("code", $_POST['sales_type']);
    $query = $this->db->get('t_trans_code');
    if ($query->num_rows() > 0) {
      foreach ($query->result() as $row) {
        $r_detail['r_type'] = $row->description;
      }
    }

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
    $r_detail['drn'] = $_POST['drn'];
    $r_detail['page'] = $_POST['page'];
    $r_detail['header'] = $_POST['header'];
    $r_detail['orientation'] = $_POST['orientation'];
    $cl=$this->sd['cl'];
    $bc=$this->sd['branch'];
    $sql="SELECT nno,
            ddate,
            ref_no,
            agr_no,
            hp_no,
            crn_no,
            from_store,
            fs.`description` AS f_store_des,
            to_store,
            ts.`description` AS t_store_des,
            hp_amount,
            arr_amount,
            paid_amount,
            s.customer,
            c.`name` AS cus_name,
            dr_acc,
            a.`description` AS acc_des,
            s.`gross_amount`,
            s.`crn_amount`,  
            s.`is_cancel`,
            s.`is_approve`,
            s.seize_no
          FROM `t_seized_items_main_store_sum` s
          JOIN m_stores ts ON ts.`code`=s.`to_store`
          JOIN m_stores fs ON fs.`code`=s.`from_store`
          JOIN m_customer c ON c.`code` =s.`customer`
          JOIN m_account a ON a.`code` =s.`dr_acc`
          WHERE s.cl='$cl' AND s.bc='$bc' AND s.nno='".$_POST['qno']."'";
          $query_sum=$this->db->query($sql);

      $r_detail['sum']  = $query_sum->result();  

      $sql_det="SELECT d.`code`,
                i.`description`,
                i.`model`,
                d.`batch_no`,
                d.`qty`,
                d.`cost`,
                d.`min`,
                d.`max`,
                d.`new_item_code`,
                d.amount  
              FROM `t_seized_items_main_store_det` d
              JOIN m_item i ON i.`code` = d.`code`
              WHERE d.`cl`='$cl' AND d.`bc`='$bc' AND d.`nno`='".$_POST['qno']."'
              GROUP BY d.code";
             $query=$this->db->query($sql_det);
    $r_detail['det']  = $query->result(); 

    $this->db->select(array('t_serial.item', 't_serial.serial_no', 'other_no1', 'other_no2'));
    $this->db->from('t_serial');
    $this->db->where('t_serial.trans_no', $_POST['qno']);
    $this->db->where('t_serial.trans_type', 118);
    $this->db->where('t_serial.cl', $this->sd['cl']);
    $this->db->where('t_serial.bc', $this->sd['branch']);
    $this->db->group_by("t_serial.serial_no");
    $query_s = $this->db->get(); 
    $r_detail['serial']  = $query_s->result(); 

    $this->db->select(array('loginName'));
    $this->db->where('cCode', $this->sd['oc']);
    $r_detail['user'] = $this->db->get('users')->result();

    $s_time=$this->utility->save_time();
    if($s_time==1){
      $r_detail['save_time']="  -  ".$this->utility->get_save_time('t_seized_items_main_store_sum','action_date',$_POST['qno'],'nno');
    }else{
      $r_detail['save_time']="";
    } 

    if($query_sum->num_rows()>0){
      $this->load->view($_POST['by'].'_'.'pdf',$r_detail);
    }else{
      echo "<script>alert('No Data');window.close();</script>";
    }
  }


  public function account_update($condition) {
    return "1";
  }


  private function set_delete() {
    $this->db->where("cl", $this->sd['cl']);
    $this->db->where("bc", $this->sd['branch']);
    $this->db->where('nno', $this->max_no);
    $this->db->delete('t_seized_items_main_store_det');

    $this->load->model('trans_settlement');
    $this->trans_settlement->delete_item_movement('t_item_movement',118,$this->max_no);
  }


  public function load_agr(){
    $sql="SELECT s.`agr_no`,
          s.`customer` AS customer,
          c.name AS cus_name,
          s.`hp_nno`,
          s.`stores`,
          st.`description` AS store_des
        FROM `t_hp_seize_sum` s
        JOIN m_customer c ON c.`code` = s.`customer`
        JOIN m_stores st ON st.code=s.`stores`
        WHERE s.`cl`='".$this->sd['cl']."' 
        AND s.bc='".$this->sd['branch']."' 
        AND s.`is_cancel`=0
        AND (s.agr_no LIKE '%$_POST[search]%' OR s.`customer` LIKE '%$_POST[search]%'
            OR c.`name` LIKE '%$_POST[search]%')";

    $query = $this->db->query($sql);
    $a  = "<table id='item_list' style='width : 100%' >";
    $a .= "<thead><tr>";
    $a .= "<th class='tb_head_th'>Agreement No </th>";
    $a .= "<th class='tb_head_th'>Customer</th>";
    $a .= "<th class='tb_head_th'>HP No</th>";
    $a .= "</thead></tr><tr class='cl'><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>";

    foreach($query->result() as $r){
      $a .= "<tr class='cl'>";
      $a .= "<td>".$r->agr_no."</td>";
      $a .= "<td>".$r->customer." - ".$r->cus_name."</td>";
      $a .= "<td>".$r->hp_nno."</td>";
      $a .= "<td style='display: none'>".$r->customer."</td>";
      $a .= "<td style='display: none'>".$r->cus_name."</td>";
      $a .= "<td style='display: none'>".$r->stores."</td>";
      $a .= "<td style='display: none'>".$r->store_des."</td>";
      $a .= "</tr>";
    }
    $a .= "</table>";
    echo $a;
  }

  public function load_items(){
    $sql_s="SELECT agr_no,SUM(i.dr-i.cr) AS arr,  SUM(i.cr) AS paid ,s.`net_amount` 
            FROM t_hp_sales_sum s
            JOIN t_ins_trans i ON i.`cl`=s.`cl` AND i.`bc`=s.`bc` AND i.`agr_no`=s.`agreement_no`
            WHERE s.cl='".$this->sd['cl']."' 
            AND s.bc='".$this->sd['branch']."' 
            AND s.`agreement_no`='".$_POST['agr_no']."'
            GROUP BY agr_no";
    $query_s=$this->db->query($sql_s);

    if($query_s->num_rows()>0){
      $result['sum']=$query_s->result();
    }else{
      $result=2;
    }

    $sql="SELECT s.nno,
            d.`item_code`,
            m.`description` AS item_des,
            b.`purchase_price`,
            b.`min_price`,
            d.`price` AS max_price,
            b.batch_no,
            d.qty
          FROM t_hp_seize_sum s 
          JOIN `t_hp_seize_det` d ON s.`cl`=d.`cl` AND s.`bc`=d.`bc` AND s.`nno`=d.`nno`
          JOIN m_item m ON m.`code`=d.`item_code`
          JOIN t_item_batch b ON b.`item`=d.`item_code` AND b.`batch_no`=d.`batch`
          WHERE d.`cl`='".$this->sd['cl']."' 
          AND d.`bc`='".$this->sd['branch']."' 
          AND status='1'
          AND s.`agr_no`='".$_POST['agr_no']."'";
    $query=$this->db->query($sql);

    if($query->num_rows()>0){
      $result['det']=$query->result();
    }else{
      $result=2;
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
      if($this->user_permissions->is_delete('t_hp_seized_main_store')){
          $trans_no=$_POST['trans_no'];

          $this->db->where('cl',$this->sd['cl']);
          $this->db->where('bc',$this->sd['branch']);
          $this->db->where('trans_type','118');
          $this->db->where('trans_no',$_POST['trans_no']);
          $this->db->delete('t_serial_movement_out');

          $this->db->where('cl',$this->sd['cl']);
          $this->db->where('bc',$this->sd['branch']);
          $this->db->where('trans_type','118');
          $this->db->where('trans_no',$_POST['trans_no']);
          $this->db->delete('t_serial_movement');

          $this->db->where("trans_no",$_POST['trans_no']);
          $this->db->where("trans_code", 118);
          $this->db->where("cl", $this->sd['cl']);
          $this->db->where("bc", $this->sd['branch']);
          $this->db->delete("t_serial_trans");

          $this->db->where('cl',$this->sd['cl']);
          $this->db->where('bc',$this->sd['branch']);
          $this->db->where('trans_type','118');
          $this->db->where('trans_no',$_POST['trans_no']);
          $this->db->delete('t_serial');

          $this->db->where('cl',$this->sd['cl']);
          $this->db->where('bc',$this->sd['branch']);
          $this->db->where('trans_code','118');
          $this->db->where('trans_no',$_POST['trans_no']);
          $this->db->delete('t_account_trans');

          $this->load->model('trans_settlement');
          $this->trans_settlement->delete_item_movement('t_item_movement',118,$_POST['trans_no']);
          $this->trans_settlement->delete_settlement_sub("t_credit_note_trans","118",$trans_no); 

          $sql="SELECT crn_no FROM t_seized_items_main_store_sum
                WHERE cl='".$this->sd['cl']."'
                AND bc='".$this->sd['branch']."'
                AND nno='$trans_no'"; 
          $query=$this->db->query($sql);
          if($query->num_rows()>0){
            $crn=$query->first_row()->crn_no;
          }else{
            $crn=0;
          }

          $data=array('is_cancel'=>'1');

          $this->db->where('cl',$this->sd['cl']);
          $this->db->where('bc',$this->sd['branch']);
          $this->db->where('nno',$crn);
          $this->db->update('t_credit_note',$data);

          $this->db->where('cl',$this->sd['cl']);
          $this->db->where('bc',$this->sd['branch']);
          $this->db->where('nno',$_POST['trans_no']);
          $this->db->update('t_seized_items_main_store_sum',$data);

          $this->utility->save_logger("CANCEL",118,$_POST['trans_no'],$this->mod);  
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

  public function item_code_length($item){
    $status=1;
    for($x=0; $x<25; $x++){
      $itm = strlen($_POST[$item.$x].'SZ');
      if($itm>15){
        $status =  "This item (".$_POST[$item.$x].") code length exceed the character limit";
      }
    }
    return $status;
  }
}
