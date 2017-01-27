<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class r_total_sale_emp extends CI_Model 
{
    
    private $sd;
    private $w = 210;
    private $h = 297;
    
	private $mtb;
    private $tb_client;
    private $tb_branch;
   
    function __construct()
	{
        parent::__construct();
        $this->sd = $this->session->all_userdata();
        $this->load->database($this->sd['db'], true);
    }
    
    public function base_details()
	{
    	$this->load->model('r_sales_category');
        $a['sales_category'] = $this->r_sales_category->select();	
        $a['cluster']=$this->get_cluster_name();
        //$a['branch']=$this->get_branch_name();
		return $a;
       
        
    }

    public function get_cluster_name(){
        $sql="  SELECT `code`,description 
                FROM m_cluster m
                JOIN u_branch_to_user u ON u.cl = m.code
                WHERE user_id='".$this->sd['oc']."'
                GROUP BY m.code";
        $query=$this->db->query($sql);
  
        $s = "<select name='cluster' id='cluster' style='width:179px;'>";
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

        $s = "<select name='branch' id='branch' style='width:179px;'>";
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

        $s = "<select name='branch' id='branch' style='width:179px;'>";
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

        $s = "<select name='branch' id='branch' style='width:179px;'>";
        $s .= "<option value='0'>---</option>";
        foreach($query->result() as $r){
            $s .= "<option title='".$r->name."' value='".$r->bc."'>".$r->bc.'-'.$r->name."</option>";
        }
        $s .= "</select>";
        echo $s;
    }
	
	public function PDF_report(){
        
		$r_detail['type']=$_POST['type'];
		$r_detail['page']=$_POST['page'];
		$r_detail['header']=$_POST['header'];
		$r_detail['orientation']="L";
        $r_detail['type']="";
		$r_detail['to']=$_POST['to'];
		$r_detail['from']=$_POST['from'];
        $cluster=$_POST['cluster'];
        $branch =$_POST['branch'];
        $emp    =$_POST['emp'];
        $to_date=$_POST['to'];
        $f_date =$_POST['from'];
        $r_detail['cluster']=$_POST['cluster'];
        $r_detail['branchs']=$_POST['branch'];
        $r_detail['emp']=$_POST['emp'];
        $r_detail['emp_des']=$_POST['emp_des'];

        if(!empty($cluster)){
            $cl=" AND c.cl='$cluster'";
            $cl1=" AND t.cl='$cluster'";
        }else{
            $cl=" ";
            $cl1=" ";
        }

        if(!empty($branch)){
            $bc=" AND c.bc='$branch'";
            $bc1=" AND t.bc='$branch'";
        }else{
            $bc=" ";
            $bc1=" ";
        }


        if(!empty($emp)){
            $emp1=" AND c.rep='$emp'";
        }else{
            $emp1=" ";
        }

        if(!empty($emp)){
            $emp2=" AND t.rep='$emp'";
        }else{
            $emp2=" ";
        }


        $this->db->select(array('name','address','tp','fax','email'));
        $this->db->where("cl",$this->sd['cl']);
        $this->db->where("bc",$this->sd['branch']);
        $r_detail['branch']=$this->db->get('m_branch')->result();


        $this->db->select(array('description','code'));
        $this->db->where("code",$_POST['cluster']);
        $r_detail['clus']=$this->db->get('m_cluster')->result();

        $this->db->select(array('name','bc'));
        $this->db->where("bc",$_POST['branch']);
        $r_detail['bran']=$this->db->get('m_branch')->result();
			
	$sql="SELECT    CONCAT(t.bc,' - ',bb.name) AS bc,
                    t.rep,
                    CONCAT(t.rep,' - ',ee.name) AS emp_name,
                    t.ddate, 
                    IFNULL(cash_gross,0.00) AS cash_gross,
                    IFNULL(cash_dis+cash_deduct,0.00) AS cash_dis,
                    IFNULL(cash_net, 0.00) AS cash_net,
                    IFNULL(cash_add, 0.00) AS cash_add,
                    IFNULL(credit_gross,0.00) AS credit_gross,
                    IFNULL(credit_dis+credit_deduct,0.00) AS credit_dis,
                    IFNULL(credit_net,0.00) AS credit_net,
                    IFNULL(credit_add, 0.00) AS credit_add,
                    IFNULL(return_net,0.00) AS return_net,
                    (IFNULL(cash_net, 0.00)+IFNULL(credit_net,0.00))-IFNULL(return_net,0.00) AS total                     
                FROM(SELECT cl, bc, ddate,rep FROM t_cash_sales_sum
                        UNION ALL
                    SELECT cl, bc, ddate,rep FROM t_credit_sales_sum
                        UNION ALL
                    SELECT cl, bc, ddate,rep FROM t_sales_return_sum)t 
                LEFT JOIN (SELECT cl, bc, c.ddate,SUM(IFNULL(c.gross_amount,0)) AS cash_gross,SUM(IFNULL(c.discount_amount,0)) AS cash_dis ,SUM(IFNULL(c.net_amount,0)) AS cash_net,SUM(IFNULL(c.additional_add,0)) AS cash_add ,SUM(IFNULL(c.additional_deduct,0)) AS cash_deduct ,rep FROM t_cash_sales_sum c WHERE c.ddate BETWEEN '$f_date' AND '$to_date' AND is_cancel != '1' $cl $bc $emp1  GROUP BY cl, bc, c.rep) cs ON (t.cl=cs.cl) AND (t.bc=cs.bc) AND (cs.rep=t.rep)
                LEFT JOIN (SELECT cl, bc, c.ddate,SUM(IFNULL(c.gross_amount,0)) AS credit_gross, SUM(IFNULL(c.discount_amount,0))  AS credit_dis , SUM(IFNULL(c.net_amount,0)) AS credit_net, SUM(IFNULL(c.additional_add,0)) AS credit_add ,SUM(IFNULL(c.additional_deduct,0)) AS credit_deduct, rep  FROM t_credit_sales_sum c WHERE c.ddate BETWEEN '$f_date' AND '$to_date' AND is_cancel != '1' $cl $bc $emp1  GROUP BY cl, bc,c.rep) cr ON (t.cl=cr.cl) AND (t.bc=cr.bc) AND (cr.rep=t.rep)
                LEFT JOIN (SELECT cl, bc, c.ddate, SUM(IFNULL(c.net_amount,0)) AS return_net, rep FROM t_sales_return_sum c WHERE c.ddate BETWEEN '$f_date' AND '$to_date' $cl $bc $emp1   GROUP BY cl, bc,c.rep) rt ON (rt.cl=t.cl) AND (rt.bc=t.bc) AND (rt.rep=t.rep)
                LEFT JOIN m_employee ee ON ee.code=t.rep
                JOIN m_branch bb ON bb.bc=t.bc  
                WHERE t.ddate BETWEEN '$f_date' AND '$to_date' $cl1 $bc1 $emp2
                GROUP BY t.cl, t.bc, t.rep
                Having total>0 OR return_net>0
                ORDER BY t.bc, t.ddate ASC";
                
			//-------get additional amout table details

        /*$sql="SELECT  CONCAT(t.bc,' - ',bb.name) AS bc, 
                t.ddate, 
                IFNULL(cash_gross,0.00) AS cash_gross,
                IFNULL(cash_dis,0.00) AS cash_dis,
                IFNULL(cash_net, 0.00) AS cash_net,
                IFNULL(credit_gross,0.00) AS credit_gross,
                IFNULL(credit_dis,0.00) AS credit_dis,
                IFNULL(credit_net,0.00) AS credit_net,
                IFNULL(return_net,0.00) AS return_net,
                (IFNULL(cash_net, 0.00)+IFNULL(credit_net,0.00))-IFNULL(return_net,0.00) AS total
                 
            FROM    (SELECT cl,bc, ddate FROM t_cash_sales_sum 
                UNION ALL
                SELECT cl,bc, ddate FROM t_credit_sales_sum
                UNION ALL
                SELECT cl,bc, ddate FROM t_sales_return_sum
                GROUP BY bc)t 
            LEFT JOIN (SELECT c.bc, c.ddate, SUM(IFNULL(c.gross_amount, 0)) AS cash_gross, SUM(IFNULL(c.discount_amount, 0)+IFNULL(ai.amount,0)) AS cash_dis, SUM(IFNULL(c.net_amount, 0)) AS cash_net FROM t_cash_sales_sum c LEFT JOIN (SELECT  t.cl,t.bc, t.nno,SUM(CASE ai.`is_add` WHEN 0 THEN t.`amount`*-1 ELSE t.`amount` END) AS amount FROM t_cash_sales_additional_item t JOIN r_additional_item ai ON ai.`code`=t.`type` GROUP BY t.cl,t.bc, t.nno ) ai ON (ai.cl=c.cl) AND (ai.bc=c.bc) AND (ai.nno=c.nno)
                   WHERE c.cl = 'SE' AND c.bc = 'BG' AND c.ddate BETWEEN '2015-01-01' AND '2015-08-21' GROUP BY c.ddate ) cs ON cs.ddate=t.ddate 
            LEFT JOIN (SELECT c.bc, c.ddate, SUM(IFNULL(c.gross_amount, 0)) AS credit_gross, SUM(IFNULL(c.discount_amount, 0)+IFNULL(ai.amount,0)) AS credit_dis, SUM(IFNULL(c.net_amount, 0)) AS credit_net FROM t_credit_sales_sum c LEFT JOIN (SELECT  t.cl,t.bc, t.nno,SUM(CASE ai.`is_add` WHEN 0 THEN t.`amount`*-1 ELSE t.`amount` END) AS amount FROM t_credit_sales_additional_item t JOIN r_additional_item ai ON ai.`code`=t.`type` GROUP BY t.cl,t.bc, t.nno ) ai ON (ai.cl=c.cl) AND (ai.bc=c.bc) AND (ai.nno=c.nno)
                   WHERE c.cl = 'SE' AND c.bc = 'BG' AND c.ddate BETWEEN '2015-01-01' AND '2015-08-21' GROUP BY c.ddate ) cr ON cs.ddate=t.ddate 
            LEFT JOIN (SELECT bc, c.ddate, SUM(IFNULL(c.net_amount,0)) AS return_net FROM t_sales_return_sum c WHERE c.cl='SE' AND c.bc='BG' AND c.ddate BETWEEN '2015-01-01' AND '2015-08-21' GROUP BY c.ddate) rt ON rt.ddate=t.ddate 
            JOIN m_branch bb ON bb.bc=t.bc
            WHERE t.ddate BETWEEN '2015-01-01' AND '2015-08-22'
            GROUP BY t.ddate,t.bc   
            ORDER BY t.bc ASC";            */    

	        $data=$this->db->query($sql);  
			if($data->num_rows()>0){
				$r_detail['r_data']=$data->result();
                $r_detail['emp_data']=$data->result();
				$this->load->view($_POST['by'].'_'.'pdf',$r_detail);
		    }else{
				echo "<script>alert('No data found');close();</script>";
		    } 
		 
    }

    public function get_branch(){	
		$q = $this->db->select(array('code', 'name'))
		->where('code', $this->sd['bc'])
		->get($this->tb_branch);        
        $s = "<select name='bc' id='bc'>";
        //$s .= "<option value='0'>---</option>";
        foreach($q->result() as $r){
            $s .= "<option title='".$r->name."' value='".$r->code."'>".$r->code."-".$r->name."</option>";
        }
        $s .= "</select>";        
        return $s;
    }
























    public function get_loanNo()
    {
    	$q = $this->db->select(array('loan_no'))
		->where('bc', $this->sd['bc'])
		->get('t_loan_sum');
        
        $s = "<select name='loan_no' id='loan_no'>";
        $s .= "<option value='0'>---</option>";
        foreach($q->result() as $r)
        {
            $s .= "<option title='".$r->loan_no."' value='".$r->loan_no."'>".$r->loan_no."</option>";
        }
        $s .= "</select>";
        
        return $s;
    }

    public function get_all_branch()
    {
	
		$q = $this->db->select(array('code', 'name', ))
		
		->get($this->tb_branch);
        
        $s = "<select name='bc' id='bc'>";
        //$s .= "<option value='0'>---</option>";
        foreach($q->result() as $r)
        {
        	//echo $r->num_rows() ;
            $s .= "<option title='".$r->name."' value='".$r->code."'>".$r->code."-".$r->name."</option>";
        }
        $s .= "</select>";
        
      // $a['d'] = $s ;
        echo json_encode($s);
    
    }

    public function set_group()
     {
        
     	//echo $_POST['center'];
       // $query = $this->db->where("center_code", $_POST['center'])->get($this->tb_group);

	/*	$query ="SELECT 
					`m_group`.`code`, 
					`m_group`.`description`
FROM 
				  	 `m_group`
WHERE
m_group.center_code =  'KT001'
";
        
        $s = "<select name='group' id='group'>";
        $s .= "<option value='0'>---</option>";
        foreach($query->result() as $r){
            $s .= "<option title='".$r->description."' value='".$r->code."'>".$r->code."</option>";
        }
        $s .= "</select>";
        
        return $s;*/

        $qry = $this->db

            ->select(array("code","description"))
            ->where("center_code",$_POST['center'])
           // ->where("mem_no","KT000001")
            //->where("is_approved",1)
            ->get($this->tb_group);

        $op="<select name='group' id='group'>";
        $op .="<option value='0'>---</option>"; 
        foreach($qry->result() as $r){

            $op .="<option title='".$r->description."'value='".$r->code."'>".$r->code."-".$r->description."</option>"; 

        }
        

        echo $op;
    }

    public function select_center(){
        $query = $this->db->where("bc", $this->sd['bc'])->get($this->tb_center);
        
        $s = "<select name='center' id='center'>";
        $s .= "<option value='0'>---</option>";
        foreach($query->result() as $r){
            $s .= "<option title='".$r->description."' value='".$r->code."'>".$r->code."</option>";
        }
        $s .= "</select>";
        
        return $s;
    }
		
}
?>