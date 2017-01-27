<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class r_bank_entry extends CI_Model {
    
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
    	$a['branch']=$this->get_branch_name();
    	$a['stores']=$this->get_stores();
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

		$s = "<select name='cluster' id='cluster' >";
        $s .= "<option value='0'>---</option>";
        foreach($query->result() as $r){
            $s .= "<option title='".$r->description."' value='".$r->code."'>".$r->code.'-'.$r->description."</option>";
	    }
        $s .= "</select>";
        
        return $s;
    }


    public function get_branch_name(){
		$this->db->select(array('bc','name'));
		$query = $this->db->get('m_branch');

		$s = "<select name='branch' id='branch' >";
        $s .= "<option value='0'>---</option>";
        foreach($query->result() as $r){
            $s .= "<option title='".$r->name."' value='".$r->bc."'>".$r->bc.'-'.$r->name."</option>";
	    }
        $s .= "</select>";
        
        return $s;

    }

    public function get_branch_name2(){
        $sql="  SELECT m.`bc`,name 
                FROM m_branch m
                JOIN u_branch_to_user u ON u.bc = m.bc
                WHERE user_id='".$this->sd['oc']."' AND m.cl='".$_POST['cl']."'
                GROUP BY m.bc";
        $query=$this->db->query($sql);

        $s = "<select name='branch' id='branch' >";
        $s .= "<option value='0'>---</option>";
        foreach($query->result() as $r){
            $s .= "<option title='".$r->name."' value='".$r->bc."'>".$r->bc.'-'.$r->name."</option>";
        }
        $s .= "</select>";
        
        echo $s;
    }

    public function get_branch_name3(){
        $sql="  SELECT m.`bc`,name 
                FROM m_branch m
                JOIN u_branch_to_user u ON u.bc = m.bc
                WHERE user_id='".$this->sd['oc']."'
                GROUP BY m.bc";
        $query=$this->db->query($sql);

        $s = "<select name='branch' id='branch' >";
        $s .= "<option value='0'>---</option>";
        foreach($query->result() as $r){
            $s .= "<option title='".$r->name."' value='".$r->bc."'>".$r->bc.'-'.$r->name."</option>";
        }
        $s .= "</select>";
        
        echo $s;
    }


  public function get_stores(){
		$this->db->select(array('code','description'));
		$query = $this->db->get('m_stores');

		$s = "<select name='store' id='store' >";
        $s .= "<option value='0'>---</option>";
        foreach($query->result() as $r){
            $s .= "<option title='".$r->description."' value='".$r->code."'>".$r->code.'-'.$r->description."</option>";
	    }
        $s .= "</select>";
        
        return $s;

    }



    public function account_type(){
        $this->db->like('code', $_GET['q']);
        $this->db->or_like('heading', $_GET['q']);
        $query = $this->db->select(array('code','heading'))->get("m_account_type");
        $abc = "";
        foreach($query->result() as $r){
            $abc .= $r->code."|".$r->heading;
        $abc .= "\n";
        }
        echo $abc;
    } 


    public function trans_type(){
        $this->db->like('code', $_GET['q']);
        $this->db->or_like('description', $_GET['q']);
        $query = $this->db->select(array('code','description'))->get("t_trans_code");
        $abc = "";
        foreach($query->result() as $r){
            $abc .= $r->code."|".ucwords(strtolower($r->description));
        $abc .= "\n";
        }
        echo $abc;
    }


    public function auto_com(){
        $this->db->like('code', $_GET['q']);
        $this->db->or_like('description', $_GET['q']);
        $query = $this->db->select(array('code','description'))->get('m_account');
        $abc = "";
            foreach($query->result() as $r){
                $abc .= $r->code."|".$r->description;
                $abc .= "\n";
            }
        echo $abc;
    }  
    
    public function acc_cat(){
        $this->db->like('code', $_GET['q']);
        $this->db->or_like('description', $_GET['q']);
        $query = $this->db->select(array('code','description'))->get('m_account_category');
        $abc = "";
            foreach($query->result() as $r){
                $abc .= $r->code."|".$r->description;
                $abc .= "\n";
            }
        echo $abc;
    }  
    
    public function cntrl_acc(){
        $this->db->like('code', $_GET['q']);
        $this->db->or_like('description', $_GET['q']);
        $this->db->where('is_control_acc','1');
        $query = $this->db->select(array('code','description'))->get('m_account');
        $abc = "";
            foreach($query->result() as $r){
                $abc .= $r->code."|".$r->description;
                $abc .= "\n";
            }
        echo $abc;
    } 


    public function get_account_det(){
        $this->db->select(array('m_account.code','m_account.description','m_account_type.heading as heading','m_account_type.code as type'));
        $this->db->where('m_account.code',$_POST['code']);
        $this->db->from('m_account');
        $this->db->join('m_account_type','m_account_type.code=m_account.type');
        $this->db->join('m_account_category','m_account_category.code=m_account.category');
        $query=$this->db->get();
          if($query->num_rows()>0){
            $a['acc']=$query->result();
          }else{
            $a['acc']=2;
          }
        echo json_encode($a);
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
                      BE.`nno`,
                      BE.`dDate`,
                      BE.`description`,
                      BE.`amount`,
                      BE.`draccId`,
                      BE.`craccId`,
                      BE.`type`,
                      dracc.description AS dracc_des,
                      cracc.description AS cracc_des
                      FROM t_bank_entry AS BE
                      INNER JOIN m_account AS dracc ON dracc.code = BE.draccId
                      INNER JOIN m_account AS cracc ON cracc.code = BE.craccId
                      WHERE BE.`dDate` BETWEEN '".$_POST['from']."' AND '".$_POST['to']."'";
        
        if(!empty($cluster))
        {
            $sql.=" AND BE.cl = '$cluster'";
        }
        if(!empty($branch))
        {
            $sql.=" AND BE.bc = '$branch'";
        } 
            
        $r_detail['r_bank_entry']=$this->db->query($sql)->result();    //pass as the variable in pdf page t_bank_entry_list



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