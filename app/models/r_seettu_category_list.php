
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class r_seettu_category_list extends CI_Model{
    
  private $sd;
  private $mtb;
  
  private $mod = '003';
  
  function __construct(){
  parent::__construct();

  $this->sd = $this->session->all_userdata();
  $this->load->database($this->sd['db'], true);
 // $this->mtb = $this->tables->tb['t_privilege_card'];
 // $this->m_customer = $this->tables->tb['m_customer'];
  //$this->t_sales_sum=$this->tables->tb['t_sales_sum'];
  //$this->t_previlliage_trans=$this->tables->tb['t_previlliage_trans'];
  //$this->t_privilege_card=$this->tables->tb['t_privilege_card']; 
  }
  
  public function base_details(){
      
    $a['table_data'] = $this->data_table();

    return $a;
  }
  

  public function PDF_report(){


  
        
    $this->db->select(array('name','address','tp','fax','email'));
    $this->db->where("bc",$this->sd['branch']);

    $r_detail['branch']=$this->db->get('m_branch')->result();

    $r_detail['page']='A4';
    $r_detail['orientation']='P';  
    $r_detail['category']=$_POST['settu_item_category'];

    $sql = "SELECT 
              `code`,
              `name`,
              `value`,
              `no_of_installment`,
              `installment_amount`
            FROM m_settu_item_category
            WHERE  book_edition= '".$_POST['book_edition']."'";

      $query=$this->db->query($sql);

      
      
      $r_detail['sum']=$query->result();
     
     
      if($query->num_rows()>0){
        $this->load->view($_POST['by'].'_'.'pdf',$r_detail);

      }else{
        echo "<script>alert('No Data');window.close();</script>";
      }
  }
}