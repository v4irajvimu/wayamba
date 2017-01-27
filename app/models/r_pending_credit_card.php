<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class r_pending_credit_card extends CI_Model {

		function __construct(){
        parent::__construct();
        
        $this->load->database();
        $this->load->library('useclass');
        
        $this->sd = $this->session->all_userdata();
		$this->load->database($this->sd['db'], true);
        
    }
    
    public function base_details(){
    	
    	$a['cluster']=$this->get_cluster_name();
    	$a['branch']=$this->get_branch_name();
    	$a['stores']=$this->get_stores();
    	return $a;
	}

	public function PDF_report(){

        $this->db->select(array('name','address','tp','fax','email'));
        $this->db->where("cl",$this->sd['cl']);
        $this->db->where("bc",$this->sd['branch']);
        $r_detail['branch']=$this->db->get('m_branch')->result();


        $cl=$this->sd['cl'];
        $bc=$this->sd['branch'];

        $r_detail['store_code']=$_POST['stores'];   
        $r_detail['type']=$_POST['type'];        
        $r_detail['dd']=$_POST['dd'];
        $r_detail['qno']=$_POST['qno'];

        $r_detail['page']=$_POST['page'];
        $r_detail['header']=$_POST['header'];
        $r_detail['orientation']="L";
        $r_detail['dfrom']=$_POST['from'];
        $r_detail['dto']=$_POST['to'];
        $r_detail['trans_code']=$_POST['t_type'];
        $r_detail['trans_code_des']=$_POST['t_type_des'];
        $r_detail['trans_no_from']=$_POST['t_range_from'];
        $r_detail['trans_no_to']=$_POST['t_range_to'];
        $cluster=$_POST['cluster'];
        $branch=$_POST['branch'];

        $sql="SELECT 
					description,
					amount,
					rate,
					int_amount,
					merchant_id,
					(amount - int_amount) AS balance,
					date
					FROM
					opt_credit_card_det 
					JOIN m_bank 
					ON m_bank.code = opt_credit_card_det.bank_id 
                    WHERE opt_credit_card_det.is_reconcil='0' AND opt_credit_card_det.`date` BETWEEN '".$_POST['from']."' AND '".$_POST['to']."' ";
        
        if(!empty($cluster))
        {
            $sql.=" AND opt_credit_card_det.cl = '$cluster'";
        }
        if(!empty($branch))
        {
            $sql.=" AND opt_credit_card_det.bc = '$branch'";
        } 
            
        $r_detail['r_pending_credit_card']=$this->db->query($sql)->result();    //pass as the variable in pdf page t_bank_entry_list



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