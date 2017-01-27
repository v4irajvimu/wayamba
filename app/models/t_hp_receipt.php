<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class t_hp_receipt extends CI_Model {
    
  private $sd;
  private $mtb;
  private $tb_po_trans;
  private $max_no;
  private $mod = '003';
  private $trans_code="23";
  private $sub_trans_code="23";
  private $qty_out="0";

  function __construct(){
  	parent::__construct();
  	
  	$this->sd = $this->session->all_userdata();
    $this->load->database($this->sd['db'], true);
  	$this->mtb = $this->tables->tb['t_po_sum'];
  	$this->tb_po_trans= $this->tables->tb['t_po_trans'];
    $this->load->model('utility');
    $this->load->model('user_permissions');
  }
    
  public function base_details(){  	
   	$a['max_no']= $this->utility->get_max_no("t_po_sum","nno");
   	$a['cluster']=$this->load_cluster();
    $a['branch']=$this->load_branch();
    return $a;
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

    public function load_cluster(){
        $this->db->select(array("description"));
        $this->db->where("code",$this->sd['cl']);
        return $this->db->get('m_cluster')->row()->description;
    }
    
    public function save(){

    }


    public function get_details(){

        
        
    }


    public function PDF_report(){
     
      $r_detail['deliver_date'];
      $r_detail['ship_to_bc'];
      $r_detail['supplier'];
      $r_detail['ddate'];
      $r_detail['total_amount'];
     

      $this->db->where("nno",$_POST['qno']);
      $query= $this->db->get('t_po_sum'); 
      if ($query->num_rows() > 0){
          foreach ($query->result() as $row){
                $r_detail['deliver_date']=$row->deliver_date;
                $r_detail['ship_to_bc']=$row->ship_to_bc;
                $r_detail['supplier']=$row->supplier;
                $r_detail['ddate']=$row->ddate;
                $r_detail['total_amount']=$row->total_amount;
            }
       } 


      $this->db->select(array('name','address','tp','fax','email'));
      $this->db->where("cl",$this->sd['cl']);
      $this->db->where("bc",$this->sd['branch']);
      $r_detail['branch']=$this->db->get('m_branch')->result();

      $this->db->select(array('name','address','tp','fax','email'));
      $this->db->where("cl",$this->sd['cl']);
      $this->db->where("bc",$r_detail['ship_to_bc']);
      $r_detail['ship_branch']=$this->db->get('m_branch')->result();
      
     
      $r_detail['qno']=$_POST['qno'];
      $r_detail['page']=$_POST['page'];
      $r_detail['header']=$_POST['header'];
      $r_detail['orientation']=$_POST['orientation'];
      $r_detail['type']=$_POST['type'];

     



      $sql="SELECT 
      `m_supplier`.`code`, 
      `m_supplier`.`name`, 
      `m_supplier`.`address1`, 
      IFNULL (`m_supplier`.`address2`,'') address2,
      IFNULL (`m_supplier`.`address3`,'') address3, 
      IFNULL (`m_supplier`.`email`,'') email,
      IFNULL (`m_supplier_contact`.`tp`,'') tp FROM (`m_supplier`) 
      LEFT JOIN `m_supplier_contact` ON `m_supplier_contact`.`code`=`m_supplier`.`code` WHERE `m_supplier`.`code`='".$r_detail['supplier']."' LIMIT 1";

      
      $r_detail['suppliers']=$this->db->query($sql)->result();


       $sql="SELECT 
        `m_item`.`code`,
         `m_item`.`description`,
         `m_item`.`model`,
         `m_item`.`purchase_price`,
         `t_po_det`.`item`,
         `t_po_det`.`current_qty`,
         `t_po_det`.`qty`,
         `t_po_det`.`cost`,
         `t_po_det`.`amount`
         FROM `t_po_det` 
         JOIN m_item ON m_item.`code`=t_po_det.`item`
         WHERE `t_po_det`.`nno`=".$_POST['qno']." AND cl='".$this->sd['cl']."' AND bc='".$this->sd['branch']."'";

      $query=$this->db->query($sql);
      if($query->num_rows>0){
        $r_detail['det']=$query->result();
      }else{
        $r_detail['det']=2;
      }

      $this->load->view($_POST['by'].'_'.'pdf',$r_detail);

    }


       private function set_delete(){
        $this->db->where("nno", $_POST['id']);
        $this->db->where("cl", $_POST['cl']);
        $this->db->where("bc", $_POST['branch']);
        $this->db->delete("t_po_det");
       }
        
        public function check_code(){
        	$this->db->where('code', $_POST['code']);
        	$this->db->limit(1);
    	
    	    echo $this->db->get($this->mtb)->num_rows;
        }
        
        
         public function load(){
                $x=0;

                $this->db->select(array(
                    't_po_sum.supplier as supp_id' ,
                    'm_supplier.name'
                  ));

                $this->db->from('t_po_sum');
                $this->db->join('m_supplier','t_po_sum.supplier=m_supplier.code');
                $this->db->where('t_po_sum.cl',$this->sd['cl'] );
                $this->db->where('t_po_sum.bc',$this->sd['branch'] );
                $this->db->where('t_po_sum.nno',$_POST['id']);
                $query=$this->db->get();

                     

                     if($query->num_rows()>0){
                      $a['supplier']=$query->result();
                         }else{
                        $x=2;
                      }

               $this->db->select(array(
                    't_po_sum.ddate' ,
                    't_po_sum.ref_no' ,
                    't_po_sum.comment',
                    't_po_sum.total_amount',
                    't_po_sum.deliver_date',
                    't_po_sum.ship_to_bc',
                    't_po_sum.is_cancel'
                  ));

                $this->db->where('t_po_sum.cl',$this->sd['cl'] );
                $this->db->where('t_po_sum.bc',$this->sd['branch'] );
                $this->db->where('t_po_sum.nno',$_POST['id']);
                $query=$this->db->get('t_po_sum');

                     

                if($query->num_rows()>0){
                      $a['sum']=$query->result();
                         }else{
                        $x=2;
                      } 


                $this->db->select(array(
                    't_po_det.item' ,
                    't_po_det.qty',
                    't_po_det.current_qty',
                    't_po_det.cost',
                    't_po_det.amount',
                    'm_item.description',
                    'm_item.model'
                  ));

                $this->db->from('t_po_det');
                $this->db->join('m_item','m_item.code=t_po_det.item');
                $this->db->where('t_po_det.cl',$this->sd['cl'] );
                $this->db->where('t_po_det.bc',$this->sd['branch'] );
                $this->db->where('t_po_det.nno',$_POST['id']);
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



        public function delete(){

          $this->utility->delete_po_trans($this->tb_po_trans, $this->trans_code, $_POST['id']);

          //$this->utility->cancel_trans('t_req_sum', $_POST['id']);

          $this->utility->cancel_trans('t_po_sum', $_POST['id']);

          $this->db->where('cl',$this->sd['cl']);
          $this->db->where('bc',$this->sd['branch']);
          $this->db->where('orderd_no',$_POST['id']);
          $this->db->update('t_req_det', array("orderd"=>0));    


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
            $sql = "SELECT m.code,
                           m.description,
                           m.model,
                           m.purchase_price,
                           q.qty 
                    FROM m_item m
                    LEFT JOIN qry_current_stock q ON q.`item` = m.`code`  
                    WHERE m.description LIKE '$_POST[search]%' 
                    OR m.code LIKE '$_POST[search]%' AND inactive='1' LIMIT 25";
            $query = $this->db->query($sql);
            $a = "<table id='item_list' style='width : 100%' >";
            $a .= "<thead><tr>";
            $a .= "<th class='tb_head_th'>Code</th>";
            $a .= "<th class='tb_head_th'>Item Name</th>";
            $a .= "<th class='tb_head_th'>Model</th>";
            $a .= "<th class='tb_head_th'>Current Qty</th>";
            $a .= "<th class='tb_head_th'>Price</th>";
            $a .= "</thead></tr>";

            $a .= "<tr class='cl'>";
            $a .= "<td>&nbsp;</td>";
            $a .= "<td>&nbsp;</td>";
            $a .= "<td>&nbsp;</td>";
            $a .= "<td>&nbsp;</td>";
            $a .= "<td>&nbsp;</td>";
            $a .= "</tr>";

                foreach($query->result() as $r){
                    $a .= "<tr class='cl'>";
                        $a .= "<td>".$r->code."</td>";
                        $a .= "<td>".$r->description."</td>";
                        $a .= "<td>".$r->model."</td>";
                        $a .= "<td>".$r->qty."</td>";
                        $a .= "<td>".$r->purchase_price."</td>";
                    $a .= "</tr>";
                }
            $a .= "</table>";
            echo $a;
        }

         public function get_item(){
            $sql = "SELECT m.code,
                           m.description,
                           m.model,
                           m.purchase_price,
                           q.qty 
                    FROM m_item m
                    LEFT JOIN qry_current_stock q ON q.`item` = m.`code`  
                    WHERE  m.code ='".$_POST['code']."'
                    LIMIT 25";
            $query = $this->db->query($sql);
            if($query->num_rows() > 0){
                $data['a']=$query->result();
            }else{
                $data['a']=2;
            }
            
            echo json_encode($data);
        }


  function load_request_note(){
          $supplier=$this->input->post("supplier");
          // $sql="SELECT
          //    m_item.`description`,
          //    m_item.`model`,
          //    m_item.`purchase_price`,
          //   `t_req_det`.`Item`,
          //    t_req_det.`nNo`,
          //    t_req_det.`Cur_Qty`,
          //    t_req_det.`Approve_Qty`,
          //    t_req_det.`Approve_Qty`*m_item.`purchase_price` AS total
          //    FROM `t_req_det` 
          //    JOIN m_item ON m_item.`code`=t_req_det.`Item`
          //    WHERE `t_req_det`.`nNo` 
          //    IN (SELECT `t_req_sum`.`nNo` FROM `t_req_sum` WHERE `t_req_sum`.`Approved`='1' AND t_req_sum.`Orderd`='0'
          //    AND cl='".$this->sd['cl']."' AND bc='".$this->sd['branch']."' AND `t_req_det`.`Supplier`='". $supplier."')
          //    AND cl='".$this->sd['cl']."' AND bc='".$this->sd['branch']."'
          // ";

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
   
          if($query->num_rows>0)
          {
            $a['det']=$query->result();
            echo json_encode($a);
          }
          else
          {

            $a['det']=2;
            echo json_encode($a);
             
          }
          
          
        }

        
}