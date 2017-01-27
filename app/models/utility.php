<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class utility extends CI_Model {
  private $sd;
  function __construct(){
    parent::__construct();
    $this->sd = $this->session->all_userdata();
  }

  public function update_chq_book_status(){
    $num_count=0;
    $sql="SELECT COUNT(*) as num_of_count,nno FROM t_cheque_book_det
    WHERE cl='".$this->sd['cl']."'
    AND bc ='".$this->sd['branch']."'
    GROUP BY nno";

    $query=$this->db->query($sql);
    foreach($query->result() as $row){
      $num_count =$row->num_of_count;
      $sql2="SELECT COUNT(*) as num_of_count ,nno FROM t_cheque_book_det
      WHERE status!='0'
      AND cl='".$this->sd['cl']."'
      AND bc ='".$this->sd['branch']."'
      AND nno='".$row->nno."'";

      $query2=$this->db->query($sql2);

      if((int)$query2->row()->num_of_count == (int)$num_count){
        $sql_c="UPDATE t_cheque_book_sum
        SET status='3'
        WHERE cl='".$this->sd['cl']."' 
        AND bc='".$this->sd['branch']."' 
        AND nno='".$row->nno."'";
        $this->db->query($sql_c);
      }
    }
  }


  public function get_max_no($table_name,$field_name){
    if(isset($_POST['hid'])){
      if($_POST['hid'] == "0" || $_POST['hid'] == ""){      
        $this->db->select_max($field_name);
        $this->db->where("cl",$this->sd['cl']);
        $this->db->where("bc",$this->sd['branch']);    
        return $this->db->get($table_name)->first_row()->$field_name+1;
      }else{
        return $_POST['hid'];  
      }
    }else{
      $this->db->select_max($field_name);
      $this->db->where("cl",$this->sd['cl']);
      $this->db->where("bc",$this->sd['branch']);    
      return $this->db->get($table_name)->first_row()->$field_name+1;
    }
  }


  public function get_max_no_sub2($table_name,$field_name){
    if(isset($_POST['hid_nno'])){
      if($_POST['hid_nno'] == "0" || $_POST['hid_nno'] == ""){      
        $this->db->select_max($field_name);
        $this->db->where("cl",$this->sd['cl']);
        $this->db->where("bc",$this->sd['branch']);    
        return $this->db->get($table_name)->first_row()->$field_name+1;
      }else{
        return $_POST['hid_nno'];  
      }
    }else{
      $this->db->select_max($field_name);
      $this->db->where("cl",$this->sd['cl']);
      $this->db->where("bc",$this->sd['branch']);    
      return $this->db->get($table_name)->first_row()->$field_name+1;
    }
  }


  public function get_max_no_in_type($table_name,$field_name,$type){

    $this->db->select_max($field_name);
    $this->db->where("cl",$this->sd['cl']);
    $this->db->where("bc",$this->sd['branch']);
    $this->db->where("type",$type);     
    return $this->db->get($table_name)->first_row()->$field_name+1;
  }


  public function get_max_no_in_type_echo(){

    $table_name =$_POST['table'];
    $field_name =$_POST['sub_no'];
    $type = $_POST['type'];

    if(isset($_POST['sub_hid'])){
      if($_POST['sub_hid'] == "0" || $_POST['sub_hid'] == ""){      
        $this->db->select_max($field_name);
        $this->db->where("cl",$this->sd['cl']);
        $this->db->where("bc",$this->sd['branch']); 
        $this->db->where("type",$type);   
        echo $this->db->get($table_name)->first_row()->$field_name+1;
      }else{
        echo $_POST['sub_hid'];  
      }
    }else{
      $this->db->select_max($field_name);
      $this->db->where("cl",$this->sd['cl']);
      $this->db->where("bc",$this->sd['branch']);
      $this->db->where("type",$type);     
      echo $this->db->get($table_name)->first_row()->$field_name+1;
    }
  }

  public function get_max_no_in_type_transfer($table_name,$field_name,$type,$t_code){

    $this->db->select_max($field_name);
    $this->db->where("cl",$this->sd['cl']);
    $this->db->where("bc",$this->sd['branch']);
    $this->db->where("type",$type);   
    $this->db->where("trans_code",$t_code);    
    return $this->db->get($table_name)->first_row()->$field_name+1;
  }
  
  public function get_max_no_in_type_transfer_echo(){      
    $table_name =$_POST['table'];
    $field_name =$_POST['sub_no'];
    $type = $_POST['type'];

    if(isset($_POST['sub_hid'])){
      if($_POST['sub_hid'] == "0" || $_POST['sub_hid'] == ""){      
        $this->db->select_max($field_name);
        $this->db->where("cl",$this->sd['cl']);
        $this->db->where("bc",$this->sd['branch']); 
        $this->db->where("trans_code",$_POST['t_code']);
        $this->db->where("type",$type);   
        echo $this->db->get($table_name)->first_row()->$field_name+1;
      }else{
        echo $_POST['sub_hid'];  
      }
    }else{
      $this->db->select_max($field_name);
      $this->db->where("cl",$this->sd['cl']);
      $this->db->where("bc",$this->sd['branch']);
      $this->db->where("type",$type);     
      $this->db->where("trans_code",$_POST['t_code']);
      echo $this->db->get($table_name)->first_row()->$field_name+1;
    }
  }
  

  public function get_max_no_in_type_echo2($table_name,$field_name,$type){

    if(isset($_POST['sub_hid'])){
      if($_POST['sub_hid'] == "0" || $_POST['sub_hid'] == ""){      
        $this->db->select_max($field_name);
        $this->db->where("cl",$this->sd['cl']);
        $this->db->where("bc",$this->sd['branch']); 
        $this->db->where("type",$type);   
        return $this->db->get($table_name)->first_row()->$field_name+1;
      }else{
        return $_POST['sub_hid'];  
      }
    }else{
      $this->db->select_max($field_name);
      $this->db->where("cl",$this->sd['cl']);
      $this->db->where("bc",$this->sd['branch']);
      $this->db->where("type",$type);     
      return $this->db->get($table_name)->first_row()->$field_name+1;
    }
  }



  
  public function save_po_trans($table_name,$code,$trans_code,$trans_no,$sub_trans_code,$sub_trans_no,$request_qty,$received_qty){

   $data=array(
    "cl"=>$this->sd['cl'],
    "bc"=>$this->sd['branch'],
    "item_code"=>$code,
    "trans_code"=>$trans_code,
    "trans_no"=>$trans_no,
    "sub_trans_code"=>$sub_trans_code,
    "sub_trans_no"=>$sub_trans_no,
    "request_qty"=>$request_qty,
    "received_qty"=>$received_qty
    );
   $this->db->insert($table_name,$data);
   
 }

 public function save_po_trans2($table_name,$code,$trans_code,$trans_no,$sub_trans_code,$sub_trans_no,$request_qty,$received_qty,$type){

  $data=array(
    "cl"=>$this->sd['cl'],
    "bc"=>$this->sd['branch'],
    "item_code"=>$code,
    "trans_code"=>$trans_code,
    "trans_no"=>$trans_no,
    "sub_trans_code"=>$sub_trans_code,
    "sub_trans_no"=>$sub_trans_no,
    "request_qty"=>$request_qty,
    "received_qty"=>$received_qty,
    "type"=>$type
    );
  $this->db->insert($table_name,$data);
  
}

public function delete_po_trans($table_name,$trans_code,$trans_no){
  $this->db->where("cl",$this->sd['cl']);
  $this->db->where("bc",$this->sd['branch']);
  $this->db->where("trans_code",$trans_code);
  $this->db->where("trans_no",$trans_no);
  $this->db->delete($table_name);
}

public function delete_po_trans2($table_name,$trans_code,$trans_no,$type){
  $this->db->where("cl",$this->sd['cl']);
  $this->db->where("bc",$this->sd['branch']);
  $this->db->where("trans_code",$trans_code);
  $this->db->where("trans_no",$trans_no);
  $this->db->where("type",$type);
  $this->db->delete($table_name);
}

public function cancel_trans($tb_sum,$nno){
  $this->db->where('cl',$this->sd['cl']);
  $this->db->where('bc',$this->sd['branch']);
  $this->db->where('nno',$nno);
  $this->db->update($tb_sum, array("is_cancel"=>1));
}

public function cancel_transs($tb_sum,$nno,$type){
  $this->db->where('cl',$this->sd['cl']);
  $this->db->where('bc',$this->sd['branch']);
  $this->db->where('nno',$nno);
  $this->db->where('type',$type);
  $this->db->update($tb_sum, array("is_cancel"=>1));
}

public function get_account_balance($acc_code){

  $sql="SELECT IFNULL(SUM(dr_amount)-SUM(cr_amount),0) AS balance FROM t_account_trans WHERE acc_code='$acc_code'";
  return $this->db->query($sql)->first_row()->balance; 
}

public function get_account_balance_voucher(){

  $acc_code = $_POST['code'];
  
  $sql="SELECT IFNULL(SUM(dr_amount)-SUM(cr_amount),0) AS balance FROM t_account_trans WHERE acc_code='$acc_code' 
  AND cl='".$this->sd['cl']."'
  AND bc='".$this->sd['branch']."'
  ";
  echo json_encode($this->db->query($sql)->first_row()->balance); 

}


public function get_account_balance_receipt(){

  $acc_code = $_POST['code'];
  
  $sql="SELECT IFNULL(SUM(dr_amount)-SUM(cr_amount),0) AS balance FROM t_account_trans WHERE acc_code='$acc_code'";
  echo json_encode($this->db->query($sql)->first_row()->balance); 

}


public function get_data_table(){
  echo $this->data_table2();
}

public function data_table2(){
  $this->load->library('table');
  $this->load->library('useclass');
  $this->table->set_template($this->useclass->grid_style());
  $codes=$_POST['code'];
  $tbl=$_POST['tbl'];

  if(isset($_POST['col4'])){
    $pp=explode("-",$_POST['tbl_fied_names']);
    $tbl_field_name1=$pp[0];
    $tbl_field_name2=$pp[1];
    $tbl_field_name3=$pp[2];
    $pp1=explode("-",$_POST['fied_names']);
    
    $field_name1=$pp1[0];
    $field_name2=$pp1[1];
    $field_name3=$pp1[2];
    
    $code = array("data"=>"$tbl_field_name1", "style"=>"width: 100px; cursor : pointer;", "onclick"=>"set_short(1)");
    $des = array("data"=>"$tbl_field_name2", "style"=>"cursor : pointer;", "onclick"=>"set_short(2)");
    $field_head = array("data"=>"$tbl_field_name3", "style"=>"cursor : pointer;", "onclick"=>"set_short(3)");
    $action = array("data"=>"Action", "style"=>"width: 100px;");

    $this->table->set_heading($code, $des, $field_head, $action);

    if(isset($_POST['search_all'])){
      $sql="SELECT `$field_name1`,`$field_name2`, `$field_name3` FROM ".$tbl." WHERE `code` like '%$codes%' OR `$field_name2` like '%$codes%' OR `$field_name3` like '%$codes%'";
    }else{
      $sql="SELECT `$field_name1`,`$field_name2`, `$field_name3` FROM ".$tbl." WHERE `code` like '%$codes%' OR `$field_name2` like '%$codes%' OR `$field_name3` like '%$codes%' LIMIT 10";
    }
    
    $query=$this->db->query($sql);

    if(isset($_POST['is_r'])){
      if($_POST['is_r']=="Y"){
        foreach($query->result() as $r){
          $but = "<img src='".base_url()."img/edit.gif' onclick='set_edit(\"".$r->code."-".$r->$field_name1."\")' title='Edit' />&nbsp;&nbsp;";
          $but .= "<img src='".base_url()."img/delete.gif' onclick='set_delete(\"".$r->code."-".$r->$field_name1."\")' title='Delete' />";
          $ed = array("data"=>$but, "style"=>"text-align: center; width: 100px;");
          $des = array("data"=>$this->useclass->limit_text($r->$field_name2, 50), "style"=>"text-align: left;");
          $field_body = array("data"=>$this->useclass->limit_text($r->$field_name3, 50), "style"=>"text-align: left;");
          $code = array("data"=>$r->$field_name1, "style"=>"text-align: left; width: 100px; ", "value"=>"code");
          
          $this->table->add_row($code, $des, $field_body, $ed);
        }
      }
    }else{
      foreach($query->result() as $r){
              //var_dump($r->$field_name2,$r->$field_name3,$r->code,$r->$field_name1);
        $but = "<img src='".base_url()."img/edit.gif' onclick='set_edit(\"".$r->code."\")' title='Edit' />&nbsp;&nbsp;";
        $but .= "<img src='".base_url()."img/delete.gif' onclick='set_delete(\"".$r->code."\")' title='Delete' />";
        $ed = array("data"=>$but, "style"=>"text-align: center; width: 100px;");
        $des = array("data"=>$this->useclass->limit_text($r->$field_name2, 50), "style"=>"text-align: left;");
        $field_body = array("data"=>$this->useclass->limit_text($r->$field_name3, 50), "style"=>"text-align: left;");
        $code = array("data"=>$r->$field_name1, "style"=>"text-align: left; width: 100px; ", "value"=>"code");
        
        $this->table->add_row($code, $des, $field_body, $ed);
      }

    }

    
  }

  else if(isset($_POST['item'])){
    $sale_prices=$this->use_sale_prices(); 
    $code = array("data"=>"Code", "style"=>"width: 80px; cursor : pointer;");
    $des = array("data"=>"Description", "style"=>"width: 150px;");
    if($sale_prices['min']=='1'){
      $min = array("data"=>"Min Price", "style"=>"width: 80px;");
    }else{
      $min ="";     
    }if($sale_prices['max']=='1'){
      $max = array("data"=>"Max Price", "style"=>"width: 80px;");
    }else{
      $max ="";     
    }if($sale_prices['cost']=='1'){
      $pur = array("data"=>"Cost", "style"=>"width: 100px;");
    }else{
      $pur ="";     
    }if($sale_prices['is_sale_3']=='1'){
      $s3 = array("data"=>$sale_prices['def_sale_3'], "style"=>"width: 100px;");
    }else{
      $s3 ="";     
    }if($sale_prices['is_sale_4']=='1'){
      $s4 = array("data"=>$sale_prices['def_sale_4'], "style"=>"width: 100px;");
    }else{
      $s4 ="";     
    }if($sale_prices['is_sale_5']=='1'){
      $s5 = array("data"=>$sale_prices['def_sale_5'], "style"=>"width: 100px;");
    }else{
      $s5 ="";     
    }if($sale_prices['is_sale_6']=='1'){
      $s6 = array("data"=>$sale_prices['def_sale_6'], "style"=>"width: 100px;");
    }else{
      $s6 ="";     
    }
    $action = array("data"=>"Action", "style"=>"width: 80px;");

    $this->table->set_heading($code, $des, $min,$max, $pur,$s3,$s4,$s5,$s6,$action);

    $sql="SELECT `inactive`, `code`, `description`, `max_price`, `min_price`, `purchase_price`,sale_price_3,sale_price_4,sale_price_5,sale_price_6 FROM ".$tbl." WHERE bc='".$this->sd['branch']."' AND (`code` like '%$codes%' OR `description` like '%$codes%' OR `max_price` like '%$codes%' OR `min_price` like '%$codes%' OR `purchase_price` like '%$codes%' OR `model` like '%$codes%' )LIMIT 10";
    
    $query=$this->db->query($sql);


    foreach($query->result() as $r){
      if($r->inactive=="1"){
        $but = "<img src='".base_url()."img/edit.gif' onclick='set_edit(\"".$r->code."\")' title='Edit' />&nbsp;&nbsp;";
        $but .= "<img src='".base_url()."img/delete.gif' onclick='set_delete(\"".$r->code."\")' title='Delete' />";
        $ed = array("data"=>$but, "style"=>"text-align: center; background-color: #DE4B3F;");
        $code = array("data"=>$r->code, "value"=>"code", "style"=>"background-color: #DE4B3F;");
        $des = array("data"=>$this->useclass->limit_text($r->description, 50), "style"=>"text-align: left; background-color: #DE4B3F;");
        if($sale_prices['max']=='1'){
          $max = array("data"=>number_format($r->max_price, 2, ".", ","), "style"=>"text-align: right; background-color: #DE4B3F;");
        }else{
          $max =array("style"=>"border:none;padding: 0px;");       
        }if($sale_prices['min']=='1'){
          $min = array("data"=>number_format($r->min_price, 2, ".", ","), "style"=>"text-align: right; background-color: #DE4B3F;");
        }else{
          $min =array("style"=>"border:none;padding: 0px;");       
        }if($sale_prices['cost']=='1'){
          $pur = array("data"=>number_format($r->purchase_price, 2, ".", ","), "style"=>"text-align: right; background-color: #DE4B3F;");
        }else{
          $pur =array("style"=>"border:none;padding: 0px;");       
        }if($sale_prices['is_sale_3']=='1'){
          $s3 = array("data"=>number_format($r->sale_price_3, 2, ".", ","), "style"=>"text-align: right; background-color: #DE4B3F;");
        }else{
          $s3 =array("style"=>"border:none;padding: 0px;");  
        }if($sale_prices['is_sale_4']=='1'){
          $s4 =array("data"=>number_format($r->sale_price_4, 2, ".", ","), "style"=>"text-align: right; background-color: #DE4B3F;");
        }else{
          $s4 =array("style"=>"border:none;padding: 0px;");      
        }if($sale_prices['is_sale_5']=='1'){
          $s5 = array("data"=>number_format($r->sale_price_5, 2, ".", ","), "style"=>"text-align: right; background-color: #DE4B3F;");
        }else{
          $s5 =array("style"=>"border:none;padding: 0px;");      
        }if($sale_prices['is_sale_6']=='1'){
          $s6 = array("data"=>number_format($r->sale_price_6, 2, ".", ","), "style"=>"text-align: right; background-color: #DE4B3F;");
        }else{
          $s6 =array("style"=>"border:none;padding: 0px;");     
        }
      }else{
        $but = "<img src='".base_url()."img/edit.gif' onclick='set_edit(\"".$r->code."\")' title='Edit' />&nbsp;&nbsp;";
        $but .= "<img src='".base_url()."img/delete.gif' onclick='set_delete(\"".$r->code."\")' title='Delete' />";
        $ed = array("data"=>$but, "style"=>"text-align: center;");
        $code = array("data"=>$r->code, "value"=>"code");
        $des = array("data"=>$this->useclass->limit_text($r->description, 50), "style"=>"text-align: left;");
        if($sale_prices['max']=='1'){
          $max = array("data"=>number_format($r->max_price, 2, ".", ","), "style"=>"text-align: right;");
        }else{
          $max =array("style"=>"border:none;padding: 0px;");       
        }if($sale_prices['min']=='1'){
          $min = array("data"=>number_format($r->min_price, 2, ".", ","), "style"=>"text-align: right;");
        }else{
          $min =array("style"=>"border:none;padding: 0px;");       
        }if($sale_prices['cost']=='1'){
          $pur = array("data"=>number_format($r->purchase_price, 2, ".", ","), "style"=>"text-align: right;");
        }else{
          $pur =array("style"=>"border:none;padding: 0px;");       
        }if($sale_prices['is_sale_3']=='1'){
          $s3 = array("data"=>number_format($r->sale_price_3, 2, ".", ","), "style"=>"text-align: right;");
        }else{
          $s3 =array("style"=>"border:none;padding: 0px;");  
        }if($sale_prices['is_sale_4']=='1'){
          $s4 =array("data"=>number_format($r->sale_price_4, 2, ".", ","), "style"=>"text-align: right;");
        }else{
          $s4 =array("style"=>"border:none;padding: 0px;");      
        }if($sale_prices['is_sale_5']=='1'){
          $s5 = array("data"=>number_format($r->sale_price_5, 2, ".", ","), "style"=>"text-align: right;");
        }else{
          $s5 =array("style"=>"border:none;padding: 0px;");      
        }if($sale_prices['is_sale_6']=='1'){
          $s6 = array("data"=>number_format($r->sale_price_6, 2, ".", ","), "style"=>"text-align: right;");
        }else{
          $s6 =array("style"=>"border:none;padding: 0px;");     
        }
      }
      $this->table->add_row($code, $des, $min, $max, $pur,$s3,$s4, $s5,$s6, $ed);
    }
  }



  
  else if(isset($_POST['itemFree'])){

    $code = array("data"=>"No", "style"=>"width: 50px;");
    $item = array("data"=>"Item", "style"=>"width: 50px;");
    $description = array("data"=>"Description", "style"=>"");
    $from = array("data"=>"From Date", "style"=>"width: 60px;");
    $to = array("data"=>"To Date", "style"=>"width: 50px;");
    $action = array("data"=>"Action", "style"=>"width: 60px;");
    
    $this->table->set_heading($code,$item, $description, $from,$to,$action);
    
    $sql="SELECT `code`, `nno`, `description`, `date_from`, `date_to` FROM ".$tbl." WHERE `code` like '%$codes%' OR `description` like '%$codes%' OR `nno` like '%$codes%' OR `date_from` like '%$codes%' OR `date_to` like '%$codes%'LIMIT 10";
    $query=$this->db->query($sql);

    
    foreach($query->result() as $r){
      $but = "<img src='".base_url()."img/edit.gif' onclick='set_edit(\"".$r->nno."\")' title='Edit' />&nbsp;&nbsp;";
      $but .= "<img src='".base_url()."img/delete.gif' onclick='set_delete(\"".$r->nno."\")' title='Delete' />";
      
      $no = array("data"=>$r->nno);
      $item = array("data"=>$r->code);
      $description = array("data"=>$this->useclass->limit_text($r->description, 25));
      $from = array("data"=>$r->date_from);
      $to = array("data"=>$r->date_to);
      $action = array("data"=>$but, "style"=>"text-align: center;");
      
      $this->table->add_row($no, $item, $description, $from,$to, $action);
    }
    
  }else{
    $pp=explode("-",$_POST['tbl_fied_names']);
    $tbl_field_name1=$pp[0];
    $tbl_field_name2=$pp[1];
    $pp1=explode("-",$_POST['fied_names']);

    $field_name1=$pp1[0];
    $field_name2=$pp1[1];
    
    $code = array("data"=>"$tbl_field_name1", "style"=>"width: 100px; cursor : pointer;", "onclick"=>"set_short(1)");
    $des = array("data"=>"$tbl_field_name2", "style"=>"cursor : pointer;", "onclick"=>"set_short(2)");
    $action = array("data"=>"Action", "style"=>"width: 100px;");
    $this->table->set_heading($code, $des, $action);

    $sql="SELECT `$field_name1`,`$field_name2` FROM ".$tbl." WHERE `code` like '%$codes%' OR `$field_name2` like '%$codes%' LIMIT 10";
    $query=$this->db->query($sql);
    foreach($query->result() as $r){
      $but = "<img src='".base_url()."img/edit.gif' onclick='set_edit(\"".$r->code."\")' title='Edit' />&nbsp;&nbsp;";
      $but .= "<img src='".base_url()."img/delete.gif' onclick='set_delete(\"".$r->code."\")' title='Delete' />";
      $ed = array("data"=>$but, "style"=>"text-align: center; width: 100px;");
      $des = array("data"=>$this->useclass->limit_text($r->$field_name2, 50), "style"=>"text-align: left;");
      $code = array("data"=>$r->code, "style"=>"text-align: left; width: 100px; ", "value"=>"code");
      $this->table->add_row($code, $des, $ed);
    }
  }        
  return $this->table->generate();
}



public function batch_update($item_pre,$batch_pre,$qty_pre,$foc_pre=0){
  $status=1;
  $cl=$this->sd['cl'];
  $bc=$this->sd['branch'];
  $store=$_POST['stores'];
  for($x = 0; $x<25; $x++){
    if(isset($_POST[$item_pre.$x]) && !empty($_POST[$item_pre.$x])) {
          //if($this->check_is_batch_item($_POST[$item_pre.$x])){
      $batch_no=$_POST[$batch_pre.$x];
      $item=$_POST[$item_pre.$x];
      $quantity=(int)$_POST[$qty_pre.$x];
      $foc=($foc_pre==0)?0:(int)$_POST[$foc_pre.$x];
      $total_qty=$quantity+$foc;

      $sql="SELECT IFNULL(qty,0) AS qty FROM qry_current_stock  WHERE batch_no='$batch_no' AND store_code='$store' AND item='$item' AND cl='$cl'  AND bc='$bc'";
      
      $query=$this->db->query($sql);
      if($query->num_rows()>0){
        $actual_qty=(int)$query->first_row()->qty; 
      }else{
        $actual_qty=(int)0;
      }

      
      if($actual_qty<$total_qty){
        $status="This item ".$item." not enough quantity.";
      }
      
          //}
    }
  }
  return $status;
}



public function batch_updatee($item_pre,$batch_pre,$qty_pre,$foc_pre=0){
  $status=1;
  $cl=$this->sd['cl'];
  $bc=$this->sd['branch'];
  $store=$_POST['store_from'];
  for($x = 0; $x<25; $x++){
    if(isset($_POST[$item_pre.$x]) && !empty($_POST[$item_pre.$x])) {
          //if($this->check_is_batch_item($_POST[$item_pre.$x])){

      $batch_no=$_POST[$batch_pre.$x];
      $item=$_POST[$item_pre.$x];
      $quantity=(int)$_POST[$qty_pre.$x];
      $foc=($foc_pre==0)?0:(int)$_POST[$foc_pre.$x];
      $total_qty=$quantity+$foc;

      $sql="SELECT IFNULL(qty,0) AS qty FROM qry_current_stock  WHERE batch_no='$batch_no' AND store_code='$store' AND item='$item' AND cl='$cl'  AND bc='$bc'";
      
      $query=$this->db->query($sql);
      if($query->num_rows()>0){
        $actual_qty=(int)$query->first_row()->qty; 
      }else{
        $actual_qty=(int)0;
      }

      
      if($actual_qty<$total_qty){
        $status="This item ".$item." not enough quantity.";
      }
      
          //}
    }
  }
  return $status;
}


public function batch_update2($item_pre,$batch_pre,$qty_pre,$store){
  $status=1;
  if(isset($_POST['transCode'])){
    if($_POST['transCode']=="121"){
      $cl=$_POST['location_cl'];
      $bc=$_POST['location_bc'];
    }else{
      $cl=$this->sd['cl'];
      $bc=$this->sd['branch'];
    }
  }else{
    $cl=$this->sd['cl'];
    $bc=$this->sd['branch'];
  }
  
  switch($_POST['transtype']){
    case 'DAMAGE NOTE':
    $table='t_damage_det';
    break;  
    case 'DISPATCH LOADING':
    $table='t_loading_det';
    break;
    case 'DISPATCH UNLOADING':
    $table='t_unloading_det';
    break;
    case 'DISPATCH NOTE':
    $table='t_dispatch_det';
    break;      
    
    default:$table="";
    break;   
  }


  
  for($x = 0; $x<25; $x++){
    if(isset($_POST[$item_pre.$x]) && !empty($_POST[$item_pre.$x])) {
          //if($this->check_is_batch_item($_POST[$item_pre.$x])){
      $batch_no=$_POST[$batch_pre.$x];
      $item=$_POST[$item_pre.$x];
      $quantity=(int)$_POST[$qty_pre.$x];
      $total_qty=$quantity;
      $no=$_POST['hid'];



      if(isset($_POST['hid']) && $_POST['hid']=="0"){
        $sql="SELECT IFNULL(qty,0) AS qty FROM qry_current_stock WHERE batch_no='$batch_no' AND store_code='$store' AND item='$item' AND cl='$cl'  AND bc='$bc'";
        
        $query=$this->db->query($sql);
        if($query->num_rows()>0){
          $actual_qty=(int)$query->first_row()->qty; 
        }else{
          $actual_qty=(int)0;
        }

        
        if($actual_qty<$total_qty){
          $status="This (".$item.") does not have enough quantity in this batch(".$batch_no.")";
        }

      }else{

        $sql="SELECT IFNULL(SUM(qry_current_stock.`qty`) + SUM(c.qty),SUM(qry_current_stock.`qty`)) as qty FROM (`qry_current_stock`)  
        LEFT JOIN (SELECT qty,code,batch_no,cl,bc FROM $table WHERE  `batch_no` = '$batch_no'  AND  nno='$no' AND `code` = '$item') c 
        ON c.code=qry_current_stock.`item` AND c.cl=qry_current_stock.cl AND c.bc=qry_current_stock.bc AND c.batch_no=qry_current_stock.batch_no
        WHERE qry_current_stock.`batch_no` = '$batch_no' AND qry_current_stock.`store_code` = '$store' AND `item` = '$item'
        ";
        
        foreach($this->db->query($sql)->result() as $row){
          $actual_qty=(int)$row->qty; 
        }
        if($actual_qty<$total_qty){
          $status="This (".$item.") does not have enough quantity in this batch(".$batch_no.")";
        }
      }

      
          //}
    }
  }
  return $status;
}


public function batch_update3($item_pre,$batch_pre,$qty_pre){
  $status=1;
  $cl=$this->sd['cl'];
  $bc=$this->sd['branch'];
  
  for($x = 0; $x<25; $x++){
    if(isset($_POST[$item_pre.$x]) && !empty($_POST[$item_pre.$x])) {
          //if($this->check_is_batch_item($_POST[$item_pre.$x])){
      $batch_no=$_POST[$batch_pre.$x];
      $item=$_POST[$item_pre.$x];
      $quantity=(int)$_POST[$qty_pre.$x];
      $total_qty=$quantity;


      $sql="SELECT IFNULL(qty,0) AS qty FROM qry_current_stock  WHERE batch_no='$batch_no' AND item='$item' AND cl='$cl'  AND bc='$bc'";
      
      $query=$this->db->query($sql);
      if($query->num_rows()>0){
        $actual_qty=(int)$query->first_row()->qty; 
      }else{
        $actual_qty=(int)0;
      }

      
      if($actual_qty<$total_qty){
        $status="This (".$item.") does not have enough quantity in this batch(".$batch_no.")";
      }
      
          //}
    }
  }

  return $status;
}

public function check_is_batch_item($code){
 $this->db->select(array('batch_item'));
 $this->db->where("code",$code);
 $this->db->limit(1);
 $result=$this->db->get("m_item");
 
 foreach($result->result() as $row){
  return $row->batch_item;
}
}

public function has_serial($items){
  $wordChunks = explode(",",$items);
  $status=1;
  for($x = 0; $x<25; $x++){
    for($i = 0; $i < count($wordChunks); $i++){
      $p=explode("-", $wordChunks[$i]);
      
      $this->db->where('item',$p[0]);
      $this->db->where('serial_no', $p[1]); 
      $this->db->where("cl",$this->sd['cl']);
      $this->db->where("bc",$this->sd['branch']);
      $query=$this->db->get('t_serial_movement_out');
      if($query->num_rows()>0){
        $status=0;
      }

      if($status=='0'){
        break;                  
      }
    }
  }
  echo $status;
}

public function is_batch_item($code){
 $this->db->select(array('batch_item'));
 $this->db->where("code",$code);
 $this->db->limit(1);
 $result=$this->db->get("m_item");
 foreach($result->result() as $row){
  return $row->batch_item;
}  

}  

public function check_last_price($item_pre,$price_pre,$n_m_price_pre)
{
  $status=1;

  for($x = 0; $x<25; $x++){

    $item_code=$_POST[$item_pre.$x];
    $price=(float)$_POST[$price_pre.$x];
    $n_max=(float)$_POST[$n_m_price_pre.$x];

    $this->db->select(array('max_price'));
    $this->db->where('code',$item_code);
    $query=$this->db->get('m_item');

    if($query->num_rows()>0){
      foreach($query->result() as $row){
        $max_price=(float)$row->max_price;
        
        if($price>$max_price){
          $status="This ".$item_code." new last price should be lower than (Rs ".$max_price."/=)";
        }
        else if($n_max<$max_price){
          $status="This ".$item_code." new max price should be greater than (Rs ".$max_price."/=)";
        }            
      }
    }
  }
  return $status; 
}


public function check_min_price($item_pre,$price_pre,$field,$chk_price){
  $status=1;

  for($x = 0; $x<25; $x++){

    $item_code=$_POST[$item_pre.$x];
    $price=(float)$_POST[$price_pre.$x];

    $this->db->select(array($field));
    $this->db->where('code',$item_code);
    $query=$this->db->get('m_item');
    if($chk_price=='p')
    {
      if($query->num_rows()>0){
        foreach($query->result() as $row){
          $purchase_price=(float)$row->purchase_price;
          
          if($price<$purchase_price){
            $status="This ".$item_code." new min price should be greater than (Rs ".$purchase_price."/=)";
          }            
        }
      }
    }
    elseif($chk_price=='c') 
    {
      if($query->num_rows()>0){
        foreach($query->result() as $row){
          $min_price=(float)$row->min_price;
          
          if($price>$min_price){
            $status="This ".$item_code." cost should be lower than (Rs ".$min_price."/=)";
          }            
        }
      }
    }
  }
  return $status; 
}

public function check_min_price2($item_pre,$price_pre,$field,$chk_price){
  $status=1;

  for($x = 0; $x<25; $x++){

    $item_code=$_POST[$item_pre.$x];
    $price=(float)$_POST[$price_pre.$x];

    $this->db->select(array($field));
    $this->db->where('code',$item_code);
    $query=$this->db->get('m_item');
    if($chk_price=='p')
    {
      if($query->num_rows()>0){
        foreach($query->result() as $row){
          $purchase_price=(float)$row->purchase_price;
          
          if($price<$purchase_price){
            $status="This ".$item_code." new min price should be greater than (Rs ".$purchase_price."/=)";
          }            
        }
      }
    }
    elseif($chk_price=='c') 
    {
      if($query->num_rows()>0){
        foreach($query->result() as $row){
          $min_price=(float)$row->min_price;
          
          if($price>$min_price){
            $status="This ".$item_code." cost should be lower than (Rs ".$min_price."/=)";
          }            
        }
      }
    }
  }
  return $status; 
}


public function check_item_with_grn_no($grn_no,$item_pre){
  $status=1;
  $cl=$this->sd['cl'];
  $bc=$this->sd['branch'];

  for($x = 0; $x<20; $x++){
    $item_code=$_POST[$item_pre.$x];
    if(isset($_POST[$item_pre.$x]) && !empty($_POST[$item_pre.$x])){
      $this->db->where('bc',$bc);
      $this->db->where('cl',$cl);
      $this->db->where('nno',$grn_no);
      $this->db->where('code',$item_code);
      $count=$this->db->get('t_grn_det')->num_rows();
      if($count==0){
        $status="Invalid item( ".$item_code. ") with GRN No";
      }  
    }
  }
  return $status; 
}


public function check_item_with_invoice($inv_no,$item_pre,$ptype){
  $status=1;
  $cl=$this->sd['cl'];
  $bc=$this->sd['branch'];
  $item_col="code";

  if($ptype=='4'){
    $ptype='t_cash_sales_det';
  }else if($ptype=='5'){
    $ptype='t_credit_sales_det';
  }else if($ptype=='6'){
    $ptype='t_hp_sales_det';
    $item_col="item_code";
  }
  

  for($x = 0; $x<25; $x++){
    $item_code=$_POST[$item_pre.$x];
    if(isset($_POST[$item_pre.$x]) && !empty($_POST[$item_pre.$x])){
      $this->db->where('bc',$bc);
      $this->db->where('cl',$cl);
      $this->db->where('nno',$inv_no);
      $this->db->where($item_col,$item_code);
      $count=$this->db->get($ptype)->num_rows();
      if($count==0){
        $status="Invalid item( ".$item_code. ") with invoce no";
      }  
    }
  }
  return $status; 
}

public function get_max_no_in_type_echo2_transfer($table_name,$field_name,$type,$t_code){

  if(isset($_POST['sub_hid'])){
    if($_POST['sub_hid'] == "0" || $_POST['sub_hid'] == ""){      
      $this->db->select_max($field_name);
      $this->db->where("cl",$this->sd['cl']);
      $this->db->where("bc",$this->sd['branch']); 
      $this->db->where("type",$type);   
      $this->db->where("trans_code",$t_code); 
      return $this->db->get($table_name)->first_row()->$field_name+1;
    }else{
      return $_POST['sub_hid'];  
    }
  }else{
    $this->db->select_max($field_name);
    $this->db->where("cl",$this->sd['cl']);
    $this->db->where("bc",$this->sd['branch']);
    $this->db->where("type",$type);     
    $this->db->where("trans_code",$t_code); 
    return $this->db->get($table_name)->first_row()->$field_name+1;
  }
}

public function check_return_qty($item_pre,$qty_pre,$inv_no,$tbl){
  $status=1;
  $cl=$this->sd['cl'];
  $bc=$this->sd['branch'];
  $item_col="code";

  if($tbl=='4'){
    $tbl ="t_cash_sales_det";
  }else if($tbl=='5'){
    $tbl ="t_credit_sales_det";
  }else if($tbl=='6'){
    $tbl ="t_grn_det";
  }else if($tbl=='7'){
    $tbl ="t_hp_sales_det";
    $item_col="item_code";
  }

  for($x = 0; $x<20; $x++){
    $item_code=$_POST[$item_pre.$x];
    $qty = $_POST[$qty_pre.$x];
    $sql="SELECT SUM(`qty`-`return_qty`) as return_qty FROM $tbl 
    WHERE $item_col='$item_code' AND nno='$inv_no' AND cl='$cl' AND bc='$bc'"; 
    
    foreach($this->db->query($sql)->result() as $row){
      $return_qty=(int)$row->return_qty;
      
      if($qty>$return_qty){
        $status="This ".$item_code." maximum available quntity is ".$return_qty."";
      }            
    } 
  }
  return $status; 
}


public function check_item_price($item_pre,$inv_no,$type,$c_price){
  $status =1;
  $cl=$this->sd['cl'];
  $bc=$this->sd['branch'];

  for($x=0; $x<20; $x++){

    $item_code=$_POST[$item_pre.$x];
    $invoce=$inv_no;
    $sale_type=$type;
    $price=$_POST[$c_price.$x];

    if($sale_type==4){
      $sale_type="t_cash_sales_det";
    }
    else if($sale_type==5){
      $sale_type="t_credit_sales_det";
    }
    else if($sale_type==6){
      $sale_type="t_grn_det";
    }

    $sql="SELECT `price` FROM $sale_type
    WHERE `cl` = '$cl' AND `bc` ='$bc' 
    AND `code` ='$item_code' AND `nno` ='$invoce'";
    foreach($this->db->query($sql)->result()as $row){
      $actual_price=(float)$row->price;
      if($price!=$actual_price)
      {
        $status="This ".$item_code." actual price is ".$actual_price."";
      }
    }     
  }
  return $status; 
}

public function get_max_price($item){
  $this->db->select('max_price');
  $this->db->where('code',$item);
  return $this->db->get('m_item')->first_row()->max_price;
}

public function get_min_price($item){
  $this->db->select('min_price');
  $this->db->where('code',$item);
  return $this->db->get('m_item')->first_row()->min_price;
}

public function get_cost_price($item){
  $this->db->select('purchase_price');
  $this->db->where('code',$item);
  $query=$this->db->get('m_item');
  foreach($query->result() as $row){
    return $row->purchase_price;
  }
}  

public function get_default_acc($code){
  $this->db->select(array('acc_code'));
  $this->db->where('code',$code);
  return $this->db->get('m_default_account')->first_row()->acc_code;
}

public function get_qty(){
  $item=$_POST['item'];
  $batch=$_POST['batch'];
  $store=$_POST['store'];
  $cl=$this->sd['cl'];
  $bc=$this->sd['branch'];
  $sql3="SELECT qty FROM qry_current_stock WHERE item='$item' AND batch_no='$batch' AND cl='$cl' AND bc='$bc' AND store_code='$store'";
  $query3 = $this->db->query($sql3);
  if ($query3->num_rows() > 0) {
    $a['qty'] = $query3->result();
  } else {
    $a['qty'] = 2;
  }
  echo json_encode($a);
}




public function is_sub_item(){
  $item=$_POST['code'];
  $sql="SELECT sub_item,r_sub_item.`description`
  FROM m_item
  JOIN m_item_sub ON m_item_sub.`item_code`=m_item.`code`
  JOIN r_sub_item ON r_sub_item.`code`=m_item_sub.`sub_item`
  WHERE m_item.code='".$item."'";
  $query = $this->db->query($sql);
  if ($query->num_rows() > 0){
    echo "1";
  }else{
    echo "0";
  }
}


public function sub_item(){
  $item=$_POST['search'];
  $batch=$_POST['batch'];

  $sql="SELECT s.sub_item , r.`description`,r.qty
  FROM t_item_movement_sub s
  JOIN r_sub_item r ON r.`code`=s.`sub_item`
  WHERE s.`item`='$item' AND s.cl='".$this->sd['cl']."' AND s.bc ='".$this->sd['branch']."' AND s.`batch_no`='$batch' 
  GROUP BY r.`code`";
  
  $query = $this->db->query($sql);

  $a = "<table id='batch_item_list' style='width : 100%' >";
  $a .= "<thead><tr>";
  $a .= "<th class='tb_head_th' style='width:30%'>Sub Item Code</th>";
  $a .= "<th class='tb_head_th'>Description</th>";
  $a .= "<th class='tb_head_th'>Qty</th>";

  $a .= "</thead></tr>";
  $a .= "<tr class='cl'>";
  $a .= "<td>&nbsp;</td>";
  $a .= "<td>&nbsp;</td>";
  $a .= "<td>&nbsp;</td>";
  
  $a .= "</tr>";
  foreach ($query->result() as $r) {
    $a .= "<tr class='cl'>";
    $a .= "<td>" . $r->sub_item . "</td>";
    $a .= "<td>" . $r->description . "</td>";
    $a .= "<td>" . $r->qty . "</td>";
    $a .= "</tr>";
  }
  $a .= "</table>";
  
  echo $a;
}



public function sub_item_window(){
  $item=$_POST['search'];
  $sql="SELECT sub_item,r_sub_item.`description`,qty
  FROM m_item
  JOIN m_item_sub ON m_item_sub.`item_code`=m_item.`code`
  JOIN r_sub_item ON r_sub_item.`code`=m_item_sub.`sub_item`
  WHERE m_item.code='".$item."'";
  
  $query = $this->db->query($sql);

  $a = "<table id='batch_item_list' style='width : 100%' >";
  $a .= "<thead><tr>";
  $a .= "<th class='tb_head_th' style='width:30%'>Sub Item Code</th>";
  $a .= "<th class='tb_head_th'>Description</th>";
  $a .= "<th class='tb_head_th'>Quantity</th>";
  $a .= "<th class='tb_head_th'>Approve</th>";

  $a .= "</thead></tr>";
  $a .= "<tr class='cl'>";
  $a .= "<td>&nbsp;</td>";
  $a .= "<td>&nbsp;</td>";
  $a .= "<td>&nbsp;</td>";
  
  $a .= "</tr>";
  $t=0;
  foreach ($query->result() as $r) {

    $a .= "<tr class='cl'>";
    $a .= "<td id='sub_".$t."'>" . $r->sub_item . "</td>";
    $a .= "<td id='subdes_".$t."'>"  . $r->description . "</td>";
    $a .= "<td id='subqty_".$t."'>"  . $r->qty . "</td>";
    $a .= "<td><input type='checkbox' name='chkd' class='approve' id='app_".$t."'/></td>";
    $a .= "</tr>";
    $t++;
  }
  $a .= "</table>";
  
  echo $a;

}

public function get_item_detail(){
  $this->db->select(array('code','description','model','purchase_price','min_price','max_price'));
  $this->db->where('code',$_POST['code']);
  $query=$this->db->get('m_item');

  $this->db->select(array('qty'));
  $this->db->where('store_code',$_POST['store']);
  $this->db->where('bc',$this->sd['branch']);
  $this->db->where('cl',$this->sd['cl']);
  $this->db->where('item',$_POST['code']);
  $qury=$this->db->get('qry_current_stock');

  $code=$description=$model=$qty=$purchase_price=$max_price=$min_price="";
  
  
  foreach($qury->result() as $row){
    $qty=$row->qty;
  }

  if($query->num_rows()>0){
    foreach($query->result() as $row){
      $code=$row->code;
      $description=$row->description;
      $model=$row->model;
      $purchase_price=$row->purchase_price;
      $max_price=$row->max_price;
      $min_price=$row->min_price;
      $min_pre=number_format(((float)$min_price-(float)$purchase_price)*100/$purchase_price,2);
      $max_pre=number_format(((float)$max_price-(float)$purchase_price)*100/$purchase_price,2);
    }

    $html="<table style='width:100%;margin-top:20px;'>
    <tr style='background:#AAA;color:#fff;text-align:center;font-weight:bold;'><td colspan='2'>ITEM DETAILS</td></tr>
    <tr style='background:#CCC;color:#fff;font-weight:bold;'><td colspan='2'>Code</td></tr>
    <tr><td colspan='2'>".$code."</td></tr>
    <tr style='background:#CCC;color:#fff;'><td colspan='2'>Description</td></tr>
    <tr><td colspan='2'>".$description."</td></tr>
    <tr style='background:#CCC;color:#fff;'><td colspan='2'>Model</td></tr>
    <tr><td colspan='2'>".$model."</td></tr>
    <tr><td colspan='2'><hr/></td></tr>

    <tr><td>Quantity</td><td>".$qty."</td></tr>
    <tr><td colspan='2'><hr/></td></tr>

    <tr><td>Purchase Price</td><td>".$purchase_price."</td></tr>
    <tr><td>Max Price</td><td>".$max_price."</td></tr>
    <tr><td>Min Price</td><td>".$min_price."</td></tr>
    <tr><td colspan='2'><hr/></td></tr>

    <tr><td>Max %</td><td>".$max_pre."</td></tr>
    <tr><td>Min %</td><td>".$min_pre."</td></tr>

    ";
    echo $html.="</table>";
  }else{
    echo "0";
  } 
  
}

public function item_detail_with_po(){
  $this->db->select(array('code','description','model','purchase_price','min_price','max_price'));
  $this->db->where('code',$_POST['code']);
  $query=$this->db->get('m_item');

  $this->db->select(array('qty'));
  $this->db->where('store_code',$_POST['store']);
  $this->db->where('bc',$this->sd['branch']);
  $this->db->where('cl',$this->sd['cl']);
  $this->db->where('item',$_POST['code']);
  $qury=$this->db->get('qry_current_stock');

  $total_qty=0;
  $balance_qty=0;
  if($_POST['po']!=""){
    $this->db->select(array('qty'));
    $this->db->where('nno',$_POST['po']);
    $this->db->where('bc',$this->sd['branch']);
    $this->db->where('cl',$this->sd['cl']);
    $this->db->where('item',$_POST['code']);
    $query2=$this->db->get('t_po_det');
    
    if($query2->num_rows()>0){
      $total_qty=$this->db->get('t_po_det')->row()->qty;
    }

    $sql="SELECT SUM(request_qty)-SUM(received_qty) AS balance FROM t_po_trans WHERE trans_no='$_POST[po]' AND item_code='$_POST[code]'";
    $query2=$this->db->query($sql);

    if($query2->num_rows()>0){
      $balance_qty=$query2->row()->balance;
    }
  }



  if($_POST['qty']==""){$_POST['qty']=0;}  
  $code=$description=$model=$qty=$purchase_price=$max_price=$min_price="";
  
  foreach($qury->result() as $row){
    $qty=$row->qty;
  }

  if($query->num_rows()>0){
    foreach($query->result() as $row){
      $code=$row->code;
      $description=$row->description;
      $model=$row->model;
      $purchase_price=$row->purchase_price;
      $max_price=$row->max_price;
      $min_price=$row->min_price;
      $min_pre=number_format(((float)$min_price-(float)$purchase_price)*100/$purchase_price,2);
      $max_pre=number_format(((float)$max_price-(float)$purchase_price)*100/$purchase_price,2);
    }

    $html="
    <h3 id='hed1'>Item Detail</h3>
    <div class='sub-content' id='sub1'>
      <table style='width:100%;margin-top:20px;'>
        <tr style='background:#AAA;color:#fff;text-align:center;font-weight:bold;'><td colspan='2'>ITEM DETAILS</td></tr>
        <tr style='background:#CCC;color:#fff;font-weight:bold;'><td colspan='2'>Code</td></tr>
        <tr><td colspan='2'>".$code."</td></tr>
        <tr style='background:#CCC;color:#fff;'><td colspan='2'>Description</td></tr>
        <tr><td colspan='2'>".$description."</td></tr>
        <tr style='background:#CCC;color:#fff;'><td colspan='2'>Model</td></tr>
        <tr><td colspan='2'>".$model."</td></tr>
        <tr><td colspan='2'><hr/></td></tr>

        <tr><td>Current Quantity</td><td>".$qty."</td></tr>
        <tr><td colspan='2'><hr/></td></tr>

        <tr><td>Total Ordered Quantity</td><td>".$total_qty."</td></tr>
        <tr><td>Balance Quantity</td><td>".$balance_qty."</td></tr>
        <tr><td>Recieved Quantity</td><td>".$_POST['qty']."</td></tr>
        <tr><td>Pending Quantity</td><td>".((float)$balance_qty-(float)$_POST['qty'])."</td></tr>
        <tr><td colspan='2'><hr/></td></tr>

        <tr><td>Purchase Price</td><td>".$purchase_price."</td></tr>
        <tr><td>Max Price</td><td>".$max_price."</td></tr>
        <tr><td>Min Price</td><td>".$min_price."</td></tr>
        <tr><td colspan='2'><hr/></td></tr>

        <tr><td>Max %</td><td>".$max_pre."</td></tr>
        <tr><td>Min %</td><td>".$min_pre."</td></tr>
      </table>
    </div>

    <h3 id='hed2'>Sub Item Detail</h3>
    <div class='sub-content' id='sub2'>





    </div>
    ";

    echo $html;
  }else{
    echo "0";
  } 
}




public function get_sub_item_detail(){

  if(!isset($_POST['po'])){
    $_POST['po']="";
  }

  $this->db->select(array('code','description','model','purchase_price','min_price','max_price'));
  $this->db->where('code',$_POST['code']);
  $query=$this->db->get('m_item');

  $sqls="SELECT r.description, r.code ,r.qty
  FROM m_item_sub s
  RIGHT JOIN r_sub_item r ON s.`sub_item`=r.`code`
  WHERE s.`item_code`='".$_POST['code']."'
  GROUP BY r.`code`";

  $querys=$this->db->query($sqls);

  $this->db->select(array('sum(qty) as qty'));
        //$this->db->where('store_code',$_POST['store']);
  $this->db->where('bc',$this->sd['branch']);
  $this->db->where('cl',$this->sd['cl']);
  $this->db->where('item',$_POST['code']);
  $qury=$this->db->get('qry_current_stock');

  $total_qty=0;
  $balance_qty=0;
  if($_POST['po']!=""){
    $this->db->select(array('qty'));
    $this->db->where('nno',$_POST['po']);
    $this->db->where('bc',$this->sd['branch']);
    $this->db->where('cl',$this->sd['cl']);
    $this->db->where('item',$_POST['code']);
    $query2=$this->db->get('t_po_det');
    
    if($query2->num_rows()>0){
      $total_qty=$this->db->get('t_po_det')->row()->qty;
    }

    $sql="SELECT SUM(request_qty)-SUM(received_qty) AS balance FROM t_po_trans WHERE trans_no='$_POST[po]' AND item_code='$_POST[code]'";
    $query2=$this->db->query($sql);

    if($query2->num_rows()>0){
      $balance_qty=$query2->row()->balance;
    }
  }



  if($_POST['qty']==""){$_POST['qty']=0;}  
  $code=$description=$model=$qty=$purchase_price=$max_price=$min_price="";
  
  foreach($qury->result() as $row){
    $qty=$row->qty;
  }

  if($query->num_rows()>0){
    foreach($query->result() as $row){
      $code=$row->code;
      $description=$row->description;
      $model=$row->model;
      $purchase_price=$row->purchase_price;
      $max_price=$row->max_price;
      $min_price=$row->min_price;
      $min_pre=number_format(((float)$min_price-(float)$purchase_price)*100/$min_price,2);
      $max_pre=number_format(((float)$max_price-(float)$purchase_price)*100/$max_price,2);
    }


    $html="
    
    <table style='width:100%;margin-top:20px;'>
      <tr id='hed1' style='background:#AAA;color:#fff;text-align:center;font-weight:bold;'><td colspan='2'>ITEM DETAILS</td></tr>
      <tbody class='sub-content' id='sub1' style='display:none;'>
        <tr style='background:#CCC;color:#fff;font-weight:bold;'><td colspan='2'>Code</td></tr>
        <tr><td colspan='2'>".$code."</td></tr>
        <tr style='background:#CCC;color:#fff;'><td colspan='2'>Description</td></tr>
        <tr><td colspan='2'>".$description."</td></tr>
        <tr style='background:#CCC;color:#fff;'><td colspan='2'>Model</td></tr>
        <tr><td colspan='2'>".$model."</td></tr>
        <tr><td colspan='2'><hr/></td></tr>

        <tr><td>Current Quantity</td><td>".$qty."</td></tr>
        <tr><td colspan='2'><hr/></td></tr>

        <tr><td>Total Ordered Quantity</td><td>".$total_qty."</td></tr>
        <tr><td>Balance Quantity</td><td>".$balance_qty."</td></tr>
        <tr><td>Recieved Quantity</td><td>".$_POST['qty']."</td></tr>
        <tr><td>Pending Quantity</td><td>".((float)$balance_qty-(float)$_POST['qty'])."</td></tr>
        <tr><td colspan='2'><hr/></td></tr>

        <tr><td>Purchase Price</td><td>".$purchase_price."</td></tr>
        <tr><td>Max Price</td><td>".$max_price."</td></tr>
        <tr><td>Min Price</td><td>".$min_price."</td></tr>
        <tr><td colspan='2'><hr/></td></tr>
        <tr><td>Discount Price</td><td>".number_format(($max_price-$min_price),2)."</td></tr>
        <tr><td colspan='2'><hr/></td></tr>

        <tr><td>Max %</td><td>".$max_pre."</td></tr>
        <tr><td>Min %</td><td>".$min_pre."</td></tr>


      </tbody>
    </table>

    
    ";


    if($querys->num_rows()>0){

      $html.="
      
      
      <table style='width:100%;margin-top:20px;'>
        <tr id='hed2' style='background:#AAA;color:#fff;text-align:center;font-weight:bold;'><td colspan='3'>SUB ITEM DETAILS</td></tr>
        <tbody class='sub-content' id='sub2' style='display:none;'>
          <tr style='background:#CCC;color:#fff;font-weight:bold;'>
            <td>Code</td>
            <td>Description</td>
            <td>Qty</td>
          </tr>
          ";
          foreach($querys->result() as $roww){

            $code=$roww->code;
            $description=$roww->description;
            $qty=$roww->qty;
            $html.="<tr><td>".$code."</td><td>".$description."</td><td>".$qty."</td></tr>";
          }

          $html.="</tbody></table>";

          
        }
        echo $html;


      }else{
        echo "0";
      } 
    }


    public function get_sub_item_detail2(){

      $avg_from_date=date('Y-m-d', strtotime('-2 months'));
      $avg_to_date=date("Y-m-d");

      if(isset($_POST['avg_from'])){
        $avg_from_date=$_POST['avg_from'];
      }

      if(isset($_POST['avg_to'])){
        $avg_to_date=$_POST['avg_to'];
      }
      

      if(!isset($_POST['po'])){
        $_POST['po']="";
      }

      $this->db->select(array('code','description','model','purchase_price','min_price','max_price'));
      $this->db->where('code',$_POST['code']);
      $query=$this->db->get('m_item');

      $sqls="SELECT r.description, r.code ,r.qty
      FROM m_item_sub s
      RIGHT JOIN r_sub_item r ON s.`sub_item`=r.`code`
      WHERE s.`item_code`='".$_POST['code']."'
      GROUP BY r.`code`";

      $querys=$this->db->query($sqls);

      $this->db->select(array('qty'));
        //$this->db->where('store_code',$_POST['store']);
      $this->db->where('bc',$this->sd['branch']);
      $this->db->where('cl',$this->sd['cl']);
      $this->db->where('item',$_POST['code']);
      $qury=$this->db->get('qry_current_stock');



      $total_qty=0;
      $balance_qty=0;
      if($_POST['po']!=""){
        $this->db->select(array('qty'));
        $this->db->where('nno',$_POST['po']);
        $this->db->where('bc',$this->sd['branch']);
        $this->db->where('cl',$this->sd['cl']);
        $this->db->where('item',$_POST['code']);
        $query2=$this->db->get('t_po_det');
        
        if($query2->num_rows()>0){
          $total_qty=$this->db->get('t_po_det')->row()->qty;
        }

        $sql="SELECT SUM(request_qty)-SUM(received_qty) AS balance FROM t_po_trans WHERE trans_no='$_POST[po]' AND item_code='$_POST[code]'";
        $query2=$this->db->query($sql);

        if($query2->num_rows()>0){
          $balance_qty=$query2->row()->balance;
        }
      }



      if($_POST['qty']==""){$_POST['qty']=0;}  
      $code=$description=$model=$qty=$purchase_price=$max_price=$min_price="";
      
      foreach($qury->result() as $row){
        $qty=$row->qty;
      }

      if($query->num_rows()>0){
        foreach($query->result() as $row){
          $code=$row->code;
          $description=$row->description;
          $model=$row->model;
          $purchase_price=$row->purchase_price;
          $max_price=$row->max_price;
          $min_price=$row->min_price;
          $min_pre=number_format(((float)$min_price-(float)$purchase_price)*100/$purchase_price,2);
          $max_pre=number_format(((float)$max_price-(float)$purchase_price)*100/$purchase_price,2);
        }

              //get last month purchase qty
        $code = $_POST['code'];

        $start_date = date('Y-m-d', strtotime('first day of last month'));
        $end_date = date('Y-m-d', strtotime('last day of last month'));

        $curnt_date = $_POST["date"];

        $qry1 = $this->db->query("SELECT SUM(qty_in) AS qty FROM t_item_movement d WHERE (trans_code='3') AND (d.item='$code') AND (d.ddate BETWEEN (SELECT DATE_ADD(DATE_FORMAT('$curnt_date' ,'%Y-%m-01'),INTERVAL -1 MONTH)) AND (SELECT DATE_ADD(DATE_FORMAT('$curnt_date' ,'%Y-%m-01'),INTERVAL -1 DAY)))");

        if($qry1->num_rows()>0){
          foreach($qry1->result() as $row){

            $purchase_last = $row->qty;

          }

        } 

              //get last month sales qty
        $qry2 = $this->db->query("SELECT SUM(qty_out) AS qty FROM t_item_movement d
          WHERE ((trans_code='4')OR(trans_code='5')) AND (d.item='$code') AND (d.ddate BETWEEN (SELECT DATE_ADD(DATE_FORMAT('$curnt_date' ,'%Y-%m-01'),INTERVAL -1 MONTH)) AND (SELECT DATE_ADD(DATE_FORMAT('$curnt_date' ,'%Y-%m-01'),INTERVAL -1 DAY)))");

        if($qry2->num_rows()>0){
          foreach($qry2->result() as $row){

            $sale_last = $row->qty;

          }

        } 

              //get last six months purchase qty
        $qry3 = $this->db->query("SELECT SUM(qty_in) AS qty 
          FROM t_item_movement d 
          WHERE (trans_code = '3') 
          AND (d.item = '$code') 
          AND (d.ddate BETWEEN '$avg_from_date' AND '$avg_to_date')");

        if($qry3->num_rows()>0){
          foreach($qry3->result() as $row){

            $purchase_last_six = $row->qty;

          }

        } 

              //get last six months sales qty
        $qry4 = $this->db->query("SELECT SUM(qty_out) AS qty 
          FROM t_item_movement d 
          WHERE ((trans_code = '4') 
          OR (trans_code = '5')) 
          AND (d.item = '$code') 
          AND (d.ddate BETWEEN '$avg_from_date' AND '$avg_to_date')");

        if($qry4->num_rows()>0){
          foreach($qry4->result() as $row){

            $sale_last_six = $row->qty;

          }

        } 



        

        $html="
        
        <table style='width:100%;margin-top:20px;'>
          <tr id='hed1' style='background:#AAA;color:#fff;text-align:center;font-weight:bold;cursor:pointer;'><td colspan='2'>ITEM DETAILS</td></tr>
          <tbody class='sub-content' id='sub1' style='display:none;'>
            <tr style='background:#CCC;color:#fff;font-weight:bold;'><td colspan='2'>Code</td></tr>
            <tr><td colspan='2'>".$code."</td></tr>
            <tr style='background:#CCC;color:#fff;'><td colspan='2'>Description</td></tr>
            <tr><td colspan='2'>".$description."</td></tr>
            <tr style='background:#CCC;color:#fff;'><td colspan='2'>Model</td></tr>
            <tr><td colspan='2'>".$model."</td></tr>

            <tr style='background:#CCC;color:#fff;'><td colspan='2'>Previous Month Purchasing & Sales</td></tr>

            <tr>
              <td>Purchase QTY<br><input type='text' style='width:90px;' value='$purchase_last'></td>
              <td>Sales QTY<br><input type='text' style='width:90px;' value='$sale_last'></td>
            </tr>
            
            <tr style='background:#CCC;color:#fff;'>
              <td colspan='2'>Last Months</td>
            </tr>

            <tr>
              <td ><input type='text' style='width:75px;' value='".date('Y-m-d', strtotime('-2 months'))."' id='avg_from' name='avg_from' readonly='readonly' class='input_date_down_future'></td>
              <td ><input type='text' style='width:75px; margin-left: -15px;' value='".date("Y-m-d")."' id='avg_to' name='avg_to' readonly='readonly' class='input_date_down_future'></td>
              <td><input type='button' id='load_qty' title='Load' style='margin-left: -28px;'/></td>
            </tr>


            <tr>

              <td>Purchase QTY<br><input type='text' style='width:90px;' id='grn_qty' value='$purchase_last_six'></td>
              <td>Sales QTY<br><input type='text' style='width:90px;' id='sale_qty' value='$sale_last_six'></td>
            </tr>
            
            
          </tbody>
        </table>
        ";
        echo $html;
      }else{
        echo "0";
      } 
    }

    public function get_sub_item_detail3(){

      $avg_from_date=date('Y-m-d', strtotime('-2 months'));
      $avg_to_date=date("Y-m-d");

      if(!isset($_POST['po'])){
        $_POST['po']="";
      }

      $this->db->select(array('code','description','model','purchase_price','min_price','max_price'));
      $this->db->where('code',$_POST['code']);
      $query=$this->db->get('m_item');

      $sqls="SELECT r.description, r.code ,r.qty
      FROM m_item_sub s
      RIGHT JOIN r_sub_item r ON s.`sub_item`=r.`code`
      WHERE s.`item_code`='".$_POST['code']."'
      GROUP BY r.`code`";

      $querys=$this->db->query($sqls);

      $this->db->select(array('qty'));
        //$this->db->where('store_code',$_POST['store']);
      $this->db->where('bc',$this->sd['branch']);
      $this->db->where('cl',$this->sd['cl']);
      $this->db->where('item',$_POST['code']);
      $qury=$this->db->get('qry_current_stock');

      $total_qty=0;
      $balance_qty=0;
      if($_POST['po']!=""){
        $this->db->select(array('qty'));
        $this->db->where('nno',$_POST['po']);
        $this->db->where('bc',$this->sd['branch']);
        $this->db->where('cl',$this->sd['cl']);
        $this->db->where('item',$_POST['code']);
        $query2=$this->db->get('t_po_det');
        
        if($query2->num_rows()>0){
          $total_qty=$this->db->get('t_po_det')->row()->qty;
        }

        $sql="SELECT SUM(request_qty)-SUM(received_qty) AS balance FROM t_po_trans WHERE trans_no='$_POST[po]' AND item_code='$_POST[code]'";
        $query2=$this->db->query($sql);

        if($query2->num_rows()>0){
          $balance_qty=$query2->row()->balance;
        }
      }



      if($_POST['qty']==""){$_POST['qty']=0;}  
      $code=$description=$model=$qty=$purchase_price=$max_price=$min_price="";
      
      foreach($qury->result() as $row){
        $qty=$row->qty;
      }

      if($query->num_rows()>0){
        foreach($query->result() as $row){
          $code=$row->code;
          $description=$row->description;
          $model=$row->model;
          $purchase_price=$row->purchase_price;
          $max_price=$row->max_price;
          $min_price=$row->min_price;
          $min_pre=number_format(((float)$min_price-(float)$purchase_price)*100/(float)$min_price,2);
          $max_pre=number_format(((float)$max_price-(float)$purchase_price)*100/(float)$max_price,2);
        }

        $code=$_POST['code'];
        $curnt_date = $_POST["date"];

        $qry1 = $this->db->query("SELECT SUM(qty_in) AS qty FROM t_item_movement d WHERE (trans_code='3') AND (d.item='$code') AND (d.ddate BETWEEN (SELECT DATE_ADD(DATE_FORMAT('$curnt_date' ,'%Y-%m-01'),INTERVAL -1 MONTH)) AND (SELECT DATE_ADD(DATE_FORMAT('$curnt_date' ,'%Y-%m-01'),INTERVAL -1 DAY)))");

        if($qry1->num_rows()>0){
          foreach($qry1->result() as $row){

            $purchase_last = $row->qty;

          }

        } 

              //get last month sales qty
        $qry2 = $this->db->query("SELECT SUM(qty_out) AS qty FROM t_item_movement d
          WHERE ((trans_code='4')OR(trans_code='5')) AND (d.item='$code') AND (d.ddate BETWEEN (SELECT DATE_ADD(DATE_FORMAT('$curnt_date' ,'%Y-%m-01'),INTERVAL -1 MONTH)) AND (SELECT DATE_ADD(DATE_FORMAT('$curnt_date' ,'%Y-%m-01'),INTERVAL -1 DAY)))");

        if($qry2->num_rows()>0){
          foreach($qry2->result() as $row){

            $sale_last = $row->qty;

          }

        } 

              //get last six months purchase qty
        $qry3 = $this->db->query("SELECT SUM(qty_in) AS qty 
          FROM t_item_movement d 
          WHERE (trans_code = '3') 
          AND (d.item = '$code') 
          AND (d.ddate BETWEEN '$avg_from_date' AND '$avg_to_date')");

        if($qry3->num_rows()>0){
          foreach($qry3->result() as $row){

            $purchase_last_six = $row->qty;

          }

        } 

              //get last six months sales qty
        $qry4 = $this->db->query("SELECT SUM(qty_out) AS qty 
          FROM t_item_movement d 
          WHERE ((trans_code = '4') 
          OR (trans_code = '5')) 
          AND (d.item = '$code') 
          AND (d.ddate BETWEEN '$avg_from_date' AND '$avg_to_date')");

        if($qry4->num_rows()>0){
          foreach($qry4->result() as $row){

            $sale_last_six = $row->qty;

          }

        } 

        $html="
        
        <table style='width:100%;margin-top:20px;'>
          <tr id='hed1' style='background:#AAA;color:#fff;text-align:center;font-weight:bold;'><td colspan='2'>ITEM DETAILS</td></tr>
          <tbody class='sub-content' id='sub1' style='display:none;'>
            <tr style='background:#CCC;color:#fff;font-weight:bold;'><td colspan='2'>Code</td></tr>
            <tr><td colspan='2'>".$code."</td></tr>
            <tr style='background:#CCC;color:#fff;'><td colspan='2'>Description</td></tr>
            <tr><td colspan='2'>".$description."</td></tr>
            <tr style='background:#CCC;color:#fff;'><td colspan='2'>Model</td></tr>
            <tr><td colspan='2'>".$model."</td></tr>
            <tr><td colspan='2'><hr/></td></tr>

            <tr><td>Current Quantity</td><td>".$qty."</td></tr>
            <tr><td colspan='2'><hr/></td></tr>

            <tr><td>Total Ordered Quantity</td><td>".$total_qty."</td></tr>
            <tr><td>Balance Quantity</td><td>".$balance_qty."</td></tr>
            <tr><td>Recieved Quantity</td><td>".$_POST['qty']."</td></tr>
            <tr><td>Pending Quantity</td><td>".((float)$balance_qty-(float)$_POST['qty'])."</td></tr>
            <tr><td colspan='2'><hr/></td></tr>

            <tr><td>Purchase Price</td><td>".$purchase_price."</td></tr>
            <tr><td>Max Price</td><td>".$max_price."</td></tr>
            <tr><td>Min Price</td><td>".$min_price."</td></tr>
            <tr><td colspan='2'><hr/></td></tr>

            <tr><td>Max %</td><td>".$max_pre."</td></tr>
            <tr><td>Min %</td><td>".$min_pre."</td></tr>

            <tr style='background:#CCC;color:#fff;'><td colspan='2'>Previous Month Purchasing & Sales</td></tr>

            <tr>
              <td>Purchase QTY<br><input type='text' style='width:90px;' value='$purchase_last'></td>
              <td>Sales QTY<br><input type='text' style='width:90px;' value='$sale_last'></td>
            </tr>
            
            <tr style='background:#CCC;color:#fff;'>
              <td colspan='2'>Last Months</td>
            </tr>

            <tr>
              <td ><input type='text' style='width:75px;' value='".date('Y-m-d', strtotime('-2 months'))."' id='avg_from' name='avg_from' readonly='readonly' class='input_date_down_future'></td>
              <td ><input type='text' style='width:75px; margin-left: -15px;' value='".date("Y-m-d")."' id='avg_to' name='avg_to' readonly='readonly' class='input_date_down_future'></td>
              <td><input type='button' id='load_qty' title='Load' style='margin-left: -28px;'/></td>
            </tr>


            <tr>

              <td>Purchase QTY<br><input type='text' style='width:90px;' id='grn_qty' value='$purchase_last_six'></td>
              <td>Sales QTY<br><input type='text' style='width:90px;' id='sale_qty' value='$sale_last_six'></td>
            </tr>

          </tbody>
        </table>

        
        ";


        if($querys->num_rows()>0){

          $html.="
          
          
          <table style='width:100%;margin-top:20px;'>
            <tr id='hed2' style='background:#AAA;color:#fff;text-align:center;font-weight:bold;'><td colspan='3'>SUB ITEM DETAILS</td></tr>
            <tbody class='sub-content' id='sub2' style='display:none;'>
              <tr style='background:#CCC;color:#fff;font-weight:bold;'>
                <td>Code</td>
                <td>Description</td>
                <td>Qty</td>
              </tr>
              ";
              foreach($querys->result() as $roww){

                $code=$roww->code;
                $description=$roww->description;
                $qty=$roww->qty;
                $html.="<tr><td>".$code."</td><td>".$description."</td><td>".$qty."</td></tr>";
              }

              $html.="</tbody></table>";

              
            }
            echo $html;


          }else{
            echo "0";
          } 
        }


        public function previous_qty(){

          $avg_from_date=date('Y-m-d', strtotime('-2 months'));
          $avg_to_date=date("Y-m-d");
          $code=$_POST['item'];

          if(isset($_POST['avg_from'])){
            $avg_from_date=$_POST['avg_from'];
          }

          if(isset($_POST['avg_to'])){
            $avg_to_date=$_POST['avg_to'];
          }
       //get last six months purchase qty
          $qry3 = $this->db->query("SELECT SUM(qty_in) AS qty 
            FROM t_item_movement d 
            WHERE (trans_code = '3') 
            AND (d.item = '$code') 
            AND (d.ddate BETWEEN '$avg_from_date' AND '$avg_to_date')");

          if($qry3->num_rows()>0){
            foreach($qry3->result() as $row){
              $a['grn'] = $row->qty;
            }
          }else{
            $a['grn']=0;
          } 

      //get last six months sales qty
          $qry4 = $this->db->query("SELECT SUM(qty_out) AS qty 
            FROM t_item_movement d 
            WHERE ((trans_code = '4') 
            OR (trans_code = '5')) 
            AND (d.item = '$code') 
            AND (d.ddate BETWEEN '$avg_from_date' AND '$avg_to_date')");

          if($qry4->num_rows()>0){
            foreach($qry4->result() as $row){
              $a['sales']= $row->qty;
            }
          }else{
           $a['sales']=0;
         } 

         echo json_encode($a);

       } 


       public function is_sub_items() {

        $code = $_POST['code'];
    // $quantity= $_POST['qty'];
        $batch = $_POST['batch'];

        $sql = "SELECT s.sub_item , r.qty 
        FROM t_item_movement_sub s
        JOIN r_sub_item r ON r.`code`=s.`sub_item`
        WHERE s.`item`='$code' AND s.cl='".$this->sd['cl']."' AND s.bc ='".$this->sd['branch']."' AND s.`batch_no`='$batch' 
        GROUP BY r.`code`
        ";

        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
          $a['sub']= $query->result();
        } else {
          $a = 2;
        }
        echo json_encode($a);
      }



      public function is_sub_items_sales_return() {

        $code = $_POST['code'];

        $sql="SELECT s.sub_item , r.qty 
        FROM t_item_movement_sub s
        JOIN r_sub_item r ON r.`code`=s.`sub_item`
        WHERE s.`item`='$code' AND s.cl='".$this->sd['cl']."' AND s.bc ='".$this->sd['branch']."'
        GROUP BY r.`code`";
        
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
          $a['sub']= $query->result();
        } else {
          $a = 2;
        }
        echo json_encode($a);
      }


      public function is_sub_items_load() {

        $code = $_POST['code'];
        $hid= $_POST['hid'];
        $type=$_POST['type'];


        $sql="SELECT s.sub_item , r.qty 
        FROM t_item_movement_sub s
        JOIN r_sub_item r ON r.`code`=s.`sub_item`
        WHERE s.trans_code ='$type' AND s.trans_no='$hid' AND item='$code' AND cl='".$this->sd['cl']."' AND bc='".$this->sd['branch']."' ";
        

    // $sql = "SELECT sub_item,qty_in
    //         FROM t_item_movement_sub
    //         WHERE trans_code ='".$type."' AND trans_no='".$hid."' AND item='".$code."' AND cl='".$this->sd['cl']."' AND bc='".$this->sd['branch']."'";

        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
          $a['sub']= $query->result();
        } else {
          $a = 2;
        }
        echo json_encode($a);
      }


      public function is_sub_items_available() {

        $code = $_POST['code'];
        $quantity= (int)$_POST['qty'];
        $g_qty= (int)$_POST['grid_qty'];
        $batch= $_POST['batch'];
        $hid = $_POST['hid'];
        $trns_type=$_POST['trans_type'];
        $store = $_POST['store'];

        $tot_qty=$quantity*$g_qty;

    // $sql = "SELECT sub_item, qty_in, qty, SUM(qty_in-qty_out) AS balance
    //         FROM t_item_movement_sub
    //         JOIN r_sub_item ON r_sub_item.`code` = t_item_movement_sub.sub_item
    //         WHERE sub_item='".$code."' AND batch_no='".$batch."'
    //         GROUP BY trans_code , trans_no, sub_item
    //         HAVING balance >= '".$tot_qty."' ";

        if($hid==0 || $hid==""){
          if($trns_type==8){
           $sql = "SELECT sub_item, qty_in, qty, SUM(qty_in-qty_out) AS balance
           FROM t_item_movement_sub
           JOIN r_sub_item ON r_sub_item.`code` = t_item_movement_sub.sub_item
           WHERE sub_item='".$code."' AND batch_no='".$batch."' AND t_item_movement_sub.cl='".$this->sd['cl']."' AND t_item_movement_sub.bc='".$this->sd['branch']."'
           HAVING balance >= '".$tot_qty."' ";        

         }else{
          $sql = "SELECT sub_item, qty_in, qty, SUM(qty_in-qty_out) AS balance
          FROM t_item_movement_sub
          JOIN r_sub_item ON r_sub_item.`code` = t_item_movement_sub.sub_item
          WHERE sub_item='".$code."' AND batch_no='".$batch."' AND store_code='".$store."' AND t_item_movement_sub.cl='".$this->sd['cl']."' AND t_item_movement_sub.bc='".$this->sd['branch']."'
          HAVING balance >= '".$tot_qty."' ";   
        }       
      }else{

        if($trns_type==8){
          $sql="SELECT t_item_movement_sub.sub_item, 
          t_item_movement_sub.qty_in, 
          qty, 
          SUM(t_item_movement_sub.qty_in) - SUM(t_item_movement_sub.qty_out) - IFNULL(c.qty_in,0) AS balance
          FROM t_item_movement_sub 
          JOIN r_sub_item  ON r_sub_item.`code` = t_item_movement_sub.sub_item 
          LEFT JOIN (SELECT qty_in,cl,bc,item,sub_item 
          FROM t_item_movement_sub 
          WHERE trans_code ='".$trns_type."' AND trans_no='".$hid."') c 
          ON c.item=t_item_movement_sub.`item` AND c.sub_item = t_item_movement_sub.`sub_item` 
          AND c.cl = t_item_movement_sub.`cl` AND c.bc = t_item_movement_sub.`bc`
          WHERE t_item_movement_sub.sub_item ='".$code."' AND batch_no='".$batch."' AND t_item_movement_sub.cl='".$this->sd['cl']."' AND t_item_movement_sub.bc='".$this->sd['branch']."'
          HAVING balance >= '".$tot_qty."' ";   
        }else{
          $sql="SELECT t_item_movement_sub.sub_item, 
          t_item_movement_sub.qty_in, 
          qty, 
          SUM(t_item_movement_sub.qty_in) - SUM(t_item_movement_sub.qty_out) + IFNULL(c.qty_out,0) AS balance
          FROM t_item_movement_sub 
          JOIN r_sub_item  ON r_sub_item.`code` = t_item_movement_sub.sub_item 
          LEFT JOIN (SELECT qty_out,cl,bc,item,sub_item 
          FROM t_item_movement_sub 
          WHERE trans_code ='".$trns_type."' AND trans_no='".$hid."' AND store_code='".$store."') c 
          ON c.item=t_item_movement_sub.`item` AND c.sub_item = t_item_movement_sub.`sub_item` 
          AND c.cl = t_item_movement_sub.`cl` AND c.bc = t_item_movement_sub.`bc`
          WHERE t_item_movement_sub.sub_item ='".$code."' AND batch_no='".$batch."' AND store_code='".$store."' AND t_item_movement_sub.cl='".$this->sd['cl']."' AND t_item_movement_sub.bc='".$this->sd['branch']."'
          HAVING balance >= '".$tot_qty."' ";   
        }
      }

      $query = $this->db->query($sql);

      if ($query->num_rows() > 0) {
        $a['sub']= $query->result();
      } else {
        $a = 2;
      }
      echo json_encode($a);
    }

    public function is_sub_items1() {
      $code = $_POST['code'];
      $quantity= $_POST['qty'];
      $sql = "SELECT sub_item , qty FROM m_item_sub 
      JOIN r_sub_item ON r_sub_item.`code`=m_item_sub.`sub_item`
      WHERE item_code='".$code."'";

      $query = $this->db->query($sql);
      $a='';
      if ($query->num_rows() > 0) {
        foreach($query->result() as $row){
          $code      = $row->sub_item;
          $qty       = (int)$row->qty;
          $g_qty     = (int)$_POST['grid_qty'];
          $batch     = $_POST['batch'];
          $hid       = $_POST['hid'];
          $trns_type = $_POST['trans_type'];
          $tot_qty   = $qty*$g_qty;

          if($hid==0 || $hid==""){
            $sql1="SELECT IFNULL((SELECT SUM(qty_in-qty_out) AS balance
            FROM t_item_movement_sub
            JOIN r_sub_item ON r_sub_item.`code` = t_item_movement_sub.sub_item
            WHERE sub_item='$code' AND batch_no='$batch'
            HAVING balance >= '$tot_qty'),0) AS result";          
          }else{
            $sql1="SELECT IFNULL((SELECT SUM(t_item_movement_sub.qty_in) - SUM(t_item_movement_sub.qty_out) + c.qty_out AS balance
            FROM t_item_movement_sub 
            JOIN r_sub_item  ON r_sub_item.`code` = t_item_movement_sub.sub_item 
            JOIN (SELECT qty_out,cl,bc,item,sub_item 
            FROM t_item_movement_sub 
            WHERE trans_code ='".$trns_type."' AND trans_no='".$hid."') c 
            ON c.item=t_item_movement_sub.`item` AND c.sub_item = t_item_movement_sub.`sub_item` 
            AND c.cl = t_item_movement_sub.`cl` AND c.bc = t_item_movement_sub.`bc`
            WHERE t_item_movement_sub.sub_item ='".$code."' AND batch_no='".$batch."'
            HAVING balance >= '".$tot_qty."' ),0) AS result";   
          }
          $query1 = $this->db->query($sql1);
          if ($query1->first_row()->result!=0) {
            $a=$a.$code."-";
          }else{
            $a = 2;
          }
        }
      }else{
        $a =2;
      }
      echo json_encode($a);
    }

    public function save_logger($action,$trans_code,$trans_no,$module,$sub_no=0){
     $data=array(
      "cl"        =>$this->sd['cl'],
      "bc"        =>$this->sd['branch'],
      "oc"        =>$this->sd['oc'],
      "action"    =>$action,
      "trans_code"=>$trans_code,
      "sub_no"    =>$sub_no,
      "trans_no"  =>$trans_no,
      "module"    =>$module,
      "ip_address"=>$this->input->ip_address()
      );
     $this->db->insert("t_log_det",$data);
   }

   public function update_credit_sale_balance($code){
    $sql="UPDATE t_credit_sales_sum cs,
    (SELECT sub_cl,sub_bc,acc_code,trans_no,SUM(dr)-SUM(cr) AS balance FROM t_cus_settlement
    WHERE  trans_code ='5' GROUP BY sub_cl,sub_bc,acc_code,trans_code,trans_no HAVING acc_code='$code') tc
    SET cs.`balance`=tc.balance 
    WHERE cs.cl=tc.sub_cl 
    AND cs.bc=tc.sub_bc 
    AND cs.cus_id = tc.acc_code 
    AND tc.trans_no=cs.nno";
    $this->db->query($sql);                
  }

  public function update_credit_note_balance($code){
    $sql="UPDATE t_credit_note cs,
    (SELECT sub_cl,sub_bc,acc_code,trans_no,SUM(dr)-SUM(cr) AS balance FROM t_credit_note_trans
    GROUP BY sub_cl,sub_bc,acc_code,trans_code,trans_no HAVING acc_code='$code') tc
    SET cs.`balance`=tc.balance WHERE cs.cl=tc.sub_cl AND cs.`bc`=tc.sub_bc AND cs.`code` = tc.acc_code AND tc.trans_no=cs.nno";
    $this->db->query($sql);                
  }

  public function update_debit_note_balance($code){
    $sql="UPDATE t_debit_note cs,
    (SELECT sub_cl,sub_bc,acc_code,trans_no,SUM(dr)-SUM(cr) AS balance FROM t_debit_note_trans
    GROUP BY sub_cl,sub_bc,acc_code,trans_code,trans_no HAVING acc_code='$code') tc
    SET cs.`balance`=tc.balance WHERE cs.cl=tc.sub_cl AND cs.`bc`=tc.sub_bc AND cs.`code` = tc.acc_code AND tc.trans_no=cs.nno";
    $this->db->query($sql);                
  }

  public function update_purchase_balance($code){
    $sql="UPDATE t_grn_sum cs,
    (SELECT sub_cl,sub_bc,acc_code,trans_no,SUM(dr)-SUM(cr) AS balance FROM t_sup_settlement
    WHERE  trans_code ='3' GROUP BY sub_cl,sub_bc,acc_code,trans_code,trans_no HAVING acc_code='$code') tc
    SET cs.`balance`=tc.balance WHERE cs.cl=tc.sub_cl AND cs.`bc`=tc.sub_bc AND cs.`supp_id` = tc.acc_code AND tc.trans_no=cs.nno";
    $this->db->query($sql);                
  }

  public function update_receipt_op_balance($code){
    $sql="UPDATE t_receipt cs,
    (SELECT sub_cl,sub_bc,acc_code,trans_no,SUM(dr)-SUM(cr) AS balance FROM t_cus_settlement
    WHERE  trans_code ='16' GROUP BY sub_cl,sub_bc,acc_code,trans_code,trans_no HAVING acc_code='$code') tc
    SET cs.`receipt_balance`=tc.balance WHERE cs.cl=tc.sub_cl AND cs.`bc`=tc.sub_bc AND cs.`cus_acc` = tc.acc_code AND tc.trans_no=cs.nno";
    $this->db->query($sql);                
  }

  public function update_voucher_op_balance($code){
    $sql="UPDATE t_voucher_sum cs,
    (SELECT sub_cl,sub_bc,acc_code,trans_no,SUM(dr)-SUM(cr) AS balance FROM t_sup_settlement
    WHERE  trans_code ='19' GROUP BY sub_cl,sub_bc,acc_code,trans_code,trans_no HAVING acc_code='$code') tc
    SET cs.`voucher_balance`=tc.balance WHERE cs.cl=tc.sub_cl AND cs.`bc`=tc.sub_bc AND cs.`acc_code` = tc.acc_code AND tc.trans_no=cs.nno";
    $this->db->query($sql);                
  }

  public function f1_selection_list(){


    $table         = $_POST['data_tbl'];
    $field         = isset($_POST['field'])?$_POST['field']:'code';
    $field2        = isset($_POST['field2'])?$_POST['field2']:'description';
    $hid_field     = isset($_POST['hid_field'])?$_POST['hid_field']:"0";
    $add_query     = isset($_POST['add_query'])?$_POST['add_query']:"";
    $preview_name1 = isset($_POST['preview1'])?$_POST['preview1']:'Code';
    $preview_name2 = isset($_POST['preview2'])?$_POST['preview2']:'Description';

    if (isset($_POST['chkClBc'])) {
      $add_query = "AND `cl`='".$this->sd['cl']."' AND `bc`='".$this->sd['branch']."' ".$add_query;       
    }

    if($_POST['search'] == 'Key Word: code, name'){$_POST['search'] = "";}
    if($add_query!=""){
      $sql = "SELECT * FROM $table  WHERE ($field2 LIKE '%$_POST[search]%' OR $field LIKE '%$_POST[search]%' ) ".$add_query." LIMIT 25";
    }else{
      $sql = "SELECT * FROM $table  WHERE $field2 LIKE '%$_POST[search]%' OR $field LIKE '%$_POST[search]%' LIMIT 25";
    }
    $query = $this->db->query($sql);
    $a  = "<table id='item_list' style='width : 100%' >";
    $a .= "<thead><tr>";
    $a .= "<th class='tb_head_th'>".$preview_name1."</th>";
    $a .= "<th class='tb_head_th' colspan='2'>".$preview_name2."</th>";
    $a .= "</thead></tr><tr class='cl' style='visibility: hidden;'><td>&nbsp;</td><td colspan='2'>&nbsp;</td></tr>";

    foreach($query->result() as $r){
      $a .= "<tr class='cl'>";
      $a .= "<td>".$r->{$field}."</td>";
      $a .= "<td>".$r->{$field2}."</td>";
      if($hid_field!="0"){
        $a .= "<td><input type='hidden' class='code_gen' value='".$r->{$hid_field}."' title='".$r->{$hid_field}."' /></td>";        
      }
      $a .= "</tr>";
    }
    $a .= "</table>";
    echo $a;
  }

  public function f1_selection_list_loan(){

   if($_POST['search'] == 'Key Word: code, name'){$_POST['search'] = "";}
   $sql="SELECT agreement_no,cus_id,name,nic 
   FROM t_hp_sales_sum JOIN m_customer ON m_customer.`code`=t_hp_sales_sum.`cus_id`
   WHERE agreement_no LIKE '%$_POST[search]%' OR cus_id LIKE '%$_POST[search]%' OR name LIKE '%$_POST[search]%' OR nic LIKE '%$_POST[search]%'";

   $query = $this->db->query($sql);
   $a  = "<table id='item_list' style='width : 100%' >";
   $a .= "<thead><tr>";
   $a .= "<th class='tb_head_th'>Agreement No</th>";
   $a .= "<th class='tb_head_th' colspan='2'>NIC</th>";
   $a .= "<th class='tb_head_th' colspan='2'>Customer Name</th>";
   $a .= "</thead></tr><tr class='cl'><td>&nbsp;</td><td colspan='2'>&nbsp;</td><td colspan='2'>&nbsp;</td></tr>";

   foreach($query->result() as $r){
    $a .= "<tr class='cl'>";
    $a .= "<td>".$r->agreement_no."</td>";
    $a .= "<td colspan='2'>".$r->nic."</td>";
    $a .= "<td colspan='2'>".$r->name."</td>";
    
    $a .= "</tr>";
  }
  $a .= "</table>";
  echo $a;
}


public function f1_selection_chrages_type(){

 if($_POST['search'] == 'Key Word: code, name'){$_POST['search'] = "";}
 $sql="SELECT CODE,description FROM m_account WHERE CODE LIKE '%$_POST[search]%' OR description LIKE '%$_POST[search]%' ";

 $query = $this->db->query($sql);
 $a  = "<table id='item_list' style='width : 100%' >";
 $a .= "<thead><tr>";
 $a .= "<th class='tb_head_th'>Code</th>";
 $a .= "<th class='tb_head_th' colspan='2'>Description</th>";
 $a .= "</thead></tr><tr class='cl'><td>&nbsp;</td><td>&nbsp;</td></tr>";

 foreach($query->result() as $r){
  $a .= "<tr class='cl'>";
  $a .= "<td>".$r->CODE."</td>";
  $a .= "<td>".$r->description."</td>";
  
  $a .= "</tr>";
}
$a .= "</table>";
echo $a;
}

public function f1_selection_list_po(){
  $table         = $_POST['data_tbl'];
  $field         = isset($_POST['field'])?$_POST['field']:'code';
  $field2        = isset($_POST['field2'])?$_POST['field2']:'description';
  $hid_field     = isset($_POST['hid_field'])?$_POST['hid_field']:0;
  $add_query     = isset($_POST['add_query'])?$_POST['add_query']:"";
  $preview_name1 = isset($_POST['preview1'])?$_POST['preview1']:'Code';
  $preview_name2 = isset($_POST['preview2'])?$_POST['preview2']:'Description';
  $preview_name3 = isset($_POST['preview3'])?$_POST['preview3']:'';

  if($_POST['search'] == 'Key Word: code, name'){$_POST['search'] = "";}
  if($add_query!=""){
    $sql = "SELECT * FROM $table  WHERE ($field2 LIKE '%$_POST[search]%' OR $field LIKE '%$_POST[search]%' ) ".$add_query." AND cl ='".$this->sd['cl']."' AND bc='".$this->sd['branch']."' LIMIT 25";
  }else{
    $sql = "SELECT * FROM $table  WHERE $field2 LIKE '%$_POST[search]%' OR $field LIKE '%$_POST[search]%' LIMIT 25";
  }

  $query = $this->db->query($sql);
  $a  = "<table id='item_list' style='width : 100%' >";
  $a .= "<thead><tr>";
  $a .= "<th class='tb_head_th'>".$preview_name1."</th>";
  $a .= "<th class='tb_head_th'>".$preview_name2."</th>";
  $a .= "<th class='tb_head_th' colspan='2'>".$preview_name3."</th>";
  $a .= "</thead></tr><tr class='cl'><td>&nbsp;</td><td colspan='2'>&nbsp;</td></tr>";

  foreach($query->result() as $r){
    $a .= "<tr class='cl'>";
    $a .= "<td>".$r->{$field}."</td>";
    $a .= "<td>".$r->{$field2}."</td>";
    $a .= "<td>".$r->supplier."</td>";
    if($hid_field!=0){
      $a .= "<td><input type='hidden' class='code_gen' value='".$r->{$hid_field}."' title='".$r->{$hid_field}."' /></td>";        
    }
    $a .= "</tr>";
  }
  $a .= "</table>";
  echo $a;
}


public function invoice_format($qno){
  $inv=(int)$qno;
  if($inv<0){
   $inv =  "000000".$qno;
 }else if($inv<9){
  $inv = "00000".$qno;
}else if($inv<99){
  $inv = "0000".$qno;
}else if($inv<999){
  $inv = "000".$qno;
}else if($inv<9999){
  $inv = "00".$qno;
}else if($inv<99999){
  $inv = "0".$qno;
}else if($inv<999999){
  $inv = "".$qno;
}
return $inv;
}

public function check_account_trans($code,$type,$form,$table,$field){
  $status=1;
  $sql="SELECT * FROM $table WHERE $field='".$code."'";
  $query=$this->db->query($sql);  
  if ($query->num_rows() > 0) {
    $status = "This $type cann't delete. This $type already have transactions";
  }   
  return $status;
}


public function check_approve_level(){
  $tbl=$_POST['table'];
  $nno=$_POST['nno'];
  $trans_code=$_POST['trans_code'];

  $sql="SELECT approve_type FROM $tbl WHERE is_approve=0 AND nno=$nno";
  $approve_type=$this->db->query($sql)->first_row()->approve_type;

  $sql="SELECT role_id,role_description FROM s_permission_level_det WHERE code='$approve_type'";
  $this->db->query($sql);
  $data['det']=$this->db->query($sql)->result();
  $data['sum']=$this->db->where('code',$approve_type)->get('s_permission_level_sum')->result();

  $this->db->where('cl',$this->sd['cl']);
  $this->db->where('bc',$this->sd['branch']);
  $this->db->where('upl_no',$approve_type);
  $this->db->where('trans_code',$trans_code);
  $this->db->where('trans_no',$nno);
  $query=$this->db->get('t_approval_trans');

  $data['approve_det']=$query->result();
  echo json_encode($data);
}

public function save_approval_level(){
  $cl=$this->sd['cl'];
  $bc=$this->sd['branch'];

  $trans_no  =$_POST['trans_no'];
  $trans_code=$_POST['trans_code'];

    // $data=array(
    //   "cl"=>$cl,
    //   "bc"=>$bc,
    //   "trans_code"=>$trans_code,
    //   "trans_no"=>$trans_no,
    //   "upl_no"=>,
    //   "user_role_id"=>,
    //   "user_id"=>$this->sd['op'],
    //   "ddate"=>date("Y-m-d",time()),
    //   "ttime"=>date("HH:MM:SS",time()),
    //   "com_name"=>"Default",
    //   "ip_address"=>$this->ip_address()
    // );

  $sql="";
  echo $_POST['name'];
}

/*  public function get_batch_no($item,$cost,$max_price,$min_price){
    $field    ="batch_no";
    $cl       =$this->sd['cl'];
    $bc       =$this->sd['branch'];
    $this->db->where("batch_item","1");
    $this->db->where("code",$item);
    $query=$this->db->get("m_item");

    if($query->num_rows()>0){
      $sql="SELECT IFNULL(MAX(`batch_no`),0) AS batch_no, COUNT(*) as records FROM (`t_item_movement`) 
            WHERE `cl` = '$cl' AND `bc` = '$bc' 
            AND `item` = '$item' AND `cost` = '$cost' AND `sales_price` = '$max_price' AND `last_sales_price` = '$min_price'";
      $batch_no=$this->db->query($sql)->last_row()->batch_no;
      $records =$this->db->query($sql)->last_row()->records;

      if($records==0 && $batch_no==0){
        $sql2="SELECT IFNULL(MAX(`batch_no`), 0) AS batch_no FROM (`t_item_movement`) WHERE `cl` = '$cl' AND `bc` = '$bc'
               AND `item` = '$item'";
        return $this->db->query($sql2)->last_row()->batch_no+1;
      }else if($records==0 && $batch_no>0){
        return $batch_no+1;
      }else{
        return $batch_no;
      }
    }else{
      return "0";
    }
  }*/

  public function get_batch_no($item,$cost,$max_price,$min_price,$color){
    $field    ="batch_no";
    $cl       =$this->sd['cl'];
    $bc       =$this->sd['branch'];
    $this->db->where("batch_item","1");
    $this->db->where("code",$item);
    $query=$this->db->get("m_item");

    if($query->num_rows()>0){
      $sql="SELECT IFNULL(MAX(`batch_no`),0) AS batch_no, COUNT(*) as records 
      FROM (`t_item_batch`) 
      WHERE purchase_price='$cost' 
      AND min_price='$min_price' 
      AND max_price='$max_price' 
      AND item='$item'
      AND `color_code` = '$color'";
      
      $batch_no=$this->db->query($sql)->last_row()->batch_no;
      $records =$this->db->query($sql)->last_row()->records;

      if($records==0 && $batch_no==0){
        $sql2="SELECT IFNULL(MAX(`batch_no`), 0) AS batch_no FROM (`t_item_batch`) WHERE `item` = '$item'";
        return $this->db->query($sql2)->last_row()->batch_no+1;
      }else if($records==0 && $batch_no>0){
        return $batch_no+1;
      }else{
        return $batch_no;
      }
    }else{
      return "0";
    }
  }


  function get_open_bal_date(){

    $sql = "SELECT open_bal_date FROM m_branch WHERE cl='".$this->sd['cl']."' AND bc='".$this->sd['branch']."'";
    $query = $this->db->query($sql);

    foreach($query->result() as $r){

      $open_bal_date = $r->open_bal_date;

    }
    return $open_bal_date;
  }

  function get_max_sales_category(){

    $field_name = $_POST['nno'];
    $table_name = $_POST['table'];
    $category = $_POST['category'];
    if($_POST['hid'] == "0" || $_POST['hid'] == ""){   
      $this->db->select_max($field_name);
      $this->db->where("cl",$this->sd['cl']);
      $this->db->where("bc",$this->sd['branch']);
      $this->db->where("category",$category);    
      echo $this->db->get($table_name)->first_row()->$field_name+1;
    }else{
      echo $_POST['sub_no'];
    }
  }

  function get_max_sales_category2($field_name,$table_name,$category){
    if($_POST['hid'] == "0" || $_POST['hid'] == ""){   
      $this->db->select_max($field_name);
      $this->db->where("cl",$this->sd['cl']);
      $this->db->where("bc",$this->sd['branch']);
      $this->db->where("category",$category);    
      return $this->db->get($table_name)->first_row()->$field_name+1;
    }else{
      return $_POST['sub_no'];
    }
  }

  public function get_max_no_by_type($table_name,$field_name){
    if(isset($_POST['hid'])){
      if($_POST['hid'] == "0" || $_POST['hid'] == ""){      
        $this->db->select_max($field_name);
        $this->db->where("cl",$this->sd['cl']);
        $this->db->where("bc",$this->sd['branch']);    
        return $this->db->get($table_name)->first_row()->$field_name+1;
      }else{
        return $_POST['hid'];  
      }
    }else{
      $this->db->select_max($field_name);
      $this->db->where("cl",$this->sd['cl']);
      $this->db->where("bc",$this->sd['branch']);    
      return $this->db->get($table_name)->first_row()->$field_name+1;
    }
  }

  public function get_is_store_in_branch(){
    $sql="SELECT is_store FROM m_branch WHERE bc = '".$this->sd['branch']."' AND cl = '".$this->sd['cl']."'";
    $query = $this->db->query($sql);
    return $query->row()->is_store;
  }

  public function main_store_branch(){
    $sql="SELECT bc FROM m_branch WHERE is_store ='1' ";
    $query = $this->db->query($sql);
    return $query->row()->bc;
  }


  public function main_store_select(){
    $sql="SELECT cl, bc , name FROM m_branch WHERE is_store ='1' ";
    $query = $this->db->query($sql);
    echo json_encode($query->result());
  }


  public function get_item_supplier($item){
   // var_dump($item);
    $sql="SELECT supplier FROM m_item WHERE code ='$item' ";
    $query = $this->db->query($sql);      
    return $query->row()->supplier;
  }


  public function check_item_in_batch_table($item){
    $status=1;
    $sql="SELECT item FROM t_item_batch WHERE item ='$item' ";
    $query = $this->db->query($sql);   

    if($query->num_rows()>0){
      $status=0;
    }

    return $status;
  }


  public function batch_in_item_batch_tb($item,$bt){
    $status = 1;

    $sql="SELECT batch_no FROM t_item_batch WHERE item ='$item' AND batch_no ='$bt' ";
    $query = $this->db->query($sql);   

    if($query->num_rows()>0){
      $status = 0;
    }

    return $status;
  }


  public function insert_batch_items($cl,$bc,$item,$t_code,$t_no,$b_no,$p_price,$min,$max,$s3,$s4,$s5,$s6,$color,$sup,$oc,$table){
    $data=array(
      "cl"=>$cl,
      "bc"=>$bc,
      "item"=>$item,
      "trans_code"=>$t_code,
      "trans_no"=>$t_no,
      "batch_no"=>$b_no,
      "purchase_price"=>$p_price,
      "min_price"=>$min,
      "max_price"=>$max,
      "sale_price3"=>$s3,
      "sale_price4"=>$s4,
      "sale_price5"=>$s5,
      "sale_price6"=>$s6,
      "color_code"=>$color,
      "supplier"=>$sup,
      "oc"=>$oc
      );
    $this->db->insert($table,$data);
  }

  public function remove_batch_item($cl,$bc,$t_code,$t_no,$table){
    $this->db->where("cl",$cl);
    $this->db->where("bc",$bc);
    $this->db->where("trans_code",$t_code);
    $this->db->where("trans_no",$t_no);
    $this->db->delete($table);
  }

  public function is_pending(){
    $pending=0;
    $cl=$this->sd['cl'];
    $bc=$this->sd['branch'];

    $sql="SELECT nno,ddate,action_date,'Purchase Request Approve' AS des, 32 as t_code ,0 AS types
    FROM t_req_approve_sum 
    WHERE cl = '$cl' 
    AND bc = '$bc' 
    AND is_level_3_approved = '0' 
    AND is_cancel = '0' 
    
    UNION ALL

    SELECT nno,ddate,action_date,'Purchase Request' AS des, 31 as t_code,0 AS types
    FROM t_req_sum
    WHERE cl = '$cl' 
    AND bc = '$bc'
    AND is_cancel = '0' 
    AND is_level_1_approved ='0'

    UNION ALL
    
    SELECT nno,ddate,action_date,'Cash Sale' AS des, 4 as t_code,0 AS types 
    FROM t_cash_sales_sum 
    WHERE cl='$cl' 
    AND bc='$bc' 
    AND is_approve='0'

    UNION ALL
    
    SELECT nno,ddate,action_date,'Purchase Return' AS des, 10 as t_code , 0 as types
    FROM t_pur_ret_sum 
    WHERE cl='$cl' 
    AND bc='$bc' 
    AND is_approve='0'  

    UNION ALL
    
    SELECT nno,ddate,action_date,'Sales Return' AS des, 8 as t_code,return_type as types
    FROM t_sales_return_sum 
    WHERE cl='$cl' 
    AND bc='$bc' 
    AND is_approve='0'  

    UNION ALL

    SELECT voucher_no AS nno,ddate,t.action_date, 'Voucher' AS des, 48 AS t_code, b.name AS `types`
    FROM t_voucher_trans t
    JOIN m_branch b ON t.`cl`=b.`cl` AND t.`bc`=b.`bc` 
    WHERE `status`='0'  AND t.bc!='".$this->sd['branch']."'
    GROUP BY t.cl,t.`bc`,t.`voucher_no`";

    $query=$this->db->query($sql);

    if($query->num_rows>0){
      $pending=1;
    }
    return $pending;    
  }

  public function pending_list(){
    $cl=$this->sd['cl'];
    $bc=$this->sd['branch'];

       // $sql="SELECT * FROM t_req_approve_sum WHERE cl='$cl' AND bc='$bc' AND is_level_3_approved='0' AND is_cancel='0'";
    $sql="SELECT '0' AS max_no,nno,ddate,action_date,'Purchase Request Approve' AS des, 32 as t_code , 0 as types,bc AS branch
    FROM t_req_approve_sum 
    WHERE cl = '$cl' 
    AND bc = '$bc' 
    AND is_level_3_approved = '0' 
    AND is_cancel = '0' 
    
    UNION ALL

    SELECT '0' AS max_no,nno,ddate,action_date,'Purchase Request' AS des, 31 as t_code , 0 as types,bc AS branch
    FROM t_req_sum
    WHERE cl = '$cl' 
    AND bc = '$bc'
    AND is_cancel = '0' 
    AND is_level_1_approved ='0'

    UNION ALL
    
    SELECT '0' AS max_no,nno,ddate,action_date,'Cash Sale' AS des, 4 as t_code , 0 as types,bc AS branch
    FROM t_cash_sales_sum 
    WHERE cl='$cl' 
    AND bc='$bc' 
    AND is_approve='0'

    UNION ALL
    
    SELECT '0' AS max_no,nno,ddate,action_date,'Purchase Return' AS des, 10 as t_code , 0 as types,bc AS branch
    FROM t_pur_ret_sum 
    WHERE cl='$cl' 
    AND bc='$bc' 
    AND is_approve='0'  

    UNION ALL
    
    SELECT '0' AS max_no, nno,ddate,action_date,'Sales Return' AS des, 8 as t_code,return_type as types,bc AS branch
    FROM t_sales_return_sum 
    WHERE cl='$cl' 
    AND bc='$bc' 
    AND is_approve='0' 

    UNION ALL

    SELECT voucher_no AS max_no,sub_no AS nno,ddate,t.action_date, CONCAT(UCASE(type), ' GL Voucher') AS des, 48 AS t_code, b.name AS `types`,t.bc AS branch
    FROM t_voucher_trans t
    JOIN m_branch b ON t.`cl`=b.`cl` AND t.`bc`=b.`bc` 
    WHERE `status`='0'  AND t.bc!='".$this->sd['branch']."'
    GROUP BY t.cl,t.`bc`,t.`voucher_no`  

    ";
//-----continue from generate approve and reject js functions
    $query=$this->db->query($sql);

    $html="<div style='margin:5px auto;width:800px;border:1px solid #ccc;'><table><tr>";
    $html.="<td>Is User Available For Approve</td>";
    $html.="<td>&nbsp;</td>";
    $html.="<td></td>";
    $html.="</tr></table><hr>";
    $html.="<table border='1' style='width:100%;'>

    <tr><td colspan='5' style='background:#AAA;color:#fff;font-weight:bolder;'>PENDING REQUISITION APPROVE LIST</td></tr>
    <tr>
      <td style='background:#ccc;width:75px;'>&nbsp;Invoice No</td>
      <td style='background:#ccc; width:400px;'>&nbsp;Approved By</td>
      <td style='background:#ccc; width:100px;'>&nbsp;Date</td>
      <td style='background:#ccc; width:100px;'>&nbsp;Time</td>
      <td style='background:#ccc; width:100px;'>&nbsp;</td>
    </tr>";
    
    foreach($query->result() as $row){
      $time=explode(" ",$row->action_date);
      $html.="<tr>
      <td style='width:75px;text-align:center;'>".$row->nno."</td>";
      if($row->types == "2"){
        $html.="<td>Sales Return Without Invoice</td>";
      }else{
        if($row->t_code=="48"){
          $html.="<td>".$row->des." From (".$row->types.") </td>";
        }else{
          $html.="<td>".$row->des ."</td>";
        }
      }
      $html.="<td style='width:100px;'>&nbsp;".$row->ddate."</td>
      <td style='width:100px;'>&nbsp;".$time[1]."</td>";

      if($row->t_code=="48"){
        $html.="<td style='width:200px;text-align:center;'><input type='button' title='Approve' value='Approve' onclick='approve_voucher_form_main(\"".$row->branch."|".$row->max_no."\")' />

        <input type='button' title='Reject' value='Reject' onclick='reject_voucher_form_main(\"".$row->branch."|".$row->max_no."\")' /></td>

      </tr>";  
    }else{
      $html.="<td style='width:100px;text-align:center;'><input type='button' title='Load' value='Load' onclick='load_data_form_main(\"".$row->nno."-".$row->t_code."-".$row->types."\"),disable_form()' /></td></tr>";  
    }
    
  }        
  $html.="</table>";
  $html.="</div>";
  echo $html;
}

public function send_email($status,$file_name,$send_name,$send_email,$subject,$send_email_list){


  if($status=="p"){
    $this->pdf->Output($file_name.date('Y-m-d').".pdf", 'I');
  }else if($status=="e"){
    $this->pdf->Output(__DIR__.$file_name.date('Y-m-d').".pdf", 'F');
  }

  $my_file = __DIR__."/PDF_to_email.pdf"; 
  $my_name = $send_name; 
  $my_mail = $send_email; 
  $my_replyto = $send_email; 
  $to_email = $send_email_list; 
  $my_subject = $subject; 
  $requester = "Nisaco (Pvt)Ltd."; 
  $message = "PDF"; 
  
  $this->mail_attachment($my_file, $to_email, $my_mail, $my_name, $my_replyto, $my_subject, $message); 

  
} 

public function mail_attachment($filename, $mailto, $from_mail, $from_name, $replyto, $subject, $message) { 
  $body = ''; 
  $headers = ''; 

  $file = $filename; 
  $separator = md5(time()); 
  $attachment = chunk_split(base64_encode(file_get_contents($file))); 
  $headers = "From: ".$from_name."<".$from_mail.">" . PHP_EOL; 
  $headers .= "Reply-To: ".$replyto . PHP_EOL; 
  $headers .= "MIME-Version: 1.0".PHP_EOL; 
  $headers .= "Content-Type: multipart/mixed; boundary=\"" . $separator . "\"" . PHP_EOL . PHP_EOL; 
  $body .= "Content-Transfer-Encoding: 7bit" . PHP_EOL; 
  $body .= "This is a MIME encoded message." . PHP_EOL; 
  $body .= "--" . $separator . PHP_EOL; 
  $body .= "Content-Type: text/html; charset=\"iso-8859-1\"" . PHP_EOL; 
  $body .= "Content-Transfer-Encoding: 8bit" . PHP_EOL . PHP_EOL; 
  $body .= $message . PHP_EOL; 
  $body .= "--" . $separator . PHP_EOL; 
  $body .= "Content-Type: application/octet-stream; name=\"" . "PDF.pdf" . "\"" . PHP_EOL; 
  $body .= "Content-Transfer-Encoding: base64" . PHP_EOL; 
  $body .= "Content-Disposition: attachment" . PHP_EOL . PHP_EOL; 
  $body .= $attachment . PHP_EOL; 
  $body .= "--" . $separator . "--"; 
  
  if (mail($mailto, $subject, $body, $headers)) { 
    echo "Email sent!"; 
  } else { 
    echo "EMAIL NOT SENT"; 
  } 
} 

function num_in_letter($num){


 function convertNum($num)
 {
  $safeNum = $num;
      $num     = (int) $num; // make sure it's an integer
      
      if ($num < 0)
        return "negative" . convertTri(-$num, 0);
      if ($num == 0)
        return "zero";
      
      $pos         = strpos($safeNum, '.');
      $len         = strlen($safeNum);
      $decimalPart = substr($safeNum, $pos + 1, $len - ($pos + 1));
      // var_dump($decimalPart);
       //exit();
      if ($pos > 0) {
        if($decimalPart=="00"){
          return convertTri1($num, 0) ." Only ";
        }else{
          $num1=rtrim(convertTri($num, 0) ,"and");
          return $num1 . " and Cents" . convertTri($decimalPart, 0) ." Only ";
        }
      } else {
        return convertTri($num, 0);
      }
    }

    function convertTri1($num, $tri)
    {
      $ones     = array(
        "",
        " One",
        " Two",
        " Three",
        " Four",
        " Five",
        " Six",
        " Seven",
        " Eight",
        " Nine",
        " Ten",
        " Eleven",
        " Twelve",
        " Thirteen",
        " Fourteen",
        " Fifteen",
        " Sixteen",
        " Seventeen",
        " Eighteen",
        " Nineteen"
        );
      $tens     = array(
        "",
        "",
        " Twenty",
        " Thirty",
        " Forty",
        " Fifty",
        " Sixty",
        " Seventy",
        " Eighty",
        " Ninety"
        );
      $triplets = array(
        "",
        " Thousand",
        " Million",
        " Billion",
        " Trillion",
        " Quadrillion",
        " Quintillion",
        " Sextillion",
        " Septillion",
        " Octillion",
        " Nonillion"
        );
      
      // chunk the number, ...rxyy
      $r = (int) ($num / 1000);
      $x = ($num / 100) % 10;
      $y = $num % 100;
      
      // init the output string
      $str = "";
      
      // do hundreds      
      if($y!="") 
      {
        if ($x > 0)
          $str = $ones[$x] . " Hundred and";
        
        // do ones and tens
        if ($y < 20)
          $str .= $ones[$y];
        else
        {

          $str .= $tens[(int) ($y / 10)] . $ones[$y % 10];
        }
      } 
      if($y==0) 
      {
        if ($x > 0)
          $str = $ones[$x] . " Hundred";
        
        // do ones and tens
        if ($y < 20)
          $str .= $ones[$y];
        else
          $str .= $tens[(int) ($y / 10)] . $ones[$y % 10];
        
      }   
      
      // add triplet modifier only if there
      // is some output to be modified...
      if ($str != "")
        $str .= $triplets[$tri];
      
      // continue recursing?
      if ($r > 0)
        return convertTri($r, $tri + 1) .$str;
      else
        return $str;
    }
    
    //------ ------ ------
      function convertTri($num, $tri) //no decimal part
      {
        $ones     = array(
          "",
          " One",
          " Two",
          " Three",
          " Four",
          " Five",
          " Six",
          " Seven",
          " Eight",
          " Nine",
          " Ten",
          " Eleven",
          " Twelve",
          " Thirteen",
          " Fourteen",
          " Fifteen",
          " Sixteen",
          " Seventeen",
          " Eighteen",
          " Nineteen"
          );
        $tens     = array(
          "",
          "",
          " Twenty",
          " Thirty",
          " Forty",
          " Fifty",
          " Sixty",
          " Seventy",
          " Eighty",
          " Ninety"
          );
        $triplets = array(
          "",
          " Thousand",
          " Million",
          " Billion",
          " Trillion",
          " Quadrillion",
          " Quintillion",
          " Sextillion",
          " Septillion",
          " Octillion",
          " Nonillion"
          );
        
      // chunk the number, ...rxyy
        $r = (int) ($num / 1000);
        $x = ($num / 100) % 10;
        $y = $num % 100;
        
      // init the output string
        $str = "";
        
      // do hundreds 
        if($y!="") 
        {
          if ($x > 0)
            $str = $ones[$x] . " Hundred";
          
        // do ones and tens
          if ($y < 20)
            $str .= $ones[$y];
          else
            $str .= $tens[(int) ($y / 10)] . $ones[$y % 10];
          
        } 
        else{

          if ($x > 0)
            $str = $ones[$x] . " Hundred and";
          
        // do ones and tens
          if ($y < 20)
            $str .= $ones[$y];
          else
            $str .= $tens[(int) ($y / 10)] . $ones[$y % 10];
          
        }
        
        
      // add triplet modifier only if there
      // is some output to be modified...
        if ($str != "")
          $str .= $triplets[$tri];
        
      // continue recursing?
        if ($r > 0)
          return convertTri($r, $tri + 1) . $str;
        else
          return $str;
      }
    //------------------------------------------------------------

    }
    public function default_group(){
      $sql="SELECT sales_group_code FROM `def_option_stock`";
      $query   =$this->db->query($sql)->row()->sales_group_code;
      return $query;
    }

    public function f1_selection_acc_code(){


      $table         = $_POST['data_tbl'];
      $field         = isset($_POST['field'])?$_POST['field']:'code';
      $field2        = isset($_POST['field2'])?$_POST['field2']:'description';
      $hid_field     = isset($_POST['hid_field'])?$_POST['hid_field']:0;
      $add_query     = isset($_POST['add_query'])?$_POST['add_query']:"";
      $preview_name1 = isset($_POST['preview1'])?$_POST['preview1']:'Code';
      $preview_name2 = isset($_POST['preview2'])?$_POST['preview2']:'Description';

      if($_POST['search'] == 'Key Word: code, name'){$_POST['search'] = "";}
      if($add_query!=""){
        $sql = "SELECT * FROM $table  WHERE ($field2 LIKE '%$_POST[search]%' OR $field LIKE '%$_POST[search]%' ) ".$add_query." LIMIT 25";
      }else{
        $sql = "SELECT * FROM $table  WHERE $field2 LIKE '%$_POST[search]%' OR $field LIKE '%$_POST[search]%' LIMIT 25";
      }
      $query = $this->db->query($sql);
      $a  = "<table id='item_list' style='width : 100%' >";
      $a .= "<thead><tr>";
      $a .= "<th class='tb_head_th'>".$preview_name1."</th>";
      $a .= "<th class='tb_head_th' colspan='2'>".$preview_name2."</th>";
      $a .= "</thead></tr><tr class='cl'><td>&nbsp;</td><td colspan='2'>&nbsp;</td></tr>";

      foreach($query->result() as $r){
        $a .= "<tr class='cl'>";
        $a .= "<td>".$r->{$field}."</td>";
        $a .= "<td>".$r->{$field2}."</td>";
        if($hid_field!=0){
          $a .= "<td><input type='hidden' class='code_gen' value='".$r->{$hid_field}."' title='".$r->{$hid_field}."' /></td>";        
        }
        $a .= "</tr>";
      }
      $a .= "</table>";
      echo $a;
    }

    public function sales_order_store(){
      $sql="SELECT def_sales_order_store FROM m_branch 
      WHERE cl='".$this->sd['cl']."' AND bc='".$this->sd['branch']."'";

      $result = $this->db->query($sql)->first_row()->def_sales_order_store;

      return $result;
    }
    
    public function is_auto_genarate($table,$col_name,$col_is_auto,$col_type){
      $sql="SELECT $col_is_auto AS is_auto, $col_type AS code_type FROM def_option_stock";

      $query=$this->db->query($sql);
      $cha_count = $query->first_row()->code_type;
      $is_auto = $query->first_row()->is_auto;
      
      if($is_auto==1){
        return $this->genarate_code($table,$cha_count,$col_name);
      }
    }

    public function genarate_code($table,$cha_count,$col_name){
      $sql="SELECT LPAD (IFNULL(MAX(max_no),0)+1,$cha_count,0) AS max_no FROM $table";
      return $max_no=$this->db->query($sql)->first_row()->max_no;
    }

    public function max_nno($table,$col_name){
      if(isset($_POST['code_'])){
        if($_POST['code_'] == "0" || $_POST['code_'] == ""){      
          $sql="SELECT IFNULL(MAX($col_name),0)+1 AS max_no FROM $table";
          return $this->db->query($sql)->row()->max_no;
        }else{
          return $_POST['max_nno'];  
        }
      }else{
        $sql="SELECT IFNULL(MAX($col_name),0)+1 AS max_no FROM $table";
        return $this->db->query($sql)->row()->max_no;
      }
    }


    public function max_nno_filter($table,$col_name,$filter_col,$filter_val){
      if(isset($_POST['code_'])){
        if($_POST['code_'] == "0" || $_POST['code_'] == ""){      
          $sql="SELECT IFNULL(MAX($col_name),0)+1 AS max_no FROM $table WHERE $filter_col='$filter_val'";
          return $this->db->query($sql)->row()->max_no;
        }else{
          return $_POST['max_nno'];  
        }
      }else{
        $sql="SELECT IFNULL(MAX($col_name),0)+1 AS max_no FROM $table WHERE $filter_col='$filter_val'";
        return $this->db->query($sql)->row()->max_no;
      }
    }


    public function get_nxt_code(){
      $table      = $_POST['data_tbl'];
      $filter_col = $_POST['filter_col'];
      $filter_val = $_POST['filter_val'];
      $col_is_auto= $_POST['col_is_auto'];
      $col_type   = $_POST['col_type'];
      $col_name   = $_POST['col_name'];
      $is_filter  = $_POST['is_filter'];
      
      $sql="SELECT $col_is_auto AS is_auto, $col_type AS code_type FROM def_option_stock";

      $query=$this->db->query($sql);
      $cha_count = $query->first_row()->code_type;
      $is_auto = $query->first_row()->is_auto;
      $max_no="";
      if($is_auto==1){
        if($is_filter==1){
          $sql="SELECT LPAD(IFNULL(MAX($col_name),0)+1,$cha_count,0) AS max_no FROM $table WHERE $filter_col ='$filter_val'";
          $max_no=$this->db->query($sql)->first_row()->max_no;      
        }else{
          $sql="SELECT LPAD(IFNULL(MAX($col_name),0)+1,$cha_count,0) AS max_no FROM $table";
          $max_no=$this->db->query($sql)->first_row()->max_no;          
        }
      }else{
        $max_no="";
      }
      echo $max_no;
    }

    public function f1_selection_list_emp(){

      $emp_category  = "";

      if($_POST['search'] == 'Key Word: code, name'){$_POST['search'] = "";}

      if(isset($_POST['filter_emp_cat'])){
        if($_POST['filter_emp_cat']=="salesman"){
          $emp_category="salesman_cat_code";
        }else if($_POST['filter_emp_cat']=="c_officer"){
          $emp_category="collection_officer_cat_code";
        }else if($_POST['filter_emp_cat']=="driver"){
          $emp_category="driver_cat_code";
        }else if($_POST['filter_emp_cat']=="helper"){
          $emp_category="helper_cat_code";
        }

        $sql="SELECT $emp_category FROM def_option_sales";
        $emp_cat = $this->db->query($sql)->row()->$emp_category;
        
        $sql="SELECT e.`code`,e.`name` FROM m_employee_activity a
        JOIN m_employee e ON e.`code` = a.`employee_id`
        WHERE a.`category` ='$emp_cat' AND a.`is_active` ='1' AND a.working_bc='".$this->sd['branch']."' OR a.working_bc=''
        AND (code LIKE '%$_POST[search]%' OR name LIKE '%$_POST[search]%')
        LIMIT 25";
      }else{
        $sql="SELECT e.`code`,e.`name` FROM m_employee_activity a
        JOIN m_employee e ON e.`code` = a.`employee_id`
        WHERE (code LIKE '%$_POST[search]%' OR name LIKE '%$_POST[search]%')
        LIMIT 25";
      }

      $query = $this->db->query($sql);
      $a  = "<table id='item_list' style='width : 100%' >";
      $a .= "<thead><tr>";
      $a .= "<th class='tb_head_th'>Employee Id</th>";
      $a .= "<th class='tb_head_th' colspan='2'>Name</th>";
      $a .= "</thead></tr><tr class='cl'><td>&nbsp;</td><td colspan='2'>&nbsp;</td></tr>";

      foreach($query->result() as $r){
        $a .= "<tr class='cl'>";
        $a .= "<td>".$r->code."</td>";
        $a .= "<td>".$r->name."</td>";
        $a .= "</tr>";
      }
      $a .= "</table>";
      echo $a;
    }
    public function f1_selection_list_customer(){


      $table         = $_POST['data_tbl'];
      $field         = isset($_POST['field'])?$_POST['field']:'code';
      $field2        = isset($_POST['field2'])?$_POST['field2']:'description';
      $field3        = isset($_POST['field3'])?$_POST['field3']:'nic';
      $field4        = isset($_POST['field4'])?$_POST['field4']:'tp';
      $field_address = isset($_POST['field_address'])?$_POST['field_address']:"";
      $hid_field     = isset($_POST['hid_field'])?$_POST['hid_field']:0;
      $add_query     = isset($_POST['add_query'])?$_POST['add_query']:"";
      $preview_name1 = isset($_POST['preview1'])?$_POST['preview1']:'Code';
      $preview_name2 = isset($_POST['preview2'])?$_POST['preview2']:'Name';
      $preview_name3 = isset($_POST['preview3'])?$_POST['preview3']:'NIC';

      if($_POST['search'] == 'Key Word: code, name'){$_POST['search'] = "";}
      if($add_query!=""){

        $sql = "SELECT $table.*,IFNULL(GROUP_CONCAT(m_customer_contact.$field4),'') AS $field4 FROM $table
        LEFT JOIN m_customer_contact ON m_customer_contact.$field=$table.$field
        WHERE ($table.$field2 LIKE '%$_POST[search]%' OR $table.$field3 LIKE '%$_POST[search]%' OR $table.$field LIKE '%$_POST[search]%' OR m_customer_contact.$field4 LIKE '%$_POST[search]%' ) ".$add_query."
        GROUP BY $table.$field LIMIT 25";
      }else{
        $sql = "SELECT $table.*,IFNULL(GROUP_CONCAT(m_customer_contact.$field4),'') AS $field4 FROM $table
        LEFT JOIN m_customer_contact ON m_customer_contact.$field=$table.$field
        WHERE ($table.$field2 LIKE '%$_POST[search]%' OR $table.$field3 LIKE '%$_POST[search]%' OR $table.$field LIKE '%$_POST[search]%' OR m_customer_contact.$field4 LIKE '%$_POST[search]%' ) GROUP BY $table.$field LIMIT 25";
      }
      $query = $this->db->query($sql);
      $a  = "<table id='item_list' style='width : 100%' >";
      $a .= "<thead><tr>";
      $a .= "<th class='tb_head_th'>".$preview_name1."</th>";
      $a .= "<th class='tb_head_th' colspan='2'>".$preview_name2."</th>";
      $a .= "<th class='tb_head_th'>".$preview_name3."</th>";
      if($hid_field!= 0 || $hid_field !='undefined' ){
        $a .= "<th class='tb_head_th'>&nbsp;</th>";
      }
      $a .= "<th class='tb_head_th'>TP</th>";
      $a .= "</thead></tr><tr class='cl'><td>&nbsp;</td><td colspan='3'>&nbsp;</td></tr>";

      foreach($query->result() as $r){
        $a .= "<tr class='cl'>";
        $a .= "<td>".$r->{$field}."</td>";
        $a .= "<td colspan='2'>".$r->{$field2}."</td>";
        $a .= "<td>".$r->{$field3}."</td>";
        if($hid_field!= 0 || $hid_field !='undefined' ){
          $a .= "<td><input type='hidden' class='code_gen' value='".$r->{$hid_field}."' title='".$r->{$hid_field}."' /></td>";        
        }
        if($field_address!=""){
          $address=""; 
          if ($r->address1!="") {$address.=$r->address1;}
          if ($r->address2!="") {$address.=", ".$r->address2;}
          if ($r->address3!="") {$address.=", ".$r->address3;}
          $a .= "<td style='display:none;'>".$address."</td>";

        } 
        $a .= "<td>".$r->{$field4}."</td>";
        $a .= "</tr>";
      }
      $a .= "</table>";
      echo $a;
    }
    public function is_developer(){

     $status="0";
     if($this->sd['name']=="developer"){
       $status="1";
     }

    /* if($this->sd['name']=="SuperAdmin" && $this->sd['oc']=="0"){
       $status="1";
     }*/

     return $status;
   }

   public function default_option(){

     $sql="SELECT 
     mb.def_sales_category,
     mb.use_sales_category,
     mb.def_sales_group,
     mb.use_sales_group,
     mb.`def_salesman`,
     e.`name` AS salesman,
     mb.`use_salesman`,
     mb.`def_sales_store`,
     s.`description` AS store,
     mb.`def_cash_customer`,
     c.`name` AS customer,
     c.`address1`,c.`address2`,c.`address3`,
     mb.`def_salesman`,
     mb.`def_salesman_code`,
     mb.`def_collection_officer`,
     mb.`def_collection_officer_code`,
     mb.`def_driver`,
     mb.`def_driver_code`,
     mb.`def_helper`,
     mb.`def_helper_code`
     FROM
     m_branch mb 
     LEFT JOIN m_stores s ON s.`code`=mb.`def_sales_store`
     LEFT JOIN m_employee e ON e.`code`=mb.`def_salesman` 
     LEFT JOIN m_customer c ON c.`code`=mb.`def_cash_customer` WHERE mb.cl ='".$this->sd['cl']."' AND mb.bc = '".$this->sd['branch']."'";
     $query = $this->db->query($sql)->first_row();

     echo json_encode( $query);
   }

   public function get_cur_time(){
    $sql="SELECT is_print_cur_time_rec FROM def_opt_common";
    $query=$this->db->query($sql);

    if ($query->num_rows() > 0) {
      $cur_time=$query->first_row()->is_print_cur_time_rec;
    }else{
      $cur_time=0;
    }

    return $cur_time;
    
  }

  public function heading_align(){
    $sql="SELECT `heading_align` FROM def_opt_common";
    $query=$this->db->query($sql);

    if ($query->num_rows() > 0) {
      $h_align=$query->first_row()->heading_align;
    }else{
      $h_align="";
    }
    return $h_align;
    
  }

  public function save_time(){
    $sql="SELECT `is_print_save_time_rec` FROM def_opt_common ";
    $query=$this->db->query($sql);

    if ($query->num_rows() > 0) {
      $sav_time=$query->first_row()->is_print_save_time_rec;
    }else{
     $sav_time=0;
   }
   return  $sav_time;
   
   
 }

 public function get_save_time($table,$col,$nno,$col_name){
  $sql="SELECT SUBSTRING($col,11) as action_date FROM $table WHERE $col_name='$nno' AND cl='".$this->sd['cl']."' AND bc='".$this->sd['branch']."'";
  $query=$this->db->query($sql);
  if ($query->num_rows() > 0) {
    $action_time=$query->first_row()->action_date;
  }else{
    $action_time="";
  }
  return $action_time; 
}


public function post_dated_chqs(){
  $ddate= date('y-m-d');
  $sql="SELECT t.bank,t.branch,t.account,t.cheque_no,t.amount,t.realize_date,b.description 
  FROM t_receipt_temp_cheque_det t
  JOIN m_bank_branch b ON b.code = t.branch
  WHERE cl='".$this->sd['cl']."'
  AND bc='".$this->sd['branch']."'
  AND realize_date <= '$ddate'
  AND t.status='P'";

  $query=$this->db->query($sql);
  if($query->num_rows()>0){
    $result=1;
  }else{
    $result=2;
  }
  return $result;
}

public function post_dated_chq_list(){
  $ddate= date('y-m-d');
  $sql="SELECT t.bank,t.branch,t.account,t.cheque_no,t.amount,t.realize_date,b.description 
  FROM t_receipt_temp_cheque_det t
  JOIN m_bank_branch b ON b.code = t.branch
  WHERE cl='".$this->sd['cl']."'
  AND bc='".$this->sd['branch']."'
  AND realize_date <= '$ddate'
  AND t.status='P' ";

  $query = $this->db->query($sql);
  $a = "<table id='item_list' style='width : 100%' >";
  $a .= "<thead><tr>";
  $a .= "<th class='tb_head_th'>Bank</th>";
  $a .= "<th class='tb_head_th'>Account</th>";
  $a .= "<th class='tb_head_th'>Cheque No</th>";
  $a .= "<th class='tb_head_th'>Amount</th>";

  $a .= "</thead></tr>";
  $a .= "<tr class='cl'>";
  $a .= "<td>&nbsp;</td>";
  $a .= "<td>&nbsp;</td>";
  $a .= "<td>&nbsp;</td>";
  $a .= "<td>&nbsp;</td>";
  $a .= "</tr>";

  foreach ($query->result() as $r){
    $a .= "<tr class='cl'>";
    $a .= "<td style='text-align:left;'>".trim($r->description)."</td>"; 
    $a .= "<td style='text-align:right;'>".trim($r->account)."</td>"; 
    $a .= "<td style='text-align:right;'>".trim($r->cheque_no)."</td>"; 
    $a .= "<td style='text-align:right;'>".trim($r->amount)."</td>"; 
    $a .= "</tr>";
  }
  $a .= "</table>";
  echo $a;   
}

public function price_type(){
  $sql="SELECT def_price_type FROM m_branch WHERE cl='".$this->sd['cl']."' AND bc='".$this->sd['branch']."'";
  $result = $this->db->query($sql)->row()->def_price_type;
  
  echo $result;
}

public function use_sale_prices(){
  $sql="SELECT is_sale_price_3,is_sale_price_4,is_sale_price_5,is_sale_price_6,def_sale_price_3,def_sale_price_4,def_sale_price_5,def_sale_price_6,is_show_cost,is_show_min,is_show_max FROM `m_branch` WHERE cl='".$this->sd['cl']."' AND bc='".$this->sd['branch']."'";
  $query = $this->db->query($sql)->row();
  
  $ar['is_sale_3'] = $query->is_sale_price_3;
  $ar['is_sale_4'] = $query->is_sale_price_4;
  $ar['is_sale_5'] = $query->is_sale_price_5;
  $ar['is_sale_6'] = $query->is_sale_price_6;
  $ar['def_sale_3'] = $query->def_sale_price_3;
  $ar['def_sale_4'] = $query->def_sale_price_4;
  $ar['def_sale_5'] = $query->def_sale_price_5;
  $ar['def_sale_6'] = $query->def_sale_price_6;
  $ar['cost'] = $query->is_show_cost;
  $ar['max'] = $query->is_show_max;
  $ar['min'] = $query->is_show_min;

  return $ar;
  
}

public function use_sale_prices_2(){
  $sql="SELECT is_sale_price_3,is_sale_price_4,is_sale_price_5,is_sale_price_6,def_sale_price_3,def_sale_price_4,def_sale_price_5,def_sale_price_6,is_show_cost,is_show_min,is_show_max FROM `m_branch` WHERE cl='".$this->sd['cl']."' AND bc='".$this->sd['branch']."'";
  $query = $this->db->query($sql)->row();
  
  $ar['is_sale_3'] = $query->is_sale_price_3;
  $ar['is_sale_4'] = $query->is_sale_price_4;
  $ar['is_sale_5'] = $query->is_sale_price_5;
  $ar['is_sale_6'] = $query->is_sale_price_6;
  $ar['def_sale_3'] = $query->def_sale_price_3;
  $ar['def_sale_4'] = $query->def_sale_price_4;
  $ar['def_sale_5'] = $query->def_sale_price_5;
  $ar['def_sale_6'] = $query->def_sale_price_6;
  $ar['cost'] = $query->is_show_cost;
  $ar['max'] = $query->is_show_max;
  $ar['min'] = $query->is_show_min;

  echo json_encode($ar);
  
}
public function select_color(){
  $sql = "SELECT cs.`color` 
  FROM `m_customer_status` cs
  WHERE cs.`code`='".$_POST['color_code']."'";
  $query = $this->db->query($sql);
  
  if ($query->num_rows() > 0) {
    $a['a'] = $query->result();
  }else{
    $a['a'] =2;
  } 
  echo json_encode($a);
}


public function default_modules(){
  $sql="SELECT def_use_seettu,def_use_hp,def_use_service,def_use_cheque,def_use_giftV,def_use_privilege,def_use_delivery_note FROM `def_option_sales`";
  $query = $this->db->query($sql)->row();

  $df['def_use_seettu']=$query->def_use_seettu;
  $df['def_use_hp']=$query->def_use_hp;
  $df['def_use_service']=$query->def_use_service;
  $df['def_use_cheque']=$query->def_use_cheque;
  $df['def_use_giftV']=$query->def_use_giftV;
  $df['is_use_pr_cards']=$query->def_use_privilege;
  $df['is_use_dele_note']=$query->def_use_delivery_note;

  
  return $df;

}

public function show_price(){

  $this->db->select(array('isShowCost','isShowMinPrice','isShowMaxPrice'));
  $this->db->where('cCode',$this->sd['oc']);
  $query= $this->db->get('s_users')->result_array();

  return $query;

}

public function default_color(){
  $sql="SELECT def_color FROM m_branch WHERE cl='".$this->sd['cl']."' AND bc='".$this->sd['bc']."'";
  $query=$this->db->query($sql)->row()->def_color;
  
  echo json_encode($query);
}


public function is_use_color(){
  $sql="SELECT is_use_color FROM m_branch WHERE cl='".$this->sd['cl']."' AND bc='".$this->sd['bc']."'";
  $query=$this->db->query($sql)->row()->is_use_color;
  
  return $query;
}

public function is_color_item(){
  $this->db->select(array("is_color_item"));
  $this->db->where("code", $_POST['code']);
  $this->db->where("inactive =", "0");
  $query = $this->db->get("m_item");

  foreach ($query->result() as $row) {
    echo $row->is_color_item;
  }
}




public function approve_voucher(){

  $branch = $_POST['bc'];
  $nno = $_POST['no'];
  $sql="SELECT ddate,note,cheque_amount,cash_amount,cash_acc,cheque_acc,sub_no FROM t_voucher_gl_sum WHERE bc='$branch' AND nno='$nno'";
  $query = $this->db->query($sql);
  $chq = $query->first_row()->cheque_amount;
  $cash = $query->first_row()->cash_amount;
  $ddate = $query->first_row()->ddate;
  $note = $query->first_row()->note;
  $cash_acc = $query->first_row()->cash_acc;
  $chq_acc = $query->first_row()->cheque_acc;
  $id= $query->first_row()->sub_no;

  $sql_det="SELECT acc_code,amount FROM t_voucher_gl_det WHERE bc='$branch' AND nno='$nno'";
  $query_det = $this->db->query($sql_det);


  $f_dr_amount=$f_cr_amount=0;
  foreach ($query_det->result() as $row){
    $f_dr_amount+=$row->amount;
  }

  $f_cr_amount = $chq + $cash;

  if($f_dr_amount == $f_cr_amount){

    $this->db->where('bc', $branch);
    $this->db->where('voucher_no', $nno);
    $this->db->update('t_voucher_trans',array("status"=>1,"approved_by"=>$this->sd['oc'])); 

    $this->db->where('bc', $branch);
    $this->db->where('nno', $nno);
    $this->db->update('t_voucher_gl_sum',array("status"=>1)); 

    $this->db->where('bc', $branch);
    $this->db->where('trans_code', 48);
    $this->db->where('trans_no', $nno);
    $this->db->delete('t_account_trans');
    
    $config = array(
      "ddate" => $ddate,
      "trans_code" => 48,
      "trans_no" => $nno,
      "op_acc" => 0,
      "reconcile" => 0,
      "cheque_no" => 0,
      "narration" => "",
      "ref_no" => ""
      );

    $des =  $note;
    $this->load->model('account');
    $this->account->set_data($config);

    foreach ($query_det->result() as $row){
      if ($row->amount > 0) {
        $dess =$note;
        $this->account->set_value4($dess, $row->amount, "dr", $row->acc_code, 1, $id);
      }
    }

    if ($cash > 0) {
      $acc_code = $cash_acc;
      $this->account->set_value4($des, $cash, "cr", $acc_code, 1,$id);
    }

    if ($chq > 0) {
      $sql_chq = "SELECT * FROM `opt_issue_cheque_det` WHERE trans_code='48' AND trans_no='$nno'";
      $query_chq = $this->db->query($sql_chq);

      foreach ($query_chq->result() as $chq){
        $acc_code = $this->utility->get_default_acc('ISSUE_CHEQUES');
        $this->account->set_value4("CHEQUE ACC -'".$chq->bank."' ", $chq->amount, "cr", $acc_code, 1,$id);
      }
    }
    echo 1;
  }else{
    echo "Invalid Account Update";
  }
}



public function reject_voucher(){
  $branch = $_POST['bc'];
  $nno = $_POST['no'];

  $this->db->where('bc', $branch);
  $this->db->where('voucher_no', $nno);
  $this->db->update('t_voucher_trans',array("status"=>2,"approved_by"=>$this->sd['oc'])); 

  $this->db->where('bc', $branch);
  $this->db->where('nno', $nno);
  $this->db->update('t_voucher_gl_sum',array("status"=>2)); 

  echo 1;
}

public function session_update(){
  $this->session->set_userdata('delete_day', $_POST['dddate']);
}

}
