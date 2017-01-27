<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class r_stock_in_hand extends CI_Model {
    
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
    	$a['store_list']=$this->m_stores->select3();
    	$this->load->model('m_branch');
    	$a['branch']=$this->get_branch_name();
    	return $a;
	}


	public function get_branch_name(){
		$this->db->select('name');
		$this->db->where('bc',$this->sd['branch']);
		return $this->db->get('m_branch')->row()->name;
	}


	public function PDF_report(){
		$this->db->select(array('name','address','tp','fax','email'));
		$this->db->where("cl",$this->sd['cl']);
		$this->db->where("bc",$this->sd['branch']);
		$r_detail['branch']=$this->db->get('m_branch')->result();

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

		$this->db->select(array('name','code'));
		$this->db->where("code",$_POST['dealer_id']);
		if($_POST['load_type']==2){
			$this->db->where("is_guarantor","1");
			$r_detail['dealer']=$this->db->get('m_customer')->result();
		}else
		{
			//$this->db->where("is_guarantor","1");
			$r_detail['groupS']=$this->db->get('r_groups')->result();
		}
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
		$r_detail['orientation']=$_POST['orientation'];
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
		$dealer=$_POST['dealer_id'];

		/*
		$sql="SELECT m_item.`code`, 
					m_item.`description`,
					m_item.`model`,
					qry_current_stock.`qty`
			FROM 	m_item
			JOIN 	qry_current_stock ON qry_current_stock.`item`=m_item.`code` 

			WHERE 	qry_current_stock.`store_code`='$_POST[stores]'
					AND qry_current_stock.`cl`='$cl' AND qry_current_stock.bc='$bc'";
		*/


		$sql="SELECT m_item.`code`, 
					m_item.`description`,
					m_item.`model`,
					SUM(`t_item_movement`.`qty_in` - `t_item_movement`.`qty_out`) as qty,
					t_item_movement.`store_code`,
					m_item.`purchase_price`,
					m_item.`min_price`,
  					m_item.`max_price`
			FROM 	t_item_movement
			LEFT JOIN m_item ON t_item_movement.`item`=m_item.`code`
			WHERE 	t_item_movement.`ddate` <=  '".$to."' 
			";

		
		if(!empty($cluster))
		{
			$sql.=" AND `t_item_movement`.`cl` = '$cluster'";
		}
		
		if(!empty($branch))
		{
			$sql.=" AND `t_item_movement`.`bc` = '$branch'";
		}
		
		if(!empty($store))
		{
			$sql.=" AND `t_item_movement`.`store_code` = '$store'";
		}

		if(!empty($department))
		{
			$sql.=" AND `m_item`.`department` = '$department'";
		}

		if(!empty($main_category))
		{
			$sql.=" AND `m_item`.`main_category` = '$main_category'";
		}

		if(!empty($sub_category))
		{
			$sql.=" AND `m_item`.`category` = '$sub_category'";
		}

		if(!empty($item))
		{
			$sql.=" AND `m_item`.`code` = '$item'";
		}

		if(!empty($unit))
		{
			$sql.=" AND `m_item`.`unit` = '$unit'";
		}

		if(!empty($brand))
		{
			$sql.=" AND `m_item`.`brand` = '$brand'";
		}

		if(!empty($supplier))
		{
			$sql.=" AND `m_item`.`supplier` = '$supplier'";
		}

		if(!empty($dealer))
		{
			$sql.=" AND `t_item_movement`.`group_sale_id` = '$dealer'";
		}

		//$sql.= " GROUP BY t_item_movement.`item`, t_item_movement.`batch_no` ";
		$sql.= " GROUP BY t_item_movement.`item`";

		
		$r_detail['item_det']=$this->db->query($sql)->result();	


        if($this->db->query($sql)->num_rows()>0){
			$this->load->view($_POST['by'].'_'.'pdf',$r_detail);
		}else{
			echo "<script>alert('No Data');window.close();</script>";
		}
	}



}	
?>