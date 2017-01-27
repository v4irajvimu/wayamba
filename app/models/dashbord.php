<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class dashbord extends CI_Model
{
  private $sd;

  function __construct()
  {
    parent::__construct();
    $this->sd = $this->session->all_userdata();
    $this->load->database($this->sd['db'], true);
  }

  public function base_details()
  {
  }

  public function get_all_sales(){
    // Sales Details Query
    $sql = "SELECT A.tr_code,tc.`description`,IFNULL(SUM(A.amount),0) AS final_sum  FROM (
    SELECT ca.cl, ca.bc, ca.nno, css.ddate, ca.code, i.`description` AS item_name, ca.`batch_no`, ca.qty, ca.price,
    ca.discount, ca.amount, '4' AS tr_code, css.`cus_id`, mc.`name` AS cus FROM `t_cash_sales_det` ca
    JOIN `t_cash_sales_sum` css ON css.nno = ca.`nno` AND css.cl = ca.cl AND css.bc = ca.`bc`
    JOIN m_item i ON i.code = ca.`code`
    JOIN m_customer mc ON mc.`code` = css.`cus_id`
    WHERE ca.`cl` = '".$this->sd['cl']."' AND ca.`bc` = '".$this->sd['branch']."' AND css.`ddate` BETWEEN '".$_POST['from']."' AND '".$_POST['to']."'AND is_cancel != '1' GROUP BY ca.code, ca.nno
    UNION
    ALL
    SELECT cr.cl, cr.bc, cr.nno, crs.ddate, cr.code, i.`description` AS item_name, cr.`batch_no`, cr.qty, cr.price,
    cr.discount, cr.amount, '5' AS tr_code, crs.`cus_id`, mc.`name` AS cus FROM `t_credit_sales_det` cr
    JOIN `t_credit_sales_sum` crs ON crs.nno = cr.`nno` AND crs.cl = cr.cl AND crs.bc = cr.`bc`
    JOIN m_item i ON i.code = cr.`code`
    JOIN m_customer mc ON mc.`code` = crs.`cus_id`
    WHERE cr.`cl` = '".$this->sd['cl']."' AND cr.`bc` = '".$this->sd['branch']."' AND crs.`ddate` BETWEEN '".$_POST['from']."'
    AND '".$_POST['to']."' AND is_cancel != '1' GROUP BY cr.code, cr.nno
    UNION
    ALL
    SELECT hs.cl, hs.bc, hs.nno, hss.ddate, hs.item_code, i.`description` AS item_name, hs.`batch_no`, hs.qty,
    hs.sales_price AS price, hs.discount, hs.amount, '6' AS tr_code, hss.`cus_id`, mc.`name` AS cus
    FROM `t_hp_sales_sum` hss
    JOIN `t_hp_sales_det` hs ON hss.nno = hs.`nno` AND hss.cl = hs.cl AND hss.bc = hs.`bc`
    JOIN m_item i ON i.code = hs.`item_code`
    JOIN m_customer mc ON mc.`code` = hss.`cus_id`
    WHERE hs.`cl` = '".$this->sd['cl']."' AND hs.`bc` = '".$this->sd['branch']."' AND hss.`ddate` BETWEEN '".$_POST['from']."'
    AND '".$_POST['to']."' AND is_cancel != '1' GROUP BY hs.item_code,
    hs.nno ORDER BY tr_code
    ) A
    JOIN `t_trans_code` tc ON A.tr_code = tc.`code`
    GROUP BY A.tr_code
         ";

    // Collecttion Details query -- PERIOD
    $sql1 = "SELECT IFNULL(SUM(total),0) AS total, IFNULL(SUM(paid),0)AS paid, IFNULL(SUM(bal),0)AS bal FROM
            (SELECT s.`agreement_no`,SUM(s.`net_amount` + s.`interest_amount`) AS total,IFNULL(rs.paid, 0) AS paid,
            (SUM(s.`net_amount` + s.`interest_amount`)) - IFNULL(rs.paid, 0) AS bal
            FROM t_hp_sales_sum s
            LEFT JOIN (SELECT agr_no,SUM(paid_amount) AS paid FROM t_hp_receipt_sum
                      WHERE ddate BETWEEN '".$_POST['from']."' AND '".$_POST['to']."' GROUP BY agr_no) rs
                      ON rs.`agr_no` = s.`agreement_no`
            WHERE s.ddate BETWEEN '".$_POST['from']."' AND '".$_POST['to']."' AND s.cl='".$this->sd['cl']."'
            AND s.bc='".$this->sd['branch']."' GROUP BY s.`agreement_no`
            ) A";

            // Collecttion Details query -- B?F
    $sql2 = "SELECT IFNULL(SUM(arreas),0) AS total, IFNULL(SUM(paid),0)AS paid, IFNULL(SUM(bal),0)AS bal FROM
            (SELECT s.agr_no, SUM(s.dr) - SUM(s.cr) AS arreas, IFNULL(a.paid, 0) AS paid,
            ((SUM(s.dr) - SUM(s.cr)) - IFNULL(a.paid, 0)) AS bal
            FROM t_ins_trans s
            LEFT JOIN
            (SELECT SUM(paid_amount) AS paid, agr_no
            FROM t_hp_receipt_sum
            WHERE ddate BETWEEN '".$_POST['from']."' AND '".$_POST['to']."'
            GROUP BY agr_no) a
            ON a.agr_no = s.agr_no
            JOIN t_hp_sales_sum ss
            ON ss.agreement_no = s.agr_no
            WHERE s.due_date <= '".$_POST['from']."' AND ss.is_closed = '0'  AND ss.is_cancel = '0'
            AND s.cl='".$this->sd['cl']."' AND s.bc='".$this->sd['branch']."'
            GROUP BY agr_no
            HAVING arreas != 0
            ) A";

            // Total Collection
            $sql3 = "SELECT SUM(A.amt) AS total_collection FROM (
                      	SELECT 'CASH' AS s_type, SUM(cs.net_amount) AS amt
                        FROM t_cash_sales_sum cs
                        WHERE cs.`ddate` BETWEEN '".$_POST['from']."'  AND '".$_POST['to']."' AND `is_cancel` != '1'
                        AND cs.cl = '".$this->sd['cl']."' AND cs.bc = '".$this->sd['branch']."'
                        UNION
                        ALL
                        SELECT 'CREDIT' AS s_type, SUM(r.`settle_amount`) AS amt
                        FROM `t_receipt` r
                        JOIN `t_credit_sales_sum` cr ON cr.nno = r.`nno`
                        WHERE cr.`ddate` BETWEEN '".$_POST['from']."'  AND '".$_POST['to']."' AND cr.`is_cancel` != '1'
                        AND r.cl = '".$this->sd['cl']."' AND r.bc = '".$this->sd['branch']."'
                        UNION
                        ALL
                        SELECT 'HP RECIEPT' AS s_type, SUM(rs.`paid_amount`) AS amt
                        FROM t_hp_receipt_sum rs
                        WHERE rs.`ddate` BETWEEN '".$_POST['from']."'  AND '".$_POST['to']."' AND `is_cancel` != '1'
                        AND rs.cl = '".$this->sd['cl']."' AND rs.bc = '".$this->sd['branch']."'
                        UNION
                        ALL
                        SELECT 'HP EARLY SETTLEMENT' AS s_type,SUM(es.`paid_amount` - es.`rebeat_amount`) AS amt
                        FROM `t_hp_early_settlement_sum` es
                        WHERE es.`ddate` BETWEEN '".$_POST['from']."'  AND '".$_POST['to']."' AND  `is_cancel` != '1'
                        AND es.cl = '".$this->sd['cl']."' AND es.bc = '".$this->sd['branch']."'
                        ) A";

                        // Stock Valuation
                        $sql4 = "SELECT
                                fn_stock_valuation ('".$_POST['from']."', '".$this->sd['cl']."', '".$this->sd['branch']."', '1') AS sv,
                                fn_stock_valuation ('".$_POST['from']."', '".$this->sd['cl']."', '".$this->sd['branch']."', '2') AS sv_lastweek";



         $data=$this->db->query($sql);
         $data1=$this->db->query($sql1);
         $data2=$this->db->query($sql2);
         $data3=$this->db->query($sql3);
         $data4=$this->db->query($sql4);

         if($data->num_rows()>0 || $data2->num_rows()>0 || $data3->num_rows()>0 || $data4->num_rows()>0){
           $a['sub']= $data->result();
           $a['coll_period']= $data1->result();
           $a['coll_bf']= $data2->result();
           $a['total_collection']= $data3->result();
           $a['stock_val']= $data4->result();
           echo json_encode($a);

         }else{
           echo 0;
         }
  }

}
?>
