
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class r_seettu_Item_setup extends CI_Model{
    
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
    $this->db->where("bc",$this->sd['branch']);

    $r_detail['branch']=$this->db->get('m_branch')->result();

    $r_detail['page']='A4';
    $r_detail['orientation']='P';  
    $r_detail['category']=$_POST['settu_item_category'];

    $sql = "SELECT 
                  S_SUM.no,
                  S_SUM.settu_item_category,
                  S_SUM.code,
                  S_SUM.name AS dis,
                  S_SUM.item_value,
                  S_SUM.free_item_value,
                  S_DET.`item_code`,
                  S_DET.`qty`,
                  S_DET.`item_max_price`,
                  M_ITEM.`description`,
                  CT.`name`
              FROM `m_settu_item_sum` AS S_SUM
                JOIN m_settu_item_det  S_DET ON
                 S_DET.`no`=S_SUM.`no` AND
                 S_DET.`cl`=S_SUM.`cl` AND
                 S_DET.`bc`=S_SUM.`bc`
              LEFT JOIN m_item  AS M_ITEM ON
                M_ITEM.`code`=S_DET.`item_code`
              LEFT JOIN m_settu_item_category AS CT ON
                CT.`code`=S_SUM.`settu_item_category`
              WHERE is_cancel = '0' AND S_SUM.settu_item_category='".$_POST['book_edition'].$_POST['settu_item_category']."'  ";

      $query=$this->db->query($sql);

      $sql_1="SELECT 
                F_DET.`no`,
                F_DET.`category_code`,
                F_DET.`item_code`,
                F_DET.`qty`,
                F_DET.`item_max_price`,
                M_ITEM.`description` 
              FROM
                `m_settu_item_det_free` F_DET 
              LEFT JOIN m_item AS M_ITEM 
                  ON F_DET.`item_code` = M_ITEM.`code` 
                LEFT JOIN m_settu_item_sum AS S_SUM 
                  ON F_DET.`no` = S_SUM.`no` 
                  AND F_DET.`cl` = S_SUM.`cl` 
                  AND F_DET.`bc` = S_SUM.`bc` 
              WHERE S_SUM.is_cancel = '0' 
                AND F_DET.category_code ='".$_POST['book_edition'].$_POST['settu_item_category']."'  "; 
      
    $sql_1.="ORDER BY F_DET.category_code LIMIT 1"; 

      $query1=$this->db->query($sql_1);
      
      $r_detail['sum']=$query->result();
      $r_detail['free_item']=$query1->result();    
     
      if($query->num_rows()>0){
        $this->load->view($_POST['by'].'_'.'pdf',$r_detail);

      }else{
        echo "<script>alert('No Data');window.close();</script>";
      }
  }
}