<?php if (!defined('BASEPATH'))exit('No direct script access allowed');

class t_settu_item_req extends CI_Model {

    private $sd;
    private $mtb;
    private $mod = '003';

    function __construct() {
        parent::__construct();
        $this->sd = $this->session->all_userdata();
        $this->load->database($this->sd['db'], true);
        $this->load->model('user_permissions');
    }

    public function base_details(){
        $a['max_no'] = $this->utility->get_max_no("t_settu_item_req_sum","nno");
        return $a;
    }

    public function validation(){
      $this->max_no = $this->utility->get_max_no("t_settu_item_req_sum", "nno");
      $status = 1;
      $customer_validation = $this->validation->check_is_customer($_POST['organizer_id']);
      if ($customer_validation != 1) {
          return "Please enter valid Orgenizer";
      }

      for($x=0; $x<25; $x++){
          $req_validation = $this->is_can_request($_POST['seettu_id'],$_POST['1_'.$x]);
          if ($req_validation != 1) {
              return $req_validation;
          }
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
          if($validation_status == 1) {
            $settu_req_sum = array(
              "cl"          => $this->sd['cl'],
              "bc"          => $this->sd['branch'],
              "nno"         => $this->max_no,
              "ddate"       => $_POST['date'],
              "ref_no"      => $_POST['ref_no'],
              "orgernizer"  => $_POST['organizer_id'],       
              "settu_no"    => $_POST['seettu_id'],
              "oc"          => $this->sd['oc'],    
            );

                 
            for ($x=0; $x<25; $x++) {
              if (isset($_POST['0_'.$x], $_POST['1_'. $x])) {
                if ($_POST['1_'.$x]!=""){
                  $settu_req_det[] = array(
                    "cl"        => $this->sd['cl'],
                    "bc"        => $this->sd['branch'],
                    "nno"       => $this->max_no,
                    "code"      => $_POST['1_'.$x]
                  );
                }
              }    
            }

            $settu_det_update = array(
              "status"          => "1"    
            );

            if ($_POST['hid']== "0" || $_POST['hid']== "") {
                if($this->user_permissions->is_add('t_settu_item_req')){
                    $this->db->insert('t_settu_item_req_sum',$settu_req_sum);
                    if(count($settu_req_det)){
                      $this->db->insert_batch("t_settu_item_req_det", $settu_req_det);
                    } 
                    for ($x=0; $x<25; $x++){
                      if (isset($_POST['0_'.$x], $_POST['1_'. $x])) {
                        if ($_POST['1_'.$x]!=""){
                          $this->db->where("nno",$_POST['seettu_id']);
                          $this->db->where("cl", $this->sd['cl']);
                          $this->db->where("bc", $this->sd['branch']);
                          $this->db->where("item_code", $_POST['1_'.$x]);
                          $this->db->update('t_settu_det', $settu_det_update);
                        }
                      }
                    }
                    $this->utility->save_logger("SAVE",78,$this->max_no,$this->mod);
                    echo $this->db->trans_commit();
                }else{
                    $this->db->trans_commit();
                    echo "No permission to save records";
                }
            } else {
              if($this->user_permissions->is_edit('t_settu_item_req')){
                $this->db->where("nno",$this->max_no);
                $this->db->where("cl", $this->sd['cl']);
                $this->db->where("bc", $this->sd['branch']);
                $this->db->update('t_settu_item_req_sum', $settu_req_sum);
                 
                $this->db->where("nno",$this->max_no);
                $this->db->where("cl", $this->sd['cl']);
                $this->db->where("bc", $this->sd['branch']);
                $this->db->delete('t_settu_item_req_det');

                if(count($settu_req_det)){
                  $this->db->insert_batch("t_settu_item_req_det", $settu_req_det);
                } 

                for ($x=0; $x<25; $x++){
                  $this->db->where("nno",$_POST['seettu_id']);
                  $this->db->where("cl", $this->sd['cl']);
                  $this->db->where("bc", $this->sd['branch']);
                  $this->db->where("item_code", $_POST['1_'.$x]);
                  $this->db->update('t_settu_det', array("status"=>0));
                  if (isset($_POST['0_'.$x], $_POST['1_'. $x])) {
                    if ($_POST['1_'.$x]!=""){
                      $this->db->where("nno",$_POST['seettu_id']);
                      $this->db->where("cl", $this->sd['cl']);
                      $this->db->where("bc", $this->sd['branch']);
                      $this->db->where("item_code", $_POST['1_'.$x]);
                      $this->db->update('t_settu_det', $settu_det_update);
                    }
                  }
                }
                $this->utility->save_logger("EDIT",78,$this->max_no,$this->mod);
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
        } catch (Exception $e) {
          $this->db->trans_rollback();
          echo $e->getMessage(). "Operation fail please contact admin";
        }
    }

    public function load() {
      $x = 0; 
      $sql="SELECT s.*, c.`name`,c.root 
            FROM `t_settu_item_req_sum` s
            JOIN m_customer c ON c.`code` = s.`orgernizer`
            WHERE s.cl='".$this->sd['cl']."' AND s.bc='".$this->sd['branch']."' 
            AND s.nno='".$_POST['no']."'";

      $query=$this->db->query($sql);      
          
      if ($query->num_rows() > 0) {
          $a['sum'] = $query->result();
      } else {
          $x = 2;
      }

      $sql="SELECT d.*, s.`name`,c.`code` AS c_code
            FROM `t_settu_item_req_det` d
            JOIN m_settu_item_sum s ON s.`code` = d.`code`
            JOIN m_settu_item_category c ON c.`ref_code` = s.`settu_item_category`
            WHERE d.cl='".$this->sd['cl']."' AND d.bc='".$this->sd['branch']."'
            AND d.nno='".$_POST['no']."'";

      $query=$this->db->query($sql);          

      if ($query->num_rows() > 0) {
          $a['det'] = $query->result();
      } else {
          $x = 2;
      }

      if($x==0) {
        echo json_encode($a);
      }else{
        echo json_encode($x);
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
            if($this->user_permissions->is_delete('t_settu_item_req')){

              $sql="SELECT * FROM `t_settu_item_req_det` 
                    WHERE cl='".$this->sd['cl']."' 
                    AND bc='".$this->sd['branch']."' 
                    AND nno='".$_POST['trans_no']."'";
              $query=$this->db->query($sql);

              foreach($query->result() as $row){
                $this->db->where("nno",$_POST['seettu_id']);
                $this->db->where("cl", $this->sd['cl']);
                $this->db->where("bc", $this->sd['branch']);
                $this->db->where("item_code", $row->code);
                $this->db->update('t_settu_det', array("status"=>0));
              }

              $this->db->where("nno",$_POST['trans_no']);
              $this->db->where("cl", $this->sd['cl']);
              $this->db->where("bc", $this->sd['branch']);
              $this->db->update('t_settu_item_req_sum',array("is_cancel" => 1));

               $this->utility->save_logger("DELETE",78,$_POST['trans_no'],$this->mod);
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

  
    public function load_orgernizer(){

      if($_POST['search'] == 'Key Word: code, name'){$_POST['search'] = "";}
        $sql = "SELECT * FROM m_customer  WHERE category = '005' AND (code LIKE '%$_POST[search]%' OR name LIKE '%$_POST[search]%') LIMIT 25";
  
      $query = $this->db->query($sql);
      $a  = "<table id='item_list' style='width : 100%' >";
      $a .= "<thead><tr>";
      $a .= "<th class='tb_head_th'>Code</th>";
      $a .= "<th class='tb_head_th' colspan='2'>Name</th>";
      $a .= "</thead></tr><tr class='cl'><td>&nbsp;</td><td colspan='2'>&nbsp;</td></tr>";

    foreach($query->result() as $r){
      $a .= "<tr class='cl'>";
      $a .= "<td>".$r->code."</td>";
      $a .= "<td>".$r->name."</td>";
      $a .= "<td style='display:none;'>".$r->address1."</td>";
      $a .= "</tr>";
    }
      $a .= "</table>";
      echo $a;
  }

  public function load_settu(){

      if($_POST['search'] == 'Key Word: code, name'){$_POST['search'] = "";}
      
      if($_POST['organizer']==""){
        $sql="SELECT  d.nno,
                      st.`ddate`,
                      st.`organizer` ,
                      c.`name`,
                      c.root,
                      COUNT(`status`)AS tot_count, 
                      IFNULL(s.status_req_count,0) AS req_count, 
                      (COUNT(`status`)-IFNULL(s.status_req_count,0)) AS pending
              FROM t_settu_det d
              LEFT JOIN (SELECT cl,bc,nno,COUNT(`status`)AS status_req_count 
                FROM t_settu_det WHERE `status`='1' 
                GROUP BY nno,cl,bc)s ON s.cl= d.cl AND s.bc=d.bc AND s.nno=d.nno
              JOIN t_settu_sum st ON st.cl=d.cl AND st.bc=d.bc AND st.`nno`=d.`nno`
              JOIN m_customer c ON c.`code` = st.`organizer`
              WHERE st.cl = '".$this->sd['cl']."' 
                    AND st.bc ='".$this->sd['branch']."' 
                    AND (d.nno LIKE '%$_POST[search]%' OR st.organizer LIKE '%$_POST[search]%')
              GROUP BY d.nno,d.cl,d.bc
              HAVING pending > 0
              LIMIT 25";

      }else{

        $sql="SELECT  d.nno,
                      st.`ddate`,
                      st.`organizer` ,
                      c.`name`,
                      c.root,
                      COUNT(`status`)AS tot_count, 
                      IFNULL(s.status_req_count,0) AS req_count, 
                      (COUNT(`status`)-IFNULL(s.status_req_count,0)) AS pending
              FROM t_settu_det d
              LEFT JOIN (SELECT cl,bc,nno,COUNT(`status`)AS status_req_count 
                FROM t_settu_det WHERE `status`='1' 
                GROUP BY nno,cl,bc)s ON s.cl= d.cl AND s.bc=d.bc AND s.nno=d.nno
              JOIN t_settu_sum st ON st.cl=d.cl AND st.bc=d.bc AND st.`nno`=d.`nno`
              JOIN m_customer c ON c.`code` = st.`organizer`
              WHERE st.cl = '".$this->sd['cl']."' 
                  AND st.bc ='".$this->sd['branch']."' 
                  AND organizer ='".$_POST['organizer']."'
                  AND (d.nno LIKE '%$_POST[search]%' OR st.organizer LIKE '%$_POST[search]%')
              GROUP BY d.nno,d.cl,d.bc
              HAVING pending > 0
              LIMIT 25";

      }

  
      $query = $this->db->query($sql);
      $a  = "<table id='item_list' style='width : 100%' >";
      $a .= "<thead><tr>";
      $a .= "<th class='tb_head_th'>Settu No</th>";
      $a .= "<th class='tb_head_th'>Date</th>";
      $a .= "<th class='tb_head_th'>Orgenizer</th>";
      $a .= "</thead></tr><tr class='cl'><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>";

    foreach($query->result() as $r){
      $a .= "<tr class='cl'>";
      $a .= "<td>".$r->nno."</td>";
      $a .= "<td>".$r->ddate."</td>";
      $a .= "<td>".$r->organizer."</td>";
      $a .= "<td style='display:none;'>".$r->name."</td>";
      $a .= "<td style='display:none;'>".$r->pending."</td>";
      $a .= "<td style='display:none;'>".$r->root."</td>";
      $a .= "</tr>";
    }
      $a .= "</table>";
      echo $a;
  }

  public function load_pending_details(){

    $id=$_POST['id'];
    $sql="SELECT COUNT(`status`)AS tot_count 
          FROM t_settu_det dd 
          JOIN t_settu_sum ss ON ss.nno=dd.nno AND ss.bc=dd.bc AND ss.cl=dd.cl 
          WHERE dd.`status`='1'  AND organizer = '$id'";

    $sql1="SELECT COUNT(`status`)AS tot_count 
          FROM t_settu_det dd 
          JOIN t_settu_sum ss ON ss.nno=dd.nno AND ss.bc=dd.bc AND ss.cl=dd.cl 
          WHERE organizer = '$id'";

    $sql2="SELECT COUNT(`status`)AS tot_count 
          FROM t_settu_det dd 
            JOIN t_settu_sum ss ON ss.nno=dd.nno AND ss.bc=dd.bc AND ss.cl=dd.cl 
            JOIN m_customer c ON c.`code` = ss.`organizer`
          WHERE dd.`status`='0'  AND c.`root` = '".$_POST['root']."'";

    $sql3="SELECT * FROM r_root
           where code = '".$_POST['root']."'";

    $root_name=$this->db->query($sql3)->row()->description;   
    $req_qty  = (int)$this->db->query($sql)->row()->tot_count;
    $pending_qty = (int)$this->db->query($sql1)->row()->tot_count;
    $root_qty = (int)$this->db->query($sql2)->row()->tot_count;

    $tot_pending = (int)$pending_qty-(int)$req_qty;

    if($tot_pending>0){
      $tot_p_qty = $tot_pending;
    }else{
      $tot_p_qty = 0;
    }
    $a['tot_pending'] = $tot_p_qty;
    $a['tot_root_pending'] = $root_qty;
    $a['root_name'] = $root_name;

    echo json_encode($a);


  }
  public function load_settu_item(){
    $sql="SELECT c.`code`, d.`item_code`, s.`name` FROM t_settu_det d
          JOIN m_settu_item_sum s ON  s.`code` = d.`item_code`
          JOIN m_settu_item_category c ON c.`ref_code` = s.`settu_item_category`
          WHERE d.cl='".$this->sd['cl']."' 
          AND d.bc='".$this->sd['branch']."' 
          AND d.nno='".$_POST['no']."'
          AND d.status ='0'";

    $query = $this->db->query($sql);

    if($query->num_rows>0){
      $a=$query->result();
    }else{
      $a="2";
    }
    echo json_encode($a);
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

      $sql="SELECT s.*, c.`name`,c.root 
            FROM `t_settu_item_req_sum` s
            JOIN m_customer c ON c.`code` = s.`orgernizer`
            WHERE s.cl='".$this->sd['cl']."' AND s.bc='".$this->sd['branch']."' 
            AND s.nno='".$_POST['qno']."'";
      $query=$this->db->query($sql);      
      if ($query->num_rows() > 0) {
          $r_detail['sum'] = $query->result();
      } 

      $sql="SELECT d.*, s.`name`,c.`code` AS c_code
            FROM `t_settu_item_req_det` d
            JOIN m_settu_item_sum s ON s.`code` = d.`code`
            JOIN m_settu_item_category c ON c.`ref_code` = s.`settu_item_category`
            WHERE d.cl='".$this->sd['cl']."' AND d.bc='".$this->sd['branch']."'
            AND d.nno='".$_POST['qno']."'";

      $query=$this->db->query($sql);          
      if ($query->num_rows() > 0) {
          $r_detail['det'] = $query->result();
      }
      $this->load->view($_POST['by'].'_'.'pdf',$r_detail);
    }

    public function is_can_request($settu_no,$item){

      $status =1;
      $sql="SELECT `status` 
            FROM t_settu_det
            WHERE nno='$settu_no' AND item_code='$item' AND cl='".$this->sd['cl']."' AND bc='".$this->sd['branch']."'";

      $query=$this->db->query($sql)->result();
      $st=0;
      foreach ($query as $row) {
        $st = $row->status;
      }
      if($st=="2"){
        $status ="This Item ( ".$item." ) already loaded ! ";
      }      
      return $status;
    }

}

