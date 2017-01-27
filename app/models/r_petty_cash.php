<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class r_petty_cash extends CI_Model{
    
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

    $cl=$this->sd['cl'];
    $bc=$this->sd['branch'];
    $acc=$_POST['acc_code'];
    $no_range_frm=$_POST['t_range_from'];
    $no_range_to=$_POST['t_range_to'];

    $r_detail['page']='A4';
    $r_detail['orientation']='P';  
    $r_detail['card_no']=$_POST['card_no1'];
    $r_detail['dfrom']=$_POST['from'];
    $r_detail['dto']=$_POST['to'];
    $r_detail['acc']=$_POST['acc_code'];
    $r_detail['t_no_from']=$_POST['t_range_from'];
    $r_detail['t_no_to']=$_POST['t_range_to'];
   
    
    $sql="SELECT 
              PCM.`no`,
              PCM.`date`,
              PCM.`description` As dis,     
              PCM.`total`
          FROM
              t_petty_cash_sum AS PCM
          INNER JOIN `m_account` AS MA 
                  ON MA.`code`=PCM.`pettycash_account`
          WHERE PCM.`date` BETWEEN '".$_POST['from']."' AND '".$_POST['to']."'AND PCM.cl = '$cl' AND PCM.bc = '$bc'";

          if(!empty($_POST['acc_code']))
        {
           $sql.=" AND MA.`code` = '$acc'";
        }
        
        if(!empty($cluster))
        {
           $sql.=" AND TPCM.cl = '$cl'";
        }
       if(!empty($branch))
        {
            $sql.=" AND PCM.bc = '$bc'";
        }
         
        if(!empty($_POST['t_range_from']) && empty($_POST['t_range_to']))
        {
           $sql.=" AND PCM.`nno` >= '$no_range_frm'";
        }
        
         if(!empty($_POST['t_range_to']) && empty($_POST['t_range_from']))
        {
           $sql.=" AND PCM.`nno` <= '$no_range_to'";
        }

        if(!empty($_POST['t_range_to']) && !empty($_POST['t_range_to']))
        {
           $sql.=" AND PCM.`nno` BETWEEN  '$no_range_frm' AND '$no_range_to'";
        }

      $sql1="SELECT 
              PCM.`no`,
              PCM.`date`,
              PCM.`description` As dis,     
              PCM.`total`
          FROM
              t_petty_cash_sum AS PCM
          INNER JOIN `m_account` AS MA 
                  ON MA.`code`=PCM.`pettycash_account`
          WHERE PCM.is_cancel='1' AND PCM.`date` BETWEEN '".$_POST['from']."' AND '".$_POST['to']."'AND PCM.cl = '$cl' AND PCM.bc = '$bc'";

      if(!empty($_POST['acc_code']))
        {
           $sql1.=" AND MA.`code` = '$acc'";
        }
        
        if(!empty($cluster))
        {
           $sql1.=" AND TPCM.cl = '$cl'";
        }
       if(!empty($branch))
        {
            $sql1.=" AND PCM.bc = '$bc'";
        }
         
        if(!empty($_POST['t_range_from']) && empty($_POST['t_range_to']))
        {
           $sql1.=" AND PCM.`nno` >= '$no_range_frm'";
        }
        
         if(!empty($_POST['t_range_to']) && empty($_POST['t_range_from']))
        {
           $sql1.=" AND PCM.`nno` <= '$no_range_to'";
        }

        if(!empty($_POST['t_range_to']) && !empty($_POST['t_range_to']))
        {
           $sql1.=" AND PCM.`nno` BETWEEN  '$no_range_frm' AND '$no_range_to'";
        }



    $sql_branch="SELECT 
                        MBC.`name`,
                        MCL.`description`,
                        MCL.`code`,
                         MBC.`bc`   
                        FROM
                            `m_branch` MBC
                            INNER JOIN `m_cluster` MCL
                                ON (MBC.`cl` = MCL.`code`) WHERE MBC.`bc`='$bc' AND MCL.`code`='$cl'";  
        
                 
          
    $r_detail['r_petty_cash_summery']=$this->db->query($sql)->result();
    $r_detail['cancelled']=$this->db->query($sql1)->result();        
    $r_detail['r_branch_name']=$this->db->query($sql_branch)->result();       
    
    //$this->load->view($_POST['by'].'_'.'pdf',$r_detail);

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