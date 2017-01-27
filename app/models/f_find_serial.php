

<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class f_find_serial extends CI_Model {
    
    private $sd;
    private $mtb;
    
    private $mod = '003';
    
    function __construct(){
    	parent::__construct();
	    $this->sd = $this->session->all_userdata();
        $this->load->database($this->sd['db'], true);
    }
    
    public function base_details(){

    }

  	private function set_delete(){
		$this->db->where("bc", $_POST['bc']);
		$this->db->delete("m_item_rol");
    }
    
    
    public function check_code(){
	$this->db->where('bc', $_POST['bc']);
	$this->db->limit(1);
	
	echo $this->db->get($this->mtb)->num_rows;
    }
    
    public function load(){
    	$this->db->select(array('m_item.code','m_item.model','m_item.description','m_item_rol.cl','m_item_rol.bc','m_item_rol.rol','m_item_rol.roq'));
        $this->db->join('m_item', 'm_item.code= m_item_rol.code');
        $this->db->where('bc', $_POST['bc']);
        $query=$this->db->get($this->mtb);
		$a['c'] = $query->result();	
		echo json_encode($a);
    }
    
    public function delete(){
    	$p = $this->user_permissions->get_permission($this->mod, array('is_delete'));
    	if($p->is_delete){
    	    $this->db->where('bc', $_POST['code']);
    	    $this->db->limit(1);
    	    
    	    echo $this->db->delete($this->mtb);
    	}else{
    	    echo 2;
    	}
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
    	$cl=$this->sd['cl'];
    	$bc=$this->sd['branch'];

        if($_POST['search'] == 'Key Word: code, name'){$_POST['search'] = "";}
               
        // $sql = "SELECT t_serial.`item`,t_serial.`serial_no`,t_serial.`batch`,t_serial.`available`,m_item.`description`,m_stores.`description` AS s_des FROM t_serial JOIN m_item ON m_item.code=t_serial.`item` JOIN m_stores ON m_stores.`code`=t_serial.`store_code` 
        // WHERE  t_serial.`item` LIKE '%$_POST[search]%' OR t_serial.`serial_no` LIKE '%$_POST[search]%' OR  m_item.`description` LIKE '%$_POST[search]%' LIMIT 25";
        
        $sql="SELECT t_item_movement.`item` as item,
					t_trans_code.`description` as trans_des,
					t_item_movement.`trans_no`as trans_no,
					t_item_movement.`ddate`,
					t_serial_movement.`serial_no`as serial_no,
					m_item.`description` as item_des

					FROM t_item_movement JOIN t_serial_movement ON t_item_movement.`item`=t_serial_movement.`item` AND 
					t_item_movement.`trans_code`=t_serial_movement.`trans_type` AND t_item_movement.`trans_no`=t_serial_movement.`trans_no`
					JOIN m_item ON m_item.`code` = t_item_movement.`item`
					JOIN t_trans_code ON t_trans_code.`code` = t_item_movement.`trans_code`
					WHERE m_item.`code` LIKE '%$_POST[search]%' OR m_item.`description` LIKE '%$_POST[search]%' OR t_serial_movement.`serial_no` LIKE '%$_POST[search]%'

                UNION ALL 

                SELECT t_item_movement.`item` as item,
						t_trans_code.`description` as trans_des,
						t_item_movement.`trans_no` as trans_no,
						t_item_movement.`ddate`,
						t_serial_movement_out.`serial_no` as serial_no,
						m_item.`description` as item_des

						FROM t_item_movement JOIN t_serial_movement_out ON t_item_movement.`item`=t_serial_movement_out.`item` AND 
						t_item_movement.`trans_code`=t_serial_movement_out.`trans_type` AND t_item_movement.`trans_no`=t_serial_movement_out.`trans_no`
               			JOIN m_item ON m_item.`code` = t_item_movement.`item`
               			JOIN t_trans_code ON t_trans_code.`code` = t_item_movement.`trans_code`
               			WHERE m_item.`code` LIKE '%$_POST[search]%' OR m_item.`description` LIKE '%$_POST[search]%' OR t_serial_movement_out.`serial_no` LIKE '%$_POST[search]%' LIMIT 50";


        $query = $this->db->query($sql);
        
        $a = "<table id='item_list' style='width : 100%' border='0'>";
        
       
            $x=0;
            foreach($query->result() as $r){

                    $a .= "<tr class='cl'>";
                    $a .= "<td ><input type='text' readonly='readonly' class='g_input_txt' name='0_".$x."' value='".$r->trans_des."' title='".$r->trans_des."' style='border:dotted 1px #ccc;background-color: #f9f9ec; width:120px;cursor:pointer;'/></td>";
                    $a .= "<td ><input type='text' readonly='readonly' class='g_input_num' name='1_".$x."' value='".$r->trans_no."' title='".$r->trans_no."' style='border:dotted 1px #ccc; background-color: #f9f9ec; width:80px; cursor:pointer;'/></td>";
                    $a .= "<td ><input type='text' readonly='readonly' class='g_input_txt' name='2_".$x."' value='".$r->ddate."' title='".$r->ddate."'  style='border:dotted 1px #ccc;background-color: #f9f9ec; cursor:pointer; width:100px;'/></td>";
                    $a .= "<td ><input type='text' readonly='readonly' class='g_input_txt' name='3_".$x."' value='".$r->item."' title='".$r->item."' style='border:dotted 1px #ccc;background-color: #f9f9ec; cursor:pointer;width:120px;'/></td>";
 

                    $a .= "<td ><input type='text' readonly='readonly' class='g_input_txt' name='4_".$x."' value='".$r->item_des."' title='".$r->item_des."' style='border:dotted 1px #ccc; background-color: #f9f9ec; cursor:pointer; width:200px;'/></td>";
                    $a .= "<td ><input type='text' readonly='readonly' class='g_input_num' name='5_".$x."' value='".$r->serial_no."' title='".$r->serial_no."' style='border:dotted 1px #ccc;background-color: #f9f9ec; cursor:pointer;width:100px;'/></td>";
                    $a .= "<td ><input type='text' readonly='readonly' class='g_input_num' name='6_".$x."' value='' title='' style='border:dotted 1px #ccc;background-color: #f9f9ec;  cursor:pointer;width:80px;'/></td>";
                    $a .= "<td ><input type='text' readonly='readonly' class='g_input_num' name='7_".$x."' value='' title='' style='border:dotted 1px #ccc;background-color: #f9f9ec; cursor:pointer;width:80px;'/></td>";

                   
                    $a .= "</tr>";
            $x++;
            }
        $a .= "</table>";
        
        echo $a;
    }


    public function get_branch(){
        $this->db->where("cl",$this->sd['cl']);
        $this->db->where("bc",$this->sd['branch']);   
        $result=$this->db->get("m_branch")->result_array();
        
        return $result; 
    }

    public function get_item(){
        $this->db->select(array('code','description','model','rol','roq'));
        $this->db->where("code",$this->input->post('code'));
        $this->db->limit(1);
        $query=$this->db->get('m_item');
        if($query->num_rows() > 0){
            $data['a']=$query->result();
        }else{
            $data['a']=2;
        }
        
        echo json_encode($data);
    }

    public function PDF_report(){

        $r_detail['type']=$_POST['type'];        
        $r_detail['dt']=$_POST['dt'];
        $r_detail['qno']=$_POST['qno'];

        $r_detail['page']=$_POST['page'];
        $r_detail['header']=$_POST['header'];
        $r_detail['orientation']=$_POST['orientation'];
        $r_detail['title']="SERIALS DETAILS";

        $r_detail['all_det']=$_POST;
        


        $this->db->select(array('name','address','tp','fax','email'));
        $this->db->where("cl",$this->sd['cl']);
        $this->db->where("bc",$this->sd['branch']);
        $r_detail['branch']=$this->db->get('m_branch')->result();


        $this->load->view($_POST['by'].'_'.'pdf',$r_detail);
    }

}