<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class t_sup_job_ref_no extends CI_Model {

    function __construct(){
	parent::__construct();
	
	$this->sd = $this->session->all_userdata();
    $this->load->database($this->sd['db'], true);
	$this->mtb = $this->tables->tb['m_employee'];

    }


    public function base_details(){
		$a="";
    	//$this->load->model('m_branch');
    	$this->load->model('t_sup_job_ref_no');
    	$a['get_grid_det']=$this->get_grid_det(null,null);
    	//$a['cluster']=$this->get_cluster_name();
    	//$a['branch']=$this->get_branch_name();

    	return $a;
	}

	public function save(){

		$NoID=explode("_",$_POST['Upc']);
		$stpn=$_POST['Sjn'];
		$No=intval($NoID[1]);

		$data = array(
               'send_to_sup_no' => $stpn,
            );
		$this->db->where('nno', $No);
		$this->db->update('t_job', $data); 
		echo $this->db->affected_rows();
	}


	public function get_Su_data(){
		$code=$_POST['code'];
		$sid=$_POST['sid'];

		echo $this->get_grid_det($code,$sid);
	}


public function get_grid_det($code,$sid){

  $cl=$this->sd['cl'];
  $branch=$this->sd['branch'];
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
				    , tj.`send_to_sup_no`
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
        			WHERE
						tj.`cl` = '$cl'
						AND tj.`bc` = '$branch'";

		if($sid!=""){
			$sqll.=" AND tj.`supplier` = '$sid'";
		}
        if($code!=""){
        	$sqll.=" AND( tj.`nno` like '%$code%'  
        				OR tj.`inv_type` like '%$code%'
        				OR tj.`inv_no` like '%$code%'
        				OR tj.`item_code` like '%$code%'
        				OR tj.`Item_name` like '%$code%'
        				OR mc.`name` like '%$code%' 
        				OR tj.`cus_id` like '%$code%'         				       				
        				OR mi.`description` like '%$code%'
        				OR tj.`send_to_sup_no` like '%$code%')";
        	//$code
            //$sqll.=" AND tj.`cl` = '$cluster'";
        }

   
        $retVal=$this->db->query($sqll)->result();
      //  $r_detail['r_job_dt_gr']=$this->db->query($sqll_gr)->result();

               $retTb="";
               $x=0;
        if($this->db->query($sqll)->num_rows()>0){

			foreach ($retVal as $value) {
			//var_dump($value->cu_name);exit();
			$item = ($value->description=="") ? $value->Item_name : $value->description ;
				
				$retTb.="<tr ondblclick=onDclik('thId_".$value->nno."'); class='gridTr' id='thId_".$value->nno."'>";
                $retTb.="<td align='right'>".$value->nno."</td>";
                $retTb.="<td>".$value->inv_date."</td>";
                $retTb.="<td>".$value->inv_type."</td>";
                $retTb.="<td align='right'>".$value->inv_no."</td>";
                $retTb.="<td>".$value->item_code."</td>";
                $retTb.="<td>".$item."</td>";
                $retTb.="<td>".$value->cus_id."</td>";
                $retTb.="<td>".$value->cu_name."</td>";
                $retTb.="<td align='right'>".$value->advance_amount."</td>";
                $retTb.="<td align='right'>".$value->send_to_sup_no."</td>";

				$retTb.="</tr>";

				$x++;
			//echo $value['cu_name'];
			};
        	return $retTb;
		}
		else{
		 	echo "<script>set_msg('No Record Found');</script>";
		}


	}



}
