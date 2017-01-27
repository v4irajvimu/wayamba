<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class m_settu_item_setup extends CI_Model {

    private $sd;
    private $mtb;
    private $mod = '003';

    function __construct() {
        parent::__construct();

        $this->sd = $this->session->all_userdata();
        $this->load->database($this->sd['db'], true);
        $this->load->model('user_permissions');
        $this->max_no= $this->utility->get_max_no("m_settu_item_sum","no");
       
    }

    public function base_details() {

        $a['max_no'] = $this->utility->get_max_no("m_settu_item_sum","no");
       
        return $a;
    }

    
    public function save() {
        $this->db->trans_begin();
        error_reporting(E_ALL);

        function exceptionThrower($type, $errMsg, $errFile, $errLine) {
            throw new Exception($errLine);
        }

        set_error_handler('exceptionThrower');
        try {
            $_POST['cl'] = $this->sd['cl'];
            $_POST['bc'] = $this->sd['branch'];
            $_POST['oc'] = $this->sd['oc'];
            $code = strtoupper($_POST['code_id']);

                $settu_item = array(
                    "cl" => $this->sd['cl'],
                    "bc" => $this->sd['branch'],
                    "no" => $this->max_no,
                    "ddate" => $_POST['date'],
                    "book_edition" => $_POST['book_no'],
                    "settu_item_category" => $_POST['hid_code'],
                    "code" => $code,       
                    "name" => $_POST['discription'],
                    "note" => $_POST['note'],
                    "item_value" => $_POST['item_value'],
                    "free_item_value" => $_POST['free_item_value'],
                    "type" => $_POST['i_type'],
                    "oc" => $this->sd['oc'],    
                );

                $settu_item_update = array(                   
                    "ddate" => $_POST['date'],
                    "book_edition" => $_POST['book_no'],
                    "settu_item_category" => $_POST['hid_code'],
                    "code" => $code,       
                    "name" => $_POST['discription'],
                    "note" => $_POST['note'],
                    "item_value" => $_POST['item_value'],
                    "free_item_value" => $_POST['free_item_value'],
                    "type" => $_POST['i_type'],
                    "oc" => $this->sd['oc'],    
                );
               
            for ($x = 0; $x < 10; $x++) {
                if (isset($_POST['0_' . $x], $_POST['2_' . $x], $_POST['3_' . $x])) {
                     if ($_POST['0_' . $x] != "" && $_POST['2_' . $x] != "" && $_POST['3_' . $x] != "") {

                        $settu_sub_item[] = array(
                            "cl" => $this->sd['cl'],
                            "bc" => $this->sd['branch'],
                            "no" => $this->max_no,
                            "category_code" => $code,
                            "item_code" => $_POST['0_' . $x],
                            "qty" => $_POST['2_' . $x],
                            "item_cost_price" => $_POST['3_' . $x],
                            "item_last_price" => $_POST['item_min_price_' . $x],
                            "item_max_price" => $_POST['free_price_' . $x],  
                        );
                    }
                }    
            }

            for ($y=0; $y < 10; $y++) {
                if (isset($_POST['itemCode_' . $y], $_POST['qty_' . $y], $_POST['cost_' . $y])) {
                     if ($_POST['itemCode_' . $y] != "" && $_POST['qty_' . $y] != "" && $_POST['cost_' . $y] != "") {
                       
                        $free_settu_item[]=array(
                                "cl" => $this->sd['cl'],
                                "bc" => $this->sd['branch'],
                                "no" => $this->max_no,
                                "category_code" => $_POST['hid_code'],
                                "item_code" => $_POST['itemCode_' . $y],
                                "qty" => $_POST['qty_' . $y],
                                "item_cost_price" => $_POST['cost_' . $y],
                                "item_last_price" => $_POST['last_price_' . $y],
                                "item_max_price" => $_POST['max_price_' . $y],  
                        );
                    }
                }    

            }

                if ($_POST['hid']== "0" || $_POST['hid']== "") {
                    if($this->user_permissions->is_add('m_settu_item_setup')){
                        $this->db->insert('m_settu_item_sum',$settu_item);
                        if(count($settu_sub_item)){$this->db->insert_batch("m_settu_item_det",$settu_sub_item);}

                        if(isset($free_settu_item)){
                            if(count($free_settu_item)){$this->db->insert_batch("m_settu_item_det_free",$free_settu_item);}
                           
                        }
                        $this->utility->save_logger("EDIT",75,$this->max_no,$this->mod);
                        echo $this->db->trans_commit();
                      
                    }else{
                        $this->db->trans_commit();
                        echo "No permission to save records";
                    }
                } else {
                    if($this->user_permissions->is_edit('m_settu_item_setup')){
                         $this->db->where("no",$_POST['id_no']);
                         $this->db->where("cl", $this->sd['cl']);
                         $this->db->where("bc", $this->sd['branch']);
                         $this->db->update('m_settu_item_sum', $settu_item_update);
                         
                         $this->db->where("no",$_POST['id_no']);
                         $this->db->where("cl", $this->sd['cl']);
                         $this->db->where("bc", $this->sd['branch']);
                         $this->db->delete('m_settu_item_det');

                         if(count($settu_sub_item)){$this->db->insert_batch("m_settu_item_det",$settu_sub_item);}


                         $this->db->where("no",$_POST['id_no']);
                         $this->db->where("cl", $this->sd['cl']);
                         $this->db->where("bc", $this->sd['branch']);
                         $this->db->delete('m_settu_item_det_free');
                         
                         if(isset($free_settu_item)){
                            if(count($free_settu_item)){$this->db->insert_batch("m_settu_item_det_free",$free_settu_item);} 
                        }
                          $this->utility->save_logger("EDIT",75,$this->max_no,$this->mod);
                         echo $this->db->trans_commit();
                        
                     }else{
                         $this->db->trans_commit();
                         echo "No permission to edit records";
                    }
                 }
        } catch (Exception $e) {
            $this->db->trans_rollback();
            echo $e->getMessage(). "Operation fail please contact admin";
        }
    }

    public function check_code() {
      $a="";
      $sql="SELECT * 
            FROM (`m_settu_item_sum`)
            WHERE `code` = '".$_POST['code']."' 
            AND `cl` = '".$this->sd['cl']."' 
            AND `bc` = '".$this->sd['branch']."' 
            LIMIT 1";
      $query=$this->db->query($sql);
      if($query->num_rows() > 0){
        $a['num'] = "1";
      }else{
        $a['num'] = "2";
      }
      $a['det'] = $query->result();
      echo json_encode($a);
    }

    public function load() {
        
        $sql_sum="SELECT
                  `no`,
                  `ddate`,
                  `m_settu_item_category`.code as settu_item_category,
                  `m_settu_item_sum`.`code` AS item_code,
                  `m_settu_item_sum`.`name`,
                  `m_settu_item_sum`.`book_edition`,
                  `m_settu_book_edition`.`description` as b_name,
                   m_settu_item_sum.note,
                   m_settu_item_category.ref_code as hid_code,
                  `item_value`,
                  `free_item_value`,
                  `is_cancel`,
                  `m_settu_item_category`.`name` AS item_name,
                   m_settu_item_sum.type
                FROM
                  (`m_settu_item_sum`) 
                  LEFT JOIN `m_settu_item_category` 
                    ON `m_settu_item_sum`.`settu_item_category` = `m_settu_item_category`.`ref_code` 
                  LEFT JOIN m_settu_book_edition 
                    ON m_settu_book_edition.code = m_settu_item_sum.book_edition
                WHERE `m_settu_item_sum`.`cl` = '".$this->sd['cl']."' 
                  AND `m_settu_item_sum`.`bc` = '".$this->sd['branch']."' 
                  AND `m_settu_item_sum`.`no` = '".$_POST['id_no']."' ";

        $query_1 = $this->db->query($sql_sum);

        $x = 0;
        if ($query_1->num_rows() > 0) {
          $a['sum'] = $query_1->result();
        } else {
          $x = 2;
        }

        $sql="SELECT 
                  `m_settu_item_det`.`item_code`,
                  `m_settu_item_det`.`qty`,
                  `m_settu_item_det`.`item_cost_price`,
                  `m_settu_item_det`.`item_last_price`,
                  `m_settu_item_det`.`item_max_price`,
                  `m_item`.`description`
                 
                FROM
                  `m_settu_item_det`
                  JOIN `m_item` 
                    ON `m_item`.`code` = `m_settu_item_det`.`item_code`    
                WHERE `m_settu_item_det`.`cl` = '".$this->sd['cl']."' 
                  AND `m_settu_item_det`.`bc` = '".$this->sd['branch']."' 
                  AND `m_settu_item_det`.`no` = '".$_POST['id_no']."' ";

        $query = $this->db->query($sql);
      
          if ($query->num_rows() > 0) {
              $a['det'] = $query->result();
          } else {
              $x = 2;
          }

         $sql_det_free="SELECT 
                              IFNULL( `m_settu_item_det_free`.`item_code`,'') AS item_codes,
                              IFNULL(`m_item`.`description`, '') AS dis,
                              IFNULL(`m_settu_item_det_free`.`qty`,'') AS quantity,
                              IFNULL(`m_settu_item_det_free`.`item_cost_price`,'') AS cost,
                              IFNULL(`m_settu_item_det_free`.`item_last_price`,'') AS last_p,
                              IFNULL(`m_settu_item_det_free`.`item_max_price`,'') AS max_p
                        FROM
                          m_settu_item_det_free 
                          JOIN `m_item` 
                        ON `m_item`.`code` = m_settu_item_det_free . item_code  
                        WHERE  m_settu_item_det_free . cl  = '".$this->sd['cl']."' 
                        AND  m_settu_item_det_free .bc  = '".$this->sd['branch']."' 
                        AND  m_settu_item_det_free . NO  = '".$_POST['id_no']."'  ";
          $query_2 = $this->db->query( $sql_det_free);
      
          if ($query_2->num_rows() > 0) {
              $a['det_free'] = $query_2->result();
          } else {
              $a['det_free'] ="2";
          }

         if ($x == 0) {
        echo json_encode($a);
      } else {
        echo json_encode($x);
      }
        
    }

    public function delete() {
        $this->db->trans_begin();
        error_reporting(E_ALL);

        function exceptionThrower($type, $errMsg, $errFile, $errLine) {
            throw new Exception($errMsg);
        }

        set_error_handler('exceptionThrower');
        try {
          
            if($this->user_permissions->is_delete('m_settu_item_setup')){
                 $this->db->where("no",$_POST['id_no']);
                 $this->db->where("cl", $this->sd['cl']);
                 $this->db->where("bc", $this->sd['branch']);
                 $this->db->update('m_settu_item_sum',array("is_cancel" => 1));
                 $this->utility->save_logger("EDIT",75,$this->max_no,$this->mod);
                 echo $this->db->trans_commit();
                 
            }else{
                $this->db->trans_commit();
                echo "No permission to delete records";
            }
        } catch (Exception $e) {
            $this->db->trans_rollback();
            echo "Operation fail please contact admin";
        }
    }

    

     public function get_item() {

        $cl=$this->sd['cl'];
        $branch=$this->sd['branch'];
        $code=$_POST['code_id'];
        
            $sql = "SELECT DISTINCT(m_item.code), 
            m_item.`description`,
            m_item.`model`,
            t_item_batch.`purchase_price`,
            t_item_batch.`max_price`,
            t_item_batch.`min_price` 
            FROM m_item 
            JOIN qry_current_stock_group ON m_item.`code`=qry_current_stock_group.`item` 
            JOIN t_item_batch ON t_item_batch.`item` = m_item.`code` AND t_item_batch.`batch_no`= qry_current_stock_group.`batch_no`
            WHERE qry_current_stock_group.cl='$cl' 
            AND qry_current_stock.qty > 0 
            AND qry_current_stock_group.bc='$branch' AND m_item.code='$code' 
            
            AND `m_item`.`inactive`='0' 
            GROUP BY  m_item.code
            LIMIT 25";
      
       
         $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            $data['a'] = $this->db->query($sql)->result();
        } else {
            $data['a'] = 2;
        }

        echo json_encode($data);

    }

    public function item_list_all() {
        $cl=$this->sd['cl'];
        $branch=$this->sd['branch'];
        //$group_sale=$_POST['group_sale'];

        if ($_POST['search'] == 'Key Word: code, name') {
            $_POST['search'] = "";
        }
        $codes=$_POST['search'];
            $sql = "SELECT DISTINCT 
                              (m_item.code),
                               m_item.`description`,
                               m_item.`purchase_price`,
                               m_item.`model`,
                               m_item.`max_price`,
                               m_item.`min_price` 
                            FROM
                              m_item   
                            WHERE (
                                m_item.`description` LIKE '%$codes%' 
                                OR m_item.`code` LIKE '%$codes%' 
                                OR m_item.model LIKE '%$codes%' 
                                OR m_item.`max_price` LIKE '%$codes%' 
                                OR `m_item`.`min_price` LIKE '%$codes%' 
                                OR `m_item`.`max_price` LIKE '%$codes%'
                              )     
                            GROUP BY m_item.code 
                            LIMIT 25 ";
        
        $query = $this->db->query($sql);
        $a = "<table id='item_list' style='width : 100%' >";
        $a .= "<thead><tr>";
        $a .= "<th class='tb_head_th'>Code</th>";
        $a .= "<th class='tb_head_th'>Item Name</th>";
        $a .= "<th class='tb_head_th'>cost</th>";
        $a .= "<th class='tb_head_th'>Price</th>";
        $a .= "<th class='tb_head_th'>Min Price</th>";
        $a .= "<th class='tb_head_th' style='display:none'>Purchase Price</th>";

        $a .= "</thead></tr>";
        $a .= "<tr class='cl'>";
        $a .= "<td>&nbsp;</td>";
        $a .= "<td>&nbsp;</td>";
        $a .= "<td>&nbsp;</td>";
        $a .= "<td>&nbsp;</td>";
        $a .= "<td>&nbsp;</td>";
        $a .= "<td style='display:none'>&nbsp;</td>";

        $a .= "</tr>";
        foreach ($query->result() as $r) {
            $a .= "<tr class='cl'>";
            $a .= "<td>" . $r->code . "</td>";
            $a .= "<td>" . $r->description . "</td>";
            $a .= "<td>" . $r->purchase_price. "</td>";
            $a .= "<td>" . $r->min_price . "</td>";
            $a .= "<td>" . $r->max_price. "</td>";
            $a .= "<td style='display:none'>" . $r->purchase_price . "</td>";
            $a .= "</tr>";
        }
        $a .= "</table>";

        echo $a;
    }

  public function load_saved_codes(){
    if ($_POST['search'] == 'Key Word: code, name') {
      $_POST['search'] = "";
    }
    $type=$_POST['type'];
    if($type=="1"){
      $sql="SELECT s.code,
                  s.name AS c_name,
                  c.`code` AS settu_item_category,
                  s.no,
                  c.`name` AS cat_name 
            FROM m_settu_item_sum s 
            JOIN m_settu_item_category c 
              ON c.`ref_code` = s.`settu_item_category` 
            WHERE s.type='1' AND (s.code LIKE '%".$_POST['search']."%' OR s.name LIKE '%".$_POST['search']."%')
            LIMIT 25";
    }else{
      $sql="SELECT s.code,
                  s.name AS c_name,                 
                  s.no
            FROM m_settu_item_sum s 
            WHERE s.type='2' AND (s.code LIKE '%".$_POST['search']."%' OR s.name LIKE '%".$_POST['search']."%')
            LIMIT 25";
    }

    $query=$this->db->query($sql);
        $a = "<table id='item_list' style='width : 100%' >";
        $a .= "<thead><tr>";
        $a .= "<th class='tb_head_th'>Code</th>";
        $a .= "<th class='tb_head_th'>Description</th>";
        if($type=="1"){
          $a .= "<th class='tb_head_th'>Category</th>";
          $a .= "<th class='tb_head_th'>Category Name</th>";
        }else{
          $a .= "<td></td>";
          $a .= "<td></td>";
        }
        $a .= "<th class='tb_head_th' style='display:none'></th>";

        $a .= "</thead></tr>";
        $a .= "<tr class='cl'>";
        $a .= "<td>&nbsp;</td>";
        $a .= "<td>&nbsp;</td>";
        if($type=="1"){
          $a .= "<td>&nbsp;</td>";
          $a .= "<td>&nbsp;</td>";
        }else{
          $a .= "<td></td>";
          $a .= "<td></td>";
        }
        $a .= "<td style='display:none'>&nbsp;</td>";

        $a .= "</tr>";
        foreach ($query->result() as $r) {
            $a .= "<tr class='cl'>";
            $a .= "<td>" . $r->code . "</td>";
            $a .= "<td>" . $r->c_name . "</td>";
            if($type=="1"){
              $a .= "<td>" . $r->settu_item_category. "</td>";
              $a .= "<td>" . $r->cat_name. "</td>";
            }else{
              $a .= "<td></td>";
              $a .= "<td></td>";
            }
            $a .= "<td style='display:none'>" . $r->no . "</td>";
            $a .= "</tr>";
        }
        $a .= "</table>";
        echo $a;
  }
}

