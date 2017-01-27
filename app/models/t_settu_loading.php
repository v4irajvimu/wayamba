<?php
if (!defined('BASEPATH'))exit('No direct script access allowed');

class t_settu_loading extends CI_Model {

    private $sd;
    private $mtb;
    private $max_no;
    private $mod = '003';

    function __construct() {
        parent::__construct();
        $this->sd = $this->session->all_userdata();
        $this->load->database($this->sd['db'], true);
        $this->load->model('user_permissions');
        $this->mtb = $this->tables->tb['t_settu_load_sum'];
        
    }

    public function base_details(){
        $a['max_no'] = $this->utility->get_max_no("t_settu_load_sum","nno");
        return $a;
    }

public function validation(){
     $status = 1;
      for($x=0; $x<25; $x++){
        /*var_dump($_POST['items_'.$x]);*/
          $req_validation = $this->is_can_load($_POST['itemdet_'.$x]);
          if ($req_validation != 1) {
              return $req_validation;
          }
      }
      return $status;
    }
public function load_route(){

      if($_POST['search'] == 'Key Word: code, name'){$_POST['search'] = "";}
        $sql = "SELECT 
                  c.root,
                  r.`description` AS route_name,
                  c.code AS organizer,
                  s.`settu_no`
                  FROM
                  t_settu_item_req_sum s 
                  JOIN m_customer c ON c.`code`=s.`orgernizer`
                  JOIN r_root r ON r.`code`=c.`root`
                  WHERE (root LIKE '%$_POST[search]%' 
                  OR description LIKE '%$_POST[search]%')GROUP BY root LIMIT 25";
  
      $query = $this->db->query($sql);
      $a  = "<table id='item_list' style='width : 100%' >";
      $a .= "<thead><tr>";
      $a .= "<th class='tb_head_th'>Code</th>";
      $a .= "<th class='tb_head_th' colspan='2'>Route</th>";
      $a .= "</thead></tr><tr class='cl'><td>&nbsp;</td><td colspan='2'>&nbsp;</td></tr>";

    foreach($query->result() as $r){
      $a .= "<tr class='cl'>";
      $a .= "<td>".$r->root."</td>";
      $a .= "<td>".$r->route_name."</td>";
      $a .= "<td style='display:none;'>".$r->settu_no."</td>";
      $a .= "</tr>";
    }
      $a .= "</table>";
      echo $a;
  }
public function item_chk(){

  $itm=$_POST['item'];
  $stor=$_POST['store'];
  $x=0;
   $sql="SELECT m.`code`,m.`description`,d.qty
            FROM m_settu_item_sum s 
            JOIN m_settu_item_det d ON d.`cl` = s.`cl` AND d.`bc` = s.`bc` AND d.`no` = s.`no` 
            JOIN m_item m ON m.`code` = d.`item_code` 
            WHERE s.code = '$itm' 
            GROUP BY m.code 
            UNION ALL 
            SELECT m.`code`,m.`description`,f.qty
            FROM m_settu_item_sum s 
            JOIN m_settu_item_det_free f ON f.`cl` = s.`cl` AND f.`bc` = s.`bc` AND f.`no` = s.`no` 
            JOIN m_item m ON m.`code` = f.`item_code` 
            WHERE s.code = '$itm' 
            group by m.`code` 
            LIMIT 25 ";

          $query = $this->db->query($sql);
          foreach($query->result() as $row){
            $settu_item=$row->code;
            $settu_qty = $row->qty;

            $sql_qty="SELECT item,batch_no,IFNULL(qty,0) AS qty FROM qry_current_stock WHERE item='$settu_item' AND cl='".$this->sd['cl']."' AND bc ='".$this->sd['branch']."' AND store_code='$stor'";
            $query_qty=$this->db->query($sql_qty);

            if($query_qty->num_rows()>0){
              $qtys=(int)0;
              foreach ($query_qty->result() as $det) {
                $qtys=(int) $det->qty;
                if ($settu_qty > $qtys){               
                   $x='2';
                }  
              }  
            }else{
              $x="2";
            }           
    } 
    if($x==0){
      echo json_encode($a);
      }else{
          echo json_encode($x);
      }
}

public function load_grid(){

          $x=0;
                $this->db->select(array(
                    'm_customer.code AS org',
                    'm_customer.name AS organizer',
                    't_settu_item_req_sum.settu_no',
                    't_settu_item_req_sum.nno AS req_no',
                    't_settu_item_req_sum.ddate AS req_date',
                    'm_settu_item_category.code',
                    'm_settu_item_category.ref_code',
                    't_settu_item_req_det.code AS item',
                    'm_settu_item_sum.name',
                    't_settu_det.status',
                    't_settu_item_req_sum.is_cancel'
    
                  ));

          $this->db->from('t_settu_item_req_sum');
          $this->db->join('m_customer','m_customer.code=t_settu_item_req_sum.orgernizer');
          $this->db->join('r_root','r_root.code=m_customer.root'); 
          $this->db->join('t_settu_item_req_det','t_settu_item_req_det.nno=t_settu_item_req_sum.nno');
          $this->db->join('m_settu_item_sum','m_settu_item_sum.code=t_settu_item_req_det.code');
          $this->db->join('m_settu_item_category','m_settu_item_category.ref_code=m_settu_item_sum.settu_item_category');
          $this->db->join('t_settu_det','t_settu_det.nno=t_settu_item_req_sum.settu_no');
          $this->db->where('t_settu_item_req_sum.cl',$this->sd['cl'] );
          $this->db->where('t_settu_item_req_sum.bc',$this->sd['branch'] ); 
          $this->db->where('t_settu_det.status',"1"); 
          $this->db->where('t_settu_item_req_sum.is_cancel',"0"); 
          $this->db->group_by('req_no');  

          $query=$this->db->get();
          if($query->num_rows()>0){
                $a['det']=$query->result();
                   }else{
                  $x=2;
                }
                if($x==0){
                    echo json_encode($a);
                }else{
                    echo json_encode($x);
                }
                     
        }



 public function save(){

  $this->max_no=$this->utility->get_max_no("t_settu_load_sum","nno");
   $this->db->trans_begin();
    error_reporting(E_ALL); 
    function exceptionThrower($type, $errMsg, $errFile, $errLine) { 
        throw new Exception($errMsg); 
    }
    set_error_handler('exceptionThrower'); 
    try {
          $validation_status = $this->validation();
          if($validation_status == 1) {

      $sum=array(
        "cl"                =>$this->sd['cl'],
        "bc"                =>$this->sd['branch'],
        "nno"               =>$this->max_no,
        "ddate"             =>$_POST['date'],
        "ref_no"            =>$_POST['ref_no'],
        "root"              =>$_POST['root_id'],
        "driver"            =>$_POST['driver_id'],
        "salesman"          =>$_POST['salesman_id'],
        "helper"            =>$_POST['helper_id'],
        "store_from"        =>$_POST['store_from_id'],
        "store_to"          =>$_POST['store_to_id'],
        "memo"              =>$_POST['memo'],
        "oc"                =>$this->sd['oc'],
      );


      for($x = 0; $x<25; $x++){
        if(isset($_POST['n_'.$x])){
          if($_POST['n_'.$x] != "" ){
             
            $det[]= array(
              "cl"          =>$this->sd['cl'],
              "bc"          =>$this->sd['branch'],
              "nno"         =>$this->max_no,
              "organizer"   =>$_POST['org_'.$x],
              "settu_no"    =>$_POST['1_'.$x],
              "req_no"      =>$_POST['2_'.$x],
              "req_date"    =>$_POST['3_'.$x],
              "category"    =>$_POST['refno_'.$x],
              "code"        =>$_POST['5_'.$x],
              "reason_id"   =>$_POST['reason_'.$x],
              
            ); 
          }
        }
      }
    $settu_det_update = array(
      "status"          => "2"    
    );


      if($_POST['hid'] == "0" || $_POST['hid'] == ""){

        if($this->user_permissions->is_add('t_settu_loading')){
          $this->db->insert("t_settu_load_sum", $sum);
          if(count($det)){
            $this->db->insert_batch("t_settu_load_det",$det);
          }
          for ($x=0; $x<25; $x++){
            if (isset($_POST['1_'.$x], $_POST['check_'. $x])) {
              if ($_POST['check_'.$x]!=""){
                $this->db->where("nno",$_POST['1_'.$x]);
                $this->db->where("cl", $this->sd['cl']);
                $this->db->where("bc", $this->sd['branch']);
                $this->db->where("item_code", $_POST['5_'.$x]);
                $this->db->update('t_settu_det', $settu_det_update);
              }
            }
          }
        for ($x=0; $x<25; $x++){
          if (isset($_POST['2_'.$x], $_POST['check_'. $x])) {
            if ($_POST['check_'.$x]!=""){
              $this->db->where("req_no",$_POST['2_'.$x]);
              $this->db->where("cl", $this->sd['cl']);
              $this->db->where("bc", $this->sd['branch']);
              $this->db->where("code", $_POST['5_'.$x]);
              $this->db->update('t_settu_load_det', array("status"=>1));
            }
          }
        }
                   
        for ($x = 0; $x < 25; $x++) {
          if (isset($_POST['n_' . $x])) {
            if ($_POST['n_' . $x] != "") {
              $item_det2=$_POST['itemdet_'. $x];
              $item_ex2=explode(",",$item_det2);
              $arr_length2= (int)sizeof($item_ex2)-1;
              for($y = 0; $y<$arr_length2; $y++){

                $item_ex3= (explode("-",$item_ex2[$y]));
                $batch=$item_ex3[0];
                $item_a=$item_ex3[1];
                $item_qty=$item_ex3[2];

                $this->trans_settlement->save_item_movement('t_item_movement',
                $item_a,
                '77',
                $this->max_no,
                $_POST['date'],
                0,
                $item_qty,
                $_POST['store_from_id'],
                $this->utility->get_cost_price($_POST['0_' . $x]),
                $batch,
                $this->utility->get_cost_price($_POST['0_' . $x]),
                $this->utility->get_min_price($_POST['0_' . $x]),
                $this->utility->get_cost_price($_POST['0_' . $x]),
                '001');

                $this->trans_settlement->save_item_movement('t_item_movement',
                $item_a,
                '77',
                $this->max_no,
                $_POST['date'],
                $item_qty,
                0,
                $_POST['store_to_id'],
                $this->utility->get_cost_price($_POST['0_' . $x]),
                $batch,
                $this->utility->get_cost_price($_POST['0_' . $x]),
                $this->utility->get_min_price($_POST['0_' . $x]),
                $this->utility->get_cost_price($_POST['0_' . $x]),
                '001');
              }
            }
          }
        }
  
          //$this->account_update(1);
          $this->utility->save_logger("SAVE",77,$this->max_no,$this->mod);
          echo $this->db->trans_commit();
        }else{
          $this->db->trans_commit();
          echo "No permission to save records";
        }
      }else{
        if($this->user_permissions->is_edit('t_settu_loading')){
          $this->db->where('nno',$_POST['hid']);
          $this->db->where('cl',$this->sd['cl']);
          $this->db->where('bc',$this->sd['branch']);
          $this->db->update($this->mtb, $sum);
         
          $this->db->where("nno",$this->max_no);
          $this->db->where("cl", $this->sd['cl']);
          $this->db->where("bc", $this->sd['branch']);
          $this->db->delete('t_settu_load_det');

          $this->load->model('trans_settlement');
          $this->trans_settlement->delete_item_movement('t_item_movement',77,$this->max_no);

          if(count($det)){
            $this->db->insert_batch("t_settu_load_det",$det);
          }
          for ($x=0; $x<25; $x++){
                  $this->db->where("nno",$this->max_no);
                  $this->db->where("cl", $this->sd['cl']);
                  $this->db->where("bc", $this->sd['branch']);
                  $this->db->where("item_code", $_POST['5_'.$x]);
                  $this->db->update('t_settu_det', array("status"=>1));
                  if (isset($_POST['1_'.$x], $_POST['check_'. $x])) {
                    if ($_POST['check_'.$x]!=""){
                      $this->db->where("nno",$this->max_no);
                      $this->db->where("cl", $this->sd['cl']);
                      $this->db->where("bc", $this->sd['branch']);
                      $this->db->where("item_code", $_POST['5_'.$x]);
                      $this->db->update('t_settu_det', $settu_det_update);
                    }
                  }
                }
          for ($x=0; $x<25; $x++){

          if (isset($_POST['1_'.$x], $_POST['check_'. $x])) {

              $this->db->where("nno",$this->max_no);
              $this->db->where("cl", $this->sd['cl']);
              $this->db->where("bc", $this->sd['branch']);
              $this->db->where("code", $_POST['5_'.$x]);
              $this->db->update('t_settu_load_det', array("status"=>1));
            
          }
        }

        
        for ($x = 0; $x < 25; $x++) {
          if (isset($_POST['n_' . $x])) {
            if ($_POST['n_' . $x] != "") {
              $item_det2=$_POST['itemdet_'. $x];
              $item_ex2=explode(",",$item_det2);
              $arr_length2= (int)sizeof($item_ex2)-1;
              for($y = 0; $y<$arr_length2; $y++){

                $item_ex3= (explode("-",$item_ex2[$y]));
                $batch=$item_ex3[0];
                $item_a=$item_ex3[1];
                $item_qty=$item_ex3[2];

                $this->trans_settlement->save_item_movement('t_item_movement',
                $item_a,
                '77',
                $this->max_no,
                $_POST['date'],
                0,
                $item_qty,
                $_POST['store_from_id'],
                $this->utility->get_cost_price($_POST['0_' . $x]),
                $batch,
                $this->utility->get_cost_price($_POST['0_' . $x]),
                $this->utility->get_min_price($_POST['0_' . $x]),
                $this->utility->get_cost_price($_POST['0_' . $x]),
                '001');

                $this->trans_settlement->save_item_movement('t_item_movement',
                $item_a,
                '77',
                $this->max_no,
                $_POST['date'],
                $item_qty,
                0,
                $_POST['store_to_id'],
                $this->utility->get_cost_price($_POST['0_' . $x]),
                $batch,
                $this->utility->get_cost_price($_POST['0_' . $x]),
                $this->utility->get_min_price($_POST['0_' . $x]),
                $this->utility->get_cost_price($_POST['0_' . $x]),
                '001');
              }
            }
          }
        }
          //$this->account_update(1);
          $this->utility->save_logger("EDIT",77,$this->max_no,$this->mod);
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


   public function load(){

    $x=1;

    $sql_sum="SELECT 
                    nno,
                    ddate,
                    ref_no,
                    s.root,
                    r.description AS root_name,
                    store_from,
                    m.description AS store_from_name,
                    store_to,
                    n.description AS store_to_name,
                    s.driver,
                    e.name AS dri_name,
                    s.salesman,
                    c.name AS salesman_name,
                    s.helper,
                    b.name AS helper_name,
                    memo,
                    s.is_cancel
                    FROM
                    t_settu_load_sum s 
                    JOIN r_root r ON r.code = s.root 
                    JOIN m_stores m ON m.code = s.store_from 
                    JOIN m_stores n ON n.code = s.store_to 
                    JOIN m_employee e ON e.code = s.driver 
                    JOIN m_employee c ON c.code = s.salesman 
                    JOIN m_employee b ON b.code = s.helper 
                    WHERE s.`cl` ='".$this->sd['cl']."'
                    AND s.`bc`='".$this->sd['branch']."'
                    AND s.`nno`='".$_POST['no']."'";

    $query_sum = $this->db->query($sql_sum); 

    if($query_sum->num_rows()>0){ 

      $a['sum']=$query_sum->result();         
    }else{
      $x=2;      
    }
    $sql_det="SELECT
                d.organizer,
                c.`name`,
                d.settu_no,
                d.req_no,
                d.req_date,
                d.code AS item,
                d.category AS ref_code,
                i.`code`,
                s.`name` AS des,
                sr.code as ret_id,
                sr.`description` AS reason,
                d.`status`
                FROM
                t_settu_load_det d
                JOIN m_customer c ON c.code=d.`organizer`
                JOIN `m_settu_item_category` i ON i.`ref_code`=d.`category`
                JOIN `m_settu_item_sum` s ON s.`settu_item_category`=i.`ref_code`
                left JOIN r_settu_reason sr ON sr.`code`=d.`reason_id`
                WHERE d.cl='".$this->sd['cl']."' 
                AND d.bc='".$this->sd['branch']."'
                AND d.nno='".$_POST['no']."'
                GROUP BY req_no";

    $sql_det = $this->db->query($sql_det); 

    if($sql_det->num_rows()>0){ 
      $a['det']=$sql_det->result();         
    }else{
      $x=2;    
    }
    if($x==1){
      echo json_encode($a);
    }else{
      echo json_encode("2");
    }       
  }

   public function is_can_load($item_det){

      $status=1;
      $store_fr=$_POST['store_from_id'];
      $item_ex=explode(",",$item_det);
      $arr_length= (int)sizeof($item_ex)-1;
     
      for($y = 0; $y<$arr_length; $y++){

        $item_ex2 = (explode("-",$item_ex[$y]));

        $batch=$item_ex2[0];
        $item_a=$item_ex2[1];
        $item_qty=$item_ex2[2];
        $st_qty=$item_ex2[3];


        $sql_qty="SELECT item,batch_no,IFNULL(qty,0) AS qty FROM qry_current_stock WHERE item='$item_a' AND batch_no='$batch' AND qty='$st_qty' AND store_code='$store_fr' AND cl='".$this->sd['cl']."' AND bc ='".$this->sd['branch']."'";
        $query_qty=$this->db->query($sql_qty);
        if($query_qty->num_rows()>0){
          $qtys=(int)0;
          foreach ($query_qty->result() as $det) {
              $qtys=(int) $det->qty;
          }  
        if ($item_qty > $qtys){
          //var_dump($total_qty."<".$qtys);                 
           $status='Low Quantity';
        }  
      }else{
        $status="Low Quantity";
      }
    }
 return $status; 
}



   public function delete() {
        $this->db->trans_begin();
        error_reporting(E_ALL);
        function exceptionThrower($type, $errMsg, $errFile, $errLine) {
            throw new Exception($errMsg);
        }
        set_error_handler('exceptionThrower');
        try {
            if($this->user_permissions->is_delete('t_settu_loading')){

              $sql="SELECT * FROM `t_settu_load_det` 
                    WHERE cl='".$this->sd['cl']."' 
                    AND bc='".$this->sd['branch']."' 
                    AND nno='".$_POST['nno']."'";
              $query=$this->db->query($sql);

              foreach($query->result() as $row){
                $this->db->where("nno",$_POST['nno']);
                $this->db->where("cl", $this->sd['cl']);
                $this->db->where("bc", $this->sd['branch']);
                $this->db->where("item_code", $row->code);
                $this->db->update('t_settu_det', array("status"=>0));
              }

              $this->db->where("nno",$_POST['nno']);
              $this->db->where("cl", $this->sd['cl']);
              $this->db->where("bc", $this->sd['branch']);
              $this->db->update('t_settu_load_sum',array("is_cancel" => 1));

              $this->load->model('trans_settlement');
              $this->trans_settlement->delete_item_movement('t_item_movement',77,$_POST['nno']);

              $this->utility->save_logger("DELETE",77,$_POST['nno'],$this->mod);
              echo $this->db->trans_commit();
            }else{
                $this->db->trans_commit();
                echo "No permission to delete records";
            }
        } catch (Exception $e) {
            $this->db->trans_rollback();
            echo $e->getMessage()." - Operation fail please contact admin";
        }
    }

    public function PDF_report(){
     
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

      $r_detail['qno']=$_POST['qno'];
      $r_detail['page']=$_POST['page'];
      $r_detail['header']=$_POST['header'];
      $r_detail['orientation']=$_POST['orientation'];

      $sql="SELECT 
                  ls.nno,
                  ls.ddate,
                  ls.ref_no,
                  ls.store_from,
                  ms.description as f_store,
                  ls.store_to,
                  mss.description AS t_store,
                  ls.root,
                  r.description as root_name,
                  ls.driver,
                  me.name as driv_name,
                  ls.salesman,
                  me.name as sal_name,
                  ls.helper,
                  me.name as hel_name
                from
                  t_settu_load_sum ls
                  join m_stores ms on ms.code=ls.store_from
                  JOIN m_stores mss ON mss.code=ls.store_to
                  join r_root r on r.code=ls.root
                  join m_employee me on me.code=ls.driver
                  JOIN m_employee mem ON mem.code=ls.salesman
                  JOIN m_employee memp ON memp.code=ls.helper
            WHERE ls.cl='".$this->sd['cl']."' AND ls.bc='".$this->sd['branch']."' 
            AND ls.nno='".$_POST['qno']."'";
      $query=$this->db->query($sql);      
      if ($query->num_rows() > 0) {
          $r_detail['sum'] = $query->result();
      } 

      $sql="SELECT 
                d.organizer,
                c.`name`,
                d.settu_no,
                d.req_no,
                d.req_date,
                d.code AS item,
                d.category AS ref_code,
                i.`code`,
                s.`name` AS des,
                sr.code as ret_id,
                sr.`description` AS reason,
                d.`status` 
                FROM
                t_settu_load_det d 
                JOIN m_customer c ON c.code = d.`organizer` 
                JOIN `m_settu_item_category` i ON i.`ref_code` = d.`category` 
                JOIN `m_settu_item_sum` s ON s.`settu_item_category` = i.`ref_code` 
                left JOIN r_settu_reason sr ON sr.`code` = d.`reason_id` 
            WHERE d.cl='".$this->sd['cl']."' AND d.bc='".$this->sd['branch']."'
            AND d.nno='".$_POST['qno']."'
            GROUP BY req_no";

      $query=$this->db->query($sql);          
      if ($query->num_rows() > 0) {
          $r_detail['det'] = $query->result();
      }
      $this->load->view($_POST['by'].'_'.'pdf',$r_detail);
    }

public function f1_load_driver(){

      if($_POST['search'] == 'Key Word: code, name'){$_POST['search'] = "";}  

      $sql="SELECT driver,e.`name` AS dri_name FROM m_vehicle_setup v JOIN m_employee e ON e.`code`=v.`driver`
              WHERE (driver LIKE '%".$_POST['search']."%' OR name LIKE '%".$_POST['search']."%') 
                AND v.cl = '".$this->sd['cl']."' 
                AND v.bc = '".$this->sd['branch']."'
              LIMIT 25";

        $query = $this->db->query($sql);
        
        $a  = "<table id='item_list' style='width : 100%' >";
        $a .= "<thead><tr>";
        $a .= "<th class='tb_head_th'>Code</th>";
        $a .= "<th class='tb_head_th'>Name</th>";
        $a .= "</thead></tr><tr class='cl'><td>&nbsp;</td><td>&nbsp;</td></tr>";
        
        foreach($query->result() as $r){
          
          $a .= "<tr class='cl'><td>".$r->driver."</td>";
          $a .= "<td>".$r->dri_name."</td>";
          $a .= "</tr>";
        }

          $a .= "</table>";
          echo $a;
  }

public function f1_batch_item(){

        $items=$_POST['items'];
        $store=$_POST['stores']; 

  if($_POST['search'] == 'Key Word: code, name'){$_POST['search'] = "";}  

      $sql="SELECT
                  m.`code`,
                  m.`description`,
                  d.qty,
                  IFNULL(qq.qty, 0) AS stock_qty,
                  qq.batch_no 
                  FROM
                  m_settu_item_sum s 
                  JOIN m_settu_item_det d ON d.`cl` = s.`cl` AND d.`bc` = s.`bc` AND d.`no` = s.`no` 
                  JOIN m_item m ON m.`code` = d.`item_code` 
                  LEFT JOIN qry_current_stock q ON m.`code` = q.`item` AND q.cl = d.cl AND q.bc = d.bc 
                  LEFT JOIN 
                  (SELECT * FROM
                  qry_current_stock 
                  WHERE store_code = '$store' AND cl = 'C1' AND bc = 'B01') qq ON qq.item = m.`code` AND d.`cl` = qq.cl AND d.bc = qq.bc 
                  WHERE s.code = '$items' 
                  GROUP BY qq.batch_no,m.code 
                  UNION
                  ALL 
                  SELECT 
                  m.`code`,
                  m.`description`,
                  f.qty,
                  IFNULL(qq.qty, 0) AS stock_qty,
                  qq.batch_no 
                  FROM
                  m_settu_item_sum s 
                  JOIN m_settu_item_det_free f ON f.`cl` = s.`cl` AND f.`bc` = s.`bc` AND f.`no` = s.`no` 
                  JOIN m_item m ON m.`code` = f.`item_code` 
                  LEFT JOIN qry_current_stock q ON m.`code` = q.`item` AND q.cl = f.cl AND q.bc = f.bc 
                  LEFT JOIN 
                  (SELECT * FROM
                  qry_current_stock 
                  WHERE store_code = '$store' AND cl = 'C1' AND bc = 'B01') qq 
                  ON qq.item = m.`code` AND f.`cl` = qq.cl AND f.bc = qq.bc 
                  WHERE s.code = '$items' 
                  group by qq.batch_no,m.`code`LIMIT 25";

        $query = $this->db->query($sql);
        
        $a  = "<table id='item_list' style='width : 100%' >";
        $a .= "<thead><tr>";
        $a .= "<th class='tb_head_th' ></th>";
        $a .= "<th class='tb_head_th'>Batch No</th>";
        $a .= "<th class='tb_head_th'>Item Code</th>";
        $a .= "<th class='tb_head_th'>Description</th>";
        $a .= "</thead></tr><tr class='cl'><td>&nbsp;</td><td>&nbsp;</td></tr>";
        
        $x=0;
        foreach($query->result() as $r){
          
          $a .= "<tr class='cl'><td><input type='checkbox' name='checki' id='checki_".$x."' class='chkck' title='1'/></td>";
          $a .= "<td id='batch_".$x."'>".$r->batch_no."</td>";
          $a .= "<td id='code_".$x."'>".$r->code."</td>";
          $a .= "<td id='des_".$x."'>".$r->description."</td>";
          $a .= "<td style='display:none;' id='qty_".$x."'>".$r->qty."</td>";
          $a .= "<td style='display:none;' id='stqty_".$x."'>".$r->stock_qty."</td>";
          $a .= "</tr>";
          $x++;
        }

          $a .= "</table>";
          echo $a;

}

function load_sales_stores(){
    $sql="SELECT 
            mb.def_sales_store_code,
            ms.`description` 
          FROM
            m_branch mb 
            JOIN m_stores ms ON ms.`code` = mb.`def_sales_store_code` 
          WHERE mb.cl ='".$this->sd['cl']."' AND mb.bc = '".$this->sd['bc']."' AND ms.`sales` = '1' ";
    
     $query = $this->db->query($sql);

    if ($query->num_rows() > 0) {
       $a= $query->result();
    } else {
        $a = 3;
    }
   echo json_encode($a);
}

}