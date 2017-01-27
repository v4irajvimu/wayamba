<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class m_branch extends CI_Model {

  private $sd;
  private $mtb;

  function __construct(){
   parent::__construct();

   $this->sd = $this->session->all_userdata();
   $this->load->database($this->sd['db'], true);
   $this->mtb = $this->tables->tb['m_branch'];
   $this->load->model('user_permissions');
 }

 public function base_details(){
   $a['table_data'] = $this->data_table();
   $a['cluster']=$this->cluster();
   $a['accNos']=$this->accNo();
   $a['cus_type']=$this->select_cus_type();
    //$a['stores']=$this->storeDetails();
   $a['sale_price'] = $this->utility->use_sale_prices(); 
   return $a;
 }

    //public function 
 public function data_table(){
  $this->load->library('table');
  $this->load->library('useclass');

  $this->table->set_template($this->useclass->grid_style());

  $cluster = array("data"=>"Cluster", "style"=>"width: 50px;");
  $name = array("data"=>"Name", "style"=>"width: 150px;");
  $bc = array("data"=>"Code", "style"=>"width: 100px;");
  $action = array("data"=>"Action", "style"=>"width: 60px;");

  $this->table->set_heading($cluster, $bc,$name,$action);

  $this->db->select(array('name', 'cl', 'bc'));
  $query = $this->db->get($this->mtb);

  foreach($query->result() as $r){
    $but = "<img src='".base_url()."img/edit.gif' onclick='set_edit(\"".$r->bc."\")' title='Edit' />&nbsp;&nbsp;";
    if($this->user_permissions->is_delete('m_branch')){ $but .= "<img src='".base_url()."img/delete.gif' onclick='set_delete(\"".$r->bc."\")' title='Delete' />";}

    $bc = array("data"=>$r->bc, "value"=>"code");
    $cluster = array("data"=>$r->cl, "value"=>"code");
    $name = array("data"=>$this->useclass->limit_text($r->name, 25));

    $action = array("data"=>$but, "style"=>"text-align: center;");

    $this->table->add_row($cluster, $bc, $name, $action);
  }

  return $this->table->generate();
}

public function save(){
	
  $this->db->trans_begin();
  error_reporting(E_ALL); 
  function exceptionThrower($type, $errMsg, $errFile, $errLine) { 
    throw new Exception($errMsg); 
  }
  set_error_handler('exceptionThrower'); 
  try {
   if (!isset($_POST['multi_store'])) {
    $_POST['multi_store'] = 0;
  }else{
    $_POST['multi_store'] = 1;
  }

  if (!isset($_POST['d_only'])) {
    $_POST['d_only'] = 0;
  }else{
    $_POST['d_only'] = 1;
  }

  if (!isset($_POST['is_sales_cat'])) {
    $_POST['is_sales_cat'] = 0;
  }else{
    $_POST['is_sales_cat'] = 1;
  }

  if (!isset($_POST['is_sales_group'])) {
    $_POST['is_sales_group'] = 0;
  }
  else{
    $_POST['is_sales_group'] = 1;
  }

  if (!isset($_POST['is_sales_man'])) {
    $_POST['is_sales_man'] = 0;
  }else{
    $_POST['is_sales_man'] = 1;
  }

  if (!isset($_POST['is_collection_off'])) {
    $_POST['is_collection_off'] = 0;
  }else{
    $_POST['is_collection_off'] = 1;
  }

  if (!isset($_POST['is_driver'])) {
    $_POST['is_driver'] = 0;
  }else{
    $_POST['is_driver'] = 1;
  }

  if (!isset($_POST['is_helper'])) {
    $_POST['is_helper'] = 0;
  }else{
    $_POST['is_helper'] = 1;
  }

  if(!isset($_POST['def_use_opening_hp'])){
    $_POST['def_use_opening_hp']= 0;
    $_POST['no_of_opening_hp']= "";    
  }else{
    $_POST['def_use_opening_hp']= 1;
    $_POST['no_of_opening_hp']=$_POST['no_of_opening_hp'] ;
  }

  if (!isset($_POST['is_price_3'])) {
    $_POST['is_price_3'] = 0;

  } else {
    $_POST['is_price_3'] = 1;
  }

  if (!isset($_POST['is_price_4'])) {
    $_POST['is_price_4'] = 0;

  } else {
    $_POST['is_price_4'] = 1;
  }

  if (!isset($_POST['is_price_5'])) {
    $_POST['is_price_5'] = 0;

  } else {
    $_POST['is_price_5'] = 1;
  }

  if (!isset($_POST['is_price_6'])) {
    $_POST['is_price_6'] = 0;

  } else {
    $_POST['is_price_6'] = 1;
  }

  if(!isset($_POST['is_show_type'])){
    $_POST['is_show_type']=0;
  }else{
    $_POST['is_show_type']=1;
  }

  if(!isset($_POST['is_show_financial_det'])){
    $_POST['is_show_financial_det']=0;
  }else{
    $_POST['is_show_financial_det']=1;
  }

  if(!isset($_POST['is_show_email'])){
    $_POST['is_show_email']=0;
  }else{
    $_POST['is_show_email']=1;
  }

  if(!isset($_POST['is_show_black_list_det'])){
    $_POST['is_show_black_list_det']=0;
  }else{
    $_POST['is_show_black_list_det']=1;
  }

  if(!isset($_POST['is_show_date_of_join'])){
    $_POST['is_show_date_of_join']=0;
  }else{
    $_POST['is_show_date_of_join']=1;
  }

  if(!isset($_POST['is_show_event'])){
    $_POST['is_show_event']=0;
  }else{
    $_POST['is_show_event']=1;
  }

  if(!isset($_POST['is_show_category'])){
    $_POST['is_show_category']=0;
  }else{
    $_POST['is_show_category']=1;
  }

  if(!isset($_POST['is_show_town'])){
    $_POST['is_show_town']=0;
  }else{
    $_POST['is_show_town']=1;
  }

  if(!isset($_POST['is_show_area'])){
    $_POST['is_show_area']=0;
  }else{
    $_POST['is_show_area']=1;
  }

  if(!isset($_POST['is_show_route'])){
    $_POST['is_show_route']=0;
  }else{
    $_POST['is_show_route']=1;
  }

  if(!isset($_POST['is_show_nationality'])){
    $_POST['is_show_nationality']=0;
  }else{
    $_POST['is_show_nationality']=1;
  }

  if(!isset($_POST['is_show_lp'])){
    $_POST['is_show_lp']=0;
  }else{
    $_POST['is_show_lp']=1;
  }

  if(!isset($_POST['is_show_sp'])){
    $_POST['is_show_sp']=0;
  }else{
    $_POST['is_show_sp']=1;
  }

  if (!isset($_POST['use_color'])) {
    $_POST['use_color'] = 0;
  } else {
    $_POST['use_color'] = 1;
  }

  $def_settings=array(
    "cl"                      => $_POST['cl'],
    "bc"                      => $_POST['bc'],
    "name"                    => $_POST['name'],
    "address"                 => $_POST['address'],
    "tp"                      => $_POST['tp'],
    "fax"                     => $_POST['fax'],
    "email"                   => $_POST['email'],
    "oc"                      => $this->sd["oc"],
    "current_acc"             => $_POST['current_acc'],
    "cash_customer_limit"     => $_POST['cash_customer_limit'],
    "def_cash_customer"       => $_POST['def_cash_customer'],
    "use_multi_stores"        => $_POST['multi_store'],
    "def_sales_store"         => $_POST['def_store'],
    "def_purchase_store_code" => $_POST['pur_store'],
    "def_sales_store_code"    => $_POST['sales_store'],
    "use_sales_category"      => $_POST['is_sales_cat'],
    "def_sales_category"      => $_POST['def_sales_category'],
    "use_sales_group"         => $_POST['is_sales_group'],
    "def_sales_group"         => $_POST['def_sales_group'],
                 // "open_bal_date"           => $_POST['open_bal_date'],
    "use_salesman"            => $_POST['is_sales_man'],
    "def_salesman"            => $_POST['desc_sales_man'],
    "def_salesman_code"       => $_POST['sales_man'],
    "use_collection_officer"  => $_POST['is_collection_off'],
    "def_collection_officer" => $_POST['desc_collection_off'],
    "def_collection_officer_code" => $_POST['collection_off'],
    "use_driver"                  => $_POST['is_driver'],
    "def_driver"                  => $_POST['desc_driver'],
    "def_driver_code"             => $_POST['driver'],
    "use_helper"                  => $_POST['is_helper'],
    "def_helper"                  => $_POST['desc_helper'],
    "def_helper_code"             => $_POST['helper'],
    "def_use_opening_hp"          => $_POST['def_use_opening_hp'],
    "no_of_opening_hp"            => $_POST['no_of_opening_hp'],
    "use_sales_type"              => $_POST['s_type'],
    "def_price_type"              => $_POST['def_price_type'],
    "is_sale_price_3"             => $_POST['is_price_3'],
    "is_sale_price_4"             => $_POST['is_price_4'],
    "is_sale_price_5"             => $_POST['is_price_5'],
    "is_sale_price_6"             => $_POST['is_price_6'],
    "def_sale_price_3"            => $_POST['def_sale_price_3'],
    "def_sale_price_4"            => $_POST['def_sale_price_4'],
    "def_sale_price_5"            => $_POST['def_sale_price_5'],
    "def_sale_price_6"            => $_POST['def_sale_price_6'],
    "is_show_type"                => $_POST['is_show_type'],
    "is_show_email"               => $_POST['is_show_email'],
    "is_show_date_of_join"        => $_POST['is_show_date_of_join'],
    "is_show_category"            => $_POST['is_show_category'],
    "def_category"                => $_POST['show_cat'],
    "is_show_town"                => $_POST['is_show_town'],
    "def_town"                    => $_POST['show_town'],
    "is_show_area"                => $_POST['is_show_area'],
    "def_area"                    => $_POST['show_area'],
    "is_show_route"               => $_POST['is_show_route'],
    "def_route"                   => $_POST['show_route'],
    "is_show_nationality"         => $_POST['is_show_nationality'],
    "def_nationality"             => $_POST['show_nation'],
    "is_show_financial_det"       => $_POST['is_show_financial_det'],
    "is_show_black_list_det"      => $_POST['is_show_black_list_det'],
    "is_show_event"               => $_POST['is_show_event'],
    "is_show_lp"                  => $_POST['is_show_lp'],
    "is_show_sp"                  => $_POST['is_show_sp'],
    "cus_type"                    => $_POST['cus_type'],
    "is_use_color"                => $_POST['use_color'],
    "def_color"                   => $_POST['def_color'],
    "is_only_transfer"            => $_POST['d_only']
    );

if($_POST['code_'] == "0" || $_POST['code_'] == ""){
  if($this->user_permissions->is_add('m_branch')){  
   $_POST['bc']=strtoupper($_POST['bc']);
   $this->db->insert('m_branch', $def_settings);
   $this->items_add_new_bc($_POST['cl'],$_POST['bc']);
   echo $this->db->trans_commit();
 }else{
  echo "No permission to save records";
  $this->db->trans_commit();
}    
}else{
  if($this->user_permissions->is_edit('m_branch')){  
    $this->db->where("bc", $_POST['code_']);
    $this->db->update('m_branch', $def_settings);
    $this->remove_item_in_bc($_POST['cl'],$_POST['code_']);
    $this->items_add_new_bc($_POST['cl'],$_POST['code_']);
    echo $this->db->trans_commit();
  }else{
    echo "No permission to edit records";
    $this->db->trans_commit();
  }    
}

}catch(Exception $e){ 
  $this->db->trans_rollback();
  echo $e->getMessage()."Operation fail please contact admin"; 
}    
}

public function remove_item_in_bc($cl,$bc){
  $this->db->where('cl', $cl);
  $this->db->where('bc', $bc);
  $this->db->delete("m_item_branch");
}

public function items_add_new_bc($cl,$bc){
  $sql="INSERT INTO `m_item_branch`
            (`cl`,`bc`,`code`,`department`,`main_category`,`category`,`inactive`,
             `serial_no`,`batch_item`,`unit`,`brand`,`model`,`rol`,`roq`,`supplier`,
             `barcode`,`purchase_price`,`min_price`,`max_price`,
             `item_serial`,`eoq`,`buffer_stock`,`qty`,`sale_price_3`,`sale_price_4`,
             `sale_price_5`,`sale_price_6`,`description`)
        SELECT '$cl','$bc',`code`,`department`,`main_category`,`category`,`inactive`,
             `serial_no`,`batch_item`,`unit`,`brand`,`model`,`rol`,`roq`,`supplier`,
             `barcode`,`purchase_price`,`min_price`,`max_price`,
             `item_serial`,`eoq`,`buffer_stock`,`qty`,`sale_price_3`,`sale_price_4`,
             `sale_price_5`,`sale_price_6`,`description`
        FROM m_item";
  $query=$this->db->query($sql);
}



public function check_code(){
	$this->db->where('code', $_POST['code']);
	$this->db->limit(1);
	
	echo $this->db->get($this->mtb)->num_rows;
}



public function get_data_table(){
  echo $this->data_table();
}



public function load(){
  /*  	$this->db->where('bc', $_POST['bc']);
    	$this->db->limit(1);
    	echo json_encode($this->db->get($this->mtb)->first_row());*/
      $sql="SELECT  
      m_branch.cl,
      m_branch.bc, 
      m_branch.name,
      m_branch.address,
      m_branch.tp,
      m_branch.fax,
      m_branch.email,
      m_branch.current_acc,  
      m_branch.cash_customer_limit,
      m_branch.def_cash_customer,
      m_branch.use_multi_stores,
      m_branch.def_sales_store,
      m_branch.def_purchase_store_code,
      m_branch.def_sales_store_code,
      m_branch.use_sales_category,
      m_branch.def_sales_category,
      m_branch.use_sales_group,
      m_branch.def_sales_group,
      m_branch.use_salesman,
      m_branch.def_salesman_code,
      m_branch.def_salesman,
      m_branch.use_collection_officer,
      m_branch.def_collection_officer,
      m_branch.def_collection_officer_code,
      m_branch.use_driver,
      m_branch.def_driver_code,
      m_branch.def_driver,
      m_branch.use_helper,
      m_branch.def_helper_code,
      m_branch.def_helper,
      m_branch.def_use_opening_hp,
      m_branch.no_of_opening_hp,
      m_branch.is_only_transfer,
      m_customer.name AS customer_name,
      m_stores.`description` AS stores_name,
      r_sales_category.`description` AS category_name,
      r_groups.name AS group_name,
      m_account.description AS Acc_name,
      ps.description AS def_p_store,
      ss.description AS def_s_store,
      m_branch.use_sales_type,
      m_branch.def_price_type,
      m_branch.is_sale_price_3,
      m_branch.is_sale_price_4,
      m_branch.is_sale_price_5,
      m_branch.def_sale_price_3,
      m_branch.def_sale_price_4,
      m_branch.def_sale_price_5,
      m_branch.def_sale_price_6,
      m_branch.is_show_type,
      m_branch.is_show_email,
      m_branch.is_show_date_of_join,
      m_branch.is_show_category,
      m_branch.def_category,
      m_branch.is_show_town,
      m_branch.def_town,
      m_branch.is_show_area,
      m_branch.def_area,
      m_branch.is_show_route,
      m_branch.def_route,
      m_branch.is_show_nationality,
      m_branch.def_nationality,
      m_branch.is_show_financial_det,
      m_branch.is_show_black_list_det,
      m_branch.is_show_event,
      m_branch.is_show_lp,
      m_branch.is_show_sp,
      m_branch.cus_type,
      m_branch.is_use_color,
      m_branch.def_color,
      rc.`description` AS cat_desc,
      rt.`description` AS town_desc,
      ra.`description` AS area_desc,
      rtt.`description` AS root_desc,
      rn.`description` AS nation_desc


      FROM m_branch 
      LEFT JOIN `r_cus_category` rc ON rc.`code` = m_branch.`def_category` 
      LEFT JOIN `r_town` rt ON rt.`code`=m_branch.`def_town`
      LEFT JOIN `r_area` ra ON ra.`code`= m_branch.`def_area`
      LEFT JOIN `r_root` rtt ON rtt.`code`= m_branch.`def_route`
      LEFT JOIN `r_nationality` rn ON rn.`code` = m_branch.`def_nationality`

      LEFT JOIN m_customer ON m_branch.def_cash_customer= m_customer.code
      LEFT JOIN m_stores ON m_branch.`def_sales_store`=m_stores.code
      LEFT JOIN m_stores  AS ps ON ps.`code`=m_branch.def_purchase_store_code
      LEFT JOIN m_stores  AS ss ON ss.`code`=m_branch.def_sales_store_code
      LEFT JOIN r_sales_category ON m_branch.`def_sales_category`=r_sales_category.`code` 
      LEFT JOIN r_groups ON m_branch.`def_sales_group`=r_groups.`code`
      LEFT JOIN m_account ON m_branch.`current_acc`=m_account.`code`  
      LEFT JOIN r_color ON r_color.`code`=m_branch.`def_color`  
      WHERE m_branch.bc='".$_POST['bc']."'";
      $query = $this->db->query($sql)->result();

      echo json_encode($query);

    }


    
    public function delete(){

      $this->db->trans_begin();
      error_reporting(E_ALL); 
      function exceptionThrower($type, $errMsg, $errFile, $errLine) { 
        throw new Exception($errMsg); 
      }
      set_error_handler('exceptionThrower'); 
      try {
        if($this->user_permissions->is_delete('m_branch')){

          $this->db->where('bc', $_POST['bc']);
          $this->db->delete("m_item_branch");

          $this->db->where('bc', $_POST['bc']);
          $this->db->limit(1);
          $this->db->delete($this->mtb);
          echo $this->db->trans_commit();
       }else{
        echo "No permission to delete records";
        $this->db->trans_commit();
      }    
    }catch(Exception $e){ 
      $this->db->trans_rollback();
      echo $e->getMessage()." - Operation fail please contact admin"; 
    }

  }


  public function select(){
    $query = $this->db->get($this->mtb);
    $s = "<select name='bc' id='bc'>";
    $s .= "<option value='0'>---</option>";
    foreach($query->result() as $r){
      $s .= "<option title='".$r->name."' value='".$r->bc."'>".$r->bc." | ".$r->name."</option>";
    }
    $s .= "</select>";

    return $s;
  }


  public function cluster(){
    $query = $this->db->get("m_cluster");
    $s = "<select name='cl' id='cluster' style='width:100px;'>";
    $s .= "<option value='0'>---</option>";
    foreach($query->result() as $r){
      $s .= "<option title='".$r->description."' value='".$r->code."'>".$r->code."</option>";
    }
    $s .= "</select>";
    return $s;

  }

  public function accNo(){
    $this->db->where("is_control_acc", '0');
    $query = $this->db->get("m_account");
    $s = "<select name='current_acc' id='acc' style='width:100px;'>";
    $s .= "<option value='0'>---</option>";
    foreach($query->result() as $r){
      $s .= "<option title='".$r->description."' value='".$r->code."'>".$r->code." | ".$r->description."</option>";
    }
    $s .= "</select>";
    return $s;

  }



  public function auto_com(){
    $this->db->like('bc', $_GET['q']);
    $this->db->or_like($this->mtb.'.name', $_GET['q']);
    $query = $this->db->select(array('bc', $this->mtb.'.name'))->get($this->mtb);
    $abc = "";
    foreach($query->result() as $r){
      $abc .= $r->bc."|".$r->name;
      $abc .= "\n";
    }

    echo $abc;
  } 

  function load_all_stores(){

    $add_query     = isset($_POST['add_query'])?$_POST['add_query']:"";

    if($_POST['search'] == 'Key Word: code, name'){$_POST['search'] = "";}
    if($add_query!=""){
      $sql = "SELECT * FROM m_stores  WHERE (description LIKE '%$_POST[search]%' OR code LIKE '%$_POST[search]%' )  AND cl='".$this->sd['cl']."' AND bc='".$this->sd['branch']."' ".$add_query." LIMIT 25";
    }else{
      $sql = "SELECT * FROM m_stores  WHERE (description LIKE '%$_POST[search]%' OR code LIKE '%$_POST[search]%' )  AND cl='".$this->sd['cl']."' AND bc='".$this->sd['branch']."' LIMIT 25";
    }
    $query = $this->db->query($sql);
    $a  = "<table id='item_list' style='width : 100%' >";
    $a .= "<thead><tr>";
    $a .= "<th class='tb_head_th'> Code </th>";
    $a .= "<th class='tb_head_th' colspan='2'> Description </th>";
    $a .= "</thead></tr><tr class='cl'><td>&nbsp;</td><td colspan='2'>&nbsp;</td></tr>";

    foreach($query->result() as $r){
      $a .= "<tr class='cl'>";
      $a .= "<td>".$r->code."</td>";
      $a .= "<td>".$r->description."</td>";
      $a .= "</tr>";
    }
    $a .= "</table>";
    echo $a;
  }

  function select_cus_type(){
    $query = $this->db->get('r_customer_type');
    $cus = "<select name='cus_type' id='cus_type'>";
    $cus.="<option >-----</option>";
    foreach($query->result() as $r){          
      $cus.="<option title='".$r->description."' value='".$r->code."'>".$r->description."</option>";
    }
    $cus.="</select>";
    return $cus;

  }

  
}