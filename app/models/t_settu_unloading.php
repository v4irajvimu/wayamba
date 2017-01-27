<?php
if (!defined('BASEPATH'))exit('No direct script access allowed');

class t_settu_unloading extends CI_Model {

    private $sd;
    private $mtb;
    private $max_no;
    private $mod = '003';

    function __construct() {
        parent::__construct();
        $this->sd = $this->session->all_userdata();
        $this->load->database($this->sd['db'], true);
        $this->load->model('user_permissions');
        $this->mtb = $this->tables->tb['t_seettu_unload_sum'];
        
    }

    public function base_details(){
        $a['max_no'] = $this->utility->get_max_no("t_seettu_unload_sum","nno");
        return $a;
    }

public function loading_data(){

  $nno=$_POST['load_id'];
      $sql="SELECT 
                ls.root,
                r.description AS root_name,
                ls.store_from,
                s.description AS store_from_name,
                ls.store_to,
                s1.description AS store_to_name
              FROM
                t_settu_load_sum ls 
                JOIN r_root r ON r.code=ls.root
                JOIN m_stores s ON s.code=ls.store_from
                JOIN m_stores s1 ON s1.code=ls.store_to
              WHERE ls.nno='$nno' AND ls.cl = '".$this->sd['cl']."' 
                AND ls.bc = '".$this->sd['branch']."'
              LIMIT 25";

        $query = $this->db->query($sql)->first_row();

        echo json_encode( $query);
       
}

function load_grid(){
  $nno=$_POST['load_id'];
  $sql="SELECT  d.`nno`,
                d.`organizer`,
                c.`name`,
                d.`settu_no`,
                sc.`ref_code` ,
                sc.code AS category,
                d.`code` AS item,
                s.`name` AS des
        FROM `t_settu_load_det` d
        JOIN m_settu_item_sum s ON s.`cl` = d.`cl` AND s.`bc` = d.`bc` AND s.`code` = d.`code`
        JOIN m_customer c ON c.`code` = d.`organizer`
        JOIN `m_settu_item_category` sc ON sc.`ref_code` = d.`category`
        WHERE d.cl='".$this->sd['cl']."' 
        AND d.bc='".$this->sd['branch']."' 
        AND d.`nno` ='$nno' 
        AND d.`status`='1'
        GROUP BY d.`code`";

  $query=$this->db->query($sql);

  if($query->num_rows()>0){
    $a['det']=$query->result();
  }else{
    $a=2;
  }
  echo json_encode($a);
}

public function validation(){
 $status = 1;
   $this->max_no=$this->utility->get_max_no("t_seettu_unload_sum","nno");
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
        $validation_status = $this->validation();
        if($validation_status == 1){

      $sum=array(
        "cl"                =>$this->sd['cl'],
        "bc"                =>$this->sd['branch'],
        "nno"               =>$this->max_no,
        "date"              =>$_POST['date'],
        "ref_no"            =>$_POST['ref_no'],
        "load_no"           =>$_POST['load_id'],
        "route"             =>$_POST['root_id'],
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
              "seettu_no"   =>$_POST['1_'.$x],
              "category"    =>$_POST['refno_'.$x],
              "code"        =>$_POST['5_'.$x],
            ); 
          }
        }
      }
    $settu_det_update = array(
      "status"          => "3"    
    );

     /*for ($x = 0; $x < 25; $x++) {
        if (isset($_POST['n_' . $x])) {
          if ($_POST['n_' . $x] != "") {
           

              $t_item_movement_out[] = array(
                  "cl"        => $this->sd['cl'],
                  "bc"        => $this->sd['branch'],
                  "item"      => $_POST['5_' . $x],
                  "trans_code"=> 79,
                  "trans_no"  => $this->max_no,
                  "ddate"     => $_POST['date'],
                  "qty_in"    => 0,
                  "qty_out"   => 1,
                  "store_code"=> $_POST['store_from_id'],
                  "avg_price" => '',
                  "batch_no"  => '',
                  "sales_price"=> '',
                  "last_sales_price"=> '',
                  "cost"      => '',
                  "group_sale_id"=> 1,
              );

              $t_item_movement_in[] = array(
                  "cl"        => $this->sd['cl'],
                  "bc"        => $this->sd['branch'],
                  "item"      => $_POST['5_' . $x],
                  "trans_code"=> 79,
                  "trans_no"  => $this->max_no,
                  "ddate"     => $_POST['date'],
                  "qty_in"    => 1,
                  "qty_out"   => 0,
                  "store_code"=> $_POST['store_to_id'],
                  "avg_price" => '',
                  "batch_no"  => '',
                  "sales_price"=> '',
                  "last_sales_price"=> '',
                  "cost"      => '',
                  "group_sale_id"=> 1,
              );
          }
        }
      }*/

      if($_POST['hid'] == "0" || $_POST['hid'] == ""){

        if($this->user_permissions->is_add('t_settu_unloading')){
          $this->db->insert("t_seettu_unload_sum", $sum);
          if(count($det)){
            $this->db->insert_batch("t_seettu_unload_det",$det);
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
          if (isset($_POST['1_'.$x], $_POST['check_'. $x])) {
            $this->db->where("nno",$this->max_no);
            $this->db->where("cl", $this->sd['cl']);
            $this->db->where("bc", $this->sd['branch']);
            $this->db->where("code", $_POST['5_'.$x]);
            $this->db->update('t_seettu_unload_det', array("status"=>1));
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
  
          //$this->account_update(1);
          $this->utility->save_logger("SAVE",79,$this->max_no,$this->mod);
          echo $this->db->trans_commit();
        }else{
          $this->db->trans_commit();
          echo "No permission to save records";
        }
      }else{
       
        if($this->user_permissions->is_edit('t_settu_unloading')){
          $this->db->where('nno',$this->max_no);
          $this->db->where('cl',$this->sd['cl']);
          $this->db->where('bc',$this->sd['branch']);
          $this->db->update($this->mtb, $sum);
         
          $this->db->where("nno",$this->max_no);
          $this->db->where("cl", $this->sd['cl']);
          $this->db->where("bc", $this->sd['branch']);
          $this->db->delete('t_seettu_unload_det');

          if(count($det)){
            $this->db->insert_batch("t_seettu_unload_det",$det);
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
                      $this->db->where("code", $_POST['5_'.$x]);
                      $this->db->update('t_seettu_unload_det', $settu_det_update);
                    }
                  }
                }
          for ($x=0; $x<25; $x++){
            if (isset($_POST['1_'.$x], $_POST['check_'. $x])) {
              $this->db->where("nno",$this->max_no);
              $this->db->where("cl", $this->sd['cl']);
              $this->db->where("bc", $this->sd['branch']);
              $this->db->where("code", $_POST['5_'.$x]);
              $this->db->update('t_seettu_unload_det', array("status"=>1));
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
          //$this->account_update(1);
          $this->utility->save_logger("EDIT",79,$this->max_no,$this->mod);
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
                      us.date,
                      us.ref_no,
                      us.load_no,
                      us.route,
                      r.description as route_name,
                      us.store_from,
                      s1.description as store_from_name,
                      us.store_to,
                      s2.description as store_to_name,
                      us.memo,
                      us.is_cancel 
                    from
                      t_seettu_unload_sum us 
                      join r_root r on r.code=us.route
                      join m_stores s1 on s1.code=us.store_from
                      join m_stores s2 on s2.code=us.store_to
                    WHERE us.`cl` ='".$this->sd['cl']."'
                    AND us.`bc`='".$this->sd['branch']."'
                    AND us.`nno`='".$_POST['no']."'";

    $query_sum = $this->db->query($sql_sum); 

    if($query_sum->num_rows()>0){ 

      $a['sum']=$query_sum->result();         
    }else{
      $x=2;      
    }
    $sql_det="SELECT 
                  ud.organizer,
                  c.name,
                  ud.seettu_no,
                  ud.category,
                  ic.`code` AS cat,
                  ud.code,
                  s.`name` AS des,
                  ud.`status`
                FROM
                  t_seettu_unload_det ud
                 JOIN m_customer c ON c.`code`=ud.organizer
                 JOIN m_settu_item_category ic ON ic.`ref_code`=ud.category
                 JOIN m_settu_item_sum s ON s.`code`=ud.code 
                WHERE ud.cl='".$this->sd['cl']."' 
                AND ud.bc='".$this->sd['branch']."'
                AND ud.nno='".$_POST['no']."'";

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

  public function delete() {
        $this->db->trans_begin();
        error_reporting(E_ALL);
        function exceptionThrower($type, $errMsg, $errFile, $errLine) {
            throw new Exception($errMsg);
        }
        set_error_handler('exceptionThrower');
        try {
            if($this->user_permissions->is_delete('t_settu_unloading')){

              $sql="SELECT * FROM `t_seettu_unload_det` 
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
              $this->db->update('t_seettu_unload_sum',array("is_cancel" => 1));

               $this->utility->save_logger("DELETE",79,$_POST['nno'],$this->mod);
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
                      us.nno,
                      us.date,
                      us.ref_no,
                      us.load_no,
                      us.route,
                      r.description as route_name,
                      us.store_from,
                      s1.description as store_from_name,
                      us.store_to,
                      s2.description as store_to_name,
                      us.memo,
                      us.is_cancel 
                    from
                      t_seettu_unload_sum us 
                      join r_root r on r.code=us.route
                      join m_stores s1 on s1.code=us.store_from
                      join m_stores s2 on s2.code=us.store_to
                    WHERE us.`cl` ='".$this->sd['cl']."'
                    AND us.`bc`='".$this->sd['branch']."'
                    AND us.`nno`='".$_POST['qno']."'";
            
      $query=$this->db->query($sql);      
      if ($query->num_rows() > 0) {
          $r_detail['sum'] = $query->result();
      } 

      $sql="SELECT 
                  ud.organizer,
                  c.name,
                  ud.seettu_no,
                  ud.category,
                  ic.`code` AS cat,
                  ud.code,
                  s.`name` AS des,
                  ud.`status`
                FROM
                  t_seettu_unload_det ud
                 JOIN m_customer c ON c.`code`=ud.organizer
                 JOIN m_settu_item_category ic ON ic.`ref_code`=ud.category
                 JOIN m_settu_item_sum s ON s.`code`=ud.code 
                WHERE ud.cl='".$this->sd['cl']."' 
                AND ud.bc='".$this->sd['branch']."'
                AND ud.nno='".$_POST['qno']."'";

      $query=$this->db->query($sql);          
      if ($query->num_rows() > 0) {
          $r_detail['det'] = $query->result();
      }
      $this->load->view($_POST['by'].'_'.'pdf',$r_detail);
    }

  public function load_pending_loadings(){
    if($_POST['search'] == 'Key Word: code, name'){$_POST['search'] = "";}
    $sql="SELECT s.`nno`,
                  s.`ddate`,
                  s.`root`,
                  r.`description`, 
                  s.`store_from`, 
                  m.`description` AS from_store_name,
                  s.`store_to`,
                  mm.`description` AS to_store_name 
          FROM t_settu_load_det d
          JOIN t_settu_load_sum s ON s.`cl` = d.`cl` AND s.`bc` = d.`bc` AND d.`nno` = s.`nno`
          JOIN r_root r ON r.`code` = s.`root`
          JOIN m_stores m ON m.`code` = s.`store_from`
          JOIN m_stores mm ON mm.`code` = s.`store_to`
          WHERE s.cl='".$this->sd['cl']."' 
          AND s.bc='".$this->sd['branch']."' 
          AND s.`nno` LIKE '%$_POST[search]%'
          AND d.`status` ='1'
          GROUP BY s.`nno`,s.`cl`,s.`bc`";

    $query=$this->db->query($sql);

    $a  = "<table id='item_list' style='width : 100%' >";
    $a .= "<thead><tr>";
    $a .= "<th class='tb_head_th'>No</th>";
    $a .= "<th class='tb_head_th'>Date</th>";
    $a .= "<th class='tb_head_th' colspan='2'>Root</th>";
    $a .= "</thead></tr><tr class='cl'><td>&nbsp;</td><td>&nbsp;</td><td colspan='2'>&nbsp;</td></tr>";

    foreach($query->result() as $r){
      $a .= "<tr class='cl'>";
      $a .= "<td>".$r->nno."</td>";
      $a .= "<td>".$r->ddate."</td>";
      $a .= "<td>".$r->root."-".$r->description."</td>";
      $a .= "<td style='display:none;'>".$r->root."</td>";
      $a .= "<td style='display:none;'>".$r->description."</td>";
      $a .= "<td style='display:none;'>".$r->store_from."</td>";
      $a .= "<td style='display:none;'>".$r->from_store_name."</td>";
      $a .= "<td style='display:none;'>".$r->store_to."</td>";
      $a .= "<td style='display:none;'>".$r->to_store_name."</td>";
      $a .= "</tr>";
    }
      $a .= "</table>";
      echo $a;
  }

}