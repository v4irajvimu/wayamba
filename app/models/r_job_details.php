<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class r_job_details extends CI_Model {

    function __construct(){
	parent::__construct();
	
	$this->sd = $this->session->all_userdata();
    $this->load->database($this->sd['db'], true);
    }


    public function base_details(){

    	$this->load->model('m_branch');
    	$a['cluster']=$this->get_cluster_name();
    	//$a['branch']=$this->get_branch_name();

    	return $a;
	}



	public function PDF_report(){

        $cluster=$_POST['cluster'];
        $branch=$_POST['branch'];


        $this->db->select(array('name','address','tp','fax','email'));
        $this->db->where("cl",$this->sd['cl']);
        $this->db->where("bc",$this->sd['branch']);
        $r_detail['branch']=$this->db->get('m_branch')->result();


       
        $sqll="SELECT
				    tj.`ddate`
				    , tj.`nno`
				    , tj.`type`
				    , tj.`inv_type`
				    , tj.`inv_no`
				    , tj.`inv_date`
				    , mc.`name` AS cu_name
				    , tj.`cus_id`
				    , tj.`Item_name`
				    , tj.`item_code`
				    , tj.`advance_amount`
				    , tj.`cl`
				    , tj.`bc`
				    , tj.`supplier`
    				, mi.`description`
    				, ms.`name` AS su_name
				FROM
				    `t_job` tj
				    INNER JOIN `m_customer` mc
				        ON (tj.`cus_id` = mc.`code`)
				    LEFT JOIN `m_item` mi
        				ON (tj.`item_code` = mi.`code`)
        			INNER JOIN `m_supplier` ms
        				ON (tj.`supplier` = ms.`code`)
				WHERE tj.`ddate`!='' 
               AND (tj.`ddate` BETWEEN '$_POST[from]' 
               AND '$_POST[to]')";

        if(!empty($cluster)||!($cluster==0)){
            $sqll.=" AND tj.`cl` = '$cluster'";
        }
        if(!empty($branch)||!($branch==0)){
            $sqll.=" AND tj.`bc` = '$branch'";
        }  
		
		 $sqll_gr= $sqll."GROUP BY tj.`supplier`";
   
        $r_detail['r_job_dt']=$this->db->query($sqll)->result();
        $r_detail['r_job_dt_gr']=$this->db->query($sqll_gr)->result();


		$cluster_q = $this->db->query("SELECT`description`FROM`m_cluster`WHERE (`code` = '$cluster');" )->result() ;
		$branch_q = $this->db->query("SELECT`name`FROM`m_branch`WHERE (`bc` = '$branch');" )->result() ;
 //var_dump($branch_q[0]->name);exit();



		$r_detail['clusterS']=$cluster_q[0]->description;
		$r_detail['branchS']=$branch_q[0]->name;


        $r_detail['page']='A4';
        $r_detail['orientation']='P';  
        $r_detail['dfrom']=$_POST['from'];
        $r_detail['dto']=$_POST['to'];


               
        if($this->db->query($sqll)->num_rows()>0){
			$this->load->view($_POST['by'] . '_' . 'pdf',$r_detail);
		}else{
		 	echo "<script>alert('No Data');window.close()</script>";
		}


	}



}