<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class r_credit_card_rate extends CI_Model {
    
    private $sd;
    private $mtb;
    
    private $mod = '003';
    
    function __construct(){
    parent::__construct();
    
    $this->sd = $this->session->all_userdata();
    $this->load->database($this->sd['db'], true);
    $this->mtb = $this->tables->tb['r_credit_card_rate'];
    $this->load->model('user_permissions');
    $this->max_no=$this->utility->get_max_no("r_credit_card_rate", "nno"); 
    }
    
    public function base_details(){
    $a['max_no'] = $this->utility->get_max_no("r_credit_card_rate", "nno");    
    $a['table_data'] = $this->get_data_table();
    return $a;
    }

    
    
    public function data_table(){
        $this->load->library('table');
        $this->load->library('useclass');
        
        $this->table->set_template($this->useclass->grid_style());
        
        $nno = array("data"=>"No", "style"=>"width: 60px; cursor : pointer;");
        $terminal_id = array("data"=>"Terminal ID", "style"=>"cursor : pointer;");
        $action = array("data"=>"Action", "style"=>"width: 60px;");
    
        $this->table->set_heading($nno,$terminal_id,$action);//
       
        if(isset($_POST['is_src'])){
            $term = $_POST['code'];
            $sql = "SELECT * FROM r_credit_card_rate WHERE cl = '".$this->sd['cl']."' AND bc ='".$this->sd['branch']."' AND (nno LIKE '%$term%' OR terminal_id LIKE '%$term%') GROUP BY terminal_id LIMIT 10";
        }
        else{
            $sql = "SELECT * FROM r_credit_card_rate WHERE cl = '".$this->sd['cl']."' AND bc ='".$this->sd['branch']."' GROUP BY terminal_id LIMIT 10";
        }
            $query = $this->db->query($sql);
        
        
        foreach($query->result() as $r){
            $but = "<img src='".base_url()."img/edit.gif' onclick='set_edit(\"".$r->terminal_id."\")' title='Edit' />&nbsp;&nbsp;";
            if($this->user_permissions->is_delete('r_area')){$but .= "<img src='".base_url()."img/delete.gif' onclick='set_delete(\"".$r->terminal_id."\")' title='Delete' />";}
        
            $ed = array("data"=>$but, "style"=>"text-align: center; width: 68px;");
            $nno = array("data"=>$this->useclass->limit_text($r->nno, 20), "style"=>"text-align: left;  width: 158px;");
            $terminal_id = array("data"=>$this->useclass->limit_text($r->terminal_id, 20), "style"=>"text-align: left;  width: 158px;");
            
            $this->table->add_row($nno,$terminal_id,$ed);//
        } 
        
        if(isset($_POST['is_src'])){
            echo $this->table->generate();
        }
        else{
            return $this->table->generate();
        }
        
    }
    
    public function save(){
        $this->db->trans_begin();
        error_reporting(E_ALL); 
        function exceptionThrower($type, $errMsg, $errFile, $errLine) { 
            throw new Exception($errMsg); 
        }
        set_error_handler('exceptionThrower'); 
        try {
            if($this->user_permissions->is_add('r_credit_card_rate')){
                for($x=0;$x<12;$x++){
                    if(isset($_POST['act_'.$x])){
                        $tick =1;   
                    }else{
                        $tick =0; 
                    }
                    if(isset($_POST['rate_'.$x],$_POST['month_'.$x]) && !empty($_POST['rate_'.$x]) && !empty($_POST['acc_'.$x])){
                        
                    $r_credit_card_rate[]=array(                        
                        "cl"=>$this->sd['cl'],
                        "bc"=>$this->sd['branch'],
                        "ddate"=>$_POST['date'],
                        "nno"=>$_POST['id'],
                        "terminal_id"=>strtoupper($_POST['terminal_id']),
                        "bank_id"=>$_POST['bank_id'],
                        "month"=>$_POST['month_'.$x],
                        "rate"=>$_POST['rate_'.$x],
                        "acc_no"=>$_POST['acc_'.$x],
                        "merchant_id"=>$_POST['merchant_id_'.$x],
                        "oc"=>$this->sd['oc'],
                        "ddate"=>$_POST['date'],
                        "is_inactive" =>$tick,
                        "ddate"=>$_POST['date'],
                        );
                   }
                }

                if($_POST['code_'] == "0" || $_POST['code_'] == ""){  

                    if(isset($r_credit_card_rate)){if(count($r_credit_card_rate)){$this->db->insert_batch("r_credit_card_rate",$r_credit_card_rate);}}
                    echo $this->db->trans_commit();
                }else{
                    for ($i=0; $i <11 ; $i++) { 
                        if(isset($_POST['rate_'.$i],$_POST['merchant_id_'.$i]) && !empty($_POST['merchant_id_'.$i]) && !empty($_POST['acc_'.$i])){
                        $check_exsist = $this->is_exist($_POST['terminal_id'],$_POST['merchant_id_'.$i]);
                        if($check_exsist==1){
                            if(isset($_POST['act_'.$i])){$tick =1;}else{$tick =0;}

                            $r_credit_card_rate_update=array(                        
                                "cl"=>$this->sd['cl'],
                                "bc"=>$this->sd['branch'],
                                "ddate"=>$_POST['date'],
                                "nno"=>$_POST['id'],
                                "terminal_id"=>strtoupper($_POST['terminal_id']),
                                "bank_id"=>$_POST['bank_id'],
                                "month"=>$_POST['month_'.$i],
                                "rate"=>$_POST['rate_'.$i],
                                "acc_no"=>$_POST['acc_'.$i],
                                "merchant_id"=>$_POST['merchant_id_'.$i],
                                "oc"=>$this->sd['oc'],
                                "ddate"=>$_POST['date'],
                                "is_inactive" =>$tick,
                                "ddate"=>$_POST['date'],
                            );
                            $this->db->where("terminal_id", $_POST['terminal_id']);
                            $this->db->where("merchant_id", $_POST['merchant_id_'.$i]);
                            $this->db->where('cl', $this->sd['cl']);
                            $this->db->where('bc', $this->sd['branch']);
                            $this->db->update('r_credit_card_rate',$r_credit_card_rate_update);
                        }else{
                            $r_credit_card_rate_update=array(                        
                                "cl"=>$this->sd['cl'],
                                "bc"=>$this->sd['branch'],
                                "ddate"=>$_POST['date'],
                                "nno"=>$_POST['id'],
                                "terminal_id"=>strtoupper($_POST['terminal_id']),
                                "bank_id"=>$_POST['bank_id'],
                                "month"=>$_POST['month_'.$i],
                                "rate"=>$_POST['rate_'.$i],
                                "acc_no"=>$_POST['acc_'.$i],
                                "merchant_id"=>$_POST['merchant_id_'.$i],
                                "oc"=>$this->sd['oc'],
                                "ddate"=>$_POST['date'],
                                "is_inactive" =>$tick,
                                "ddate"=>$_POST['date'],
                            );

                            $this->db->insert('r_credit_card_rate',$r_credit_card_rate_update);

                        }    
                    }
                }    
                echo $this->db->trans_commit();
                }
            }else{
                echo "No permission to save records";
                $this->db->trans_commit();
            }    
        }catch(Exception $e){ 
        $this->db->trans_rollback();
        echo $e->getMessage()."Operation fail please contact admin"; 
        } 
    }
    
    public function is_exist($terminal,$merchant){
        $sql=" SELECT * 
                FROM r_credit_card_rate
                WHERE cl='".$this->sd['cl']."'
                AND bc='".$this->sd['branch']."'
                AND terminal_id = '$terminal'
                AND merchant_id = '$merchant'";
        $query=$this->db->query($sql);

        if($query->num_rows()>0){
            $result = 1;
        }else{
            $result = 2;
        }
        return $result;
    }

    public function load(){

        $terminal_id=$_POST['code'];    
        $sql="SELECT c.nno, 
                    c.month,
                    c.rate,
                    c.merchant_id,
                    c.acc_no,
                    a.description AS acc_des,
                    c.terminal_id,
                    c.bank_id, 
                    b.description AS b_des, 
                    c.ddate,
                    c.is_inactive
                 FROM r_credit_card_rate c
                JOIN m_bank b ON c.bank_id = b.CODE 
                JOIN m_account a ON c.acc_no = a.code 
                WHERE c.terminal_id = '$terminal_id' 
                    AND cl = '".$this->sd['cl']."' 
                    AND bc ='".$this->sd['branch']."'
                ORDER BY auto_no ";    

        $query=$this->db->query($sql);
           
        if($query->num_rows()>0){
          $a['card_rate']=$query->result();
        }else{
          $a['card_rate']=2;
        }
        echo json_encode($a);
    } 
    public function get_data_table(){
    return $this->data_table();
    }

    public function delete(){
        $this->db->trans_begin();
        error_reporting(E_ALL); 
        function exceptionThrower($type, $errMsg, $errFile, $errLine) { 
            throw new Exception($errMsg); 
        }
        set_error_handler('exceptionThrower'); 
        try {
            if($this->user_permissions->is_delete('r_credit_card_rate')){
                $this->db->where('terminal_id', $_POST['code']);
                $this->db->where('cl', $this->sd['cl']);
                $this->db->where('bc', $this->sd['branch']);   
                $this->db->delete("r_credit_card_rate");     
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

   public function PDF_report(){

    $this->db->select(array('name', 'address', 'tp', 'fax', 'email'));
    $this->db->where("cl", $this->sd['cl']);
    $this->db->where("bc", $this->sd['branch']);
    $r_detail['branch'] = $this->db->get('m_branch')->result();
     
      $this->db->where("nno",$_POST['qno']);
      $this->db->where("cl",$this->sd['cl']);
      $this->db->where("bc",$this->sd['branch']);     
      $query= $this->db->get('r_credit_card_rate'); 
      
      $card_number= $this->utility->invoice_format($_POST['qno']);
      $session_array = array(
           $this->sd['cl'],
           $this->sd['branch'],
           $card_number
      );

      $r_detail['session'] = $session_array;
    
      $r_detail['qno']=$_POST['qno'];
      $r_detail['page']=$_POST['page'];
      $r_detail['header']=$_POST['header'];
      $r_detail['orientation']=$_POST['orientation'];
      $r_detail['type']=$_POST['type'];
      $r_detail['terminal_id_h']=$_POST['terminal_id_h'];

    
     $sql="SELECT c.nno, 
                    c.month,
                    c.rate,
                    c.merchant_id,
                    c.acc_no,
                    a.description AS acc_des,
                    c.terminal_id,
                    c.bank_id, 
                    b.description AS b_des, 
                    c.ddate
                 FROM r_credit_card_rate c
                JOIN m_bank b ON c.bank_id = b.CODE 
                JOIN m_account a ON c.acc_no = a.code 
                WHERE c.terminal_id ='".$_POST['terminal_id_h']."' 
                    AND cl = '".$this->sd['cl']."' 
                    AND bc ='".$this->sd['branch']."'";
    
          
        $r_detail['credit_card']=$this->db->query($sql)->result();

         $this->load->view($_POST['by'].'_'.'pdf',$r_detail);

    }
  
    public function check_termianl(){
        $sql="SELECT * 
                FROM r_credit_card_rate
                WHERE cl='".$this->sd['cl']."'
                AND bc='".$this->sd['branch']."'
                AND terminal_id = '".$_POST['code']."' ";
        $query = $this->db->query($sql);

        if($query->num_rows()>0){
            $status=1;
        }else{
            $status=2;
        }
        echo $status;
    }

}