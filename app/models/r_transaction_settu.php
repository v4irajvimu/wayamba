<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class r_transaction_settu extends CI_Model {
    
    private $sd;
    private $mtb;
    private $mod = '003';
    private $max_no;
    
    function __construct(){
	parent::__construct();
	
	$this->sd = $this->session->all_userdata();
	$this->load->database($this->sd['db'], true);
	$this->load->model('user_permissions');
  
        

    }
    
    public function base_details(){

      
    }


public function f1_selection_list(){

     
    if($_POST['search'] == 'Key Word: code, name'){$_POST['search'] = "";}
     
    $sql = "SELECT  nno,c.`name` FROM t_settu_sum s JOIN m_customer c ON c.`code`=s.`organizer`  WHERE (nno LIKE '%$_POST[search]%' OR name LIKE '%$_POST[search]%' ) LIMIT 25";
     
      $query = $this->db->query($sql);
      $a  = "<table id='item_list' style='width : 100%' >";
      $a .= "<thead><tr>";
      $a .= "<th class='tb_head_th'>Seettu No</th>";
      $a .= "<th class='tb_head_th' colspan='2'>Organizer</th>";
      $a .= "</thead></tr><tr class='cl'><td>&nbsp;</td><td colspan='2'>&nbsp;</td></tr>";

    foreach($query->result() as $r){
      $a .= "<tr class='cl'>";
      $a .= "<td>".$r->nno."</td>";
      $a .= "<td>".$r->name."</td>";
      
      $a .= "</tr>";
    }
      $a .= "</table>";
      echo $a;
  }

   

}