<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class r_item_sales extends CI_Model {
    
    private $tb_items;
    private $tb_main_cat;
    private $tb_sub_cat;
    private $sd;
    private $w = 210;
    private $h = 297;
    
    function __construct(){
        parent::__construct();
        
        $this->load->database();
        $this->load->library('useclass');
        
        $this->sd = $this->session->all_userdata();
	      $this->load->database($this->sd['db'], true);
	
       
    }
    
    public function base_details(){
      
    }
    
    public function PDF_report(){

    $this->db->select(array('name','address','tp','fax','email'));
    $this->db->where("cl",$this->sd['cl']);
    $this->db->where("bc",$this->sd['branch']);
    $r_detail['branch']=$this->db->get('m_branch')->result();
    $r_detail['page']=$_POST['page'];
    $r_detail['type']=$_POST['type']; 

    //////////////////

    $this->db->select(array('description','code'));
    $this->db->where("code",$_POST['cluster']);
    $r_detail['clus']=$this->db->get('m_cluster')->result();

    $this->db->select(array('name','bc'));
    $this->db->where("bc",$_POST['branch']);
    $r_detail['bran']=$this->db->get('m_branch')->result();

    $this->db->select(array('description','code'));
    $this->db->where("cl",$_POST['cluster']);
    $this->db->where("code",$_POST['store']);
    $r_detail['str']=$this->db->get('m_stores')->result();

    $this->db->select(array('description','code'));
    $this->db->where("code",$_POST['department']);
    $r_detail['dp']=$this->db->get('r_department')->result();

    $this->db->select(array('description','code'));
    $this->db->where("code",$_POST['main_category']);
    $r_detail['cat']=$this->db->get('r_category')->result();

    $this->db->select(array('description','code'));
    $this->db->where("code",$_POST['sub_category']);
    $r_detail['scat']=$this->db->get('r_sub_category')->result();

    $this->db->select(array('description','code'));
    $this->db->where("code",$_POST['item']);
    $r_detail['itm']=$this->db->get('m_item')->result();

    $this->db->select(array('description','code'));
    $this->db->where("code",$_POST['unit']);
    $r_detail['unt']=$this->db->get('r_unit')->result();

    $this->db->select(array('description','code'));
    $this->db->where("code",$_POST['brand']);
    $r_detail['brnd']=$this->db->get('r_brand')->result();

    $this->db->select(array('name','code'));
    $this->db->where("code",$_POST['supplier']);
    $r_detail['sup']=$this->db->get('m_supplier')->result();

    ///////

    $this->db->select(array('code','description'));
    $this->db->where("cl",$this->sd['cl']);
    $this->db->where("bc",$this->sd['branch']);
    $this->db->where("code",$_POST['stores']);
    $r_detail['store_des']=$this->db->get('m_stores')->row()->description;

    $cl=$this->sd['cl'];
    $bc=$this->sd['branch'];

    $r_detail['store_code']=$_POST['stores']; 
    $r_detail['type']=$_POST['type'];        
    $r_detail['dd']=$_POST['dd'];
    $r_detail['qno']=$_POST['qno'];

    $r_detail['page']=$_POST['page'];
    $r_detail['header']=$_POST['header'];
    $r_detail['orientation']="P";
    $r_detail['from']=$_POST['from'];
    $r_detail['to']=$_POST['to'];
    $r_detail['cluster']=$_POST['cluster'];
    $r_detail['branchs']=$_POST['branch'];
    $r_detail['store']=$_POST['store'];
    $r_detail['department']=$_POST['department'];
    $r_detail['main_category']=$_POST['main_category'];
    $r_detail['sub_category']=$_POST['sub_category'];
    $r_detail['item']=$_POST['item'];
    $r_detail['unit']=$_POST['unit'];
    $r_detail['brand']=$_POST['brand'];
    $r_detail['supplier']=$_POST['supplier'];
    $r_detail['act']=$_POST['act'];

    $to=$_POST['to'];
    $from=$_POST['from'];
    $cluster=$_POST['cluster'];
    $branch=$_POST['branch'];
    $store=$_POST['store'];
    $department=$_POST['department'];
    $main_category=$_POST['main_category'];
    $sub_category=$_POST['sub_category'];
    $item=$_POST['item'];
    $unit=$_POST['unit'];
    $brand=$_POST['brand'];
    $supplier=$_POST['supplier'];
    $act_in=$_POST['act'];

   
      $sql="SELECT m.`code`,
                  m.`description`,
                  m.`brand`,
                  m.`model`,
                  m.`max_price`,
                  m.`min_price`,
                  m.`purchase_price`,
                  c.`description` AS Category,
                  m.`department`,
                  d.`description` AS Department_Name 
            FROM  `m_item` m 
            LEFT JOIN `r_category` c  ON m.`main_category` = c.`code` 
            LEFT JOIN `r_department` d  ON m.`department` = d.`code` 
            WHERE m.code != ''";   
   

    if(!empty($department))
    {
      $sql.=" AND `m`.`department` = '$department'";
    }

    if(!empty($main_category))
    {
      $sql.=" AND `m`.`main_category` = '$main_category'";
    }

    if(!empty($sub_category))
    {
      $sql.=" AND `m`.`category` = '$sub_category'";
    }

    if(!empty($item))
    {
      $sql.=" AND `m`.`code` = '$item'";
    }

    if(!empty($unit))
    {
      $sql.=" AND `m`.`unit` = '$unit'";
    }

    if(!empty($brand))
    {
      $sql.=" AND `m`.`brand` = '$brand'";
    }

    if(!empty($supplier))
    {
      $sql.=" AND `m`.`supplier` = '$supplier'";
    }

    if($act_in!="3")
    {
      $sql.=" AND `m`.`inactive` = '$act_in'";
    }

    $sql.= " ORDER BY m.`code`";

    $r_detail['customer']=$this->db->query($sql)->result(); 

    if($this->db->query($sql)->num_rows()>0){
      $this->load->view($_POST['by'].'_'.'pdf',$r_detail);
    }else{
      echo "<script>alert('No Data');window.close();</script>";
    }
    
  }
}
?>