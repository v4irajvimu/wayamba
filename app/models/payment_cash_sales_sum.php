
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class payment_cash_sales_sum extends CI_Model{
    
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

    $this->db->select(array('code','description'));
    $this->db->where("code",$_POST['sales_category']);
    $r_detail['category']=$this->db->get('r_sales_category')->result();

    $r_detail['page']='A4';
    $r_detail['orientation']='P';  
    $r_detail['card_no']=$_POST['card_no1'];
    $r_detail['dfrom']=$_POST['from'];
    $r_detail['dto']=$_POST['to'];

    $r_detail['category_field']=$_POST['sales_category'];

    if($_POST['sales_category']!="0"){

      $query = $this->db->query('SELECT  s.`nno`,
                    s.`cus_id`,
                    c.`name`,
                    s.`ddate`,
                    s.`gross_amount` gross,
                    discount_amount AS discount,
                    s.`net_amount`,
                    pay_cash,
                    pay_ccard
                    FROM `t_cash_sales_sum` s
                    JOIN `m_customer` c ON s.`cus_id`=c.`code`                   
                  WHERE s.`cl` = "'.$this->sd['cl'].'" 
                    AND s.`bc` = "'.$this->sd['branch'].'"
                    AND s.category ="'.$_POST['sales_category'].'"
                    AND s.`ddate` BETWEEN "'.$_POST['from'].'" 
                    AND "'.$_POST['to'].'" 
                  GROUP BY s.nno ' );
      
      $r_detail['purchase']=$query->result();  

   /*  $query1=$this->db->query('SELECT SUM(`t_cash_sales_det`.`qty` * `t_cash_sales_det`.`price`) AS gsum,
        SUM(`t_cash_sales_sum`.`net_amount`) AS nsum,
        IFNULL(SUM(ad.amount),0) AS addi 
        FROM `t_cash_sales_sum` 
        LEFT JOIN `t_cash_sales_det` 
          ON `t_cash_sales_sum`.`nno` = `t_cash_sales_det`.`nno` 
          AND `t_cash_sales_sum`.`cl` = `t_cash_sales_det`.`cl`
          AND `t_cash_sales_sum`.`bc` = `t_cash_sales_det`.`bc`  
        LEFT JOIN `t_cash_sales_additional_item` ad 
          ON ad.nno = `t_cash_sales_sum`.`nno`
          AND `t_cash_sales_sum`.`cl` = `ad`.`cl`
          AND `t_cash_sales_sum`.`bc` = `ad`.`bc`  
        WHERE `t_cash_sales_sum`.`cl`="'.$this->sd['cl'].'" AND `t_cash_sales_sum`.`bc`= "'.$this->sd['branch'].'"
        and `t_cash_sales_sum`.`ddate` between "'.$_POST['from'].'" and "'.$_POST['to'].'"');
   */


   /*   $query = $this->db->query('SELECT `t_cash_sales_sum`.`nno`,
        `t_cash_sales_sum`.`sub_no`,
        `t_cash_sales_sum`.`cus_id`,
        `t_cash_sales_sum`.`ddate`,
        `m_customer`.`name`,
        SUM(`t_cash_sales_det`.`price` * `t_cash_sales_det`.`qty`) AS gross,
        SUM(`t_cash_sales_det`.`discount` * `t_cash_sales_det`.`qty`) AS discount,
        `t_cash_sales_sum`.`net_amount` AS net_amount,
        `m_stores`.`description` FROM `t_cash_sales_sum` 
        LEFT JOIN `m_customer` 
          ON `t_cash_sales_sum`.`cus_id` = `m_customer`.`code` 
        LEFT JOIN `t_cash_sales_det` ON `t_cash_sales_sum`.`nno` = `t_cash_sales_det`.`nno` AND `t_cash_sales_sum`.`cl` = `t_cash_sales_det`.`cl` AND `t_cash_sales_sum`.`bc` = `t_cash_sales_det`.`bc`  
        LEFT JOIN `m_stores`   ON `m_stores`.`code` = `t_cash_sales_sum`.`store` 

        WHERE t_cash_sales_sum.category ="'.$_POST['sales_category'].'" AND `t_cash_sales_sum`.`cl`="'.$this->sd['cl'].'" AND `t_cash_sales_sum`.`bc`= "'.$this->sd['branch'].'"
        and `t_cash_sales_sum`.`ddate` between "'.$_POST['from'].'" and "'.$_POST['to'].'" GROUP BY nno ORDER BY sub_no ASC' );
  */
         

    }else{  

      $query = $this->db->query('SELECT  s.`nno`,
                s.`cus_id`,
                c.`name`,
                s.`ddate`,
                s.`gross_amount` gross,
                discount_amount AS discount,
                s.`net_amount`,
                pay_cash,
                pay_ccard
              FROM `t_cash_sales_sum` s
              JOIN `m_customer` c ON s.`cus_id`=c.`code`
              JOIN `m_stores` ms ON ms.`code` = s.`store` 
            WHERE s.`cl` = "'.$this->sd['cl'].'" 
              AND s.`bc` = "'.$this->sd['branch'].'"
              AND s.`ddate` BETWEEN "'.$_POST['from'].'" 
              AND "'.$_POST['to'].'" 
            GROUP BY s.nno ' );

     /* $query = $this->db->query('SELECT `t_cash_sales_sum`.`nno`,
        `t_cash_sales_sum`.`sub_no`,
        `t_cash_sales_sum`.`cus_id`,
        `t_cash_sales_sum`.`ddate`,
        `m_customer`.`name`,
        SUM(`t_cash_sales_det`.`price` * `t_cash_sales_det`.`qty`) AS gross,
        SUM(`t_cash_sales_det`.`discount` * `t_cash_sales_det`.`qty`) AS discount,
        `t_cash_sales_sum`.`net_amount` AS net_amount,
        `m_stores`.`description` FROM `t_cash_sales_sum` 
        LEFT JOIN `m_customer` 
          ON `t_cash_sales_sum`.`cus_id` = `m_customer`.`code` 
        LEFT JOIN `t_cash_sales_det` ON `t_cash_sales_sum`.`nno` = `t_cash_sales_det`.`nno` AND `t_cash_sales_sum`.`cl` = `t_cash_sales_det`.`cl` AND `t_cash_sales_sum`.`bc` = `t_cash_sales_det`.`bc`  
        LEFT JOIN `m_stores`   ON `m_stores`.`code` = `t_cash_sales_sum`.`store` 

        WHERE `t_cash_sales_sum`.`cl`="'.$this->sd['cl'].'" AND `t_cash_sales_sum`.`bc`= "'.$this->sd['branch'].'"
        and `t_cash_sales_sum`.`ddate` between "'.$_POST['from'].'" and "'.$_POST['to'].'" GROUP BY nno' );
        */

        $r_detail['purchase']=$query->result();   
    }


      if($query->num_rows()>0)
      {
        $this->load->view($_POST['by'].'_'.'pdf',$r_detail);
      }
      else
      {
        echo "<script>alert('No Data');window.close();</script>";
      }
  }
}