<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class r_card_and_cash_sales_gross_profit extends CI_Model{
    
    private $sd;
    private $mtb;
    
    private $mod = '003';
    
    function __construct(){
    parent::__construct();
  
    $this->sd = $this->session->all_userdata();
    $this->load->database($this->sd['db'], true);
    $this->mtb = $this->tables->tb['t_privilege_card'];
    $this->m_customer = $this->tables->tb['m_customer'];
    $this->t_sales_sum=$this->tables->tb['t_sales_sum'];
    $this->t_previlliage_trans=$this->tables->tb['t_previlliage_trans'];
    $this->t_privilege_card=$this->tables->tb['t_privilege_card']; 
    }
    
    public function base_details(){
        
      $a['table_data'] = $this->data_table();
  
        return $a;
    }
    

     public function PDF_report(){
          
          $this->db->select(array('name','address','tp','fax','email'));
          $this->db->where("cl",$this->sd['cl']);
          $this->db->where("bc",$this->sd['branch']);
          $r_detail['branch']=$this->db->get('m_branch')->result();

          $cluster=$_POST['cluster'];
          $branch=$_POST['branch'];

          $r_detail['page']='A4';
          $r_detail['orientation']='P';  
          $r_detail['card_no']=$_POST['card_no1'];
          $r_detail['dfrom']=$_POST['from'];
          $r_detail['dto']=$_POST['to'];
          $r_detail['type']="r_credit_sales_gross_profit";          
         
          

          $sql="SELECT
                  d.nno, 
                  d.code,
                  d.qty,
                  d.cost,
                  d.price,
                  m.description,
                  d.cost * d.qty AS cost_value,
                  d.price * d.qty AS price_value,
                  (d.price * d.qty) - (d.cost * d.qty) AS profit
                FROM
                  t_cash_and_card_sales_det d 
                  JOIN t_cash_and_card_sales_sum s ON d.cl = s.cl AND d.bc = s.bc AND d.nno = s.nno 
                   JOIN m_item m ON m.code=d.code
                WHERE s.ddate between '".$_POST['from']."' and '".$_POST['to']."'";
          
           if(!empty($_POST['cluster'])){
             $sql.=" AND s.cl='".$_POST['cluster']."'";
          }
           if(!empty($_POST['branch']))
           {
              $sql.=" AND s.bc='".$_POST['branch']."'";
           }
          if(!empty($_POST['item'])){
             $sql.=" AND d.code='".$_POST['item']."'";
          }
         
          if(!empty($_POST['supplier'])){
             $sql.=" AND m.supplier='".$_POST['supplier']."'";
          }
          
         
          $query1=$this->db->query($sql);
          $r_detail['sum']=$query1->result();
           
           $sql_branch="SELECT 
                        MBC.`name`,
                        MCL.`description`,
                        MCL.`code`,
                         MBC.`bc`   
                        FROM
                            `m_branch` MBC
                            INNER JOIN `m_cluster` MCL
                                ON (MBC.`cl` = MCL.`code`) WHERE MBC.`bc`='$branch' AND MCL.`code`='$cluster'";  
           $r_detail['r_branch_name']=$this->db->query($sql_branch)->result(); 
      
           $sql_supplier="SELECT code,name FROM m_supplier  WHERE code='".$_POST['supplier']."'";
           $r_detail['r_supplier_name']=$this->db->query( $sql_supplier)->result();

           $sql_item="SELECT code,description FROM m_item   WHERE code='".$_POST['item']."'";
           $r_detail['r_item_name']=$this->db->query($sql_item)->result();
            

          if($query1->num_rows()>0)
          {
           
            $this->load->view($_POST['by'].'_'.'pdf',$r_detail);
          }
          else
          {
            echo "<script>alert('No Data');window.close();</script>";
          }

     }
}