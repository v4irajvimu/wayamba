<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class add_serial extends CI_Model {

	private $sd;
	private $mtb;
	

	function __construct(){
		parent::__construct();
		$this->sd = $this->session->all_userdata();
		$this->load->database($this->sd['db'], true);
		$this->load->model('user_permissions');


	}

	public function base_details(){
		$a['brand'] = ''; 
		return $a;
	}

	public function serial_item_detials(){
		if($_POST['trans_code']=="43"){
	    $cl=$_POST['cl'];
	    $bc=$_POST['bc'];
	    $store=$_POST['v_stores'];
	  }else{
	    $cl=$this->sd['cl'];
	    $bc=$this->sd['branch'];
	    $store=$_POST['stores'];
	  }
		$serials = $_POST['data'];
		$sr_no = explode(",",$serials);

		$result['invalid']='';
		$result['all']='';
		$rr=$tt=array();


		for($x=0; $x<count($sr_no); $x++){
			
			if($_POST['trans_code']=='8'){
				$sql="SELECT available
                      FROM t_serial 
                      WHERE `cl`='$cl' AND `bc`='$bc'
                      AND out_doc='".$_POST['type']."'
                      AND out_no='".$_POST['type_no']."'
                      LIMIT 1";
			}else{
				$sql="SELECT available FROM t_serial 
							WHERE serial_no='".$sr_no[$x]."'
							AND cl='$cl' 
	            AND bc='$bc' 
	            AND store_code='$store'
	            AND available ='1'
	            LIMIT 1";
			}
			$query=$this->db->query($sql);
			if($query->num_rows()>0){

				$sql="SELECT  s.serial_no,
								s.`item`,
								i.`description` AS item_des,
								i.`model`,
								b.`batch_no`,
								b.`purchase_price`,
								b.`min_price`,
								b.`max_price`,
								q.`qty` AS cur_qty
							FROM t_serial s 
							JOIN m_item i ON s.`item` = i.`code`
							JOIN t_item_batch b ON s.`item` = b.`item` AND s.`batch` = b.`batch_no`
							JOIN qry_current_stock q ON q.cl=s.cl AND q.bc=s.bc AND q.`item`=s.`item` AND q.`batch_no`=s.`batch`  AND q.`store_code`='$store'
							WHERE s.serial_no='".$sr_no[$x]."'
							";
				$query=$this->db->query($sql);
				if($query->num_rows()>0){
					$rr[$x]=$query->result_array();
					$tt=array_merge($rr, $rr[$x]);
				}
			}else{
				$result['invalid'].=$sr_no[$x].", ";
			}
		}
		array_pop($tt);
		$result['all'] =$tt;
		echo json_encode($result);
	}





}


