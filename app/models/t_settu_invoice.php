<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class t_settu_invoice extends CI_Model {

    private $sd;
    private $mtb;
    private $mod = '003';

    function __construct() {
        parent::__construct();

        $this->sd = $this->session->all_userdata();
        $this->load->database($this->sd['db'], true);
        $this->mtb = $this->tables->tb['t_seettu_inv_sum'];
        $this->load->model('user_permissions');
        
      
    }

public function base_details() {

       $a['max_no'] = $this->utility->get_max_no("t_seettu_inv_sum","nno");
        return $a;
    }

   public function f1_seettu_item(){


      if($_POST['search'] == 'Key Word: code, name'){$_POST['search'] = "";}  
      $seettu_no=$_POST['seettu_no'];
      
      $sql="SELECT 
                  item_code,
                  s.name,
                  d.VALUE,
                  SUM(d.VALUE * no_ins) AS amount,
                  c.`no_of_installment`
                  FROM
                  t_settu_det d 
                  JOIN m_settu_item_sum s 
                  ON s.code = d.`item_code` 
                  JOIN m_settu_item_sum i 
                  ON i.`code` = d.`item_code` 
                  JOIN m_settu_item_category c 
                  ON c.`code` = i.`settu_item_category` 
                  WHERE (item_code LIKE '%".$_POST['search']."%' OR s.name LIKE '%".$_POST['search']."%')
                  AND d.nno='$seettu_no' 
                  AND d.cl = '".$this->sd['cl']."' 
                  AND d.bc = '".$this->sd['branch']."'
                  LIMIT 25";

        $query = $this->db->query($sql);
        
        $a  = "<table id='item_list' style='width : 100%' >";
        $a .= "<thead><tr>";
        $a .= "<th class='tb_head_th'>Code</th>";
        $a .= "<th class='tb_head_th'>Description</th>";
        $a .= "</thead></tr><tr class='cl'><td>&nbsp;</td><td>&nbsp;</td></tr>";
        
        foreach($query->result() as $r){
          
          $a .= "<tr class='cl'><td>".$r->item_code."</td>";
          $a .= "<td>".$r->name."</td>";
          $a .= "<td style='display:none;text-align:right;'>".$r->amount."</td>";
          $a .= "<td style='display:none;text-align:right;'>".$r->VALUE."</td>";
           $a .= "<td style='display:none;text-align:right;'>".$r->no_of_installment."</td>";
          $a .= "</tr>";
        }

          $a .= "</table>";
          echo $a;
  }

  public function f1_seettu_no(){

      if($_POST['search'] == 'Key Word: code, name'){$_POST['search'] = "";}  

      $sql="SELECT nno,organizer,MC.name,book_no FROM t_settu_sum SS JOIN m_customer MC ON MC.code=SS.`organizer`
              WHERE (nno LIKE '%".$_POST['search']."%' OR organizer LIKE '%".$_POST['search']."%' OR name LIKE '%".$_POST['search']."%') 
                AND SS.cl = '".$this->sd['cl']."' 
                AND SS.bc = '".$this->sd['branch']."'
              LIMIT 25";

        $query = $this->db->query($sql);
        
        $a  = "<table id='item_list' style='width : 100%' >";
        $a .= "<thead><tr>";
        $a .= "<th class='tb_head_th'>No</th>";
        $a .= "<th class='tb_head_th'>Code</th>";
        $a .= "<th class='tb_head_th' colspan='2'>Name</th>";
        $a .= "</thead></tr><tr class='cl'><td>&nbsp;</td><td>&nbsp;</td><td colspan='2'>&nbsp;</td></tr>";
        
        foreach($query->result() as $r){
          
          $a .= "<tr class='cl'><td>".$r->nno."</td>";
          $a .= "<td>".$r->organizer."</td>";
          $a .= "<td colspan='2'>".$r->name."</td>";
          $a .= "<td style='display:none;'>".$r->book_no."</td>";
          $a .= "</tr>";
        }

          $a .= "</table>";
          echo $a;
  }

public function f1_load_vehicle(){

      if($_POST['search'] == 'Key Word: code, name'){$_POST['search'] = "";}  

      $sql="SELECT v.code,v.description,driver,e.`name` AS dri_name FROM m_vehicle_setup v JOIN m_employee e ON e.`code`=v.`driver`
              WHERE (v.code LIKE '%".$_POST['search']."%' OR v.description LIKE '%".$_POST['search']."%') 
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
          
          $a .= "<tr class='cl'><td>".$r->code."</td>";
          $a .= "<td>".$r->description."</td>";
          $a .= "<td style='display:none;'>".$r->driver."</td>";
          $a .= "<td style='display:none;'>".$r->dri_name."</td>";
          $a .= "</tr>";
        }

          $a .= "</table>";
          echo $a;
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

  

  public function f1_load_route(){

      if($_POST['search'] == 'Key Word: code, name'){$_POST['search'] = "";}  

      $sql="SELECT r.CODE,r.description FROM r_root r
              WHERE (CODE LIKE '%".$_POST['search']."%' OR description LIKE '%".$_POST['search']."%') 
               
              LIMIT 25";

        $query = $this->db->query($sql);
        
        $a  = "<table id='item_list' style='width : 100%' >";
        $a .= "<thead><tr>";
        $a .= "<th class='tb_head_th'>Code</th>";
        $a .= "<th class='tb_head_th'>Name</th>";
        $a .= "</thead></tr><tr class='cl'><td>&nbsp;</td><td>&nbsp;</td></tr>";
        
        foreach($query->result() as $r){
          
          $a .= "<tr class='cl'><td>".$r->CODE."</td>";
          $a .= "<td>".$r->description."</td>";
          $a .= "</tr>";
        }

          $a .= "</table>";
          echo $a;
  }

  public function load_details(){
      
      $sql="SELECT
                  s.`nno`,
                  s.vehicle_no,
                  v.description AS vehicle,
                  s.driver,
                  e.`name` AS dri_name,
                  s.salesman,
                  e.`name` AS salesmn,
                  s.c_officer,
                  e.`name` AS c_officer_name,
                  s.route,
                  r.`description` AS route
                  FROM
                  t_seettu_inv_sum s
                  JOIN m_vehicle_setup v ON v.`code`=s.`vehicle_no`
                  JOIN m_employee e ON e.`code`=s.`driver`
                  JOIN m_employee q ON q.`code`=s.`salesman`
                  JOIN m_employee w ON w.`code`=s.`c_officer`
                  JOIN r_root r ON r.`code`=s.`route`
                  WHERE s.cl = '".$this->sd['cl']."' 
                  AND s.bc = '".$this->sd['branch']."'
                  ORDER BY s.`nno` DESC
                  LIMIT 25";

        $qry=$this->db->query($sql);
        echo json_encode($qry->first_row());  
        
       
  }

public function save(){
    $this->max_no= $this->utility->get_max_no("t_seettu_inv_sum","nno");
    $this->db->trans_begin();
    error_reporting(E_ALL); 
    function exceptionThrower($type, $errMsg, $errFile, $errLine) { 
        throw new Exception($errMsg); 
    }
    set_error_handler('exceptionThrower'); 
    try { 

       
        $t_seettu_inv_sum=array(
           "cl"           =>$this->sd['cl'],
           "bc"           =>$this->sd['branch'],
           "nno"          =>$this->max_no,
           "ddate"        =>$_POST['date'],
           "ref_no"       =>$_POST['ref_no'],
           "vehicle_no"   =>$_POST['seettu_vehicle'],
           "driver"       =>$_POST['driver_id'],
           "salesman"     =>$_POST['salesman_id'],
           "c_officer"    =>$_POST['c_officer_id'],
           "route"        =>$_POST['route_id'],
           "note"         =>$_POST['note'],
           "book_no"      =>$_POST['book_no'],
           "amount"       =>$_POST['amount'],
           "card_no"      =>$_POST['card_no'],
           "reciept_no"   =>$_POST['reciept_no'],
           "oc"           =>$this->sd['oc'],
    );
    

    $t_seettu_inv_det=array(
           "cl"           =>$this->sd['cl'],
           "bc"           =>$this->sd['branch'],
           "nno"          =>$this->max_no,
           "seettu_no"    =>$_POST['seettu_no'],
           "organizer_no" =>$_POST['organizer'],
           "item"         =>$_POST['seettu_item'],
           "no_of_ins"    =>$_POST['no_of_ins'],
           "price"        =>$_POST['price'],
           "installement" =>$_POST['amount'],
           "addit_charge" =>$_POST['additional'],
           "paid"         =>$_POST['paid'],
    );
    
        if($_POST['hid'] == "0" || $_POST['hid'] == ""){
          if($this->user_permissions->is_add('t_settu_invoice')){ 
            $this->db->insert("t_seettu_inv_sum",  $t_seettu_inv_sum);
           $this->db->insert("t_seettu_inv_det",  $t_seettu_inv_det);
            $this->utility->save_logger("SAVE",73,$this->max_no,$this->mod);
            echo $this->db->trans_commit();
          }else{
            echo "No permission to save records";
            $this->db->trans_commit();
          } 
        }else{
          if($this->user_permissions->is_edit('t_settu_invoice')){ 
            $this->db->where('cl',$this->sd['cl']);
            $this->db->where('bc',$this->sd['branch']);
            $this->db->where('nno',$this->max_no);
            $this->db->update("t_seettu_inv_sum", $t_seettu_inv_sum);
            $this->db->where('cl',$this->sd['cl']);
            $this->db->where('bc',$this->sd['branch']);
            $this->db->where('nno',$this->max_no);
            $this->db->update("t_seettu_inv_det",  $t_seettu_inv_det);
            $this->utility->save_logger("EDIT",73,$this->max_no,$this->mod); 
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

   public function load(){

                $x=0;

                $this->db->select(array(
                    't_seettu_inv_sum.cl',
                    't_seettu_inv_sum.bc',
                    't_seettu_inv_sum.nno',
                    't_seettu_inv_sum.ddate',
                    't_seettu_inv_sum.ref_no',
                    't_seettu_inv_sum.vehicle_no',
                    'm_vehicle_setup.description AS vehicle',
                    't_seettu_inv_sum.driver',
                    'm_employee.name AS dri_name',
                    't_seettu_inv_sum.salesman',
                    'm_employee.name AS salesman_name',
                    't_seettu_inv_sum.route',
                    't_seettu_inv_sum.c_officer',
                    'm_employee.name AS c_officer_name',
                    't_seettu_inv_sum.note',
                    'r_root.description AS route_name',
                    't_seettu_inv_sum.book_no',
                    't_seettu_inv_sum.amount',
                    't_seettu_inv_sum.card_no',
                    't_seettu_inv_sum.reciept_no',
                    't_seettu_inv_sum.is_cancel',
                    't_seettu_inv_det.seettu_no',
                    't_seettu_inv_det.organizer_no',
                    'm_customer.name',
                    't_seettu_inv_det.item',
                    'm_settu_item_sum.name AS item_name',
                    't_seettu_inv_det.no_of_ins',
                    't_seettu_inv_det.price',
                    't_seettu_inv_det.installement',
                    't_seettu_inv_det.addit_charge',
                    't_seettu_inv_det.paid'
                  ));

                $this->db->from('t_seettu_inv_sum');
                $this->db->join('t_seettu_inv_det','t_seettu_inv_det.nno=t_seettu_inv_sum.nno');
                $this->db->join('m_vehicle_setup','m_vehicle_setup.code=t_seettu_inv_sum.vehicle_no');
                $this->db->join('m_customer','m_customer.code=t_seettu_inv_det.organizer_no');
                $this->db->join('m_settu_item_sum','m_settu_item_sum.code=t_seettu_inv_det.item');
                $this->db->join('m_employee','m_employee.code=t_seettu_inv_sum.driver');
                $this->db->join('r_root','r_root.code=t_seettu_inv_sum.route');
                $this->db->where('t_seettu_inv_sum.cl',$this->sd['cl'] );
                $this->db->where('t_seettu_inv_sum.bc',$this->sd['branch'] );
                $this->db->where('t_seettu_inv_sum.nno',$_POST['id']);

                $query=$this->db->get();

                     if($query->num_rows()>0){
                      $a['seettu']=$query->result();
                         }else{
                        $x=2;
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
                    't_seettu_inv_det.cl',
                    't_seettu_inv_det.bc',
                    't_seettu_inv_det.seettu_no',
                    't_seettu_inv_det.organizer_no',
                    't_seettu_inv_det.no_of_ins',
                    'm_settu_item_sum.name AS item_name',
                    't_seettu_inv_det.installement',
                    't_seettu_inv_det.price',
                    't_seettu_inv_det.addit_charge',
                    't_seettu_inv_det.paid',
                    't_seettu_inv_sum.is_cancel'
                  ));

                $this->db->from('t_seettu_inv_det');
                $this->db->join('m_settu_item_sum','m_settu_item_sum.code=t_seettu_inv_det.item');
                $this->db->join('t_seettu_inv_sum','t_seettu_inv_sum.nno=t_seettu_inv_det.nno');
                $this->db->where('t_seettu_inv_det.cl',$this->sd['cl'] );
                $this->db->where('t_seettu_inv_det.bc',$this->sd['branch'] );
                $this->db->where('t_seettu_inv_sum.ddate',$_POST['ddate']);
                $this->db->where('t_seettu_inv_sum.vehicle_no',$_POST['seettu_vehicle']);
                $this->db->group_by(array('t_seettu_inv_det.cl','t_seettu_inv_det.bc','t_seettu_inv_det.nno')); 
                $this->db->order_by("t_seettu_inv_det.auto_no","desc");

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

public function cancel(){
        $this->db->trans_begin();
        error_reporting(E_ALL); 
        function exceptionThrower($type, $errMsg, $errFile, $errLine) { 
            throw new Exception($errMsg); 
        }
        set_error_handler('exceptionThrower'); 
        try { 
            if($this->user_permissions->is_delete('t_settu_invoice')){
              
            $this->db->where('cl',$this->sd['cl']);
            $this->db->where('bc',$this->sd['branch']);
            $this->db->where('nno',$_POST['id']);
            $this->db->update('t_seettu_inv_sum',array('is_cancel' => 1)); 
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


    public function delete(){
        $this->db->trans_begin();
        error_reporting(E_ALL); 
        function exceptionThrower($type, $errMsg, $errFile, $errLine) { 
            throw new Exception($errMsg); 
        }
        set_error_handler('exceptionThrower'); 
        try { 
            if($this->user_permissions->is_delete('t_settu_invoice')){
              $this->db->where('nno', $_POST['id']);
              $this->db->limit(1);
              $this->db->delete($this->mtb);
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



}