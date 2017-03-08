<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class r_general_report extends CI_Model {

    private $tb_items;
    private $tb_storse;
    private $tb_department;
    private $sd;
    private $w = 297;
    private $h = 210;
    
    function __construct(){
        parent::__construct();
        
        $this->load->database();
        $this->load->library('useclass');
        
        $this->sd = $this->session->all_userdata();
        $this->load->database($this->sd['db'], true);

        $this->tb_items = $this->tables->tb['m_items'];
        $this->tb_storse = $this->tables->tb['m_stores'];
    }
    
    public function base_details(){
    	$this->load->model('m_stores');
    	$this->load->model('m_branch');
    	$a['cluster']=$this->get_cluster_name();
        $a['d_cl']=$this->sd['cl'];
        $a['d_bc']=$this->sd['branch'];
        return $a;
    }


    public function get_cluster_name(){
      $sql="  SELECT `code`,description 
      FROM m_cluster m
      JOIN u_branch_to_user u ON u.cl = m.code
      WHERE user_id='".$this->sd['oc']."'
      GROUP BY m.code";
      $query=$this->db->query($sql);

      $s = "";
      $s .= "<div>";
        $s .= '<input id="0" type="radio" class="cl" name="cluster" title="0" checked>';
        $s .= '<label for="0"> No Filteration</label>';
        $s .= "</div>";
      foreach($query->result() as $r){
        $s .= "<div>";
        $s .= '<input id="'.$r->code.'" type="radio" class="cl" name="cluster" title="'.$r->code.'" >';
        $s .= '<label for="'.$r->code.'">'.$r->code.' - '.$r->description.'</label>';
        $s .= "</div>";
    }
    return $s;
}


public function get_branch_name(){
  $sql="  SELECT m.`bc`,name 
                FROM m_branch m
                JOIN u_branch_to_user u ON u.bc = m.bc
                WHERE user_id='".$this->sd['oc']."' AND m.cl='".$_POST['cluster']."'
                GROUP BY m.bc";
        $query=$this->db->query($sql);

  $s = "";
  $s .= "<div>";
    $s .= '<input id="0" type="radio" name="branch" class="bc" value="0" title="0" >';
    $s .= '<label for="0"> No Filteration</label>';
    $s .= "</div>";
  foreach($query->result() as $r){
    $s .= "<div>";
    $s .= '<input id="'.$r->bc.'" type="radio" name="branch" class="bc" value="'.$r->bc.'" title="'.$r->bc.'" >';
    $s .= '<label for="'.$r->bc.'">'.$r->bc.' - '.$r->name.'</label>';
    $s .= "</div>";
}

echo $s;

}

public function get_stores(){
  $this->db->select(array('code','description'));
    if(isset($_POST['cluster'])){
      $this->db->where("cl",$_POST['cluster']);
    }
    if(isset($_POST['branch']) && $_POST['branch'] != '0'){
      $this->db->where("bc",$_POST['branch']);
    }
    
    
    $query = $this->db->get('m_stores');

  $s = "";
  foreach($query->result() as $r){
    $s .= "<div>";
    $s .= '<input id="'.$r->code.'" type="checkbox" name="stores" class="st" title="'.$r->code.'" value="'.$r->code.'">';
    $s .= '<label for="'.$r->code.'">'.$r->code.' - '.$r->description.'</label>';
    $s .= "</div>";
}

echo $s;

}





}	
?>