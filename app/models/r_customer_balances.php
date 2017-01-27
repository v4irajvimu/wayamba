<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class r_customer_balances extends CI_Model {
    
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


		$this->db->select(array('code','description'));
		$this->db->where("cl",$this->sd['cl']);
		$this->db->where("bc",$this->sd['branch']);
		$this->db->where("code",$_POST['stores']);
		$r_detail['store_des']=$this->db->get('m_stores')->row()->description;

		$cl=$this->sd['cl'];
		$bc=$this->sd['branch'];

		$r_detail['store_code']=$_POST['stores'];	
		$r_detail['type']="r_customer_balances";        
		$r_detail['dd']=$_POST['dd'];
		$r_detail['qno']=$_POST['qno'];

		$r_detail['page']=$_POST['page'];
		$r_detail['header']=$_POST['header'];
		$r_detail['orientation']=$_POST['orientation'];
		$r_detail['from']=$_POST['from'];
		$r_detail['to']=$_POST['to'];
		$r_detail['supplier']=$_POST['supp'];

		$to=$_POST['to'];
		$from=$_POST['from'];
		
		$sql="SELECT m.`nic`,
					m.`name`,
					m.`tp`,
					SUM(t.`dr_amount` - t.`cr_amount`) AS balance 
			FROM m_customer m 
			LEFT JOIN t_account_trans t ON t.`acc_code` = m.`code` AND m.cl = t.`cl` AND m.bc = t.`bc`
			WHERE t.ddate <='$to'
			";

		if(!empty($_POST['cluster'])){
          $sql.=" AND t.`cl` = '".$_POST['cluster']."'";
        }if(!empty($_POST['branch'])){
          $sql.=" AND t.`bc` = '".$_POST['branch']."'";
        } 
        if(!empty($_POST['cus_id'])){
          $sql.=" AND m.`code` = '".$_POST['cus_id']."'";
        }  	

		$sql .="GROUP BY m.`code`";	
		
		$r_detail['item_det']=$this->db->query($sql)->result();	

        if($this->db->query($sql)->num_rows()>0)
        {
			$this->load->view($_POST['by'].'_'.'pdf',$r_detail);
		}
		else
		{
			echo "<script>alert('No Data');window.close();</script>";
		}



	}



}	
?>