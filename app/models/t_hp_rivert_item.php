<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class t_hp_rivert_item extends CI_Model {

  private $sd;
  private $mtb;
  private $tb_po_trans;
  private $max_no;
  private $mod = '003';
  private $trans_code;
  private $sub_trans_code;
  private $qty_out="0";
  protected $show_cost_2;

  function __construct(){
  	parent::__construct();
  	
  	$this->sd = $this->session->all_userdata();
    $this->load->database($this->sd['db'], true);

    $this->load->model('user_permissions');

    $this->load->model('utility');

    /*$cost = $this->utility->show_price();
    $this->show_cost_2=$cost[0]['isShowCost'];*/
  }

  public function base_details(){
    $a['max_no'] = $this->utility->get_max_no("t_hp_seize_rivert_sum","nno");
    $a['type'] = 'HP_RIVERT_ITEM';
    $a['cl']=$this->sd['cl'];
    $a['bc']=$this->sd['branch'];

    return $a;
  }

  public function validation(){
    $status=1;
    $this->max_no= $this->utility->get_max_no("t_hp_seize_rivert_sum","nno");
    return $status;
  }

  public function save(){

    //$this->db->trans_begin();
    error_reporting(E_ALL); 
    function exceptionThrower($type, $errMsg, $errFile, $errLine) { 
      throw new Exception($errMsg."-".$errFile."-".$errLine); 
    }
    set_error_handler('exceptionThrower'); 
    try {

      $validation_status=$this->validation();
      if($validation_status==1){

        $sum=array(
         "cl"             =>$this->sd['cl'],
         "bc"             =>$this->sd['branch'],
         "nno"            =>$this->max_no,
         "ddate"          =>$_POST['date'],
         "ref_no"         =>$_POST['ref_no'],
         "agr_no"         =>$_POST['agr_no'],
         "cus_id"         =>$_POST['customer'],
         "from_store"     =>$_POST['from_store'],
         "return_person"  =>$_POST['return_person'],
         "salesman"       =>$_POST['s_code'],
         "note"           =>$_POST['note'],
         "tot_qty"        =>$_POST['tot_qty'],
         "net_amount"     =>$_POST['net'],
         "oc"             =>$this->sd['oc']
         );

        for($x = 0; $x<=25; $x++){
          if(isset($_POST['0_'.$x])){
            if($_POST['0_'.$x] != ""){
              $det[]= array(
                "cl"         =>$this->sd['cl'],
                "bc"         =>$this->sd['branch'],
                "nno"        =>$this->max_no,
                "item_code"  =>$_POST['0_'.$x], 
                "serial_no"  =>$_POST['serial_no_'.$x],
                "price"      =>$_POST['max_'.$x],
                "a_qty"      =>$_POST['a_qty_'.$x],
                "t_qty"      =>$_POST['tqty_'.$x],
                "batch_no"   =>$_POST['bt1_'.$x]

                ); 
            }
          }
        }


        if($_POST['hid'] == "0" || $_POST['hid'] == ""){
          if($this->user_permissions->is_add('t_hp_rivert_item')){

           $this->db->insert("t_hp_seize_rivert_sum",$sum);
           if(count($det)){$this->db->insert_batch("t_hp_seize_rivert_det",$det);} 

           $this->load->model('trans_settlement');
           for($x = 0; $x<=25; $x++){
            if(isset($_POST['0_'.$x])){
              if($_POST['0_'.$x] != ""){

                $this->trans_settlement->save_item_movement('t_item_movement',
                  $_POST['0_'.$x],
                  '119',
                  $this->max_no,
                  $_POST['date'],
                  0,
                  $_POST['tqty_' . $x],
                  $_POST['from_store'],
                  $this->utility->get_cost_price($_POST['0_' . $x]),
                  $_POST['bt1_'.$x],
                  $this->utility->get_cost_price($_POST['0_' . $x]),
                  $this->utility->get_min_price($_POST['0_' . $x]),
                  $_POST['max_' . $x],
                  001);

                $this->db->where("cl", $this->sd['cl']);
                $this->db->where("bc", $this->sd['branch']);
                $this->db->where("nno", $_POST['seize_no']);
                $this->db->where("item_code", $_POST['0_'.$x]);
                $this->db->update("t_hp_seize_det",array("status"=>3));

                $this->serial_save();    
              }
            }
          }

          $this->utility->save_logger("SAVE",119,$this->max_no,$this->mod);
          echo $this->db->trans_commit();
        }else{
          $this->db->trans_commit();
          echo "No permission to save records";
        }  
      }else{

        if($this->user_permissions->is_edit('t_hp_rivert_item')){

          $this->db->where("cl", $this->sd['cl']);
          $this->db->where("bc", $this->sd['branch']);
          $this->db->where('nno',$_POST['id']);
          $this->db->update("t_hp_seize_rivert_sum",$sum);

          $this->set_delete();

          if(count($det)){$this->db->insert_batch("t_hp_seize_rivert_det",$det);}

          $this->load->model('trans_settlement');
          for($x = 0; $x<=25; $x++){
            if(isset($_POST['0_'.$x])){
              if($_POST['0_'.$x] != ""){

                $this->trans_settlement->save_item_movement('t_item_movement',
                  $_POST['0_'.$x],
                  '119',
                  $this->max_no,
                  $_POST['date'],
                  0,
                  $_POST['tqty_' . $x],
                  $_POST['from_store'],
                  $this->utility->get_cost_price($_POST['0_' . $x]),
                  $_POST['bt1_'.$x],
                  $this->utility->get_cost_price($_POST['0_' . $x]),
                  $this->utility->get_min_price($_POST['0_' . $x]),
                  $_POST['max_' . $x],
                  001);

                $this->db->where("cl", $this->sd['cl']);
                $this->db->where("bc", $this->sd['branch']);
                $this->db->where("nno", $_POST['seize_no']);
                $this->db->where("item_code", $_POST['0_'.$x]);
                $this->db->update("t_hp_seize_det",array("status"=>3));

                $this->serial_save();    
              }
            }
          }

          $this->serial_save();    

          $this->utility->save_logger("EDIT",119,$this->max_no,$this->mod); 
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
    echo $e->getMessage()."Operation fail please contact admin".$e; 
  }  
}

public function serial_save() {

  if ($_POST['hid'] == "0" || $_POST['hid'] == "") {
    for ($x = 0; $x < 20; $x++) {
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
                  "out_doc" => 119,
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
                  "trans_type" => 119,
                  "trans_no" => $this->max_no,
                  "item" => $_POST['0_' . $x],
                  "batch_no" => $this->get_batch_serial_wise($_POST['0_' . $x], $p[$i]),
                  "serial_no" => $p[$i],
                  "qty_in" => 0,
                  "qty_out" => 1,
                  "cost" => $_POST['max_' . $x],
                  "store_code" => $_POST['from_store'],
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
   $this->db->where("out_doc", 119);
   $this->db->update("t_serial", $t_serial);

   $this->db->select(array('item', 'serial_no'));
   $this->db->where("trans_no", $this->max_no);
   $this->db->where("trans_type", 119);
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
   $this->db->where("trans_type", 119);
   $this->db->delete("t_serial_movement");

   $this->db->where("cl", $this->sd['cl']);
   $this->db->where("bc",$this->sd['branch']);
   $this->db->where("trans_no", $this->max_no);
   $this->db->where("trans_type", 119);
   $this->db->delete("t_serial_movement_out");


   for ($x = 0; $x < 20; $x++) {
    if (isset($_POST['0_' . $x])) {
      if ($_POST['0_' . $x] != "" || !empty($_POST['0_' . $x])) {
       if ($this->check_is_serial_items($_POST['0_' . $x]) == 1) {
        $serial = $_POST['all_serial_'.$x];
        $p=explode(",",$serial);
        for($i=0; $i<count($p); $i++){

         $t_seriall = array(
           "engine_no" => "",
           "chassis_no" => '',
           "out_doc" => 119,
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
           "trans_type" => 119,
           "trans_no" => $this->max_no,
           "item" => $_POST['0_'.$x],
           "batch_no" => $this->get_batch_serial_wise($_POST['0_'.$x], $p[$i]),
           "serial_no" => $p[$i],
           "qty_in" => 0,
           "qty_out" => 1,
           "cost" => $_POST['max_' . $x],
           "store_code" => $_POST['from_store'],
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

public function get_batch_serial_wise($item, $serial) {
  $this->db->select("batch");
  $this->db->where("cl", $this->sd['cl']);
  $this->db->where("bc", $this->sd['branch']);
  $this->db->where("item", $item);
  $this->db->where("serial_no", $serial);
  return $this->db->get('t_serial')->first_row()->batch;
}


public function check_is_serial_items($code) {
  $this->db->select(array('serial_no'));
  $this->db->where("code", $code);
  $this->db->limit(1);
  return $this->db->get("m_item")->first_row()->serial_no;
}

public function PDF_report(){


  $this->db->select(array('name','address','tp','fax','email'));
  $this->db->where("cl",$this->sd['cl']);
  $this->db->where("bc",$this->sd['branch']);
  $r_detail['branch']=$this->db->get('m_branch')->result();

  $this->db->select(array('name','address','tp','fax','email'));
  $this->db->where("cl",$this->sd['cl']);
  $this->db->where("bc",$r_detail['ship_to_bc']);
  $r_detail['ship_branch']=$this->db->get('m_branch')->result();


  $r_detail['qno']=$_POST['qno'];
  $r_detail['page']="A5";
  $r_detail['header']=$_POST['header'];
  $r_detail['orientation']="L";
  $r_detail['type']=$_POST['type'];
  $r_detail['status']=$_POST['print_type'];

  $this->db->select(array(
    'sm.nno',
    'sm.ddate',
    'sm.ref_no',
    'sm.agr_no',
    'sm.cus_id',
    'sm.from_store',
    'sm.tot_qty',
    'm_customer.name AS cus_name',
    'm_customer.address1',
    'm_customer.address2',
    'm_customer.address3',
    'ths.nno AS hp_nno',
    'ths.ref_no AS hpref_no',
    'ths.ddate AS hp_ddate',
    'sm.from_store',
    'm_stores.description AS store_name',
    'sm.return_person',
    'e1.name AS ret_person_name',
    'sm.salesman',
    'e2.name as salesman_name',
    'sm.note',
    'sm.is_cancel'
    ));
  $this->db->from('t_hp_seize_rivert_sum AS sm');
  $this->db->join('t_hp_sales_sum  AS ths','ths.agreement_no=sm.agr_no');
  $this->db->join('m_customer','m_customer.code=ths.cus_id');
  $this->db->join('m_stores','m_stores.code=sm.from_store');
  $this->db->join('m_employee e1','e1.code=sm.return_person');
  $this->db->join('m_employee e2','e2.code=sm.salesman');
  $this->db->where('sm.cl',$this->sd['cl']);
  $this->db->where('sm.bc',$this->sd['branch']);
  $this->db->where('sm.nno',$_POST['qno']);

  $r_detail['sum']=$this->db->get()->result();

  $this->db->select(array(
    'dt.nno',
    'dt.item_code',
    'dt.serial_no',
    'dt.a_qty',
    'dt.t_qty',
    'mi.description AS item_name'));

  $this->db->from('t_hp_seize_rivert_det AS dt');
  $this->db->join('m_item AS mi','mi.code=dt.item_code');
  $this->db->where('dt.cl',$this->sd['cl']);
  $this->db->where('dt.bc',$this->sd['branch']);
  $this->db->where('dt.nno',$_POST['qno']);

  $r_detail['det']=$this->db->get()->result();

  $this->db->SELECT(array('serial_no','item'));
  $this->db->FROM('t_serial_movement_out');
  $this->db->WHERE('t_serial_movement_out.cl', $this->sd['cl']);
  $this->db->WHERE('t_serial_movement_out.bc', $this->sd['branch']);
  $this->db->WHERE('t_serial_movement_out.trans_type','119');
  $this->db->WHERE('t_serial_movement_out.trans_no',$_POST['qno']);
  $r_detail['serial'] = $this->db->get()->result();


 // $r_detail['suppliers']=$this->db->query($sql)->result();

  $this->load->view($_POST['by'].'_'.'pdf',$r_detail);

}


private function set_delete(){
  $this->db->where("nno", $_POST['id']);
  $this->db->where("cl", $this->sd['cl']);
  $this->db->where("bc", $this->sd['branch']);
  $this->db->delete("t_hp_seize_rivert_det");

  $this->load->model('trans_settlement');
  $this->trans_settlement->delete_item_movement('t_item_movement',119,$_POST['hid']);
}




public function load(){

  $this->db->select(array(
    'sm.nno',
    'sm.ddate',
    'sm.ref_no',
    'sm.agr_no',
    'sm.cus_id',
    'sm.from_store',
    'sm.tot_qty',
    'sm.net_amount',
    'm_customer.name AS cus_name',
    'm_customer.address1',
    'm_customer.address2',
    'm_customer.address3',
    'ths.nno AS hp_nno',
    'ths.ref_no AS hpref_no',
    'ths.ddate AS hp_ddate',
    'sm.from_store',
    'm_stores.description AS store_name',
    'sm.return_person',
    'm_employee.name AS ret_person_name',
    'sm.salesman',
    'sm.note',
    'sm.is_cancel',
    'ss.nno AS seize_no'
    ));
  $this->db->from('t_hp_seize_rivert_sum AS sm');
  $this->db->join('t_hp_sales_sum  AS ths','ths.agreement_no=sm.agr_no');
  $this->db->join('t_hp_seize_sum  AS ss','ss.agr_no=sm.agr_no');
  $this->db->join('m_customer','m_customer.code=ths.cus_id');
  $this->db->join('m_stores','m_stores.code=sm.from_store');
  $this->db->join('m_employee','m_employee.code=sm.return_person');
  $this->db->where('sm.cl',$this->sd['cl']);
  $this->db->where('sm.bc',$this->sd['branch']);
  $this->db->where('sm.nno',$_POST['id']);

  $a['sum']=$this->db->get()->result();

  $this->db->select(array(
    'dt.nno',
    'dt.item_code',
    'dt.serial_no',
    'dt.a_qty',
    'dt.t_qty',
    'mi.description AS item_name',
    'dt.batch_no',
    'dt.price'
    ));

  $this->db->from('t_hp_seize_rivert_det AS dt');
  $this->db->join('m_item AS mi','mi.code=dt.item_code');
  $this->db->where('dt.cl',$this->sd['cl']);
  $this->db->where('dt.bc',$this->sd['branch']);
  $this->db->where('dt.nno',$_POST['id']);

  $a['det']=$this->db->get()->result();

  $this->db->select(array('t_serial.item', 't_serial.serial_no'));
  $this->db->from('t_serial');
  $this->db->join('t_hp_seize_rivert_sum', 't_serial.out_no=t_hp_seize_rivert_sum.nno');
  $this->db->where('t_serial.out_doc', 119);
  $this->db->where('t_serial.out_no', $_POST['id']);
  $this->db->where('t_hp_seize_rivert_sum.cl', $this->sd['cl']);
  $this->db->where('t_hp_seize_rivert_sum.bc', $this->sd['branch']);
  $query = $this->db->get();

  if ($query->num_rows() > 0) {
    $a['serial'] = $query->result();
  } else {
    $a['serial'] = 2;
  }

  echo json_encode($a);
}



public function delete(){

  $this->db->trans_begin();
  error_reporting(E_ALL); 
  function exceptionThrower($type, $errMsg, $errFile, $errLine) { 
    throw new Exception($errMsg."-".$errFile."-".$errLine); 
  }
  set_error_handler('exceptionThrower'); 
  try {

   if($this->user_permissions->is_delete('t_hp_rivert_item')){
    $this->db->where('cl',$this->sd['cl']);
    $this->db->where('bc',$this->sd['branch']);
    $this->db->where('nno',$_POST['id']);
    $this->db->update('t_hp_seize_rivert_sum',array("is_cancel"=>1));

    $this->utility->save_logger("CANCEL",116,$_POST['id'],$this->mod);
    echo $this->db->trans_commit();
  }else{
   $this->db->trans_commit();
   echo "No permission to delete records";

 }

}catch(Exception $e){ 
  $this->db->trans_rollback();
  echo $e->getMessage()."Operation fail please contact admin".$e; 
}  


}



public function load_agr_no(){

  if($_POST['search'] == 'Key Word: code, name'){$_POST['search'] = "";} 

  $sql="SELECT 
  s.`nno`,
  s.`ref_no`,
  s.`ddate`,
  s.`agreement_no`,
  s.`cus_id`,
  mc.`name`,
  mc.`address1`,
  mc.`address2`,
  mc.`address3`
  FROM t_hp_sales_sum s
  JOIN m_customer mc ON mc.`code`=s.`cus_id`
  WHERE s.is_seize = 1
  AND s.`cl`='".$this->sd['cl']."'
  AND s.`bc` = '".$this->sd['branch']."'
  AND (s.ddate LIKE '%$_POST[search]%' OR s.agreement_no LIKE '$_POST[search]%' OR s.cus_id LIKE '%$_POST[search]%' OR mc.name LIKE '%$_POST[search]%' )
  LIMIT 25";

  $query=$this->db->query($sql);

  $a = "<table id='item_list' style='width : 100%' >";
  $a .= "<thead><tr>";
  $a .= "<th class='tb_head_th'>Date</th>";
  $a .= "<th class='tb_head_th'>Agreement No</th>";
  $a .= "<th class='tb_head_th'>Customer Code</th>";
  $a .= "<th class='tb_head_th'>Customer Name</th>";
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
    $a .= "<td>".$r->name."</td>";
    $a.="<td style='display:none;'>".$r->address1."</td>";
    $a.="<td style='display:none;'>".$r->address2."</td>";
    $a.="<td style='display:none;'>".$r->address3."</td>";
    $a.="<td style='display:none;'>".$r->ddate."</td>";
    $a.="<td style='display:none;'>".$r->nno."</td>";
    $a.="<td style='display:none;'>".$r->ref_no."</td>";
    $a.="</tr>";
  }
  $a.="</table>";

  echo $a;
}

public function load_agr_item(){

  $sql="SELECT 
  sm.`agr_no`,
  dt.`item_code`,
  dt.`qty`,
  dt.`serials`,
  mi.`description` AS item_name,
  dt.batch,
  dt.price,
  sm.nno
  FROM t_hp_seize_det dt
  JOIN t_hp_seize_sum sm ON sm.`cl`=dt.`cl` AND sm.`bc`=dt.`bc` AND sm.`nno`=dt.`nno`
  JOIN m_item mi ON mi.code=dt.item_code
  WHERE sm.`agr_no`='".$_POST['agr_no']."'";

  $a['data']=$this->db->query($sql)->result();
  echo json_encode($a);

}

}