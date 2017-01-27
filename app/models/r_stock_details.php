<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class r_stock_details extends CI_Model {
    
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
    $this->db->where("code",$this->sd['cl']);
    $r_detail['clus']=$this->db->get('m_cluster')->result();

    
    $this->db->select(array('name','bc'));
    $this->db->where("bc",$this->sd['branch']);
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
    $r_detail['orientation']="L";
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

    
      $sql="SELECT i.`code` , 
                   i.`description` , 
                   i.`model` , 
                   i.`roq`,
                   i.`rol` AS eoq,
                   IFNULL(o.OPB   ,0) AS OPB , 
                   IFNULL( g.GRN,0) AS GRN , 
                   IFNULL( cs.qty,0) AS CashSales,
                   IFNULL(cr.qty,0) AS CreditSales,
                   IFNULL(srn.qty,0) AS SalesReturn,
                   IFNULL(cls.qty,0) AS clossingStock,
                   i.`eoq` ,i.`buffer_stock`
            FROM `m_item` i 
            LEFT JOIN (SELECT m.`item` , SUM( m.`qty_in`) - SUM( m.`qty_out` ) AS OPB FROM  `t_item_movement` m     WHERE m.`cl`='$cl' AND m.`bc`='$bc'  AND m.`ddate`<'$to'   GROUP BY m.`item`)o ON i.`code`=o.item
            LEFT JOIN (SELECT m.`item` , SUM( m.`qty_in`)  AS GRN FROM `t_item_movement` m WHERE m.`trans_code`='3' AND  m.`cl`='$cl' AND m.`bc`='$bc'  AND (m.`ddate` BETWEEN '$from' AND '$to' ) GROUP BY m.`item`)  g ON i.`code`=g.item
            LEFT JOIN (SELECT m.`item` , SUM( m.`qty_out`)  AS qty FROM `t_item_movement` m WHERE m.`trans_code`='4' AND  m.`cl`='$cl' AND m.`bc`='$bc'  AND (m.`ddate` BETWEEN '$from' AND '$to' ) GROUP BY m.`item`)  cs ON i.`code`=cs.item
            LEFT JOIN (SELECT m.`item` , SUM( m.`qty_out`)  AS qty FROM `t_item_movement` m WHERE m.`trans_code`='5' AND  m.`cl`='$cl' AND m.`bc`='$bc'  AND (m.`ddate` BETWEEN '$from' AND '$to' ) GROUP BY m.`item`)  cr ON i.`code`=cr.item
            LEFT JOIN (SELECT m.`item` , SUM( m.`qty_In`)  AS qty FROM `t_item_movement` m WHERE m.`trans_code`='8' AND  m.`cl`='$cl' AND m.`bc`='$bc'  AND (m.`ddate` BETWEEN '$from' AND '$to' ) GROUP BY m.`item`)  srn ON i.`code`=srn.item
            LEFT JOIN (SELECT m.`item` , SUM( m.`qty_in`) - SUM( m.`qty_out` ) AS qty FROM  `t_item_movement` m     WHERE m.`cl`='$cl' AND m.`bc`='$bc'  AND m.`ddate`<'$to'   GROUP BY m.`item`) cls ON i.`code`=cls.item
    
      ";
   

  
    $r_detail['customer']=$this->db->query($sql)->result(); 

    if($this->db->query($sql)->num_rows()>0){
      $this->load->view($_POST['by'].'_'.'pdf',$r_detail);
    }else{
      echo "<script>alert('No Data');window.close();</script>";
    }
    
  }
}
?>