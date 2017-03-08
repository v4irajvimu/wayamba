<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class items_dashboard extends CI_Model
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

  public function tbl_data(){
    $res = array();

    /*
    -------------------------------------------------------------------------------------------------------Purchase value and qty RANGE
    -------------------------------------------------------------------------------------------------------
    */
    $sql_purchase_RANGE = "SELECT d.`code`,IFNULL(SUM(d.`qty`),0) AS qty,s.`ddate`,SUM(d.`qty` * d.`discount`) AS discount , CONCAT(FORMAT(SUM(d.`amount` - (d.`qty` * d.`discount`)),2,2),' LKR') AS amount
            FROM t_grn_det d JOIN t_grn_sum s ON  d.nno = s.nno AND s.`cl`=d.`cl` AND d.`bc` = s.`bc`
            WHERE s.ddate BETWEEN '".$_POST['d_from']."' AND '".$_POST['d_to']."' 
            AND s.is_approve = '1' AND s.`is_cancel` = '0' 
            AND d.`code`='".$_POST['itemcode']."' 
            AND s.cl='".$this->sd['cl']."' AND s.bc='".$this->sd['branch']."' GROUP BY d.`code`";

    if($this->db->query($sql_purchase_RANGE)->num_rows() > 0){
        $res['purchase_RANGE'] = $this->db->query($sql_purchase_RANGE)->result();
    }
    else{
      $res['purchase_RANGE'] = 0;
    }
    

    /*
    -------------------------------------------------------------------------------------------------------Purchase value and qty UPTONOW
    -------------------------------------------------------------------------------------------------------
    */
    $sql_purchase_ALL = "SELECT IFNULL(SUM(A.qty),0) AS qty, IFNULL(SUM(A.amount),0) as amount FROM  (
                          SELECT d.`code`,SUM(d.`qty`) AS qty,s.`ddate`,SUM(d.`qty` * d.`discount`) AS discount , SUM(d.`amount` - (d.`qty` * d.`discount`)) AS amount
                        FROM t_grn_det d JOIN t_grn_sum s ON  d.nno = s.nno AND s.`cl`=d.`cl` AND d.`bc` = s.`bc`
                        WHERE s.ddate BETWEEN '".$_POST['d_from']."' AND '".$_POST['d_to']."' 
                        AND s.is_approve = '1' AND s.`is_cancel` = '0'
                        AND s.cl='".$this->sd['cl']."' AND s.bc='".$this->sd['branch']."' GROUP BY d.`code`) A";

    if($this->db->query($sql_purchase_ALL)->num_rows() > 0){
      $res['purchase_ALL'] = $this->db->query($sql_purchase_ALL)->result();
    }
    else{
      $res['purchase_ALL'] = 0;
    }
    

    /*
    -------------------------------------------------------------------------------------------------------Sales value and qty RANGE for item
    -------------------------------------------------------------------------------------------------------
    */
    $sql_sales_RANGE = "SELECT cl,bc,CODE,ddate,IFNULL(SUM(qty),0) AS qty,CONCAT(FORMAT(IFNULL(SUM(amount),0),2,2),' LKR')
     AS amount FROM (

    SELECT s.cl,s.bc,CODE,ddate,SUM(qty) AS qty,SUM(amount) AS amount FROM t_cash_sales_det d
    JOIN t_cash_sales_sum s ON s.`cl`=d.`cl` AND s.`bc`=d.`bc` AND s.nno=d.`nno`
    WHERE s.ddate BETWEEN '".$_POST['d_from']."' AND '".$_POST['d_to']."'
    AND s.cl='".$this->sd['cl']."' AND s.bc='".$this->sd['branch']."' AND  d.`code`='".$_POST['itemcode']."' AND s.is_cancel='0'
    
    UNION ALL

    SELECT s.cl,s.bc,CODE,ddate,IFNULL(SUM(qty),0) AS qty,IFNULL(SUM(amount),0) AS amount FROM t_credit_sales_det d
    JOIN t_credit_sales_sum s ON s.`cl`=d.`cl` AND s.`bc`=d.`bc` AND s.nno=d.`nno`
    WHERE  s.ddate BETWEEN '".$_POST['d_from']."' AND '".$_POST['d_to']."'
    AND s.cl='".$this->sd['cl']."' AND s.bc='".$this->sd['branch']."' AND  d.`code`='".$_POST['itemcode']."' AND s.is_cancel='0'

    UNION ALL

    SELECT s.cl,s.bc,item_code,ddate,IFNULL(SUM(qty),0) AS qty,IFNULL(SUM(amount),0) AS amount FROM t_hp_sales_det d
    JOIN t_hp_sales_sum s ON s.`cl`=d.`cl` AND s.`bc`=d.`bc` AND s.nno=d.`nno`
    WHERE s.ddate BETWEEN '".$_POST['d_from']."' AND '".$_POST['d_to']."'
    AND s.cl='".$this->sd['cl']."' AND s.bc='".$this->sd['branch']."' AND  d.`item_code`='".$_POST['itemcode']."' AND s.is_cancel='0'

    UNION ALL
    
    SELECT s.cl,s.bc,CODE,ddate,IFNULL(SUM(qty),0) AS qty,IFNULL(SUM(amount),0) AS amount FROM `t_sales_order_sales_det` d
    JOIN `t_sales_order_sales_sum` s ON s.`cl`=d.`cl` AND s.`bc`=d.`bc` AND s.nno=d.`nno`
    WHERE s.ddate BETWEEN '".$_POST['d_from']."' AND '".$_POST['d_to']."'
    AND s.cl='".$this->sd['cl']."' AND s.bc='".$this->sd['branch']."' AND  d.`code`='".$_POST['itemcode']."' AND s.is_cancel='0'
    ) A 
    ";
    if($this->db->query($sql_sales_RANGE)->num_rows() > 0){
      $res['sales_RANGE'] = $this->db->query($sql_sales_RANGE)->result();
    }
    else{
      $res['sales_RANGE'] = 0;
    }
    

    /*
    -------------------------------------------------------------------------------------------------------Sales value and qty 
    -------------------------------------------------------------------------------------------------------
    */
    $sql_sales_ALL = "SELECT cl,bc,CODE,ddate,SUM(qty) AS qty,
    CONCAT(FORMAT(SUM(amount),2,2),' LKR')
     AS amount FROM (

    SELECT s.cl,s.bc,CODE,ddate,SUM(qty) AS qty,SUM(amount) AS amount FROM t_cash_sales_det d
    JOIN t_cash_sales_sum s ON s.`cl`=d.`cl` AND s.`bc`=d.`bc` AND s.nno=d.`nno`
    WHERE s.ddate BETWEEN '".$_POST['d_from']."' AND '".$_POST['d_to']."' AND s.is_cancel='0' AND s.cl='".$this->sd['cl']."' AND s.bc='".$this->sd['branch']."'
    
    UNION ALL

    SELECT s.cl,s.bc,CODE,ddate,IFNULL(SUM(qty),0) AS qty,IFNULL(SUM(amount),0) AS amount FROM t_credit_sales_det d
    JOIN t_credit_sales_sum s ON s.`cl`=d.`cl` AND s.`bc`=d.`bc` AND s.nno=d.`nno`
    WHERE s.ddate BETWEEN '".$_POST['d_from']."' AND '".$_POST['d_to']."' AND s.is_cancel='0' AND s.cl='".$this->sd['cl']."' AND s.bc='".$this->sd['branch']."'

    UNION ALL

    SELECT s.cl,s.bc,item_code,ddate,IFNULL(SUM(qty),0) AS qty,IFNULL(SUM(amount),0) AS amount FROM t_hp_sales_det d
    JOIN t_hp_sales_sum s ON s.`cl`=d.`cl` AND s.`bc`=d.`bc` AND s.nno=d.`nno`
    WHERE s.ddate BETWEEN '".$_POST['d_from']."' AND '".$_POST['d_to']."' AND s.is_cancel='0' AND s.cl='".$this->sd['cl']."' AND s.bc='".$this->sd['branch']."'

    UNION ALL
    
    SELECT s.cl,s.bc,CODE,ddate,IFNULL(SUM(qty),0) AS qty,IFNULL(SUM(amount),0) AS amount FROM `t_sales_order_sales_det` d
    JOIN `t_sales_order_sales_sum` s ON s.`cl`=d.`cl` AND s.`bc`=d.`bc` AND s.nno=d.`nno`
    WHERE s.ddate BETWEEN '".$_POST['d_from']."' AND '".$_POST['d_to']."' AND s.is_cancel='0' AND s.cl='".$this->sd['cl']."' AND s.bc='".$this->sd['branch']."'
    ) A  
    ";

    if($this->db->query($sql_sales_ALL)->num_rows()  > 0){
      $res['sales_ALL'] = $this->db->query($sql_sales_ALL)->result();
    }
    else{
      $res['sales_ALL'] = 0;
    }
    

    /*
    -------------------------------------------------------------------------------------------------------
    Purchase Return from item within the range
    -------------------------------------------------------------------------------------------------------
    */
    $sql_pur_ret_item = "SELECT dd.code, ss.`cl`, ss.bc, IFNULL(SUM(qty),0) AS ret_qty, 
    CONCAT(FORMAT(IFNULL(SUM(ss.net_amount),0),2,2),' LKR')
     AS ret_amount 
    FROM `t_pur_ret_det` dd 
      JOIN `t_pur_ret_sum` ss  ON ss.`cl` = dd.`cl` AND ss.`cl` = dd.`cl` 
        AND ss.`nno` = dd.`nno` 
    WHERE ss.`is_approve` = '1' 
      AND ss.`is_cancel` = '0' 
      AND dd.cl = '".$this->sd['cl']."' 
      AND dd.bc = '".$this->sd['branch']."' 
      AND ss.`ddate` BETWEEN '".$_POST['d_from']."' AND '".$_POST['d_to']."' 
      AND dd.code='".$_POST['itemcode']."'
    GROUP BY dd.`code`";

    if($this->db->query($sql_pur_ret_item)->num_rows() > 0){
      $res['pur_ret_item'] = $this->db->query($sql_pur_ret_item)->result();
    }
    else{
      $res['pur_ret_item'] = 0;
    }


    /*
    -------------------------------------------------------------------------------------------------------
    Purchase Return ALL within the range
    -------------------------------------------------------------------------------------------------------
    */
    $sql_pur_ret_all = "SELECT CONCAT(FORMAT(IFNULL(SUM(A.ret_amount),0),2,2),' LKR') AS ret_amount,SUM(A.ret_qty) AS ret_qty FROM (
      SELECT dd.code, ss.`cl`, ss.bc, IFNULL(SUM(qty),0) AS ret_qty, 
    SUM(ss.net_amount)
     AS ret_amount 
    FROM `t_pur_ret_det` dd 
      JOIN `t_pur_ret_sum` ss  ON ss.`cl` = dd.`cl` AND ss.`cl` = dd.`cl` 
        AND ss.`nno` = dd.`nno` 
    WHERE ss.`is_approve` = '1' 
      AND ss.`is_cancel` = '0' 
      AND dd.cl = '".$this->sd['cl']."' 
      AND dd.bc = '".$this->sd['branch']."' 
      AND ss.`ddate` BETWEEN '".$_POST['d_from']."' AND '".$_POST['d_to']."'
    GROUP BY dd.`code`
    ) A";
    if($this->db->query($sql_pur_ret_all)->num_rows() > 0){
      $res['pur_ret_all'] = $this->db->query($sql_pur_ret_all)->result();
    }
    else{
      $res['pur_ret_all'] = 0;
    }


    /*
    -------------------------------------------------------------------------------------------------------
    Sales Return from item within the range
    -------------------------------------------------------------------------------------------------------
    */
    $sql_sales_ret_item = "SELECT CODE,IFNULL(SUM(qty),0) AS qty,SUM(amount) AS amount,
    IFNULL(SUM(ret_qty),0) AS ret_qty,
    CONCAT(FORMAT(IFNULL(SUM(A.ret_amount),0),2,2),' LKR') AS ret_amount FROM (

SELECT s.`ddate`,d.`code`,IFNULL(SUM(d.qty),0) AS qty,IFNULL(SUM(d.amount),0) AS amount,IFNULL(ret.ret_qty,0) AS ret_qty,IFNULL(ret.ret_amount,0)AS ret_amount FROM t_cash_sales_det d
JOIN t_cash_sales_sum s ON s.`cl`=d.`cl` AND s.`bc`=d.`bc` AND s.`nno`=d.`nno`
 LEFT JOIN(SELECT dd.code,ss.`cl`,ss.bc,SUM(qty)AS ret_qty,SUM(ss.net_amount)AS ret_amount FROM `t_sales_return_det` dd 
JOIN `t_sales_return_sum` ss ON ss.`cl`=dd.`cl` AND ss.`cl`=dd.`cl` AND ss.`nno`=dd.`nno`
WHERE ss.`is_approve`='1' AND ss.`is_cancel`='0' AND ss.cl='".$this->sd['cl']."' AND ss.bc='".$this->sd['branch']."' AND ss.`ddate` BETWEEN '".$_POST['d_from']."' AND '".$_POST['d_to']."' AND  ss.`sales_type`='4'
GROUP BY dd.`code`)ret ON  ret.cl=s.cl AND ret.bc=s.`bc` AND ret.code=d.`code`
WHERE s.cl='".$this->sd['cl']."' AND s.bc='".$this->sd['branch']."' AND s.`ddate` BETWEEN '".$_POST['d_from']."' AND '".$_POST['d_to']."' AND s.`is_approve`='1' AND s.`is_cancel`='0' 

 AND d.code='".$_POST['itemcode']."'
GROUP BY d.`code`

UNION ALL 

SELECT s.`ddate`,d.`code`,IFNULL(SUM(d.qty),0) AS qty,IFNULL(SUM(d.amount),0) AS amount,IFNULL(ret.ret_qty,0) AS ret_qty,IFNULL(ret.ret_amount,0)AS ret_amount 
FROM t_credit_sales_det d
JOIN t_credit_sales_sum s ON s.`cl`=d.`cl` AND s.`bc`=d.`bc` AND s.`nno`=d.`nno`
 LEFT JOIN(SELECT dd.code,ss.`cl`,ss.bc,SUM(qty)AS ret_qty,SUM(ss.net_amount)AS ret_amount FROM `t_sales_return_det` dd 
JOIN `t_sales_return_sum` ss ON ss.`cl`=dd.`cl` AND ss.`cl`=dd.`cl` AND ss.`nno`=dd.`nno`
WHERE ss.`is_approve`='1' AND ss.`is_cancel`='0' AND ss.cl='".$this->sd['cl']."' AND ss.bc='".$this->sd['branch']."' AND ss.`ddate`BETWEEN '".$_POST['d_from']."' AND '".$_POST['d_to']."' AND  ss.`sales_type`='5'
GROUP BY dd.`code`)ret ON  ret.cl=s.cl AND ret.bc=s.`bc` AND ret.code=d.`code`
WHERE s.cl='".$this->sd['cl']."' AND s.bc='".$this->sd['branch']."' AND s.`ddate` BETWEEN '".$_POST['d_from']."' AND '".$_POST['d_to']."' AND s.`is_approve`='1' AND s.`is_cancel`='0'
 AND d.code='".$_POST['itemcode']."'
GROUP BY d.`code`

UNION ALL

SELECT s.`ddate`,d.`item_code`,IFNULL(SUM(d.qty),0) AS qty,IFNULL(SUM(d.amount),0) AS amount,IFNULL(ret.ret_qty,0) AS ret_qty,IFNULL(ret.ret_amount,0)AS ret_amount 
FROM t_hp_sales_det d
JOIN t_hp_sales_sum s ON s.`cl`=d.`cl` AND s.`bc`=d.`bc` AND s.`nno`=d.`nno`
LEFT JOIN(SELECT dd.code,ss.`cl`,ss.bc,SUM(qty)AS ret_qty,SUM(ss.net_amount)AS ret_amount FROM `t_hp_return_det` dd 
JOIN `t_hp_return_sum` ss ON ss.`cl`=dd.`cl` AND ss.`cl`=dd.`cl` AND ss.`nno`=dd.`nno`
WHERE ss.`is_approve`='1' AND ss.`is_cancel`='0' AND ss.cl='".$this->sd['cl']."' AND ss.bc='".$this->sd['branch']."' AND ss.`ddate` BETWEEN '".$_POST['d_from']."' AND '".$_POST['d_to']."'
GROUP BY dd.`code`)ret ON  ret.cl=s.cl AND ret.bc=s.`bc` AND ret.code=d.`item_code`
WHERE s.cl='".$this->sd['cl']."' AND s.bc='".$this->sd['branch']."' AND s.`ddate` BETWEEN '".$_POST['d_from']."' AND '".$_POST['d_to']."' AND s.`is_cancel`='0'
 AND d.item_code='".$_POST['itemcode']."'
GROUP BY d.`item_code`) A

WHERE ddate BETWEEN '".$_POST['d_from']."' AND '".$_POST['d_to']."'";

    if($this->db->query($sql_sales_ret_item)->num_rows() > 0){
      $res['sales_ret_item'] = $this->db->query($sql_sales_ret_item)->result();
    }
    else{
      $res['sales_ret_item'] = 0;
    }
    

    /*
    -------------------------------------------------------------------------------------------------------
    Sales Return ALL within the range
    -------------------------------------------------------------------------------------------------------
    */
    $sql_sales_ret_all = "SELECT CODE,SUM(qty) AS qty,SUM(amount) AS amount,SUM(ret_qty)AS ret_qty, 
    CONCAT(FORMAT(IFNULL(SUM(A.ret_amount),0),2,2),' LKR') AS ret_amount FROM (

SELECT s.`ddate`,d.`code`,IFNULL(SUM(d.qty),0) AS qty,IFNULL(SUM(d.amount),0) AS amount,IFNULL(ret.ret_qty,0) AS ret_qty,IFNULL(ret.ret_amount,0)AS ret_amount FROM t_cash_sales_det d
JOIN t_cash_sales_sum s ON s.`cl`=d.`cl` AND s.`bc`=d.`bc` AND s.`nno`=d.`nno`
 LEFT JOIN(SELECT dd.code,ss.`cl`,ss.bc,SUM(qty)AS ret_qty,SUM(ss.net_amount)AS ret_amount FROM `t_sales_return_det` dd 
JOIN `t_sales_return_sum` ss ON ss.`cl`=dd.`cl` AND ss.`cl`=dd.`cl` AND ss.`nno`=dd.`nno`
WHERE ss.`is_approve`='1' AND ss.`is_cancel`='0' AND dd.cl='".$this->sd['cl']."' AND dd.bc='".$this->sd['branch']."' AND ss.`ddate` BETWEEN '".$_POST['d_from']."' AND '".$_POST['d_to']."' AND  ss.`sales_type`='4'
GROUP BY dd.`code`)ret ON  ret.cl=s.cl AND ret.bc=s.`bc` AND ret.code=d.`code`
WHERE s.cl='".$this->sd['cl']."' AND s.bc='".$this->sd['branch']."' AND s.`ddate` BETWEEN '".$_POST['d_from']."' AND '".$_POST['d_to']."' AND s.`is_approve`='1' AND s.`is_cancel`='0' 

 
GROUP BY d.`code`

UNION ALL 

SELECT s.`ddate`,d.`code`,IFNULL(SUM(d.qty),0) AS qty,IFNULL(SUM(d.amount),0) AS amount,IFNULL(ret.ret_qty,0) AS ret_qty,IFNULL(ret.ret_amount,0)AS ret_amount 
FROM t_credit_sales_det d
JOIN t_credit_sales_sum s ON s.`cl`=d.`cl` AND s.`bc`=d.`bc` AND s.`nno`=d.`nno`
 LEFT JOIN(SELECT dd.code,ss.`cl`,ss.bc,SUM(qty)AS ret_qty,SUM(ss.net_amount)AS ret_amount FROM `t_sales_return_det` dd 
JOIN `t_sales_return_sum` ss ON ss.`cl`=dd.`cl` AND ss.`cl`=dd.`cl` AND ss.`nno`=dd.`nno`
WHERE ss.`is_approve`='1' AND ss.`is_cancel`='0' AND dd.cl='".$this->sd['cl']."' AND dd.bc='".$this->sd['branch']."' AND ss.`ddate`BETWEEN '".$_POST['d_from']."' AND '".$_POST['d_to']."' AND  ss.`sales_type`='5'
GROUP BY dd.`code`)ret ON  ret.cl=s.cl AND ret.bc=s.`bc` AND ret.code=d.`code`
WHERE s.cl='".$this->sd['cl']."' AND s.bc='".$this->sd['branch']."' AND s.`ddate` BETWEEN '".$_POST['d_from']."' AND '".$_POST['d_to']."' AND s.`is_approve`='1' AND s.`is_cancel`='0'
 
GROUP BY d.`code`

UNION ALL

SELECT s.`ddate`,d.`item_code`,IFNULL(SUM(d.qty),0) AS qty,IFNULL(SUM(d.amount),0) AS amount,IFNULL(ret.ret_qty,0) AS ret_qty,IFNULL(ret.ret_amount,0)AS ret_amount 
FROM t_hp_sales_det d
JOIN t_hp_sales_sum s ON s.`cl`=d.`cl` AND s.`bc`=d.`bc` AND s.`nno`=d.`nno`
LEFT JOIN(SELECT dd.code,ss.`cl`,ss.bc,SUM(qty)AS ret_qty,SUM(ss.net_amount)AS ret_amount FROM `t_hp_return_det` dd 
JOIN `t_hp_return_sum` ss ON ss.`cl`=dd.`cl` AND ss.`cl`=dd.`cl` AND ss.`nno`=dd.`nno`
WHERE ss.`is_approve`='1' AND ss.`is_cancel`='0' AND dd.cl='".$this->sd['cl']."' AND dd.bc='".$this->sd['branch']."' AND ss.`ddate` BETWEEN '".$_POST['d_from']."' AND '".$_POST['d_to']."'
GROUP BY dd.`code`)ret ON  ret.cl=s.cl AND ret.bc=s.`bc` AND ret.code=d.`item_code`
WHERE s.cl='".$this->sd['cl']."' AND s.bc='".$this->sd['branch']."' AND s.`ddate` BETWEEN '".$_POST['d_from']."' AND '".$_POST['d_to']."' AND s.`is_cancel`='0'
 
GROUP BY d.`item_code`) A

WHERE ddate BETWEEN '".$_POST['d_from']."' AND '".$_POST['d_to']."'";
    if($this->db->query($sql_sales_ret_all)->num_rows() > 0){
      $res['sales_ret_all'] = $this->db->query($sql_sales_ret_all)->result();
    }
    else{
      $res['sales_ret_all'] = 0;
    }


    /*
    -------------------------------------------------------------------------------------------------------
    Stock ALL within the range
    -------------------------------------------------------------------------------------------------------
    */
    $sql_stock_all = "SELECT 
  i.cl, i.`bc`, i.`item`, IFNULL(SUM(i.`qty_in` - i.`qty_out`),0) AS qty, 
  CONCAT(FORMAT(IFNULL(SUM(i.`cost` * (i.`qty_in` - i.`qty_out`)),0),2,2),' LKR')
   AS amount
FROM
  t_item_movement i 
WHERE cl = '".$this->sd['cl']."' 
  AND bc = '".$this->sd['branch']."' 
  AND i.`ddate` <= '".$_POST['d_to']."' ";

    if($this->db->query($sql_stock_all)->num_rows() > 0){
      $res['stock_all'] = $this->db->query($sql_stock_all)->result();
    }
    else{
      $res['stock_all'] = 0;
    }

    /*
    -------------------------------------------------------------------------------------------------------
    STOCK ITEM within the range
    -------------------------------------------------------------------------------------------------------
    */
    $sql_stock_item = "SELECT 
  i.cl, i.`bc`, i.`item`, IFNULL(SUM(i.`qty_in` - i.`qty_out`),0) AS qty, 
  CONCAT(FORMAT(IFNULL(SUM(i.`cost` * (i.`qty_in` - i.`qty_out`)),0),2,2),' LKR')
   AS amount
FROM
  t_item_movement i 
WHERE cl = '".$this->sd['cl']."' 
  AND bc = '".$this->sd['branch']."' 
  AND i.`ddate` <= '".$_POST['d_to']."' AND i.item = '".$_POST['itemcode']."'";
    if($this->db->query($sql_stock_item)->num_rows() > 0){
      $res['stock_item'] = $this->db->query($sql_stock_item)->result();
    }
    else{
      $res['stock_item'] = 0;
    }

    $sql_profit = "SELECT m.`code`, m.`description`, IFNULL(cs.qty, 0) AS cash_qty, IFNULL(css.qty, 0) AS credit_qty, IFNULL(cc.qty, 0) AS card_qty, IFNULL(so.qty, 0) AS so_qty, IFNULL(hp.qty, 0) AS hp_qty,
  IFNULL(
    IFNULL(cs.qty, 0) + IFNULL(css.qty, 0) + IFNULL(cc.qty, 0) + IFNULL(so.qty, 0) + IFNULL(hp.qty, 0),
    0
  ) AS tot_qty,
  (
    IFNULL(
      IFNULL(cs.cost * cs.qty, 0) + IFNULL(css.cost * css.qty, 0) + IFNULL(cc.cost * cc.qty, 0) + IFNULL(so.cost * so.qty, 0) + IFNULL(hp.cost * hp.qty, 0),
      0
    )
  ) AS cost_value,
  (
    IFNULL(
      IFNULL(cs.amount, 0) + IFNULL(css.amount, 0) + IFNULL(cc.amount, 0) + IFNULL(so.amount, 0) + IFNULL(hp.amount, 0),
      0
    )
  ) AS sales_value,
  (
    IFNULL(
      IFNULL(cs.discount, 0) + IFNULL(css.discount, 0) + IFNULL(cc.discount, 0) + IFNULL(so.discount, 0) + IFNULL(hp.discount, 0),
      0
    )
  ) AS discount,
  (
    IFNULL(
      IFNULL(cs.amount, 0) + IFNULL(css.amount, 0) + IFNULL(cc.amount, 0) + IFNULL(so.amount, 0) + IFNULL(hp.amount, 0),
      0
    )
  ) - (
    IFNULL(
      IFNULL(cs.cost * cs.qty, 0) + IFNULL(css.cost * css.qty, 0) + IFNULL(cc.cost * cc.qty, 0) + IFNULL(so.cost * so.qty, 0) + IFNULL(hp.cost * hp.qty, 0),
      0
    )
  ) AS profit 
FROM
  m_item_branch m 
  LEFT JOIN 
    (SELECT 
      `code`,
      cost,
      SUM(qty) AS qty,
      SUM(c.amount) AS amount,
      SUM(c.discount) AS discount 
    FROM
      t_cash_sales_det c 
      JOIN t_cash_sales_sum s 
        ON s.cl = c.cl 
        AND s.bc = c.bc 
        AND s.nno = c.nno 
    WHERE s.ddate BETWEEN '".$_POST['d_from']."' AND '".$_POST['d_to']."' 
      AND s.cl = '".$this->sd['cl']."' 
      AND s.bc = '".$this->sd['branch']."' 
      AND c.code = '".$_POST['itemcode']."' 
      AND s.`is_cancel` != '1' 
    GROUP BY c.code) cs 
    ON cs.code = m.code 
  LEFT JOIN 
    (SELECT 
      `code`,
      cost,
      SUM(qty) AS qty,
      SUM(c.amount) AS amount,
      SUM(c.discount) AS discount 
    FROM
      t_credit_sales_det c 
      JOIN t_credit_sales_sum s 
        ON s.cl = c.cl 
        AND s.bc = c.bc 
        AND s.nno = c.nno 
    WHERE s.ddate BETWEEN '".$_POST['d_from']."' AND '".$_POST['d_to']."' 
      AND s.cl = '".$this->sd['cl']."' 
      AND s.bc = '".$this->sd['branch']."' 
      AND c.code = '".$_POST['itemcode']."' 
      AND s.`is_cancel` != '1' 
    GROUP BY c.code) css 
    ON css.code = m.code 
  LEFT JOIN 
    (SELECT 
      `code`,
      cost,
      SUM(qty) AS qty,
      SUM(c.amount) AS amount,
      SUM(c.discount) AS discount 
    FROM
      t_cash_and_card_sales_det c 
      JOIN t_cash_and_card_sales_sum s 
        ON s.cl = c.cl 
        AND s.bc = c.bc 
        AND s.nno = c.nno 
    WHERE s.ddate BETWEEN '".$_POST['d_from']."' AND '".$_POST['d_to']."' 
      AND s.cl = '".$this->sd['cl']."' 
      AND s.bc = '".$this->sd['branch']."' 
      AND c.code = '".$_POST['itemcode']."' 
      AND s.`is_cancel` != '1' 
    GROUP BY c.code) cc 
    ON cc.code = m.code 
  LEFT JOIN 
    (SELECT 
      `code`,
      cost,
      SUM(qty) AS qty,
      SUM(c.amount) AS amount,
      SUM(c.discount) AS discount 
    FROM
      t_sales_order_sales_det c 
      JOIN t_sales_order_sales_sum s 
        ON s.cl = c.cl 
        AND s.bc = c.bc 
        AND s.nno = c.nno 
    WHERE s.ddate BETWEEN '".$_POST['d_from']."' AND '".$_POST['d_to']."' 
      AND s.cl = '".$this->sd['cl']."' 
      AND s.bc = '".$this->sd['branch']."' 
      AND c.code = '".$_POST['itemcode']."' 
      AND s.`is_cancel` != '1' 
    GROUP BY c.code) so 
    ON so.code = m.code 
  LEFT JOIN 
    (SELECT 
      `item_code`,
      (pur_price) AS cost,
      SUM(qty) AS qty,
      SUM(c.amount) AS amount,
      SUM(c.discount) AS discount 
    FROM
      t_hp_sales_det c 
      JOIN t_hp_sales_sum s 
        ON s.cl = c.cl 
        AND s.bc = c.bc 
        AND s.nno = c.nno 
    WHERE s.ddate BETWEEN '".$_POST['d_from']."' AND '".$_POST['d_to']."' 
      AND s.cl = '".$this->sd['cl']."' 
      AND s.bc = '".$this->sd['branch']."' 
      AND c.item_code = '".$_POST['itemcode']."' 
      AND s.`is_cancel` != '1' 
    GROUP BY c.item_code) hp 
    ON hp.item_code = m.code 
WHERE m.`code` != '' 
  AND m.code = '".$_POST['itemcode']."' 
  AND m.cl = '".$this->sd['cl']."' 
  AND m.bc = '".$this->sd['branch']."' 
GROUP BY m.code 
HAVING tot_qty > 0 
ORDER BY m.code "; 

if($this->db->query($sql_profit)->num_rows() > 0){
      $res['profit'] = $this->db->query($sql_profit)->result();
    }
    else{
      $res['profit'] = 0;
    }
    

    echo json_encode($res);
  }

  public function load_last_sales(){
    $sql = "SELECT A.* FROM ( 
    (SELECT cd.cl, cd.bc, cd.nno, cd.qty, cd.`discount`, cd.`price`, cd.`amount` ,cs.`ddate`, 'CASH SALES' as type
    FROM `t_cash_sales_det` cd 
    LEFT JOIN `t_cash_sales_sum` cs ON cs.`nno` = cd.`nno` 
    WHERE cs.`is_approve` = '1' 
    AND cs.`is_cancel` = '0' AND cd.cl = '".$this->sd['cl']."' AND cd.bc = '".$this->sd['branch']."' 
    AND cd.`code`='".$_POST['itemcode']."'
    AND cs.`ddate` BETWEEN '".$_POST['d_from']."' AND '".$_POST['d_to']."' 
    ORDER BY cs.`ddate` DESC LIMIT 0,5)
    
    UNION ALL

    (SELECT crd.cl, crd.bc, crd.nno, crd.qty, crd.`discount`, crd.`price`, crd.`amount` ,crs.`ddate`, 'CREDIT SALES' as type
    FROM `t_credit_sales_det` crd 
    LEFT JOIN `t_credit_sales_sum` crs ON crs.`nno` = crd.`nno` 
    WHERE crs.`is_approve` = '1' 
    AND crs.`is_cancel` = '0' AND crd.cl = '".$this->sd['cl']."' AND crd.bc = '".$this->sd['branch']."' 
    AND crd.`code`='".$_POST['itemcode']."'
    AND crs.`ddate` BETWEEN '".$_POST['d_from']."' AND '".$_POST['d_to']."' 
    ORDER BY crs.`ddate` DESC LIMIT 0,5)

    UNION ALL 
  
    (SELECT sosd.cl, sosd.bc, sosd.nno, sosd.qty, sosd.`discount`, sosd.`price`, sosd.`amount` ,soss.`ddate`, 'SO SALES' as type
    FROM `t_sales_order_sales_det` sosd 
    LEFT JOIN `t_sales_order_sales_sum` soss ON soss.`nno` = sosd.`nno` 
    WHERE soss.`is_approve` = '1' 
    AND soss.`is_cancel` = '0' 
    AND sosd.cl = '".$this->sd['cl']."' AND sosd.bc = '".$this->sd['branch']."' 
    AND sosd.`code`='".$_POST['itemcode']."'
    AND soss.`ddate` BETWEEN '".$_POST['d_from']."' AND '".$_POST['d_to']."' 
    ORDER BY soss.`ddate` DESC LIMIT 0,5)
  
    UNION ALL
  
    (SELECT  hpd.cl, hpd.bc, hpd.nno, hpd.qty, hpd.`discount`, hpd.`sales_price`, hpd.`amount` ,hps.`ddate`, 'HP SALES' as type
    FROM t_hp_sales_det hpd 
    JOIN t_hp_sales_sum hps ON hps.`nno`=hpd.`nno` 
    WHERE hps.`is_cancel` ='0'  
    AND hpd.cl = '".$this->sd['cl']."' AND hpd.bc = '".$this->sd['branch']."' 
    AND hpd.`item_code`='".$_POST['itemcode']."'
    AND hps.`ddate` BETWEEN '".$_POST['d_from']."' AND '".$_POST['d_to']."' 
    ORDER BY hps.`ddate` DESC LIMIT 0,5 ) 
    ) A ORDER BY ddate DESC LIMIT 0,5";

    $res = $this->db->query($sql)->result();
    $a="";
    $i = 0;
    foreach ($res as $value) {
      $i++;
      $a.='<tr>';
      $a.='<td class="col-xs-1">'.$i.'</td>';
      $a.='<td class="col-xs-3">'.$value->type.'('.$value->nno.')</td>';
      $a.='<td class="col-xs-2">'.$value->ddate.'</td>';
      $a.='<td class="col-xs-2">'.$value->price.'</td>';
      $a.='<td class="col-xs-1">'.$value->qty.'</td>';
      $a.='<td class="col-xs-1">'.($value->qty * $value->discount).'</td>';
      $a.='<td class="col-xs-2">'.(($value->amount)- ($value->qty * $value->discount)).'</td>';
      $a.='</tr>';
    }

    echo $a;
  }

  public function load_last_purchase(){
    $sql = "SELECT d.nno, d.`batch_no`,d.`qty`,d.`price`,d.`amount`,s.`ddate`,d.`discount` 
            FROM t_grn_det d JOIN t_grn_sum s ON  d.nno = s.nno
            WHERE s.ddate BETWEEN '".$_POST['d_from']."' 
            AND '".$_POST['d_to']."' AND s.is_approve = '1' 
            AND s.`is_cancel` = '0' 
            AND d.`code`='".$_POST['itemcode']."' 
            AND d.cl='".$this->sd['cl']."' AND d.bc='".$this->sd['branch']."'
            ORDER BY s.`ddate` DESC LIMIT 0,5";

    $res = $this->db->query($sql)->result();
    $a="";
    $i = 0;
    foreach ($res as $value) {
      $i++;
      $a.='<tr>';
      $a.='<td class="col-xs-1">'.$i.'</td>';
      $a.='<td class="col-xs-1">'.$value->nno.'</td>';
      $a.='<td class="col-xs-2">'.$value->batch_no.'</td>';
      $a.='<td class="col-xs-2">'.$value->price.'</td>';
      $a.='<td class="col-xs-2">'.$value->qty.'</td>';
      $a.='<td class="col-xs-2">'.($value->qty * $value->discount).'</td>';
      $a.='<td class="col-xs-2">'.(($value->amount)- ($value->qty * $value->discount)).'</td>';
      $a.='</tr>';
    }

    echo $a;
  }

  public function load_item_movement(){
    $sql = "SELECT i.ddate, t_trans_code.description AS trans_des, i.trans_no, i.qty_in, i.qty_out 
            FROM t_item_movement i 
            JOIN t_trans_code 
              ON i.`trans_code` = t_trans_code.`code` 
            JOIN m_item m 
              ON i.`item` = m.code 
          WHERE i.ddate BETWEEN '".$_POST['d_from']."' 
            AND '".$_POST['d_to']."' 
            AND i.`cl` = '".$this->sd['cl']."' 
            AND i.`bc` = '".$this->sd['branch']."' 
            AND `m`.`code` = '".$_POST['itemcode']."' 
          ORDER BY i.auto_num LIMIT 0,5";

    $res = $this->db->query($sql)->result();
    $a="";
    $i = 0;
    foreach ($res as $value) {
      $i++;
      $a.='<tr>';
      $a.='<td class="col-xs-1">'.$i.'</td>';
      $a.='<td class="col-xs-2">'.$value->ddate.'</td>';
      $a.='<td class="col-xs-6">'.$value->trans_des.'</td>';
      $a.='<td class="col-xs-1">'.$value->trans_no.'</td>';
      $a.='<td class="col-xs-1">'.$value->qty_in.'</td>';
      $a.='<td class="col-xs-1">'.$value->qty_out.'</td>';
      $a.='</tr>';
    }

    echo $a;
  }

  public function load_stock_det(){
    $sql = "SELECT qcs.`cl`, qcs.`bc`, qcs.`store_code`, qcs.`qty`, SUM(qcs.`qty`) AS su_qty,
              mc.`description` AS cl_name, mbr.`name` AS br_name , ms.`description` AS Sto_name
              FROM `qry_current_stock` qcs 
              INNER JOIN `m_cluster` mc 
                ON (mc.`code` = qcs.`cl`) 
              INNER JOIN `m_branch` mbr 
                ON (mbr.`bc` = qcs.`bc`)
              INNER JOIN `m_stores` ms 
                ON (ms.`code` = qcs.`store_code`) 
              WHERE item='".$_POST['itemcode']."' AND qcs.cl='".$this->sd['cl']."' 
              AND qcs.bc='".$this->sd['branch']."'
              GROUP BY qcs.`store_code` ";

    $res = $this->db->query($sql)->result();
    $a="";
    $i = 0;
    foreach ($res as $value) {
      $i++;
      $a.='<tr>';
      $a.='<td class="col-xs-1">'.$i.'</td>';
      $a.='<td class="col-xs-3">'.$value->store_code.'</td>';
      $a.='<td class="col-xs-6">'.$value->Sto_name.' ['.$value->cl.' '.$value->bc.']'.'</td>';
      $a.='<td class="col-xs-2">'.$value->su_qty.'</td>';
      $a.='</tr>';
    }

    echo $a;
  }

  public function view_item_info(){
    $sql = "SELECT i.`code`, i.`description`, i.`model`, i.`rol`, i.`roq` , dpt.`description` AS dpt,
            c.`description` AS maincat, sc.`description` AS subcat,
            IFNULL(
            (SELECT CONCAT('".base_url()."',picture)  FROM `m_item_picture` WHERE `item_code`=i.`code` LIMIT 0,1 ),
            CONCAT('".base_url()."','images/no_image.jpg')) as pic_picture
            FROM m_item i 
            JOIN r_department dpt ON dpt.`code`= i.`department`
            JOIN `r_category` c ON c.`code`= i.`main_category`
            JOIN `r_sub_category` sc ON sc.`code`= i.`category` 
            WHERE inactive='0' AND i.`code`='".$_POST['itemcode']."' ";       
    $res = $this->db->query($sql)->first_row();
    echo json_encode($res);
  }

  public function item_list_all() {
    $sql = "SELECT m_item.`code`,m_item.`description`,m_item.`model` FROM m_item WHERE inactive='0' 
    AND  (m_item.`description` LIKE '%$_POST[search]%' 
          OR m_item.`code` LIKE '%$_POST[search]%' 
          OR m_item.model LIKE '%$_POST[search]%')
    GROUP BY  m_item.code
    LIMIT 25";       
    $query = $this->db->query($sql);
        $a = "";
        foreach ($query->result() as $r) {
          $a .= "<tr>";
          $a .= "<td class='col-sm-3'>" . $r->code . "</td>";
          $a .= "<td class='col-sm-6'>" . $r->description . "</td>";
          $a .= "<td class='col-sm-2'>" . $r->model . "</td>";
          $a .= '<td class="col-sm-1"><button type="button"
          data-code="'.$r->code.'"
          data-description="'.$r->description.'"
          data-model="'.$r->model.'"
          class="item_row btn btn-info btn-sm"><span class="glyphicon glyphicon-plus"></span></button></td>';
          
          $a .= "</tr>";
        }

        echo $a;
      }

}
?>
