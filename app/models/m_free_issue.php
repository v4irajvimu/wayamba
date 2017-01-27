<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class m_free_issue extends CI_Model {

    private $sd;    
    private $mod = '003';

    function __construct() {
        parent::__construct();
        $this->sd = $this->session->all_userdata();
        $this->load->database($this->sd['db'], true);
        $this->load->model('user_permissions');  
        $this->max_no = $this->utility->get_max_no("m_item_free_po", "nno");      
    }

    public function base_details() {        
        $a['maxno'] = $this->utility->get_max_no("m_item_free_po", "nno");

        $a['code'] = $this->sd['cl'].$this->sd['branch'].$this->max_code();
        return $a;
    }  

    public function max_code(){
        $sql="SELECT LPAD(MAX(nno)+1,4,0) AS max_code FROM m_item_free_po
                WHERE cl='".$this->sd['cl']."' AND bc='".$this->sd['branch']."'";
        $result=$this->db->query($sql)->first_row()->max_code;

        return $result;
    }
   

    public function save(){
        $this->db->trans_begin();
        error_reporting(E_ALL); 
        function exceptionThrower($type, $errMsg, $errFile, $errLine) { 
            throw new Exception($errMsg); 
        }
        set_error_handler('exceptionThrower'); 
        try {

            if(isset($_POST['is_inactive'])){
                    $inactive="1";
                }else{
                    $inactive="0";
                }

            $sum = array(   
                "cl"            => $this->sd["cl"],
                "bc"            => $this->sd["branch"],                           
                "nno"           => $this->max_no,
                "code"          => $_POST['code'],
                "name"          => $_POST['c_name'],
                "dfrom"         => $_POST['date_from'],   
                "dto"           => $_POST['date_to'], 
                "date"          => $_POST['date'],
                "oc"            => $this->sd["oc"],
                "is_inactive"   => $inactive,                                                     
            );



            for ($x = 0; $x < 25; $x++) {
                if (isset($_POST['00_' . $x], $_POST['33_' . $x] )) {
                    if ($_POST['00_' . $x] != "" && $_POST['33_' . $x] != "") {
                        $det[] = array(     
                            "cl"      => $this->sd["cl"],
                            "bc"      => $this->sd["branch"],                            
                            "nno"     => $this->max_no,
                            "po_item" => $_POST['0_0'],
                            "po_qty"  => $_POST['3_0'],
                            "foc_item"=> $_POST['00_'.$x],   
                            "foc_qty" => $_POST['33_'.$x],                                                        
                        );
                    }
                }
            }

            if ($_POST['hid'] == "0" || $_POST['hid'] == "") {
                if($this->user_permissions->is_add('m_free_issue')){

                    $this->db->insert("m_item_free_po", $sum);

                    if (isset($det)) {
                        if (count($det)) {
                            $this->db->insert_batch("m_item_free_po_det", $det);
                        }
                    }
                    $this->utility->save_logger("SAVE",56,$this->max_no,$this->mod);
                    echo $this->db->trans_commit();
                }else{
                    $this->db->trans_commit();
                    echo "No permission to save records";
                }

            }else{
                if($this->user_permissions->is_edit('m_free_issue')){

                    $this->db->where("nno", $this->max_no);
                    $this->db->where("cl", $this->sd['cl']);
                    $this->db->where("bc", $this->sd['branch']);
                    $this->db->delete("m_item_free_po_det");

                    if (isset($det)) {
                        if (count($det)) {
                            $this->db->insert_batch("m_item_free_po_det", $det);
                        }
                    }

                    $this->db->where("cl", $this->sd['cl']);
                    $this->db->where("bc", $this->sd['branch']);
                    $this->db->where("nno", $this->max_no);
                    $this->db->update("m_item_free_po", $sum);

                    $this->utility->save_logger("EDIT",56,$this->max_no,$this->mod);
                    echo $this->db->trans_commit();
                }else{
                    $this->db->trans_commit();
                    echo "No permission to edit records";
                }
            }
        }catch(Exception $e){ 
            $this->db->trans_rollback();
            echo $e->getMessage()."Operation fail please contact admin"; 
        }   

    }

    public function delete() {
        $this->db->trans_begin();
        error_reporting(E_ALL); 
        function exceptionThrower($type, $errMsg, $errFile, $errLine) { 
            throw new Exception($errLine); 
        }
        set_error_handler('exceptionThrower'); 
        try {
            if($this->user_permissions->is_delete('m_free_issue')){
         
                  $data=array('is_cancel'=>'1');
                  $this->db->where('cl',$this->sd['cl']);
                  $this->db->where('bc',$this->sd['branch']);
                  $this->db->where('nno',$_POST['id']);
                  $this->db->update('m_item_free_po',$data);
                 
                  $this->utility->save_logger("CANCEL",56,$_POST['id'],$this->mod);
                  echo $this->db->trans_commit();
                }else{
                    $this->db->trans_commit();
                    echo "No permission to delete records";
                }  
        }catch(Exception $e){ 
            $this->db->trans_rollback();
            echo $e->getMessage()."Operation fail please contact admin"; 
        } 
    }
    
    public function load(){
        $bc = $this->sd['branch'];
        $cl = $this->sd['cl'];
        $nno = $_POST['no'];   

        $sql="SELECT * FROM m_item_free_po WHERE cl='$cl' AND bc='$bc' AND nno='$nno'";
        $query=$this->db->query($sql);

        $x = 0;

        if ($query->num_rows() > 0) {
            $a['sum'] = $query->result();
        } else {
            $x = 2;
        }


        $sql2="SELECT c.description as f_des,
                        c.model as f_mod,
                        d.description as i_des,
                        d.model as i_mod,
                        cl,
                        bc,
                        po_qty,
                        foc_qty,
                        po_item,
                        foc_item
               FROM m_item_free_po_det 
               LEFT JOIN m_item d on d.code = m_item_free_po_det.po_item
               LEFT JOIN m_item c on c.code = m_item_free_po_det.foc_item
               WHERE cl='$cl' AND bc='$bc' AND nno='$nno'";
        $query2=$this->db->query($sql2);

        if ($query2->num_rows() > 0) {
            $a['det'] = $query2->result();
        } else {
            $x = 2;
        }


        if ($x == 0) {
            echo json_encode($a);
        } else {
            echo json_encode($x);
        }
    }

    public function foc_sale_list(){
    
        if($_POST['search'] == 'Key Word: code, name'){$_POST['search'] = "";}               

        $cl=$this->sd['cl'];
        $bc=$this->sd['branch'];
       
         $sql="SELECT * FROM m_item_free_po WHERE cl='$cl' AND bc='$bc'AND
            (`m_item_free_po`.`code` LIKE '%$_POST[search]%' OR 
            `m_item_free_po`.`name` LIKE '%$_POST[search]%' OR
            `m_item_free_po`.`nno` LIKE '%$_POST[search]%') 
            ORDER BY nno asc             
            limit 25";    
     
        $query=$this->db->query($sql);
             $a = "<table id='item_list' style='width : 100%' >";
            $a .= "<thead><tr>";
            $a .= "<th class='tb_head_th'>No</th>";
            $a .= "<th class='tb_head_th'>Code</th>";
            $a .= "<th class='tb_head_th'>Description</th>";

            $a .= "</thead></tr>";
            $a .= "<tr class='cl'>";
            $a .= "<td>&nbsp;</td>";
            $a .= "<td>&nbsp;</td>";
            $a .= "<td>&nbsp;</td>";
            $a .= "</tr>";
            
            foreach($query->result() as $r){
                    $a .= "<tr class='cl'>";
                    $a .= "<td>".$r->nno."</td>";
                    $a .= "<td>".$r->code."</td>";
                    $a .= "<td>".$r->name."</td>";                   
                $a .= "</tr>";
            }
        $a .= "</table>";
        echo $a;
    }


    public function item_list_all(){
    
        if($_POST['search'] == 'Key Word: code, name'){$_POST['search'] = "";}               

        $cl=$this->sd['cl'];
        $bc=$this->sd['branch'];
       
         $sql="SELECT *
               FROM `m_item`                
               WHERE (`m_item`.`code` LIKE '%$_POST[search]%' OR 
                        `m_item`.`min_price` LIKE '%$_POST[search]%'  OR 
                        `m_item`.`max_price` LIKE '%$_POST[search]%' OR 
                        `m_item`.`description`  LIKE '%$_POST[search]%' )
                    AND inactive='0'                    
               GROUP BY m_item.code
               limit 25";    
     
        $query=$this->db->query($sql);
             $a = "<table id='item_list' style='width : 100%' >";
            $a .= "<thead><tr>";
            $a .= "<th class='tb_head_th'>Code</th>";
            $a .= "<th class='tb_head_th'>Description</th>";
            $a .= "<th class='tb_head_th'>Model</th>";
            $a .= "<th class='tb_head_th'>Purchase Price</th>";
            $a .= "<th class='tb_head_th'>Last Price</th>";
            $a .= "<th class='tb_head_th'>Max Price</th>";
         

            $a .= "</thead></tr>";
            $a .= "<tr class='cl'>";
            $a .= "<td>&nbsp;</td>";
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
                    $a .= "<td>".$r->purchase_price."</td>";
                    $a .= "<td>".$r->min_price."</td>";
                    $a .= "<td>".$r->max_price."</td>";                   
                $a .= "</tr>";
            }
        $a .= "</table>";
        echo $a;
    }



}
