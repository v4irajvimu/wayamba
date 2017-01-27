<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class t_direct_internal_transfer extends CI_Model {

  private $sd;
  private $mtb;

  private $mod = '003';

  function __construct(){
   parent::__construct();

   $this->sd = $this->session->all_userdata();
   $this->load->database($this->sd['db'], true);
   $this->load->model('user_permissions');
 }

 public function base_details(){
  $data = $this->get_bc_name();
  $a['cluster']=$data[0]['code'];
  $a['cluster_name']=$data[0]['description'];
  $a['branch']=$data[0]['bc'];
  $a['branch_name']=$data[0]['name'];
  $a['id']=$this->utility->get_max_no('t_direct_transfer_sum','nno');  
  return $a;
}

public function get_bc_name(){
  $sql="SELECT code,description,bc,name 
        FROM m_branch 
        JOIN m_cluster ON m_cluster.code = m_branch.cl
        WHERE cl='".$this->sd['cl']."'
        AND bc='".$this->sd['branch']."'";
  return $this->db->query($sql)->result_array();
}

public function validation(){
  $status=1;
  $this->max_no = $this->utility->get_max_no('t_direct_transfer_sum','nno'); 
  $check_is_delete=$this->validation->check_is_cancel($this->max_no,'t_direct_transfer_sum');
  if($check_is_delete!=1){
    return "Transfer no already deleted";
  }
  $check_validation_employee=$this->validation->check_is_employer($_POST['officer']);
  if($check_validation_employee!=1){
    return "Please select valid officer";
  }
  $chk_item_store_validation=$this->validation->check_item_with_store($_POST['frm_stores'],'0_');
  if($chk_item_store_validation!=1){ 
    return $chk_item_store_validation;
  }
  $serial_validation_status=$this->validation->serial_update('0_','3_','all_serial_');
  if($serial_validation_status!=1){
    return $serial_validation_status;
  }
  $check_batch_validation=$this->utility->batch_update2('0_','2_','3_',$_POST['frm_stores']);
  if($check_batch_validation!=1){
    return $check_batch_validation;
  } 
  $chk_zero_qty=$this->validation->empty_qty('0_','3_');
  if($chk_zero_qty!=1){
    return $chk_zero_qty;
  }  
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
      for($x = 0; $x<25; $x++){
        if(isset($_POST['0_'.$x],$_POST['2_'.$x],$_POST['3_'.$x])){
          if($_POST['0_'.$x] != "" && $_POST['2_'.$x] != "" && $_POST['3_'.$x] != "" ){
            $b[]= array(
              "cl"      =>$this->sd['cl'],
              "bc"      =>$this->sd['branch'],
              "nno"     =>$this->max_no,
              "code"    =>$_POST['0_'.$x],
              "qty"     =>$_POST['3_'.$x],
              "batch_no"=>$_POST['2_'.$x],
              "cost"    =>$_POST['cost_' . $x],
              "min"     =>$_POST['min_'.$x],
              "max"     =>$_POST['max_'.$x],
              "amount"  =>$_POST['amount_'.$x]
              );              
          }
        }
      }                    

      $data=array(
        "cl"            =>$this->sd['cl'],
        "bc"            =>$this->sd['branch'],
        "nno"           =>$this->max_no,
        "ddate"         =>$_POST['date'],
        "ref_no"        =>$_POST['ref_no'],
        "from_cl"       =>$_POST['frm_cluster'],
        "from_bc"       =>$_POST['frm_branch'],
        "from_store"    =>$_POST['frm_stores'],
        "to_cl"         =>$_POST['to_cluster'],
        "to_bc"         =>$_POST['to_branch'],
        "to_store"      =>$_POST['to_stores'],
        "memo"          =>$_POST['memo'],
        "net_amount"    =>$_POST['net_amount'],
        "officer"       =>$_POST['officer'],
        "oc"            =>$this->sd['oc']
      );

      $sql="SELECT is_only_transfer FROM m_branch WHERE cl='".$this->sd['cl']."' 
            AND bc='".$this->sd['branch']."'";
      $this->is_transfer_only = $this->db->query($sql)->first_row()->is_only_transfer;

      if($_POST['hid'] == "0" || $_POST['hid'] == ""){
        if($this->user_permissions->is_add('t_direct_internal_transfer')){
          $account_update=$this->account_update(0);
          if($account_update==1){
            if($_POST['df_is_serial']=='1'){
              $this->serial_save();    
            }
            $this->account_update(1);
            $this->db->insert("t_direct_transfer_sum",$data);
            if(count($b)){$this->db->insert_batch("t_direct_transfer_det",$b);}

            $this->load->model('trans_settlement');
            for($x = 0; $x<25; $x++){
              if(isset($_POST['0_'.$x])){
                if($_POST['0_'.$x] != "" && $_POST['2_'.$x] != "" && $_POST['3_'.$x] > 0){
                  $this->trans_settlement->save_item_movement('t_item_movement',
                    $_POST['0_'.$x],
                    '120',
                    $this->max_no,
                    $_POST['date'],
                    0,
                    $_POST['3_'.$x],
                    $_POST['frm_stores'],
                    $_POST['cost_' . $x],
                    $_POST['2_'.$x],
                    $_POST['cost_' . $x],
                    $_POST['min_' . $x],
                    $_POST['cost_' . $x],
                    '001');


                  if($this->is_transfer_only!="1"){  
                    $this->trans_settlement->save_item_movement('t_item_movement',
                      $_POST['0_'.$x],
                      '120',
                      $this->max_no,
                      $_POST['date'],
                      $_POST['3_'.$x],
                      0,
                      $_POST['to_stores'],
                      $_POST['cost_' . $x],
                      $_POST['2_'.$x],
                      $_POST['cost_' . $x],
                      $_POST['min_' . $x],
                      $_POST['cost_' . $x],
                      '001');
                  }
                }
              }     
            }
            $this->utility->save_logger("SAVE",120,$this->max_no,$this->mod);
            echo $this->db->trans_commit()."@".$this->max_no;
          }else{
            echo "No permission to save records";
            $this->db->trans_commit(); 
          } 
        }else{
          echo $account_update;
          $this->db->trans_commit(); 
        }   
      }else{
        if($this->user_permissions->is_edit('t_direct_internal_transfer')){
          echo "No Edit facility in this transaction";
          $this->db->trans_commit();
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


public function serial_save(){

  for ($x = 0; $x < 25; $x++){
    if (isset($_POST['0_' . $x])) {
      if ($_POST['0_' . $x] != "" || !empty($_POST['0_' . $x])) {
        if ($this->check_is_serial_items($_POST['0_'.$x]) == 1) {
          $serial = $_POST['all_serial_'.$x];
          $p=explode(",",$serial);
          for($i=0; $i<count($p); $i++){

            if ($_POST['hid'] == "0" || $_POST['hid'] == "") {

              $t_serial=array(
                "store_code"=>$_POST['to_stores'],
                "out_date"=>$_POST['date'],
                "cl"    =>$this->sd['cl'],
                "bc"    =>$this->sd['branch']
                );

              $this->db->where("cl", $this->sd['cl']);
              $this->db->where("bc", $this->sd['branch']);
              $this->db->where('serial_no',$p[$i]);
              $this->db->where("item", $_POST['0_'.$x]);
              $this->db->where("store_code", $_POST['frm_stores']);
              $this->db->update("t_serial", $t_serial);

              $t_serial_movement_out=array(
                "cl"=>$this->sd['cl'],
                "bc"=>$this->sd['branch'],
                "trans_type"=>120,
                "trans_no"=>$this->max_no,
                "item"=>$_POST['0_'.$x],
                "batch_no"=>$_POST['2_'.$x],
                "serial_no"=>$p[$i],
                "qty_in"=>0,
                "qty_out"=>1,
                "cost"=>$_POST['cost_'.$x],
                "store_code"=>$_POST['frm_stores'],
                "computer"=>$this->input->ip_address(),
                "oc"=>$this->sd['oc'],
                );

              $this->db->insert("t_serial_movement", $t_serial_movement_out);

              if($this->is_transfer_only!="1"){
                $t_serial_movement_in=array(
                  "cl"=>$this->sd['cl'],
                  "bc"=>$this->sd['branch'],
                  "trans_type"=>120,
                  "trans_no"=>$this->max_no,
                  "item"=>$_POST['0_'.$x],
                  "batch_no"=>$_POST['2_'.$x],
                  "serial_no"=>$p[$i],
                  "qty_in"=>1,
                  "qty_out"=>0,
                  "cost"=>$_POST['cost_'.$x],
                  "store_code"=>$_POST['to_stores'],
                  "computer"=>$this->input->ip_address(),
                  "oc"=>$this->sd['oc'],
                  );
                $this->db->insert("t_serial_movement", $t_serial_movement_in);
              }

              }//only if save 
            } //end execute
          }//check is serial item
        }
      }
    }
  }

  public function check_code(){
    $this->db->where('code', $_POST['code']);
    $this->db->limit(1);
    echo $this->db->get($this->mtb)->num_rows;
  }

  public function load(){
      $cl=0;
      $bc=0;
      $sql="SELECT nno,
                  ddate,
                  ref_no,
                  s.from_store,
                  st.`description` AS from_store_des,
                  to_cl,
                  cl.`description` AS t_cl_des,
                  to_bc,
                  bc.`name` AS t_bc_des,
                  s.`to_store`,
                  stt.`description` AS t_store_des,
                  s.officer,
                  e.`name` AS e_des,
                  s.`net_amount`,
                  s.`is_cancel`,
                  s.memo
          FROM `t_direct_transfer_sum` s
          JOIN m_stores st ON st.`code` = s.`from_store`
          JOIN m_cluster cl ON cl.`code` = s.`to_cl`
          JOIN m_branch bc ON bc.`bc`=s.`to_bc`
          JOIN m_stores stt ON stt.`code` = s.`to_store`
          JOIN m_employee e ON e.`code` = s.`officer`
          WHERE s.cl='".$this->sd['cl']."' AND s.bc='".$this->sd['branch']."' AND s.nno='".$_POST['id']."'";
     
    $query=$this->db->query($sql);
    $x=0;
    if($query->num_rows()>0){
      $a['sum']=$query->result();
    }else{
      $x=2;
    }
    

    $sql="SELECT  d.code,
                  i.`description` AS item_name,
                  i.model,
                  batch_no,
                  cost,
                  min,
                  d.qty,
                  max,
                  amount
          FROM `t_direct_transfer_det` d
          JOIN m_item i ON i.`code` = d.`code`
          WHERE d.cl='".$this->sd['cl']."' AND d.bc='".$this->sd['branch']."' AND d.`nno`='".$_POST['id']."'";

    $query=$this->db->query($sql);
    if($query->num_rows()>0){
      $a['det']=$query->result();
    }else{
      $x=2;
    }

  $query=$this->db->query("SELECT DISTINCT `t_serial_movement`.`item`, `t_serial_movement`.`batch_no`, 
            `t_serial_movement`.`serial_no` 
            FROM (`t_serial_movement`) 
    WHERE `t_serial_movement`.`trans_type` = 120 
    AND `t_serial_movement`.`trans_no` = '$_POST[id]' 
    AND `t_serial_movement`.`cl` = '".$this->sd['cl']."' 
    AND `t_serial_movement`.`bc` = '".$this->sd['branch']."'
    GROUP BY  `t_serial_movement`.`serial_no`");

  $a['serial']=$query->result();

  if($x==0){
    echo json_encode($a);
  }else{
    echo json_encode($x);
  }       
}


public function item_list_all(){
  $cl=$_POST['cl'];
  $bc=$_POST['bc'];

  if($_POST['search'] == 'Key Word: code, name') {
    $_POST['search'] = "";
  }
  $sql = "SELECT  DISTINCT(m_item.code), 
                m_item.`description`,
                m_item.`model`,
                t_item_batch.`max_price`, 
                t_item_batch.`min_price`,
                t_item_batch.`batch_no`,
                t_item_batch.purchase_price,
                qry_current_stock.qty
          FROM m_item 
          JOIN qry_current_stock ON m_item.`code`=qry_current_stock.`item`
          JOIN t_item_batch ON t_item_batch.`item` = m_item.`code` AND t_item_batch.`batch_no`= qry_current_stock.`batch_no`
          WHERE qry_current_stock.`store_code`='$_POST[stores]' 
          AND qry_current_stock.qty > 0 
          AND qry_current_stock.cl='$cl' 
          AND qry_current_stock.bc='$bc' 
          AND (m_item.`description` LIKE '%$_POST[search]%' 
          OR m_item.`code` LIKE '%$_POST[search]%' 
          OR m_item.model LIKE '$_POST[search]%' 
          OR t_item_batch.`max_price` LIKE '$_POST[search]%'
          OR `t_item_batch`.`min_price` LIKE '$_POST[search]%' 
          OR `t_item_batch`.`max_price` LIKE '$_POST[search]%') 
          AND `m_item`.`inactive`='0'
          GROUP BY  m_item.code
          LIMIT 25";  

  $query =$this->db->query($sql);

  $a = "<table id='item_list' style='width : 100%' >";
  $a .= "<thead><tr>";
  $a .= "<th class='tb_head_th'>Item Code</th>";
  $a .= "<th class='tb_head_th'>Name</th>"; 
  $a .= "<th class='tb_head_th'>Model</th>"; 
  $a .= "<th class='tb_head_th'>Batch No</th>"; 
  $a .= "<th class='tb_head_th'>Cost</th>"; 
  $a .= "<th class='tb_head_th'>Min</th>"; 
  $a .= "<th class='tb_head_th'>Max</th>"; 
  $a .= "<th class='tb_head_th'>Quantity</th>";

  $a .= "</thead></tr>
  <tr class='cl'>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  ";            
  foreach($query->result() as $r){
    $a .= "<tr class='cl'>";
    $a .= "<td>".$r->code."</td>";
    $a .= "<td>".$r->description."</td>"; 
    $a .= "<td>".$r->model."</td>"; 
    $a .= "<td style='text-align:right;'>".$r->batch_no."</td>";
    $a .= "<td style='text-align:right;'>".$r->purchase_price."</td>";
    $a .= "<td style='text-align:right;'>".$r->min_price."</td>";
    $a .= "<td style='text-align:right;'>".$r->max_price."</td>";
    $a .= "<td style='text-align:right;'>".$r->qty."</td>";
    $a .= "</tr>";
  }
  $a .= "</table>";
  echo $a;
}

public function get_max_no(){
  $this->db->select_max('nno', 'max_nno');
  $this->db->where('cl',$this->sd['cl']);
  $this->db->where('bc',$this->sd['branch']);
  $query =$this->db->get($this->t_dispatch_sum);

  foreach($query->result() as $value) {
    $max_nno=$value->max_nno;
  }
  echo (float)$max_nno+1;                
}

public function get_officer(){
  $this->db->select('name');
  $query =$this->db->get($this->m_employee);
  $s = "<select name='officer' id='officer'>";
  $s .= "<option value='0'>---</option>";
  foreach($query->result() as $r){
    $s .= "<option title='".$r->code."' value='".$r->code."'>".$r->name."</option>";
  }
  $s .= "</select>";
  echo  $s;
}

public function check_qty(){
  $this->db->select(array('qty','purchase_price'));
  $this->db->from($this->qry_current_stock );
  $this->db->join($this->m_item, $this->m_item.'.code='.$this->qry_current_stock.'.item');
  $this->db->where('item',$_POST['item']);
  $this->db->where('cl',$this->sd['cl']);
  $this->db->where('bc',$this->sd['branch']);      
  $this->db->limit(1);
  $query = $this->db->get();

  if($query->num_rows() > 0){
   $data['a']=$query->result() ;
 }
 echo json_encode($data);
}

public function get_display(){

  $this->db->select(
    array(
      'qry_current_stock.cl',
      'qry_current_stock.bc',
      'qry_current_stock.item',
      'qry_current_stock.batch_no',
      'qry_current_stock.description',
      't_dispatch_det.qty as dqty',
      't_dispatch_sum.officer',
      't_dispatch_sum.ref_no',
      't_dispatch_sum.store_to',
      't_dispatch_sum.store_from',
      't_dispatch_sum.memo',
      't_dispatch_sum.action_date'
      ));

  $this->db->from('qry_current_stock');
  $this->db->join('t_dispatch_det','t_dispatch_det.code=qry_current_stock.item');
  $this->db->join('t_dispatch_sum','t_dispatch_det.nno=t_dispatch_sum.nno');
      //$this->db->where('t_dispatch_det.type',$_POST['type']);
  $this->db->where('t_dispatch_det.nno',$_POST['id']);
  $this->db->where('qry_current_stock.cl',$this->sd['cl'] );
  $this->db->where('qry_current_stock.bc',$this->sd['branch'] );

  $query1=$this->db->get();

  if($query1->num_rows()>0){
    $a['det']=$query1->result();
    echo json_encode($a);
  }
  else{
    echo json_encode("2");
  }
}


public function account_update($condition) {

      $this->db->where("trans_no", $this->max_no);
      $this->db->where("trans_code", 120);
      $this->db->where("cl", $this->sd['cl']);
      $this->db->where("bc", $this->sd['branch']);
      $this->db->delete("t_check_double_entry");

      if($_POST['hid']=="0"||$_POST['hid']==""){
      }else{
        if($condition=="1"){
          $this->db->where('cl',$this->sd['cl']);
          $this->db->where('bc',$this->sd['branch']);
          $this->db->where('trans_code',120);
          $this->db->where('trans_no',$this->max_no);
          $this->db->delete('t_account_trans');
        }
      }

      $config = array(
        "ddate" => $_POST['date'],
        "trans_code" => 120,
        "trans_no" => $this->max_no,
        "op_acc" => 0,
        "reconcile" => 0,
        "cheque_no" => 0,
        "narration" => "",
        "ref_no" => $_POST['ref_no']
        );

      $des = "Internal Sale - " . $this->max_no;
      $this->load->model('account');
      $this->account->set_data($config);

      $internal_cost_acc     = $this->utility->get_default_acc('COST_OF_SALES');
      $stock_acc             = $this->utility->get_default_acc('STOCK_ACC');
      $good_in_transit_acc   = $this->utility->get_default_acc('GOOD_TRANSIT');
      $revenue_int_sales_acc = $this->utility->get_default_acc('REV_INTERNAL_SALE');

      $item_cost=$item_min=0;
      for($x=0;$x<25;$x++){
        if(isset($_POST['0_' . $x])){
          $item_cost+=($_POST['3_'.$x])*(double)$_POST['cost_'.$x];
          $item_min+=($_POST['3_'.$x])*(double)$_POST['min_'.$x];
        }
      }    
      if($this->is_transfer_only=="1"){
        $this->account->set_value2($des, $item_cost, "dr", $internal_cost_acc,$condition);
        $this->account->set_value2($des, $item_cost, "cr", $stock_acc,$condition);
      }else{
        $this->account->set_value2($des, $item_cost, "dr", $internal_cost_acc,$condition);
        $this->account->set_value2($des, $item_cost, "cr", $stock_acc,$condition);
        $this->account->set_value2($des, $item_min, "dr", $good_in_transit_acc,$condition);
        $this->account->set_value2($des, $item_min, "cr", $revenue_int_sales_acc,$condition);
      }
      
      

      if($condition==0){
       $query = $this->db->query("
         SELECT (IFNULL( SUM( t.`dr_amount`),0) = IFNULL(SUM(t.`cr_amount`),0)) AS ok 
         FROM `t_check_double_entry` t
         LEFT JOIN `m_account` a ON t.`acc_code` = a.`code`
         WHERE  t.`cl`='" . $this->sd['cl'] . "'  AND t.`bc`='" . $this->sd['branch'] . "'  AND t.`trans_code`='120'  AND t.`trans_no` ='" . $this->max_no . "' AND 
         a.`is_control_acc`='0'");

       if ($query->row()->ok == "0") {
        $this->db->where("trans_no", $this->max_no);
        $this->db->where("trans_code", 120);
        $this->db->where("cl", $this->sd['cl']);
        $this->db->where("bc", $this->sd['branch']);
        $this->db->delete("t_check_double_entry");
        return "0";
      } else {
        return "1";
      }
    }
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

  $r_detail['dt']=$_POST['dt'];
  $r_detail['qno']=$_POST['qno'];

  $r_detail['page']=$_POST['page'];
  $r_detail['header']=$_POST['header'];
  $r_detail['orientation']=$_POST['orientation'];
  $r_detail['pdf_page_type']=$_POST['type1'];




  $sql="SELECT nno,
                  ddate,
                  ref_no,
                  s.from_store,
                  st.`description` AS from_store_des,
                  to_cl,
                  cl.`description` AS t_cl_des,
                  to_bc,
                  bc.`name` AS t_bc_des,
                  s.`to_store`,
                  stt.`description` AS t_store_des,
                  s.officer,
                  e.`name` AS e_des,
                  s.`net_amount`,
                  s.`is_cancel`,
                  s.memo,
                  s.from_bc,
                  bcc.name AS f_b_name
          FROM `t_direct_transfer_sum` s
          JOIN m_stores st ON st.`code` = s.`from_store`
          JOIN m_cluster cl ON cl.`code` = s.`to_cl`
          JOIN m_branch bc ON bc.`bc`=s.`to_bc`
          JOIN m_branch bcc ON bcc.`bc`=s.`from_bc`
          JOIN m_stores stt ON stt.`code` = s.`to_store`
          JOIN m_employee e ON e.`code` = s.`officer`
          WHERE s.cl='".$this->sd['cl']."' AND s.bc='".$this->sd['branch']."' AND s.nno='".$_POST['qno']."'";
     
    $query=$this->db->query($sql);
    $r_detail['sum']=$query->result();
       

    $sql="SELECT  d.code,
                  i.`description` AS item_name,
                  i.model,
                  batch_no,
                  cost,
                  min,
                  d.qty,
                  max,
                  amount
          FROM `t_direct_transfer_det` d
          JOIN m_item i ON i.`code` = d.`code`
          WHERE d.cl='".$this->sd['cl']."' AND d.bc='".$this->sd['branch']."' AND d.`nno`='".$_POST['qno']."'";

    $query=$this->db->query($sql);
    $r_detail['det']=$query->result();

    $query=$this->db->query("SELECT DISTINCT `t_serial_movement`.`item`, 
            `t_serial_movement`.`serial_no`,
            `t_serial_movement`.`batch_no`  
            FROM (`t_serial_movement`) 
    WHERE `t_serial_movement`.`trans_type` = 120 
    AND `t_serial_movement`.`trans_no` = '$_POST[qno]' 
    AND `t_serial_movement`.`cl` = '".$this->sd['cl']."' 
    AND `t_serial_movement`.`bc` = '".$this->sd['branch']."'
    GROUP BY  `t_serial_movement`.`serial_no`");

  $r_detail['serial']=$query->result();
    
  $this->load->view($_POST['by'].'_'.'pdf',$r_detail);
}

public function check_is_serial_item(){
  $this->db->select(array('serial_no'));
  $this->db->where("code",$this->input->post('code'));
  $this->db->limit(1);
  echo  $this->db->get("m_item")->first_row()->serial_no;
}

public function check_is_serial_items($code){
  $this->db->select(array('serial_no'));
  $this->db->where("code",$code);
  $this->db->limit(1);
  return $this->db->get("m_item")->first_row()->serial_no;
}


public function is_serial_entered($trans_no,$item,$serial){
  $this->db->select(array('available'));
  $this->db->where('cl',$this->sd['cl']);
  $this->db->where('bc',$this->sd['branch']);
  $this->db->where("serial_no",$serial);
  $this->db->where("item",$item);
  $query=$this->db->get("t_serial");

  if($query->num_rows()>0){
    return 1;
  }else{
    return 0;
  }
}




public function get_batch_serial_wise($item,$serial){
  $this->db->select("batch");
  $this->db->where('cl',$this->sd['cl']);
  $this->db->where('bc',$this->sd['branch']);
  $this->db->where("item",$item);
  $this->db->where("serial_no",$serial);
  return $this->db->get('t_serial')->first_row()->batch; 
}



public function batch_item() {
  $cl=$this->sd['cl'];
  $bc=$this->sd['branch'];

  $sql="SELECT b.batch_no,q.`qty`,b.purchase_price AS cost,b.min_price,b.max_price,r.description as col_des 
  FROM qry_current_stock q
  JOIN t_item_batch b ON b.`item`=q.`item` AND b.`batch_no`=q.`batch_no`
  JOIN r_color r ON r.code=b.color_code
  WHERE q.`cl`='$cl' AND q.`bc`='$bc' 
  AND q.`item`='$_POST[search]' AND q.`store_code`='$_POST[stores]'";


  $query = $this->db->query($sql);

  $a = "<table id='batch_item_list' style='width : 100%' >";

  $a .= "<thead><tr>";
  $a .= "<th class='tb_head_th'>Batch No</th>";
  $a .= "<th class='tb_head_th'>Available Quantity</th>";
  $a .= "<th class='tb_head_th'>Cost</th>";
  $a .= "<th class='tb_head_th'>Min Price</th>";
  $a .= "<th class='tb_head_th'>Max Price</th>";
  $a .= "<th class='tb_head_th'>Color</th>";

  $a .= "</thead></tr>";
  $a .= "<tr class='cl'>";
  $a .= "<td>&nbsp;</td>";
  $a .= "<td>&nbsp;</td>";
  $a .= "<td>&nbsp;</td>";
  $a .= "<td>&nbsp;</td>";
  $a .= "<td>&nbsp;</td>";
  $a .= "<td>&nbsp;</td>";
  $a .= "</tr>";

  foreach ($query->result() as $r) {
    $a .= "<tr class='cl'>";
    $a .= "<td>" . $r->batch_no . "</td>";
    $a .= "<td>" . $r->qty . "</td>";
    $a .= "<td>" . $r->cost . "</td>";
    $a .= "<td>" . $r->min_price . "</td>";
    $a .= "<td>" . $r->max_price . "</td>";
    $a .= "<td>" . $r->col_des . "</td>";
    $a .= "</tr>";
  }
  $a .= "</table>";
  echo $a;
}
public function is_batch_item() {
  $sql="SELECT b.batch_no,q.`qty`,b.purchase_price AS cost,b.min_price,b.max_price 
  FROM qry_current_stock q
  JOIN t_item_batch b ON b.`item`=q.`item` AND b.`batch_no`=q.`batch_no`
  WHERE q.`cl`='".$this->sd['cl']."' AND q.`bc`='".$this->sd['branch']."' 
  AND q.`item`='$_POST[code]' AND q.`store_code`='$_POST[store]'
  AND q.qty>0";
  $query=$this->db->query($sql);
  if ($query->num_rows() == 1) {
    foreach ($query->result() as $row) {
      echo $row->batch_no."-".$row->qty."-".$row->cost."-".$row->min_price."-".$row->max_price;
    }
  } else if ($query->num_rows() > 0) {
    echo "1";
  } else {
    echo "0";
  }
}



public function checkdelete()
{
  $id = $_POST['no'];

  $sql="SELECT *
  FROM `t_dispatch_sum` 
  WHERE (`t_dispatch_sum`.`nno` = '$id')
  LIMIT 25 ";   

  $query=$this->db->query($sql);

  if($query->num_rows()>0){
    $a['det']=$query->result();
    echo json_encode($a);
  }else{
    echo json_encode("2");
  }
}

public function delete_validation()
{
  $status=1;
  $no = $_POST['id'];

  $check_cancellation = $this->trans_cancellation->damage_update_status($no,13,'t_dispatch_sum','t_dispatch_det');
  if ($check_cancellation != 1){
    return $check_cancellation;
  }
  return $status;
}


public function delete(){
  $this->db->trans_begin();
  error_reporting(E_ALL); 
  function exceptionThrower($type, $errMsg, $errFile, $errLine) { 
    throw new Exception($errMsg); 
  }
  set_error_handler('exceptionThrower'); 
  try { 
    if($this->user_permissions->is_delete('t_direct_internal_transfer')){

      $delete_validation_status=$this->delete_validation();
      if($delete_validation_status==1){

        $no = $_POST['id'];
        $this->db->where('nno',$no);
        $this->db->where('cl',$this->sd['cl']);
        $this->db->where('bc',$this->sd['branch']);
        $this->db->update('t_dispatch_sum', array("is_cancel"=>1));

        $this->db->select(array('store_from'));
        $this->db->from('t_dispatch_sum');
        $this->db->where('nno',$no);
        $this->db->where('cl',$this->sd['cl']);
        $this->db->where('bc',$this->sd['branch']);
        $query_store = $this->db->get();

        $this->db->select(array('item','batch_no','serial_no'));
        $this->db->from('t_serial_movement');
        $this->db->where('trans_type',13);
        $this->db->where('trans_no',$no);
        $this->db->where('cl',$this->sd['cl']);
        $this->db->where('bc',$this->sd['branch']);
        $query1 = $this->db->get();

        foreach($query1->result() as $row)
        {
          $this->db->where('item',$row->item);
          $this->db->where('batch',$row->batch_no);
          $this->db->where('serial_no',$row->serial_no);
          $this->db->where('cl',$this->sd['cl']);
          $this->db->where('bc',$this->sd['branch']);
          $this->db->update('t_serial', array("store_code"=>$query_store->row()->store_from));
        }

        $this->load->model('trans_settlement');
        $this->trans_settlement->delete_item_movement('t_item_movement',13,$no);

        $this->db->where('trans_code',13);
        $this->db->where('trans_no',$no);
        $this->db->where('cl',$this->sd['cl']);
        $this->db->where('bc',$this->sd['branch']);
        $this->db->delete("t_item_movement_sub");

        $this->db->where('trans_type',13);
        $this->db->where('trans_no',$no);
        $this->db->where('cl',$this->sd['cl']);
        $this->db->where('bc',$this->sd['branch']);
        $this->db->delete("t_serial_movement");

        $this->utility->save_logger("CANCEL",13,$no,$this->mod);
        echo  $this->db->trans_commit();
      }
      else
      {
        echo $delete_validation_status;
        $this->db->trans_commit();
      }
    }else{
      echo "No permission to delete records";
      $this->db->trans_commit();
    }
  }catch(Exception $e){ 
    $this->db->trans_rollback();
    echo "Operation fail please contact admin"; 
  }
}



public function get_batch_qty(){
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
  }else{
    $sql="SELECT SUM(qry_current_stock.`qty`)+SUM(c.qty) as qty 
    FROM (`qry_current_stock`)  
    INNER JOIN (SELECT qty,code,batch_no,cl,bc 
      FROM t_dispatch_det 
      WHERE  `batch_no` = '$batch_no'  
      AND  nno='$no' 
      AND `code` = '$item') c 
ON c.code=qry_current_stock.`item` AND c.cl=qry_current_stock.cl AND c.bc=qry_current_stock.bc AND c.batch_no=qry_current_stock.batch_no
WHERE qry_current_stock.`batch_no` = '$batch_no' 
AND qry_current_stock.`store_code` = '$store' 
AND `item` = '$item'
AND qry_current_stock.cl='".$this->sd['cl']."'
AND qry_current_stock.bc='".$this->sd['branch']."'";
$query = $this->db->query($sql);
}
if($query->num_rows() > 0) {
  echo $query->first_row()->qty;
}else{
  echo 0;
}
}




}