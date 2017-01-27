<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class r_sales_order_sales extends CI_Model 
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
    }
    
    public function base_details()
  {

        $a['cluster']=$this->get_cluster_name();
        $a['branch']=$this->get_branch_name();
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

        if (isset($_POST['cl'])) {

        $this->db->where('cl',$_POST['cl']);  

        }
        $query = $this->db->get('m_branch');

        $s = "<select name='branch' id='branch' >";
        $s .= "<option value='0'>---</option>";
        foreach($query->result() as $r){
            $s .= "<option title='".$r->name."' value='".$r->bc."'>".$r->bc.'-'.$r->name."</option>";
        }
        $s .= "</select>";
        
        if (isset($_POST['cl'])) {

                echo $s;
        }

        return $s;

    }


 

    public function get_branch()
    {
  
    $q = $this->db->select(array('code', 'name'))
    ->where('code', $this->sd['bc'])
    ->get($this->tb_branch);
        
        $s = "<select name='bc' id='bc'>";
        //$s .= "<option value='0'>---</option>";
        foreach($q->result() as $r)
        {
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

  /*  $query ="SELECT 
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